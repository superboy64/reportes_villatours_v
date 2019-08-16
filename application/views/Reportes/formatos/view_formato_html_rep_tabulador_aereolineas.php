
<div id="content_tables" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 80%;">

<?php  

setlocale(LC_MONETARY, 'en_US');


function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}


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

$contbd = 0;


//********************************

$list = array_sort($dat_BD, 'BOL_DOM', SORT_DESC);

//print_r($list);


//*********************************

foreach ($dat_BD as $clave => $valor) {  

   $NOMBRE_PROVEDOR =  $valor['NOMBRE_PROVEDOR'];
   $TOTAL_BOL = $valor['TOTAL_BOL'];
   $BOL_DOM = $valor['BOL_DOM'];

   array_push($array_TOTAL_BOL_DOM, $TOTAL_BOL);
   array_push($array_BOL_DOM, $BOL_DOM);

   $PART_BOL_DOM = (((float)$BOL_DOM/(float)$total_TARIFA_GEN)*100);

   array_push($array_PART_BOL_DOM, number_format((float)$PART_BOL_DOM, 2, '.', ''));

   $STRING_HTML_BOL_DOM = $STRING_HTML_BOL_DOM . '<tr style="font-size: 11px;">
            <td>'.$NOMBRE_PROVEDOR.'
            <input class="form-control" id="aereolineabd_'.$contbd.'" type="hidden" value="'.$NOMBRE_PROVEDOR.'">
            </td>
            <td><center>'.$TOTAL_BOL.'</center>
            <input class="form-control" id="total_bol_bd_'.$contbd.'" type="hidden" value="'.$TOTAL_BOL.'" readonly>
            </td>
            <td align="center">'.number_format($BOL_DOM).'
            <input class="form-control" id="tarifabd_'.$contbd.'" type="hidden" value="'.(float)$BOL_DOM.'" readonly>
            </td>
            <td align="center"><input class="form-control" id="comisionbd_'.$contbd.'" type="number" value="0" onchange="calculacomisionbd('.$contbd.');" style="width: 60px;text-align: center;height: 19px;
            font-size: 12px;"></td>
            <td align="center"><input class="form-control" id="val_com_bd_'.$contbd.'" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td> 
            <td align="center"><input class="form-control" id="ingresobd_'.$contbd.'" type="number" value="0" onchange="calculaingresobd('.$contbd.');" style="width: 60px;text-align: center;height: 19px;
            font-size: 12px;"></td>
            <td align="center"><input class="form-control" id="val_ing_bd_'.$contbd.'" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td> 
            <td align="center"><input class="form-control" id="val_tot_bd_'.$contbd.'" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td> 
          </tr> ' ;
  

  $contbd++;

}


$total_BOL_DOM =  array_sum($array_TOTAL_BOL_DOM);
$total_TARIFA_DOM =  array_sum($array_BOL_DOM);

$array_TOTAL_BOL_INT = [];
$array_BOL_INT = [];
$STRING_HTML_BOL_INT = "";

$contbi = 0;

foreach ($dat_BI as $clave => $valor) {  

   $NOMBRE_PROVEDOR =  $valor['NOMBRE_PROVEDOR'];
   $TOTAL_BOL = (float)$valor['TOTAL_BOL'];
   $BOL_INT = (float)$valor['BOL_INT'];

   array_push($array_TOTAL_BOL_INT, $TOTAL_BOL);
   array_push($array_BOL_INT, $BOL_INT);

   $PART_BOL_INT = (((float)$BOL_INT/(float)$total_TARIFA_GEN)*100);

   array_push($array_PART_BOL_INT, number_format((float)$PART_BOL_INT, 2, '.', ''));

   $STRING_HTML_BOL_INT = $STRING_HTML_BOL_INT . '<tr style="font-size: 11px;">
            <td>'.$NOMBRE_PROVEDOR.'
            <input class="form-control" id="aereolineabi_'.(float)$contbi.'" type="hidden" value="'.$NOMBRE_PROVEDOR.'">
            </td>
            <td><center>'.$TOTAL_BOL.'</center>
            <input class="form-control" id="total_bol_bi_'.$contbi.'" type="hidden" value="'.(float)$TOTAL_BOL.'" readonly>
            </td>
            <td align="center">'.number_format($BOL_INT).'
            <input class="form-control form-control-sm" id="tarifabi_'.$contbi.'" type="hidden" value="'.(float)$BOL_INT.'" readonly>
            </td>
            <td align="center"><input class="form-control form-control-sm" id="comisionbi_'.$contbi.'" type="number" value="0" onchange="calculacomisionbi('.$contbi.');" style="width: 60px;text-align: center;height: 19px;
            font-size: 12px;"></td>
            <td align="center"><input class="form-control form-control-sm" id="val_com_bi_'.$contbi.'" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td> 
            <td align="center"><input class="form-control form-control-sm" id="ingresobi_'.$contbi.'" type="number" value="0" onchange="calculaingresobi('.$contbi.');" style="width: 60px;text-align: center;height: 19px;
            font-size: 12px;"></td>
            <td align="center"><input class="form-control form-control-sm" id="val_ing_bi_'.$contbi.'" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td> 
            <td align="center"><input class="form-control form-control-sm" id="val_tot_bi_'.$contbi.'" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td> 
          </tr>' ;

$contbi++;

}

