<?php include("../template/cabecera.php"); ?>
<?php
//VALIDACION MEDIANTE UN IF TERNARIO
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
$url = (isset($_POST['url'])) ? $_POST['url'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../config/db.php");
    
switch ($accion) {
    case "Agregar":
        //Modificacion de sentencia sql para el remplazo de valores
        $sentencia = $conexion->prepare("INSERT INTO libros (nombre,imagen,url) VALUES (:nombre,:imagen,:url);");
        //Colocacion de parametros
        $sentencia->bindParam(':nombre', $txtNombre);

        ///////////////Crear nombre por si se repite el nombre de la imagen
        $fecha = new DateTime();
        $nombreArchivo = ($imagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg";

        ///////////////Almacenar imagen en carpeta img
        $tempImagen = $_FILES["imagen"]["tmp_name"];
        if ($tempImagen != "") {
            move_uploaded_file($tempImagen, "../../img/" . $nombreArchivo);
        }

        $sentencia->bindParam(':imagen', $nombreArchivo);
        $sentencia->bindParam(':url', $url);
        $sentencia->execute();
        header("location:productos.php");
        break;
    case "Modificar":
        $sentencia = $conexion->prepare("UPDATE `libros` SET `nombre` = :nombre WHERE `libros`.`id` = :id;");
        $sentencia->bindParam(':nombre', $txtNombre);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();

        if ($imagen != "") {
            ///////////////Crear nombre por si se repite el nombre de la imagen
            $fecha = new DateTime();
            $nombreArchivo = ($imagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg";

            ///////////////Almacenar imagen en carpeta img
            $tempImagen = $_FILES["imagen"]["tmp_name"];
            move_uploaded_file($tempImagen, "../../img/" . $nombreArchivo);

            //////////////////////////ELIMINAR IMAGEN DE LA CARPETA IMG
            $sentencia = $conexion->prepare("SELECT imagen FROM libros WHERE `libros`.`id` = :id");
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
            $libro = $sentencia->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img/" . $libro["imagen"])) {
                    unlink("../../img/" . $libro["imagen"]);
                }
            }

            $sentencia = $conexion->prepare("UPDATE `libros` SET `imagen` = :imagen WHERE `libros`.`id` = :id;");
            $sentencia->bindParam(':imagen', $nombreArchivo);
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
        }

        $sentencia = $conexion->prepare("UPDATE `libros` SET `url` = :url WHERE `libros`.`id` = :id;");
        $sentencia->bindParam(':url', $url);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("location:productos.php");
        break;
    case "Cancelar":
        header("Location:productos.php");
        break;
    case "Seleccionar":
        //Seleccionar en los registros el id :-> cuando coincida con el id
        $sentencia = $conexion->prepare("SELECT * FROM libros WHERE `libros`.`id` = :id");
        //pasar datos
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        //Cargar los datos uno a uno y rellenarlos
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);

        $txtNombre = $libro['nombre'];
        $imagen = $libro['imagen'];
        $url = $libro['url'];
        break;
    case "Eliminar":
        //////////////////////////ELIMINAR IMAGEN DE LA CARPETA IMG
        $sentencia = $conexion->prepare("SELECT imagen FROM libros WHERE `libros`.`id` = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $libro = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $libro["imagen"])) {
                unlink("../../img/" . $libro["imagen"]);
            }
        }

        ///////////////////////////////ELIMINAR TODA LA INFORMACION
        $sentencia = $conexion->prepare("DELETE FROM libros WHERE `libros`.`id` = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("location:productos.php");
        break;
}
$sentencia = $conexion->prepare("SELECT * FROM `libros`");
$sentencia->execute();
//Recuperar los registros para mostrarlos en lista de libros - genera una asociación con los nuevos registros
$listaLibros = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<!--///////////////////////////////////////////////////////////////////////////////////DATOS DEL LIBRO-->
<div class="col-md-4">

    <div class="card">
        <div class="card-header">
            Datos de libro
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Libro">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Url</label>
                    <input type="text" required class="form-control" value="<?php echo $url; ?>" name="url" id="url" placeholder="Url del Libro">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Imagen</label>
                    <br>

                    <?php if ($imagen != "") { ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $imagen; ?>" width="50" alt="">
                    <?php } ?>

                    <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen">
                </div>
                <br>
                <div class="btn-group" role="group">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-outline-light">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-outline-light">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-outline-light">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--///////////////////////////////////////////////////////////////////////////////////TABLA DE LIBROS-->
<div class="col-md-8" style="overflow: scroll;
     height:550px;
     width:65%;">
    <table id="div1" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Url</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td>
                        <img src="../../img/<?php echo $libro['imagen']; ?>" class="img-thumbnail rounded" width="50" alt="">
                    </td>
                    <td><?php echo $libro['url'];?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-outline-light">
                            <input type="submit" name="accion" value="Eliminar" class="btn btn-outline-light">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

<?php include("../template/pie.php"); ?>