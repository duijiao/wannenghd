<?php
include "data.php";
?>

<!DOCTYPE html>
<html lang="zh">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="chouren">
<title><?php echo $title; ?> - 后台管理 - 对角软件库</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="stylesheet" type="text/css" href="../assets/css/materialdesignicons.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link href="../assets/js/jquery-confirm/jquery-confirm.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../assets/css/animate.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/style.min.css">
<style>
/* 长条形的数据统计布局 */
.card-banner {
    margin-left: 0px;
    margin-right: 0px;
    margin-bottom: 24px;
    padding: 15px 0px;
    -webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.035);
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.035);
}
.card-banner .card {
    margin-bottom: 0px;
    -webkit-box-shadow: none;
    box-shadow: none;
    background-color: transparent;
}
.card-banner [class*=col] .card:before {
    position: absolute;
    height: calc(100%);
    width: 1px;
    background: rgba(77, 82, 89, 0.05);
    content: '';
    right: -15px;
}
.card-banner:not(.bg-white) [class*=col] .card:before {
    background: rgba(255, 255, 255, 0.175);
}
@media screen and (max-width: 576px) {
    .card-banner [class*=col-] .card:before {
        width: calc(100% - 30px)!important;
        right: 15px!important;
        height: 1px!important;
    }
    .card-banner [class*=col-]:first-child .card:before{
        display:none!important
    }
}
</style>
</head>

<body>
<!--页面loading-->
<div id="lyear-preloader" class="loading">
  <div class="ctn-preloader">
    <div class="round_spinner">
      <div class="spinner"></div>
      <img src="http://q.qlogo.cn/headimg_dl?dst_uin=2732144397&spec=640&img_type=jpg" alt="">
    </div>
  </div>