$total_BOL_INT =  array_sum($array_TOTAL_BOL_INT);
$total_TARIFA_INT =  array_sum($array_BOL_INT);


$TOTAL_BOL_GEN = (float)$total_BOL_INT + (float)$total_BOL_DOM;

$total_PART_BOL_DOM_GEN =  array_sum($array_PART_BOL_DOM);
$total_PART_BOL_INT_GEN =  array_sum($array_PART_BOL_INT);

$total_PART_GEN = (float)$total_PART_BOL_DOM_GEN + (float)$total_PART_BOL_INT_GEN;

//*******************************ENCABEZADOS**********************************************


print_r('
   
      <table class="table">
        <thead style="font-size: 12px;background-color: #23527c;color: #fff;">
          <tr>
            <th colspan="8"><center><H3>'.$sub.'</H3></center></th>
          </tr>
          <tr>
            <th colspan="3"></th>
            <th colspan="2"><center>COMISION</center></th>
            <th colspan="2"><center>INGRESO</center></th>
            <th><center>GRAN</center></th>
          </tr>
          <tr>
            <th scope="col"><center>AEROLINEA</center></th>
            <th scope="col"><center>CANT</center></th>
            <th scope="col">TARIFA/Pesos</th>
            <th scope="col"><center>%</center></th>
            <th scope="col"><center>VALOR</center></th>
            <th scope="col"><center>%</center></th>
            <th scope="col"><center>VALOR</center></th>
            <th scope="col"><center>TOTAL</center></th>
          </tr>
        </thead>
         <tbody>
      ');


//************************************DOMESTICO**********************************************


print_r($STRING_HTML_BOL_DOM.'
          <tr style="font-size: 12px; font-weight:bold; border: outset;">
            <td>Total BOLETOS DOMESTICOS</td>
            <td><center>'.$total_BOL_DOM.'</center></td>
            <td align="center">'.number_format($total_TARIFA_DOM).'</td>
            <td colspan="4"></td>
            <td align="center"><input class="form-control form-control-sm" id="val_tot_gen_bd" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
          </tr>

    ');



//************************************INTERNACIONAL**********************************************

print_r($STRING_HTML_BOL_INT.'
          <tr style="font-size: 12px; font-weight:bold; border: outset;">
            <td>Total BOLETOS INTERNACIONALES</th>
            <td><center>'.$total_BOL_INT.'</center></th>
            <td align="center">'.number_format($total_TARIFA_INT).'</th>
            <td colspan="4"></td>
            <td align="center"><input class="form-control form-control-sm" id="val_tot_gen_bi" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td>
          </tr>

          ');


//************************************TOTAL GENERAL**********************************************


print_r('
             <tr style="font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">
              <td>Total general</th>
              <td><center>'.$TOTAL_BOL_GEN.'</center></th>
              <td align="center">'.number_format($total_TARIFA_GEN).'</th>
              <td colspan="4"></td>
              <td align="center"><input class="form-control form-control-sm" id="val_tot_gen" type="text" value="0.00" readonly style="text-align: right;height: 19px;
            font-size: 12px;"></td>
             </tr>

        ');



print_r('</tbody></table>');

//******************************************************* FIN HTML***********************************************************************************************************

?>

<input type="hidden" id="contBD" value="<?=count($dat_BD)?>">
<input type="hidden" id="contBI" value="<?=count($dat_BI)?>">

</div>

<div style="font-weight:bold;">

<center>
  
  El consumo es la tarifa antes de impuestos de iva y tua.<br>
  El consumo es de tarifa de servicios de vuelos.(No cargos por cambios y revisados)<br>
  Cantidades en Pesos Mexicanos

</center>
  
            
</div>

<script type="text/javascript">

function calculacomisionbd(contbd){

   
      var comisionbd = $("#comisionbd_"+contbd).val();
      var tarifabd = $("#tarifabd_"+contbd).val();
      var totlcombd = (parseFloat(comisionbd) * parseFloat(tarifabd))/100;
      totlcombd = formatCurrency(totlcombd);
      $("#val_com_bd_"+contbd).val(totlcombd);

      val_com_bd = $("#val_com_bd_"+contbd).val();
      val_com_bd = val_com_bd.split(',').join('');
      val_com_bd = parseFloat(val_com_bd);

      val_ing_bd = $("#val_ing_bd_"+contbd).val();
      val_ing_bd = val_ing_bd.split(',').join('');
      val_ing_bd = parseFloat(val_ing_bd);

      var total_val = val_com_bd + val_ing_bd;
      total_val = formatCurrency(total_val); 

      $("#val_tot_bd_"+contbd).val(total_val);

      var totalcontbd = $("#contBD").val();

      var array_val_tot_bd = [];

      var tot_bd = 0
      for(var i=0;i<totalcontbd;i++){
              
         var val_tot_bd = $("#val_tot_bd_"+i).val();
         val_tot_bd = val_tot_bd.split(',').join('');
         val_tot_bd = parseFloat(val_tot_bd);

         tot_bd = parseFloat(tot_bd) + parseFloat(val_tot_bd);
         

      }

      tot_bd = formatCurrency(tot_bd);
      $("#val_tot_gen_bd").val(tot_bd);


      var val_tot_gen_bd = $("#val_tot_gen_bd").val();
      val_tot_gen_bd = val_tot_gen_bd.split(',').join('');
      val_tot_gen_bd = parseFloat(val_tot_gen_bd);

      var val_tot_gen_bi = $("#val_tot_gen_bi").val();
      val_tot_gen_bi = val_tot_gen_bi.split(',').join('');
      val_tot_gen_bi = parseFloat(val_tot_gen_bi);

      var val_tot_gen = val_tot_gen_bd + val_tot_gen_bi;

      val_tot_gen = formatCurrency(val_tot_gen);
      $("#val_tot_gen").val(val_tot_gen);
      

}

function calculaingresobd(contbd){

      var ingresobd = $("#ingresobd_"+contbd).val();
      var tarifabd = $("#tarifabd_"+contbd).val();
      var totlingbd = (parseFloat(ingresobd) * parseFloat(tarifabd))/100;
      totlingbd = formatCurrency(totlingbd);

      $("#val_ing_bd_"+contbd).val(totlingbd);

      val_com_bd = $("#val_com_bd_"+contbd).val();
      val_com_bd = val_com_bd.split(',').join('');
      val_com_bd = parseFloat(val_com_bd);

      val_ing_bd = $("#val_ing_bd_"+contbd).val();
      val_ing_bd = val_ing_bd.replace(",", "");
      val_ing_bd = parseFloat(val_ing_bd);

      var total_val = parseFloat(val_com_bd) + parseFloat(val_ing_bd);
      total_val = formatCurrency(total_val); 

      $("#val_tot_bd_"+contbd).val(total_val);

      var totalcontbd = $("#contBD").val();

      var array_val_tot_bd = [];

      var tot_bd = 0
      for(var i=0;i<totalcontbd;i++){
              
          var val_tot_bd = $("#val_tot_bd_"+i).val();
          val_tot_bd = val_tot_bd.split(',').join('');
          val_tot_bd = parseFloat(val_tot_bd);
          tot_bd = parseFloat(tot_bd) + parseFloat(val_tot_bd);
         

      }

      tot_bd = formatCurrency(tot_bd);
     $("#val_tot_gen_bd").val(tot_bd);

      var val_tot_gen_bd = $("#val_tot_gen_bd").val();
      val_tot_gen_bd = val_tot_gen_bd.split(',').join('');
      val_tot_gen_bd = parseFloat(val_tot_gen_bd);

      var val_tot_gen_bi = $("#val_tot_gen_bi").val();
      val_tot_gen_bi = val_tot_gen_bi.replace(",", "");
      val_tot_gen_bi = parseFloat(val_tot_gen_bi);

      var val_tot_gen = parseFloat(val_tot_gen_bd) + parseFloat(val_tot_gen_bi);

      val_tot_gen = formatCurrency(val_tot_gen);
      $("#val_tot_gen").val(val_tot_gen);
  
}

function calculacomisionbi(contbi){

      var comisionbi = $("#comisionbi_"+contbi).val();
      var tarifabi = $("#tarifabi_"+contbi).val();
      var totlcombi = (parseFloat(comisionbi) * parseFloat(tarifabi))/100;
      totlcombi = formatCurrency(totlcombi);
      $("#val_com_bi_"+contbi).val(totlcombi);

      val_com_bi = $("#val_com_bi_"+contbi).val();
      val_com_bi = val_com_bi.split(',').join('');
      val_com_bi = parseFloat(val_com_bi);

      val_ing_bi = $("#val_ing_bi_"+contbi).val();
      val_ing_bi = val_ing_bi.split(',').join('');
      val_ing_bi = parseFloat(val_ing_bi);

      var total_val = val_com_bi + val_ing_bi;
      total_val = formatCurrency(total_val);

      $("#val_tot_bi_"+contbi).val(total_val);

      var totalcontbi = $("#contBI").val();

      var array_val_tot_bi = [];

      var tot_bi = 0;
      for(var i=0;i<totalcontbi;i++){
              
          var val_tot_bi = $("#val_tot_bi_"+i).val();
          val_tot_bi = val_tot_bi.split(',').join('');
          val_tot_bi = parseFloat(val_tot_bi);

          tot_bi = parseFloat(tot_bi) + parseFloat(val_tot_bi);
          

      }

     tot_bi = formatCurrency(tot_bi);
     $("#val_tot_gen_bi").val(tot_bi);

      var val_tot_gen_bd = $("#val_tot_gen_bd").val();
      val_tot_gen_bd = val_tot_gen_bd.split(',').join('');
      val_tot_gen_bd = parseFloat(val_tot_gen_bd);

      var val_tot_gen_bi = $("#val_tot_gen_bi").val();
      val_tot_gen_bi = val_tot_gen_bi.split(',').join('');
      val_tot_gen_bi = parseFloat(val_tot_gen_bi);

      var val_tot_gen = parseFloat(val_tot_gen_bd) + parseFloat(val_tot_gen_bi);

      val_tot_gen = formatCurrency(val_tot_gen);
      $("#val_tot_gen").val(val_tot_gen);

}



function calculaingresobi(contbi){

      var ingresobi = $("#ingresobi_"+contbi).val();
      var tarifabi = $("#tarifabi_"+contbi).val();
      var totlingbi = (parseFloat(ingresobi) * parseFloat(tarifabi))/100;
      totlingbi = formatCurrency(totlingbi);

      $("#val_ing_bi_"+contbi).val(totlingbi);

      val_com_bi = $("#val_com_bi_"+contbi).val();
      val_com_bi = val_com_bi.split(',').join('');
      val_com_bi = parseFloat(val_com_bi);

      val_ing_bi = $("#val_ing_bi_"+contbi).val();
      val_ing_bi = val_ing_bi.split(',').join('');
      val_ing_bi = parseFloat(val_ing_bi);

      var total_val = parseFloat(val_com_bi) + parseFloat(val_ing_bi);
      total_val = formatCurrency(total_val); 
      $("#val_tot_bi_"+contbi).val(total_val);

      var totalcontbi = $("#contBI").val();

      var array_val_tot_bi = [];

      var tot_bi = 0
      for(var i=0;i<totalcontbi;i++){
              
          var val_tot_bi = $("#val_tot_bi_"+i).val();
          val_tot_bi = val_tot_bi.split(',').join('');
          val_tot_bi = parseFloat(val_tot_bi);

          tot_bi = parseFloat(tot_bi) + parseFloat(val_tot_bi);

      }

     tot_bi = formatCurrency(tot_bi);
     $("#val_tot_gen_bi").val(tot_bi);

      var val_tot_gen_bd = $("#val_tot_gen_bd").val();
      val_tot_gen_bd = val_tot_gen_bd.split(',').join('');
      val_tot_gen_bd = parseFloat(val_tot_gen_bd);

      var val_tot_gen_bi = $("#val_tot_gen_bi").val();
      val_tot_gen_bi = val_tot_gen_bi.split(',').join('');
      val_tot_gen_bi = parseFloat(val_tot_gen_bi);

      var val_tot_gen = parseFloat(val_tot_gen_bd) + parseFloat(val_tot_gen_bi);

      val_tot_gen = formatCurrency(val_tot_gen);
      $("#val_tot_gen").val(val_tot_gen);



}


function formatCurrency(total) {
    var neg = false;
    if(total < 0) {
        neg = true;
        total = Math.abs(total);
    }
    return parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString();
}

</script>

