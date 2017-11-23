<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2017/11/20
 * Time: 17:01
 */
//require_once FCPATH.'vendor/autoload.php';

class Redis extends CI_Controller
{

    public function __construct()
    {
//        $this->load->driver('cache');
//        $this->_redis = $this->cache->predis;
//        parent::__construct();
    }

    public function connect()
    {
        $this->set_protect_hash_item('sss', 'sss', 'sss');
    }

    public function set_hash_item($hkey, $k = '', $v = '')
    {
        $ret = $this->_redis->hMset($hkey, $k, $v);
        return $ret ? true : false;
    }

    public function set_protect_hash_item(string $hkey, string $k = '', $v = ''): bool
    {
        $ret = $this->_redis->hSetNx($hkey, $k, $v);
        if ($ret) {
            return true;
        }
        return false;
    }

    public function hast_get_all($hkey): array
    {
        $ret = $this->hGetAll($hkey);
        if (!$ret) {
            return [];
        }

        return $ret ?: [];
    }

    public function check_hash_key_exist($hkey, $field = '')
    {
        if (!$field) {
            return false;
        }
        return $this->_redis->hexists($hkey, $field);
    }

}