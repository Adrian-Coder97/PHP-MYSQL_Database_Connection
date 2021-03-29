<?php

/*echo "editar.php?id=1&color=success&descripcion=este es un color verde";
echo "<br>";*/
$id = $_GET["id"];
$color = $_GET["color"];
$descripcion = $_GET["descripcion"];
/*echo $id;
echo "<br>";
echo $color;
echo "<br>";
echo $descripcion;
echo "<br>";*/


include_once "conexion.php";

$sql_editar = "UPDATE colores SET color=?,descripcion=? WHERE id=?"; //los ? son por seguridad
$sentencia_editar = $pdo->prepare($sql_editar);
$sentencia_editar->execute(array($color, $descripcion, $id));//los campos deben corresponder a los simbolos de ?

header("location:index.php");//para que recargue la pagina de index y no nos mande a editar.php