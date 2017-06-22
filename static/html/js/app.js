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
