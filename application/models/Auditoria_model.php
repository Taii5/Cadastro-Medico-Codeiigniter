<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auditoria_model extends CI_Model
{
    // Registra a ação realizada no médico
    public function registrar($acao, $medico_id, $antes, $depois)
    {
        $dados = array(
            'acao' => $acao,
            'medico_id' => $medico_id,
            'data_hora' => date('Y-m-d H:i:s'),
            'dados_antes' => $antes
                ? json_encode($antes, JSON_UNESCAPED_UNICODE)
                : null,
            'dados_depois' => $depois
                ? json_encode($depois, JSON_UNESCAPED_UNICODE)
                : null
        );

        return $this->db->insert(
            'auditoria_medicos',
            $dados
        );
    }

    // Lista o histórico das alterações
    public function listar()
    {
        $this->db->select(
            'auditoria_medicos.*, medicos.nome_completo'
        );

        $this->db->from('auditoria_medicos');

        $this->db->join(
            'medicos',
            'medicos.id = auditoria_medicos.medico_id',
            'left'
        );

        $this->db->order_by(
            'auditoria_medicos.data_hora',
            'DESC'
        );

        return $this->db->get()->result();
    }
}