<?php
  
  $id_cliene_CFDI = $row_clientes_CFDI[0]['id'];

?>

<div class="col-md-12">
            
                <label>Factura a:&nbsp;</label><br>
              
                <select id="slc_tpo_factura_edit" class="form-control">

            	  <?php  
          
		              if($row_clientes_CFDI[0]['tpo_factura'] == 1){
		                
		          ?>

		                  <option value="1" selected="selected">CLIENTE</option>
                 		  <option value="2">VILLATOURS</option>

		          <?php

		              }else{
		          
		          ?>
		      			  
		      			  <option value="1">CLIENTE</option>
                 		  <option value="2" selected="selected">VILLATOURS</option>

		          
		          <?php
		          
		              }
		          
		          ?>



                </select>

                <input type="hidden" id="hidden_cliente_CFDI_edit" value="<?=$id_cliene_CFDI?>">
            
</div>

<br><br><br><br>

<script type="text/javascript">
	

function mod_guardar_actualizacion_clientes_CFDI() {

   var tpo_factura = $("#slc_tpo_factura_edit").val();
   var id_cliene_CFDI = $("#hidden_cliente_CFDI_edit").val();
   	
   $.post("<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/guardar_actualizacion_clientes_CFDI", {tpo_factura:tpo_factura,id_cliene_CFDI:id_cliene_CFDI}, function(data){

         if(data == 1){

          swal("Cliente guardado correctamente");

          clientes_CFDI('Clientes CFDI');

          $('#myModal').modal('hide');

         }else{

          swal("Error al guardar la cliente");

         }

    });


 }


</script>