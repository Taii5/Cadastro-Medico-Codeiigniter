<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auditoria extends CI_Controller
{

public function __construct()
{
    parent::__construct();

    if (!$this->session->userdata('logado')){
        redirect('auth');
    }
    
    $this->load->model('Auditoria_model');
    $this->load->helper('url');
}

    public function index()
    {
        $dados['auditorias'] = $this->Auditoria_model->listar();

        $this->load->view( //ENVIA OS DADOS PARA A VIEW
            'auditoria/antes_depois',
            $dados
        );
    }
}