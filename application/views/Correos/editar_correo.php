<script src="<?php echo base_url(); ?>referencias/Edit_text_area/js/jquery-te-1.4.0.min.js"></script>
<link href="<?php echo base_url(); ?>referencias/Edit_text_area/css/jquery-te-1.4.0.css" rel="stylesheet">

<script type="text/javascript">
 
  $('.jqte-test').jqte();
  // settings of status
  var jqteStatus = true;
  $(".status").click(function()
  {
    jqteStatus = jqteStatus ? false : true;
    $('.jqte-test').jqte({"status" : jqteStatus})
  });

  $(".jqte").css({"margin-top":"2px"});  //text area

  $(function() {
      $('input[name="txt_fecha"]').daterangepicker({
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

  $(function() {
      $('input[name="txt_dia_mes"]').daterangepicker({
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

</script>

<div class="row">

  <div class="col-md-6">

    <div class="form-group">
      <label>Destinatario</label>
      <input type="text" spellcheck="false" class="form-control" id="txt_destinatarios">
      <small id="emailHelp" class="form-text text-muted">para introducir varios correos utilizar el formato correo@prueba/correo@prueba2</small>
    </div>
    <div class="form-group">
      <label>Copia</label>
      <input type="text" spellcheck="false" class="form-control" id="txt_concopia">
      <small id="emailHelp" class="form-text text-muted">para introducir varios correos utilizar el formato correo@prueba/correo@prueba2</small>
    </div>
    <div class="form-group">
      <label>Asunto</label>
      <input type="text" spellcheck="false" class="form-control" id="txt_asunto">
    </div>

    <div class="form-group" id="div_intervalo">
       <label>Intervalo</label>
        <select class="form-control" id="slc_intervalo">
          <option value="0">seleccione</option>
          <option value="1">diariamente</option>
          <option value="5">diariamente(24 hrs)</option>
          <option value="2">semanalmente</option>
          <option value="4">quincenal</option>
          <option value="3">mensualmente</option>
        </select>
    </div>

    <div class="form-group" id="div_fecha_inicio">
      <label>Fecha Envio:&nbsp;</label><br>
      <input class="form-control" type="text" id="txt_fecha" name="txt_fecha" style="height: 34px; border: 1px solid #cccccc;text-align: center;border-radius: 5px;"/>
    </div>

    <div class="form-group" id="div_hora">
      <label>Hora:&nbsp;</label><br>
      <input class="form-control" type="time" id="txt_hora">
    </div>


  </div>


  <div class="col-md-12">
    <br>
    <div class="row">
      <div class="col-md-5">

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h1 class="panel-title" style="color: #fff;">
              

                <div class="col-md-12">
                 
                  <div class="row">

                    <div class="col-md-8">
                      Seleccionar un reporte
                    </div>
                   

                  </div>
                </div>

           
            </h1>
           
          </div>
          <div class="panel-body" style="height: 191px;overflow-y:hidden;" >
            <table id="dg_reportes" style="height: 191px; width: 300px"></table>
          </div>
        </div>

      </div>

      <div class="col-md-1">
           <center>

             <button type="button" class="btn btn-default" style="margin-top: 89px;" onclick="seleccionar();">

               &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

             </button>

             <button type="button" class="btn btn-default" style="margin-top: 8px;" onclick="deseleccionar();">

               &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

             </button>

           </center>
         
      </div>

      <div class="col-md-5">

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h1 class="panel-title" style="color: #fff;">Reportes seleccionados</h1>
           
          </div>
          <div class="panel-body" style="height: 191px;overflow-y:hidden;">
            
            <table id="dg_reportes_seleccionados" style="height: 191px;"></table>

          </div>
        </div>

      </div>

     </div>
  </div>
  

  <div class="col-md-12">
    
    <div class="col-md-12" id="div_text_area">
      <br>
      <label>Mensaje:&nbsp;</label>
      <textarea name="txt_msn" id="txt_msn" class="jqte-test" style="margin-top: 2px;"></textarea>
 
    </div>

  </div>

</div>


<!--modal global-->

               <div id="modal_edit_correo" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 30%;overflow:hidden;">
                  <div class="modal-dialog" role="document" id="modal_content_edit_correo" style="width: 50%;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modal_title_edit_correo">
                        </h5>
                      </div>
                      <div class="modal-body_" id="modal_body_edit_correo" style="margin-left: 13px;">
                       
                      </div>
                      <div class="modal-footer" id="modal_footer_edit_correo">
                        <button type="button" class="btn btn-primary" id="btn_modal_guardar">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_modal_cancelar">Cancelar</button>
                      </div>
                    </div>
                  </div>
              </div>

<!--fin modal-->
<input type="hidden" id="id_correo_aut">

<script type="text/javascript">
   
   var array_filtro = {};

   function formatField(value){
    
    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';

   }

   function get_catalogo_reportes(){

        var id_perfil = "<?php echo $id_perfil; ?>";

        var str_reportes_selec = ""; 

        var rows_reportes_selec = $('#dg_reportes_seleccionados').datagrid('getRows');
        
        $.each(rows_reportes_selec, function( index, value ) {

          str_reportes_selec = str_reportes_selec + value['id'] + '_';

                
        });
       
        $.post("<?php echo base_url(); ?>index.php/Cnt_correos/get_reportes_not_in", {id_perfil: id_perfil,str_reportes_selec:str_reportes_selec}, function(data){

            data = JSON.parse(data);

            $('#dg_reportes').datagrid({
              url:'#',
              data:data,
              onCheckAll: function(){
                var state = $(this).data('datagrid');
                state.selectedRows = $.extend(true,[],state.data.firstRows);
                state.checkedRows = $.extend(true,[],state.data.firstRows);
              },
              onUncheckAll: function(){
                var state = $(this).data('datagrid');
                state.selectedRows = [];
                state.checkedRows = [];
              },
              remoteSort:false,
              columns:[[ 

                  {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
                  {field:'id',title:'Id',formatter:formatField,sortable:true},
                  {field:'nombre',title:'Nombre',formatter:formatField,sortable:true},
                 
                 
              ]],onLoadSuccess:function(){
                  
                console.log("se cargaron los reportes correctamente");
              }
            });


        });


          

    }

    row_reportes_all =  [];

    function seleccionar(){

      //array_filtro = {};

      if($("#txt_destinatarios").val() == ''){

           swal('Favor de agregar un destinatario');

      }else if($("#txt_asunto").val() == ''){

           swal('Favor de agregar un asunto');
           
      }else if($("#slc_intervalo").val() == "0"){

           swal('Favor de seleccionar un Intervalo');
      
      }else if($("#txt_hora").val() == ""){

           swal('Favor de agregar una Hora');
      
      }else{
            
            var rows_reportes = $('#dg_reportes').datagrid('getSelections');

            var rows_reportes_selec = $('#dg_reportes_seleccionados').datagrid('getRows');

            var rows_reportes_all = $('#dg_reportes').datagrid('getRows');

              $.each(rows_reportes, function( index, value ) {
 
                  $('#dg_reportes_seleccionados').datagrid('appendRow',{ id: value['id'], nombre: value['nombre'], status:'A' });
                  
                
              });

              for (i = 0; i < rows_reportes_all.length; i++) {


                  $.each(rows_reportes, function( index2, value2 ) {

                    if(rows_reportes_all[i]['id'] == value2['id']){

                      $('#dg_reportes').datagrid('deleteRow', i);

                    }
                    
                
                  });


              }

                
         
        }


      }

    function reportes_not_in(){

            var rows_reportes_selec = $('#dg_reportes_seleccionados').datagrid('getRows');

            var ids_selec = '';
            
            $.each(rows_reportes_selec, function( index, value ) {
    
                ids_selec = ids_selec + value['id'] + ',';
               
            });

            var id_perfil = "<?php echo $id_perfil; ?>";

            $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/get_reportes_not_in", {ids_selec: ids_selec,id_perfil:id_perfil}, function(data){
          
                data = JSON.parse(data);
                $('#dg_reportes').datagrid({
                  url:"#",
                  data:data,
                  onCheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = $.extend(true,[],state.data.firstRows);
                    state.checkedRows = $.extend(true,[],state.data.firstRows);
                  },
                  onUncheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = [];
                    state.checkedRows = [];
                  },
                  remoteSort:false,
                  columns: [[
                    {field:'ck',title:'Id',checkbox:"true",formatter:formatField},
                    {field:'id',title:'Id',formatter:formatField,sortable:true},
                    {field:'nombre',title:'Reporte',formatter:formatField,sortable:true},
                  ]],onLoadSuccess:function(){
                  
                  console.log("problema solucionado 2");
                      
                }
              });
               
            });

    }
  
    function deseleccionar(){
      
      var rows_reportes_selec = $('#dg_reportes_seleccionados').datagrid('getSelections');

      var id_correo_aut = rows_reportes_selec[0]["id_correo_aut"];
      var id_rep = rows_reportes_selec[0]["id"];

      //$.post("<?php echo base_url(); ?>index.php/Cnt_correos/delete_fil", {id_correo_aut:id_correo_aut,id_rep:id_rep}, function(data){

          var rows_reportes_selec_all = $('#dg_reportes_seleccionados').datagrid('getRows');
     
          var $new_array_filtro = {};

           for (i = 0; i < rows_reportes_selec_all.length; i++) {

              $.each(rows_reportes_selec, function( index2, value2 ) {

                if(rows_reportes_selec_all[i]['id'] == value2['id']){

                    $('#dg_reportes_seleccionados').datagrid('deleteRow', i);

                    $.each(array_filtro, function( index3, value3 ) {

                       if(index3 != 'rep_'+value2['id'] ){

                          $new_array_filtro[index3] = value3;

                        
                       }

                    });


                }
                
            
              }); 
              
           }

           array_filtro = $new_array_filtro;
           

          console.log(array_filtro);
          reportes_not_in();

      //});  
    
    }


  function get_reportes_seleccionados(id_correo_aut){
    
    $.post("<?php echo base_url(); ?>index.php/Cnt_correos/get_reportes_seleccionados", {id_correo_aut:id_correo_aut}, function(data){

      data = JSON.parse(data);

      $('#dg_reportes_seleccionados').datagrid({
                  url:"#",
                  data:data,
                  singleSelect: true,
                  onCheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = $.extend(true,[],state.data.firstRows);
                    state.checkedRows = $.extend(true,[],state.data.firstRows);
                  },
                  onUncheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = [];
                    state.checkedRows = [];
                  },
                  remoteSort:false,
                  columns: [[
                    {field:'id',title:'Id',formatter:formatField,sortable:true},
                    {field:'nombre',title:'Nombre',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',
                         formatter: formatDetail
                      },
                    {field:'config_param',formatter:formatField,title:'Configurar',width:100,
                         
                         formatter: function(value,row,index){
                        
                         var d = '<a href="javascript:void(0)" onclick="ver_filtros('+row['id']+','+id_correo_aut+')"><i class="glyphicon glyphicon-cog" style="font-size: 21px;"></i></a>';
                        
                         return d;

                         }
                    },
                  ]],onLoadSuccess:function(){
                  
                    
                    get_catalogo_reportes();

                      
                }
            });



    });


  }

  function ver_filtros(id_reporte,id_correo_aut){
  
    var status_conf = $("#lbl_configurado_"+id_reporte).text();

      if(status_conf == 'D'){

        $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/get_filtros_temp_edicion", {id_reporte:id_reporte,id_correo_aut:id_correo_aut}, function(data){

            var filtros_temp = JSON.parse(data);
            
            obtener_filtros(id_reporte,filtros_temp);
                          
        });


      }else if(status_conf == 'E'){

       $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/get_filtros_temp", {id_reporte:id_reporte}, function(data){

            var filtros_temp = JSON.parse(data);
            
            obtener_filtros(id_reporte,filtros_temp);
                      
       });
            

      }else if(status_conf == 'A'){

            obtener_filtros(id_reporte);

      }
      

  }


  function obtener_filtros(id_reporte,filtros_temp = []){


    $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/get_filtros", {id_reporte:id_reporte}, function(get_filtros){
     
           $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/obtener_filtros", {id_reporte:id_reporte}, function(data){

                    data = JSON.parse(data);
                
                    $("#modal_body_edit_correo").html(get_filtros);
                    $("#modal_footer_edit_correo").hide();
                    $("#modal_title_edit_correo").html("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Configurar Filtro</h1></center>");
                    
                    $('#modal_edit_correo').modal({
                      backdrop: true,
                      show: true
                    });

                    if(data.length > 0){

                      if(Object.keys(filtros_temp).length > 0){

                        var fil_fecha1 =  filtros_temp['fil_fecha1'];
                        fil_fecha2 =  filtros_temp['fil_fecha2'];

                        var fil_id_plantilla =  filtros_temp['fil_id_plantilla'];

                        if( filtros_temp['fil_mult_id_suc'] != undefined ){ //se agrego validacion por que el filtro se añadio despues que los registros
                          
                          var fil_mult_id_suc =  filtros_temp['fil_mult_id_suc'];
                          fil_mult_id_suc = fil_mult_id_suc.split("###");
                          fil_mult_id_suc = fil_mult_id_suc.clean(""); 
                        
                        }

                        var fil_mult_id_cliente =  filtros_temp['fil_mult_id_cliente'];
                        fil_mult_id_cliente = fil_mult_id_cliente.split("##");
                        fil_mult_id_cliente = fil_mult_id_cliente.clean(""); 
                      
                        var fil_mult_id_corporativo =  filtros_temp['fil_mult_id_corporativo'];
                        fil_mult_id_corporativo = fil_mult_id_corporativo.split("######");
                        fil_mult_id_corporativo = fil_mult_id_corporativo.clean(""); 

                        var fil_mult_id_provedor =  filtros_temp['fil_mult_id_provedor'];
                        fil_mult_id_provedor = fil_mult_id_provedor.split("#####");
                        fil_mult_id_provedor = fil_mult_id_provedor.clean(""); 

                        var fil_mult_id_serie =  filtros_temp['fil_mult_id_serie'];
                        fil_mult_id_serie = fil_mult_id_serie.split("###");
                        fil_mult_id_serie = fil_mult_id_serie.clean(""); 

                        var fil_mult_id_servicio =  filtros_temp['fil_mult_id_servicio'];
                        fil_mult_id_servicio = fil_mult_id_servicio.split("####");
                        fil_mult_id_servicio = fil_mult_id_servicio.clean(""); 

                        var fil_mult_id_servicio_ae =  filtros_temp['fil_mult_id_servicio_ae'];
                        fil_mult_id_servicio_ae = fil_mult_id_servicio_ae.split("####");
                        fil_mult_id_servicio_ae = fil_mult_id_servicio_ae.clean(""); 

                        var fil_tipo_archivo =  filtros_temp['fil_tipo_archivo'];
                        
                        var fil_unic_id_servicio =  filtros_temp['fil_unic_id_servicio'];                        

                      }
                      

                      $.each(data, function( index, value ) { 
                              
                        $("#"+value['id_div']).show();

                        if(Object.keys(filtros_temp).length > 0){

                            if(value['id_div'] == 'div_rango_fechas'){

                              $("#datapicker_fecha1").val(fil_fecha1);
                              $("#datapicker_fecha2").val(fil_fecha2);

                            }else if(value['id_div'] == 'div_tipo_archivo'){

                              $("#slc_tipo_archivo").val(fil_tipo_archivo);

                            }else if(value['id_div'] == 'div_select_multiple_sucursal'){

                              set_data_filter(fil_mult_id_suc,'slc_mult_id_suc');
                              
                            }else if(value['id_div'] == 'div_select_multiple_id_cliente'){

                              set_data_filter(fil_mult_id_cliente,'slc_mult_id_cliente');
                              
                            }else if(value['id_div'] == 'div_select_multiple_id_serie'){

                              set_data_filter(fil_mult_id_serie,'slc_mult_id_serie');
                              
                            }else if(value['id_div'] == 'div_select_multiple_id_servicio'){

                               set_data_filter(fil_mult_id_servicio,'slc_mult_id_servicio');
                              
                            }else if(value['id_div'] == 'div_select_multiple_id_provedor'){

                              set_data_filter(fil_mult_id_provedor,'slc_mult_id_provedor');
                              
                            }else if(value['id_div'] == 'div_select_multiple_id_corporativo'){

                              set_data_filter(fil_mult_id_corporativo,'slc_mult_id_corporativo');
                              
                            }else if(value['id_div'] == 'div_plantilla'){

                              $("#slc_plantilla").val(fil_id_plantilla);
                              
                            }else if(value['id_div'] == 'div_select_id_servicio'){

                               $("#slc_id_servicio").val(fil_unic_id_servicio);
                              
                            }else if(value['id_div'] == 'div_select_multiple_id_servicio_ae'){
                              
                              set_data_filter(fil_mult_id_servicio_ae,'slc_mult_id_servicio_ae');
                              
                            }

                        }
                                         
                      });

                      function set_data_filter(valArr,input){

                          $('#'+input).multiselect('select', valArr,true);

                      }

                      var intervalo = $("#slc_intervalo").val();

                      if(intervalo == '5'){

                        $("#div_rango_fechas").hide();
                        
                      }else{

                        $("#div_rango_fechas").show();

                      }

                      var str_tipo_archivo = data[0]['tipo_archivo'];

                      var arr_tipo_archivo = str_tipo_archivo.split(",");

                      if(!arr_tipo_archivo.includes( '1' ) ){

                        $("#slc_tipo_archivo option[value='1']").remove();

                      }
                      if(!arr_tipo_archivo.includes( '2' ) ){

                        $("#slc_tipo_archivo option[value='2']").remove();

                      }
                      if(!arr_tipo_archivo.includes( '3' ) ){

                        $("#slc_tipo_archivo option[value='3']").remove();

                      }

                      $("#div_btn_guardar_filtro").append('<div id="btn_guardar_filtro"><br><button class="btn btn-primary" onclick="guardar_filtro('+id_reporte+');"><i class="fa fa-save">&nbsp;Guardar</i></button></div>');
                        
                    }
                  
                });
       });

  }


  function guardar_filtro(id_reporte){

    var status = 0;

    if(id_reporte == 5  || id_reporte == 6){

       var filtro_rep = obtener_valor_input();

       if(filtro_rep['fil_mult_id_cliente'] == '' && filtro_rep['fil_mult_id_corporativo'] == ''){

                swal('Favor de seleccionar algun cliente o corporativo');

       }else{

        var filtro_rep = obtener_valor_input();
      
        array_filtro['rep_'+id_reporte] = filtro_rep;

        $("#div_filtros").hide();
        $('#modal_edit_correo').modal('hide');

        $("#lbl_configurado_"+id_reporte).html("E");
        status = 1;

       }

    }else{
     
        var filtro_rep = obtener_valor_input();

        array_filtro['rep_'+id_reporte] = filtro_rep;

        $("#div_filtros").hide();
        $('#modal_edit_correo').modal('hide');

        $("#lbl_configurado_"+id_reporte).html("E");
        status = 1;

    }

    //console.log(array_filtro);

    if(status == 1){

        //validar cuando sea nuevo registro
        //validar cuando sea edicion
        $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/guardar_filtro_temp", {array_filtro:array_filtro,id_reporte:id_reporte}, function(data){

                           
        });
       
    }

  }

  function mod_guardar_actualizacion(){
    
    var destinatarios = $("#txt_destinatarios").val();
    var concopia = $("#txt_concopia").val();
    var asunto = $("#txt_asunto").val();
    var intervalo = $("#slc_intervalo").val();
    var fecha = $("#txt_fecha").val();
    var hora = $("#txt_hora").val();
    var mensaje = $("#txt_msn").val();

    var reporte = $('#dg_reportes_seleccionados').datagrid('getRows');
    
    var status = []; 
    $.each(reporte, function( index, value ) {

           var status_conf = $("#lbl_configurado_"+value['id']).text();

           if(status_conf == 'A'){

             status.push(value);

           }

        });

    if(status.length > 0){

          swal("Favor de llenar los filtros para el reporte agregado(A) --"+status[0]['nombre']+"--");

    }else{

          var filtro = array_filtro;

          var id_correo_aut = $('#id_correo_aut').val();
                 
          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_edicion_correos_programados", {destinatarios:destinatarios,concopia:concopia,asunto:asunto,intervalo:intervalo,fecha:fecha,hora:hora,mensaje:mensaje,id_correo_aut:id_correo_aut,reporte:reporte,filtro:filtro}, function(data){

            if(data == 1){

              swal("Informacion actualizada correctamente");
              $('#myModal').modal('hide');
              //consulta_correos_programados('Correos programados');

            }else{

              swal("Ocurrio un error al actualizar la informacion");

            }
           
          });

    }

    
  
  }

  function formatDetail(value,row){
      
      var status = 'D'; 

      if(row['status'] == 'A'){

         status = 'A'; 
      }
      
      var d = '<label style="color:#010101;" id="lbl_configurado_'+row.id+'">'+status+'</label>';
      return d;
    

    }

  Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
  });

  Array.prototype.removeItem = function (a) {
   for (var i = 0; i < this.length; i++) {
    if (this[i] == a) {
     for (var i2 = i; i2 < this.length - 1; i2++) {
      this[i2] = this[i2 + 1];
     }
     this.length = this.length - 1;
     return;
    }
   }
  };

  Array.prototype.clean = function( deleteValue ) {
  for ( var i = 0, j = this.length ; i < j; i++ ) {
    if ( this[ i ] == deleteValue ) {
      this.splice( i, 1 );
      i--;
    }
  }
  return this;
};

</script>
    
          
    
    

  