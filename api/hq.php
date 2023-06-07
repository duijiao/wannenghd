<?php

require "../data/config.php";
header('Content-type:text/json;charset=utf-8');
session_start();

$hqfs=$_GET["hqfs"];

$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
    die("连接失败: ".$conn->connect_error);
}else{
	
	
	
		
	
	if($hqfs == "sylist")
	{
	
	        	$sql = "select id,appname,appsize,applogo,appsort,appintro,add_time,app_vip_status from app_list order by add_time ASC limit 0,20";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQLI_ASSOC);
				$res->free_result();
				echo json_encode(array("code"=>200,"msg"=>"success","data"=>$row));
				$conn->close();

    }else if($hqfs == "ggt")
    {
                $sql = "select tupian1,tupian2,tupian3,link1,link2,link3 from app_gg";
				$res = $conn->query($sql);
				$row = $res->fetch_assoc();
				$res->free_result();
				echo json_encode(array("code"=>200,"msg"=>"广告图","data"=>$row));
				$conn->close();
				

    
    }else if($hqfs == "rjgx")
    {
             	$sql = "select update_num,update_msg,update_url,update_status from app_data";
				$res = $conn->query($sql);
				$row = $res->fetch_assoc();
				$res->free_result();
				if(empty($row)){
					$row = array("update_status"=>"1");
				}
				echo json_encode(array("code"=>200,"msg"=>"软件更新","data"=>$row));
				$conn->close();
				

    
    }else if($hqfs == "gg")
    {
             	$sql = "select app_announ,announ_status from app_data";
				$res = $conn->query($sql);
				$row = $res->fetch_assoc();
				$res->free_result();
				if(empty($row)){
					$row = array("announ_status"=>"1");
				}
				echo json_encode(array("code"=>200,"msg"=>"success","data"=>$row));
				$conn->close();

    
    }else if($hqfs == "hylist")
    {
             	$sql = "select id,hyname,hyintro,hytime,link,logo,color from hy_list order by id asc limit 0,20";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQLI_ASSOC);
				$res->free_result();
				echo json_encode(array("code"=>200,"msg"=>"首页会员","data"=>$row));
				$conn->close();
    
    }else if($hqfs == "tjnr")
    {
                $sql = "select id,nr,time from hytj order by id asc limit 0,20";
				$res = $conn->query($sql);
				$row = $res->fetch_all(MYSQLI_ASSOC);
				$res->free_result();
				echo json_encode(array("code"=>200,"msg"=>"提交内容","data"=>$row));
				$conn->close();
				

    
    }
    
    
    else{
    
             echo "获取失败请重新！！";
    
    }
    

		
}
	
	

?>  