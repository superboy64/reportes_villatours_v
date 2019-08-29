<div class="row">

      <div class="col-md-12">
      
        <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_hot_li();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
            
      </div>
      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
                      <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                      <table id="dg_rep_hot_limp"></table>
                      <div id="pg_ptoolbar" style="height: 2px;"></div>
                </div>
            
      </div>

</div>

<script type="text/javascript">
  
  $("#title").html('<?=$title?>');
  $("#div_select_multiple_sucursal").show();
  $("#div_select_id_serie").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_select_id_corporativo").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  $("#div_select_multiple_id_serie").show();
  $("#div_select_multiple_id_servicio").show();
  $("#div_select_multiple_id_provedor").show();
  $("#div_select_multiple_id_corporativo").show();

  function get_rep_gastos_generales(){
      
      $("#dg_rep_hot_limp").clearGridData(true).trigger("reloadGrid");

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

       

               $.ajax({
                      url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_hoteles_limpieza/get_rep_hoteles_limpieza",
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

                         $("#dg_rep_hot_limp").jqGrid({
                            datatype: "local",
                            height: 500,
                            shrinkToFit:false,
                            forceFit:true,
                            colNames:['GVC_ID_SERVICIO','GVC_ID_SERIE','GVC_DOC_NUMERO','GVC_ID_CLIENTE','GVC_RECORD_LOCALIZADOR','GVC_CVE_PAX','GVC_NOMBRE_PAX','GVC_NOMBRE_HOTEL','GVC_FECHA_ENTRADA','GVC_FECHA_SALIDA','GVC_NOCHES','GVC_FECHA_FACTURA','GVC_FECHA_RESERVACION','GVC_AC28','GVC_AC01','GVC_ID_CORPORATIVO','GVC_NOM_CLI','GVC_ID_STAT'],
                            colModel:[

                                    {name:'GVC_ID_SERVICIO',index:'GVC_ID_SERVICIO',width: 250},
                                    {name:'GVC_ID_SERIE',index:'GVC_ID_SERIE',width: 250},
                                    {name:'GVC_DOC_NUMERO',index:'GVC_DOC_NUMERO',width: 250},
                                    {name:'GVC_ID_CLIENTE',index:'GVC_ID_CLIENTE',width: 250},
                                    {name:'GVC_RECORD_LOCALIZADOR',index:'GVC_RECORD_LOCALIZADOR',width: 250},
                                    {name:'GVC_CVE_PAX',index:'GVC_CVE_PAX',width: 250},
                                    {name:'GVC_NOMBRE_PAX',index:'GVC_NOMBRE_PAX',width: 250},
                                    {name:'GVC_NOMBRE_HOTEL',index:'GVC_NOMBRE_HOTEL',width: 250},
                                    {name:'GVC_FECHA_ENTRADA',index:'GVC_FECHA_ENTRADA',width: 250},
                                    {name:'GVC_FECHA_SALIDA',index:'GVC_FECHA_SALIDA',width: 250},
                                    {name:'GVC_NOCHES',index:'GVC_NOCHES',width: 250},
                                    {name:'GVC_FECHA_FACTURA',index:'GVC_FECHA_FACTURA',width: 250},
                                    {name:'GVC_FECHA_RESERVACION',index:'GVC_FECHA_RESERVACION',width: 250},
                                    {name:'GVC_AC28',index:'GVC_AC28',width: 250},
                                    {name:'GVC_AC01',index:'GVC_AC01',width: 250},
                                    {name:'GVC_ID_CORPORATIVO',index:'GVC_ID_CORPORATIVO',width: 250},
                                    {name:'GVC_NOM_CLI',index:'GVC_NOM_CLI',width: 250},
                                    {name:'GVC_ID_STAT',index:'GVC_ID_STAT',width: 250},
                                   
                                        
                            ],
                            multiselect: true,
                            caption: "Hoteles limpieza",
                            width: 1200,
                            pager: "#pg_ptoolbar",
                            viewrecords: true,

                            rowNum: 10000000,
                            pgbuttons: false,
                            pginput: false
                        });
                  
                  for(var i=0;i<=data['rep'].length;i++){
                    $("#dg_rep_hot_limp").jqGrid('addRowData',i+1,data['rep'][i]);
                  }
                  

                },
                error: function () {
                    $.unblockUI();
                    alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                }
            });

        

         


  }
  
  function number_format(num,dig,dec,sep) {
    x=new Array();
    s=(num<0?"-":"");
    num=Math.abs(num).toFixed(dig).split(".");
    r=num[0].split("").reverse();
    for(var i=1;i<=r.length;i++){x.unshift(r[i-1]);if(i%3==0&&i!=r.length)x.unshift(sep);}
    return s+x.join("")+(num[1]?dec+num[1]:"");
  }


  function btn_exportar_excel_rep_hot_li(){

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

            window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_hoteles_limpieza/exportar_excel_usuario?parametros='+parametros+'&tipo_funcion=rep', 'download_window');


  }
      
  function buscar(){
    
    get_rep_gastos_generales();
    
  }

  function btn_exportar_pdf(){

      window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_hoteles_limpieza/prueba_pdf');

  }


</script>