<?php
#注册插件
RegisterPlugin("tagsPlus", "ActivePlugin_tagsPlus");

function ActivePlugin_tagsPlus()
{
  Add_Filter_Plugin('Filter_Plugin_Admin_TagMng_SubMenu', 'tagsPlus_SubMenu');
  Add_Filter_Plugin('Filter_Plugin_Cmd_Ajax', 'tagsPlus_Ajax');
  Add_Filter_Plugin('Filter_Plugin_Zbp_BuildTemplate', 'tagsPlus_tpl');
  Add_Filter_Plugin('Filter_Plugin_Admin_Footer', 'tagsPlus_ArticleMng_JS');
  Add_Filter_Plugin('Filter_Plugin_Admin_ArticleMng_Table', 'tagsPlus_ArticleMng_AddTag');
}
function tagsPlus_ArticleMng_AddTag($article, &$tabletds, $tableths)
{
  $tabletds[1] = '<td class="td5">' . $article->ID . '<span style="display:none;">' . $article->TagsToNameString() . '</span></td>';
}
function tagsPlus_ArticleMng_JS()
{
  $action = GetVars('act', 'GET');
  if ($action == "ArticleMng") {
?>
    <script src="<?php echo tagsPlus_Path("script", "host") ?>"></script>
<?php
  }
}
function tagsPlus_tpl(&$templates)
{
  $templates['tagsPlus_tr'] = file_get_contents(tagsPlus_Path("tpl-tr"));
}
function tagsPlus_Ajax($src)
{
  global $zbp;
  if ($src === "tagsPlus") {
    CheckIsRefererValid();
    $s = GetVars('s', 'GET');
    $where = array(array('like', 'tag_Name', '%' . $s . '%'));
    $array = $zbp->GetTagList("", $where);
    $zbp->template->SetTags('tags', $array);
    $zbp->template->SetTags('csrToken', $zbp->GetCSRFToken());
    $content = $zbp->template->Output("tagsPlus_tr");
    JsonReturn($content);
  }
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
  echo MakeSubMenu('搜索管理', tagsPlus_Path("main", "host"), "m-left{$mNow[0]}", "", "", "搜索");
}
function tagsPlus_Path($file, $t = "path")
{
  global $zbp;
  $result = $zbp->$t . "zb_users/plugin/tagsPlus/";
  switch ($file) {
    case "script":
      return $result . "script/script.js?v=2020-02-25";
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
function InstallPlugin_tagsPlus()
{
  global $zbp;
  $zbp->BuildTemplate();
}
function UninstallPlugin_tagsPlus()
{
}
