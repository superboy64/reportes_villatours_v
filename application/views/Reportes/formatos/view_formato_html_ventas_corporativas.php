<div id="content_tables" style="display: block;
  margin-left: auto;
  margin-right: auto;
  width: 60%;">

<?php 

  setlocale(LC_MONETARY, 'en_US');

  /*$meses_cliente = explode(',', $meses_cliente);

  $cont_en = count($meses_cliente) + 3;*/
  
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


        /*
        
          $array2["provedores_servicio"] = $rest_provedores_servicio;
          $array2["meses_cliente"] = $rest_provedores_servicio['meses_cliente'];

        */

        

          /*foreach ($meses_cliente as $key => $value) {
    
            print_r('<th scope="col"><center>'.$value.'</center></th>');

          }*/

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

        $TOTAL_GENERAL_MES01 = 0;
        $TOTAL_GENERAL_MES02 = 0;
        $TOTAL_GENERAL_MES03 = 0;
        $TOTAL_GENERAL_MES04 = 0;
        $TOTAL_GENERAL_MES05 = 0;
        $TOTAL_GENERAL_MES06 = 0;
        $TOTAL_GENERAL_MES07 = 0;
        $TOTAL_GENERAL_MES08 = 0;
        $TOTAL_GENERAL_MES09 = 0;
        $TOTAL_GENERAL_MES10 = 0;
        $TOTAL_GENERAL_MES11 = 0;
        $TOTAL_GENERAL_MES12 = 0;

        $array_total_meses = [];

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



                    foreach ($meses_cliente as $key => $value) {
                        
                         
                        if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){
                          

                          $TOTAL_MES = $valor2->$value;
                          //$TOTAL_GENERAL_MES01 = $TOTAL_GENERAL_MES01 + $TOTAL_MES;
                         
                          print_r('<td align="right">'.$TOTAL_MES.'</td>');


                        }



                    }



                    
                    /*if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

                      $TOTAL_MES2 = $valor2->TOTAL_MES2;

                      $TOTAL_GENERAL_MES02 = $TOTAL_GENERAL_MES02 + $TOTAL_MES2;
                      $array_total_meses['02'] = $TOTAL_GENERAL_MES02;
                      print_r('<td align="right">'.$TOTAL_MES2.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

                      $TOTAL_MES3 = $valor2->TOTAL_MES3;

                      $TOTAL_GENERAL_MES03 = $TOTAL_GENERAL_MES03 + $TOTAL_MES3;
                      $array_total_meses['03'] = $TOTAL_GENERAL_MES03;
                      print_r('<td align="right">'.$TOTAL_MES3.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

                      $TOTAL_MES4 = $valor2->TOTAL_MES4;

                      $TOTAL_GENERAL_MES04 = $TOTAL_GENERAL_MES04 + $TOTAL_MES4;
                      $array_total_meses['04'] = $TOTAL_GENERAL_MES04;
                      print_r('<td align="right">'.$TOTAL_MES4.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

                      $TOTAL_MES5 = $valor2->TOTAL_MES5;

                      $TOTAL_GENERAL_MES05 = $TOTAL_GENERAL_MES05 + $TOTAL_MES5;
                      $array_total_meses['05'] = $TOTAL_GENERAL_MES05;
                      print_r('<td align="right">'.$TOTAL_MES5.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){

                      $TOTAL_MES6 = $valor2->TOTAL_MES6;

                      $TOTAL_GENERAL_MES06 = $TOTAL_GENERAL_MES06 + $TOTAL_MES6;
                      $array_total_meses['06'] = $TOTAL_GENERAL_MES06;
                      print_r('<td align="right">'.$TOTAL_MES6.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){

                      $TOTAL_MES7 = $valor2->TOTAL_MES7;

                      $TOTAL_GENERAL_MES07 = $TOTAL_GENERAL_MES07 + $TOTAL_MES7;
                      $array_total_meses['07'] = $TOTAL_GENERAL_MES07;
                      print_r('<td align="right">'.$TOTAL_MES7.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

                      $TOTAL_MES8 = $valor2->TOTAL_MES8;

                      $TOTAL_GENERAL_MES08 = $TOTAL_GENERAL_MES08 + $TOTAL_MES8;
                      $array_total_meses['08'] = $TOTAL_GENERAL_MES08;
                      print_r('<td align="right">'.$TOTAL_MES8.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

                      $TOTAL_MES9 = $valor2->TOTAL_MES9;

                      $TOTAL_GENERAL_MES09 = $TOTAL_GENERAL_MES09 + $TOTAL_MES9;
                      $array_total_meses['09'] = $TOTAL_GENERAL_MES09;
                      print_r('<td align="right">'.$TOTAL_MES9.'</td>');
                      
                    }
                    if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

                      $TOTAL_MES10 = $valor2->TOTAL_MES10;

                      $TOTAL_GENERAL_MES10 = $TOTAL_GENERAL_MES10 + $TOTAL_MES10;
                      $array_total_meses['10'] = $TOTAL_GENERAL_MES10;
                      print_r('<td align="right">'.$TOTAL_MES10.'</td>');
                      
                    }  
                    if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){

                      $TOTAL_MES11 = $valor2->TOTAL_MES11;

                      $TOTAL_GENERAL_MES11 = $TOTAL_GENERAL_MES11 + $TOTAL_MES11;
                      $array_total_meses['11'] = $TOTAL_GENERAL_MES11;
                      print_r('<td align="right">'.$TOTAL_MES11.'</td>');
                      
                    }  
                    if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){

                      $TOTAL_MES12 = $valor2->TOTAL_MES12;

                      $TOTAL_GENERAL_MES12 = $TOTAL_GENERAL_MES12 + $TOTAL_MES12;
                      $array_total_meses['12'] = $TOTAL_GENERAL_MES12;
                      print_r('<td align="right">'.$TOTAL_MES12.'</td>');
                      
                    } */   

                print_r('</tr>');


              }else{

                print_r('<tr style="font-size: 9px;">

                  <td></td>
                  <td align="right">'.$GVC_ID_CLIENTE2.'</td>
                  <td align="right">'.$GVC_NOM_CLI2.'</td>');

                foreach ($meses_cliente as $key => $value) {
                        
                         
                        /*if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){
                          

                          $TOTAL_MES = $valor2->$value;
                          //$TOTAL_GENERAL_MES01 = $TOTAL_GENERAL_MES01 + $TOTAL_MES;
                         
                          print_r('<td align="right">'.$TOTAL_MES.'</td>');


                        }*/



                    }

                    /*if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){

                      $TOTAL_MES1 = $valor2->TOTAL_MES1;

                      $TOTAL_GENERAL_MES01 = $TOTAL_GENERAL_MES01 + $TOTAL_MES1;
                      $array_total_meses['01'] = $TOTAL_GENERAL_MES01;
                      print_r('<td align="right">'.$TOTAL_MES1.'</td>');

                    }
                    if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

                      $TOTAL_MES2 = $valor2->TOTAL_MES2;

                      $TOTAL_GENERAL_MES02 = $TOTAL_GENERAL_MES02 + $TOTAL_MES2;
                      $array_total_meses['02'] = $TOTAL_GENERAL_MES02;
                      print_r('<td align="right">'.$TOTAL_MES2.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

                      $TOTAL_MES3 = $valor2->TOTAL_MES3;

                      $TOTAL_GENERAL_MES03 = $TOTAL_GENERAL_MES03 + $TOTAL_MES3;
                      $array_total_meses['03'] = $TOTAL_GENERAL_MES03;
                      print_r('<td align="right">'.$TOTAL_MES3.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

                      $TOTAL_MES4 = $valor2->TOTAL_MES4;

                      $TOTAL_GENERAL_MES04 = $TOTAL_GENERAL_MES04 + $TOTAL_MES4;
                      $array_total_meses['04'] = $TOTAL_GENERAL_MES04;
                      print_r('<td align="right">'.$TOTAL_MES4.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

                      $TOTAL_MES5 = $valor2->TOTAL_MES5;

                      $TOTAL_GENERAL_MES05 = $TOTAL_GENERAL_MES05 + $TOTAL_MES5;
                      $array_total_meses['05'] = $TOTAL_GENERAL_MES05;
                      print_r('<td align="right">'.$TOTAL_MES5.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){

                      $TOTAL_MES6 = $valor2->TOTAL_MES6;

                      $TOTAL_GENERAL_MES06 = $TOTAL_GENERAL_MES06 + $TOTAL_MES6;
                      $array_total_meses['06'] = $TOTAL_GENERAL_MES06;
                      print_r('<td align="right">'.$TOTAL_MES6.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){

                      $TOTAL_MES7 = $valor2->TOTAL_MES7;

                      $TOTAL_GENERAL_MES07 = $TOTAL_GENERAL_MES07 + $TOTAL_MES7;
                      $array_total_meses['07'] = $TOTAL_GENERAL_MES07;
                      print_r('<td align="right">'.$TOTAL_MES7.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

                      $TOTAL_MES8 = $valor2->TOTAL_MES8;

                      $TOTAL_GENERAL_MES08 = $TOTAL_GENERAL_MES08 + $TOTAL_MES8;
                      $array_total_meses['08'] = $TOTAL_GENERAL_MES08;
                      print_r('<td align="right">'.$TOTAL_MES8.'</td>');
                      
                    } 
                    if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

                      $TOTAL_MES9 = $valor2->TOTAL_MES9;

                      $TOTAL_GENERAL_MES09 = $TOTAL_GENERAL_MES09 + $TOTAL_MES9;
                      $array_total_meses['09'] = $TOTAL_GENERAL_MES09;
                      print_r('<td align="right">'.$TOTAL_MES9.'</td>');
                      
                    }
                    if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

                      $TOTAL_MES10 = $valor2->TOTAL_MES10;

                      $TOTAL_GENERAL_MES10 = $TOTAL_GENERAL_MES10 + $TOTAL_MES10;
                      $array_total_meses['10'] = $TOTAL_GENERAL_MES10;
                      print_r('<td align="right">'.$TOTAL_MES10.'</td>');
                      
                    }  
                    if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){

                      $TOTAL_MES11 = $valor2->TOTAL_MES11;

                      $TOTAL_GENERAL_MES11 = $TOTAL_GENERAL_MES11 + $TOTAL_MES11;
                      $array_total_meses['11'] = $TOTAL_GENERAL_MES11;
                      print_r('<td align="right">'.$TOTAL_MES11.'</td>');
                      
                    }  
                    if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){

                      $TOTAL_MES12 = $valor2->TOTAL_MES12;

                      $TOTAL_GENERAL_MES12 = $TOTAL_GENERAL_MES12 + $TOTAL_MES12;
                      $array_total_meses['12'] = $TOTAL_GENERAL_MES12;
                      print_r('<td align="right">'.$TOTAL_MES12.'</td>');
                      
                    }    

                print_r('</tr>');*/


              }





          }


        }

        print_r('

                  <tr style="font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">

                    <td>Total</td>
                    <td align="right"></td>
                    <td align="right"></td>');



                    foreach ($array_total_meses as $key => $value) {


                        print_r('<td align="right">$'.$value.'</td>');
                        

                    }
                    

        print_r('</tr>');

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

            $array_total_meses = [];

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

                    foreach ($meses_cliente as $key => $value) {
                        


                          $TOTAL_MES = $valor2->$value;
                          
                          //$TOTAL_GENERAL_MES01 = $TOTAL_GENERAL_MES01 + $TOTAL_MES;
                         
                          print_r('<td align="right">'.$TOTAL_MES.'</td>');





                    }




                    print_r('</tr>');


              }


            }

            print_r('

                  <tr style="font-size: 12px; font-weight:bold;background-color: #0a0a0ab5;color: #FFF;">

                    <td>Total</td>
                    <td align="right"></td>
                    <td align="right"></td>');


                    foreach ($array_total_meses as $key => $value) {


                        print_r('<td align="right">$'.$value.'</td>');
                        

                    }
                    

            print_r('</tr>');


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

