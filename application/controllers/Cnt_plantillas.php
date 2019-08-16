<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_plantillas extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_plantillas');
	}

	public function get_html_plantillas()
	{

		$title = $this->input->post('title');
		
	    $param['title'] = $title;
 		
 		$id_us = $this->session->userdata('session_id');
 		$rest = $this->Mod_plantillas->get_catalogo_plantillas($id_us);

 		$param2['plantillas'] = $rest;

	    $this->load->view('Filtros/view_filtros',$param2);
		$this->load->view('Plantillas/view_plantillas',$param);
		
	}

	public function get_html_actualizar_plantilla(){

		$reportes = $this->Mod_plantillas->get_catalogo_reportes();
	    $param["reportes"] = $reportes;
		$this->load->view('Plantillas/view_actualizar_plantillas',$param);

	}

	public function get_catalogo_plantillas(){

		$parametros = $this->input->post('parametros');
		$status = $this->input->post('status');
		$id_us = $this->session->userdata('session_id');

		$rest = $this->Mod_plantillas->get_catalogo_plantillas_filtros($parametros,$status,$id_us);
		  
		echo json_encode($rest);


	}

	public function get_columnas_not_in_plantilla(){

		$ids_selec = $this->input->post('ids_selec');
		$id_rep = $this->input->post('id_rep');

		$rest = $this->Mod_plantillas->get_columnas_not_in_plantilla($ids_selec,$id_rep);
		  
		echo json_encode($rest);


	}

	

	public function get_html_agregar_plantilla(){

		$reportes = $this->Mod_plantillas->get_catalogo_reportes();
	    $param["reportes"] = $reportes;
	    $this->load->view('Plantillas/view_agregar_plantilla',$param);

	}

	public function mostrar_cloumnas(){

		$id_rep = $this->input->post('id_rep');

		$rest = $this->Mod_plantillas->get_columnas_plantillas($id_rep);
		  
		echo json_encode($rest);


	}

	public function get_columnas_plantillas_url(){

		$id_rep = $this->input->get('id_rep');

		$rest = $this->Mod_plantillas->get_columnas_plantillas($id_rep);
		  
		echo json_encode($rest);


	}

	public function get_columnas_seleccionadas(){

		$id_plantilla = $this->input->post('id_plantilla');
		$id_rep = $this->input->post('id_rep');
		$id_us = $this->input->post('id_us');

		$rest = $this->Mod_plantillas->get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us);
		  
		echo json_encode($rest);

	}

	public function guardar_plantilla(){

		$nombre = $this->input->post('nombre');
		$id_reporte = $this->input->post('id_reporte');
		$arr_col = $this->input->post('arr_col');
		$id_us = $this->session->userdata('session_id');
		$id_sucursal = $this->session->userdata('session_id_sucursal'); 

		$rest = $this->Mod_plantillas->guardar_plantilla($nombre,$id_reporte,$arr_col,$id_us,$id_sucursal);
		
		echo json_encode($rest);


	}

	public function guardar_plantilla_edicion(){


		$id_plan = $this->input->post('id_plan');
		$nombre = $this->input->post('nombre');
		$id_reporte = $this->input->post('id_reporte');
		$arr_col = $this->input->post('arr_col');
		$id_sucursal  = $this->session->userdata('session_id_sucursal');
		
		$rest = $this->Mod_plantillas->guardar_plantilla_edicion($id_plan,$nombre,$id_reporte,$arr_col,$id_sucursal);
		


		echo json_encode($rest);



	}

	public function eliminar_plantilla(){

		$id_plantilla = $this->input->post('id_plantilla');
		$rest = $this->Mod_plantillas->eliminar_plantilla($id_plantilla);
		echo json_encode($rest);


	}


}
