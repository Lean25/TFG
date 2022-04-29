function toastError(texto) {
    $(".toast-body").html(texto);
    $('.toast').toast('show');

}

function loadingOn() {
    
    let loadingon = "<div class='loadingon'> <i class='fas fa-spinner fa-spin' aria-hidden='true'></i></div>";
    $("body").append(loadingon);
}

function loadingOf() {
    $("body .loadingon").remove();
    
}

function spinLoadOn() {
    $(".lds-ring").css("visibility", "visible");
    $(".cuerpo .container").empty();
}

function spinLoadOf() {
    $(".lds-ring").css("visibility", "hidden");
}

function changeVis(id, element, bbdd) {
    let checked = 0;
    if(element.checked) {
        checked = 1;
    }
    $.post("configs/manejar_bbdd.php", {
        id: id,
        bbdd: bbdd,
        checked: checked,
        action: "changeVis"
    });
}

function changeVisProd(idproducto, element, bbdd) {
    let checked = 0;
    if(element.checked) {
        checked = 1;
    }
    $.post("configs/manejar_bbdd.php", {
        id: idproducto,
        bbdd: bbdd,
        checked: checked,
        action: "changeVisProd"
    });
}



//Comprobar que el stock de los productos está ok
function testStock(cant = "", idCalc = "", cantExtra = ""){
    let valores = {
        action: "testStock",
        cant: cant,
        idCalc: idCalc,
        cantExtra: cantExtra
    };
    let returned = false;
    $.ajax({
        url: "configs/manejar_cesta.php",
        type: 'POST',
        async: false,
        data: valores,
        success: function(data) {
            
                $result = JSON.parse(data);     
                if($result["result"] == "ok"){
                    returned = true;
                    //handleData(data);
                }else if($result["result"] == "rok"){
                    error("¡Se ha producido un error! Intentelo de nuevo más tarde.");

                }else if($result["result"] == "noStock"){
                    error("Actualmente no tenemos stock suficiente para la cantidad seleccionada del producto '"+$result["name"]+"'.");
                }           
            
        },
    });
    return returned;
}
