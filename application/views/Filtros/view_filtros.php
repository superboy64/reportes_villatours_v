<style type="text/css">
  hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #ccc;
    margin: 1em 0;
    padding: 0; 
    }

  .checkbox {

      border: 0px solid #ffff;

  }
</style>

<div class="form-inline" id="content_filter" style="background-color: #eae8e8;
    padding-bottom: 8px;
    padding-left: 8px;
    border: 2px solid #bbb8b8;
    "> 
  
  <div class="form-group" id="div_select_multiple_sucursal">

      <label>Sucursal:&nbsp;</label><br>
      
      <select id="slc_mult_id_suc" multiple="multiple">
              <?php
                  foreach ($sucursales as &$valor){
                       
                       print_r('<option value="'.$valor['id_sucursal'].'">'.$valor['cve'].'</option>');

                  }
              ?>
      </select>
      
  </div>

  <div class="form-group" id="div_select_sucursal">

      <label>Sucursal:&nbsp;</label><br>
      
      <select class="form-control" id="slc_sucursal">
            <option value="0">seleccione</option>
              <?php
                  foreach ($sucursales as &$valor){

                       print_r('<option value="'.$valor['id_sucursal'].'">'.$valor['cve'].'</option>');

                  }
              ?>
      </select>

  </div>

  <div class="form-group" id="div_select_search_nombre_usuario">
    
    <label>Nombre usuario:&nbsp;</label><br>
    
    <select class="selectpicker show-menu-arrow" 
            data-style="form-control" 
            data-live-search="true" 
            title="-- Seleccionar --" id="slc_search_nombre_usuario">
      
      <?php 
        
        if(isset($usuarios)){

            foreach ($usuarios as &$valor){
                     
                print_r('<option data-tokens="'.$valor['nombre'].'">'.$valor['nombre'].'</option>');  //usuario
        
            }

        }
        

        
      ?>

    </select>

    
  </div>

  <div class="form-group" id="div_select_search_usuario">
    
    <label>Usuario:&nbsp;</label><br>
    
    <select class="selectpicker show-menu-arrow" 
            data-style="form-control" 
            data-live-search="true" 
            title="-- Seleccionar --" id="slc_search_usuario">
      <?php 
        
        if(isset($usuarios)){

          foreach ($usuarios as &$valor){
                       
              print_r('<option data-tokens="'.$valor['usuario'].'">'.$valor['usuario'].'</option>');  //usuario
          
          }

        }

        
      ?>
    </select>

    
  </div>

  <div class="form-group" id="div_select_search_departamento">
    
    <label>Departamento:&nbsp;</label><br>
    
    <select class="selectpicker show-menu-arrow" 
            data-style="form-control" 
            data-live-search="true" 
            title="-- Seleccionar --" id="slc_search_departamento">
      <?php 
        
        if(isset($usuarios)){

          foreach ($usuarios as &$valor){
                       
              print_r('<option data-tokens="'.$valor['perfil'].'">'.$valor['perfil'].'</option>');  //usuario
          
          }

        }

        
      ?>
    </select>

    
  </div>

  <div class="form-group" id="div_select_search_perfil">
        
    <label>Perfil:&nbsp;</label><br>
    
    <select class="selectpicker show-menu-arrow" 
            data-style="form-control" 
            data-live-search="true" 
            title="-- Seleccionar --" id="slc_search_perfil">
      
      <?php 
        
        if(isset($usuarios)){

          foreach ($usuarios as &$valor){
                       
              print_r('<option data-tokens="'.$valor['perfil'].'">'.$valor['perfil'].'</option>');  //usuario
          
          }

        }

      ?>

    </select>

    
  </div>

  <div class="form-group" id="div_select_search_plantilla">
    
    <label>Plantilla:&nbsp;</label><br>

    <select class="selectpicker show-menu-arrow" 
            data-style="form-control" 
            data-live-search="true" 
            title="-- Seleccionar --" id="slc_search_plantilla">
      <?php 
        
        if(isset($plantillas)){

          foreach ($plantillas as &$valor){
       
              print_r('<option data-tokens="'.$valor["nombre"].'">'.$valor["nombre"].'</option>');  //usuario
          
          }

        }

        
      ?>
    </select>
    
  </div>

  <div class="form-group" id="div_cliente_precompra">
    
    <label>Cliente precompra:&nbsp;</label><br>

    <input type="text" class="form-control" id="txt_cliente_precompra" placeholder="cliente precompra">
    
  </div>

  <div class="form-group" id="div_txt_asunto">
    
    <label>Asunto:&nbsp;</label><br>
    
    <input type="text" class="form-control" id="txt_asunto" placeholder="asunto">

    
  </div>

  <div class="form-group" id="div_txt_destinatario">
    
    <label>Destinatario:&nbsp;</label><br>
    
    <input type="text" class="form-control" id="txt_destinatario" placeholder="destinatario">

    
  </div>

  <div class="form-group" id="div_select_search_intervalo">
    
    <label>Intervalo:&nbsp;</label><br>
    
    <select class="form-control" style="width: 172px;" id="slc_intervalo">
      <option value="0">seleccione</option>
      <option value="1">diariamente</option>
      <option value="5">diariamente(24 hrs)</option>
      <option value="2">semanalmente</option>
      <option value="4">quincenal</option>
      <option value="3">mensualmente</option>   
    </select>

    
  </div>

  <div class="form-group" id="div_select_multiple_id_serie">
    <label>Id serie:&nbsp;</label><br>
    
    <select id="slc_mult_id_serie" multiple="multiple">

        <?php

          if(isset($rest_catalogo_series)){ 

            foreach ($rest_catalogo_series as &$valor){
               
               print_r('<option value="'.$valor['id_serie'].'">'.$valor['id_serie'].'</option>');
            
            }

          }
        
        ?>

    </select>
    
  </div>


  <div class="form-group" id="div_txt_id_cliente">
    <label>Cliente(DK):&nbsp;</label><br>
    
    <input type="text" class="form-control" id="txt_id_cliente">
    
  </div>

  <div class="form-group" id="div_select_multiple_id_cliente">
    <label>Cliente(DK):&nbsp;</label><br>
  
    <select id="slc_mult_id_cliente" multiple="multiple">

        <?php
            
            if(isset($rest_clientes)){ 

              foreach ($rest_clientes as &$valor){
                 
                 $cliente = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);

                 print_r('<option value="'.$cliente.'">'.$cliente.'</option>');
              
              }
            }
        
        ?>

    </select>
    
  </div>

  <div class="form-group" id="div_select_multiple_id_servicio">
    <label>Id servicio:&nbsp;</label><br>
    
    <select id="slc_mult_id_servicio" multiple="multiple">

        <?php
            
            if(isset($rest_catalogo_id_servicio)){ 

              foreach ($rest_catalogo_id_servicio as &$valor){
            
                 print_r('<option value="'.$valor['id_tipo_servicio'].'">'.$valor['id_tipo_servicio'].'</option>');
              
              }

            }
        
        ?>

    </select>
    
  </div>

  <div class="form-group" id="div_select_cat_provedor_CFDI">
    <label>Cat aereolinea:&nbsp;</label><br>
    
    <select id="slc_cat_provedor_CFDI" class="form-control">

                  <!--<option value="0">seleccione</option>-->
                  <option value="1">AEREOMEXICO</option>
                  <option value="2">OTRAS AEREOLINEAS</option>

    </select>
    
  </div>

  <div class="form-group" id="div_select_cat_provedor">
    <label>Cat aereolinea:&nbsp;</label><br>
    
    <select id="slc_select_cat_provedor" class="form-control">

                  <option value="0">seleccione</option>
                  <option value="1">CARGO</option>
                  <option value="2">BAJO COSTO</option>

    </select>
    
  </div>

  <div class="form-group" id="div_select_multiple_id_provedor_local">
    <label>Id provedor:&nbsp;</label><br>
    
    <select id="slc_mult_id_provedor_local" multiple="multiple">

        <?php
            
            if(isset($rest_catalogo_id_servicio_local)){ 

              foreach ($rest_catalogo_id_servicio_local as &$valor){
                 
                 print_r('<option value="'.$valor['id_aereolinea'].'">'.$valor['nombre_aereolinea'].'</option>');
              
              }

            }
        
        ?>

    </select>
    
  </div>

  <div class="form-group" id="div_select_multiple_id_servicio_ae">
    <label>Id servicio:&nbsp;</label><br>
    
    <select id="slc_mult_id_servicio_ae" multiple="multiple">

        <?php

            if(isset($rest_catalogo_id_servicio_aereo)){ 

              foreach ($rest_catalogo_id_servicio_aereo as &$valor){
            
                 print_r('<option value="'.$valor['id_tipo_servicio'].'">'.$valor['id_tipo_servicio'].'</option>');
              
              }
            }
        
        ?>

    </select>
    
  </div>

  <div class="form-group" id="div_select_id_servicio">
    <label>Id servicio:&nbsp;</label><br>
    

      <select id="slc_id_servicio" class="form-control">

          <?php
              
              if(isset($rest_catalogo_id_servicio_aereo)){ 

                foreach ($rest_catalogo_id_servicio_aereo as &$valor){
              
                   print_r('<option value="'.$valor['id_tipo_servicio'].'">'.$valor['id_tipo_servicio'].'</option>');
                
                }

              }
          
          ?>

      </select>

  
    
  </div>

  <div class="form-group" id="div_select_multiple_id_provedor">
    <label>Id provedor:&nbsp;</label><br>
  
    <select id="slc_mult_id_provedor" multiple="multiple">

        <?php
            
            if(isset($rest_catalogo_id_provedor)){ 

              foreach ($rest_catalogo_id_provedor as &$valor){
            
                 print_r('<option value="'.$valor['id_proveedor'].'">'.$valor['id_proveedor'].'</option>');
              
              }

            }
        
        ?>

    </select>
    
  </div>


  <div class="form-group" id="div_select_multiple_id_metodo_pago">
    <label>forma de pago:&nbsp;</label><br>
  
    <select id="slc_mult_id_metodo_pago" multiple="multiple">

        <?php
            
            if(isset($rest_catalogo_metodo_pago)){ 

              foreach ($rest_catalogo_metodo_pago as &$valor){
            
                 print_r('<option value="'.$valor['id_forma_pago'].'">'.$valor['id_forma_pago'].'</option>');
              
              }

            }
        
        ?>

    </select>
    
  </div>

  <div class="form-group" id="div_select_multiple_id_corporativo">
    <label>Id Corporativo:&nbsp;</label><br>
  
    <select id="slc_mult_id_corporativo" multiple="multiple">

        <?php
            
            if(isset($rest_catalogo_corporativo)){ 

              foreach ($rest_catalogo_corporativo as &$valor){
            
                 print_r('<option value="'.$valor['id_corporativo'].'">'.$valor['id_corporativo'].'</option>');
              
              }

            }
        
        ?>

    </select>
    
  </div>

  <div class="form-group" id="div_plantilla">
              
              <label>Plantilla</label><br>
                <select class="form-control" style="width: 172px;" id="slc_plantilla" name='slc_plantilla'>
                  <option value="0">seleccione</option>
                  <?php
                      
                      if(isset($rest_catalogo_plantillas)){ 

                        foreach ($rest_catalogo_plantillas as &$valor){
                      
                           print_r('<option value="'.$valor['id'].'">'.$valor['nombre'].'</option>');
                        
                        }

                      }
                  
                  ?>
                 
                </select>

  </div>

  <div class="form-group" id="div_rango_fechas">

    <label id="lbl_rango_fecha">Fecha:&nbsp;</label><br>

    <input class="form-control" type="text" name="birthdate" style="height: 34px; border: 1px solid #cccccc;text-align: center;
            border-radius: 5px;" id="datapicker_fecha1"/> <label id="lbl_rango_fecha_a">a</label>  
    <input class="form-control" type="text" name="birthdate" style="height: 34px; border: 1px solid #cccccc;text-align: center;
            border-radius: 5px;" id="datapicker_fecha2"/>
  </div>

  <div class="form-group" id="div_tipo_archivo">
              
              <label>Tipo de archivo</label><br>
                <select class="form-control" style="width: 172px;" id="slc_tipo_archivo" name='slc_tipo_archivo'>
                  <!--<option value="0">seleccione</option>-->
                  <option value="1">Excel</option>
                  <option value="2">Grafica</option>
                  <option value="3">Excel y Grafica</option>
                 
                </select>
  </div>

  <div class="form-group" id="div_btn_guardar">
     
    <button class="btn btn-default" style="margin-left: 0px; margin-top: 22px;" id="btn_buscar" onclick="buscar();"><i class="fa fa-search">&nbsp;Buscar</i></button>
    <button class="btn btn-default" style="margin-left: 15px; margin-top: 22px;" id="btn_buscar" onclick="clear_options_select();"><i class="fa fa-retweet">&nbsp;Limpiar</i></button>
   
  </div>
 
  <div class="form-group" id="div_btn_guardar_filtro">
     

  </div>
