
function validar_usuario(){

        var txt_usuario = $("#txt_usuario").val();
        var txt_password = $("#txt_password").val();
    	
        $.post("index.php/Cnt_general/validar_usuario",{txt_usuario: txt_usuario, txt_password: txt_password},function(data){
			
			 if(data == 1){

			 	window.location.href = "index.php/Cnt_general/inicio";

			 }else{

			 	swal('Usuario no encontrado en la base de datos');

			 }
			
		});
		
     
}

document.onkeyup = function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) { //Enter keycode
            validar_usuario();
        }
    }