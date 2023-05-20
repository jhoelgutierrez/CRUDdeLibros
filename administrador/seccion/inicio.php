<?php include("../template/header.php") ?>
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="display-3">Bienvenido usuario: <?php echo $nombreusuario; ?></h1>
                    <p class="lead">aqui administraremos nuestros libros</p>
                    <hr class="my-2">
                    
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="libros.php" role="button">Administrar Libros</a>
                    </p>
                </div>
            </div>
<?php include("../template/footer.php") ?>