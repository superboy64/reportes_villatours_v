<?php

$id_cliente_edit = $row_tarjeta[0]['id_cliente'];


?>


<div class="row">

      <div class="col-md-12">

        <label>Numero de tarjeta</label>
        <div class="row">

          <div class="col-md-8">

            <input type="password" class="form-control" placeholder="Numero de tarjeta" id="num_tarjeta_edit">
            
          </div>

          <div class="col-md-4">

            <button class="btn btn-info" onclick="mostrarContrasena()"><i class="fa fa-eye"></i></button>

          </div>

        </div>

  		  <input type="hidden" id="hidden_cliente_edit" value="<?=$id_cliente_edit?>">

      </div>


</div>


<!--<button class="btn btn-primary" type="button" onclick="mostrarContrasena()">Mostrar Contraseña</button>-->

<script type="text/javascript">

	
	function mod_guardar_actualizacion_tarjetas(){

	  var num_tarjeta_edit = $("#num_tarjeta_edit").val();
	  var hidden_cliente_edit = $("#hidden_cliente_edit").val();

	  $.post("<?php echo base_url(); ?>index.php/Cnt_tarjetas/guardar_actualizacion_tarjetas", {num_tarjeta_edit:num_tarjeta_edit,hidden_cliente_edit:hidden_cliente_edit}, function(data){
          
          if(data == 1){

             swal('Tarjeta actualizacion correctamente');
             consulta_tarjetas('Tarjetas');
             $('#myModal').modal('hide');


          }else{
             swal('Error al eliminar plantilla');
          }

      });



	}


function mostrarContrasena(){
      var tipo = document.getElementById("num_tarjeta_edit");
      if(tipo.type == "password"){
          tipo.type = "text";
      }else{
          tipo.type = "password";
      }
}

</script>

