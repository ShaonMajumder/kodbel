<?php

namespace app\controllers;
use thecodeholic\phpmvc\Request;



/**
 * Class SiteController
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package app\controllers
 */

 

class MyRequest extends Request {

    public function mergeRequest($key,$value){
        // $GLOBALS["_POST"]["status"] = true;
        //  var_dump($GLOBALS["_POST"]);
        $data = [];
        if ($this->isGet()) {
            $_GET[$key] = $value;
            $data = $_GET;
        }

        if ($this->isPost()) {
            $_POST[$key] = $value;
            $data = $_POST;
        }
        // $_POST['status'] = true;
        // $this->data = $data;
        
        return $data;
    }
    
    public function getBody()
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        var_dump($_POST);
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                var_dump($value);
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}