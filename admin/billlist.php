<?php
$title = "账单列表";
include "head.php";
require "../data/config.php";
$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
	die("连接失败: ".$conn->connect_error);
}
$pageSize = 20;
$sql = "select count(*) from app_bill";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$res->free_result();
if($row['count(*)'] < $pageSize){
	$total_page = 1;
}else if($row['count(*)'] == $pageSize){
	$total_page = 1;
}else if($row['count(*)'] > $pageSize){
	$total_page = ceil($row['count(*)']/$pageSize);
}
if(isset($_GET['username'])){
	$sql = "select * from app_bill where username='{$_GET['username']}' order by intimate_time desc";
	$res = $conn->query($sql);
	$row = $res->fetch_all(MYSQLI_ASSOC);
	$res->free_result();
}else if(isset($_GET["page"])){
	$curPage = $_GET["page"];
	if(empty($_GET["page"])){
		$sql = "select * from app_bill order by intimate_time desc limit 0,{$pageSize}";
		$res = $conn->query($sql);
		$row = $res->fetch_all(MYSQLI_ASSOC);
		$res->free_result();
	}else if($row['count(*)'] < $pageSize){
		$sql = "select * from app_bill order by intimate_time desc limit 0,{$pageSize}";
		$res = $conn->query($sql);
		$row = $res->fetch_all(MYSQLI_ASSOC);
		$res->free_result();
	}else{
		$page = ($curPage-1)*$pageSize;
		$sql = "select * from app_bill order by intimate_time desc limit {$page},{$pageSize}";
		$res = $conn->query($sql);
		$row = $res->fetch_all(MYSQLI_ASSOC);
		$res->free_result();
	}
}else{
	$sql = "select * from app_bill order by intimate_time desc limit 0,20";
	$res = $conn->query($sql);
	$row = $res->fetch_all(MYSQLI_ASSOC);
	$res->free_result();
}
for($i=0;$i<count($row);$i++){
	if($row[$i]['pay_status'] == 0){
		$row[$i]['pay_status'] = "审核中";
	}else if($row[$i]['pay_status'] == 1){
		$row[$i]['pay_status'] = "已付款";
	}else if($row[$i]['pay_status'] == 2){
		$row[$i]['pay_status'] = "已驳回";
	}
}
for($i=0;$i<count($row);$i++){
	if($row[$i]['pay_type'] == "qq"){
		$row[$i]['pay_type'] = "QQ";
	}else if($row[$i]['pay_type'] == "wx"){
		$row[$i]['pay_type'] = "微信";
	}else if($row[$i]['pay_type'] == "zfb"){
		$row[$i]['pay_type'] = "支付宝";
	}
}
?>

    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div class="container-fluid p-t-15">

        <div class="row">
          
          <div class="col-lg-12">
            <div class="card">
              <header class="card-header"><div class="card-title">账单列表</div></header>
              <div class="card-body">
              

                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="username" placeholder="请输入账号" >
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="userquery">查询</button>
                  </div>
                </div>

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="check-all">
                      <label class="custom-control-label" for="check-all"></label>
                    </div>
                  </th>
                  <th>ID</th>
                  <th>账号</th>
                  <th>套餐序号</th>
                  <th>付款金额</th>
                  <th>支付方式</th>
                  <th>账单发起时间</th>
                  <th>账单完成时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
               <?php
              $list = '<tr><td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input ids" name="billtrue" ';
              $list2 = '</tr>';
              foreach($row as $v){
              	$v1 = $v;
              	echo $list;
              	echo 'value="'.$v["id"].'" id="ids-'.$v["id"].'"><label class="custom-control-label" for="ids-'.$v["id"].'"></label></div></td>';
              	echo $list1;
              	foreach($v as $k => $v){
              		echo '<td>'.$v.'</td>';
              	}
              	echo '<td><div class="btn-group"><a class="btn btn-xs btn-default" href="./billreview.php?username='.$v1['username'].'&billid='.$v1['id'].'" title="" data-toggle="tooltip" data-original-title="编辑"><i class="mdi mdi-pencil"></i></a></div></td>';

              	echo $list2;
              }
              ?>

              </tbody>
            </table>
          </div>

          
          <div class="mt-3">选中项：<a href="javascript:void(0);" id="deletebill">删除</a></div>


                  <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="./billlist.php?page=1">首页</a></li>
                    <li class="page-item <?php if(empty($_GET['page'])||$_GET['page']<=1) echo 'disabled';?>">
                      <a class="page-link" href="./billlist.php?page=<?php echo $_GET['page']-1;?>" aria-label="Previous">
                        <span aria-hidden="true"><i class="mdi mdi-chevron-left"></i></span>
                        <span class="sr-only">上一页</span>
                      </a>
                    </li>
                    <li class="page-item active"><a class="page-link"><?php if(empty($_GET['page'])||$_GET['page']<=1){echo '1';}else if($_GET['page']>$total_page){echo $total_page;}else{echo $_GET['page'];}?></a></li>
                    <li class="page-item <?php if(empty($_GET['page'])||$_GET['page']>=1) echo 'disabled';?>">
                      <a class="page-link" href="./billlist.php?page=<?php echo $_GET['page']+1;?>" aria-label="Next">
                        <span aria-hidden="true"><i class="mdi mdi-chevron-right"></i></span>
                        <span class="sr-only">下一页</span>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="./billlist.php?page=<?php echo $total_page;?>">尾页</a></li>
                  </ul>


                
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
	$("#deletebill").click(function(){
		var arr = new Array();
		$('input[name="billtrue"]:checked').each(function(i){
			arr[i] = $(this).val();
		});
		if(arr == false){
			Chouren_notify("请选择需要删除的项",true,"warning");
			return;
		}
		$.confirm({
			title: '提示',
			content: '是否删除选中项',
			type: 'red',
			typeAnimated: true,
			buttons: {
				button: {
					text: '确定',
					btnClass: 'btn-danger',
					action: function(){
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
							"/api/admindata.php?delete_bill",
							JSON.stringify({
								"login_data": user_data,
								"bill_ids": arr
							}),
							function(data){
								var msg = eval(data);
								if(msg.code == 200){
									Chouren_notify(msg.msg,true,"success");
									window.setTimeout(function () {
										window.location.reload();
									},1000)
								}else{
									Chouren_notify(msg.msg,true,"danger");
								}
							}
						);
					}
				},
				取消: function () {
				}
			}
		});
	});
	$('#userquery').click(function(){
		var username = $('#username').val();
		if(username == ""){
			Chouren_notify("请输入账号",true,"warning");
			return;
		}
		window.location.href="./billlist.php?username="+username;
	});
});
</script>
</body>
</html>