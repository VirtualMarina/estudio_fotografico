$(document).ready(Start);

function Start(){
	$(document).contextmenu(OcultarMenuPorDefecto);
	$(document).contextmenu(MenuContextual);
	$("button#borrar").click(ConfirmaBorrar);
	
}

function OcultarMenuPorDefecto(evento){
	evento.preventDefault();
}


function ConfirmaBorrar(evento){
    let texto;
    let confirmar = confirm("¿Seguro que desea borrar?");
    if (confirmar == true) {
        texto = "Se ha eliminado";
    } else {
        evento.preventDefault();
    }
    
}
