<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Auth_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function entrar()
    {
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'required|valid_email'
        );

        $this->form_validation->set_rules(
            'senha',
            'Senha',
            'required'
        );

        $this->form_validation->set_message(
            'required',
            'O campo {field} é obrigatório.'
        );

        $this->form_validation->set_message(
            'valid_email',
            'Digite um e-mail válido.'
        );

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $email = $this->input->post('email', TRUE);
        $senha = $this->input->post('senha', TRUE);

        $usuario = $this->Auth_model->verificar_login($email, $senha);

        if ($usuario) {

            $sessao = array(
                'usuario_id'    => $usuario->id,
                'usuario_nome'  => $usuario->nome,
                'usuario_email' => $usuario->email,
                'logado'        => TRUE
            );

            $this->session->set_userdata($sessao);

            redirect('medicos');

        } else {

            $data['erro'] = 'E-mail ou senha incorretos.';

            $this->load->view('auth/login', $data);
        }
    }

    public function sair()
    {
        $this->session->sess_destroy();

        redirect('auth');
    }
}

