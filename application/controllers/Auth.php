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
            'required|valid_email',
            array(
                'required' => 'O campo E-mail é obrigatório.',
                'valid_email' => 'Digite um E-mail válido.'
            )
        );

        $this->form_validation->set_rules(
            'senha',
            'Senha',
            'required',
            array(
                'required' => 'O campo Senha é obrigatório.'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
            return;
        }

        $email = $this->input->post('email', TRUE);
        $senha = $this->input->post('senha', TRUE);

        $usuario = $this->Auth_model->verificar_login($email, $senha);

        if ($usuario) {

            $this->session->set_userdata(
                'usuario_logado',
                $usuario
            );

            redirect('medicos');

        } else {

            $this->session->set_flashdata(
                'erro',
                'Usuário não cadastrado. Faça seu cadastro.'
            );

            redirect('usuarios/cadastro');
        }
    }

    public function sair()
    {
        $this->session->sess_destroy();

        redirect('auth');
    }
}