<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auditoria extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Auditoria_model');
        $this->load->library('session');
        $this->load->helper('url');

        // Verifica se o usuário está logado
        if (!$this->session->userdata('usuario_logado')) {
            redirect('auth');
        }
    }

    public function index()
    {
        // Busca os registros da auditoria
        $dados['auditorias'] = $this->Auditoria_model->listar();

        // Carrega a tela de auditoria
        $this->load->view(
            'auditoria/antes_depois',
            $dados
        );
    }
}