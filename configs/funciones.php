<?php

    function clear($var){
        htmlspecialchars($var);

        return $var;
    }

    function check_admin(){
        if(!isset($_SESSION['id'])){
            redir("./");
        }
    }

    function redir($var){
        ?>
        <script>
            window.location="<?=$var?>";
        </script>
        <?php
        die();
    }

    function alert($var){
        ?>
        <script>
            alert("<?=$var?>");
        </script>
        <?php
    }

    /*function addCest($cant, $id){
        $add = array(
            'ID'=>$id,
            'CANT'=>$cant
        );
        if (!isset($_SESSION['CARRITO'])) {
            //session_destroy();
            //session_start();
            $_SESSION['CARRITO'][0] = $add;
        } else {
            for ($i = 0; $i < $cant; $i++) {
                $numeroProductos = count($_SESSION['CARRITO']);
                $_SESSION['CARRITO'][$numeroProductos] = $add;
            }
        }
    }*/

    //Generar combo, la primera columna es el val, el otro el texto
    function combo($sql, $name, $con, $selected) {
        $result = "<select class='form-control' name='".$name."' id='".$name."' required>";
        $q = mysqli_query($con, $sql);
        while ($r = mysqli_fetch_row($q)) {
            $result .= "<option value='".$r[1]."' ".(($selected == $r[0]) ? "selected" : "").">".$r[1]."</option>";
        }
        $result .= "</select>";
        mysqli_close($con);
        return $result;
    }

    function generaTokenPass($user_id){
        $token = generateToken();
        $q = mysqli_query($con, "UPDATE usuarios SET usuarios");
    }

    function is_session_started(){
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}
?>