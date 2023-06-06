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
        $sentencia = $conexion->prepare("INSERT INTO cursos (nombre,url) VALUES (:nombre,:url);");
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
        header("location:cursos.php");
        break;
    case "Modificar":
        $sentencia = $conexion->prepare("UPDATE `cursos` SET `nombre` = :nombre WHERE `cursos`.`id` = :id;");
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
            $sentencia = $conexion->prepare("SELECT imagen FROM cursos WHERE `cursos`.`id` = :id");
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
            $curso = $sentencia->fetch(PDO::FETCH_LAZY);

            if (isset($curso["imagen"]) && ($curso["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img/" . $curso["imagen"])) {
                    unlink("../../img/" . $curso["imagen"]);
                }
            }

            $sentencia = $conexion->prepare("UPDATE `cursos` SET `imagen` = :imagen WHERE `cursos`.`id` = :id;");
            $sentencia->bindParam(':imagen', $nombreArchivo);
            $sentencia->bindParam(':id', $txtID);
            $sentencia->execute();
        }

        $sentencia = $conexion->prepare("UPDATE `cursos` SET `url` = :url WHERE `cursos`.`id` = :id;");
        $sentencia->bindParam(':url', $url);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("location:cursos.php");
        break;
    case "Cancelar":
        header("Location:cursos.php");
        break;
    case "Seleccionar":
        //Seleccionar en los registros el id :-> cuando coincida con el id
        $sentencia = $conexion->prepare("SELECT * FROM cursos WHERE `cursos`.`id` = :id");
        //pasar datos
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        //Cargar los datos uno a uno y rellenarlos
        $curso = $sentencia->fetch(PDO::FETCH_LAZY);

        $txtNombre = $curso['nombre'];
        $imagen = $curso['imagen'];
        $url = $curso['url'];
        break;
    case "Eliminar":
        //////////////////////////ELIMINAR IMAGEN DE LA CARPETA IMG
        $sentencia = $conexion->prepare("SELECT imagen FROM cursos WHERE `cursos`.`id` = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $curso = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($curso["imagen"]) && ($curso["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $curso["imagen"])) {
                unlink("../../img/" . $curso["imagen"]);
            }
        }

        ///////////////////////////////ELIMINAR TODA LA INFORMACION
        $sentencia = $conexion->prepare("DELETE FROM cursos WHERE `cursos`.`id` = :id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        header("location:cursos.php");
        break;
}
$sentencia = $conexion->prepare("SELECT * FROM `cursos`");
$sentencia->execute();
//Recuperar los registros para mostrarlos en lista de tutoriales - genera una asociación con los nuevos registros
$listaCursos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<!--///////////////////////////////////////////////////////////////////////////////////DATOS DEL TUTORIAL-->
<div class="col-md-4">
    
    <div class="card">
        <div class="card-header">
            Datos del Tutorial
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="txtID">ID</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Curso">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Url</label>
                    <input type="text" required class="form-control" value="<?php echo $url; ?>" name="url" id="url" placeholder="Url del Curso">
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

<!--///////////////////////////////////////////////////////////////////////////////////TABLA DE TUTORIALES-->
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
            <?php foreach ($listaCursos as $curso) { ?>
                <tr>
                    <td><?php echo $curso['id']; ?></td>
                    <td><?php echo $curso['nombre']; ?></td>
                    <td>
                        <img src="../../img/<?php echo $curso['imagen']; ?>" class="img-thumbnail rounded" width="50" alt="">
                    </td>
                    <td><?php echo $curso['url'];?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $curso['id']; ?>">
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