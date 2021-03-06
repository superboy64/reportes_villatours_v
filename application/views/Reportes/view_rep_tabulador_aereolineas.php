<link rel="stylesheet" href="<?php echo base_url(); ?>referencias/css/style_grafica_rep_graficos.css" type="text/css" media="print">

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

        <button type="button" class="btn btn-default" onclick="btn_exportar_excel_rep_graf_Ae();"><span class="fa fa-file-excel" style="color:#2fb30e;"></span>&nbsp;Descargar</button>
      
      </div>
      
      <div class="col-md-12">
            
                <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
                        
                          <div id="div_datagrid_grafica" style="width: 45%;margin: 0 auto;">
    
                              <canvas id="bar-chart-grouped"></canvas>


                          </div>

                          <div id="div_datagrid_html">
    
                            

                          </div>  

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
  $("#div_select_multiple_id_servicio").show();
  $("#div_select_multiple_id_provedor").show();
  $("#div_select_multiple_id_corporativo").show();
  

  function buscar(){

    btn_grafica_rep_graf_ae();

  }

  function btn_grafica_rep_graf_ae(){

           $("#div_datagrid").empty();
           $("#div_datagrid").append('<div id="div_datagrid_grafica" style="width: 45%;margin: 0 auto;"><canvas id="bar-chart-grouped"></canvas></div><div id="div_datagrid_html"></div>');
          

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

            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();
                        
            var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+fecha1+','+fecha2;
            var tipo_funcion = 'man';

                    $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_tabulador_aereolineas/get_grafica_provedor",
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
                    success: function (data) {
                        
                        data = JSON.parse(data);

                        var arr_dat_BD = [];
                        var arr_dat_BI = [];
                        
                        $("#div_datagrid_html").empty();

                        var arr_dom = [];
                        var arr_int = [];
                        var arr_prov = [];
                        
                        var arr_grafica =  data['grafica'];

                        if(arr_grafica.length > 0){

                            $.each(data['grafica'], function( index, value ) {

                              arr_prov.push(value['ID_PROVEDOR']);

                              
                              if(value['BOL_DOM'] == null && value['BOL_INT'] != null){

                                 arr_dom.push(0);
                                 arr_int.push(value['BOL_INT']);

                              }else if(value['BOL_INT'] == null && value['BOL_DOM'] != null){

                                arr_dom.push(value['BOL_DOM']);
                                arr_int.push(0);

                              }else{

                                 if(value['DESC_SERVICIO'] == 'BOLETO DOMESTICO'){
                                 
                                   arr_dom.push(value['BOL_DOM']);
                                 
                                   

                                  }

                                  if(value['DESC_SERVICIO'] == 'BOLETOS INTERNACIONALES'){

                                 
                                   arr_int.push(value['BOL_INT']);
                                   
                                       

                                  }


                              }

                             

                              if(value['DESC_SERVICIO'] == 'BOLETO DOMESTICO'){

                                   arr_dat_BD.push(value);
                                   
                                   

                              }

                              if(value['DESC_SERVICIO'] == 'BOLETOS INTERNACIONALES'){

                                   arr_dat_BI.push(value);
                                   
                                  
                                   

                              }

                             

                            });

                            arr_prov = arr_prov.unique();

                            var myLine = new Chart(document.getElementById("bar-chart-grouped"), {
                                  type: 'bar',
                                  data: {
                                    labels: arr_prov,
                                    datasets: [
                                      {
                                        label: "Boletos Domesticos",
                                        backgroundColor: "#1f497d",
                                        data: arr_dom
                                      }, {
                                        label: "Boletos Internacionales",
                                        backgroundColor: "#98DCFB",
                                        data: arr_int
                                      }
                                    ]
                                  },
                                  options: {
                                    scales: { 
                                      xAxes: [{ 
                                         gridLines: { 
                                          color: "rgba(0, 0, 0, 0)", 
                                         } 
                                        }], 
                                      yAxes: [{ 
                                         gridLines: { 
                                          color: "rgba(0, 0, 0, 0)", 
                                         } 
                                        }]
                                    }, 
                                    title: {
                                      display: false,
                                      text: 'Population growth (millions)'
                                    }
                                  }
                              });


                              $.ajax({
                                
                                url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_tabulador_aereolineas/get_grafica_provedor_html",
                                type: 'POST',
                                data: {arr_dat_BD:arr_dat_BD,arr_dat_BI:arr_dat_BI,parametros:parametros},
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
                            $("#div_datagrid_html").html("No existen consumos a exportar"); 

                          }

                      },
                      error: function () {
                          $.unblockUI();
                          alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                      }

                  });

       
    }
  


