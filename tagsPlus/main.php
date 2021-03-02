<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
  $zbp->ShowError(6);
  die();
}
if (!$zbp->CheckPlugin('tagsPlus')) {
  $zbp->ShowError(48);
  die();
}

$blogtitle = '标签搜索管理';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle; ?></div>
  <div class="SubMenu">
    <?php tagsPlus_SubMenu(0); ?>
    <?php require "about.php"; ?>
  </div>
  <div id="divMain2">
    <form class="search" id="search" method="post" action="#">搜索：<input id="inpSearch" name="inpSearch" style="width:250px;" type="text" value=""> &nbsp;&nbsp;<input type="submit" class="button js-submit" value="提交"></form>
    <div class="js-results">
      <p class="js-tips">正在搜索</p>
      <table class="tableFull"></table>
    </div>
  </div>
</div>
<script src="<?php echo tagsPlus_Path("script", "host") ?>"></script>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
