<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';

class Cnt_layouts_egencia_sample_summary_airline extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_egencia_sample_summary_airline');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_ciudades');
	      $this->Mod_general->get_SPID();
	     
	}

	public function get_html_layouts_egencia_sample_summary_airline(){

		$title = $this->input->post('title');
		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,6);
		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
	    $param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);

		$this->load->view('Layouts/view_lay_egencia_sample_summary_airline');
		
	}
	

	public function get_layouts_egencia_sample_summary_airline_parametros(){

		$parametros = $_REQUEST["parametros"];
        $tipo_funcion = $_REQUEST['tipo_funcion'];  //falta
		$parametros = explode(",", $parametros);
		        
		$this->get_layouts_egencia_sample_summary_airline($parametros,$tipo_funcion);

		

	}


	public function get_layouts_egencia_sample_summary_airline($parametros,$tipo_funcion){

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
	        $ids_servicio = $parametros[3];
	        $ids_provedor = $parametros[4];
	        $ids_corporativo = $parametros[5];
	        $id_plantilla = $parametros[6];
	        $fecha1 = $parametros[7];
	        $fecha2 = $parametros[8];

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
  		

		$rest = $this->Mod_layouts_egencia_sample_summary_airline->get_layouts_egencia_data_import_sp($parametros);

		  $array1 = array();
		  $array_consecutivo = array();

		  foreach ($rest as $clave => $valor) {

			     	$dat['Partner_Code'] = 'VLT';  //proporcionados por egencia,aun no se tienen
					$dat['Partner_Name'] = 'Villa Tours';  //proporcionados por egencia,aun no se tienen
					$dat['Country_Code'] = utf8_encode($valor->id_proveedor); 
					$dat['Currency_Code'] = utf8_encode($valor->moneda_vuelo);

					$fecha_fac = utf8_encode($valor->fecha_fac);
					$fecha_fac = explode('-', $fecha_fac);

					$dat['Transaction_Year'] = $fecha_fac[1];
					$dat['Transaction_Month_Number'] = $fecha_fac[0];
					$dat['Client_ID'] = utf8_encode($valor->nexp);
					$dat['Client_Name'] = utf8_encode($valor->NAME);
					$dat['Airline_Code'] = utf8_encode($valor->id_proveedor);
					$dat['Air_Net_Expense_Amount'] = number_format((float)$valor->GVC_TOTAL, 2, '.', '');
					$dat['Air_Net_Ticket_Count'] = utf8_encode($valor->cont_bolteos);


					array_push($array1, $dat);
	
	    			
			   }  //fin del for principal

			   $param_final['rep'] = $array1;


		       if($tipo_funcion == 'ex'){

		       		$this->genera_excel($param_final,$fecha1,$fecha2);
		     
		       }else{

		       		echo json_encode($param_final);

		       }
			   

    } //fin de la funcion


    public function genera_excel($param_final,$fecha1,$fecha2){

    	$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);


		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$activeSheet->setTitle("Summary_Airline");

		$allrows = $param_final;

		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}
		
		$activeSheet->setCellValue('A1','Partner Code');
		$activeSheet->setCellValue('B1','Partner Name');
		$activeSheet->setCellValue('C1','Country Code');
		$activeSheet->setCellValue('D1','Currency Code');
		$activeSheet->setCellValue('E1','Transaction Year');
		$activeSheet->setCellValue('F1','Transaction Month Number');
		$activeSheet->setCellValue('G1','Client ID');
		$activeSheet->setCellValue('H1','Client Name');
		$activeSheet->setCellValue('I1','Airline Code');
		$activeSheet->setCellValue('J1','Air Net Expense Amount');
		$activeSheet->setCellValue('K1','Air Net Ticket Count');

	    $nueva_plantilla = [];

		foreach ($allrows['rep'] as $key => $value) {
	
			array_push($nueva_plantilla, $value);
			
		}

		$activeSheet->fromArray(
	        $nueva_plantilla,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A2'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );
		
		$fecha1_explode = explode('/', $fecha1);
		$fecha2_explode = explode('/', $fecha2);

		$fecha1 = $fecha1_explode[2] .$fecha1_explode[1].$fecha1_explode[0];
		$fecha2 = $fecha2_explode[2] .$fecha2_explode[1].$fecha2_explode[0];


		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="VTL_MEX_Airline_'.$fecha1.'-'.$fecha1.'".'.'xlsx'); 
		header('Cache-Control: max-age=0');
		
		$Excel_writer->save('php://output', 'xlsx');


    }

    public function genera_txt($param_final){

		$allrows = $param_final;
		
		$archivo = fopen($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/archivos_egencia_lay_data_import_sp/Summary_Airline.txt', "w+");
		
		$header = ['Partner_Code','Partner_Name','Country_Code','Currency_Code','Transaction_Year','Transaction_Month_Number','Client_ID','Client_Name','Airline_Code','Air_Net_Expense_Amount','Air_Net_Ticket_Count'];

		$str_body = '';
		foreach ($header as $key => $value) {
			
					$str_body = $str_body . $value."	";

				}


		fwrite($archivo, $str_body);
			

	    $nueva_plantilla = [];

		foreach ($allrows['rep'] as $key => $value) {
	

			array_push($nueva_plantilla, $value);
			

		}
		
	    foreach($nueva_plantilla as $key => $value) {

	    	fwrite($archivo,"\r\n");
	    	
	    	$str_body = '';
	    	foreach($value as $value2) {

	    		$str_body = $str_body . $value2."	";

	    	}

	    	fwrite($archivo, $str_body);

		}

		

		fclose($archivo);




    }

    public function exportar_txt_lay_egencia_sample_summary_airline(){

	    header("Content-type: .txt");
	    header("Content-Disposition: attachment;filename=Summary_Airline.txt");
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	 
	    set_time_limit(0); 
	    readfile($_SERVER['DOCUMENT_ROOT'].'\reportes_villatours_v\referencias\archivos\archivos_egencia_lay_data_import_sp\Summary_Airline.txt');

	}



}
