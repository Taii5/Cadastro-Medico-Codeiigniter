<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicos extends CI_Controller
{
    public function __construct()
{
    parent::__construct();

    if (!$this->session->userdata('logado')) {
        redirect('auth');
    }

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
        $this->validar_formulario();//Método que contém as validações 

        //Caso o form_validation correr 'falso':
        if ($this->form_validation->run() == FALSE) {
            $dados['medico'] = null;//Indica que o formulário continua sendo de cadastro
            $dados['erro'] = '';//Mensagem de erro

            $this->load->view('medicos/formulario', $dados);//Carrega novamente para o formulário
            return;//Se a validação falhar, o programa não deve continuar tentando cadastrar.
        }
        
        //Array com os dados que serão enviados pelo formulário de cadastro
        $dados = array(
            'nome_completo' => $this->input->post('nome_completo', TRUE),
            'crm' => $this->input->post('crm', TRUE),
            'especialidade' => $this->input->post('especialidade', TRUE),
            'telefone' => $this->input->post('telefone', TRUE),
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
            $dados['medico'] = $medico_antigo;
            $dados['erro'] = '';

            $this->load->view('medicos/formulario', $dados);
            return;
        }

        $dados = array(
            'nome_completo' => $this->input->post('nome_completo', TRUE),
            'crm' => $this->input->post('crm', TRUE),
            'especialidade' => $this->input->post('especialidade', TRUE),
            'telefone' => $this->input->post('telefone', TRUE),
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
    $this->form_validation->set_rules(
        'nome_completo',
        'Nome completo',
        'required'
    );

    $this->form_validation->set_rules(
        'crm',
        'CRM',
        'required'
    );

    $this->form_validation->set_rules(
        'especialidade',
        'Especialidade',
        'required'
    );

    $this->form_validation->set_rules(
        'telefone',
        'Telefone',
        'required'
    );

    $this->form_validation->set_rules(
        'email',
        'E-mail',
        'required|valid_email'
    );

    $this->form_validation->set_message(
        'required',
        'O campo {field} é obrigatório.'
    );

    $this->form_validation->set_message(
        'valid_email',
        'Digite um endereço de e-mail válido.'
    );
}

}

