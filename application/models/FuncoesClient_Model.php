<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FuncoesClient_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db->reconnect();
        @session_start();
    }


    public function sessionveryfy(){

        if(isset($_SESSION['ID_CLIENT']) and isset($_SESSION['EMAIL_CLIENT']) and isset($_SESSION['PASS_CLIENT'])):

            return true;

            else:

            return false;
        endif;

    }

    public function aquisicao_robo($id){

        $this->db->from('cl_financeiro');
        $this->db->where('pago',0);
        $this->db->where('id_cliente',$id);
        $this->db->where('data_vencimento <=',date('Y-m-d'));
        $get = $this->db->get();
        $robo = $get->num_rows();


        return $robo;

    }

    public function perfil_ordem($ordem){
        $return = 'Não Informado';

        if($ordem == 1):
        $return = 'Muito Baixo<br><small>1%</small>';

        elseif($ordem == 2):
        $return = 'Baixo<br><small>2%</small>';

        elseif($ordem == 3):
        $return = 'Médio<br><small>3%</small>';

        elseif($ordem == 4):
        $return = 'Alto<br><small>4%</small>';

        elseif($ordem == 5):
        $return = 'Muito Alto<br><small>5%</small>';

        elseif($ordem == 12):
        $return = 'Padrão<br><small id="operacao"></small>';

        endif;

        return $return;
    }


}