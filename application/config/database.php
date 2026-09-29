<?php
defined('BASEPATH') OR exit('No direct script access allowed');


//Conexão do Postgresql com o Dbeaver
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'port'     => 5432,
    'username' => 'postgres',
    'password' => 'postgresqldataina5',
    'database' => 'cadastro_medicos',
    'dbdriver' => 'postgre',  
    'db_debug' => TRUE,
    'char_set' => 'utf8',
);

$active_group = 'default';
$query_builder = TRUE;

