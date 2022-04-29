<?php
include "config.php";
include "funciones.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    $action = $_POST["action"];

    switch ($action) {
        case 'añadirproducto':
            $name = str_replace("'", '"', $_POST['name']);
            $description = str_replace("'", '"', $_POST['descripcion']);
            $cant = $_POST["cant"];
            $precio = $_POST["precio"];

            $seccion = $_POST["deporte"];

            $imagen = "";

            if ( 0 < $_FILES['imagen']['error'] ) {
                echo 'Error: ' . $_FILES['imagen']['error'] . '<br>';
            }
            else {
                $imagen = $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../imgproductos/' . $imagen);
            }

            //Test multiples imagenes

            $countfiles = count($_FILES['imagenes']['name']);
            $upload_location = "../imgproductos/";
            $arrayImagenes = array();

            for($i = 0; $i < $countfiles; $i++){

                if(isset($_FILES['imagenes']['name'][$i]) && $_FILES['imagenes']['name'][$i] != ''){
                   // File name
                   $filename = $_FILES['imagenes']['name'][$i];
             
                   // Get extension
                   $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
             
                   // Valid image extension
                   $valid_ext = array("png","jpeg","jpg");
             
                   // Check extension
                   if(in_array($ext, $valid_ext)){
             
                      // File path
                      $path = $upload_location.$filename;
             
                      // Upload file
                      if(move_uploaded_file($_FILES['imagenes']['tmp_name'][$i],$path)){
                         $arrayImagenes[] = $filename;
                      }
                   }
                }
             }
             $stringImagenes = implode(",", $arrayImagenes);

            mysqli_query($con, "INSERT INTO productos (nombre, imagen, imagenes, seccion, cantidad, precio, descripcion, visibilidad) VALUES ('$name', '$imagen', '$stringImagenes', '$seccion', '$cant', '$precio', '$description', 1)");

            //Fin test
            break;

        case 'añadirdeporte':
            $name = str_replace("'", '"', $_POST['name']);
    
    
            $imagen = "";
    
            if ( 0 < $_FILES['imagen']['error'] ) {
                echo 'Error: ' . $_FILES['imagen']['error'] . '<br>';
            }
            else {
                $imagen = $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../img/' . $imagen);
            }
    
            mysqli_query($con, "INSERT INTO deportes (nombre, imagen, visibilidad) VALUES ('$name', '$imagen', 1)");
    
                //Fin test
            break;

        case "eliminar":
            $id = $_POST['id'];
            mysqli_query($con, "DELETE FROM productos WHERE idproducto ='$id'");
            break;
   
        case 'mostrarEdit':
            $id = $_POST['id'];
            $qEdit = mysqli_query($con, "SELECT * FROM productos WHERE idproducto = '$id'");
            $r = mysqli_fetch_array($qEdit);
            echo ($r["nombre"].";".$r["descripcion"].";".$r["seccion"].";".$r["cantidad"].";".$r["precio"]);
            break;

        case 'editar':
            $id = $_POST['idproducto'];
            $name =str_replace("'", '"', $_POST['name']);
		    $description = str_replace("'", '"', $_POST['description']);
		    $tipo = $_POST['deporte'];
		    $cant = $_POST['cant'];
		    $precio = $_POST['precio'];

            $imagen = "";
            $imagenes = "";

            if ( 0 < $_FILES['imagen']['error'] ) {
                echo 'Error: ' . $_FILES['imagen']['error'] . '<br>';
            }
            else {
                $imagen = $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../imgproductos/' . $imagen);
            }

            //Test multiples imagenes

            $countfiles = count($_FILES['imagenes']['name']);
            $upload_location = "../imgproductos/";
            $arrayImagenes = array();

            for($i = 0; $i < $countfiles; $i++){

                if(isset($_FILES['imagenes']['name'][$i]) && $_FILES['imagenes']['name'][$i] != ''){
                   // File name
                   $filename = $_FILES['imagenes']['name'][$i];
             
                   // Get extension
                   $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
             
                   // Valid image extension
                   $valid_ext = array("png","jpeg","jpg");
             
                   // Check extension
                   if(in_array($ext, $valid_ext)){
             
                      // File path
                      $path = $upload_location.$filename;
             
                      // Upload file
                      if(move_uploaded_file($_FILES['imagenes']['tmp_name'][$i],$path)){
                         $arrayImagenes[] = $filename;
                      }
                   }
                }
             }

             $stringImagenes = implode(",", $arrayImagenes);
             
             $and = "";
             if ($imagen != "") {
                $and .= ", imagen='$imagen'";
             }
             if ($stringImagenes != "") {
                $and .= ", imagenes='$stringImagenes'";
            }
            echo $and;
            mysqli_query($con, "UPDATE productos SET nombre='$name', descripcion='$description', seccion='$tipo', cantidad='$cant', precio='$precio' $and WHERE idproducto='$id'");

            break;

        case 'email':
            
            require_once '../vendor/autoload.php';

            $nombre = utf8_decode($_POST["nombre"]);
            $apellidos = utf8_decode($_POST["ape"]);
            $email = $_POST["mail"];
            $tel = $_POST["tel"];
            $message = utf8_decode($_POST["message"]);

            $mail = new PHPMailer(true);
            $mail2 = new PHPMailer(true);

            try{
            $mail->SMTPDebug = 2;
            $mail->isSMTP();

            $mail->Host = 'smtp.gmail.com';
            
            $mail->SMTPAuth = true;

            $mail->Username = 'lionsports100@gmail.com';
            $mail->Password = 'prueba123';

            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->AddAddress("leandro102510@gmail.com");
            $mail->SetFrom('lionsports100@gmail.com');
            $mail->Subject = "Comentario en la web de ".$nombre." ".$apellidos ;
            $content = "<b>Email de: ".$email."<br> Tel: ".$tel.". <br> Texto: ".$message."</b>";

            $mail->MsgHTML($content); 
            $mail->send();


            $mail2->SMTPDebug = 2;
            $mail2->isSMTP();

            $mail2->Host = 'smtp.gmail.com';
            
            $mail2->SMTPAuth = true;

            $mail2->Username = 'lionsports100@gmail.com';
            $mail2->Password = 'prueba123';

            $mail2->SMTPSecure = 'tls';
            $mail2->Port = 587;

            $mail2->AddAddress($email);
            $mail2->SetFrom('lionsports100@gmail.com');
            $mail2->Subject = "Soporte" ;
            
            $content = "Se ha enviado su correo, enseguida el soporte se pondra en contacto con usted.";

            $mail2->MsgHTML($content); 
            $mail2->send();

            }catch(Exception $e){
            echo 'error';
            }

            break;

        case 'recuperar':

            require_once '../vendor/autoload.php';

            $email = $_POST["email"];

            $q = mysqli_query($con, "SELECT email FROM usuarios WHERE email = '$email'");
            $r = mysqli_fetch_array($q);

            if($email == $r['email']){

                $user_id = $r["id"];
            
                $texto = utf8_decode("Recuperacion de contraseña");
                $mail = new PHPMailer(true);

                $url = 'http://localhost/ProyectoDAW/Proyecto/cambiapass?user_id='.$user_id.'&email='.$email;

                try{
                    $mail->SMTPDebug = 2;
                    $mail->isSMTP();
        
                    $mail->Host = 'smtp.gmail.com';
                    
                    $mail->SMTPAuth = true;
        
                    $mail->Username = 'lionsports100@gmail.com';
                    $mail->Password = 'prueba123';
        
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
        
                    $mail->AddAddress($email);
                    $mail->SetFrom('lionsports100@gmail.com');
                    $mail->Subject = $texto;
                    $content = "Pincha en este link para recuperar la contrase&ntilde;a: <a href='$url'>Pincha aqui</a>";
        
                    $mail->MsgHTML($content); 
                    $mail->send();
        
                    }catch(Exception $e){
                    echo 'error';
                    }
            }else{
                
            }
    
            break;

        case 'cambiar':

            $email = $_POST["email"];

            $password = md5($_POST["password"]);
            $repitepassword = md5($_POST["repitepassword"]);

            if($password == $repitepassword){

                mysqli_query($con, "UPDATE usuarios SET pass = '$password' WHERE email = '$email'");
                
            }else{
                echo '<p class="error">Las contraseñas no coinciden</p>';
            }

            break;

        case 'perfil':

            $nombre = str_replace("'", '"', $_POST['nombre']);
            $apellidos = $_POST["ape"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];
            $pais = $_POST["pais"];
            $provincia = $_POST["provincia"];
            $idsesion = $_POST['id'];

            $imagen = "";

            if ( 0 < $_FILES['imagen']['error'] ) {
                echo 'Error: ' . $_FILES['imagen']['error'] . '<br>';
            }
            else {
                $imagen = $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../img/' . $imagen);
            }

            $and = "";

            if ($imagen != "") {
            $and .= ", imagen='$imagen'";
            }

            
            mysqli_query($con, "UPDATE usuarios SET nombre = '$nombre', apellidos ='$apellidos', telefono = '$telefono', direccion = '$direccion', pais = '$pais', provincia = '$provincia' $and WHERE id = '$idsesion'");

            


            break;

        case 'envio':

            
            $nombre = str_replace("'", '"', $_POST['nombre']);
            $apellidos = $_POST["ape"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];
            $pais = $_POST["pais"];
            $provincia = $_POST["provincia"];
            $precio = $_SESSION["pago"].' €';
            $idsesion = $_POST['id'];
            $productos = json_decode($_SESSION["cesta"], true);
            


            $estado = "Creado";

            $totalproductos= '';
            
            

            foreach($productos as $valor){

                $totalproductos .= $valor["nombre"].' '.$valor["cantidad"].'. ';

                
                
                $imagen .= $valor["imagen"].' ';

            }


            date_default_timezone_set('Europe/Madrid');    
            $DateAndTime = date('d-m-Y H:i:s a', time());  
           
            if(isset($_SESSION["idinsert"]) && $_SESSION["idinsert"] != null && $_SESSION["idinsert"] != "null"){

                mysqli_query($con, "UPDATE pedidos SET idcliente = '$idsesion', cliente = '$nombre', email ='$email', fecha = '$DateAndTime', productos = '$totalproductos', precio = '$precio', imagen = '$imagen', nombre = '$nombre', apellidos = '$apellidos', 
                telefono = '$telefono', direccion = '$direccion', pais='$pais', provincia = '$provincia', estado = '$estado' WHERE idpedido = '".$_SESSION["idinsert"]."' ");

                

            }else{

                mysqli_query($con, "INSERT INTO pedidos(idcliente, cliente, email, fecha, productos, precio, imagen, nombre, apellidos, telefono, direccion, pais, provincia, estado) 
                VALUES('$idsesion','$nombre','$email','$DateAndTime','$totalproductos','$precio', '$imagen', '$nombre', '$apellidos', '$telefono','$direccion','$pais','$provincia','$estado')");
    
                $_SESSION["idinsert"] = mysqli_insert_id($con);
            }
            
            

            



            break;

        case 'cambiarestado':

            require_once '../vendor/autoload.php';

            $estado = "Pagado";
            $idinsert = $_POST["id"];

            $idusuario = $_POST["idusuario"];

            mysqli_query($con, "UPDATE pedidos SET estado = '$estado' WHERE idpedido = '$idinsert'");

            $q = mysqli_query($con, "SELECT email FROM usuarios WHERE id = '$idusuario'");
            $r = mysqli_fetch_array($q);

            $correo = $r["email"];

            $mail = new PHPMailer(true);

            try{
                $mail->SMTPDebug = 2;
                $mail->isSMTP();
    
                $mail->Host = 'smtp.gmail.com';
                
                $mail->SMTPAuth = true;
    
                $mail->Username = 'lionsports100@gmail.com';
                $mail->Password = 'prueba123';
    
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
    
                $mail->AddAddress($correo);
                $mail->SetFrom('lionsports100@gmail.com');
                $mail->Subject = "Compra Lion Sports" ;
                $content = "Su pedido ha sido finalizado y sera procesado en los proximos dias.";
    
                $mail->MsgHTML($content); 
                $mail->send();

            }catch(Exception $e){
                echo 'error';
                }



            break;


        case 'eliminarpedido':

            $id = $_POST["id"];
            mysqli_query($con, "DELETE FROM pedidos WHERE idpedido = $id");



            break;

        case'devolverpedido':

            $id = $_POST["id"];
            $devuelto = "Devuelto";
            mysqli_query($con, "UPDATE pedidos SET estado = '$devuelto' WHERE idpedido = $id");

            break;


        case 'editar_tipos':
            $id = $_POST['id'];
            $name = str_replace("'", '"', $_POST['name']);

            $imagen = "";

            if ( 0 < $_FILES['imagen']['error'] ) {
                echo 'Error: ' . $_FILES['imagen']['error'] . '<br>';
            }
            else {
                $imagen = $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../imgproductos/' . $imagen);
            }

            $and = "";
            if ($imagen != "") {
            $and .= ", imagen='$imagen'";
            }

            echo $and;
            mysqli_query($con, "UPDATE deportes SET nombre = '$name'  $and WHERE id= $id");

            break;        

        case "eliminar_tipos":
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            mysqli_query($con, "DELETE FROM productos WHERE seccion = '$nombre'");
            mysqli_query($con, "DELETE FROM deportes WHERE id=$id");
            break;

        case 'mostrarEdit_tipo':
            $id = $_POST['id'];
            $qEdit = mysqli_query($con, "SELECT * FROM deportes WHERE id = '$id'");
            $r = mysqli_fetch_array($qEdit);
            echo ($r["nombre"]);
            break;

        case 'changeVis':
            
            $id = $_POST['id'];
            $bbdd = $_POST['bbdd'];
            $checked = $_POST['checked'];
            mysqli_query($con, "UPDATE $bbdd SET visibilidad=$checked WHERE id=$id");
            break;

        case 'changeVisProd':
            $id = $_POST['id'];
            $bbdd = $_POST['bbdd'];
            $checked = $_POST['checked'];
            mysqli_query($con, "UPDATE $bbdd SET visibilidad=$checked WHERE idproducto=$id");
            break;
        
        default:
            
            break;
    }
    mysqli_close($con);
    

?>