<?php
  
  require_once('configs/configStripe.php');


  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);
  $precio = $_SESSION["pago"]."00";
  $charge = \Stripe\Charge::create([
      'customer' => $customer->id,
      'amount'   => $precio,
      'currency' => 'eur',
  ]);

  
?>

<div class="alert alert-success" style="color: green;">
  <h2 class="alert-heading">Exito!</h2>
  <h1>El pago de <?= $_SESSION["pago"] ?> € se ha procesado correctamente.</h1> 
</div>

<form method="post" action="" id="finalizoform">

<input type="hidden" class="form-control" name="id" value=" <?= $_SESSION['idinsert'] ?>">
<input type="hidden" class="form-control" name="idusuario" value=" <?= $_SESSION['id'] ?>">

<button class="btn btn-primary profile-button" type="submit">Finalizar operacion</button>


</form>

<script>
$("#finalizoform").submit(function(event) {
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'cambiarestado');


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
                    title: 'Tu pedido se ha Finalizado. Recibira un correo con la confirmacion',
                    showConfirmButton: false,
                    timer: 2500
                });
        },
    });

});

</script>

