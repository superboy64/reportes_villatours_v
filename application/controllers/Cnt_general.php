<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_general extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_perfiles');
	      //$this->load->library('pruebaclass');
	      
	}

	public function index()
	{

		$this->load->view('header');
		$this->load->view('view_login');
		$this->load->view('footer');

		//echo $this->pruebaclass->prueba();
		
	}

	public function inicio()
	{	

		  if(!$this->session->userdata('session_id')){ //si no existe
		     
		      redirect(base_url()); 

		    }else{

		      $id_perfil = $this->session->userdata('session_id_perfil');
		      $id_us = $this->session->userdata('session_id');
		      $mod = $this->Mod_perfiles->get_catalogo_modulos_perfil($id_perfil);
		      $est = $this->Mod_perfiles->get_estadisticas($id_us);
		    
		      $param['modulos_arr'] = $mod; 
		      $param['estadisticas'] = $est; 

		      $this->load->view('header');
		      $this->load->view('view_inicio',$param);
		      $this->load->view('footer');
		      $this->load->view('script_inicio');

		      $this->permisos_usuario();
			 
		  }

	}

	public function validar_usuario(){

		$usuario = $this->input->post('txt_usuario');
		$password = $this->input->post('txt_password');
		$password = md5($password);

		$rest = $this->Mod_general->validar_usuario($usuario,$password);

		$ipvisitante = $_SERVER["REMOTE_ADDR"];
		if(count($rest) > 0){

			 $this->Mod_general->nuevo_acceso($rest[0]->id,$rest[0]->id_sucursal,$ipvisitante,$usuario,1);
			 $arraydata = array(
                'session_id'  => $rest[0]->id,
                'session_id_sucursal'  => $rest[0]->id_sucursal,
                'session_nombre'  => $rest[0]->nombre,
                'session_usuario' => $rest[0]->usuario,
                'session_password' => $rest[0]->password,
                'session_id_perfil' => $rest[0]->id_perfil,
                'session_fecha_alta' => $rest[0]->fecha_alta,
                'session_status' => $rest[0]->status,
                'session_nom_perfil' => $rest[0]->nom_perfil,
        	 );
        	 
        	 $this->session->set_userdata($arraydata);

			 echo json_encode(1);
			
		}else{

			 $this->Mod_general->nuevo_acceso(0,0,$ipvisitante,$usuario,0);
			 echo json_encode(0);
		}

	}

	public function obtener_todos()
	{
		
		$rest = $this->Mod_general->obtener_todos();
		$this->load->view('welcome_message',$rest);
		
	}

	public function permisos_usuario(){

		//print_r($this->session->userdata());

	}

	public function cerrar_session(){

		$this->session->sess_destroy();

	}

}
