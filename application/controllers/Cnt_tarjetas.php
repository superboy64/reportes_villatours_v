<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_tarjetas extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_tarjetas');
	}

	public function get_html_tarjetas()
	{

		$title = $this->input->post('title');
	    $param['title'] = $title;
 
		$this->load->view('Tarjetas/view_tarjetas',$param);
		
	}

	public function get_html_actualizar_tarjetas(){
		
		$row_tarjeta = $this->input->post('row_tarjeta');
		
	    $param["row_tarjeta"] = $row_tarjeta;
	    
		$this->load->view('Tarjetas/view_actualizar_tarjetas',$param);
		
	}

	public function get_catalogo_tarjetas(){

		$parametros = $this->input->post('parametros');
		
		$rest = $this->Mod_tarjetas->get_catalogo_tarjetas_filtros($parametros);

		$rest_new = [];

		foreach ($rest as $clave => $valor) {

				  $num_tarjet = $valor['tarjeta'];

				  $num_tarjet_ini = substr($num_tarjet,0,6); 
				  $num_tarjet_med = 'XXXXXX'; 
				  $num_tarjet_fin = substr($num_tarjet,-4); 

				  $valor['tarjeta'] = $num_tarjet_ini.$num_tarjet_med.$num_tarjet_fin;
	              
	              array_push($rest_new, $valor);
	            
	            }

		echo json_encode($rest_new);

	}

	public function get_html_agregar_tarjetas(){

		//$reportes = $this->Mod_tarjetas->get_catalogo_reportes();
	    $param["reportes"] = ''; //$reportes;
	    $this->load->view('Tarjetas/view_agregar_tarjetas',$param);

	}

	public function guardar_tarjeta(){

		$arr_cli = $this->input->post('arr_cli');
		$num_tarjet = $this->input->post('num_tarjet');
		
		$rest = $this->Mod_tarjetas->guardar_tarjeta($arr_cli,$num_tarjet);
		
		echo json_encode($rest);


	}
	
	public function eliminar_tarjeta(){

		$id_cliente = $this->input->post('id_cliente');

		$rest = $this->Mod_tarjetas->eliminar_tarjeta($id_cliente);
		echo json_encode($rest);


	}

	public function guardar_actualizacion_tarjetas(){

		$num_tarjeta_edit = $this->input->post("num_tarjeta_edit");
		$hidden_cliente_edit = $this->input->post("hidden_cliente_edit");

		$rest = $this->Mod_tarjetas->guardar_actualizacion_tarjetas($num_tarjeta_edit,$hidden_cliente_edit);

		echo json_encode($rest);


	}

	public function get_columnas_seleccionadas(){

		$id_plantilla = $this->input->post('id_plantilla');
		$id_rep = $this->input->post('id_rep');
		$id_us = $this->input->post('id_us');

		$rest = $this->Mod_tarjetas->get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us);
		  
		echo json_encode($rest);


	}


}
