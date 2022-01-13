<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FuncoesAdmin_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db->reconnect();
        @session_start();
    }


    public function TextoConvertTable($tipo,$valor,$campo){

        if($tipo == 'permissoes'):

            if($valor == 't'):

                $valor = 'Todas as Permissões';

            endif;

            if($valor == 'as'):

                $valor = 'Permissões de Gerente';

            endif;

         endif;


         if($tipo == 'documentos'):

             if($campo == 'tipo'):

                 $this->db->select('nome');
                 $this->db->from('documentos_tipos');
                 $this->db->where('id',$valor);
                 $get = $this->db->get();
                 $count = $get->num_rows();

                 if($count > 0):

                     $result = $get->result_array()[0];

                 $valor = $result['nome'];

                 endif;

              endif;

             if($campo == 'cadastro'):

                 $this->db->select('nome');
                 $this->db->from('cadastros');
                 $this->db->where('id',$valor);
                 $get = $this->db->get();
                 $count = $get->num_rows();

                 if($count > 0):

                     $result = $get->result_array()[0];

                 $valor = $result['nome'];

                 endif;

              endif;

             if($campo == 'cadastro1'):

                 $this->db->select('nome');
                 $this->db->from('cadastros1');
                 $this->db->where('id',$valor);
                 $get = $this->db->get();
                 $count = $get->num_rows();

                 if($count > 0):

                     $result = $get->result_array()[0];

                 $valor = $result['nome'];

                 endif;

              endif;

        endif;

        if($tipo == 'pedidos'):


            if($campo == 'cadastro'):

                $this->db->select('nome,email');
                $this->db->from('cadastros');
                $this->db->where('id',$valor);
                $get = $this->db->get();
                $count = $get->num_rows();

                if($count > 0):

                    $result = $get->result_array()[0];

                    $valor = $result['email'];

                endif;

            endif;

            if($campo == 'cadastro1'):

                $this->db->select('nome,email');
                $this->db->from('cadastros1');
                $this->db->where('id',$valor);
                $get = $this->db->get();
                $count = $get->num_rows();

                if($count > 0):

                    $result = $get->result_array()[0];

                    $valor = $result['email'];

                endif;

            endif;

        endif;



         return $valor;

    }


    public function values_fields_sel($table,$field,$value,$act){

        $result = '';

        if($table == 'cadastros1'):

            if($value > 0):


                    $this->db->select($field);
                    $this->db->from($table);
                    $this->db->where('id',$value);
                    $get = $this->db->get();

                    $count = $get->num_rows();

                    if($count > 0):
                        $valor = $get->result_array()[0];

                        if($act == $valor[$field]):

                        $result = 'selected';

                    endif;

                endif;

            endif;

        endif;


        return $result;

    }



    public function values_fields($table,$field,$value){

        $result = '';

        if($table == 'pergunta_frequentes'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.$valor[$field].'"';
                endif;
            endif;

        endif;

        if($table == 'administrador'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.$valor[$field].'"';
                endif;
            endif;

        endif;

        if($table == 'nossos_servicos'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.$valor[$field].'"';
                endif;
            endif;

        endif;

        if($table == 'postagens_videos'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.$valor[$field].'"';
                endif;
            endif;

        endif;


        if($table == 'cadastros'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.$valor[$field].'"';
                endif;
            endif;

        endif;


        if($table == 'cogs'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.htmlspecialchars($valor[$field]).'"';
                endif;
            endif;

        endif;



        if($table == 'cadastros1'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = 'value="'.$valor[$field].'"';
                endif;
            endif;

        endif;


        return $result;

    }


    public function values_fieldstxt($table,$field,$value){

        $result = '';



        if($table == 'nossos_servicos'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;



        if($table == 'cogs'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;

        if($table == 'perguntas_frequentes'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;

        if($table == 'pendencias'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;

        if($table == 'postagens_videos'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;

        if($table == 'type_cleaning'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;
        if($table == 'cogs'):

            if($value > 0):

                $this->db->select($field);
                $this->db->from($table);
                $this->db->where('id',$value);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $valor = $get->result_array()[0];
                    $result = $valor[$field];
                endif;
            endif;

        endif;


        return $result;

    }

}


