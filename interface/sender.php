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
3. from (get/post)	the mail sender (default mail_service@noreply.com);
4.  content(it should be post as a file or use text as a post parameter). 
5. attachment(post as a file)
6. warning_name(get/post) used to control mail send speed
suggest you to use multipart form data when using curl 
";
    exit(0);
}

$surfixFlag = false;
$surfixMessage = "";

/**
 * mail sender will  use warning_name to store mail send history and check if this mail will be send or not.
 * key is send times , value is interval（unit second）
 */
if (isset($_REQUEST['warning_name'])) {
    $speedSetting = array(
        '3' => 55,
        '10' => 290,
        '30' => 1790,
        '999999' => 86390
    );
    $memcache = new MemcacheService();
    $cachedInfo = $memcache->gueryMemcache($_REQUEST['warning_name']);
    if ($cachedInfo == "") {
        /**
         * first send
         */
        $cachedInfo['send_count'] = 1;
        $cachedInfo['last_send_unix'] = time();
        $cachedInfo['last_warning_unix'] = $cachedInfo['last_send_unix'];
        $cachedInfo['send_start_unix'] = $cachedInfo['last_send_unix'];
    } else {
        $last = $cachedInfo['last_send_unix'];
        $count = $cachedInfo['send_count'];
        $warning = $cachedInfo['last_warning_unix'];
        $start = cachedInfo['send_start_unix'];

        $now = time();
        $sendInterval = 86390;
        if (($now - $warning) < 60 * 10) {
            foreach ($speedSetting as $key => $value) {
                if ($key <= $count) {
                    $sendInterval = $value;
                    break;
                }
            }
            if (($now - $last) >= $sendInterval) {
                $surfixFlag = true;
                $surfixMessage = createSurfixMessage($start,$sinceTime);
                $cachedInfo['send_count'] += 1;
                $cachedInfo['last_send_unix'] = $now;
                $cachedInfo['last_warning_unix'] = $now;
            } else {
                $cachedInfo['last_warning_unix'] = $now;
            }
        } else {
            /**
             * treat as first send
             */
            $cachedInfo['send_count'] = 1;
            $cachedInfo['last_send_unix'] = time();
            $cachedInfo['last_warning_unix'] = $cachedInfo['last_send_unix'];
            $cachedInfo['send_start_unix'] = $cachedInfo['last_send_unix'];
        }
        $memcache->setMemcache($_REQUEST['warning_name'], $cachedInfo, 86400 * 2);
    }

}


$mailGroupService = new MailGroupService();

$groupArray = $mailGroupService->getArrayMailGroupInfo();

$receiverArray = split(",", $receiver);
$receiver = array();
foreach ($receiverArray as $r) {
    if (in_array($r, $groupArray)) {
        $memberArray = $mailGroupService->getArrayMailGroupMember($r);
        $receiver = array_merge($memberArray, $receiver);
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
        if ($surfixFlag == true) {
            $body = $body . "\r\n" . $surfixMessage;
        }
	$body = urldecode($body);
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

        if ($surfixFlag == true) {
            $content = $content . "\r\n" . $surfixMessage;
        }

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
$mailGroupService->closeDBConnection();

?>
