<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/Library/WebServer/Documents/lixuan/application/admin/view/config.file.html";i:1497187871;s:77:"/Library/WebServer/Documents/lixuan/application/extra/view/admin.content.html";i:1497187871;}*/ ?>
<div class="ibox">
    
    <?php if(isset($title)): ?>
    <div class="ibox-title">
        <h5><?php echo $title; ?></h5>
        
    </div>
    <?php endif; ?>
    <div class="ibox-content fadeInUp animated">
        <?php if(isset($alert)): ?>
        <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible" role="alert" style="border-radius:0">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php if(isset($alert['title'])): ?><p style="font-size:18px;padding-bottom:10px"><?php echo $alert['title']; ?></p><?php endif; if(isset($alert['content'])): ?><p style="font-size:14px"><?php echo $alert['content']; ?></p><?php endif; ?>
        </div>
        <?php endif; ?>
        
<form onsubmit="return false;" action="__SELF__" data-auto="true" method="post" class='form-horizontal' style='padding-top:20px'>

    <div class="form-group">
        <label class="col-sm-2 control-label">Storage <span class="nowrap">(存储引擎)</span></label>
        <div class='col-sm-8'>
            <select class="layui-input" name="storage_type" required="required">
                <!--<?php if(sysconf('storage_type') == 'qiniu'): ?>-->
                <option value='local'>本地服务器</option>
                <option selected="selected" value='qiniu'>七牛云存储</option>
                <option value='oss'>AliOSS存储</option>
                <!--<?php elseif(sysconf('storage_type') == 'oss'): ?>-->
                <option value='local'>本地服务器</option>
                <option value='qiniu'>七牛云存储</option>
                <option selected="selected" value='oss'>AliOSS存储</option>
                <!--<?php else: ?>-->
                <option selected="selected" value='local'>本地服务器</option>
                <option value='qiniu'>七牛云存储</option>
                <option value='oss'>AliOSS存储</option>
                <!--<?php endif; ?>-->
            </select>
            <div class="help-block" data-storage-type="qiniu">
                若还没有七牛云帐号，请点击
                <a target="_blank" href="https://portal.qiniu.com/signup?code=3lhz6nmnwbple">免费申请10G存储空间</a>, 
                申请成功后添加公开bucket空间
            </div>
            <div class="help-block" data-storage-type="oss">
                若还没有AliOSS存储账号, 请点击 <a target="_blank" href="https://oss.console.aliyun.com">创建AliOSS存储空间</a>, 
                目前仅支持公开空间URL访问, 另外还需要配置AliOSS跨域策略
            </div>
        </div>
    </div>

    <div class="hr-line-dashed" data-storage-type="qiniu"></div>

    <div class="form-group" data-storage-type="qiniu">
        <label class="col-sm-2 control-label">Region <span class="nowrap">(存储区域)</span></label>
        <div class='col-sm-8'>
            <select class="layui-input" name="storage_qiniu_region" required="required">

                <!--<?php if(sysconf('storage_qiniu_region') == '华东'): ?>-->
                <option selected value='华东'>华东</option>
                <!--<?php else: ?>-->
                <option value='华东'>华东</option>
                <!--<?php endif; ?>-->

                <!--<?php if(sysconf('storage_qiniu_region') == '华北'): ?>-->
                <option selected value='华北'>华北</option>
                <!--<?php else: ?>-->
                <option value='华北'>华北</option>
                <!--<?php endif; ?>-->

                <!--<?php if(sysconf('storage_qiniu_region') == '华南'): ?>-->
                <option selected value='华南'>华南</option>
                <!--<?php else: ?>-->
                <option value='华南'>华南</option>
                <!--<?php endif; ?>-->

                <!--<?php if(sysconf('storage_qiniu_region') == '北美'): ?>-->
                <option selected value='北美'>北美</option>
                <!--<?php else: ?>-->
                <option value='北美'>北美</option>
                <!--<?php endif; ?>-->

            </select>
            <p class="help-block">七牛云存储空间所在区域，需要严格对应储存所在区域才能上传文件</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="qiniu">
        <label class="col-sm-2 control-label">Protocol <span class="nowrap">(访问协议)</span></label>
        <div class='col-sm-8'>
            <select class="layui-input" name="storage_qiniu_is_https" required="required">
                <!--<?php if(sysconf('storage_qiniu_is_https')!=='1'): ?>-->
                <option selected value='0'>HTTP</option>
                <option value='1'>HTTPS</option>
                <!--<?php else: ?>-->
                <option value='0'>HTTP</option>
                <option selected value='1'>HTTPS</option>
                <!--<?php endif; ?>-->
            </select>
            <p class="help-block">七牛云资源访问协议（HTTP 或 HTTPS），HTTPS 需要配置证书才能使用</p>
        </div>
    </div>


    <div class="form-group" data-storage-type="qiniu">
        <label class="col-sm-2 control-label">Bucket <span class="nowrap">(空间名称)</span></label>
        <div class='col-sm-8'>
            <input type="text" name="storage_qiniu_bucket" required="required" title="请输入七牛云存储 Bucket (空间名称)"
                   placeholder="请输入七牛云存储 Bucket (空间名称)" value="<?php echo sysconf('storage_qiniu_bucket'); ?>"
                   class="layui-input">
            <p class="help-block">填写七牛云存储空间名称，如：static</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="qiniu">
        <label class="col-sm-2 control-label">Domain <span class="nowrap">(访问域名)</span></label>
        <div class='col-sm-8'>
            <input type="text" name="storage_qiniu_domain" required="required" title="请输入七牛云存储 Domain (访问域名)"
                   placeholder="请输入七牛云存储 Domain (访问域名)" value="<?php echo sysconf('storage_qiniu_domain'); ?>" class="layui-input">
            <p class="help-block">填写七牛云存储访问域名，如：static.ctolog.cc</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="qiniu">
        <label class="col-sm-2 control-label">AccessKey <span class="nowrap">(访问密钥)</span></label>
        <div class='col-sm-8'>
            <input type="text" name="storage_qiniu_access_key" required="required" title="请输入七牛云 AccessKey (访问密钥)"
                   placeholder="请输入七牛云 AccessKey (访问密钥)" value="<?php echo sysconf('storage_qiniu_access_key'); ?>" class="layui-input">
            <p class="help-block">可以在 [ 七牛云 > 个人中心 ] 设置并获取到访问密钥</p>
        </div>
    </div>


    <div class="form-group" data-storage-type="qiniu">
        <label class="col-sm-2 control-label">SecretKey <span class="nowrap">(安全密钥)</span></label>
        <div class='col-sm-8'>
            <input type="password" name="storage_qiniu_secret_key" required="required" title="请输入七牛云 SecretKey (安全密钥)"
                   placeholder="请输入七牛云 SecretKey (安全密钥)" value="<?php echo sysconf('storage_qiniu_secret_key'); ?>"
                   maxlength="43" class="layui-input">
            <p class="help-block">可以在 [ 七牛云 > 个人中心 ] 设置并获取到安全密钥</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="oss">
        <label class="col-sm-2 control-label">Protocol <span class="nowrap">(访问协议)</span></label>
        <div class='col-sm-8'>
            <select class="layui-input" name="storage_oss_is_https" required="required">
                <!--<?php if(sysconf('storage_oss_is_https')!=='1'): ?>-->
                <option selected value='0'>HTTP</option>
                <option value='1'>HTTPS</option>
                <!--<?php else: ?>-->
                <option value='0'>HTTP</option>
                <option selected value='1'>HTTPS</option>
                <!--<?php endif; ?>-->
            </select>
            <p class="help-block">AliOSS资源访问协议（HTTP 或 HTTPS），HTTPS 需要配置证书才能使用</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="oss">
        <label class="col-sm-2 control-label">Bucket <span class="nowrap">(空间名称)</span></label>
        <div class='col-sm-8'>
            <input type="text" name="storage_oss_bucket" required="required" title="请输入AliOSS Bucket (空间名称)"
                   placeholder="请输入AliOSS Bucket (空间名称)" value="<?php echo sysconf('storage_oss_bucket'); ?>" class="layui-input">
            <p class="help-block">填写OSS存储空间名称，如：static</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="oss">
        <label class="col-sm-2 control-label">Domain <span class="nowrap">(访问域名)</span></label>
        <div class='col-sm-8'>
            <input type="text" name="storage_oss_domain" required="required" title="请输入AliOSS存储 Domain (访问域名)"
                   placeholder="请输入AliOSS存储 Domain (访问域名)" value="<?php echo sysconf('storage_oss_domain'); ?>" class="layui-input">
            <p class="help-block">填写OSS存储外部访问域名，如：static.ctolog.cc</p>
        </div>
    </div>

    <div class="form-group" data-storage-type="oss">
        <label class="col-sm-2 control-label">AccessKey <span class="nowrap">(访问密钥)</span></label>
        <div class='col-sm-8'>
            <input type="text" name="storage_oss_keyid" required="required" title="请输入16位AliOSS AccessKey (访问密钥)"
                   placeholder="请输入AliOSS AccessKey (访问密钥)" value="<?php echo sysconf('storage_oss_keyid'); ?>" maxlength="16" class="layui-input">
            <p class="help-block">可以在 [ 阿里云 > 个人中心 ] 设置并获取到访问密钥</p>
        </div>
    </div>


    <div class="form-group" data-storage-type="oss">
        <label class="col-sm-2 control-label">SecretKey <span class="nowrap">(安全密钥)</span></label>
        <div class='col-sm-8'>
            <input type="password" name="storage_oss_secret" required="required" title="请输入30位AliOSS SecretKey (安全密钥)"
                   placeholder="请输入AliOSS SecretKey (安全密钥)" value="<?php echo sysconf('storage_oss_secret'); ?>" maxlength="30" class="layui-input">
            <p class="help-block">可以在 [ 阿里云 > 个人中心 ] 设置并获取到安全密钥</p>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="col-sm-4 col-sm-offset-2">
        <div class="layui-form-item text-center">
            <button class="layui-btn" type="submit">保存配置</button>
        </div>
    </div>

</form>

    </div>
    
<script>
    $(function () {
        $('[name="storage_type"]').on('change', function () {
            $("[data-storage-type]").not($("[data-storage-type='" + $(this).val() + "']").show()).hide();
        }).trigger('change');
    });
</script>

</div>