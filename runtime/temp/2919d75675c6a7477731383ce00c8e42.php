<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/Library/WebServer/Documents/lixuan/application/admin/view/index.main.html";i:1497187871;s:77:"/Library/WebServer/Documents/lixuan/application/extra/view/admin.content.html";i:1497187871;}*/ ?>
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
        
<div class="row">
    <div class="col-lg-6">
        <table class="layui-box layui-table" lay-even lay-skin="line">
            <colgroup>
                <col width="40%">
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center" colspan="2">系统信息</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Think.Admin 版本</td>
                    <td><?php echo sysconf('app_version'); ?></td>
                </tr>
                <tr>
                    <td>ThinkPHP 版本</td>
                    <td><?php echo THINK_VERSION; ?></td>
                </tr>
                <tr>
                    <td>服务器操作系统</td>
                    <td><?php echo php_uname('s'); ?></td>
                </tr>
                <tr>
                    <td>WEB运行环境</td>
                    <td><?php echo php_sapi_name(); ?></td>
                </tr>
                <tr>
                    <td>MySQL数据库版本</td>
                    <td><?php echo $mysql_ver; ?></td>
                </tr>
                <tr>
                    <td>运行PHP版本</td>
                    <td><?php echo phpversion(); ?></td>
                </tr>
                <tr>
                    <td>上传大小限制</td>
                    <td><?php echo ini_get('upload_max_filesize'); ?></td>
                </tr>
                <tr>
                    <td>POST大小限制</td>
                    <td><?php echo ini_get('post_max_size'); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">
        <table class="layui-box layui-table" lay-even lay-skin="line">
            <colgroup>
                <col width="40%">
                <col>
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center" colspan="2">产品团队</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>产品名称</td>
                    <td>Think.Admin 管理框架</td>
                </tr>
                <tr>
                    <td>产品研发团队</td>
                    <td>广州楚才信息科技有限公司</td>
                </tr>
                <tr>
                    <td>产品DEMO体验</td>
                    <td>
                        <a target="_blank" href="https://think.ctolog.com">
                            https://think.ctolog.com
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>官方QQ群</td>
                    <td>
                        <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=ae25cf789dafbef62e50a980ffc31242f150bc61a61164458216dd98c411832a">
                            <img src="//pub.idqqimg.com/wpa/images/group.png" style="height:18px;width:auto" alt="PHP微信开发群 (SDK)">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>BUG反馈</td>
                    <td>
                        <a target="_blank" href="https://github.com/zoujingli/Think.Admin/issues"> 
                            https://github.com/zoujingli/Think.Admin/issues
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>项目地址</td>
                    <td>
                        <a target="_blank" href="https://github.com/zoujingli/Think.Admin">
                            https://github.com/zoujingli/Think.Admin
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>公司官网</td>
                    <td>
                        <a target="_blank" href="http://www.cuci.cc">
                            http://www.cuci.cc
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>公司地址</td>
                    <td>
                        广东省 广州市 海珠区 世港国际公寓E1栋
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    </div>
    
</div>