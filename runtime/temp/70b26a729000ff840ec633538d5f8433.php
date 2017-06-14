<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"/Library/WebServer/Documents/lixuan/application/lixuan/view/product.index.html";i:1497459186;s:77:"/Library/WebServer/Documents/lixuan/application/extra/view/admin.content.html";i:1497187871;}*/ ?>
<div class="ibox">
    
    <?php if(isset($title)): ?>
    <div class="ibox-title">
        <h5><?php echo $title; ?></h5>
        
<div class="nowrap pull-right" style="margin-top:10px">
    <button data-modal='<?php echo url("$classuri/add"); ?>' data-title="添加用户" class='layui-btn layui-btn-small'><i
            class='fa fa-plus'></i> 添加用户
    </button>
    <button data-update data-field='delete' data-action='<?php echo url("$classuri/del"); ?>'
            class='layui-btn layui-btn-small layui-btn-danger'><i class='fa fa-remove'></i> 删除用户
    </button>
</div>

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
        

<!-- 表单搜索 开始 -->
<form class="animated form-search" action="__SELF__" onsubmit="return false" method="get">

    <div class="row">
        <div class="col-xs-3">
            <div class="form-group">
                <input type="text" name="username" value="<?php echo (\think\Request::instance()->get('username') ?: ''); ?>" placeholder="用户名" class="input-sm form-control">
            </div>
        </div>

        <div class="col-xs-3">
            <div class="form-group">
                <input type="text" name="phone" value="<?php echo (\think\Request::instance()->get('phone') ?: ''); ?>" placeholder="手机号" class="input-sm form-control">
            </div>
        </div>

        <div class="col-xs-1">
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-white"><i class="fa fa-search"></i> 搜索</button>
            </div>
        </div>
    </div>
</form>
<!-- 表单搜索 结束 -->

<form onsubmit="return false;" data-auto="" method="POST">
    <input type="hidden" value="resort" name="action"/>
    <table class="table table-hover">
        <thead>
            <tr>
                <th class='list-table-check-td'>
                    <input data-none-auto="" data-check-target='.list-check-box' type='checkbox'/>
                </th>
                <th class='text-center'>编号</th>
                <th class='text-center'>产品图片</th>
                <th class='text-center'>产品名称</th>
                <th class='text-center'>最后编辑时间</th>
                <th class='text-center'>锁定</th>
                <th class='text-center'>操作</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <?php if(isset($page)): ?><p><?php echo $page; ?></p><?php endif; ?>
</form>

    </div>
    
</div>