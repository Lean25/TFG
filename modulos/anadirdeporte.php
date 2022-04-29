<?php

include_once("cabecera.php");
?>

<form method="post" action="" id="formAdd" enctype="multipart/form-data">
    <div class="centrarlog">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre del deporte" required>
        </div>

        <label>Inserta foto</label>
        <div class="form-group">
            <input type="file" class="form-control-file" id="imagen" name="imagen" title="Portada del deporte"
                placeholder="Image" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Añadir Deporte</button>
        </div>
    </div>
</form>
<script>
$("#formAdd").submit(function(event) {

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);
    
    formData.append('action', 'añadirdeporte');

    $.ajax({
        url: "configs/manejar_bbdd.php",
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            $("#formAdd").trigger("reset");
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Se ha añadido el deporte correctamente.',
                showConfirmButton: false,
                timer: 1800
            });
        },
    });

});
</script>