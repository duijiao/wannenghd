<?php
$title = "首页";
include "head.php";
require "../data/config.php";
$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
	die("连接失败: ".$conn->connect_error);
}
$sql = "select count(*) from app_user;";
$res = $conn->query($sql);
$total_user = $res->fetch_assoc();
$res->free_result();
$sql = "select count(*) from app_list;";
$res = $conn->query($sql);
$total_app = $res->fetch_assoc();
$res->free_result();
$sql = "select * from app_bill where to_days(complete_time) = to_days(now()) and pay_status='1';";
$res = $conn->query($sql);
$todaymoney = $res->fetch_all(MYSQLI_ASSOC);
$res->free_result();
$sql = "select * from app_bill where to_days(intimate_time) = to_days(now());";
$res = $conn->query($sql);
$todaybill = $res->fetch_all(MYSQLI_ASSOC);
$res->free_result();
$mysql_ver = $conn->get_server_info();
$conn->close();

$domain = $_SERVER['SERVER_NAME'];
$serverapp = $_SERVER['SERVER_SOFTWARE'];
/*$mysql_ver = DB::getInstance()->getMysqlVersion();*/
$php_ver = PHP_VERSION;
$uploadfile_maxsize = ini_get('upload_max_filesize');
if (function_exists("imagecreate")) {
	if (function_exists('gd_info')) {
		$ver_info = gd_info();
		$gd_ver = $ver_info['GD Version'];
	} else{
		$gd_ver = '支持';
	}
} else{
	$gd_ver = '不支持';
}
?>


    
    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div class="container-fluid p-t-15">


  <!--横条形的统计-->
  <div class="row">
    <div class="col-sm-6 col-sm-6 col-md-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="flex-box">
            <span class="img-avatar img-avatar-48 bg-primary"><i class="mdi mdi-currency-cny fs-22"></i></span>
            <span class="fs-22 lh-22"><?php foreach($todaymoney as $k => $bills){$data += $bills['money'];}echo sprintf("%.2f",$data);?></span>
          </div>
          <div class="text-right">今日收入</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-sm-6 col-md-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="flex-box">
            <span class="img-avatar img-avatar-48 bg-success"><i class="mdi mdi-account fs-22"></i></span>
            <span class="fs-22 lh-22"><?php echo $total_user['count(*)'];?></span>
          </div>
          <div class="text-right">用户总数</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-sm-6 col-md-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="flex-box">
            <span class="img-avatar img-avatar-48 bg-info"><i class="mdi mdi-cube-outline fs-22"></i></span>
            <span class="fs-22 lh-22"><?php echo $total_app['count(*)'];?></span>
          </div>
          <div class="text-right">应用总数</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-sm-6 col-md-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="flex-box">
            <span class="img-avatar img-avatar-48 bg-warning"><i class="mdi mdi-comment-outline fs-22"></i></span>
            <span class="fs-22 lh-22"><?php echo count($todaybill);?> 条</span>
          </div>
          <div class="text-right">新增账单</div>
        </div>
      </div>
    </div>
  </div>


	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="header-title mb-3">服务器信息</h4>
					<div class="chart inline-legend grid">
					<p>当前版本：对角软件库 1.0(更新版本)</p>
					<p>微信公众号：对角网络工作室</p>
					<p>当前域名：<?php echo $domain; ?></p>
					<p>PHP版本：<?php echo $php_ver; ?></p>
					<p>MySQL版本：<?php echo $mysql_ver; ?></p>
					<p>服务器环境：<?php echo $serverapp; ?></p>
					<p>GD图形处理库：<?php echo $gd_ver; ?></p>
					<p>服务器空间允许上传最大文件：<?php echo $uploadfile_maxsize; ?></p>
				</div>
				</div> <!-- end card-body-->
			</div> <!-- end card-->
		</div> <!-- end col-->
	</div>


        
      </div>
      
    </main>
    <!--End 页面主要内容-->

  </div>
</div>

<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/popper.min.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="../assets/js/main.min.js"></script>
<script type="text/javascript" src="../assets/js/Chart.min.js"></script>
</body>
</html>