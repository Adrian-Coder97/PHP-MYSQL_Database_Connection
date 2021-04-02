<?php
$link = "mysql:host=localhost;dbname=yt_colores";
$usuario = "root";
$pass = "";

try {
    $pdo = new PDO($link, $usuario, $pass);
    //echo "CONECTADO A LA BASE DE DATOS";
    /*foreach ($pdo->query('SELECT * FROM `colores`') as $row) {
        print_r($row);
    }*/
    echo "CONECTADO <br>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
