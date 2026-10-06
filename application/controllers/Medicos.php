<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Medico_model');
        $this->load->model('Auditoria_model');

        $this->load->library('form_validation');
        $this->load->library('session');

        $this->load->helper('url');
    }


    ///////////////////////////
    // LISTAGEM
    ///////////////////////////

    public function index()
    {
        $busca = trim(
            $this->input->get('busca', TRUE)
        );

        $dados['medicos'] =
            $this->Medico_model->listar($busca);

        $dados['busca'] = $busca;

        $this->load->view(
            'medicos/listagem',
            $dados
        );
    }


    ///////////////////////////
    // NOVO MÉDICO
    ///////////////////////////

    public function novo()
    {
        $dados['medico'] = null;
        $dados['erro'] = '';

        $this->load->view(
            'medicos/formulario',
            $dados
        );
    }


    ///////////////////////////
    // SALVAR NOVO MÉDICO
    ///////////////////////////

    public function salvar()
    {
        $this->validar_formulario();

        if ($this->form_validation->run() == FALSE) {

            $dados['medico'] = null;
            $dados['erro'] = '';

            $this->load->view(
                'medicos/formulario',
                $dados
            );

            return;
        }


        // Dados enviados pelo formulário
        $dados = array(
            'nome_completo' =>
                $this->input->post(
                    'nome_completo',
                    TRUE
                ),

            'cpf' =>
                preg_replace(
                    '/[^0-9]/',
                    '',
                    $this->input->post(
                        'cpf',
                        TRUE
                    )
                ),

            'crm' =>
                $this->input->post(
                    'crm',
                    TRUE
                ),

            'especialidade' =>
                $this->input->post(
                    'especialidade',
                    TRUE
                ),

            'telefone' =>
                preg_replace(
                    '/[^0-9]/',
                    '',
                    $this->input->post(
                        'telefone',
                        TRUE
                    )
                ),

            'email' =>
                $this->input->post(
                    'email',
                    TRUE
                )
        );


        //////////////////////////////
        // VERIFICA CPF
        //////////////////////////////

        if (
            $this->Medico_model->campo_existe(
                'cpf',
                $dados['cpf']
            )
        ) {

            $view['medico'] = null;
            $view['erro'] = 'CPF já cadastrado.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // VERIFICA CRM
        //////////////////////////////

        if (
            $this->Medico_model->campo_existe(
                'crm',
                $dados['crm']
            )
        ) {

            $view['medico'] = null;
            $view['erro'] = 'CRM já cadastrado.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // VERIFICA TELEFONE
        //////////////////////////////

        if (
            $this->Medico_model->campo_existe(
                'telefone',
                $dados['telefone']
            )
        ) {

            $view['medico'] = null;
            $view['erro'] = 'Telefone já cadastrado.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // VERIFICA E-MAIL
        //////////////////////////////

        if (
            !empty($dados['email']) &&
            $this->Medico_model->campo_existe(
                'email',
                $dados['email']
            )
        ) {

            $view['medico'] = null;
            $view['erro'] = 'E-mail já cadastrado.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // CADASTRA
        //////////////////////////////

        $id = $this->Medico_model->inserir(
            $dados
        );


        //////////////////////////////
        // AUDITORIA
        //////////////////////////////

        $this->Auditoria_model->registrar(
            'criar',
            $id,
            null,
            $dados
        );


        $this->session->set_flashdata(
            'sucesso',
            'Médico cadastrado com sucesso!'
        );


        redirect('medicos');
    }


    ///////////////////////////
    // EDITAR MÉDICO
    ///////////////////////////

    public function editar($id)
    {
        $medico =
            $this->Medico_model->buscar($id);

        if (!$medico) {
            show_404();
        }

        $dados['medico'] = $medico;
        $dados['erro'] = '';

        $this->load->view(
            'medicos/formulario',
            $dados
        );
    }


    ///////////////////////////
    // ATUALIZAR MÉDICO
    ///////////////////////////

    public function atualizar($id)
    {
        $medico_antigo =
            $this->Medico_model->buscar($id);

        if (!$medico_antigo) {
            show_404();
        }


        $this->validar_formulario();


        if ($this->form_validation->run() == FALSE) {

            $dados['medico'] =
                $medico_antigo;

            $dados['erro'] = '';

            $this->load->view(
                'medicos/formulario',
                $dados
            );

            return;
        }


        $dados = array(
            'nome_completo' =>
                $this->input->post(
                    'nome_completo',
                    TRUE
                ),

            'cpf' =>
                preg_replace(
                    '/[^0-9]/',
                    '',
                    $this->input->post(
                        'cpf',
                        TRUE
                    )
                ),

            'crm' =>
                $this->input->post(
                    'crm',
                    TRUE
                ),

            'especialidade' =>
                $this->input->post(
                    'especialidade',
                    TRUE
                ),

            'telefone' =>
                preg_replace(
                    '/[^0-9]/',
                    '',
                    $this->input->post(
                        'telefone',
                        TRUE
                    )
                ),

            'email' =>
                $this->input->post(
                    'email',
                    TRUE
                )
        );


        //////////////////////////////
        // CPF DUPLICADO
        //////////////////////////////

        if (
            $this->Medico_model->campo_existe(
                'cpf',
                $dados['cpf'],
                $id
            )
        ) {

            $view['medico'] =
                $medico_antigo;

            $view['erro'] =
                'CPF já cadastrado para outro médico.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // CRM DUPLICADO
        //////////////////////////////

        if (
            $this->Medico_model->campo_existe(
                'crm',
                $dados['crm'],
                $id
            )
        ) {

            $view['medico'] =
                $medico_antigo;

            $view['erro'] =
                'CRM já cadastrado para outro médico.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // TELEFONE DUPLICADO
        //////////////////////////////

        if (
            $this->Medico_model->campo_existe(
                'telefone',
                $dados['telefone'],
                $id
            )
        ) {

            $view['medico'] =
                $medico_antigo;

            $view['erro'] =
                'Telefone já cadastrado para outro médico.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // E-MAIL DUPLICADO
        //////////////////////////////

        if (
            !empty($dados['email']) &&
            $this->Medico_model->campo_existe(
                'email',
                $dados['email'],
                $id
            )
        ) {

            $view['medico'] =
                $medico_antigo;

            $view['erro'] =
                'E-mail já cadastrado para outro médico.';

            $this->load->view(
                'medicos/formulario',
                $view
            );

            return;
        }


        //////////////////////////////
        // ATUALIZA
        //////////////////////////////

        $this->Medico_model->atualizar(
            $id,
            $dados
        );


        //////////////////////////////
        // AUDITORIA
        //////////////////////////////

        $this->Auditoria_model->registrar(
            'editar',
            $id,
            $medico_antigo,
            $dados
        );


        $this->session->set_flashdata(
            'sucesso',
            'Médico atualizado com sucesso!'
        );


        redirect('medicos');
    }


    ///////////////////////////
    // EXCLUIR MÉDICO
    ///////////////////////////

    public function excluir($id)
    {
        $medico =
            $this->Medico_model->buscar($id);

        if (!$medico) {
            show_404();
        }


        // Registra antes de excluir
        $this->Auditoria_model->registrar(
            'excluir',
            $id,
            $medico,
            null
        );


        // Exclui
        $this->Medico_model->excluir($id);


        $this->session->set_flashdata(
            'sucesso',
            'Médico excluído com sucesso!'
        );


        redirect('medicos');
    }


    ///////////////////////////
    // VALIDAÇÃO
    ///////////////////////////

    private function validar_formulario()
    {

        // NOME COMPLETO
        $this->form_validation->set_rules(
            'nome_completo',
            'Nome completo',
            'required|min_length[3]|max_length[100]',
            array(
                'required' =>
                    'O campo Nome completo é obrigatório.',

                'min_length' =>
                    'O Nome completo deve ter pelo menos 3 caracteres.',

                'max_length' =>
                    'O Nome completo deve ter no máximo 100 caracteres.'
            )
        );


        // CPF
        $this->form_validation->set_rules(
            'cpf',
            'CPF',
            'required|callback_validar_cpf',
            array(
                'required' =>
                    'O campo CPF é obrigatório.',

                'validar_cpf' =>
                    'Digite um CPF válido.'
            )
        );


        // CRM
        $this->form_validation->set_rules(
            'crm',
            'CRM',
            'required|numeric|max_length[20]',
            array(
                'required' =>
                    'O campo CRM é obrigatório.',

                'numeric' =>
                    'O CRM deve conter apenas números.',

                'max_length' =>
                    'O CRM deve ter no máximo 20 caracteres.'
            )
        );


        // ESPECIALIDADE
        $this->form_validation->set_rules(
            'especialidade',
            'Especialidade',
            'required|min_length[3]|max_length[100]',
            array(
                'required' =>
                    'O campo Especialidade é obrigatório.',

                'min_length' =>
                    'A Especialidade deve ter pelo menos 3 caracteres.',

                'max_length' =>
                    'A Especialidade deve ter no máximo 100 caracteres.'
            )
        );


        // TELEFONE
        $this->form_validation->set_rules(
            'telefone',
            'Telefone',
            'required|callback_validar_telefone',
            array(
                'required' =>
                    'O campo Telefone é obrigatório.',

                'validar_telefone' =>
                    'O Telefone deve ter exatamente 11 números.'
            )
        );


        // E-MAIL
        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'required|valid_email|max_length[100]',
            array(
                'required' =>
                    'O campo E-mail é obrigatório.',

                'valid_email' =>
                    'Digite um E-mail válido.',

                'max_length' =>
                    'O E-mail deve ter no máximo 100 caracteres.'
            )
        );
    }


    ///////////////////////////
    // VALIDA CPF
    ///////////////////////////

    public function validar_cpf($cpf)
    {
        $cpf = preg_replace(
            '/[^0-9]/',
            '',
            $cpf
        );


        if (strlen($cpf) != 11) {
            return FALSE;
        }


        // Impede números iguais
        if (
            preg_match(
                '/^(\d)\1{10}$/',
                $cpf
            )
        ) {
            return FALSE;
        }


        // Primeiro dígito
        $soma = 0;

        for ($i = 0; $i < 9; $i++) {

            $soma +=
                $cpf[$i] *
                (10 - $i);
        }


        $resto = $soma % 11;


        if ($resto < 2) {
            $digito1 = 0;
        } else {
            $digito1 = 11 - $resto;
        }


        if ($cpf[9] != $digito1) {
            return FALSE;
        }


        // Segundo dígito
        $soma = 0;

        for ($i = 0; $i < 10; $i++) {

            $soma +=
                $cpf[$i] *
                (11 - $i);
        }


        $resto = $soma % 11;


        if ($resto < 2) {
            $digito2 = 0;
        } else {
            $digito2 = 11 - $resto;
        }


        if ($cpf[10] != $digito2) {
            return FALSE;
        }


        return TRUE;
    }


    ///////////////////////////
    // VALIDA TELEFONE
    ///////////////////////////

    public function validar_telefone($telefone)
    {
        $telefone = preg_replace(
            '/[^0-9]/',
            '',
            $telefone
        );


        // Telefone com DDD
        // Deve possuir 11 números
        if (strlen($telefone) != 11) {
            return FALSE;
        }


        return TRUE;
    }
}