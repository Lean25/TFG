
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
p{
    font-size: 2rem;
    font-family: 'Lato';
}
h1 {
    font-family: 'Passion One';
    font-size: 2rem;
    text-transform: uppercase;
}

label {
    
    display: inline-block;
    text-align: center;
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

<form method="post" action="" id="cambiar">

<input type="hidden" name="email" id="email" value="<?= $_REQUEST["email"]; ?>">

<div class="form-element">
    
    <label>Nueva Contraseña</label>
    <input type="password" size="25" name="password" pattern="^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$" title="La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula. Puede tener otros símbolos" required />
</div>
<div class="form-element">
    
    <label>Repite Contraseña</label>
    <input type="password" size="25" placeholder="" name="repitepassword" required />
</div>

<button type="submit" name="enviar" value="enviar">Enviar</button><br><br>


</form>
    
<script>

$("#cambiar").submit(function(event) {
    
    
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'cambiar');


    $.ajax({
        url: "configs/manejar_bbdd.php",
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            loadingOn();
        },
        success: function(data) {
            loadingOf();    
            
            Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Tu contraseña se ha cambiado correctamente.',
                    showConfirmButton: false,
                    timer: 1500
                });
                
        },


    });

});

</script>