<?php
  
  $id_aereolinea_edit = $row_aereolinea[0]['id_aereolinea'];
  $codigo_numerico_edit = $row_aereolinea[0]['codigo_numerico'];
  $codigo_timbre_edit = $row_aereolinea[0]['codigo_timbre'];

?>
<div class="row">

      <div class="col-md-12">
    
        <label>Categoria</label>
        <select id="slc_cat_aereolinea_edit" class="form-control">

          <?php  
              
              if($row_aereolinea[0]['id_categoria_aereolinea'] == 1){
                
          ?>

                  <option value="1" selected="selected">AEREOMEXICO</option>
                  <option value="2">OTRAS AEREOLINEAS</option>

          <?php

              }else{
          
          ?>
      
                  <option value="1">AEREOMEXICO</option>
                  <option value="2" selected="selected">OTRAS AEREOLINEAS</option>
          
          <?php
          
              }
          
          ?>

        </select>

        <input type="hidden" id="hidden_aereolinea_edit" value="<?=$id_aereolinea_edit?>">

      </div>

      <div class="col-md-12">
    
        <label>Categoria cuenta</label>
        <select id="slc_cat_cuenta_edit" class="form-control">

          <?php  
              
              if($row_aereolinea[0]['bajo_costo'] == 1){
                
          ?>
                  <option value="0">BSP</option>
                  <option value="1" selected="selected">BC</option>

          <?php

              }else{
          
          ?>
          
                  <option value="0" selected="selected">BSP</option>
                  <option value="1">BC</option>
          
          <?php
          
              }
          
          ?>

        </select>

      </div>

      <div class="col-md-12">
            
              <label>Codigo Numerico:&nbsp;</label><br>
              <input type="text" class="form-control" id="txt_CODIGO_NUMERICO_edit" value="<?=$codigo_numerico_edit?>">
              
      </div>

      <div class="col-md-12">
            
              <label>Codigo para timbrar:&nbsp;</label><br>
              <input type="text" class="form-control" id="txt_CODIGO_TIMBRE_edit" value="<?=$codigo_timbre_edit?>">
              
            
      </div>
     

</div>

<script type="text/javascript">

	function mod_guardar_actualizacion_aereolineas_CFDI(){

	  var slc_cat_aereolinea_edit = $("#slc_cat_aereolinea_edit").val();
    var slc_cat_cuenta_edit = $("#slc_cat_cuenta_edit").val();
    var txt_CODIGO_NUMERICO_edit = $("#txt_CODIGO_NUMERICO_edit").val();
    var txt_CODIGO_TIMBRE_edit = $("#txt_CODIGO_TIMBRE_edit").val();
	  var hidden_aereolinea_edit = $("#hidden_aereolinea_edit").val();

	  $.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_CFDI/guardar_actualizacion_aereolineas_CFDI", {slc_cat_aereolinea_edit:slc_cat_aereolinea_edit,slc_cat_cuenta_edit:slc_cat_cuenta_edit,txt_CODIGO_NUMERICO_edit:txt_CODIGO_NUMERICO_edit,txt_CODIGO_TIMBRE_edit:txt_CODIGO_TIMBRE_edit,hidden_aereolinea_edit:hidden_aereolinea_edit}, function(data){
          
        if(data == 1){

           swal('Aereolinea actualizacion correctamente');
           consulta_aereolineas_CFDI('aereolineas CFDI');

           $('#myModal').modal('hide');

        }else{
        
           swal('Error al actualizar plantilla');
        
        }

    });
  


	}


</script>

