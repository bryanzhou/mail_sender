<?php
/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 17/1/3
 * Time: 下午3:48
 */
include_once "../global.php";
if ($_REQUEST['type'] == "" || $_REQUEST['group_name'] == "" || $_REQUEST['group_member'] == "") {
    errorMsgAndExit("lost parameter , please read wiki");
}

switch ($_REQUEST['type']) {
    case "add" :
        $groupName = $_REQUEST['group_name'];
        $groupMember = $_REQUEST['group_member'];
        $mailGroupService = new MailGroupService();
        $result = $mailGroupService->insertMailGroupMember($groupName, $groupMember);
        if ($result == true) {
            succMsgAndExit("add success");
        } else {
            errorMsgAndExit("add fail , maybe this member already exists in this group");
        }
        break;
    case "delete":
        $groupName = $_REQUEST['group_name'];
        $groupMember = $_REQUEST['group_member'];
        $mailGroupService = new MailGroupService();
        $result = $mailGroupService->deleteMailGroupMember($groupName, $groupMember);
        if ($result == true) {
            succMsgAndExit("delete success");
        } else {
            errorMsgAndExit("delete fail , maybe this member is not exists in this group");
        }
        break;
    default:
        errorMsgAndExit("worng type ,need add or delete");
}
if($mailGroupService) {
    $mailGroupService->closeDBConnection();
}
?>