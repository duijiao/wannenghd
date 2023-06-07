<?php
$title = "软件公告";
include "head.php";
require "../data/config.php";
$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
	die("连接失败: ".$conn->connect_error);
}
$sql = "select app_announ,announ_status from app_data";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$res->free_result();
$conn->close();
?>



    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div class="container-fluid p-t-15">
        
        <div class="row">
          
          <div class="col-lg-6">
            <div class="card">
              <header class="card-header"><div class="card-title">应用公告</div></header>
              <div class="card-body">
                
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">公告内容</label>
                    <textarea class="form-control"  id="appannoun" rows="3" placeholder="请输入公告内容"><?php if(empty($row['app_announ'])){echo '';}else{echo $row['app_announ'];} ?></textarea>
                  </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">公告状态</label>
              <select class="form-control" id="announstatus">
                	<?php
                	if($row["announ_status"] == null){
                		echo '<option value="1" selected>关闭</option><option value="0">开启</option>';
                	}else if($row["announ_status"] == 1){
                		echo '<option value="1" selected>关闭</option><option value="0">开启</option>';
                	}else{
                		echo '<option value="1">关闭</option><option value="0" selected>开启</option>';
                	}
                	?>
              </select>
            </div>
                    <button class="btn btn-block btn-primary" id="addannoun">修改</button>
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

<script type="text/javascript" src="../assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-confirm/jquery-confirm.min.js"></script>
<script type="text/javascript" src="../assets/js/lyear-loading.js"></script>
<script type="text/javascript" src="//lib.baomitu.com/layer/3.1.1/layer.js"></script>
<script type="text/javascript" src="../assets/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="../assets/js/main.min.js"></script>
<script type="text/javascript" src="../assets/js/Chart.min.js"></script>
<script type="text/javascript" src="../data/js/function.js"></script>
<script type="text/javascript">
$(function(){
	$('#addannoun').click(function(){
		var appannoun = $('#appannoun').val();
		var announstatus = $("#announstatus").val();
		if(appannoun == ""){
			Chouren_notify("请输入公告内容",true,"warning");
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
			"/api/admindata.php?add_announ",
			JSON.stringify({
			"login_data": user_data,
			"app_announ": appannoun,
			"announ_status": announstatus
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