# PHP-MYSQL_Database_Connection
-------------------------------Para la conexion-------------------------------
```
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
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
```

-------------------------------Para consultar los datos-------------------------------

En PHP: 
```
include_once "conexion.php";
$sql_leer = "SELECT * FROM colores"; //consulta
$gsent = $pdo->prepare($sql_leer);
$gsent->execute();
$resultado = $gsent->fetchAll(); //obtener un array 
//var_dump($resultado); //mostrar el array

```

En HTML: 
```
  <?php
  foreach ($resultado as $dato) : //repetir el div por el numero de elemento en nuestra bd
  ?>
      <div class="alert alert-<?php
                              echo $dato["color"];
                              ?> text-uppercase" role="alert">
          <?php
          echo $dato["color"]; ?>
          -
          <?php
          echo $dato["descripcion"];
          ?>
      </div>
  <?php
  endforeach
  ?>
</div>
```
------------------------------- Para ingresar un nuevo campo a la base de datos: -------------------------------

En en formulario html:

```
<div class="col-md-6 text-center">
      <h2>Agregar Elementos</h2>
      <form method="POST">
          <input type="text" class="form-control" name="color">
          <!--campo name es necesario para que lo reciba POST-->
          <input type="text" class="form-control mt-3" name="descripcion">
          <button class="btn btn-primary mt-3 align-self-center">Agregar</button>
      </form>
</div>
```

En php: 

```
if ($_POST) {
    /*recibir los datos*/
    $color = $_POST["color"];
    $descripcion = $_POST["descripcion"];

    /*enviarlos a la base de datos*/
    $sql_agregar = "INSERT INTO colores (color, descripcion) VALUES (?,?)"; //signos de interrogacion por seguridad
    $sentencia_agregar = $pdo->prepare($sql_agregar);
    $sentencia_agregar->execute(array($color, $descripcion)); //en el array van el el mismo orden que irian en los signos de interrogracion 

    header("location:index.php");//recargar la pagina cuando se envien los datos 
}
```


------------------------------- Para editar un campo: -------------------------------

En Editar.php: 
```
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

```

En index.php:

```
if ($_GET) {
    $id = $_GET["id"];
    $sql_unico = "SELECT * FROM colores WHERE id=?"; //consulta por id
    $gsent_unico = $pdo->prepare($sql_unico);
    $gsent_unico->execute(array($id));
    $resultado_unico = $gsent_unico->fetch(); //obtener un array 
    //var_dump($resultado_unico);
}
```

En Html:

1. Agregar un icono de editar de font-awesome a la parte donde se muestran los datos dentro del foreach: 

 ```
<a href="index.php?id=<?php echo $dato["id"]; ?>" class="float-end"><i class="fas fa-edit"></i></a>
```

2. Encerrar el formulario de crear nuevo dato dentro de un if !Get de la sig manera:

 ```
<?php if (!$_GET) : //MOSTRAR EL SIG FORMULARIO CUANDO NO HAIGA METODO GET (CUANDO NO SE HALLA DADO CLIC EN EDITAR) 
                ?>
                    <h2>Agregar Elementos</h2>
                    <form method="POST">
                        <input type="text" class="form-control" name="color">
                        <!--campo name es necesario para que lo reciba POST-->
                        <input type="text" class="form-control mt-3" name="descripcion">
                        <button class="btn btn-primary mt-3 align-self-center">Agregar</button>
                    </form>
                <?php endif ?>
```
3. crear un nuevo formulario igual al anterior con un if get: 

Nota: tambien es este formulario se agrega en input hidden que es el que lleva el id para php
 ```
<?php if ($_GET) : //MOSTRAR EL SIG FORMULARIO CUANDO SI HAIGA METODO GET (CUANDO SE QUIERA EDITAR) 
                ?>
                    <h2>Editar Elementos</h2>
                    <form method="GET" action="editar.php">
                        <input type="text" class="form-control" name="color" value="<?php echo $resultado_unico["color"] ?>">
                        <!--campo name es necesario para que lo reciba POST-->
                        <input type="text" class="form-control mt-3" name="descripcion" value="<?php echo $resultado_unico["descripcion"] ?>">
                        <input type="hidden" value="<?php echo $resultado_unico["id"] ?>" name="id">
                        <button class="btn btn-primary mt-3 align-self-center">Agregar</button>
                    </form>
                <?php endif ?>
```

------------------------------- Para las eliminaciones: -------------------------------
1. Crear el boton de eliminar con un icono de fontawesome arriba del de editar:
```
<a href="eliminar.php?id=<?php echo $dato["id"]; ?>" class="float-end mx-3"><i class="fas fa-trash"></i></a>
```
2. crear eliminar.php con el sig codigo: 
```
<?php
include_once "conexion.php";
$id = $_GET["id"];
$sql_eliminar = "DELETE FROM colores WHERE id=?";
$sentencia_eliminar = $pdo->prepare($sql_eliminar);
$sentencia_eliminar->execute(array($id));


header("location:index.php");
```
