<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_aereolineas_CFDI extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_aereolineas_CFDI');
	      $this->load->model('Mod_catalogos_filtros');
	}

	public function get_html_aereolineas_CFDI()
	{

		$title = $this->input->post('title');
 		$param['title'] = $title;


		$this->load->view('Aereolineas_CFDI/view_aereolineas_CFDI',$param);
		
	}

	public function get_html_actualizar_aereolinea_CFDI(){

		$row_aereolinea = $this->input->post('row_aereolinea');

	    $param["row_aereolinea"] = $row_aereolinea;

		$this->load->view('Aereolineas_CFDI/view_actualizar_aereolineas_CFDI',$param);

	}

	public function get_catalogo_aereolineas_amex(){

		$rest_catalogo_id_aereolinea = $this->Mod_catalogos_filtros->get_catalogo_id_provedor();

		$array1 = [];

		foreach ($rest_catalogo_id_aereolinea as $key => $value) {
			
			$value["id_proveedor"] = utf8_encode($value["id_proveedor"]);
			$value["nombre"] = utf8_encode($value["nombre"]);

			array_push($array1, $value);

		}

		echo json_encode($array1);

	}

	public function get_catalogo_aereolineas_CFDI_local(){

		$rest_catalogo_id_aereolinea = $this->Mod_aereolineas_CFDI->get_catalogo_aereolineas_CFDI_local();

		$array1 = [];

		foreach ($rest_catalogo_id_aereolinea as $key => $value) {
			
			$value["id_aereolinea"] = utf8_encode($value["id_aereolinea"]);
			$value["nombre_aereolinea"] = utf8_encode($value["nombre_aereolinea"]);

			array_push($array1, $value);

		}

		echo json_encode($array1);


	}

	public function get_aereolineas_amex_not_in(){

		$rows_aereolineas_selec = $this->input->post('rows_aereolineas_selec');
		
		$rest_catalogo_id_aereolinea = $this->Mod_aereolineas_CFDI->get_aereolineas_amex_not_in($rows_aereolineas_selec);

		echo json_encode($rest_catalogo_id_aereolinea);


	}

	public function get_html_agregar_aereolinea_CFDI(){

		//$reportes = $this->Mod_aereolineas_CFDI->get_catalogo_reportes();
	    $param["reportes"] = ''; //$reportes;
	    $this->load->view('Aereolineas_CFDI/view_agregar_aereolineas_CFDI',$param);

	}


	public function guardar_aereolinea_CFDI(){

		$arr_prov = $this->input->post('arr_prov');
		$slc_cat_aereolinea = $this->input->post('slc_cat_aereolinea');
		$slc_cat_cuenta = $this->input->post('slc_cat_cuenta');
		$txt_CODIGO_NUMERICO = $this->input->post('txt_CODIGO_NUMERICO');
		$txt_CODIGO_TIMBRE = $this->input->post('txt_CODIGO_TIMBRE');
		
		$rest = $this->Mod_aereolineas_CFDI->guardar_aereolinea_CFDI($arr_prov,$slc_cat_aereolinea,$slc_cat_cuenta,$txt_CODIGO_NUMERICO,$txt_CODIGO_TIMBRE);
		
		echo json_encode($rest);



	}

	public function guardar_actualizacion_aereolineas_CFDI(){

		
		$slc_cat_aereolinea_edit = $this->input->post('slc_cat_aereolinea_edit');
		$slc_cat_cuenta_edit = $this->input->post('slc_cat_cuenta_edit');
		$hidden_aereolinea_edit = $this->input->post('hidden_aereolinea_edit');
		$txt_CODIGO_NUMERICO_edit = $this->input->post('txt_CODIGO_NUMERICO_edit');
		$txt_CODIGO_TIMBRE_edit = $this->input->post('txt_CODIGO_TIMBRE_edit');
		
		$rest = $this->Mod_aereolineas_CFDI->guardar_actualizacion_aereolineas_CFDI($slc_cat_aereolinea_edit,$slc_cat_cuenta_edit,$hidden_aereolinea_edit,$txt_CODIGO_NUMERICO_edit,$txt_CODIGO_TIMBRE_edit);

		echo json_encode($rest);

	}
	
	public function eliminar_aereolinea_CFDI(){

		$id = $this->input->post('id');
		$rest = $this->Mod_aereolineas_CFDI->eliminar_aereolinea_CFDI($id);
		echo json_encode($rest);


	}

	public function get_columnas_seleccionadas(){

		$id_plantilla = $this->input->post('id_plantilla');
		$id_rep = $this->input->post('id_rep');
		$id_us = $this->input->post('id_us');

		$rest = $this->Mod_aereolineas_CFDI->get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us);
		  
		echo json_encode($rest);


	}


}
