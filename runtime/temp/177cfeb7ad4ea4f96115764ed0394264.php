<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/Library/WebServer/Documents/lixuan/application/html/view/agent.index.html";i:1498268831;s:73:"/Library/WebServer/Documents/lixuan/application/extra/view/html.main.html";i:1497950307;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
         <title><?php echo (isset($title) && ($title !== '')?$title:''); ?>&nbsp;<?php if(!empty($title)): ?>-<?php endif; ?>&nbsp;<?php echo sysconf('site_name'); ?></title>

        <script type="text/javascript" src="__PUBLIC__/static/html/js/jquery_1.11.3.min.js" ></script>
        <script src="__PUBLIC__/static/html/js/mui.min.js"></script>
        <script type="text/javascript" src="__PUBLIC__/static/html/js/app.js" ></script>

        <link href="__PUBLIC__/static/html/css/mui.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="__PUBLIC__/static/html/css/app.css?ver=<?php echo date('ymd'); ?>" />
        
        <script type="text/javascript" charset="utf-8">
            mui.init();
        </script>
    </head>
    
	<body class="bgf2f2f2">
	
		<header class="mui-bar mui-bar-nav di_navbox">
		    <a href="#" class="dl_nav_btn dl_nav_info"></a>
		    <h1 class="mui-title">经销商后台</h1>
		    <a href="user_content.html" class="dl_nav_btn dl_nav_user"></a>
		</header>
		<div class="mui-content">
			<div class="dl_cont">				
			    <div class="dl_menu_son mui-clearfix">
			    	<a href="user_dailixinxi.html">
			    		<div class="dl_menu_icon dlxx mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">我的代理信息</p>
			    			<p class="text">查询已有代理授权信息</p>
			    		</div>
			    	</a>
			    </div>
			    <div class="dl_menu_son mui-clearfix">
			    	<!--<a href="user_dailijiameng.html">-->
			    	<a href="<?php echo Url('agent/new_agent_index'); ?>">
			    		<div class="dl_menu_icon dljm mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">新代理加盟</p>
			    			<p class="text">查看或生成下级申请代理的分享链接</p>
			    		</div>
			    	</a>
			    </div>
			    <div class="dl_menu_son mui-clearfix">
			    	<a href="#">
			    		<div class="dl_menu_icon xjdl mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">查看下级代理</p>
			    			<p class="text">按品牌查看下级代理信息</p>
			    		</div>
			    	</a>
			    </div>
			    <div class="dl_menu_son mui-clearfix">
			    	<a href="#">
			    		<div class="dl_menu_icon fahuo mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">发货</p>
			    			<p class="text">扫描大箱条码或产品二维码发货给下级代理</p>
			    		</div>
			    	</a>
			    </div>
			    <div class="dl_menu_son mui-clearfix">
			    	<a href="#">
			    		<div class="dl_menu_icon cxdh mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">查询单号</p>
			    			<p class="text">根据出货单号查询发货信息</p>
			    		</div>
			    	</a>
			    </div>
			    <div class="dl_menu_son mui-clearfix">
			    	<a href="#">
			    		<div class="dl_menu_icon wdgk mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">我的顾客</p>
			    			<p class="text">对我的客户进行管理和维护</p>
			    		</div>
			    	</a>
			    </div>
			    <div class="dl_menu_son mui-clearfix">
			    	<a href="#">
			    		<div class="dl_menu_icon caig mui-pull-left"></div>
			    		<div class="dl_menu_text mui-pull-left">
			    			<p class="title">采购</p>
			    			<p class="text">向上级采购货物</p>
			    		</div>
			    	</a>
			    </div>
			</div>
		</div>

	
	</body>

</html>