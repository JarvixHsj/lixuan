
$(function(){
	//首页产品列表图片平衡高度
	$(".i_prolist li").each(function(){
		var pic = $(this).find(".i_pro_pic");
		var picw = pic.outerWidth(true);
		var pich = null;
		pich = (picw*3)/4;
		pic.height(pich);
	});

});

function judgeEmpty(content, msg, title, buttons,callback)
{
    var title = title ? title : '提示';
    var buttons = buttons ? buttons : '确定';
    if (content == null || content == undefined || content == '' || content == 0) {
        mui.alert(msg, title, buttons);
        return false;
        throw SyntaxError();
    }
}

