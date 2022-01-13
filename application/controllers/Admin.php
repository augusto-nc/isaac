<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('Funcoes_Model');
        $this->load->model('FuncoesAdmin_Model');
        $this->load->model('AdminSessao_Model');
        $this->load->model('FuncoesClient_Model');

        //$this->load->model('Funcoes_Model');

    }


    // ROTAS REGULARES

    public function logout(){
        if($this->AdminSessao_Model->session_panel() == true):
            $this->AdminSessao_Model->destroy_session_panel();
        endif;
        header("Location:".base_url('cl-admin'));
        }


    //ROTAS DE NAVEGAÇÃO


    public function index(){

        $arr['page'] = 'resumo';

        if($this->AdminSessao_Model->session_panel() == true):
            $this->db->from('cogs');
            $this->db->where('id',3);
            $get = $this->db->get();

            $count = $get->num_rows();

            if($count > 0):

                $arr['cog']['meta_titulo'] = $get->result_array()[0];

                $this->db->from('cl_admin');
                $this->db->where('id',$_SESSION['acesso_user']);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):

                    $arr['admin'] = $get->result_array()[0];

                else:

                    $this->logout();

                endif;


                $this->db->from('cl_financeiro');
                $this->db->where('aquisicao_robo',1);
                $this->db->where('pago',1);
                $get = $this->db->get();

                $count = $get->num_rows();
                $arr['valor_vendido'] = 0;

                if($count > 0):

                    $result = $get->result_array();

                foreach ($result as $value){

                    $arr['valor_vendido'] = $arr['valor_vendido'] + $value['valor'];


                }

                endif;




                $this->db->from('cl_ordens');
                $this->db->where('situacao_compra',0);
                $get = $this->db->get();

                $count = $get->num_rows();
                $arr['orders_abertas'] = 0;

                if($count > 0):

                    $result = $get->result_array();

                    foreach ($result as $value){

                        $arr['orders_abertas'] = $arr['orders_abertas'] + $value['valor'];


                    }

                endif;


                $this->db->from('cl_ordens_fechadas');
                $this->db->where('status',1);
                $get = $this->db->get();

                $count = $get->num_rows();
                $arr['orders_fechadas'] = 0;

                if($count > 0):

                    $result = $get->result_array();

                    foreach ($result as $value){

                        $valorcalculo = $value['valor_lucro'] - $value['valor_prejuizo'];

                        $arr['orders_fechadas'] = $arr['orders_fechadas'] + $valorcalculo;


                    }

                endif;


                $this->db->from('cl_financeiro');
                $this->db->where('aquisicao_robo',0);
                $this->db->where('pago',0);
                $get = $this->db->get();

                $count = $get->num_rows();
                $arr['valor_vendido'] = 0;

                if($count > 0):

                    $result = $get->result_array();

                    foreach ($result as $value){


                        $arr['valor_vendido'] = $arr['valor_vendido'] + $value['valor'];


                    }

                endif;


                $this->db->from('cl_ordens_fechadas');
                $this->db->where('valor_lucro >',0);
                $this->db->where('data_venda_mes',date('m'));

                $this->db->where('data_venda_ano',date('Y'));
                $this->db->where('status',1);
                $get = $this->db->get();
                $lucros = $get->num_rows();
                $arr['lucro_mes_usdt'] = 0;
                if($lucros > 0):
                    $lucro = $get->result_array();
                    foreach ($lucro as $value){

                        $arr['lucro_mes_usdt'] = $arr['lucro_mes_usdt'] + $value['valor_lucro'];

                    }
                endif;


                $this->db->from('cl_ordens_fechadas');
                $this->db->where('id_cliente',$_SESSION['ID_CLIENT']);
                $this->db->where('valor_lucro >',0);
                $this->db->where('data_venda',date('d/m/Y'));
                $this->db->where('status',1);
                $get = $this->db->get();
                $lucros = $get->num_rows();
                $arr['valor_lucro_dia'] = 0;
                if($lucros > 0):
                    $lucro = $get->result_array();
                    foreach ($lucro as $value){

                        $arr['valor_lucro_dia'] = $arr['valor_lucro_dia'] + $value['valor_lucro'];

                    }
                endif;


                $this->db->from('cl_cadastros');
                $get = $this->db->get();

                $count2 = $get->num_rows();
                $arr['total_clientes'] = $count2;


                $arr['total_clientes_ativos'] = 0;
                $arr['total_clientes_desativados'] = 0;



                $this->db->from('cl_cadastros');
                $get = $this->db->get();

                $count2 = $get->num_rows();


                if($count2 > 0):

                    $result = $get->result_array();

                foreach ($result as $vals){

                    if($this->FuncoesClient_Model->aquisicao_robo($vals['id']) > 0):
                        $arr['total_clientes_desativados'] = $arr['total_clientes_desativados'] + 1;

                    else:

                        $arr['total_clientes_ativos'] = $arr['total_clientes_ativos'] + 1;

                    endif;


                    }



                endif;








                $this->db->from('cl_financeiro');
                $this->db->order_by('id','desc');
                $this->db->limit(10,0);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):
                    $result = $get->result_array();
                    $arr['ultimas_transacoes'] = $result;

                endif;

        $this->load->view('admin/pages/fixed_files/header',$arr);
        $this->load->view('admin/index',$arr);
        $this->load->view('admin/pages/fixed_files/footer',$arr);

        else:

                $this->logout();

        endif;

        else:

            if(isset($_POST['loginKey']) and isset($_POST['usuario']) and !empty($_POST['usuario']) and isset($_POST['senha']) and !empty($_POST['senha'])):

                $this->AdminSessao_Model->logar($_POST);

            endif;

                $this->login();

        endif;

    }



    // CLIENTES

    public function meus_clientes(){
        $arr['page'] = 'clientes';


        if (isset($_GET['excluir']) AND !empty($_GET['excluir'])):
            $this->db->where('id',$_GET['excluir']);
            if($this->db->delete('cl_cadastros')):
                header("Location: ".base_url('cl-admin/meus-clientes?sucess=2'));
            endif;

        endif;
        if (isset($_GET['robo']) AND !empty($_GET['robo'])):


            $this->db->from('cl_financeiro');
            $this->db->where('aquisicao_robo',1);
            $this->db->where('id_cliente',$_GET['usuario']);
            $get = $this->db->get();

            $count = $get->num_rows();

            if($count > 0):

                 $result = $get->result_array()[0];

                if($_GET['robo'] == 1):

                    $arp['pago'] = 0;
                    $this->db->where('id',$result['id']);
                    $this->db->update('cl_financeiro',$arp);
                    header("Location: ".base_url('cl-admin/meus-clientes?sucess=1'));
                    exit();

                    else:

                        $arp['data_vencimento'] = date('Y-m-d');

                        $arp['pago'] = 1;
                        $this->db->where('id',$result['id']);
                        $this->db->update('cl_financeiro',$arp);
                        header("Location: ".base_url('cl-admin/meus-clientes?sucess=2'));
                        exit();
                endif;

            endif;

        endif;


        if($this->AdminSessao_Model->session_panel() == true):
            $this->db->from('cogs');
            $this->db->where('id',3);
            $get = $this->db->get();

            $count = $get->num_rows();

            if($count > 0):

                $arr['cog']['meta_titulo'] = $get->result_array()[0];

                $this->db->from('cl_admin');
                $this->db->where('id',$_SESSION['acesso_user']);
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):

                    $arr['admin'] = $get->result_array()[0];

                else:

                    $this->logout();

                endif;

                $this->db->from('cl_cadastros');
                if(isset($_GET['id_cliente']) AND !empty($_GET['id_cliente'])):
                    $this->db->where('id',$_GET['id_cliente']);
                endif;
                $get = $this->db->get();

                $count = $get->num_rows();

                if($count > 0):

                    $result = $get->result_array();

                    $arr['clientes'] = $result;


                endif;

                $this->load->view('admin/pages/fixed_files/header',$arr);
                $this->load->view('admin/pages/painel/clientes/meus_clientes',$arr);
                $this->load->view('admin/pages/fixed_files/footer',$arr);

            else:

                $this->logout();

            endif;

        else:

            if(isset($_POST['loginKey']) and isset($_POST['usuario']) and !empty($_POST['usuario']) and isset($_POST['senha']) and !empty($_POST['senha'])):

                $this->AdminSessao_Model->logar($_POST);

            endif;

            $this->login();

        endif;

    }



    // PEDIDOS

     public function pedidos(){
                $arr['page'] = 'pedidos';

                if($this->uri->segment(2) == 'pedidos-aguardando'):
                    $arr['navstab'] = 'aguardando';
                endif;

                if($this->uri->segment(2) == 'pedidos-autorizado'):
                    $arr['navstab'] = 'autorizado';
                endif;

                if($this->uri->segment(2) == 'pedidos-elaborando'):
                    $arr['navstab'] = 'elaborando';
                endif;

                if($this->uri->segment(2) == 'pedidos-aprovado'):
                    $arr['navstab'] = 'aprovado';
                endif;

                if($this->uri->segment(2) == 'pedidos-enviado'):
                    $arr['navstab'] = 'enviado';
                endif;

                if($this->uri->segment(2) == 'pedidos-finalizado'):
                    $arr['navstab'] = 'finalizado';
                endif;


                if($this->AdminSessao_Model->session_panel() == true):
                    $this->db->from('cogs');
                    $this->db->where('id',3);
                    $get = $this->db->get();

                    $count = $get->num_rows();

                    if($count > 0):

                        $arr['cog']['meta_titulo'] = $get->result_array()[0];

                        $this->db->from('cl_admin');
                        $this->db->where('id',$_SESSION['acesso_user']);
                        $get = $this->db->get();

                        $count = $get->num_rows();

                        if($count > 0):

                            $arr['admin'] = $get->result_array()[0];

                        else:

                            $this->logout();

                        endif;

                        $this->db->from('cl_financeiro');
                        $this->db->where('aquisicao_robo',1);
                        $get = $this->db->get();

                        $count = $get->num_rows();

                        if($count > 0):

                            $result = $get->result_array();

                            $arr['pedidos'] = $result;


                        endif;


                        $this->load->view('admin/pages/fixed_files/header',$arr);
                        $this->load->view('admin/pages/painel/pedidos/pedidos',$arr);
                        $this->load->view('admin/pages/fixed_files/footer',$arr);

                    else:

                        $this->logout();

                    endif;

                else:

                    if(isset($_POST['loginKey']) and isset($_POST['usuario']) and !empty($_POST['usuario']) and isset($_POST['senha']) and !empty($_POST['senha'])):

                        $this->AdminSessao_Model->logar($_POST);

                    endif;

                    $this->login();

                endif;

            }






    //PAGINA DE AUTORIZAÇÃO



    public function login(){

        if($this->AdminSessao_Model->session_panel() == true): header("Location: ".base_url('cl-admin')); exit(); endif;

        $this->db->from('cogs');
        $this->db->where('status',1);
        $this->db->where('page_method','layout_login_admin');
        $get = $this->db->get();

        $count = $get->num_rows();

        if($count > 0):

            $arr['cog'] = $get->result_array()[0];
            $arr['cog']['meta_titulo'] = 'Login Administrador';
            $arr['cog']['base_url'] = base_url('temas/administrativo/'.$get->result_array()[0]['cog1'].'');

            $this->load->view('admin/auth',$arr);


        else:


            echo 'Ocorreu um erro ao configurar, entre em contato com o suporte da Agência CodeLabs';

        endif;
    }



    //PAGINA DE ERRO 404



    public function page404(){
        $this->db->from('cogs');
        $this->db->where('status',1);
        $this->db->where('page_method','layout_login_admin');
        $get = $this->db->get();

        $count = $get->num_rows();

        if($count > 0):

            $cog = $get->result_array()[0];
            $cog['base_url'] = base_url('temas/administrativo/'.$get->result_array()[0]['cog1'].'');

            echo str_replace(
                array(
                    "{{base_url}}",
                    "{{r_base_url}}"
                ),
                array(
                    $cog['base_url'],
                    base_url()
                ),
                $cog['cog9']);


        else:


            echo 'Ocorreu um erro ao configurar, entre em contato com o suporte da Agência CodeLabs';

        endif;
    }




    // ROTAS AJAX


    public function Ajax_login(){


        if(!isset($_POST['usuario']) or isset($_POST['usuario']) and empty($_POST['usuario'])): echo 'Preencha o Usuario!'; exit(); endif;

        if(!isset($_POST['senha']) or isset($_POST['senha']) and empty($_POST['senha'])): echo 'Preencha o Senha!'; exit(); endif;


        $this->db->from('cl_admin');
        $this->db->where('email',$_POST['usuario']);
        $this->db->where('senha',md5($_POST['senha']));
        $this->db->where('status',1);
        $get = $this->db->get();
        $count = $get->num_rows();

        if($count > 0):


            $_SESSION['acesso_user'] = $get->result_array()[0]['id'];
            $_SESSION['acesso_pass'] = md5($_POST['senha']);

            echo 1;
        else:

            echo  'Usuario ou senha incorretos!';

        endif;





    }


}




