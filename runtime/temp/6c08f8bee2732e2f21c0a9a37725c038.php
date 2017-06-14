<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"/Library/WebServer/Documents/testGit/Think5Admin/application/wechat/view/tags.form.html";i:1497187871;}*/ ?>
<form class="layui-form layui-box" style='padding:25px 30px 20px 0' action="__SELF__" data-auto="true" method="post">

    <div class="layui-form-item">
        <label class="layui-form-label">标签名称</label>
        <div class="layui-input-block">
            <input type="text" name="name" value='<?php echo (isset($vo['name']) && ($vo['name'] !== '')?$vo['name']:""); ?>' required="required" title="请输入标签名称" placeholder="请输入标签名称" class="layui-input">
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="layui-form-item text-center">

        <?php if(isset($vo['id'])): ?><input type='hidden' value='<?php echo $vo['id']; ?>' name='id'/><?php endif; ?>

        <button class="layui-btn" type='submit'>保存数据</button>

        <button class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消编辑吗？" data-close>取消编辑</button>

    </div>

</form>
