

<div id="content_tables" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 60%;">

<?php  

setlocale(LC_MONETARY, 'en_US');

$array_TOTAL_BOL_DOM = [];
$array_BOL_DOM = [];
$array_BOL_DOM_GEN = [];
$array_BOL_INT_GEN = [];
$array_PART_BOL_DOM = [];
$array_PART_BOL_INT = [];
$STRING_HTML_BOL_DOM = "";

foreach ($dat_BD as $clave => $valor) {  

  
   $BOL_DOM_GEN = $valor['BOL_DOM'];

   array_push($array_BOL_DOM_GEN, $BOL_DOM_GEN);

}

foreach ($dat_BI as $clave => $valor) {  


   $BOL_INT_GEN = $valor['BOL_INT'];

   array_push($array_BOL_INT_GEN, $BOL_INT_GEN);

}

$total_TARIFA_DOM_GEN =  array_sum($array_BOL_DOM_GEN);
$total_TARIFA_INT_GEN =  array_sum($array_BOL_INT_GEN);

$total_TARIFA_GEN = (float)$total_TARIFA_DOM_GEN + (float)$total_TARIFA_INT_GEN;


foreach ($dat_BD as $clave => $valor) {  

   $NOMBRE_PROVEDOR =  $valor['NOMBRE_PROVEDOR'];
   $TOTAL_BOL = $valor['TOTAL_BOL'];
   $BOL_DOM = $valor['BOL_DOM'];

   array_push($array_TOTAL_BOL_DOM, $TOTAL_BOL);
   array_push($array_BOL_DOM, $BOL_DOM);

   $PART_BOL_DOM = (((float)$BOL_DOM/(float)$total_TARIFA_GEN)*100);

   array_push($array_PART_BOL_DOM, number_format((float)$PART_BOL_DOM, 2, '.', ''));

 
   $STRING_HTML_BOL_DOM = $STRING_HTML_BOL_DOM . '<tr style="font-size: 11px;">
            <td>'.$NOMBRE_PROVEDOR.'</td>
            <td><center>'.$TOTAL_BOL.'</center></td>
            <td align="center">'.number_format((float)$BOL_DOM).'</td>
            <td align="center">'.number_format((float)$PART_BOL_DOM, 2, '.', '').'%</td> 
          </tr> ' ;
  
}


$total_BOL_DOM =  array_sum($array_TOTAL_BOL_DOM);
$total_TARIFA_DOM =  array_sum($array_BOL_DOM);

//--------

$array_TOTAL_BOL_INT = [];
$array_BOL_INT = [];
$STRING_HTML_BOL_INT = "";

foreach ($dat_BI as $clave => $valor) {  

   $NOMBRE_PROVEDOR =  $valor['NOMBRE_PROVEDOR'];
   $TOTAL_BOL = $valor['TOTAL_BOL'];
   $BOL_INT = $valor['BOL_INT'];

   array_push($array_TOTAL_BOL_INT, $TOTAL_BOL);
   array_push($array_BOL_INT, $BOL_INT);

   $PART_BOL_INT = (((float)$BOL_INT/(float)$total_TARIFA_GEN)*100);

   array_push($array_PART_BOL_INT, number_format((float)$PART_BOL_INT, 2, '.', ''));

   $STRING_HTML_BOL_INT = $STRING_HTML_BOL_INT . '<tr style="font-size: 11px;">
            <td>'.$NOMBRE_PROVEDOR.'</td>
            <td><center>'.$TOTAL_BOL.'</center></td>
            <td align="center">'.number_format((float)$BOL_INT).'</td>
            <td align="center">'.number_format((float)$PART_BOL_INT, 2, '.', '').'%</td> 
          </tr>' ;

}

$total_BOL_INT =  array_sum($array_TOTAL_BOL_INT);
$total_TARIFA_INT =  array_sum($array_BOL_INT);


$TOTAL_BOL_GEN = $total_BOL_INT + $total_BOL_DOM;

$total_PART_BOL_DOM_GEN =  array_sum($array_PART_BOL_DOM);
$total_PART_BOL_INT_GEN =  array_sum($array_PART_BOL_INT);

$total_PART_GEN = (float)$total_PART_BOL_DOM_GEN + (float)$total_PART_BOL_INT_GEN;
//$TOTAL_TARIFA_GEN = $total_TARIFA_DOM + $total_TARIFA_INT;

//******************************************************* HTML ***********************************************************************************************************

//*******************************ENCABEZADOS**********************************************


print_r('
   
      <table class="table">
        <thead style="font-size: 12px;background-color: #23527c;color: #fff;">
          <tr>
            <th colspan="4"><center><H3>'.$sub.'</H3></center></th>
          </tr>
          <tr>
            <th scope="col"><center>AEROLINEA</center></th>
            <th scope="col"><center>CANT</center></th>
            <th scope="col">TARIFA/Pesos</th>
            <th scope="col"><center>%Part</center></th>
          </tr>
        </thead>
         <tbody>
      ');


//************************************DOMESTICO**********************************************


print_r($STRING_HTML_BOL_DOM.'
          <tr style="font-size: 12px; font-weight:bold; border: outset;">
            <td>Total BOLETOS DOMESTICOS</th>
            <td><center>'.$total_BOL_DOM.'</center></th>
            <td align="center">'.number_format((float)$total_TARIFA_DOM).'</th>
            <td align="center">'.(float)$total_PART_BOL_DOM_GEN.'%</th>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;</th>
            <td>&nbsp;&nbsp;</th>
            <td>&nbsp;&nbsp;</th>
            <td>&nbsp;&nbsp;</th>
          </tr>

    ');



//************************************INTERNACIONAL**********************************************


print_r($STRING_HTML_BOL_INT.'
          <tr style="font-size: 12px; font-weight:bold; border: outset;">
            <td>Total BOLETOS INTERNACIONALES</th>
            <td><center>'.$total_BOL_INT.'</center></th>
            <td align="center">'.number_format((float)$total_TARIFA_INT).'</th>
            <td align="center">'.(float)$total_PART_BOL_INT_GEN.'%</th>
          </tr>

          ');


//************************************TOTAL GENERAL**********************************************


print_r('
             <tr style="font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">
              <td>Total general</th>
              <td><center>'.$TOTAL_BOL_GEN.'</center></th>
              <td align="center">'.number_format((float)$total_TARIFA_GEN).'</th>
              <td align="center">'.number_format((float)$total_PART_GEN).'%</th>
             </tr>

        ');



print_r('</tbody></table>');

//******************************************************* FIN HTML***********************************************************************************************************

?>


</div>

<div style="font-weight:bold;">

<center>
  
  El consumo es la tarifa antes de impuestos de iva y tua.<br>
  El consumo es de tarifa de servicios de vuelos.(No cargos por cambios y revisados)<br>
  Cantidades en Pesos Mexicanos

</center>
  
            
</div>

