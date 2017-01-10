<?php

/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 17/1/3
 * Time: 上午11:33
 */
class MailGroupService
{
    public $serverIPPort;
    public $username;
    public $password;
    public $databaseName;

    private $conn;
    function __construct()
    {
        $settings = include_once("../settings.php");
        if ($settings['serverIPPort'] == "" || $settings['username'] || $settings['password'] == "" || $settings['databaseName'] == "") {
            $this->serverIPPort = $settings['serverIPPort'];
            $this->username = $settings['username'];
            $this->password = $settings['password'];
            $this->databaseName = $settings['databaseName'];
        } else {
            log_writer("Load settings fail", json_encode($settings));
        }
        $this->conn = mysql_connect($this->serverIPPort, $this->username, $this->password);

        if (!$this->conn) {
            log_writer("Connect to mysql fail", "IPPort : " . $this->serverIPPort . " username : " . $this->username . " password : " . $this->password);
            exit(1);
        }
    }

    /*
    query mysql and return array
    */
    private function queryFromMysql($stringSql)
    {

        mysql_select_db($this->databaseName);
        $result = mysql_query($stringSql);

        $count = 0;
        $ans = array();
        while ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
            foreach ($rows as $key => $value) {
                $ans[$count][$key] = $value;
            }
            $count++;
        }
        mysql_free_result($result);
        mysql_close($conn);

        return $ans;
    }

    /*
     insert info mysql and return true or false
     */
    private function insertMysql($stringSql)
    {
        $conn = mysql_connect($this->serverIPPort, $this->username, $this->password);

        if (!$conn) {
            log_writer("Connect to mysql fail", "IPPort : " . $this->serverIPPort . " username : " . $this->username . " password : " . $this->password);
            return false;
        }
        mysql_select_db($this->databaseName);
        $result = mysql_query($stringSql);
        $insertID = mysql_insert_id();
        if ($insertID > 0) {
            return $insertID;
        } else {
            log_writer("mysql operation", mysql_error());
            return $result;
        }
    }
    public function closeDBConnection()
    {
        mysql_close($this->conn);
    }
    public function insertMailGroupInfo($groupName, $groupOwner)
    {
        $sql = "insert into group_info ( group_name , group_owner ) values ('${groupName}' , '${groupOwner}' ) ;";
        return $this->insertMysql($sql);
    }

    public function insertMailGroupMember($groupName, $groupMember)
    {
        $sql = "insert into group_member ( group_name , group_member ) values ('${groupName}' , '${groupMember}' ) ;";
        return $this->insertMysql($sql);
    }

    public function deleteMailGroupInfo($groupName)
    {
        $sql = "delete  from  group_info where group_name='${groupName}';";
        return $this->insertMysql($sql);
    }

    /*
     if groupMember is  an empty str , will delete all member belong this group ,or will delete only a member
     */
    public function deleteMailGroupMember($groupName, $groupMember)
    {
        if ($groupMember == "") {
            $sql = "delete  from  group_member where group_name='${groupName}';";
            return $this->insertMysql($sql);
        } else {
            $sql = "delete  from  group_member where group_name='${groupName}' and group_member='${groupMember}';";
            return $this->insertMysql($sql);
        }
    }

    public function getMailGroupInfo()
    {
        $sql = "select * from group_info";
        return $this->queryFromMysql($sql);
    }

    public function getMailGroupMember($group)
    {
        $sql = "select * from group_member where group_name='${group}'";
        return $this->queryFromMysql($sql);
    }

    public function getArrayMailGroupMember($group)
    {
        $totalArray = $this->getMailGroupMember($group);
        $returnArray = array();
        foreach ($totalArray as $memberInfo) {
            $returnArray[] = $memberInfo['group_member'];
        }
        return $returnArray;
    }

    public function getArrayMailGroupInfo()
    {
        $totalArray = $this->getMailGroupInfo();
        $returnArray = array();
        foreach ($totalArray as $groupInfo) {
            $returnArray[] = $groupInfo['group_name'];
        }
        return $returnArray;
    }
}