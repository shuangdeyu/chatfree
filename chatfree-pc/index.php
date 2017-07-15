<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>聊天室chat-free</title>

<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/chat.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="js/jquery.js"></script>
</head>

<body>
    <div class="chat-main">
        <div class="chat-title">
            <h1 >Chat-Free 聊天室</h1>
            <div style="margin-top:-25px;margin-left: 750px;">
                <a class="show-rules" onclick="showdiv()">游戏规则说明</a>
            </div>
        </div>
        <div id="shade"></div>
    	<div id="show">
    	   <a class="show-rules" onclick="hidediv()">关闭</a>
    	   <ol>
    	       <li>此聊天室是基于workerman服务器通讯框架开发的一个即时通信小游戏</li>
    	       <li>左边是用户列表，右边是聊天界面，发言请在聊天界面下面的聊天框编辑</li>
    	       <li>聊天室无需注册，室内成员谁也不认识谁，除非自己点明</li>
    	       <li>能够指定用户发送，关闭页面即为退出，聊天内容不会保存</li>
    	       <li>聊天室聊天可进行16进制，json，md5等加密，解密请自行寻找解决方法</li>
    	       <li>特别注意md5解密相对困难，部分字符可能不能解密，特别是汉字</li>
    	       <li>注意：刷新界面表示重新连接</li>
			   <li>暂不支持回车发送，且发送消息里不能有回车</li>
    	   </ol>
    	</div>
    	
    	<div class="chat-chat">
    	   <div class="chat-user">
    	       <h3 style="text-align: center;border-bottom:1px solid #e8e8e8">在线用户</h3>
    	       <ul id="userlist"></ul>
    	   </div>
    	   
    	   <div class="chat-content">
    	       <div class="chat-liaotian" id="chat">
    	           
    	       </div>
    	       
    	       <div class="chat-edit">
    	           <!-- <form action="" method=""> -->
        	           <div style="float:left;margin-left:15px;">
        	               <select id="seltct_user_list" class="" style="height:25px;">
        	                   
                           </select>
        	           </div>
        	           <div style="float:left;margin-left: 35px;">
        	               <span>加密:</span>
        	               <label class="radio-inline"><input type="radio" name="encrypt" value="no" checked="checked" />无</label>
                           <label class="radio-inline"><input type="radio" name="encrypt" value="json" />json</label>
                           <label class="radio-inline"><input type="radio" name="encrypt" value="hex" />16进制</label>
                           <label class="radio-inline"><input type="radio" name="encrypt" value="md5" />md5</label>
        	           </div>
        	           <div style="clear: both;padding: 15px;">
        	               <textarea id="content" class="form-control" rows="3" cols="70" style="resize:none"></textarea>
        	           </div>
        	           
        	           <div style="margin-left: 15px;">
        	               <!-- <input type="text" id="name" placeholder="输入昵称"> 
        	               <span style="margin-left:280px;"></span>-->
        	               <input type="button" class="myButton btn btn-primary" id="sendSever" value="发表">
        	           </div>
    	           <!-- </form> -->
    	       </div>
    	   </div>
    	   
    	   <div style="clear: both"></div>
    	</div>
    	
    	<div class="footer">
    	   <span style="color:white;">Power By - </span>
    	   <span style="font-weight:900;"><a href="http://www.shuangdeyu.com/" target="_blank">蒋小凡</a></span>
    	   <span style="margin-left: 20px;color:white;">2016-04-28</span>
    	</div>
    </div>
    
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/chat.js"></script>
    
</body>
</html>







