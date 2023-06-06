<?php include('template/cabecera.php');?>

<div class="col-md-12">
    <div class="p-5 ">
        <div class="container">
            <h1 class="display-3">Bienvenid@ <?php echo $nombreUsuario; ?></h1>
            <p class="lead">Date una vuelta por el sistema y agrega algo nuevo.</p>
            <hr class="my-2">
            <p>Sistema de Administración del Sitio.</p>
            <p class="lead" style="text-align: center;">
                <a class="btn btn-dark btn-lg" href="seccion/productos.php" role="button">Libros</a>
                <a class="btn btn-dark btn-lg" href="seccion/cursos.php" role="button">Cursos</a>
                <a class="btn btn-dark btn-lg" href="seccion/certificados.php" role="button">Certificados</a>
                <a class="btn btn-dark btn-lg" href="seccion/tutoriales.php" role="button">Tutoriales</a>
            </p>
        </div>
    </div>
</div>
<?php 
include("config/db.php");
$sentencia = $conexion->prepare("SELECT * FROM `libros`");
$sentencia->execute();  
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC); 
?>
<?php foreach ($listaLibros as $libro) { ?>
    <!-- <div class="col-md-3"> 
        <div class="card"> 
            <img class="card-img-top" src="../img/<?php echo $libro['imagen']; ?>" alt="Title">
            <div class="card-body">
                <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
                <a name="" id="" class="btn btn-dark" href="seccion/productos.php" role="button">Modificar</a>
            </div>
        </div>
    </div> -->
<?php } ?>

<?php include('template/pie.php');?>    