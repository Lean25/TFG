<?php
//include_once("cabecera.php");
//include "../configs/config.php";

$q = mysqli_query($con, "SELECT * FROM pedidos");

?>

<div id="div">
    <table>
        <thead>
            <tr class="mainTR">
                <th>Pedido</th>
                <th>Cliente</th>
                <th style="position: center;">Fecha</th>
                <th>Productos</th>
                <th>Estado</th>
                
                
            </tr>
        </thead>

        <?php while ($r = mysqli_fetch_array($q)) { ?>
        <tr id="tr_<?= $r['idpedido'] ?>">
            <td>
                <p style="margin-left: 30px;"><?php echo $r['idpedido']; ?></p>
            </td>
            <td>
                <p><?php echo $r['nombre']; ?></p>
            </td>
            <td>
            <p style="width: 120px" ><?php echo $r['fecha']; ?></p>
            </td>
            <td>
            <p style="width: 180px" ><?php echo $r['productos']; ?></p>
            </td>
            <td>
             <p  ><?php echo $r['estado']; ?></p>
            </td>
            <td>
            <a onclick="deletepedido('<?= $r['idpedido']; ?>')" class="btn btn-danger">Borrar</a>
                
            </td>
            
        </tr>
        <?php } ?>
    </table>
</div>

<script>
    
    function deletepedido(id) {
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
                'Este pedido ha sido eliminado.',
                'success'
            ).then(function() {
                $.post("configs/manejar_bbdd.php", {
                        id: id,
                        action: "eliminarpedido"
                    })
                    .done(function() {
                        $("#tr_" + id).remove();
                    });
            });
        }
    })
}
</script>