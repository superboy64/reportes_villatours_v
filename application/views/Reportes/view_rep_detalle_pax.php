<script src="<?php echo base_url(); ?>referencias/chartjs/dist/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>referencias/Chartjs/utils.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

<style>
canvas {
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
}
</style>

<div class="row">

      <div class="col-md-12">
      
        <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_gastos_Ae();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
            
      </div>
      <div class="col-md-12">
            
                <div id="div_datagrid_html" style="height: 80%;overflow-x: auto;">
                      
                </div>
            
      </div>

</div>


<script type="text/javascript">
  
  $("#title").html('<?=$title?>');

  $("#div_select_multiple_sucursal").show();
  $("#div_select_multiple_id_serie").show();
  $("#div_select_multiple_id_cliente").show();
  $("#div_select_id_corporativo").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  //$("#div_select_multiple_id_servicio").show();
  //$("#div_select_id_servicio").show();
  $("#div_select_multiple_id_provedor").show();
  $("#div_select_multiple_id_corporativo").show();
  

  function buscar(){

    btn_grafica_rep_gastos_ae();

  }

  function btn_grafica_rep_gastos_ae(){

            var parametros = {};
            
            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();

            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_id_servicio").val();

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

            var string_ids_provedor = '';
            
            $.each(id_provedor, function( index, value ) {

              string_ids_provedor = string_ids_provedor + value + '_';
            
            });

            var string_ids_corporativo = '';
            
            $.each(id_corporativo, function( index, value ) {

              string_ids_corporativo = string_ids_corporativo + value + '_';
            
            });

            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();
                        
            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_provedor+','+string_ids_corporativo+','+fecha1+','+fecha2;
            
            var tipo_funcion = 'man';

                    $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/get_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:tipo_funcion,id_servicio:id_servicio},
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
      
                        $("#div_datagrid_html").empty();
                        
                        if(data.length > 0){

                              $.ajax({
                                
                                url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/get_pasajero_html",
                                type: 'POST',
                                data: {parametros:parametros,data:data},
                                complete: function () {
                                    
                                     $.unblockUI();
                                },
                                success: function (data) {
                                    
                                      $("#div_datagrid_html").html(data); 
                                    
                                }
                                
                              });

                          }//fin cont
                          else{

                            $.unblockUI();
                            $("#div_datagrid_html").html("No existen consumos"); 

                          }

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                  });

       
    }
  

function btn_exportar_excel_rep_gastos_Ae(){

          $("#div_datagrid").empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped"></canvas></div><div id="div_datagrid_html"></div>');
          
          $("#bar-chart-grouped").hide();

            var parametros = {};
            
            var id_suc = $("#slc_mult_id_suc").val();

            var id_serie = $("#slc_mult_id_serie").val();

            var id_cliente = $("#slc_mult_id_cliente").val();

            var id_servicio = $("#slc_id_servicio").val();

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

           
            var string_ids_provedor = '';
            
            $.each(id_provedor, function( index, value ) {

              string_ids_provedor = string_ids_provedor + value + '_';
            
            });

            var string_ids_corporativo = '';
            
            $.each(id_corporativo, function( index, value ) {

              string_ids_corporativo = string_ids_corporativo + value + '_';
            
            });

            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();
                        
            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_provedor+','+string_ids_corporativo+','+fecha1+','+fecha2;
            var tipo_funcion = 'man';
            
            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/get_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:tipo_funcion,id_servicio:id_servicio},
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

                        $("#div_datagrid_html").empty();

                          if(data.length > 0){

                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/exportar_excel_ae",
                              data:{tipo_funcion:tipo_funcion,parametros:parametros,id_servicio:id_servicio,data:data},
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
                                    $a.attr("download","Reporte_detalle_pax_"+opResult.str_fecha+".xlsx");
                                    $a[0].click();
                                    $a.remove();

                                    $("#div_datagrid_grafica").empty();
                                    
                                  }else{

                                    $("#div_datagrid_html").html("No existen consumos a exportar"); 


                                  }

                                },
                                error: function () {
                                    $.unblockUI();
                                    alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                                }

                                      
                           });

                          }//fin cont
                          else{

                           
                            $("#div_datagrid_html").html("No existen consumos"); 

                          }


                           $.unblockUI();
                                                

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                      
                  });

            //window.open('<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae/exportar_excel_ae?parametros='+parametros+'&tipo_funcion=rep');


}

</script>