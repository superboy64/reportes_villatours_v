<div class="row">

      <div class="col-md-12">
      
        <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_layout_segmentado();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
            
      </div>
      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
                   <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                   <table id="dg_rep_layout_segmentado" style="height: 90%;"></table>
                   <div id="pg_ptoolbar" style="height: 2px;"></div>
                </div>
            
      </div>

</div>


<script type="text/javascript">
      
  $("#title").html('<?=$title?>');

  $("#div_select_multiple_sucursal").show();
  $("#div_select_multiple_id_serie").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  $("#div_select_multiple_id_corporativo").show();
  $("#div_plantilla").show();

  
  function get_rep_layout_segmentado(){
    
       $("#dg_rep_layout_segmentado").jqGrid("clearGridData");
       $("#dg_rep_layout_segmentado").clearGridData(true).trigger("reloadGrid");
       var parametros = {};
            
            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();

            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();
            
            var id_plantilla = $("#slc_plantilla").val();

            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();
            
            if(id_cliente.length == 0 && id_corporativo ==  0){

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

            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_layout_seg/get_reportes_layout_seg",
                    type: 'POST',
                    data: {parametros:parametros},
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
                            
                            $("#dg_rep_layout_segmentado").jqGrid({
                                datatype: "local",
                                height: 500,
                                shrinkToFit:false,
                                forceFit:true,
                                colNames:['consecutivo','name','Nº Exp','destination','Date Origin','Nr doc.','solicitor','type_of_service','supplier','codigo_producto','final_user','ticket_number','typo_of_ticket','fecha emision','city','country','total emissions co2','total_millas','total_Itinerary1','origin1','destina1','aerolinea1','fecha_Salida_vu1','fecha_llegada1','hora_salida_vu1','hora_llegada_vu1','numero_vuelo1','clase_reservada1','total_Itinerary2','origin2','destina2','aerolinea2','fecha_Salida_vu2','fecha_llegada2','hora_salida_vu2','hora_llegada_vu2','numero_vuelo2','clase_reservada2','total_Itinerary3','origin3','destina3','aerolinea3','fecha_Salida_vu3','fecha_llegada3','hora_salida_vu3', 'hora_llegada_vu3','numero_vuelo3','clase_reservada3','total_Itinerary4','origin4','destina4','aerolinea4','fecha_Salida_vu4','fecha_llegada4','hora_salida_vu4','hora_llegada_vu4','numero_vuelo4','clase_reservada4','total_Itinerary5','origin5','destina5','aerolinea5','fecha_Salida_vu5','fecha_llegada5','hora_salida_vu5','hora_llegada_vu5','numero_vuelo5','clase_reservada5','total_Itinerary6','origin6','destina6','aerolinea6','fecha_Salida_vu6','fecha_llegada6','hora_salida_vu6','hora_llegada_vu6','numero_vuelo6','clase_reservada6','total_Itinerary7','origin7','destina7','aerolinea7','fecha_Salida_vu7','fecha_llegada7','hora_salida_vu7','hora_llegada_vu7','numero_vuelo7','clase_reservada7','total_Itinerary8','origin8','destina8','aerolinea8','fecha_Salida_vu8','fecha_llegada8','hora_salida_vu8','hora_llegada_vu8','numero_vuelo8','clase_reservada8','total_Itinerary9','origin9','destina9','aerolinea9','fecha_Salida_vu9','fecha_llegada9','hora_salida_vu9','hora_llegada_vu9','numero_vuelo9','clase_reservada9','total_Itinerary10','origin10','destina10','aerolinea10','fecha_Salida_vu10','fecha_llegada10','hora_salida_vu10','hora_llegada_vu10','numero_vuelo10','clase_reservada10','Name Hotel 1','Check In Date 1','Check Out Date 1','Room Nigth 1','Breakfast (BB /OB) 1','Nr of Rooms 1','Type of Room 1','City 1','country1','Name Hotel 2','Check In Date 2','Check Out Date 2','Room Nigth 2','Breakfast (BB /OB) 2','Nr of Rooms 2','Type of Room 2','City 2','country2','Name Hotel 3','Check In Date 3','Check Out Date 3','Room Nigth 3','Breakfast (BB /OB) 3','Nr of Rooms 3','Type of Room 3','City 3','country3','Name Hotel 4','Check In Date 4','Check Out Date 4','Room Nigth 4','Breakfast (BB /OB) 4','Nr of Rooms 4','Type of Room 4','City 4','country4','Name Hotel 5','Check In Date 5','Check Out Date 5','Room Nigth 5','Breakfast (BB /OB) 5','Nr of Rooms 5','Type of Room 5','City 5','country5','Name Hotel 6','Check In Date 6','Check Out Date 6','Room Nigth 6','Breakfast (BB /OB) 6','Nr of Rooms 6','Type of Room 6','City 6','country6','Name Hotel 7','Check In Date 7','Check Out Date 7','Room Nigth 7','Breakfast (BB /OB) 7','Nr of Rooms 7','Type of Room 7','City 7','country7','Name Hotel 8','Check In Date 8','Check Out Date 8','Room Nigth 8','Breakfast (BB /OB) 8','Nr of Rooms 8','Type of Room 8','City 8','country8','Name Hotel 9','Check In Date 9','Check Out Date 9','Room Nigth 9','Breakfast (BB /OB) 9','Nr of Rooms 9','Type of Room 9','City 9','country9','Name Hotel 10','Check In Date 10','Check Out Date 10','Room Nigth 10','Breakfast (BB /OB) 10','Nr of Rooms 10','Type of Room 10','City 10','country10','Car_class1','Delivery_Date1','Nr_days1','Place_delivery1','Place_delivery_back1','Departure_date1','Car_class2','Delivery_Date2','Nr_days2','Place_delivery2','Place_delivery_back2','Departure_date2','Car_class3','Delivery_Date3','Nr_days3','Place_delivery3','Place_delivery_back3','Departure_date3','Car_class4','Delivery_Date4','Nr_days4','Place_delivery4','Place_delivery_back4','Departure_date4','Car_class5','Delivery_Date5','Nr_days5','Place_delivery5','Place_delivery_back5','Departure_date5','Car_class6','Delivery_Date6','Nr_days6','Place_delivery6','Place_delivery_back6','Departure_date6','Car_class7','Delivery_Date7','Nr_days7','Place_delivery7','Place_delivery_back7','Departure_date7','Car_class8','Delivery_Date8','Nr_days8','Place_delivery8','Place_delivery_back8','Departure_date8','Car_class9','Delivery_Date9','Nr_days9','Place_delivery9','Place_delivery_back9','Departure_date9','Car_class10','Delivery_Date10','Nr_days10','Place_delivery10','Place_delivery_back10','Departure_date10','buy in advance','PNR','Fecha factura','emd'],
                                colModel:[


                                    {name:'consecutivo',index:'consecutivo',width: 250},
                                    {name:'name',index:'name',width: 250},
                                    {name:'nexp',index:'nexp',width: 250},
                                    {name:'destination',index:'destination',width: 250},
                                    {name:'fecha_salida',index:'fecha_salida',width: 250},
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
                                    {name:'total_millas',index:'total_millas',width: 250},
                                    

                                    {name:'total_Itinerary1',index:'total_Itinerary1',width: 250},
                                    {name:'origin1',index:'origin1',width: 250},
                                    {name:'destina1',index:'destina1',width: 250},

                                    {name:'aerolinea1',index:'aerolinea1',width: 250},
                                    {name:'fecha_Salida_vu1',index:'fecha_Salida_vu1',width: 250},
                                    {name:'fecha_llegada1',index:'fecha_llegada1',width: 250},
                                    {name:'hora_salida_vu1',index:'hora_salida_vu1',width: 250},
                                    {name:'hora_llegada_vu1',index:'hora_llegada_vu1',width: 250},
                                    {name:'numero_vuelo1',index:'numero_vuelo1',width: 250},
                                    {name:'clase_reservada1',index:'clase_reservada1',width: 250},
                

                                    {name:'total_Itinerary2',index:'total_Itinerary2',width: 250},
                                    {name:'origin2',index:'origin2',width: 250},
                                    {name:'destina2',index:'destina2',width: 250},

                                    {name:'aerolinea2',index:'aerolinea2',width: 250},
                                    {name:'fecha_Salida_vu2',index:'fecha_Salida_vu2',width: 250},
                                    {name:'fecha_llegada2',index:'fecha_llegada2',width: 250},
                                    {name:'hora_salida_vu2',index:'hora_salida_vu2',width: 250},
                                    {name:'hora_llegada_vu2',index:'hora_llegada_vu2',width: 250},
                                    {name:'numero_vuelo2',index:'numero_vuelo2',width: 250},
                                    {name:'clase_reservada2',index:'clase_reservada2',width: 250},


                                    {name:'total_Itinerary3',index:'total_Itinerary3',width: 250},
                                    {name:'origin3',index:'origin3',width: 250},
                                    {name:'destina3',index:'destina3',width: 250},

                                    {name:'aerolinea3',index:'aerolinea3',width: 250},
                                    {name:'fecha_Salida_vu3',index:'fecha_Salida_vu3',width: 250},
                                    {name:'fecha_llegada3',index:'fecha_llegada3',width: 250},
                                    {name:'hora_salida_vu3',index:'hora_salida_vu3',width: 250},
                                    {name:'hora_llegada_vu3',index:'hora_llegada_vu3',width: 250},
                                    {name:'numero_vuelo3',index:'numero_vuelo3',width: 250},
                                    {name:'clase_reservada3',index:'clase_reservada3',width: 250},


                                    {name:'total_Itinerary4',index:'total_Itinerary4',width: 250},
                                    {name:'origin4',index:'origin4',width: 250},
                                    {name:'destina4',index:'destina4',width: 250},

                                    {name:'aerolinea4',index:'aerolinea4',width: 250},
                                    {name:'fecha_Salida_vu4',index:'fecha_Salida_vu4',width: 250},
                                    {name:'fecha_llegada4',index:'fecha_llegada4',width: 250},
                                    {name:'hora_salida_vu4',index:'hora_salida_vu4',width: 250},
                                    {name:'hora_llegada_vu4',index:'hora_llegada_vu4',width: 250},
                                    {name:'numero_vuelo4',index:'numero_vuelo4',width: 250},
                                    {name:'clase_reservada4',index:'clase_reservada4',width: 250},


                                    {name:'total_Itinerary5',index:'total_Itinerary5',width: 250},
                                    {name:'origin5',index:'origin5',width: 250},
                                    {name:'destina5',index:'destina5',width: 250},

                                    {name:'aerolinea5',index:'aerolinea5',width: 250},
                                    {name:'fecha_Salida_vu5',index:'fecha_Salida_vu5',width: 250},
                                    {name:'fecha_llegada5',index:'fecha_llegada5',width: 250},
                                    {name:'hora_salida_vu5',index:'hora_salida_vu5',width: 250},
                                    {name:'hora_llegada_vu5',index:'hora_llegada_vu5',width: 250},
                                    {name:'numero_vuelo5',index:'numero_vuelo5',width: 250},
                                    {name:'clase_reservada5',index:'clase_reservada5',width: 250},


                                    {name:'total_Itinerary6',index:'total_Itinerary6',width: 250},
                                    {name:'origin6',index:'origin6',width: 250},
                                    {name:'destina6',index:'destina6',width: 250},

                                    {name:'aerolinea6',index:'aerolinea6',width: 250},
                                    {name:'fecha_Salida_vu6',index:'fecha_Salida_vu6',width: 250},
                                    {name:'fecha_llegada6',index:'fecha_llegada6',width: 250},
                                    {name:'hora_salida_vu6',index:'hora_salida_vu6',width: 250},
                                    {name:'hora_llegada_vu6',index:'hora_llegada_vu6',width: 250},
                                    {name:'numero_vuelo6',index:'numero_vuelo6',width: 250},
                                    {name:'clase_reservada6',index:'clase_reservada6',width: 250},

                                    {name:'total_Itinerary7',index:'total_Itinerary7',width: 250},
                                    {name:'origin7',index:'origin7',width: 250},
                                    {name:'destina7',index:'destina7',width: 250},

                                    {name:'aerolinea7',index:'aerolinea7',width: 250},
                                    {name:'fecha_Salida_vu7',index:'fecha_Salida_vu7',width: 250},
                                    {name:'fecha_llegada7',index:'fecha_llegada7',width: 250},
                                    {name:'hora_salida_vu7',index:'hora_salida_vu7',width: 250},
                                    {name:'hora_llegada_vu7',index:'hora_llegada_vu7',width: 250},
                                    {name:'numero_vuelo7',index:'numero_vuelo7',width: 250},
                                    {name:'clase_reservada7',index:'clase_reservada7',width: 250},

                                    {name:'total_Itinerary8',index:'total_Itinerary8',width: 250},
                                    {name:'origin8',index:'origin8',width: 250},
                                    {name:'destina8',index:'destina8',width: 250},

                                    {name:'aerolinea8',index:'aerolinea8',width: 250},
                                    {name:'fecha_Salida_vu8',index:'fecha_Salida_vu8',width: 250},
                                    {name:'fecha_llegada8',index:'fecha_llegada8',width: 250},
                                    {name:'hora_salida_vu8',index:'hora_salida_vu8',width: 250},
                                    {name:'hora_llegada_vu8',index:'hora_llegada_vu8',width: 250},
                                    {name:'numero_vuelo8',index:'numero_vuelo8',width: 250},
                                    {name:'clase_reservada8',index:'clase_reservada8',width: 250},

                                    {name:'total_Itinerary9',index:'total_Itinerary9',width: 250},
                                    {name:'origin9',index:'origin9',width: 250},
                                    {name:'destina9',index:'destina9',width: 250},

                                    {name:'aerolinea9',index:'aerolinea9',width: 250},
                                    {name:'fecha_Salida_vu9',index:'fecha_Salida_vu9',width: 250},
                                    {name:'fecha_llegada9',index:'fecha_llegada9',width: 250},
                                    {name:'hora_salida_vu9',index:'hora_salida_vu9',width: 250},
                                    {name:'hora_llegada_vu9',index:'hora_llegada_vu9',width: 250},
                                    {name:'numero_vuelo9',index:'numero_vuelo9',width: 250},
                                    {name:'clase_reservada9',index:'clase_reservada9',width: 250},


                                    {name:'total_Itinerary10',index:'total_Itinerary10',width: 250},
                                    {name:'origin10',index:'origin10',width: 250},
                                    {name:'destina10',index:'destina10',width: 250},

                                    {name:'aerolinea10',index:'aerolinea10',width: 250},
                                    {name:'fecha_Salida_vu10',index:'fecha_Salida_vu10',width: 250},
                                    {name:'fecha_llegada10',index:'fecha_llegada10',width: 250},
                                    {name:'hora_salida_vu10',index:'hora_salida_vu10',width: 250},
                                    {name:'hora_llegada_vu10',index:'hora_llegada_vu10',width: 250},
                                    {name:'numero_vuelo10',index:'numero_vuelo10',width: 250},
                                    {name:'clase_reservada10',index:'clase_reservada10',width: 250},

                                    {name:'hotel1',index:'hotel1',width: 250},
                                    {name:'fecha_entrada1',index:'fecha_entrada1',width: 250},
                                    {name:'fecha_salida1',index:'fecha_salida1',width: 250},
                                    {name:'noches1',index:'noches1',width: 250},
                                    {name:'break_fast1',index:'break_fast1',width: 250},
                                    {name:'numero_hab1',index:'numero_hab1',width: 250},
                                    {name:'id_habitacion1',index:'id_habitacion1',width: 250},
                                    {name:'id_ciudad1',index:'id_ciudad1',width: 250},
                                    {name:'country1',index:'country1',width: 250},
                                    {name:'hotel2',index:'hotel2',width: 250},
                                    {name:'fecha_entrada2',index:'fecha_entrada2',width: 250},
                                    {name:'fecha_salida2',index:'fecha_salida2',width: 250},
                                    {name:'noches2',index:'noches2',width: 250},
                                    {name:'break_fast2',index:'break_fast2',width: 250},
                                    {name:'numero_hab2',index:'numero_hab2',width: 250},
                                    {name:'id_habitacion2',index:'id_habitacion2',width: 250},
                                    {name:'id_ciudad2',index:'id_ciudad2',width: 250},
                                    {name:'country2',index:'country2',width: 250},
                                    {name:'hotel3',index:'hotel3',width: 250},
                                    {name:'fecha_entrada3',index:'fecha_entrada3',width: 250},
                                    {name:'fecha_salida3',index:'fecha_salida3',width: 250},
                                    {name:'noches3',index:'noches3',width: 250},
                                    {name:'break_fast3',index:'break_fast3',width: 250},
                                    {name:'numero_hab3',index:'numero_hab3',width: 250},
                                    {name:'id_habitacion3',index:'id_habitacion3',width: 250},
                                    {name:'id_ciudad3',index:'id_ciudad3',width: 250},
                                    {name:'country3',index:'country3',width: 250},
                                    {name:'hotel4',index:'hotel4',width: 250},
                                    {name:'fecha_entrada4',index:'fecha_entrada4',width: 250},
                                    {name:'fecha_salida4',index:'fecha_salida4',width: 250},
                                    {name:'noches4',index:'noches4',width: 250},
                                    {name:'break_fast4',index:'break_fast4',width: 250},
                                    {name:'numero_hab4',index:'numero_hab4',width: 250},
                                    {name:'id_habitacion4',index:'id_habitacion4',width: 250},
                                    {name:'id_ciudad4',index:'id_ciudad4',width: 250},
                                    {name:'country4',index:'country4',width: 250},
                                    {name:'hotel5',index:'hotel5',width: 250},
                                    {name:'fecha_entrada5',index:'fecha_entrada5',width: 250},
                                    {name:'fecha_salida5',index:'fecha_salida5',width: 250},
                                    {name:'noches5',index:'noches5',width: 250},
                                    {name:'break_fast5',index:'break_fast5',width: 250},
                                    {name:'numero_hab5',index:'numero_hab5',width: 250},
                                    {name:'id_habitacion5',index:'id_habitacion5',width: 250},
                                    {name:'id_ciudad5',index:'id_ciudad5',width: 250},
                                    {name:'country5',index:'country5',width: 250},
                                    {name:'hotel6',index:'hotel6',width: 250},
                                    {name:'fecha_entrada6',index:'fecha_entrada6',width: 250},
                                    {name:'fecha_salida6',index:'fecha_salida6',width: 250},
                                    {name:'noches6',index:'noches6',width: 250},
                                    {name:'break_fast6',index:'break_fast6',width: 250},
                                    {name:'numero_hab6',index:'numero_hab6',width: 250},
                                    {name:'id_habitacion6',index:'id_habitacion6',width: 250},
                                    {name:'id_ciudad6',index:'id_ciudad6',width: 250},
                                    {name:'country6',index:'country6',width: 250},
                                    {name:'hotel7',index:'hotel7',width: 250},
                                    {name:'fecha_entrada7',index:'fecha_entrada7',width: 250},
                                    {name:'fecha_salida7',index:'fecha_salida7',width: 250},
                                    {name:'noches7',index:'noches7',width: 250},
                                    {name:'break_fast7',index:'break_fast7',width: 250},
                                    {name:'numero_hab7',index:'numero_hab7',width: 250},
                                    {name:'id_habitacion7',index:'id_habitacion7',width: 250},
                                    {name:'id_ciudad7',index:'id_ciudad7',width: 250},
                                    {name:'country7',index:'country7',width: 250},
                                    {name:'hotel8',index:'hotel8',width: 250},
                                    {name:'fecha_entrada8',index:'fecha_entrada8',width: 250},
                                    {name:'fecha_salida8',index:'fecha_salida8',width: 250},
                                    {name:'noches8',index:'noches8',width: 250},
                                    {name:'break_fast8',index:'break_fast8',width: 250},
                                    {name:'numero_hab8',index:'numero_hab8',width: 250},
                                    {name:'id_habitacion8',index:'id_habitacion8',width: 250},
                                    {name:'id_ciudad8',index:'id_ciudad8',width: 250},
                                    {name:'country8',index:'country8',width: 250},
                                    {name:'hotel9',index:'hotel9',width: 250},
                                    {name:'fecha_entrada9',index:'fecha_entrada9',width: 250},
                                    {name:'fecha_salida9',index:'fecha_salida9',width: 250},
                                    {name:'noches9',index:'noches9',width: 250},
                                    {name:'break_fast9',index:'break_fast9',width: 250},
                                    {name:'numero_hab9',index:'numero_hab9',width: 250},
                                    {name:'id_habitacion9',index:'id_habitacion9',width: 250},
                                    {name:'id_ciudad9',index:'id_ciudad9',width: 250},
                                    {name:'country9',index:'country9',width: 250},
                                    {name:'hotel10',index:'hotel10',width: 250},
                                    {name:'fecha_entrada10',index:'fecha_entrada10',width: 250},
                                    {name:'fecha_salida10',index:'fecha_salida10',width: 250},
                                    {name:'noches10',index:'noches10',width: 250},
                                    {name:'break_fast10',index:'break_fast10',width: 250},
                                    {name:'numero_hab10',index:'numero_hab10',width: 250},
                                    {name:'id_habitacion10',index:'id_habitacion10',width: 250},
                                    {name:'id_ciudad10',index:'id_ciudad10',width: 250},
                                    {name:'country10',index:'country10',width: 250},
                                    {name:'Car_class1',index:'Car_class1',width: 250},
                                    {name:'Delivery_Date1',index:'Delivery_Date1',width: 250},
                                    {name:'Nr_days1',index:'Nr_days1',width: 250},
                                    {name:'Place_delivery1',index:'Place_delivery1',width: 250},
                                    {name:'Place_delivery_back1',index:'Place_delivery_back1',width: 250},
                                    {name:'Departure_date1',index:'Departure_date1',width: 250},
                                    {name:'Car_class2',index:'Car_class2',width: 250},
                                    {name:'Delivery_Date2',index:'Delivery_Date2',width: 250},
                                    {name:'Nr_days2',index:'Nr_days2',width: 250},
                                    {name:'Place_delivery2',index:'Place_delivery2',width: 250},
                                    {name:'Place_delivery_back2',index:'Place_delivery_back2',width: 250},
                                    {name:'Departure_date2',index:'Departure_date2',width: 250},
                                    {name:'Car_class3',index:'Car_class3',width: 250},
                                    {name:'Delivery_Date3',index:'Delivery_Date3',width: 250},
                                    {name:'Nr_days3',index:'Nr_days3',width: 250},
                                    {name:'Place_delivery3',index:'Place_delivery3',width: 250},
                                    {name:'Place_delivery_back3',index:'Place_delivery_back3',width: 250},
                                    {name:'Departure_date3',index:'Departure_date3',width: 250},
                                    {name:'Car_class4',index:'Car_class4',width: 250},
                                    {name:'Delivery_Date4',index:'Delivery_Date4',width: 250},
                                    {name:'Nr_days4',index:'Nr_days4',width: 250},
                                    {name:'Place_delivery4',index:'Place_delivery4',width: 250},
                                    {name:'Place_delivery_back4',index:'Place_delivery_back4',width: 250},
                                    {name:'Departure_date4',index:'Departure_date4',width: 250},
                                    {name:'Car_class5',index:'Car_class5',width: 250},
                                    {name:'Delivery_Date5',index:'Delivery_Date5',width: 250},
                                    {name:'Nr_days5',index:'Nr_days5',width: 250},
                                    {name:'Place_delivery5',index:'Place_delivery5',width: 250},
                                    {name:'Place_delivery_back5',index:'Place_delivery_back5',width: 250},
                                    {name:'Departure_date5',index:'Departure_date5',width: 250},
                                    {name:'Car_class6',index:'Car_class6',width: 250},
                                    {name:'Delivery_Date6',index:'Delivery_Date6',width: 250},
                                    {name:'Nr_days6',index:'Nr_days6',width: 250},
                                    {name:'Place_delivery6',index:'Place_delivery6',width: 250},
                                    {name:'Place_delivery_back6',index:'Place_delivery_back6',width: 250},
                                    {name:'Departure_date6',index:'Departure_date6',width: 250},
                                    {name:'Car_class7',index:'Car_class7',width: 250},
                                    {name:'Delivery_Date7',index:'Delivery_Date7',width: 250},
                                    {name:'Nr_days7',index:'Nr_days7',width: 250},
                                    {name:'Place_delivery7',index:'Place_delivery7',width: 250},
                                    {name:'Place_delivery_back7',index:'Place_delivery_back7',width: 250},
                                    {name:'Departure_date7',index:'Departure_date7',width: 250},
                                    {name:'Car_class8',index:'Car_class8',width: 250},
                                    {name:'Delivery_Date8',index:'Delivery_Date8',width: 250},
                                    {name:'Nr_days8',index:'Nr_days8',width: 250},
                                    {name:'Place_delivery8',index:'Place_delivery8',width: 250},
                                    {name:'Place_delivery_back8',index:'Place_delivery_back8',width: 250},
                                    {name:'Departure_date8',index:'Departure_date8',width: 250},
                                    {name:'Car_class9',index:'Car_class9',width: 250},
                                    {name:'Delivery_Date9',index:'Delivery_Date9',width: 250},
                                    {name:'Nr_days9',index:'Nr_days9',width: 250},
                                    {name:'Place_delivery9',index:'Place_delivery9',width: 250},
                                    {name:'Place_delivery_back9',index:'Place_delivery_back9',width: 250},
                                    {name:'Departure_date9',index:'Departure_date9',width: 250},
                                    {name:'Car_class10',index:'Car_class10',width: 250},
                                    {name:'Delivery_Date10',index:'Delivery_Date10',width: 250},
                                    {name:'Nr_days10',index:'Nr_days10',width: 250},
                                    {name:'Place_delivery10',index:'Place_delivery10',width: 250},
                                    {name:'Place_delivery_back10',index:'Place_delivery_back10',width: 250},
                                    {name:'Departure_date10',index:'Departure_date10',width: 250},

                                    {name:'buy_in_advance',index:'buy_in_advance',width: 250},  //NUEVO CAMPO
                                    {name:'record_localizador',index:'record_localizador',width: 250},  //NUEVO CAMPO  
                                    {name:'fecha_fac',index:'fecha_fac',width: 250},  //NUEVO CAMPO  
                                    {name:'emd',index:'Emd',width: 250}  //NUEVO CAMPO  


                                ],
                                multiselect: true,
                                caption: "Segmentado",
                                width: 1200,
                                pager: "#pg_ptoolbar",
                                viewrecords: true,

                                rowNum: 10000000,
                                pgbuttons: false,
                                pginput: false
                            });
                            
                            jQuery("#list").jqGrid('hideCol',["consecutivo"]);

                            for(var i=0;i<=data['rep'].length;i++){
                              $("#dg_rep_layout_segmentado").jqGrid('addRowData',i+1,data['rep'][i]);
                            }

                            $.each(data['col'], function( index, value ) {


                                $("#dg_rep_layout_segmentado").jqGrid('hideCol',value['nombre_columna_vista']);
                            
                            });

                            //ocultar columnas
                            //$("#dg_rep_layout_segmentado").jqGrid('hideCol',["consecutivo"]);

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }
                  });

            }

           
  }
  
  function number_format(num,dig,dec,sep) {
    x=new Array();
    s=(num<0?"-":"");
    num=Math.abs(num).toFixed(dig).split(".");
    r=num[0].split("").reverse();
    for(var i=1;i<=r.length;i++){x.unshift(r[i-1]);if(i%3==0&&i!=r.length)x.unshift(sep);}
    return s+x.join("")+(num[1]?dec+num[1]:"");
  }


  function btn_exportar_excel_rep_layout_segmentado(){

            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();

            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();
            
            var id_plantilla = $("#slc_plantilla").val();

            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();

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
                
                
                var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;
                var tipo_funcion = 'rep';

                window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_layout_seg/exportar_excel_rep_layout_segmentado?parametros='+parametros+'&tipo_funcion=rep');

                
           }

          

  }
      
  function buscar(){
    
    get_rep_layout_segmentado();
    
  }

</script>