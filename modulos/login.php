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

if(isset($_SESSION["id"]) && $_SESSION["tipo_usuario"] == 'admin'){
    redir("admin");
}else if(isset($_SESSION["id"]) && $_SESSION["tipo_usuario"] != 'admin'){
    redir("perfil");
}

//session_destroy();
//session_start();

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT * FROM usuarios WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    //print_r ($result);
    //echo $password;
    //$password_hash = password_hash($result['password'], PASSWORD_BCRYPT);


    if (!$result) {
        echo '<p class="error">La combinación de nombre de usuario y contraseña es incorrecta!</p>';
    } else {
        if (md5($password) == $result["pass"]) {
            
            $_SESSION['id'] = $result['id'];
            $_SESSION['tipo_usuario'] = $result['tipo'];

            echo '<p class="success">Enhorabuena, ha iniciado sesión.!</p>';
            
            
            if($result['tipo'] == 'admin'){
                redir("admin");
            }else{
                redir("perfil");
            }
            
        } else {
            echo '<p class="error">La combinación de nombre de usuario y contraseña es incorrecta!</p>';
        }
    }

}


?>

<form method="post" action="" name="signin-form">
    <div class="form-element">
        <label>Usuario</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
        <label>Contraseña</label>
        <input type="password" name="password" required />
    </div><br>
    <button type="submit" name="login" value="login">Iniciar sesion</button><br><br>
    <a id="a" href="registro">¿No tienes cuenta? Registrate Aqui </a><br><br>
    <a id="a" href="recuperarpass">¿Has olvidado tu contraseña? </a>
</form>
    
</body>
</html>