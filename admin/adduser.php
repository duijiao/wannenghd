<?php
$title = "添加用户";
include "head.php";
?>



    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div class="container-fluid p-t-15">
        
        <div class="row">
          
          <div class="col-lg-6">
            <div class="card">
              <header class="card-header"><div class="card-title">添加用户</div></header>
              <div class="card-body">
                
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">账号</label>
                    <input type="text" class="form-control" id="username" placeholder="请输入账号">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">密码</label>
                    <input type="password" class="form-control" id="password" placeholder="请输入密码">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">邮箱</label>
                    <input type="email" class="form-control" id="email" placeholder="请输入邮箱">
                  </div>
                <label for="exampleFormControlInput1">会员天数</label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="vipday" placeholder="请输入会员天数">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">天</span>
                  </div>
                </div>
                <button class="btn btn-block btn-primary" id="adduser">添加</button>
          </form>

                
              </div>
            </div>


          </div>
        </div>
        
      </div>
      
    </main>
    <!--End 页面主要内容-->

  </div>
</div>

<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="//lib.baomitu.com/layer/3.1.1/layer.js"></script>
<script type="text/javascript" src="../assets/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="../assets/js/main.min.js"></script>
<script type="text/javascript" src="../data/js/function.js"></script>
<script type="text/javascript">
$(function(){
	$('#adduser').click(function(){
		var username = $('#username').val();
		var password = $('#password').val();
		var email = $('#email').val();
		var vipday = $('#vipday').val();
		if(username == ""){
			Chouren_notify("请输入账号",true,"warning");
			return;
		}else if(password == ""){
			Chouren_notify("请输入密码",true,"warning");
			return;
		}else if(email == ""){
			Chouren_notify("请输入邮箱",true,"warning");
			return;
		}else if(vipday == ""){
			Chouren_notify("请输入会员天数",true,"warning");
			return;
		}
		var user_data = jQuery.parseJSON($.cookie('user_data'));
		$(document).ajaxStart(function(){
			layer.load();
		});
		$(document).ajaxComplete(function(){
			setTimeout(function(){
				layer.closeAll('loading');
			});
		});
		$.post(
			"/api/admindata.php?add_user",
			JSON.stringify({
			"login_data": user_data,
			"username": username,
			"password": password,
			"email": email,
			"vipday": vipday
			}),
			function(data){
				var msg = eval(data);
				if(msg.code == 200){
					Chouren_notify(msg.msg,true,"success");
				}else{
					Chouren_notify(msg.msg,true,"danger");
				}
			}
		);
	});
});
</script>
</body>
</html>