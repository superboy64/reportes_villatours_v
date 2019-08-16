<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      //$this->load->database('default');
	      $this->load->model('Pruebamodel');
	     
	}

	public function index()
	{


		$rest = $this->Pruebamodel->obtener_todos();
        //print_r($referencia);

        //$this->load->view('mostrar_factura', $factura);

		$this->load->view('welcome_message',$rest);
		

	}

}
