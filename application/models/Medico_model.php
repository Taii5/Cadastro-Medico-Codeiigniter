<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medico_model extends CI_Model
{
    // Lista todos os médicos
    // Também permite pesquisar por nome ou CRM
    //Converssa diretamente com a tabela 'medicos'
    public function listar($busca = '')
    {
        if ($busca != '') {
            $this->db->group_start();
            $this->db->like('nome_completo', $busca);
            $this->db->or_like('crm', $busca);
            $this->db->group_end();
        }

        $this->db->order_by('nome_completo', 'ASC'); //ORDEM DE NOMES DE A-Z

        return $this->db->get('medicos')->result();
    }

    // Busca um médico pelo ID
  public function buscar($id)
{
    return $this->db
        ->where('id', $id)
        ->get('medicos')
        ->row();
}

    // Insere
    public function inserir($dados)
    {
        $this->db->insert('medicos', $dados);  //INSERINDO DADOS NO BANCO

        return $this->db->insert_id();
    }

    // Atualiza
    public function atualizar($id, $dados)
    {
        $this->db->where('id', $id);         //ATUALIZANDO DADOS NNO BANCO

        return $this->db->update('medicos', $dados);
    }

    // Exclui
public function excluir($id)
{ 
    $this->db->where('id', $id);           //EXCLUINDO DADOS NO BANCO

    return $this->db->delete('medicos');
}

    // Verifica se o CRM já existe
    public function crm_existe($crm, $id = null)
    {
        $this->db->where('crm', $crm);

        // Na edição, ignora o próprio médico
        if ($id !== null) {
            $this->db->where('id !=', $id);
        }

        return $this->db
            ->get('medicos')
            ->num_rows() > 0;
    }
}