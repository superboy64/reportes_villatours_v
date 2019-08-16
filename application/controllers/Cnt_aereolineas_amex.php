<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_aereolineas_amex extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_aereolineas_amex');
	      $this->load->model('Mod_catalogos_filtros');
	}

	public function get_html_aereolineas_amex()
	{

		$title = $this->input->post('title');
 		$param['title'] = $title;


		$this->load->view('Aereolineas_amex/view_aereolineas_amex',$param);
		
	}

	public function get_html_actualizar_aereolinea_amex(){

		$row_aereolinea = $this->input->post('row_aereolinea');

	    $param["row_aereolinea"] = $row_aereolinea;

		$this->load->view('Aereolineas_amex/view_actualizar_aereolineas_amex',$param);

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

	public function get_catalogo_aereolineas_amex_local(){

		$rest_catalogo_id_aereolinea = $this->Mod_aereolineas_amex->get_catalogo_aereolineas_amex_local();

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
		
		$rest_catalogo_id_aereolinea = $this->Mod_aereolineas_amex->get_aereolineas_amex_not_in($rows_aereolineas_selec);

		$array1 = [];

		foreach ($rest_catalogo_id_aereolinea as $key => $value) {

			$value["id_proveedor"] = utf8_encode($value["id_proveedor"]);
			$value["nombre"] = utf8_encode($value["nombre"]);

			array_push($array1, $value);

		}

		echo json_encode($array1);


	}

	public function get_html_agregar_aereolinea_amex(){

		//$reportes = $this->Mod_aereolineas_amex->get_catalogo_reportes();
	    $param["reportes"] = ''; //$reportes;
	    $this->load->view('Aereolineas_amex/view_agregar_aereolineas_amex',$param);

	}

	public function guardar_aereolinea_amex(){

		$arr_prov = $this->input->post('arr_prov');
		$slc_cat_aereolinea = $this->input->post('slc_cat_aereolinea');
		$txt_CODIGO_BSP = $this->input->post('txt_CODIGO_BSP');
		$rad_cambio_prov = $this->input->post('rad_cambio_prov');
		
		$rest = $this->Mod_aereolineas_amex->guardar_aereolinea_amex($arr_prov,$slc_cat_aereolinea,$txt_CODIGO_BSP,$rad_cambio_prov);
		
		echo json_encode($rest);


	}

	public function guardar_actualizacion_aereolineas_amex(){

		$slc_cat_aereolinea_edit = $this->input->post('slc_cat_aereolinea_edit');
		$hidden_aereolinea_edit = $this->input->post('hidden_aereolinea_edit');
		$txt_CODIGO_BSP_edit = $this->input->post('txt_CODIGO_BSP_edit');
		$rad_cambio_prov_edit = $this->input->post('rad_cambio_prov_edit');

		$rest = $this->Mod_aereolineas_amex->guardar_actualizacion_aereolineas_amex($slc_cat_aereolinea_edit,$hidden_aereolinea_edit,$txt_CODIGO_BSP_edit,$rad_cambio_prov_edit);

		echo json_encode($rest);

	}

	
	public function eliminar_aereolinea_amex(){

		$id = $this->input->post('id');
		$rest = $this->Mod_aereolineas_amex->eliminar_aereolinea($id);
		echo json_encode($rest);


	}

	public function get_columnas_seleccionadas(){

		$id_plantilla = $this->input->post('id_plantilla');
		$id_rep = $this->input->post('id_rep');
		$id_us = $this->input->post('id_us');

		$rest = $this->Mod_aereolineas_amex->get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us);
		  
		echo json_encode($rest);


	}


}
