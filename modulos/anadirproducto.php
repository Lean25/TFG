<?php
//include_once("cabecera.php");
//include "../configs/config.php";

?>

<form method="post" action="" id="formAdd" enctype="multipart/form-data">
    <div class="centrarlog">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre del producto" required>
        </div>

        <div class="form-group">
            <textarea type="text" class="form-control" rows="3" name="descripcion"
                placeholder="Descripcion " required></textarea>
        </div>
        
        <div class="form-group">
            <?= combo("SELECT id, nombre FROM deportes", "deporte", $con, "")?>
        </div>

        <label>Inserta foto</label>
        <div class="form-group">
            <input type="file" class="form-control-file" id="imagen" name="imagen" title="Portada del producto"
                placeholder="Image" required>
        </div>

        <div class="form-group">
            <input type="file" class="form-control-file" id="imagenes" name="imagenes[]" title="Imagenes de muestra"
                placeholder="Images" multiple required>
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="cant" placeholder="Cantidad" required>
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="precio" placeholder="Precio" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Añadir producto</button>
        </div>
    </div>
</form>
<script>
$("#formAdd").submit(function(event) {

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'añadirproducto');

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
                title: 'El producto se ha añadido correctamente.',
                showConfirmButton: false,
                timer: 1800
            });
        },
    });

});
</script>