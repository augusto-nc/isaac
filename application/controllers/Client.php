<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('SessionsVerify_Model');
       // $this->load->model('FuncoesClient_Model');
    }


    public function index(){




        $this->load->view('client/fixed/header');
        $this->load->view('client/index');
        $this->load->view('client/fixed/footer');

    }


}
