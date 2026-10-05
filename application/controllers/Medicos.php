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
    $this->load->helper('url');
}

    // Lista os médicos
    public function index()
    {
        $busca = trim($this->input->get('busca', TRUE));//Pega o que foi digitado no campo de busca pelp parâmetro 'GET'(trim(): mesmo se o nome for escrito pela metade)

        $dados['medicos'] = $this->Medico_model->listar($busca); //Chama o método 'listar($busca)', relação com a variável 'buscar' do arquivo 'Medico_model' e a tabela 'medicos' do banco de dados
        $dados['busca'] = $busca;//Guarda o texto pesquisado dentro do array '$dados'

        $this->load->view('medicos/listagem', $dados);//Carrega a view e envia os dados para o arquivo onde contém a listagem.
    }

   ///////////////////////////
   //PROCESSO DE CADASTRAMENTO
   ///////////////////////////

    // Abre o formulário para cadastrar
    public function novo()
    {
        $dados['medico'] = null;//Como ainda não existe médico cadastrado, seu valor inicial é 'Null'(observados na tabela medico)
        $dados['erro'] = '';//Variável para mensagem de erro.

        $this->load->view('medicos/formulario', $dados);//Carrega a view e envia os dados para o arquivo onde contém o formulário.
    }

    // Salva um novo médico
    //Executado quando o formulário de cadastro é executado

 public function salvar()
{
    $this->validar_formulario();

        if ($this->form_validation->run() == FALSE) {
            $this->novo();

            return;
        }
        
        //Array com os dados que serão enviados pelo formulário de cadastro
        $dados = array(
            'nome_completo' => $this->input->post('nome_completo', TRUE),
            'cpf' => preg_replace('/[^0-9]/', '', $this->input->post('cpf', TRUE)),
            'crm' => $this->input->post('crm', TRUE),
            'especialidade' => $this->input->post('especialidade', TRUE),
            'telefone' => preg_replace('/[^0-9]/', '', $this->input->post('telefone', TRUE)),
            'email' => $this->input->post('email', TRUE)
        );
        // DADO ESPECÍFICO: Verifica se o CRM já existe
        if ($this->Medico_model->crm_existe($dados['crm'])) {//CONDIÇÃO PARA SABER SE EXISTE NO BANCO

            $view['medico'] = null;//Prepara os dados (tabela medicos) para mostrar o formulário novamente.
            $view['erro'] = 'CRM já cadastrado.';

            $this->load->view('medicos/formulario', $view);
            return;
        }

        // Cadastra o médico (Medico_model)
        $id = $this->Medico_model->inserir($dados);

        // Registra a auditoria (Auditoria_model)
        $this->Auditoria_model->registrar(
            'criar',
            $id,       //INFORMA O MÉDICO CRIADO
            null,      //DADOS DE CADASTRO NULO (ANTES)
            $dados     //DADOS DEPOIS DO ADASTRO DO MEDICO
        );

        $this->session->set_flashdata(       //lINHA: mensagem temporária
            'sucesso',                       //Nome da mensagem
            'Médico cadastrado com sucesso!' //Mensagem que vai aparecer
        );

        redirect('medicos'); 
    }
    ////////////////
    //EDITAR MEDICO
    ////////////////

    // Abre o formulário para editar
    public function editar($id)
    {
        $medico = $this->Medico_model->buscar($id);//Proucura o id do medico 
        
        //Caso o id do medico não for encontrado
        if (!$medico) {
            show_404();
        }

        $dados['medico'] = $medico;//coloca os dados do '$medico' encontrado detro de '$dados'
        $dados['erro'] = '';

        $this->load->view('medicos/formulario', $dados);
    }

    // Atualiza um médico
    public function atualizar($id)
    {
        $medico_antigo = $this->Medico_model->buscar($id); //Antes de modificar o medico antigo busca os dados atuais

        if (!$medico_antigo) {
            show_404();
        }
    $this->validar_formulario();

        if ($this->form_validation->run() == FALSE) {
        $this->editar($id);
        return;
        }

        $dados = array(
            'nome_completo' => $this->input->post('nome_completo', TRUE),
            'cpf' => preg_replace('/[^0-9]/', '', $this->input->post('cpf', TRUE)),
            'crm' => $this->input->post('crm', TRUE),
            'especialidade' => $this->input->post('especialidade', TRUE),
            'telefone' => preg_replace('/[^0-9]/', '', $this->input->post('telefone', TRUE)),
            'email' => $this->input->post('email', TRUE)
        );

        // Verifica se o CRM já pertence a outro médico
        if ($this->Medico_model->crm_existe($dados['crm'], $id)) {

            $view['medico'] = $medico_antigo;
            $view['erro'] = 'CRM já cadastrado para outro médico.';

            $this->load->view('medicos/formulario', $view);
            return;
        }

        // Atualiza
        $this->Medico_model->atualizar($id, $dados);

        // Registra o antes e o depois
        $this->Auditoria_model->registrar(
            'editar',
            $id,               //INFORMA QUAL MEDICO FOI ALTERADO
            $medico_antigo,    //DADOS ANTES DA ALTERAÇÃO 
            $dados             //DADOS DEPOIS DA ALTERAÇÃO
        );

        $this->session->set_flashdata(
            'sucesso',
            'Médico atualizado com sucesso!'
        );

        redirect('medicos'); //redireciona para a tabela atualizada 
    }

    //////////////////////
    //PROCESSO DE EXCLUIR
    //////////////////////
    // Exclui um médico
    public function excluir($id)
{
    $medico = $this->Medico_model->buscar($id);//Busca o medico que vai ser excluido

    if (!$medico) {
        show_404();
    }

    // Registra a exclusão antes de apagar
    $this->Auditoria_model->registrar(
        'excluir',
        $id,
        $medico,
        null
    );

    // Exclui o médico
    $this->Medico_model->excluir($id);

    $this->session->set_flashdata(
        'sucesso',
        'Médico excluído com sucesso!'
    );

    redirect('medicos');
}

    /////////////////////////
    //VALIDAÇÃO DO FORMULÁRIO
    /////////////////////////

    // Regras de validação
