<?php
$title = "应用修改";
include "head.php";
require "../data/config.php";
$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
	die("连接失败: ".$conn->connect_error);
}
$sql = "select * from app_list where id='{$_GET['appid']}'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$res->free_result();
$sql = "select app_type from app_type";
$res = $conn->query($sql);
$row1 = $res->fetch_all();
$res->free_result();
$conn->close();
?>



    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div class="container-fluid p-t-15">
        
        <div class="row">
          
          <div class="col-lg-6">
            <div class="card">
              <header class="card-header"><div class="card-title">应用修改</div></header>
              <div class="card-body">
                
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">
                  <div class="form-group">
                    <label for="exampleFormControlInput1">应用名称</label>
                    <input type="text" class="form-control" id="appname" placeholder="请输入应用名称" value="<?php echo $row['appname'];?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlInput1">应用大小</label>
                    <input type="text" class="form-control" id="appsize" placeholder="请输入应用大小（MB）" value="<?php echo $row['appsize'];?>">
                  </div>
            <div class="form-group file-group">
              <label for="web_site_logo">应用LOGO</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['applogo'];?>" id="applogo" placeholder="LOGO图片地址" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">选择分类</label>
                    <select class="form-control" id="appsort">
                    <?php
                    foreach($row1 as $k => $v){
                    	foreach($v as $k => $v){
                    		if($row['appsort'] == $v){
                    			echo '<option selected>'.$v.'</option>';
                    		}else{
                    			echo '<option>'.$v.'</option>';
                    		}
                    	}
                    }
                    ?>
                    </select>
                  </div>

            <div class="form-group file-group">
              <label for="web_site_logo">应用截图1</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['appimg1'];?>" id="appimg1" placeholder="应用截图地址" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>

            <div class="form-group file-group">
              <label for="web_site_logo">应用截图2</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['appimg2'];?>" id="appimg2" placeholder="应用截图地址2" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>

            <div class="form-group file-group">
              <label for="web_site_logo">应用截图3</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['appimg3'];?>" id="appimg3" placeholder="应用截图地址3" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>

                  <div class="form-group">
                    <label for="exampleFormControlInput1">应用下载链接</label>
                    <input type="text" class="form-control" id="appurl" placeholder="请输入应用下载链接" value="<?php echo $row['app_download_url'];?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">应用介绍</label>
                    <textarea class="form-control" id="appintro" rows="3" placeholder="请输入应用介绍"><?php echo $row['appintro'];?></textarea>
                  </div>

            <div class="form-group">
              <label for="exampleFormControlSelect1">收费状态</label>
              <select class="form-control" id="appvipstatus">
                <?php
                if($row['app_vip_status'] == 1){
                	echo '<option value="1" selected>收费</option><option value="0">免费</option>';
                }else if($row['app_vip_status'] == 0){
                	echo '<option value="1">收费</option><option value="0" selected>免费</option>';
                }
                ?>
              </select>
            </div>

                    <button class="btn btn-block btn-primary" id="addapp">修改</button>

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
$(document).ready(function() {
    $(document).on('click', '.file-browser', function() {
        var $browser = $(this);
        var file = $browser.closest('.file-group').find('[type="file"]');
        file.on( 'click', function(e) {
            e.stopPropagation();
        });
        file.trigger('click');
    });
    
    $(document).on('change', '.file-group [type="file"]', function() {
        var $this    = $(this);
        var $input   = $(this)[0];
        var $len     = $input.files.length;
        var formFile = new FormData();
        
        if ($len == 0) {
            return false;
        } else {
            var fileAccaccept = $this.attr('accaccept');
            var fileType      = $input.files[0].type;
            var type          = (fileType.substr(fileType.lastIndexOf("/") + 1)).toLowerCase();
            
            if (!type || fileAccaccept.indexOf(type) == -1) {
                jQuery.notify({
                    icon: '',
                    message: '您上传图片的类型不符合(.jpg|.jpeg|.gif|.png|.bmp)'
                },
                {
                    element: 'body',
                    type: 'danger',
                    allow_dismiss: true,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: 'top',
                        align: 'center'
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 10800,
                    delay: 1000,
                    animate: {
                        enter: 'animated shake',
                        exit: 'animated fadeOutDown'
                    }
                });
                return false;
            }
            formFile.append("file", $input.files[0]);
        }
        
        var data = formFile;
        var l = $('body').lyearloading({
            opacity: 0.2,
            spinnerSize: 'nm'
        });
        
        $.ajax({
            url: 'upload.php',
            data: data,
            type: "POST",
            dataType: "json",
            //上传文件无需缓存
            cache: false,
            //用于对data参数进行序列化处理 这里必须false
             processData: false,
            //必须
            contentType: false, 
            success: function (res) {
                l.destroy();
                if (res.status === 1) {
                    $this.closest('.file-group').find('.file-value').val(res.url);
                } else {
                    jQuery.notify({
                        icon: '',
                        message: res.info
                    },
                    {
                        element: 'body',
                        type: 'danger',
                        allow_dismiss: true,
                        newest_on_top: true,
                        showProgressbar: false,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        offset: 20,
                        spacing: 10,
                        z_index: 10800,
                        delay: 3000,
                        animate: {
                            enter: 'animated shake',
                            exit: 'animated fadeOutDown'
                        }
                    });
                }
            },
        });
    });
});
</script>
<script type="text/javascript">
$(function(){
	$('#addapp').click(function(){
		var appname = $('#appname').val();
		var appsize = $('#appsize').val();
		var applogo = $('#applogo').val();
		var appsort =  $("#appsort").find("option:selected").text();
		var appimg1 = $('#appimg1').val();
		var appimg2 = $('#appimg2').val();
		var appimg3 = $('#appimg3').val();
		var appurl = $('#appurl').val();
		var appintro = $('#appintro').val();
		var appvipstatus = $('#appvipstatus').val();
		if(appname == ""){
			Chouren_notify("请输入应用名称",true,"warning");
			return;
		}else if(appsize == ""){
			Chouren_notify("请输入应用大小",true,"warning");
			return;
		}else if(applogo == ""){
			Chouren_notify("请输入应用logo地址",true,"warning");
			return;
		}else if(appsort == ""){
			Chouren_notify("请选择应用分类",true,"warning");
			return;
		}else if(appurl == ""){
			Chouren_notify("请输入应用下载链接",true,"warning");
			return;
		}else if(appintro == ""){
			Chouren_notify("请输入应用介绍",true,"warning");
			return;
		}else if(appvipstatus == ""){
			Chouren_notify("请选择收费状态",true,"warning");
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
			"/api/admindata.php?modify_app_data",
			JSON.stringify({
			"login_data": user_data,
			"appname": appname,
			"appsize": appsize,
			"applogo": applogo,
			"appsort": appsort,
			"appimg1": appimg1,
			"appimg2": appimg2,
			"appimg3": appimg3,
			"appurl": appurl,
			"appintro": appintro,
			"app_vip_status": appvipstatus,
			"app_id": <?php echo $row['id'];?>
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