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
