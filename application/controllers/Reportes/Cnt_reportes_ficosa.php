<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_ficosa extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_ficosa');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->Mod_general->get_SPID();
	     
	}

	public function get_html_rep_ficosa(){

		$title = $this->input->post('title');
		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,6);
		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
	    $param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param['title'] = $title;


		$this->load->view('Filtros/view_filtros',$param);

		$this->load->view('Reportes/view_rep_ficosa');
		
	}
	
	public function get_reportes_ficosa(){

		$parametros = $this->input->post("parametros");
        $tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$parametros = explode(",", $parametros);
        
        if($tipo_funcion == "aut"){

       		$ids_suc = $parametros[0];
        	$ids_serie = $parametros[1];
	        $ids_cliente = $parametros[2];
	        $ids_servicio = $parametros[3];  //esta vacio --no se ocupa en este reporte 
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

     
		$rest = $this->Mod_reportes_ficosa->get_reportes_ficosa($parametros);
		  
		  $array1 = array();
		  $array_consecutivo = array();
		  $array_ticket_number = array();

		  function data_general($valor,$segmentos){  //SUB FUNCION
 					
					$dat['GVC_NOM_CLI'] = utf8_encode($valor->GVC_NOM_CLI);
					$dat['consecutivo'] = utf8_encode($valor->consecutivo);
					$dat['name'] = utf8_encode($valor->name);
					$dat['nexp'] = utf8_encode($valor->nexp);
					$dat['destination'] = utf8_encode($valor->destination);

					$dat['fecha_salida_vu'] = utf8_encode($valor->fecha_salida_vu);

					$dat['documento'] = utf8_encode($valor->documento);
					$dat['solicitor'] = utf8_encode($valor->solicitor);

					$dat['type_of_service'] = utf8_encode($valor->type_of_service);
					//$valor->type_of_service = 'HOTEL';
					$dat['supplier'] = utf8_encode($valor->supplier);
					
					$dat['final_user'] = utf8_encode($valor->final_user);
					$dat['ticket_number'] = utf8_encode($valor->ticket_number);
					$dat['typo_of_ticket'] = utf8_encode($valor->typo_of_ticket);
					$dat['fecha_emi'] = utf8_encode($valor->fecha_emi);
					

					if(utf8_encode($valor->city) == '_____campo_vacio_____'){

						$valor->city = '';

					}else{

						$valor->city = utf8_encode($valor->city);

					}


					$dat['country'] = utf8_encode($valor->country);
					$dat['total_emission'] = utf8_encode($valor->total_emission);
					$dat['total_millas'] = utf8_encode($valor->total_millas);

					$dat['buy_in_advance'] = utf8_encode($valor->buy_in_advance);
					$dat['record_localizador'] = utf8_encode($valor->record_localizador);
					$dat['GVC_ID_CENTRO_COSTO'] = utf8_encode($valor->GVC_ID_CENTRO_COSTO);
					$dat['analisis14_cliente'] = utf8_encode($valor->analisis14_cliente);

					if( $valor->emd == 'S'){  //pone los itnerary vacios

					$dat['total_Itinerary1'] = '';
					$dat['origin1'] = '';
					$dat['destina1'] = '';

					$dat['total_Itinerary2'] = '';
					$dat['origin2'] = '';
					$dat['destina2'] = '';

					$dat['total_Itinerary3'] = '';
					$dat['origin3'] = '';
					$dat['destina3'] = '';

					$dat['total_Itinerary4'] = '';
					$dat['origin4'] = '';
					$dat['destina4'] = '';

					$dat['total_Itinerary5'] = '';
					$dat['origin5'] = '';
					$dat['destina5'] = '';

					$dat['total_Itinerary6'] = '';
					$dat['origin6'] = '';
					$dat['destina6'] ='';

					$dat['total_Itinerary7'] ='';
					$dat['origin7'] = '';
					$dat['destina7'] = '';

					$dat['total_Itinerary8'] = '';
					$dat['origin8'] = '';
					$dat['destina8'] = '';

					$dat['total_Itinerary9'] = '';
					$dat['origin9'] = '';
					$dat['destina9'] = '';

					$dat['total_Itinerary10'] = '';
					$dat['origin10'] = '';
					$dat['destina10'] = '';


					}else{

							for($x=0;$x<10;$x++){


								if(array_key_exists($x, $segmentos) && $valor->typo_of_ticket == 'I') {

										$tarifa_segmento = $segmentos[$x]['tarifa_segmento'];
										$combustible = $valor->combustible;
										$tpo_cambio = $valor->tpo_cambio;
										$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
										$dat['total_Itinerary'.($x+1)] = $scf;



								}else if(array_key_exists($x, $segmentos) && $valor->typo_of_ticket == 'N'){

										$tarifa_segmento = $segmentos[$x]['tarifa_segmento'];
										$combustible = $valor->combustible;
										$scf = (int)$tarifa_segmento + (int)$combustible;
										$dat['total_Itinerary'.($x+1)] = $scf;

								}else{

									   $total_Itinerary = 'total_Itinerary'.($x+1);
									   $dat['total_Itinerary'.($x+1)] = $valor->$total_Itinerary;

								}

								//*******origin1
								if(array_key_exists($x, $segmentos)) {

										$id_ciudad_salida = $segmentos[$x]['id_ciudad_salida'];
										$dat['origin'.($x+1)] = $id_ciudad_salida;


								}else{

									    $origin = 'origin'.($x+1);
									    $dat['origin'.($x+1)] = $valor->$origin;
									
								}

								//******destina1
								if(array_key_exists($x, $segmentos)) {

										$id_ciudad_destino = $segmentos[$x]['id_ciudad_destino'];
										$dat['destina'.($x+1)] = $id_ciudad_destino;

								}else{

									    $destina = 'destina'.($x+1);
										$dat['destina'.($x+1)] =$valor->$destina;
									
								}

							}
		

					} //fin else
				
					return $dat;
				} //FIN FUNCION DATA GENERAL

		
		   foreach ($rest as $clave => $valor) {

			    $consecutivo = utf8_encode($valor->consecutivo);
			    $record_localizador = utf8_encode($valor->record_localizador);

			   
			  	    if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI' || $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT' || $valor->type_of_service == 'HOTNAC_RES' /*|| $valor->type_of_service == 'HOTNAC_VARIOS'*/){
						

						if( !in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT'){

							$ticket = utf8_encode($valor->ticket_number);
							$segmentos = $this->Mod_reportes_ficosa->get_segmentos_ticket_number($ticket,$consecutivo);
							$dat = data_general($valor,$segmentos);

							$dat['type_of_service'] = 'HOTEL';
							$dat['codigo_producto'] = 'HOTEL';

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

						    $fac_numero = utf8_encode($valor->documento);
						    $id_serie = utf8_encode($valor->id_serie);


							$hoteles_iris_arr = $this->Mod_reportes_ficosa->get_hoteles_iris('man',$fecha_ini_proceso = '',$id_intervalo = 0,$fac_numero,$fecha1,$fecha2,$id_serie);


							$cont3=0;
					    	foreach ($hoteles_iris_arr as $clave_hot_ir => $valor_hot_ir) {  
							$cont3++;

						    	 $dat['nombre_hotel'] = utf8_encode($valor_hot_ir['servicio']);
						    	 $dat['fecha_entrada'] = utf8_encode($valor_hot_ir['fecha_entrada']);
						    	 $dat['fecha_salida'] = utf8_encode($valor_hot_ir['fecha_salida']);
						    	 $dat['noches'] = utf8_encode($valor_hot_ir['noches']);
						    	 $dat['numero_hab'] = utf8_encode($valor_hot_ir['cantidad']);
						    	 $dat['id_habitacion'] = utf8_encode($valor_hot_ir['id_habitacion']);
						    	 $dat['id_ciudad'] = utf8_encode($valor_hot_ir['id_ciudad']);

						    	 $dat['buy_in_advance'] = utf8_encode($valor_hot_ir['buy_in_advance']);
						    	 $dat['fecha_emi'] = $valor_hot_ir['fecha_fac2'];
						    
						    	array_push($array1, $dat);

							}

							$autos_arr = $this->Mod_reportes_ficosa->get_autos_num_bol($consecutivo);

						    $cont2=0;
						    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
						    $cont2++;

						  
						    	$dat['Car_class'] = utf8_encode($valor_aut['tipo_auto']);
								$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega']);
								$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
								$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
								$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
								$dat['Departure_date'] = utf8_encode($valor_aut['fecha_entrega']); //// es fecha recoge

								array_push($array1, $dat);

						    }
							
						    	

						}else if( !in_array($consecutivo, $array_consecutivo) && $valor->type_of_service == 'HOTNAC_RES'){

								$ticket = utf8_encode($valor->ticket_number);
								$segmentos = $this->Mod_reportes_ficosa->get_segmentos_ticket_number($ticket,$consecutivo);
								$dat = data_general($valor,$segmentos);

								$dat['type_of_service'] = 'HOTEL';
								$dat['codigo_producto'] = 'HOTEL';
						
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

								$hoteles_arr = $this->Mod_reportes_ficosa->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo,$fecha1,$fecha2);


								$cont=0;
							    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
							    $cont++;
							    

							    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
							    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada']);
							    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida']);
							    	$dat['noches'] = utf8_encode($valor_hot['noches']);
							    	$dat['numero_hab'] = utf8_encode($valor_hot['numero_hab']);
							    	$dat['id_habitacion'] = utf8_encode($valor_hot['id_habitacion']);
							    	$dat['id_ciudad'] = utf8_encode($valor_hot['id_ciudad']);
							    	
							    	$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];

							    	array_push($array1, $dat);

							   }

							   $autos_arr = $this->Mod_reportes_ficosa->get_autos_num_bol($consecutivo);

							    $cont2=0;
							    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
							    $cont2++;

							   
							    	$dat['Car_class'] = utf8_encode($valor_aut['tipo_auto']);
									$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega']);
									$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
									$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
									$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
									$dat['Departure_date'] = utf8_encode($valor_aut['fecha_entrega']);

									array_push($array1, $dat);
							    }

							  
					   
						}  // FIN ELSE IF HOTNAC RES

						
						else if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI'){
									
									$ticket = utf8_encode($valor->ticket_number);
	 
									$segmentos = $this->Mod_reportes_ficosa->get_segmentos_ticket_number($ticket,$consecutivo);

					    			$dat = data_general($valor,$segmentos);
									array_push($array1, $dat);
						    		
									if(!in_array($consecutivo, $array_consecutivo) ){

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

									    $hoteles_arr = $this->Mod_reportes_ficosa->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo,$fecha1,$fecha2);



							    		foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
									  		
									  		$dat = data_general($valor,$segmentos);

							    			$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
											$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada']);
											$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida']);
											$dat['noches'] = utf8_encode($valor_hot['noches']);

											$dat['numero_hab'] = utf8_encode($valor_hot['numero_hab']);
											$dat['id_habitacion'] = utf8_encode($valor_hot['id_habitacion']);
											$dat['id_ciudad'] = utf8_encode($valor_hot['id_ciudad']);
											$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];
							
									    	array_push($array1, $dat);
									   
									   }

									   $autos_arr = $this->Mod_reportes_ficosa->get_autos_num_bol($consecutivo);

									    $cont2=0;
									    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
									    $cont2++;

									    	
									    	$dat['tipo_auto'] = utf8_encode($valor_aut['tipo_auto']);
											$dat['fecha_entrega'] = utf8_encode($valor_aut['fecha_entrega']);
											$dat['dias'] = utf8_encode($valor_aut['dias']);
											$dat['id_ciudad_entrega'] = utf8_encode($valor_aut['id_ciudad_entrega']);
											$dat['id_ciudad_recoge'] = utf8_encode($valor_aut['id_ciudad_recoge']);
											$dat['fecha_entrega'] = utf8_encode($valor_aut['fecha_entrega']);

											array_push($array1, $dat);

									    }

								} //fin consecutivo hoteles
					   				
						    
							    //array_push($array1, $valor);
						}  //FIN IF BD Y BI

					}  // FIN DE if VADICION TYPE OF SERVICES
					else{ // todo lo que sea diferente pero tenga hoteles

						if(!in_array($consecutivo, $array_consecutivo) ){

									$ticket = utf8_encode($valor->ticket_number);
									$segmentos = $this->Mod_reportes_ficosa->get_segmentos_ticket_number($ticket,$consecutivo);
									$dat = data_general($valor,$segmentos);
									
									$dat['type_of_service'] = 'HOTEL';
								    $dat['codigo_producto'] = 'HOTEL';

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

									$hoteles_arr = $this->Mod_reportes_ficosa->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo,$fecha1,$fecha2);

									
									$cont=0;
								    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
								    $cont++;
								    	
								       	
								    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
								    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada']);
								    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida']);
								    	$dat['noches'] = utf8_encode($valor_hot['noches']);
								    	$dat['numero_hab'] = utf8_encode($valor_hot['numero_hab']);
								    	$dat['id_habitacion'] = utf8_encode($valor_hot['id_habitacion']);
								    	$dat['id_ciudad'] = utf8_encode($valor_hot['id_ciudad']);
							    		
							    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];

							    		array_push($array1, $dat);

							   	  }

								    $autos_arr = $this->Mod_reportes_ficosa->get_autos_num_bol($consecutivo);

								    $cont2=0;
								    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
								    $cont2++;

								    	$dat['Car_class'] = utf8_encode($valor_aut['tipo_auto']);
										$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega']);
										$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
										$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
										$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
										$dat['Departure_date'] = utf8_encode($valor_aut['fecha_entrega']);

										array_push($array1, $dat);

								    }

								    /*if(count($hoteles_arr) != 0){

								    	array_push($array1, $valor);
								    
								    }*/
								    

								}  // fin consecutivo

							
					
					}// FIN DE else VADICION TYPE OF SERVICES
	    
				    array_push($array_consecutivo, $valor->consecutivo);

					array_push($array_ticket_number, $valor->ticket_number);
			        
			   }  //fin del for principal

			   $col = $this->Mod_reportes_ficosa->get_columnas($id_plantilla,6);
			   
			   $param_final['rep'] = $array1;
		       $param_final['col'] = $col;
		     

			   echo json_encode($param_final);

         } //fin de la funcion


    public function exportar_excel_rep_ficosa(){

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

        
	$rep = $this->Mod_reportes_ficosa->get_reportes_ficosa($parametros);
		
	if(count($rep) > 0){

		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}
		
		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');

		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BL')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('BN')->setAutoSize(true);

		
		$activeSheet->getStyle('A5:BN5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('A5:BN5')
        ->getFont()->getColor()->setARGB('ffffff');

		 $styleArray = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ],
		];

		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');
		
        		
        $spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$spreadsheet->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('P5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('Q5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('R5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('S5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('T5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('U5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('V5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('W5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('X5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('Y5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('Z5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AA5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AB5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AC5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AD5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AE5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AF5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AG5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AH5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AI5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AJ5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AK5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AL5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AM5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AN5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AO5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AP5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AQ5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AR5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AS5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AT5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AU5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('AV5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				
				
		$cont = 5;
		$str_razon_social = "";
		$str_corporativo = "";

		$array_consecutivo = array();
		foreach ($rep as $clave => $valor) {
			
			$str_razon_social = $str_razon_social . $valor->GVC_NOM_CLI . '/';
			$str_corporativo = $str_corporativo . $valor->GVC_ID_CORPORATIVO . '/';
			$consecutivo = utf8_encode($valor->consecutivo);
			$record_localizador = utf8_encode($valor->record_localizador);

		if(utf8_encode($valor->type_of_service) == 'BD' || utf8_encode($valor->type_of_service) == 'BI' || utf8_encode($valor->type_of_service) == 'HOTNAC' || utf8_encode($valor->type_of_service) == 'HOTINT'){
			

			$cont++;

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
				//$activeSheet->setCellValue('R5','total_millas' )->getStyle('R5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('R5','total_Itinerary1' )->getStyle('R5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('S5','origin1' )->getStyle('S5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('T5','destina1' )->getStyle('T5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('U5','total_Itinerary2' )->getStyle('U5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('V5','origin2' )->getStyle('V5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('W5','destina2' )->getStyle('W5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('X5','total_Itinerary3' )->getStyle('X5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('Y5','origin3' )->getStyle('Y5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('Z5','destina3' )->getStyle('Z5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AA5','total_Itinerary4' )->getStyle('AA5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AB5','origin4' )->getStyle('AB5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AC5','destina4' )->getStyle('AC5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AD5','total_Itinerary5' )->getStyle('AD5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AE5','origin5' )->getStyle('AE5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AF5','destina5' )->getStyle('AF5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AG5','total_Itinerary6' )->getStyle('AG5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AH5','origin6' )->getStyle('AH5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AI5','destina6' )->getStyle('AI5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AJ5','total_Itinerary7' )->getStyle('AJ5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AK5','origin7' )->getStyle('AK5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AL5','destina7' )->getStyle('AL5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AM5','total_Itinerary8' )->getStyle('AM5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AN5','origin8' )->getStyle('AN5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AO5','destina8' )->getStyle('AO5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AP5','total_Itinerary9' )->getStyle('AP5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AQ5','origin9' )->getStyle('AQ5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AR5','destina9' )->getStyle('AR5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AS5','total_Itinerary10' )->getStyle('AS5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AT5','origin10' )->getStyle('AT5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AU5','destina10' )->getStyle('AU5')->getFont()->setBold(true)->setSize(11);
				

				$activeSheet->setCellValue('AV5','hotel' )->getStyle('AV5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AW5','Check In Date' )->getStyle('AW5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AX5','Check Out Date' )->getStyle('AX5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AY5','Room Nigth' )->getStyle('AY5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('AZ5','Breakfast (BB /OB)' )->getStyle('AZ5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BA5','Nr of Rooms' )->getStyle('BA5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BB5','Type of Room' )->getStyle('BB5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BC5','City' )->getStyle('BC5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BD5','country' )->getStyle('BD5')->getFont()->setBold(true)->setSize(11);
				

				$activeSheet->setCellValue('BE5','Car_class' )->getStyle('BE5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BF5','Delivery_Date' )->getStyle('BF5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BG5','Nr_days' )->getStyle('BG5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BH5','Place_delivery' )->getStyle('BH5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BI5','Place_delivery_back' )->getStyle('BI5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BJ5','Departure_date' )->getStyle('BJ5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BK5','buy in advance' )->getStyle('BK5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BL5','PNR' )->getStyle('BL5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BM5','CC' )->getStyle('BM5')->getFont()->setBold(true)->setSize(11);
				$activeSheet->setCellValue('BN5','AC14' )->getStyle('BN5')->getFont()->setBold(true)->setSize(11);


			   $ticket = utf8_encode($valor->ticket_number);
			   $segmentos = $this->Mod_reportes_ficosa->get_segmentos_ticket_number($ticket,$consecutivo);

               if(utf8_encode($valor->city) != '_____campo_vacio_____'){


					$activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('D'.$cont ,$valor->destination )->getStyle('D'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('E'.$cont ,$valor->fecha_salida_vu )->getStyle('E'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('Bk'.$cont ,$valor->buy_in_advance )->getStyle('Bk'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('BL'.$cont ,$valor->record_localizador )->getStyle('BL'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('BM'.$cont ,$valor->GVC_ID_CENTRO_COSTO )->getStyle('BM'.$cont)->getFont()->setBold(false);  
					$activeSheet->setCellValue('BN'.$cont ,$valor->analisis14_cliente )->getStyle('BN'.$cont)->getFont()->setBold(false);  
					
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

					
					//$activeSheet->setCellValue('R'.$cont ,$valor->total_millas )->getStyle('R'.$cont)->getFont()->setBold(false);

					if($valor->emd == 'S'){

					$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('S'.$cont ,'' )->getStyle('S'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('T'.$cont ,'' )->getStyle('T'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('U'.$cont ,'')->getStyle('U'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('V'.$cont ,'')->getStyle('V'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('W'.$cont ,'')->getStyle('W'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('X'.$cont ,'')->getStyle('X'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('Y'.$cont ,'' )->getStyle('Y'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('Z'.$cont ,'' )->getStyle('Z'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AA'.$cont ,'' )->getStyle('AA'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AB'.$cont ,'' )->getStyle('AB'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AC'.$cont ,'' )->getStyle('AC'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AD'.$cont ,'' )->getStyle('AD'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AE'.$cont ,'' )->getStyle('AE'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AF'.$cont ,'' )->getStyle('AF'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AG'.$cont ,'' )->getStyle('AG'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AH'.$cont ,'' )->getStyle('AH'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AI'.$cont ,'' )->getStyle('AI'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AJ'.$cont ,'' )->getStyle('AJ'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AK'.$cont ,'' )->getStyle('AK'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AL'.$cont ,'' )->getStyle('AL'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AM'.$cont ,'' )->getStyle('AM'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AN'.$cont ,'' )->getStyle('AN'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AO'.$cont ,'' )->getStyle('AO'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AP'.$cont ,'' )->getStyle('AP'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AQ'.$cont ,'' )->getStyle('AQ'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AR'.$cont ,'' )->getStyle('AR'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AS'.$cont ,'' )->getStyle('AS'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AT'.$cont ,'' )->getStyle('AT'.$cont)->getFont()->setBold(false);
					$activeSheet->setCellValue('AU'.$cont ,'' )->getStyle('AU'.$cont)->getFont()->setBold(false);

					}else{

					
					//******total Itenerary1
						if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'I') {
							$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
							$combustible = $valor->combustible;
							$tpo_cambio = $valor->tpo_cambio;
							$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
							$activeSheet->setCellValue('R'.$cont ,number_format($scf,2) )->getStyle('R'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(0, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[0]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('R'.$cont ,number_format($scf,2) )->getStyle('R'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('R'.$cont ,0 )->getStyle('R'.$cont)->getFont()->setBold(false);

						}

					//*******origin1
						if(array_key_exists(0, $segmentos)) {
								$id_ciudad_salida = $segmentos[0]['id_ciudad_salida'];
								$activeSheet->setCellValue('S'.$cont ,$id_ciudad_salida )->getStyle('S'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('S'.$cont ,$valor->origin1 )->getStyle('S'.$cont)->getFont()->setBold(false);
						}


					//******destina1
						if(array_key_exists(0, $segmentos)) {
								$id_ciudad_destino = $segmentos[0]['id_ciudad_destino'];
								$activeSheet->setCellValue('T'.$cont ,$id_ciudad_destino )->getStyle('T'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('T'.$cont ,$valor->destina1 )->getStyle('T'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary2

						if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('U'.$cont ,number_format($tarifa_segmento,2))->getStyle('V'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(1, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[1]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('U'.$cont ,number_format($tarifa_segmento,2))->getStyle('V'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('U'.$cont ,0)->getStyle('V'.$cont)->getFont()->setBold(false);
						}

					//*******origin2
						if(array_key_exists(1, $segmentos)) {
								$id_ciudad_salida = $segmentos[1]['id_ciudad_salida'];
								$activeSheet->setCellValue('V'.$cont ,$id_ciudad_salida)->getStyle('W'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('V'.$cont ,$valor->origin2)->getStyle('W'.$cont)->getFont()->setBold(false);
						}

					//******destina2
						if(array_key_exists(1, $segmentos)) {
								$id_ciudad_destino = $segmentos[1]['id_ciudad_destino'];
								$activeSheet->setCellValue('W'.$cont ,$id_ciudad_destino)->getStyle('X'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('W'.$cont ,$valor->destina2)->getStyle('X'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary3
						if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('X'.$cont ,number_format($scf,2))->getStyle('Y'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(2, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[2]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('X'.$cont ,number_format($scf,2))->getStyle('Y'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('X'.$cont ,0)->getStyle('Y'.$cont)->getFont()->setBold(false);
						}


					//*******origin3
						if(array_key_exists(2, $segmentos)) {
								$id_ciudad_salida = $segmentos[2]['id_ciudad_salida'];
								$activeSheet->setCellValue('Y'.$cont ,$id_ciudad_salida )->getStyle('Z'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('Y'.$cont ,$valor->origin3 )->getStyle('Z'.$cont)->getFont()->setBold(false);
						}

					//******destina3
						if(array_key_exists(2, $segmentos)) {
								$id_ciudad_destino = $segmentos[2]['id_ciudad_destino'];
								$activeSheet->setCellValue('Z'.$cont ,$id_ciudad_destino )->getStyle('AA'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('Z'.$cont ,$valor->destina3 )->getStyle('AA'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary4

						if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AA'.$cont ,number_format($scf,2) )->getStyle('AB'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(3, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[3]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AA'.$cont ,number_format($scf,2) )->getStyle('AB'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AA'.$cont ,0 )->getStyle('AB'.$cont)->getFont()->setBold(false);
						}


					//*******origin4
						if(array_key_exists(3, $segmentos)) {
								$id_ciudad_salida = $segmentos[3]['id_ciudad_salida'];
								$activeSheet->setCellValue('AB'.$cont ,$id_ciudad_salida )->getStyle('AC'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AB'.$cont ,$valor->origin4 )->getStyle('AC'.$cont)->getFont()->setBold(false);
						}


					//******destina4
						if(array_key_exists(3, $segmentos)) {
								$id_ciudad_destino = $segmentos[3]['id_ciudad_destino'];
								$activeSheet->setCellValue('AC'.$cont ,$id_ciudad_destino )->getStyle('AD'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AC'.$cont ,$valor->destina4 )->getStyle('AD'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary5
						if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AD'.$cont ,number_format($scf,2) )->getStyle('AE'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(4, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[4]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AD'.$cont ,number_format($scf,2) )->getStyle('AE'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AD'.$cont ,0 )->getStyle('AE'.$cont)->getFont()->setBold(false);
						}

					//*******origin5
						if(array_key_exists(4, $segmentos)) {
								$id_ciudad_salida = $segmentos[4]['id_ciudad_salida'];
								$activeSheet->setCellValue('AE'.$cont ,$id_ciudad_salida )->getStyle('AF'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AE'.$cont ,$valor->origin5 )->getStyle('AF'.$cont)->getFont()->setBold(false);
						}

					//******destina5
						if(array_key_exists(4, $segmentos)) {
								$id_ciudad_destino = $segmentos[4]['id_ciudad_destino'];
								$activeSheet->setCellValue('AF'.$cont ,$id_ciudad_destino )->getStyle('AG'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AF'.$cont ,$valor->destina5 )->getStyle('AG'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary6
						if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AG'.$cont ,number_format($scf,2) )->getStyle('AH'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(5, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[5]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AG'.$cont ,number_format($scf,2) )->getStyle('AH'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AG'.$cont ,0 )->getStyle('AH'.$cont)->getFont()->setBold(false);
						}

					//*******origin6
						if(array_key_exists(5, $segmentos)) {
								$id_ciudad_salida = $segmentos[5]['id_ciudad_salida'];
								$activeSheet->setCellValue('AH'.$cont ,$id_ciudad_salida )->getStyle('AI'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AH'.$cont ,$valor->origin6 )->getStyle('AI'.$cont)->getFont()->setBold(false);
						}

					//******destina6
						if(array_key_exists(5, $segmentos)) {
								$id_ciudad_destino = $segmentos[5]['id_ciudad_destino'];
								$activeSheet->setCellValue('AI'.$cont ,$id_ciudad_destino )->getStyle('AJ'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AI'.$cont ,$valor->destina6 )->getStyle('AJ'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary7
						if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AJ'.$cont ,number_format($scf,2) )->getStyle('AK'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(6, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[6]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AJ'.$cont ,number_format($scf,2) )->getStyle('AK'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AJ'.$cont ,0 )->getStyle('AK'.$cont)->getFont()->setBold(false);
						}

					//*******origin7
						if(array_key_exists(6, $segmentos)) {
								$id_ciudad_salida = $segmentos[6]['id_ciudad_salida'];
								$activeSheet->setCellValue('AK'.$cont ,$id_ciudad_salida )->getStyle('AL'.$cont)->getFont()->setBold(false);

						}else{
							   $activeSheet->setCellValue('AK'.$cont ,$valor->origin7 )->getStyle('AL'.$cont)->getFont()->setBold(false);
						}

					//******destina7
						if(array_key_exists(6, $segmentos)) {
								$id_ciudad_destino = $segmentos[6]['id_ciudad_destino'];
								$activeSheet->setCellValue('AL'.$cont ,$id_ciudad_destino )->getStyle('AM'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AL'.$cont ,$valor->destina7 )->getStyle('AM'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary8

						if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AM'.$cont ,number_format($scf,2) )->getStyle('AN'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(7, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[7]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AM'.$cont ,number_format($scf,2) )->getStyle('AN'.$cont)->getFont()->setBold(false);
						}else{
							  $activeSheet->setCellValue('AM'.$cont ,0 )->getStyle('AN'.$cont)->getFont()->setBold(false);
						}

					//*******origin8
						if(array_key_exists(7, $segmentos)) {
								$id_ciudad_salida = $segmentos[7]['id_ciudad_salida'];
								$activeSheet->setCellValue('AN'.$cont ,$id_ciudad_salida )->getStyle('AO'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AN'.$cont ,$valor->origin8 )->getStyle('AO'.$cont)->getFont()->setBold(false);
						}

					//******destina8
						if(array_key_exists(7, $segmentos)) {
								$id_ciudad_destino = $segmentos[7]['id_ciudad_destino'];
								$activeSheet->setCellValue('AO'.$cont ,$id_ciudad_destino )->getStyle('AP'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AO'.$cont ,$valor->destina8 )->getStyle('AP'.$cont)->getFont()->setBold(false);
						}

					//***********total_Itinerary9
						if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AP'.$cont ,number_format($scf,2) )->getStyle('AQ'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(8, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[8]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AP'.$cont ,number_format($scf,2) )->getStyle('AQ'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AP'.$cont ,0 )->getStyle('AQ'.$cont)->getFont()->setBold(false);
						}

					//*******origin9
						if(array_key_exists(8, $segmentos)) {
								$id_ciudad_salida = $segmentos[8]['id_ciudad_salida'];
								$activeSheet->setCellValue('AQ'.$cont ,$id_ciudad_salida )->getStyle('AR'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AQ'.$cont ,$valor->origin9 )->getStyle('AR'.$cont)->getFont()->setBold(false);
						}

					//******destina9
						if(array_key_exists(8, $segmentos)) {
								$id_ciudad_destino = $segmentos[8]['id_ciudad_destino'];
								$activeSheet->setCellValue('AR'.$cont ,$id_ciudad_destino )->getStyle('AS'.$cont)->getFont()->setBold(false);	
						}else{
								$activeSheet->setCellValue('AR'.$cont ,$valor->destina9 )->getStyle('AS'.$cont)->getFont()->setBold(false);
						}


					//***********total_Itinerary10
						if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'I') {
								$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$tpo_cambio = $valor->tpo_cambio;
								$scf = ((int)$tarifa_segmento + (int)$combustible) * (int)$tpo_cambio;
								$activeSheet->setCellValue('AS'.$cont ,number_format($scf,2) )->getStyle('AT'.$cont)->getFont()->setBold(false);
						}else if(array_key_exists(9, $segmentos) && $valor->typo_of_ticket == 'N'){
								$tarifa_segmento = $segmentos[9]['tarifa_segmento'];
								$combustible = $valor->combustible;
								$scf = (int)$tarifa_segmento + (int)$combustible;
								$activeSheet->setCellValue('AS'.$cont ,number_format($scf,2) )->getStyle('AT'.$cont)->getFont()->setBold(false);
						}else{
							   $activeSheet->setCellValue('AS'.$cont ,0 )->getStyle('AT'.$cont)->getFont()->setBold(false);
						}

					//*******origin10
						if(array_key_exists(9, $segmentos)) {
								$id_ciudad_salida = $segmentos[9]['id_ciudad_salida'];
								$activeSheet->setCellValue('AT'.$cont ,$id_ciudad_salida )->getStyle('AU'.$cont)->getFont()->setBold(false);
						}else{
							    $activeSheet->setCellValue('AT'.$cont ,$valor->origin10 )->getStyle('AU'.$cont)->getFont()->setBold(false);
						}

					//******destina10
						if(array_key_exists(9, $segmentos)) {
								$id_ciudad_destino = $segmentos[9]['id_ciudad_destino'];
								$activeSheet->setCellValue('AU'.$cont ,$id_ciudad_destino )->getStyle('AV'.$cont)->getFont()->setBold(false);
						}else{
								$activeSheet->setCellValue('AU'.$cont ,$valor->destina10 )->getStyle('AV'.$cont)->getFont()->setBold(false);
						}

					}

				}else{

					$cont--;

				}

			  } //FIN DE VALIDACION DE TIPO DE SERVICIOS

			  //$activeSheet->setCellValue('BL'.$cont ,$valor->record_localizador)->getStyle('BL'.$cont)->getFont()->setBold(false); 


			  if($valor->type_of_service == 'HOTNAC'){
						$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);

								
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

							    	$fac_numero = utf8_encode($valor->documento);
								    $id_serie = utf8_encode($valor->id_serie);

								    if($tipo_funcion == "aut"){

								    	$hoteles_iris_arr = $this->Mod_reportes_ficosa->get_hoteles_iris($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$fac_numero,$fecha1,$fecha2,$id_serie);
								    
								    }else{

								    	$hoteles_iris_arr = $this->Mod_reportes_ficosa->get_hoteles_iris($tipo_funcion,$fecha_ini_proceso = '',$id_intervalo = 0,$fac_numero,$fecha1,$fecha2,$id_serie);
								    }

						       
						    if (!in_array($consecutivo, $array_consecutivo)) {
						    	$cont_ir = 0;
						    	foreach ($hoteles_iris_arr as $clave_hot_ir => $valor_hot_ir) {
									$cont_ir++;

									if($cont_ir > 1){
										$cont++;
									}
									
							  		$activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
								    $activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('D'.$cont ,'' )->getStyle('D'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('E'.$cont ,'' )->getStyle('E'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
									
									$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);   //ecomod
								
									$activeSheet->setCellValue('I'.$cont ,'' )->getStyle('I'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
									
									$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);

									
									$activeSheet->setCellValue('K'.$cont ,$valor->final_user )->getStyle('K'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('L'.$cont ,$valor->ticket_number )->getStyle('L'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('M'.$cont ,$valor->typo_of_ticket )->getStyle('M'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('N'.$cont ,$valor_hot_ir['fecha_fac2'])->getStyle('N'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('O'.$cont ,'' )->getStyle('O'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('P'.$cont ,'' )->getStyle('P'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Q'.$cont ,'' )->getStyle('Q'.$cont)->getFont()->setBold(false);
									//$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BK'.$cont ,$valor_hot_ir['buy_in_advance'])->getStyle('BK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BL'.$cont ,$valor->record_localizador)->getStyle('BL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BM'.$cont ,$valor->GVC_ID_CENTRO_COSTO)->getStyle('BM'.$cont)->getFont()->setBold(false);  
									$activeSheet->setCellValue('BN'.$cont ,$valor->analisis14_cliente)->getStyle('BN'.$cont)->getFont()->setBold(false); 

									$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('S'.$cont ,'' )->getStyle('S'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('T'.$cont ,'' )->getStyle('T'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('U'.$cont ,'')->getStyle('U'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('V'.$cont ,'')->getStyle('V'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('W'.$cont ,'')->getStyle('W'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('X'.$cont ,'')->getStyle('X'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Y'.$cont ,'' )->getStyle('Y'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Z'.$cont ,'' )->getStyle('Z'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AA'.$cont ,'' )->getStyle('AA'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AB'.$cont ,'' )->getStyle('AB'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AC'.$cont ,'' )->getStyle('AC'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AD'.$cont ,'' )->getStyle('AD'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AE'.$cont ,'' )->getStyle('AE'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AF'.$cont ,'' )->getStyle('AF'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AG'.$cont ,'' )->getStyle('AG'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AH'.$cont ,'' )->getStyle('AH'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AI'.$cont ,'' )->getStyle('AI'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AJ'.$cont ,'' )->getStyle('AJ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AK'.$cont ,'' )->getStyle('AK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AL'.$cont ,'' )->getStyle('AL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AM'.$cont ,'' )->getStyle('AM'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AN'.$cont ,'' )->getStyle('AN'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AO'.$cont ,'' )->getStyle('AO'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AP'.$cont ,'' )->getStyle('AP'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AQ'.$cont ,'' )->getStyle('AQ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AR'.$cont ,'' )->getStyle('AR'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AS'.$cont ,'' )->getStyle('AS'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AT'.$cont ,'' )->getStyle('AT'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AU'.$cont ,'' )->getStyle('AU'.$cont)->getFont()->setBold(false);

							  		$activeSheet->setCellValue('AV'.$cont ,$valor_hot_ir['servicio'] )->getStyle('AV'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AW'.$cont ,$valor_hot_ir['fecha_entrada'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AX'.$cont ,$valor_hot_ir['fecha_salida'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AY'.$cont ,$valor_hot_ir['noches'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AZ'.$cont ,'' )->getStyle('AZ'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BA'.$cont ,$valor_hot_ir['cantidad'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BB'.$cont ,$valor_hot_ir['id_habitacion'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BC'.$cont ,$valor_hot_ir['id_ciudad'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BD'.$cont ,'' )->getStyle('BD'.$cont)->getFont()->setBold(false);

							    	



								}
							}//fin if consecutivo hotnac
						

					}else if($valor->type_of_service == 'HOTINT'){
						$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);
						$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);

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

									
							    	$fac_numero = utf8_encode($valor->documento);
								    $id_serie = utf8_encode($valor->id_serie);

								    if($tipo_funcion == "aut"){

								    	$hoteles_iris_arr = $this->Mod_reportes_ficosa->get_hoteles_iris($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$fac_numero,$fecha1,$fecha2,$id_serie);
								    
								    }else{

								    	$hoteles_iris_arr = $this->Mod_reportes_ficosa->get_hoteles_iris($tipo_funcion,$fecha_ini_proceso = '',$id_intervalo = 0,$fac_numero,$fecha1,$fecha2,$id_serie);
								    }

								
						    if (!in_array($consecutivo, $array_consecutivo)) {
						    	$cont_ir = 0;
						    	foreach ($hoteles_iris_arr as $clave_hot_ir => $valor_hot_ir) {
									$cont_ir++;

									if($cont_ir > 1){
										$cont++;
									}

									$activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
								    $activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('D'.$cont ,'' )->getStyle('D'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('E'.$cont ,'' )->getStyle('E'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
									
									$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);   //ecomod
								
									$activeSheet->setCellValue('I'.$cont ,'' )->getStyle('I'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
									
									$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);

									
									$activeSheet->setCellValue('K'.$cont ,$valor->final_user )->getStyle('K'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('L'.$cont ,$valor->ticket_number )->getStyle('L'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('M'.$cont ,$valor->typo_of_ticket )->getStyle('M'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('N'.$cont ,$valor_hot['fecha_fac'] )->getStyle('N'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('O'.$cont ,'' )->getStyle('O'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('P'.$cont ,'' )->getStyle('P'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Q'.$cont ,'' )->getStyle('Q'.$cont)->getFont()->setBold(false);
									//$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('BK'.$cont ,$valor_hot_ir['buy_in_advance'])->getStyle('BK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BL'.$cont ,$valor->record_localizador)->getStyle('BL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BM'.$cont ,$valor->GVC_ID_CENTRO_COSTO)->getStyle('BM'.$cont)->getFont()->setBold(false); 
									$activeSheet->setCellValue('BN'.$cont ,$valor->analisis14_cliente)->getStyle('BN'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('S'.$cont ,'' )->getStyle('S'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('T'.$cont ,'' )->getStyle('T'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('U'.$cont ,'')->getStyle('U'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('V'.$cont ,'')->getStyle('V'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('W'.$cont ,'')->getStyle('W'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('X'.$cont ,'')->getStyle('X'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Y'.$cont ,'' )->getStyle('Y'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Z'.$cont ,'' )->getStyle('Z'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AA'.$cont ,'' )->getStyle('AA'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AB'.$cont ,'' )->getStyle('AB'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AC'.$cont ,'' )->getStyle('AC'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AD'.$cont ,'' )->getStyle('AD'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AE'.$cont ,'' )->getStyle('AE'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AF'.$cont ,'' )->getStyle('AF'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AG'.$cont ,'' )->getStyle('AG'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AH'.$cont ,'' )->getStyle('AH'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AI'.$cont ,'' )->getStyle('AI'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AJ'.$cont ,'' )->getStyle('AJ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AK'.$cont ,'' )->getStyle('AK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AL'.$cont ,'' )->getStyle('AL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AM'.$cont ,'' )->getStyle('AM'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AN'.$cont ,'' )->getStyle('AN'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AO'.$cont ,'' )->getStyle('AO'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AP'.$cont ,'' )->getStyle('AP'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AQ'.$cont ,'' )->getStyle('AQ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AR'.$cont ,'' )->getStyle('AR'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AS'.$cont ,'' )->getStyle('AS'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AT'.$cont ,'' )->getStyle('AT'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AU'.$cont ,'' )->getStyle('AU'.$cont)->getFont()->setBold(false);

							  		$activeSheet->setCellValue('AV'.$cont ,$valor_hot_ir['servicio'] )->getStyle('AV'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AW'.$cont ,$valor_hot_ir['fecha_entrada'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AX'.$cont ,$valor_hot_ir['fecha_salida'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AY'.$cont ,$valor_hot_ir['noches'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AZ'.$cont ,'' )->getStyle('AZ'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BA'.$cont ,$valor_hot_ir['cantidad'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BB'.$cont ,$valor_hot_ir['id_habitacion'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BC'.$cont ,$valor_hot_ir['id_ciudad'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BD'.$cont ,'' )->getStyle('BD'.$cont)->getFont()->setBold(false);


								}
							}//fin if consecutivo hotint
						
					}else{


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

						if($tipo_funcion == "aut"){

					    	$hoteles_arr = $this->Mod_reportes_ficosa->get_hoteles_num_bol($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$record_localizador,$consecutivo,$fecha1,$fecha2);

					    }else{

					   		$hoteles_arr = $this->Mod_reportes_ficosa->get_hoteles_num_bol($tipo_funcion,$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo,$fecha1,$fecha2);

					    }

					    if (!in_array($consecutivo, $array_consecutivo)) {
					    			    	
								$cont_hot = 0;			
					    		foreach ($hoteles_arr as $clave_hot => $valor_hot) {    //recorre hoteles
					    			$cont_hot++;
					    			
					    			if($cont_hot > 0){
												$cont++;
											}
										
								    $activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
								    $activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('D'.$cont ,'' )->getStyle('D'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('E'.$cont ,'' )->getStyle('E'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
									
									$activeSheet->setCellValue('BK'.$cont ,$valor_hot['buy_in_advance'])->getStyle('BK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BL'.$cont ,$valor->record_localizador)->getStyle('BL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BM'.$cont ,$valor->GVC_ID_CENTRO_COSTO)->getStyle('BM'.$cont)->getFont()->setBold(false); 
									$activeSheet->setCellValue('BN'.$cont ,$valor->analisis14_cliente)->getStyle('BN'.$cont)->getFont()->setBold(false);

									if($valor->typo_of_ticket == 'N' ){

										$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);   //ecomod

									}else if($valor->typo_of_ticket == 'I' ){


										$activeSheet->setCellValue('H'.$cont ,'HOTEL' )->getStyle('H'.$cont)->getFont()->setBold(false);   //ecomod
									
									}

									
									

									$activeSheet->setCellValue('I'.$cont ,'' )->getStyle('I'.$cont)->getFont()->setBold(false);

									if(utf8_encode($valor->city) != '_____campo_vacio_____'){

										$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);
									
									}else{

										$activeSheet->setCellValue('J'.$cont ,'HOTEL' )->getStyle('J'.$cont)->getFont()->setBold(false);

									}
									
									$activeSheet->setCellValue('K'.$cont ,$valor->final_user )->getStyle('K'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('L'.$cont ,$valor->ticket_number )->getStyle('L'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('M'.$cont ,$valor->typo_of_ticket )->getStyle('M'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('N'.$cont ,$valor->fecha_emi)->getStyle('N'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('O'.$cont ,'' )->getStyle('O'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('P'.$cont ,'' )->getStyle('P'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Q'.$cont ,'' )->getStyle('Q'.$cont)->getFont()->setBold(false);
									//$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('S'.$cont ,'' )->getStyle('S'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('T'.$cont ,'' )->getStyle('T'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('U'.$cont ,'')->getStyle('U'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('V'.$cont ,'')->getStyle('V'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('W'.$cont ,'')->getStyle('W'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('X'.$cont ,'')->getStyle('X'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Y'.$cont ,'' )->getStyle('Y'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Z'.$cont ,'' )->getStyle('Z'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AA'.$cont ,'' )->getStyle('AA'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AB'.$cont ,'' )->getStyle('AB'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AC'.$cont ,'' )->getStyle('AC'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AD'.$cont ,'' )->getStyle('AD'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AE'.$cont ,'' )->getStyle('AE'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AF'.$cont ,'' )->getStyle('AF'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AG'.$cont ,'' )->getStyle('AG'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AH'.$cont ,'' )->getStyle('AH'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AI'.$cont ,'' )->getStyle('AI'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AJ'.$cont ,'' )->getStyle('AJ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AK'.$cont ,'' )->getStyle('AK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AL'.$cont ,'' )->getStyle('AL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AM'.$cont ,'' )->getStyle('AM'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AN'.$cont ,'' )->getStyle('AN'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AO'.$cont ,'' )->getStyle('AO'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AP'.$cont ,'' )->getStyle('AP'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AQ'.$cont ,'' )->getStyle('AQ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AR'.$cont ,'' )->getStyle('AR'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AS'.$cont ,'' )->getStyle('AS'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AT'.$cont ,'' )->getStyle('AT'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AU'.$cont ,'' )->getStyle('AU'.$cont)->getFont()->setBold(false);


									$activeSheet->setCellValue('AV'.$cont ,$valor_hot['nombre_hotel'] )->getStyle('AV'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AW'.$cont ,$valor_hot['fecha_entrada'] )->getStyle('AW'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AX'.$cont ,$valor_hot['fecha_salida'] )->getStyle('AX'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AY'.$cont ,$valor_hot['noches'] )->getStyle('AY'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('AZ'.$cont ,'' )->getStyle('AZ'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BA'.$cont ,$valor_hot['numero_hab'] )->getStyle('BA'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BB'.$cont ,$valor_hot['id_habitacion'] )->getStyle('BB'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BC'.$cont ,$valor_hot['id_ciudad'] )->getStyle('BC'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BD'.$cont ,'' )->getStyle('BD'.$cont)->getFont()->setBold(false);

							    	
					    		}



					 }


					  $autos_arr = $this->Mod_reportes_ficosa->get_autos_num_bol($consecutivo);
					  if (!in_array($consecutivo, $array_consecutivo)) {
					  	$cont_aut = 0;			
					    foreach ($autos_arr as $clave_aut => $valor_aut) {    //recorre hoteles
					    		$cont_aut++;	

					    			if($cont_aut > 0){
												$cont++;
											}

								    $activeSheet->setCellValue('A'.$cont ,$valor->consecutivo )->getStyle('A'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('B'.$cont ,$valor->name )->getStyle('B'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('C'.$cont ,$valor->nexp )->getStyle('C'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('D'.$cont ,'' )->getStyle('D'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('E'.$cont ,'' )->getStyle('E'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('F'.$cont ,$valor->documento )->getStyle('F'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('G'.$cont ,$valor->solicitor )->getStyle('G'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('H'.$cont ,'' )->getStyle('H'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('I'.$cont ,'' )->getStyle('I'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('J'.$cont ,'CAR' )->getStyle('J'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('K'.$cont ,$valor->final_user )->getStyle('K'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('L'.$cont ,$valor->ticket_number )->getStyle('L'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('M'.$cont ,$valor->typo_of_ticket )->getStyle('M'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('N'.$cont ,$valor->fecha_emi )->getStyle('N'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('O'.$cont ,'' )->getStyle('O'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('P'.$cont ,'' )->getStyle('P'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Q'.$cont ,'' )->getStyle('Q'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('BK'.$cont ,$valor->buy_in_advance)->getStyle('BK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BL'.$cont ,$valor->record_localizador)->getStyle('BL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('BM'.$cont ,$valor->GVC_ID_CENTRO_COSTO)->getStyle('BM'.$cont)->getFont()->setBold(false); 
									$activeSheet->setCellValue('BN'.$cont ,$valor->analisis14_cliente)->getStyle('BN'.$cont)->getFont()->setBold(false);

									//$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('R'.$cont ,'' )->getStyle('R'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('S'.$cont ,'' )->getStyle('S'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('T'.$cont ,'' )->getStyle('T'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('U'.$cont ,'')->getStyle('U'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('V'.$cont ,'')->getStyle('V'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('W'.$cont ,'')->getStyle('W'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('X'.$cont ,'')->getStyle('X'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Y'.$cont ,'' )->getStyle('Y'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('Z'.$cont ,'' )->getStyle('Z'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AA'.$cont ,'' )->getStyle('AA'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AB'.$cont ,'' )->getStyle('AB'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AC'.$cont ,'' )->getStyle('AC'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AD'.$cont ,'' )->getStyle('AD'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AE'.$cont ,'' )->getStyle('AE'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AF'.$cont ,'' )->getStyle('AF'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AG'.$cont ,'' )->getStyle('AG'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AH'.$cont ,'' )->getStyle('AH'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AI'.$cont ,'' )->getStyle('AI'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AJ'.$cont ,'' )->getStyle('AJ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AK'.$cont ,'' )->getStyle('AK'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AL'.$cont ,'' )->getStyle('AL'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AM'.$cont ,'' )->getStyle('AM'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AN'.$cont ,'' )->getStyle('AN'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AO'.$cont ,'' )->getStyle('AO'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AP'.$cont ,'' )->getStyle('AP'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AQ'.$cont ,'' )->getStyle('AQ'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AR'.$cont ,'' )->getStyle('AR'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AS'.$cont ,'' )->getStyle('AS'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AT'.$cont ,'' )->getStyle('AT'.$cont)->getFont()->setBold(false);
									$activeSheet->setCellValue('AU'.$cont ,'' )->getStyle('AU'.$cont)->getFont()->setBold(false);

									$activeSheet->setCellValue('BE'.$cont ,$valor_aut['tipo_auto'] )->getStyle('BE'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BF'.$cont ,$valor_aut['fecha_entrega'] )->getStyle('BF'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BG'.$cont ,$valor_aut['dias'] )->getStyle('BG'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BH'.$cont ,$valor_aut['id_ciudad_entrega'] )->getStyle('BH'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BI'.$cont ,$valor_aut['id_ciudad_recoge'] )->getStyle('BI'.$cont)->getFont()->setBold(false);
							    	$activeSheet->setCellValue('BJ'.$cont ,$valor_aut['fecha_entrega'] )->getStyle('BJ'.$cont)->getFont()->setBold(false);
							    	

					    }



					}

					
				

			    

			    $spreadsheet->getActiveSheet()->getStyle('A1:BN'.$cont)->applyFromArray($styleArray);
			    
			  }
			    
			    //print_r($valor->consecutivo.'/');

			    array_push($array_consecutivo, $valor->consecutivo);
			   

		}			   


		$activeSheet->getStyle('A5:BN5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('A5:BN5')
        ->getFont()->getColor()->setARGB('ffffff');

		 $styleArray = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ],
		];


		$spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		//$spreadsheet->getActiveSheet()->getStyle('A1:AA4')->applyFromArray($styleArray);

		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setCoordinates('A1');
		$drawing->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/img/villatours.png');
		$drawing->setHeight(250);
		$drawing->setWidth(250);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing2->setName('Logo');
		$drawing2->setDescription('Logo');
		$drawing2->setCoordinates('N1');
		$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/img/91_4c.gif');
		$drawing2->setHeight(60);
		$drawing2->setWidth(60);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());


		$activeSheet->setCellValue('F1','FICOSA' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);			

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

            	
                $rz = $this->Mod_reportes_ficosa->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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
       	
       	$str_fecha = $fecha1.'_A_'.$fecha2;
       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/Reporte_ficosa_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
       	echo json_encode(1); //cuando es uno si tiene informacion

       }else{

		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte_ficosa_'.$fecha1.'_A_'.$fecha2.'.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$Excel_writer->save('php://output', 'xlsx');
		

       }

	  }// fin validacion count
	  else{ 

	  	if($tipo_funcion != "aut"){

       	    echo json_encode(0); //cuando es uno si tiene informacion

        }else{

        	echo json_encode(0); //cuando es uno si tiene informacion
        
        }

	  }

	}

}
