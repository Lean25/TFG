
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
    width: 150px;
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


<form method="post" action="" id="recuperar">

    <p for="">Recuperar Contraseña</p>
    <div class="form-element">
        
        <label>Email</label>
        <input type="email" size="25" placeholder="Email" name="email" required />
    </div>
    
    <button type="submit" name="enviar" value="enviar">Enviar</button><br><br>
    

</form>

<script>

$("#recuperar").submit(function(event) {
    
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'recuperar');


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
                    title: 'Tu correo se ha enviado correctamente.',
                    showConfirmButton: false,
                    timer: 1500
                });
        },


    });

});
</script>
    
