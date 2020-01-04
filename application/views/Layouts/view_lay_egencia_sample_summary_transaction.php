<div class="row">

      <div class="col-md-12">
      
          <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_ficosa();"><span class="fa fa-file-text-o" style="color:#0ea4b3;"></span>&nbsp;TXT</button>
      
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


  function get_layouts_egencia_data_import_sp(){
        
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
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_sample_summary_transaction/get_layouts_egencia_data_import_sp_parametros",
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
                          colNames:['Partner_Code','Partner_Name','Country_Code','Currency_Code','Transaction_Year','Transaction_Month_Number','Client_ID','Client_Name','Domestic_International','Air_Net_Expense_Amount','Air_Net_Ticket_Count'  ,'Air_Original_Ticket_Count','Air_Advance_Purchase_Days_Count','Train_Net_Expense_Amount','Train_Net_Ticket_Count','Train_Original_Ticket_Count','Train_Advance_Purchase_Days_Count','Hotel_Net_Base_Amount','Hotel_Net_Booking_Count','Hotel_Original_Booking_Count','Hotel_Net_Nights_Count','Car_Net_Base_Amount','Car_Net_Booking_Count','Car_Original_Booking_Count','Car_Net_Days_Count','Towncar_Net_Expense_Amount','Towncar_Net_Booking_Count','Towncar_Original_Booking_Count','Other_Ground_Transportation_Net_Expense_Amount','Other_Ground_Transportation_Net_Booking_Count ','Other_Ground_Transportation_Original_Booking_Count','Other_Services_Net_Expense_Amount','Other_Services_Net_Booking_Count'],
                          colModel:[

                                {name:'Partner_Code',index:'Partner_Code',width: 250},
                                {name:'Partner_Name',index:'Partner_Code',width: 250},
                                {name:'Country_Code',index:'Partner_Code',width: 250},
                                {name:'Currency_Code',index:'Partner_Code',width: 250},
                                {name:'Transaction_Year',index:'Partner_Code',width: 250},
                                {name:'Transaction_Month_Number',index:'Partner_Code',width: 250},
                                {name:'Client_ID',index:'Partner_Code',width: 250},
                                {name:'Client_Name',index:'Partner_Code',width: 250},
                                {name:'Domestic_International',index:'Partner_Code',width: 250},
                                {name:'Air_Net_Expense_Amount',index:'Partner_Code',width: 250},
                                {name:'Air_Net_Ticket_Count',index:'Partner_Code',width: 250},
                                {name:'Air_Original_Ticket_Count',index:'Partner_Code',width: 250},
                                {name:'Air_Advance_Purchase_Days_Count',index:'Partner_Code',width: 250},
                                {name:'Train_Net_Expense_Amount',index:'Partner_Code',width: 250},
                                {name:'Train_Net_Ticket_Count',index:'Partner_Code',width: 250},
                                {name:'Train_Original_Ticket_Count',index:'Partner_Code',width: 250},
                                {name:'Train_Advance_Purchase_Days_Count',index:'Partner_Code',width: 250},
                                {name:'Hotel_Net_Base_Amount',index:'Partner_Code',width: 250},
                                {name:'Hotel_Net_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Hotel_Original_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Hotel_Net_Nights_Count',index:'Partner_Code',width: 250},
                                {name:'Car_Net_Base_Amount',index:'Partner_Code',width: 250},
                                {name:'Car_Net_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Car_Original_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Car_Net_Days_Count',index:'Partner_Code',width: 250},
                                {name:'Towncar_Net_Expense_Amount',index:'Partner_Code',width: 250},
                                {name:'Towncar_Net_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Towncar_Original_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Other_Ground_Transportation_Net_Expense_Amount',index:'Partner_Code',width: 250},
                                {name:'Other_Ground_Transportation_Net_Booking_Count ',index:'Partner_Code',width: 250},
                                {name:'Other_Ground_Transportation_Original_Booking_Count',index:'Partner_Code',width: 250},
                                {name:'Other_Services_Net_Expense_Amount',index:'Partner_Code',width: 250},
                                {name:'Other_Services_Net_Booking_Count',index:'Partner_Code',width: 250}


                          ],
                          multiselect: true,
                          caption: "bookings",
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
                var tipo_funcion = 'ex';


                window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_sample_summary_transaction/get_layouts_egencia_data_import_sp_parametros?parametros='+parametros+'&tipo_funcion=ex', 'download_window');
              

           }

          

  }
      
  function buscar(){
    
    get_layouts_egencia_data_import_sp();
    
  }


</script>