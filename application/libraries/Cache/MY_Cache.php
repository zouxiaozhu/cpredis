<?php
class MY_Cache extends CI_Cache{
    public function __construct()
    {
        parent::__construct();
        $this->valid_drivers[]='predis';
    }

}