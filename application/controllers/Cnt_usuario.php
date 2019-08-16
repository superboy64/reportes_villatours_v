<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_usuario extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_perfiles');
	     
	}

	public function get_datos_usuario(){

		$id_us = $this->session->userdata('session_id');
		$rest = $this->Mod_usuario->get_datos_usuario($id_us);

		$this->load->view('Perfiles/view_perfil_usuario');
		
	}

	public function get_html_cambio_contrasena_usuario(){

		$res = $this->load->view('Usuarios/view_cambio_contrasena_usuario');

		echo json_encode($res);
		
	}

	public function cambio_contrasena_usuario(){

		$id_us = $this->session->userdata('session_id');
 		
 		$password_actual = $this->input->post('txt_password_actual');
 		$password_nuevo = $this->input->post('txt_password_nuevo');
 		$confirmar_password = $this->input->post('txt_confirmar_password');

		$rest = $this->Mod_usuario->cambio_contrasena_usuario($password_actual,$password_nuevo,$confirmar_password,$id_us);
		  
		echo json_encode($rest);

	}

	public function get_catalogo_usuarios()
	{

		  $sucursal = $this->input->get('sucursal');
		  $nombre_usuario = $this->input->get('nombre_usuario');
		  $usuario = $this->input->get('usuario');
		  $departamento = $this->input->get('departamento');
		  $status = $this->input->get('status');

		  $rest = $this->Mod_usuario->get_catalogo_usuarios_filtro($sucursal,$nombre_usuario,$usuario,$departamento,$status);

		  echo json_encode($rest);

	}

	public function get_accesos(){

		  $parametros = $this->input->post('parametros');
		  $rest = $this->Mod_usuario->get_accesos($parametros);
		  
		  echo json_encode($rest);

	}

	public function get_html_accesos()
	{

		  $nombre_usuario = $this->input->post('nombre_usuario');
		  $usuario = $this->input->post('usuario');
		  $departamento = $this->input->post('departamento');
		  $fecha1 = $this->input->post('fecha1');
		  $fecha2 = $this->input->post('fecha2');
		  
		  $parametros['nombre_usuario'] = $nombre_usuario;
		  $parametros['usuario'] = $usuario;
		  $parametros['departamento'] = $departamento;
		  $parametros['fecha1'] = $fecha1;
		  $parametros['fecha2'] = $fecha2;

		  $this->load->view('Usuarios/view_accesos',$parametros);

	}

	public function get_html_usuarios()
	{	 
		  $title = $this->input->post('title');
		  $param['title'] = $title;

		  $param2['usuarios'] = $this->Mod_usuario->get_catalogo_usuarios();
		  $param2['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();

		  $this->load->view('Filtros/view_filtros',$param2);
		  
		  $this->load->view('Usuarios/view_usuarios',$param);
	
	}

	public function get_html_agregar_usuario()
	{
		  $perfiles = $this->Mod_usuario->get_catalogo_perfiles();
		  $sucursales = $this->Mod_usuario->get_catalogo_sucursales();

		  $param["perfiles"] = $perfiles;
		  $param["sucursales"] = $sucursales;

		  $this->load->view('Usuarios/view_agregar_usuario',$param);

	}

	public function get_html_actualizar_usuario(){

		  $row_usuario = $this->input->post('row_usuario');

		  $id_usuario = $row_usuario[0]['id'];
		  $id_sucursal = $row_usuario[0]['id_sucursal'];
		  $nombre_usuario = $row_usuario[0]['nombre'];
		  $usuario = $row_usuario[0]['usuario'];
		  $password = $row_usuario[0]['password'];
		  $id_perfil = $row_usuario[0]['id_perfil'];

		  $perfiles = $this->Mod_usuario->get_catalogo_perfiles();
		  $sucursales = $this->Mod_usuario->get_catalogo_sucursales();
		  $param["perfiles"] = $perfiles;
		  $param["sucursales"] = $sucursales;
		  $param["id_usuario"] = $id_usuario;
		  $param["id_sucursal"] = $id_sucursal;
		  $param["nombre_usuario"] = $nombre_usuario;
		  $param["usuario"] = $usuario;
		  $param["password"] = $password;
		  $param["id_perfil"] = $id_perfil;
		

		  $this->load->view('Usuarios/view_actualizar_usuario',$param);
	}

	public function get_html_dks_usuario(){

		 $id_usuario = $this->input->post('id_usuario');

		 $param["id_usuario"] = $id_usuario;

		 $this->load->view('Usuarios/view_dks_usuario',$param);

	}

	public function guardar_usuario()
	{
		$nombre = $this->input->post('txt_nombre');
		$usuario = $this->input->post('txt_usuario');
		$password = $this->input->post('txt_password');
		$sucursal = $this->input->post('slc_sucursal');
		$perfil = $this->input->post('slc_dep');
		$rows_clientes_selec_all = $this->input->post('rows_clientes_selec_all');

		$all_dks = $this->input->post('all_dks');

		$rest = $this->Mod_usuario->guardar_usuario($nombre,$usuario,$sucursal,$password,$perfil,$rows_clientes_selec_all,$all_dks);

		echo json_encode($rest);

	}

	public function actualizar_usuario(){

		$id_usuario = $this->input->post('id_usuario');
		$nombre = $this->input->post('txt_nombre');
		$usuario = $this->input->post('txt_usuario');
		$sucursal = $this->input->post('slc_sucursal');
		$password = $this->input->post('txt_password');
		$id_perfil = $this->input->post('slc_dep');
		$rows_clientes_selec_all = $this->input->post('rows_clientes_selec_all');

		$all_dks = $this->input->post('all_dks');

		$rest = $this->Mod_usuario->actualizar_usuario($id_usuario,$nombre,$usuario,$sucursal,$password,$id_perfil,$rows_clientes_selec_all,$all_dks);

		echo json_encode($rest);

	}


	function eliminar_usuario(){

		$id_usuario = $this->input->post('id_usuario');
		
		$rest = $this->Mod_usuario->eliminar_usuario($id_usuario);

		echo json_encode($rest);

	}



}
