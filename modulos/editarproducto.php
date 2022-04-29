<?php
//include_once("cabecera.php");
//include "../configs/config.php";

$q = mysqli_query($con, "SELECT p.idproducto, p.imagen, p.nombre, d.nombre dnombre, p.visibilidad FROM productos p, deportes d where p.seccion = d.nombre order by p.seccion");

?>
<script>

$(document).ready(function() {    

    $("#formEdit").submit(function(event) {
        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();

        var formData = new FormData(this);

		let id = $("div#transEdit input[name='idEdit']").val();

        formData.append('action', 'editar');
        formData.append('idproducto', id);

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

				($imagen != "") ? $('tr#tr_' + id + " img").attr('src', "imgproductos/"+$imagen) : "";
				$('tr#tr_' + id + " p").html($nombre);
					
                $("#formEdit").trigger("reset");
				$("div#transEdit textarea[name='description']").html("");
				
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Tu producto se ha editado correctamente.',
                    showConfirmButton: false,
                    timer: 1800
                });
            },
        });

    });
});

function deleteProd(id) {
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
                'Este producto ha sido eliminado.',
                'success'
            ).then(function() {
                $.post("configs/manejar_bbdd.php", {
                        id: id,
                        action: "eliminar"
                    })
                    .done(function() {
                        $("#tr_" + id).remove();
                    });
            });
        }
    })
}

function editProd(id) {
    
    $.post("configs/manejar_bbdd.php", {
        id: id,
        action: "mostrarEdit"
    }, function(data) {
        let datEdit = new Array();
        datEdit = data.split(";");

        var edit = $("#transEdit");
        edit.css("display", "block");
        edit.css("height", "500px");
        edit.css("height", "500px");

        $("div#transEdit input[name='idEdit']").val(id);
        $("div#transEdit input[name='name']").val(datEdit[0]);
        $("div#transEdit textarea[name='description']").html(datEdit[1]);        
        $('div#transEdit select#deporte').val(datEdit[2]);
        $("div#transEdit input[name='cant']").val(datEdit[3]);
        $("div#transEdit input[name='precio']").val(datEdit[4]);

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
            <input type="text" class="form-control" name="name" placeholder="Nombre del producto" value="" required>
        </div>

        <div class="form-group">
            <textarea type="text" class="form-control" rows="3" name="description"
                placeholder="descripcion del producto" required></textarea>
        </div>

        <label>Cambiar portada</label>
        <div class="form-group">
            <input type="file" class="form-control-file" name="imagen" title="Portada del producto" placeholder="Image">
        </div>

        <div class="form-group">
            <input type="file" class="form-control-file" name="imagenes[]" title="Imagenes de muestra"
                placeholder="Images" multiple>
        </div>

        <div class="form-group">
            <?= combo("SELECT id, nombre FROM deportes", "deporte", $con, "")?>
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="cant" placeholder="Cantidad" required>
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="precio" placeholder="Precio" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success" name="editar">Actualizar</button>
        </div>
    </div>
</form>

<table style="width:80%;">
    <thead>
        <tr class="mainTR">
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Seccion</th>
            <th>Visibilidad</th>
            
        </tr>
    </thead>

    <?php while ($r = mysqli_fetch_array($q)) { ?>
    <tr id="tr_<?= $r['idproducto'] ?>">
        <td>
            <img class="img_edit" src="imgproductos/<?= $r['imagen'] ?>"/>
        </td>
        <td><p><?= $r['nombre']; ?></p></td>
        <td><p><?= $r['dnombre']; ?></p></td>
        <td>
            <input style="margin-left: 60px;" type="checkbox" onclick="changeVisProd('<?= $r['idproducto']; ?>', this, 'productos')" <?= ($r['visibilidad'] == 1) ? "checked" : "" ?>>
        </td>
        <td>
            <a onclick="editProd('<?= $r['idproducto']; ?>')" class="btn btn-success">Editar</a>
        </td>
        <td>
            <a onclick="deleteProd('<?= $r['idproducto']; ?>')" class="btn btn-danger">Borrar</a>
        </td>
        
        
    </tr>
    <?php } ?>
</table>