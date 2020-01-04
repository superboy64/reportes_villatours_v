<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';

class Cnt_layouts_egencia_segments_cadena extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_egencia_segments_cadena');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_ciudades');
	      $this->Mod_general->get_SPID();
	     
	}

	public function get_html_layouts_egencia_segments(){

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

		$this->load->view('Layouts/view_lay_egencia_segments');
		
	}
	

	public function get_layouts_egencia_data_import_sp_parametros(){

		$parametros = $_REQUEST["parametros"];
        $tipo_funcion = $_REQUEST['tipo_funcion'];  //falta
		$parametros = explode(",", $parametros);
		       
		$this->get_layouts_egencia_data_import_sp($parametros,$tipo_funcion);

		

	}


	public function get_layouts_egencia_data_import_sp($parametros,$tipo_funcion){
		  
		  $id_us = $this->session->userdata('session_id');
		  $rest = $this->Mod_layouts_egencia_segments_cadena->get_layouts_egencia_data_import_sp($id_us);

		  $param_final['rep'] = $rest['array_nuevo_formato'];
		  $param_final['log'] = $rest['msn'];


	       if($tipo_funcion == 'ex'){

	       		$this->genera_txt($param_final);
	       		echo json_encode($param_final);
	     
	       }else{

	       		echo json_encode($param_final);

	       }
			   

    } //fin de la funcion


    public function genera_txt($param_final){

		$allrows = $param_final;
		
		$id_us = $this->session->userdata('session_id');

		$archivo = fopen($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/archivos_egencia_lay_data_import_sp/segments_'.$id_us.'.txt', "w+");
		
		$header = ['SegmentID', 'Link_Key','BookingID','DocumentNumber','Leg','AirlineCode','DepartCityCode','DepartDate','DepartTime','FlightNumber','ArriveCityCode','ArriveDate','ArriveTime','ConnectionCode','FareBasis','SegmentFare','Class','TicketDesignator','Mileage','SeatAssignment','EquipmentType'];

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

    public function exportar_txt_lay_egencia_data_import_sp(){

    	$id_us = $this->session->userdata('session_id');
	    header("Content-type: .txt");
	    header('Content-Disposition: attachment;filename=segments_'.$id_us.'.txt');
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	 
	    set_time_limit(0);
	    readfile($_SERVER['DOCUMENT_ROOT'].'\reportes_villatours_v\referencias\archivos\archivos_egencia_lay_data_import_sp\segments_'.$id_us.'.txt');

	}



}
