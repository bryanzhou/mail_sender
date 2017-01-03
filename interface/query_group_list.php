<?php
/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 17/1/3
 * Time: 下午3:41
 */
include_once "../global.php";

$mailGroupService = new MailGroupService();
$resultGroupArray = $mailGroupService->getMailGroupInfo();
$result['groups'] = $resultGroupArray;

echo json_encode($result);

?>