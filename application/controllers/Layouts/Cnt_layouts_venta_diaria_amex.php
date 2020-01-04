<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '2000000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;

class Cnt_layouts_venta_diaria_amex extends CI_Controller {

	public function __construct()
	{

	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_venta_diaria_amex');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->model('Mod_usuario');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->load->model('Mod_general');
		  $this->Mod_general->get_SPID();
	      
	}
    
    public function get_html_layouts_venta_diaria_amex(){

    	$title = $this->input->post('title');

		$id_us = $this->session->userdata('session_id');
		$id_perfil = $this->session->userdata('session_id_perfil');

		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio();
		$rest_catalogo_metodo_pago = $this->Mod_catalogos_filtros->get_catalogo_metodo_pago();
		$rest_catalogo_suc = $this->Mod_usuario->get_sucursales_actuales($id_perfil);


		$param['sucursales'] = $rest_catalogo_suc;
		$param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_id_servicio"] = $rest_catalogo_id_servicio;
	    $param["rest_catalogo_metodo_pago"] = $rest_catalogo_metodo_pago;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Layouts/view_lay_venta_diaria_amex');

	}

	public function get_catalogo_aereolineas_venta_diaria_amex(){

		$slc_select_cat_provedor = $this->input->post("slc_select_cat_provedor");
		
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_tipo_aereolinea_venta_diaria_amex($slc_select_cat_provedor);

		echo json_encode($rest_catalogo_id_servicio);

	}

	public function sanear_string($string)
	{
		 
		    $string = trim($string);
		 
		    $string = str_replace(
		        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		        $string
		    );
		 
		    $string = str_replace(
		        array('ñ', 'Ñ', 'ç', 'Ç'),
		        array('n', 'N', 'c', 'C',),
		        $string
		    );
		 
		
		    return $string;
	}

    public function get_lay_venta_diaria_amex(){

		$parametros = $this->input->post("parametros");

		$parametros = explode(",", $parametros);
        
        $ids_suc = $parametros[0];
        $ids_serie = $parametros[1];
        $ids_cliente = $parametros[2];
        $ids_servicio = $parametros[3];
        $ids_metodo_pago = $parametros[4];
        $fecha1 = $parametros[5];
        $fecha2 = $parametros[6];
        
        $parametros = [];

        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["ids_servicio"] = $ids_servicio;
        $parametros["ids_metodo_pago"] = $ids_metodo_pago;
        $parametros["fecha1"] = $fecha1;
        $parametros["fecha2"] = $fecha2;

        $parametros["id_usuario"] = $this->session->userdata('session_id');
        $parametros["proceso"] = 2;
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';

		$rep = $this->lay_venta_diaria_amex($parametros);

		$param_final['rep'] = $rep;
		
		echo json_encode($param_final);

	}

	public function lay_venta_diaria_amex($parametros){
		
	    $rest = $this->Mod_layouts_venta_diaria_amex->lay_venta_diaria_amex($parametros);
	  	
	    $array1 = array();

	    $rep = [];
		foreach($rest as $value) {

			  $value["GVC_ID_SERIE"] = $this->sanear_string(utf8_encode($value["GVC_ID_SERIE"]));
			  $value["GVC_DOC_NUMERO"] = $this->sanear_string(utf8_encode($value["GVC_DOC_NUMERO"]));
		      //$value["GVC_ID_SUCURSAL"] = $this->sanear_string(utf8_encode($value["GVC_ID_SUCURSAL"]));
		      $value["FECHA"] = $this->sanear_string(utf8_encode($value["FECHA"]));
		      //$value["GVC_ID_CLIENTE"] = $this->sanear_string(utf8_encode($value["GVC_ID_CLIENTE"]));
		      $value["GVC_NOM_CLI"] = $this->sanear_string(utf8_encode($value["GVC_NOM_CLI"]));
		      $value["analisis27_cliente"] = $this->sanear_string(utf8_encode($value["analisis27_cliente"]));
		      $value["GVC_ID_CORPORATIVO"] = $this->sanear_string(utf8_encode($value["GVC_ID_CORPORATIVO"]));
		      $value["GVC_TOTAL"] = $this->sanear_string(utf8_encode($value["GVC_TOTAL"]));
		      $value["GVC_ID_SERVICIO"] = $this->sanear_string(utf8_encode($value["GVC_ID_SERVICIO"]));
		      $value["ID_FORMA_PAGO"] = $this->sanear_string(utf8_encode($value["ID_FORMA_PAGO"]));


			  $value["c_FormaPago"] = $this->sanear_string(utf8_encode($value["c_FormaPago"]));
			  $value["GVC_RUTA"] = $this->sanear_string(utf8_encode($value["GVC_RUTA"]));
			  $value["GVC_ID_PROVEEDOR"] = $this->sanear_string(utf8_encode($value["GVC_ID_PROVEEDOR"]));
			  $value["GVC_NOMBRE_PROVEEDOR"] = $this->sanear_string(utf8_encode($value["GVC_NOMBRE_PROVEEDOR"]));
  

			  $value["GVC_TARIFA"] = $this->sanear_string(utf8_encode($value["GVC_TARIFA"]));
			  $value["GVC_IVA"] = $this->sanear_string(utf8_encode($value["GVC_IVA"]));
			  $value["GVC_TUA"] = $this->sanear_string(utf8_encode($value["GVC_TUA"]));
			  $value["GVC_OTROS_IMPUESTOS"] = $this->sanear_string(utf8_encode($value["GVC_OTROS_IMPUESTOS"]));
			  $value["GVC_NOM_VEN_TIT"] = $this->sanear_string(utf8_encode($value["GVC_NOM_VEN_TIT"]));


		      $value["NUMERO_CUENTA"] = $this->sanear_string(utf8_encode($value["NUMERO_CUENTA"]));
		      $value["CONCEPTO"] = $this->sanear_string(utf8_encode($value["CONCEPTO"]));
		      $value["NUMERO_CUPON"] = $this->sanear_string(utf8_encode($value["NUMERO_CUPON"]));

		  
		      $NUMERO_BOLETO = '306'.str_pad(substr($value["NUMERO_BOLETO"],0,10), 10,"0");

		      $value["NUMERO_BOLETO"] = $this->sanear_string(utf8_encode($NUMERO_BOLETO));


		      //$value["CVE"] = $this->sanear_string(utf8_encode($value["CVE"]));
		      //$value["NOMBRE_COMERCIAL"] = $this->sanear_string(utf8_encode($value["NOM_COMERCIAL"]));


    		$cast_utf8 = array_map("utf8_encode", $value );

    		array_push($array1, $cast_utf8);
		   
		}

	    return $array1;

	}

