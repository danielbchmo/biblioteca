<?php include("template/cabecera.php"); ?>
<?php 
include('administrador/config/db.php');


if($_POST){
    if($_POST['buscar']){
    $busqueda = $_POST['busqueda'];
    $consulta = $conexion->prepare("SELECT * FROM (certificados, libros, tutoriales) WHERE (nombre,nombre,nombre) LIKE '%$busqueda%'");
    while($row = $consulta->fetchAll(PDO::FETCH_ASSOC)){
        echo $row."<br>";
    }   
}
}
?>
<div class="p-5  text-center">
    <div class="container">
        <h1 class="display-3">Aprende a Codificar</h1>
        <p class="lead">Podra consultar libros, tutoriales y certificaciones relacionados a programación.</p>
        <hr class="my-2">
   
        <!-- <img width="400" src="img2/progra.webp  " class="img-thumbnail rounded mx-auto d-block">
        <br> -->

        <!--////////////////////////////////////////////////////////////BUSCADOR-->
        <!-- <nav class="navbar navbar-light" style="margin-left: 32%;">
            <form class="d-flex my-2 my-lg-0" method="POST" action="index.php">
                <input class="form-control me-sm-2" type="search" placeholder="Buscar" name="busqueda">
                <button name="buscar" class="btn btn-light" type="submit"><img src="../img/search.png" alt="search" width="30%"></button>
            </form>
        </nav> -->
        <br> 

        <p class="lead">
            <a class="btn btn-dark btn-lg" href="libros" role="button">Libros</a>
            <a class="btn btn-dark btn-lg" href="cursos" role="button">Cursos</a>
            <a class="btn btn-dark btn-lg" href="certificaciones" role="button">Certificaciones</a>
            <a class="btn btn-dark btn-lg" href="tutoriales" role="button">Tutoriales</a>
        </p>
            
    </div>
</div>

<?php include("template/pie.php"); ?>