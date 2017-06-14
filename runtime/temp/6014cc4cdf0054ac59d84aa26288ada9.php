<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"/Library/WebServer/Documents/testGit/Think5Admin/application/admin/view/user.pass.html";i:1497187871;}*/ ?>
<form class="layui-form layui-box" style='padding:25px 30px 20px 0' action="__SELF__" data-auto="true" method="post">

    <div class="layui-form-item">
        <label class="layui-form-label">用户账号</label>
        <div class="layui-input-block">
            <?php if($vo and $vo['username']): ?>
            <input type="text" readonly="" disabled="" name="username" value='<?php echo (isset($vo['username']) && ($vo['username'] !== '')?$vo['username']:""); ?>' required="required" title="请输入用户名称" placeholder="请输入用户名称" class="layui-input disabled">
            <?php else: ?>
            <input type="text" name="username" value='<?php echo (isset($vo['username']) && ($vo['username'] !== '')?$vo['username']:""); ?>' required="required" title="请输入用户名称" placeholder="请输入用户名称" class="layui-input">
            <?php endif; ?>
        </div>
    </div>

    <?php if($verify): ?>
    <div class="layui-form-item">
        <label class="layui-form-label">旧的密码</label>
        <div class="layui-input-block">
            <input type="password" autofocus name="oldpassword" value='' pattern="^\S{1,}$" required=""  title="请输入旧的密码" placeholder="请输入旧的密码" class="layui-input">
        </div>
    </div>
    <?php endif; ?>

    <div class="layui-form-item">
        <label class="layui-form-label">新的密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" value='' pattern="^\S{1,}$" required=""  title="请输入新的密码" placeholder="请输入新的密码" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">重复密码</label>
        <div class="layui-input-block">
            <input type="password" name="repassword" value='' pattern="^\S{1,}$" required="" title="请输入重复密码" placeholder="请输入重复密码" class="layui-input">
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="layui-form-item text-center">
        <?php if(isset($vo['id'])): ?><input type='hidden' value='<?php echo $vo['id']; ?>' name='id'/><?php endif; ?>
        <button class="layui-btn" type='submit'>保存数据</button>
        <button class="layui-btn layui-btn-danger" type='button' data-confirm="确定要取消编辑吗？" data-close>取消编辑</button>
    </div>

</form>
