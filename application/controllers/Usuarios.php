
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Usuario_model');
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
        $this->form_validation->set_rules(
            'nome',
            'Nome',
            'required|min_length[3]',
            array(
                'required' => 'O campo Nome é obrigatório.',
                'min_length' => 'O Nome deve ter pelo menos 3 caracteres.'
            )
        );

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

        $this->form_validation->set_rules(
            'senha',
            'Senha',
            'required|min_length[6]',
            array(
                'required' => 'O campo Senha é obrigatório.',
                'min_length' => 'A Senha deve ter pelo menos 6 caracteres.'
            )
        );

        $this->form_validation->set_rules(
            'confirmar_senha',
            'Confirmar senha',
            'required|matches[senha]',
            array(
                'required' => 'Confirme a senha.',
                'matches' => 'As senhas não são iguais.'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('usuarios/cadastro');
            return;
        }

        $dados = array(
            'nome' => $this->input->post('nome', TRUE),
            'email' => $this->input->post('email', TRUE),
            'senha' => md5($this->input->post('senha', TRUE))
        );

        // Cadastra o usuário
        $this->Usuario_model->cadastrar($dados);

        // Busca o usuário recém-cadastrado
        $usuario = $this->Usuario_model->buscar_por_email($dados['email']);

        // Cria a sessão
        $this->session->set_userdata(
            'usuario_logado',
            $usuario
        );

        // Entra diretamente no sistema
        redirect('medicos');
    }
}