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
    width: 150px;
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

.form {
    background: #2a6b5b81;
    margin: 25px auto;
    padding: 20px;
    border: 5px solid #ccc;
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
</style>

    <?php
        
        
        if (isset($_REQUEST['logout'])) {
            session_destroy();
            redir("login");
        }
    
        
    if (isset($_SESSION['id'])) { //con sesión iniciada 
    ?>

    <div class="centrarlog">
            <a href="anadirdeporte">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-plus-circle" style="background:transparent;"></i>Añadir deporte</button>
            </a>
            <a href="editardeporte">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-edit" style="background:transparent;"></i>Editar deporte</button>
            </a><br>
            <a href="anadirproducto">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-plus-circle" style="background:transparent;"></i>Añadir Producto</button>
            </a>
            <a href="editarproducto">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-edit" style="background:transparent;"></i>Editar Producto</button>
            </a><br>
            <a href="verpedidos">
                <button class="btn btn-submit&&btn btn-dark margin"><i class="fa fa-search-plus" style="background:transparent;"></i>Ver Pedidos</button>
            </a>
            

            <form method="post" action="">
                <button class="btn btn-danger margin" name="logout" type="submit">Cerrar sesión</button>
            </form>
    </div>

<?php
    }else{
       redir("login");
    }
?>
