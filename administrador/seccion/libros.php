<?php include "../template/header.php";
        include "../config/bd.php";

    $txtid=(isset($_POST["txtid"]))?$_POST["txtid"]:"";
    $txtnombre=(isset($_POST["txtnombre"]))?$_POST["txtnombre"]:"";
    $txtimagen=(isset($_FILES["txtimagen"]["name"]))?$_FILES["txtimagen"]["name"]:"";
    $txtaccion=(isset($_POST["accion"]))?$_POST["accion"]:"";


    switch ($txtaccion) {
        case 'agregar':
            //INSERT INTO `libro` (`id`, `nombre`, `imagen`) VALUES ('3', 'libro de html', 'imagenhtml.jpg');
            $sentenciasql=$conexion->prepare("INSERT INTO libro (nombre, imagen) VALUES (:nombre, :imagen);");
            $sentenciasql->bindParam(':nombre',$txtnombre);

            $fechaimagen=new DateTime();
            $nombreArchivo=($txtimagen!="")? $fechaimagen->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen.jpg";
            $imgTmp=$_FILES["txtimagen"]["tmp_name"];

            if($imgTmp!=""){
                move_uploaded_file($imgTmp, "../../img/".$nombreArchivo);
            }

            $sentenciasql->bindParam(':imagen',$nombreArchivo);
            $sentenciasql->execute();
            header("Location:libros.php");
            break;
        case 'modificar':
            //UPDATE `libro` SET `nombre` = 'libro de PHP', `imagen` = 'imagenphp.jpg' WHERE `libro`.`id` = 1;
            $sentenciasql=$conexion->prepare("UPDATE `libro` SET `nombre` = :nombre WHERE `libro`.`id` = :id;");
            $sentenciasql->bindParam(':nombre',$txtnombre);
            $sentenciasql->bindParam(':id',$txtid);
            $sentenciasql->execute();

            if($txtimagen!=""){
               
                $fechaimagen=new DateTime();
                $nombreArchivo=($txtimagen!="")? $fechaimagen->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen.jpg";
                $imgTmp=$_FILES["txtimagen"]["tmp_name"];
                move_uploaded_file($imgTmp, "../../img/".$nombreArchivo);

                 $sentenciasql=$conexion->prepare("SELECT imagen FROM libro WHERE id=:id");
                $sentenciasql->bindParam(':id',$txtid);
                $sentenciasql->execute();
                $libro=$sentenciasql->fetch(PDO::FETCH_LAZY);
                if (isset($libro["imagen"]) && $libro["imagen"]!="imagen.jpg") {
                    if(file_exists("../../img/".$libro["imagen"])){
                      unlink("../../img/".$libro["imagen"]);
                    }
            }
                $sentenciasql=$conexion->prepare("UPDATE `libro` SET `imagen` = :imagen WHERE `libro`.`id` = :id;");
                $sentenciasql->bindParam(':imagen',$nombreArchivo);
                $sentenciasql->bindParam(':id',$txtid);
                $sentenciasql->execute();
            }
            header("Location:libros.php");
            break;
        case 'cancelar':
            header("Location:libros.php");
            break;
        case 'seleccionar':
            $sentenciasql=$conexion->prepare("SELECT * FROM libro WHERE id=:id");
            $sentenciasql->bindParam(':id',$txtid);
            $sentenciasql->execute();
            $libro=$sentenciasql->fetch(PDO::FETCH_LAZY);

            $txtid=$libro["id"];
            $txtnombre=$libro["nombre"];
            $txtimagen=$libro["imagen"];

            break;
        case 'borrar':
            $sentenciasql=$conexion->prepare("SELECT imagen FROM libro WHERE id=:id");
            $sentenciasql->bindParam(':id',$txtid);
            $sentenciasql->execute();
            $libro=$sentenciasql->fetch(PDO::FETCH_LAZY);
            if (isset($libro["imagen"]) && $libro["imagen"]!="imagen.jpg") {
                if(file_exists("../../img/".$libro["imagen"])){
                    unlink("../../img/".$libro["imagen"]);
                }
            }


            $sentenciasql=$conexion->prepare("DELETE FROM libro WHERE id=:id");
            $sentenciasql->bindParam(':id',$txtid);
            $sentenciasql->execute();
            header("Location:libros.php");
            break;
    
    }

    $sentenciasql=$conexion->prepare("SELECT * FROM libro;");
    $sentenciasql->execute();
    $listalibros=$sentenciasql->fetchAll(PDO::FETCH_ASSOC);
    
?>

<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del libro
        </div>
        <div class="card-body">
           <form method="POST" enctype="multipart/form-data">
           <div class = "form-group">
           <label for="txtid">ID</label>
           <input type="text" readonly class="form-control" value="<?php echo $txtid; ?>" id="txtid" name="txtid" placeholder="Ingrese un ID">
           </div>
           <div class="form-group">
           <label for="txtnombre">Nombre</label>
           <input type="text" required class="form-control" value="<?php echo $txtnombre; ?>" id="txtnombre" name="txtnombre" placeholder="Ingresa un nombre    ">
           </div>
           <div class="form-group">
           <label for="txtimagen">Imagen:</label>
           <br> 
           <?php if($txtimagen!="") { ?>
                <img src="../../img/<?php echo $txtimagen ?>" width="100" class="img-thumbnail" alt="">
           <?php } ?>
           <input type="file" class="form-control" id="txtimagen" name="txtimagen">
           </div>
           
           <div class="btn-group" role="group" aria-label="">
            <button type="submit" name="accion" <?php echo ($txtaccion == "seleccionar")?"disabled":""; ?> value="agregar" class="btn btn-success">Agregar</button>
            <button type="submit" name="accion" <?php echo ($txtaccion != "seleccionar")?"disabled":""; ?> value="modificar" class="btn btn-warning">Modificar</button>
            <button type="submit" name="accion" <?php echo ($txtaccion != "seleccionar")?"disabled":""; ?> value="cancelar" class="btn btn-info">Cancelar</button>
           </div>
           
           </form>
           
           
        </div>
    </div>
</div>

<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listalibros as $libro) { ?>
            <tr>
                <td><?php echo $libro["id"]; ?></td>
                <td><?php echo $libro["nombre"]; ?></td>
                <td>
                    <img src="../../img/<?php echo $libro["imagen"]; ?>" width="100" class="img-thumbnail" alt="">
                
                </td>      
                <td>
                    <form method="post">
                    <input type="hidden" name="txtid" value="<?php echo $libro["id"]; ?>" id="" />
                    <button type="submit" name="accion" value="seleccionar" class="btn btn-primary">Seleccionar</button>
                    <button type="submit" name="accion" value="borrar" class="btn btn-danger">Borrar</button>
                    </form>
                </td>
            </tr>
            <?php  } ?>
        </tbody>
    </table>
</div>

<?php include "../template/footer.php"; ?>