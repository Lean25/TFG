<?php 
 
 require_once ('configs/configStripe.php');

 
if(isset($_SESSION['id']) != ''){

  

  $id = $_SESSION['id'];
      
  $q = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id' ");
  $r = mysqli_fetch_array($q);

?>

<form method="post" action="" id="envioform">

<input type="hidden" class="form-control" name="id" value=" <?= $_SESSION['id'] ?>">


                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Datos del envio</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Nombre</label><input type="text" class="form-control" name="nombre" placeholder="Nombre" value=" <?= $r['nombre'] ?>" required></div>
                        <div class="col-md-6"><label class="labels">Apellidos</label><input type="text" class="form-control" name="ape"  value="<?= $r['apellidos'] ?>" placeholder="Apellidos" required></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Correo electronico</label><input type="text" class="form-control" name="email" placeholder="Ejemplo@gmail.com" value="<?= $r['email'] ?>" required><br></div>
                        <div class="col-md-12"><label class="labels">Telefono Movil</label><input type="text" class="form-control" name="telefono" placeholder="Telefono Movil" value="<?= $r['telefono'] ?>" required><br></div>
                        <div class="col-md-12"><label class="labels">Direccion</label><input type="text" class="form-control" name="direccion" placeholder="Direccion" value="<?= $r['direccion'] ?>" required></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Pais</label><input type="text" class="form-control" name="pais" placeholder="Pais" value="<?= $r['pais'] ?>" required></div>
                        <div class="col-md-6"><label class="labels">Provincia</label><input type="text" class="form-control" name="provincia" value="<?= $r['provincia'] ?>" placeholder="Provincia" required></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Continuar con el pago</button></div>
                </div>
            </div>
</form>

<?php }
  else{?>
  <form method="post" action="" id="envioform">

<input type="hidden" class="form-control" name="id" value="">



                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Datos del envio</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Nombre</label><input type="text" class="form-control" name="nombre" placeholder="Nombre" value="" required></div>
                        <div class="col-md-6"><label class="labels">Apellidos</label><input type="text" class="form-control" name="ape"  value="" placeholder="Apellidos" required></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Correo electronico</label><input type="text" class="form-control" name="email" placeholder="Ejemplo@gmail.com" value="" required><br></div>
                        <div class="col-md-12"><label class="labels">Telefono Movil</label><input type="text" class="form-control" name="telefono" placeholder="Telefono Movil" value="" required><br></div>
                        <div class="col-md-12"><label class="labels">Direccion</label><input type="text" class="form-control" name="direccion" placeholder="Direccion" value="" required></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Pais</label><input type="text" class="form-control" name="pais" placeholder="Pais" value="" required></div>
                        <div class="col-md-6"><label class="labels">Provincia</label><input type="text" class="form-control" name="provincia" value="" placeholder="Provincia" required></div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="submit">Continuar con el pago</button>
                    </div>
                    
                </div>
            </div>
</form>

<?php 
} 

?>

<form action="charge" method="post">
    
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-description="Pago"
          data-amount="<?= $_SESSION["pago"] ?>00"
          data-locale="auto">

    </script>
    
</form>

<script>

    
$("#envioform").submit(function(event) {
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'envio');


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

            $(".stripe-button-el").click();
            

            loadingOf();    
                    
            Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Tu pedido se ha creado, por favor continua con el pago.',
                    showConfirmButton: false,
                    timer: 1800
                });
        },
    });

});
</script>