
<?php include_once("cabecera.php") ?>

<style>
    .loadingon{
    font-size: 50px;
    position: fixed;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    background-color: #0000007a;
    color: white;
    z-index: 999;
}
.loadingon i{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

<form method="post" action="" id="contactForm">
    <div class="centrarlog">
        <label>
            <h5><i class="fa fa-envelope"></i> Enviar mensaje</h5>
        </label>
        <div class="form-group">
            <span><i class="fa fa-user bigicon"></i></span><br><br>
            <input type="text" class="form-control" placeholder="Nombre" name="nombre" required />
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Apellidos" name="ape" required />
        </div>
        <div class="form-group">
            <span><i class="fa fa-envelope-o bigicon"></i></span><br><br>
            <input type="email" class="form-control" placeholder="Email" name="mail" required />
        </div>
        <div class="form-group">
            <span><i class="fa fa-phone-square bigicon"></i></span><br><br>
            <input type="number" minlenght="9" maxlenght="9" class="form-control" placeholder="Telefono" name="tel"
                required />
        </div>
        <div class="form-group">
            <span><i class="fa fa-pencil-square-o bigicon"></i></span><br><br>
            <textarea class="form-control" id="message" name="message"
                placeholder="Introduce tu mensaje aqui. Se le respondera en un plazo de 2 dias laborales." rows="7"
                required></textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-info" type="submit"><i class="fas fa-paper-plane"
                    style="background:transparent; color:white;"></i> Enviar</button>
        </div>
        
    </div>
</form>

<script>
$("#contactForm").submit(function(event) {
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'email');


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