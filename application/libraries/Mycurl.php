<?php
class Mycurl {

    static function exec($method,$url,$field='',$userAgent='',$httpHeaders='',$username='',$password='',$opts=[]){
        $ch = Mycurl::init();
        if (false === $ch) {
            return false;
        }
        if (is_string ( $url ) && strlen ( $url )) {
            curl_setopt ( $ch, CURLOPT_URL, $url );
        } else {
            return false;
        }

        //是否显示头部信息
        curl_setopt ( $ch, CURLOPT_HEADER, false );
        //是否输出页面内容
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        //https
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
        if(is_array($opts) && count($opts) > 0) {
            curl_setopt_array($ch, $opts);
        }

        if ($username != '') {
            curl_setopt ( $ch, CURLOPT_USERPWD, $username . ':' . $password );
        }
        if(strtolower($method)=='post'){
            curl_setopt($ch,CURLOPT_POST,True);
            if(is_array($field)){
                $flag = true;
                foreach ($field as $key){
                    if(strpos($key,'@') === 0){ //如果首字母是@开头那么说明这个是文件上传
                        //     使用数组提供post数据时，CURL组件大概是为了兼容@filename这种上传文件的写法
                        $flag = False;
                    }
                }
                if($flag){
                    $field = http_build_query($field);
                }
            }
            curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
        }

            curl_setopt($ch,CURLOPT_TIMEOUT,50); //5秒
        if (strlen ( $userAgent )) {
            curl_setopt ( $ch, CURLOPT_USERAGENT, $userAgent );
        }

        if (is_array ( $httpHeaders )) {
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $httpHeaders );
        }
        $res = curl_exec($ch);
        if($error_no = curl_errno($ch)){
            $error_info = curl_error($ch);
            curl_close ( $ch );
            return ['status'=>0,'error_no'=>$error_no,'error_info'=>$error_info];
        }
        curl_close ( $ch );
        return ['status'=>1,'res'=>$res];
    }

    function get_curl($url,$userAgent='',$httpHeaders='',$username='',$password=''){
        $ret = Mycurl::execute ( 'GET', $url, '', $userAgent, $httpHeaders, $username, $password );
        return $ret;
    }
    function post_curl($url, $userAgent='',$httpHeaders='',$username='',$password=''){
        $ret = Mycurl::execute ( 'POST', $url, '', $userAgent, $httpHeaders, $username, $password );
        return $ret;
    }

    public static function init(){
        $ch = null;
        if (!function_exists('curl_init')){
            return false;
        }
        $ch = curl_init();
        if(!is_resource($ch)){
            return false;
        }
        return $ch;
    }
}
//
///*<?php
///**
// * curl类
// * $this->load->library('Ycurl');
// * $this->Ycurl->get('http://www.baidu.com');
// * @author    weirenzhong <rzwei@che300.com>
// * @created   2016-06-25 16:20
// */
//class Ycurl {
//
//    function execute($method, $url, $fields = '', $userAgent = '', $httpHeaders = '', $username = '', $password = '', $opts = array()) {
//        $ch = YCurl::create ();
//        if (false === $ch) {
//            return false;
//        }
//
//        if (is_string ( $url ) && strlen ( $url )) {
//            $ret = curl_setopt ( $ch, CURLOPT_URL, $url );
//        } else {
//            return false;
//        }
//        //是否输出页面内容
//        curl_setopt ( $ch, CURLOPT_HEADER, false );
//        //是否显示头部信息
//        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
//        if(is_array($opts) && count($opts) > 0) {
//            curl_setopt_array($ch, $opts);
//        }
//
//        if ($username != '') {
//            curl_setopt ( $ch, CURLOPT_USERPWD, $username . ':' . $password );
//        }
//
//        $method = strtolower ( $method );
//        if ('post' == $method) {
//            curl_setopt ( $ch, CURLOPT_POST, true );
//            if (is_array ( $fields )) {
//                $flag = true;
//                foreach ( $fields as $key => $val ) {
//                    if (strpos( $val, '@') == 0 ) {
//                        $flag = false;
//                        break;
//                    }
//                }
//                if ($flag) {
//                    $fields = http_build_query ( $fields );
//                }
//            }
//            // print_r($fields);exit;
//            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
//        } else if ('put' == $method) {
//            curl_setopt ( $ch, CURLOPT_PUT, true );
//        }
//
//        // curl_setopt($ch, CURLOPT_PROGRESS, true);
//        // curl_setopt($ch, CURLOPT_VERBOSE, true);
//        // curl_setopt($ch, CURLOPT_MUTE, false);
//        curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 ); // 设置curl超时秒数，例如将信息POST出去3秒钟后自动结束运行。
//
//        if (strlen ( $userAgent )) {
//            curl_setopt ( $ch, CURLOPT_USERAGENT, $userAgent );
//        }
//
//        if (is_array ( $httpHeaders )) {
//            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $httpHeaders );
//        } else {
//            // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        }
//
//        $ret = curl_exec ( $ch );
//
//        if (curl_errno ( $ch )) {
//            curl_close ( $ch );
//            return false;
//            // return array(curl_error($ch), curl_errno($ch));
//        } else {
//            curl_close ( $ch );
//            if (! is_string ( $ret ) || ! strlen ( $ret )) {
//                return false;
//            }
//            return $ret;
//        }
//    }
//
//    function post($url, $fields, $userAgent = '', $httpHeaders = '', $username = '', $password = '') {
//        $ret = YCurl::execute ( 'POST', $url, $fields, $userAgent, $httpHeaders, $username, $password );
//        if (false === $ret) {
//            return false;
//        }
//
//        if (is_array ( $ret )) {
//            return false;
//        }
//        return $ret;
//    }
//
//    public function get($url, $userAgent = '', $httpHeaders = '', $username = '', $password = '') {
//        $ret = YCurl::execute ( 'GET', $url, '', $userAgent, $httpHeaders, $username, $password );
//        if ($ret && ! is_array ( $ret )) {
//            return $ret;
//        }
//        return false;
//    }
//
//    function create() {
//        $ch = null;
//        if (! function_exists ( 'curl_init' )) {
//            return false;
//        }
//        $ch = curl_init ();
//        if (! is_resource ( $ch )) {
//            return false;
//        }
//        return $ch;
//    }
//
//}
