
<!--<div id="content_tables" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 80%;">-->

<?php  
//setlocale(LC_MONETARY, 'en_US');

  $data_gen = json_decode($data);
  $data = json_decode($data);  
  $data = $data->array_nuevo_formato;


?>

<table class="table">

  <thead style="font-size: 12px;background-color: #23527c;color: #fff;">
          
          <tr>

            <th scope="col"><center>GVC_NOM_VEN_TIT</center></th>
            <th scope="col"><center>GVC_ID_SERIE</center></th>
            <th scope="col"><center>GVC_DOC_NUMERO</center></th>
            <th scope="col"><center>GVC_ID_CORPORATIVO</center></th>
            <th scope="col"><center>GVC_ID_CLIENTE</center></th>
            <th scope="col"><center>GVC_NOM_CLI</center></th>
            <th scope="col"><center>GVC_CVE_RES_GLO</center></th>
            <th scope="col"><center>analisis28_cliente</center></th>
            <th scope="col"><center>GVC_FECHA</center></th>
            <th scope="col"><center>GVC_BOLETO</center></th>
            <th scope="col"><center>GVC_ID_SERVICIO</center></th>
            <th scope="col"><center>TIPO_BOLETO</center></th>
            <th scope="col"><center>GVC_ID_PROVEEDOR</center></th>
            <th scope="col"><center>GVC_NOMBRE_PROVEEDOR</center></th>
            <th scope="col"><center>GVC_CONCEPTO</center></th>
            <th scope="col"><center>GVC_NOM_PAX</center></th>
            <th scope="col"><center>GVC_TARIFA_MON_BASE</center></th>
            <th scope="col"><center>GVC_IVA</center></th>
            <th scope="col"><center>GVC_TUA</center></th>
            <th scope="col"><center>GVC_OTROS_IMPUESTOS</center></th>
            <th scope="col"><center>GVC_TOTAL</center></th>
            <th scope="col"><center>analisis13_cliente</center></th>
            <th scope="col"><center>analisis14_cliente</center></th>
            <th scope="col"><center>analisis15_cliente</center></th>
            <th scope="col"><center>valor_mas_alto</center></th>
            <th scope="col"><center>ahorro</center></th>
            <th scope="col"><center>%ahorro</center></th>
            <th scope="col"><center>analisis6_cliente</center></th>
            <th scope="col"><center>analisis17_cliente</center></th>
            <th scope="col"><center>ahorro sobre tarifa antes de desc</center></th>
            <th scope="col"><center>%ahorro sobre tarifa antes de desc</center></th>
            <th scope="col"><center>analisis32_cliente</center></th>
            <th scope="col"><center>analisis35_cliente</center></th>
            <th scope="col"><center>analisis57_cliente</center></th>
            <th scope="col"><center>GVC_CLASE_FACTURADA</center></th>
            <th scope="col"><center>GVC_FECHA_SALIDA</center></th>
            <th scope="col"><center>GVC_FECHA_REGRESO</center></th>
            <th scope="col"><center>GVC_FECHA_EMISION_BOLETO</center></th>
            <th scope="col"><center>PRECOMPRA</center></th>
            <th scope="col"><center>GVC_CLAVE_EMPLEADO</center></th>
            <th scope="col"><center>GVC_FECHA_RESERVACION</center></th>
            <th scope="col"><center>MES</center></th>
            <th scope="col"><center>AÑO</center></th>
            <th scope="col"><center>analisis26_cliente</center></th>
            <th scope="col"><center>analisis11_cliente</center></th>
            <th scope="col"><center>analisis23_cliente</center></th>
            <th scope="col"><center>analisis1_cliente</center></th>
            <th scope="col"><center>analisis18_cliente</center></th>

            
          </tr>
          <tbody>

            <?php 
            
                    foreach ($data as $clave => $valor) {  

                        // print_r("<tr style='font-size: 12px; font-weight:bold; border-bottom: groove;'>".
                        // print_r("<tr style='font-size: 12px; font-weight:bold; border-top: groove;'>".

                        $string_table = "";



                        if($valor->inicio == '1' && $valor->fin == '0'){  //comienza

                            $string_table = $string_table . "<tr style='font-size: 12px; border-top: groove;'>";

                        }else if($valor->inicio == '0' && $valor->fin == '1'){  //termina

                            $string_table = $string_table . "<tr style='font-size: 12px; border-bottom: groove;'>";

                        }else if($valor->inicio == '0' && $valor->fin == '0'){

                            $string_table = $string_table . "<tr style='font-size: 12px;'>";

                        }


                             $string_table = $string_table .
                             "<td>".$valor->GVC_NOM_VEN_TIT."</td>"
                            ."<td>".$valor->GVC_ID_SERIE."</td>"
                            ."<td>".$valor->GVC_DOC_NUMERO."</td>"
                            ."<td>".$valor->GVC_ID_CORPORATIVO."</td>"
                            ."<td>".$valor->GVC_ID_CLIENTE."</td>"
                            ."<td>".$valor->GVC_NOM_CLI."</td>"
                            ."<td>".$valor->GVC_CVE_RES_GLO."</td>"
                            ."<td>".$valor->analisis28_cliente."</td>"
                            ."<td>".$valor->GVC_FECHA."</td>"
                            ."<td>".$valor->GVC_BOLETO."</td>"
                            ."<td>".$valor->GVC_ID_SERVICIO."</td>"
                            ."<td>".$valor->TIPO_BOLETO."</td>"
                            ."<td>".$valor->GVC_ID_PROVEEDOR."</td>"
                            ."<td>".$valor->GVC_NOMBRE_PROVEEDOR."</td>"
                            ."<td>".$valor->GVC_CONCEPTO."</td>"
                            ."<td>".$valor->GVC_NOM_PAX."</td>"
                            ."<td>".$valor->GVC_TARIFA_MON_BASE."</td>"
                            ."<td>".$valor->GVC_IVA."</td>"
                            ."<td>".$valor->GVC_TUA."</td>"
                            ."<td>".$valor->GVC_OTROS_IMPUESTOS."</td>"
                            ."<td>".$valor->GVC_TOTAL."</td>"
                            ."<td>".$valor->analisis13_cliente."</td>"
                            ."<td>".$valor->analisis14_cliente."</td>"
                            ."<td>".$valor->analisis15_cliente."</td>"
                            ."<td>".$valor->valor_mas_alto."</td>"
                            ."<td>".$valor->ahorro."</td>"
                            ."<td>".$valor->_ahorro."</td>"
                            ."<td>".$valor->analisis6_cliente."</td>"
                            ."<td>".$valor->analisis17_cliente."</td>"
                            ."<td>".$valor->ahorro_sobre_tar_ant_desc."</td>"
                            ."<td>".$valor->_ahorro_sobre_tar_ant_desc."</td>"
                            ."<td>".$valor->analisis32_cliente."</td>"
                            ."<td>".$valor->analisis35_cliente."</td>"
                            ."<td>".$valor->analisis57_cliente."</td>"
                            ."<td>".$valor->GVC_CLASE_FACTURADA."</td>"
                            ."<td>".$valor->GVC_FECHA_SALIDA."</td>"
                            ."<td>".$valor->GVC_FECHA_REGRESO."</td>"
                            ."<td>".$valor->GVC_FECHA_EMISION_BOLETO."</td>"
                            ."<td>".$valor->PRECOMPRA."</td>"
                            ."<td>".$valor->GVC_CLAVE_EMPLEADO."</td>"
                            ."<td>".$valor->GVC_FECHA_RESERVACION."</td>"
                            ."<td>".$valor->MES."</td>"
                            ."<td>".$valor->ANO."</td>"
                            ."<td>".$valor->analisis26_cliente."</td>"
                            ."<td>".$valor->analisis11_cliente."</td>"
                            ."<td>".$valor->analisis23_cliente."</td>"
                            ."<td>".$valor->analisis1_cliente."</td>"
                            ."<td>".$valor->analisis18_cliente."</td></tr>";


                            print_r($string_table);


                      }


                ?>

          </tbody>

  </thead>



</table>