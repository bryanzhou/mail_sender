<?php
/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 17/1/3
 * Time: 下午3:21
 */
include_once "../global.php";
if ($_REQUEST['type'] == "" || $_REQUEST['group_name'] == "" || $_REQUEST['group_owner'] == "") {
    errorMsgAndExit("lost parameter , please read wiki");
}

switch ($_REQUEST['type']) {
    case "add":
        $groupName = $_REQUEST['group_name'];
        $groupOwner = $_REQUEST['group_owner'];
        $mailGroupService = new MailGroupService();
        $result = $mailGroupService->insertMailGroupInfo($groupName, $groupOwner);
        if ($result == true) {
            $mailGroupService->insertMailGroupMember($groupName, $groupOwner);
            succMsgAndExit("add success");
        } else {
            errorMsgAndExit("add fail , maybe group name exists");
        }
        break;
    case "delete":
        $groupName = $_REQUEST['group_name'];
        $mailGroupService = new MailGroupService();
        $result = $mailGroupService->deleteMailGroupInfo($groupName);
        if ($result == true) {
            $mailGroupService->deleteMailGroupMember($groupName, "");
            succMsgAndExit("delete success");
        } else {
            errorMsgAndExit("no such group");
        }
        break;
    default:
        errorMsgAndExit("worng type ,need add or delete");
}
?>