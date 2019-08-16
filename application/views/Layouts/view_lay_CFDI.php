<div class="row">

      <div class="col-md-12" id="div_btns">
            <button type="button" class="btn btn-default" onclick="btn_exportar_excel_ot_lay_CFDI();" id="btn_excel_ot"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;EXCEL</button>
            <button type="button" class="btn btn-default" onclick="btn_exportar_excel_ae_lay_CFDI();" id='btn_excel_ae'><span class="fa fa-file-excel" style="color:#0ea4b3;"></span>&nbsp;EXCEL</button>
           
            <button type="button" class="btn btn-default" onclick="editar_row();"><span class="fa fa-edit" style="color:#a66cb5;"></span>&nbsp;Editar</button>
            <button type="button" class="btn btn-default" onclick="guardar_row();"><span class="fa fa-save" style="color:#5e8cf3;"></span>&nbsp;Guardar</button>
            <button type="button" class="btn btn-default" onclick="Eliminar_row();"><span class="fa fa-remove" style="color:#ea3949;"></span>&nbsp;Eliminar</button>

      </div>
      
      <div class="col-md-12">

            <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
                  <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                  
                  <div id="div_tbl_aereomexico">
                    <table id="dg_aereomexico" style="height: 90%;"></table>
                    <div id="pg_ptoolbar_ae" style="height: 2px;"></div>
                  </div>
                  <div id="div_tbl_otras">
                    <table id="dg_otras" style="height: 90%;"></table>
                    <div id="pg_ptoolbar_ot" style="height: 2px;"></div>
                  </div>

            </div>

      </div>

</div>


