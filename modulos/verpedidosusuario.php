<?php
//include_once("cabecera.php");
//include "../configs/config.php";


$q = mysqli_query($con, "SELECT * FROM pedidos WHERE idcliente = '".$_SESSION["id"]."'");

?>

<table>
    <thead>
        <tr class="mainTR">
            <th>Pedido</th>
            
            <th>Fecha</th>
            <th>Productos</th>
            <th>Precio</th>
            <th>Estado</th>
            
            
        </tr>
    </thead>

    <?php while ($r = mysqli_fetch_array($q)) { ?>
    <tr id="tr_<?= $r['idpedido'] ?>">
        <td>
            <p style="margin-left: 30px;"><?php echo $r['idpedido']; ?></p>
        </td>
        <td>
        <p style="width: 120px" ><?php echo $r['fecha']; ?></p>
        </td>
        <td>
        <p style="width: 180px" ><?php echo $r['productos']; ?></p>
        </td>
        <td>
        <p style="margin-left: 15px;"><?php echo $r['precio']; ?></p>
        </td>
        <td>
        <p><?php echo $r['estado']; ?></p>
        </td>
        <td>
            <a onclick="devolverpedido('<?= $r['idpedido']; ?>')" class="btn btn-warning">Devolver</a>    
        </td>
        
    </tr>
    <?php } ?>
</table>


<script>
    
    function devolverpedido(id) {
    Swal.fire({
        title: '¿Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            setTimeout(function(){
                    window.location.reload(1);
                    }, 2500);
            Swal.fire(
                'Devolucion!',
                'Este pedido ha sido devuelto.',
                'success'
            ).then(function() {
                $.post("configs/manejar_bbdd.php", {
                        id: id,
                        action: "devolverpedido"
                    })
                    .done(function() {
                        $("#tr_" + id).update();
                        
                    });
            });
        }
    })
}
</script>