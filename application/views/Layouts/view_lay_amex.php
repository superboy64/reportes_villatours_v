<div class="row">

      <div class="col-md-12" id="div_btns">
            <!--<button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_gvc();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;EXCEL</button>-->
            <button type="button" class="btn btn-default" onclick="btn_exportar_txt_lay_amex();"><span class="fa fa-file-text-o" style="color:#0ea4b3;"></span>&nbsp;TXT</button>
            <button type="button" class="btn btn-default" onclick="btn_comparar_tarjetas();"><span class="fa fa-exchange" style="color:#EAB139;"></span>&nbsp;Comparar tarjetas</button>

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
  //$("#div_select_id_serie").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();

  //$("#div_select_multiple_id_serie").show();
  //$("#div_select_multiple_id_servicio_amex").show();
  
  $("#div_select_multiple_id_provedor_local").show();
  $("#div_select_cat_provedor").show();
  //$("#div_select_multiple_id_corporativo").show();
  //$("#div_plantilla").show();
  $("#div_btns").hide();

	function get_lay_amex(){

            $("#dg").clearGridData(true).trigger("reloadGrid");
           
            var parametros = {};

            var id_serie = $("#slc_mult_id_serie").val();
                     
            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor_local").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();

            var cat_provedor = $("#slc_select_cat_provedor").val();


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
	          
            /*if(id_cliente.length == 0 && id_corporativo.length == 0){

              btn_exportar_excel_rep_gvc();

            }else{*/

            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/get_lay_amex",
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

                            $("#dg").jqGrid({

                                datatype: "local",
                                height: 500,
                                shrinkToFit:false,
                                forceFit:true,
                                
                                /*colNames:['AMEX_TIPO','AMEX_5555','AMEX_CVE_AMEX','AMEX_EMPTY1','AMEX_EMPTY2','AMEX_EMPTY3','AMEX_CODIGO_BSP','AMEX_BOLETO','AMEX_CERO','AMEX_EMPTY4','AMEX_NOM_PAX','AMEX_CONCEPTO','AMEX_FECHA_SALIDA','AMEX_EMPTY5','AMEX_EMPTY6','AMEX_STATUS','AMEX_A','AMEX_FAC_NUMERO','AMEX_ID_PROVEEDOR','AMEX_TOTAL','AMEX_EMPTY7','AMEX_EMPTY8','AMEX_EMPTY9','AMEX_CONCEPTO','AMEX_CLA_PAX','AMEX_EMPTY10','AMEX_TUA','AMEX_IVA','AMEX_OTROS_IMPUESTOS','AMEX_EMPTY11','AMEX_EMPTY12','AMEX_FECHA_EMISION','AMEX_STATUS2','AMEX_EMPTY13','AMEX_EMPTY14','AMEX_EMPTY15','AMEX_EMPTY16','AMEX_EMPTY17','AMEX_EMPTY18','AMEX_EMPTY19','AMEX_NOM_CENCO','AMEX_EMPTY20','AMEX_IVA2','AMEX_EMPTY21','AMEX_EMPTY22','AMEX_EMPTY23','AMEX_EMPTY24','AMEX_EMPTY25','AMEX_EMPTY26','AMEX_TARIFA_MON_BASE','AMEX_EMPTY27','AMEX_EMPTY28','AMEX_EMPTY29','AMEX_EMPTY30','AMEX_EMPTY31'],*/
                                colNames:['AMEX_TIPO','AMEX_5555','AMEX_CVE_AMEX','AMEX_CODIGO_BSP','AMEX_BOLETO','AMEX_CERO','AMEX_NOM_PAX','AMEX_CONCEPTO','AMEX_FECHA_SALIDA','AMEX_STATUS','AMEX_A','AMEX_FAC_NUMERO','AMEX_ID_PROVEEDOR','AMEX_TOTAL','AMEX_CONCEPTO','AMEX_CLA_PAX','AMEX_TUA','AMEX_IVA','AMEX_OTROS_IMPUESTOS','AMEX_FECHA_EMISION','AMEX_STATUS2','AMEX_NOM_CENCO','AMEX_IVA2','AMEX_TARIFA_MON_BASE'],
                                colModel:[

                                          {name:'AMEX_TIPO',index:'AMEX_TIPO',sorttype:"int",width:30, editable:true},
                                          {name:'AMEX_5555',index:'AMEX_5555',sorttype:"int",width:50, editable:true},
                                          {name:'AMEX_CVE_AMEX',index:'AMEX_CVE_AMEX',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY1',index:'AMEX_EMPTY1',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY2',index:'AMEX_EMPTY2',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY3',index:'AMEX_EMPTY3',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_CODIGO_BSP',index:'AMEX_CODIGO_BSP',sorttype:"int",width:30, editable:true},
                                          {name:'AMEX_BOLETO',index:'AMEX_BOLETO',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_CERO',index:'AMEX_CERO',sorttype:"int",width:30, editable:true},
                                          //{name:'AMEX_EMPTY4',index:'AMEX_EMPTY4',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_NOM_PAX',index:'AMEX_NOM_PAX',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_CONCEPTO',index:'AMEX_CONCEPTO',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_FECHA_SALIDA',index:'AMEX_FECHA_SALIDA',sorttype:"int",width:80, editable:true},
                                          //{name:'AMEX_EMPTY5',index:'AMEX_EMPTY5',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY6',index:'AMEX_EMPTY6',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_STATUS',index:'AMEX_STATUS',sorttype:"int",width:30, editable:true},
                                          {name:'AMEX_A',index:'AMEX_A',sorttype:"int",width:30, editable:true},
                                          {name:'AMEX_FAC_NUMERO',index:'AMEX_FAC_NUMERO',sorttype:"int",width:80, editable:true},
                                          {name:'AMEX_ID_PROVEEDOR',index:'AMEX_ID_PROVEEDOR',sorttype:"int",width:50, editable:true},
                                          {name:'AMEX_TOTAL',index:'AMEX_TOTAL',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY7',index:'AMEX_EMPTY7',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY8',index:'AMEX_EMPTY8',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY9',index:'AMEX_EMPTY9',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_CONCEPTO2',index:'AMEX_CONCEPTO2',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_CLA_PAX',index:'AMEX_CLA_PAX',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY10',index:'AMEX_EMPTY10',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_TUA',index:'AMEX_TUA',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_IVA',index:'AMEX_IVA',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_OTROS_IMPUESTOS',index:'AMEX_OTROS_IMPUESTOS',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY11',index:'AMEX_EMPTY11',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY12',index:'AMEX_EMPTY12',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_FECHA_EMISION',index:'AMEX_FECHA_EMISION',sorttype:"int",width:80, editable:true},
                                          {name:'AMEX_STATUS2',index:'AMEX_STATUS2',sorttype:"int",width:30, editable:true},
                                          //{name:'AMEX_EMPTY13',index:'AMEX_EMPTY13',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY14',index:'AMEX_EMPTY14',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY15',index:'AMEX_EMPTY15',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY16',index:'AMEX_EMPTY16',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY17',index:'AMEX_EMPTY17',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY18',index:'AMEX_EMPTY18',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY19',index:'AMEX_EMPTY19',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_NOM_CENCO',index:'AMEX_NOM_CENCO',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY20',index:'AMEX_EMPTY20',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_IVA2',index:'AMEX_IVA2',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY21',index:'AMEX_EMPTY21',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY22',index:'AMEX_EMPTY22',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY23',index:'AMEX_EMPTY23',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY24',index:'AMEX_EMPTY24',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY25',index:'AMEX_EMPTY25',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY26',index:'AMEX_EMPTY26',sorttype:"int",autowidth:true, editable:true},
                                          {name:'AMEX_TARIFA_MON_BASE',index:'AMEX_TARIFA_MON_BASE',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY27',index:'AMEX_EMPTY27',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY28',index:'AMEX_EMPTY28',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY29',index:'AMEX_EMPTY29',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY30',index:'AMEX_EMPTY30',sorttype:"int",autowidth:true, editable:true},
                                          //{name:'AMEX_EMPTY31',index:'AMEX_EMPTY31',sorttype:"int",autowidth:true, editable:true}
                                          
                                ],
                                multiselect: false,
                                caption: "Layout amex",
                                width: 1200,
                                pager: "#pg_ptoolbar",
                                viewrecords: true,
                                rowNum: 10000000,
                                pgbuttons: false,
                                pginput: false
                                //rownumbers: true/*,
                                //editurl: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/edit_lay_amex",*/
                            });

                            for(var i=0;i<=data['rep'].length;i++){
                              $("#dg").jqGrid('addRowData',i+1,data['rep'][i]);
                            }

                            $("#dg").jqGrid('navGrid','#ptoolbar',{del:false,add:false,edit:false,search:false});
                            $("#dg").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
                            /*$.each(data['col'], function( index, value ) {

                              $("#dg").showCol(value['nombre_columna_vista']);
                                    
                            });*/

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                      
                  });

                 //}

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
      
      function btn_exportar_txt_lay_amex(){


        var allrows = jQuery("#dg").jqGrid('getRowData');

                $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/generar_txt",
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

                        window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/exportar_txt_lay_amex');            

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }
                      
                });

      }

      function btn_exportar_excel_rep_gvc(){

            var id_serie = $("#slc_mult_id_serie").val();
                     
            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();


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

            var page = $(".pagination-num").val();
                        
            var parametros = string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;
            var tipo_funcion = 'rep';
            
            //if(id_cliente.length == 0){

              window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/exportar_excel_usuario_masivo?parametros='+parametros+'&tipo_funcion=rep');

            //}else{

              //window.open('<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/exportar_excel_usuario?parametros='+parametros+'&tipo_funcion=rep');

            //}
  

      }

      function btn_comparar_tarjetas(){

                var id_cliente = $("#slc_mult_id_cliente").val();
                
                var string_ids_cliente = '';
                            
                $.each(id_cliente, function( index, value ) {

                  string_ids_cliente = string_ids_cliente + value + '_';
                
                });

                var ids_cliente = string_ids_cliente;

                  $.ajax({

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/get_comparacion_tarjetas",
                    type: 'POST',
                    data: {ids_cliente:ids_cliente},
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

                         $("#modal_content").css({"width": "50%"});

                         $('#modal_footer').hide();
                         $("#modal_body").html(data);
                         $("#modal_title").html("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Comparativo de tarjetas</h1></center>");

                         $('#myModal').modal({
                            backdrop: false,
                            show: true
                          });
                                                  
                        
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

                    url: "<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/get_catalogo_aereolineas_amex",
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
                        
                        $("#slc_mult_id_provedor_amex").multiselect('dataprovider', arr_obj);

                        var selectconfig = {
                            enableFiltering: true,
                            includeSelectAllOption: true
                        };

                        $('#slc_mult_id_provedor_amex').multiselect('setOptions', selectconfig);
                        
                        $('#slc_mult_id_provedor_amex').multiselect('rebuild');

                      }

                  });


      });

      function buscar(){
    
          get_lay_amex();
          
      }
	
</script>