private function validar_formulario()
{
    // NOME COMPLETO
    $this->form_validation->set_rules(
        'nome_completo',
        'Nome completo',
        'required|min_length[3]|max_length[100]',
        array(
            'required' => 'O campo Nome completo é obrigatório.',
            'min_length' => 'O Nome completo deve ter pelo menos 3 caracteres.',
            'max_length' => 'O Nome completo deve ter no máximo 100 caracteres.'
        )
    );

   
 // CPF
$this->form_validation->set_rules(
    'cpf',
    'CPF',
    'required|callback_validar_cpf',
    array(
        'required' => 'O campo CPF é obrigatório.',
        'validar_cpf' => 'Digite um CPF válido.'
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
            'max_length' => 'O CRM deve ter no máximo 20 caracteres.'
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
            'max_length' => 'A Especialidade deve ter no máximo 100 caracteres.'
        )
    );

    
   // TELEFONE
$this->form_validation->set_rules(
    'telefone',
    'Telefone',
    'required|callback_validar_telefone',
    array(
        'required' => 'O campo Telefone é obrigatório.',
        'validar_telefone' => 'O Telefone deve ter exatamente 11 números.'
    )
);

    // E-MAIL
    $this->form_validation->set_rules(
        'email',
        'E-mail',
        'required|valid_email|max_length[100]',
    array(
        'required' => 'O campo E-mail é obrigatório.',
        'valid_email' => 'Digite um endereço de e-mail',
        'max_length' => 'O E-mail deve ter no máximo 100 caracteres.'
    )
);
}

// Validação do CPF
public function validar_cpf($cpf)
{
    // Remove pontos, traços e outros caracteres
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se possui exatamente 11 números
    if (strlen($cpf) != 11) {
        return FALSE;
    }

    // Impede CPFs com todos os números iguais
    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return FALSE;
    }

    // Cálculo do primeiro dígito
    $soma = 0;

    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }

    $resto = $soma % 11;

    if ($resto < 2) {
        $digito1 = 0;
    } else {
        $digito1 = 11 - $resto;
    }

    // Confere o primeiro dígito
    if ($cpf[9] != $digito1) {
        return FALSE;
    }

    // Cálculo do segundo dígito
    $soma = 0;

    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }

    $resto = $soma % 11;

    if ($resto < 2) {
        $digito2 = 0;
    } else {
        $digito2 = 11 - $resto;
    }

    // Confere o segundo dígito
    if ($cpf[10] != $digito2) {
        return FALSE;
    }

    return TRUE;
}

// Validação do telefone
public function validar_telefone($telefone)
{
    // Remove máscara: espaços, parênteses, hífen etc.
    $telefone = preg_replace('/[^0-9]/', '', $telefone);

    // Telefone brasileiro com DDD = 11 números
    if (strlen($telefone) != 11) {
        return FALSE;
    }

    return TRUE;
}

}


