<?php
/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 17/1/3
 * Time: 下午3:44
 */

include_once "../global.php";

$groupName = $_REQUEST['group_name'];

if ($groupName == "") {
    errorMsgAndExit("need group_name");
}

$mailGroupService = new MailGroupService();
$resultMemberArray = $mailGroupService->getMailGroupMember($groupName);

$result['member'] = $resultMemberArray;

echo json_encode($result);

?>