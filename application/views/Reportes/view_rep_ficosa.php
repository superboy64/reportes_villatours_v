<div class="row">

      <div class="col-md-12">
      
        <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_ficosa();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
            
      </div>
      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%; overflow-x: auto;">
                       <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                       <table id="dg_rep_ficosa"></table>
                       <div id="pg_ptoolbar" style="height: 2px;"></div>
                </div>
            
      </div>

</div>

<script type="text/javascript">
 
  $("#title").html('<?=$title?>');
  $("#div_select_multiple_sucursal").show();
  $("#div_select_multiple_id_serie").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_select_multiple_id_corporativo").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  //$("#div_plantilla").show();


  function get_rep_ficosa(){
        
        $("#dg_rep_ficosa").clearGridData(true).trigger("reloadGrid");

        var parametros = {};

            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();
                     
            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();

            if(id_cliente.length == 0 && id_corporativo == ''){

                swal('Favor de seleccionar algun cliente o corporativo');

            }else{

            var string_ids_suc = '';
            
            $.each(id_suc, function( index, value ) {

              string_ids_suc = string_ids_suc + value + '_';
            
            });

            var string_ids_serie = '';
            
            $.each(id_serie, function( index, value ) {

              string_ids_serie = string_ids_serie + value + '_';
            
            });

            var string_ids_cliente = '';
            
            $.each(id_cliente, function( index, value ) {

              string_ids_cliente = string_ids_cliente + value + '_';
            
            });

            var string_ids_servicio = '';
            
            $.each(id_servicio, function( index, value ) {

              string_ids_servicio = string_ids_servicio + value + '_';
            
            });

            var string_ids_provedor = '';
            
            $.each(id_provedor, function( index, value ) {

              string_ids_provedor = string_ids_provedor + value + '_';
            
            });

            var string_ids_corporativo = '';
            
            $.each(id_corporativo, function( index, value ) {

              string_ids_corporativo = string_ids_corporativo + value + '_';
            
            });

            var id_plantilla = $("#slc_plantilla").val();
            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();
                 
            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;

            var tipo_funcion = 'man';
                
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ficosa/get_reportes_ficosa",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:tipo_funcion},
                    beforeSend : function() {
                       $.blockUI({ 
                          message: '<h1> Consultando datos </h1>', 
                          css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                        } }); 
                    }, 
                    complete: function () {
                        //bc.find('.submit').removeClass('lock');
                         $.unblockUI();
                    },
                    success: function (data) {
                      data = JSON.parse(data);
                       
                      
                       $("#dg_rep_ficosa").jqGrid({
                          datatype: "local",
                          height: 500,
                          shrinkToFit:false,
                          forceFit:true,
                          colNames:['consecutivo','name', 'Nº Exp', 'destination','Date Origin', 'Nr doc.', 'solicitor', 'type_of_service', 'supplier', 'Product', 'final_user', 'ticket_number', 'typo_of_ticket', 'date emission', 'city', 'country', 'total emissions co2', 'total_Itinerary1', 'origin1', 'destina1', 'total_Itinerary2', 'origin2', 'destina2', 'total_Itinerary3', 'origin3', 'destina3', 'total_Itinerary4', 'origin4', 'destina4', 'total_Itinerary5', 'origin5', 'destina5', 'total_Itinerary6', 'origin6', 'destina6', 'total_Itinerary7', 'origin7', 'destina7', 'total_Itinerary8', 'origin8', 'destina8', 'total_Itinerary9', 'origin9', 'destina9', 'total_Itinerary10', 'origin10', 'destina10', 'Name Hotel', 'Check In Date', 'Check Out Date', 'Room Nigth', 'Breakfast (BB /OB)', 'Nr of Rooms', 'Type of Room', 'City', 'country', 'Car_class', 'Delivery_Date', 'Nr_days', 'Place_delivery', 'Place_delivery_back', 'Departure_date', 'buy in advance', 'PNR', 'CC', 'AC14'],
                          colModel:[

                                      {name:'consecutivo',index:'consecutivo',sorttype:"int",width: 250},
                                      {name:'name',index:'name',width: 250},
                                      {name:'nexp',index:'nexp',width: 250},
                                      {name:'destination',index:'destination',width: 250},
                                      {name:'fecha_salida_vu',index:'fecha_salida_vu',width: 250},
                                      {name:'documento',index:'documento',width: 250},
                                      {name:'solicitor',index:'solicitor',width: 250},
                                      {name:'type_of_service',index:'type_of_service',width: 250},
                                      {name:'supplier',index:'supplier',width: 250},
                                      {name:'codigo_producto',index:'codigo_producto',width: 250},
                                      {name:'final_user',index:'final_user',width: 250},
                                      {name:'ticket_number',index:'ticket_number',width: 250},
                                      {name:'typo_of_ticket',index:'typo_of_ticket',width: 250},
                                      {name:'fecha_emi',index:'fecha_emi',width: 250},
                                      {name:'city',index:'city',width: 250},
                                      {name:'country',index:'country',width: 250},
                                      {name:'total_emission',index:'total_emission',width: 250},
                                      //{name:'total_millas',index:'total_millas',width: 250},
                                      {name:'total_Itinerary1',index:'total_Itinerary1',width: 250},
                                      {name:'origin1',index:'origin1',width: 250},
                                      {name:'destina1',index:'destina1',width: 250},
                                      {name:'total_Itinerary2',index:'total_Itinerary2',width: 250},
                                      {name:'origin2',index:'origin2',width: 250},
                                      {name:'destina2',index:'destina2',width: 250},
                                      {name:'total_Itinerary3',index:'total_Itinerary3',width: 250},
                                      {name:'origin3',index:'origin3',width: 250},
                                      {name:'destina3',index:'destina3',width: 250},
                                      {name:'total_Itinerary4',index:'total_Itinerary4',width: 250},
                                      {name:'origin4',index:'origin4',width: 250},
                                      {name:'destina4',index:'destina4',width: 250},
                                      {name:'total_Itinerary5',index:'total_Itinerary5',width: 250},
                                      {name:'origin5',index:'origin5',width: 250},
                                      {name:'destina5',index:'destina5',width: 250},
                                      {name:'total_Itinerary6',index:'total_Itinerary6',width: 250},
                                      {name:'origin6',index:'origin6',width: 250},
                                      {name:'destina6',index:'destina6',width: 250},
                                      {name:'total_Itinerary7',index:'total_Itinerary7',width: 250},
                                      {name:'origin7',index:'origin7',width: 250},
                                      {name:'destina7',index:'destina7',width: 250},
                                      {name:'total_Itinerary8',index:'total_Itinerary8',width: 250},
                                      {name:'origin8',index:'origin8',width: 250},
                                      {name:'destina8',index:'destina8',width: 250},
                                      {name:'total_Itinerary9',index:'total_Itinerary9',width: 250},
                                      {name:'origin9',index:'origin9',width: 250},
                                      {name:'destina9',index:'destina9',width: 250},
                                      {name:'total_Itinerary10',index:'total_Itinerary10',width: 250},
                                      {name:'origin10',index:'origin10',width: 250},
                                      {name:'destina10',index:'destina10',width: 250},

                                      {name:'nombre_hotel',index:'nombre_hotel',width: 250},
                                      {name:'fecha_entrada',index:'fecha_entrada',width: 250},
                                      {name:'fecha_salida',index:'fecha_salida',width: 250},
                                      {name:'noches',index:'noches',width: 250},
                                      {name:'break_fast',index:'break_fast',width: 250},
                                      {name:'numero_hab',index:'numero_hab',width: 250},
                                      {name:'id_habitacion',index:'id_habitacion',width: 250},
                                      {name:'id_ciudad',index:'id_ciudad',width: 250},
                                      {name:'country',index:'country',width: 250},
                                      {name:'Car_class',index:'Car_class',width: 250},
                                      {name:'Delivery_Date',index:'Delivery_Date',width: 250},
                                      {name:'Nr_days',index:'Nr_days',width: 250},
                                      {name:'Place_delivery',index:'Place_delivery',width: 250},
                                      {name:'Place_delivery_back',index:'Place_delivery_back',width: 250},
                                      {name:'Departure_date',index:'Departure_date',width: 250},
                                      
                                      {name:'buy_in_advance',index:'buy_in_advance',width: 250},  //NUEVO CAMPO
                                      {name:'record_localizador',index:'record_localizador',width: 250},  //NUEVO CAMPO
                                      {name:'GVC_ID_CENTRO_COSTO',index:'GVC_ID_CENTRO_COSTO',width: 250},  //NUEVO CAMPO
                                      {name:'analisis14_cliente',index:'analisis14_cliente',width: 250}  //NUEVO CAMPO

                          ],
                          multiselect: true,
                          caption: "FICOSA",
                          width: 1200,
                          pager: "#pg_ptoolbar",
                          viewrecords: true,

                          rowNum: 10000000,
                          pgbuttons: false,
                          pginput: false
                      });
      
                      
                      for(var i=0;i<=data['rep'].length;i++){
                          $("#dg_rep_ficosa").jqGrid('addRowData',i+1,data['rep'][i]);
                      }

                    

              },
              error: function () {
                  $.unblockUI();
                  alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
              }
          });

        } // fin validacion cliente corporativo

    }


  
  function number_format(num,dig,dec,sep) {
    x=new Array();
    s=(num<0?"-":"");
    num=Math.abs(num).toFixed(dig).split(".");
    r=num[0].split("").reverse();
    for(var i=1;i<=r.length;i++){x.unshift(r[i-1]);if(i%3==0&&i!=r.length)x.unshift(sep);}
    return s+x.join("")+(num[1]?dec+num[1]:"");
  }


  function btn_exportar_excel_rep_ficosa(){

            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();

            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();
            
            var id_plantilla = $("#slc_plantilla").val();
            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();

           if(id_cliente.length == 0 && id_corporativo == ""){

                  swal('Favor de seleccionar algun cliente o corporativo');

            }else{

                var string_ids_suc = '';
            
                $.each(id_suc, function( index, value ) {

                  string_ids_suc = string_ids_suc + value + '_';
                
                });

                var string_ids_serie = '';
            
                $.each(id_serie, function( index, value ) {

                  string_ids_serie = string_ids_serie + value + '_';
                
                });
            
                var string_ids_cliente = '';
                
                $.each(id_cliente, function( index, value ) {

                  string_ids_cliente = string_ids_cliente + value + '_';
                
                });

                var string_ids_servicio = '';
                
                $.each(id_servicio, function( index, value ) {

                  string_ids_servicio = string_ids_servicio + value + '_';
                
                });

                var string_ids_provedor = '';
                
                $.each(id_provedor, function( index, value ) {

                  string_ids_provedor = string_ids_provedor + value + '_';
                
                });

                var string_ids_corporativo = '';
                
                $.each(id_corporativo, function( index, value ) {

                  string_ids_corporativo = string_ids_corporativo + value + '_';
                
                });
                
                var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;
                var tipo_funcion = 'rep';
                
                window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ficosa/exportar_excel_rep_ficosa?parametros='+parametros+'&tipo_funcion=rep');

                

           }

          

  }
      
  function buscar(){
    
    get_rep_ficosa();
    
  }


</script>