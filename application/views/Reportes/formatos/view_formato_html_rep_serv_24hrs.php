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
        <th colspan="4"><center><H3>TOP 10<br><?=$sub?></H3></center></th>
      </tr>
      <tr>
        <th scope="col"><center>AGENTE</center></th>
        <th scope="col"><center>CVE SERVICIO</center></th>
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
        

      $count=0;
      foreach ($provedores_servicio as $clave2 => $valor2) {  

       $AGENT2 = $valor2->AGENT;
       $TOTAL2 = $valor2->TOTAL;
       $TOTAL_BOL2 = $valor2->TOTAL_BOL;
       $GVC_ID_SERVICIO2 = $valor2->GVC_ID_SERVICIO;

        if($AGENT2 == $AGENT){
          $count++;

          if($count==1){

            print_r('<tr style="font-size: 9px;">

              <td>'.$AGENT.'</td>
              <td align="right">'.$GVC_ID_SERVICIO2.'</td>
              <td align="right"><center>'.$TOTAL_BOL2.'</center></td>
              <td align="center">'.number_format((float)$TOTAL2).'</td>

            </tr>');


          }else{

            print_r('<tr style="font-size: 9px;">

              <td></td>
              <td align="right">'.$GVC_ID_SERVICIO2.'</td>
              <td align="right"><center>'.$TOTAL_BOL2.'</center></td>
              <td align="center">'.number_format((float)$TOTAL2).'</td>

            </tr>');


          }

        }//fin validacion pax

      }//fin for rows_provedores_servicio

      print_r('<tr style="font-size: 9px;font-weight: bold;font-size:12px; border: outset;">
            <td>Total '.$AGENT.'</td>
            <td></td>
            <td><center>'.$TOTAL_BOL.'</center></td>
            <td align="center">'.number_format((float)$TOTAL).'</td>
          </tr>');

    }// fin validacion vacios

  } //fin for

  print_r('<tr style="font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">
            <td>Total general</td>
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

