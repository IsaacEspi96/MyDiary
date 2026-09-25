<?php

require($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/../', 'MyDiary.env');
$dotenv->load();

function conexionBD()
{
    try {
        $servidor = 'mysql:host=' . $_ENV['bDatosServer'] . ';dbname=' . $_ENV['bDatos'];
        $user = $_ENV['bDatosUser'];
        $password = $_ENV['bDatosPass'];
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        $pdo = new PDO($servidor, $user, $password, $options);
    } catch (PDOException $e) {
        $resultado = ['error' => 'Error Temporal: No se puede conectar con la base de datos.'];
        return $resultado;
    }

    return $pdo;
}