	public function get_lay_venta_diaria_amex_aereomexico(){

		$parametros = $this->input->post("parametros");
        $cat_provedor = $this->input->post("cat_provedor");

		$parametros = explode(",", $parametros);
        
        $ids_serie = $parametros[0];
        $ids_cliente = $parametros[1];
        $ids_servicio = $parametros[2];
        $ids_provedor = $parametros[3];
        $ids_corporativo = $parametros[4];
        $id_plantilla = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];
        
        $parametros = [];
        
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["ids_servicio"] = $ids_servicio;
        $parametros["ids_provedor"] = $ids_provedor;
        $parametros["ids_corporativo"] = $ids_corporativo;
        $parametros["fecha1"] = $fecha1;
        $parametros["fecha2"] = $fecha2;

        $parametros["id_usuario"] = $this->session->userdata('session_id');
        $parametros["proceso"] = 2;
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';
        $parametros["id_plantilla"] = $id_plantilla;

		$rep = $this->lay_venta_diaria_amex_aereomexico($parametros,$cat_provedor);

		$param_final['rep'] = $rep;
		
		echo json_encode($param_final);



	}


	public function exportar_excel(){


		$allrows = $_REQUEST['allrows'];
		$allrows = json_decode($allrows);

		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}

		$activeSheet->setCellValue('A1' ,'SERIE');
		$activeSheet->setCellValue('B1' ,'FACTURA');
		$activeSheet->setCellValue('C1' ,'BOLETO');
		$activeSheet->setCellValue('D1' ,'CUPON');
		$activeSheet->setCellValue('E1' ,'FECHA');
		$activeSheet->setCellValue('F1' ,'CLIENTE');
		$activeSheet->setCellValue('G1' ,'CUENTA CONTABLE');
		$activeSheet->setCellValue('H1' ,'FECHA VENCIMIENTO TDC');
		$activeSheet->setCellValue('I1' ,'ID CORPORATIVO');
		$activeSheet->setCellValue('J1' ,'ID FORMA DE PAGO');
		$activeSheet->setCellValue('K1' ,'FORMA DE PAGO');
		$activeSheet->setCellValue('L1' ,'RUTA');
		$activeSheet->setCellValue('M1' ,'ID PROVEEDOR');
		$activeSheet->setCellValue('N1' ,'NOMBRE PROVEEDOR');
		$activeSheet->setCellValue('O1' ,'TARIFA');
		$activeSheet->setCellValue('P1' ,'IVA');
		$activeSheet->setCellValue('Q1' ,'TUA');
		$activeSheet->setCellValue('R1' ,'OTROS IMPUESTOS');
		$activeSheet->setCellValue('S1' ,'VENDEDOR');
		$activeSheet->setCellValue('T1' ,'CONCEPTO');
		$activeSheet->setCellValue('U1' ,'IMPORTE');
		$activeSheet->setCellValue('V1' ,'ID SERVICIO');
		$activeSheet->setCellValue('W1','GVC DESCRIPCION EXTENDIDA');
		
		
		$rep = [];
		foreach($allrows as $value) {

    		$value = (array)$value;
    		array_push($rep, $value);  
		
		}

		$spreadsheet->getActiveSheet()
			    ->getStyle('O2:O'.((count($rep)) + 1))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		$spreadsheet->getActiveSheet()
			    ->getStyle('P2:P'.((count($rep)) + 1))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	    $spreadsheet->getActiveSheet()
			    ->getStyle('Q2:Q'.((count($rep)) + 1))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	    $spreadsheet->getActiveSheet()
			    ->getStyle('R2:R'.((count($rep)) + 1))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	    $spreadsheet->getActiveSheet()
			    ->getStyle('U2:U'.((count($rep)) + 1))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$activeSheet->fromArray(
	        $rep,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A2'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

	    																												
		//$activeSheet->removeColumnByIndex(2);

    	ob_start();
		$Excel_writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();
		 
		$opResult = array(
				'str_fecha'=> '',
		        'status' => 1,
		        'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
		     );

    	echo json_encode($opResult);

	  
	}

	

	
	
}
