<?php
session_start();
///////////////////////////////////////////////////////////////////LOGIN con DB
if ($_POST) {
    include("config/db.php");
    $usuario = ($_POST['usuario']);
    $contrasenia = ($_POST['contrasenia']);

    //cotejar los datos una vez conectado a la db
    $sentencia = $conexion->prepare("SELECT * FROM `usuarios` WHERE usuario=:usuario AND password=:password");
    //PARAM_STR-> recibir datos en string
    $sentencia->bindParam("usuario", $usuario, PDO::PARAM_STR);
    $sentencia->bindParam("password", $contrasenia, PDO::PARAM_STR);
    $sentencia->execute();

    //Contabiliza numero de registros, devuelve la información encontrada.
    $numeroRegistros = $sentencia->rowCount();

    if ($numeroRegistros >= 1) {
        $_SESSION['usuario'] = "ok";
        $_SESSION['nombreUsuario'] = $usuario;
        header('Location:inicio.php');
    } else {
        $mensaje = "<script>alert('Usuario o contraseña incorrecta');</script>";
    }
/////////////////////////////////////////////////////////////////LOGIN sin DB
    /*if (($_POST['usuario'] == "oscar") && ($_POST['contrasenia'] == "1234")) {

        $_SESSION['usuario'] = "ok";
        $_SESSION['nombreUsuario'] = "Oscar";
        header('Location:inicio.php');
    } else {
        $mensaje = "Error: El usuario o contraseña son incorrectos";
    }*/
}

?>

<!doctype html>
<html lang="es">

<head>
    <title>Administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./css/bootstrap.min5.css">
</head>

<style>
    h4 {
        text-align: center;
    }
</style>

<body><br>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <br><br><br>
                <div class="card">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">

                        <?php if (isset($mensaje)) { ?>
                            <!-- <div class="alert alert-danger" role="alert"> -->
                                <?php echo $mensaje; ?>
                            <!-- </div> -->
                        <?php } ?>

                        <form method="POST">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Constraseña:</label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                            </div>
                            <br>
                            <div class="d-grid gap-2 col-3 mx-auto">
                                <button type="submit" class="btn btn-dark">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>



</body>

</html>