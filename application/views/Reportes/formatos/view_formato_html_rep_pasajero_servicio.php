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
        <th scope="col"><center>PASAJERO / SERVICIO</center></th>
        <th scope="col"><center># TRANSACCIONES</center></th>
        <th scope="col">TARIFA/Pesos</th>
      </tr>
    </thead>
     <tbody>
     
<?php

  if(isset($rows_grafica)){

    foreach ($rows_grafica as $clave => $valor) {  

      if($valor['TOTAL'] != 0 && $valor['TOTAL'] != ""){

        $NOMBRE_PAX = $valor['NOMBRE_PAX'];
        $GVC_ID_CLIENTE = $valor['GVC_ID_CLIENTE'];
        $TOTAL = $valor['TOTAL'];
        $TOTAL_BOL = $valor['TOTAL_BOL'];

?>
  
    <tr style="font-size: 11px; font-weight:bold;">
      <td><?=$NOMBRE_PAX?></td>
      <td><center><?=$TOTAL_BOL?></center></td>
      <td align="center"><?=number_format((float)$TOTAL)?></td>
    </tr>

<?php
      
      $provedores_servicio = json_decode($rows_provedores_servicio);

      foreach ($provedores_servicio as $clave2 => $valor2) {  

       $NOMBRE_PAX2 = $valor2->NOMBRE_PAX;
       $GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;
       $TOTAL2 = $valor2->TOTAL;
       $TOTAL_BOL2 = $valor2->TOTAL_BOL;
       $GVC_ID_PROVEEDOR2 = $valor2->GVC_ID_PROVEEDOR;
       $GVC_NOMBRE_PROVEEDOR2 = $valor2->GVC_NOMBRE_PROVEEDOR;

        if($NOMBRE_PAX2 == $NOMBRE_PAX){


?>

          <tr style="font-size: 9px;">

            <td align="right"><?=$GVC_NOMBRE_PROVEEDOR2?></td>
            <td align="right"><center><?=$TOTAL_BOL2?></center></td>
            <td align="center"><?=number_format((float)$TOTAL2)?></td>

          </tr>

  
<?php
        }//fin validacion pax

      }//fin for rows_provedores_servicio

    }// fin validacion vacios

  } //fin for

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

