<?php
//include_once("cabecera.php");
//include "../configs/config.php";

$q = mysqli_query($con, "SELECT * FROM deportes");

?>
<script>

$(document).ready(function() {    

    $("#formEdit").submit(function(event) {
        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();

        var formData = new FormData(this);

		let id = $("div#transEdit input[name='idEdit']").val();

        formData.append('action', 'editar_tipos');
        formData.append('id', id);

        $.ajax({
            url: "configs/manejar_bbdd.php",
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
				var edit = $("#transEdit");
				edit.css("height", "0");
				
        		$nombre = $("div#transEdit input[name='name']").val();
				$imagen = $("div#transEdit input[name='imagen']").val().split('\\').pop();

				($imagen != "") ? $('tr#tr_' + id + " img").attr('src', "img/"+$imagen) : "";
				$('tr#tr_' + id + " p").html($nombre);
					
                $("#formEdit").trigger("reset");
				
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se ha modificado el deporte correctamente',
                    showConfirmButton: false,
                    timer: 1700
                });
            },
        });

    });
});

function deleteTipo(id,nombre) {
    Swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            Swal.fire(
                'Borrado!',
                'Este deporte ha sido eliminado.',
                'success'
            ).then(function() {
                $.post("configs/manejar_bbdd.php", {
                        id: id,
                        nombre: nombre,
                        action: "eliminar_tipos"
                    })
                    .done(function() {
                        $("#tr_" + id).remove();
                    });
            });
        }
    })
}

function editTipo(id) {
    $.post("configs/manejar_bbdd.php", {
        id: id,
        action: "mostrarEdit_tipo"
    }, function(data) {

        var edit = $("#transEdit");
        edit.css("display", "block");
        edit.css("height", "320px");

        $("div#transEdit input[name='idEdit']").val(id);
        $("div#transEdit input[name='name']").val(data);

        $('html, body').animate({
            scrollTop: 0
        }, 500);

    });
}

</script>


<form method="post" action="" id="formEdit" enctype="multipart/form-data" style="padding-top: 20px; ">
    <div class="centrarlog" id="transEdit" style="padding:0; display: none;">
	<input type="hidden" id="idEdit" name="idEdit" value = "" style="display:none;" readonly>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre de la seccion" value="" required>
        </div>

        <label>Cambiar Imagen</label>
        <div class="form-group">
            <input type="file" class="form-control-file" name="imagen" title="Portada del Deporte" placeholder="Image">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success" name="editar">Actualizar</button>
        </div>
    </div>
</form>

<table>
    <thead>
        <tr class="mainTR">
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Visibilidad</th>
            
            
        </tr>
    </thead>

    <?php while ($r = mysqli_fetch_array($q)) { ?>
    <tr id="tr_<?= $r['id'] ?>">
        <td>
            <img class="img_edit" src="img/<?= $r['imagen'] ?>"/>
        </td>
        <td><p><?php echo $r['nombre']; ?></p></td>
        <td>
            <input style="margin-left: 60px;" type="checkbox" onclick="changeVis('<?= $r['id']; ?>', this, 'deportes')" <?= ($r['visibilidad'] == 1) ? "checked" : "" ?>>
        </td>
        <td>
            <a onclick="editTipo('<?= $r['id']; ?>')" class="btn btn-success">Editar</a>
        </td>
        <td>
            <a onclick="deleteTipo('<?= $r['id']; ?>', '<?= $r['nombre']; ?>' )" class="btn btn-danger">Borrar</a>
        </td>
        
    </tr>
    <?php } ?>
</table>