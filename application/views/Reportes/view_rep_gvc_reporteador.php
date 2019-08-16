<div class="row">

      <div class="col-md-12">
            <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_gvc();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
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

  $("#div_select_multiple_sucursal").show();
  $("#div_select_id_serie").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  $("#div_select_multiple_id_serie").show();
  $("#div_select_multiple_id_servicio").show();
  $("#div_select_multiple_id_provedor").show();
  $("#div_select_multiple_id_corporativo").show();
  $("#div_plantilla").show();

	function get_rep_gvc_reporteador(){

            $("#dg").clearGridData(true).trigger("reloadGrid");
           
            var parametros = {};

            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();
                     
            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();
           
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
	          
            if(id_cliente.length == 0 && id_corporativo.length == 0){

              btn_exportar_excel_rep_gvc();

            }else{

            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador/get_rep_gvc_reporteador",
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
                          
                            data = JSON.parse(data);

                            $("#dg").jqGrid({

                                datatype: "local",
                                height: 500,
                                shrinkToFit:false,
                                forceFit:true,
                                colNames:['GVC_DOC_NUMERO ','GVC_ID_SUCURSAL','GVC_ID_SERIE','GVC_ID_CORPORATIVO','GVC_NOM_CORP','GVC_ID_CLIENTE','GVC_NOM_CLI','GVC_ID_CENTRO_COSTO','GVC_DESC_CENTRO_COSTO','GVC_ID_DEPTO','GVC_DEPTO','GVC_ID_VEN_TIT','GVC_NOM_VEN_TIT','GVC_ID_VEN_AUX','GVC_NOM_VEN_AUX','GVC_ID_CIUDAD','GVC_FECHA','GVC_MONEDA','GVC_TIPO_CAMBIO','GVC_SOLICITO','GVC_CVE_RES_GLO','analisis1_cliente','analisis2_cliente','analisis3_cliente','analisis4_cliente','analisis5_cliente','analisis6_cliente','analisis7_cliente','analisis8_cliente','analisis9_cliente','analisis10_cliente','analisis11_cliente','analisis12_cliente','analisis13_cliente','analisis14_cliente','analisis15_cliente','analisis16_cliente','analisis17_cliente','analisis18_cliente','analisis19_cliente','analisis20_cliente','analisis21_cliente','analisis22_cliente','analisis23_cliente','analisis24_cliente','analisis25_cliente','analisis26_cliente','analisis27_cliente','analisis28_cliente','analisis29_cliente','analisis30_cliente','analisis31_cliente','analisis32_cliente','analisis33_cliente','analisis34_cliente','analisis35_cliente','analisis36_cliente','analisis39_cliente','confirmacion_la','analisis40_cliente','analisis41_cliente','analisis42_cliente','analisis43_cliente','analisis44_cliente','analisis45_cliente','analisis46_cliente','analisis47_cliente','analisis48_cliente','analisis49_cliente','analisis50_cliente','analisis51_cliente','analisis52_cliente','analisis53_cliente','analisis54_cliente','analisis55_cliente','analisis56_cliente','analisis57_cliente','analisis58_cliente','analisis59_cliente','analisis60_cliente','TIPO_BOLETO','GVC_BOLETO','GVC_ID_SERVICIO','GVC_ID_PROVEEDOR','BOLETO_EMD','GVC_ALCANCE_SERVICIO','GVC_CONCEPTO','GVC_NOM_PAX','GVC_TARIFA_MON_BASE','GVC_TARIFA_MON_EXT','GVC_DESCUENTO','GVC_IVA_DESCUENTO','GVC_COM_AGE','GVC_POR_COM_AGE','GVC_COM_TIT','GVC_POR_COM_TIT','GVC_COM_AUX','GVC_POR_COM_AUX','GVC_POR_IVA_COM','GVC_IVA','GVC_TUA','GVC_OTROS_IMPUESTOS','GVC_SUMA_IMPUESTOS','GVC_IVA_EXT','GVC_TUA_EXT','GVC_OTR_EXT','GVC_CVE_SUCURSAL','GVC_NOM_SUCURSAL','GVC_TARIFA_COMPARATIVA_BOLETO','GVC_TARIFA_COMPARATIVA_BOLETO_EXT','GVC_CLASE_FACTURADA','GVC_CLASE_COMPARATIVO','GVC_FECHA_SALIDA','GVC_FECHA_REGRESO','GVC_FECHA_EMISION_BOLETO','GVC_CLAVE_EMPLEADO','GVC_FOR_PAG1','GVC_FOR_PAG2','GVC_FOR_PAG3','GVC_FOR_PAG4','GVC_FOR_PAG5','GVC_FAC_NUMERO','GVC_ID_SERIE_FAC','GVC_FAC_CVE_SUCURSAL'],
                                colModel:[

                                          {name:'GVC_DOC_NUMERO',index:'GVC_DOC_NUMERO',width: 250},
                                          {name:'GVC_ID_SUCURSAL',index:'GVC_ID_SUCURSAL',sorttype:"int",width: 250},
                                          {name:'GVC_ID_SERIE',index:'GVC_ID_SERIE',width: 250},
                                          {name:'GVC_ID_CORPORATIVO',index:'GVC_ID_CORPORATIVO',width: 250},
                                          {name:'GVC_NOM_CORP',index:'GVC_NOM_CORP',width: 250},
                                          {name:'GVC_ID_CLIENTE',index:'GVC_ID_CLIENTE',width: 250},
                                          {name:'GVC_NOM_CLI',index:'GVC_NOM_CLI',width: 250},
                                          {name:'GVC_ID_CENTRO_COSTO',index:'GVC_ID_CENTRO_COSTO',width: 250},
                                          {name:'GVC_DESC_CENTRO_COSTO',index:'GVC_DESC_CENTRO_COSTO',width: 250},
                                          {name:'GVC_ID_DEPTO',index:'GVC_ID_DEPTO',width: 250},
                                          {name:'GVC_DEPTO',index:'GVC_DEPTO',width: 250},
                                          {name:'GVC_ID_VEN_TIT',index:'GVC_ID_VEN_TIT',width: 250},
                                          {name:'GVC_NOM_VEN_TIT',index:'GVC_NOM_VEN_TIT',width: 250},
                                          {name:'GVC_ID_VEN_AUX',index:'GVC_ID_VEN_AUX',width: 250},
                                          {name:'GVC_NOM_VEN_AUX',index:'GVC_NOM_VEN_AUX',width: 250},
                                          {name:'GVC_ID_CIUDAD',index:'GVC_ID_CIUDAD',width: 250},
                                          {name:'GVC_FECHA',index:'GVC_FECHA',width: 250},
                                          {name:'GVC_MONEDA',index:'GVC_MONEDA',width: 250},
                                          {name:'GVC_TIPO_CAMBIO',index:'GVC_TIPO_CAMBIO',width: 250},
                                          {name:'GVC_SOLICITO',index:'GVC_SOLICITO',width: 250},
                                          {name:'GVC_CVE_RES_GLO',index:'GVC_CVE_RES_GLO',width: 250},
                                          {name:'analisis1_cliente',index:'analisis1_cliente',width: 250},
                                          {name:'analisis2_cliente',index:'analisis2_cliente',width: 250},
                                          {name:'analisis3_cliente',index:'analisis3_cliente',width: 250},
                                          {name:'analisis4_cliente',index:'analisis4_cliente',width: 250},
                                          {name:'analisis5_cliente',index:'analisis5_cliente',width: 250},
                                          {name:'analisis6_cliente',index:'analisis6_cliente',width: 250},
                                          {name:'analisis7_cliente',index:'analisis7_cliente',width: 250},
                                          {name:'analisis8_cliente',index:'analisis8_cliente',width: 250},
                                          {name:'analisis9_cliente',index:'analisis9_cliente',width: 250},
                                          {name:'analisis10_cliente',index:'analisis10_cliente',width: 250},
                                          {name:'analisis11_cliente',index:'analisis11_cliente',width: 250},
                                          {name:'analisis12_cliente',index:'analisis12_cliente',width: 250},
                                          {name:'analisis13_cliente',index:'analisis13_cliente',width: 250},
                                          {name:'analisis14_cliente',index:'analisis14_cliente',width: 250},
                                          {name:'analisis15_cliente',index:'analisis15_cliente',width: 250},
                                          {name:'analisis16_cliente',index:'analisis16_cliente',width: 250},
                                          {name:'analisis17_cliente',index:'analisis17_cliente',width: 250},
                                          {name:'analisis18_cliente',index:'analisis18_cliente',width: 250},
                                          {name:'analisis19_cliente',index:'analisis19_cliente',width: 250},
                                          {name:'analisis20_cliente',index:'analisis20_cliente',width: 250},
                                          {name:'analisis21_cliente',index:'analisis21_cliente',width: 250},
                                          {name:'analisis22_cliente',index:'analisis22_cliente',width: 250},
                                          {name:'analisis23_cliente',index:'analisis23_cliente',width: 250},
                                          {name:'analisis24_cliente',index:'analisis24_cliente',width: 250},
                                          {name:'analisis25_cliente',index:'analisis25_cliente',width: 250},
                                          {name:'analisis26_cliente',index:'analisis26_cliente',width: 250},
                                          {name:'analisis27_cliente',index:'analisis27_cliente',width: 250},
                                          {name:'analisis28_cliente',index:'analisis28_cliente',width: 250},
                                          {name:'analisis29_cliente',index:'analisis29_cliente',width: 250},
                                          {name:'analisis30_cliente',index:'analisis30_cliente',width: 250},
                                          {name:'analisis31_cliente',index:'analisis31_cliente',width: 250},
                                          {name:'analisis32_cliente',index:'analisis32_cliente',width: 250},
                                          {name:'analisis33_cliente',index:'analisis33_cliente',width: 250},
                                          {name:'analisis34_cliente',index:'analisis34_cliente',width: 250},
                                          {name:'analisis35_cliente',index:'analisis35_cliente',width: 250},
                                          {name:'analisis36_cliente',index:'analisis36_cliente',width: 250},
                                          {name:'analisis39_cliente',index:'analisis39_cliente',width: 250},
                                          {name:'confirmacion_la',index:'confirmacion_la',width: 250},
                                          {name:'analisis40_cliente',index:'analisis40_cliente',width: 250},
                                          {name:'analisis41_cliente',index:'analisis41_cliente',width: 250},
                                          {name:'analisis42_cliente',index:'analisis42_cliente',width: 250},
                                          {name:'analisis43_cliente',index:'analisis43_cliente',width: 250},
                                          {name:'analisis44_cliente',index:'analisis44_cliente',width: 250},
                                          {name:'analisis45_cliente',index:'analisis45_cliente',width: 250},
                                          {name:'analisis46_cliente',index:'analisis46_cliente',width: 250},
                                          {name:'analisis47_cliente',index:'analisis47_cliente',width: 250},
                                          {name:'analisis48_cliente',index:'analisis48_cliente',width: 250},
                                          {name:'analisis49_cliente',index:'analisis49_cliente',width: 250},
                                          {name:'analisis50_cliente',index:'analisis50_cliente',width: 250},
                                          {name:'analisis51_cliente',index:'analisis51_cliente',width: 250},
                                          {name:'analisis52_cliente',index:'analisis52_cliente',width: 250},
                                          {name:'analisis53_cliente',index:'analisis53_cliente',width: 250},
                                          {name:'analisis54_cliente',index:'analisis54_cliente',width: 250},
                                          {name:'analisis55_cliente',index:'analisis55_cliente',width: 250},
                                          {name:'analisis56_cliente',index:'analisis56_cliente',width: 250},
                                          {name:'analisis57_cliente',index:'analisis57_cliente',width: 250},
                                          {name:'analisis58_cliente',index:'analisis58_cliente',width: 250},
                                          {name:'analisis59_cliente',index:'analisis59_cliente',width: 250},
                                          {name:'analisis60_cliente',index:'analisis60_cliente',width: 250},
                                          {name:'TIPO_BOLETO',index:'TIPO_BOLETO',width: 250},
                                          {name:'GVC_BOLETO',index:'GVC_BOLETO',width: 250},
                                          {name:'GVC_ID_SERVICIO',index:'GVC_ID_SERVICIO',width: 250},
                                          {name:'GVC_ID_PROVEEDOR',index:'GVC_ID_PROVEEDOR',width: 250},
                                          {name:'BOLETO_EMD',index:'BOLETO_EMD',width: 250},
                                          {name:'GVC_ALCANCE_SERVICIO',index:'GVC_ALCANCE_SERVICIO',width: 250},
                                          {name:'GVC_CONCEPTO',index:'GVC_CONCEPTO',width: 250},
                                          {name:'GVC_NOM_PAX',index:'GVC_NOM_PAX',width: 250},
                                          {name:'GVC_TARIFA_MON_BASE',index:'GVC_TARIFA_MON_BASE',width: 250},
                                          {name:'GVC_TARIFA_MON_EXT',index:'GVC_TARIFA_MON_EXT',width: 250},
                                          {name:'GVC_DESCUENTO',index:'GVC_DESCUENTO',width: 250},
                                          {name:'GVC_IVA_DESCUENTO',index:'GVC_IVA_DESCUENTO',width: 250},
                                          {name:'GVC_COM_AGE',index:'GVC_COM_AGE',width: 250},
                                          {name:'GVC_POR_COM_AGE',index:'GVC_POR_COM_AGE',width: 250},
                                          {name:'GVC_COM_TIT',index:'GVC_COM_TIT',width: 250},
                                          {name:'GVC_POR_COM_TIT',index:'GVC_POR_COM_TIT',width: 250},
                                          {name:'GVC_COM_AUX',index:'GVC_COM_AUX',width: 250},
                                          {name:'GVC_POR_COM_AUX',index:'GVC_POR_COM_AUX',width: 250},
                                          {name:'GVC_POR_IVA_COM',index:'GVC_POR_IVA_COM',width: 250},
                                          {name:'GVC_IVA',index:'GVC_IVA',width: 250},
                                          {name:'GVC_TUA',index:'GVC_TUA',width: 250},
                                          {name:'GVC_OTROS_IMPUESTOS',index:'GVC_OTROS_IMPUESTOS',width: 250},
                                          {name:'GVC_SUMA_IMPUESTOS',index:'GVC_SUMA_IMPUESTOS',width: 250},
                                          {name:'GVC_IVA_EXT',index:'GVC_IVA_EXT',width: 250},
                                          {name:'GVC_TUA_EXT',index:'GVC_TUA_EXT',width: 250},
                                          {name:'GVC_OTR_EXT',index:'GVC_OTR_EXT',width: 250},
                                          {name:'GVC_CVE_SUCURSAL',index:'GVC_CVE_SUCURSAL',width: 250},
                                          {name:'GVC_NOM_SUCURSAL',index:'GVC_NOM_SUCURSAL',width: 250},
                                          {name:'GVC_TARIFA_COMPARATIVA_BOLETO',index:'GVC_TARIFA_COMPARATIVA_BOLETO',width: 250},
                                          {name:'GVC_TARIFA_COMPARATIVA_BOLETO_EXT',index:'GVC_TARIFA_COMPARATIVA_BOLETO_EXT',width: 250},
                                          {name:'GVC_CLASE_FACTURADA',index:'GVC_CLASE_FACTURADA',width: 250},
                                          {name:'GVC_CLASE_COMPARATIVO',index:'GVC_CLASE_COMPARATIVO',width: 250},
                                          {name:'GVC_FECHA_SALIDA',index:'GVC_FECHA_SALIDA',width: 250},
                                          {name:'GVC_FECHA_REGRESO',index:'GVC_FECHA_REGRESO',width: 250},
                                          {name:'GVC_FECHA_EMISION_BOLETO',index:'GVC_FECHA_EMISION_BOLETO',width: 250},
                                          {name:'GVC_CLAVE_EMPLEADO',index:'GVC_CLAVE_EMPLEADO',width: 250},
                                          {name:'GVC_FOR_PAG1',index:'GVC_FOR_PAG1',width: 250},
                                          {name:'GVC_FOR_PAG2',index:'GVC_FOR_PAG2',width: 250},
                                          {name:'GVC_FOR_PAG3',index:'GVC_FOR_PAG3',width: 250},
                                          {name:'GVC_FOR_PAG4',index:'GVC_FOR_PAG4',width: 250},
                                          {name:'GVC_FOR_PAG5',index:'GVC_FOR_PAG5',width: 250},
                                          {name:'GVC_FAC_NUMERO',index:'GVC_FAC_NUMERO',width: 250},
                                          {name:'GVC_ID_SERIE_FAC',index:'GVC_ID_SERIE_FAC',width: 250},
                                          {name:'GVC_FAC_CVE_SUCURSAL',index:'GVC_FAC_CVE_SUCURSAL'}
                                ],
                                //multiselect: true,
                                caption: "GVC_reporteador",
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

                            /*$.each(data['col'], function( index, value ) {

                              $("#dg").showCol(value['nombre_columna_vista']);
                                    
                            });*/

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                      
                  });

                 }

	    }

      function btn_exportar_excel_rep_gvc(){

            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();
                     
            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_mult_id_servicio").val();

            var id_provedor = $("#slc_mult_id_provedor").val();

            var id_corporativo = $("#slc_mult_id_corporativo").val();

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
            
            var page = $(".pagination-num").val();
                        
            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+id_plantilla+','+fecha1+','+fecha2;
            var tipo_funcion = 'rep';
            
            
            //if(id_cliente.length == 0){

              window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador/exportar_excel_usuario_masivo?parametros='+parametros+'&tipo_funcion=rep');

            //}else{

              //window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador/exportar_excel_usuario?parametros='+parametros+'&tipo_funcion=rep');

            //}

            

      }

      function buscar(){
    
          get_rep_gvc_reporteador();
          
      }
	
</script>