<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_perfiles extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_perfiles');
	      $this->load->model('Mod_usuario');
	}

	public function get_catalogo_perfiles(){

		$sucursal = $this->input->get('sucursal');
		$perfil = $this->input->get('perfil');
		$fecha1 = $this->input->get('fecha1');
		$fecha2 = $this->input->get('fecha2');
		$status = $this->input->get('status');
		
		$rest = $this->Mod_perfiles->get_catalogo_perfiles($sucursal,$perfil,$fecha1,$fecha2,$status);

	    echo json_encode($rest);


	}

	public function get_perfiles_id(){

		$id_per = $this->input->post('id_per');
		$perfil = $this->Mod_perfiles->get_perfiles_id($id_per);

		echo json_encode($perfil);


	}

	public function get_html_perfiles()
	{    
			
		 $title = $this->input->post('title');
		 $usuarios = $this->Mod_usuario->get_catalogo_usuarios();
		 $departamentos = $this->Mod_perfiles->get_catalogo_departamentos();
		 $param['usuarios'] = $usuarios;
		 $param['departamentos'] = $departamentos;
		 $param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		 $param['title'] = $title;

		 $this->load->view('Filtros/view_filtros',$param);

		 $this->load->view('Perfiles/view_perfiles',$param);

	}

	public function get_catalogo_modulos(){

		$modulos = $this->Mod_perfiles->get_catalogo_modulos();

		echo json_encode($modulos);

	}

	public function get_catalogo_modulos_perfil(){

		$id_perfil = $this->input->get('id_perfil');
		
		$modulos = $this->Mod_perfiles->get_catalogo_modulos_perfil($id_perfil);

		echo json_encode($modulos);

	}

	public function get_catalogo_modulos_perfil_distinct(){

		$id_perfil = $this->input->get('id_perfil');
		
		$modulos = $this->Mod_perfiles->get_catalogo_modulos_perfil_distinct($id_perfil);

		
		echo json_encode($modulos);

	}

	public function get_html_agregar_perfiles()
	{
		
		 $departamentos = $this->Mod_perfiles->get_catalogo_departamentos();
		 $modulos = $this->Mod_perfiles->get_catalogo_modulos();
		 $sucursales = $this->Mod_usuario->get_catalogo_sucursales();
		
		 $param['departamentos'] = $departamentos;
		 $param['modulos'] = $modulos;
		 $param['sucursales'] = $sucursales;
		 
		 $this->load->view('Perfiles/view_agregar_perfiles.php',$param);

	}

	public function get_html_actualizar_perfiles()
	{
		 
		 $id_perfil = $this->input->post('id_perfil');
		 $id_suc = $this->input->post('id_suc');
		 $usuarios = $this->Mod_usuario->get_catalogo_usuarios();
		 $departamentos = $this->Mod_perfiles->get_catalogo_departamentos();
		 $perfil = $this->Mod_perfiles->get_perfiles_id($id_perfil);
		 $modulos = $this->Mod_perfiles->get_catalogo_modulos();
		 $sucursales = $this->Mod_usuario->get_catalogo_sucursales();
		 
		 $sucursales_actuales = $this->Mod_usuario->get_sucursales_actuales($id_perfil);

		 //obtener sucrsales seleccionadas atraves de id perfil

		 $param['usuarios'] = $usuarios;
		 $param['departamentos'] = $departamentos;
		 $param['modulos'] = $modulos;
		 $param['sucursales'] = $sucursales;
		 $param['id_suc'] = $id_suc;
		 $param['id_perfil'] = $id_perfil;
		 $param['id_departamento'] = $perfil[0]["id_departamento"];
		 $param['sucursales_actuales'] = $sucursales_actuales;
		 
		 $this->load->view('Perfiles/view_actualizar_perfiles.php',$param);


	}

	public function guardar_perfil(){

		$id_suc = $this->input->post('slc_id_suc');
		$rows_cli_select = $this->input->post('rows_cli_select');
		$slc_dep = $this->input->post('slc_dep');
		$slc_mult_id_sucursal_alta = $this->input->post('slc_mult_id_sucursal_alta');

		if($slc_mult_id_sucursal_alta == ''){

			$slc_mult_id_sucursal_alta = 0;
		
		}

		$array_mod_submod = $this->input->post('array_mod_submod');
		$rows_mod = $this->input->post('rows_mod');

		$status_all_cli = $this->input->post('status_all_cli');

		$rest = $this->Mod_perfiles->guardar_perfil($id_suc,$rows_cli_select,$slc_dep,$slc_mult_id_sucursal_alta,$array_mod_submod,$rows_mod,$status_all_cli);

		echo json_encode($rest);

	}

	public function guardar_perfil_actualizado(){

		$id_suc = $this->input->post('slc_id_suc');
		$rows_cli_select = json_decode($this->input->post('rows_cli_select'));
		$slc_dep = $this->input->post('slc_dep');
		$slc_mult_id_sucursal_act = $this->input->post('slc_mult_id_sucursal_act');
		$array_mod_submod = json_decode($this->input->post('array_mod_submod'));
		$rows_mod = json_decode($this->input->post('rows_mod'));
		$id_perfil = $this->input->post('id_perfil');
		

		$status_all_cli = $this->input->post('status_all_cli');

		$rest = $this->Mod_perfiles->guardar_perfil_actualizado($id_suc,$rows_cli_select,$slc_dep,$slc_mult_id_sucursal_act,$array_mod_submod,$rows_mod,$id_perfil,$status_all_cli);

		echo json_encode($rest);
		
	}

	public function guardar_perfil_actualizacion(){

		$rows_cli_select = $this->input->post('rows_cli_select');
		$slc_dep = $this->input->post('slc_dep');
		$array_mod_submod = $this->input->post('array_mod_submod');
		$rows_mod = $this->input->post('rows_mod');
		
		$rest = $this->Mod_perfiles->guardar_perfil_actualizacion($rows_cli_select,$slc_dep,$array_mod_submod,$rows_mod);

		echo json_encode($rest);

	}

	public function get_html_dks_perfil(){

		$id_perfil = $this->input->post('id_perfil');
		$param["id_perfil"] = $id_perfil;
		$this->load->view('Perfiles/view_dks_perfil',$param);


	}

	public function get_html_modulos_perfil(){

		$id_perfil = $this->input->post('id_perfil');
		$param["id_perfil"] = $id_perfil;
		$this->load->view('Perfiles/view_modulos_perfil',$param);


	}

	public function get_catalogo_submodulos(){

		 $modulo_id = $this->input->post('modulo_id');

		 $rest = $this->Mod_perfiles->get_catalogo_submodulos($modulo_id);
		
		 echo json_encode($rest);


	}

	public function get_catalogo_perfil_submodulos(){

		 $modulo_id = $this->input->post('modulo_id');
		 $id_perfil = $this->input->post('id_perfil'); //Id del usuario seleccionado
		 
		 //$id_perfil = $this->session->userdata('session_id_perfil'); //Id del usuario administrador

		 $rest = $this->Mod_perfiles->get_catalogo_perfil_submodulos($modulo_id,$id_perfil);
		
		 echo json_encode($rest);


	}

	public function get_catalogo_submodulos_in(){

		 $array_mod = $this->input->post('array_mod');

		 $str_mod = implode(",",$array_mod);

		 $rest = $this->Mod_perfiles->get_catalogo_submodulos_in($str_mod);
 	
		 echo json_encode($rest);


	}

	function eliminar_perfil(){

		$id_perfil = $this->input->post('id_perfil');
		
		$rest = $this->Mod_perfiles->eliminar_perfil($id_perfil);

		echo json_encode($rest);

	}


}
