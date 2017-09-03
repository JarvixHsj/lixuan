<?php
//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']. '---REQUEST_URL = '.$_SERVER['REQUEST_URI'];
//echo '<br />';
//echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'---PHP_SELF='.$_SERVER['PHP_SELF']. '----QUERY_STRING='.$_SERVER['QUERY_STRING'];
//var_dump($_SERVER['HTTP_REFERER']);
//die;
$currentUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(strpos($currentUrl, '?fcode') !== false){
    $skipUrl = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/html/Tourists/fcode?'.$_SERVER['QUERY_STRING'];
//    var_dump($skipUrl);
    header('Location: '.$skipUrl);
}else{
    var_dump('访问链接出错，请重新扫描二维码');
}

