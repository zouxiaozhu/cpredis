<?php

/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2017/11/21
 * Time: 18:24
 */

use Predis\Client;
class Predis extends Client
{
    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        echo 1111;
    }
}