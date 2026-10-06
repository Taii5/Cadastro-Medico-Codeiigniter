<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Usuario_model');
        $this->load->model('Medico_model');

        $this->load->library('form_validation');
        $this->load->library('session');

        $this->load->helper('url');
    }


    public function cadastro()
    {
        $this->load->view('usuarios/cadastro');
    }


    public function salvar()
    {
        // NOME
        $this->form_validation->set_rules(
            'nome',
            'Nome',
            'required|min_length[3]|max_length[100]',
            array(
                'required' => 'O campo Nome é obrigatório.',
                'min_length' => 'O Nome deve ter pelo menos 3 caracteres.',
                'max_length' => 'O Nome pode ter no máximo 100 caracteres.'
            )
        );


        // CRM
        $this->form_validation->set_rules(
            'crm',
            'CRM',
            'required|numeric|max_length[20]',
            array(
                'required' => 'O campo CRM é obrigatório.',
                'numeric' => 'O CRM deve conter apenas números.',
                'max_length' => 'O CRM pode ter no máximo 20 números.'
            )
        );


        // ESPECIALIDADE
        $this->form_validation->set_rules(
            'especialidade',
            'Especialidade',
            'required|min_length[3]|max_length[100]',
            array(
                'required' => 'O campo Especialidade é obrigatório.',
                'min_length' => 'A Especialidade deve ter pelo menos 3 caracteres.',
                'max_length' => 'A Especialidade pode ter no máximo 100 caracteres.'
            )
        );


        // TELEFONE
        $this->form_validation->set_rules(
            'telefone',
            'Telefone',
            'required|numeric|min_length[10]|max_length[11]',
            array(
                'required' => 'O campo Telefone é obrigatório.',
                'numeric' => 'O Telefone deve conter apenas números.',
                'min_length' => 'O Telefone deve ter 10 ou 11 números.',
                'max_length' => 'O Telefone deve ter 10 ou 11 números.'
            )
        );


        // EMAIL
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'required|valid_email|is_unique[usuarios.email]',
            array(
                'required' => 'O campo E-mail é obrigatório.',
                'valid_email' => 'Digite um E-mail válido.',
                'is_unique' => 'Este E-mail já está cadastrado.'
            )
        );


        // SENHA
        $this->form_validation->set_rules(
            'senha',
            'Senha',
            'required|min_length[6]',
            array(
                'required' => 'O campo Senha é obrigatório.',
                'min_length' => 'A Senha deve ter pelo menos 6 caracteres.'
            )
        );


        // CONFIRMAR SENHA
        $this->form_validation->set_rules(
            'confirmar_senha',
            'Confirmar senha',
            'required|matches[senha]',
            array(
                'required' => 'Confirme a senha.',
                'matches' => 'As senhas não são iguais.'
            )
        );


        // SE TIVER ERRO, VOLTA PARA O FORMULÁRIO
        if ($this->form_validation->run() == FALSE) {

            $this->load->view('usuarios/cadastro');

            return;
        }


        // Verifica se o CRM já existe
        if ($this->Medico_model->crm_existe(
            $this->input->post('crm', TRUE)
        )) {

            $this->session->set_flashdata(
                'erro',
                'Este CRM já está cadastrado.'
            );

            $this->load->view('usuarios/cadastro');

            return;
        }


        // Dados do usuário
        $dados_usuario = array(
            'nome' => $this->input->post('nome', TRUE),
            'email' => $this->input->post('email', TRUE),
            'senha' => md5(
                $this->input->post('senha', TRUE)
            )
        );


        // Cadastra na tabela USUARIOS
        $this->Usuario_model->cadastrar($dados_usuario);


        // Dados do médico
        $dados_medico = array(
            'nome_completo' => $this->input->post('nome', TRUE),
            'crm' => $this->input->post('crm', TRUE),
            'especialidade' => $this->input->post('especialidade', TRUE),
            'telefone' => $this->input->post('telefone', TRUE),
            'email' => $this->input->post('email', TRUE)
        );


        // Cadastra na tabela MEDICOS
        $this->Medico_model->inserir($dados_medico);


        // Busca o usuário recém-cadastrado
        $usuario = $this->Usuario_model->buscar_por_email(
            $dados_usuario['email']
        );


        // Cria a sessão
        $this->session->set_userdata(
            'usuario_logado',
            $usuario
        );


        // Entra diretamente no sistema
        redirect('medicos');
    }
}