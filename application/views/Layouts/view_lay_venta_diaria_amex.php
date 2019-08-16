<div class="row">

      <div class="col-md-12" id="div_btns">
            <button type="button" class="btn btn-default" onclick="btn_exportar_excel_lay_venta_diaria_amex();" id="btn_excel"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;EXCEL</button>
           
            <button type="button" class="btn btn-default" onclick="editar_row();"><span class="fa fa-edit" style="color:#a66cb5;"></span>&nbsp;Editar</button>
            <button type="button" class="btn btn-default" onclick="guardar_row();"><span class="fa fa-save" style="color:#5e8cf3;"></span>&nbsp;Guardar</button>
            <button type="button" class="btn btn-default" onclick="Eliminar_row();"><span class="fa fa-remove" style="color:#ea3949;"></span>&nbsp;Eliminar</button>

      </div>
      
      <div class="col-md-12">

            <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
                  <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                  
                  
                    <table id="dg" style="height: 90%;"></table>
                    <div id="pg_ptoolbar" style="height: 2px;"></div>
                  
                  

            </div>

      </div>

</div>


<script type="text/javascript">
  
  $("#title").html('<?=$title?>');

  $("#div_select_multiple_id_serie").show();
  $("#div_select_multiple_sucursal").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_select_multiple_id_servicio").show();
  $("#div_select_multiple_id_metodo_pago").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  
  $("#div_btns").hide();

  function get_lay_venta_diaria_amex(){

            $("#dg").clearGridData(true).trigger("reloadGrid");
          
            var parametros = {};

            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();

            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_metodo_pago = $("#slc_mult_id_metodo_pago").val();
            

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

            var string_ids_metodo_pago = '';
            
            $.each(id_metodo_pago, function( index, value ) {

              string_ids_metodo_pago = string_ids_metodo_pago + value + '_';
            
            });
            

            var id_plantilla = $("#slc_plantilla").val();
            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();
                        
            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_metodo_pago+','+fecha1+','+fecha2;


              $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_venta_diaria_amex/get_lay_venta_diaria_amex",
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
                        
                        $.unblockUI();
                                                
                    },
                    success: function (data) {

                        $("#div_btns").show();

                        data = JSON.parse(data);

                        $("#dg").jqGrid({
                                datatype: "local",
                                height: 500,
                                shrinkToFit:false,
                                forceFit:true,
                                colNames:[
                                'SERIE',
                                'FACTURA',
                                'BOLETO',
                                'CUPON',
                                'ID SUCURSAL',
                                'FECHA',
                                'ID CLIENTE',
                                'CLIENTE',
                                'CUENTA',
                                'ANALISIS 27 DE CLIENTE',
                                'ID CORPORATIVO',
                                'ID FORMA DE PAGO',
                                'FORMA DE PAGO',
                                'RUTA',
                                'ID PROVEEDOR',
                                'NOMBRE PROVEEDOR',
                                'TARIFA',
                                'IVA',
                                'TUA',
                                'OTROS IMPUESTOS',
                                'VENDEDOR',
                                'CONCEPTO',
                                'IMPORTE',
                                'CVE',
                                'NOMBRE COMERCIAL',
                                'ID SERVICIO',
                                'GVC_DESCRIPCION_EXTENDIDA'
                                ],
                                colModel:[

                                          {name:'GVC_ID_SERIE',index:'GVC_ID_SERIE',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_DOC_NUMERO',index:'GVC_DOC_NUMERO',sorttype:"int",width: 250, editable:true},
                                          {name:'NUMERO_BOLETO',index:'NUMERO_BOLETO',sorttype:"int",width: 250, editable:true},
                                          {name:'NUMERO_CUPON',index:'NUMERO_CUPON',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_ID_SUCURSAL',index:'GVC_ID_SUCURSAL',sorttype:"int",width: 250, editable:true},
                                          {name:'FECHA',index:'FECHA',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_ID_CLIENTE',index:'GVC_ID_CLIENTE',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_NOM_CLI',index:'GVC_NOM_CLI',sorttype:"int",width: 250, editable:true},
                                          {name:'NUMERO_CUENTA',index:'NUMERO_CUENTA',sorttype:"int",width: 250, editable:true},
                                          {name:'analisis27_cliente',index:'analisis27_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_ID_CORPORATIVO',index:'GVC_ID_CORPORATIVO',sorttype:"int",width: 250, editable:true},
                                          {name:'ID_FORMA_PAGO',index:'ID_FORMA_PAGO',sorttype:"int",width: 250, editable:true},
                                          {name:'c_FormaPago',index:'c_FormaPago',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_RUTA',index:'GVC_RUTA',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_ID_PROVEEDOR',index:'GVC_ID_PROVEEDOR',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_NOMBRE_PROVEEDOR',index:'GVC_NOMBRE_PROVEEDOR',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_TARIFA',index:'GVC_TARIFA',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_IVA',index:'GVC_IVA',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_TUA',index:'GVC_TUA',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_OTROS_IMPUESTOS',index:'GVC_OTROS_IMPUESTOS',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_NOM_VEN_TIT',index:'GVC_NOM_VEN_TIT',sorttype:"int",width: 250, editable:true},
                                          {name:'CONCEPTO',index:'CONCEPTO',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_TOTAL',index:'GVC_TOTAL',sorttype:"int",width: 250, editable:true},
                                          {name:'CVE',index:'CVE',sorttype:"int",width: 250, editable:true},
                                          {name:'NOMBRE_COMERCIAL',index:'NOMBRE_COMERCIAL',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_ID_SERVICIO',index:'GVC_ID_SERVICIO',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_DESCRIPCION_EXTENDIDA',index:'GVC_DESCRIPCION_EXTENDIDA',sorttype:"int",width: 250, editable:true}
     
                                        
                                ],
                                multiselect: false,
                                caption: "Layout Venta diaria Amex",
                                width: 1200,
                                pager: "#pg_ptoolbar",
                                viewrecords: true,

                                rowNum: 10000000,
                                pgbuttons: false,
                                pginput: false

                           
                            });

                            for(var i=0;i<=data['rep'].length;i++){
                              $("#dg").jqGrid('addRowData',i+1,data['rep'][i]);
                            }

                            $("#dg").jqGrid('navGrid','#pg_ptoolbar',{del:false,add:false,edit:false,search:false});
                            $("#dg").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});




                    },
                    error: function () {
                        $.unblockUI();
                        alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                    }

                      
                  });


      }

      function editar_row() {

          var row = $("#dg").jqGrid('getGridParam','selrow');
          $("#dg").jqGrid('editRow',row);

      }

      function guardar_row() {
          
        var ids = jQuery("#dg").jqGrid('getDataIDs');
          for(var i=0;i < ids.length;i++){
            var cl = ids[i];
            $("#dg").jqGrid('saveRow',cl);
          } 

      }

      function Eliminar_row(){

          var row = $("#dg").jqGrid('getGridParam','selrow');
          $("#dg").jqGrid('delRowData',row);
          
      }
      
   
      function btn_exportar_excel_lay_venta_diaria_amex(){

            var allrows = jQuery("#dg").jqGrid('getRowData');
            
            $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_venta_diaria_amex/exportar_excel",
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
                    complete: function () {
                                  
                        $.unblockUI();

                    },
                    success: function (data) {

                        if(data != 0){

                            var opResult = JSON.parse(data);
                            var $a=$("<a>");
                            $a.attr("href",opResult.data);
                            //$a.html("LNK");
                            $("body").append($a);
                            $a.attr("download","VENTA_DIARIA.xlsx");
                            $a[0].click();
                            $a.remove();

                        }else{


                          $("#div_datagrid_html").html("No existen consumos a exportar"); 


                        }        

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }
                      
                });


          
      }


      function buscar(){

       
            get_lay_venta_diaria_amex();

          
      }
  
</script>