<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medico_model extends CI_Model
{
    // Lista todos os médicos
    // Também permite pesquisar por nome ou CRM
    public function listar($busca = '')
    {
        if ($busca != '') {

            $this->db->group_start();

            // Pesquisa por qualquer parte do nome
            $this->db->where(
                "nome_completo ILIKE '%" .
                $this->db->escape_like_str($busca) .
                "%'",
                NULL,
                FALSE
            );

            // Pesquisa por qualquer parte do CRM
            $this->db->or_where(
                "crm::text ILIKE '%" .
                $this->db->escape_like_str($busca) .
                "%'",
                NULL,
                FALSE
            );

            $this->db->group_end();
        }

        // Ordem alfabética
        $this->db->order_by('nome_completo', 'ASC');

        return $this->db
            ->get('medicos')
            ->result();
    }


    // Busca um médico pelo ID
    public function buscar($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('medicos')
            ->row();
    }


    // Insere um médico
    public function inserir($dados)
    {
        $this->db->insert('medicos', $dados);

        return $this->db->insert_id();
    }


    // Atualiza um médico
    public function atualizar($id, $dados)
    {
        $this->db->where('id', $id);

        return $this->db->update('medicos', $dados);
    }


    // Exclui um médico
    public function excluir($id)
    {
        $this->db->where('id', $id);

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


    // Verifica se qualquer campo já existe
  public function campo_existe($campo, $valor, $id = null)
{
    $this->db->where($campo, $valor);

    if ($id !== null) {
        $this->db->where('id !=', $id);
    }

    return $this->db
        ->get('medicos')
        ->num_rows() > 0;
}
}