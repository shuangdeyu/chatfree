<?php

use \GatewayWorker\Lib\Gateway;

class Events
{
    /*public static function onConnect($client_id)
    {
        
    }*/
    
   public static function onMessage($client_id, $message)
   {
       $message_data = json_decode($message, true);  //解析JSON，客户端数据
       
       switch($message_data['type']){
           case 'login':
               $_SESSION['client_name'] = $message_data['name']; //将用户名存入session，不存入workerman不能获取用户信息
               
               $client_list = Gateway::getALLClientInfo();       //获取所有用户的信息
               $send_client = array(
                   'type'        => 'login',
                   'client_id'   => $client_id,
                   'client_list' => $client_list
               );
               $send_list = json_encode($send_client);           //用户列表打包成json格式
               Gateway::sendToAll($send_list);                   //将用户列表发送给所有用户
               break;
           case 'send':
               $message_data['client_id'] = $client_id;
               $message_data['time'] = date('Y-m-d h:i:s'); //当前系统时间
               
               switch($message_data['encrypt']){
                   case 'no':break;
                   case 'json': //加密成 json
                       $content = $message_data['content'];
                       $message_data['content'] = json_encode($content);
                       break;
                   case 'hex':  //加密成 16进制
                       $content = $message_data['content'];
                       $content = iconv("UTF-8", "GB2312", $content);
                       $message_data['content'] = bin2hex($content);
                       break;
                   case 'md5':  //加密成 md5
                       $content = $message_data['content'];
                       $content = iconv("UTF-8", "GB2312", $content);
                       $message_data['content'] = md5($content);
                       break;
               }
               
               //选择发送对象
               if($message_data['target'] == 'all'){
                   //发送给所有用户
                   Gateway::sendToAll(json_encode($message_data));
               }else{
                   //发送给自己和选择的对象
                   Gateway::sendToClient($client_id,json_encode($message_data));
                   Gateway::sendToClient($message_data['target'],json_encode($message_data));
               }
               break;
       }
   }
   
   public static function onClose($client_id)
   {
       $message = array(
           'type'  => 'logout',
           'outId' => $client_id
       );
       
       // 向所有人发送 
       GateWay::sendToAll(json_encode($message));
   }
}
