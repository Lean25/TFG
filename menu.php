<?php

include "configs/config.php";


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lion Sports</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/portada.css">
</head>
<body>
    <div class="menu">
        <div class="menu-inner">
            <div class="divLogo">
                <img class="logo" src="img/leon.png" />
                <h1 class="white-text">Bienvenido a Lion Sports</h1><br>
                <h4 class="white-text">Los limites los pones tú.</h4>
            </div>
            <ul class="menu-nav">
            <li class="menu-nav-item"><a class="menu-nav-link" href="menu"><span>
                    <div>Inicio</div>
                </span></a></li>
            <li class="menu-nav-item"><a class="menu-nav-link" href="tienda"><span>
                    <div>Tienda</div>
                </span></a></li>
            <li class="menu-nav-item"><a class="menu-nav-link" href="about"><span>
                    <div>Acerca de</div>
                </span></a></li>
            <li class="menu-nav-item"><a class="menu-nav-link" href="contacto"><span>
                    <div>Contacto</div>
                </span></a></li>
            </ul>


            <div class="gallery">
                <div class="images">
                    <?php 
                        $q = mysqli_query($con, "SELECT * FROM deportes WHERE portada = 'si' ORDER BY id");
                        while($r = mysqli_fetch_array($q)){

                    ?>
                    <a class="image-link" href="tienda">
                    <div class="image" data-label="<?= $r['nombre'] ?>"><img src="img/<?= $r['imagen'] ?>" alt=""></div>
                    </a>

                    <?php 
                    } mysqli_close($con)
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</body>
<?php include_once("modulos/footer.php") ?>
</html>
