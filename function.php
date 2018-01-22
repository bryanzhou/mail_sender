<?php
function log_writer($operation_name, $operation_info)
{
    date_default_timezone_set("Asia/Shanghai");
    $tt = date("Y-M-D-d-H-i-s");
    $ip = $_SERVER["REMOTE_ADDR"];

    $fw = fopen("../operation.log", "a+");
    fwrite($fw, "[" . $ip . "] [" . $tt . "] " . $operation_name . " " . $operation_info . "\n");
    fclose($fw);
}

function http_log_writer($operation_name, $operation_info)
{
    date_default_timezone_set("Asia/Shanghai");
    $tt = date("Y-M-D-d-H-i-s");
    $ip = $_SERVER["REMOTE_ADDR"];

    $fw = fopen("../operation.log", "a+");
    fwrite($fw, "[" . $ip . "] [" . $tt . "] " . $operation_name . " " . $operation_info . "\n");
    fclose($fw);
}

function errorMsgAndExit($msg)
{
    $json['result'] = false;
    $json['msg'] = $msg;
    echo json_encode($json);
    exit(0);
}

function succMsgAndExit($msg)
{
    $json['result'] = true;
    $json['msg'] = $msg;
    echo json_encode($json);
    exit(0);
}

function createSurfixMessage($start, $sinceTime)
{
    $msg = "报警开始时间：" + date('Y-m-d H:i:s', $start) + "\r\n";
    $msg = "持续时间：" + secToTime($sinceTime);
    return $msg;

}

function secToTime($times)
{
    $result = '00:00:00';
    if ($times > 0) {
        $hour = floor($times / 3600);
        $minute = floor(($times - 3600 * $hour) / 60);
        $second = floor((($times - 3600 * $hour) - 60 * $minute) % 60);
        $result = $hour . '时' . $minute . '分' . $second;
    }
    return $result;
}

?>