function btn_exportar_excel_rep_graf_Ae(){


  var totalcontbd = $("#contBD").val();
  var totalcontbi = $("#contBI").val();
  
  var arr_dat_BD = [];
  
  /*
     arr_BD['NOMBRE_PROVEDOR'] = aereolineabd;
     arr_BD['TOTAL_BOL'] = total_bol_bd;
     arr_BD['BOL_DOM'] = tarifabd;
     arr_BD['COMISIONBD'] = comisionbd;
     arr_BD['VAL_COM_BD'] = val_com_bd;
     arr_BD['INGRESOBD'] = ingresobd;
     arr_BD['VAL_ING_BD'] = val_ing_bd;
     arr_BD['VAL_TOT_BD'] = val_tot_bd;

  */
  
  for(var x=0;x<totalcontbd;x++){

     var aereolineabd =  $("#aereolineabd_"+x).val();
     var total_bol_bd =  $("#total_bol_bd_"+x).val();
     var tarifabd =      $("#tarifabd_"+x).val();
     var comisionbd =    $("#comisionbd_"+x).val();
     var val_com_bd =    $("#val_com_bd_"+x).val();
     var ingresobd =     $("#ingresobd_"+x).val();
     var val_ing_bd =    $("#val_ing_bd_"+x).val();
     var val_tot_bd =    $("#val_tot_bd_"+x).val();
     
     var arr_BD = [];

     arr_BD[0] = aereolineabd;
     arr_BD[1] = total_bol_bd;
     arr_BD[2] = tarifabd;
     arr_BD[3] = comisionbd;
     arr_BD[4] = val_com_bd;
     arr_BD[5] = ingresobd;
     arr_BD[6] = val_ing_bd;
     arr_BD[7] = val_tot_bd;

     arr_dat_BD.push(arr_BD);


  }

  
  var arr_dat_BI = [];

  for(var x=0;x<totalcontbi;x++){

     var aereolineabi =  $("#aereolineabi_"+x).val();
     var total_bol_bi =  $("#total_bol_bi_"+x).val();
     var tarifabi =      $("#tarifabi_"+x).val();
     var comisionbi =    $("#comisionbi_"+x).val();
     var val_com_bi =    $("#val_com_bi_"+x).val();
     var ingresobi =     $("#ingresobi_"+x).val();
     var val_ing_bi =    $("#val_ing_bi_"+x).val();
     var val_tot_bi =    $("#val_tot_bi_"+x).val();
     
     var arr_BI = [];

     arr_BI[0] = aereolineabi;
     arr_BI[1] = total_bol_bi;
     arr_BI[2] = tarifabi;
     arr_BI[3] = comisionbi;
     arr_BI[4] = val_com_bi;
     arr_BI[5] = ingresobi;
     arr_BI[6] = val_ing_bi;
     arr_BI[7] = val_tot_bi;


     arr_dat_BI.push(arr_BI);

  }

  var val_tot_gen_bd = $("#val_tot_gen_bd").val();
  val_tot_gen_bd = val_tot_gen_bd.split(',').join('');
  val_tot_gen_bd = parseFloat(val_tot_gen_bd);

  var val_tot_gen_bi = $("#val_tot_gen_bi").val();
  val_tot_gen_bi = val_tot_gen_bi.split(',').join('');
  val_tot_gen_bi = parseFloat(val_tot_gen_bi);

  var val_tot_gen = $("#val_tot_gen").val();
  val_tot_gen = val_tot_gen.split(',').join('');
  val_tot_gen = parseFloat(val_tot_gen);


  $("#div_datagrid").empty();
  $("#div_datagrid").append('<div id="div_datagrid_grafica" style="width: 45%;margin: 0 auto;"><canvas id="bar-chart-grouped"></canvas></div><div id="div_datagrid_html"></div>');
  
  $("#bar-chart-grouped").hide();

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
            
    var string_ids_cliente = '';
    
    $.each(id_cliente, function( index, value ) {

      string_ids_cliente = string_ids_cliente + value + '_';
    
    });

    var string_ids_serie = '';
            
    $.each(id_serie, function( index, value ) {

      string_ids_serie = string_ids_serie + value + '_';
    
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

    var fecha1 = $("#datapicker_fecha1").val();
    var fecha2 = $("#datapicker_fecha2").val();
                
    var parametros = string_ids_suc+','+string_ids_serie+','+string_ids_cliente+','+string_ids_servicio+','+string_ids_provedor+','+string_ids_corporativo+','+fecha1+','+fecha2+','+val_tot_gen_bd+','+val_tot_gen_bi+','+val_tot_gen;
    var tipo_funcion = 'man';
    
    $.ajax({
            url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_tabulador_aereolineas/get_grafica_provedor",
            type: 'POST',
            data: {parametros:parametros,tipo_funcion:tipo_funcion},
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

                data = JSON.parse(data);

                $("#div_datagrid_html").empty();

                var arr_dom = [];
                var arr_int = [];
                var arr_prov = [];

                $.each(data['grafica'], function( index, value ) {

                  arr_dom.push(value['BOL_DOM']);
                  arr_int.push(value['BOL_INT']);
                  arr_prov.push(value['ID_PROVEDOR']);

                });

                function done(){
                
                  var url=myLine.toBase64Image();
                  //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');

                    $.ajax({  //,val_tot_gen_bd:val_tot_gen_bd,val_tot_gen_bi:val_tot_gen_bi
                      async:true,
                      type:"POST",
                      dataType:"html",//html
                      contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                      url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_tabulador_aereolineas/exportar_excel_ae",
                      data:{tipo_funcion:tipo_funcion,parametros:parametros,img_grafica:url,arr_dat_BD:arr_dat_BD,arr_dat_BI:arr_dat_BI},
                      complete: function () {
                          
                           $.unblockUI();
                      },
                      success: function (data) {

                            var opResult = JSON.parse(data);
                            var $a=$("<a>");
                            $a.attr("href",opResult.data);
                            //$a.html("LNK");
                            $("body").append($a);
                            $a.attr("download","Reporte_Tab_Graficos_ae_net_"+opResult.str_fecha+".xlsx");
                            $a[0].click();
                            $a.remove();

                            $("#div_datagrid_grafica").empty();

                        },
                        error: function () {
                            $.unblockUI();
                            alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
                        }

                              
                   });

                }

                var myLine = new Chart(document.getElementById("bar-chart-grouped"), {
                      type: 'bar',
                      data: {
                        labels: arr_prov,
                        datasets: [
                          {
                            label: "Boletos Domesticos",
                            backgroundColor: "#1f497d",
                            data: arr_dom
                          }, {
                            label: "Boletos Internacionales",
                            backgroundColor: "#98DCFB",
                            data: arr_int
                          }
                        ]
                      },
                      options: {
                        scales: { 
                          xAxes: [{ 
                             gridLines: { 
                              color: "rgba(0, 0, 0, 0)", 
                             } 
                            }], 
                          yAxes: [{ 
                             gridLines: { 
                              color: "rgba(0, 0, 0, 0)", 
                             } 
                            }]
                        }, 
                        title: {
                          display: false,
                          text: 'Population growth (millions)'
                        },
                        animation: {
                          onComplete: done
                        }
                      }
                  });
                

              },
              error: function () {
                  $.unblockUI();
                  alert('Ocurrió un error interno, favor de reportarlo con el administrador del sistema');
              }

              
          });

      

}

Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});
  
</script>