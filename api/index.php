<?php
require "../data/config.php";
$data = file_get_contents("php://input");
$data = json_decode($data,true);
$username = $data["username"];
$password = $data["password"];
$passwords = $data["passwords"];
$email = $data["email"];
$captcha = $data["captcha"];
$crs = $data["crs"];

header('Content-type:text/json;charset=utf-8');
session_start();

if(isset($_GET["login"])){
	if($data == null){
		die(json(array("code"=>201,"msg"=>"非法请求")));
	}else if(!isset($username) && !isset($password)){
		die(json(array("code"=>202,"msg"=>"非法请求")));
	}else if($username == null && $passname == null){
		die(json(array("code"=>203,"msg"=>"请输入账号密码")));
	}else if(!is_numeric($username)){
		die(json(array("code"=>204,"msg"=>"账号必须为数字")));
	}

	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
	if($conn->connect_error){
		die("连接失败: ".$conn->connect_error);
	}
	$sql = "select * from app_user where username='".daddslashes($username)."'";
	$res = $conn->query($sql);
	$row = $res->fetch_assoc();
	$time = date('Y-m-d H:i:s');

	if(!empty($row)){
		if(isset($crs)){
			if($crs != null){
				if(strlen($crs) == 32){
					if($row["password"] == $crs){
						$sql = "UPDATE app_user SET atlast_login_time='{$time}' WHERE username='{$username}'";
						$conn->query($sql);
						$expire_status = strtotime($row["expire_time"]);
						$expire_status<time()?$expire_status='0':$expire_status='1';
						$json = array("code"=>200,"msg"=>"登录成功","username"=>$username,"nick"=>nickname($username),"avatar"=>"http://q1.qlogo.cn/g?b=qq&nk={$username}&s=640","vip_expire_time"=>$row["expire_time"],"vip_expire_status"=>$expire_status);
					}else{
						$json = array("code"=>208,"msg"=>"CRS验证失败");
					}
				}else{
					$json = array("code"=>207,"msg"=>"CRS错误");
				}
			}else{
				$json = array("code"=>206,"msg"=>"CRS为空");
			}
		}else if($row["password"] != md5($password)){
			$json = array("code"=>209,"msg"=>"密码不正确");
		}else if($row["username"] == $username && $row["password"] == md5($password)){
			$sql = "UPDATE app_user SET atlast_login_time='{$time}' WHERE username='{$username}'";
			$conn->query($sql);
			$json = array("code"=>200,"msg"=>"登录成功","crs"=>md5($password));
		}
	}else{
		$json = array("code"=>205,"msg"=>"账号不存在");
	}
	$res->free_result();
	$conn->close();
	echo json($json);
	exit();
}else if(isset($_GET["reg"])){
	if($data == null){
		die(json(array("code"=>201,"msg"=>"非法请求")));
	}else if(!isset($username) && !isset($password)){
		die(json(array("code"=>202,"msg"=>"非法请求")));
	}else if($username == null){
		die(json(array("code"=>203,"msg"=>"请输入账号")));
	}else if(strlen($username) < 5 || strlen($username) > 10){
		die(json(array("code"=>204,"msg"=>"账号不能小于5或大于10")));
	}else if(!is_numeric($username)){
		die(json(array("code"=>205,"msg"=>"账号必须为数字")));
	}else if($password == null){
		die(json(array("code"=>206,"msg"=>"请输入密码")));
	}else if(strlen($password) < 8 || strlen($password) > 16){
		die(json(array("code"=>207,"msg"=>"密码不能小于8或大于16")));
	}else if($passwords == null){
		die(json(array("code"=>208,"msg"=>"请再次输入密码")));
	}else if($password != $passwords){
		die(json(array("code"=>209,"msg"=>"两次密码不正确")));
	}else if($email == null){
		die(json(array("code"=>210,"msg"=>"请输入邮箱")));
	}else if(filter_var($email,FILTER_VALIDATE_EMAIL) == false){
		die(json(array("code"=>211,"msg"=>"邮箱不合法")));
	}else if($captcha == null){
		die(json(array("code"=>212,"msg"=>"请输入验证码")));
	}else if($captcha != $_SESSION["captcha"]){
		die(json(array("code"=>213,"msg"=>"验证码不正确")));
	}

	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
	$res = $conn->query("select * from app_user where username='$username'");
	$row = $res->fetch_assoc();
	$res2 = $conn->query("select * from app_user where email='$email'");
	$row2 = $res2->fetch_assoc();
	if(is_array($row)){
		$json = array("code"=>214,"msg"=>"账号已被注册");
	}else if(is_array($row2)){
		$json = array("code"=>215,"msg"=>"邮箱已绑定其他账号");
	}else{
		$time = date('Y-m-d H:i:s');
		$password = md5($password);
		$sql = "INSERT INTO app_user (username,password,email,reg_time,expire_time) VALUES ('{$username}','{$password}','{$email}','{$time}','{$time}')";
		if($conn->query($sql)){
			$json = array("code"=>200,"msg"=>"注册成功");
		}else{
			$json = array("code"=>216,"msg"=>"注册失败，请联系管理员！");
		}
	}

	$res->free_result();
	$res2->free_result();
	$conn->close();

	die(json($json));

}else if(isset($_GET["data"])){
	if($data == null){
		die(json(array("code"=>201,"msg"=>"非法请求")));
	}else if(!isset($username) && !isset($password)){
		die(json(array("code"=>202,"msg"=>"非法请求")));
	}else if($username == null && $passname == null){
		die(json(array("code"=>203,"msg"=>"请输入账号密码")));
	}else if(!is_numeric($username)){
		die(json(array("code"=>204,"msg"=>"账号必须为数字")));
	}

	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
	if($conn->connect_error){
		die("连接失败: ".$conn->connect_error);
	}
	$sql = "select * from app_user where username='".daddslashes($username)."'";
	$res = $conn->query($sql);
	$row = $res->fetch_assoc();
	$res->free_result();

	if(empty($row)){
		echo json(array("code"=>205,"msg"=>"账号不存在"));
	}else if(isset($crs)){
		if($crs == null){
			echo json(array("code"=>206,"msg"=>"CRS为空"));
		}else if(strlen($crs) != 32){
			echo json(array("code"=>207,"msg"=>"CRS错误"));
		}else if($row["password"] == $crs){
			if($_GET["data"] == "app_list"){
				if(!empty($_GET['type'])){
					$sql = "select id,appname,appsize,applogo,appsort,appintro,add_time,app_vip_status from app_list where appsort='{$_GET['type']}'";
					$res = $conn->query($sql);
					$row = $res->fetch_all(MYSQLI_ASSOC);
					$res->free_result();
					echo json(array("code"=>200,"msg"=>"success","data"=>$row));
				}else if(!empty($_GET["name"])){
					$sql = "select id,appname,appsize,applogo,appsort,appimg1,appimg2,appimg3,appintro,app_download_url,add_time,app_vip_status from app_list where CONCAT(appname) LIKE '%{$_GET['name']}%';";
					$res = $conn->query($sql);
					$row = $res->fetch_all(MYSQLI_ASSOC);
					$res->free_result();
					if(!empty($row)){
						echo json(array("code"=>200,"msg"=>"success","data"=>$row));
					}else{
						echo json(array("code"=>200,"msg"=>"没有找到相关应用","data"=>$row));
					}
				}else{
					echo json(array("code"=>201,"msg"=>"未知错误"));
				}
			}else if($_GET["data"] == "app_announ"){
				$sql = "select app_announ,announ_status from app_data";
				$res = $conn->query($sql);
				$row = $res->fetch_assoc();
				$res->free_result();
				if(empty($row)){
					$row = array("announ_status"=>"1");
				}
				echo json(array("code"=>200,"msg"=>"success","data"=>$row));
			}else if($_GET["data"] == "app_update"){
				$sql = "select update_num,update_msg,update_url,update_status from app_data";
				$res = $conn->query($sql);
				$row = $res->fetch_assoc();
				$res->free_result();
				if(empty($row)){
					$row = array("update_status"=>"1");
				}
				echo json(array("code"=>200,"msg"=>"success","data"=>$row));
			}else if($_GET["data"] == "app_type"){
				$sql = "select app_type from app_type";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQLI_ASSOC);
				$res->free_result();
				if(empty($row)){
					echo json(array("code"=>200,"msg"=>"success","data"=>""));
				}else{
					foreach($row as $v){
						$app_type[] = $v['app_type'];
					}
					echo json(array("code"=>200,"msg"=>"success","data"=>implode('|',$app_type)));
				}
			}else if($_GET["data"] == "app_home"){
				$sql = "select id,appname,appsize,applogo,appsort,appintro,add_time,app_download_url,app_vip_status from app_list order by add_time desc limit 0,20";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQLI_ASSOC);
				$res->free_result();
				echo json(array("code"=>200,"msg"=>"success","data"=>$row));
			}else if($_GET["data"] == "app_download"){
				if(!empty($_GET['name'])){
					$sql = "select expire_time from app_user where username='{$username}'";
					$res = $conn->query($sql);
					$row = $res->fetch_assoc();
					$res->free_result();
					if(!empty($row)){
						$expire_status = strtotime($row["expire_time"]);
						if($expire_status < time()){
							echo json(array("code"=>201,"msg"=>"你还不是会员"));
						}else{
							$sql = "select id,appname,app_download_url,app_vip_status from app_list where appname='{$_GET['name']}'";
							$res = $conn->query($sql);
							$row = $res->fetch_assoc();
							$res->free_result();
							if(!empty($row)){
								echo json(array("code"=>200,"msg"=>"success","data"=>$row));
							}else{
								echo json(array("code"=>202,"msg"=>"应用不存在"));
							}
						}
					}
				}
			}else if($_GET["data"] == "app_vip_config"){
				$sql = "select package_num,package_title,package_money,package_days from app_vip_config";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQL_ASSOC);
				$res->free_result();
				echo json(array("code"=>200,"msg"=>"success","data"=>$row));
			}else if($_GET["data"] == "app_pay_config"){
				$sql = "select qq_pay_url,wx_pay_url,zfb_pay_url from app_pay_config";
				$res = $conn->query($sql);
				$row = $res->fetch_assoc();
				$res->free_result();
				echo json(array("code"=>200,"msg"=>"success","data"=>$row));
			}else if($_GET["data"] == "bill_msg"){
				$sql = "select * from app_bill_msg where username='{$username}'";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQLI_ASSOC);
				$res->free_result();
				for($i=0;$i<count($row);$i++){
					if($row[$i]['bill_type'] == 0){
						$row[$i]['bill_type'] = "审核通知";
					}else if($row[$i]['bill_type'] == 1){
						$row[$i]['bill_type'] = "审核通过";
					}else if($row[$i]['bill_type'] == 2){
						$row[$i]['bill_type'] = "驳回通知";
					}
				}
				$billstatus[0] = 0;
				$billstatus[1] = 0;
				for($i=0;$i<count($row);$i++){
					if($row[$i]['bill_msg_status'] == 0){
						$billstatus[0] = $billstatus[0]+1;
					}else if($row[$i]['bill_msg_status'] == 1){
						$billstatus[1] = $billstatus[1]+1;
					}
				}
				echo json(array("code"=>200,"msg"=>"success","bill_total"=>$billstatus[0],"data"=>$row));
			}else if($_GET["data"] == "bill_msg_status"){
				$billmsgid = $data['bill_msg_id'];
				if($billmsgid == null){
					$conn->close();
					die(json(array("code"=>201,"msg"=>"请输入ID")));
				}
				$sql = "update app_bill_msg set bill_msg_status='1' where id='{$billmsgid}';";
				if($conn->query($sql)){
					echo json(array("code"=>200,"msg"=>"修改成功"));
				}else{
					echo json(array("code"=>202,"msg"=>"修改失败"));
				}
			}else{
				echo json(array("code"=>208,"msg"=>"error"));
			}
		}else{
			echo json(array("code"=>208,"msg"=>"CRS验证失败"));
		}
	}

	$conn->close();
	exit();
}else if(isset($_GET["add_bill"])){
	if($data == null){
		die(json(array("code"=>201,"msg"=>"非法请求")));
	}else if(!isset($username) && !isset($password)){
		die(json(array("code"=>202,"msg"=>"非法请求")));
	}else if($username == null && $passname == null){
		die(json(array("code"=>203,"msg"=>"请输入账号密码")));
	}else if(!is_numeric($username)){
		die(json(array("code"=>204,"msg"=>"账号必须为数字")));
	}

	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
	if($conn->connect_error){
		die("连接失败: ".$conn->connect_error);
	}
	$sql = "select * from app_user where username='".daddslashes($username)."'";
	$res = $conn->query($sql);
	$row = $res->fetch_assoc();
	$res->free_result();

	if(empty($row)){
		echo json(array("code"=>205,"msg"=>"账号不存在"));
	}else if(isset($crs)){
		if($crs == null){
			echo json(array("code"=>206,"msg"=>"CRS为空"));
		}else if(strlen($crs) != 32){
			echo json(array("code"=>207,"msg"=>"CRS错误"));
		}else if($row["password"] == $crs){
			$money = $data["money"];
			$paytype = $data["pay_type"];
			$packagenum = $data["package_num"];
			if($username == null){
				die(json(array("code"=>201,"msg"=>"请输入账号")));
			}else if($money == null){
				die(json(array("code"=>202,"msg"=>"请输入套餐金额")));
			}else if($paytype == null){
				die(json(array("code"=>203,"msg"=>"请输入支付方式")));
			}else if($packagenum == null){
				die(json(array("code"=>204,"msg"=>"请输入套餐序号")));
			}

			$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
			if($conn->connect_error){
				die("连接失败: ".$conn->connect_error);
			}
			$time = date('Y-m-d H:i:s');
			$sql = "insert into app_bill (username,package_num,money,pay_type,intimate_time,pay_status) values ('{$username}','{$packagenum}','{$money}','{$paytype}','{$time}','0');";
			if($conn->query($sql)){
				$time = date('Y-m-d H:i:s');
				if($paytype == "qq"){
					$paytype = "QQ";
				}else if($paytype == "wx"){
					$paytype = "微信";
				}else if($paytype == "zfb"){
					$paytype = "支付宝";
				}
				$sql = "insert into app_bill_msg (username,bill_type,bill_msg,bill_msg_status,bill_msg_time) values ('{$username}','0','您于{$time}通过{$paytype}支付{$money}元购买套餐{$packagenum}，目前账单正在审核中，请注意查看消息通知，等待审核结果，如有疑问请联系客服。','0','{$time}');";
				$conn->query($sql);
				echo json(array("code"=>200,"msg"=>"订单生成成功"));
			}else{
				echo json(array("code"=>205,"msg"=>"订单生成失败"));
			}
		}else{
			echo json(array("code"=>208,"msg"=>"CRS验证失败"));
		}
	}

	$conn->close();
	exit();
}else if(isset($_GET["captcha"])){
	define('ROOT_PATH', dirname(__FILE__));
	require '../data/code.class.php';
	$_mulin = new ValidateCode();
	$_mulin->doimg();
	$_SESSION['captcha'] = $_mulin->getCode();
}else{
	
}


function json($data){
	$json = json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	return $json;
}


// 在每个双引号（"）前添加反斜杠
function daddslashes($string, $force = 0, $strip = FALSE){
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force){
		if(is_array($string)){
			foreach($string as $key => $val){
				$string[$key] = daddslashes($val, $force, $strip);
			}
		}else{
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function nickname($qq) {
	$url = "https://api.unipay.qq.com/v1/r/1450000186/wechat_query";
	$post = "cmd=1&pf=mds_storeopen_qb-2199_-html5&pfkey=pfkey&from_h5=1&from_https=1&openid=78A8D213B39EAEFFDCABDAFD0D328DDF&openkey=A3BCB20F3C65085A3AC8E226B1394737&session_id=openid&session_type=kp_accesstoken&qq_appid=101502376&offerId=1450000186&sandbox=&provide_uin=".$qq;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($data,true);
	return urldecode($data["nick"]);
}