<?php include "../template/header.php"; 
    $txtid=(isset($_POST["txtid"]))?$_POST["txtid"]:"";
    $txtnombre=(isset($_POST["txtnombre"]))?$_POST["txtnombre"]:"";
    $txtimagen=(isset($_FILES["txtimagen"]["name"]))?$_FILES["txtimagen"]["name"]:"";
    $txtaccion=(isset($_POST["accion"]))?$_POST["accion"]:"";

    switch ($txtaccion) {
        case 'agregar':
            echo "presione agregar";
            break;
        case 'modificar':
            echo "presione modificar";
            break;
        case 'cancelar':
            echo "presione cancelar";
            break;
        
    
    }
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
           <input type="text" class="form-control" id="txtid" name="txtid" placeholder="Ingrese un ID">
           </div>
           <div class="form-group">
           <label for="txtnombre">Nombre</label>
           <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Password">
           </div>
           <div class="form-group">
           <label for="txtimagen">Imagen</label>
           <input type="file" class="form-control" id="txtimagen" name="txtimagen">
           </div>
           
           <div class="btn-group" role="group" aria-label="">
            <button type="submit" name="accion" value="agregar" class="btn btn-success">Agregar</button>
            <button type="submit" name="accion" value="modificar" class="btn btn-warning">Modificar</button>
            <button type="submit" name="accion" value="cancelar" class="btn btn-info">Cancelar</button>
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
            <tr>
                <td>2</td>
                <td>One piece</td>
                <td>aqui va la iamgen</td>      
                <td>Selecionar | borrar </td>
            </tr>
        </tbody>
    </table>
</div>

<?php include "../template/footer.php"; ?>