<?php include('template/cabecera.php');?>

<?php
include("administrador/config/db.php");
$sentencia = $conexion->prepare("SELECT * FROM `cursos`");
$sentencia->execute();
$listaCursos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>CURSOS</h1>
<h5>Cursos que te brindarán oportunidades de crecer como desarrollador.</h5>
<hr>
<?php foreach ($listaCursos as $curso) { ?>
    <div class="col-md-3">
        <div class="card">
        <img class="card-img-top" src="./img/<?php echo $curso['imagen']; ?>" alt="Title">
            <div class="card-body">
                <h4 class="card-title"><?php echo $curso['nombre']; ?></h4>
                <a class="btn btn-primary" href="<?php echo $curso['url']?>" role="button" target="_blank">Ver más</a> <br> <br>
                <!--////////////////////////////////// TELEGRAM ////////////////////////////////-->
                <script async src="https://telegram.org/js/telegram-widget.js?21" data-telegram-share-url="<?php echo $curso['url']?>" data-comment="Comparte este libro" data-size="large" data-text="notext"></script>
                <!--////////////////////////////////// FACEBOOK ////////////////////////////////-->
                <br>
                <div class="fb-share-button" data-href="<?php echo $curso['url']?>" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartir</a></div>
                <!--////////////////////////////////// WHATSAPP ////////////////////////////////-->
                <br> <br>
                <a class="btn btn-success" href="https://api.whatsapp.com/send?text=<?php echo $curso['url'];?>" role="button" target="_blank">Compartir en WhatsApp</a>
            </div>
        </div>
    </div>
<?php } ?>


<?php include("template/pie.php"); ?>