<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/Library/WebServer/Documents/lixuan/application/wechat/view/news.image.html";i:1497187871;s:74:"/Library/WebServer/Documents/lixuan/application/extra/view/admin.main.html";i:1497187871;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="shortcut icon" href="<?php echo sysconf('browser_icon'); ?>" />
        <title><?php echo (isset($title) && ($title !== '')?$title:''); ?>&nbsp;<?php if(!empty($title)): ?>-<?php endif; ?>&nbsp;<?php echo sysconf('site_name'); ?></title>
        <link rel="stylesheet" href="__PUBLIC__/static/plugs/bootstrap/css/bootstrap.min.css?ver=<?php echo date('ymd'); ?>"/>
        <link rel="stylesheet" href="__PUBLIC__/static/plugs/layui/css/layui.css?ver=<?php echo date('ymd'); ?>"/>
        <link rel="stylesheet" href="__PUBLIC__/static/theme/default/css/console.css?ver=<?php echo date('ymd'); ?>">
        <link rel="stylesheet" href="__PUBLIC__/static/theme/default/css/animate.css?ver=<?php echo date('ymd'); ?>">
        <script>window.ROOT_URL = '__PUBLIC__';</script>
        <script src="__PUBLIC__/static/plugs/require/require.js?ver=<?php echo date('ymd'); ?>"></script>
        <script src="__PUBLIC__/static/admin/app.js?ver=<?php echo date('ymd'); ?>"></script>
    </head>
    
    <body>
        
<style>
    body{min-width:100px!important}
    .pagination{padding:0 10px}
    .news-image{cursor:pointer;width:111px;height:120px;background-size:cover;background-position:center center;float:left;margin:10px;border:1px solid rgba(125,125,125,0.3)}
</style>
<div class="news-container" id='news_box'>
    <?php foreach($list as $key=>$vo): ?>
    <a class="news-image transition" data-src='<?php echo $vo['local_url']; ?>' style="background-image:url('<?php echo $vo['local_url']; ?>')"></a>
    <?php endforeach; ?>
    <div style='clear:both'></div>
</div>

<?php if(isset($page)): ?><?php echo $page; endif; ?>
<script>
    require(['jquery'], function () {
        $('body').on('click', '[data-open]', function () {
            window.location.href = this.getAttribute('data-open');
        }).on('click', '.news-image', function () {
            var src = this.getAttribute('data-src');
            top.$('[name="<?php echo $field; ?>"]').val(src).trigger('change');
            parent.layer.close(parent.layer.getFrameIndex(window.name));
        });
    });
</script>

        
    </body>
    
</html>