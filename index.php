<?php
/*----------------------------------MOSTRAR LOS ELEMENTOS (CONSULTA)--------------------------------------*/
include_once "conexion.php";
$sql_leer = "SELECT * FROM colores"; //consulta
$gsent = $pdo->prepare($sql_leer);
$gsent->execute();
$resultado = $gsent->fetchAll(); //obtener un array 
//var_dump($resultado); //mostrar el array


/*----------------------------------AGREGAR NUEVO ELEMENTO--------------------------------------*/
if ($_POST) {
    /*recibir los datos*/
    $color = $_POST["color"];
    $descripcion = $_POST["descripcion"];

    /*enviarlos a la base de datos*/
    $sql_agregar = "INSERT INTO colores (color, descripcion) VALUES (?,?)"; //signos de interrogacion por seguridad
    $sentencia_agregar = $pdo->prepare($sql_agregar);
    $sentencia_agregar->execute(array($color, $descripcion)); //en el array van el el mismo orden que irian en los signos de interrogracion 

    /*cerrar la conexion de agregar:*/
    $sentencia_agregar = null;
    $pdo = null;
    header("location:index.php"); //recargar la pagina cuando se envien los datos 
}


/*----------------------------------EDITAR ELEMENTO--------------------------------------*/
if ($_GET) {
    $id = $_GET["id"];
    $sql_unico = "SELECT * FROM colores WHERE id=?"; //consulta por id
    $gsent_unico = $pdo->prepare($sql_unico);
    $gsent_unico->execute(array($id));
    $resultado_unico = $gsent_unico->fetch(); //obtener un array 
    //var_dump($resultado_unico);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!--CONSULTA-->
            <div class="col-md-6">
                <?php foreach ($resultado as $dato) : //repetir el div por el numero de elemento en nuestra bd
                ?>
                    <div class="alerta alert alert-<?php echo $dato["color"]; ?> text-uppercase text-start" role="alert">
                        <?php echo $dato["color"]; ?> -
                        <?php
                        echo $dato["descripcion"];
                        ?>
                        <a href="eliminar.php?id=<?php echo $dato["id"]; ?>" class="float-end ms-3"><i class="fas fa-trash"></i></a>
                        <a href="index.php?id=<?php echo $dato["id"]; ?>" class="float-end"><i class="fas fa-edit"></i></a>


                    </div>
                <?php endforeach ?>
            </div>
            <!--********************************************************************FORMULARIO AGREGAR NUEVO************************************************************-->
            <div class="col-md-6 text-center">
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

                <!--********************************************************************FORMULARIO EDITAR************************************************************-->
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
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/4eba38762e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>

</html>

<?php
/*cerrar la conexion de la consulta*/
$pdo = null;
$gsent = null;
?>