<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cache_predis extends Predis\Client{
    protected static $_default_config = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0
    );

    public function __construct()
    {
        $CI = &get_instance();
        if($CI->load->config('redis',TRUE,TRUE)) {
            self::$_default_config = array_merge(self::$_default_config, $CI->config->item('redis'));
        }
        parent::__construct(self::$_default_config);
    }
    public function decoration($parent){
    }
}