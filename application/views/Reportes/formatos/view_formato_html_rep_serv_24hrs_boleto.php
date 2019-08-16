<div id="content_tables" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 60%;">

<?php 

setlocale(LC_MONETARY, 'en_US');

?>
  
  <table class="table">
    <thead style="font-size: 12px;background-color: #23527c;color: #fff;">
      <tr>
        <th colspan="5"><center><H3>TOP 10<br><?=$sub?></H3></center></th>
      </tr>
      <tr>
        <th scope="col"><center>AGENTE</center></th>
        <th scope="col"><center>CVE SERVICIO</center></th>
        <th scope="col"><center>NOMBRE PROVEEDOR</center></th>
        <th scope="col"><center># TRANSACCIONES</center></th>
        <th scope="col">TARIFA/Pesos</th>
      </tr>
    </thead>
     <tbody>
     
<?php
  

  if(isset($rows_grafica)){

    $provedores_servicio = json_decode($rows_provedores_servicio);

    $TOTAL_GEN = 0;
    $TOTAL_BOL_GEN = 0;
    foreach ($rows_grafica as $clave => $valor) {  

      if($valor['TOTAL'] != 0 && $valor['TOTAL'] != ""){

        $AGENT = $valor['AGENT'];
        $TOTAL = $valor['TOTAL'];
        $TOTAL_BOL = $valor['TOTAL_BOL'];

        $TOTAL_GEN = $TOTAL_GEN + $TOTAL;
        $TOTAL_BOL_GEN = $TOTAL_BOL_GEN + $TOTAL_BOL;

        //cuenta la cantidad de agentes
        $cont_agent=1;
        $arr_bd = [];
        $arr_bi = [];
        foreach ($provedores_servicio as $clave2 => $valor2) { 

          $AGENT2 = $valor2->AGENT;
          $GVC_ID_SERVICIO2 = $valor2->GVC_ID_SERVICIO;

          if($AGENT2 == $AGENT){
            $cont_agent++;

            if($GVC_ID_SERVICIO2 == 'BD'){

              array_push($arr_bd, $valor2);


            }

            if($GVC_ID_SERVICIO2 == 'BI'){

              array_push($arr_bi, $valor2);

            }


          }



        }
      
      $total_bol_bd = 0;
      $total_bd = 0;
      foreach ($arr_bd as $clave2 => $valor2) {  

        $AGENT2 = $valor2->AGENT;
        //$GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;
        $TOTAL2 = $valor2->TOTAL;
        $TOTAL_BOL2 = $valor2->TOTAL_BOL;
        $GVC_ID_SERVICIO2 = $valor2->GVC_ID_SERVICIO;
        $GVC_ID_PROVEEDOR2 = $valor2->GVC_ID_PROVEEDOR;
        $GVC_NOMBRE_PROVEEDOR2 = $valor2->GVC_NOMBRE_PROVEEDOR;

        if($clave2 == 0){

           print_r("

            <tr style='font-size: 9px;'>

              <td align='center' style='border-top: 0px;font-size: 11px;'>".$AGENT."</td>
              <td align='right' rowspan=".count($arr_bd)." style='border-top: 0px;'>BOL.DOM.</td>
              <td align='right' style='border-top: 0px;'>".$GVC_NOMBRE_PROVEEDOR2."</td>
              <td align='right' style='border-top: 0px;'><center>".$TOTAL_BOL2."</center></td>
              <td align='center' style='border-top: 0px;'>".number_format((float)$TOTAL2)."</td>

            </tr>

           ");


        }else{

          print_r("

            <tr style='font-size: 9px;'>

              <td style='border-top: 0px;'></td>
              <td align='right' style='border-top: 0px;'>".$GVC_NOMBRE_PROVEEDOR2."</td>
              <td align='right' style='border-top: 0px;'><center>".$TOTAL_BOL2."</center></td>
              <td align='center' style='border-top: 0px;'>".number_format((float)$TOTAL2)."</td>

            </tr>

           ");

        }

        $total_bol_bd = $total_bol_bd + $TOTAL_BOL2;
        $total_bd = $total_bd + $TOTAL2;

      }

      print_r("
      <tr style='font-size: 11px; font-weight:bold; background-color: #7b7575b5;color: #FFF;'>
        <td style='border-top: 0px;'></td>
        <td style='border-top: 0px;'>Total BOL.DOM</td>
        <td style='border-top: 0px;'></td>
        <td style='border-top: 0px;'><center>".$total_bol_bd."</center></td>
        <td align='center' style='border-top: 0px;'>".$total_bd."</td>
      </tr> ");
    
      $total_bol_bi = 0;
      $total_bi = 0;
      foreach ($arr_bi as $clave2 => $valor2) {  

        $AGENT2 = $valor2->AGENT;
        //$GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;
        $TOTAL2 = $valor2->TOTAL;
        $TOTAL_BOL2 = $valor2->TOTAL_BOL;
        $GVC_ID_SERVICIO2 = $valor2->GVC_ID_SERVICIO;
        $GVC_ID_PROVEEDOR2 = $valor2->GVC_ID_PROVEEDOR;
        $GVC_NOMBRE_PROVEEDOR2 = $valor2->GVC_NOMBRE_PROVEEDOR;


        if($clave2 == 0){

          print_r("<tr style='font-size: 9px;'>");


          if(count($arr_bd) == 0){


            print_r("<td align='center' style='border-top: 0px;font-size: 11px;'>".$AGENT."</td>
                     <td align='right' rowspan=".count($arr_bi)." style='border-top: 0px;'>BOL.INT.</td>
                     <td align='right' style='border-top: 0px;'>".$GVC_NOMBRE_PROVEEDOR2."</td>
                     <td align='right' style='border-top: 0px;'><center>".$TOTAL_BOL2."</center></td>
                     <td align='center' style='border-top: 0px;'>".number_format((float)$TOTAL2)."</td>
                   ");


          }else{

             print_r("

              <td align='center' style='border-top: 0px;font-size: 11px;'></td>
              <td align='right' rowspan=".count($arr_bi)." style='border-top: 0px;'>BOL.INT.</td>
              <td align='right' style='border-top: 0px;'>".$GVC_NOMBRE_PROVEEDOR2."</td>
              <td align='right' style='border-top: 0px;'><center>".$TOTAL_BOL2."</center></td>
              <td align='center' style='border-top: 0px;'>".number_format((float)$TOTAL2)."</td>

              </tr>

            ");

          }

         


        }else{

          print_r("

            <tr style='font-size: 9px;'>

              <td style='border-top: 0px;'></td>
              <td align='right' style='border-top: 0px;'>".$GVC_NOMBRE_PROVEEDOR2."</td>
              <td align='right' style='border-top: 0px;'><center>".$TOTAL_BOL2."</center></td>
              <td align='center' style='border-top: 0px;'>".number_format((float)$TOTAL2)."</td>

            </tr>

           ");

        }

        $total_bol_bi = $total_bol_bi + $TOTAL_BOL2;
        $total_bi = $total_bi + $TOTAL2;

      }    

      print_r("
      <tr style='font-size: 11px; font-weight:bold;background-color: #7b7575b5;color: #FFF;'>
        <td style='border-top: 0px;'></td>
        <td style='border-top: 0px;'>Total BOL.INT</td>
        <td style='border-top: 0px;'></td>
        <td style='border-top: 0px;'><center>".$total_bol_bi."</center></td>
        <td align='center' style='border-top: 0px;'>".$total_bi."</td>
      </tr> ");


    ?>
    
    <tr style="font-size: 11px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">
      <td style='border-top: 0px;'><center>Total <?=$AGENT?></center></td>
      <td style='border-top: 0px;'></td>
      <td style='border-top: 0px;'></td>
      <td style='border-top: 0px;'><center><?=$TOTAL_BOL?></center></td>
      <td align="center" style='border-top: 0px;'><?=number_format((float)$TOTAL)?></td>
    </tr> 

    <?php

    }// fin validacion vacios

  } //fin for

  print_r('<tr style="font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">
            <td><center>Total general</center></td>
            <td></td>
            <td></td>
            <td><center>'.$TOTAL_BOL_GEN.'</center></td>
            <td align="center">'.number_format((float)$TOTAL_GEN).'</td>
          </tr>');

?>

</tbody></table>


<?php

  }// fin validacion isset

?>


</div>

<div style="font-weight:bold;">

<center>

  El consumo es la tarifa antes de impuestos de iva y tua.<br>
  El consumo es de tarifa de servicios de vuelos.(No cargos por cambios)<br>
  Cantidades en Pesos Mexicanos

</center>
  
            
</div>

