<?php  
  
  $data = json_decode($data);


  $array_bd = [];
  $array_bi = [];


	foreach ($data as $clave => $valor) {


		if($valor->tipo_servicio == 'BD'){


			array_push($array_bd, $valor);

		}

		if($valor->tipo_servicio == 'BI'){


			array_push($array_bi, $valor);


		}


	  }


?>

<table class="table" style="max-width: 500px;">
		
  <thead style="font-size: 12px;background-color: #23527c;color: #fff;">
          
          <tr>

            <th scope="col"><center>DIAS DE PRECOMPRA</center></th>
            <th scope="col"><center># TRANSACCIONES</center></th>
            <th scope="col"><center>TARIFA</center></th>
            
          </tr>
          <tbody>

            <?php 
            	
            	$cont_bd = count($array_bd);
            	$cont = 0;
            	$sum_transac_bd = 0;
            	$sum_tarifa_bd = 0;

                    foreach ($array_bd as $clave => $valor) {
                    	$cont++;

                        	 $string_table = '<tr style="font-size:11px; ">';

                             $string_table = $string_table .
                             "<td align='center'>".$valor->dias_precompra."</td>"
                            ."<td align='center'>".$valor->ntransacciones."</td>"
                            ."<td align='center'>".number_format((float)$valor->tarifa)."</td></tr>";

                            $sum_transac_bd = $sum_transac_bd + (int)$valor->ntransacciones;
							              $sum_tarifa_bd = $sum_tarifa_bd + (int)$valor->tarifa;

                            if($cont == $cont_bd){

	                            	$string_table = $string_table .
	                            "<tr style='font-size:12px; font-weight:bold; border: outset;'>
						            <td>TOTAL BOLETOS DOMESTICOS</td>
						            <td align='center'>".number_format((float)$sum_transac_bd)."</td>
						            <td align='center'>".number_format((float)$sum_tarifa_bd)."</td>
						          </tr>
						         ";

                            }

                            print_r($string_table);


                      }

                $cont_bi = count($array_bi);
            	$cont = 0;
            	$sum_transac_bi = 0;
            	$sum_tarifa_bi = 0;

                      foreach ($array_bi as $clave => $valor) {
                    	$cont++;

                        	 $string_table = '<tr style="font-size:11px; ">';

                             $string_table = $string_table .
                             "<td align='center'>".$valor->dias_precompra."</td>"
                            ."<td align='center'>".$valor->ntransacciones."</td>"
                            ."<td align='center'>".number_format((float)$valor->tarifa)."</td></tr>";

                            $sum_transac_bi = $sum_transac_bi + (int)$valor->ntransacciones;
							$sum_tarifa_bi = $sum_tarifa_bi + (int)$valor->tarifa;

                            if($cont == $cont_bi){

	                            	$string_table = $string_table .
	                            "<tr style='font-size:12px; font-weight:bold; border: outset;'>
						            <td>TOTAL BOLETOS INTERNACIONALES</td>
						            <td align='center'>".number_format((float)$sum_transac_bi)."</td>
						            <td align='center'>".number_format((float)$sum_tarifa_bi)."</td>
						          </tr>";

                            }

                            print_r($string_table);


                      }

                      print_r('

			             <tr style="font-size:12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">
			              <td>Total general</th>
			              <td align="center">'.number_format((float)$sum_transac_bd + (float)$sum_transac_bi).'</th>
			              <td align="center">'.number_format((float)$sum_tarifa_bd + (float)$sum_tarifa_bi).'</th>
			             </tr>



			        ');

	

                ?>

          </tbody>

  </thead>



</table>