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

class Cnt_layouts_CFDI extends CI_Controller {

	public function __construct()
	{

	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_CFDI');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      
	}
    
    public function get_html_layouts_CFDI(){

    	$title = $this->input->post('title');

		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();

		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();

		//$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio_CFDI();
		
		$rest_catalogo_id_servicio_CFDI = $this->Mod_catalogos_filtros->get_catalogo_id_provedor_CFDI();
		
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,4);

		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_catalogos_filtros->get_catalogo_clientes_CFDI($id_perfil);

		$param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    //$param["rest_catalogo_id_servicio_CFDI"] = $rest_catalogo_id_servicio;
	    $param["rest_catalogo_id_servicio_local"] = $rest_catalogo_id_servicio_CFDI;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Layouts/view_lay_CFDI');

	}

	public function get_catalogo_aereolineas_CFDI(){

		$slc_select_cat_provedor = $this->input->post("slc_select_cat_provedor");
		
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_tipo_aereolinea_CFDI($slc_select_cat_provedor);

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

    public function get_lay_CFDI(){

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

		$rep = $this->lay_CFDI($parametros,$cat_provedor);

		$param_final['rep'] = $rep;
		
		echo json_encode($param_final);

	}

	public function lay_CFDI($parametros,$cat_provedor){
		
	    $rest = $this->Mod_layouts_CFDI->lay_CFDI($parametros,$cat_provedor);
	  	
	    $array1 = array();

	    $rep = [];
		foreach($rest as $value) {

			  $value["analisis39_cliente"] = $this->sanear_string(utf8_encode($value["analisis39_cliente"]));
		      $value["confirmacion_la"] = $this->sanear_string(utf8_encode($value["confirmacion_la"]));
		      $value["id_cliente"] = $this->sanear_string(utf8_encode($value["id_cliente"]));
		      $value["GVC_DOC_NUMERO"] = $this->sanear_string(utf8_encode($value["GVC_DOC_NUMERO"]));
		      $value["ID_PROVEEDOR"] = $this->sanear_string(utf8_encode($value["ID_PROVEEDOR"]));
		      $value["BOLETO"] = $this->sanear_string(utf8_encode($value["BOLETO"]));
		      $value["BOLETO_ORIGINAL"] = $this->sanear_string(utf8_encode($value["BOLETO"]));
		      $value["FECHA_EMISION_BOLETO"] = $this->sanear_string(utf8_encode($value["FECHA_EMISION_BOLETO"]));
		      $value["IATA"] = $this->sanear_string(utf8_encode($value["IATA"]));
		      $value["NOM_PAX"] = $this->sanear_string(utf8_encode($value["NOM_PAX"]));
		      $value["rfc_cliente"] = $this->sanear_string(utf8_encode($value["rfc_cliente"]));
		      $value["razon_social"] = $this->sanear_string(utf8_encode($value["razon_social"]));
		      $value["calle"] = $this->sanear_string(utf8_encode($value["calle"]));
		      $value["no_ext_cliente"] = $this->sanear_string(utf8_encode($value["no_ext_cliente"]));
		      $value["no_int_cliente"] = $this->sanear_string(utf8_encode($value["no_int_cliente"]));
		      $value["colonia_cliente"] = $this->sanear_string(utf8_encode($value["colonia_cliente"]));
		      $value["MUNICIPIO"] = $this->sanear_string(utf8_encode($value["MUNICIPIO"]));
		      $value["codigo_postal"] = $this->sanear_string(utf8_encode($value["codigo_postal"]));
		      $value["LOCALIDAD"] = $this->sanear_string(utf8_encode($value["LOCALIDAD"]));
		      $value["ESTADO"] = $this->sanear_string(utf8_encode($value["ESTADO"]));
		      $value["PAIS"] = $this->sanear_string(utf8_encode($value["PAIS"]));
		      $value["ID_FORMA_PAGO"] = $this->sanear_string(utf8_encode($value["ID_FORMA_PAGO"]));
		      $value["MONTO_TOTAL"] = $this->sanear_string(utf8_encode($value["MONTO_TOTAL"]));
		      $value["USO_CFDI"] = $this->sanear_string(utf8_encode($value["USO_CFDI"]));

				$id_cliente = $value["id_cliente"];
				$ID_PROVEEDOR = $value["ID_PROVEEDOR"];

				$MONTO_TOTAL = $value["MONTO_TOTAL"];

				if($MONTO_TOTAL == 0.000000){

					$value["MONTO_TOTAL"] = '';

				}
			
				$conf_cliente = $this->Mod_layouts_CFDI->get_config_cliente_CFDI($id_cliente);	
				$conf_aereolinea = $this->Mod_layouts_CFDI->get_config_aereolinea_CFDI($ID_PROVEEDOR);

				if(count($conf_cliente) > 0 ){

					$tpo_factura = $conf_cliente[0]->tpo_factura;

					if($tpo_factura == '2'){
				  
						  $value["rfc_cliente"] = 'VTO791024C79';  
						  $value["razon_social"] = 'VILLA TOURS, S.A. DE C.V.';  
						  $value["calle"] = 'RAYON SUR';  
						  $value["no_ext_cliente"] = '534';  
						  $value["no_int_cliente"] = '';  
						  $value["colonia_cliente"] = 'CENTRO';  
						  $value["MUNICIPIO"] = 'MONTERREY';  
						  $value["codigo_postal"] = '64000';  
						  $value["LOCALIDAD"] = 'MONTERREY';  
						  $value["ESTADO"] = 'NUEVO LEON';  
						  $value["PAIS"] = 'MEXICO';  

					}

				}

				$rfc_cl = $value["rfc_cliente"];

				$value["rfc_cliente"] = str_replace(" ", "", $rfc_cl);
				
				$value["CLAVE_AEROLINEA"] = '000';

			    if(count($conf_aereolinea) > 0 ){

			    	$value["CLAVE_AEROLINEA"] = $conf_aereolinea[0]->codigo_timbre;

					$codigo_numerico = $conf_aereolinea[0]->codigo_numerico;
					$value["ID_PROVEEDOR"] = $codigo_numerico;

					$bajo_costo = $conf_aereolinea[0]->bajo_costo;

					if($bajo_costo == 1){

						if($value["confirmacion_la"] != '' || $value["confirmacion_la"] != null){

							$value["BOLETO"] = $value["confirmacion_la"];

						}else{

							if($value["analisis39_cliente"] != '' || $value["analisis39_cliente"] != null){

								$value["BOLETO"] = $value["analisis39_cliente"];

							}else{

								$value["BOLETO"] = "";

							}

						}


					}else{

						$value["BOLETO"] = $value["CLAVE_AEROLINEA"].$value["BOLETO"];

					}


				}


			
			if($ID_PROVEEDOR == '4O'){

				$value["ID_FORMA_PAGO"] = '04';
			}

			$NOM_PAX = $value["NOM_PAX"];
			$apellido = "";
			$nombre = "";

			if(strlen($NOM_PAX) != '0'){

				$NOM_PAX = explode('/', $NOM_PAX);

				for($x=0;$x<count($NOM_PAX);$x++){

					if($x == 0){
						$apellido = $NOM_PAX[0];
					}
					if($x == 1){
						$nombre = $NOM_PAX[1];
					}

				}

			}

			$value["apellido"] = $apellido;
			$value["nombre"] = $nombre;


    		$cast_utf8 = array_map("utf8_encode", $value );

    		array_push($array1, $cast_utf8);
		   
		}

	    return $array1;

	}

	public function get_lay_CFDI_aereomexico(){

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

		$rep = $this->lay_CFDI_aereomexico($parametros,$cat_provedor);

		$param_final['rep'] = $rep;
		
		echo json_encode($param_final);



	}

	function lay_CFDI_aereomexico($parametros,$cat_provedor){

		$rest = $this->Mod_layouts_CFDI->lay_CFDI_aereomexico($parametros,$cat_provedor);
	  	
	    $array1 = array();

	    $rep = [];
		foreach($rest as $value) {
			
			$id_cliente = $value["id_cliente"];
			$ID_PROVEEDOR = $value["ID_PROVEEDOR"];

			$conf_cliente = $this->Mod_layouts_CFDI->get_config_cliente_CFDI($id_cliente);
			$conf_aereolinea = $this->Mod_layouts_CFDI->get_config_aereolinea_CFDI($ID_PROVEEDOR);

			if(count($conf_cliente) > 0 ){

				$tpo_factura = $conf_cliente[0]->tpo_factura;
					
				if($tpo_factura == '2'){

				  $value["rfc_emisor"] = 'VTO791024C79';
				  $value["razon_social"] = 'VILLA TOURS, S.A. DE C.V.';
				  $value["ID_PROVEEDOR"] = '139';
				  $value["GVC_NOMBRE_PROVEEDOR"] = 'AEROMEXICO';
				  $value["nombre_cliente"] = 'VILLA TOURS, S.A. DE C.V.';
				  $value["rfc_cliente"] = 'VTO791024C79';
				  $value["calle"] = 'RAYON SUR';
				  $value["no_ext_cliente"] = '534';
				  $value["no_int_cliente"] = '';
				  $value["colonia_cliente"] = 'CENTRO';
				  $value["MUNICIPIO"] = 'MONTERREY';
				  $value["CIUDAD"] = 'MONTERREY';
				  $value["ESTADO"] = 'NUEVO LEON';
				  $value["PAIS"] = 'MEXICO';
				  $value["codigo_postal"] = '64000';

				}

			}

			if(count($conf_aereolinea) > 0 ){

				$codigo_numerico = $conf_aereolinea[0]->codigo_numerico;
				$value["ID_PROVEEDOR"] = $codigo_numerico;

			}

    		$cast_utf8 = array_map("utf8_encode", $value );

    		array_push($array1, $cast_utf8);
		    
		}

	    return $array1;

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


		$activeSheet->setCellValue('A1' ,'CLAVE AEROLINEA');
		$activeSheet->setCellValue('B1' ,'NUMERO BOLETO');
		$activeSheet->setCellValue('C1' ,'FECHA EMISION');
		$activeSheet->setCellValue('D1' ,'IATA');
		$activeSheet->setCellValue('E1' ,'PAX NOMBRE');
		$activeSheet->setCellValue('F1' ,'PAX APELLIDOS');
		$activeSheet->setCellValue('G1' ,'RFC');
		$activeSheet->setCellValue('H1' ,'RAZON SOCIAL');
		$activeSheet->setCellValue('I1' ,'CALLE');
		$activeSheet->setCellValue('J1' ,'NO EXT');
		$activeSheet->setCellValue('K1' ,'NO INT');
		$activeSheet->setCellValue('L1' ,'COLONIA');
		$activeSheet->setCellValue('M1' ,'MUNICIPIO');
		$activeSheet->setCellValue('N1' ,'CP');
		$activeSheet->setCellValue('O1' ,'LOCALIDAD');
		$activeSheet->setCellValue('P1' ,'ESTADO');
		$activeSheet->setCellValue('Q1' ,'PAIS');
		$activeSheet->setCellValue('R1' ,'ID FORMA PAGO');
		$activeSheet->setCellValue('S1' ,'MONTO TOTAL');
		$activeSheet->setCellValue('T1' ,'USO CFDI');

		$rep = [];
		foreach($allrows as $value) {

    		/*$value = (array)$value;*/
   
            $campos['CLAVE_AEROLINEA'] = $value->CLAVE_AEROLINEA;
            //$campos['BOLETO_ORIGINAL'] = $value->BOLETO_ORIGINAL;
            $campos['BOLETO'] = $value->BOLETO;
            $campos['FECHA_EMISION_BOLETO'] = $value->FECHA_EMISION_BOLETO;
            $campos['IATA'] = $value->IATA;
            $campos['nombre'] = $value->nombre;
            $campos['apellido'] = $value->apellido;
            $campos['rfc_cliente'] = $value->rfc_cliente;
            $campos['razon_social'] = $value->razon_social;
            $campos['calle'] = $value->calle;
            $campos['no_ext_cliente'] = $value->no_ext_cliente;
            $campos['no_int_cliente'] = $value->no_int_cliente;
            $campos['colonia_cliente'] = $value->colonia_cliente;
            $campos['MUNICIPIO'] = $value->MUNICIPIO;
            $campos['codigo_postal'] = $value->codigo_postal;
            $campos['LOCALIDAD'] = $value->LOCALIDAD;
            $campos['ESTADO'] = $value->ESTADO;
            $campos['PAIS'] = $value->PAIS;
            $campos['ID_FORMA_PAGO'] = $value->ID_FORMA_PAGO;
            $campos['MONTO_TOTAL'] = $value->MONTO_TOTAL;
            $campos['USO_CFDI'] = $value->USO_CFDI;



    		array_push($rep, $campos);  
		
		}

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

	public function exportar_excel_ae(){

		$allrows = $this->input->post("allrows");
		$allrows = json_decode($allrows);
		
		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}


		$activeSheet->setCellValue('A1' ,'NO ETICKET /PNR');
		$activeSheet->setCellValue('B1' ,'RFC');
		$activeSheet->setCellValue('C1' ,'NOMBRE /RAZÓN SOCIAL');
		$activeSheet->setCellValue('D1' ,'CÓDIGO POSTAL');
		$activeSheet->setCellValue('E1' ,'REFERENCIA');
		$activeSheet->setCellValue('F1' ,'NOMBRE ARCHIVO');
		$activeSheet->setCellValue('G1' ,'CORREO ELECTRÓNICO');
		


		$rep = [];
		foreach($allrows as $value) {

    		//$value = (array)$value;
   			
   			$campos["pnr"] = $value->pnr;
   			$campos["rfc_emisor"] = $value->rfc_cliente;
			$campos["razon_social"] = $value->razon_social;
			$campos["codigo_postal"] = $value->codigo_postal;
			$campos["referencia"] = '';
			$campos["nombre_archivo"] = '';
			$campos["CORREO_ELECTRONICO"] = $value->CORREO_ELECTRONICO;


    		array_push($rep, $campos);  
		
		}

		$activeSheet->fromArray(
	        $rep,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A2'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );
		

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

	
	public function exportar_txt_lay_CFDI(){

	    header("Content-type: .txt");
	    header("Content-Disposition: attachment;filename=MEX_EBTA_TPP_PI6VIL.txt");
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	 
	    set_time_limit(0); 
	    readfile($_SERVER['DOCUMENT_ROOT'].'\reportes_villatours\referencias\archivos\archivos_CFDI\MEX_EBTA_TPP_PI6VIL.txt');

	}

	
	
}
