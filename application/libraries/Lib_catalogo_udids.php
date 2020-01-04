<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_catalogo_udids {

   function udids($id_udid)
   {


    $concepto = '';

        switch ($id_udid) {

		case 11 : $concepto ='COMPANY';
		break;
		case 13 : $concepto ='CODIGO GINEBRA';
		break;
		case 14 : $concepto ='SECTOR';
		break;
		case 15 : $concepto ='LOCATION';
		break;
		case 17 : $concepto ='PROYECT NUMBER';
		break;
		case 18 : $concepto ='AUTORIZADOR';
		break;
		case 25 : $concepto ='ACTIVITY';
		break;
		case 26 : $concepto ='COST LEVEL';
		break;
		case 46 : $concepto ='GROUP ID';
		break;
		



        }

        

        return $concepto;

      
   }


   
}