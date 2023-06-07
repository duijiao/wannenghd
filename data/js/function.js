/*bootstrap notify通知消息*/
function Chouren_notify(content,code,type){
	$.notify({
		message: content
	},{
		element: 'body',
		type: type,
		allow_dismiss: code,
		newest_on_top: true,
		showProgressbar: false,
		placement: {
			from: "top",
			align: "center"
		},
		offset: 20,
		spacing: 10,
		z_index: 9999,
		delay: 1000,
		//timer: 1000,
		animate: {
		enter: 'animated fadeInDown',
		exit: 'animated fadeOutUp'
		}
	});
}
/*
Chouren_notify(内容,x显示状态,背景颜色);

success 成功 绿色
info 蓝色 信息
warning 警告 橙色
danger 危险 红色

true 显示x
false 不显示x
*/

/*jQuery confirm弹窗*/
function jQuery_confirm(head,title,content,color,text,url){
	$.confirm({
		title: title,
		content: content,
		type: head,
		typeAnimated: true,
		buttons: {
			button: {
				text: text,
				btnClass: color,
				action: function(){
					if(url != null){
						window.location.href=url;
					}
				}
			}
		}
	});
}
/*
jQuery_confirm(头颜色,标题,内容,按钮颜色,按钮文字,url);

Dialog 类型
green 绿色
red 红色
orange 橙色
blue 蓝色
purple 紫色
dark 灰色

按钮风格
jconfirm：
btn-blue 蓝色
btn-green 绿色
btn-redbtn-orange 橙色
btn-purple 紫色
btn-default 默认
btn-dark 深灰

bootstrap：
btn-primary 主
btn-inverse 逆
btn-warning 警告 橙色
btn-info 信息 天空蓝
btn-danger 危险 红色
btn-success 成功 绿色
*/