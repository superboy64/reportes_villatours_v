<div class="row">

      <div class="col-md-12">
      
          <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_ficosa();"><span class="fa fa-file-text-o" style="color:#0ea4b3;"></span>&nbsp;TXT</button>
      
      </div>
      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%; overflow-x: auto;">
                       <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                       <table id="dg_rep_egencia_segments"></table>
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


  function get_layouts_egencia_data_import_sp(){
        
        $("#dg_rep_egencia_segments").clearGridData(true).trigger("reloadGrid");

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
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_segments/get_layouts_egencia_data_import_sp_parametros",
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
                       
                       $("#dg_rep_egencia_segments").jqGrid({
                          datatype: "local",
                          height: 500,
                          shrinkToFit:false,
                          forceFit:true,
                          colNames:['SegmentID', 'Link_Key','BookingID','DocumentNumber','Leg','AirlineCode','DepartCityCode','DepartDate','DepartTime','FlightNumber','ArriveCityCode','ArriveDate','ArriveTime','ConnectionCode','FareBasis','SegmentFare','Class','TicketDesignator','Mileage','SeatAssignment','EquipmentType'],
                          colModel:[

                                     {name:'SegmentID',index:'SegmentID',width: 250},
                                     {name:'Link_Key',index:'Link_Key',width: 250},
                                     {name:'BookingID',index:'BookingID',width: 250},
                                     {name:'DocumentNumber',index:'DocumentNumber',width: 250},
                                     {name:'Leg',index:'Leg',width: 250},
                                     {name:'AirlineCode',index:'AirlineCode',width: 250},
                                     {name:'DepartCityCode',index:'DepartCityCode',width: 250},
                                     {name:'DepartDate',index:'DepartDate',width: 250},
                                     {name:'DepartTime',index:'DepartTime',width: 250},
                                     {name:'FlightNumber',index:'FlightNumber',width: 250},
                                     {name:'ArriveCityCode',index:'ArriveCityCode',width: 250},
                                     {name:'ArriveDate',index:'ArriveDate',width: 250},
                                     {name:'ArriveTime',index:'ArriveTime',width: 250},
                                     {name:'ConnectionCode',index:'ConnectionCode',width: 250},
                                     {name:'FareBasis',index:'FareBasis',width: 250},
                                     {name:'SegmentFare',index:'SegmentFare',width: 250},
                                     {name:'Class',index:'Class',width: 250},
                                     {name:'TicketDesignator',index:'TicketDesignator',width: 250},
                                     {name:'Mileage',index:'Mileage',width: 250},
                                     {name:'SeatAssignment',index:'SeatAssignment',width: 250},
                                     {name:'EquipmentType',index:'EquipmentType',width: 250}


                          ],
                          multiselect: true,
                          caption: "egencia segments",
                          width: 1200,
                          pager: "#pg_ptoolbar",
                          viewrecords: true,

                          rowNum: 10000000,
                          pgbuttons: false,
                          pginput: false
                      });
      
                      
                      for(var i=0;i<=data['rep'].length;i++){
                          $("#dg_rep_egencia_segments").jqGrid('addRowData',i+1,data['rep'][i]);
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
                var tipo_funcion = 'ex';


                $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_segments/get_layouts_egencia_data_import_sp_parametros",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:'ex'},
                     beforeSend : function() {

                       $.blockUI({ 
                          message: '<h1> Obteniendo datos </h1>',
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
                                  
                        $.unblockUI();

                    },
                    success: function (data) {
  
                        window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_segments/exportar_txt_lay_egencia_data_import_sp');            

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }
                      
                });



           }

          

  }
      
  function buscar(){
    
    get_layouts_egencia_data_import_sp();
    
  }


</script>