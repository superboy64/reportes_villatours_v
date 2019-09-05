<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_layout_seg extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_layout_seg');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->load->library('lib_letras_excel');  //al llamar una libreria se hace referencia en minusculas
	      $this->load->library('lib_segmentos_millas');
	     
	}

	public function get_html_rep_layout_segmentado(){
		
		$title = $this->input->post('title');

		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,5);
		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
	    $param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);

		$this->load->view('Reportes/view_rep_layout_segmentado');
		
	}

	
	public function get_reportes_layout_seg(){

		$parametros = $this->input->post("parametros");
        
		$parametros = explode(",", $parametros);
        
        $ids_suc = $parametros[0];
        $ids_serie = $parametros[1];
        $ids_cliente = $parametros[2];
        $ids_servicio = $parametros[3];
        $ids_provedor = $parametros[4];
        $ids_corporativo = $parametros[5];
        $id_plantilla = $parametros[6];
        $fecha1 = $parametros[7];
        $fecha2 = $parametros[8];
        
        $parametros = [];

        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["ids_servicio"] = $ids_servicio;
        $parametros["ids_provedor"] = $ids_provedor;
        $parametros["ids_corporativo"] = $ids_corporativo;
        $parametros["fecha1"] = $fecha1;
        $parametros["fecha2"] = $fecha2;


        $parametros["id_usuario"] = $this->session->userdata('session_id');
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';


		$rest = $this->Mod_reportes_layout_seg->get_reportes_layout_seg($parametros);

		$array1 = array();
		$array_consecutivo = array();
		
					function data_general($valor,$segmentos){  //SUB FUNCION

					$valor->tpo_cambio = utf8_encode($valor->tpo_cambio);
					$valor->combustible = utf8_encode($valor->combustible);
					$valor->GVC_NOM_CLI = utf8_encode($valor->GVC_NOM_CLI);
					$valor->consecutivo = utf8_encode($valor->consecutivo);
					$valor->name = utf8_encode($valor->name);
					$valor->nexp = utf8_encode($valor->nexp);
					$valor->destination = utf8_encode($valor->destination);
					$valor->fecha_salida = utf8_encode($valor->fecha_salida);
					$valor->documento = (int)$valor->documento;
					$valor->solicitor = utf8_encode($valor->solicitor);

					$valor->type_of_service = $valor->type_of_service;
					//$valor->type_of_service = 'HOTEL';
					$valor->supplier = utf8_encode($valor->supplier);

					$valor->final_user = utf8_encode($valor->final_user);
					$valor->ticket_number = utf8_encode($valor->ticket_number);
					$valor->typo_of_ticket = utf8_encode($valor->typo_of_ticket);
					$valor->fecha_emi = utf8_encode($valor->fecha_emi);
					$valor->city = utf8_encode($valor->city);
					$valor->country = utf8_encode($valor->country);
					$valor->total_emission = utf8_encode($valor->total_emission);

					$millas = 0;

					if(array_key_exists(0, $segmentos)) {

							$millas_seg1 = $segmentos[0]['millas'];
							
							$millas = (int)$millas_seg1;
							if(array_key_exists(1, $segmentos)) {
								$millas_seg2 = $segmentos[1]['millas'];
								$millas = (int)$millas_seg1 + (int)$millas_seg2;
								if(array_key_exists(2, $segmentos)) {
									$millas_seg3 = $segmentos[2]['millas'];
									$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3;
									if(array_key_exists(3, $segmentos)) {
										$millas_seg4 = $segmentos[3]['millas'];
										$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4;
										if(array_key_exists(4, $segmentos)) {
											$millas_seg5 = $segmentos[4]['millas'];
											$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5;
											if(array_key_exists(5, $segmentos)) {
												$millas_seg6 = $segmentos[5]['millas'];
												$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6;
												if(array_key_exists(6, $segmentos)) {
													$millas_seg7 = $segmentos[6]['millas'];
													$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7;
													if(array_key_exists(7, $segmentos)) {
														$millas_seg8 = $segmentos[7]['millas'];
														$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7 + (int)$millas_seg8;
														if(array_key_exists(8, $segmentos)) {
															$millas_seg9 = $segmentos[8]['millas'];
															$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7 + (int)$millas_seg8 + (int)$millas_seg9;
															if(array_key_exists(9, $segmentos)) {
																$millas_seg10 = $segmentos[9]['millas'];
																$millas = (int)$millas_seg1 + (int)$millas_seg2 + (int)$millas_seg3 + (int)$millas_seg4 + (int)$millas_seg5 + (int)$millas_seg6 + (int)$millas_seg7 + (int)$millas_seg8 + (int)$millas_seg9  + (int)$millas_seg10;
															}
														}
													}
												}
											}
										}
									}
								}

							}

					}//fin if

					$valor->total_millas = $millas;


					$valor->buy_in_advance = $valor->buy_in_advance;
					$valor->record_localizador= $valor->record_localizador;
					$valor->fecha_fac= $valor->fecha_fac;


					if( $valor->emd == 'S'){  //pone los itnerary vacios   por que es una replica del boleto original y no lleba segmentacion

					$valor->total_Itinerary1 = '';
					$valor->origin1 = '';
					$valor->destina1 = '';

					$valor->aerolinea1 = '';
					$valor->fecha_Salida_vu1 = '';
					$valor->fecha_llegada1 = '';
					$valor->hora_salida_vu1 = '';
					$valor->hora_llegada_vu1 = '';
					$valor->numero_vuelo1 = '';
					$valor->clase_reservada1 = '';

					$valor->total_Itinerary2 = '';
					$valor->origin2 = '';
					$valor->destina2 = '';

					$valor->aerolinea2 = '';
					$valor->fecha_Salida_vu2 = '';
					$valor->fecha_llegada2 = '';
					$valor->hora_salida_vu2 = '';
					$valor->hora_llegada_vu2 = '';
					$valor->numero_vuelo2 = '';
					$valor->clase_reservada2 = '';

					$valor->total_Itinerary3 = '';
					$valor->origin3 = '';
					$valor->destina3 = '';

					$valor->aerolinea3 = '';
					$valor->fecha_Salida_vu3 = '';
					$valor->fecha_llegada3 = '';
					$valor->hora_salida_vu3 = '';
					$valor->hora_llegada_vu3 = '';
					$valor->numero_vuelo3 = '';
					$valor->clase_reservada3 = '';

					$valor->total_Itinerary4 = '';
					$valor->origin4 = '';
					$valor->destina4 = '';

					$valor->aerolinea4 = '';
					$valor->fecha_Salida_vu4 = '';
					$valor->fecha_llegada4 = '';
					$valor->hora_salida_vu4 = '';
					$valor->hora_llegada_vu4 = '';
					$valor->numero_vuelo4 = '';
					$valor->clase_reservada4 = '';

					$valor->total_Itinerary5 = '';
					$valor->origin5 = '';
					$valor->destina5 = '';

					$valor->aerolinea5 = '';
					$valor->fecha_Salida_vu5 = '';
					$valor->fecha_llegada5 = '';
					$valor->hora_salida_vu5 = '';
					$valor->hora_llegada_vu5 = '';
					$valor->numero_vuelo5 = '';
					$valor->clase_reservada5 = '';

					$valor->total_Itinerary6 = '';
					$valor->origin6 = '';
					$valor->destina6 ='';

					$valor->aerolinea6 = '';
					$valor->fecha_Salida_vu6 = '';
					$valor->fecha_llegada6 = '';
					$valor->hora_salida_vu6 = '';
					$valor->hora_llegada_vu6 = '';
					$valor->numero_vuelo6 = '';
					$valor->clase_reservada6 = '';

					$valor->total_Itinerary7 ='';
					$valor->origin7 = '';
					$valor->destina7 = '';

					$valor->aerolinea7 = '';
					$valor->fecha_Salida_vu7 = '';
					$valor->fecha_llegada7 = '';
					$valor->hora_salida_vu7 = '';
					$valor->hora_llegada_vu7 = '';
					$valor->numero_vuelo7 = '';
					$valor->clase_reservada7 = '';

					$valor->total_Itinerary8 = '';
					$valor->origin8 = '';
					$valor->destina8 = '';

					$valor->aerolinea8 = '';
					$valor->fecha_Salida_vu8 = '';
					$valor->fecha_llegada8 = '';
					$valor->hora_salida_vu8 = '';
					$valor->hora_llegada_vu8 = '';
					$valor->numero_vuelo8 = '';
					$valor->clase_reservada8 = '';

					$valor->total_Itinerary9 = '';
					$valor->origin9 = '';
					$valor->destina9 = '';

					$valor->aerolinea9 = '';
					$valor->fecha_Salida_vu9 = '';
					$valor->fecha_llegada9 = '';
					$valor->hora_salida_vu9 = '';
					$valor->hora_llegada_vu9 = '';
					$valor->numero_vuelo9 = '';
					$valor->clase_reservada9 = '';

					$valor->total_Itinerary10 = '';
					$valor->origin10 = '';
					$valor->destina10 = '';

					$valor->aerolinea10 = '';
					$valor->fecha_Salida_vu10 = '';
					$valor->fecha_llegada10 = '';
					$valor->hora_salida_vu10 = '';
					$valor->hora_llegada_vu10 = '';
					$valor->numero_vuelo10 = '';
					$valor->clase_reservada10 = '';

					}else{
					//***********total_Itinerary1
					if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary1 = $scf;



					}else if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary1 = $scf;

					}else{

						   $valor->total_Itinerary1 = $valor->total_Itinerary1;

					}

					//*******origin1
					if(array_key_exists(0, $segmentos)) {

							$id_ciudad_salida = $segmentos[0]['id_ciudad_salida'];
						
							$valor->origin1 = $id_ciudad_salida;


					}else{

						    $valor->origin1 = $valor->origin1;
						
					}
					//******destina1
					if(array_key_exists(0, $segmentos)) {

							$id_ciudad_destino = $segmentos[0]['id_ciudad_destino'];
						
							$valor->destina1 = $id_ciudad_destino;



					}else{

							$valor->destina1 =$valor->destina1;
						
					}

					//*****aerolinea1
					if(array_key_exists(0, $segmentos)) {

							$id_la = $segmentos[0]['id_la'];
						
							$valor->aerolinea1 = $id_la;



					}else{

							$valor->aerolinea1 = $valor->aerolinea1;
						
					}

					//*****fecha_Salida_vu1
					if(array_key_exists(0, $segmentos)) {

							$fecha_salida = $segmentos[0]['fecha_salida'];
						
							$valor->fecha_Salida_vu1 = $fecha_salida;



					}else{

						   $valor->fecha_Salida_vu1 = $valor->fecha_Salida_vu1;
						
					}
					//*****fecha_llegada1   falta logica
					if(array_key_exists(0, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[0]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[0]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada1 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada1 = $valor->fecha_llegada1;
						
					}
					//*****hora_salida_vu1
					if(array_key_exists(0, $segmentos)) {

							$hora_salida = $segmentos[0]['hora_salida'];
						
							$valor->hora_salida_vu1 = $hora_salida;



					}else{

							$valor->hora_salida_vu1 = $valor->hora_salida_vu1;
					}
					//*****hora_llegada_vu1
					if(array_key_exists(0, $segmentos)) {

							$hora_llegada = $segmentos[0]['hora_llegada'];
						
							$valor->hora_llegada_vu1 = $hora_llegada;



					}else{

							$valor->hora_llegada_vu1 = $valor->hora_llegada_vu1;
						
					}
					//*****numero_vuelo1
					if(array_key_exists(0, $segmentos)) {

							$numero_vuelo = $segmentos[0]['numero_vuelo'];
						
							$valor->numero_vuelo1 = $numero_vuelo;



					}else{

						    $valor->numero_vuelo1 = $valor->numero_vuelo1;
						
					}
					//*****clase_reservada1

					if(array_key_exists(0, $segmentos)) {

						   
						   $clase_reservada = $segmentos[0]['clase_reservada'];

						   $valor->clase_reservada1 = $clase_reservada;



					}else{

						   $valor->clase_reservada1 = $valor->clase_reservada1;
						
					}



					//***********total_Itinerary2

					if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary2 = $scf;




					}else if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary2 = $scf;

					}else{

						   $valor->total_Itinerary2 = $valor->total_Itinerary2;

					}

					//*******origin2
					if(array_key_exists(1, $segmentos)) {

							$id_ciudad_salida = $segmentos[1]['id_ciudad_salida'];
						
							$valor->origin2 = $id_ciudad_salida;



					}else{

						    $valor->origin2 = $valor->origin2;
						
					}
					//******destina2
					if(array_key_exists(1, $segmentos)) {

							$id_ciudad_destino = $segmentos[1]['id_ciudad_destino'];
						
							$valor->destina2 = $id_ciudad_destino;

							

					}else{

							$valor->destina2 =$valor->destina2;
							
					}

					//*****aerolinea2
					if(array_key_exists(1, $segmentos)) {

							$id_la = $segmentos[1]['id_la'];
						
							$valor->aerolinea2 = $id_la;

							

					}else{

							$valor->aerolinea2 = $valor->aerolinea2;
						
					}

					//*****fecha_Salida_vu2
					if(array_key_exists(1, $segmentos)) {

							$fecha_salida = $segmentos[1]['fecha_salida'];
						
							$valor->fecha_Salida_vu2 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu2 = $valor->fecha_Salida_vu2;
						
					}
					//*****fecha_llegada2   falta logica
					if(array_key_exists(1, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[1]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[1]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada2 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada2 = $valor->fecha_llegada2;
						
					}
					//*****hora_salida_vu2
					if(array_key_exists(1, $segmentos)) {

							$hora_salida = $segmentos[1]['hora_salida'];
						
							$valor->hora_salida_vu2 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu2 = $valor->hora_salida_vu2;
					}
					//*****hora_llegada_vu2
					if(array_key_exists(1, $segmentos)) {

							$hora_llegada = $segmentos[1]['hora_llegada'];
						
							$valor->hora_llegada_vu2 = $valor->hora_llegada_vu2;

							

					}else{

							$valor->hora_llegada_vu2 = $valor->hora_llegada_vu2;
						
					}
					//*****numero_vuelo2
					if(array_key_exists(1, $segmentos)) {

							$numero_vuelo = $segmentos[1]['numero_vuelo'];
						
							$valor->numero_vuelo2 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo2 = $valor->numero_vuelo2;
						
					}
					//*****clase_reservada2

					if(array_key_exists(1, $segmentos)) {

						   
						   $clase_reservada = $segmentos[1]['clase_reservada'];

						   $valor->clase_reservada2 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada2 = $valor->clase_reservada2;
						
					}


					//***********total_Itinerary3

					if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary3 = $scf;




					}else if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary3 = $scf;

					}else{

						   $valor->total_Itinerary3 = $valor->total_Itinerary3;

					}

					//*******origin3
					if(array_key_exists(2, $segmentos)) {

							$id_ciudad_salida = $segmentos[2]['id_ciudad_salida'];
						
							$valor->origin3 = $id_ciudad_salida;



					}else{

						    $valor->origin3 = $valor->origin3;
						
					}
					//******destina3
					if(array_key_exists(2, $segmentos)) {

							$id_ciudad_destino = $segmentos[2]['id_ciudad_destino'];
						
							$valor->destina3 = $id_ciudad_destino;

							

					}else{

							$valor->destina3 =$valor->destina3;
							
					}

					//*****aerolinea3
					if(array_key_exists(2, $segmentos)) {

							$id_la = $segmentos[2]['id_la'];
						
							$valor->aerolinea3 = $id_la;

							

					}else{

							$valor->aerolinea3 = $valor->aerolinea3;
						
					}

					//*****fecha_Salida_vu3
					if(array_key_exists(2, $segmentos)) {

							$fecha_salida = $segmentos[2]['fecha_salida'];
						
							$valor->fecha_Salida_vu3 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu3 = $valor->fecha_Salida_vu3;
						
					}
					//*****fecha_llegada3   falta logica

					if(array_key_exists(2, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[2]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[2]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada3 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada3 = $valor->fecha_llegada3;
						
					}
					//*****hora_salida_vu3
					if(array_key_exists(2, $segmentos)) {

							$hora_salida = $segmentos[2]['hora_salida'];
						
							$valor->hora_salida_vu3 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu3 = $valor->hora_salida_vu3;
					}
					//*****hora_llegada_vu3
					if(array_key_exists(2, $segmentos)) {

							$hora_llegada = $segmentos[2]['hora_llegada'];
						
							$valor->hora_llegada_vu3 = $valor->hora_llegada_vu3;

							

					}else{

							$valor->hora_llegada_vu3 = $valor->hora_llegada_vu3;
						
					}
					//*****numero_vuelo3
					if(array_key_exists(2, $segmentos)) {

							$numero_vuelo = $segmentos[2]['numero_vuelo'];
						
							$valor->numero_vuelo3 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo3 = $valor->numero_vuelo3;
						
					}
					//*****clase_reservada3

					if(array_key_exists(2, $segmentos)) {

						   
						   $clase_reservada = $segmentos[2]['clase_reservada'];

						   $valor->clase_reservada3 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada3 = $valor->clase_reservada3;
						
					}

					//***********total_Itinerary4

					if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary4 = $scf;




					}else if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary4 = $scf;

					}else{

						   $valor->total_Itinerary4 = $valor->total_Itinerary4;

					}

					//*******origin4
					if(array_key_exists(3, $segmentos)) {

							$id_ciudad_salida = $segmentos[3]['id_ciudad_salida'];
						
							$valor->origin4 = $id_ciudad_salida;



					}else{

						    $valor->origin4 = $valor->origin4;
						
					}
					//******destina4
					if(array_key_exists(3, $segmentos)) {

							$id_ciudad_destino = $segmentos[3]['id_ciudad_destino'];
						
							$valor->destina4 = $id_ciudad_destino;

							

					}else{

							$valor->destina4 =$valor->destina4;
							
					}

					//*****aerolinea4
					if(array_key_exists(3, $segmentos)) {

							$id_la = $segmentos[3]['id_la'];
						
							$valor->aerolinea4 = $id_la;

							

					}else{

							$valor->aerolinea4 = $valor->aerolinea4;
						
					}

					//*****fecha_Salida_vu4
					if(array_key_exists(3, $segmentos)) {

							$fecha_salida = $segmentos[3]['fecha_salida'];
						
							$valor->fecha_Salida_vu4 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu4 = $valor->fecha_Salida_vu4;
						
					}
					//*****fecha_llegada4   falta logica
					if(array_key_exists(3, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[3]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[3]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada4 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada4 = $valor->fecha_llegada4;
						
					}
					//*****hora_salida_vu4
					if(array_key_exists(3, $segmentos)) {

							$hora_salida = $segmentos[3]['hora_salida'];
						
							$valor->hora_salida_vu4 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu4 = $valor->hora_salida_vu4;
					}
					//*****hora_llegada_vu4
					if(array_key_exists(3, $segmentos)) {

							$hora_llegada = $segmentos[3]['hora_llegada'];
						
							$valor->hora_llegada_vu4 = $valor->hora_llegada_vu4;

							

					}else{

							$valor->hora_llegada_vu4 = $valor->hora_llegada_vu4;
						
					}
					//*****numero_vuelo4
					if(array_key_exists(3, $segmentos)) {

							$numero_vuelo = $segmentos[3]['numero_vuelo'];
						
							$valor->numero_vuelo4 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo4 = $valor->numero_vuelo4;
						
					}
					//*****clase_reservada4

					if(array_key_exists(3, $segmentos)) {

						   
						   $clase_reservada = $segmentos[3]['clase_reservada'];

						   $valor->clase_reservada4 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada4 = $valor->clase_reservada4;
						
					}

					//***********total_Itinerary5

					if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary5 = $scf;




					}else if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary5 = $scf;

					}else{

						   $valor->total_Itinerary5 = $valor->total_Itinerary5;

					}

					//*******origin5
					if(array_key_exists(4, $segmentos)) {

							$id_ciudad_salida = $segmentos[4]['id_ciudad_salida'];
						
							$valor->origin5 = $id_ciudad_salida;



					}else{

						    $valor->origin5 = $valor->origin5;
						
					}
					//******destina5
					if(array_key_exists(4, $segmentos)) {

							$id_ciudad_destino = $segmentos[4]['id_ciudad_destino'];
						
							$valor->destina5 = $id_ciudad_destino;

							

					}else{

							$valor->destina5 =$valor->destina5;
							
					}

					//*****aerolinea5
					if(array_key_exists(4, $segmentos)) {

							$id_la = $segmentos[4]['id_la'];
						
							$valor->aerolinea5 = $id_la;

							

					}else{

							$valor->aerolinea5 = $valor->aerolinea5;
						
					}

					//*****fecha_Salida_vu5
					if(array_key_exists(4, $segmentos)) {

							$fecha_salida = $segmentos[4]['fecha_salida'];
						
							$valor->fecha_Salida_vu5 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu5 = $valor->fecha_Salida_vu5;
						
					}
					//*****fecha_llegada5   falta logica
					if(array_key_exists(4, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[4]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[4]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada5 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada5 = $valor->fecha_llegada5;
						
					}
					//*****hora_salida_vu5
					if(array_key_exists(4, $segmentos)) {

							$hora_salida = $segmentos[4]['hora_salida'];
						
							$valor->hora_salida_vu5 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu5 = $valor->hora_salida_vu5;
					}
					//*****hora_llegada_vu5
					if(array_key_exists(4, $segmentos)) {

							$hora_llegada = $segmentos[4]['hora_llegada'];
						
							$valor->hora_llegada_vu5 = $valor->hora_llegada_vu5;

							

					}else{

							$valor->hora_llegada_vu5 = $valor->hora_llegada_vu5;
						
					}
					//*****numero_vuelo5
					if(array_key_exists(4, $segmentos)) {

							$numero_vuelo = $segmentos[4]['numero_vuelo'];
						
							$valor->numero_vuelo5 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo5 = $valor->numero_vuelo5;
						
					}
					//*****clase_reservada5

					if(array_key_exists(4, $segmentos)) {

						   
						   $clase_reservada = $segmentos[4]['clase_reservada'];

						   $valor->clase_reservada5 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada5 = $valor->clase_reservada5;
						
					}
					//***********total_Itinerary6

					if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary6 = $scf;




					}else if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary6 = $scf;

					}else{

						   $valor->total_Itinerary6 = $valor->total_Itinerary6;

					}

					//*******origin6
					if(array_key_exists(5, $segmentos)) {

							$id_ciudad_salida = $segmentos[5]['id_ciudad_salida'];
						
							$valor->origin6 = $id_ciudad_salida;



					}else{

						    $valor->origin6 = $valor->origin6;
						
					}
					//******destina6
					if(array_key_exists(5, $segmentos)) {

							$id_ciudad_destino = $segmentos[5]['id_ciudad_destino'];
						
							$valor->destina6 = $id_ciudad_destino;

							

					}else{

							$valor->destina6 =$valor->destina6;
							
					}

					//*****aerolinea6
					if(array_key_exists(5, $segmentos)) {

							$id_la = $segmentos[5]['id_la'];
						
							$valor->aerolinea6 = $id_la;

							

					}else{

							$valor->aerolinea6 = $valor->aerolinea6;
						
					}

					//*****fecha_Salida_vu6
					if(array_key_exists(5, $segmentos)) {

							$fecha_salida = $segmentos[5]['fecha_salida'];
						
							$valor->fecha_Salida_vu6 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu6 = $valor->fecha_Salida_vu6;
						
					}
					//*****fecha_llegada6   falta logica
					if(array_key_exists(5, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[5]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[5]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada6 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada6 = $valor->fecha_llegada6;
						
					}
					//*****hora_salida_vu6
					if(array_key_exists(5, $segmentos)) {

							$hora_salida = $segmentos[5]['hora_salida'];
						
							$valor->hora_salida_vu6 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu6 = $valor->hora_salida_vu6;
					}
					//*****hora_llegada_vu6
					if(array_key_exists(5, $segmentos)) {

							$hora_llegada = $segmentos[5]['hora_llegada'];
						
							$valor->hora_llegada_vu6 = $valor->hora_llegada_vu6;

							

					}else{

							$valor->hora_llegada_vu6 = $valor->hora_llegada_vu6;
						
					}
					//*****numero_vuelo6
					if(array_key_exists(5, $segmentos)) {

							$numero_vuelo = $segmentos[5]['numero_vuelo'];
						
							$valor->numero_vuelo6 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo6 = $valor->numero_vuelo6;
						
					}
					//*****clase_reservada6

					if(array_key_exists(5, $segmentos)) {

						   
						   $clase_reservada = $segmentos[5]['clase_reservada'];

						   $valor->clase_reservada6 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada6 = $valor->clase_reservada6;
						
					}
					//***********total_Itinerary7

					if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary7 = $scf;




					}else if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary7 = $scf;

					}else{

						   $valor->total_Itinerary7 = $valor->total_Itinerary7;

					}

					//*******origin7
					if(array_key_exists(6, $segmentos)) {

							$id_ciudad_salida = $segmentos[6]['id_ciudad_salida'];
						
							$valor->origin7 = $id_ciudad_salida;



					}else{

						    $valor->origin7 = $valor->origin7;
						
					}
					//******destina7
					if(array_key_exists(6, $segmentos)) {

							$id_ciudad_destino = $segmentos[6]['id_ciudad_destino'];
						
							$valor->destina7 = $id_ciudad_destino;

							

					}else{

							$valor->destina7 =$valor->destina7;
							
					}

					//*****aerolinea7
					if(array_key_exists(6, $segmentos)) {

							$id_la = $segmentos[6]['id_la'];
						
							$valor->aerolinea7 = $id_la;

							

					}else{

							$valor->aerolinea7 = $valor->aerolinea7;
						
					}

					//*****fecha_Salida_vu7
					if(array_key_exists(6, $segmentos)) {

							$fecha_salida = $segmentos[6]['fecha_salida'];
						
							$valor->fecha_Salida_vu7 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu7 = $valor->fecha_Salida_vu7;
						
					}
					//*****fecha_llegada7   falta logica
					if(array_key_exists(6, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[6]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[6]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada7 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada7 = $valor->fecha_llegada7;
						
					}
					//*****hora_salida_vu7
					if(array_key_exists(6, $segmentos)) {

							$hora_salida = $segmentos[6]['hora_salida'];
						
							$valor->hora_salida_vu7 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu7 = $valor->hora_salida_vu7;
					}
					//*****hora_llegada_vu7
					if(array_key_exists(6, $segmentos)) {

							$hora_llegada = $segmentos[6]['hora_llegada'];
						
							$valor->hora_llegada_vu7 = $valor->hora_llegada_vu7;

							

					}else{

							$valor->hora_llegada_vu7 = $valor->hora_llegada_vu7;
						
					}
					//*****numero_vuelo7
					if(array_key_exists(6, $segmentos)) {

							$numero_vuelo = $segmentos[6]['numero_vuelo'];
						
							$valor->numero_vuelo7 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo7 = $valor->numero_vuelo7;
						
					}
					//*****clase_reservada7

					if(array_key_exists(6, $segmentos)) {

						   
						   $clase_reservada = $segmentos[6]['clase_reservada'];

						   $valor->clase_reservada7 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada7 = $valor->clase_reservada7;
						
					}
					//***********total_Itinerary8

					if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary8 = $scf;




					}else if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary8 = $scf;

					}else{

						   $valor->total_Itinerary8 = $valor->total_Itinerary8;

					}

					//*******origin8
					if(array_key_exists(7, $segmentos)) {

							$id_ciudad_salida = $segmentos[7]['id_ciudad_salida'];
						
							$valor->origin8 = $id_ciudad_salida;



					}else{

						    $valor->origin8 = $valor->origin8;
						
					}
					//******destina8
					if(array_key_exists(7, $segmentos)) {

							$id_ciudad_destino = $segmentos[7]['id_ciudad_destino'];
						
							$valor->destina8 = $id_ciudad_destino;

							

					}else{

							$valor->destina8 =$valor->destina8;
							
					}

					//*****aerolinea8
					if(array_key_exists(7, $segmentos)) {

							$id_la = $segmentos[7]['id_la'];
						
							$valor->aerolinea8 = $id_la;

							

					}else{

							$valor->aerolinea8 = $valor->aerolinea8;
						
					}

					//*****fecha_Salida_vu8
					if(array_key_exists(7, $segmentos)) {

							$fecha_salida = $segmentos[7]['fecha_salida'];
						
							$valor->fecha_Salida_vu8 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu8 = $valor->fecha_Salida_vu8;
						
					}
					//*****fecha_llegada8   falta logica
					if(array_key_exists(7, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[7]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[7]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada8 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada8 = $valor->fecha_llegada8;
						
					}
					//*****hora_salida_vu8
					if(array_key_exists(7, $segmentos)) {

							$hora_salida = $segmentos[7]['hora_salida'];
						
							$valor->hora_salida_vu8 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu8 = $valor->hora_salida_vu8;
					}
					//*****hora_llegada_vu8
					if(array_key_exists(7, $segmentos)) {

							$hora_llegada = $segmentos[7]['hora_llegada'];
						
							$valor->hora_llegada_vu8 = $valor->hora_llegada_vu8;

							

					}else{

							$valor->hora_llegada_vu8 = $valor->hora_llegada_vu8;
						
					}
					//*****numero_vuelo8
					if(array_key_exists(7, $segmentos)) {

							$numero_vuelo = $segmentos[7]['numero_vuelo'];
						
							$valor->numero_vuelo8 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo8 = $valor->numero_vuelo8;
						
					}
					//*****clase_reservada8

					if(array_key_exists(7, $segmentos)) {

						   
						   $clase_reservada = $segmentos[7]['clase_reservada'];

						   $valor->clase_reservada8 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada8 = $valor->clase_reservada8;
						
					}
					//***********total_Itinerary9

					if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary9 = $scf;




					}else if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary9 = $scf;

					}else{

						   $valor->total_Itinerary9 = $valor->total_Itinerary9;

					}

					//*******origin9
					if(array_key_exists(8, $segmentos)) {

							$id_ciudad_salida = $segmentos[8]['id_ciudad_salida'];
						
							$valor->origin9 = $id_ciudad_salida;



					}else{

						    $valor->origin9 = $valor->origin9;
						
					}
					//******destina9
					if(array_key_exists(8, $segmentos)) {

							$id_ciudad_destino = $segmentos[8]['id_ciudad_destino'];
						
							$valor->destina9 = $id_ciudad_destino;

							

					}else{

							$valor->destina9 =$valor->destina9;
							
					}

					//*****aerolinea9
					if(array_key_exists(8, $segmentos)) {

							$id_la = $segmentos[8]['id_la'];
						
							$valor->aerolinea9 = $id_la;

							

					}else{

							$valor->aerolinea9 = $valor->aerolinea9;
						
					}

					//*****fecha_Salida_vu9
					if(array_key_exists(8, $segmentos)) {

							$fecha_salida = $segmentos[8]['fecha_salida'];
						
							$valor->fecha_Salida_vu9 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu9 = $valor->fecha_Salida_vu9;
						
					}
					//*****fecha_llegada9   falta logica
					if(array_key_exists(8, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[8]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[8]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada9 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada9 = $valor->fecha_llegada9;
						
					}
					//*****hora_salida_vu9
					if(array_key_exists(8, $segmentos)) {

							$hora_salida = $segmentos[8]['hora_salida'];
						
							$valor->hora_salida_vu9 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu9 = $valor->hora_salida_vu9;
					}
					//*****hora_llegada_vu9
					if(array_key_exists(8, $segmentos)) {

							$hora_llegada = $segmentos[8]['hora_llegada'];
						
							$valor->hora_llegada_vu9 = $valor->hora_llegada_vu9;

							

					}else{

							$valor->hora_llegada_vu9 = $valor->hora_llegada_vu9;
						
					}
					//*****numero_vuelo9
					if(array_key_exists(8, $segmentos)) {

							$numero_vuelo = $segmentos[8]['numero_vuelo'];
						
							$valor->numero_vuelo9 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo9 = $valor->numero_vuelo9;
						
					}
					//*****clase_reservada9

					if(array_key_exists(8, $segmentos)) {

						   
						   $clase_reservada = $segmentos[8]['clase_reservada'];

						   $valor->clase_reservada9 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada9 = $valor->clase_reservada9;
						
					}
					//***********total_Itinerary10

					if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'I') {

							$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;

							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							
							$valor->total_Itinerary10 = $scf;




					}else if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'N'){

							$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
							$combustible = $valor->combustible;

							$scf = (int)$tarifa_segmento + (int)$combustible;
							
							$valor->total_Itinerary10 = $scf;

					}else{

						   $valor->total_Itinerary10 = $valor->total_Itinerary10;

					}

					//*******origin10
					if(array_key_exists(9, $segmentos)) {

							$id_ciudad_salida = $segmentos[9]['id_ciudad_salida'];
						
							$valor->origin10 = $id_ciudad_salida;



					}else{

						    $valor->origin10 = $valor->origin10;
						
					}
					//******destina10
					if(array_key_exists(9, $segmentos)) {

							$id_ciudad_destino = $segmentos[9]['id_ciudad_destino'];
						
							$valor->destina10 = $id_ciudad_destino;

							

					}else{

							$valor->destina10 =$valor->destina10;
							
					}

					//*****aerolinea10
					if(array_key_exists(9, $segmentos)) {

							$id_la = $segmentos[9]['id_la'];
						
							$valor->aerolinea10 = $id_la;

							

					}else{

							$valor->aerolinea10 = $valor->aerolinea10;
						
					}

					//*****fecha_Salida_vu10
					if(array_key_exists(9, $segmentos)) {

							$fecha_salida = $segmentos[9]['fecha_salida'];
						
							$valor->fecha_Salida_vu10 = $fecha_salida;


					}else{

						   $valor->fecha_Salida_vu10 = $valor->fecha_Salida_vu10;
						
					}
					//*****fecha_llegada10   falta logica
					if(array_key_exists(9, $segmentos)) {

							$cambio_fecha_llegada = $segmentos[9]['cambio_fecha_llegada'];
							
							if($cambio_fecha_llegada == '0'){

								$cambio_fecha_llegada = $segmentos[9]['fecha_salida'];

							}else if($cambio_fecha_llegada == '1'){

								$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;

							}else if($cambio_fecha_llegada == '2'){

								$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '3'){

								$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '4'){

								$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
								
							}else if($cambio_fecha_llegada == '5'){

								$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
								
							}

							$valor->fecha_llegada10 = $cambio_fecha_llegada;



					}else{

						$valor->fecha_llegada10 = $valor->fecha_llegada10;
						
					}
					//*****hora_salida_vu10
					if(array_key_exists(9, $segmentos)) {

							$hora_salida = $segmentos[9]['hora_salida'];
						
							$valor->hora_salida_vu10 = $hora_salida;

							

					}else{

							$valor->hora_salida_vu10 = $valor->hora_salida_vu10;
					}
					//*****hora_llegada_vu10
					if(array_key_exists(9, $segmentos)) {

							$hora_llegada = $segmentos[9]['hora_llegada'];
						
							$valor->hora_llegada_vu10 = $valor->hora_llegada_vu10;

							

					}else{

							$valor->hora_llegada_vu10 = $valor->hora_llegada_vu10;
						
					}
					//*****numero_vuelo10
					if(array_key_exists(9, $segmentos)) {

							$numero_vuelo = $segmentos[9]['numero_vuelo'];
						
							$valor->numero_vuelo10 = $numero_vuelo;

							

					}else{

						    $valor->numero_vuelo10 = $valor->numero_vuelo10;
						
					}
					//*****clase_reservada10

					if(array_key_exists(9, $segmentos)) {

						   
						   $clase_reservada = $segmentos[9]['clase_reservada'];

						   $valor->clase_reservada10 = $clase_reservada;

							

					}else{

						   $valor->clase_reservada10 = $valor->clase_reservada10;
						
					}
					


					$valor->total_Itinerary8 = $valor->total_Itinerary8;
					$valor->origin8 = $valor->origin8;
					$valor->destina8 = $valor->destina8;

					$valor->aerolinea8 = $valor->aerolinea8;
					$valor->fecha_Salida_vu8 = $valor->fecha_Salida_vu8;
					$valor->fecha_llegada8 = $valor->fecha_llegada8;
					$valor->hora_salida_vu8 = $valor->hora_salida_vu8;
					$valor->hora_llegada_vu8 = $valor->hora_llegada_vu8;
					$valor->numero_vuelo8 = $valor->numero_vuelo8;
					$valor->clase_reservada8 = $valor->clase_reservada8;


					$valor->total_Itinerary9 = $valor->total_Itinerary9;
					$valor->origin9 = $valor->origin9;
					$valor->destina9 = $valor->destina9;

					$valor->aerolinea9 = $valor->aerolinea9;
					$valor->fecha_Salida_vu9 = $valor->fecha_Salida_vu9;
					$valor->fecha_llegada9 = $valor->fecha_llegada9;
					$valor->hora_salida_vu9 = $valor->hora_salida_vu9;
					$valor->hora_llegada_vu9 = $valor->hora_llegada_vu9;
					$valor->numero_vuelo9 = $valor->numero_vuelo9;
					$valor->clase_reservada9 = $valor->clase_reservada9;

					$valor->total_Itinerary10 = $valor->total_Itinerary10;
					$valor->origin10 = $valor->origin10;
					$valor->destina10 = $valor->destina10;

					$valor->aerolinea10 = $valor->aerolinea10;
					$valor->fecha_Salida_vu10 = $valor->fecha_Salida_vu10;
					$valor->fecha_llegada10 = $valor->fecha_llegada10;
					$valor->hora_salida_vu10 = $valor->hora_salida_vu10;
					$valor->hora_llegada_vu10 = $valor->hora_llegada_vu10;
					$valor->numero_vuelo10 = $valor->numero_vuelo10;
					$valor->clase_reservada10 = $valor->clase_reservada10;

					//nuevo_eco
					$valor->emd = $valor->emd;


					}
				
					return $valor;
				}

			  foreach ($rest as $clave => $valor) {
			    $consecutivo = utf8_encode($valor->consecutivo);

			   
			  	    if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI' || $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT' || $valor->type_of_service == 'HOTNAC_RES' /*|| $valor->type_of_service == 'HOTNAC_VARIOS'*/){
						

						if( !in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT'){

							$valor = data_general($valor,[]);

							$valor->type_of_service = 'HOTEL';
							$valor->codigo_producto = 'HOTEL';

							$fecha1 = $parametros["fecha1"];
				      		$fecha2 = $parametros["fecha2"];

							if($fecha1 == ""){
						          $hoy = getdate();
						          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
						          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
						          $year = $hoy['year'];
						          $fecha1 = $year.'-'.$mes.'-'.$dia;
						          $fecha2 = $year.'-'.$mes.'-'.$dia;
						        
						      }else{
						          
						          $array_fecha1 = explode('/', $fecha1);
						          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
						          $array_fecha2 = explode('/', $fecha2);
						          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
						         
						      }

						    $fac_numero = $valor->documento;
						    $id_serie = utf8_encode($valor->id_serie);
					        $hoteles_iris_arr = $this->Mod_reportes_layout_seg->get_hoteles_iris($fac_numero,$fecha1,$fecha2,$id_serie);


							$cont3=0;
					    	foreach ($hoteles_iris_arr as $clave_hot_ir => $valor_hot_ir) {  
							$cont3++;

						  		$hotel = 'hotel'.$cont3;
						    	$fecha_entrada = 'fecha_entrada'.$cont3;
						    	$fecha_salida = 'fecha_salida'.$cont3;
						    	$noches = 'noches'.$cont3;
						    	$break_fast = 'break_fast'.$cont3;
						    	$numero_hab = 'numero_hab'.$cont3;
						    	$id_habitacion = 'id_habitacion'.$cont3;
						    	$id_ciudad = 'id_ciudad'.$cont3;
						    	$country = 'country'.$cont3;

						    	$valor->$hotel = utf8_encode($valor_hot_ir['servicio']);
						    	$valor->$fecha_entrada = utf8_encode($valor_hot_ir['fecha_entrada']);
						    	$valor->$fecha_salida = utf8_encode($valor_hot_ir['fecha_salida']);
						    	$valor->$noches = utf8_encode($valor_hot_ir['noches']);
						    	$valor->$numero_hab = utf8_encode($valor_hot_ir['cantidad']);
						    	$valor->$id_habitacion = utf8_encode($valor_hot_ir['id_habitacion']);
						    	$valor->$id_ciudad = utf8_encode($valor_hot_ir['id_ciudad']);
						    	$valor->fecha_emi = $valor_hot_ir['fecha_fac2'];

							}

							$autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);

						    $cont2=0;
						    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
						    $cont2++;

						    	$Car_class = 'Car_class'.$cont2;
						    	$Delivery_Date = 'Delivery_Date'.$cont2;
						    	$Nr_days = 'Nr_days'.$cont2;
						    	$Place_delivery = 'Place_delivery'.$cont2;
						    	$Place_delivery_back = 'Place_delivery_back'.$cont2;
						    	$Departure_date = 'Departure_date'.$cont2;
						    	
						    	$valor->$Car_class = utf8_encode($valor_aut['tipo_auto']);
								$valor->$Delivery_Date = utf8_encode($valor_aut['fecha_entrega']);
								$valor->$Nr_days = utf8_encode($valor_aut['dias']);
								$valor->$Place_delivery = utf8_encode($valor_aut['id_ciudad_entrega']);
								$valor->$Place_delivery_back = utf8_encode($valor_aut['id_ciudad_recoge']);
								$valor->$Departure_date = utf8_encode($valor_aut['fecha_entrega']);

						    }
							
						    array_push($array1, $valor);	

						}else if( !in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTNAC_RES'){

								$valor = data_general($valor,[]);

								$valor->type_of_service = 'HOTEL';
								$valor->codigo_producto = 'HOTEL';
						
								$fecha1 = $parametros["fecha1"];
				      			$fecha2 = $parametros["fecha2"];
				      					
										if($fecha1 == ""){
										          $hoy = getdate();
										          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
										          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
										          $year = $hoy['year'];
										          $fecha1 = $year.'-'.$mes.'-'.$dia;
										          $fecha2 = $year.'-'.$mes.'-'.$dia;
										        
										      }else{
										          
										          $array_fecha1 = explode('/', $fecha1);
										          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
										          $array_fecha2 = explode('/', $fecha2);
										          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
										         
										      }

					    		$hoteles_arr = $this->Mod_reportes_layout_seg->get_hoteles_num_bol($consecutivo,$fecha1,$fecha2);
					    		$autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);

					    		if( count($hoteles_arr) > 0 || count($autos_arr) > 0 ){

						    		$cont=0;
								    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
								    $cont++;
								    	
								    	$hotel = 'hotel'.$cont;
								    	$fecha_entrada = 'fecha_entrada'.$cont;
								    	$fecha_salida = 'fecha_salida'.$cont;
								    	$noches = 'noches'.$cont;
								    	$break_fast = 'break_fast'.$cont;
								    	$numero_hab = 'numero_hab'.$cont;
								    	$id_habitacion = 'id_habitacion'.$cont;
								    	$id_ciudad = 'id_ciudad'.$cont;
								    	$country = 'country'.$cont;

								    	$valor->$hotel = utf8_encode($valor_hot['nombre_hotel']);
								    	$valor->$fecha_entrada = utf8_encode($valor_hot['fecha_entrada']);
								    	$valor->$fecha_salida = utf8_encode($valor_hot['fecha_salida']);
								    	$valor->$noches = utf8_encode($valor_hot['noches']);
								    	$valor->$numero_hab = utf8_encode($valor_hot['numero_hab']);
								    	$valor->$id_habitacion = utf8_encode($valor_hot['id_habitacion']);
								    	$valor->$id_ciudad = utf8_encode($valor_hot['id_ciudad']);
								    	
								   }
					    		
							    $cont2=0;
							    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
							    $cont2++;

							    	$Car_class = 'Car_class'.$cont2;
							    	$Delivery_Date = 'Delivery_Date'.$cont2;
							    	$Nr_days = 'Nr_days'.$cont2;
							    	$Place_delivery = 'Place_delivery'.$cont2;
							    	$Place_delivery_back = 'Place_delivery_back'.$cont2;
							    	$Departure_date = 'Departure_date'.$cont2;
							    	
							    	$valor->$Car_class = utf8_encode($valor_aut['tipo_auto']);
									$valor->$Delivery_Date = utf8_encode($valor_aut['fecha_entrega']);
									$valor->$Nr_days = utf8_encode($valor_aut['dias']);
									$valor->$Place_delivery = utf8_encode($valor_aut['id_ciudad_entrega']);
									$valor->$Place_delivery_back = utf8_encode($valor_aut['id_ciudad_recoge']);
									$valor->$Departure_date = utf8_encode($valor_aut['fecha_entrega']);

							    }

							    array_push($array1, $valor);	

							}
							
					   
						}  // FIN ELSE IF HOTNAC RES

						if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI'){
							
							$ticket = utf8_encode($valor->ticket_number);
	 
							$segmentos = $this->Mod_reportes_layout_seg->get_segmentos_ticket_number($ticket,$consecutivo);

							/*if($ticket == '3056073063' and $consecutivo == '2907299'){

								
								foreach ($segmentos as $clave => $valor) {

									print_r($valor['nombre_ciudad_salida'].'<br>');

								}

							}*/

							data_general($valor,$segmentos);

								$fecha1 = $parametros["fecha1"];
				      			$fecha2 = $parametros["fecha2"];
				      					
								if($fecha1 == ""){
								          $hoy = getdate();
								          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
								          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
								          $year = $hoy['year'];
								          $fecha1 = $year.'-'.$mes.'-'.$dia;
								          $fecha2 = $year.'-'.$mes.'-'.$dia;
								        
								      }else{
								          
								          $array_fecha1 = explode('/', $fecha1);
								          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
								          $array_fecha2 = explode('/', $fecha2);
								          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
								         
								      }

					    		$hoteles_arr = $this->Mod_reportes_layout_seg->get_hoteles_num_bol($consecutivo,$fecha1,$fecha2);

					    		if(!in_array($consecutivo, $array_consecutivo) ){

						    		$cont=0;
								    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
								    $cont++;
								    	
								    	$hotel = 'hotel'.$cont;
								    	$fecha_entrada = 'fecha_entrada'.$cont;
								    	$fecha_salida = 'fecha_salida'.$cont;
								    	$noches = 'noches'.$cont;
								    	$break_fast = 'break_fast'.$cont;
								    	$numero_hab = 'numero_hab'.$cont;
								    	$id_habitacion = 'id_habitacion'.$cont;
								    	$id_ciudad = 'id_ciudad'.$cont;
								    	$country = 'country'.$cont;

								    	$valor->$hotel = utf8_encode($valor_hot['nombre_hotel']);
								    	$valor->$fecha_entrada = utf8_encode($valor_hot['fecha_entrada']);
								    	$valor->$fecha_salida = utf8_encode($valor_hot['fecha_salida']);
								    	$valor->$noches = utf8_encode($valor_hot['noches']);
								    	$valor->$numero_hab = utf8_encode($valor_hot['numero_hab']);
								    	$valor->$id_habitacion = utf8_encode($valor_hot['id_habitacion']);
								    	$valor->$id_ciudad = utf8_encode($valor_hot['id_ciudad']);
								    	
								   }

								   $autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);

								    $cont2=0;
								    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
								    $cont2++;

								    	$Car_class = 'Car_class'.$cont2;
								    	$Delivery_Date = 'Delivery_Date'.$cont2;
								    	$Nr_days = 'Nr_days'.$cont2;
								    	$Place_delivery = 'Place_delivery'.$cont2;
								    	$Place_delivery_back = 'Place_delivery_back'.$cont2;
								    	$Departure_date = 'Departure_date'.$cont2;
								    	
								    	$valor->$Car_class = utf8_encode($valor_aut['tipo_auto']);
										$valor->$Delivery_Date = utf8_encode($valor_aut['fecha_entrega']);
										$valor->$Nr_days = utf8_encode($valor_aut['dias']);
										$valor->$Place_delivery = utf8_encode($valor_aut['id_ciudad_entrega']);
										$valor->$Place_delivery_back = utf8_encode($valor_aut['id_ciudad_recoge']);
										$valor->$Departure_date = utf8_encode($valor_aut['fecha_entrega']);

								    }

					    		}

							    array_push($array1, $valor);
						}  //FIN IF BD Y BI

					}  // FIN DE if VADICION TYPE OF SERVICES
					else{ // todo lo que sea diferente pero tenga hoteles

						if(!in_array($consecutivo, $array_consecutivo) ){

									$valor = data_general($valor,[]);
									
									$valor->type_of_service = 'HOTEL';
								    $valor->codigo_producto = 'HOTEL';

									$fecha1 = $parametros["fecha1"];
					      			$fecha2 = $parametros["fecha2"];
					      					
											if($fecha1 == ""){
											          $hoy = getdate();
											          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
											          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
											          $year = $hoy['year'];
											          $fecha1 = $year.'-'.$mes.'-'.$dia;
											          $fecha2 = $year.'-'.$mes.'-'.$dia;
											        
											      }else{
											          
											          $array_fecha1 = explode('/', $fecha1);
											          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
											          $array_fecha2 = explode('/', $fecha2);
											          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
											         
											      }

						             $hoteles_arr = $this->Mod_reportes_layout_seg->get_hoteles_num_bol($consecutivo,$fecha1,$fecha2);

									
									$cont=0;
								    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
								    $cont++;
								    	
								    	$hotel = 'hotel'.$cont;
								    	$fecha_entrada = 'fecha_entrada'.$cont;
								    	$fecha_salida = 'fecha_salida'.$cont;
								    	$noches = 'noches'.$cont;
								    	$break_fast = 'break_fast'.$cont;
								    	$numero_hab = 'numero_hab'.$cont;
								    	$id_habitacion = 'id_habitacion'.$cont;
								    	$id_ciudad = 'id_ciudad'.$cont;
								    	$country = 'country'.$cont;

								    	$valor->$hotel = utf8_encode($valor_hot['nombre_hotel']);
								    	$valor->$fecha_entrada = utf8_encode($valor_hot['fecha_entrada']);
								    	$valor->$fecha_salida = utf8_encode($valor_hot['fecha_salida']);
								    	$valor->$noches = utf8_encode($valor_hot['noches']);
								    	$valor->$numero_hab = utf8_encode($valor_hot['numero_hab']);
								    	$valor->$id_habitacion = utf8_encode($valor_hot['id_habitacion']);
								    	$valor->$id_ciudad = utf8_encode($valor_hot['id_ciudad']);
							    	
							   	  }

								    $autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);

								    $cont2=0;
								    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
								    $cont2++;

								    	$Car_class = 'Car_class'.$cont2;
								    	$Delivery_Date = 'Delivery_Date'.$cont2;
								    	$Nr_days = 'Nr_days'.$cont2;
								    	$Place_delivery = 'Place_delivery'.$cont2;
								    	$Place_delivery_back = 'Place_delivery_back'.$cont2;
								    	$Departure_date = 'Departure_date'.$cont2;
								    	
								    	$valor->$Car_class = utf8_encode($valor_aut['tipo_auto']);
										$valor->$Delivery_Date = utf8_encode($valor_aut['fecha_entrega']);
										$valor->$Nr_days = utf8_encode($valor_aut['dias']);
										$valor->$Place_delivery = utf8_encode($valor_aut['id_ciudad_entrega']);
										$valor->$Place_delivery_back = utf8_encode($valor_aut['id_ciudad_recoge']);
										$valor->$Departure_date = utf8_encode($valor_aut['fecha_entrega']);

								    }

								    if(count($hoteles_arr) != 0){

								    	array_push($array1, $valor);
								    
								    }
								    

								}  // fin consecutivo

							
					
					}// FIN DE else VADICION TYPE OF SERVICES
	    
				    array_push($array_consecutivo, $valor->consecutivo);

			        
			   }  //fin del for principal

			   
			    $col = $this->Mod_reportes_layout_seg->get_columnas_hide($id_plantilla,5);

				$param_final['rep'] = $array1;
				$param_final['col'] = $col;

				echo json_encode($param_final);

         } //fin de la funcion



    public function exportar_excel_rep_layout_segmentado(){

		$parametros = $_REQUEST['parametros'];
		$tipo_funcion = $_REQUEST['tipo_funcion'];
        
        $parametros = explode(",", $parametros);
      
        
        if($tipo_funcion == "aut"){
        	
        	$ids_suc = $parametros[0];
        	$ids_serie = $parametros[1];
        	$ids_cliente = $parametros[2];
	        $ids_servicio = $parametros[3];
	        $ids_provedor = $parametros[4];
	        $ids_corporativo = $parametros[5];
	        $id_plantilla = $parametros[6];
	        $fecha1 = $parametros[7];
	        $fecha2 = $parametros[8];

        	$id_correo_automatico = $parametros[9];
            $id_reporte = $parametros[10];
            $id_usuario = $parametros[11];
            $id_intervalo = $parametros[12];
            $fecha_ini_proceso = $parametros[13];
			
		}else{

			$ids_suc = $parametros[0];
			$ids_serie = $parametros[1];
			$ids_cliente = $parametros[2];
	        $ids_servicio = $parametros[3];
	        $ids_provedor = $parametros[4];
	        $ids_corporativo = $parametros[5];
	        $id_plantilla = $parametros[6];
	        $fecha1 = $parametros[7];
	        $fecha2 = $parametros[8];
        


		}

        $parametros = [];
        
        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["ids_servicio"] = $ids_servicio;
        $parametros["ids_provedor"] = $ids_provedor;
        $parametros["ids_corporativo"] = $ids_corporativo;
        $parametros["id_plantilla"] = $id_plantilla;
        $parametros["fecha1"] = $fecha1;
        $parametros["fecha2"] = $fecha2;


       if($tipo_funcion == "aut"){
        	

        	$parametros["id_usuario"] = $id_usuario;
        	$parametros["id_intervalo"] = $id_intervalo;
        	$parametros["fecha_ini_proceso"] = $fecha_ini_proceso;
			
		}else{

			$parametros["id_usuario"] = $this->session->userdata('session_id');
	        $parametros["id_intervalo"] = '0';
	        $parametros["fecha_ini_proceso"] = '';

		}

		$rep = $this->Mod_reportes_layout_seg->get_reportes_layout_seg($parametros);
		
	if(count($rep) > 0){

		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();


		$activeSheet->setCellValue('A5','consecutivo' )->getStyle('A5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('B5','name' )->getStyle('B5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('C5','Nº Exp' )->getStyle('C5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('D5','destination' )->getStyle('D5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('E5','Date Origin' )->getStyle('E5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('F5','Nr doc.' )->getStyle('F5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('G5','solicitor' )->getStyle('G5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('H5','type_of_service' )->getStyle('H5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('I5','supplier' )->getStyle('I5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('J5','Product' )->getStyle('J5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('K5','final_user' )->getStyle('K5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('L5','ticket_number' )->getStyle('L5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('M5','typo_of_ticket' )->getStyle('M5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('N5','date emission' )->getStyle('N5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('O5','city' )->getStyle('O5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('P5','country' )->getStyle('P5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('Q5','total emissions co2' )->getStyle('Q5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('R5','total_millas' )->getStyle('R5')->getFont()->setBold(true)->setSize(11);
		
		$activeSheet->setCellValue('S5','total_Itinerary1' )->getStyle('S5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('T5','origin1' )->getStyle('T5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('U5','destina1' )->getStyle('U5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('V5','aerolinea1' )->getStyle('V5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('W5','fecha_Salida_vu1' )->getStyle('W5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('X5','fecha_llegada1' )->getStyle('X5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('Y5','hora_salida_vu1' )->getStyle('Y5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('Z5','hora_llegada_vu1' )->getStyle('Z5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AA5','numero_vuelo1' )->getStyle('AA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AB5','clase_reservada1' )->getStyle('AB5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('AC5','total_Itinerary2' )->getStyle('AC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AD5','origin2' )->getStyle('AD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AE5','destina2' )->getStyle('AE5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('AF5','aerolinea2' )->getStyle('AF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AG5','fecha_Salida_vu2' )->getStyle('AG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AH5','fecha_llegada2' )->getStyle('AF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AI5','hora_salida_vu2' )->getStyle('AI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AJ5','hora_llegada_vu2' )->getStyle('AJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AK5','numero_vuelo2' )->getStyle('AK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AL5','clase_reservada2' )->getStyle('AL5')->getFont()->setBold(true)->setSize(11);


		$activeSheet->setCellValue('AM5','total_Itinerary3' )->getStyle('AM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AN5','origin3' )->getStyle('AN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AO5','destina3' )->getStyle('AO5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('AP5','aerolinea3' )->getStyle('AP5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AQ5','fecha_Salida_vu3' )->getStyle('AQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AR5','fecha_llegada3' )->getStyle('AR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AS5','hora_salida_vu3' )->getStyle('AS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AT5','hora_llegada_vu3' )->getStyle('AT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AU5','numero_vuelo3' )->getStyle('AU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AV5','clase_reservada3' )->getStyle('AV5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('AW5','total_Itinerary4' )->getStyle('AW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AX5','origin4' )->getStyle('AX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('AY5','destina4' )->getStyle('AY5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('AZ5','aerolinea4' )->getStyle('AZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BA5','fecha_Salida_vu4' )->getStyle('BA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BB5','fecha_llegada4' )->getStyle('BB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BC5','hora_salida_vu4' )->getStyle('BC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BD5','hora_llegada_vu4' )->getStyle('BD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BE5','numero_vuelo4' )->getStyle('BE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BF5','clase_reservada4' )->getStyle('BF5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('BG5','total_Itinerary5' )->getStyle('BG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BH5','origin5' )->getStyle('BH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BI5','destina5' )->getStyle('BI5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('BJ5','aerolinea5' )->getStyle('BJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BK5','fecha_Salida_vu5' )->getStyle('BK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BL5','fecha_llegada5' )->getStyle('BL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BM5','hora_salida_vu5' )->getStyle('BM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BN5','hora_llegada_vu5' )->getStyle('BN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BO5','numero_vuelo5' )->getStyle('BO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BP5','clase_reservada5' )->getStyle('BP5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('BQ5','total_Itinerary6' )->getStyle('BQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BR5','origin6' )->getStyle('BR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BS5','destina6' )->getStyle('BS5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('BT5','aerolinea6' )->getStyle('BT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BU5','fecha_Salida_vu6' )->getStyle('BU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BV5','fecha_llegada6' )->getStyle('BV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BW5','hora_salida_vu6' )->getStyle('BW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BX5','hora_llegada_vu6' )->getStyle('BX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BY5','numero_vuelo6' )->getStyle('BY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('BZ5','clase_reservada6' )->getStyle('BZ5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('CA5','total_Itinerary7' )->getStyle('CA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CB5','origin7' )->getStyle('CB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CC5','destina7' )->getStyle('CC5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('CD5','aerolinea7' )->getStyle('CD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CE5','fecha_Salida_vu7' )->getStyle('CE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CF5','fecha_llegada7' )->getStyle('CF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CG5','hora_salida_vu7' )->getStyle('CG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CH5','hora_llegada_vu7' )->getStyle('CH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CI5','numero_vuelo7' )->getStyle('CI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CJ5','clase_reservada7' )->getStyle('CJ5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('CK5','total_Itinerary8' )->getStyle('CK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CL5','origin8' )->getStyle('CL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CM5','destina8' )->getStyle('CM5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('CN5','aerolinea8' )->getStyle('CN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CO5','fecha_Salida_vu8' )->getStyle('CO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CP5','fecha_llegada8' )->getStyle('CP5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CQ5','hora_salida_vu8' )->getStyle('CQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CR5','hora_llegada_vu8' )->getStyle('CR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CS5','numero_vuelo8' )->getStyle('CS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CT5','clase_reservada8' )->getStyle('CT5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('CU5','total_Itinerary9' )->getStyle('CU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CV5','origin9' )->getStyle('CV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CW5','destina9' )->getStyle('CW5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('CX5','aerolinea9' )->getStyle('CX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CY5','fecha_Salida_vu9' )->getStyle('CY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('CZ5','fecha_llegada9' )->getStyle('CZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DA5','hora_salida_vu9' )->getStyle('DA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DB5','hora_llegada_vu9' )->getStyle('DB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DC5','numero_vuelo9' )->getStyle('DC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DD5','clase_reservada9' )->getStyle('DD5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('DE5','total_Itinerary10' )->getStyle('DE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DF5','origin10' )->getStyle('DF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DG5','destina10' )->getStyle('DG5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('DH5','aerolinea10' )->getStyle('DH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DI5','fecha_Salida_vu10' )->getStyle('DI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DJ5','fecha_llegada10' )->getStyle('DJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DK5','hora_salida_vu10' )->getStyle('DK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DL5','hora_llegada_vu10' )->getStyle('DL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DM5','numero_vuelo10' )->getStyle('DM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DN5','clase_reservada10' )->getStyle('DN5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('DO5','Name Hotel 1' )->getStyle('DO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DP5','Check In Date 1' )->getStyle('DP5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DQ5','Check Out Date 1' )->getStyle('DQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DR5','Room Nigth 1' )->getStyle('DR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DS5','Breakfast (BB /OB) 1' )->getStyle('DS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DT5','Nr of Rooms 1' )->getStyle('DT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DU5','id_habitacion1' )->getStyle('DU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DV5','City 1' )->getStyle('DV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DW5','country1' )->getStyle('DW5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('DX5','Name Hotel 2' )->getStyle('DX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DY5','Check In Date 2' )->getStyle('DY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('DZ5','Check Out Date 2' )->getStyle('DZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EA5','Room Nigth 2' )->getStyle('EA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EB5','Breakfast (BB /OB) 2' )->getStyle('EB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EC5','Nr of Rooms 2' )->getStyle('EC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('ED5','id_habitacion2' )->getStyle('ED5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EE5','City 2' )->getStyle('EE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EF5','country2' )->getStyle('EF5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('EG5','Name Hotel 3' )->getStyle('EG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EH5','Check In Date 3' )->getStyle('EH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EI5','Check Out Date 3' )->getStyle('EI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EJ5','Room Nigth 3' )->getStyle('EJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EK5','Breakfast (BB /OB) 3' )->getStyle('EK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EL5','Nr of Rooms 3' )->getStyle('EL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EM5','Type of Room 3' )->getStyle('EM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EN5','City 3' )->getStyle('EN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EO5','country3' )->getStyle('EO5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('EP5','Name Hotel 4' )->getStyle('EP5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EQ5','Check In Date 4' )->getStyle('EQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('ER5','Check Out Date 4' )->getStyle('ER5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('ES5','Room Nigth 4' )->getStyle('ES5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('ET5','Breakfast (BB /OB) 4' )->getStyle('ET5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EU5','Nr of Rooms 4' )->getStyle('EU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EV5','Type of Room 4' )->getStyle('EV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EW5','City 4' )->getStyle('EW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EX5','country4' )->getStyle('EX5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('EY5','Name Hotel 5' )->getStyle('EY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('EZ5','Check In Date 5' )->getStyle('EZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FA5','Check Out Date 5' )->getStyle('FA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FB5','Room Nigth 5' )->getStyle('FB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FC5','Breakfast (BB /OB) 5' )->getStyle('FC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FD5','Nr of Rooms 5' )->getStyle('FD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FE5','Type of Room 5' )->getStyle('FE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FF5','City 5' )->getStyle('FF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FG5','country5' )->getStyle('FG5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('FH5','Name Hotel 6' )->getStyle('FH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FI5','Check In Date 6' )->getStyle('FI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FJ5','Check Out Date 6' )->getStyle('FJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FK5','Room Nigth 6' )->getStyle('FK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FL5','Breakfast (BB /OB) 6' )->getStyle('FL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FM5','Nr of Rooms 6' )->getStyle('FM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FN5','Type of Room 6' )->getStyle('FN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FO5','City 6' )->getStyle('FO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FP5','country6' )->getStyle('FP5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('FQ5','Name Hotel 7' )->getStyle('FQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FR5','Check In Date 7' )->getStyle('FR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FS5','Check Out Date 7' )->getStyle('FS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FT5','Room Nigth 7' )->getStyle('FT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FU5','Breakfast (BB /OB) 7' )->getStyle('FU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FV5','Nr of Rooms 7' )->getStyle('FV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FW5','Type of Room 7' )->getStyle('FW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FX5','City 7' )->getStyle('FX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('FY5','country7' )->getStyle('FY5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('FZ5','Name Hotel 8' )->getStyle('FZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GA5','Check In Date 8' )->getStyle('GA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GB5','Check Out Date 8' )->getStyle('GB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GC5','Room Nigth 8' )->getStyle('GC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GD5','Breakfast (BB /OB) 8' )->getStyle('GD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GE5','Nr of Rooms 8' )->getStyle('GE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GF5','Type of Room 8' )->getStyle('GF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GG5','City 8' )->getStyle('GG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GH5','country8' )->getStyle('GH5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('GI5','Name Hotel 9' )->getStyle('GI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GJ5','Check In Date 9' )->getStyle('GJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GK5','Check Out Date 9' )->getStyle('GK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GL5','Room Nigth 9' )->getStyle('GL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GM5','Breakfast (BB /OB) 9' )->getStyle('GM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GN5','Nr of Rooms 9' )->getStyle('GN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GO5','Type of Room 9' )->getStyle('GO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GP5','City 9' )->getStyle('GP5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GQ5','country9' )->getStyle('GQ5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('GR5','Name Hotel 10' )->getStyle('GR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GS5','Check In Date 10' )->getStyle('GS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GT5','Check Out Date 10' )->getStyle('GT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GU5','Room Nigth 10' )->getStyle('GU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GV5','Breakfast (BB /OB) 10' )->getStyle('GV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GW5','Nr of Rooms 10' )->getStyle('GW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GX5','Type of Room 10' )->getStyle('GX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GY5','City 10' )->getStyle('GY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('GZ5','country10' )->getStyle('GZ5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('HA5','Car_class1' )->getStyle('HA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HB5','Delivery_Date1' )->getStyle('HB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HC5','Nr_days1' )->getStyle('HC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HD5','Place_delivery1' )->getStyle('HD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HE5','Place_delivery_back1' )->getStyle('HE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HF5','Departure_date1' )->getStyle('HF5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('HG5','Car_class2' )->getStyle('HG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HH5','Delivery_Date2' )->getStyle('HH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HI5','Nr_days2' )->getStyle('HI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HJ5','Place_delivery2' )->getStyle('HJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HK5','Place_delivery_back2' )->getStyle('HK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HL5','Departure_date2' )->getStyle('HL5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('HM5','Car_class3' )->getStyle('HM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HN5','Delivery_Date3' )->getStyle('HN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HO5','Nr_days3' )->getStyle('HO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HP5','Place_delivery3' )->getStyle('HP5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HQ5','Place_delivery_back3' )->getStyle('HQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HR5','Departure_date3' )->getStyle('HR5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('HS5','Car_class4' )->getStyle('HS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HT5','Delivery_Date4' )->getStyle('HT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HU5','Nr_days4' )->getStyle('HU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HV5','Place_delivery4' )->getStyle('HV5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HW5','Place_delivery_back4' )->getStyle('HW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HX5','Departure_date4' )->getStyle('HX5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('HY5','Car_class5' )->getStyle('HY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('HZ5','Delivery_Date5' )->getStyle('HZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IA5','Nr_days5' )->getStyle('IA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IB5','Place_delivery5' )->getStyle('IB5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IC5','Place_delivery_back5' )->getStyle('IC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('ID5','Departure_date5' )->getStyle('ID5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('IE5','Car_class6' )->getStyle('IE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IF5','Delivery_Date6' )->getStyle('IF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IG5','Nr_days6' )->getStyle('IG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IH5','Place_delivery6' )->getStyle('IH5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('II5','Place_delivery_back6' )->getStyle('II5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IJ5','Departure_date6' )->getStyle('IJ5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('IK5','Car_class7' )->getStyle('IK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IL5','Delivery_Date7' )->getStyle('IL5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IM5','Nr_days7' )->getStyle('IM5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IN5','Place_delivery7' )->getStyle('IN5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IO5','Place_delivery_back7' )->getStyle('IO5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IP5','Departure_date7' )->getStyle('IP5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('IQ5','Car_class8' )->getStyle('IQ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IR5','Delivery_Date8' )->getStyle('IR5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IS5','Nr_days8' )->getStyle('IS5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IT5','Place_delivery8' )->getStyle('IT5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IU5','Place_delivery_back8' )->getStyle('IU5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IV5','Departure_date8' )->getStyle('IV5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('IW5','Car_class9' )->getStyle('IW5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IX5','Delivery_Date9' )->getStyle('IX5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IY5','Nr_days9' )->getStyle('IY5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('IZ5','Place_delivery9' )->getStyle('IZ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JA5','Place_delivery_back9' )->getStyle('JA5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JB5','Departure_date9' )->getStyle('JB5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('JC5','Car_class10' )->getStyle('JC5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JD5','Delivery_Date10' )->getStyle('JD5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JE5','Nr_days10' )->getStyle('JE5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JF5','Place_delivery10' )->getStyle('JF5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JG5','Place_delivery_back10' )->getStyle('JG5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JH5','Departure_date10' )->getStyle('JH5')->getFont()->setBold(true)->setSize(11);

		$activeSheet->setCellValue('JI5','Air buy in advance' )->getStyle('JI5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JJ5','PNR' )->getStyle('JJ5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JK5','Fecha factura' )->getStyle('JK5')->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('JL5','EMD' )->getStyle('JK5')->getFont()->setBold(true)->setSize(11);
				
		$cont = 5;
		$str_razon_social = "";
		$str_corporativo = "";

		$array_consecutivo = array();
		$array_ticket_number = array();
		
		foreach ($rep as $clave => $valor) {

			$consecutivo = $valor->consecutivo;
			
			$str_razon_social = $str_razon_social . $valor->GVC_NOM_CLI . '/';
			$str_corporativo = $str_corporativo . $valor->GVC_ID_CORPORATIVO . '/';

			$ticket = utf8_encode($valor->ticket_number);
			$segmentos = $this->Mod_reportes_layout_seg->get_segmentos_ticket_number($ticket,$consecutivo);

			if(/*!in_array($consecutivo, $array_consecutivo) && */($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI' || $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT' || $valor->type_of_service == 'HOTNAC_RES' || $valor->type_of_service == 'HOTNAC_VARIOS')){

			    //if (!in_array($consecutivo, $array_consecutivo)) {

			 	if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI'){

					 	$cont++;

						$activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('D'.$cont ,$valor->destination )->getStyle('D'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('E'.$cont ,$valor->fecha_salida )->getStyle('E'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
						
						$activeSheet->setCellValue('H'.$cont ,$valor->type_of_service )->getStyle('H'.$cont)->getFont()->setBold(false);
						
						$activeSheet->setCellValue('I'.$cont ,$valor->supplier )->getStyle('I'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('J'.$cont ,$valor->codigo_producto )->getStyle('J'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('K'.$cont ,$valor->final_user )->getStyle('K'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('L'.$cont ,$valor->ticket_number )->getStyle('L'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('M'.$cont ,$valor->typo_of_ticket )->getStyle('M'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('N'.$cont ,$valor->fecha_emi )->getStyle('N'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('O'.$cont ,$valor->city )->getStyle('O'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('P'.$cont ,$valor->country )->getStyle('P'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('Q'.$cont ,$valor->total_emission )->getStyle('Q'.$cont)->getFont()->setBold(false);

						
						$millas = $this->lib_segmentos_millas->get_millas($segmentos);
						$activeSheet->setCellValue('R'.$cont ,$millas )->getStyle('R'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('JI'.$cont ,$valor->buy_in_advance )->getStyle('JI'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('JJ'.$cont ,$valor->record_localizador )->getStyle('JJ'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('JK'.$cont ,$valor->fecha_fac )->getStyle('JK'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('JL'.$cont ,$valor->emd )->getStyle('JK'.$cont)->getFont()->setBold(false);

						if($valor->emd == 'S'){

								
							for($x=19;$x<119;$x++){

								$letra = $this->lib_letras_excel->get_letra_excel($x);
								$activeSheet->setCellValue($letra.$cont,'')->getStyle($letra.$cont)->getFont()->setBold(false);

							}
					 

						}else{
							//******total Itenerary1
							if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('S'.$cont ,$scf)->getStyle('S'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('S'.$cont ,$scf)->getStyle('S'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('S'.$cont ,0 )->getStyle('S'.$cont)->getFont()->setBold(false);
							}

							//*******origin1
							if(array_key_exists(0, $segmentos)) {
									$id_ciudad_salida = $segmentos[0]['id_ciudad_salida'];
									$activeSheet->setCellValue('T'.$cont ,$id_ciudad_salida )->getStyle('T'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('T'.$cont ,$valor->origin1 )->getStyle('T'.$cont)->getFont()->setBold(false);
							}
							//******destina1
							if(array_key_exists(0, $segmentos)) {
									$id_ciudad_destino = $segmentos[0]['id_ciudad_destino'];
									$activeSheet->setCellValue('U'.$cont ,$id_ciudad_destino )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('U'.$cont ,$valor->destina1 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea1
							if(array_key_exists(0, $segmentos)) {
									$id_la = $segmentos[0]['id_la'];
									$activeSheet->setCellValue('V'.$cont ,$id_la )->getStyle('V'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('V'.$cont ,$valor->aerolinea1 )->getStyle('V'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu1
							if(array_key_exists(0, $segmentos)) {
									$fecha_salida = $segmentos[0]['fecha_salida'];
									$activeSheet->setCellValue('W'.$cont ,$fecha_salida )->getStyle('W'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('W'.$cont ,$valor->fecha_Salida_vu1 )->getStyle('W'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada1   falta logica
							if(array_key_exists(0, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[0]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[0]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[0]['fecha_salida'] ) ) ;
									
								}

								
								$activeSheet->setCellValue('X'.$cont ,$cambio_fecha_llegada )->getStyle('X'.$cont)->getFont()->setBold(false);


						 	}else{

								$activeSheet->setCellValue('X'.$cont ,$valor->fecha_llegada1 )->getStyle('X'.$cont)->getFont()->setBold(false);
							
							}
							//*****hora_salida_vu1
							if(array_key_exists(0, $segmentos)) {
									$hora_salida = $segmentos[0]['hora_salida'];
									$activeSheet->setCellValue('Y'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('Y'.$cont ,$valor->hora_salida_vu1 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu1
							if(array_key_exists(0, $segmentos)) {
									$hora_llegada = $segmentos[0]['hora_llegada'];
									$activeSheet->setCellValue('Z'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('Z'.$cont ,$valor->hora_llegada_vu1 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo1
							if(array_key_exists(0, $segmentos)) {
									$numero_vuelo = $segmentos[0]['numero_vuelo'];
									$activeSheet->setCellValue('AA'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('AA'.$cont ,$valor->numero_vuelo1 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada1
							if(array_key_exists(0, $segmentos)) {
								   $clase_reservada = $segmentos[0]['clase_reservada'];
								   $activeSheet->setCellValue('AB'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AB'.$cont ,$valor->clase_reservada1 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary2

							if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('AC'.$cont ,$tarifa_segmento)->getStyle('V'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('AC'.$cont ,$tarifa_segmento)->getStyle('V'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AC'.$cont ,0)->getStyle('V'.$cont)->getFont()->setBold(false);
							}
							//*******origin2
							if(array_key_exists(1, $segmentos)) {
									$id_ciudad_salida = $segmentos[1]['id_ciudad_salida'];
									$activeSheet->setCellValue('AD'.$cont ,$id_ciudad_salida)->getStyle('W'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AD'.$cont ,$valor->origin2)->getStyle('W'.$cont)->getFont()->setBold(false);
							}
							//******destina2
							if(array_key_exists(1, $segmentos)) {
									$id_ciudad_destino = $segmentos[1]['id_ciudad_destino'];
									$activeSheet->setCellValue('AE'.$cont ,$id_ciudad_destino)->getStyle('X'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AE'.$cont ,$valor->destina2)->getStyle('X'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea2
							if(array_key_exists(1, $segmentos)) {
									$id_la = $segmentos[1]['id_la'];
									$activeSheet->setCellValue('AF'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AF'.$cont ,$valor->aerolinea2 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu2
							if(array_key_exists(1, $segmentos)) {
									$fecha_salida = $segmentos[1]['fecha_salida'];
									$activeSheet->setCellValue('AG'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AG'.$cont ,$valor->fecha_Salida_vu2 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada2   falta logica
							
							if(array_key_exists(1, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[1]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[1]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[1]['fecha_salida'] ) ) ;
									
								}

								
								$activeSheet->setCellValue('AH'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);


						 	}else{

								$activeSheet->setCellValue('AH'.$cont ,$valor->fecha_llegada2 )->getStyle('U'.$cont)->getFont()->setBold(false);

							}
							//*****hora_salida_vu2
							if(array_key_exists(1, $segmentos)) {
									$hora_salida = $segmentos[1]['hora_salida'];
									$activeSheet->setCellValue('AI'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AI'.$cont ,$valor->hora_salida_vu2 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu2
							if(array_key_exists(1, $segmentos)) {
									$hora_llegada = $segmentos[1]['hora_llegada'];
									$activeSheet->setCellValue('AJ'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AJ'.$cont ,$valor->hora_llegada_vu2 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo2
							if(array_key_exists(1, $segmentos)) {
									$numero_vuelo = $segmentos[1]['numero_vuelo'];
									$activeSheet->setCellValue('AK'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('AK'.$cont ,$valor->numero_vuelo2 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada2
							if(array_key_exists(1, $segmentos)) {
								   $clase_reservada = $segmentos[1]['clase_reservada'];
								   $activeSheet->setCellValue('AL'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AL'.$cont ,$valor->clase_reservada2 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary3
							if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('AM'.$cont ,$scf)->getStyle('Y'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('AM'.$cont ,$scf)->getStyle('Y'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AM'.$cont ,0)->getStyle('Y'.$cont)->getFont()->setBold(false);
							}
							//*******origin3
							if(array_key_exists(2, $segmentos)) {
									$id_ciudad_salida = $segmentos[2]['id_ciudad_salida'];
									$activeSheet->setCellValue('AN'.$cont ,$id_ciudad_salida )->getStyle('Z'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('AN'.$cont ,$valor->origin3 )->getStyle('Z'.$cont)->getFont()->setBold(false);
							}
							//******destina3
							if(array_key_exists(2, $segmentos)) {
									$id_ciudad_destino = $segmentos[2]['id_ciudad_destino'];
									$activeSheet->setCellValue('AO'.$cont ,$id_ciudad_destino )->getStyle('AA'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AO'.$cont ,$valor->destina3 )->getStyle('AA'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea3
							if(array_key_exists(2, $segmentos)) {
									$id_la = $segmentos[2]['id_la'];
									$activeSheet->setCellValue('AP'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AP'.$cont ,$valor->aerolinea3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu3
							if(array_key_exists(2, $segmentos)) {
									$fecha_salida = $segmentos[2]['fecha_salida'];
									$activeSheet->setCellValue('AQ'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AQ'.$cont ,$valor->fecha_Salida_vu3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada3   falta logica
							if(array_key_exists(2, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[2]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[2]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[2]['fecha_salida'] ) ) ;
									
								}

								
								$activeSheet->setCellValue('AR'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);

						 	}else{

							
								$activeSheet->setCellValue('AR'.$cont ,$valor->fecha_llegada3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_salida_vu3
							if(array_key_exists(2, $segmentos)) {
									$hora_salida = $segmentos[2]['hora_salida'];
									$activeSheet->setCellValue('AS'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AS'.$cont ,$valor->hora_salida_vu3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu3
							if(array_key_exists(2, $segmentos)) {
									$hora_llegada = $segmentos[2]['hora_llegada'];
									$activeSheet->setCellValue('AT'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AT'.$cont ,$valor->hora_llegada_vu3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo3
							if(array_key_exists(2, $segmentos)) {
									$numero_vuelo = $segmentos[2]['numero_vuelo'];
									$activeSheet->setCellValue('AU'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AU'.$cont ,$valor->numero_vuelo3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada3

							if(array_key_exists(2, $segmentos)) {
								   $clase_reservada = $segmentos[2]['clase_reservada'];
								   $activeSheet->setCellValue('AV'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AV'.$cont ,$valor->clase_reservada3 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary4

							if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('AW'.$cont ,$scf)->getStyle('AB'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('AW'.$cont ,$scf)->getStyle('AB'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('AW'.$cont ,0 )->getStyle('AB'.$cont)->getFont()->setBold(false);
							}
							//*******origin4
							if(array_key_exists(3, $segmentos)) {
									$id_ciudad_salida = $segmentos[3]['id_ciudad_salida'];
									$activeSheet->setCellValue('AX'.$cont ,$id_ciudad_salida )->getStyle('AC'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('AX'.$cont ,$valor->origin4 )->getStyle('AC'.$cont)->getFont()->setBold(false);
							}
							
							//******destina4
							if(array_key_exists(3, $segmentos)) {
									$id_ciudad_destino = $segmentos[3]['id_ciudad_destino'];
									$activeSheet->setCellValue('AY'.$cont ,$id_ciudad_destino )->getStyle('AD'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AY'.$cont ,$valor->destina4 )->getStyle('AD'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea4
							if(array_key_exists(3, $segmentos)) {
									$id_la = $segmentos[3]['id_la'];
									$activeSheet->setCellValue('AZ'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('AZ'.$cont ,$valor->aerolinea4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu4
							if(array_key_exists(3, $segmentos)) {
									$fecha_salida = $segmentos[3]['fecha_salida'];
									$activeSheet->setCellValue('BA'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BA'.$cont ,$valor->fecha_Salida_vu4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada4   falta logica
							if(array_key_exists(3, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[3]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[3]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[3]['fecha_salida'] ) ) ;
									
								}

								
								
								$activeSheet->setCellValue('BB'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);

						 	}else{

								$activeSheet->setCellValue('BB'.$cont ,$valor->fecha_llegada4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_salida_vu4
							if(array_key_exists(3, $segmentos)) {
									$hora_salida = $segmentos[3]['hora_salida'];
									$activeSheet->setCellValue('BC'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BC'.$cont ,$valor->hora_salida_vu4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu4
							if(array_key_exists(3, $segmentos)) {
									$hora_llegada = $segmentos[3]['hora_llegada'];
									$activeSheet->setCellValue('BD'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BD'.$cont ,$valor->hora_llegada_vu4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo4
							if(array_key_exists(3, $segmentos)) {
									$numero_vuelo = $segmentos[3]['numero_vuelo'];
									$activeSheet->setCellValue('BE'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('BE'.$cont ,$valor->numero_vuelo4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}	
							//*****clase_reservada4
							if(array_key_exists(3, $segmentos)) {
								   $clase_reservada = $segmentos[3]['clase_reservada'];
								   $activeSheet->setCellValue('BF'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BF'.$cont ,$valor->clase_reservada4 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary5
							if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('BG'.$cont ,$scf)->getStyle('AE'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('BG'.$cont ,$scf)->getStyle('AE'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BG'.$cont ,0 )->getStyle('AE'.$cont)->getFont()->setBold(false);
							}
							//*******origin5
							if(array_key_exists(4, $segmentos)) {
									$id_ciudad_salida = $segmentos[4]['id_ciudad_salida'];
									$activeSheet->setCellValue('BH'.$cont ,$id_ciudad_salida )->getStyle('AF'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('BH'.$cont ,$valor->origin5 )->getStyle('AF'.$cont)->getFont()->setBold(false);
							}
							//******destina5
							if(array_key_exists(4, $segmentos)) {
									$id_ciudad_destino = $segmentos[4]['id_ciudad_destino'];
									$activeSheet->setCellValue('BI'.$cont ,$id_ciudad_destino )->getStyle('AG'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BI'.$cont ,$valor->destina5 )->getStyle('AG'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea5
							if(array_key_exists(4, $segmentos)) {
									$id_la = $segmentos[4]['id_la'];
									$activeSheet->setCellValue('BJ'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BJ'.$cont ,$valor->aerolinea5 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu5
							if(array_key_exists(4, $segmentos)) {
									$fecha_salida = $segmentos[4]['fecha_salida'];
									$activeSheet->setCellValue('BK'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BK'.$cont ,$valor->fecha_Salida_vu5 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada5   falta logica
							if(array_key_exists(4, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[4]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[4]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[4]['fecha_salida'] ) ) ;
									
								}

								
						
								$activeSheet->setCellValue('BL'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);

						 	}else{

						 		$activeSheet->setCellValue('BL'.$cont ,$valor->fecha_llegada5 )->getStyle('U'.$cont)->getFont()->setBold(false);
								
							}
							//*****hora_salida_vu5
							if(array_key_exists(4, $segmentos)) {
									$hora_salida = $segmentos[4]['hora_salida'];
									$activeSheet->setCellValue('BM'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BM'.$cont ,$valor->hora_salida_vu5 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu5
							if(array_key_exists(4, $segmentos)) {
									$hora_llegada = $segmentos[4]['hora_llegada'];
									$activeSheet->setCellValue('BN'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BN'.$cont ,$valor->hora_llegada_vu5 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo5
							if(array_key_exists(4, $segmentos)) {
									$numero_vuelo = $segmentos[4]['numero_vuelo'];
									$activeSheet->setCellValue('BO'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('BO'.$cont ,$valor->numero_vuelo5 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada5
							if(array_key_exists(4, $segmentos)) {
								   $clase_reservada = $segmentos[4]['clase_reservada'];
								   $activeSheet->setCellValue('BP'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								  $activeSheet->setCellValue('BP'.$cont ,$valor->clase_reservada5 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary6
							if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('BQ'.$cont ,$scf)->getStyle('AH'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('BQ'.$cont ,$scf)->getStyle('AH'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BQ'.$cont ,0 )->getStyle('AH'.$cont)->getFont()->setBold(false);
							}
							//*******origin6
							if(array_key_exists(5, $segmentos)) {
									$id_ciudad_salida = $segmentos[5]['id_ciudad_salida'];
									$activeSheet->setCellValue('BR'.$cont ,$id_ciudad_salida )->getStyle('AI'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('BR'.$cont ,$valor->origin6 )->getStyle('AI'.$cont)->getFont()->setBold(false);
							}
							//******destina6
							if(array_key_exists(5, $segmentos)) {
									$id_ciudad_destino = $segmentos[5]['id_ciudad_destino'];
									$activeSheet->setCellValue('BS'.$cont ,$id_ciudad_destino )->getStyle('AJ'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BS'.$cont ,$valor->destina6 )->getStyle('AJ'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea6
							if(array_key_exists(5, $segmentos)) {
									$id_la = $segmentos[5]['id_la'];
									$activeSheet->setCellValue('BT'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BT'.$cont ,$valor->aerolinea6 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu6
							if(array_key_exists(5, $segmentos)) {
									$fecha_salida = $segmentos[5]['fecha_salida'];
									$activeSheet->setCellValue('BU'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BU'.$cont ,$valor->fecha_Salida_vu6 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada6   falta logica
							if(array_key_exists(5, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[5]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[5]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[5]['fecha_salida'] ) ) ;
									
								}

								
								$activeSheet->setCellValue('BV'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);

						 	}else{

						 		$activeSheet->setCellValue('BV'.$cont ,$valor->fecha_llegada6 )->getStyle('U'.$cont)->getFont()->setBold(false);
								
							}
							//*****hora_salida_vu6
							if(array_key_exists(5, $segmentos)) {
									$hora_salida = $segmentos[5]['hora_salida'];
									$activeSheet->setCellValue('BW'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BW'.$cont ,$valor->hora_salida_vu6 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu6
							if(array_key_exists(5, $segmentos)) {
									$hora_llegada = $segmentos[5]['hora_llegada'];
									$activeSheet->setCellValue('BX'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('BX'.$cont ,$valor->hora_llegada_vu6 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo6
							if(array_key_exists(5, $segmentos)) {
									$numero_vuelo = $segmentos[5]['numero_vuelo'];
									$activeSheet->setCellValue('BY'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('BY'.$cont ,$valor->numero_vuelo6 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada6
							if(array_key_exists(5, $segmentos)) {
								   $clase_reservada = $segmentos[5]['clase_reservada'];
								   $activeSheet->setCellValue('BZ'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('BZ'.$cont ,$valor->clase_reservada6 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary7
							if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('CA'.$cont ,$scf)->getStyle('AK'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('CA'.$cont ,$scf)->getStyle('AK'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('CA'.$cont ,0 )->getStyle('AK'.$cont)->getFont()->setBold(false);
							}

							//*******origin7
							if(array_key_exists(6, $segmentos)) {
									$id_ciudad_salida = $segmentos[6]['id_ciudad_salida'];
									$activeSheet->setCellValue('CB'.$cont ,$id_ciudad_salida )->getStyle('AL'.$cont)->getFont()->setBold(false);

							}else{
								   $activeSheet->setCellValue('CB'.$cont ,$valor->origin7 )->getStyle('AL'.$cont)->getFont()->setBold(false);
							}
							//******destina7
							if(array_key_exists(6, $segmentos)) {
									$id_ciudad_destino = $segmentos[6]['id_ciudad_destino'];
									$activeSheet->setCellValue('CC'.$cont ,$id_ciudad_destino )->getStyle('AM'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CC'.$cont ,$valor->destina7 )->getStyle('AM'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea7
							if(array_key_exists(6, $segmentos)) {
									$id_la = $segmentos[6]['id_la'];
									$activeSheet->setCellValue('CD'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CD'.$cont ,$valor->aerolinea7 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu7
							if(array_key_exists(6, $segmentos)) {
									$fecha_salida = $segmentos[6]['fecha_salida'];
									$activeSheet->setCellValue('CE'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								  	$activeSheet->setCellValue('CE'.$cont ,$valor->fecha_Salida_vu7 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada7   falta logica
							if(array_key_exists(6, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[6]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[6]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[6]['fecha_salida'] ) ) ;
									
								}

								$activeSheet->setCellValue('CF'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);

						 	}else{

						 		$activeSheet->setCellValue('CF'.$cont ,$valor->fecha_llegada7 )->getStyle('U'.$cont)->getFont()->setBold(false);
								
							}
							//*****hora_salida_vu7
							if(array_key_exists(6, $segmentos)) {
									$hora_salida = $segmentos[6]['hora_salida'];
									$activeSheet->setCellValue('CG'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CG'.$cont ,$valor->hora_salida_vu7 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu7
							if(array_key_exists(6, $segmentos)) {
									$hora_llegada = $segmentos[6]['hora_llegada'];
									$activeSheet->setCellValue('CH'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CH'.$cont ,$valor->hora_llegada_vu7 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo7
							if(array_key_exists(6, $segmentos)) {
									$numero_vuelo = $segmentos[6]['numero_vuelo'];
									$activeSheet->setCellValue('CI'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('CI'.$cont ,$valor->numero_vuelo7 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada7
							if(array_key_exists(6, $segmentos)) {
								   $clase_reservada = $segmentos[6]['clase_reservada'];
								   $activeSheet->setCellValue('CJ'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('CJ'.$cont ,$valor->clase_reservada7 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary8

							if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('CK'.$cont ,$scf)->getStyle('AN'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('CK'.$cont ,$scf)->getStyle('AN'.$cont)->getFont()->setBold(false);
							}else{
								  $activeSheet->setCellValue('CK'.$cont ,0 )->getStyle('AN'.$cont)->getFont()->setBold(false);
							}
							//*******origin8
							if(array_key_exists(7, $segmentos)) {
									$id_ciudad_salida = $segmentos[7]['id_ciudad_salida'];
									$activeSheet->setCellValue('CL'.$cont ,$id_ciudad_salida )->getStyle('AO'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('CL'.$cont ,$valor->origin8 )->getStyle('AO'.$cont)->getFont()->setBold(false);
							}
							//******destina8
							if(array_key_exists(7, $segmentos)) {
									$id_ciudad_destino = $segmentos[7]['id_ciudad_destino'];
									$activeSheet->setCellValue('CM'.$cont ,$id_ciudad_destino )->getStyle('AP'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CM'.$cont ,$valor->destina8 )->getStyle('AP'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea8
							if(array_key_exists(7, $segmentos)) {
									$id_la = $segmentos[7]['id_la'];
									$activeSheet->setCellValue('CN'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CN'.$cont ,$valor->aerolinea8 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu8
							if(array_key_exists(7, $segmentos)) {
									$fecha_salida = $segmentos[7]['fecha_salida'];
								    $activeSheet->setCellValue('CO'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   	$activeSheet->setCellValue('CO'.$cont ,$valor->fecha_Salida_vu8 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada8   falta logica
							if(array_key_exists(7, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[7]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[7]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[7]['fecha_salida'] ) ) ;
									
								}

								$activeSheet->setCellValue('CP'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						 	}else{

						 		$activeSheet->setCellValue('CP'.$cont ,$valor->fecha_llegada8 )->getStyle('U'.$cont)->getFont()->setBold(false);
								
							}				
							//*****hora_salida_vu8
							if(array_key_exists(7, $segmentos)) {
									$hora_salida = $segmentos[7]['hora_salida'];
									$activeSheet->setCellValue('CQ'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CQ'.$cont ,$valor->hora_salida_vu8 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu8
							if(array_key_exists(7, $segmentos)) {
									$hora_llegada = $segmentos[7]['hora_llegada'];
									$activeSheet->setCellValue('CR'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CR'.$cont ,$valor->hora_llegada_vu8 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo8
							if(array_key_exists(7, $segmentos)) {
									$numero_vuelo = $segmentos[7]['numero_vuelo'];
									$activeSheet->setCellValue('CS'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('CS'.$cont ,$valor->numero_vuelo8 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada8
							if(array_key_exists(7, $segmentos)) {
								   $clase_reservada = $segmentos[7]['clase_reservada'];
								   $activeSheet->setCellValue('CT'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('CT'.$cont ,$valor->clase_reservada8 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary9
							if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('CU'.$cont ,$scf)->getStyle('AQ'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('CU'.$cont ,$scf)->getStyle('AQ'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('CU'.$cont ,0 )->getStyle('AQ'.$cont)->getFont()->setBold(false);
							}
							//*******origin9
							if(array_key_exists(8, $segmentos)) {
									$id_ciudad_salida = $segmentos[8]['id_ciudad_salida'];
									$activeSheet->setCellValue('CV'.$cont ,$id_ciudad_salida )->getStyle('AR'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('CV'.$cont ,$valor->origin9 )->getStyle('AR'.$cont)->getFont()->setBold(false);
							}
							//******destina9
							if(array_key_exists(8, $segmentos)) {
									$id_ciudad_destino = $segmentos[8]['id_ciudad_destino'];
									$activeSheet->setCellValue('CW'.$cont ,$id_ciudad_destino )->getStyle('AS'.$cont)->getFont()->setBold(false);	
							}else{
									$activeSheet->setCellValue('CW'.$cont ,$valor->destina9 )->getStyle('AS'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea9
							if(array_key_exists(8, $segmentos)) {
									$id_la = $segmentos[8]['id_la'];
									$activeSheet->setCellValue('CX'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('CX'.$cont ,$valor->aerolinea9 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu9
							if(array_key_exists(8, $segmentos)) {
									$fecha_salida = $segmentos[8]['fecha_salida'];
									$activeSheet->setCellValue('CY'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('CY'.$cont ,$valor->fecha_Salida_vu9 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada9   falta logica
							if(array_key_exists(8, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[8]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[8]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[8]['fecha_salida'] ) ) ;
									
								}

								$activeSheet->setCellValue('CZ'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						 	}else{

						 		$activeSheet->setCellValue('CZ'.$cont ,$valor->fecha_llegada9 )->getStyle('U'.$cont)->getFont()->setBold(false);
								
							}
							//*****hora_salida_vu9
							if(array_key_exists(8, $segmentos)) {
									$hora_salida = $segmentos[8]['hora_salida'];
									$activeSheet->setCellValue('DA'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('DA'.$cont ,$valor->hora_salida_vu9 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu9
							if(array_key_exists(8, $segmentos)) {
									$hora_llegada = $segmentos[8]['hora_llegada'];
									$activeSheet->setCellValue('DB'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('DB'.$cont ,$valor->hora_llegada_vu9 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo9
							if(array_key_exists(8, $segmentos)) {
									$numero_vuelo = $segmentos[8]['numero_vuelo'];
									$activeSheet->setCellValue('DC'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('DC'.$cont ,$valor->numero_vuelo9 )->getStyle('U'.$cont)->getFont()->setBold(false);
							} 
							//*****clase_reservada9
							if(array_key_exists(8, $segmentos)) {
								   $clase_reservada = $segmentos[8]['clase_reservada'];
								   $activeSheet->setCellValue('DD'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('DD'.$cont ,$valor->clase_reservada9 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//***********total_Itinerary10
							if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'I') {
									$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$tpo_cambio = $valor->tpo_cambio;
									$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
									$activeSheet->setCellValue('DE'.$cont ,$scf)->getStyle('AT'.$cont)->getFont()->setBold(false);
							}else if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'N'){
									$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
									$combustible = $valor->combustible;
									$scf = (int)$tarifa_segmento + (int)$combustible;
									$activeSheet->setCellValue('DE'.$cont ,$scf)->getStyle('AT'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('DE'.$cont ,0 )->getStyle('AT'.$cont)->getFont()->setBold(false);
							}
							//*******origin10
							if(array_key_exists(9, $segmentos)) {
									$id_ciudad_salida = $segmentos[9]['id_ciudad_salida'];
									$activeSheet->setCellValue('DF'.$cont ,$id_ciudad_salida )->getStyle('AU'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('DF'.$cont ,$valor->origin10 )->getStyle('AU'.$cont)->getFont()->setBold(false);
							}
							//******destina10
							if(array_key_exists(9, $segmentos)) {
									$id_ciudad_destino = $segmentos[9]['id_ciudad_destino'];
									$activeSheet->setCellValue('DG'.$cont ,$id_ciudad_destino )->getStyle('AV'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('DG'.$cont ,$valor->destina10 )->getStyle('AV'.$cont)->getFont()->setBold(false);
							}
							//*****aerolinea10
							if(array_key_exists(9, $segmentos)) {
									$id_la = $segmentos[9]['id_la'];
									$activeSheet->setCellValue('DH'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('DH'.$cont ,$valor->aerolinea10 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_Salida_vu10
							if(array_key_exists(9, $segmentos)) {
									$fecha_salida = $segmentos[9]['fecha_salida'];
									$activeSheet->setCellValue('DI'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('DI'.$cont ,$valor->fecha_Salida_vu10 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****fecha_llegada10   falta logica
							if(array_key_exists(9, $segmentos)) {

								$cambio_fecha_llegada = $segmentos[9]['cambio_fecha_llegada'];
								
								if($cambio_fecha_llegada == '0'){

									$cambio_fecha_llegada = $segmentos[9]['fecha_salida'];

								}else if($cambio_fecha_llegada == '1'){

									$cambio_fecha_llegada = strtotime ( '+1 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;

								}else if($cambio_fecha_llegada == '2'){

									$cambio_fecha_llegada = strtotime ( '+2 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '3'){

									$cambio_fecha_llegada = strtotime ( '+3 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '4'){

									$cambio_fecha_llegada = strtotime ( '-1 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
									
								}else if($cambio_fecha_llegada == '5'){

									$cambio_fecha_llegada = strtotime ( '-2 day' , strtotime ( $segmentos[9]['fecha_salida'] ) ) ;
									
								}

								$activeSheet->setCellValue('DJ'.$cont ,$cambio_fecha_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						 	}else{

						 		$activeSheet->setCellValue('DJ'.$cont ,$valor->fecha_llegada10 )->getStyle('U'.$cont)->getFont()->setBold(false);
								
							}
							//*****hora_salida_vu10
							if(array_key_exists(9, $segmentos)) {
									$hora_salida = $segmentos[9]['hora_salida'];
									$activeSheet->setCellValue('DK'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('DK'.$cont ,$valor->hora_salida_vu10 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****hora_llegada_vu10
							if(array_key_exists(9, $segmentos)) {
									$hora_llegada = $segmentos[9]['hora_llegada'];
									$activeSheet->setCellValue('DL'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
									$activeSheet->setCellValue('DL'.$cont ,$valor->hora_llegada_vu10 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****numero_vuelo10
							if(array_key_exists(9, $segmentos)) {
									$numero_vuelo = $segmentos[9]['numero_vuelo'];
									$activeSheet->setCellValue('DM'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								    $activeSheet->setCellValue('DM'.$cont ,$valor->numero_vuelo10 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}
							//*****clase_reservada10
							if(array_key_exists(9, $segmentos)) {
								   $clase_reservada = $segmentos[9]['clase_reservada'];
								   $activeSheet->setCellValue('DN'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
							}else{
								   $activeSheet->setCellValue('DN'.$cont ,$valor->clase_reservada10 )->getStyle('U'.$cont)->getFont()->setBold(false);
							}

							

						}// fin validacion emd




			 	}else{ // fin validacion bd bi

			 		if(!in_array($consecutivo, $array_consecutivo)){

					 	$cont++;

						$activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('D'.$cont ,$valor->destination )->getStyle('D'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('E'.$cont ,$valor->fecha_salida )->getStyle('E'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
						
						$activeSheet->setCellValue('H'.$cont ,$valor->type_of_service )->getStyle('H'.$cont)->getFont()->setBold(false);
						
						$activeSheet->setCellValue('I'.$cont ,$valor->supplier )->getStyle('I'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('J'.$cont ,$valor->codigo_producto )->getStyle('J'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('K'.$cont ,$valor->final_user )->getStyle('K'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('L'.$cont ,$valor->ticket_number )->getStyle('L'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('M'.$cont ,$valor->typo_of_ticket )->getStyle('M'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('N'.$cont ,$valor->fecha_emi )->getStyle('N'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('O'.$cont ,$valor->city )->getStyle('O'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('P'.$cont ,$valor->country )->getStyle('P'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('Q'.$cont ,$valor->total_emission )->getStyle('Q'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('R'.$cont ,$valor->total_millas )->getStyle('R'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('JI'.$cont ,$valor->buy_in_advance )->getStyle('JK'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('JJ'.$cont ,$valor->record_localizador )->getStyle('JL'.$cont)->getFont()->setBold(false);

						if($valor->emd == 'S'){

						$activeSheet->setCellValue('S'.$cont ,'' )->getStyle('S'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('T'.$cont ,'' )->getStyle('T'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('U'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('V'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('W'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('X'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('Y'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('Z'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AA'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AB'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);


						$activeSheet->setCellValue('AC'.$cont ,'')->getStyle('V'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AD'.$cont ,'')->getStyle('W'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AE'.$cont ,'')->getStyle('X'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('AF'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AG'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AH'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AI'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AJ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AK'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AL'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);


						$activeSheet->setCellValue('AM'.$cont ,'')->getStyle('Y'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AN'.$cont ,'' )->getStyle('Z'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AO'.$cont ,'' )->getStyle('AA'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('AP'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AQ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AR'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AS'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AT'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AU'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AV'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('AW'.$cont ,'' )->getStyle('AB'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AX'.$cont ,'' )->getStyle('AC'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('AY'.$cont ,'' )->getStyle('AD'.$cont)->getFont()->setBold(false);


						$activeSheet->setCellValue('AZ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BA'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BB'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BC'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BD'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BE'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BF'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('BG'.$cont ,'' )->getStyle('AE'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BH'.$cont ,'' )->getStyle('AF'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BI'.$cont ,'' )->getStyle('AG'.$cont)->getFont()->setBold(false);


						$activeSheet->setCellValue('BJ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BK'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BL'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BM'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BN'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BO'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BP'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('BQ'.$cont ,'' )->getStyle('AH'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BR'.$cont ,'' )->getStyle('AI'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BS'.$cont ,'' )->getStyle('AJ'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('BT'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BU'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BV'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BW'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BX'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BY'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('BZ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('CA'.$cont ,'' )->getStyle('AK'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CB'.$cont ,'' )->getStyle('AL'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CC'.$cont ,'' )->getStyle('AM'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('CD'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CE'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CF'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CG'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CH'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CI'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CJ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('CK'.$cont ,'' )->getStyle('AN'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CL'.$cont ,'' )->getStyle('AO'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CM'.$cont ,'' )->getStyle('AP'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('CN'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CO'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CP'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CQ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CR'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CS'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CT'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('CU'.$cont ,'' )->getStyle('AQ'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CV'.$cont ,'' )->getStyle('AR'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CW'.$cont ,'' )->getStyle('AS'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('CX'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CY'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('CZ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DA'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DB'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DC'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DD'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('DE'.$cont ,'' )->getStyle('AT'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DF'.$cont ,'' )->getStyle('AU'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DG'.$cont ,'' )->getStyle('AV'.$cont)->getFont()->setBold(false);

						$activeSheet->setCellValue('DH'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DI'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DJ'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DK'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DL'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DM'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('DN'.$cont ,'' )->getStyle('U'.$cont)->getFont()->setBold(false);

					}else{ //fin validacion emd



						if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'I') {
							$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;
							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							$activeSheet->setCellValue('S'.$cont ,$scf)->getStyle('S'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('S'.$cont ,$scf)->getStyle('S'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('S'.$cont ,0 )->getStyle('S'.$cont)->getFont()->setBold(false);
						}

						//*******origin1
						if(array_key_exists(0, $segmentos)) {
								$id_ciudad_salida = $segmentos[0]['id_ciudad_salida'];
								$activeSheet->setCellValue('T'.$cont ,$id_ciudad_salida )->getStyle('T'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('T'.$cont ,$valor->origin1 )->getStyle('T'.$cont)->getFont()->setBold(false);
						}
						//******destina1
						if(array_key_exists(0, $segmentos)) {
								$id_ciudad_destino = $segmentos[0]['id_ciudad_destino'];
								$activeSheet->setCellValue('U'.$cont ,$id_ciudad_destino )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('U'.$cont ,$valor->destina1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea1
						if(array_key_exists(0, $segmentos)) {
								$id_la = $segmentos[0]['id_la'];
								$activeSheet->setCellValue('V'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('V'.$cont ,$valor->aerolinea1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu1
						if(array_key_exists(0, $segmentos)) {
								$fecha_salida = $segmentos[0]['fecha_salida'];
								$activeSheet->setCellValue('W'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('W'.$cont ,$valor->fecha_Salida_vu1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada1   falta logica
						if(array_key_exists(0, $segmentos)) {
								$fecha_salida = $segmentos[0]['fecha_salida'];
								$activeSheet->setCellValue('X'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							$activeSheet->setCellValue('X'.$cont ,$valor->fecha_llegada1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu1
						if(array_key_exists(0, $segmentos)) {
								$hora_salida = $segmentos[0]['hora_salida'];
								$activeSheet->setCellValue('Y'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('Y'.$cont ,$valor->hora_salida_vu1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu1
						if(array_key_exists(0, $segmentos)) {
								$hora_llegada = $segmentos[0]['hora_llegada'];
								$activeSheet->setCellValue('Z'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('Z'.$cont ,$valor->hora_llegada_vu1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo1
						if(array_key_exists(0, $segmentos)) {
								$numero_vuelo = $segmentos[0]['numero_vuelo'];
								$activeSheet->setCellValue('AA'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AA'.$cont ,$valor->numero_vuelo1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada1
						if(array_key_exists(0, $segmentos)) {
							   $clase_reservada = $segmentos[0]['clase_reservada'];
							   $activeSheet->setCellValue('AB'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AB'.$cont ,$valor->clase_reservada1 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary2

						if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AC'.$cont ,$tarifa_segmento)->getStyle('V'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AC'.$cont ,$tarifa_segmento)->getStyle('V'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AC'.$cont ,0)->getStyle('V'.$cont)->getFont()->setBold(false);
						}
						//*******origin2
						if(array_key_exists(1, $segmentos)) {
								$id_ciudad_salida = $segmentos[1]['id_ciudad_salida'];
								$activeSheet->setCellValue('AD'.$cont ,$id_ciudad_salida)->getStyle('W'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AD'.$cont ,$valor->origin2)->getStyle('W'.$cont)->getFont()->setBold(false);
						}
						//******destina2
						if(array_key_exists(1, $segmentos)) {
								$id_ciudad_destino = $segmentos[1]['id_ciudad_destino'];
								$activeSheet->setCellValue('AE'.$cont ,$id_ciudad_destino)->getStyle('X'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AE'.$cont ,$valor->destina2)->getStyle('X'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea2
						if(array_key_exists(1, $segmentos)) {
								$id_la = $segmentos[1]['id_la'];
								$activeSheet->setCellValue('AF'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AF'.$cont ,$valor->aerolinea2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu2
						if(array_key_exists(1, $segmentos)) {
								$fecha_salida = $segmentos[1]['fecha_salida'];
								$activeSheet->setCellValue('AG'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AG'.$cont ,$valor->fecha_Salida_vu2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada2   falta logica
						if(array_key_exists(1, $segmentos)) {
								$fecha_salida = $segmentos[1]['fecha_salida'];
								$activeSheet->setCellValue('AH'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							$activeSheet->setCellValue('AH'.$cont ,$valor->fecha_llegada2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu2
						if(array_key_exists(1, $segmentos)) {
								$hora_salida = $segmentos[1]['hora_salida'];
								$activeSheet->setCellValue('AI'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AI'.$cont ,$valor->hora_salida_vu2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu2
						if(array_key_exists(1, $segmentos)) {
								$hora_llegada = $segmentos[1]['hora_llegada'];
								$activeSheet->setCellValue('AJ'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AJ'.$cont ,$valor->hora_llegada_vu2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo2
						if(array_key_exists(1, $segmentos)) {
								$numero_vuelo = $segmentos[1]['numero_vuelo'];
								$activeSheet->setCellValue('AK'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AK'.$cont ,$valor->numero_vuelo2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada2
						if(array_key_exists(1, $segmentos)) {
							   $clase_reservada = $segmentos[1]['clase_reservada'];
							   $activeSheet->setCellValue('AL'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AL'.$cont ,$valor->clase_reservada2 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary3
						if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AM'.$cont ,$scf)->getStyle('Y'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AM'.$cont ,$scf)->getStyle('Y'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AM'.$cont ,0)->getStyle('Y'.$cont)->getFont()->setBold(false);
						}
						//*******origin3
						if(array_key_exists(2, $segmentos)) {
								$id_ciudad_salida = $segmentos[2]['id_ciudad_salida'];
								$activeSheet->setCellValue('AN'.$cont ,$id_ciudad_salida )->getStyle('Z'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AN'.$cont ,$valor->origin3 )->getStyle('Z'.$cont)->getFont()->setBold(false);
						}
						//******destina3
						if(array_key_exists(2, $segmentos)) {
								$id_ciudad_destino = $segmentos[2]['id_ciudad_destino'];
								$activeSheet->setCellValue('AO'.$cont ,$id_ciudad_destino )->getStyle('AA'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AO'.$cont ,$valor->destina3 )->getStyle('AA'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea3
						if(array_key_exists(2, $segmentos)) {
								$id_la = $segmentos[2]['id_la'];
								$activeSheet->setCellValue('AP'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AP'.$cont ,$valor->aerolinea3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu3
						if(array_key_exists(2, $segmentos)) {
								$fecha_salida = $segmentos[2]['fecha_salida'];
								$activeSheet->setCellValue('AQ'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AQ'.$cont ,$valor->fecha_Salida_vu3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada3   falta logica
						if(array_key_exists(2, $segmentos)) {
								$fecha_salida = $segmentos[2]['fecha_salida'];
								$activeSheet->setCellValue('AR'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							$activeSheet->setCellValue('AR'.$cont ,$valor->fecha_llegada3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu3
						if(array_key_exists(2, $segmentos)) {
								$hora_salida = $segmentos[2]['hora_salida'];
								$activeSheet->setCellValue('AS'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AS'.$cont ,$valor->hora_salida_vu3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu3
						if(array_key_exists(2, $segmentos)) {
								$hora_llegada = $segmentos[2]['hora_llegada'];
								$activeSheet->setCellValue('AT'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AT'.$cont ,$valor->hora_llegada_vu3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo3
						if(array_key_exists(2, $segmentos)) {
								$numero_vuelo = $segmentos[2]['numero_vuelo'];
								$activeSheet->setCellValue('AU'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AU'.$cont ,$valor->numero_vuelo3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada3

						if(array_key_exists(2, $segmentos)) {
							   $clase_reservada = $segmentos[2]['clase_reservada'];
							   $activeSheet->setCellValue('AV'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AV'.$cont ,$valor->clase_reservada3 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary4

						if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AW'.$cont ,$scf)->getStyle('AB'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AW'.$cont ,$scf)->getStyle('AB'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AW'.$cont ,0 )->getStyle('AB'.$cont)->getFont()->setBold(false);
						}
						//*******origin4
						if(array_key_exists(3, $segmentos)) {
								$id_ciudad_salida = $segmentos[3]['id_ciudad_salida'];
								$activeSheet->setCellValue('AX'.$cont ,$id_ciudad_salida )->getStyle('AC'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AX'.$cont ,$valor->origin4 )->getStyle('AC'.$cont)->getFont()->setBold(false);
						}
						
						//******destina4
						if(array_key_exists(3, $segmentos)) {
								$id_ciudad_destino = $segmentos[3]['id_ciudad_destino'];
								$activeSheet->setCellValue('AY'.$cont ,$id_ciudad_destino )->getStyle('AD'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AY'.$cont ,$valor->destina4 )->getStyle('AD'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea4
						if(array_key_exists(3, $segmentos)) {
								$id_la = $segmentos[3]['id_la'];
								$activeSheet->setCellValue('AZ'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AZ'.$cont ,$valor->aerolinea4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu4
						if(array_key_exists(3, $segmentos)) {
								$fecha_salida = $segmentos[3]['fecha_salida'];
								$activeSheet->setCellValue('BA'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BA'.$cont ,$valor->fecha_Salida_vu4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada4   falta logica
						if(array_key_exists(3, $segmentos)) {
								$fecha_salida = $segmentos[3]['fecha_salida'];
								$activeSheet->setCellValue('BB'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							$activeSheet->setCellValue('BB'.$cont ,$valor->fecha_llegada4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu4
						if(array_key_exists(3, $segmentos)) {
								$hora_salida = $segmentos[3]['hora_salida'];
								$activeSheet->setCellValue('BC'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BC'.$cont ,$valor->hora_salida_vu4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu4
						if(array_key_exists(3, $segmentos)) {
								$hora_llegada = $segmentos[3]['hora_llegada'];
								$activeSheet->setCellValue('BD'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BD'.$cont ,$valor->hora_llegada_vu4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo4
						if(array_key_exists(3, $segmentos)) {
								$numero_vuelo = $segmentos[3]['numero_vuelo'];
								$activeSheet->setCellValue('BE'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('BE'.$cont ,$valor->numero_vuelo4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}	
						//*****clase_reservada4
						if(array_key_exists(3, $segmentos)) {
							   $clase_reservada = $segmentos[3]['clase_reservada'];
							   $activeSheet->setCellValue('BF'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BF'.$cont ,$valor->clase_reservada4 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary5
						if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('BG'.$cont ,$scf)->getStyle('AE'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('BG'.$cont ,$scf)->getStyle('AE'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BG'.$cont ,0 )->getStyle('AE'.$cont)->getFont()->setBold(false);
						}
						//*******origin5
						if(array_key_exists(4, $segmentos)) {
								$id_ciudad_salida = $segmentos[4]['id_ciudad_salida'];
								$activeSheet->setCellValue('BH'.$cont ,$id_ciudad_salida )->getStyle('AF'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('BH'.$cont ,$valor->origin5 )->getStyle('AF'.$cont)->getFont()->setBold(false);
						}
						//******destina5
						if(array_key_exists(4, $segmentos)) {
								$id_ciudad_destino = $segmentos[4]['id_ciudad_destino'];
								$activeSheet->setCellValue('BI'.$cont ,$id_ciudad_destino )->getStyle('AG'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BI'.$cont ,$valor->destina5 )->getStyle('AG'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea5
						if(array_key_exists(4, $segmentos)) {
								$id_la = $segmentos[4]['id_la'];
								$activeSheet->setCellValue('BJ'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BJ'.$cont ,$valor->aerolinea5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu5
						if(array_key_exists(4, $segmentos)) {
								$fecha_salida = $segmentos[4]['fecha_salida'];
								$activeSheet->setCellValue('BK'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BK'.$cont ,$valor->fecha_Salida_vu5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada5   falta logica
						if(array_key_exists(4, $segmentos)) {
								$fecha_salida = $segmentos[4]['fecha_salida'];
								$activeSheet->setCellValue('BL'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							$activeSheet->setCellValue('BL'.$cont ,$valor->fecha_llegada5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu5
						if(array_key_exists(4, $segmentos)) {
								$hora_salida = $segmentos[4]['hora_salida'];
								$activeSheet->setCellValue('BM'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BM'.$cont ,$valor->hora_salida_vu5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu5
						if(array_key_exists(4, $segmentos)) {
								$hora_llegada = $segmentos[4]['hora_llegada'];
								$activeSheet->setCellValue('BN'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BN'.$cont ,$valor->hora_llegada_vu5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo5
						if(array_key_exists(4, $segmentos)) {
								$numero_vuelo = $segmentos[4]['numero_vuelo'];
								$activeSheet->setCellValue('BO'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('BO'.$cont ,$valor->numero_vuelo5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada5
						if(array_key_exists(4, $segmentos)) {
							   $clase_reservada = $segmentos[4]['clase_reservada'];
							   $activeSheet->setCellValue('BP'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							  $activeSheet->setCellValue('BP'.$cont ,$valor->clase_reservada5 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary6
						if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('BQ'.$cont ,$scf)->getStyle('AH'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('BQ'.$cont ,$scf)->getStyle('AH'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BQ'.$cont ,0 )->getStyle('AH'.$cont)->getFont()->setBold(false);
						}
						//*******origin6
						if(array_key_exists(5, $segmentos)) {
								$id_ciudad_salida = $segmentos[5]['id_ciudad_salida'];
								$activeSheet->setCellValue('BR'.$cont ,$id_ciudad_salida )->getStyle('AI'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('BR'.$cont ,$valor->origin6 )->getStyle('AI'.$cont)->getFont()->setBold(false);
						}
						//******destina6
						if(array_key_exists(5, $segmentos)) {
								$id_ciudad_destino = $segmentos[5]['id_ciudad_destino'];
								$activeSheet->setCellValue('BS'.$cont ,$id_ciudad_destino )->getStyle('AJ'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BS'.$cont ,$valor->destina6 )->getStyle('AJ'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea6
						if(array_key_exists(5, $segmentos)) {
								$id_la = $segmentos[5]['id_la'];
								$activeSheet->setCellValue('BT'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BT'.$cont ,$valor->aerolinea6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu6
						if(array_key_exists(5, $segmentos)) {
								$fecha_salida = $segmentos[5]['fecha_salida'];
								$activeSheet->setCellValue('BU'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BU'.$cont ,$valor->fecha_Salida_vu6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada6   falta logica
						if(array_key_exists(5, $segmentos)) {
								$fecha_salida = $segmentos[5]['fecha_salida'];
								$activeSheet->setCellValue('BV'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							$activeSheet->setCellValue('BV'.$cont ,$valor->fecha_llegada6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu6
						if(array_key_exists(5, $segmentos)) {
								$hora_salida = $segmentos[5]['hora_salida'];
								$activeSheet->setCellValue('BW'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BW'.$cont ,$valor->hora_salida_vu6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu6
						if(array_key_exists(5, $segmentos)) {
								$hora_llegada = $segmentos[5]['hora_llegada'];
								$activeSheet->setCellValue('BX'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('BX'.$cont ,$valor->hora_llegada_vu6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo6
						if(array_key_exists(5, $segmentos)) {
								$numero_vuelo = $segmentos[5]['numero_vuelo'];
								$activeSheet->setCellValue('BY'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('BY'.$cont ,$valor->numero_vuelo6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada6
						if(array_key_exists(5, $segmentos)) {
							   $clase_reservada = $segmentos[5]['clase_reservada'];
							   $activeSheet->setCellValue('BZ'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('BZ'.$cont ,$valor->clase_reservada6 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary7
						if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('CA'.$cont ,$scf)->getStyle('AK'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('CA'.$cont ,$scf)->getStyle('AK'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('CA'.$cont ,0 )->getStyle('AK'.$cont)->getFont()->setBold(false);
						}

						//*******origin7
						if(array_key_exists(6, $segmentos)) {
								$id_ciudad_salida = $segmentos[6]['id_ciudad_salida'];
								$activeSheet->setCellValue('CB'.$cont ,$id_ciudad_salida )->getStyle('AL'.$cont)->getFont()->setBold(false);

						}else{
							   $activeSheet->setCellValue('CB'.$cont ,$valor->origin7 )->getStyle('AL'.$cont)->getFont()->setBold(false);
						}
						//******destina7
						if(array_key_exists(6, $segmentos)) {
								$id_ciudad_destino = $segmentos[6]['id_ciudad_destino'];
								$activeSheet->setCellValue('CC'.$cont ,$id_ciudad_destino )->getStyle('AM'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CC'.$cont ,$valor->destina7 )->getStyle('AM'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea7
						if(array_key_exists(6, $segmentos)) {
								$id_la = $segmentos[6]['id_la'];
								$activeSheet->setCellValue('CD'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CD'.$cont ,$valor->aerolinea7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu7
						if(array_key_exists(6, $segmentos)) {
								$fecha_salida = $segmentos[6]['fecha_salida'];
								$activeSheet->setCellValue('CE'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							  	$activeSheet->setCellValue('CE'.$cont ,$valor->fecha_Salida_vu7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada7   falta logica
						if(array_key_exists(6, $segmentos)) {
								$fecha_salida = $segmentos[6]['fecha_salida'];
								$activeSheet->setCellValue('CF'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CF'.$cont ,$valor->fecha_llegada7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu7
						if(array_key_exists(6, $segmentos)) {
								$hora_salida = $segmentos[6]['hora_salida'];
								$activeSheet->setCellValue('CG'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CG'.$cont ,$valor->hora_salida_vu7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu7
						if(array_key_exists(6, $segmentos)) {
								$hora_llegada = $segmentos[6]['hora_llegada'];
								$activeSheet->setCellValue('CH'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CH'.$cont ,$valor->hora_llegada_vu7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo7
						if(array_key_exists(6, $segmentos)) {
								$numero_vuelo = $segmentos[6]['numero_vuelo'];
								$activeSheet->setCellValue('CI'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('CI'.$cont ,$valor->numero_vuelo7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada7
						if(array_key_exists(6, $segmentos)) {
							   $clase_reservada = $segmentos[6]['clase_reservada'];
							   $activeSheet->setCellValue('CJ'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('CJ'.$cont ,$valor->clase_reservada7 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary8

						if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('CK'.$cont ,$vscf)->getStyle('AN'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('CK'.$cont ,$vscf)->getStyle('AN'.$cont)->getFont()->setBold(false);
						}else{
							  $activeSheet->setCellValue('CK'.$cont ,0 )->getStyle('AN'.$cont)->getFont()->setBold(false);
						}
						//*******origin8
						if(array_key_exists(7, $segmentos)) {
								$id_ciudad_salida = $segmentos[7]['id_ciudad_salida'];
								$activeSheet->setCellValue('CL'.$cont ,$id_ciudad_salida )->getStyle('AO'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('CL'.$cont ,$valor->origin8 )->getStyle('AO'.$cont)->getFont()->setBold(false);
						}
						//******destina8
						if(array_key_exists(7, $segmentos)) {
								$id_ciudad_destino = $segmentos[7]['id_ciudad_destino'];
								$activeSheet->setCellValue('CM'.$cont ,$id_ciudad_destino )->getStyle('AP'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CM'.$cont ,$valor->destina8 )->getStyle('AP'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea8
						if(array_key_exists(7, $segmentos)) {
								$id_la = $segmentos[7]['id_la'];
								$activeSheet->setCellValue('CN'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CN'.$cont ,$valor->aerolinea8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu8
						if(array_key_exists(7, $segmentos)) {
								$fecha_salida = $segmentos[7]['fecha_salida'];
							    $activeSheet->setCellValue('CO'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   	$activeSheet->setCellValue('CO'.$cont ,$valor->fecha_Salida_vu8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada8   falta logica
						if(array_key_exists(7, $segmentos)) {
								$fecha_salida = $segmentos[7]['fecha_salida'];
								$activeSheet->setCellValue('CP'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CP'.$cont ,$valor->fecha_llegada8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}					
						//*****hora_salida_vu8
						if(array_key_exists(7, $segmentos)) {
								$hora_salida = $segmentos[7]['hora_salida'];
								$activeSheet->setCellValue('CQ'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CQ'.$cont ,$valor->hora_salida_vu8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu8
						if(array_key_exists(7, $segmentos)) {
								$hora_llegada = $segmentos[7]['hora_llegada'];
								$activeSheet->setCellValue('CR'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CR'.$cont ,$valor->hora_llegada_vu8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo8
						if(array_key_exists(7, $segmentos)) {
								$numero_vuelo = $segmentos[7]['numero_vuelo'];
								$activeSheet->setCellValue('CS'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('CS'.$cont ,$valor->numero_vuelo8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada8
						if(array_key_exists(7, $segmentos)) {
							   $clase_reservada = $segmentos[7]['clase_reservada'];
							   $activeSheet->setCellValue('CT'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('CT'.$cont ,$valor->clase_reservada8 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary9
						if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('CU'.$cont ,$scf)->getStyle('AQ'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('CU'.$cont ,$scf)->getStyle('AQ'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('CU'.$cont ,0 )->getStyle('AQ'.$cont)->getFont()->setBold(false);
						}
						//*******origin9
						if(array_key_exists(8, $segmentos)) {
								$id_ciudad_salida = $segmentos[8]['id_ciudad_salida'];
								$activeSheet->setCellValue('CV'.$cont ,$id_ciudad_salida )->getStyle('AR'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('CV'.$cont ,$valor->origin9 )->getStyle('AR'.$cont)->getFont()->setBold(false);
						}
						//******destina9
						if(array_key_exists(8, $segmentos)) {
								$id_ciudad_destino = $segmentos[8]['id_ciudad_destino'];
								$activeSheet->setCellValue('CW'.$cont ,$id_ciudad_destino )->getStyle('AS'.$cont)->getFont()->setBold(false);	
						}else{
								$activeSheet->setCellValue('CW'.$cont ,$valor->destina9 )->getStyle('AS'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea9
						if(array_key_exists(8, $segmentos)) {
								$id_la = $segmentos[8]['id_la'];
								$activeSheet->setCellValue('CX'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('CX'.$cont ,$valor->aerolinea9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu9
						if(array_key_exists(8, $segmentos)) {
								$fecha_salida = $segmentos[8]['fecha_salida'];
								$activeSheet->setCellValue('CY'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('CY'.$cont ,$valor->fecha_Salida_vu9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada9   falta logica
						if(array_key_exists(8, $segmentos)) {
								$fecha_salida = $segmentos[8]['fecha_salida'];
								
								$activeSheet->setCellValue('CZ'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							
								$activeSheet->setCellValue('CZ'.$cont ,$valor->fecha_llegada9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu9
						if(array_key_exists(8, $segmentos)) {
								$hora_salida = $segmentos[8]['hora_salida'];
								$activeSheet->setCellValue('DA'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DA'.$cont ,$valor->hora_salida_vu9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu9
						if(array_key_exists(8, $segmentos)) {
								$hora_llegada = $segmentos[8]['hora_llegada'];
								$activeSheet->setCellValue('DB'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DB'.$cont ,$valor->hora_llegada_vu9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo9
						if(array_key_exists(8, $segmentos)) {
								$numero_vuelo = $segmentos[8]['numero_vuelo'];
								$activeSheet->setCellValue('DC'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('DC'.$cont ,$valor->numero_vuelo9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						} 
						//*****clase_reservada9
						if(array_key_exists(8, $segmentos)) {
							   $clase_reservada = $segmentos[8]['clase_reservada'];
							   $activeSheet->setCellValue('DD'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('DD'.$cont ,$valor->clase_reservada9 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//***********total_Itinerary10
						if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('DE'.$cont ,$scf)->getStyle('AT'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('DE'.$cont ,$scf,2)->getStyle('AT'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('DE'.$cont ,0 )->getStyle('AT'.$cont)->getFont()->setBold(false);
						}
						//*******origin10
						if(array_key_exists(9, $segmentos)) {
								$id_ciudad_salida = $segmentos[9]['id_ciudad_salida'];
								$activeSheet->setCellValue('DF'.$cont ,$id_ciudad_salida )->getStyle('AU'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('DF'.$cont ,$valor->origin10 )->getStyle('AU'.$cont)->getFont()->setBold(false);
						}
						//******destina10
						if(array_key_exists(9, $segmentos)) {
								$id_ciudad_destino = $segmentos[9]['id_ciudad_destino'];
								$activeSheet->setCellValue('DG'.$cont ,$id_ciudad_destino )->getStyle('AV'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DG'.$cont ,$valor->destina10 )->getStyle('AV'.$cont)->getFont()->setBold(false);
						}
						//*****aerolinea10
						if(array_key_exists(9, $segmentos)) {
								$id_la = $segmentos[9]['id_la'];
								$activeSheet->setCellValue('DH'.$cont ,$id_la )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DH'.$cont ,$valor->aerolinea10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_Salida_vu10
						if(array_key_exists(9, $segmentos)) {
								$fecha_salida = $segmentos[9]['fecha_salida'];
								$activeSheet->setCellValue('DI'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('DI'.$cont ,$valor->fecha_Salida_vu10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****fecha_llegada10   falta logica
						if(array_key_exists(9, $segmentos)) {
								$fecha_salida = $segmentos[9]['fecha_salida'];
								$activeSheet->setCellValue('DJ'.$cont ,$fecha_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DJ'.$cont ,$valor->fecha_llegada10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_salida_vu10
						if(array_key_exists(9, $segmentos)) {
								$hora_salida = $segmentos[9]['hora_salida'];
								$activeSheet->setCellValue('DK'.$cont ,$hora_salida )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DK'.$cont ,$valor->hora_salida_vu10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****hora_llegada_vu10
						if(array_key_exists(9, $segmentos)) {
								$hora_llegada = $segmentos[9]['hora_llegada'];
								$activeSheet->setCellValue('DL'.$cont ,$hora_llegada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('DL'.$cont ,$valor->hora_llegada_vu10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****numero_vuelo10
						if(array_key_exists(9, $segmentos)) {
								$numero_vuelo = $segmentos[9]['numero_vuelo'];
								$activeSheet->setCellValue('DM'.$cont ,$numero_vuelo )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('DM'.$cont ,$valor->numero_vuelo10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}
						//*****clase_reservada10
						if(array_key_exists(9, $segmentos)) {
							   $clase_reservada = $segmentos[9]['clase_reservada'];
							   $activeSheet->setCellValue('DN'.$cont ,$clase_reservada )->getStyle('U'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('DN'.$cont ,$valor->clase_reservada10 )->getStyle('U'.$cont)->getFont()->setBold(false);
						}

					 } // fin else emd



			 	   } // fin validacion consecutivo

			 	}// fin else bd bi
				
			    
			 //} //fin validacion consecutivo general

				//****************HOTELE IRIS*******************

				if( !in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTNAC'){

						$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('N'.$cont ,$valor->fecha_fac )->getStyle('N'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);
						//*********************************************
						$fecha1 = $parametros["fecha1"];
      					$fecha2 = $parametros["fecha2"];

						if($fecha1 == ""){
						          $hoy = getdate();
						          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
						          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
						          $year = $hoy['year'];
						          $fecha1 = $year.'-'.$mes.'-'.$dia;
						          $fecha2 = $year.'-'.$mes.'-'.$dia;
						        
						      }else{
						          
						          $array_fecha1 = explode('/', $fecha1);
						          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
						          $array_fecha2 = explode('/', $fecha2);
						          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
						         
						      }

					    $fac_numero = $valor->documento;
					    $id_serie = utf8_encode($valor->id_serie);
				        $hoteles_iris_arr = $this->Mod_reportes_layout_seg->get_hoteles_iris($fac_numero,$fecha1,$fecha2,$id_serie);
					    //**********************HOTEL 1


					    if(isset($hoteles_iris_arr[0]['servicio'])){
					    	$activeSheet->setCellValue('DO'.$cont ,$hoteles_iris_arr[0]['servicio'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DO'.$cont ,'')->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DP'.$cont ,$hoteles_iris_arr[0]['fecha_entrada'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DP'.$cont ,'')->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['fecha_salida'])){
					    	$activeSheet->setCellValue('DQ'.$cont ,$hoteles_iris_arr[0]['fecha_salida'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DQ'.$cont ,'')->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['noches'])){
					    	$activeSheet->setCellValue('DR'.$cont ,$hoteles_iris_arr[0]['noches'] )->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DR'.$cont ,'')->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['break_fast'])){
					    	$activeSheet->setCellValue('DS'.$cont ,$hoteles_iris_arr[0]['break_fast'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DS'.$cont ,'')->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['cantidad'])){
					    	$activeSheet->setCellValue('DT'.$cont ,$hoteles_iris_arr[0]['cantidad'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DT'.$cont ,'')->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['id_habitacion'])){
					    	$activeSheet->setCellValue('DU'.$cont ,$hoteles_iris_arr[0]['id_habitacion'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DU'.$cont ,'')->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['id_ciudad'])){
					    	$activeSheet->setCellValue('DV'.$cont ,$hoteles_iris_arr[0]['id_ciudad'] )->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DV'.$cont ,'')->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['country'])){
					    	$activeSheet->setCellValue('DW'.$cont ,$hoteles_iris_arr[0]['country'] )->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DW'.$cont ,'')->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }
		                 //**********************HOTEL 2
					    if(isset($hoteles_iris_arr[1]['nombre_hotel'])){
					    	$activeSheet->setCellValue('DX'.$cont ,$hoteles_iris_arr[1]['nombre_hotel'] )->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DX'.$cont ,'')->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DY'.$cont ,$hoteles_iris_arr[1]['fecha_entrada'] )->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DY'.$cont ,'')->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['fecha_salida'])){
					    	$activeSheet->setCellValue('DZ'.$cont ,$hoteles_iris_arr[1]['fecha_salida'] )->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DZ'.$cont ,'')->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['noches'])){
					    	$activeSheet->setCellValue('EA'.$cont ,$hoteles_iris_arr[1]['noches'] )->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EA'.$cont ,'')->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['break_fast'])){
					    	$activeSheet->setCellValue('EB'.$cont ,$hoteles_iris_arr[1]['break_fast'] )->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EB'.$cont ,'')->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['cantidad'])){
					    	$activeSheet->setCellValue('EC'.$cont ,$hoteles_iris_arr[1]['cantidad'] )->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EC'.$cont ,'')->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['id_habitacion'])){
					    	$activeSheet->setCellValue('ED'.$cont ,$hoteles_iris_arr[1]['id_habitacion'] )->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ED'.$cont ,'')->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['id_ciudad'])){
					    	$activeSheet->setCellValue('EE'.$cont ,$hoteles_iris_arr[1]['id_ciudad'] )->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EE'.$cont ,'')->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['country'])){
					    	$activeSheet->setCellValue('EF'.$cont ,$hoteles_iris_arr[1]['country'] )->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EF'.$cont ,'')->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 3
					    if(isset($hoteles_iris_arr[2]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EG'.$cont ,$hoteles_iris_arr[2]['nombre_hotel'] )->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EG'.$cont ,'')->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EH'.$cont ,$hoteles_iris_arr[2]['fecha_entrada'] )->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EH'.$cont ,'')->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['fecha_salida'])){
					    	$activeSheet->setCellValue('EI'.$cont ,$hoteles_iris_arr[2]['fecha_salida'] )->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EI'.$cont ,'')->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['noches'])){
					    	$activeSheet->setCellValue('EJ'.$cont ,$hoteles_iris_arr[2]['noches'] )->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EJ'.$cont ,'')->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['break_fast'])){
					    	$activeSheet->setCellValue('EK'.$cont ,$hoteles_iris_arr[2]['break_fast'] )->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EK'.$cont ,'')->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['cantidad'])){
					    	$activeSheet->setCellValue('EL'.$cont ,$hoteles_iris_arr[2]['cantidad'] )->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EL'.$cont ,'')->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['id_habitacion'])){
					    	$activeSheet->setCellValue('EM'.$cont ,$hoteles_iris_arr[2]['id_habitacion'] )->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EM'.$cont ,'')->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['id_ciudad'])){
					    	$activeSheet->setCellValue('EN'.$cont ,$hoteles_iris_arr[2]['id_ciudad'] )->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EN'.$cont ,'')->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['country'])){
					    	$activeSheet->setCellValue('EO'.$cont ,$hoteles_iris_arr[2]['country'] )->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EO'.$cont ,'')->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 4
					    if(isset($hoteles_iris_arr[3]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EP'.$cont ,$hoteles_iris_arr[3]['nombre_hotel'] )->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EP'.$cont ,'')->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EQ'.$cont ,$hoteles_iris_arr[3]['fecha_entrada'] )->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EQ'.$cont ,'')->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['fecha_salida'])){
					    	$activeSheet->setCellValue('ER'.$cont ,$hoteles_iris_arr[3]['fecha_salida'] )->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ER'.$cont ,'')->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['noches'])){
					    	$activeSheet->setCellValue('ES'.$cont ,$hoteles_iris_arr[3]['noches'] )->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ES'.$cont ,'')->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['break_fast'])){
					    	$activeSheet->setCellValue('ET'.$cont ,$hoteles_iris_arr[3]['break_fast'] )->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ET'.$cont ,'')->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['cantidad'])){
					    	$activeSheet->setCellValue('EU'.$cont ,$hoteles_iris_arr[3]['cantidad'] )->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EU'.$cont ,'')->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['id_habitacion'])){
					    	$activeSheet->setCellValue('EV'.$cont ,$hoteles_iris_arr[3]['id_habitacion'] )->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EV'.$cont ,'')->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['id_ciudad'])){
					    	$activeSheet->setCellValue('EW'.$cont ,$hoteles_iris_arr[3]['id_ciudad'] )->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EW'.$cont ,'')->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['country'])){
					    	$activeSheet->setCellValue('EX'.$cont ,$hoteles_iris_arr[3]['country'] )->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EX'.$cont ,'')->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 5
					    if(isset($hoteles_iris_arr[4]['servicio'])){
					    	$activeSheet->setCellValue('EY'.$cont ,$hoteles_iris_arr[4]['servicio'] )->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EY'.$cont ,'')->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EZ'.$cont ,$hoteles_iris_arr[4]['fecha_entrada'] )->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EZ'.$cont ,'')->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['fecha_salida'])){
					    	$activeSheet->setCellValue('FA'.$cont ,$hoteles_iris_arr[4]['fecha_salida'] )->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FA'.$cont ,'')->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['noches'])){
					    	$activeSheet->setCellValue('FB'.$cont ,$hoteles_iris_arr[4]['noches'] )->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FB'.$cont ,'')->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['break_fast'])){
					    	$activeSheet->setCellValue('FC'.$cont ,$hoteles_iris_arr[4]['break_fast'] )->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FC'.$cont ,'')->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['cantidad'])){
					    	$activeSheet->setCellValue('FD'.$cont ,$hoteles_iris_arr[4]['cantidad'] )->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FD'.$cont ,'')->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['id_habitacion'])){
					    	$activeSheet->setCellValue('FE'.$cont ,$hoteles_iris_arr[4]['id_habitacion'] )->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FE'.$cont ,'')->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['id_ciudad'])){
					    	$activeSheet->setCellValue('FF'.$cont ,$hoteles_iris_arr[4]['id_ciudad'] )->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FF'.$cont ,'')->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['country'])){
					    	$activeSheet->setCellValue('FG'.$cont ,$hoteles_iris_arr[4]['country'] )->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FG'.$cont ,'')->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 6
					    if(isset($hoteles_iris_arr[5]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FH'.$cont ,$hoteles_iris_arr[5]['nombre_hotel'] )->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FH'.$cont ,'')->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FI'.$cont ,$hoteles_iris_arr[5]['fecha_entrada'] )->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FI'.$cont ,'')->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['fecha_salida'])){
					    	$activeSheet->setCellValue('FJ'.$cont ,$hoteles_iris_arr[5]['fecha_salida'] )->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FJ'.$cont ,'')->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['noches'])){
					    	$activeSheet->setCellValue('FK'.$cont ,$hoteles_iris_arr[5]['noches'] )->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FK'.$cont ,'')->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['break_fast'])){
					    	$activeSheet->setCellValue('FL'.$cont ,$hoteles_iris_arr[5]['break_fast'] )->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FL'.$cont ,'')->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['cantidad'])){
					    	$activeSheet->setCellValue('FM'.$cont ,$hoteles_iris_arr[5]['cantidad'] )->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FM'.$cont ,'')->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['id_habitacion'])){
					    	$activeSheet->setCellValue('FN'.$cont ,$hoteles_iris_arr[5]['id_habitacion'] )->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FN'.$cont ,'')->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['id_ciudad'])){
					    	$activeSheet->setCellValue('FO'.$cont ,$hoteles_iris_arr[5]['id_ciudad'] )->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FO'.$cont ,'')->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['country'])){
					    	$activeSheet->setCellValue('FP'.$cont ,$hoteles_iris_arr[5]['country'] )->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FP'.$cont ,'')->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 7
					    if(isset($hoteles_iris_arr[6]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FQ'.$cont ,$hoteles_iris_arr[6]['nombre_hotel'] )->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FQ'.$cont ,'')->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FR'.$cont ,$hoteles_iris_arr[6]['fecha_entrada'] )->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FR'.$cont ,'')->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['fecha_salida'])){
					    	$activeSheet->setCellValue('FS'.$cont ,$hoteles_iris_arr[6]['fecha_salida'] )->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FS'.$cont ,'')->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['noches'])){
					    	$activeSheet->setCellValue('FT'.$cont ,$hoteles_iris_arr[6]['noches'] )->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FT'.$cont ,'')->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['break_fast'])){
					    	$activeSheet->setCellValue('FU'.$cont ,$hoteles_iris_arr[6]['break_fast'] )->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FU'.$cont ,'')->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['cantidad'])){
					    	$activeSheet->setCellValue('FV'.$cont ,$hoteles_iris_arr[6]['cantidad'] )->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FV'.$cont ,'')->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['id_habitacion'])){
					    	$activeSheet->setCellValue('FW'.$cont ,$hoteles_iris_arr[6]['id_habitacion'] )->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FW'.$cont ,'')->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['id_ciudad'])){
					    	$activeSheet->setCellValue('FX'.$cont ,$hoteles_iris_arr[6]['id_ciudad'] )->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FX'.$cont ,'')->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['country'])){
					    	$activeSheet->setCellValue('FY'.$cont ,$hoteles_iris_arr[6]['country'] )->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FY'.$cont ,'')->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 8
					    if(isset($hoteles_iris_arr[7]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FZ'.$cont ,$hoteles_iris_arr[7]['nombre_hotel'] )->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FZ'.$cont ,'')->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GA'.$cont ,$hoteles_iris_arr[7]['fecha_entrada'] )->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GA'.$cont ,'')->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['fecha_salida'])){
					    	$activeSheet->setCellValue('GB'.$cont ,$hoteles_iris_arr[7]['fecha_salida'] )->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GB'.$cont ,'')->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['noches'])){
					    	$activeSheet->setCellValue('GC'.$cont ,$hoteles_iris_arr[7]['noches'] )->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GC'.$cont ,'')->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['break_fast'])){
					    	$activeSheet->setCellValue('GD'.$cont ,$hoteles_iris_arr[7]['break_fast'] )->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GD'.$cont ,'')->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['cantidad'])){
					    	$activeSheet->setCellValue('GE'.$cont ,$hoteles_iris_arr[7]['cantidad'] )->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GE'.$cont ,'')->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['id_habitacion'])){
					    	$activeSheet->setCellValue('GF'.$cont ,$hoteles_iris_arr[7]['id_habitacion'] )->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GF'.$cont ,'')->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['id_ciudad'])){
					    	$activeSheet->setCellValue('GG'.$cont ,$hoteles_iris_arr[7]['id_ciudad'] )->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GG'.$cont ,'')->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['country'])){
					    	$activeSheet->setCellValue('GH'.$cont ,$hoteles_iris_arr[7]['country'] )->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GH'.$cont ,'')->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 9
					    if(isset($hoteles_iris_arr[8]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GI'.$cont ,$hoteles_iris_arr[8]['nombre_hotel'] )->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GI'.$cont ,'')->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GJ'.$cont ,$hoteles_iris_arr[8]['fecha_entrada'] )->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GJ'.$cont ,'')->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['fecha_salida'])){
					    	$activeSheet->setCellValue('GK'.$cont ,$hoteles_iris_arr[8]['fecha_salida'] )->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GK'.$cont ,'')->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['noches'])){
					    	$activeSheet->setCellValue('GL'.$cont ,$hoteles_iris_arr[8]['noches'] )->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GL'.$cont ,'')->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['break_fast'])){
					    	$activeSheet->setCellValue('GM'.$cont ,$hoteles_iris_arr[8]['break_fast'] )->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GM'.$cont ,'')->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['cantidad'])){
					    	$activeSheet->setCellValue('GN'.$cont ,$hoteles_iris_arr[8]['cantidad'] )->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GN'.$cont ,'')->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['id_habitacion'])){
					    	$activeSheet->setCellValue('GO'.$cont ,$hoteles_iris_arr[8]['id_habitacion'] )->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GO'.$cont ,'')->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['id_ciudad'])){
					    	$activeSheet->setCellValue('GP'.$cont ,$hoteles_iris_arr[8]['id_ciudad'] )->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GP'.$cont ,'')->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['country'])){
					    	$activeSheet->setCellValue('GQ'.$cont ,$hoteles_iris_arr[8]['country'] )->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GQ'.$cont ,'')->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }
					     //**********************HOTEL 9
					    if(isset($hoteles_iris_arr[9]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GR'.$cont ,$hoteles_iris_arr[9]['nombre_hotel'] )->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GR'.$cont ,'')->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GS'.$cont ,$hoteles_iris_arr[9]['fecha_entrada'] )->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GS'.$cont ,'')->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['fecha_salida'])){
					    	$activeSheet->setCellValue('GT'.$cont ,$hoteles_iris_arr[9]['fecha_salida'] )->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GT'.$cont ,'')->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['noches'])){
					    	$activeSheet->setCellValue('GU'.$cont ,$hoteles_iris_arr[9]['noches'] )->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GU'.$cont ,'')->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['break_fast'])){
					    	$activeSheet->setCellValue('GV'.$cont ,$hoteles_iris_arr[9]['break_fast'] )->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GV'.$cont ,'')->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['cantidad'])){
					    	$activeSheet->setCellValue('GW'.$cont ,$hoteles_iris_arr[9]['cantidad'] )->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GW'.$cont ,'')->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['id_habitacion'])){
					    	$activeSheet->setCellValue('GX'.$cont ,$hoteles_iris_arr[9]['id_habitacion'] )->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GX'.$cont ,'')->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['id_ciudad'])){
					    	$activeSheet->setCellValue('GY'.$cont ,$hoteles_iris_arr[9]['id_ciudad'] )->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GY'.$cont ,'')->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['country'])){
					    	$activeSheet->setCellValue('GZ'.$cont ,$hoteles_iris_arr[9]['country'] )->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GZ'.$cont ,'')->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }

					    $autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);  

						//**********************Autos 1
					    if(isset($autos_arr[0]['tipo_auto'])){
					    	$activeSheet->setCellValue('HA'.$cont ,$autos_arr[0]['tipo_auto'] )->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HA'.$cont ,'')->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HB'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HB'.$cont ,'')->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['dias'])){
					    	$activeSheet->setCellValue('HC'.$cont ,$autos_arr[0]['dias'] )->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HC'.$cont ,'')->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HD'.$cont ,$autos_arr[0]['id_ciudad_entrega'] )->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HD'.$cont ,'')->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HE'.$cont ,$autos_arr[0]['id_ciudad_recoge'] )->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HE'.$cont ,'')->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HF'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HF'.$cont ,'')->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[1]['tipo_auto'])){
					    	$activeSheet->setCellValue('HG'.$cont ,$autos_arr[1]['tipo_auto'] )->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HG'.$cont ,'')->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HH'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HH'.$cont ,'')->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['dias'])){
					    	$activeSheet->setCellValue('HI'.$cont ,$autos_arr[1]['dias'] )->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HI'.$cont ,'')->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HJ'.$cont ,$autos_arr[1]['id_ciudad_entrega'] )->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HJ'.$cont ,'')->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HK'.$cont ,$autos_arr[1]['id_ciudad_recoge'] )->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HK'.$cont ,'')->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HL'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HL'.$cont ,'')->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[2]['tipo_auto'])){
					    	$activeSheet->setCellValue('HM'.$cont ,$autos_arr[2]['tipo_auto'] )->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HM'.$cont ,'')->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HN'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HN'.$cont ,'')->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['dias'])){
					    	$activeSheet->setCellValue('HO'.$cont ,$autos_arr[2]['dias'] )->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HO'.$cont ,'')->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HP'.$cont ,$autos_arr[2]['id_ciudad_entrega'] )->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HP'.$cont ,'')->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HQ'.$cont ,$autos_arr[2]['id_ciudad_recoge'] )->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HQ'.$cont ,'')->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HR'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HR'.$cont ,'')->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[3]['tipo_auto'])){
					    	$activeSheet->setCellValue('HS'.$cont ,$autos_arr[3]['tipo_auto'] )->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HS'.$cont ,'')->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HT'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HT'.$cont ,'')->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['dias'])){
					    	$activeSheet->setCellValue('HU'.$cont ,$autos_arr[3]['dias'] )->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HU'.$cont ,'')->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HV'.$cont ,$autos_arr[3]['id_ciudad_entrega'] )->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HV'.$cont ,'')->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HW'.$cont ,$autos_arr[3]['id_ciudad_recoge'] )->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HW'.$cont ,'')->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HX'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HX'.$cont ,'')->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[4]['tipo_auto'])){
					    	$activeSheet->setCellValue('HY'.$cont ,$autos_arr[4]['tipo_auto'] )->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HY'.$cont ,'')->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HZ'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HZ'.$cont ,'')->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['dias'])){
					    	$activeSheet->setCellValue('IA'.$cont ,$autos_arr[4]['dias'] )->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IA'.$cont ,'')->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IB'.$cont ,$autos_arr[4]['id_ciudad_entrega'] )->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IB'.$cont ,'')->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IC'.$cont ,$autos_arr[4]['id_ciudad_recoge'] )->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IC'.$cont ,'')->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('ID'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ID'.$cont ,'')->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[5]['tipo_auto'])){
					    	$activeSheet->setCellValue('IE'.$cont ,$autos_arr[5]['tipo_auto'] )->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IE'.$cont ,'')->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IF'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IF'.$cont ,'')->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['dias'])){
					    	$activeSheet->setCellValue('IG'.$cont ,$autos_arr[5]['dias'] )->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IG'.$cont ,'')->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IH'.$cont ,$autos_arr[5]['id_ciudad_entrega'] )->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IH'.$cont ,'')->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('II'.$cont ,$autos_arr[5]['id_ciudad_recoge'] )->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('II'.$cont ,'')->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IJ'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IJ'.$cont ,'')->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[6]['tipo_auto'])){
					    	$activeSheet->setCellValue('IK'.$cont ,$autos_arr[6]['tipo_auto'] )->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IK'.$cont ,'')->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IL'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IL'.$cont ,'')->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['dias'])){
					    	$activeSheet->setCellValue('IM'.$cont ,$autos_arr[6]['dias'] )->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IM'.$cont ,'')->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IN'.$cont ,$autos_arr[6]['id_ciudad_entrega'] )->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IN'.$cont ,'')->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IO'.$cont ,$autos_arr[6]['id_ciudad_recoge'] )->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IO'.$cont ,'')->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IP'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IP'.$cont ,'')->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[7]['tipo_auto'])){
					    	$activeSheet->setCellValue('IQ'.$cont ,$autos_arr[7]['tipo_auto'] )->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IQ'.$cont ,'')->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IR'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IR'.$cont ,'')->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['dias'])){
					    	$activeSheet->setCellValue('IS'.$cont ,$autos_arr[7]['dias'] )->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IS'.$cont ,'')->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IT'.$cont ,$autos_arr[7]['id_ciudad_entrega'] )->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IT'.$cont ,'')->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IU'.$cont ,$autos_arr[7]['id_ciudad_recoge'] )->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IU'.$cont ,'')->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IV'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IV'.$cont ,'')->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[8]['tipo_auto'])){
					    	$activeSheet->setCellValue('IW'.$cont ,$autos_arr[8]['tipo_auto'] )->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IW'.$cont ,'')->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IX'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IX'.$cont ,'')->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['dias'])){
					    	$activeSheet->setCellValue('IY'.$cont ,$autos_arr[8]['dias'] )->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IY'.$cont ,'')->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IZ'.$cont ,$autos_arr[8]['id_ciudad_entrega'] )->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IZ'.$cont ,'')->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JA'.$cont ,$autos_arr[8]['id_ciudad_recoge'] )->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JA'.$cont ,'')->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JB'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JB'.$cont ,'')->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[9]['tipo_auto'])){
					    	$activeSheet->setCellValue('JC'.$cont ,$autos_arr[9]['tipo_auto'] )->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JC'.$cont ,'')->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JD'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JD'.$cont ,'')->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['dias'])){
					    	$activeSheet->setCellValue('JE'.$cont ,$autos_arr[9]['dias'] )->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JE'.$cont ,'')->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('JF'.$cont ,$autos_arr[9]['id_ciudad_entrega'] )->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JF'.$cont ,'')->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JG'.$cont ,$autos_arr[9]['id_ciudad_recoge'] )->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JG'.$cont ,'')->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JH'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JH'.$cont ,'')->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }


				}else if(!in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTINT'){

					    $activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
					    $activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);
						//*********************************************
					    $fac_numero = $valor->documento;
					    $id_serie = utf8_encode($valor->id_serie);
				        $hoteles_iris_arr = $this->Mod_reportes_layout_seg->get_hoteles_iris($fac_numero,$fecha1,$fecha2,$id_serie);
					    //**********************HOTEL 1
					    if(isset($hoteles_iris_arr[0]['servicio'])){
					    	$activeSheet->setCellValue('DO'.$cont ,$hoteles_iris_arr[0]['servicio'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DO'.$cont ,'')->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DP'.$cont ,$hoteles_iris_arr[0]['fecha_entrada'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DP'.$cont ,'')->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['fecha_salida'])){
					    	$activeSheet->setCellValue('DQ'.$cont ,$hoteles_iris_arr[0]['fecha_salida'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DQ'.$cont ,'')->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['noches'])){
					    	$activeSheet->setCellValue('DR'.$cont ,$hoteles_iris_arr[0]['noches'] )->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DR'.$cont ,'')->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['break_fast'])){
					    	$activeSheet->setCellValue('DS'.$cont ,$hoteles_iris_arr[0]['break_fast'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DS'.$cont ,'')->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['numero_hab'])){
					    	$activeSheet->setCellValue('DT'.$cont ,$hoteles_iris_arr[0]['numero_hab'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DT'.$cont ,'')->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['id_habitacion'])){
					    	$activeSheet->setCellValue('DU'.$cont ,$hoteles_iris_arr[0]['id_habitacion'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DU'.$cont ,'')->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['id_ciudad'])){
					    	$activeSheet->setCellValue('DV'.$cont ,$hoteles_iris_arr[0]['id_ciudad'] )->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DV'.$cont ,'')->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[0]['country'])){
					    	$activeSheet->setCellValue('DW'.$cont ,$hoteles_iris_arr[0]['country'] )->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DW'.$cont ,'')->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }
		                 //**********************HOTEL 2
					    if(isset($hoteles_iris_arr[1]['nombre_hotel'])){
					    	$activeSheet->setCellValue('DX'.$cont ,$hoteles_iris_arr[1]['nombre_hotel'] )->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DX'.$cont ,'')->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DY'.$cont ,$hoteles_iris_arr[1]['fecha_entrada'] )->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DY'.$cont ,'')->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['fecha_salida'])){
					    	$activeSheet->setCellValue('DZ'.$cont ,$hoteles_iris_arr[1]['fecha_salida'] )->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DZ'.$cont ,'')->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['noches'])){
					    	$activeSheet->setCellValue('EA'.$cont ,$hoteles_iris_arr[1]['noches'] )->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EA'.$cont ,'')->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['break_fast'])){
					    	$activeSheet->setCellValue('EB'.$cont ,$hoteles_iris_arr[1]['break_fast'] )->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EB'.$cont ,'')->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['numero_hab'])){
					    	$activeSheet->setCellValue('EC'.$cont ,$hoteles_iris_arr[1]['numero_hab'] )->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EC'.$cont ,'')->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['id_habitacion'])){
					    	$activeSheet->setCellValue('ED'.$cont ,$hoteles_iris_arr[1]['id_habitacion'] )->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ED'.$cont ,'')->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['id_ciudad'])){
					    	$activeSheet->setCellValue('EE'.$cont ,$hoteles_iris_arr[1]['id_ciudad'] )->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EE'.$cont ,'')->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[1]['country'])){
					    	$activeSheet->setCellValue('EF'.$cont ,$hoteles_iris_arr[1]['country'] )->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EF'.$cont ,'')->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 3
					    if(isset($hoteles_iris_arr[2]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EG'.$cont ,$hoteles_iris_arr[2]['nombre_hotel'] )->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EG'.$cont ,'')->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EH'.$cont ,$hoteles_iris_arr[2]['fecha_entrada'] )->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EH'.$cont ,'')->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['fecha_salida'])){
					    	$activeSheet->setCellValue('EI'.$cont ,$hoteles_iris_arr[2]['fecha_salida'] )->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EI'.$cont ,'')->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['noches'])){
					    	$activeSheet->setCellValue('EJ'.$cont ,$hoteles_iris_arr[2]['noches'] )->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EJ'.$cont ,'')->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['break_fast'])){
					    	$activeSheet->setCellValue('EK'.$cont ,$hoteles_iris_arr[2]['break_fast'] )->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EK'.$cont ,'')->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['numero_hab'])){
					    	$activeSheet->setCellValue('EL'.$cont ,$hoteles_iris_arr[2]['numero_hab'] )->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EL'.$cont ,'')->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['id_habitacion'])){
					    	$activeSheet->setCellValue('EM'.$cont ,$hoteles_iris_arr[2]['id_habitacion'] )->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EM'.$cont ,'')->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['id_ciudad'])){
					    	$activeSheet->setCellValue('EN'.$cont ,$hoteles_iris_arr[2]['id_ciudad'] )->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EN'.$cont ,'')->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[2]['country'])){
					    	$activeSheet->setCellValue('EO'.$cont ,$hoteles_iris_arr[2]['country'] )->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EO'.$cont ,'')->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 4
					    if(isset($hoteles_iris_arr[3]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EP'.$cont ,$hoteles_iris_arr[3]['nombre_hotel'] )->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EP'.$cont ,'')->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EQ'.$cont ,$hoteles_iris_arr[3]['fecha_entrada'] )->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EQ'.$cont ,'')->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['fecha_salida'])){
					    	$activeSheet->setCellValue('ER'.$cont ,$hoteles_iris_arr[3]['fecha_salida'] )->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ER'.$cont ,'')->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['noches'])){
					    	$activeSheet->setCellValue('ES'.$cont ,$hoteles_iris_arr[3]['noches'] )->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ES'.$cont ,'')->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['break_fast'])){
					    	$activeSheet->setCellValue('ET'.$cont ,$hoteles_iris_arr[3]['break_fast'] )->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ET'.$cont ,'')->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['numero_hab'])){
					    	$activeSheet->setCellValue('EU'.$cont ,$hoteles_iris_arr[3]['numero_hab'] )->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EU'.$cont ,'')->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['id_habitacion'])){
					    	$activeSheet->setCellValue('EV'.$cont ,$hoteles_iris_arr[3]['id_habitacion'] )->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EV'.$cont ,'')->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['id_ciudad'])){
					    	$activeSheet->setCellValue('EW'.$cont ,$hoteles_iris_arr[3]['id_ciudad'] )->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EW'.$cont ,'')->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[3]['country'])){
					    	$activeSheet->setCellValue('EX'.$cont ,$hoteles_iris_arr[3]['country'] )->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EX'.$cont ,'')->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 5
					    if(isset($hoteles_iris_arr[4]['servicio'])){
					    	$activeSheet->setCellValue('EY'.$cont ,$hoteles_iris_arr[4]['servicio'] )->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EY'.$cont ,'')->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EZ'.$cont ,$hoteles_iris_arr[4]['fecha_entrada'] )->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EZ'.$cont ,'')->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['fecha_salida'])){
					    	$activeSheet->setCellValue('FA'.$cont ,$hoteles_iris_arr[4]['fecha_salida'] )->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FA'.$cont ,'')->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['noches'])){
					    	$activeSheet->setCellValue('FB'.$cont ,$hoteles_iris_arr[4]['noches'] )->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FB'.$cont ,'')->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['break_fast'])){
					    	$activeSheet->setCellValue('FC'.$cont ,$hoteles_iris_arr[4]['break_fast'] )->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FC'.$cont ,'')->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['numero_hab'])){
					    	$activeSheet->setCellValue('FD'.$cont ,$hoteles_iris_arr[4]['numero_hab'] )->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FD'.$cont ,'')->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['id_habitacion'])){
					    	$activeSheet->setCellValue('FE'.$cont ,$hoteles_iris_arr[4]['id_habitacion'] )->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FE'.$cont ,'')->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['id_ciudad'])){
					    	$activeSheet->setCellValue('FF'.$cont ,$hoteles_iris_arr[4]['id_ciudad'] )->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FF'.$cont ,'')->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[4]['country'])){
					    	$activeSheet->setCellValue('FG'.$cont ,$hoteles_iris_arr[4]['country'] )->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FG'.$cont ,'')->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 6
					    if(isset($hoteles_iris_arr[5]['servicio'])){
					    	$activeSheet->setCellValue('FH'.$cont ,$hoteles_iris_arr[5]['servicio'] )->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FH'.$cont ,'')->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FI'.$cont ,$hoteles_iris_arr[5]['fecha_entrada'] )->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FI'.$cont ,'')->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['fecha_salida'])){
					    	$activeSheet->setCellValue('FJ'.$cont ,$hoteles_iris_arr[5]['fecha_salida'] )->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FJ'.$cont ,'')->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['noches'])){
					    	$activeSheet->setCellValue('FK'.$cont ,$hoteles_iris_arr[5]['noches'] )->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FK'.$cont ,'')->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['break_fast'])){
					    	$activeSheet->setCellValue('FL'.$cont ,$hoteles_iris_arr[5]['break_fast'] )->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FL'.$cont ,'')->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['numero_hab'])){
					    	$activeSheet->setCellValue('FM'.$cont ,$hoteles_iris_arr[5]['numero_hab'] )->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FM'.$cont ,'')->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['id_habitacion'])){
					    	$activeSheet->setCellValue('FN'.$cont ,$hoteles_iris_arr[5]['id_habitacion'] )->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FN'.$cont ,'')->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['id_ciudad'])){
					    	$activeSheet->setCellValue('FO'.$cont ,$hoteles_iris_arr[5]['id_ciudad'] )->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FO'.$cont ,'')->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[5]['country'])){
					    	$activeSheet->setCellValue('FP'.$cont ,$hoteles_iris_arr[5]['country'] )->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FP'.$cont ,'')->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 7
					    if(isset($hoteles_iris_arr[6]['servicio'])){
					    	$activeSheet->setCellValue('FQ'.$cont ,$hoteles_iris_arr[6]['servicio'] )->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FQ'.$cont ,'')->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FR'.$cont ,$hoteles_iris_arr[6]['fecha_entrada'] )->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FR'.$cont ,'')->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['fecha_salida'])){
					    	$activeSheet->setCellValue('FS'.$cont ,$hoteles_iris_arr[6]['fecha_salida'] )->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FS'.$cont ,'')->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['noches'])){
					    	$activeSheet->setCellValue('FT'.$cont ,$hoteles_iris_arr[6]['noches'] )->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FT'.$cont ,'')->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['break_fast'])){
					    	$activeSheet->setCellValue('FU'.$cont ,$hoteles_iris_arr[6]['break_fast'] )->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FU'.$cont ,'')->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['numero_hab'])){
					    	$activeSheet->setCellValue('FV'.$cont ,$hoteles_iris_arr[6]['numero_hab'] )->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FV'.$cont ,'')->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['id_habitacion'])){
					    	$activeSheet->setCellValue('FW'.$cont ,$hoteles_iris_arr[6]['id_habitacion'] )->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FW'.$cont ,'')->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['id_ciudad'])){
					    	$activeSheet->setCellValue('FX'.$cont ,$hoteles_iris_arr[6]['id_ciudad'] )->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FX'.$cont ,'')->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[6]['country'])){
					    	$activeSheet->setCellValue('FY'.$cont ,$hoteles_iris_arr[6]['country'] )->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FY'.$cont ,'')->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 8
					    if(isset($hoteles_iris_arr[7]['servicio'])){
					    	$activeSheet->setCellValue('FZ'.$cont ,$hoteles_iris_arr[7]['servicio'] )->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FZ'.$cont ,'')->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GA'.$cont ,$hoteles_iris_arr[7]['fecha_entrada'] )->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GA'.$cont ,'')->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['fecha_salida'])){
					    	$activeSheet->setCellValue('GB'.$cont ,$hoteles_iris_arr[7]['fecha_salida'] )->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GB'.$cont ,'')->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['noches'])){
					    	$activeSheet->setCellValue('GC'.$cont ,$hoteles_iris_arr[7]['noches'] )->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GC'.$cont ,'')->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['break_fast'])){
					    	$activeSheet->setCellValue('GD'.$cont ,$hoteles_iris_arr[7]['break_fast'] )->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GD'.$cont ,'')->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['numero_hab'])){
					    	$activeSheet->setCellValue('GE'.$cont ,$hoteles_iris_arr[7]['numero_hab'] )->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GE'.$cont ,'')->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['id_habitacion'])){
					    	$activeSheet->setCellValue('GF'.$cont ,$hoteles_iris_arr[7]['id_habitacion'] )->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GF'.$cont ,'')->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['id_ciudad'])){
					    	$activeSheet->setCellValue('GG'.$cont ,$hoteles_iris_arr[7]['id_ciudad'] )->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GG'.$cont ,'')->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[7]['country'])){
					    	$activeSheet->setCellValue('GH'.$cont ,$hoteles_iris_arr[7]['country'] )->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GH'.$cont ,'')->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 9
					    if(isset($hoteles_iris_arr[8]['servicio'])){
					    	$activeSheet->setCellValue('GI'.$cont ,$hoteles_iris_arr[8]['servicio'] )->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GI'.$cont ,'')->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GJ'.$cont ,$hoteles_iris_arr[8]['fecha_entrada'] )->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GJ'.$cont ,'')->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['fecha_salida'])){
					    	$activeSheet->setCellValue('GK'.$cont ,$hoteles_iris_arr[8]['fecha_salida'] )->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GK'.$cont ,'')->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['noches'])){
					    	$activeSheet->setCellValue('GL'.$cont ,$hoteles_iris_arr[8]['noches'] )->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GL'.$cont ,'')->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['break_fast'])){
					    	$activeSheet->setCellValue('GM'.$cont ,$hoteles_iris_arr[8]['break_fast'] )->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GM'.$cont ,'')->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['numero_hab'])){
					    	$activeSheet->setCellValue('GN'.$cont ,$hoteles_iris_arr[8]['numero_hab'] )->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GN'.$cont ,'')->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['id_habitacion'])){
					    	$activeSheet->setCellValue('GO'.$cont ,$hoteles_iris_arr[8]['id_habitacion'] )->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GO'.$cont ,'')->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['id_ciudad'])){
					    	$activeSheet->setCellValue('GP'.$cont ,$hoteles_iris_arr[8]['id_ciudad'] )->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GP'.$cont ,'')->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[8]['country'])){
					    	$activeSheet->setCellValue('GQ'.$cont ,$hoteles_iris_arr[8]['country'] )->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GQ'.$cont ,'')->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }
					     //**********************HOTEL 9
					    if(isset($hoteles_iris_arr[9]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GR'.$cont ,$hoteles_iris_arr[9]['nombre_hotel'] )->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GR'.$cont ,'')->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GS'.$cont ,$hoteles_iris_arr[9]['fecha_entrada'] )->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GS'.$cont ,'')->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['fecha_salida'])){
					    	$activeSheet->setCellValue('GT'.$cont ,$hoteles_iris_arr[9]['fecha_salida'] )->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GT'.$cont ,'')->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['noches'])){
					    	$activeSheet->setCellValue('GU'.$cont ,$hoteles_iris_arr[9]['noches'] )->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GU'.$cont ,'')->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['break_fast'])){
					    	$activeSheet->setCellValue('GV'.$cont ,$hoteles_iris_arr[9]['break_fast'] )->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GV'.$cont ,'')->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['numero_hab'])){
					    	$activeSheet->setCellValue('GW'.$cont ,$hoteles_iris_arr[9]['numero_hab'] )->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GW'.$cont ,'')->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['id_habitacion'])){
					    	$activeSheet->setCellValue('GX'.$cont ,$hoteles_iris_arr[9]['id_habitacion'] )->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GX'.$cont ,'')->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['id_ciudad'])){
					    	$activeSheet->setCellValue('GY'.$cont ,$hoteles_iris_arr[9]['id_ciudad'] )->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GY'.$cont ,'')->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_iris_arr[9]['country'])){
					    	$activeSheet->setCellValue('GZ'.$cont ,$hoteles_iris_arr[9]['country'] )->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GZ'.$cont ,'')->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }

					    $autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);  

						//**********************Autos 1
					    if(isset($autos_arr[0]['tipo_auto'])){
					    	$activeSheet->setCellValue('HA'.$cont ,$autos_arr[0]['tipo_auto'] )->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HA'.$cont ,'')->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HB'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HB'.$cont ,'')->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['dias'])){
					    	$activeSheet->setCellValue('HC'.$cont ,$autos_arr[0]['dias'] )->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HC'.$cont ,'')->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HD'.$cont ,$autos_arr[0]['id_ciudad_entrega'] )->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HD'.$cont ,'')->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HE'.$cont ,$autos_arr[0]['id_ciudad_recoge'] )->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HE'.$cont ,'')->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HF'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HF'.$cont ,'')->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[1]['tipo_auto'])){
					    	$activeSheet->setCellValue('HG'.$cont ,$autos_arr[1]['tipo_auto'] )->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HG'.$cont ,'')->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HH'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HH'.$cont ,'')->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['dias'])){
					    	$activeSheet->setCellValue('HI'.$cont ,$autos_arr[1]['dias'] )->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HI'.$cont ,'')->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HJ'.$cont ,$autos_arr[1]['id_ciudad_entrega'] )->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HJ'.$cont ,'')->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HK'.$cont ,$autos_arr[1]['id_ciudad_recoge'] )->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HK'.$cont ,'')->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HL'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HL'.$cont ,'')->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[2]['tipo_auto'])){
					    	$activeSheet->setCellValue('HM'.$cont ,$autos_arr[2]['tipo_auto'] )->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HM'.$cont ,'')->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HN'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HN'.$cont ,'')->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['dias'])){
					    	$activeSheet->setCellValue('HO'.$cont ,$autos_arr[2]['dias'] )->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HO'.$cont ,'')->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HP'.$cont ,$autos_arr[2]['id_ciudad_entrega'] )->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HP'.$cont ,'')->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HQ'.$cont ,$autos_arr[2]['id_ciudad_recoge'] )->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HQ'.$cont ,'')->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HR'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HR'.$cont ,'')->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[3]['tipo_auto'])){
					    	$activeSheet->setCellValue('HS'.$cont ,$autos_arr[3]['tipo_auto'] )->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HS'.$cont ,'')->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HT'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HT'.$cont ,'')->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['dias'])){
					    	$activeSheet->setCellValue('HU'.$cont ,$autos_arr[3]['dias'] )->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HU'.$cont ,'')->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HV'.$cont ,$autos_arr[3]['id_ciudad_entrega'] )->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HV'.$cont ,'')->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HW'.$cont ,$autos_arr[3]['id_ciudad_recoge'] )->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HW'.$cont ,'')->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HX'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HX'.$cont ,'')->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[4]['tipo_auto'])){
					    	$activeSheet->setCellValue('HY'.$cont ,$autos_arr[4]['tipo_auto'] )->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HY'.$cont ,'')->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HZ'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HZ'.$cont ,'')->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['dias'])){
					    	$activeSheet->setCellValue('IA'.$cont ,$autos_arr[4]['dias'] )->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IA'.$cont ,'')->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IB'.$cont ,$autos_arr[4]['id_ciudad_entrega'] )->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IB'.$cont ,'')->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IC'.$cont ,$autos_arr[4]['id_ciudad_recoge'] )->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IC'.$cont ,'')->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('ID'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ID'.$cont ,'')->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[5]['tipo_auto'])){
					    	$activeSheet->setCellValue('IE'.$cont ,$autos_arr[5]['tipo_auto'] )->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IE'.$cont ,'')->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IF'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IF'.$cont ,'')->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['dias'])){
					    	$activeSheet->setCellValue('IG'.$cont ,$autos_arr[5]['dias'] )->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IG'.$cont ,'')->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IH'.$cont ,$autos_arr[5]['id_ciudad_entrega'] )->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IH'.$cont ,'')->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('II'.$cont ,$autos_arr[5]['id_ciudad_recoge'] )->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('II'.$cont ,'')->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IJ'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IJ'.$cont ,'')->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[6]['tipo_auto'])){
					    	$activeSheet->setCellValue('IK'.$cont ,$autos_arr[6]['tipo_auto'] )->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IK'.$cont ,'')->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IL'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IL'.$cont ,'')->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['dias'])){
					    	$activeSheet->setCellValue('IM'.$cont ,$autos_arr[6]['dias'] )->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IM'.$cont ,'')->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IN'.$cont ,$autos_arr[6]['id_ciudad_entrega'] )->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IN'.$cont ,'')->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IO'.$cont ,$autos_arr[6]['id_ciudad_recoge'] )->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IO'.$cont ,'')->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IP'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IP'.$cont ,'')->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[7]['tipo_auto'])){
					    	$activeSheet->setCellValue('IQ'.$cont ,$autos_arr[7]['tipo_auto'] )->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IQ'.$cont ,'')->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IR'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IR'.$cont ,'')->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['dias'])){
					    	$activeSheet->setCellValue('IS'.$cont ,$autos_arr[7]['dias'] )->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IS'.$cont ,'')->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IT'.$cont ,$autos_arr[7]['id_ciudad_entrega'] )->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IT'.$cont ,'')->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IU'.$cont ,$autos_arr[7]['id_ciudad_recoge'] )->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IU'.$cont ,'')->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IV'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IV'.$cont ,'')->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[8]['tipo_auto'])){
					    	$activeSheet->setCellValue('IW'.$cont ,$autos_arr[8]['tipo_auto'] )->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IW'.$cont ,'')->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IX'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IX'.$cont ,'')->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['dias'])){
					    	$activeSheet->setCellValue('IY'.$cont ,$autos_arr[8]['dias'] )->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IY'.$cont ,'')->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IZ'.$cont ,$autos_arr[8]['id_ciudad_entrega'] )->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IZ'.$cont ,'')->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JA'.$cont ,$autos_arr[8]['id_ciudad_recoge'] )->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JA'.$cont ,'')->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JB'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JB'.$cont ,'')->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[9]['tipo_auto'])){
					    	$activeSheet->setCellValue('JC'.$cont ,$autos_arr[9]['tipo_auto'] )->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JC'.$cont ,'')->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JD'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JD'.$cont ,'')->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['dias'])){
					    	$activeSheet->setCellValue('JE'.$cont ,$autos_arr[9]['dias'] )->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JE'.$cont ,'')->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('JF'.$cont ,$autos_arr[9]['id_ciudad_entrega'] )->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JF'.$cont ,'')->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JG'.$cont ,$autos_arr[9]['id_ciudad_recoge'] )->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JG'.$cont ,'')->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JH'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JH'.$cont ,'')->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }

				}else if( !in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTNAC_RES'){

						$activeSheet->setCellValue('J'.$cont ,$cont )->getStyle('J'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('H'.$cont ,$cont )->getStyle('H'.$cont)->getFont()->setBold(false);
					    //*********************************************
						
					    $fecha1 = $parametros["fecha1"];
		      			$fecha2 = $parametros["fecha2"];
		      					
								if($fecha1 == ""){
								          $hoy = getdate();
								          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
								          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
								          $year = $hoy['year'];
								          $fecha1 = $year.'-'.$mes.'-'.$dia;
								          $fecha2 = $year.'-'.$mes.'-'.$dia;
								        
								      }else{
								          
								          $array_fecha1 = explode('/', $fecha1);
								          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
								          $array_fecha2 = explode('/', $fecha2);
								          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
								         
								      }

			    	   $hoteles_arr = $this->Mod_reportes_layout_seg->get_hoteles_num_bol($consecutivo,$fecha1,$fecha2);

					   $autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);

					   if( count($hoteles_arr) > 0 || count($autos_arr) > 0 ){

					    //**********************HOTEL 1
					    if(isset($hoteles_arr[0]['nombre_hotel'])){
					    	$activeSheet->setCellValue('DO'.$cont ,$hoteles_arr[0]['nombre_hotel'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DO'.$cont ,'')->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DP'.$cont ,$hoteles_arr[0]['fecha_entrada'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DP'.$cont ,'')->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['fecha_salida'])){
					    	$activeSheet->setCellValue('DQ'.$cont ,$hoteles_arr[0]['fecha_salida'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DQ'.$cont ,'')->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['noches'])){
					    	$activeSheet->setCellValue('DR'.$cont ,$hoteles_arr[0]['noches'] )->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DR'.$cont ,'')->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['break_fast'])){
					    	$activeSheet->setCellValue('DS'.$cont ,$hoteles_arr[0]['break_fast'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DS'.$cont ,'')->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['numero_hab'])){
					    	$activeSheet->setCellValue('DT'.$cont ,$hoteles_arr[0]['numero_hab'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DT'.$cont ,'')->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['id_habitacion'])){
					    	$activeSheet->setCellValue('DU'.$cont ,$hoteles_arr[0]['id_habitacion'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DU'.$cont ,'')->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['id_ciudad'])){
					    	$activeSheet->setCellValue('DV'.$cont ,$hoteles_arr[0]['id_ciudad'] )->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DV'.$cont ,'')->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['country'])){
					    	$activeSheet->setCellValue('DW'.$cont ,$hoteles_arr[0]['country'] )->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DW'.$cont ,'')->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }
		                 //**********************HOTEL 2
					    if(isset($hoteles_arr[1]['nombre_hotel'])){
					    	$activeSheet->setCellValue('DX'.$cont ,$hoteles_arr[1]['nombre_hotel'] )->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DX'.$cont ,'')->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DY'.$cont ,$hoteles_arr[1]['fecha_entrada'] )->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DY'.$cont ,'')->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['fecha_salida'])){
					    	$activeSheet->setCellValue('DZ'.$cont ,$hoteles_arr[1]['fecha_salida'] )->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DZ'.$cont ,'')->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['noches'])){
					    	$activeSheet->setCellValue('EA'.$cont ,$hoteles_arr[1]['noches'] )->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EA'.$cont ,'')->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['break_fast'])){
					    	$activeSheet->setCellValue('EB'.$cont ,$hoteles_arr[1]['break_fast'] )->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EB'.$cont ,'')->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['numero_hab'])){
					    	$activeSheet->setCellValue('EC'.$cont ,$hoteles_arr[1]['numero_hab'] )->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EC'.$cont ,'')->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['id_habitacion'])){
					    	$activeSheet->setCellValue('ED'.$cont ,$hoteles_arr[1]['id_habitacion'] )->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ED'.$cont ,'')->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['id_ciudad'])){
					    	$activeSheet->setCellValue('EE'.$cont ,$hoteles_arr[1]['id_ciudad'] )->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EE'.$cont ,'')->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['country'])){
					    	$activeSheet->setCellValue('EF'.$cont ,$hoteles_arr[1]['country'] )->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EF'.$cont ,'')->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 3
					    if(isset($hoteles_arr[2]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EG'.$cont ,$hoteles_arr[2]['nombre_hotel'] )->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EG'.$cont ,'')->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EH'.$cont ,$hoteles_arr[2]['fecha_entrada'] )->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EH'.$cont ,'')->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['fecha_salida'])){
					    	$activeSheet->setCellValue('EI'.$cont ,$hoteles_arr[2]['fecha_salida'] )->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EI'.$cont ,'')->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['noches'])){
					    	$activeSheet->setCellValue('EJ'.$cont ,$hoteles_arr[2]['noches'] )->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EJ'.$cont ,'')->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['break_fast'])){
					    	$activeSheet->setCellValue('EK'.$cont ,$hoteles_arr[2]['break_fast'] )->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EK'.$cont ,'')->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['numero_hab'])){
					    	$activeSheet->setCellValue('EL'.$cont ,$hoteles_arr[2]['numero_hab'] )->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EL'.$cont ,'')->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['id_habitacion'])){
					    	$activeSheet->setCellValue('EM'.$cont ,$hoteles_arr[2]['id_habitacion'] )->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EM'.$cont ,'')->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['id_ciudad'])){
					    	$activeSheet->setCellValue('EN'.$cont ,$hoteles_arr[2]['id_ciudad'] )->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EN'.$cont ,'')->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['country'])){
					    	$activeSheet->setCellValue('EO'.$cont ,$hoteles_arr[2]['country'] )->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EO'.$cont ,'')->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 4
					    if(isset($hoteles_arr[3]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EP'.$cont ,$hoteles_arr[3]['nombre_hotel'] )->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EP'.$cont ,'')->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EQ'.$cont ,$hoteles_arr[3]['fecha_entrada'] )->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EQ'.$cont ,'')->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['fecha_salida'])){
					    	$activeSheet->setCellValue('ER'.$cont ,$hoteles_arr[3]['fecha_salida'] )->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ER'.$cont ,'')->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['noches'])){
					    	$activeSheet->setCellValue('ES'.$cont ,$hoteles_arr[3]['noches'] )->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ES'.$cont ,'')->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['break_fast'])){
					    	$activeSheet->setCellValue('ET'.$cont ,$hoteles_arr[3]['break_fast'] )->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ET'.$cont ,'')->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['numero_hab'])){
					    	$activeSheet->setCellValue('EU'.$cont ,$hoteles_arr[3]['numero_hab'] )->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EU'.$cont ,'')->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['id_habitacion'])){
					    	$activeSheet->setCellValue('EV'.$cont ,$hoteles_arr[3]['id_habitacion'] )->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EV'.$cont ,'')->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['id_ciudad'])){
					    	$activeSheet->setCellValue('EW'.$cont ,$hoteles_arr[3]['id_ciudad'] )->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EW'.$cont ,'')->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['country'])){
					    	$activeSheet->setCellValue('EX'.$cont ,$hoteles_arr[3]['country'] )->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EX'.$cont ,'')->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 5
					    if(isset($hoteles_arr[4]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EY'.$cont ,$hoteles_arr[4]['nombre_hotel'] )->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EY'.$cont ,'')->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EZ'.$cont ,$hoteles_arr[4]['fecha_entrada'] )->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EZ'.$cont ,'')->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['fecha_salida'])){
					    	$activeSheet->setCellValue('FA'.$cont ,$hoteles_arr[4]['fecha_salida'] )->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FA'.$cont ,'')->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['noches'])){
					    	$activeSheet->setCellValue('FB'.$cont ,$hoteles_arr[4]['noches'] )->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FB'.$cont ,'')->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['break_fast'])){
					    	$activeSheet->setCellValue('FC'.$cont ,$hoteles_arr[4]['break_fast'] )->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FC'.$cont ,'')->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['numero_hab'])){
					    	$activeSheet->setCellValue('FD'.$cont ,$hoteles_arr[4]['numero_hab'] )->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FD'.$cont ,'')->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['id_habitacion'])){
					    	$activeSheet->setCellValue('FE'.$cont ,$hoteles_arr[4]['id_habitacion'] )->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FE'.$cont ,'')->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['id_ciudad'])){
					    	$activeSheet->setCellValue('FF'.$cont ,$hoteles_arr[4]['id_ciudad'] )->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FF'.$cont ,'')->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['country'])){
					    	$activeSheet->setCellValue('FG'.$cont ,$hoteles_arr[4]['country'] )->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FG'.$cont ,'')->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 6
					    if(isset($hoteles_arr[5]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FH'.$cont ,$hoteles_arr[5]['nombre_hotel'] )->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FH'.$cont ,'')->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FI'.$cont ,$hoteles_arr[5]['fecha_entrada'] )->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FI'.$cont ,'')->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['fecha_salida'])){
					    	$activeSheet->setCellValue('FJ'.$cont ,$hoteles_arr[5]['fecha_salida'] )->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FJ'.$cont ,'')->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['noches'])){
					    	$activeSheet->setCellValue('FK'.$cont ,$hoteles_arr[5]['noches'] )->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FK'.$cont ,'')->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['break_fast'])){
					    	$activeSheet->setCellValue('FL'.$cont ,$hoteles_arr[5]['break_fast'] )->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FL'.$cont ,'')->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['numero_hab'])){
					    	$activeSheet->setCellValue('FM'.$cont ,$hoteles_arr[5]['numero_hab'] )->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FM'.$cont ,'')->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['id_habitacion'])){
					    	$activeSheet->setCellValue('FN'.$cont ,$hoteles_arr[5]['id_habitacion'] )->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FN'.$cont ,'')->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['id_ciudad'])){
					    	$activeSheet->setCellValue('FO'.$cont ,$hoteles_arr[5]['id_ciudad'] )->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FO'.$cont ,'')->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['country'])){
					    	$activeSheet->setCellValue('FP'.$cont ,$hoteles_arr[5]['country'] )->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FP'.$cont ,'')->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 7
					    if(isset($hoteles_arr[6]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FQ'.$cont ,$hoteles_arr[6]['nombre_hotel'] )->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FQ'.$cont ,'')->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FR'.$cont ,$hoteles_arr[6]['fecha_entrada'] )->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FR'.$cont ,'')->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['fecha_salida'])){
					    	$activeSheet->setCellValue('FS'.$cont ,$hoteles_arr[6]['fecha_salida'] )->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FS'.$cont ,'')->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['noches'])){
					    	$activeSheet->setCellValue('FT'.$cont ,$hoteles_arr[6]['noches'] )->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FT'.$cont ,'')->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['break_fast'])){
					    	$activeSheet->setCellValue('FU'.$cont ,$hoteles_arr[6]['break_fast'] )->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FU'.$cont ,'')->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['numero_hab'])){
					    	$activeSheet->setCellValue('FV'.$cont ,$hoteles_arr[6]['numero_hab'] )->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FV'.$cont ,'')->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['id_habitacion'])){
					    	$activeSheet->setCellValue('FW'.$cont ,$hoteles_arr[6]['id_habitacion'] )->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FW'.$cont ,'')->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['id_ciudad'])){
					    	$activeSheet->setCellValue('FX'.$cont ,$hoteles_arr[6]['id_ciudad'] )->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FX'.$cont ,'')->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['country'])){
					    	$activeSheet->setCellValue('FY'.$cont ,$hoteles_arr[6]['country'] )->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FY'.$cont ,'')->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 8
					    if(isset($hoteles_arr[7]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FZ'.$cont ,$hoteles_arr[7]['nombre_hotel'] )->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FZ'.$cont ,'')->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GA'.$cont ,$hoteles_arr[7]['fecha_entrada'] )->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GA'.$cont ,'')->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['fecha_salida'])){
					    	$activeSheet->setCellValue('GB'.$cont ,$hoteles_arr[7]['fecha_salida'] )->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GB'.$cont ,'')->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['noches'])){
					    	$activeSheet->setCellValue('GC'.$cont ,$hoteles_arr[7]['noches'] )->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GC'.$cont ,'')->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['break_fast'])){
					    	$activeSheet->setCellValue('GD'.$cont ,$hoteles_arr[7]['break_fast'] )->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GD'.$cont ,'')->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['numero_hab'])){
					    	$activeSheet->setCellValue('GE'.$cont ,$hoteles_arr[7]['numero_hab'] )->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GE'.$cont ,'')->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['id_habitacion'])){
					    	$activeSheet->setCellValue('GF'.$cont ,$hoteles_arr[7]['id_habitacion'] )->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GF'.$cont ,'')->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['id_ciudad'])){
					    	$activeSheet->setCellValue('GG'.$cont ,$hoteles_arr[7]['id_ciudad'] )->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GG'.$cont ,'')->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['country'])){
					    	$activeSheet->setCellValue('GH'.$cont ,$hoteles_arr[7]['country'] )->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GH'.$cont ,'')->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 9
					    if(isset($hoteles_arr[8]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GI'.$cont ,$hoteles_arr[8]['nombre_hotel'] )->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GI'.$cont ,'')->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GJ'.$cont ,$hoteles_arr[8]['fecha_entrada'] )->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GJ'.$cont ,'')->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['fecha_salida'])){
					    	$activeSheet->setCellValue('GK'.$cont ,$hoteles_arr[8]['fecha_salida'] )->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GK'.$cont ,'')->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['noches'])){
					    	$activeSheet->setCellValue('GL'.$cont ,$hoteles_arr[8]['noches'] )->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GL'.$cont ,'')->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['break_fast'])){
					    	$activeSheet->setCellValue('GM'.$cont ,$hoteles_arr[8]['break_fast'] )->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GM'.$cont ,'')->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['numero_hab'])){
					    	$activeSheet->setCellValue('GN'.$cont ,$hoteles_arr[8]['numero_hab'] )->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GN'.$cont ,'')->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['id_habitacion'])){
					    	$activeSheet->setCellValue('GO'.$cont ,$hoteles_arr[8]['id_habitacion'] )->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GO'.$cont ,'')->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['id_ciudad'])){
					    	$activeSheet->setCellValue('GP'.$cont ,$hoteles_arr[8]['id_ciudad'] )->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GP'.$cont ,'')->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['country'])){
					    	$activeSheet->setCellValue('GQ'.$cont ,$hoteles_arr[8]['country'] )->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GQ'.$cont ,'')->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }
					     //**********************HOTEL 9
					    if(isset($hoteles_arr[9]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GR'.$cont ,$hoteles_arr[9]['nombre_hotel'] )->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GR'.$cont ,'')->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GS'.$cont ,$hoteles_arr[9]['fecha_entrada'] )->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GS'.$cont ,'')->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['fecha_salida'])){
					    	$activeSheet->setCellValue('GT'.$cont ,$hoteles_arr[9]['fecha_salida'] )->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GT'.$cont ,'')->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['noches'])){
					    	$activeSheet->setCellValue('GU'.$cont ,$hoteles_arr[9]['noches'] )->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GU'.$cont ,'')->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['break_fast'])){
					    	$activeSheet->setCellValue('GV'.$cont ,$hoteles_arr[9]['break_fast'] )->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GV'.$cont ,'')->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['numero_hab'])){
					    	$activeSheet->setCellValue('GW'.$cont ,$hoteles_arr[9]['numero_hab'] )->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GW'.$cont ,'')->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['id_habitacion'])){
					    	$activeSheet->setCellValue('GX'.$cont ,$hoteles_arr[9]['id_habitacion'] )->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GX'.$cont ,'')->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['id_ciudad'])){
					    	$activeSheet->setCellValue('GY'.$cont ,$hoteles_arr[9]['id_ciudad'] )->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GY'.$cont ,'')->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['country'])){
					    	$activeSheet->setCellValue('GZ'.$cont ,$hoteles_arr[9]['country'] )->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GZ'.$cont ,'')->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }
						//**********************Autos 1
					    if(isset($autos_arr[0]['tipo_auto'])){
					    	$activeSheet->setCellValue('HA'.$cont ,$autos_arr[0]['tipo_auto'] )->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HA'.$cont ,'')->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HB'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HB'.$cont ,'')->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['dias'])){
					    	$activeSheet->setCellValue('HC'.$cont ,$autos_arr[0]['dias'] )->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HC'.$cont ,'')->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HD'.$cont ,$autos_arr[0]['id_ciudad_entrega'] )->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HD'.$cont ,'')->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HE'.$cont ,$autos_arr[0]['id_ciudad_recoge'] )->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HE'.$cont ,'')->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HF'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HF'.$cont ,'')->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[1]['tipo_auto'])){
					    	$activeSheet->setCellValue('HG'.$cont ,$autos_arr[1]['tipo_auto'] )->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HG'.$cont ,'')->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HH'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HH'.$cont ,'')->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['dias'])){
					    	$activeSheet->setCellValue('HI'.$cont ,$autos_arr[1]['dias'] )->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HI'.$cont ,'')->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HJ'.$cont ,$autos_arr[1]['id_ciudad_entrega'] )->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HJ'.$cont ,'')->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HK'.$cont ,$autos_arr[1]['id_ciudad_recoge'] )->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HK'.$cont ,'')->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HL'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HL'.$cont ,'')->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[2]['tipo_auto'])){
					    	$activeSheet->setCellValue('HM'.$cont ,$autos_arr[2]['tipo_auto'] )->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HM'.$cont ,'')->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HN'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HN'.$cont ,'')->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['dias'])){
					    	$activeSheet->setCellValue('HO'.$cont ,$autos_arr[2]['dias'] )->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HO'.$cont ,'')->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HP'.$cont ,$autos_arr[2]['id_ciudad_entrega'] )->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HP'.$cont ,'')->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HQ'.$cont ,$autos_arr[2]['id_ciudad_recoge'] )->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HQ'.$cont ,'')->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HR'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HR'.$cont ,'')->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[3]['tipo_auto'])){
					    	$activeSheet->setCellValue('HS'.$cont ,$autos_arr[3]['tipo_auto'] )->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HS'.$cont ,'')->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HT'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HT'.$cont ,'')->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['dias'])){
					    	$activeSheet->setCellValue('HU'.$cont ,$autos_arr[3]['dias'] )->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HU'.$cont ,'')->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HV'.$cont ,$autos_arr[3]['id_ciudad_entrega'] )->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HV'.$cont ,'')->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HW'.$cont ,$autos_arr[3]['id_ciudad_recoge'] )->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HW'.$cont ,'')->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HX'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HX'.$cont ,'')->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[4]['tipo_auto'])){
					    	$activeSheet->setCellValue('HY'.$cont ,$autos_arr[4]['tipo_auto'] )->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HY'.$cont ,'')->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HZ'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HZ'.$cont ,'')->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['dias'])){
					    	$activeSheet->setCellValue('IA'.$cont ,$autos_arr[4]['dias'] )->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IA'.$cont ,'')->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IB'.$cont ,$autos_arr[4]['id_ciudad_entrega'] )->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IB'.$cont ,'')->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IC'.$cont ,$autos_arr[4]['id_ciudad_recoge'] )->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IC'.$cont ,'')->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('ID'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ID'.$cont ,'')->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[5]['tipo_auto'])){
					    	$activeSheet->setCellValue('IE'.$cont ,$autos_arr[5]['tipo_auto'] )->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IE'.$cont ,'')->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IF'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IF'.$cont ,'')->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['dias'])){
					    	$activeSheet->setCellValue('IG'.$cont ,$autos_arr[5]['dias'] )->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IG'.$cont ,'')->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IH'.$cont ,$autos_arr[5]['id_ciudad_entrega'] )->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IH'.$cont ,'')->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('II'.$cont ,$autos_arr[5]['id_ciudad_recoge'] )->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('II'.$cont ,'')->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IJ'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IJ'.$cont ,'')->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[6]['tipo_auto'])){
					    	$activeSheet->setCellValue('IK'.$cont ,$autos_arr[6]['tipo_auto'] )->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IK'.$cont ,'')->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IL'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IL'.$cont ,'')->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['dias'])){
					    	$activeSheet->setCellValue('IM'.$cont ,$autos_arr[6]['dias'] )->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IM'.$cont ,'')->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IN'.$cont ,$autos_arr[6]['id_ciudad_entrega'] )->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IN'.$cont ,'')->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IO'.$cont ,$autos_arr[6]['id_ciudad_recoge'] )->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IO'.$cont ,'')->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IP'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IP'.$cont ,'')->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[7]['tipo_auto'])){
					    	$activeSheet->setCellValue('IQ'.$cont ,$autos_arr[7]['tipo_auto'] )->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IQ'.$cont ,'')->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IR'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IR'.$cont ,'')->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['dias'])){
					    	$activeSheet->setCellValue('IS'.$cont ,$autos_arr[7]['dias'] )->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IS'.$cont ,'')->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IT'.$cont ,$autos_arr[7]['id_ciudad_entrega'] )->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IT'.$cont ,'')->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IU'.$cont ,$autos_arr[7]['id_ciudad_recoge'] )->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IU'.$cont ,'')->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IV'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IV'.$cont ,'')->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[8]['tipo_auto'])){
					    	$activeSheet->setCellValue('IW'.$cont ,$autos_arr[8]['tipo_auto'] )->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IW'.$cont ,'')->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IX'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IX'.$cont ,'')->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['dias'])){
					    	$activeSheet->setCellValue('IY'.$cont ,$autos_arr[8]['dias'] )->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IY'.$cont ,'')->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IZ'.$cont ,$autos_arr[8]['id_ciudad_entrega'] )->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IZ'.$cont ,'')->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JA'.$cont ,$autos_arr[8]['id_ciudad_recoge'] )->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JA'.$cont ,'')->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JB'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JB'.$cont ,'')->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[9]['tipo_auto'])){
					    	$activeSheet->setCellValue('JC'.$cont ,$autos_arr[9]['tipo_auto'] )->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JC'.$cont ,'')->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JD'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JD'.$cont ,'')->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['dias'])){
					    	$activeSheet->setCellValue('JE'.$cont ,$autos_arr[9]['dias'] )->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JE'.$cont ,'')->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('JF'.$cont ,$autos_arr[9]['id_ciudad_entrega'] )->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JF'.$cont ,'')->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JG'.$cont ,$autos_arr[9]['id_ciudad_recoge'] )->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JG'.$cont ,'')->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JH'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JH'.$cont ,'')->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }

					
		    		}else{ //fin validacion coun hot aut

		    			$activeSheet->removeRow($cont);

		    		}

				}else{  //TODO LO QUE NO ESTA DENTRO DE LA VALIDACION Y TIENE HOTELES O AUTOS
						
						
					if(!in_array($consecutivo, $array_consecutivo)){

						if($valor->type_of_service == 'HOTNAC_VARIOS' && $valor->typo_of_ticket == 'N'){

							$valor->type_of_service = 'HOTNAC';
							$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
							$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);

						}else if($valor->type_of_service == 'HOTNAC_VARIOS' && $valor->typo_of_ticket == 'I'){

							$valor->type_of_service = 'HOTINT';
							$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
							$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);
						}

						//$activeSheet->setCellValue('H'.$cont ,$valor->type_of_service )->getStyle('H'.$cont)->getFont()->setBold(false);
						
						//*********************************************
					    $fecha1 = $parametros["fecha1"];
		      			$fecha2 = $parametros["fecha2"];
		      					
								if($fecha1 == ""){
								          $hoy = getdate();
								          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
								          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
								          $year = $hoy['year'];
								          $fecha1 = $year.'-'.$mes.'-'.$dia;
								          $fecha2 = $year.'-'.$mes.'-'.$dia;
								        
								      }else{
								          
								          $array_fecha1 = explode('/', $fecha1);
								          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];
								          $array_fecha2 = explode('/', $fecha2);
								          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
								         
								      }

			            $hoteles_arr = $this->Mod_reportes_layout_seg->get_hoteles_num_bol($consecutivo,$fecha1,$fecha2);

					    //$hoteles_arr = $this->Mod_reportes_layout_seg->get_hoteles_num_bol($consecutivo);


					    //**********************HOTEL 1
					    if(isset($hoteles_arr[0]['nombre_hotel'])){

					    	$activeSheet->setCellValue('DO'.$cont ,$hoteles_arr[0]['nombre_hotel'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DO'.$cont ,'')->getStyle('AW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DP'.$cont ,$hoteles_arr[0]['fecha_entrada'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DP'.$cont ,'')->getStyle('AX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['fecha_salida'])){
					    	$activeSheet->setCellValue('DQ'.$cont ,$hoteles_arr[0]['fecha_salida'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DQ'.$cont ,'')->getStyle('AY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['noches'])){
					    	$activeSheet->setCellValue('DR'.$cont ,$hoteles_arr[0]['noches'] )->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DR'.$cont ,'')->getStyle('AZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['break_fast'])){
					    	$activeSheet->setCellValue('DS'.$cont ,$hoteles_arr[0]['break_fast'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DS'.$cont ,'')->getStyle('BA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['numero_hab'])){
					    	$activeSheet->setCellValue('DT'.$cont ,$hoteles_arr[0]['numero_hab'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DT'.$cont ,'')->getStyle('BB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['id_habitacion'])){
					    	$activeSheet->setCellValue('DU'.$cont ,$hoteles_arr[0]['id_habitacion'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DU'.$cont ,'')->getStyle('BC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['id_ciudad'])){
					    	$activeSheet->setCellValue('DV'.$cont ,$hoteles_arr[0]['id_ciudad'] )->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DV'.$cont ,'')->getStyle('BD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[0]['country'])){
					    	$activeSheet->setCellValue('DW'.$cont ,$hoteles_arr[0]['country'] )->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DW'.$cont ,'')->getStyle('BE'.$cont)->getFont()->setBold(false);
					    }
		                 //**********************HOTEL 2
					    if(isset($hoteles_arr[1]['nombre_hotel'])){
					    	$activeSheet->setCellValue('DX'.$cont ,$hoteles_arr[1]['nombre_hotel'] )->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DX'.$cont ,'')->getStyle('BF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['fecha_entrada'])){
					    	$activeSheet->setCellValue('DY'.$cont ,$hoteles_arr[1]['fecha_entrada'] )->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DY'.$cont ,'')->getStyle('BG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['fecha_salida'])){
					    	$activeSheet->setCellValue('DZ'.$cont ,$hoteles_arr[1]['fecha_salida'] )->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('DZ'.$cont ,'')->getStyle('BH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['noches'])){
					    	$activeSheet->setCellValue('EA'.$cont ,$hoteles_arr[1]['noches'] )->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EA'.$cont ,'')->getStyle('BI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['break_fast'])){
					    	$activeSheet->setCellValue('EB'.$cont ,$hoteles_arr[1]['break_fast'] )->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EB'.$cont ,'')->getStyle('BJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['numero_hab'])){
					    	$activeSheet->setCellValue('EC'.$cont ,$hoteles_arr[1]['numero_hab'] )->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EC'.$cont ,'')->getStyle('BK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['id_habitacion'])){
					    	$activeSheet->setCellValue('ED'.$cont ,$hoteles_arr[1]['id_habitacion'] )->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ED'.$cont ,'')->getStyle('BL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['id_ciudad'])){
					    	$activeSheet->setCellValue('EE'.$cont ,$hoteles_arr[1]['id_ciudad'] )->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EE'.$cont ,'')->getStyle('BM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[1]['country'])){
					    	$activeSheet->setCellValue('EF'.$cont ,$hoteles_arr[1]['country'] )->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EF'.$cont ,'')->getStyle('BN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 3
					    if(isset($hoteles_arr[2]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EG'.$cont ,$hoteles_arr[2]['nombre_hotel'] )->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EG'.$cont ,'')->getStyle('BO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EH'.$cont ,$hoteles_arr[2]['fecha_entrada'] )->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EH'.$cont ,'')->getStyle('BP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['fecha_salida'])){
					    	$activeSheet->setCellValue('EI'.$cont ,$hoteles_arr[2]['fecha_salida'] )->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EI'.$cont ,'')->getStyle('BQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['noches'])){
					    	$activeSheet->setCellValue('EJ'.$cont ,$hoteles_arr[2]['noches'] )->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EJ'.$cont ,'')->getStyle('BR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['break_fast'])){
					    	$activeSheet->setCellValue('EK'.$cont ,$hoteles_arr[2]['break_fast'] )->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EK'.$cont ,'')->getStyle('BS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['numero_hab'])){
					    	$activeSheet->setCellValue('EL'.$cont ,$hoteles_arr[2]['numero_hab'] )->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EL'.$cont ,'')->getStyle('BT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['id_habitacion'])){
					    	$activeSheet->setCellValue('EM'.$cont ,$hoteles_arr[2]['id_habitacion'] )->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EM'.$cont ,'')->getStyle('BU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['id_ciudad'])){
					    	$activeSheet->setCellValue('EN'.$cont ,$hoteles_arr[2]['id_ciudad'] )->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EN'.$cont ,'')->getStyle('BV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[2]['country'])){
					    	$activeSheet->setCellValue('EO'.$cont ,$hoteles_arr[2]['country'] )->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EO'.$cont ,'')->getStyle('BW'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 4
					    if(isset($hoteles_arr[3]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EP'.$cont ,$hoteles_arr[3]['nombre_hotel'] )->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EP'.$cont ,'')->getStyle('BX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EQ'.$cont ,$hoteles_arr[3]['fecha_entrada'] )->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EQ'.$cont ,'')->getStyle('BY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['fecha_salida'])){
					    	$activeSheet->setCellValue('ER'.$cont ,$hoteles_arr[3]['fecha_salida'] )->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ER'.$cont ,'')->getStyle('BZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['noches'])){
					    	$activeSheet->setCellValue('ES'.$cont ,$hoteles_arr[3]['noches'] )->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ES'.$cont ,'')->getStyle('CA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['break_fast'])){
					    	$activeSheet->setCellValue('ET'.$cont ,$hoteles_arr[3]['break_fast'] )->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ET'.$cont ,'')->getStyle('CB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['numero_hab'])){
					    	$activeSheet->setCellValue('EU'.$cont ,$hoteles_arr[3]['numero_hab'] )->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EU'.$cont ,'')->getStyle('CC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['id_habitacion'])){
					    	$activeSheet->setCellValue('EV'.$cont ,$hoteles_arr[3]['id_habitacion'] )->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EV'.$cont ,'')->getStyle('CD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['id_ciudad'])){
					    	$activeSheet->setCellValue('EW'.$cont ,$hoteles_arr[3]['id_ciudad'] )->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EW'.$cont ,'')->getStyle('CE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[3]['country'])){
					    	$activeSheet->setCellValue('EX'.$cont ,$hoteles_arr[3]['country'] )->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EX'.$cont ,'')->getStyle('CF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 5
					    if(isset($hoteles_arr[4]['nombre_hotel'])){
					    	$activeSheet->setCellValue('EY'.$cont ,$hoteles_arr[4]['nombre_hotel'] )->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EY'.$cont ,'')->getStyle('CG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['fecha_entrada'])){
					    	$activeSheet->setCellValue('EZ'.$cont ,$hoteles_arr[4]['fecha_entrada'] )->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('EZ'.$cont ,'')->getStyle('CH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['fecha_salida'])){
					    	$activeSheet->setCellValue('FA'.$cont ,$hoteles_arr[4]['fecha_salida'] )->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FA'.$cont ,'')->getStyle('CI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['noches'])){
					    	$activeSheet->setCellValue('FB'.$cont ,$hoteles_arr[4]['noches'] )->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FB'.$cont ,'')->getStyle('CJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['break_fast'])){
					    	$activeSheet->setCellValue('FC'.$cont ,$hoteles_arr[4]['break_fast'] )->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FC'.$cont ,'')->getStyle('CK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['numero_hab'])){
					    	$activeSheet->setCellValue('FD'.$cont ,$hoteles_arr[4]['numero_hab'] )->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FD'.$cont ,'')->getStyle('CL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['id_habitacion'])){
					    	$activeSheet->setCellValue('FE'.$cont ,$hoteles_arr[4]['id_habitacion'] )->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FE'.$cont ,'')->getStyle('CM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['id_ciudad'])){
					    	$activeSheet->setCellValue('FF'.$cont ,$hoteles_arr[4]['id_ciudad'] )->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FF'.$cont ,'')->getStyle('CN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[4]['country'])){
					    	$activeSheet->setCellValue('FG'.$cont ,$hoteles_arr[4]['country'] )->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FG'.$cont ,'')->getStyle('CO'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 6
					    if(isset($hoteles_arr[5]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FH'.$cont ,$hoteles_arr[5]['nombre_hotel'] )->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FH'.$cont ,'')->getStyle('CP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FI'.$cont ,$hoteles_arr[5]['fecha_entrada'] )->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FI'.$cont ,'')->getStyle('CQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['fecha_salida'])){
					    	$activeSheet->setCellValue('FJ'.$cont ,$hoteles_arr[5]['fecha_salida'] )->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FJ'.$cont ,'')->getStyle('CR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['noches'])){
					    	$activeSheet->setCellValue('FK'.$cont ,$hoteles_arr[5]['noches'] )->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FK'.$cont ,'')->getStyle('CS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['break_fast'])){
					    	$activeSheet->setCellValue('FL'.$cont ,$hoteles_arr[5]['break_fast'] )->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FL'.$cont ,'')->getStyle('CT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['numero_hab'])){
					    	$activeSheet->setCellValue('FM'.$cont ,$hoteles_arr[5]['numero_hab'] )->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FM'.$cont ,'')->getStyle('CU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['id_habitacion'])){
					    	$activeSheet->setCellValue('FN'.$cont ,$hoteles_arr[5]['id_habitacion'] )->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FN'.$cont ,'')->getStyle('CV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['id_ciudad'])){
					    	$activeSheet->setCellValue('FO'.$cont ,$hoteles_arr[5]['id_ciudad'] )->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FO'.$cont ,'')->getStyle('CW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[5]['country'])){
					    	$activeSheet->setCellValue('FP'.$cont ,$hoteles_arr[5]['country'] )->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FP'.$cont ,'')->getStyle('CX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 7
					    if(isset($hoteles_arr[6]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FQ'.$cont ,$hoteles_arr[6]['nombre_hotel'] )->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FQ'.$cont ,'')->getStyle('CY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['fecha_entrada'])){
					    	$activeSheet->setCellValue('FR'.$cont ,$hoteles_arr[6]['fecha_entrada'] )->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FR'.$cont ,'')->getStyle('CZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['fecha_salida'])){
					    	$activeSheet->setCellValue('FS'.$cont ,$hoteles_arr[6]['fecha_salida'] )->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FS'.$cont ,'')->getStyle('DA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['noches'])){
					    	$activeSheet->setCellValue('FT'.$cont ,$hoteles_arr[6]['noches'] )->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FT'.$cont ,'')->getStyle('DB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['break_fast'])){
					    	$activeSheet->setCellValue('FU'.$cont ,$hoteles_arr[6]['break_fast'] )->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FU'.$cont ,'')->getStyle('DC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['numero_hab'])){
					    	$activeSheet->setCellValue('FV'.$cont ,$hoteles_arr[6]['numero_hab'] )->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FV'.$cont ,'')->getStyle('DD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['id_habitacion'])){
					    	$activeSheet->setCellValue('FW'.$cont ,$hoteles_arr[6]['id_habitacion'] )->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FW'.$cont ,'')->getStyle('DE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['id_ciudad'])){
					    	$activeSheet->setCellValue('FX'.$cont ,$hoteles_arr[6]['id_ciudad'] )->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FX'.$cont ,'')->getStyle('DF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[6]['country'])){
					    	$activeSheet->setCellValue('FY'.$cont ,$hoteles_arr[6]['country'] )->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FY'.$cont ,'')->getStyle('DG'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 8
					    if(isset($hoteles_arr[7]['nombre_hotel'])){
					    	$activeSheet->setCellValue('FZ'.$cont ,$hoteles_arr[7]['nombre_hotel'] )->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('FZ'.$cont ,'')->getStyle('DH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GA'.$cont ,$hoteles_arr[7]['fecha_entrada'] )->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GA'.$cont ,'')->getStyle('DI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['fecha_salida'])){
					    	$activeSheet->setCellValue('GB'.$cont ,$hoteles_arr[7]['fecha_salida'] )->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GB'.$cont ,'')->getStyle('DJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['noches'])){
					    	$activeSheet->setCellValue('GC'.$cont ,$hoteles_arr[7]['noches'] )->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GC'.$cont ,'')->getStyle('DK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['break_fast'])){
					    	$activeSheet->setCellValue('GD'.$cont ,$hoteles_arr[7]['break_fast'] )->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GD'.$cont ,'')->getStyle('DL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['numero_hab'])){
					    	$activeSheet->setCellValue('GE'.$cont ,$hoteles_arr[7]['numero_hab'] )->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GE'.$cont ,'')->getStyle('DM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['id_habitacion'])){
					    	$activeSheet->setCellValue('GF'.$cont ,$hoteles_arr[7]['id_habitacion'] )->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GF'.$cont ,'')->getStyle('DN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['id_ciudad'])){
					    	$activeSheet->setCellValue('GG'.$cont ,$hoteles_arr[7]['id_ciudad'] )->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GG'.$cont ,'')->getStyle('DO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[7]['country'])){
					    	$activeSheet->setCellValue('GH'.$cont ,$hoteles_arr[7]['country'] )->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GH'.$cont ,'')->getStyle('DP'.$cont)->getFont()->setBold(false);
					    }
					    //**********************HOTEL 9
					    if(isset($hoteles_arr[8]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GI'.$cont ,$hoteles_arr[8]['nombre_hotel'] )->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GI'.$cont ,'')->getStyle('DQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GJ'.$cont ,$hoteles_arr[8]['fecha_entrada'] )->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GJ'.$cont ,'')->getStyle('DR'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['fecha_salida'])){
					    	$activeSheet->setCellValue('GK'.$cont ,$hoteles_arr[8]['fecha_salida'] )->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GK'.$cont ,'')->getStyle('DS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['noches'])){
					    	$activeSheet->setCellValue('GL'.$cont ,$hoteles_arr[8]['noches'] )->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GL'.$cont ,'')->getStyle('DT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['break_fast'])){
					    	$activeSheet->setCellValue('GM'.$cont ,$hoteles_arr[8]['break_fast'] )->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GM'.$cont ,'')->getStyle('DU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['numero_hab'])){
					    	$activeSheet->setCellValue('GN'.$cont ,$hoteles_arr[8]['numero_hab'] )->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GN'.$cont ,'')->getStyle('DV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['id_habitacion'])){
					    	$activeSheet->setCellValue('GO'.$cont ,$hoteles_arr[8]['id_habitacion'] )->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GO'.$cont ,'')->getStyle('DW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['id_ciudad'])){
					    	$activeSheet->setCellValue('GP'.$cont ,$hoteles_arr[8]['id_ciudad'] )->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GP'.$cont ,'')->getStyle('DX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[8]['country'])){
					    	$activeSheet->setCellValue('GQ'.$cont ,$hoteles_arr[8]['country'] )->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GQ'.$cont ,'')->getStyle('DY'.$cont)->getFont()->setBold(false);
					    }
					     //**********************HOTEL 9
					    if(isset($hoteles_arr[9]['nombre_hotel'])){
					    	$activeSheet->setCellValue('GR'.$cont ,$hoteles_arr[9]['nombre_hotel'] )->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GR'.$cont ,'')->getStyle('DZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['fecha_entrada'])){
					    	$activeSheet->setCellValue('GS'.$cont ,$hoteles_arr[9]['fecha_entrada'] )->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GS'.$cont ,'')->getStyle('EA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['fecha_salida'])){
					    	$activeSheet->setCellValue('GT'.$cont ,$hoteles_arr[9]['fecha_salida'] )->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GT'.$cont ,'')->getStyle('EB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['noches'])){
					    	$activeSheet->setCellValue('GU'.$cont ,$hoteles_arr[9]['noches'] )->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GU'.$cont ,'')->getStyle('EC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['break_fast'])){
					    	$activeSheet->setCellValue('GV'.$cont ,$hoteles_arr[9]['break_fast'] )->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GV'.$cont ,'')->getStyle('ED'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['numero_hab'])){
					    	$activeSheet->setCellValue('GW'.$cont ,$hoteles_arr[9]['numero_hab'] )->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GW'.$cont ,'')->getStyle('EE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['id_habitacion'])){
					    	$activeSheet->setCellValue('GX'.$cont ,$hoteles_arr[9]['id_habitacion'] )->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GX'.$cont ,'')->getStyle('EF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['id_ciudad'])){
					    	$activeSheet->setCellValue('GY'.$cont ,$hoteles_arr[9]['id_ciudad'] )->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GY'.$cont ,'')->getStyle('EG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($hoteles_arr[9]['country'])){
					    	$activeSheet->setCellValue('GZ'.$cont ,$hoteles_arr[9]['country'] )->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('GZ'.$cont ,'')->getStyle('EH'.$cont)->getFont()->setBold(false);
					    }


						$autos_arr = $this->Mod_reportes_layout_seg->get_autos_num_bol($consecutivo);  

						//**********************Autos 1
					    if(isset($autos_arr[0]['tipo_auto'])){
					    	$activeSheet->setCellValue('HA'.$cont ,$autos_arr[0]['tipo_auto'] )->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HA'.$cont ,'')->getStyle('EI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HB'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HB'.$cont ,'')->getStyle('EJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['dias'])){
					    	$activeSheet->setCellValue('HC'.$cont ,$autos_arr[0]['dias'] )->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HC'.$cont ,'')->getStyle('EK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HD'.$cont ,$autos_arr[0]['id_ciudad_entrega'] )->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HD'.$cont ,'')->getStyle('EL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HE'.$cont ,$autos_arr[0]['id_ciudad_recoge'] )->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HE'.$cont ,'')->getStyle('EM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[0]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HF'.$cont ,$autos_arr[0]['fecha_entrega'] )->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HF'.$cont ,'')->getStyle('EN'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[1]['tipo_auto'])){
					    	$activeSheet->setCellValue('HG'.$cont ,$autos_arr[1]['tipo_auto'] )->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HG'.$cont ,'')->getStyle('EO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HH'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HH'.$cont ,'')->getStyle('EP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['dias'])){
					    	$activeSheet->setCellValue('HI'.$cont ,$autos_arr[1]['dias'] )->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HI'.$cont ,'')->getStyle('EQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HJ'.$cont ,$autos_arr[1]['id_ciudad_entrega'] )->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HJ'.$cont ,'')->getStyle('ER'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HK'.$cont ,$autos_arr[1]['id_ciudad_recoge'] )->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HK'.$cont ,'')->getStyle('ES'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[1]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HL'.$cont ,$autos_arr[1]['fecha_entrega'] )->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HL'.$cont ,'')->getStyle('ET'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[2]['tipo_auto'])){
					    	$activeSheet->setCellValue('HM'.$cont ,$autos_arr[2]['tipo_auto'] )->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HM'.$cont ,'')->getStyle('EU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HN'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HN'.$cont ,'')->getStyle('EV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['dias'])){
					    	$activeSheet->setCellValue('HO'.$cont ,$autos_arr[2]['dias'] )->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HO'.$cont ,'')->getStyle('EW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HP'.$cont ,$autos_arr[2]['id_ciudad_entrega'] )->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HP'.$cont ,'')->getStyle('EX'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HQ'.$cont ,$autos_arr[2]['id_ciudad_recoge'] )->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HQ'.$cont ,'')->getStyle('EY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[2]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HR'.$cont ,$autos_arr[2]['fecha_entrega'] )->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HR'.$cont ,'')->getStyle('EZ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[3]['tipo_auto'])){
					    	$activeSheet->setCellValue('HS'.$cont ,$autos_arr[3]['tipo_auto'] )->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HS'.$cont ,'')->getStyle('FA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HT'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HT'.$cont ,'')->getStyle('FB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['dias'])){
					    	$activeSheet->setCellValue('HU'.$cont ,$autos_arr[3]['dias'] )->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HU'.$cont ,'')->getStyle('FC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('HV'.$cont ,$autos_arr[3]['id_ciudad_entrega'] )->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HV'.$cont ,'')->getStyle('FD'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('HW'.$cont ,$autos_arr[3]['id_ciudad_recoge'] )->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HW'.$cont ,'')->getStyle('FE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[3]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HX'.$cont ,$autos_arr[3]['fecha_entrega'] )->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HX'.$cont ,'')->getStyle('FF'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[4]['tipo_auto'])){
					    	$activeSheet->setCellValue('HY'.$cont ,$autos_arr[4]['tipo_auto'] )->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HY'.$cont ,'')->getStyle('FG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('HZ'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('HZ'.$cont ,'')->getStyle('FH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['dias'])){
					    	$activeSheet->setCellValue('IA'.$cont ,$autos_arr[4]['dias'] )->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IA'.$cont ,'')->getStyle('FI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IB'.$cont ,$autos_arr[4]['id_ciudad_entrega'] )->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IB'.$cont ,'')->getStyle('FJ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IC'.$cont ,$autos_arr[4]['id_ciudad_recoge'] )->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IC'.$cont ,'')->getStyle('FK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[4]['fecha_entrega'])){
					    	$activeSheet->setCellValue('ID'.$cont ,$autos_arr[4]['fecha_entrega'] )->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('ID'.$cont ,'')->getStyle('FL'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[5]['tipo_auto'])){
					    	$activeSheet->setCellValue('IE'.$cont ,$autos_arr[5]['tipo_auto'] )->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IE'.$cont ,'')->getStyle('FM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IF'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IF'.$cont ,'')->getStyle('FN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['dias'])){
					    	$activeSheet->setCellValue('IG'.$cont ,$autos_arr[5]['dias'] )->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IG'.$cont ,'')->getStyle('FO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IH'.$cont ,$autos_arr[5]['id_ciudad_entrega'] )->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IH'.$cont ,'')->getStyle('FP'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('II'.$cont ,$autos_arr[5]['id_ciudad_recoge'] )->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('II'.$cont ,'')->getStyle('FQ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[5]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IJ'.$cont ,$autos_arr[5]['fecha_entrega'] )->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IJ'.$cont ,'')->getStyle('FR'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[6]['tipo_auto'])){
					    	$activeSheet->setCellValue('IK'.$cont ,$autos_arr[6]['tipo_auto'] )->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IK'.$cont ,'')->getStyle('FS'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IL'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IL'.$cont ,'')->getStyle('FT'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['dias'])){
					    	$activeSheet->setCellValue('IM'.$cont ,$autos_arr[6]['dias'] )->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IM'.$cont ,'')->getStyle('FU'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IN'.$cont ,$autos_arr[6]['id_ciudad_entrega'] )->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IN'.$cont ,'')->getStyle('FV'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IO'.$cont ,$autos_arr[6]['id_ciudad_recoge'] )->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IO'.$cont ,'')->getStyle('FW'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[6]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IP'.$cont ,$autos_arr[6]['fecha_entrega'] )->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IP'.$cont ,'')->getStyle('FX'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[7]['tipo_auto'])){
					    	$activeSheet->setCellValue('IQ'.$cont ,$autos_arr[7]['tipo_auto'] )->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IQ'.$cont ,'')->getStyle('FY'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IR'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IR'.$cont ,'')->getStyle('FZ'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['dias'])){
					    	$activeSheet->setCellValue('IS'.$cont ,$autos_arr[7]['dias'] )->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IS'.$cont ,'')->getStyle('GA'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IT'.$cont ,$autos_arr[7]['id_ciudad_entrega'] )->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IT'.$cont ,'')->getStyle('GB'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('IU'.$cont ,$autos_arr[7]['id_ciudad_recoge'] )->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IU'.$cont ,'')->getStyle('GC'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[7]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IV'.$cont ,$autos_arr[7]['fecha_entrega'] )->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IV'.$cont ,'')->getStyle('GD'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[8]['tipo_auto'])){
					    	$activeSheet->setCellValue('IW'.$cont ,$autos_arr[8]['tipo_auto'] )->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IW'.$cont ,'')->getStyle('GE'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('IX'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IX'.$cont ,'')->getStyle('GF'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['dias'])){
					    	$activeSheet->setCellValue('IY'.$cont ,$autos_arr[8]['dias'] )->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IY'.$cont ,'')->getStyle('GG'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('IZ'.$cont ,$autos_arr[8]['id_ciudad_entrega'] )->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('IZ'.$cont ,'')->getStyle('GH'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JA'.$cont ,$autos_arr[8]['id_ciudad_recoge'] )->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JA'.$cont ,'')->getStyle('GI'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[8]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JB'.$cont ,$autos_arr[8]['fecha_entrega'] )->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JB'.$cont ,'')->getStyle('GJ'.$cont)->getFont()->setBold(false);
					    }
					    //**********************Autos 1
					    if(isset($autos_arr[9]['tipo_auto'])){
					    	$activeSheet->setCellValue('JC'.$cont ,$autos_arr[9]['tipo_auto'] )->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JC'.$cont ,'')->getStyle('GK'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JD'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JD'.$cont ,'')->getStyle('GL'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['dias'])){
					    	$activeSheet->setCellValue('JE'.$cont ,$autos_arr[9]['dias'] )->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JE'.$cont ,'')->getStyle('GM'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_entrega'])){
					    	$activeSheet->setCellValue('JF'.$cont ,$autos_arr[9]['id_ciudad_entrega'] )->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JF'.$cont ,'')->getStyle('GN'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['id_ciudad_recoge'])){
					    	$activeSheet->setCellValue('JG'.$cont ,$autos_arr[9]['id_ciudad_recoge'] )->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JG'.$cont ,'')->getStyle('GO'.$cont)->getFont()->setBold(false);
					    }
					    if(isset($autos_arr[9]['fecha_entrega'])){
					    	$activeSheet->setCellValue('JH'.$cont ,$autos_arr[9]['fecha_entrega'] )->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }else{
					    	$activeSheet->setCellValue('JH'.$cont ,'')->getStyle('GP'.$cont)->getFont()->setBold(false);
					    }

					   }//FIN VALIDACION ELSE CONSECUTIVO
				}

			  //} //fin validacion consecutivo

			} //FIN DE LA VALIDACION TYPE OF SERVICE

			//$activeSheet->getColumnDimension('A')->setVisible(false);

			array_push($array_consecutivo, $valor->consecutivo);	   
			    
		} //FIN DEL FOREACH PRINCIPAL
 

 		$spreadsheet->getActiveSheet()
	    ->getStyle('S5:S'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('AC5:AC'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('AM5:AM'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('AW5:AW'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('BG5:BG'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('BQ5:BQ'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('CA5:CA'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('CK5:CK'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('CU5:CU'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('DE5:DE'.$cont)
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);



	    //********se optiene array ya trabajado por phpexcel
		$cellValues = $activeSheet->rangeToArray('A5:JK'.$cont); 

		//*********reseetea el formato
		$spreadsheet->disconnectWorksheets();
		unset($spreadsheet);
		//*****************************

		//********crea nuevamente una hoja de trabajo
		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();
		//***********************************
		
		$rest_plantilla = $this->Mod_reportes_layout_seg->get_columnas($id_plantilla,5);

		if($id_plantilla != 0){

			$array_plantilla = [];

			foreach ($rest_plantilla as $key_plantilla => $value_plantilla) {
					
			    $order_column =  ltrim(rtrim($value_plantilla->order_column));

				$order_column = $order_column - 1;

				array_push($array_plantilla, $order_column);

			}

			$array_nuevo_formato_ordenado = [];
		    foreach ($cellValues as $key_cel => $value_cel) {  

		    		$array_nuevo_formato = [];
			    	foreach ($array_plantilla as $key_col => $value_col) {  

				    	array_push($array_nuevo_formato, $value_cel[$value_col]);
						
					}

					array_push($array_nuevo_formato_ordenado, $array_nuevo_formato);

	        }

	    $data = $array_nuevo_formato_ordenado;

		}else{

		$data = $cellValues;

		}

		$activeSheet->fromArray(
	        $data,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A5'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

	    $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
		
		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');
		

		$cont_let = 1;
		foreach ($rest_plantilla as $clave => $valor) {

			$letra = $this->lib_letras_excel->get_letra_excel($cont_let);
			
			$spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
			
			$spreadsheet->getActiveSheet()->getStyle($letra.'5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$activeSheet->getStyle('A5:'.$letra.'5')->getFill()
	    	->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    	->getStartColor()->setARGB('1f497d');

	    	$spreadsheet->getActiveSheet()->getStyle('A5:'.$letra.'5')
        	->getFont()->getColor()->setARGB('ffffff');

        	
	    $cont_let++;

		}

		$styleArray = [
			    'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			             'color' => ['argb' => 'ffffff'],
			        ],
			    ],
			];

	    if(count($rest_plantilla) < 15){

	    	$spreadsheet->getActiveSheet()->getStyle('A1:N'.$cont)->applyFromArray($styleArray);

	    }else{

	    	if($id_plantilla == 0){

	    		$spreadsheet->getActiveSheet()->getStyle('A1:JL'.$cont)->applyFromArray($styleArray);

	    	}else{

	    		$num_col = count($rest_plantilla);
	    		$letra = $this->lib_letras_excel->get_letra_excel($cont_let);

	    		$spreadsheet->getActiveSheet()->getStyle('A1:'.$letra.$cont)->applyFromArray($styleArray);

	    	}
	    	

	    }
		

		$spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setCoordinates('A1');
		$drawing->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/img/villatours.png');
		$drawing->setHeight(250);
		$drawing->setWidth(250);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing2->setName('Logo');
		$drawing2->setDescription('Logo');
		$drawing2->setCoordinates('N1');
		$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/img/91_4c.gif');
		$drawing2->setHeight(60);
		$drawing2->setWidth(60);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());

		$activeSheet->setCellValue('F1','SERVICIOS POR SEGMENTO' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);
	
		if($tipo_funcion == "aut"){

        	  	 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$parametros["fecha1"],$parametros["fecha2"]);

        		 $rango_fechas = explode("_", $rango_fechas);

        		 $fecha1 = $rango_fechas[0];
        		 $fecha2 = $rango_fechas[1];

        	   	 $activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);

        	
		}else{

			$activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);

		}

		//************************************************************************************/

		$ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");

            if(count($ids_corporativo) > 0 ){


	            if(count($ids_corporativo) == 1){

	              	$str_corporativo = explode('/', $str_corporativo);
					$str_corporativo = array_filter($str_corporativo, "strlen");
					$str_corporativo = array_unique($str_corporativo);
					$str_corporativo = implode("/", $str_corporativo);
					$activeSheet->setCellValue('F3',utf8_encode($str_corporativo) )->getStyle('F3')->getFont()->setSize(14);	              	

	            }else{

	              	$activeSheet->setCellValue('F2',"Clientes Villatours" )->getStyle('F2')->getFont()->setSize(14);

	            }


            }else if(count($ids_cliente) > 0){

            	
                $rz = $this->Mod_reportes_layout_seg->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
                if(count($rz) > 1){

                	$activeSheet->setCellValue('F2',"Clientes Villatours" )->getStyle('F2')->getFont()->setSize(14);
                	  
                }else{


                    $str_razon_social = explode('/', $str_razon_social);
					$str_razon_social = array_filter($str_razon_social, "strlen");
					$str_razon_social = array_unique($str_razon_social);
					$str_razon_social = implode("/", $str_razon_social);
					$activeSheet->setCellValue('F2',utf8_encode($str_razon_social) )->getStyle('F2')->getFont()->setSize(14);
					
	            	
                }
                
            }else{

            	$activeSheet->setCellValue('F2',"Clientes Villatours" )->getStyle('F2')->getFont()->setSize(14);
            	

            }

		//*************************************************************************************/

       if($tipo_funcion == "aut"){

       	$fecha1 = substr($fecha1, 0, 10);
       	$fecha2 = substr($fecha2, 0, 10);
       	
       	$str_fecha = $fecha1.'_A_'.$fecha2;

       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Layout_Segmentado_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Layout_Segmentado_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
       	echo json_encode(1); //cuando es uno si tiene informacion

       }else{

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte_Layout_Segmentado_'.$fecha1.'_A_'.$fecha2.'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$Excel_writer->save('php://output', 'xlsx');

       }
       

     }// fin validacion count
  else{ 

  	if($tipo_funcion != "aut"){

   	  		print_r("<label>No existe informacion para exportar</label>");

    }else{

        	echo json_encode(0); //cuando es uno si tiene informacion

    }
 	

  }
		
 }

}
