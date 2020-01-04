<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_ega_booking_type_code_cxs {



   function booking_type_code($code)
   {

      
       $booking_code = '';

       switch ($code) {

            case'CSAG':  $booking_code ='OTHUNKFEE1';
            break;
            case'CSE':   $booking_code ='OTHUNKAHF1';
            break;
            case'CSFAU': $booking_code ='CARUNKBKG1';
            break;
            case'CSFEX': $booking_code ='AIRUNKMOD1';
            break;
            case'CSFHI': $booking_code ='HOTINTLBKG1';
            break;
            case'CSFHN': $booking_code ='HOTDOMBKG1';
            break;
            case'CSFHX': $booking_code ='HOTUNKMOD1';
            break;
            case'CSFLC': $booking_code ='AIRUNKLCC1';
            break;
            case'CSFRH': $booking_code ='HOTUNKRFD1';
            break;
            case'CSFRV': $booking_code ='AIRUNKRFD1';
            break;
            case'CSFVI': $booking_code ='AIRINTLBKG1';
            break;
            case'CSFVN': $booking_code ='AIRDOMBKG1';
            break;
            case'CSOA':  $booking_code ='CARUNKBKG0';
            break;
            case'CSOEX': $booking_code ='AIRUNKMOD0';
            break;
            case'CSOHI': $booking_code ='HOTINTLBKG0';
            break;
            case'CSOHN': $booking_code ='HOTDOMBKG0';
            break;
            case'CSOHX': $booking_code ='HOTUNKMOD0';
            break;
            case'CSOLC': $booking_code ='AIRUNKLCC0';
            break;
            case'CSORH': $booking_code ='HOTUNKRFD0';
            break;
            case'CSORV': $booking_code ='AIRUNKRFD0';
            break;
            case'CSOVI': $booking_code ='AIRINTLBKG0';
            break;
            case'CSOVN': $booking_code ='AIRDOMBKG0';
            break;
            case'CSSS':  $booking_code ='OTHUNKSRF2';
            break;
            case'CSVIP': $booking_code ='OTHUNKVIP2';
            break;
            case'CSVIS': $booking_code ='OTHUNKVSA2';
            break;


      }
 
      
      return $booking_code;

      
   }


   
}