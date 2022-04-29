<?php 
include_once("cabecera.php"); 

$id = $_SESSION['id'];

if (isset($_REQUEST['logout'])) {
    
    session_destroy();
    redir("login");
}

    $q = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id' ");
    $r = mysqli_fetch_array($q);

?>

<link rel="stylesheet" href="css/perfil.css" />

<form method="post" action="" id="perfilform">

<input type="hidden" class="form-control" name="id" value=" <?= $_SESSION['id'] ?>">

    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <div class="image-upload">
                        <p style="color: black">Foto de Perfil</p>
                        <label for="file-input">
                            
                            <img name="imagen" id="imagen" class="rounded-circle mt-5" width="150px" src="img/<?= $r['imagen'] ?>" alt ="Click aquí para subir tu foto" title ="Click aquí para subir tu foto"> 
                        </label>
                            <input id="file-input" name="imagen" type="file">
                    </div><br><br>
                    
                    <span class="font-weight-bold"><p><?= $r['nombre'] ?></p></span> <span class="text-black-50"><p><?= $r['email'] ?></p></span><span></span>

                   
                
                </div>
               
                    
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Ajustes del perfil</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Nombre</label><input type="text" class="form-control" name="nombre" placeholder="Nombre" value=" <?= $r['nombre'] ?>"></div>
                        <div class="col-md-6"><label class="labels">Apellidos</label><input type="text" class="form-control" name="ape"  value="<?= $r['apellidos'] ?>" placeholder="Apellidos"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">telefono Movil</label><input type="text" class="form-control" name="telefono" placeholder="telefono Movil" value="<?= $r['telefono'] ?>"><br></div>
                        <div class="col-md-12"><label class="labels">Direccion</label><input type="text" class="form-control" name="direccion" placeholder="Direccion" value="<?= $r['direccion'] ?>"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Pais</label><input type="text" class="form-control" name="pais" placeholder="Pais" value="<?= $r['pais'] ?>"></div>
                        <div class="col-md-6"><label class="labels">Provincia</label><input type="text" class="form-control" name="provincia" value="<?= $r['provincia'] ?>" placeholder="Provincia"></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Guardar cambios</button></div>
                </div>
            </div>
</form>
        <div class="col-md-4">
        
                <div class="p-3 py-5">

                    
                       <button type="button" class="btn btn-info margin"> <a href="verpedidosusuario" style="color: white;">
                            <i style="background:transparent; color: white;"></i>Ver Pedidos
                        </a></button>
                    
                    <br><br>
                    <form method="post" action="">
                        <button class="btn btn-danger margin" name="logout" type="submit">Cerrar sesión</button>
                    </form>
                    
                    

                </div>
            </div>

        

                    
    </div>
</div>




<script>
    $("#btnpedidos").on("click",function(event){
    event.preventDefault();
    // resto de tu codigo
 });

$("#perfilform").submit(function(event) {
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    var formData = new FormData(this);

    formData.append('action', 'perfil');


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

            setTimeout(function(){
                window.location.reload(1);
                }, 2600);
            loadingOf();    
                    
            Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Tu perefil se ha modificado correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                });
        },
    });

});
</script>