<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('SessionsVerify_Model');
        // $this->load->model('FuncoesClient_Model');
        $this->load->model('AdminSessao_Model');
        $this->load->model('FuncoesAdmin_Model');
        $this->load->model('FuncoesClient_Model');
    }




    public function index()
    {

        $this->load->view('client/index');

    }





}