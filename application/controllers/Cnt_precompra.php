<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_precompra extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_precompra');
	}

	public function get_html_precompra()
	{

		$title = $this->input->post('title');
		
	    $param['title'] = $title;
 		
 		$id_us = $this->session->userdata('session_id');
 		$rest = $this->Mod_precompra->get_catalogo_precompra($id_us);

 		$param2['plantillas'] = $rest;

	    $this->load->view('Filtros/view_filtros',$param2);
		$this->load->view('Precompra/view_precompra',$param);
		
	}

	public function get_html_actualizar_precompra(){

		$row_precompra = $this->input->post('row_precompra');

	    $param["row_precompra"] = $row_precompra;

		$this->load->view('Precompra/view_actualizar_precompra',$param);

	}

	public function get_catalogo_precompra(){

		$parametros = $this->input->post('parametros');
		
		$rest = $this->Mod_precompra->get_catalogo_precompra_filtros($parametros);
		
		echo json_encode($rest);


	}

	public function get_html_agregar_precompra(){

		//$reportes = $this->Mod_precompra->get_catalogo_reportes();
	    $param["reportes"] = ''; //$reportes;
	    $this->load->view('Precompra/view_agregar_precompra',$param);

	}

	public function guardar_precompra(){

		$arr_cli = $this->input->post('arr_cli');
		$arr_rangos_cli = $this->input->post('arr_rangos_cli');
		$id_sucursal  = $this->session->userdata('session_id_sucursal');
		
		$rest = $this->Mod_precompra->guardar_precompra($arr_cli,$arr_rangos_cli,$id_sucursal);
		
		echo json_encode($rest);


	}

	public function guardar_edicion_precompra(){

		$id_cliente = $this->input->post('id_cliente');
		$id_precompra = $this->input->post('id_precompra');
		$arr_rangos_cli = $this->input->post('arr_rangos_cli');
		$id_sucursal  = $this->session->userdata('session_id_sucursal');
		
		$rest = $this->Mod_precompra->guardar_edicion_precompra($id_cliente,$id_precompra,$arr_rangos_cli,$id_sucursal);
		
		echo json_encode($rest);


	}
	
	public function eliminar_precompra(){

		$id_precompra = $this->input->post('id_precompra');
		$rest = $this->Mod_precompra->eliminar_precompra($id_precompra);
		echo json_encode($rest);


	}

	public function get_columnas_seleccionadas(){

		$id_plantilla = $this->input->post('id_plantilla');
		$id_rep = $this->input->post('id_rep');
		$id_us = $this->input->post('id_us');

		$rest = $this->Mod_precompra->get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us);
		  
		echo json_encode($rest);


	}


}
