<div class="row">

      <div class="col-md-6" id="div_btns">
      
          <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_ega();"><span class="fa fa-file-text-o" style="color:#0ea4b3;"></span>&nbsp;TXT</button>
          <button type="button" class="btn btn-default" onclick="editar_row();"><span class="fa fa-edit" style="color:#a66cb5;"></span>&nbsp;Editar</button>
          <button type="button" class="btn btn-default" onclick="guardar_row();"><span class="fa fa-save" style="color:#5e8cf3;"></span>&nbsp;Guardar</button>
          <button type="button" class="btn btn-default" onclick="Eliminar_row();"><span class="fa fa-remove" style="color:#ea3949;"></span>&nbsp;Eliminar</button>
          
      
      </div>

      <div class="col-md-2">
      
         <input type="text" id="consecutivo_ega" placeholder="concecutivo">
      
      </div>

      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%; overflow-x: auto;">
                       <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                       <table id="dg_rep_ega"></table>
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
  $("#div_btns").hide();

  function get_layouts_egencia_data_import_sp(){
        
        $("#dg_rep_ega").clearGridData(true).trigger("reloadGrid");

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

            var consecutivo_ega = $("#consecutivo_ega").val();

            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;

            var tipo_funcion = 'man';
                
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings_cadena/get_layouts_egencia_data_import_sp_parametros",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:tipo_funcion,consecutivo_ega:consecutivo_ega},
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
                       $("#div_btns").show();

                       var log = data['log'];

                       rest_modal('');
                       $("#modal_content").css({"width": "50%"});

                       $.each(log, function( index, value ) {

                        $("#modal_body").append(value);
                      
                       });
                       $("#modal_footer").hide();
                       $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Log de errores</h1></center>");
                       
                       $('#myModal').modal({
                          backdrop: false,
                          show: true
                       });
                       
                      
                       $("#dg_rep_ega").jqGrid({
                          datatype: "local",
                          height: 500,
                          shrinkToFit:false,
                          forceFit:true,
                          colNames:['Link_Key','BookingID','BookingType','BookingSubType','DocumentType','TransactionType','RecordLocator','InvoiceNumber','BranchName','BranchInterfaceID','BranchARCNumber','OutsideAgent','BookingAgent','InsideAgent','TicketingAgent','BookedOnline','AccountName','AccountInterfaceID','AccountType','VendorName','VendorInterfaceID','VendorCode','VendorAddress','VendorCity','VendorState','VendorZip','VendorCountryCode','VendorPhone','AirlineNumber','ReasonCode','ReasonDescription','IssuedDate','BookingDate','StartDate','EndDate','NumberofUnits','BookingDuration','CommissionAmount','CommissionRate','FullFare','LowFare','BaseFare','Tax1Amount','Tax2Amount','Tax3Amount','Tax4Amount','GSTAmount','QSTAmount','TotalTaxes','TotalPaid','PenaltyAmount','Rate','RateType','CurrencyCode','FormofPayment','PaymentNumber','TravelerName','DocumentNumber','OriginalDocumentNumber','Routing','Origin','Destination','DomesticInternational','Class','TourCode','TicketDesignator','ClientRemarks','Department','GSANumber','PurchaseOrder','CostCenter','CostCenterdescription','SBU','EmployeeID','BillableNonBillable','ProjectCode','ReasonforTravel','DepartmentDescription','CustomField9','CustomField10','GroupID','InPolicy','TravelerEmail','NegotiatedFare'],
                          colModel:[

                                     
                                      {name:'Link_Key2',index:'Link_Key2',width: 250, editable:false},
                                      {name:'BookingID2',index:'BookingID2',width: 250, editable:false},
                                      {name:'BookingType',index:'BookingType',width: 250, editable:false},
                                      {name:'BookingSubType',index:'BookingSubType',width: 250, editable:false},
                                      {name:'DocumentType',index:'DocumentType',width: 250, editable:false},
                                      {name:'TransactionType',index:'TransactionType',width: 250, editable:false},
                                      {name:'RecordLocator',index:'RecordLocator',width: 250, editable:false},
                                      {name:'InvoiceNumber',index:'InvoiceNumber',width: 250, editable:false},
                                      {name:'BranchName',index:'BranchName',width: 250, editable:true},
                                      {name:'BranchInterfaceID',index:'BranchInterfaceID',width: 250, editable:true},
                                      {name:'BranchARCNumber',index:'BranchARCNumber',width: 250, editable:true},
                                      {name:'OutsideAgent',index:'OutsideAgent',width: 250, editable:true},
                                      {name:'BookingAgent',index:'BookingAgent',width: 250, editable:true},
                                      {name:'InsideAgent',index:'InsideAgent',width: 250, editable:true},
                                      {name:'TicketingAgent',index:'TicketingAgent',width: 250, editable:true},
                                      {name:'BookedOnline',index:'BookedOnline',width: 250, editable:true},
                                      {name:'AccountName',index:'AccountName',width: 250, editable:true},
                                      {name:'AccountInterfaceID',index:'AccountInterfaceID',width: 250, editable:true},
                                      {name:'AccountType',index:'AccountType',width: 250, editable:true},
                                      {name:'VendorName',index:'VendorName',width: 250, editable:true},
                                      {name:'VendorInterfaceID',index:'VendorInterfaceID',width: 250, editable:true},
                                      {name:'VendorCode',index:'VendorCode',width: 250, editable:true},
                                      {name:'VendorAddress',index:'VendorAddress',width: 250, editable:true},
                                      {name:'VendorCity',index:'VendorCity',width: 250, editable:true},
                                      {name:'VendorState',index:'VendorState',width: 250, editable:true},
                                      {name:'VendorZip',index:'VendorZip',width: 250, editable:true},
                                      {name:'VendorCountryCode',index:'VendorCountryCode',width: 250, editable:true},
                                      {name:'VendorPhone',index:'VendorPhone',width: 250, editable:true},
                                      {name:'AirlineNumber',index:'AirlineNumber',width: 250, editable:true},
                                      {name:'ReasonCode',index:'ReasonCode',width: 250, editable:true},
                                      {name:'ReasonDescription',index:'ReasonDescription',width: 250, editable:true},
                                      {name:'IssuedDate',index:'IssuedDate',width: 250, editable:true},
                                      {name:'BookingDate',index:'BookingDate',width: 250, editable:true},
                                      {name:'StartDate',index:'StartDate',width: 250, editable:true},
                                      {name:'EndDate',index:'EndDate',width: 250, editable:true},
                                      {name:'NumberofUnits',index:'NumberofUnits',width: 250, editable:true},
                                      {name:'BookingDuration',index:'BookingDuration',width: 250, editable:true},
                                      {name:'CommissionAmount',index:'CommissionAmount',width: 250, editable:true},
                                      {name:'CommissionRate',index:'CommissionRate',width: 250, editable:true},
                                      {name:'FullFare',index:'FullFare',width: 250, editable:true},
                                      {name:'LowFare',index:'LowFare',width: 250, editable:true},
                                      {name:'BaseFare',index:'BaseFare',width: 250, editable:true},
                                      {name:'Tax1Amount',index:'Tax1Amount',width: 250, editable:true},
                                      {name:'Tax2Amount',index:'Tax2Amount',width: 250, editable:true},
                                      {name:'Tax3Amount',index:'Tax3Amount',width: 250, editable:true},
                                      {name:'Tax4Amount',index:'Tax4Amount',width: 250, editable:true},
                                      {name:'GSTAmount',index:'GSTAmount',width: 250, editable:true},
                                      {name:'QSTAmount',index:'QSTAmount',width: 250, editable:true},
                                      {name:'TotalTaxes',index:'TotalTaxes',width: 250, editable:true},
                                      {name:'TotalPaid',index:'TotalPaid',width: 250, editable:true},
                                      {name:'PenaltyAmount',index:'PenaltyAmount',width: 250, editable:true},
                                      {name:'Rate',index:'Rate',width: 250, editable:true},
                                      {name:'RateType',index:'RateType',width: 250, editable:true},
                                      {name:'CurrencyCode',index:'CurrencyCode',width: 250, editable:true},
                                      {name:'FormofPayment',index:'FormofPayment',width: 250, editable:true},
                                      {name:'PaymentNumber',index:'PaymentNumber',width: 250, editable:true},
                                      {name:'TravelerName',index:'TravelerName',width: 250, editable:true},
                                      {name:'DocumentNumber',index:'DocumentNumber',width: 250, editable:true},
                                      {name:'OriginalDocumentNumber',index:'OriginalDocumentNumber',width: 250, editable:true},
                                      {name:'Routing',index:'Routing',width: 250, editable:true},
                                      {name:'Origin',index:'Origin',width: 250, editable:true},
                                      {name:'Destination',index:'Destination',width: 250, editable:true},
                                      {name:'DomesticInternational',index:'DomesticInternational',width: 250, editable:true},
                                      {name:'Class',index:'Class',width: 250, editable:true},
                                      {name:'TourCode',index:'nTourCodeame',width: 250, editable:true},
                                      {name:'TicketDesignator',index:'TicketDesignator',width: 250, editable:true},
                                      {name:'ClientRemarks',index:'ClientRemarks',width: 250, editable:true},
                                      {name:'Department',index:'Department',width: 250, editable:true},
                                      {name:'GSANumber',index:'GSANumber',width: 250, editable:true},
                                      {name:'PurchaseOrder',index:'PurchaseOrder',width: 250, editable:true},

                                      {name:'CostCenter',index:'CostCenter',width: 250, editable:true},
                                      {name:'CostCenterdescription',index:'CostCenterdescription',width: 250, editable:true},
                                      {name:'SBU',index:'SBU',width: 250, editable:true},
                                      {name:'EmployeeID',index:'EmployeeID',width: 250, editable:true},
                                      {name:'BillableNonBillable',index:'BillableNonBillable',width: 250, editable:true},
                                      {name:'ProjectCode',index:'ProjectCode',width: 250, editable:true},
                                      {name:'ReasonforTravel',index:'ReasonforTravel',width: 250, editable:true},
                                      {name:'DepartmentDescription',index:'DepartmentDescription',width: 250, editable:true},
                                      
                                      {name:'Custom_Field9',index:'Custom_Field9',width: 250, editable:true},
                                      {name:'Custom_Field10',index:'Custom_Field10',width: 250, editable:true},
                                      {name:'GroupID',index:'GroupID',width: 250, editable:true},
                                      {name:'InPolicy',index:'InPolicy',width: 250, editable:true},
                                      {name:'TravelerEmail',index:'TravelerEmail',width: 250, editable:true},
                                      {name:'Negotiated_Fare',index:'Negotiated_Fare',width: 250, editable:true}
                

                          ],
                          multiselect: true,
                          caption: "Bookings",
                          width: 1200,
                          pager: "#pg_ptoolbar",
                          viewrecords: true,

                          rowNum: 10000000,
                          pgbuttons: false,
                          pginput: false
                      });
      
                      
                      for(var i=0;i<=data['rep'].length;i++){
                          $("#dg_rep_ega").jqGrid('addRowData',i+1,data['rep'][i]);
                      }

                      $("#dg_rep_ega").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                      $("#dg_rep_ega").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});

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


  function editar_row() {

      var row = $("#dg_rep_ega").jqGrid('getGridParam','selrow');
      $("#dg_rep_ega").jqGrid('editRow',row);

  }

  function guardar_row() {
      
      var ids = jQuery("#dg_rep_ega").jqGrid('getDataIDs');
      for(var i=0;i < ids.length;i++){
        var cl = ids[i];
        $("#dg_rep_ega").jqGrid('saveRow',cl);
      } 
  
  }

  function Eliminar_row(){

    var row_id = $("#dg_rep_ega").jqGrid('getGridParam','selrow');
    var rowData = jQuery("#dg_rep_ega").getRowData(row_id);
    var BookingID = rowData['BookingID2']; 

    
    $.post( "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings_cadena/eliminar_BookingID", {BookingID:BookingID}, function( data ) {
        
        if(data == 1){

          $("#dg_rep_ega").jqGrid('delRowData',row_id);
          swal("registro eliminado correctamente");

        }else{

          swal("error al eliminar registro");

        }
        

    });

  }

  function btn_exportar_excel_rep_ega(){


            var allrows = jQuery("#dg_rep_ega").jqGrid('getRowData');


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

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings_cadena/genera_txt",
                    type: 'POST',
                    data: {allrows:JSON.stringify(allrows)},
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
                    success: function (data) {
                        
                        console.log("termina bookings");

                        $.post( "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_segments_cadena/get_layouts_egencia_data_import_sp_parametros", {parametros:parametros,tipo_funcion:'ex'}, function( data ) {

                          data = JSON.parse(data);
                          
                          console.log("termina segmentado");
                          var log = data['log'];
                          
                          rest_modal('');
                          $("#modal_content").css({"width": "50%"});

                          $("#modal_body").append(log);
                          
                           $("#modal_footer").hide();
                           $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Log de errores</h1></center>");
                           
                           $('#myModal').modal({
                              backdrop: false,
                              show: true
                           });

                          $.post( "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_udids_cadena/get_layouts_egencia_data_import_sp_parametros", {parametros:parametros,tipo_funcion:'ex'}, function( data ) {
                             
                             console.log("termina udids");

                             $.unblockUI();

                              window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_bookings_cadena/exportar_txt_lay_egencia_data_import_sp');   
                              window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_segments_cadena/exportar_txt_lay_egencia_data_import_sp');      
                              window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_egencia_udids_cadena/exportar_txt_lay_egencia_data_import_sp');


                          });
                        
                        });

                                

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