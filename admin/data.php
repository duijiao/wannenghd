<?php
include "../data/config.php";
if($_GET['action'] == "login") {
	$json = file_get_contents('php://input');
	$arr = json_decode($json, true);
	$username = $arr['username'];
	$password = $arr['password'];
	if(isset($username) || isset($password)){
		if(!empty($username)){
			if(!empty($password)){
				if(!empty($arr['captcha'])){
					session_start();
					if(strtolower($_SESSION['captcha']) == strtolower($arr['captcha'])){
						$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
						$res = $conn->query("select * from app_admin where username='$username'");
						$row = $res->fetch_assoc();
						if(!is_array($row)){
							$json = array("code"=>1001, "msg"=>"用户名不存在！", "Boolean"=>true, "notify_color"=>"danger", "captcha"=>true);
							goto end;
						}
						if($row['password'] != md5($password)){
							$json = array("code"=>1002, "msg"=>"密码不正确！", "Boolean"=>true, "notify_color"=>"danger", "captcha"=>true);
						}else if($row['status'] == 1){
							$json = array("code"=>1003, "msg"=>"账号被禁止登录，请联系管理员！", "Boolean"=>true, "notify_color"=>"danger", "captcha"=>true);
						}else if($row['username'] == $username && $row['password'] == md5($password)){
							$text = array("username"=>$username,"password"=>md5($password));
							$enjson = json_encode($text);
							setcookie("user_data",$enjson,time()+604800);
							$time = date('Y-m-d H:i:s');
							$sql = "UPDATE app_admin SET atlast_login_time='{$time}' WHERE username='{$username}'";
							$conn->query($sql);
							$json = array("code"=>1000, "title"=>"登录成功", "msg"=>"愿你成长无所顾忌，愿你未来披荆斩棘。", "Boolean"=>true, "notify_color"=>"green", "location"=>"index", "captcha"=>true);
						}else{
							$json = array("code"=>1004, "msg"=>"系统出现错误，请联系管理员！", "Boolean"=>true, "notify_color"=>"warning", "captcha"=>true);
						}
						end:
						$res->free_result();
						$conn->close();
					}else{
						$json = array("code"=>1005, "msg"=>"验证码错误！", "Boolean"=>true, "notify_color"=>"warning", "captcha"=>true);
					}
				}else{
					$json = array("code"=>1006, "msg"=>"请输入验证码", "Boolean"=>true, "notify_color"=>"info", "captcha"=>false);
				}
			}else{
				$json = array("code"=>1007, "msg"=>"请输入密码", "Boolean"=>true, "notify_color"=>"info", "captcha"=>flase);
			}
		}else{
			$json = array("code"=>1008, "msg"=>"请输入用户名", "Boolean"=>true, "notify_color"=>"info", "captcha"=>flase);
		}
		die(json_encode($json));
	}else{
		die("error.");
	}
}

if(isset($_COOKIE['user_data']) && !empty($_COOKIE['user_data'])){
	$dejson = json_decode($_COOKIE['user_data'],true);
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
	$res = $conn->query('SELECT * from app_admin WHERE username="'.$dejson["username"].'"');
	$row = $res->fetch_assoc();
	if(isset($dejson["username"]) && isset($dejson["password"])){
		if(!empty($dejson["username"]) && !empty($dejson["password"])){
			if($row['username'] == $dejson["username"] && $row['password'] == $dejson["password"]){
				setcookie("user_data",$_COOKIE['user_data'],time()+604800);
				$crmsg = "<script>lightyear.notify('欢迎回来！', 'success');</script>";
				$data_user = $row['username'];
				$time = date('Y-m-d H:i:s');
				$sql = "UPDATE app_admin SET atlast_login_time='{$time}' WHERE username='{$dejson['username']}'";
				$conn->query($sql);
			}else{
				setcookie("user_data","",time()-604800);
				header("location:./login.php");
			}
		}else{
			header("location:./login.php");
		}
	}else{
		header("location:./login.php");
	}
	$res->free_result();
	$conn->close();
}else{
	header("location:./login.php");
}
?>