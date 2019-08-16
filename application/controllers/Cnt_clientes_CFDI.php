<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_clientes_CFDI extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_clientes_CFDI');
	}

	public function get_html_clientes_CFDI()
	{

		$title = $this->input->post('title');
	    $param['title'] = $title;
 
		$this->load->view('Clientes_CFDI/view_clientes_CFDI',$param);
		
	}

	public function get_html_actualizar_clientes_CFDI(){
		
		$row_clientes_CFDI = $this->input->post('row_clientes_CFDI');
		
	    $param["row_clientes_CFDI"] = $row_clientes_CFDI;
	    
		$this->load->view('Clientes_CFDI/view_actualizar_clientes_CFDI',$param);
		
	}

	public function get_catalogo_clientes_CFDI(){

		$parametros = $this->input->post('parametros');
		
		$rest = $this->Mod_clientes_CFDI->get_catalogo_clientes_CFDI_filtros($parametros);

		echo json_encode($rest);

	}

	public function get_html_agregar_clientes_CFDI(){

		//$reportes = $this->Mod_clientes_CFDI->get_catalogo_reportes();
	    $param["reportes"] = ''; //$reportes;
	    $this->load->view('Clientes_CFDI/view_agregar_clientes_CFDI',$param);

	}

	public function guardar_cliente_CFDI(){

		$arr_cli = $this->input->post('arr_cli');
		$tpo_factura = $this->input->post('tpo_factura');
		
		$rest = $this->Mod_clientes_CFDI->guardar_cliente_CFDI($arr_cli,$tpo_factura);
		
		echo json_encode($rest);


	}
	
	public function eliminar_cliente_CFDI(){

		$id_cliente_CFDI = $this->input->post('id_cliente_CFDI');

		$rest = $this->Mod_clientes_CFDI->eliminar_cliente_CFDI($id_cliente_CFDI);
		echo json_encode($rest);


	}

	public function guardar_actualizacion_clientes_CFDI(){

		$tpo_factura = $this->input->post("tpo_factura");
		$id_cliene_CFDI = $this->input->post("id_cliene_CFDI");

		$rest = $this->Mod_clientes_CFDI->guardar_actualizacion_clientes_CFDI($tpo_factura,$id_cliene_CFDI);

		echo json_encode($rest);


	}

	public function get_columnas_seleccionadas(){

		$id_plantilla = $this->input->post('id_plantilla');
		$id_rep = $this->input->post('id_rep');
		$id_us = $this->input->post('id_us');

		$rest = $this->Mod_clientes_CFDI->get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us);
		  
		echo json_encode($rest);


	}


}
