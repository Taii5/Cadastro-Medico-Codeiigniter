<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function verificar_login($email, $senha)
    {
        $this->db->where('email', $email);
        $this->db->where('senha', md5($senha));

        return $this->db
            ->get('usuarios')
            ->row();
    }
}

