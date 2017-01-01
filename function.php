<?php
function log_writer($operation_name,$operation_info)
{
        date_default_timezone_set("Asia/Shanghai");
        $tt=date("Y-M-D-d-H-i-s");
        $ip=$_SERVER["REMOTE_ADDR"];

        $fw=fopen("operation.log","a+");
        fwrite($fw, "[".$ip."] [".$tt."] ".$operation_name." ".$operation_info."\n");
        fclose($fw);
}
?>
