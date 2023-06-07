<?php
$title = "支付配置";
include "head.php";
require "../data/config.php";
$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWD,DB_NAME);
if($conn->connect_error){
	die("连接失败: ".$conn->connect_error);
}
$sql = "select * from app_pay_config";
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
              <header class="card-header"><div class="card-title">支付配置</div></header>
              <div class="card-body">
                
                <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data" onsubmit="return false;">

            <div class="form-group file-group">
              <label for="web_site_logo">QQ支付二维码</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['qq_pay_url'];?>" id="qqpayurl" placeholder="QQ支付二维码地址" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>
            <div class="form-group file-group">
              <label for="web_site_logo">微信支付二维码</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['wx_pay_url'];?>" id="wxpayurl" placeholder="微信支付二维码地址" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>
            <div class="form-group file-group">
              <label for="web_site_logo">支付宝支付二维码</label>
              <div class="input-group">
                <input type="text" class="form-control file-value" name="web_site_logo" value="<?php echo $row['zfb_pay_url'];?>" id="zfbpayurl" placeholder="支付宝支付二维码地址" />
                <input type="file" accaccept=".png,.jpg,.jpeg,.bmp,.gif" class="d-none" />
                <div class="input-group-append">
                  <button class="btn btn-default file-browser" type="button">上传图片</button>
                </div>
              </div>
            </div>


                    <button class="btn btn-block btn-primary" id="payconfig">修改</button>

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
	$('#payconfig').click(function(){
		var qqpayurl = $('#qqpayurl').val();
		var wxpayurl = $('#wxpayurl').val();
		var zfbpayurl = $('#zfbpayurl').val();
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
			"/api/admindata.php?app_pay_config",
			JSON.stringify({
			"login_data": user_data,
			"qq_pay_url": qqpayurl,
			"wx_pay_url": wxpayurl,
			"zfb_pay_url": zfbpayurl
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