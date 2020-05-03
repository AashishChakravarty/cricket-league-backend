<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Home extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database('default', true);
        $this->load->model('home_model');
        $this->load->helper('url');
    }

    public function ongoing_leagues_get()
    {
        $date = date("Y/m/d");
        
        $result = $this->home_model->current_league($date);

        if($result){
            $response = array(
                        'status'    => true,
                        'data'  => $result
                    );
            return $this->response($response, REST_Controller::HTTP_OK);
        }else{
            $response = array(
                        'status'    => false,
                        'message'   => 'No data found.'
                    );
            return $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function previous_leagues_get()
    {
        $date = date("Y/m/d");
        
        $result = $this->home_model->previous_league($date);

        if($result){
            $response = array(
                        'status'    => true,
                        'data'  => $result
                    );
            return $this->response($response, REST_Controller::HTTP_OK);
        }else{
            $response = array(
                        'status'    => false,
                        'message'   => 'No data found.'
                    );
            return $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function upcoming_leagues_get()
    {
        $date = date("Y/m/d");
        
        $result = $this->home_model->upcoming_league($date);

        if($result){
            $response = array(
                        'status'    => true,
                        'data'  => $result
                    );
            return $this->response($response, REST_Controller::HTTP_OK);
        }else{
            $response = array(
                        'status'    => false,
                        'message'   => 'No data found.'
                    );
            return $this->response($response, REST_Controller::HTTP_OK);
        }
    }

    public function league_get()
    {
        $id = $this->uri->segment(3, 0);
        if ($id) {
            $result_league = $this->home_model->league_details($id);
            
            if($result_league){
                $matches = $this->home_model->matches($id);

                $data = array(
                    'id' => $result_league['id'],
                    'name' => $result_league['name'],
                    'description' => $result_league['description'],
                    'cover_img' => $result_league['cover_img'],
                    'start_date' => $result_league['start_date'],
                    'end_date' => $result_league['end_date'],
                    'total_match' => $result_league['total_match'],
                    'matches'=> $matches
                );

                $response = array(
                            'status'    => true,
                            'data'  => $data
                        );
                return $this->response($response, REST_Controller::HTTP_OK);
                
            }else{
                $response = array(
                            'status'    => false,
                            'message'   => 'No data found.'
                        );
                return $this->response($response, REST_Controller::HTTP_OK);
            }
        }
        else {
            $response = array(
                        'status'    => false
                    );
            return $this->response($response,REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function match_get()
    {
        $id = $this->uri->segment(3, 0);
        if ($id) {
            $result_match = $this->home_model->match($id);
            
            if($result_match){
               
                $response = array(
                            'status'    => true,
                            'data'  => $result_match
                        );
                return $this->response($response, REST_Controller::HTTP_OK);
                
            }else{
                $response = array(
                            'status'    => false,
                            'message'   => 'No data found.'
                        );
                return $this->response($response, REST_Controller::HTTP_OK);
            }
        }
        else {
            $response = array(
                        'status'    => false
                    );
            return $this->response($response,REST_Controller::HTTP_NOT_FOUND);
        }
    }
}

?>