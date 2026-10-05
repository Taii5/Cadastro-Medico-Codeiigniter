<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
    public function cadastrar($dados)
    {
        return $this->db->insert('usuarios', $dados);
    }

    public function buscar_por_email($email)
    {
        return $this->db
            ->where('email', $email)
            ->get('usuarios')
            ->row();
    }
}