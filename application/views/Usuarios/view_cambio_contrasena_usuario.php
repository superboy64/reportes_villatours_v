 <div class="form-group">
	    <label for="exampleInputEmail1">Contraseña actual:</label>
	    <input class="form-control" type="password" id="txt_password_actual" placeholder="Contraseña actual" >
 </div>
 <div class="form-group">
	    <label for="exampleInputEmail1">Nueva contraseña:</label>
	    <input class="form-control" type="password" id="txt_password_nuevo" placeholder="Nueva contraseña" >
 </div>
  <div class="form-group">
	    <label for="exampleInputEmail1">Confirmar Nueva contraseña:</label>
	    <input class="form-control" type="password" id="txt_confirmar_password" placeholder="Confirmar Nueva contraseña" >
 </div>
 
 <center><button onclick="update_password();" class="btn btn-primary">Guardar</button></center>


 <script>

 	function update_password(){

 		var txt_password_actual = $("#txt_password_actual").val();
 		var txt_password_nuevo = $("#txt_password_nuevo").val();
 		var txt_confirmar_password = $("#txt_confirmar_password").val();

 		if(txt_password_nuevo != txt_confirmar_password){

 			
 			swal('las contraseñas no coinciden');

 			$("#txt_password_nuevo").val("");
 			$("#txt_confirmar_password").val("");


 		}else{


	 		$.post("<?php echo base_url(); ?>index.php/Cnt_usuario/cambio_contrasena_usuario", {txt_password_actual: txt_password_actual,txt_password_nuevo:txt_password_nuevo,txt_confirmar_password:txt_confirmar_password}, function(data){
	              	

	             	if(data == 1){

	             		$('#myModal').modal('hide');
	             		swal('Actualizacion guardada correctamente');

	             	}else if(data == 2){

	             		$("#txt_password_actual").val("");
	             		swal('La contraseña actual no coincide');
	             		

	             	}else if(data == 0){
	             		
	             		$('#myModal').modal('hide');
	             		swal('Error en el proceso');

	             	}
	                
	               
	         });


		}

 	}


 </script>