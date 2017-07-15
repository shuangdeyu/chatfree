/**
 *
 */
//显示网页说明
function showdiv() {
	document.getElementById("shade").style.display ="block";
    document.getElementById("show").style.display ="block";
}
//隐藏网页说明
function hidediv() {
	document.getElementById("shade").style.display ="none";
    document.getElementById("show").style.display ="none";
}


/* 立即执行以下js代码
 * 下面是客户端代码，与服务端进行通信
 */
(function(){
	//指定连接服务器ip和端口
	var wsServer = 'ws://121.43.98.118:8282';
	var ws = new WebSocket(wsServer);

	//定义函数
	ws.onopen    = onopen;    //连接服务器时触发
	ws.onclose   = onclose;   //和服务器断开时触发
	ws.onmessage = onmessage; //客户端接收到服务器数据时触发
	ws.onerror   = onerror;   //出错时触发

	var online = false;       //在线标志

	function onopen(){
		//console.log("连接服务器成功"); //调试显示
		online = true;        //在线标志为 true

		//输入用户名
		login();
	}
	function login() {
		name = prompt('输入你的名字：', ''); //全局name
        if(!name || name=='null'){
            alert("输入名字不能为空，请重新输入！");
            login(); //再次进入输名字界面
        }else{
        	//给服务器发送登录信息
        	var message = '{"type":"login","name":"'+name+'"}';
			ws.send(message);
        }
	}

	function onclose(){
		//预留
	}

	function onmessage(msg){
		var data = eval("("+msg.data+")"); //解析json格式数据，来自服务端
		console.log(data); //调试显示
		switch(data['type']){
			case 'login':
				//随机显示头像
				var img = new Array(5);
				img[0]='<img src="image/1.jpg" height="45" width="45" />';
				img[1]='<img src="image/2.jpg" height="45" width="45" />';
				img[2]='<img src="image/3.jpg" height="45" width="45" />';
				img[3]='<img src="image/4.jpg" height="45" width="45" />';
				img[4]='<img src="image/5.jpg" height="45" width="45" />';

				//刷新显示用户列表
				client_list = data['client_list']; //全局client_list，存储所有用户登录信息
				$('#userlist').empty();            //先置显示列表为空，避免冗余
				$('#seltct_user_list').empty();
				$('#seltct_user_list').append('<option value="all" >所有人</option>');
				for(var key in client_list){       //循环遍历，往界面输出登录用户
					$('#userlist').append('<li id="'+key+'">'+client_list[key]['client_name']+'</li>');
					$('#seltct_user_list').append('<option value="'+key+'">'+client_list[key]['client_name']+'</option>');

					//给每个用户一个随机头像
					var rd = Math.floor(Math.random()*5);
					client_list[key]['img'] = img[rd];
				}

				//页面输出用户登录消息
				$("#chat").append('<div class="login">'+client_list[data['client_id']]['client_name']+'加入聊天室</div>');
				break;
			case 'send':
				//页面输出 聊天内容
				if(data['target'] == 'all'){
					$("#chat").append('<div id="chat-name" ><div class="head">'+client_list[data['client_id']]['img']+'</div><div class="head"><p>'+data['name']+'</p><span>'+data['time']+'</span></div></div>'+'<div class="chat-box">'+data['content']+'</div>');
				}else{
					$("#chat").append('<div id="chat-name" ><div class="head">'+client_list[data['client_id']]['img']+'</div><div class="head"><p>'+data['name']+' to '+client_list[data['target']]['client_name']+'</p><span>'+data['time']+'</span></div></div>'+'<div class="chat-box">'+data['content']+'</div>');
				}

				break;
			case 'logout':
				//console.log(client_list); //调试显示

				//页面输出 用户退出消息
				var logout_id = data['outId'];
				$("#chat").append('<div class="logout">'+client_list[logout_id]['client_name']+'退出聊天室</div>');

				//刷新用户列表
				delete client_list[logout_id];  //删除用户列表中 退出的用户
				$('#userlist').empty();
				$('#seltct_user_list').empty();
				$('#seltct_user_list').append('<option value="all" >所有人</option>');
				for(var p in client_list){
					$('#userlist').append('<li id="'+p+'">'+client_list[p]['client_name']+'</li>');
					$('#seltct_user_list').append('<option value="'+p+'">'+client_list[p]['client_name']+'</option>');
				}
				break;
		}
	}

	function onerror(){
		//预留
	}

	//向服务器发送数据-按键发送形式
	document.getElementById("sendSever").onclick = function() {
		if(online == false){
			alert('服务器未连接！');
			return false;
		}

		var content = document.getElementById('content').value;          //获取发送的内容
		var target  = document.getElementById('seltct_user_list').value; //获取发送对象的值
		var encrypt = $("input[name='encrypt']:checked").val();          //获取消息加密类型

		content = content.replace(/[\r\n]/g,"</br>");

		if(!content){
			alert('请先输入内容！');
			return false;
		}

		var message = '{"type":"send","name":"'+name+'","content":"'+content+'","target":"'+target+'","encrypt":"'+encrypt+'"}';
		ws.send(message); //发送到服务器
		document.getElementById('content').value = ''; //重置输入框的值
	}
	//向服务器发送数据-回车发送形式
	/*document.onkeypress = function(){
		if(event.keyCode == "13"){
			if(online == false){
				alert('服务器未连接！');
				return false;
			}

			var content = document.getElementById('content').value;          //获取发送的内容
			var target  = document.getElementById('seltct_user_list').value; //获取发送对象的值
			var encrypt = $("input[name='encrypt']:checked").val();          //获取消息加密类型

			content = content.replace(/[\r\n]/g,"</br>");

			if(!content){
				alert('请先输入内容！');
				return false;
			}

			var message = '{"type":"send","name":"'+name+'","content":"'+content+'","target":"'+target+'","encrypt":"'+encrypt+'"}';
			ws.send(message); //发送到服务器
			document.getElementById('content').value = ''; //重置输入框的值
		}
	}*/

})();
