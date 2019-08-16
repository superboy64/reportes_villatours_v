<?php
  
  $id_aereolinea_edit = $row_aereolinea[0]['id_aereolinea'];
  $codigo_bsp_edit = $row_aereolinea[0]['codigo_bsp'];

?>
<div class="row">

      <div class="col-md-12">
    
        <label>Categoria</label>
        <select id="slc_cat_aereolinea_edit" class="form-control">

          <?php  
            
              if($row_aereolinea[0]['id_categoria_aereolinea'] == 1){
                
          ?>

                  <option value="1" selected="selected">CARGO</option>
                  <option value="2">BAJO COSTO</option>

          <?php

              }else{
          
          ?>
      
                  <option value="1">CARGO</option>
                  <option value="2" selected="selected">BAJO COSTO</option>
          
          <?php
          
              }
          
          ?>

        </select>

        <input type="hidden" id="hidden_aereolinea_edit" value="<?=$id_aereolinea_edit?>">

      </div>

      <div class="col-md-12">
            
              <label>Codigo BSP:&nbsp;</label><br>
              <input type="text" class="form-control" id="txt_CODIGO_BSP_edit" value="<?=$codigo_bsp_edit?>">
              
            
      </div>
      <?php 
        if($row_aereolinea[0]['id_categoria_aereolinea'] == 1 && $codigo_bsp_edit == '306'){
      ?>
      <div class="col-md-12" id="div_cambio_prov_edit">
       
          <div class="form-check">
            <input class="form-check-input" type="radio" name="rad_cambio_prov_edit"  value="9K" checked>
            <label class="form-check-label">
              9K
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="rad_cambio_prov_edit"  value="CS">
            <label class="form-check-label">
              CS
            </label>
          </div>

      </div>

      <?php 
        }
      ?>


</div>

<script type="text/javascript">

	function mod_guardar_actualizacion_aereolineas_amex(){

	  var slc_cat_aereolinea_edit = $("#slc_cat_aereolinea_edit").val();
    var txt_CODIGO_BSP_edit = $("#txt_CODIGO_BSP_edit").val();
	  var hidden_aereolinea_edit = $("#hidden_aereolinea_edit").val();

    var rad_cambio_prov_edit = "";

    if(slc_cat_aereolinea_edit == '1'){

        if(txt_CODIGO_BSP_edit == '306'){

           rad_cambio_prov_edit = $('input[name="rad_cambio_prov_edit"]:checked').val();

        }

    }


	  $.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/guardar_actualizacion_aereolineas_amex", {slc_cat_aereolinea_edit:slc_cat_aereolinea_edit,txt_CODIGO_BSP_edit:txt_CODIGO_BSP_edit,hidden_aereolinea_edit:hidden_aereolinea_edit,rad_cambio_prov_edit:rad_cambio_prov_edit}, function(data){
          
        if(data == 1){

           swal('Tarjeta actualizacion correctamente');
           consulta_aereolineas('aereolineas AMEX');
           $('#myModal').modal('hide');

        }else{
        
           swal('Error al eliminar plantilla');
        
        }

    });
  


	}

  $("#txt_CODIGO_BSP_edit").blur(function(){

    var codigo_bsp = $(this).val();
    var cat_aereolinea = $("#slc_cat_aereolinea_edit").val();

    if(cat_aereolinea == '1'){

        if(codigo_bsp == '306'){

          $("#div_cambio_prov_edit").show();


        }else{

          $("#div_cambio_prov_edit").hide();

        }

    }else{

          $("#div_cambio_prov_edit").hide();

    }
    

  });

</script>

