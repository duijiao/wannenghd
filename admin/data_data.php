<?php
include "../data/config.php";
if(isset($_COOKIE['user_data']) && !empty($_COOKIE['user_data'])) {
	$dejson = json_decode($_COOKIE['user_data'],true);
	$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
	$res = $conn->query('SELECT * from app_admin WHERE username="'.$dejson["username"].'"');
	$row = $res->fetch_assoc();
	if(isset($dejson["username"]) && isset($dejson["password"])) {
		if(!empty($dejson["username"]) && !empty($dejson["password"])) {
			if($row["username"] == $dejson["username"] && $row['password'] == $dejson["password"]) {
				setcookie("user_data",$_COOKIE['user_data'],time()+604800);
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