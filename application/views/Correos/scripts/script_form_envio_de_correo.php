<script src="<?php echo base_url(); ?>referencias/Edit_text_area/js/jquery-te-1.4.0.min.js"></script>
<link href="<?php echo base_url(); ?>referencias/Edit_text_area/css/jquery-te-1.4.0.css" rel="stylesheet">

<script>
  
  function formatField(value){
    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  }
  //filtros
  limpiar_form_cron();
  var array_filtro = {};
  
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

	$('.jqte-test').jqte();
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});

	$(".jqte").css({"margin-top":"2px"});  //text area

  $("#div_text_area").hide();

  $('#tipo_msn').change(function() {
         
      var status = $(this).prop('checked');

      if(status == true){

          $("#div_text_area").show();

       }else if(status == false){

          $("#div_text_area").hide();
       
       }

  });

  get_catalogo_reportes();
  
	 function get_catalogo_reportes(id_per){

        var id_perfil = "<?php echo $id_perfil; ?>";

          $('#dg_reportes').datagrid({
              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/get_catalogo_reportes?id_perfil="+id_perfil,
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
                  
                $('#dg_reportes_seleccionados').datagrid({
                                url:"#",
                                data:[],
                                remoteSort:false,
                                columns: [[
                                  {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                                  {field:'reporte',title:'Reporte',formatter:formatField,sortable:true},
                                ]],onLoadSuccess:function(){
                                    
                                    row_clientes_all = [];
                                    console.log("problema solucionado1");

                                  }
                              });
  
              }
          });

    }

    row_reportes_all =  [];

    function seleccionar(){

      if($("#txt_destinatarios_correo").val() == ''){

           swal('Favor de agregar un destinatario');

      }else if($("#txt_asunto_correo").val() == ''){

           swal('Favor de agregar un asunto');
           
      }else if($("#slc_intervalo_correo").val() == "0"){

           swal('Favor de seleccionar un Intervalo');
      
      }else if($("#txt_hora").val() == ""){

           swal('Favor de agregar una Hora');
      
      }else{

            var rows_reportes = $('#dg_reportes').datagrid('getSelections');

            var rows_reportes_selec = $('#dg_reportes_seleccionados').datagrid('getRows');

            var rows_reportes_all = $('#dg_reportes').datagrid('getRows');

            if(rows_reportes_selec.length > 0){

              $.each(rows_reportes, function( index, value ) {
                
                  $('#dg_reportes_seleccionados').datagrid('appendRow',{ id: value['id'], nombre: value['nombre'], action:"SI" });
                  
                
              });

              for (i = 0; i < rows_reportes_all.length; i++) {


                  $.each(rows_reportes, function( index2, value2 ) {

                    if(rows_reportes_all[i]['id'] == value2['id']){

                      $('#dg_reportes').datagrid('deleteRow', i);

                    }
                    
                
                  });


              }

                
            }else{

                $.each(rows_reportes, function( index, value ) {
                
                  row_reportes_all.push(value);
                
                });

                  row_reportes_all = row_reportes_all.unique();

                  $('#dg_reportes_seleccionados').datagrid({
                      data:row_reportes_all,
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
                        {field:'nombre',title:'Reporte',formatter:formatField,sortable:true},
                        {field:'action',title:'Parametros configurados',
                             formatter: formatDetail
                          },
                        {field:'config_param',formatter:formatField,title:'Configurar',width:100,
                             
                             formatter: function(value,row,index){
                            
                             var d = '<a href="javascript:void(0)" onclick="ver_filtros('+row['id']+')"><i class="glyphicon glyphicon-cog" style="font-size: 21px;"></i></a>';
                            
                             return d;

                             }
                        },
                      ]],onLoadSuccess:function(){
                            
                            reportes_not_in();
                            

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


      function formatDetail(value,row){
        var d = '<label style="color:#010101;" id="lbl_configurado_'+row.id+'">NO</label>';
        return d;
      
      }

      function deseleccionar(){


      var rows_reportes_selec = $('#dg_reportes_seleccionados').datagrid('getSelections');

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
       

      //console.log(array_filtro);
      reportes_not_in();
    
    }



  function ver_filtros(id_reporte){

    var status_conf = $("#lbl_configurado_"+id_reporte).text();

     
      if(status_conf == 'SI'){

        $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/get_filtros_temp", {id_reporte:id_reporte}, function(data){

            var filtros_temp = JSON.parse(data);
            
            obtener_filtros(id_reporte,filtros_temp);
                          
        });


      }else{

            obtener_filtros(id_reporte);

      }
      

  }


  function obtener_filtros(id_reporte,filtros_temp = []){


    $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/get_filtros", {id_reporte:id_reporte}, function(get_filtros){
     
           $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/obtener_filtros", {id_reporte:id_reporte}, function(data){

                    data = JSON.parse(data);
                    rest_modal('');
                    $("#modal_body").append(get_filtros);

                    $("#modal_footer").hide();
                    $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Configurar Filtro</h1></center>");
                    $('#myModal').modal({
                        backdrop: false,
                        show: true
                      });

                    if(data.length > 0){

                      if(Object.keys(filtros_temp).length > 0){

                        var fil_fecha1 =  filtros_temp['fil_fecha1'];
                        fil_fecha2 =  filtros_temp['fil_fecha2'];

                        var fil_id_plantilla =  filtros_temp['fil_id_plantilla'];

                        var fil_mult_id_suc =  filtros_temp['fil_mult_id_suc'];
                        fil_mult_id_suc = fil_mult_id_suc.split("###");
                        fil_mult_id_suc = fil_mult_id_suc.clean(""); 
                        
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

                      var intervalo = $("#slc_intervalo_correo").val();

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
        $('#myModal').modal('hide');

        $("#lbl_configurado_"+id_reporte).html("SI");
        status = 1;

       }

    }else{

      var filtro_rep = obtener_valor_input();
      
      array_filtro['rep_'+id_reporte] = filtro_rep;

      $("#div_filtros").hide();
      $('#myModal').modal('hide');

      $("#lbl_configurado_"+id_reporte).html("SI");
      status = 1;

    }

    if(status == 1){


        $.post("<?php echo base_url(); ?>index.php/Cnt_filtros/guardar_filtro_temp", {array_filtro:array_filtro,id_reporte:id_reporte}, function(data){

                           
        });


    }
    


  }


  function guardar_config_envio_de_correos(){
  
    var reporte = $('#dg_reportes_seleccionados').datagrid('getRows');

    var status = []; 
    $.each(reporte, function( index, value ) {

           var status_conf = $("#lbl_configurado_"+value['id']).text();
           
           if(status_conf == 'NO'){

             status.push(value);

           }

                
        });

    if($("#txt_destinatarios_correo").val() == ''){

         swal('Favor de agregar un destinatario');

    }else if($("#txt_asunto_correo").val() == ''){

         swal('Favor de agregar un asunto');
         
    }else if(reporte.length == 0){

         swal('Favor de seleccionar un reporte');
    
    }else if($("#slc_intervalo_correo").val() == "0"){

         swal('Favor de seleccionar un Intervalo');
    
    }else if($("#txt_hora").val() == ""){

         swal('Favor de agregar una Hora');
    
    }else if(status.length > 0 ){

         swal('Favor de agregar filtros a los reportes seleccionados');
    
    }else if( $('#tipo_msn').prop('checked') == true && $("#txt_msn").val() == ""  ){

         swal('Favor de agregar una mensaje de correo');
    
    }else{

                var  dias = "";

                if( $('#check_lunes').is(':checked') ) {
                    dias = dias +"1/";
                }
                if( $('#check_martes').is(':checked') ) {
                    dias = dias + "2/";
                }
                if( $('#check_miercoles').is(':checked') ) {
                   dias = dias + "3/";
                }
                if( $('#check_jueves').is(':checked') ) {
                   dias = dias + "4/";
                }
                if( $('#check_viernes').is(':checked') ) {
                   dias = dias + "5/";
                }
                if( $('#check_sabado').is(':checked') ) {
                    dias = dias + "6/";
                }
                if( $('#check_domingo').is(':checked') ) {
                    dias = dias + "7/";
                }
                
               
                var destinatarios = $("#txt_destinatarios_correo").val();
                var concopia = $("#txt_concopia_correo").val();
                var asunto = $("#txt_asunto_correo").val();
                var intervalo = $("#slc_intervalo_correo").val();
                var fecha = $("#txt_fecha").val();
                var hora = $("#txt_hora").val();
                var mensaje = $("#txt_msn").val();
                var dia_mes = $("#txt_dia_mes").val();
                var reporte = $('#dg_reportes_seleccionados').datagrid('getRows');
                var tipo_msn = $('#tipo_msn').prop('checked');
                if(tipo_msn == true){

                  tipo_msn = 1;

                }else{

                  tipo_msn = 0;
                }

                var filtro = array_filtro;

                $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_config_envio_de_correos", {destinatarios: destinatarios,concopia:concopia,asunto:asunto,intervalo:intervalo,fecha:fecha,hora:hora,reporte:reporte,tipo_msn:tipo_msn,mensaje:mensaje,dias:dias,dia_mes:dia_mes,filtro:filtro}, function(data){

                    if(data == 1){
                       $('#dg').datagrid('reload');
                       swal('Configuración guardada correctamente');
                       prueba_correos('Automatización - Envio de correos');
                    }else{
                       swal('Error en el proceso');
                    }
                    
                });

    }

  }

  function prueba_envio(){

    $.post("<?php echo base_url(); ?>index.php/Cnt_correos/prueba_envio", {}, function(data){
      
          });

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

  function limpiar_form_cron(){

    $("#div_dia_semana").hide();
    $("#div_dia_mes").hide();
  
  }


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

