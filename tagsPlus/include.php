<?php
#注册插件
RegisterPlugin("tagsPlus", "ActivePlugin_tagsPlus");

function ActivePlugin_tagsPlus()
{
  Add_Filter_Plugin('Filter_Plugin_Admin_TagMng_SubMenu', 'tagsPlus_SubMenu');
  Add_Filter_Plugin('Filter_Plugin_ViewList_Core', 'tagsPlus_ViewList');
}

function tagsPlus_SubMenu($isSys = 1)
{
  global $zbp;
  if ($isSys) {
    $mNow = array("", " m-now");
  } else {
    $mNow = array(" m-now", "");
  }
  echo MakeSubMenu('系统管理', "{$zbp->host}zb_system/admin/?act=TagMng", "m-left{$mNow[1]}", "", "", "系统管理");
  echo MakeSubMenu('扩展管理', tagsPlus_Path("main", "host"), "m-left{$mNow[0]}", "", "", "扩展管理");
}

function tagsPlus_ViewList($type, $page, $category, $author, $datetime, $tag, &$w, $pagebar, $list_template)
{
  global $zbp;
  if ($type !== 'tag') {
    return;
  }
  $action = 'root';
  if (!$zbp->CheckRights($action)) {
    return;
  }
  $w = array();
  $w[] = array('=', 'log_Type', 0);
  $w[] = array('LIKE', 'log_Tag', '%{' . $tag->ID . '}%');
}

function InstallPlugin_tagsPlus()
{
}

function UninstallPlugin_tagsPlus()
{
}

// ----------

function tagsPlus_Path($file, $t = "path")
{
  global $zbp;
  $result = $zbp->$t . "zb_users/plugin/tagsPlus/";
  switch ($file) {
    case "script":
      return $result . "script/script.js?v=2021-03-02";
      break;
    case "tpl-tr":
      return $result . "tpl/tpl-tr.html";
      break;
    case "main":
      return $result . "main.php";
      break;
    default:
      return $result . $file;
  }
}
