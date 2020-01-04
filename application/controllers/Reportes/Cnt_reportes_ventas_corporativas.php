<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_ventas_corporativas extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_ventas_corporativas');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->load->model('Mod_general');
		  $this->Mod_general->get_SPID();

	     
	}

	public function get_html_rep_pasajeros_servicio(){

		$title = $this->input->post('title');
		
		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio();
		$rest_catalogo_id_provedor = $this->Mod_catalogos_filtros->get_catalogo_id_provedor();
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,3);
		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		$param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_catalogo_id_servicio"] = $rest_catalogo_id_servicio;
	    $param["rest_catalogo_id_provedor"] = $rest_catalogo_id_provedor;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param["rest_clientes"] = $rest_clientes;

	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);

		$this->load->view('Reportes/view_rep_ventas_corporativas');
		
	}

	public function get_grafica_pasajero_html(){

		$rows_grafica = $this->input->post("rows_grafica");
		$rows_provedores_servicio = $this->input->post("rows_provedores_servicio");
		$meses_cliente = $this->input->post("meses_cliente");

		
		$para = $this->input->post("parametros");

		$id_servicio = $this->input->post("id_servicio");

		$parametros = explode(",", $para);


		$ids_suc = $parametros[0];
		$ids_serie = $parametros[1];
        $ids_cliente = $parametros[2];
        $ids_servicio = $parametros[3];  
        $ids_provedor = $parametros[4];
        $ids_corporativo = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];

	    $ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");
  
        if(count($ids_corporativo) > 0 ){

              $sub = "";

              if(count($ids_corporativo) > 1){

              	    $sub = $sub . $fecha1 . ' - ' . $fecha2;

              }else{

              	foreach ($ids_corporativo as $clave => $valor) {  //obtiene clientes asignados

                 	$sub = $sub . $valor .'<br>'. $fecha1 . ' - ' . $fecha2;

              	}

              }

        }else if(count($ids_cliente) > 0){

        	$sub = "";
            
            $rz = $this->Mod_reportes_ventas_corporativas->get_razon_social_id_in($ids_cliente);  //optiene razon social
            
            if(count($rz) > 1){

            	  $sub = $sub . $fecha1 . ' - ' . $fecha2 .' ';

            }else{

            	foreach ($rz as $clave => $valor) {  //obtiene clientes asignados

                   $sub = $sub . $valor->nombre_cliente .'<br>'. $fecha1 . ' - ' . $fecha2 .' ';

            	}
            }
            
           

        }else{
        	
        	$sub = "Clientes Villatours" .'<br>'. $fecha1 . ' - ' . $fecha2;

        }

		$array2["rows_grafica"] =  $rows_grafica;
		$array2["rows_provedores_servicio"] = $rows_provedores_servicio;
		$array2["cont_corporativo"] = count($ids_corporativo);
		$array2["meses_cliente"] = $meses_cliente;
		$array2["id_servicio"] =  $id_servicio;
		$array2["fecha1"] =  $fecha1;
		$array2["fecha2"] =  $fecha2;
		$array2["sub"] =  $sub;


		$this->load->view('Reportes/formatos/view_formato_html_ventas_corporativas',$array2);
		
		

	}


	public function get_grafica_pasajero(){

		$para = $this->input->post("parametros");
		//$id_servicio = $this->input->post("id_servicio");
		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$parametros = explode(",", $para);

	

       if($tipo_funcion == "aut"){

       		$ids_suc = $parametros[0];
        	$ids_serie = $parametros[1];
	        $ids_cliente = $parametros[2];
	        $ids_servicio = $parametros[3];  //esta vacio --no se ocupa en este reporte 
	        $ids_provedor = $parametros[4];
	        $ids_corporativo = $parametros[5];
	        $id_plantilla = $parametros[6];
	        $fecha1 = $parametros[7];
	        $fecha2 = $parametros[8];
        	$id_correo_automatico = $parametros[9];
            $id_reporte = $parametros[10];
            $id_usuario = $parametros[11];
            $id_intervalo = $parametros[12];
            $fecha_ini_proceso = $parametros[13];
			
		}else{

			$ids_suc = $parametros[0];
			$ids_serie = $parametros[1];
			$ids_cliente = $parametros[2];
			$ids_servicio = $parametros[3];  //esta vacio --no se ocupa en este reporte 
	        $ids_provedor = $parametros[4];
	        $ids_corporativo = $parametros[5];
	        $fecha1 = $parametros[6];
	        $fecha2 = $parametros[7];

		}

        $parametros = [];

        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["ids_servicio"] = $ids_servicio;
        $parametros["ids_provedor"] = $ids_provedor;
        $parametros["ids_corporativo"] = $ids_corporativo;
        $parametros["fecha1"] = $fecha1;
        $parametros["fecha2"] = $fecha2;

        if($tipo_funcion == "aut"){
        	
        	$parametros["id_usuario"] = $id_usuario;
        	$parametros["id_intervalo"] = $id_intervalo;
        	$parametros["fecha_ini_proceso"] = $fecha_ini_proceso;
			
		}else{

			$parametros["id_usuario"] = $this->session->userdata('session_id');
	        $parametros["id_intervalo"] = '0';
	        $parametros["fecha_ini_proceso"] = '';

		}

		$parametros["proceso"] = 1;

		$rest_SPID = $this->Mod_general->get_SPID();
		$rest_grafica = $this->Mod_reportes_ventas_corporativas->get_grafica_pasajero($parametros);
		$rest_provedores_servicio = $this->Mod_reportes_ventas_corporativas->get_provedores_servicio($parametros);
		

		foreach ($rest_grafica as $key => $value) {
		
			$value->GVC_ID_CORPORATIVO =  utf8_encode($value->GVC_ID_CORPORATIVO);
			$value->GVC_ID_CLIENTE =  utf8_encode($value->GVC_ID_CLIENTE);

		}

		$array2["grafica"] = $rest_grafica;

		foreach ($rest_provedores_servicio as $key => $value) {
			
			if(isset($value->GVC_NOM_CLI)){
				
				$value['GVC_NOM_CLI'] =  utf8_encode($value['GVC_NOM_CLI'] );

			}

			if(isset($value->GVC_ID_CORPORATIVO)){
					
				
				$value['GVC_ID_CORPORATIVO'] =  utf8_encode($value['GVC_ID_CORPORATIVO']);


			}

		}
		
		$array2["provedores_servicio"] = $rest_provedores_servicio;


	    echo json_encode( $array2, JSON_NUMERIC_CHECK );
	    

	}


	public function exportar_excel_ae(){

	    $para = $this->input->post("parametros");
	    $parametros = explode(",", $para);

		$ids_suc = $parametros[0];
		$ids_serie = $parametros[1];
		$ids_cliente = $parametros[2];
		$ids_servicio = $parametros[3];  //esta vacio --no se ocupa en este reporte 
        $ids_provedor = $parametros[4];
        $ids_corporativo = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];

        $ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
		$cont_corporativo = count($ids_corporativo);
		
		$rows_grafica = $this->input->post("rows_grafica");
		$rows_provedores_servicio = $this->input->post("rows_provedores_servicio");
		$rows_provedores_servicio = json_decode($rows_provedores_servicio);
		$meses_cliente = $this->input->post("meses_cliente");


        foreach ($rows_grafica as $key => $value) {
		
			$value['GVC_ID_CORPORATIVO'] =  utf8_encode($value['GVC_ID_CORPORATIVO']);
			$value['GVC_ID_CLIENTE'] =  utf8_encode($value['GVC_ID_CLIENTE']);

		}
		
		$array2["grafica"] = $rows_grafica;

		foreach ($rows_provedores_servicio as $key => $value) {
			
			if(isset($value->GVC_NOM_CLI)){
				
				$value->GVC_NOM_CLI =  utf8_encode($value->GVC_NOM_CLI);

			}

			if(isset($value->GVC_ID_CORPORATIVO)){
					
				$value->GVC_ID_CORPORATIVO =  utf8_encode($value->GVC_ID_CORPORATIVO);

			}

			if(isset($value->GVC_ID_CLIENTE)){
					
				$value->GVC_ID_CLIENTE =  utf8_encode($value->GVC_ID_CLIENTE);

			}


		}

        if(count($rows_grafica) > 0){

		
        $spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

        $styleArray = [
		    'borders' => [
		        //'diagonalDirection' => \PhpOffice\PhpSpreadsheet\Style\Borders::DIAGONAL_BOTH,
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ]
		   
		];

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		$styleArray1 = [
		    'borders' => [
		        'top' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '010101'],
		        ],
		    ],
		];
		$styleArray2 = [
		    'borders' => [
		        'bottom' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '010101'],
		        ],
		    ],
		];

	

        $activeSheet->setCellValue('B10','CORPORATIVO');
        $activeSheet->setCellValue('C10','CLIENTE');
		$activeSheet->setCellValue('D10','NOMBRE CLIENTE');

		
		//******************************************************************************
		$cont = 0;
		$TOTAL_GEN = 0;
    	$TOTAL_BOL_GEN = 0;

    	if(isset($rows_grafica) && count($rows_grafica) > 0 && $cont_corporativo > 0){ 

		    foreach ($rows_grafica as $clave => $valor) {  

		    	//$cont++;
		        $GVC_ID_CORPORATIVO = $valor['GVC_ID_CORPORATIVO'];

		         $count=0;
		         foreach ($rows_provedores_servicio as $clave2 => $valor2) {  

		          $GVC_ID_CORPORATIVO2 = $valor2->GVC_ID_CORPORATIVO;
		          //$TOTAL2 = $valor2->TOTAL;
		          $GVC_NOM_CLI2 = $valor2->GVC_NOM_CLI;
		          $GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;    

		          if($GVC_ID_CORPORATIVO2 == $GVC_ID_CORPORATIVO){
		           $cont++;
		           $count++;

		              if($count==1){

		              	  	$activeSheet->setCellValue('B'.($cont+10),$GVC_ID_CORPORATIVO)->getStyle('B'.($cont+10))->getFont()->setBold(true);
		              	  	$activeSheet->setCellValue('C'.($cont+10),$GVC_ID_CLIENTE2);
		              	  	$activeSheet->setCellValue('D'.($cont+10),$GVC_NOM_CLI2);

		              	    if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){

		              	      $activeSheet->setCellValue('E'.($cont+10),$valor2->TOTAL_MES1);

			                }
			                if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

			                  $activeSheet->setCellValue('F'.($cont+10),$valor2->TOTAL_MES2);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

			                  $activeSheet->setCellValue('G'.($cont+10),$valor2->TOTAL_MES3);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

			                  $activeSheet->setCellValue('H'.($cont+10),$valor2->TOTAL_MES4);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

			                  $activeSheet->setCellValue('I'.($cont+10),$valor2->TOTAL_MES5);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){
			                  
			                  $activeSheet->setCellValue('J'.($cont+10),$valor2->TOTAL_MES6);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){
			                  
			                  $activeSheet->setCellValue('K'.($cont+10),$valor2->TOTAL_MES7);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

			                  $activeSheet->setCellValue('L'.($cont+10),$valor2->TOTAL_MES8);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

			                  $activeSheet->setCellValue('M'.($cont+10),$valor2->TOTAL_MES9);
			                  
			                }
			                if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

			                  $activeSheet->setCellValue('N'.($cont+10),$valor2->TOTAL_MES10);
			                  
			                }  
			                if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){
			                  
			                  $activeSheet->setCellValue('O'.($cont+10),$valor2->TOTAL_MES11);
			                  
			                }  
			                if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){
			                  
			                  $activeSheet->setCellValue('P'.($cont+10),$valor2->TOTAL_MES12);
			                  
			                }    


		              }else{

		              	  $activeSheet->setCellValue('B'.($cont+10),'')->getStyle('B'.($cont+10))->getFont()->setBold(true);
		              	  $activeSheet->setCellValue('C'.($cont+10),$GVC_ID_CLIENTE2);
		              	  $activeSheet->setCellValue('D'.($cont+10),$GVC_NOM_CLI2);

		              	  if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){

		              	      $activeSheet->setCellValue('E'.($cont+10),$valor2->TOTAL_MES1);

			                }
			                if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

			                  $activeSheet->setCellValue('F'.($cont+10),$valor2->TOTAL_MES2);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

			                  $activeSheet->setCellValue('G'.($cont+10),$valor2->TOTAL_MES3);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

			                  $activeSheet->setCellValue('H'.($cont+10),$valor2->TOTAL_MES4);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

			                  $activeSheet->setCellValue('I'.($cont+10),$valor2->TOTAL_MES5);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){
			                  
			                  $activeSheet->setCellValue('J'.($cont+10),$valor2->TOTAL_MES6);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){
			                  
			                  $activeSheet->setCellValue('K'.($cont+10),$valor2->TOTAL_MES7);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

			                  $activeSheet->setCellValue('L'.($cont+10),$valor2->TOTAL_MES8);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

			                  $activeSheet->setCellValue('M'.($cont+10),$valor2->TOTAL_MES9);
			                  
			                }
			                if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

			                  $activeSheet->setCellValue('N'.($cont+10),$valor2->TOTAL_MES10);
			                  
			                }  
			                if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){
			                  
			                  $activeSheet->setCellValue('O'.($cont+10),$valor2->TOTAL_MES11);
			                  
			                }  
			                if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){
			                  
			                  $activeSheet->setCellValue('P'.($cont+10),$valor2->TOTAL_MES12);
			                  
			                }    

		              }


		          }

		        }

		      
		    } //fin for

		}  // fin validacion isset
		else{   //cuando es solamente filtro por cliente

			$count=0;
			 foreach ($rows_provedores_servicio as $clave2 => $valor2) {  
			 	$cont++;
			 	$count++;

			 	$GVC_ID_CLIENTE2 = $valor2->GVC_ID_CLIENTE;
              	$GVC_NOM_CLI2 = $valor2->GVC_NOM_CLI;

					      $activeSheet->setCellValue('B'.($cont+10),'')->getStyle('B'.($cont+10))->getFont()->setBold(true);
		              	  $activeSheet->setCellValue('C'.($cont+10),$GVC_ID_CLIENTE2);
		              	  $activeSheet->setCellValue('D'.($cont+10),$GVC_NOM_CLI2);

		              	  if(isset($valor2->TOTAL_MES1) && $valor2->TOTAL_MES1 != ''){


		              	      $activeSheet->setCellValue('E'.($cont+10),$valor2->TOTAL_MES1);


			                }
			                if(isset($valor2->TOTAL_MES2) && $valor2->TOTAL_MES2 != ''){

			                  $activeSheet->setCellValue('F'.($cont+10),$valor2->TOTAL_MES2);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES3) && $valor2->TOTAL_MES3 != ''){

			                  $activeSheet->setCellValue('G'.($cont+10),$valor2->TOTAL_MES3);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES4) && $valor2->TOTAL_MES4 != ''){

			                  $activeSheet->setCellValue('H'.($cont+10),$valor2->TOTAL_MES4);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES5) && $valor2->TOTAL_MES5 != ''){

			                  $activeSheet->setCellValue('I'.($cont+10),$valor2->TOTAL_MES5);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES6) && $valor2->TOTAL_MES6 != ''){
			                  
			                  $activeSheet->setCellValue('J'.($cont+10),$valor2->TOTAL_MES6);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES7) && $valor2->TOTAL_MES7 != ''){
			                  
			                  $activeSheet->setCellValue('K'.($cont+10),$valor2->TOTAL_MES7);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES8) && $valor2->TOTAL_MES8 != ''){

			                  $activeSheet->setCellValue('L'.($cont+10),$valor2->TOTAL_MES8);
			                  
			                } 
			                if(isset($valor2->TOTAL_MES9) && $valor2->TOTAL_MES9 != ''){

			                  $activeSheet->setCellValue('M'.($cont+10),$valor2->TOTAL_MES9);
			                  
			                }
			                if(isset($valor2->TOTAL_MES10) && $valor2->TOTAL_MES10 != ''){

			                  $activeSheet->setCellValue('N'.($cont+10),$valor2->TOTAL_MES10);
			                  
			                }  
			                if(isset($valor2->TOTAL_MES11) && $valor2->TOTAL_MES11 != ''){
			                  
			                  $activeSheet->setCellValue('O'.($cont+10),$valor2->TOTAL_MES11);
			                  
			                }  
			                if(isset($valor2->TOTAL_MES12) && $valor2->TOTAL_MES12 != ''){
			                  
			                  $activeSheet->setCellValue('P'.($cont+10),$valor2->TOTAL_MES12);
			                  
			                } 

			} // fin for proveedores servicio



		}

		  
	  $cont++; 

	  $count_meses = count($meses_cliente);
	  $letra_Excel = 'E';


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

            switch ($key) {
                case 0:
                    $letra_Excel_encabezado = 'E';
                    break;
                case 1:
                    $letra_Excel_encabezado = 'F';
                    break;
                case 2:
                    $letra_Excel_encabezado = 'G';
                    break;
                case 3:
                    $letra_Excel_encabezado = 'H';
                    break;
                case 4:
                    $letra_Excel_encabezado = 'I';
                    break;
                case 5:
                    $letra_Excel_encabezado = 'J';
                    break;
                case 6:
                    $letra_Excel_encabezado = 'K';
                    break;
                case 7:
                    $letra_Excel_encabezado = 'L';
                    break;
                case 8:
                    $letra_Excel_encabezado = 'M';
                    break;
                case 9:
                    $letra_Excel_encabezado = 'N';
                    break;
                case 10:
                     $letra_Excel_encabezado = 'O';
                    break;
                case 11:
                     $letra_Excel_encabezado = 'P';
                    break;

            } 


            $fecha = $mes_palabra.' '.$ano;
            $activeSheet->setCellValue($letra_Excel_encabezado.'10',$fecha);


     }


  	  switch ($count_meses) {

	    case 1:
	        $letra_Excel = 'E';
	        break;
	    case 2:
	        $letra_Excel = 'F';
	        break;
	    case 3:
	        $letra_Excel = 'G';
	        break;
	    case 4:
	        $letra_Excel = 'H';
	        break;
	    case 5:
	        $letra_Excel = 'I';
	        break;
	    case 6:
	        $letra_Excel = 'J';
	        break;
	    case 7:
	        $letra_Excel = 'K';
	        break;
	    case 8:
	        $letra_Excel = 'L';
	        break;
	    case 9:
	        $letra_Excel = 'M';
	        break;
	    case 10:
	        $letra_Excel = 'N';
	        break;
	    case 11:
	        $letra_Excel = 'O';
	        break;
	    case 12:
	        $letra_Excel = 'P';
	        break;

	  }

     $spreadsheet->getActiveSheet()->mergeCells('B6:'.$letra_Excel.'6');
	 $spreadsheet->getActiveSheet()->mergeCells('B7:'.$letra_Excel.'7');
	 $spreadsheet->getActiveSheet()->mergeCells('B8:'.$letra_Excel.'8');
	 $spreadsheet->getActiveSheet()->mergeCells('B9:'.$letra_Excel.'9');

	 $spreadsheet->getActiveSheet()->getStyle('B6:'.$letra_Excel.'6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	 $spreadsheet->getActiveSheet()->getStyle('B7:'.$letra_Excel.'7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	 $spreadsheet->getActiveSheet()->getStyle('B8:'.$letra_Excel.'8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	 $spreadsheet->getActiveSheet()->getStyle('B9:'.$letra_Excel.'9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

	 $spreadsheet->getActiveSheet()->getStyle('C8:C3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	 $spreadsheet->getActiveSheet()->getStyle('D8:D3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	 $spreadsheet->getActiveSheet()->getStyle('E8:E3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

	  foreach(range('A',$letra_Excel) as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

	  }

	  $spreadsheet->getActiveSheet()->getStyle('A1:'.$letra_Excel.($cont+10))->applyFromArray($styleArray);

	
      $activeSheet->setCellValue('C'.($cont+10),'')->getStyle('C'.($cont+10))->getFont()->setBold(true);

   
      $spreadsheet->getActiveSheet()->getStyle('B'.($cont+10).':'.$letra_Excel.($cont+10).'')
      ->getFont()->getColor()->setARGB('ffffff');

      $spreadsheet->getActiveSheet()
		    ->getStyle('E11:'.$letra_Excel.($cont+10))
		    ->getNumberFormat()
		    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	  	//****************************************************************************************************************

	    $activeSheet->getStyle('B10:'.$letra_Excel.'10')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');
	    
		 $spreadsheet->getActiveSheet()->getStyle('B10:'.$letra_Excel.'10')
        ->getFont()->getColor()->setARGB('ffffff');
	  
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setCoordinates('A1');
		$drawing->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/img/villatours.png');
		$drawing->setHeight(250);
		$drawing->setWidth(250);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing2->setName('Logo');
		$drawing2->setDescription('Logo');
		$drawing2->setCoordinates($letra_Excel.'1');
		$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/img/91_4c.gif');
		$drawing2->setHeight(60);
		$drawing2->setWidth(60);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());
       	
       	
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");

  	    $activeSheet->setCellValue('B6','Ventas corporativas')->getStyle('B6')->getFont()->setBold(true)->setSize(25);
        
			if(count($ids_corporativo) > 0 ){

	            $title = "";
            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
            	$sub = "";

	              if(count($ids_corporativo) > 1){

	              	    $title = "Clientes Villatours";

	              }else{

	              	foreach ($ids_corporativo as $clave => $valor) {  //obtiene clientes asignados

	                 	$sub = $sub . $valor;


	              	}

	              }

            }

            else if(count($ids_cliente) > 0){
            	$title = "";
            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
            	$sub = "";
                
                $rz = $this->Mod_reportes_ventas_corporativas->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
                if(count($rz) > 1){

                	  $title = "Clientes Villatours";
                	  
                }else{

                	foreach ($rz as $clave => $valor) {  //obtiene clientes asignados

	                   $sub = $sub . $valor->nombre_cliente;

	            	}
                }
                
            }else{

            	$title = "Clientes Villatours";
            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
            	$sub = "";

            }

            $activeSheet->setCellValue('B7', utf8_encode($title) )->getStyle('B7')->getFont()->setBold(true)->setSize(14);
			$activeSheet->setCellValue('B8', utf8_encode($sub) )->getStyle('B8')->getFont()->setBold(true)->setSize(14);
			$activeSheet->setCellValue('B9', utf8_encode($rango_fecha) )->getStyle('B8')->getFont()->setBold(true)->setSize(14);

			
			$mes1 = $fecha1;
		    $mes2 = $fecha2;

		    $hoy = getdate();
		    $dia_actual = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
		    $mes_actual = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);

		    $year_actual = $hoy['year'];
		    

		    $fecha_actual = $year_actual.'-'.$mes1.'-'.$dia_actual;   //fecha actual con mes seleccionado
		    $fecha_actual2 = $year_actual.'-'.$mes2.'-'.$dia_actual;   //fecha actual con mes seleccionado

		    $fecha1 = strtotime ( '-1 year' , strtotime ( $fecha_actual ) ) ;
		    $fecha1 = date("Y-m-d", $fecha1);

		    $fecha_actual2 = strtotime ( $fecha_actual2 );
		    $fecha2 = date("Y-m-d", $fecha_actual2);


	     	$fecha1 = explode('-', $fecha1);
	        $ano1 = $fecha1[0];
	        $mes1 = $fecha1[1];
	        $dia1 = $fecha1[2];
	        $fecha1 = $ano1.'_'.$mes1.'_'.$dia1;

	        $fecha2 = explode('-', $fecha2);
	        $ano2 = $fecha2[0];
	        $mes2 = $fecha2[1];
	        $dia2 = $fecha2[2];
	        $fecha2 = $ano2.'_'.$mes2.'_'.$dia2;

			ob_start();
			$Excel_writer->save("php://output");
			$xlsData = ob_get_contents();
			ob_end_clean();
			 
			$opResult = array(
					'str_fecha'=> $fecha1.'_A_'.$fecha2,
			        'status' => 1,
			        'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			     );

	    	echo json_encode($opResult);
		

	  }//fin count
	  else{

	    if($tipo_funcion != "aut"){

	    	 echo json_encode(0);
       	 

        }else{

        	 echo json_encode(0);


        }


	  }
	  

	}
	
	

}
