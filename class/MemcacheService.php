<?php

/**
 * Created by PhpStorm.
 * User: zhouyuan1
 * Date: 2018/1/22
 * Time: 下午3:12
 */
class MemcacheService
{
    public $ip;
    public $port;
    public $memcache;

    function __construct()
    {
        $settings = include_once("../settings.php");
        if ($settings['memcacheIP'] == "" || $settings['memcachePort']) {
            $this->ip = $settings['memcacheIP'];
            $this->port = $settings['memcachePort'];
        } else {
            log_writer("Load settings fail", json_encode($settings));
        }
        $this->memcache = new Memcache();
        $this->memcache->pconnect($this->ip, $this->port);

    }

    function setMemcache($key, $value_input, $validTime)
    {
        $value = serialize($value_input);
        $ans = $this->memcache->set($key, $value, 0, $validTime);
        return $ans;
    }

    function queryMemcache($key)
    {
        $value = $this->memcache->get($key);
        $value = unserialize($value);
        return $value;
    }
}
