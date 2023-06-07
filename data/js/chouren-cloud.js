$(function(){
	$('#login').click(function(){
		var username = $('#username').val();
		var password = $('#password').val();
		var captcha = $('#code').val();
		$(document).ajaxStart(function(){
			layer.load();
		});
		$(document).ajaxComplete(function(){
			setTimeout(function(){
				layer.closeAll('loading');
			});
		});
		$.post(
			"/admin/?action=login",
			JSON.stringify({
			"username": username,
			"password": password,
			"captcha": captcha
			}),
			function(data){
				var msg = JSON.parse(data);
				if(msg.captcha == true){
					$("#captcha").attr('src', "../data/code.php");
				}
				if(msg.code == 1000){
					var s1 = "btn-", s2 = msg.notify_color;
					if(msg.location == "index"){
						jQuery_confirm(msg.notify_color,msg.title,msg.msg,(s1+s2),'确定','./');
					}else{
						jQuery_confirm(msg.notify_color,msg.title,msg.msg,(s1+s2),'确定');
					}
				}else{
					Chouren_notify(msg.msg,msg.Boolean,msg.notify_color);
				}
			}
		);
	});
});