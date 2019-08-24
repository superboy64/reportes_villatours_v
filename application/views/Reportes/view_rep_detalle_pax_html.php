
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
          
          <!--<tr>
            <th colspan="4"><center><H3></H3></center></th>
          </tr>-->

          <tr>

            <th scope="col"><center>PASAJERO</center></th>
            <th scope="col"><center>SERIE</center></th>
            <th scope="col"><center>DOCUMENTO</center></th>
            <th scope="col"><center>CORPORATIVO</center></th>
            <th scope="col"><center>CLIENTE</center></th>
            <th scope="col"><center>NOMBRE CLIENTE</center></th>
            <th scope="col"><center>CC</center></th>
            <th scope="col"><center>DESC CC</center></th>
            <th scope="col"><center>FECHA DOCUMENTO</center></th>
            <th scope="col"><center>QUIEN SOLICITO</center></th>
            <th scope="col"><center>PNR</center></th>
            <th scope="col"><center>BOLETO</center></th>
            <th scope="col"><center>CVE DE SERVICIO</center></th>
            <th scope="col"><center>CVE DE PROVEEDOR</center></th>
            <th scope="col"><center>NOMBRE PROVEEDOR</center></th>
            <th scope="col"><center>RUTA</center></th>
            <th scope="col"><center>TARIFA</center></th>
            <th scope="col"><center>IVA</center></th>
            <th scope="col"><center>TUA</center></th>
            <th scope="col"><center>OTROS IMPUESTOS</center></th>
            <th scope="col"><center>TOTAL</center></th>
            <th scope="col"><center>CLASE</center></th>
            <th scope="col"><center>FECHA DE SALIDA</center></th>
            <th scope="col"><center>FECHA DE REGRESO</center></th>
            <th scope="col"><center>FECHA DE EMISION</center></th>
            <th scope="col"><center>NUMERO DE EMPLEADO</center></th>
            <th scope="col"><center>CVE FORMA DE PAGO</center></th>
            <th scope="col"><center>FECHA DE RESERVACION</center></th>
            
          </tr>
          <tbody>

            <?php 
            
                    foreach ($data as $clave => $valor) {  

                      if($valor->TIPO == 'TOTALES'){

                          print_r("<tr style='font-size: 17px; font-weight:bold; border: outset;' >".

                             "<td>".$valor->GVC_NOM_PAX."</td>"
                            ."<td>".$valor->GVC_ID_SERIE."</td>"
                            ."<td>".$valor->GVC_DOC_NUMERO."</td>"
                            ."<td>".$valor->GVC_ID_CORPORATIVO."</td>"
                            ."<td>".$valor->GVC_ID_CLIENTE."</td>"
                            ."<td>".$valor->GVC_NOM_CLI."</td>"
                            ."<td>".$valor->GVC_ID_CENTRO_COSTO."</td>"
                            ."<td>".$valor->GVC_DESC_CENTRO_COSTO."</td>"
                            ."<td>".$valor->GVC_FECHA."</td>"
                            ."<td>".$valor->GVC_SOLICITO."</td>"
                            ."<td>".$valor->GVC_CVE_RES_GLO."</td>"
                            ."<td>".$valor->GVC_BOLETO."</td>"
                            ."<td>".$valor->GVC_ID_SERVICIO."</td>"
                            ."<td>".$valor->GVC_ID_PROVEEDOR."</td>"
                            ."<td>".$valor->GVC_NOMBRE_PROVEEDOR."</td>"
                            ."<td>".$valor->GVC_CONCEPTO."</td>"
                            ."<td>".number_format($valor->GVC_TARIFA_MON_BASE)."</td>"
                            ."<td>".number_format($valor->GVC_IVA)."</td>"
                            ."<td>".number_format($valor->GVC_TUA)."</td>"
                            ."<td>".number_format($valor->GVC_OTROS_IMPUESTOS)."</td>"
                            ."<td>".number_format($valor->GVC_TOTAL)."</td>"
                            ."<td>".$valor->GVC_CLASE_FACTURADA."</td>"
                            ."<td>".$valor->GVC_FECHA_SALIDA."</td>"
                            ."<td>".$valor->GVC_FECHA_REGRESO."</td>"
                            ."<td>".$valor->GVC_FECHA_EMISION_BOLETO."</td>"
                            ."<td>".$valor->GVC_CLAVE_EMPLEADO."</td>"
                            ."<td>".$valor->GVC_FOR_PAG1."</td>"
                            ."<td>".$valor->GVC_FECHA_RESERVACION."</td></tr>");


                      
                      }else{

                         print_r("<tr style='font-size: 12px;'>".

                             "<td>".$valor->GVC_NOM_PAX."</td>"
                            ."<td>".$valor->GVC_ID_SERIE."</td>"
                            ."<td>".$valor->GVC_DOC_NUMERO."</td>"
                            ."<td>".$valor->GVC_ID_CORPORATIVO."</td>"
                            ."<td>".$valor->GVC_ID_CLIENTE."</td>"
                            ."<td>".$valor->GVC_NOM_CLI."</td>"
                            ."<td>".$valor->GVC_ID_CENTRO_COSTO."</td>"
                            ."<td>".$valor->GVC_DESC_CENTRO_COSTO."</td>"
                            ."<td>".$valor->GVC_FECHA."</td>"
                            ."<td>".$valor->GVC_SOLICITO."</td>"
                            ."<td>".$valor->GVC_CVE_RES_GLO."</td>"
                            ."<td>".$valor->GVC_BOLETO."</td>"
                            ."<td>".$valor->GVC_ID_SERVICIO."</td>"
                            ."<td>".$valor->GVC_ID_PROVEEDOR."</td>"
                            ."<td>".$valor->GVC_NOMBRE_PROVEEDOR."</td>"
                            ."<td>".$valor->GVC_CONCEPTO."</td>"
                            ."<td>".number_format($valor->GVC_TARIFA_MON_BASE)."</td>"
                            ."<td>".number_format($valor->GVC_IVA)."</td>"
                            ."<td>".number_format($valor->GVC_TUA)."</td>"
                            ."<td>".number_format($valor->GVC_OTROS_IMPUESTOS)."</td>"
                            ."<td>".number_format($valor->GVC_TOTAL)."</td>"
                            ."<td>".$valor->GVC_CLASE_FACTURADA."</td>"
                            ."<td>".$valor->GVC_FECHA_SALIDA."</td>"
                            ."<td>".$valor->GVC_FECHA_REGRESO."</td>"
                            ."<td>".$valor->GVC_FECHA_EMISION_BOLETO."</td>"
                            ."<td>".$valor->GVC_CLAVE_EMPLEADO."</td>"
                            ."<td>".$valor->GVC_FOR_PAG1."</td>"
                            ."<td>".$valor->GVC_FECHA_RESERVACION."</td></tr>");


                          }


                      }

                     print_r("<tr style='font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;'>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td>TOTAL GENERAL</td>"
                            ."<td>".number_format((float)$data_gen->tot_gen_GVC_TARIFA_MON_BASE)."</td>"
                            ."<td>".number_format((float)$data_gen->tot_gen_GVC_IVA)."</td>"
                            ."<td>".number_format((float)$data_gen->tot_gen_GVC_TUA)."</td>"
                            ."<td>".number_format((float)$data_gen->tot_gen_GVC_OTROS_IMPUESTOS)."</td>"
                            ."<td>".number_format((float)$data_gen->tot_gen_total)."</td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td>"
                            ."<td></td></tr>");



                ?>

          </tbody>

  </thead>



</table>