<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Api extends Auth {

    public function __construct(){
        parent::__construct();
    }

    public function index_get()
    {

        if($this->set_response($response, REST_Controller::HTTP_OK)){
            $msg=[
                'message'=>'Logged in',
            ];
            print_r($msg);
        }
        else{
            echo "error";
        }
    }
    public function home_get()
    {
        
        if($this->set_response($response, REST_Controller::HTTP_OK)){
            $msg=[
                'message'=>' at home',
            ];
            print_r(json_encode($msg));
        }
        else{
            echo "error";
        }
    }
    
}
