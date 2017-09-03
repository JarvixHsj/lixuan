<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/Library/WebServer/Documents/lixuan/application/html/view/index.index.html";i:1504189670;s:73:"/Library/WebServer/Documents/lixuan/application/extra/view/html.main.html";i:1501861937;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
         <title><?php echo (isset($title) && ($title !== '')?$title:''); ?>&nbsp;<?php if(!empty($title)): ?>-<?php endif; ?>&nbsp;<?php echo sysconf('site_name'); ?></title>

        <script type="text/javascript" src="__PUBLIC__/static/html/js/jquery_1.11.3.min.js" ></script>
        <script src="__PUBLIC__/static/html/js/mui.min.js"></script>
        <script type="text/javascript" src="__PUBLIC__/static/html/js/app.js?ver=<?php echo date('ymdH'); ?>" ></script>

        <link href="__PUBLIC__/static/html/css/mui.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="__PUBLIC__/static/html/css/app.css?ver=<?php echo date('ymdH'); ?>" />
        
        <script type="text/javascript" charset="utf-8">
            mui.init();
        </script>
    </head>
    
        <body>
            
	
	<div id="slider" class="mui-slider i_banner" >
	  <div class="mui-slider-group mui-slider-loop">
	    <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
          <?php if(empty($banner_res) || (($banner_res instanceof \think\Collection || $banner_res instanceof \think\Paginator ) && $banner_res->isEmpty())): ?>
          <div class="mui-slider-item mui-slider-item-duplicate">
              <a href="#">
                  <img src="__PUBLIC__/static/html/img/banner.png">
              </a>
          </div>
          <?php else: ?>
          <div class="mui-slider-item">
              <a href="<?php echo Url('Index/bannerDetails',['id' => $banner_res[$banner_res_count]['id']]); ?>">
                  <img src="__PUBLIC__/<?php echo $banner_res[$banner_res_count]['image']; ?>">
              </a>
          </div>
          <?php endif; ?>

	    <!-- 第一张 -->
          <?php if(empty($banner_res) || (($banner_res instanceof \think\Collection || $banner_res instanceof \think\Paginator ) && $banner_res->isEmpty())): ?>
              <div class="mui-slider-item">
                  <a href="#">
                      <img src="__PUBLIC__/static/html/img/banner.png">
                  </a>
              </div>
          <?php else: if(is_array($banner_res) || $banner_res instanceof \think\Collection || $banner_res instanceof \think\Paginator): $k = 0; $__LIST__ = $banner_res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
              <div class="mui-slider-item">
                  <a href="<?php echo Url('Index/bannerDetails',['id' => $vo['id']]); ?>">
                      <img src="__PUBLIC__/<?php echo $vo['image']; ?>" data-test="<?php echo $k; ?>" data-test1="<?php echo $banner_res_count; ?>">
                  </a>
              </div>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>

	    <!-- 第二张 -->
	    <!--<div class="mui-slider-item">-->
	      <!--<a href="#">-->
	        <!--<img src="__PUBLIC__/static/html/img/banner.png">-->
	      <!--</a>-->
	    <!--</div>-->
	    <!--&lt;!&ndash; 第三张 &ndash;&gt;-->
	    <!--<div class="mui-slider-item">-->
	      <!--<a href="#">-->
	        <!--<img src="__PUBLIC__/static/html/img/banner.png">-->
	      <!--</a>-->
	    <!--</div>-->
	    <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
          <?php if(empty($banner_res) || (($banner_res instanceof \think\Collection || $banner_res instanceof \think\Paginator ) && $banner_res->isEmpty())): ?>
          <div class="mui-slider-item mui-slider-item-duplicate">
              <a href="#">
                  <img src="__PUBLIC__/static/html/img/banner.png">
              </a>
          </div>
          <?php else: ?>
              <div class="mui-slider-item">
                  <a href="<?php echo Url('Index/bannerDetails',['id' => $banner_res['0']['id']]); ?>">
                      <img src="__PUBLIC__/<?php echo $banner_res['0']['image']; ?>">
                  </a>
              </div>
          <?php endif; ?>

	  </div>
	  <div class="mui-slider-indicator">
          <?php if(empty($banner_res) || (($banner_res instanceof \think\Collection || $banner_res instanceof \think\Paginator ) && $banner_res->isEmpty())): ?>
              <div class="mui-indicator mui-active"></div>
              <div class="mui-indicator"></div>
              <div class="mui-indicator"></div>
          <?php else: if(is_array($banner_res) || $banner_res instanceof \think\Collection || $banner_res instanceof \think\Paginator): $k = 0; $__LIST__ = $banner_res;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                <div class="mui-indicator <?php if($k == '1'): ?>mui-active<?php endif; ?>"></div>

            <?php endforeach; endif; else: echo "" ;endif; endif; ?>

    </div>
	</div>
	<div class="mui-content">
		<div class="i_iconbtn mui-clearfix">
			<div class="son"><a href="<?php echo Url('html/Index/authorize'); ?>" class="soncont sqcx">授权查询</a></div>
			<div class="son"><a href="<?php echo Url('html/Tourists/anti'); ?>" class="soncont fwcx">防伪查询</a></div>
			<div class="son"><a href="<?php echo Url('html/Agents/index'); ?>" class="soncont dlht">代理后台</a></div>
			<div class="son"><a href="#" class="soncont jfcx">积分查询</a></div>
			<div class="son"><a href="<?php echo Url('html/Index/about'); ?>" class="soncont gywm">关于我们</a></div>
		</div>
		<div class="i_title mui-text-center">
			-&nbsp;产品展示&nbsp;-
		</div>
		<ul class="i_prolist">
			
			<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li class="mui-clearfix">
                    <?php if(empty($vo['out_link']) || (($vo['out_link'] instanceof \think\Collection || $vo['out_link'] instanceof \think\Paginator ) && $vo['out_link']->isEmpty())): ?>
                        <a href="<?php echo Url('Index/productDetails',['id'=>$vo['id']]); ?>">
                    <?php else: ?>
                        <a href="<?php echo $vo['out_link']; ?>">
                    <?php endif; ?>
                    <div class="i_pro_pic mui-pull-left" style="background-image: url(__PUBLIC__<?php echo $vo['image']; ?>);"></div>
                    <div class="i_pro_info mui-pull-left">
                        <p class="title"><?php echo $vo['name']; ?></p>
                        <p class="text"><?php echo msubstr($vo['intro'],0,40,'utf-8',true); ?></p>
                    </div>
                </a>
            </li>
            <?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>

		</ul>
	</div>
	<script type="text/javascript">
		var gallery = mui('.mui-slider');
		gallery.slider({
		  interval:3500//自动轮播周期，若为0则不自动播放，默认为0；
		});
		
	</script>


            
        </body>
    
</html>