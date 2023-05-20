<?php include "./template/header.php";
        include "./administrador/config/bd.php";
        
        $sentenciasql=$conexion->prepare("SELECT * FROM libro;");
        $sentenciasql->execute();
        $listalibros=$sentenciasql->fetchAll(PDO::FETCH_ASSOC);

?>

<?php foreach ($listalibros as $libro){ ?>
<div class="col-md-3">
    <div class="card">
        <img class="card-img-top" src="./img/<?php echo $libro["imagen"]; ?>" alt="">
         <div class="card-body">
             <h4 class="card-title"><?php echo $libro["nombre"]; ?></h4>
             <a name="" id="" class="btn btn-primary" href="#" role="button">Ver mas</a>
        </div>
    </div>
</div>
<?php }  ?>
<?php include "./template/footer.php" ?>