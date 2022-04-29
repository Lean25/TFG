<?php //include "../configs/config.php";?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<?php //include_once("cabecera.php"); ?>
<body>
    
<?php

if (isset($_GET["producto"])) {
    $producto = $_GET["producto"];

    $q = mysqli_query($con, "SELECT * FROM productos WHERE nombre = '$producto'");
    $r = mysqli_fetch_array($q);
    mysqli_close($con);

    if($r["visibilidad"] == 0){
        echo "ESTE PRODUCTO NO ESTÁ DISPONIBLE ACTUALMENTE";
        die();
    }

    $stringImages = $r['imagenes'];
    $arrayImages = explode(",", $stringImages);


?>

<script>
       $(document).ready(function(){
           
            $(".containerProduct button.addCest").on("click", function(){
                
                if($(".cantAddCest").length > 0){
                    let cant = $(".cantAddCest").val(); 
                    if(testStock("", <?= $r["idproducto"] ?>, cant) == true){                        
                        if(cant != "" && cant > 0){                    
                            let cual = $(this).attr("cual");
                            let valores = {
                                idProd: '<?= $r["idproducto"] ?>',
                                action: "añadir",
                                cant: cant
                            };

                            $.ajax({
                                url: "configs/manejar_cesta.php",
                                type: 'POST',
                                data: valores,
                                success: function(data) {
                                    try {
                                        $result = JSON.parse(data);
                                    
                                        if($result["result"] == "ok"){
                                            success("Añadido correctamente");
                                            
                                        }else if($result["result"] == "rok"){
                                            error("¡Se ha producido un error! Intentelo de nuevo más tarde.");

                                        }else if($result["result"] == "noStock"){
                                            error("Actualmente no tenemos stock suficiente para la cantidad seleccionada, recargue la web.");
                                        }
                                    } catch(err) {
                                        error("¡Se ha producido un error! Intentelo de nuevo más tarde.");
                                    }   
                                    
                                    //alert("correcto");
                                },
                            });
                        }
                    }
                }
            });
        })
        function error($mensaje) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: $mensaje,
                footer: '<a href="?p=cart">Ir a la cesta.</a>'
            })
        }

        function success() {
            Swal.fire({
                icon: 'success',
                title: 'Perfecto',
                text: 'Ha añadido el producto a la cesta.',
                footer: '<a href="?p=cart">Ir a la cesta.</a>'
            })
        }
    </script>


        <div class="container containerProduct">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <?php
                                for ($i = 1; $i < count($arrayImages); $i++) {
                                    $posi = strval($i);
                                ?>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?= $posi ?>"></li>
                                <?php
                                }
                                ?>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="imgproductos/<?= $arrayImages[0] ?>" class="d-block w-100 img" alt="...">
                                </div>
                                <?php
                                for ($i = 1; $i < count($arrayImages); $i++) {
                                ?>
                                    <div class="carousel-item">
                                        <img src="imgproductos/<?= $arrayImages[$i] ?>" class="d-block w-100 img" alt="...">
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                <div class="productData">
                        <div>
                            <p class="tipoProd"><?= $r['seccion'] ?></p>
                            <h1 class="titProd"><?= $r['nombre'] ?></h1>                        
                            <h2><?= $r['precio'] ?>€</h2>
                        </div>
                        <p class="descProd"><?= $r['descripcion'] ?></p>                        
                        <div class="divCestaPro">
                            <div>
                                <div class="d-flex align-items-center">
                                    <p>Cantidad:</p>
                                    <input type="number" class="form-control cantAddCest" min="1" max="<?= $r["cantidad"] ?>" value="1" oninput="validity.valid||(value='')">
                                </div>
                                <p class="stockProd">Stock: <?= $r["cantidad"] ?> uds.</p>
                            </div>                                                  
                            <button class="buttonProd addCest">Añadir al carrito</button>
                        </div>                        
                    </div>

                </div>
            </div>
        </div>


    <?php
    }
?>

    
</body>
</html>