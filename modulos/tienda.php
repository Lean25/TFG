<?php //include "../configs/config.php";?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    
    
</head>
<?php //include_once("cabecera.php"); ?>
<body>

<?php 


if(isset($_GET["seccion"])){
    $seccion = $_GET["seccion"];

    $q = mysqli_query($con, "SELECT visibilidad FROM deportes WHERE nombre = '$seccion'");
    $r = mysqli_fetch_array($q);
    

        if($r["visibilidad"] == 0){
            echo "ESTA SECCIÓN NO ESTÁ DISPONIBLE ACTUALMENTE";
            die();
        }
        $q = mysqli_query($con, "SELECT * FROM productos where seccion = '$seccion' and visibilidad = 1 ORDER BY idproducto DESC");
    ?>
    <div class="container">
        <div class="row">
            <?php
            while ($r = mysqli_fetch_array($q)) {
                ?>
                            <div class="col-12 col-md-4">
                                
                                    <div class="card" onclick="togglePopup('<?= $r['nombre'] ?>', this)" style="background-image: url('imgproductos/<?= $r['imagen'] ?>');" >
                                
                                        <div class="contentBx">

                                            <p><?= $r['nombre'] ?></p>
                                        
                                            <div class="size">
                                                <h3><?= $r['precio'].' ' ?>€</h3>
                                            </div>

                                            <a style="background: #90EE90;" href="#">Añadir al carro</a>
                                            
                                        </div>
                                    </div>
                                
                            </div>
                    <?php
                }
                ?>
        </div>
    </div>
    <?php 
    mysqli_close($con); 
}else{
        $q = mysqli_query($con, "SELECT * FROM deportes WHERE visibilidad = 1 ORDER BY id");
        ?>
        <div class="container">
            <div class="row">
        <?php
        while ($r = mysqli_fetch_array($q)){ 
    ?>
                <div class="col-12 col-md-4">
                    <div class="tipoGallery">
                        <div class="itemType" onclick="openSeccion('<?= $r['nombre'] ?>', this)">
                            <img src="img/<?= $r['imagen'] ?>" alt="" style="width:100%;">
                            <p><?= $r['nombre'] ?></p>
                        </div>
                    </div>    
                </div>
            
        <?php  
        } 
        ?>
        </div>  
        </div>
        <?php
        mysqli_close($con);
}
?>
<script>
    function openSeccion(deporte) {
        window.location = "tienda?seccion=" + deporte; 
       
    }

    function togglePopup(producto) {
        window.location = "producto?producto=" + producto; 
       
    }


</script>
    
</body>


</html>