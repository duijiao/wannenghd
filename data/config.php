<?php

	$mysql_conn=array(
        "localhost",  //数据库连接地址，默认：localhost或127.0.0.1
        "root",       //数据库账号
        "zhang123456", //数据库密码
        "grrjk",  //数据库名称
        "3306"
        
	);
	$config=array(
    'host'=>$mysql_conn['0'],//数据库地址
    'sqluser'=>$mysql_conn['1'],//数据库用户名
    'sqlpass'=>$mysql_conn['2'],//数据库密码
    'dbname'=>$mysql_conn['3'],//数据库名


);


define('DB_HOST',$mysql_conn['0']);
define('DB_USER',$mysql_conn['1']);
define('DB_PASSWD',$mysql_conn['2']);
define('DB_NAME',$mysql_conn['3']);
?>