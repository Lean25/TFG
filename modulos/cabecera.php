   
<div id="cabecera">
        <div id="divMenu">
            <div id="logoleft">
                <a  href="menu"><img class="tamañologo" src="img/leon.png" alt=""></a>
                
            </div>
            <div id="login">
                <a href="login"><img class="tamañologin" src="img/acceso.png" alt=""></a>

            </div>
            <div id="carr">
                <a href="cart"><img class="tamañocarr" src="img/carro.png" alt=""></a>
            </div>

            <nav id="menu">
                <ul class="button">
                    <li><a href="menu" onclick="spinLoadOn()">Inicio</a></li>
                    <li><a href="tienda" onclick="spinLoadOn()">Deportes</a></li>
                    <li><a href="about" onclick="spinLoadOn()">Acerca de</a></li>
                    <li><a href="contacto" onclick="spinLoadOn()">Contacto</a></li>
                </ul>
            </nav>
            

            <div class="menu-mobile">
                <div id="MinavMobile" class="MiOverlayMobile">
                    <a href="javascript:void(0)" class="Miclosebtn" onclick="closeNav()">&times;</a>
                    <div class="MiOverlayMobile-content">
                        <a href="menu">Inicio</a>
                        <a href="tienda">Deportes</a>
                        <a href="about">Acerca de</a>
                        <a href="contacto">Contacto</a>
                    </div>
                </div>
                <span style="font-size:30px;cursor:pointer; margin-top:20px;" class="Miopenbtn" onclick="openNav()">&#9776;</span>

            </div>
        </div>
</div>

<script>
function openNav() {
    
  document.getElementById("MinavMobile").style.width = "100%";
}

function closeNav() {
  document.getElementById("MinavMobile").style.width = "0%";
}
</script>

