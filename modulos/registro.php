<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php //include_once("cabecera.php"); ?>

<style>
    * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    
    text-align: center;
    width: 100%;
}

h1 {
    font-family: 'Passion One';
    font-size: 2rem;
    text-transform: uppercase;
}

label {
    width: 300px;
    display: inline-block;
    text-align: left;
    font-size: 1.5rem;
    font-family: 'Lato';
}

input {
    border: 2px solid #ccc;
    font-size: 1.5rem;
    font-weight: 100;
    font-family: 'Lato';
    padding: 10px;
}

form {
    background: rgba(255, 255, 255, 0.137);
    margin: 25px auto;
    padding: 20px;
    border: 5px solid rgba(0, 0, 0, 0);
    width: 500px;
}

div.form-element {
    margin: 20px 0;
}

button {
    padding: 10px;
    font-size: 1.5rem;
    font-family: 'Lato';
    font-weight: 100;
    background: yellowgreen;
    color: white;
    border: none;
}

p.success,
p.error {
    color: white;
    font-family: lato;
    background: yellowgreen;
    display: inline-block;
    padding: 2px 10px;
}

p.error {
    background: orangered;
}
form #a{
    color: white;
}
</style>
<body>

<?php


//session_start();

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $repeatPass = md5($_POST['repeatpassword']);
    $password = md5($_POST['password']);
    //$password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    if($password == $repeatPass){

        $query = $connection->prepare("SELECT * FROM usuarios WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount() > 0) {
            echo '<p class="error">La dirección de correo electrónico ya está registrada.!</p>';
        }
    
        if ($query->rowCount() == 0) {
            $query = $connection->prepare("INSERT INTO usuarios(username,pass,email) VALUES (:username,:password,:email)");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password", $password, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $result = $query->execute();
    
            if ($result) {
                echo '<p class="success">Tu registro se ha completado!</p>';
                
                redir('login');
                
            } else {
                echo '<p class="error">Algo salio mal!</p>';
            }
        }
    }else{
        echo '<p class="error">Las contraseñas no coinciden</p>';
    }
    
}

?>

<form method="post" action="" name="signup-form">
    <div class="form-element">
        <label>Usuario</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Correo</label>
        <input type="email" name="email" required />
    </div>
    <div class="form-element">
        <label>Contraseña</label>
        <input type="password" name="password" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" title="La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos" required />
    </div>
    <div class="form-element">
        <label>Repetir Contraseña</label>
        <input type="password" name="repeatpassword" required />
    </div>

    <button type="submit" name="register" value="register">Registrar</button><br><br>
    <a id="a" href="login">Iniciar Sesion</a>
</form>
    
</body>
</html>