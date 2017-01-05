<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
   <head>
      <title>邮件组管理</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!-- 引入 Bootstrap -->
      <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
      <script src="https://code.jquery.com/jquery.js"></script>
      <!-- HTML5 Shim 和 Respond.js 用于让 IE8 支持 HTML5元素和媒体查询 -->
      <!-- 注意： 如果通过 file://  引入 Respond.js 文件，则该文件无法起效果 -->
      <!--[if lt IE 9]>
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <h1>邮件组列表</h1>

<div class="panel-group" id="accordion">

<?php
include_once "../global.php";
    function createTag($group)
    {
        $tagId=md5($group['group_name']);
        echo "<div class=\"panel panel-default\">";
        echo "<div class=\"panel-heading\">";
        echo "<h4 class=\"panel-title\">";
        echo "<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#${tagId}\">";
        echo $group['group_name'];
        echo "</a></h4></div>";
        echo "<div id=\"${tagId}\" class=\"panel-collapse collapse\">";
        echo "<div class=\"panel-body\">";
        echo $group['group_owner'];
        echo "</div></div></div>";
    }
    $mailGroupService=new MailGroupService();

    $groupList=$mailGroupService->getMailGroupInfo();
    foreach ($groupList as $group)
    {
        createTag($group);
    }


?>

<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading">-->
<!--            <h4 class="panel-title">-->
<!--                <a data-toggle="collapse" data-parent="#accordion" -->
<!--                href="#collapseOne">-->
<!--                点击我进行展开，再次点击我进行折叠。第 1 部分-->
<!--                </a>-->
<!--            </h4>-->
<!--        </div>-->
<!--        <div id="collapseOne" class="panel-collapse collapse">-->
<!--            <div class="panel-body">-->
<!--                Nihil anim keffiyeh helvetica, craft beer labore wes anderson -->
<!--                cred nesciunt sapiente ea proident. Ad vegan excepteur butcher -->
<!--                vice lomo.-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

</div>

   </body>
</html>
