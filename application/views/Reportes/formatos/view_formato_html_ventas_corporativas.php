<div id="content_tables" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 60%;">

<?php 

  setlocale(LC_MONETARY, 'en_US');

  $meses_cliente = $meses_cliente;
  $cont_en = count($meses_cliente) + 3;
  
?>
  
  <table class="table">
    <thead style="font-size: 12px;background-color: #23527c;color: #fff;">
      <tr>
        <th colspan="<?=$cont_en?>"><center><H3><?=$sub?></H3></center></th>
      </tr>
      <tr>
        <th scope="col"><center>CORPORATIVO</center></th>
        <th scope="col"><center>CLIENTE</center></th>
        <th scope="col"><center>NOMBRE CLIENTE</center></th>
        <?php  

          foreach ($meses_cliente as $key => $value) {
    
            $fecha_explode = explode('-', $value['MES']);

            $ano = $fecha_explode[0];
            $mes = $fecha_explode[1];
            $mes_palabra = '';

            switch ($mes) {
                case 1:
                    $mes_palabra = 'Enero';
                    break;
                case 2:
                    $mes_palabra = 'Febrero';
                    break;
                case 3:
                    $mes_palabra = 'Marzo';
                    break;
                case 4:
                    $mes_palabra = 'Abril';
                    break;
                case 5:
                    $mes_palabra = 'Mayo';
                    break;
                case 6:
                    $mes_palabra = 'Junio';
                    break;
                case 7:
                    $mes_palabra = 'Julio';
                    break;
                case 8:
                    $mes_palabra = 'Agosto';
                    break;
                case 9:
                    $mes_palabra = 'Septiembre';
                    break;
                case 10:
                    $mes_palabra = 'Octubre';
                    break;
                case 11:
                    $mes_palabra = 'Noviembre';
                    break;
                case 12:
                    $mes_palabra = 'Diciembre';
                    break;

            } 

            $fecha = $mes_palabra.' '.$ano;

            print_r('<th scope="col"><center>'.$fecha.'</center></th>');

          }

        ?>
      </tr>
    </thead>
     <tbody>
     
<?php
  

  if(isset($rows_grafica) && count($rows_grafica) > 0 && $cont_corporativo > 0){   

    //agrupado por corporativo

    $provedores_servicio = json_decode($rows_provedores_servicio);

    foreach ($rows_grafica as $clave => $valor) {  

        $GVC_ID_CORPORATIVO = $valor['GVC_ID_CORPORATIVO'];

         $count=0;
         foreach ($provedores_servicio as $clave2 => $valor2) {  

          $GVC_ID_CORPORATIVO2 = $valor2->GVC_ID_CORPORATIVO;
          //$TOTAL2 = $valor2->TOTAL;
          $GVC_NOM_CLI2 = $valor2->GVC_NOM_CLI;
          $GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;    

          if($GVC_ID_CORPORATIVO2 == $GVC_ID_CORPORATIVO){
              $count++;

              if($count==1){

                print_r('<tr style="font-size: 9px;">

                  <td>'.$GVC_ID_CORPORATIVO.'</td>
                  <td align="right">'.$GVC_ID_CLIENTE2.'</td>
                  <td align="right">'.$GVC_NOM_CLI2.'</td>');

                if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES1.'</td>');

                }
                if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES2.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES3.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES4.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES5.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){
                  
                  print_r('<td align="right">'.$valor2->TOTAL_MES6.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){
                  
                  print_r('<td align="right">'.$valor2->TOTAL_MES7.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES8.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES9.'</td>');
                  
                }
                if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES10.'</td>');
                  
                }  
                if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){
                  
                  print_r('<td align="right">'.$valor2->TOTAL_MES11.'</td>');
                  
                }  
                if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){
                  
                  print_r('<td align="right">'.$valor2->TOTAL_MES12.'</td>');
                  
                }    

                print_r('</tr>');


              }else{

                print_r('<tr style="font-size: 9px;">

                  <td></td>
                  <td align="right">'.$GVC_ID_CLIENTE2.'</td>
                  <td align="right">'.$GVC_NOM_CLI2.'</td>');

                if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES1.'</td>');

                }
                if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES2.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES3.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES4.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES5.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES6.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES7.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES8.'</td>');
                  
                } 
                if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES9.'</td>');
                  
                }
                if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES10.'</td>');
                  
                }  
                if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES11.'</td>');
                  
                }  
                if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){

                  print_r('<td align="right">'.$valor2->TOTAL_MES12.'</td>');
                  
                }    

                print_r('</tr>');


              }


          }



        }

      
    } //fin for



?>

</tbody></table>


<?php

  }// fin validacion isset

else{


        //BUSQUEDA POR CLIENTES

        $provedores_servicio = json_decode($rows_provedores_servicio);

        foreach ($rows_grafica as $clave => $valor) {  

            $GVC_ID_CLIENTE = $valor['GVC_ID_CLIENTE'];

             $count=0;
             foreach ($provedores_servicio as $clave2 => $valor2) {  

              $GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;
              $GVC_NOM_CLI2 = $valor2->GVC_NOM_CLI;

              if($GVC_ID_CLIENTE2 == $GVC_ID_CLIENTE){
                  $count++;

                  
                    print_r('<tr style="font-size: 9px;">

                      <td></td>
                      <td align="right">'.$GVC_ID_CLIENTE2.'</td>
                      <td align="right">'.$GVC_NOM_CLI2.'</td>');

                    if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES1.'</td>');

                    }
                    if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES2.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES3.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES4.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES5.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES6.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES7.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES8.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES9.'</td>');
                      
                    }
                    if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES10.'</td>');
                      
                    }  
                    if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES11.'</td>');
                      
                    }  
                    if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){

                      print_r('<td align="right">'.$valor2->TOTAL_MES12.'</td>');
                      
                    }    

                    print_r('</tr>');


              }

            }

          
        } //fin for



    }

?>


</div>

<div style="font-weight:bold;">

<center>

  El consumo es la tarifa antes de impuestos de iva y tua.<br>
  El consumo es de tarifa de servicios de vuelos.(No cargos por cambios)<br>
  Cantidades en Pesos Mexicanos

</center>
  
            
</div>

