<?php
//ACCESO DE USUARIO
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location:../index.php");
} else {
    if ($_SESSION['usuario'] == "ok") {
        $nombreUsuario = $_SESSION["nombreUsuario"];
    }
}
?>

<!doctype html>
<html lang="es">

<head>
    <title>Administrador</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min5.css">
</head>

<body>

    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/programacionWeb/proyecto"; ?>
    <nav class="navbar navbar-expand navbar-dark bg-primary">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active"><h5>Administrador</h5></a>
            <a class="nav-item nav-link" href="/proyecto/administrador/inicio">Inicio</a>
            <a class="nav-item nav-link" href="/proyecto/administrador/seccion/productos">Libros</a>
            <a class="nav-item nav-link" href="/proyecto/administrador/seccion/cursos">Cursos</a>
            <a class="nav-item nav-link" href="/proyecto/administrador/seccion/certificados">Certificados</a>
            <a class="nav-item nav-link" href="/proyecto/administrador/seccion/tutoriales">Tutoriales</a>
            <a class="nav-item nav-link" href="/proyecto/administrador/seccion/cerrar">Cerrar</a>
            <a class="nav-item nav-link" href="/proyecto/index" target="_blank">Sitio web</a>
        </div>
    </nav>

    <div class="container"><br>
        <div class="row">