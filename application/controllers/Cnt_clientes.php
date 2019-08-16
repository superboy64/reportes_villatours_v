<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_clientes extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	     
	      $this->load->model('Mod_clientes');

	}

	public function get_clientes_dk(){

		$rest = $this->Mod_clientes->get_clientes_dk();

		$array1 = array();

		    foreach ($rest as $clave => $valor) {
			   
			    	$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);

			    	array_push($array1, $valor);
			    	
			}

			echo json_encode($array1);

	}

	public function get_clientes_dk_perfil(){
		
		$id_per = $this->input->get('id_per');

		$clientes = $this->Mod_clientes->get_clientes_dk_perfil($id_per);

		$array_clientes = array();
		foreach ($clientes as $clave => $valor) {
			 
			    array_push($array_clientes, $valor['id_cliente']);
			   
			}
		
		$clientes = implode(",", $array_clientes);

		$rest = $this->Mod_clientes->get_clientes_dk_perfil_filtrados($clientes);

		$array1 = array();

		    foreach ($rest as $clave => $valor) {
			   
			    	$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);

			    	array_push($array1, $valor);
			   
			}

			echo json_encode($array1);

	}

	public function get_clientes_dk_perfil_not_in(){

		$ids_selec = $this->input->post('ids_selec');
		$ids_selec = explode(",", $ids_selec);
		$ids_selec = array_filter($ids_selec, "strlen");

		
		$id_per = $this->input->post('id_per');

		$clientes = $this->Mod_clientes->get_clientes_dk_perfil($id_per);

		$array_clientes = array();

		foreach ($clientes as $clave => $valor) {
			 
			    array_push($array_clientes, $valor['id_cliente']);
			   
			}
		
		$clientes = implode(",", $array_clientes);

		$rest = $this->Mod_clientes->get_clientes_dk_perfil_filtrados($clientes);

		$array1 = array();

		    foreach ($rest as $clave => $valor) {
			   
			    	$array1[$valor->id_cliente] = $valor;

			}

			$ids_selec = implode(",", $ids_selec);
			$ids_selec = explode(",", $ids_selec);

			foreach ($ids_selec as $clave => $valor) {
			   
			    	unset($array1[$valor]);
			    	
			}

			$array2 = array();
			foreach ($array1 as $clave => $valor) {
			   		
			   		$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);
			    	array_push($array2, $valor);
			    	
			}

			echo json_encode($array2);

	}

	public function get_clientes_dk_not_in(){

		$ids_selec = $this->input->post('ids_selec');
		
		if($ids_selec != ''){

			$ids_selec = explode(",", $ids_selec);
			$ids_selec = array_filter($ids_selec, "strlen");
		    $ids_selec = implode(",", $ids_selec);
		   
		
			$rest = $this->Mod_clientes->get_clientes_dk_not_in($ids_selec);

			$array1 = array();
			
		    foreach ($rest as $clave => $valor) {
			   		
			    	$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);
			    	array_push($array1, $valor);
			   		
			}

			echo json_encode($array1);
		
		}else{

			$this->get_clientes_dk();


		}


	}

	public function get_clientes_dk_not_in_usuario(){

		$ids_selec = $this->input->post('ids_selec');
		$id_per = $this->input->post('id_per');
		

		if($ids_selec != ''){

			$ids_selec = explode(",", $ids_selec);
			$ids_selec = array_filter($ids_selec, "strlen");
		    $ids_selec = implode(",", $ids_selec);
		   
		
			$rest = $this->Mod_clientes->get_clientes_dk_not_in_usuario($ids_selec,$id_per);

			$array1 = array();

		    foreach ($rest as $clave => $valor) {
			   
			    	$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);

			    	array_push($array1, $valor);
			   
			}

			echo json_encode($array1);
		

		}else{

			$this->get_clientes_dk();


		}

		

	}

	public function get_catalogo_dks_usuarios(){

		$id_usuario = $this->input->get('id_usuario');
		$rest = $this->Mod_clientes->get_catalogo_dks_usuario_actualizacion($id_usuario);

		echo json_encode($rest);

	}


	public function get_catalogo_dks_perfil(){

		$id_perfil = $this->input->get('id_perfil');
		$rest = $this->Mod_clientes->get_catalogo_dks_perfil_general($id_perfil);

		echo json_encode($rest);

	}

	public function get_catalogo_dks_seleccionados(){

		 $id_usuario = $this->input->get('id_usuario');

		 $row_dks = $this->Mod_clientes->get_catalogo_dks_usuario_actualizacion($id_usuario);

		 $dks = [];

		 foreach ($row_dks as $clave => $valor) {
			    	
			    array_push($dks, $valor['id_cliente']);
		 		
		 }

		 $dks = implode(",", $dks);
			
	
		 $rest = $this->Mod_clientes->get_catalogo_dks_seleccionados($dks);
		 
		 
		 $array1 = array();

		    foreach ($rest as $clave => $valor) {
			    	
			    	$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);
			    	
			    	array_push($array1, $valor);
			
			}

			echo json_encode($array1);
		
	}

	public function get_catalogo_dks_seleccionados_perfil(){

		 $id_perfil = $this->input->get('id_perfil');
		 $row_dks = $this->Mod_clientes->get_catalogo_dks_perfil($id_perfil);

		 $dks = [];

		 foreach ($row_dks as $clave => $valor) {
			    	
			    array_push($dks, $valor['id_cliente']);
		 		
		 }

		 $dks = implode(",", $dks);

		 $rest = $this->Mod_clientes->get_catalogo_dks_seleccionados($dks);
		 
		 $array1 = array();

		    foreach ($rest as $clave => $valor) {
			    	
			    	$valor->nombre_cliente = utf8_encode($valor->nombre_cliente);
			    	$valor->id_corporativo = utf8_encode($valor->id_corporativo);
			    	
			    	array_push($array1, $valor);
			
			}

			echo json_encode($array1);

	}


}
