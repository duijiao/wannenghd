<?php
$title = "软件更新";
include "head.php";
require "../data/config.php";
$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
	die("连接失败: ".$conn->connect_error);
}
$sql = "select update_msg,update_num,update_url,update_status from app_data";
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
              <header class="card-header"><div class="card-title">软件更新</div></header>
              <div class="card-body">
                
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">版本号</label>
                    <input type="text" class="form-control" id="updatenum" placeholder="请输入版本号" value="<?php if(empty($row['update_num'])){echo '';}else{echo $row['update_num'];} ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlInput1">下载链接</label>
                    <input type="text" class="form-control" id="updateurl" placeholder="请输入下载链接" value="<?php if(empty($row['update_url'])){echo '';}else{echo $row['update_url'];} ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">更新内容</label>
                    <textarea class="form-control" id="updatemsg" rows="3" placeholder="请输入更新内容"><?php if(empty($row['update_msg'])){echo '';}else{echo $row['update_msg'];} ?></textarea>
                  </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">更新状态</label>
              <select class="form-control" id="updatestatus">
                	<?php
                	if($row["update_status"] == null){
                		echo '<option value="1" selected>关闭</option><option value="0">开启</option>';
                	}else if($row["update_status"] == 1){
                		echo '<option value="1" selected>关闭</option><option value="0">开启</option>';
                	}else{
                		echo '<option value="1">关闭</option><option value="0" selected>开启</option>';
                	}
                	?>
              </select>
            </div>
                    <button class="btn btn-block btn-primary" id="appupdate">修改</button>
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
	$('#appupdate').click(function(){
		var updatenum = $('#updatenum').val();
		var updateurl = $("#updateurl").val();
		var updatemsg = $("#updatemsg").val();
		var updatestatus = $("#updatestatus").val();
		if(updatenum == ""){
			Chouren_notify("请输入版本号",true,"warning");
			return;
		}else if(updateurl == ""){
			Chouren_notify("请输入下载链接",true,"warning");
			return;
		}else if(updatemsg == ""){
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
			"/api/admindata.php?app_update",
			JSON.stringify({
			"login_data": user_data,
			"update_num": updatenum,
			"update_url": updateurl,
			"update_msg": updatemsg,
			"update_status": updatestatus
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