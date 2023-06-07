<?php
$title = "账单审核";
include "head.php";
?>



    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div class="container-fluid p-t-15">
        
        <div class="row">
          
          <div class="col-lg-6">
            <div class="card">
              <header class="card-header"><div class="card-title">账单审核</div></header>
              <div class="card-body">
                
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">账号</label>
                    <input type="text" class="form-control" id="username" placeholder="请输入账号" value="<?php echo $_GET['username'];?>">
                  </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">账单状态</label>
              <select class="form-control" id="billstatus">
                <option value="0" selected>审核账单</option>
                <option value="1">确认付款</option>
                <option value="2">驳回账单</option>
              </select>
            </div>

                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">返回内容</label>
                    <textarea class="form-control" id="billmsg" rows="3" placeholder="请输入返回给用户的内容"></textarea>
                  </div>
                <button class="btn btn-block btn-primary" id="dealwith">处理</button>
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
	$('#dealwith').click(function(){
		var username = $('#username').val();
		var billstatus = $("#billstatus").val();
		var billmsg = $('#billmsg').val();
		if(username == ""){
			Chouren_notify("请输入账号",true,"warning");
			return;
		}else if(billstatus == ""){
			Chouren_notify("请选择状态类型",true,"warning");
			return;
		}else if(billmsg == ""){
			Chouren_notify("请输入返回内容",true,"warning");
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
			"/api/admindata.php?bill_msg",
			JSON.stringify({
			"login_data": user_data,
			"username": username,
			"bill_status": billstatus,
			"bill_msg": billmsg,
			"bill_id": <?php echo $_GET['billid'];?>
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