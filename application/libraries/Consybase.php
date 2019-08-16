<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consybase {

   function conn()
   {
   	 $conect = odbc_connect('icaavcapa', 'dba', 'sql');
      if(!$conect){
      	echo "conexion fallida";
      }else{
      	return $conect;
      }
   }
   
}