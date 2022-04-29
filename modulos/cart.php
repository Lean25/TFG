<?php //session_destroy(); //include_once("cabecera.php"); ?>

<script>
$(document).ready(function() {
    $(".iconCartMobile").css("display", "none");

    getTotalPrice();

    $('.cartSection .qty').on("focusout", function () {
    
    let cant = $(this).val();
    let idCalc = $(this).attr("idprod");
    if(cant == "" || cant == null){

        $("#item" + idCalc + " .removeWrap a.remove").click();    
    }

    });


    $('.cartSection .qty').on("input", function () {  
        let cant = $(this).val();
        let precio = $(this).attr("precio");
        let idCalc = $(this).attr("idprod");
        if(testStock(cant, idCalc) == true){
            let valores = {
                idCest: idCalc,
                cantCest: cant,
                action: "cant"
            };
            if(cant != "" && cant > 0){
                $.ajax({
                url: "configs/manejar_cesta.php",
                type: 'POST',
                data: valores,
                success: function(data) {

                    $("#item" + idCalc + " .prodTotal p").html(precio*cant + "€");
                    getTotalPrice();
                },
                });  
            }
        }

    });



    // Remove Items From Cart
    $('a.remove').on("click", function(event){
        event.preventDefault();
        let cestView = $( this ).parent().parent().parent();
        let valores = {
            idCest: $(this).attr("idCest"),
            action: "delete"
        };
        $.ajax({
        url: "configs/manejar_cesta.php",
        type: 'POST',
        data: valores,
        success: function(data) {
            cestView.hide( 400, function(){
            cestView.remove(); 
            let par = 0;
            $(".cartWrap .items").each(function(){
                $(this).removeClass("even");
                $(this).removeClass("odd");
                if(par%2 == 0){
                $(this).addClass("even");
                }else{
                $(this).addClass("odd");              
                }
                par++;
            });
            getTotalPrice();
            });         
        },
        });    
        
    });

    $('a.continua').on("click", function () {  

        let valores = {
            action: "enviarprecio"
        };

        $.ajax({
        url: "configs/manejar_cesta.php",
        type: 'POST',
        data: valores,
        success: function(data){

            $result = JSON.parse(data);     
            if($result["result"] == "ok"){
                window.location="indexpago";
            }else{
                alert("¡Se ha producido un error! Intentelo de nuevo más tarde.");

            } 

        },
    

        });

    });
    

    function getTotalPrice(){
        let totalPrice = 0;
        $(".cartWrap .items").each(function(){
            let priceUnit = Number($(this).find(".prodTotal p").html().slice(0, -1));
            totalPrice += priceUnit;
        });
        $(".totalRow span.value").html(totalPrice+".00€");
    }

   

});
</script>

<div class="cardCesta">
        
        <div class="wrap cf">
            <!--<h1 class="projTitle">Cesta</h1>-->
            <div class="heading cf">
                <h1>Mi cesta</h1>
                <a href="tienda" class="continue">Continua comprando</a>
            </div>
            <div class="cart">
                <ul class="cartWrap">

                    <?php
                    
                    
                    if(isset($_SESSION["cesta"]) && $_SESSION["cesta"] != null){    
                    $cesta = json_decode($_SESSION["cesta"], true);
                    }else{
                        $cesta = array();
                    }
                    $par = 0;
                    
                    foreach($cesta as $valor){
                        
                    $color =  "odd";
                    if($par%2 == 0) $color = "even";
                    ?>
                    <li class="items <?= $color ?>" id="item<?= $valor["id"] ?>">
                        <div class="infoWrap">
                            <div class="cartSection">
                                <img src="imgproductos/<?= $valor["imagen"] ?>" alt="" class="itemImg" />
                                <p class="itemNumber"><b><?= $valor["seccion"] ?></b></p>
                                <h3 style="color: black;"><?= $valor["nombre"] ?></h3>

                                <p style="color: black;"><input type="number" class="qty" placeholder="0" min="1" max="<?= $valor["cantidadMax"] ?>" value="<?= $valor["cantidad"] ?>" precio="<?= $valor["precio"] ?>" idprod="<?= $valor["id"] ?>" oninput="validity.valid||(value='')"/> X<?= $valor["precio"] ?>€</p>

                                <!--<p class="stockStatus"> In Stock</p>-->
                            </div>
                            <div class="prodTotal cartSection">
                                <p style="color: black;"><?= $valor["precio"]*$valor["cantidad"] ?>€</p>
                            </div>
                            <div class="cartSection removeWrap">
                                <a href="#" class="remove" idCest="<?= $valor["id"] ?>">x</a>
                            </div>
                        </div>
                    </li>
                    <?php
                    $par++;
                    }
                    ?>
                
                    

                </ul>
            </div>
            
            <div class="subtotal cf">
                <ul>
                    <li class="totalRow final">
                        <span class="label" style="color: black;">Total:&nbsp</span><span class="value"> 0.00€</span>
                    </li>
                    <li class="totalRow final">
                    <?php 

                    if(isset($_SESSION["cesta"]) && $_SESSION["cesta"] != null && $_SESSION["cesta"] != "null"){
                        
                    ?>
                    <a class="btn continua" id="continua">Comprar</a>
                    <?php
                    } 
                    ?>

                    
                    </li>
                </ul>
            </div>
            

        </div>

</div>

