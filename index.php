<?php
include "configs/config.php";
include "configs/funciones.php";

if (!isset($_GET["p"])) {
    header("Location: menu");
    exit();
} else {
    $p = $_GET["p"];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <script type="text/javascript" src="js/jquery.js"></script>

    <script type="text/javascript" src="js/funciones.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    
    <script src="https://kit.fontawesome.com/8ae4b535da.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/media.css" />

    <title>Tienda online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body>
    <?php include_once("modulos/cabecera.php"); ?>

    <div class="cuerpo">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="container">
        <?php
        
        if (file_exists("modulos/" . $_GET["p"] . ".php")) {            
            include "modulos/" . $_GET["p"] . ".php";
        } else {
            echo "<i>No se ha encontrado <b>" . $_GET["p"] . ".</b></i>";
        }
        ?>
        </div>
    </div>

    

</body>


</html>