</div>
<!--页面loading end-->
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="./"><img src="../assets/images/logo-icon.png" height="36px" title="chouren" alt="chouren" /></a>
      </div>
      <div class="lyear-layout-sidebar-info lyear-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav-drawer">
            <li class="nav-item active"> <a href="./"><i class="mdi mdi-home"></i> <span>首页</span></a> </li>



            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-cube-outline"></i> <span>功能</span></a>
              <ul class="nav nav-subnav">
                <li> <a href="manageapp.php">管理功能</a> </li>
                <li> <a href="addapp.php">添加功能</a> </li>
              </ul>
            </li>

            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-account-supervisor"></i> <span>用户</span></a>
              <ul class="nav nav-subnav">
                <li> <a href="manageuser.php">管理用户</a> </li>
                <li> <a href="adduser.php">添加用户</a> </li>
              </ul>
            </li>

            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-square-inc-cash"></i> <span>财务</span></a>
              <ul class="nav nav-subnav">
                <li> <a href="billlist.php">账单列表</a> </li>
              </ul>
            </li>

            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-settings"></i> <span>设置</span></a>
              <ul class="nav nav-subnav">
                <li> <a href="appannoun.php">软件公告</a> </li>
                <li> <a href="appupdate.php">软件更新</a> </li>
                <li> <a href="appkami.php">卡密配置</a> </li>
                <li> <a href="managekm.php">管理卡密</a> </li>
              </ul>

            </li>

            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-emoticon-happy-outline"></i> <span>关于</span></a>
              <ul class="nav nav-subnav">
                <li> <a href="lyear_forms_elements.html">对角网络工作室</a> </li>
              </ul>
            </li>



          </ul>
        </nav>
        
        <div class="sidebar-footer">
          <p class="copyright">Copyright &copy; 2021. <a target="_blank" href="./">对角管理系统</a> All rights reserved.</p>
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->
    
    <!--头部信息-->
    <header class="lyear-layout-header">
      
      <nav class="navbar">
      
        <div class="navbar-left">
          <div class="lyear-aside-toggler">
            <span class="lyear-toggler-bar"></span>
            <span class="lyear-toggler-bar"></span>
            <span class="lyear-toggler-bar"></span>
          </div>
        </div>
        
        <ul class="navbar-right d-flex align-items-center">
          <!--切换主题配色-->
		  <li class="dropdown dropdown-skin">
		    <span data-toggle="dropdown" class="icon-item"><i class="mdi mdi-palette"></i></span>
			<ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
              <li class="drop-title"><p>主题</p></li>
              <li class="drop-skin-li clearfix">
                <span class="inverse">
                  <input type="radio" name="site_theme" value="default" id="site_theme_1" checked>
                  <label for="site_theme_1"></label>
                </span>
                <span>
                  <input type="radio" name="site_theme" value="dark" id="site_theme_2">
                  <label for="site_theme_2"></label>
                </span>
                <span>
                  <input type="radio" name="site_theme" value="translucent" id="site_theme_3">
                  <label for="site_theme_3"></label>
                </span>
              </li>
			  <li class="drop-title"><p>LOGO</p></li>
			  <li class="drop-skin-li clearfix">
                <span class="inverse">
                  <input type="radio" name="logo_bg" value="default" id="logo_bg_1" checked>
                  <label for="logo_bg_1"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
                  <label for="logo_bg_2"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
                  <label for="logo_bg_3"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
                  <label for="logo_bg_4"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_5" id="logo_bg_5">
                  <label for="logo_bg_5"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
                  <label for="logo_bg_6"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
                  <label for="logo_bg_7"></label>
                </span>
                <span>
                  <input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
                  <label for="logo_bg_8"></label>
                </span>
			  </li>
			  <li class="drop-title"><p>头部</p></li>
			  <li class="drop-skin-li clearfix">
                <span class="inverse">
                  <input type="radio" name="header_bg" value="default" id="header_bg_1" checked>
                  <label for="header_bg_1"></label>                      
                </span>                                                    
                <span>                                                     
                  <input type="radio" name="header_bg" value="color_2" id="header_bg_2">
                  <label for="header_bg_2"></label>                      
                </span>                                                    
                <span>                                                     
                  <input type="radio" name="header_bg" value="color_3" id="header_bg_3">
                  <label for="header_bg_3"></label>
                </span>
                <span>
                  <input type="radio" name="header_bg" value="color_4" id="header_bg_4">
                  <label for="header_bg_4"></label>                      
                </span>                                                    
                <span>                                                     
                  <input type="radio" name="header_bg" value="color_5" id="header_bg_5">
                  <label for="header_bg_5"></label>                      
                </span>                                                    
                <span>                                                     
                  <input type="radio" name="header_bg" value="color_6" id="header_bg_6">
                  <label for="header_bg_6"></label>                      
                </span>                                                    
                <span>                                                     
                  <input type="radio" name="header_bg" value="color_7" id="header_bg_7">
                  <label for="header_bg_7"></label>
                </span>
                <span>
                  <input type="radio" name="header_bg" value="color_8" id="header_bg_8">
                  <label for="header_bg_8"></label>
                </span>
				</li>
			  <li class="drop-title"><p>侧边栏</p></li>
			  <li class="drop-skin-li clearfix">
                <span class="inverse">
                  <input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" checked>
                  <label for="sidebar_bg_1"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
                  <label for="sidebar_bg_2"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
                  <label for="sidebar_bg_3"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
                  <label for="sidebar_bg_4"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5">
                  <label for="sidebar_bg_5"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
                  <label for="sidebar_bg_6"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
                  <label for="sidebar_bg_7"></label>
                </span>
                <span>
                  <input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
                  <label for="sidebar_bg_8"></label>
                </span>
			  </li>
		    </ul>
		  </li>
          <!--切换主题配色-->
          <li class="dropdown dropdown-profile">
            <a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle">
              <img class="img-avatar img-avatar-48 m-r-10" src="http://q.qlogo.cn/headimg_dl?dst_uin=2732144397&spec=640&img_type=jpg" alt="Chouren" />
              <span><?php echo $data_user;?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li>
                <a class="dropdown-item" href="modifypwd.php"><i class="mdi mdi-lock-outline"></i> 修改密码</a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-delete"></i> 清空缓存</a>
              </li>
              <li class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="./login.php?action=abort"><i class="mdi mdi-logout-variant"></i> 退出登录</a>
              </li>
            </ul>
          </li>
        </ul>
        
      </nav>
      
    </header>
    <!--End 头部信息-->
