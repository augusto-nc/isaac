<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AjaxClient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Funcoes_Model');
        $this->load->model('AdminSessao_Model');
        $this->load->model('FuncoesAdmin_Model');
        $this->load->model('FuncoesClient_Model');

    }


    public function cadastro()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            echo 'Você ja esta logado';

        else:


            if (isset($_POST['nome']) and !empty($_POST['nome']) and isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['senha']) and !empty($_POST['senha']) and isset($_POST['senha_r']) and !empty($_POST['senha_r'])):


                $this->db->select('email');
                $this->db->from('cl_cadastros');
                $this->db->where('email', $_POST['email']);
                $get = $this->db->get();

                $count = $get->num_rows();

                if ($count > 0):
                    echo 'Você já possui cadastro como usuario, realize login';
                else:

                    if (md5($_POST['senha']) <> md5($_POST['senha_r'])):

                        echo 'As senhas não correspondem!';
                        exit();
                    endif;


                    $arr['nome'] = $_POST['nome'];
                    $arr['email'] = $_POST['email'];
                    $arr['status'] = 1;
                    $arr['senha'] = md5($_POST['senha']);

                    if ($this->db->insert('cl_cadastros', $arr)):

                        $_SESSION['ID_CLIENT'] = $this->db->insert_id();
                        $_SESSION['EMAIL_CLIENT'] = $_POST['email'];
                        $_SESSION['PASS_CLIENT'] = md5($_POST['senha']);


                        $arp['nome'] = 'Aquisição do Robô BotReels';
                        $arp['id_cliente'] = $this->db->insert_id();
                        $arp['data'] = date('d/m/Y');
                        $arp['data_vencimento'] = date('Y-m-d');
                        $arp['valor'] = 397;
                        $arp['bloqueia_sistema'] = 1;
                        $arp['pago'] = 0;
                        $arp['status'] = 1;
                        $arp['aquisicao_robo'] = 1;
                        $arp['obs'] = 'Após o pagamento seu Painel será liberado.';
                        $this->db->insert('cl_financeiro', $arp);

                        echo 1;
                    else:
                        echo 'Ocorreu um erro ao realizar o cadastro, tente novamente!';
                    endif;


                endif;


            else:

                echo 'Preencha todos os campos';

            endif;


        endif;


    }


    public function login()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            echo 1;

        else:


            if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['senha']) and !empty($_POST['senha'])):


                $this->db->select('id');
                $this->db->from('cl_cadastros');
                $this->db->where('email', $_POST['email']);
                $get = $this->db->get();

                $count = $get->num_rows();

                if ($count > 0):


                    $this->db->select('id');
                    $this->db->from('cl_cadastros');
                    $this->db->where('email', $_POST['email']);
                    $this->db->where('senha', md5($_POST['senha']));
                    $get = $this->db->get();

                    $count = $get->num_rows();

                    if ($count > 0):

                        $_SESSION['ID_CLIENT'] = $get->result_array()[0]['id'];
                        $_SESSION['EMAIL_CLIENT'] = $_POST['email'];
                        $_SESSION['PASS_CLIENT'] = md5($_POST['senha']);

                        echo 1;
                    else:

                        echo 'Senha Incorreta, tente novamente';

                    endif;
                else:


                    echo 'Usuario não encontrado, realize o cadastro.';

                endif;


            else:

                var_dump($_POST);

            endif;


        endif;


    }


    public function logout()
    {
        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            unset($_SESSION['ID_CLIENT']);
            unset($_SESSION['EMAIL_CLIENT']);
            unset($_SESSION['PASS_CLIENT']);

            header('Location: ' . base_url());

        else:

            header('Location: ' . base_url());

        endif;
    }


    public function adicionarOrdem()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):


            if (isset($_POST) and !empty($_POST)):


                $arr['status'] = 1;
                $arr['id_cliente'] = $_SESSION['ID_CLIENT'];

                foreach ($_POST as $keys => $vals) {

                    $arr[$keys] = $vals;

                }


                if(isset($_POST['estrategia']) AND $_POST['estrategia'] == 1):

                    $this->db->from('paridades');
                    $this->db->order_by('rand()');
                    $get = $this->db->get();

                    unset(  $arr['paridade']);
                    $arr['paridade'] = $get->result_array()[0]['paridade'];


                endif;
                unset($arr['estrategia']);
                if ($this->db->insert('cl_ordens', $arr)):

                    echo 1;

                else:

                    echo 'Erro ao gravar, tente novamente!';

                endif;

            else:

                echo 'Ocorreu um erro, tente novamente!';

            endif;


        else:

            echo 'Você não esta logado!';

        endif;

    }


    public function ativarordens()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            if (isset($_POST['ordem']) and !empty($_POST['ordem'])):

                $arr['status'] = 1;

                if ($_POST['ordem'] > 0):
                    $this->db->where('id', $_POST['ordem']);
                endif;
                if ($this->db->update('cl_ordens', $arr)):
                    echo 1;
                else:
                    echo 'Erro ao pausar ordens!';
                endif;

            else:

                echo 'Erro ao pausar ordens!';

            endif;

        else:

            echo 'Você não esta logado!';

        endif;


    }


    public function pausarordens()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            if (isset($_POST['ordem'])):

                $arr['status'] = 0;

                if ($_POST['ordem'] > 0):
                    $this->db->where('id', $_POST['ordem']);
                endif;
                if ($this->db->update('cl_ordens', $arr)):
                    echo 1;
                else:
                    echo 'Erro ao pausar ordens!';
                endif;

            else:

                echo 'Erro ao pausar ordens!';

            endif;

        else:

            echo 'Você não esta logado!';

        endif;


    }

    public function remover_ordem()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            if (isset($_POST['ordem'])):

                $arr['status'] = 0;

                if ($_POST['ordem'] > 0):
                    $this->db->where('id', $_POST['ordem']);
                endif;
                if ($this->db->delete('cl_ordens')):
                    echo 1;
                else:
                    echo 'Erro ao pausar ordens!';
                endif;

            else:

                echo 'Erro ao pausar ordens!';

            endif;

        else:

            echo 'Você não esta logado!';

        endif;


    }


    public function saveEdit()
    {


        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            $tabela = $_POST['tabela'];
            unset($_POST['tabela']);
            if ($_POST['editar']):
                $edit = $_POST['editar'];
                unset($_POST['editar']);
            endif;




            if (isset($_POST) and !empty($_POST)):

                foreach ($_POST as $key => $val) {

                    $arr[$key] = $val;

                }

                if (isset($_POST['senha']) and !empty($_POST['senha'])):
                    $arr['senha'] = md5($_POST['senha']);

                endif;
            endif;


            if (isset($edit) and !empty($edit)):

                $this->db->where('id', $edit);
                if ($this->db->update($tabela, $arr)):

                    header("Location: " . $_SERVER['HTTP_REFERER'] . '?salvo=1');

                else:

                    header("Location: " . $_SERVER['HTTP_REFERER'] . '?erro=1');

                endif;
            else:

                if ($this->db->insert($tabela, $arr)):

                    header("Location: " . $_SERVER['HTTP_REFERER']);

                else:

                    header("Location: " . $_SERVER['HTTP_REFERER'] . '?erro=1');

                endif;
            endif;


        endif;

    }


    public function desativarConta()
    {

        if ($this->FuncoesClient_Model->sessionveryfy() == true):

            $arr['status'] = 0;
            $this->db->where('id', $_SESSION['ID_CLIENT']);
            if ($this->db->update('cl_cadastros', $arr)):

                echo 1;
            else:
                echo 'Ocorreu um erro, tente novamente!';

            endif;

        else:
            echo 'Faça login para continuar!';


        endif;

    }


    public function contatoForm()
    {
        if ($this->FuncoesClient_Model->sessionveryfy() == true):


            $arr['client_id'] = $_SESSION['ID_CLIENT'];
            $arr['assunto'] = $_POST['assunto'];
            $arr['mensagem'] = $_POST['mensagem'];
            $arr['data'] = date('d/m/Y');
            $arr['status'] = 1;
            if ($this->db->insert('cl_contato', $arr)):

                $emailenviar = "contato@botreels.com";
                $destino = $emailenviar;
                $assunto = "Contato pelo Site BootReels";

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $_POST['assunto'];

                $enviaremail = mail($destino, $_POST['assunto'], $_POST['mensagem'], $headers);
                if ($enviaremail) {
                    header("Location: " . $_SERVER['HTTP_REFERER'] . '?salvo=1');
                } else {
                    header("Location: " . $_SERVER['HTTP_REFERER'] . '?salvo=1');
                }


            else:

                header("Location: " . $_SERVER['HTTP_REFERER'] . '?erro=1');


            endif;


            header("Location: " . $_SERVER['HTTP_REFERER'] . '?salvo=1');

        else:

            header("Location: " . $_SERVER['HTTP_REFERER'] . '?erro=1');

        endif;

    }

}