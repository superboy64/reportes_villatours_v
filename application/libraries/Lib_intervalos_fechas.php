<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_intervalos_fechas {

   function rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2)
   {

        $date1 = new DateTime(date('Y-m-d'));
        $date2 = new DateTime($fecha_ini_proceso);
          
        $interval = $date1->diff($date2);
           
         if($id_intervalo == '1'){  //ya quedo
          
                   $diff_dias = $interval->days;

                   $array_fecha1 = explode('/', $fecha1);
                   $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

                   $fecha1 = strtotime ( '+'.$diff_dias.' day' , strtotime ( $fecha1 ) ) ;
                   $fecha1 = date('Y-m-d',  $fecha1);

                   $array_fecha2 = explode('/', $fecha2);
                   $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];

                   $fecha2 = strtotime ( '+'.$diff_dias.' day' , strtotime ( $fecha2 ) ) ;
                   $fecha2 = date('Y-m-d',  $fecha2);


            }else if($id_intervalo == '2'){  //ya quedo

                   $diff_dias = $interval->days;
                   $semanas = floor(($interval->format('%a') / 7));

                   $array_fecha1 = explode('/', $fecha1);
                   $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

                   $fecha1 = strtotime ( '+'.$diff_dias.' day' , strtotime ( $fecha1 ) ) ;
                 
                   $fecha1 = date('Y-m-d',  $fecha1);

                   //$fecha1 = '2019-09-09';

                   $array_fecha2 = explode('/', $fecha2);
                   $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];

                   $fecha2 = strtotime ( '+'.$semanas.' week' , strtotime ( $fecha2 ) ) ;
                   
                   $fecha2 = date('Y-m-d',  $fecha2);
                   
                   //$fecha2 = '2019-09-15';


            }else if($id_intervalo == '3'){  //month

                 $diff_meses = $interval->m; //3
                 $diff_dias = $interval->days;
                 
                 $array_fecha1 = explode('/', $fecha1);
                 $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

                 $array_fecha2 = explode('/', $fecha2);
                 $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
                 

                 if($diff_meses > 0){  //para acumulados cuando es mayor a un mes la configuracion (solo deberia de ser 1)

                       $fecha1 = strtotime ( '+'.$diff_meses.' month' , strtotime ( $fecha1 ) ) ;

                       $ex_fecha1 = date("Y-m-d", $fecha1);
                       $ex_fecha1 = explode('-', $ex_fecha1);

                       $ex_ano_fecha1 = $ex_fecha1[0];
                       $ex_mes_fecha1 = $ex_fecha1[1];
                       
                      
                       $ex_dia_fecha1 = $ex_fecha1[2];

                       $numero_dias_mes = cal_days_in_month(CAL_GREGORIAN, $ex_mes_fecha1, $ex_ano_fecha1); //dia que tiene el mes

                       if($ex_dia_fecha1 == '01'){ //si es el primer dia del mes
                           
                           $fecha2 = strtotime ( '+'.($numero_dias_mes - 1).' day' , $fecha1);
                           $fecha2 = date("Y-m-d", $fecha2);

                           $fecha1 = date("Y-m-d", $fecha1);

                       }else{

                             if($ex_dia_fecha1 == '01' && (int)$diff_meses  > 1){
                      
                                 $fecha2 = strtotime ( '+'.($numero_dias_mes - 1).' day' , $fecha1);
                                 $fecha2 = date("Y-m-d", $fecha2);

                                 $fecha1 = date("Y-m-d", $fecha1);

                             }else{  // un dia intermedio del mes

                                $fecha2 = strtotime ( '+'.$numero_dias_mes.' day' , $fecha1);
                                $fecha2 = date("Y-m-d", $fecha2);

                                if((int)$diff_meses  > 1){

                                        $fecha1 = strtotime ( '+1 day' , $fecha1);
                                        $fecha1 = date("Y-m-d", $fecha1);

                                        }else{

                                          $fecha1 = date("Y-m-d", $fecha1);
                                          
                                        }

                             }

                       }

                 }  //fin if dif meses


            }else if($id_intervalo == '4'){

                   $diff_dias = $interval->days;
                   
                   $array_fecha1 = explode('/', $fecha1);
                   $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

                   $fecha1 = strtotime ( '+'.$diff_dias.' month' , strtotime ( $fecha1 ) ) ;
                   if((int)$diff_dias > 15){

                    $fecha1 = strtotime ( '+ 1 day' , $fecha1) ;

                 }
                   $fecha1 = date('Y-m-d',  $fecha1);

                   $array_fecha2 = explode('/', $fecha2);
                   $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];

                   $fecha2 = strtotime ( '+'.$diff_dias.' month' , strtotime ( $fecha2 ) ) ;
                   $fecha2 = date('Y-m-d',  $fecha2);

              

            }else if($id_intervalo == '5'){

                   $fecha2 = date('Y-m-d H:i:s');
                   $fecha1 = strtotime ( '-23 hour' , strtotime ( $fecha2 ) ) ;
                   $fecha1 = date('Y-m-d H:i:s',  $fecha1);
                   $fecha2 = strtotime ( '+1 hour' , strtotime ( $fecha2 ) ) ;
                   $fecha2 = date('Y-m-d H:i:s',  $fecha2);
                  
            }


            $rango_fechas = $fecha1.'_'.$fecha2;


            return $rango_fechas;


      
   }

   function fecha_proximo_envio($fecha_ini_proceso,$id_intervalo)
   {

        $date1 = new DateTime(date('Y-m-d'));
        $date2 = new DateTime($fecha_ini_proceso);
          
        $interval = $date1->diff($date2);
        
         if($id_intervalo == '1'){  //ya quedo


                   $fecha_proximo_envio = strtotime ( '+1 day' , strtotime ( $fecha_ini_proceso )) ;
                   $fecha_proximo_envio = date('Y-m-d',  $fecha_proximo_envio);


            }else if($id_intervalo == '2'){  //ya quedo

                   $diff_dias = $interval->days;
                   $semanas = floor(($interval->format('%a') / 7));

                   $fecha_proximo_envio = strtotime ( '+'.$semanas.' week' , strtotime ( $fecha_ini_proceso ) ) ;
                   $fecha_proximo_envio = date('Y-m-d',  $fecha_proximo_envio);


            }else if($id_intervalo == '3'){  //month

                 $diff_meses = $interval->m; //3
                 

                 if($diff_meses > 0){

                  $fecha_proximo_envio = strtotime ( '+'.$diff_meses.' month' , strtotime ( $fecha_ini_proceso ) ) ;
                 

                 }else{

                  $fecha_proximo_envio = strtotime ( '+1 month' , strtotime ( $fecha_ini_proceso ) ) ;
                 

                 }
                 
                  $fecha_proximo_envio = date("Y-m-d", $fecha_proximo_envio);

            }else if($id_intervalo == '4'){

                   $diff_dias = $interval->days;
                   
                   if((int)$diff_dias > 15){

                    $fecha_proximo_envio = strtotime ( '+'.$diff_dias.' month' , strtotime ( $fecha_ini_proceso ) ) ;
                    $fecha_proximo_envio = date('Y-m-d',  $fecha_proximo_envio);
                    
                   }
 

            }else if($id_intervalo == '5'){

                   $fecha_proximo_envio = strtotime ( '+1 day' , strtotime ( $fecha_ini_proceso ) ) ;
                   $fecha_proximo_envio = date('Y-m-d',  $fecha_proximo_envio);
                  
            }


            return $fecha_proximo_envio;

      
   }
   
}