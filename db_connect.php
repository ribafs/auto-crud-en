<?php
$host = '127.0.0.1';
/*
$db   = 'register';
$user = 'postgres';
$pass = 'postgres';
$sgbd='pgsql';      // pgsql, mysql
$table='customers';
*/
$db   = 'register';
$user = 'root';
$pass = '';
$sgbd='mysql';      // pgsql, mysql
$table='customers';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
];

try {
    $pdo = new PDO("$sgbd:host=$host;dbname=$db;", $user, $pass, $opt);

    // echo 'Conectado para o banco de dados<br />';

    // Fechar conexão com o banco de dados
    // $pdo = null;
}catch(PDOException $e){
    echo '<br><br><b>Message</b>: '. $e->getMessage().'<br>';// Usar estas linhas no catch apenas em ambiente de testes/desenvolvimento
    echo '<b>File</b>: '.$e->getFile().'<br>';
    echo '<b>Line</b>: '.$e->getLine().'<br>';
}

