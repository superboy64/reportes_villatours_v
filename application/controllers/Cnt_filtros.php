<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_filtros extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
		  $this->load->model('Reportes/Mod_reportes_gastos_gen');
		  $this->load->model('Mod_catalogos_filtros');

	}

	public function obtener_filtros()
	{
		
		$id_reporte = $this->input->post("id_reporte");
		$rest = $this->Mod_filtros->obtener_filtros($id_reporte);
		echo json_encode($rest);
		
	}

	public function obtener_filtros_correos_aut(){
		
		$id_reporte = $this->input->post("id_reporte");
		$id_correo_automatico = $this->input->post("id_correo_automatico");
		$this->Mod_correos->cambiar_status_correo($id_correo_automatico);
		$rest = $this->Mod_filtros->obtener_filtros_correos_aut($id_correo_automatico);	
		
	    echo json_encode($rest);
					    
	}

	public function get_filtros(){

		$id_reporte = $this->input->post("id_reporte");

		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio();
		$rest_catalogo_id_servicio_aereo = $this->Mod_catalogos_filtros->get_catalogo_id_servicio_aereo();
		$rest_catalogo_id_provedor = $this->Mod_catalogos_filtros->get_catalogo_id_provedor();
		$rest_catalogo_metodo_pago = $this->Mod_catalogos_filtros->get_catalogo_metodo_pago();

		$id_us = $this->session->userdata('session_id');

		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,$id_reporte);

		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param2['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
	    $param2["rest_catalogo_series"] = $rest_catalogo_series;
	    $param2["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param2["rest_catalogo_id_servicio"] = $rest_catalogo_id_servicio;
	    $param2["rest_catalogo_id_servicio_aereo"] = $rest_catalogo_id_servicio_aereo;
	    $param2["rest_catalogo_id_provedor"] = $rest_catalogo_id_provedor;
	    $param2["rest_catalogo_metodo_pago"] = $rest_catalogo_metodo_pago;
	    $param2["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param2["rest_clientes"] = $rest_clientes;

		$this->load->view('Filtros/view_filtros',$param2);


	}

	public function get_filtros_temp(){

		$id_usuario = $this->session->userdata('session_id');
		$id_reporte = $this->input->post('id_reporte');
		
		$rest = $this->Mod_filtros->get_filtros_temp($id_usuario,$id_reporte);
		$rest = $rest[0]; 

		echo json_encode($rest);

	}

	public function get_filtros_temp_edicion(){

		$id_reporte = $this->input->post('id_reporte');
		$id_correo_aut = $this->input->post('id_correo_aut');



		$rest = $this->Mod_filtros->get_filtros_temp_edicion($id_correo_aut,$id_reporte);
		//echo json_encode($rest);

		if(count($rest) > 0){
			
			$array_filtros = explode("/XX", $rest[0]['filtro_rep']);

			$array_filtros=array_filter($array_filtros, "strlen");

			$array_string_filtro = [];

		    foreach ($array_filtros as $clave => $valor) {

				$filtro = explode("___", $valor);
	            $array_string_filtro[$filtro[0]] = $filtro[1];

	            
	        }

	        echo json_encode($array_string_filtro);

		}else{

			echo json_encode([]);

		}


	}

	public function guardar_filtro_temp(){

		$array_filtro = $this->input->post('array_filtro');
		$id_reporte = $this->input->post('id_reporte');
		$id_usuario = $this->session->userdata('session_id');

		$this->Mod_filtros->guardar_filtro_temp($array_filtro,$id_reporte,$id_usuario);
		
		
	}



}
