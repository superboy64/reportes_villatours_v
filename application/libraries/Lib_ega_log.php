<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_ega_log {

   function procesar_errores($value,$arr_errores_log_duplicate_records,$arr_errores_log_duplicate_records_hoteles,$ultimo_id)
   {

        $error = '';

        $str_val_duplicate_records = LTRIM(RTRIM($value['RecordLocator'])).LTRIM(RTRIM($value['BookingType'])).LTRIM(RTRIM($value['IssuedDate'])).LTRIM(RTRIM($value['TravelerName'])).LTRIM(RTRIM($value['DocumentNumber'])).$value['TransactionType'];
        $str_val_duplicate_records_hoteles = LTRIM(RTRIM($value['RecordLocator'])).LTRIM(RTRIM($value['BookingType'])).LTRIM(RTRIM($value['TravelerName'])).LTRIM(RTRIM($value['DocumentNumber'])).$value['TransactionType'].$value['StartDate'].$value['EndDate'];

            if( !in_array($str_val_duplicate_records, $arr_errores_log_duplicate_records)){ 
              array_push($arr_errores_log_duplicate_records, $str_val_duplicate_records);
            }else{
              $error =  $error .'Error: consumos duplicados para el BookingID-'.$ultimo_id.'<br>';
            }
            if( !in_array($str_val_duplicate_records_hoteles, $arr_errores_log_duplicate_records_hoteles)){ 
              array_push($arr_errores_log_duplicate_records_hoteles, $str_val_duplicate_records);
            }else{
              $error = 'Error: consumos de hoteles duplicados para el BookingID-'.$ultimo_id.'<br>';
            }
            if($value['StartDate'] == '' || $value['EndDate'] == ''){
              $error =  $error .'Error: Startdate o Endate vacio para el BookingID-'.$ultimo_id.'<br>';
            }
            if($value['StartDate'] == '1900-01-01' || $value['EndDate'] == '1900-01-01'){
              $error =  $error .'Error: Startdate o Endate con formato erroneo para el BookingID-'.$ultimo_id.'<br>';
            }
            if($value['GroupID'] == ''){
              $error =  $error .'Error: GroupID vacio para el BookingID-'.$ultimo_id.'<br>';
            }
            if($value['BookedOnline'] == 'G'){
              $error =  $error .'Error: BookedOnline debe ser "N" no "G" para el BookingID-'.$ultimo_id.'<br>';
            }
            if($value['FormofPayment'] != 'CA'){
              if($value['PaymentNumber'] == '' || strlen($value['PaymentNumber']) == '3'){
                $error =  $error .'Error: PaymentNumber vacio para el BookingID-'.$ultimo_id.'<br>';
              }
            }
            if($value['TravelerName'] == ''){
              $error =  $error .'Error: TravelerName vacio para el BookingID-'.$ultimo_id.'<br>';
            }
            if($value['RecordLocator'] == ''){
              $error =  $error .'Error: RecordLocator vacio para el BookingID-'.$ultimo_id.'<br>';
            }

        $data = [];
        $data['arr_errores_log_duplicate_records'] = $arr_errores_log_duplicate_records;
        $data['arr_errores_log_duplicate_records_hoteles'] = $arr_errores_log_duplicate_records_hoteles;
        $data['msn'] = $error;

        return $data;

      
   }

}