</div>

<br>

<script type="text/javascript">

$('.selectpicker').selectpicker({
    style: 'btn-default',
  });

 $('#slc_mult_id_cliente').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

 $('#slc_mult_id_servicio').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

 $('#slc_mult_id_provedor_local').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

  $('#slc_mult_id_metodo_pago').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

 $('#slc_mult_id_servicio_ae').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });
 
 $('#slc_mult_id_provedor').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

 $('#slc_mult_id_serie').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

 $('#slc_mult_id_suc').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });
 
 $('#slc_mult_id_corporativo').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

 
  ocultar_filtros();

  $(function() {
      $('input[name="birthdate"]').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          locale: {
            format: 'DD/MM/YYYY'
          }
      }, 
      function(start, end, label) {
          var years = moment().diff(start, 'years');
         
      });
  });

  
  function ocultar_filtros(){
       
    $("#div_select_id_serie").hide();
    $("#div_txt_id_cliente").hide();
    $("#div_select_id_corporativo").hide();
    $("#div_rango_fechas").hide();
    $("#div_btn_guardar").hide();
    $("#div_tipo_archivo").hide();
    $("#div_select_multiple_sucursal").hide();
    $("#div_select_multiple_id_cliente").hide();
    $("#div_select_multiple_id_serie").hide();
    $("#div_select_multiple_id_servicio").hide();
    $("#div_select_multiple_id_servicio_ae").hide();
    $("#div_select_id_servicio").hide();
    $("#div_select_multiple_id_provedor").hide();
    $("#div_select_multiple_id_provedor_amex").hide();
    $("#div_select_multiple_id_corporativo").hide();
    $("#div_select_search_nombre_usuario").hide();
    $("#div_select_search_usuario").hide();
    $("#div_select_search_departamento").hide();
    $("#div_select_search_perfil").hide();
    $("#div_select_search_plantilla").hide();
    $("#div_cliente_precompra").hide();
    $("#div_txt_asunto").hide();
    $("#div_txt_destinatario").hide();
    $("#div_select_search_intervalo").hide();
    $("#div_select_cat_provedor").hide();
    $("#div_select_cat_provedor_CFDI").hide();
    $("#div_select_sucursal").hide();
    $("#div_select_multiple_id_provedor_local").hide();
    $("#div_select_multiple_id_metodo_pago").hide();
    $("#div_plantilla").hide();

  }

  function clear_options_select(){

    $('#slc_mult_id_serie').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_cliente').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_corporativo').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_servicio').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_provedor_local').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_metodo_pago').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_servicio_ae').multiselect("deselectAll", false).multiselect("refresh");
    $('#slc_mult_id_provedor').multiselect("deselectAll", false).multiselect("refresh");
    $("#slc_plantilla").val("0");
    $("#slc_select_cat_provedor").val("0");

    $("#slc_sucursal").val("0");
    $("#slc_intervalo").val("0");
    $("#slc_cat_provedor_CFDI").val("0");
    $("#txt_asunto").val("");
    $("#txt_destinatario").val("");

    $('#slc_search_nombre_usuario').val('').selectpicker('refresh');
    $('#slc_search_usuario').val('').selectpicker('refresh');
    $('#slc_search_departamento').val('').selectpicker('refresh');
    $('#slc_search_perfil').val('').selectpicker('refresh');
    $('#slc_search_plantilla').val('').selectpicker('refresh');
    $("#txt_asunto").val("");
    $("#txt_destinatario").val("");
   
    $('input[name="birthdate"]').daterangepicker({
      singleDatePicker: true,
      startDate: moment(),
      endDate: moment(),
      showDropdowns: true,
      locale: {
        format: 'DD/MM/YYYY'
      }
    });

  }

  function obtener_valor_input(){
    
    var param = {};

    /************sucursal***********/

    var arr_mult_id_suc = $("#slc_mult_id_suc").val();

    var string_mult_id_suc = "";
    
     $.each(arr_mult_id_suc, function( index, value ) {

            string_mult_id_suc = string_mult_id_suc + value + '###';
            
        });

    param['fil_mult_id_suc'] = string_mult_id_suc;

    /************serie***********/

    var arr_mult_id_serie = $("#slc_mult_id_serie").val();

    var string_mult_id_serie = "";
    
     $.each(arr_mult_id_serie, function( index, value ) {

            string_mult_id_serie = string_mult_id_serie + value + '###';
            
        });

    param['fil_mult_id_serie'] = string_mult_id_serie;

    /************cliente***********/

    var arr_mult_id_cliente = $("#slc_mult_id_cliente").val();
    
    var string_mult_id_cliente = "";
    
     $.each(arr_mult_id_cliente, function( index, value ) {

            string_mult_id_cliente = string_mult_id_cliente + value + '##';
            
        });

    param['fil_mult_id_cliente'] = string_mult_id_cliente;

    /**********id corporativo***********/

    param['fil_id_corporativo'] = $("#select_id_corporativo").val();

    /**********tipo archivo***********/
   
    param['fil_tipo_archivo'] = $("#slc_tipo_archivo").val();
    
    /**********tipo archivo***********/
   
    param['fil_select_cat_servicio'] = $("#slc_select_cat_provedor").val();

    /***********servicio unico************/

    var id_servicio = $("#slc_id_servicio").val();

    param['fil_unic_id_servicio'] = id_servicio;

    /***********servicio multiple************/

    var arr_mult_id_servicio = $("#slc_mult_id_servicio").val();

    var string_mult_id_servicio = "";
    
     $.each(arr_mult_id_servicio, function( index, value ) {

            string_mult_id_servicio = string_mult_id_servicio + value + '####';
            
        });

    param['fil_mult_id_servicio'] = string_mult_id_servicio;

    /***********servicio multiple************/

    var arr_mult_id_provedor_amex = $("#slc_mult_id_provedor_local").val();

    var string_mult_id_provedor_amex = "";
    
     $.each(arr_mult_id_provedor_amex, function( index, value ) {

            string_mult_id_provedor_amex = string_mult_id_provedor_amex + value + '####';
            
        });

    param['fil_mult_id_provedor_amex'] = string_mult_id_provedor_amex;

    /***********servicio ae************/
    var arr_mult_id_servicio_ae = $("#slc_mult_id_servicio_ae").val();

    var string_mult_id_servicio_ae = "";
    
     $.each(arr_mult_id_servicio_ae, function( index, value ) {

            string_mult_id_servicio_ae = string_mult_id_servicio_ae + value + '####';
            
        });

    param['fil_mult_id_servicio_ae'] = string_mult_id_servicio_ae;


    /***********provedor************/

    var arr_mult_id_provedor = $("#slc_mult_id_provedor").val();

    var string_mult_id_provedor = "";
    
     $.each(arr_mult_id_provedor, function( index, value ) {

            string_mult_id_provedor = string_mult_id_provedor + value + '#####';
            
        });

    param['fil_mult_id_provedor'] = string_mult_id_provedor;

     /***********corporativo************/

    var arr_mult_id_corporativo = $("#slc_mult_id_corporativo").val();

    var string_mult_id_corporativo = "";
    
     $.each(arr_mult_id_corporativo, function( index, value ) {

            string_mult_id_corporativo = string_mult_id_corporativo + value + '######';
            
        });

    param['fil_mult_id_corporativo'] = string_mult_id_corporativo;

    /************plantilla****************/
    
    var id_plantilla = $("#slc_plantilla").val();

    param['fil_id_plantilla'] = id_plantilla;
    
    /************fechas****************/

    param['fil_fecha1'] = $("#datapicker_fecha1").val();
    param['fil_fecha2'] = $("#datapicker_fecha2").val();
   
    return param;


  }


</script>