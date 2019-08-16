<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_segmentos_millas {

   function get_millas($segmentos)
   {


      $millas = 0;

            if(array_key_exists(0, $segmentos)) {

                $millas_seg1 = $segmentos[0]['millas'];
                
                $millas = (int)$millas_seg1;
                if(array_key_exists(1, $segmentos)) {
                  $millas_seg2 = $segmentos[1]['millas'];
                  $millas = (int)$millas_seg1 + (int)$millas_seg2;
                  if(array_key_exists(2, $segmentos)) {
                    $millas_seg3 = $segmentos[2]['millas'];
                    $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3;
                    if(array_key_exists(3, $segmentos)) {
                      $millas_seg4 = $segmentos[3]['millas'];
                      $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4;
                      if(array_key_exists(4, $segmentos)) {
                        $millas_seg5 = $segmentos[4]['millas'];
                        $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5;
                        if(array_key_exists(5, $segmentos)) {
                          $millas_seg6 = $segmentos[5]['millas'];
                          $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6;
                          if(array_key_exists(6, $segmentos)) {
                            $millas_seg7 = $segmentos[6]['millas'];
                            $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7;
                            if(array_key_exists(7, $segmentos)) {
                              $millas_seg8 = $segmentos[7]['millas'];
                              $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7 + (int)$millas_seg8;
                              if(array_key_exists(8, $segmentos)) {
                                $millas_seg9 = $segmentos[8]['millas'];
                                $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7 + (int)$millas_seg8 + (int)$millas_seg9;
                                if(array_key_exists(9, $segmentos)) {
                                  $millas_seg10 = $segmentos[9]['millas'];
                                  $millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7 + (int)$millas_seg8 + (int)$millas_seg9  + (int)$millas_seg10;
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }

                }

            }//fin if

            return $millas;
      
   }
   
}