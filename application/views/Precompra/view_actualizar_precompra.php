<?php

$id_cliente = $row_precompra[0]['id_cliente'];
$id_precompra = $row_precompra[0]['id'];
$precompra =  explode('/', $row_precompra[0]['rango_dias']);
$precompra=array_filter($precompra, "strlen");
$cont_rango = count($precompra);

?>

<input type="hidden" id="txt_cliente" value="<?=$id_cliente?>">
<input type="hidden" id="txt_precompra" value="<?=$id_precompra?>">

<div class="row">

      <div class="col-md-12">

               <div class="col-md-12"><br></div>

               <div class="col-md-11">

                      <div class="col-md-12">

                        <label>Rango de dias</label>
                        <br>

                      </div>

                      <div class="row" id="contenedor_rangos">

                      
                        <?php

                            for($x=0;$x<$cont_rango;$x++){

                              $explode_precompra = explode('_', $precompra[$x]);

                              $desde = $explode_precompra[0];
                              $hasta = $explode_precompra[1];

                              $str_rango = '<div class="col-md-10" id="div_row_'.$x.'"><div class="col-md-5"><label>Desde</label><input type="text" class="form-control" id="txt_desde'.$x.'" placeholder="Desde" value="'.$desde.'"></div><div class="col-md-5"><label>Hasta</label><input type="text" class="form-control" id="txt_hasta'.$x.'" placeholder="Hasta" value="'.$hasta.'"></div><div class="col-md-2"><div class="row"><div class="col-md-12"><button type="button" class="btn btn-default" onclick="agregar_rango();" style="width: 0px;height: 25px;" id="btn_mas_'.$x.'"><label class="glyphicon glyphicon-plus" aria-hidden="true" style=" margin-left: -6px; margin-top: -3px;"></label></button><button type="button" class="btn btn-default" onclick="eliminar_rango('.$x.');" style="width: 0px;height: 25px;" id="btn_menos_'.$x.'"><label class="glyphicon glyphicon-minus" aria-hidden="true" style=" margin-left: -7px; margin-top: -3px;"></label></button></div></div></div></div>';

                              print_r($str_rango);



                            }


                        ?>


                      </div>
                 

              </div>


      </div>


   </div>


   <script type="text/javascript">
      
     var cont_rango = "<?php  echo $cont_rango; ?>";
     
     var cont_rango_consecutivo = 0;

     var str_rango = '';
     
     array_cont_rangos_exis = [];

     for(var x=0;x<cont_rango;x++){

        $("#btn_mas_"+x).hide();

     }

      $("#btn_mas_"+(cont_rango - 1)).show();
      $("#btn_menos_"+(cont_rango - 1)).hide();

      function agregar_rango(){

        var btn_old =  cont_rango - 1;

        str_rango = '<div class="col-md-10" id="div_row_'+cont_rango+'"><div class="col-md-5"><label>Desde</label><input type="text" class="form-control" id="txt_desde'+cont_rango+'" placeholder="Desde"></div><div class="col-md-5"><label>Hasta</label><input type="text" class="form-control" id="txt_hasta'+cont_rango+'" placeholder="Hasta"></div><div class="col-md-2"><div class="row"><div class="col-md-12"><button type="button" class="btn btn-default" onclick="agregar_rango();" style="width: 0px;height: 25px;" id="btn_mas_'+cont_rango+'"><label class="glyphicon glyphicon-plus" aria-hidden="true" style=" margin-left: -6px; margin-top: -3px;"></label></button><button type="button" class="btn btn-default" onclick="eliminar_rango('+cont_rango+');" style="width: 0px;height: 25px;" id="btn_menos_'+cont_rango+'"><label class="glyphicon glyphicon-minus" aria-hidden="true" style=" margin-left: -7px; margin-top: -3px;"></label></button></div></div></div></div>';

         $("#contenedor_rangos").append(str_rango);

         $("#btn_mas_"+btn_old).hide();
         $("#btn_menos_"+btn_old).show();
         $("#btn_menos_"+cont_rango).hide();

        
        cont_rango++;

      }

      function eliminar_rango(cont_rango){


        $("#div_row_"+cont_rango).remove();


      }

      function mod_guardar_actualizacion_precompra(){



        var arr_rangos_cli = [];
        var cont_rango = $("#contenedor_rangos>div").length;


          $("#contenedor_rangos>div").each( function (){

              var str = $(this).attr("id"); //concateno la misma variable

              arr = str.split('div_row_');

              var id_rango =  arr[1];

              var desde = $("#txt_desde"+id_rango).val();
              var hasta = $("#txt_hasta"+id_rango).val();

              if(cont_rango > 0 && hasta == '0'){

               hasta = '1000000';

              }

              var str_rangos_cli = desde + '_' + hasta;

              arr_rangos_cli.push(str_rangos_cli);


            }

          );

         var id_cliente = $("#txt_cliente").val();
         var id_precompra = $("#txt_precompra").val();

         $.post("<?php echo base_url(); ?>index.php/Cnt_precompra/guardar_edicion_precompra", {id_cliente:id_cliente,id_precompra:id_precompra,arr_rangos_cli:arr_rangos_cli}, function(data){

           if(data == 1){

            swal("Precompra guardada correctamente");

            consulta_precompra('Precompra');

            $('#myModal').modal('hide');

           }else{

            swal("Error al guardar la plantilla");

           }

        });


      }

   </script>