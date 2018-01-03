<?php
/**
 * Created by PhpStorm.
 * User: zhanglong
 * Date: 2017/11/28
 * Time: 19:31
 */

class chat extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function get(){

    	 $this->load->library('email');
        $this->email->initialize([
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.126.com',
            'smtp_port' => '25',
            'smtp_user' => 'zouxiaozhu520@126.com',
            'smtp_pass' => 'zl520025',
            'charset' => 'utf-8',
            'mailtype' => 'html'
        ]);

        $from = 'NO_REPLY';
        if (in_array(ENVIRONMENT, array('testing','development'))) {
            $from = '[测试机]'.$from;
        }
        $this->email->from('zouxiaozhu520@126.com', $from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();

    }



}