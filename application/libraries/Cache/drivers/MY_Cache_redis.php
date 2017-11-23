<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2017/11/20
 * Time: 17:37
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Cache_redis {


    public function test(){
       get_instance()->load->config('database',true,true);
       var_export($this->redis->item('default'));die;
    }

}