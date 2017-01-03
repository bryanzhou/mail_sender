<?php
/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 16/12/28
 * Time: 下午4:12
 */

include_once("../global.php");

$receiver = $_REQUEST['receiver'];
$subject = $_REQUEST['subject'];
$from = $_REQUEST['from'];
if ($from == "") {
    $from = "mail_service@noreply.com";
}
$subject = urldecode($subject);

#echo $receiver."  ".$_POST['subject'];
if ($receiver == "" || $subject == "") {
    echo "
USAGE:
1. receiver(get/post)	mail address list;
2. subject(get/post)	subject of the mail;
3. from (get/post)	the mail sender (default zhouyuan1);
4.  content(it should be post as a file or use text as a post parameter). \n
";
    exit(0);
}

$mailGroupService = new MailGroupService();

$groupArray = $mailGroupService->getArrayMailGroupInfo();

$receiverArray = split(",", $receiver);
$receiver = array();
foreach ($receiverArray as $r) {
    if (in_array($r, $groupArray)) {
        $memberArray = $mailGroupService->getArrayMailGroupMember($r);
        $receiver=array_merge($memberArray, $receiver);
    } else {
        array_push($receiver, $r);
    }
}
$receiver = implode(",", $receiver);

if (isset($_FILES['content']) && ($_FILES['content']['tmp_name'] != "") || isset($_POST['text'])) {
    if (!isset($_POST['text']) && !is_uploaded_file($_FILES['content']['tmp_name'])) {
        echo '非法的文件';
    } else if ($_FILES['attachment']['tmp_name'] != "") {
        $body = isset($_POST['text']) ? $_POST['text'] : file_get_contents($_FILES['content']['tmp_name']);
        $body = base64_encode($body);
        $boundary = "_000_AC2A887CCAC04FF398BBD975E33B692B_";
        //设置header
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "X-MS-Has-Attach: yes \r\n";
        $headers .= "Content-type: multipart/mixed; boundary= $boundary\r\n";
        $headers .= "From:$from\r\n\r\n";
        //获得上传文件的文件内容
        $file = $_FILES['attachment']['tmp_name'];
        //确定上传文件的MIME类型
        $mimeType = $_FILES['attachment']['type'];
        //获得上传文件的文件名
        $fileName = $_FILES['attachment']['name'];
        $fp = fopen($file, "r"); //打开文件
        $read = fread($fp, filesize($file)); //读入文件
        $read = base64_encode($read); //base64编码
        $read = chunk_split($read); //切割字符串
        $body = "--$boundary 
Content-type: text/plain; charset=utf-8
Content-transfer-encoding: base64

$body 

--$boundary
Content-type: $mimeType; name=$fileName 
Content-disposition: attachment; filename=$fileName 
Content-transfer-encoding: base64  

$read 

--$boundary--";
        echo $body;
        mail($receiver, $subject, $body, $headers);
        echo "Mail  From <$from> To <$receiver> Subject <$subject> send successfully.";
    } else {
        $content = isset($_POST['text']) ? $_POST['text'] : file_get_contents($_FILES['content']['tmp_name']);

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
        $headers .= "From: <$from>" . "\r\n";

        #$send=`echo $content | mutt -s $subject $receiver `;
        $respon = mail($receiver, $subject, $content, $headers);
        #echo $respon;
        echo "Mail  From <$from> To <$receiver> Subject <$subject> send successfully.";
    }
} else {
    echo "not receiver a content file \n ";
}


?>
