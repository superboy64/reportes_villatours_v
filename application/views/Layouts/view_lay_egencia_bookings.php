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
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings/get_layouts_egencia_data_import_sp_parametros",
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
                          colNames:['Link_Key','BookingID','BookingType','BookingSubType','DocumentType','TransactionType','RecordLocator','InvoiceNumber','BranchName','BranchInterfaceID','BranchARCNumber','OutsideAgent','BookingAgent','InsideAgent','TicketingAgent','BookedOnline','AccountName','AccountInterfaceID','AccountType','VendorName','VendorInterfaceID','VendorCode','VendorAddress','VendorCity','VendorState','VendorZip','VendorCountryCode','VendorPhone','AirlineNumber','ReasonCode','ReasonDescription','IssuedDate','BookingDate','StartDate','EndDate','NumberofUnits','BookingDuration','CommissionAmount','CommissionRate','FullFare','LowFare','BaseFare','Tax1Amount','Tax2Amount','Tax3Amount','Tax4Amount','GSTAmount','QSTAmount','TotalTaxes','TotalPaid','PenaltyAmount','Rate','RateType','CurrencyCode','FormofPayment','PaymentNumber','TravelerName','DocumentNumber','OriginalDocumentNumber','Routing','Origin','Destination','DomesticInternational','Class','TourCode','TicketDesignator','ClientRemarks','Department','GSANumber','PurchaseOrder','CostCenter','CostCenterdescription','SBU','EmployeeID','BillableNonBillable','ProjectCode','ReasonforTravel','DepartmentDescription','CustomField9','CustomField10','GroupID','InPolicy','TravelerEmail','NegotiatedFare'],
                          colModel:[

                                     
                                      {name:'Link_Key',index:'Link_Key',width: 250},
                                      {name:'BookingID',index:'BookingID',width: 250},
                                      {name:'BookingType',index:'BookingType',width: 250},
                                      {name:'BookingSubType',index:'BookingSubType',width: 250},
                                      {name:'DocumentType',index:'DocumentType',width: 250},
                                      {name:'TransactionType',index:'TransactionType',width: 250},
                                      {name:'RecordLocator',index:'RecordLocator',width: 250},
                                      {name:'InvoiceNumber',index:'InvoiceNumber',width: 250},
                                      {name:'BranchName',index:'BranchName',width: 250},
                                      {name:'BranchInterfaceID',index:'BranchInterfaceID',width: 250},
                                      {name:'BranchARCNumber',index:'BranchARCNumber',width: 250},
                                      {name:'OutsideAgent',index:'OutsideAgent',width: 250},
                                      {name:'BookingAgent',index:'BookingAgent',width: 250},
                                      {name:'InsideAgent',index:'InsideAgent',width: 250},
                                      {name:'TicketingAgent',index:'TicketingAgent',width: 250},
                                      {name:'BookedOnline',index:'BookedOnline',width: 250},
                                      {name:'AccountName',index:'AccountName',width: 250},
                                      {name:'AccountInterfaceID',index:'AccountInterfaceID',width: 250},
                                      {name:'AccountType',index:'AccountType',width: 250},
                                      {name:'VendorName',index:'VendorName',width: 250},
                                      {name:'VendorInterfaceID',index:'VendorInterfaceID',width: 250},
                                      {name:'VendorCode',index:'VendorCode',width: 250},
                                      {name:'VendorAddress',index:'VendorAddress',width: 250},
                                      {name:'VendorCity',index:'VendorCity',width: 250},
                                      {name:'VendorState',index:'VendorState',width: 250},
                                      {name:'VendorZip',index:'VendorZip',width: 250},
                                      {name:'VendorCountryCode',index:'VendorCountryCode',width: 250},
                                      {name:'VendorPhone',index:'VendorPhone',width: 250},
                                      {name:'AirlineNumber',index:'AirlineNumber',width: 250},
                                      {name:'ReasonCode',index:'ReasonCode',width: 250},
                                      {name:'ReasonDescription',index:'ReasonDescription',width: 250},
                                      {name:'IssuedDate',index:'IssuedDate',width: 250},
                                      {name:'BookingDate',index:'BookingDate',width: 250},
                                      {name:'StartDate',index:'StartDate',width: 250},
                                      {name:'EndDate',index:'EndDate',width: 250},
                                      {name:'NumberofUnits',index:'NumberofUnits',width: 250},
                                      {name:'BookingDuration',index:'BookingDuration',width: 250},
                                      {name:'CommissionAmount',index:'CommissionAmount',width: 250},
                                      {name:'CommissionRate',index:'CommissionRate',width: 250},
                                      {name:'FullFare',index:'FullFare',width: 250},
                                      {name:'LowFare',index:'LowFare',width: 250},
                                      {name:'BaseFare',index:'BaseFare',width: 250},
                                      {name:'Tax1Amount',index:'Tax1Amount',width: 250},
                                      {name:'Tax2Amount',index:'Tax2Amount',width: 250},
                                      {name:'Tax3Amount',index:'Tax3Amount',width: 250},
                                      {name:'Tax4Amount',index:'Tax4Amount',width: 250},
                                      {name:'GSTAmount',index:'GSTAmount',width: 250},
                                      {name:'QSTAmount',index:'QSTAmount',width: 250},
                                      {name:'TotalTaxes',index:'TotalTaxes',width: 250},
                                      {name:'TotalPaid',index:'TotalPaid',width: 250},
                                      {name:'PenaltyAmount',index:'PenaltyAmount',width: 250},
                                      {name:'Rate',index:'Rate',width: 250},
                                      {name:'RateType',index:'RateType',width: 250},
                                      {name:'CurrencyCode',index:'CurrencyCode',width: 250},
                                      {name:'FormofPayment',index:'FormofPayment',width: 250},
                                      {name:'PaymentNumber',index:'PaymentNumber',width: 250},
                                      {name:'TravelerName',index:'TravelerName',width: 250},
                                      {name:'DocumentNumber',index:'DocumentNumber',width: 250},
                                      {name:'OriginalDocumentNumber',index:'OriginalDocumentNumber',width: 250},
                                      {name:'Routing',index:'Routing',width: 250},
                                      {name:'Origin',index:'Origin',width: 250},
                                      {name:'Destination',index:'Destination',width: 250},
                                      {name:'DomesticInternational',index:'DomesticInternational',width: 250},
                                      {name:'Class',index:'Class',width: 250},
                                      {name:'TourCode',index:'nTourCodeame',width: 250},
                                      {name:'TicketDesignator',index:'TicketDesignator',width: 250},
                                      {name:'ClientRemarks',index:'ClientRemarks',width: 250},
                                      {name:'Department',index:'Department',width: 250},
                                      {name:'GSANumber',index:'GSANumber',width: 250},
                                      {name:'PurchaseOrder',index:'PurchaseOrder',width: 250},

                                      {name:'CostCenter',index:'CostCenter',width: 250},
                                      {name:'CostCenterdescription',index:'CostCenterdescription',width: 250},
                                      {name:'SBU',index:'SBU',width: 250},
                                      {name:'EmployeeID',index:'EmployeeID',width: 250},
                                      {name:'BillableNonBillable',index:'BillableNonBillable',width: 250},
                                      {name:'ProjectCode',index:'ProjectCode',width: 250},
                                      {name:'ReasonforTravel',index:'ReasonforTravel',width: 250},
                                      {name:'DepartmentDescription',index:'DepartmentDescription',width: 250},
                                      
                                      {name:'Custom_Field9',index:'Custom_Field9',width: 250},
                                      {name:'Custom_Field10',index:'Custom_Field10',width: 250},
                                      {name:'GroupID',index:'GroupID',width: 250},
                                      {name:'InPolicy',index:'InPolicy',width: 250},
                                      {name:'TravelerEmail',index:'TravelerEmail',width: 250},
                                      {name:'Negotiated_Fare',index:'Negotiated_Fare',width: 250}
                


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


                $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings/get_layouts_egencia_data_import_sp_parametros",
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
  
                        window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings/exportar_txt_lay_egencia_data_import_sp');            

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