<?php
include "config.php";
include "funciones.php";

try {
    $action = $_POST["action"];
    
    switch ($action) {
        case 'añadir':
            $idProd = $_POST["idProd"];
            $cantProd = $_POST["cant"];
            $q = mysqli_query($con, "SELECT p.cantidad FROM productos p WHERE p.idproducto = '$idProd'");
            $r = mysqli_fetch_array($q);

            if($cantProd <= $r["cantidad"] && $cantProd > 0){
                
                if(isset($_SESSION["cesta"]) && $_SESSION["cesta"] != null){    
                    $cesta = json_decode($_SESSION["cesta"], true);
                }else{
                    $cesta = array();
                }
                if(!empty($cesta)){
                    if (($key = array_search($idProd, array_column($cesta, 'id'))) !== false) {
                        $cesta[$key]["cantidad"] += 1;
                    }else{
                        $q = mysqli_query($con, "SELECT p.idproducto, p.nombre, p.cantidad, p.imagen, d.nombre deporte, p.precio 
                        FROM productos p, deportes d WHERE p.idproducto = '$idProd' and p.seccion = d.nombre");
                        $r = mysqli_fetch_array($q);

                        $producto = array(
                            "nombre"=>$r["nombre"],
                            "precio"=>$r["precio"],
                            "cantidad"=>$cantProd,
                            "cantidadMax"=>$r["cantidad"],
                            "imagen"=>$r["imagen"],
                            "seccion"=>$r["deporte"],
                            "id"=>$r["idproducto"]
                        );
                        array_push($cesta, $producto);

                        $result = array(
                            "result"=>"ok"
                        );
                    }
                }else{
                    $q = mysqli_query($con, "SELECT p.idproducto, p.nombre, p.cantidad, p.imagen, d.nombre deporte, p.precio 
                    FROM productos p, deportes d WHERE p.idproducto = '$idProd' and p.seccion = d.nombre");
                    $r = mysqli_fetch_array($q);

                    $producto = array(
                        "nombre"=>$r["nombre"],
                        "precio"=>$r["precio"],
                        "cantidad"=>$cantProd,
                        "cantidadMax"=>$r["cantidad"],
                        "imagen"=>$r["imagen"],
                        "seccion"=>$r["deporte"],
                        "id"=>$r["idproducto"]
                    );
                    array_push($cesta, $producto);

                    $result = array(
                        "result"=>"ok"
                    );
                }
            }else{

                $result = array(
                    "result"=>"noStock"
                );
            }

        break;

        case "testStock":
            if(isset($_SESSION["cesta"]) && $_SESSION["cesta"] != null && $_SESSION["cesta"] != "null"){    
                $cant = $_POST["cant"];
                $idCalc = $_POST["idCalc"];
                $cantExtra = $_POST["cantExtra"];
                $cesta = json_decode($_SESSION["cesta"], true);
                
                foreach ($cesta as $key => $value) {
                    $q = mysqli_query($con, "SELECT p.idproducto, p.nombre, p.cantidad FROM productos p WHERE p.idproducto = '".$value["id"]."'");
                    $r = mysqli_fetch_array($q);
                    if($r["idproducto"] != $idCalc){
                        if($value["cantidad"] > $r["cantidad"]){
                            $result = array(
                                "result"=>"noStock",
                                "name"=>$r["nombre"]
                            );
                        } 
                    }else{
                        if($cantExtra == ""){
                            if($cant > $r["cantidad"]){
                                $result = array(
                                    "result"=>"noStock",
                                    "name"=>$r["nombre"]
                                );
                            } 
                        }else{
                            if(($value["cantidad"]+$cantExtra) > $r["cantidad"]){
                                $result = array(
                                    "result"=>"noStock",
                                    "name"=>$r["nombre"]
                                );
                            } 
                        }
                    }
                                           
                }
            }else{
                $cesta = array();
            }
            break;


        case "cant":
            $idCest = $_POST["idCest"];
            $cantCest = $_POST["cantCest"];
            
            if($cantCest > 0){
                if(isset($_SESSION["cesta"]) && $_SESSION["cesta"] != null){    
                    $cesta = json_decode($_SESSION["cesta"], true);
                }else{
                    $cesta = array();
                }
            
                if (($key = array_search($idCest, array_column($cesta, 'id'))) !== false) {    
                    $cesta[$key]["cantidad"] = $cantCest;
                }
            }else{
                die();
            }
            break;

        case "delete":
            if(isset($_SESSION["cesta"]) && $_SESSION["cesta"] != null){    
                $cesta = json_decode($_SESSION["cesta"], true);
            }else{
                $cesta = array();
            }
            $idCest = $_POST["idCest"];
            if (($key = array_search($idCest, array_column($cesta, 'id'))) !== false) {
                if($key < (count($cesta)-1)){
                    array_splice($cesta, $key, 1);
                }else{
                    unset($cesta[$key]);
                }
            }
            break;

        case "enviarprecio":
            $_SESSION["idinsert"] = '';
            $cesta = json_decode($_SESSION["cesta"], true);
            $coste = 0;
            foreach ($cesta as $value) {
                $coste += ($value["precio"]*$value["cantidad"]);
            }            
            $_SESSION["pago"] = $coste;
            break;
        default:
            
            break;
    }

        mysqli_close($con);
        

        if(!isset($result)){
            $result = array(
                "result"=>"ok"
            );
        }
        if($result["result"] == "ok"){

            $_SESSION["cesta"] = json_encode($cesta, true);
        }

    echo(json_encode($result, true));


}catch (Exception $e) {

    $result = array(
        "result"=>"rok"
    );

    echo(json_encode($result,true));
       
}

?>