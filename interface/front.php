<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<?php 
include "../../group_chat_debug/login_check.php";
login_check();
?>
<head>
    <title>邮件组管理</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	  <!-- 引入 Bootstrap -->
    <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
	    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <script src="https://code.jquery.com/jquery.js"></script>
    <!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
  <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
	    <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
	    <script type="text/javascript">
	function deleteGroupMember(groupName, groupMember, tag) {
	    var xmlhttp;
	if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp = new XMLHttpRequest();
	    }
    else {// code for IE6, IE5
	    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
xmlhttp.onreadystatechange = function () {
  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	document.getElementById(tag).style.display = "none";
    }
    }
	    xmlhttp.open("GET", "group_member_operator.php?type=delete&group_name=" + groupName + "&group_member=" + groupMember, true);
	xmlhttp.send();
}
  function addGroupMember(groupName,elementName) {
var groupMember = document.getElementById(elementName).value;
	    if (groupMember == "") {
    location.reload();
}
	var xmlhttp;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp = new XMLHttpRequest();
	}
else {// code for IE6, IE5
  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	    xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	  location.reload();
	  }
}
	xmlhttp.open("GET", "group_member_operator.php?type=add&group_name=" + groupName + "&group_member=" + groupMember, true);
    xmlhttp.send();
  }
  function deleteGroup(groupName) {
var xmlhttp;
	    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
}
	else {// code for IE6, IE5
	  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	    }
    xmlhttp.onreadystatechange = function () {
	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
  location.reload();
  }
	}
xmlhttp.open("GET", "group_info_operator.php?type=delete&group_name=" + groupName, true);
	    xmlhttp.send();
	  }
  function addGroup() {
var groupName = document.getElementById("add_group_name").value;
	    var groupOwner = document.getElementById("add_group_owner").value;
	if (groupName == "" || groupOwner == "") {
	  location.reload();
	    }
    var xmlhttp;
if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
    }
	    else {// code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
	xmlhttp.onreadystatechange = function () {
	  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
location.reload();
	    }
	    }
    xmlhttp.open("GET", "group_info_operator.php?type=add&group_name=" + groupName + "&group_owner=" + groupOwner, true);
xmlhttp.send();
	}
    </script>
    </head>
    <body>
    <h1>邮件组列表</h1>
    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  添加邮件组
	</button>
	<div class="panel-group" id="accordion">

	    <?php
	  include_once "../global.php";
    function createTag($group, $mailGroupService)
	    {
$tagId = md5($group['group_name']);
	$groupMemeberList = $mailGroupService->getMailGroupMember($group['group_name']);
echo "<div class=\"panel panel-default\">";
	echo "<div class=\"panel-heading\">";
echo "<h4 class=\"panel-title\">";
	echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#${tagId}\">";
echo $group['group_name'] . '(' . $group['group_owner'] . ')(共'.count($groupMemeberList).'人) ';
	echo "</a> 
	 <a href=\"\" onclick=\"deleteGroup('" . $group['group_name'] . "')\" class=\"btn btn-danger btn-xs pull-right\" role=\"button\">删除邮件组</a>
 <a  class=\"btn btn-success btn-xs pull-right\" role=\"button\" data-toggle=\"modal\" data-target=\"#modal${tagId}\"> 增加成员</a>
	 </h4></div>";
echo "<div id=\"${tagId}\" class=\"panel-collapse collapse\">";
	echo "<div class=\"panel-body\">";
echo "<ul class=\"list-group\">";
	foreach ($groupMemeberList as $groupMember) {
	    $memId = rand(10000000, 1000000000);
	echo "<li id=\"${memId}\" class=\"list-group-item\">" . $groupMember['group_member'] . "
	     <a href=\"#${tagId}\" onclick=\"deleteGroupMember('" . $group['group_name'] . "' ,  '" . $groupMember['group_member'] . "' , '${memId}')\" class=\"btn btn-danger btn-xs pull-right\" role=\"button\">-</a>
	  </li>";
}
echo "</div></div>";

	echo "<div class=\"modal fade\" id=\"modal${tagId}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
	<div class=\"modal-dialog\">
<div class=\"modal-content\">
	    <div class=\"modal-header\">
	    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">
	  &times;
  </button>
	  <h4 class=\"modal-title\" id=\"myModalLabel\">
	添加邮件组成员
    </h4>
</div>
	    <div class=\"modal-body\">
	    <div class=\"input-group\">
	  <span class=\"input-group-addon\">成员</span>
	<input id=\"add_member${tagId}\" type=\"text\" class=\"form-control\" placeholder=\"xx@staff.weibo.com\">
    </div>
</div>
	    <div class=\"modal-footer\">
	    <button type=\"button\" class=\"btn btn-primary\" onclick=\"addGroupMember('" . $group['group_name'] . "','add_member${tagId}')\">
	  提交
	  </button>
	    </div>
	  </div><!-- /.modal-content -->
    </div><!-- /.modal -->
  </div>";


echo "</div>";
	  }

    $mailGroupService = new MailGroupService();

  $groupList = $mailGroupService->getMailGroupInfo();
	    foreach ($groupList as $group) {
createTag($group, $mailGroupService);
	  }

    $mailGroupService->closeDBConnection();
  ?>

	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	<div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
  &times;
  </button>
  <h4 class="modal-title" id="myModalLabel">
添加邮件组
	    </h4>
	</div>
    <div class="modal-body">
    <div class="input-group">
  <span class="input-group-addon">邮件组</span>
<input id="add_group_name" type="text" class="form-control" placeholder="">
	    </div>
	    <div class="input-group">
	  <span class="input-group-addon">创建人 </span>
	<input id="add_group_owner" type="text" class="form-control" placeholder="xx@staff.weibo.com">
    </div>
</div>
	    <div class="modal-footer">
	    <button type="button" class="btn btn-primary" onclick="addGroup()">
	  提交
	  </button>
	    </div>
	  </div><!-- /.modal-content -->
    </div><!-- /.modal -->
    </div>

    </body>
    </html>

