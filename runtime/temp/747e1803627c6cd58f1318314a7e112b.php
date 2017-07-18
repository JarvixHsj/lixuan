<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/Library/WebServer/Documents/lixuan/application/html/view/login.index.html";i:1499271854;s:73:"/Library/WebServer/Documents/lixuan/application/extra/view/html.main.html";i:1500302650;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
         <title><?php echo (isset($title) && ($title !== '')?$title:''); ?>&nbsp;<?php if(!empty($title)): ?>-<?php endif; ?>&nbsp;<?php echo sysconf('site_name'); ?></title>

        <script type="text/javascript" src="__PUBLIC__/static/html/js/jquery_1.11.3.min.js" ></script>
        <script src="__PUBLIC__/static/html/js/mui.min.js"></script>
        <script type="text/javascript" src="__PUBLIC__/static/html/js/app.js?ver=<?php echo date('ymdHis'); ?>" ></script>

        <link href="__PUBLIC__/static/html/css/mui.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="__PUBLIC__/static/html/css/app.css?ver=<?php echo date('ymdHis'); ?>" />
        
        <script type="text/javascript" charset="utf-8">
            mui.init();
        </script>
    </head>
    
        <body>
            
	<div class="mui-content">
	    <div class="log_head mui-text-center">
	    	<div class="log_logo center_block" style="background-image: url(__PUBLIC__/static/html/img/logo.png);"></div>
	    	<p class="log_title">励轩代理后台登录</p>
	    </div>
	    <form action="__SELF__" method="post">
    		<input class="log_input" type="text" maxlength="11" name="mobile" placeholder="请输入手机号码" value="" />
    		<input class="log_input" type="password" maxlength="16" name="password" placeholder="请输入密码" value="" />
    		<button class="log_btn" type="button">登录</button>
	    </form>
	</div>
	<script type="text/javascript">
        $('.log_btn').click(function(){
            var loginUrl = "<?php echo Url('Login/ajaxLogin'); ?>";
            var mobile = $("input:text[name='mobile']").val();
            var password = $("input:password[name='password']").val();
            judgeEmpty(mobile,'手机号不能为空');
            judgeEmpty(password,'密码不能为空');
            $.ajax({
                type: "POST",
                url: loginUrl,
                data: {'mobile': mobile,'password': password},
                success: function(res){
                    if(res.status == 0){
                        mui.alert(res.msg,'提示');
                    }else if(res.status == 1){
                        mui.toast(res.msg);
                        window.location.href = res.url;
                    }
                }
            });
        })

        //自动消失提示框
		// mui.toast('密码修改成功，请重新登录');

	</script>

            
        </body>
    
</html>