<script type="text/javascript">
  
  $("#title").html('<?=$title?>');
  $("#div_select_multiple_id_cliente").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  $("#div_select_multiple_id_provedor_local").show();
  $("#div_select_cat_provedor_CFDI").show();
  $("#div_btns").hide();

	function get_lay_CFDI(){

            $("#dg_aereomexico").clearGridData(true).trigger("reloadGrid");
            $("#dg_otras").clearGridData(true).trigger("reloadGrid");
           
            var parametros = {};

            var id_serie = $("#slc_mult_id_serie").val();
                     
            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor_local").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();

            var cat_provedor = $("#slc_cat_provedor_CFDI").val();


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
                        
            var parametros = string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;
	          

            if($("#slc_cat_provedor_CFDI").val() == 1){

              $("#btn_excel_ot").hide();
              $("#btn_excel_ae").show();

              $("#div_tbl_otras").hide();
              $("#div_tbl_aereomexico").show();

              $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_CFDI/get_lay_CFDI_aereomexico",
                    type: 'POST',
                    data: {parametros:parametros,cat_provedor},
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

                        data = JSON.parse(data);
                        $("#div_btns").show();

                        $("#dg_aereomexico").jqGrid({

                                datatype: "local",
                                height: 500,
                                shrinkToFit:false,
                                forceFit:true,

                                colNames:['rfc_emisor','razon_social_emisor','numero_iata','id_proveedor','nombre_proveedor','id_serie','fac_numero','numero_boleto','id_serie_cxs','fac_numero_cxs','fecha_compra','monto_compra','id_cliente','nombre_cliente','rfc','calle','exterior','interior','colonia','deleg_municipio','ciudad','estado','pais','cp','correo_electronico','comentarios','nombre_pasajero','ruta','seguro_pasajero','importe_seguro','id_gds','pseudocity_code','pnr','clave_vendedor','aereo','numero_viaje','revisado','bol_revisado','solicita_fac_la'],
                                colModel:[

                                          {name:'rfc_cliente',index:'rfc_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'razon_social',index:'razon_social',sorttype:"int",width: 250, editable:true},
                                          {name:'IATA',index:'IATA',sorttype:"int",width: 250, editable:true},
                                          {name:'ID_PROVEEDOR',index:'ID_PROVEEDOR',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_NOMBRE_PROVEEDOR',index:'GVC_NOMBRE_PROVEEDOR',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_ID_SERIE',index:'GVC_ID_SERIE',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_DOC_NUMERO',index:'GVC_DOC_NUMERO',sorttype:"int",width: 250, editable:true},
                                          {name:'BOLETO',index:'BOLETO',sorttype:"int",width: 250, editable:true},
                                          {name:'id_serie_cxs',index:'id_serie_cxs',sorttype:"int",width: 250, editable:true},
                                          {name:'fac_numero_cxs',index:'fac_numero_cxs',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_FECHA_EMISION_BOLETO',index:'GVC_FECHA_EMISION_BOLETO',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_TOTAL',index:'GVC_TOTAL',sorttype:"int",width: 250, editable:true},
                                          {name:'id_cliente',index:'id_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'nombre_cliente',index:'nombre_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'rfc_cliente',index:'rfc_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'calle',index:'calle',sorttype:"int",width: 250, editable:true},
                                          {name:'no_ext_cliente',index:'no_ext_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'no_int_cliente',index:'no_int_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'colonia_cliente',index:'colonia_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'MUNICIPIO',index:'MUNICIPIO',sorttype:"int",width: 250, editable:true},
                                          {name:'CIUDAD',index:'CIUDAD',sorttype:"int",width: 250, editable:true},
                                          {name:'ESTADO',index:'v',sorttype:"int",width: 250, editable:true},
                                          {name:'PAIS',index:'PAIS',sorttype:"int",width: 250, editable:true},
                                          {name:'codigo_postal',index:'codigo_postal',sorttype:"int",width: 250, editable:true},
                                          {name:'CORREO_ELECTRONICO',index:'CORREO_ELECTRONICO',sorttype:"int",width: 250, editable:true},
                                          {name:'comentarios',index:'comentarios',sorttype:"int",width: 250, editable:true},
                                          {name:'GVC_NOM_PAX',index:'GVC_NOM_PAX',sorttype:"int",width: 250, editable:true},
                                          {name:'RUTA',index:'RUTA',sorttype:"int",width: 250, editable:true},
                                          {name:'seguro_pasajero',index:'seguro_pasajero',sorttype:"int",width: 250, editable:true},
                                          {name:'importe_seguro',index:'importe_seguro',sorttype:"int",width: 250, editable:true},
                                          {name:'id_gds',index:'id_gds',sorttype:"int",width: 250, editable:true},
                                          {name:'pseudocity_code',index:'pseudocity_code',sorttype:"int",width: 250, editable:true},
                                          {name:'pnr',index:'pnr',sorttype:"int",width: 250, editable:true},
                                          {name:'CLAVE_VENDEDOR',index:'CLAVE_VENDEDOR',sorttype:"int",width: 250, editable:true},
                                          {name:'aereo',index:'aereo',sorttype:"int",width: 250, editable:true},
                                          {name:'numero_viaje',index:'numero_viaje',sorttype:"int",width: 250, editable:true},
                                          {name:'revisado',index:'revisado',sorttype:"int",width: 250, editable:true},
                                          {name:'bol_revisado',index:'bol_revisado',sorttype:"int",width: 250, editable:true},
                                          {name:'solicita_fac_la',index:'solicita_fac_la',sorttype:"int",width: 250, editable:true}                                       
                                        
                                ],
                                multiselect: false,
                                caption: "Layout CFDI",
                                width: 1200,
                                pager: "#pg_ptoolbar_ot",
                                viewrecords: true,

                                rowNum: 10000000,
                                pgbuttons: false,
                                pginput: false

                           
                            });

                            for(var i=0;i<=data['rep'].length;i++){
                              $("#dg_aereomexico").jqGrid('addRowData',i+1,data['rep'][i]);
                            }

                            $("#dg_aereomexico").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                            $("#dg_aereomexico").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
   
                    },
                    error: function () {
                        $.unblockUI();
                        alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                    }

                      
                  });


            }else{

              $("#btn_excel_ot").show();
              $("#btn_excel_ae").hide();

              $("#div_tbl_otras").show();
              $("#div_tbl_aereomexico").hide();

              $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_CFDI/get_lay_CFDI",
                    type: 'POST',
                    data: {parametros:parametros,cat_provedor},
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
                            
                            data = JSON.parse(data);
                            $("#div_btns").show();
                            
                            $("#dg_otras").jqGrid({

                                datatype: "local",
                                height: 500,
                                shrinkToFit:false,
                                forceFit:true,
                                
                                colNames:['CLAVE AEROLINEA','BOLETO ORIGINAL','NUMERO BOLETO', 'FECHA EMISION', 'IATA','PAX NOMBRE','PAX APELLIDOS','RFC','RAZON SOCIAL','CALLE','NO EXT','NO INT','COLONIA','MUNICIPIO','CP','LOCALIDAD','ESTADO','PAIS','ID FORMA PAGO','MONTO TOTAL','USO CFDI'],
                                colModel:[

                                          {name:'CLAVE_AEROLINEA',index:'CLAVE_AEROLINEA',sorttype:"int",width: 250, editable:true},
                                          {name:'BOLETO_ORIGINAL',index:'BOLETO_ORIGINAL',sorttype:"int",width: 250, editable:true},
                                          {name:'BOLETO',index:'BOLETO',sorttype:"int",width: 250, editable:true},
                                          {name:'FECHA_EMISION_BOLETO',index:'FECHA_EMISION_BOLETO',sorttype:"int",width: 250, editable:true},
                                          {name:'IATA',index:'ID_PROVEEDOR',sorttype:"IATA",width: 250, editable:true},
                                          {name:'nombre',index:'nombre',sorttype:"int",width: 250, editable:true},
                                          {name:'apellido',index:'apellido',sorttype:"int",width: 250, editable:true},
                                          {name:'rfc_cliente',index:'rfc_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'razon_social',index:'razon_social',sorttype:"int",width: 250, editable:true},
                                          {name:'calle',index:'calle',sorttype:"int",width: 250, editable:true},
                                          {name:'no_ext_cliente',index:'no_ext_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'no_int_cliente',index:'no_int_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'colonia_cliente',index:'colonia_cliente',sorttype:"int",width: 250, editable:true},
                                          {name:'MUNICIPIO',index:'MUNICIPIO',sorttype:"int",width: 250, editable:true},
                                          {name:'codigo_postal',index:'codigo_postal',sorttype:"int",width: 250, editable:true},
                                          {name:'LOCALIDAD',index:'LOCALIDAD',sorttype:"int",width: 250, editable:true},
                                          {name:'ESTADO',index:'ESTADO',sorttype:"int",width: 250, editable:true},
                                          {name:'PAIS',index:'PAIS',sorttype:"int",width: 250, editable:true},
                                          {name:'ID_FORMA_PAGO',index:'ID_FORMA_PAGO',sorttype:"int",width: 250, editable:true},
                                          {name:'MONTO_TOTAL',index:'MONTO_TOTAL',sorttype:"int",width: 250, editable:true},
                                          {name:'USO_CFDI',index:'USO_CFDI',sorttype:"int",width: 250, editable:true}

                                        
                                ],
                                multiselect: false,
                                caption: "Layout CFDI",
                                width: 1200,
                                pager: "#pg_ptoolbar_ae",
                                viewrecords: true,

                                rowNum: 10000000,
                                pgbuttons: false,
                                pginput: false
                           
                            });

                            for(var i=0;i<=data['rep'].length;i++){
                              $("#dg_otras").jqGrid('addRowData',i+1,data['rep'][i]);
                            }
                            
                            $("#dg_otras").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                            $("#dg_otras").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
                            
                      },  
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                      
                  });

            }



	    }

      function editar_row() {

        if($("#slc_cat_provedor_CFDI").val() == 1){

          var row = $("#dg_aereomexico").jqGrid('getGridParam','selrow');
          $("#dg_aereomexico").jqGrid('editRow',row);

        }else{

          var row = $("#dg_otras").jqGrid('getGridParam','selrow');
          $("#dg_otras").jqGrid('editRow',row);

        }
          

      }

      function guardar_row() {
          
          if($("#slc_cat_provedor_CFDI").val() == 1){

             var ids = jQuery("#dg_aereomexico").jqGrid('getDataIDs');
              for(var i=0;i < ids.length;i++){
                var cl = ids[i];
                $("#dg_aereomexico").jqGrid('saveRow',cl);
              } 

          }else{

            var ids = jQuery("#dg_otras").jqGrid('getDataIDs');
              for(var i=0;i < ids.length;i++){
                var cl = ids[i];
                $("#dg_otras").jqGrid('saveRow',cl);
              } 

          }

      
      }

      function Eliminar_row(){

        if($("#slc_cat_provedor_CFDI").val() == 1){

          var row = $("#dg_aereomexico").jqGrid('getGridParam','selrow');
          $("#dg_aereomexico").jqGrid('delRowData',row);

        }else{

          var row = $("#dg_otras").jqGrid('getGridParam','selrow');
          $("#dg_otras").jqGrid('delRowData',row);

        }
          
      }
      
      function btn_exportar_excel_ae_lay_CFDI(){


        var allrows = jQuery("#dg_aereomexico").jqGrid('getRowData');

                $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_CFDI/exportar_excel_ae",
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
                            $a.attr("download","CFDI.xlsx");
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

      function btn_exportar_excel_ot_lay_CFDI(){

            var allrows = jQuery("#dg_otras").jqGrid('getRowData');
            
            $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_CFDI/exportar_excel",
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
                            $a.attr("download","CFDI.xlsx");
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

    
      $( "#slc_select_cat_provedor" ).change(function() {
            
            var slc_select_cat_provedor = $( this ).val();
            
            $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_CFDI/get_catalogo_aereolineas_CFDI",
                    type: 'POST',
                    data: {slc_select_cat_provedor:slc_select_cat_provedor},
                    success: function (data) {

                        data = JSON.parse(data);
                        
                        var arr_obj = [];
                        for(var x=0;x<data.length;x++){

                            var obj_serv = {};
                            
                            obj_serv['label'] = data[x]['nombre_aereolinea'];
                            obj_serv['value'] = data[x]['id_aereolinea'];
                           
                            arr_obj.push(obj_serv);

                        }
                        
                        $("#slc_mult_id_provedor_local").multiselect('dataprovider', arr_obj);

                        var selectconfig = {
                            enableFiltering: true,
                            includeSelectAllOption: true
                        };

                        $('#slc_mult_id_provedor_local').multiselect('setOptions', selectconfig);
                        
                        $('#slc_mult_id_provedor_local').multiselect('rebuild');

                      }

                  });


      });

      function buscar(){

       
            get_lay_CFDI();

          
      }
	
</script>