<div class="row">

      <div class="col-md-12">
      
        <button type="button" class="btn btn-default" onclick="btn_grafica_rep_gast_gen();"><span class="fa fa-chart-pie" style="color:#ff814f;"></span>&nbsp;Grafica</button>
        <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_gast_gen();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
            
      </div>
      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
                      <center><img id="img_login" src="<?php echo base_url(); ?>referencias/img/load.gif" style="margin-top: -36px;" hidden></center>
                      <table id="dg_rep_gast_gen"></table>
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
  //$("#div_plantilla").show();

  function get_rep_gastos_generales(){
      
      $("#dg_rep_gast_gen").clearGridData(true).trigger("reloadGrid");

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

              
            btn_exportar_excel_rep_gast_gen();
              

          }else{

               $.ajax({
                      url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/get_rep_gastos_generales",
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

                         //console.log(data);

                         $("#dg_rep_gast_gen").jqGrid({
                            datatype: "local",
                            height: 500,
                            shrinkToFit:false,
                            forceFit:true,
                            colNames:['SERIE','DOCUMENTO','CORPORATIVO','CLIENTE','NOMBRE CLIENTE','CC','DESC CC','FECHA DOCUMENTO','QUIEN SOLICITO','PNR','BOLETO','CVE DE SERVICIO','CVE DE PROVEEDOR','RUTA','PASAJERO','TARIFA','IVA','TUA','OTROS IMPUESTOS','TOTAL','CLASE','FECHA DE SALIDA','FECHA DE REGRESO','FECHA DE EMISION','NUMERO DE EMPLEADO','CVE FORMA DE PAGO','FECHA DE RESERVACION'],
                            colModel:[

                                        {name:'GVC_ID_SERIE',index:'GVC_ID_SERIE',sorttype:"int",width: 250},
                                        {name:'GVC_DOC_NUMERO',index:'GVC_DOC_NUMERO',width: 250},
                                        {name:'GVC_ID_CORPORATIVO',index:'GVC_ID_CORPORATIVO',width: 250},
                                        {name:'GVC_ID_CLIENTE',index:'GVC_ID_CLIENTE',width: 250},
                                        {name:'GVC_NOM_CLI',index:'GVC_NOM_CLI',width: 250},
                                        {name:'GVC_ID_CENTRO_COSTO',index:'GVC_ID_CENTRO_COSTO',width: 250},
                                        {name:'GVC_DESC_CENTRO_COSTO',index:'GVC_DESC_CENTRO_COSTO',width: 250},
                                        {name:'GVC_FECHA',index:'GVC_FECHA',width: 250},
                                        {name:'GVC_SOLICITO',index:'GVC_SOLICITO',width: 250},
                                        {name:'GVC_CVE_RES_GLO',index:'GVC_CVE_RES_GLO',width: 250},
                                        {name:'GVC_BOLETO',index:'GVC_BOLETO',width: 250},
                                        {name:'GVC_ID_SERVICIO',index:'GVC_ID_SERVICIO',width: 250},
                                        {name:'GVC_ID_PROVEEDOR',index:'GVC_ID_PROVEEDOR',width: 250},
                                        {name:'GVC_CONCEPTO',index:'GVC_CONCEPTO',width: 250},
                                        {name:'GVC_NOM_PAX',index:'GVC_NOM_PAX',width: 250},
                                        {name:'GVC_TARIFA_MON_BASE',index:'GVC_TARIFA_MON_BASE',width: 250},
                                        {name:'GVC_IVA',index:'GVC_IVA',width: 250},
                                        {name:'GVC_TUA',index:'GVC_TUA',width: 250},
                                        {name:'GVC_OTROS_IMPUESTOS',index:'GVC_OTROS_IMPUESTOS',width: 250},
                                        {name:'GVC_TOTAL',index:'TOTAL',width: 250},
                                        {name:'GVC_CLASE_FACTURADA',index:'GVC_CLASE_FACTURADA',width: 250},
                                        {name:'GVC_FECHA_SALIDA',index:'GVC_FECHA_SALIDA',width: 250},
                                        {name:'GVC_FECHA_REGRESO',index:'GVC_FECHA_REGRESO',width: 250},
                                        {name:'GVC_FECHA_EMISION_BOLETO',index:'GVC_FECHA_EMISION_BOLETO',width: 250},
                                        {name:'GVC_CLAVE_EMPLEADO',index:'GVC_CLAVE_EMPLEADO',width: 250},
                                        {name:'GVC_FOR_PAG1',index:'GVC_FOR_PAG1',width: 250},
                                        {name:'GVC_FECHA_RESERVACION',index:'GVC_FECHA_RESERVACION',width: 250},
                                        
                                        
                            ],
                            multiselect: true,
                            caption: "Gastos generales Neto",
                            width: 1200,
                            pager: "#pg_ptoolbar",
                            viewrecords: true,

                            rowNum: 10000000,
                            pgbuttons: false,
                            pginput: false
                        });
                  
                  for(var i=0;i<=data['rep'].length;i++){
                    $("#dg_rep_gast_gen").jqGrid('addRowData',i+1,data['rep'][i]);
                  }
                  

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

  function btn_grafica_rep_gast_gen(){

            rest_modal('');

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
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/get_prueba_grafica",
                    type: 'POST',
                    data: {parametros:parametros,proceso:"man"},
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

                         $("#modal_content").css({"width": "80%"});
                         $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });
                         $('#modal_footer').hide();
                         $("#modal_body").append(data);

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                      
                  });

       
    }

  function btn_exportar_excel_rep_gast_gen(){

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


            //window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/exportar_excel_usuario?parametros='+parametros+'&tipo_funcion=rep');
            
            window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/exportar_excel_usuario?parametros='+parametros+'&tipo_funcion=rep', 'download_window');

            
             /*$.ajax({
                    async:true,
                    type:"POST",
                    dataType:"html",//html
                    contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                    url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/exportar_excel_usuario",
                    data:{parametros:parametros,tipo_funcion:tipo_funcion},
                    beforeSend : function() {

                       $.blockUI({ 
                        message: '<h1> Descargando Excel </h1>', 
                        css: { 
                            border: 'none', 
                            padding: '15px', 
                            backgroundColor: '#000', 
                            '-webkit-border-radius': '10px', 
                            '-moz-border-radius': '10px', 
                            opacity: .5, 
                            color: '#fff' 
                        } 
                      });

                    }, 
                    complete: function () {
                        
                         $.unblockUI();
                    },
                    success: function (data) {

                          var opResult = JSON.parse(data);
                          var $a=$("<a>");
                          $a.attr("href",opResult.data);
                          //$a.html("LNK");
                          $("body").append($a);
                          $a.attr("download","Gastos_generales.xlsx");
                          $a[0].click();
                          $a.remove();

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                      
                  });*/



  }
      
  function buscar(){
    
    get_rep_gastos_generales();
    
  }

  function btn_exportar_pdf(){

      window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/prueba_pdf');

  }


</script>