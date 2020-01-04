<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';

class Cnt_layouts_egencia_sample_summary_transaction extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_egencia_sample_summary_transaction');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_ciudades');
	      $this->load->library('lib_ciudades_pais');
	      $this->load->library('lib_ega_booking_type');
	      $this->Mod_general->get_SPID();
	     
	}

	public function get_html_layouts_egencia_sample_summary_transaction(){

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

		$this->load->view('Layouts/view_lay_egencia_sample_summary_transaction');
		
	}
	

	public function get_layouts_egencia_data_import_sp_parametros(){

		$parametros = $_REQUEST["parametros"];
        $tipo_funcion = $_REQUEST['tipo_funcion'];  //falta
		$parametros = explode(",", $parametros);
		        
		$this->get_layouts_egencia_data_import_sp($parametros,$tipo_funcion);


	}


	public function get_layouts_egencia_data_import_sp($parametros,$tipo_funcion){


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
	        $fecha_recepcion = $parametros[7];

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

		  

		  $rest = $this->Mod_layouts_egencia_sample_summary_transaction->get_layouts_egencia_data_import_sp($parametros);

		  $array1 = array();
		  $array_consecutivo = array();
		  $array_codigo_detalle = array();
		  $array_ticket_number = array();

		  function data_general($valor){  //SUB FUNCION
					
					$dat['precompra'] = $valor->precompra;
					$dat['bol_origi'] = $valor->bol_origi;
			        $dat['GVC_TOTAL'] = $valor->GVC_TOTAL;
			        $dat['NAME'] = utf8_encode($valor->NAME);
			        $dat['nexp'] = utf8_encode($valor->nexp);
			        $dat['GVC_FECHA'] = utf8_encode($valor->GVC_FECHA);
			        $dat['record_localizador'] = utf8_encode($valor->record_localizador);
					$dat['consecutivo'] = utf8_encode($valor->consecutivo);
					$dat['type_of_service'] = $valor->type_of_service;
					$dat['DomesticInternational'] = '';
					$dat['Partner_Code'] = 'VLT';
					$dat['Partner_Name'] = 'Partner_Name';
					$dat['Country_Code'] = 'MEX';
					$dat['Currency_Code'] = 'MXN';
				
				
					return $dat;
				} //FIN FUNCION DATA GENERAL


		   foreach ($rest as $clave => $valor) {

			    $consecutivo_gds_general = $valor->consecutivo;
			    $record_localizador = utf8_encode($valor->record_localizador);
			    $codigo_detalle = $valor->codigo_detalle;
				//$consecutivo_id_boleto = $valor->id_boleto;

			  	    if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI' || $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT' || $valor->type_of_service == 'HOTNAC_RES' ){

						if( !in_array($consecutivo_gds_general, $array_consecutivo) && !in_array($codigo_detalle, $array_codigo_detalle) && $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT'){

							$dat = data_general($valor);

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


							$hoteles_iris_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_hoteles_iris('man',$fecha_ini_proceso = '',$id_intervalo = 0,$fac_numero,$fecha1,$fecha2,$id_serie);


							$cont3=0;
					    	foreach ($hoteles_iris_arr as $clave_hot_ir => $valor_hot_ir) {  
							$cont3++;

								 $dat = data_general($valor);

								 $dat['type_of_service'] = 'HOTEL';
								 $dat['codigo_producto'] = 'HOTEL';

									if($valor->type_of_service == 'HOTNAC'){

										$dat['DomesticInternational'] = 'D';

									}else if($valor->type_of_service == 'HOTINT'){

										$dat['DomesticInternational'] = 'I';

									}


								 $dat['class_hotel'] = utf8_encode($valor_hot_ir['class_hotel']);
								 $dat['destination_hotel'] = utf8_encode($valor_hot_ir['destination_hotel']);
								 $dat['origin_hotel'] = utf8_encode($valor_hot_ir['origin_hotel']);
								 $dat['routing_hotel'] = utf8_encode($valor_hot_ir['routing_hotel']);
								 $dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot_ir['GVC_NOM_PAX_HOTEL']);
								 $dat['payment_number_hotel'] = utf8_encode($valor_hot_ir['payment_number_hotel']);
								 $dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot_ir['ID_FORMA_PAGO_HOTEL']);
								 $dat['moneda_hotel'] = utf8_encode($valor_hot_ir['moneda_hotel']);
								 $dat['telefono_hotel'] = utf8_encode($valor_hot_ir['tel1_ho']);
								 $dat['direccion_hotel'] = utf8_encode($valor_hot_ir['direccion_ho']);
								 $dat['nombre_ciudad_hotel'] = utf8_encode($valor_hot_ir['desc_ciudad']);
								 $dat['estado_hotel'] = '';
								 $dat['cp_ho'] = utf8_encode($valor_hot_ir['cp_ho']);
						    	 $dat['nombre_hotel'] = utf8_encode($valor_hot_ir['nombre_hotel']);
						    	 $dat['fecha_entrada'] = utf8_encode($valor_hot_ir['fecha_entrada']);
						    	 $dat['fecha_salida'] = utf8_encode($valor_hot_ir['fecha_salida']);
						    	 $dat['noches'] = utf8_encode($valor_hot_ir['noches']);
						    	 $dat['numero_hab'] = utf8_encode($valor_hot_ir['numero_hab']);
						    	 $dat['id_habitacion'] = utf8_encode($valor_hot_ir['id_habitacion']);
						    	 $dat['id_ciudad'] = utf8_encode($valor_hot_ir['id_ciudad']);
						    	 $dat['buy_in_advance'] = utf8_encode($valor_hot_ir['buy_in_advance']);
						    	 $dat['tarifa_neta_hotel'] = utf8_encode($valor_hot_ir['tarifa_neta_hotel']);

						    	 //$dat['fecha_emi_hot'] = $valor_hot_ir['fecha_fac2'];
						    
						    	array_push($array1, $dat);

							}

							$autos_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_autos_num_bol($consecutivo_gds_general);

						    $cont2=0;
						    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
						    $cont2++;

						    	$dat['type_of_service'] = 'CAR';
								$dat['codigo_producto'] = 'CAR';
						    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
						    	$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
						    	$id_ciudad = $valor_aut['routing_car'];
						    	$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
								$dat['routing_car'] = utf8_encode($routing_car);
						    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
						    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
						   		$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
						   		$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
						   		$dat['nombre_arrendadora'] = utf8_encode($valor_aut['nombre_arrendadora']);
						    	$dat['Car_class'] = utf8_encode($valor_aut['tipo_auto']);
								$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega']);
								$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
								$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
								$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
								$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge']);
								$dat['tarifa_total_car'] = utf8_encode($valor_aut['tarifa_total_car']);
								$dat['dias'] = utf8_encode($valor_aut['dias']);

								$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

								array_push($array1, $dat);

						    }
							
						    	

						}else if( !in_array($consecutivo_gds_general, $array_consecutivo) && !in_array($codigo_detalle, $array_codigo_detalle) && $valor->type_of_service == 'HOTNAC_RES'){   //no estan facturados

								$dat = data_general($valor);

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

								$hoteles_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo_gds_general,$fecha1,$fecha2);


								$cont=0;
							    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
							    $cont++;
							    	

							    	$dat = data_general($valor);
							    	//$rango_fechas = $this->lib_ciudades->ciudades($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

							    	$dat['type_of_service'] = 'HOTEL';
									$dat['codigo_producto'] = 'HOTEL';
									$dat['class_hotel'] = utf8_encode($valor_hot['class_hotel']);
							    	$dat['destination_hotel'] = utf8_encode($valor_hot['destination_hotel']);
									$dat['origin_hotel'] = utf8_encode($valor_hot['origin_hotel']);
							    	$id_ciudad = $valor_hot['routing_hotel'];
							    	$routing_hotel = $this->lib_ciudades->ciudades($id_ciudad);
									$dat['routing_hotel'] = utf8_encode($routing_hotel);
							    	$dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot['GVC_NOM_PAX_HOTEL']);
							    	$dat['payment_number_hotel'] = utf8_encode($valor_hot['payment_number_hotel']);
							    	$dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL']);
							    	$dat['moneda_hotel'] = utf8_encode($valor_hot['moneda_hotel']);
						    	    $dat['telefono_hotel'] = utf8_encode($valor_hot['telefono']);
									$dat['direccion_hotel'] = utf8_encode($valor_hot['direccion']);
									$dat['nombre_ciudad_hotel'] = utf8_encode($valor_hot['nombre_ciudad']);
									$dat['estado_hotel'] = utf8_encode($valor_hot['poblacion']);   //aveces biene vacio y tiene informacion de mas aparte del estado
								    $dat['cp_ho'] = '';  //no existe el cp en gds_hoteles
							    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
							    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada']);
							    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida']);
							    	$dat['noches'] = utf8_encode($valor_hot['noches']);
							    	$dat['numero_hab'] = utf8_encode($valor_hot['numero_hab']);
							    	$dat['id_habitacion'] = utf8_encode($valor_hot['id_habitacion']);
							    	$dat['id_ciudad'] = utf8_encode($valor_hot['id_ciudad']);
						    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];
						    		$dat['tarifa_neta_hotel'] = utf8_encode($valor_hot['tarifa_neta_hotel']);

						    		$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

							    	array_push($array1, $dat);

							   }

							   $autos_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_autos_num_bol($consecutivo_gds_general);

							    $cont2=0;
							    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
							    $cont2++;

							    	$dat = data_general($valor);

							    	$dat['type_of_service'] = 'CAR';
								    $dat['codigo_producto'] = 'CAR';

							    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
							    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
									$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
							    	$id_ciudad = $valor_aut['routing_car'];
							    	$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
									$dat['routing_car'] = utf8_encode($routing_car);
							    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
							    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
							   		$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
							   		$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
							   		$dat['nombre_arrendadora'] = utf8_encode($valor_aut['nombre_arrendadora']);
							    	$dat['Car_class'] = utf8_encode($valor_aut['tipo_auto']);
									$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega']);
									$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
									$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
									$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
									$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge']);
									$dat['tarifa_total_car'] = utf8_encode($valor_aut['tarifa_total_car']);
									$dat['dias'] = utf8_encode($valor_aut['dias']);


									$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

									array_push($array1, $dat);
							    }

							  
					   
						}  // FIN ELSE IF HOTNAC RES

						
						else if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI'){
									
									$dat = data_general($valor);

									if($valor->type_of_service == 'BD'){

										$dat['DomesticInternational'] = 'D';

									}else if($valor->type_of_service == 'BI'){

										$dat['DomesticInternational'] = 'I';

									}
									array_push($array1, $dat);
						    		
									if(!in_array($consecutivo_gds_general, $array_consecutivo) && !in_array($codigo_detalle, $array_codigo_detalle)){

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

									    $hoteles_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo_gds_general,$fecha1,$fecha2);



							    		foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
									  		
									  		$dat = data_general($valor);

									  		

									  		$dat['type_of_service'] = 'HOTEL';
								    		$dat['codigo_producto'] = 'HOTEL';

									  		$dat['class_hotel'] = utf8_encode($valor_hot['class_hotel']);
									  		$dat['destination_hotel'] = utf8_encode($valor_hot['destination_hotel']);
									  		$dat['origin_hotel'] = utf8_encode($valor_hot['origin_hotel']);
									  		$id_ciudad = $valor_hot['routing_hotel'];
							    			$routing_hotel = $this->lib_ciudades->ciudades($id_ciudad);
											$dat['routing_hotel'] = utf8_encode($routing_hotel);
									  		$dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot['GVC_NOM_PAX_HOTEL']);
									  		$dat['payment_number_hotel'] = utf8_encode($valor_hot['payment_number_hotel']);
									  		$dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL']);
									  		$dat['moneda_hotel'] = utf8_encode($valor_hot['moneda_hotel']);
							    			$dat['telefono_hotel'] = utf8_encode($valor_hot['telefono']);
											$dat['direccion_hotel'] = utf8_encode($valor_hot['direccion']);
											$dat['nombre_ciudad_hotel'] = utf8_encode($valor_hot['nombre_ciudad']);
											$dat['estado_hotel'] = utf8_encode($valor_hot['poblacion']);
								    		$dat['cp_ho'] = '';
									    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
									    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada']);
									    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida']);
									    	$dat['noches'] = utf8_encode($valor_hot['noches']);
									    	$dat['numero_hab'] = utf8_encode($valor_hot['numero_hab']);
									    	$dat['id_habitacion'] = utf8_encode($valor_hot['id_habitacion']);
									    	$dat['id_ciudad'] = utf8_encode($valor_hot['id_ciudad']);
								    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];
								    		$dat['tarifa_neta_hotel'] = utf8_encode($valor_hot['tarifa_neta_hotel']);

								    		$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}
							
									    	array_push($array1, $dat);
									   
									   }

									   $autos_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_autos_num_bol($consecutivo_gds_general);

									    $cont2=0;
									    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
									    $cont2++;

									    	$dat = data_general($valor);

									    	$dat['type_of_service'] = 'CAR';
								            $dat['codigo_producto'] = 'CAR';
									    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
									    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
									    	$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
									    	$id_ciudad = $valor_aut['routing_car'];
							    			$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
											$dat['routing_car'] = utf8_encode($routing_car);
									    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
									    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
									    	$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
									    	$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
									    	$dat['nombre_arrendadora'] = utf8_encode($valor_aut['nombre_arrendadora']);
									    	$dat['tipo_auto'] = utf8_encode($valor_aut['tipo_auto']);
											$dat['fecha_entrega'] = utf8_encode($valor_aut['fecha_entrega']);
											$dat['dias'] = utf8_encode($valor_aut['dias']);
											$dat['id_ciudad_entrega'] = utf8_encode($valor_aut['id_ciudad_entrega']);
											$dat['id_ciudad_recoge'] = utf8_encode($valor_aut['id_ciudad_recoge']);
											$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge']);
											$dat['tarifa_total_car'] = utf8_encode($valor_aut['tarifa_total_car']);
											$dat['dias'] = utf8_encode($valor_aut['dias']);

											$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

											array_push($array1, $dat);

									    }

								} //fin consecutivo hoteles
					   				
						    
							    //array_push($array1, $valor);
						}  //FIN IF BD Y BI

						array_push($array_consecutivo, $consecutivo_gds_general);
						array_push($array_codigo_detalle, $codigo_detalle);
					
					}  // FIN DE if VADICION TYPE OF SERVICES
					else{ // todo lo que sea diferente pero tenga hoteles    //son reservados   //si estan facturados  //bienen con tipos de servicios difrentes a las condiciones de arriba
						
						$dat = data_general($valor);
						array_push($array1, $dat);

						if(!in_array($consecutivo_gds_general, $array_consecutivo) && !in_array($codigo_detalle, $array_codigo_detalle)){

									$dat = data_general($valor);
									
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

									$hoteles_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo_gds_general,$fecha1,$fecha2);

									
									$cont=0;
								    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
								    $cont++;
								    	
								    	$dat = data_general($valor);
								    	
								    	$dat['type_of_service'] = 'HOTEL';
								        $dat['codigo_producto'] = 'HOTEL';
								    	$dat['class_hotel'] = utf8_encode($valor_hot['class_hotel']);
								    	$dat['destination_hotel'] = utf8_encode($valor_hot['destination_hotel']);
								    	$dat['origin_hotel'] = utf8_encode($valor_hot['origin_hotel']);
								    	$id_ciudad = $valor_hot['routing_hotel'];
							    		$routing_hotel = $this->lib_ciudades->ciudades($id_ciudad);
										$dat['routing_hotel'] = utf8_encode($routing_hotel);
								    	$dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot['GVC_NOM_PAX_HOTEL']);
								    	$dat['payment_number_hotel'] = utf8_encode($valor_hot['payment_number_hotel']);
								    	$dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL']);
								    	$dat['moneda_hotel'] = utf8_encode($valor_hot['moneda_hotel']);
										$dat['telefono_hotel'] = utf8_encode($valor_hot['telefono']);
										$dat['direccion_hotel'] = utf8_encode($valor_hot['direccion']);
										$dat['nombre_ciudad_hotel'] = utf8_encode($valor_hot['nombre_ciudad']);
										$dat['estado_hotel'] = utf8_encode($valor_hot['poblacion']);
								    	$dat['cp_ho'] = '';
								    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
								    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada']);
								    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida']);
								    	$dat['noches'] = utf8_encode($valor_hot['noches']);
								    	$dat['numero_hab'] = utf8_encode($valor_hot['numero_hab']);
								    	$dat['id_habitacion'] = utf8_encode($valor_hot['id_habitacion']);
								    	$dat['id_ciudad'] = utf8_encode($valor_hot['id_ciudad']);
							    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];
							    		$dat['tarifa_neta_hotel'] = utf8_encode($valor_hot['tarifa_neta_hotel']);

							    		$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

							    		array_push($array1, $dat);

							   	  }

								    $autos_arr = $this->Mod_layouts_egencia_sample_summary_transaction->get_autos_num_bol($consecutivo_gds_general);

								    $cont2=0;
								    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
								    $cont2++;

								    	$dat = data_general($valor);

								    	$dat['type_of_service'] = 'CAR';
								        $dat['codigo_producto'] = 'CAR';
								    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
								    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
								    	$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
								    	$id_ciudad = $valor_aut['routing_car'];
							    		$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
										$dat['routing_car'] = utf8_encode($routing_car);
								    	$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
								    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
								    	$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
								    	$dat['nombre_arrendadora'] = utf8_encode($valor_aut['nombre_arrendadora']);
								    	$dat['Car_class'] = utf8_encode($valor_aut['tipo_auto']);
										$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega']);
										$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
										$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
										$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
										$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge']);
										$dat['tarifa_total_car'] = utf8_encode($valor_aut['tarifa_total_car']);
										$dat['dias'] = utf8_encode($valor_aut['dias']);

										$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

										array_push($array1, $dat);

								    }

								  
								}  // fin consecutivo
							
							array_push($array_consecutivo, $consecutivo_gds_general);
							array_push($array_codigo_detalle, $codigo_detalle);
					
					}// FIN DE else VADICION TYPE OF SERVICES

					array_push($array_ticket_number, $valor->ticket_number);
			        
			   }  //fin del for principal

		       if($tipo_funcion == 'ex'){

		       		$ids_cliente =  explode('_', $ids_cliente);
      			    $ids_cliente=array_filter($ids_cliente, "strlen");
      			    
		       		$this->genera_excel($array1,$ids_cliente,$fecha_recepcion,$fecha1,$fecha2);
		       		

		       }else{

		       	   $ids_cliente =  explode('_', $ids_cliente);
      			   $ids_cliente=array_filter($ids_cliente, "strlen");
		       	   
		       	   $nueva_plantilla = $this->nueva_plantilla($array1,$ids_cliente,$fecha_recepcion);
			       $col = $this->Mod_layouts_egencia_sample_summary_transaction->get_columnas($id_plantilla,6);
				   
				   $param_final['rep'] = $nueva_plantilla;
			       $param_final['col'] = $col;

		       	   echo json_encode($param_final);

		       }
			   

         } //fin de la funcion


    public function genera_excel($param_final,$ids_cliente,$fecha_recepcion,$fecha1,$fecha2){

    	$allrows = $param_final;
		
		$nueva_plantilla = $this->nueva_plantilla($allrows,$ids_cliente,$fecha_recepcion);

    	$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);


		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$activeSheet->setTitle("Summary_Transaction");

		$allrows = $param_final;

		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}
		
		
		$activeSheet->setCellValue('A1','Partner Code');
		$activeSheet->setCellValue('B1','Partner Name');
		$activeSheet->setCellValue('C1','Country Code');
		$activeSheet->setCellValue('D1','Currency Code');
		$activeSheet->setCellValue('E1','Transaction Year');
		$activeSheet->setCellValue('F1','Transaction Month Number');
		$activeSheet->setCellValue('G1','Client ID');
		$activeSheet->setCellValue('H1','Client Name');
		$activeSheet->setCellValue('I1','Domestic International');
		$activeSheet->setCellValue('J1','Air Net Expense Amount');
		$activeSheet->setCellValue('K1','Air Net Ticket Count');
		$activeSheet->setCellValue('L1','Air Original Ticket Count');
		$activeSheet->setCellValue('M1','Air Advance Purchase Days Count');
		$activeSheet->setCellValue('N1','Train Net Expense Amount');
		$activeSheet->setCellValue('O1','Train Net Ticket Count');
		$activeSheet->setCellValue('P1','Train Original Ticket Count');
		$activeSheet->setCellValue('Q1','Train Advance Purchase Days Count');
		$activeSheet->setCellValue('R1','Hotel Net Base Amount');
		$activeSheet->setCellValue('S1','Hotel Net Booking Count');
		$activeSheet->setCellValue('T1','Hotel Original Booking Count');
		$activeSheet->setCellValue('U1','Hotel Net Nights Count');
		$activeSheet->setCellValue('V1','Car Net Base Amount');
		$activeSheet->setCellValue('W1','Car Net Booking Count');
		$activeSheet->setCellValue('X1','Car Original Booking Count');
		$activeSheet->setCellValue('Y1','Car Net Days Count');
		$activeSheet->setCellValue('Z1','Towncar Net Expense Amount');
		$activeSheet->setCellValue('A1','Towncar Net Booking Count');

		$activeSheet->setCellValue('AB1','Towncar Original Booking Count');
		$activeSheet->setCellValue('AC1','Other Ground Transportation Net Expense Amount');
		$activeSheet->setCellValue('AD1','Other Ground Transportation Net Booking Count');
		$activeSheet->setCellValue('AE1','Other Ground Transportation Original Booking Count');
		$activeSheet->setCellValue('AF1','Other Services Net Expense Amount');
		$activeSheet->setCellValue('AG1','Other Services Net Booking Count');




		$activeSheet->fromArray(
	        $nueva_plantilla,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A2'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );
		
		$fecha1_explode = explode('-', $fecha1);
		$fecha2_explode = explode('-', $fecha2);

		$fecha1 = $fecha1_explode[0] .$fecha1_explode[1].$fecha1_explode[2];
		$fecha2 = $fecha2_explode[1] .$fecha2_explode[1].$fecha2_explode[2];


		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="VTL_MEX_Transaction_'.$fecha1.'-'.$fecha1.'".'.'xlsx'); 
		header('Cache-Control: max-age=0');
		
		$Excel_writer->save('php://output', 'xlsx');


    }

    public function genera_txt($param_final,$ids_cliente,$fecha_recepcion){

		$allrows = $param_final;
		
		$nueva_plantilla = $this->nueva_plantilla($allrows,$ids_cliente,$fecha_recepcion);

		$archivo = fopen($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/archivos_egencia_lay_data_import_sp/Summary_Transaction.txt', "w+");
		
		$header = ['Partner_Code','Partner_Name','Country_Code','Currency_Code','Transaction_Year','Transaction_Month_Number','Client_ID','Client_Name','Domestic_International','Air_Net_Expense_Amount','Air_Net_Ticket_Count'  ,'Air_Original_Ticket_Count','Air_Advance_Purchase_Days_Count','Train_Net_Expense_Amount','Train_Net_Ticket_Count','Train_Original_Ticket_Count','Train_Advance_Purchase_Days_Count','Hotel_Net_Base_Amount','Hotel_Net_Booking_Count','Hotel_Original_Booking_Count','Hotel_Net_Nights_Count','Car_Net_Base_Amount','Car_Net_Booking_Count','Car_Original_Booking_Count','Car_Net_Days_Count','Towncar_Net_Expense_Amount','Towncar_Net_Booking_Count','Towncar_Original_Booking_Count','Other_Ground_Transportation_Net_Expense_Amount','Other_Ground_Transportation_Net_Booking_Count ','Other_Ground_Transportation_Original_Booking_Count','Other_Services_Net_Expense_Amount','Other_Services_Net_Booking_Count'];

		$str_body = '';
		foreach ($header as $key => $value) {
			
					$str_body = $str_body . $value."	";

				}


		fwrite($archivo, $str_body);
			
	    foreach($nueva_plantilla as $key => $value) {

	    	fwrite($archivo,"\r\n");
	    	
	    	$str_body = '';
	    	foreach($value as $value2) {

	    		$str_body = $str_body . $value2."	";

	    	}

	    	fwrite($archivo, $str_body);

		}

		

		fclose($archivo);


    }

    public function nueva_plantilla($rep,$ids_cliente,$fecha_recepcion){

    	 

    	 $CONT_TARIFA_NETA_AEREO_D = 0;
    	 $CONT_TARIFA_NETA_AEREO_I = 0;
    	 $CONT_AEREO_D = 0;
    	 $CONT_AEREO_I = 0;
    	 $CONT_AEREO_BOL_ORIGI_D = 0;
    	 $CONT_AEREO_BOL_ORIGI_I = 0;
    	 $CONT_AEREO_PRECOMPRA_D = 0;
    	 $CONT_AEREO_PRECOMPRA_I = 0;


	     $CONT_TARIFA_NETA_HOTEL_D = 0;
	     $CONT_TARIFA_NETA_HOTEL_I = 0;
	     $CONT_HOTEL_D = 0;
	     $CONT_HOTEL_I = 0;
	     $CONT_HOTEL_NOCHES_D = 0;
	     $CONT_HOTEL_NOCHES_I = 0;
	     
	     $CONT_TARIFA_NETA_CAR_D = 0;
	     $CONT_TARIFA_NETA_CAR_I = 0;
	     $CONT_CAR_D = 0;
	     $CONT_CAR_I = 0;
	     $CONT_CAR_DIAS_D = 0;
	     $CONT_CAR_DIAS_I = 0;
	     
	     $CONT_TARIFA_NETA_TREN_D = 0;
	     $CONT_TARIFA_NETA_TREN_I = 0;
	     $CONT_TREN_D = 0;
	     $CONT_TREN_I = 0;
	     
	     $CONT_TARIFA_NETA_TRENVIA_D = 0;
	     $CONT_TARIFA_NETA_TRENVIA_I = 0;
	     $CONT_TRENVIA_D = 0;
	     $CONT_TRENVIA_I = 0;
	     
	     $CONT_TARIFA_OTROS_TRANS_TERR_NETA_D = 0;
	     $CONT_TARIFA_OTROS_TRANS_TERR_NETA_I = 0;
	     $CONT_TRANS_TERR_D = 0;
	     $CONT_TRANS_TERR_I = 0;
	     
	     $CONT_TARIFA_NETA_OTROS_SERVICIOS_D = 0;
	     $CONT_TARIFA_NETA_OTROS_SERVICIOS_I = 0;
	     $CONT_OTROS_SERVICIOS_D = 0;
	     $CONT_OTROS_SERVICIOS_I = 0;
    	
    	foreach ($rep as $key => $value) {

			foreach ($ids_cliente as $key => $value2) {

				if($value2 == $value['nexp']){


					$DomesticInternational = $value['DomesticInternational'];

					if($value['type_of_service'] == 'BD' || $value['type_of_service'] == 'BI'){

						if($DomesticInternational == 'D'){
						$CONT_AEREO_D++;

							$CONT_TARIFA_NETA_AEREO_D = $CONT_TARIFA_NETA_AEREO_D + $value['GVC_TOTAL'];
							if($value['bol_origi'] != ''){

								$CONT_AEREO_BOL_ORIGI_D++;

							}

							$precompra = $value['precompra'];
							
							if($precompra > 0){

								$CONT_AEREO_PRECOMPRA_D = $CONT_AEREO_PRECOMPRA_D + $precompra;

							}

							

						}else if($DomesticInternational == 'I'){
						$CONT_AEREO_I++;

							$CONT_TARIFA_NETA_AEREO_I = $CONT_TARIFA_NETA_AEREO_I + $value['GVC_TOTAL'];
							if($value['bol_origi'] != ''){

								$CONT_AEREO_BOL_ORIGI_I++;

							}

							$precompra = $value['precompra'];
							
							if($precompra > 0){

								$CONT_AEREO_PRECOMPRA_I = $CONT_AEREO_PRECOMPRA_I + $precompra;

							}

						}
			
						

					}else if($value['type_of_service'] == 'HOTEL'){

						if($DomesticInternational == 'D'){
						$CONT_HOTEL_D++;

							$CONT_TARIFA_NETA_HOTEL_D = $CONT_TARIFA_NETA_HOTEL_D + $value['tarifa_neta_hotel'];
							
							$noches = $value['noches'];
							
							if($noches > 0){

								$CONT_HOTEL_NOCHES_D = $CONT_HOTEL_NOCHES_D + $noches;

							}

						}else if($DomesticInternational == 'I'){
						$CONT_HOTEL_I++;

							$CONT_TARIFA_NETA_HOTEL_I = $CONT_TARIFA_NETA_HOTEL_I + $value['tarifa_neta_hotel'];
							
							$noches = $value['noches'];
							
							if($noches > 0){

								$CONT_HOTEL_NOCHES_I = $CONT_HOTEL_NOCHES_I + $noches;

							}

						}
						
						

					}else if($value['type_of_service'] == 'CAR'){ //CARROS

						if($DomesticInternational == 'D'){
						$CONT_CAR_D++;

							$CONT_TARIFA_NETA_CAR_D = $CONT_TARIFA_NETA_CAR_D + $value['tarifa_total_car'];
							
							$dias = $value['dias'];
							
							if($dias > 0){

								$CONT_CAR_DIAS_D = $CONT_CAR_DIAS_D + $dias;

							}

						}else if($DomesticInternational == 'I'){
						$CONT_CAR_I++;

							$CONT_TARIFA_NETA_CAR_I = $CONT_TARIFA_NETA_CAR_I + $value['tarifa_total_car'];
							
							$dias = $value['dias'];
							
							if($dias > 0){

								$CONT_CAR_DIAS_I = $CONT_CAR_DIAS_I + $dias;

							}

						}
						
						

					}else{

						$booking_type = $this->lib_ega_booking_type->booking_type($value['type_of_service']);

						if($booking_type == 7){  //otras transportaciones  TODAS SON NACIONALES
						$CONT_TRANS_TERR_D++;							
						
								$CONT_TARIFA_OTROS_TRANS_TERR_NETA_D = $CONT_TARIFA_OTROS_TRANS_TERR_NETA_D + $value['GVC_TOTAL'];

								

						}

						if($booking_type == 10){  //otras SERVICIOS
					
							/*

							if($DomesticInternational == 'D'){
							$CONT_OTROS_SERVICIOS_D++;

								$CONT_TARIFA_NETA_OTROS_SERVICIOS_D = $CONT_TARIFA_NETA_OTROS_SERVICIOS_D + $value['GVC_TOTAL'];

							}else if($DomesticInternational == 'I'){
							$CONT_OTROS_SERVICIOS_I++;

								$CONT_TARIFA_NETA_OTROS_SERVICIOS_I = $CONT_TARIFA_NETA_OTROS_SERVICIOS_I + $value['GVC_TOTAL'];

							}

							*/

						}

						


					}



				}

			}

    	}
    	

    	$fecha_recepcion = explode('/', $fecha_recepcion);
    	$year = $fecha_recepcion[2];
    	$month = $fecha_recepcion[1];

    	$nueva_plantilla = [];

    	foreach ($ids_cliente as $key => $value) {

    				$name_client = $this->Mod_layouts_egencia_sample_summary_transaction->client_name($value);

					$campos = [];
					
					$campos['Partner_Code'] = '';
					$campos['Partner_Name'] = '';
					$campos['Country_Code'] = 'MEX';
					$campos['Currency_Code'] = 'MXN';
					$campos['Transaction_Year'] = $year;
					$campos['Transaction_Month_Number'] = $month;
					$campos['Client_ID'] = $value;
					$campos['Client_Name'] = $name_client;
					$campos['Domestic_International'] = 'Domestic';
					$campos['Air_Net_Expense_Amount'] = number_format((float)$CONT_TARIFA_NETA_AEREO_D, 2, '.', '');
					$campos['Air_Net_Ticket_Count'] = $CONT_AEREO_D;  
					$campos['Air_Original_Ticket_Count'] = $CONT_AEREO_BOL_ORIGI_D; //REVISAR
					$campos['Air_Advance_Purchase_Days_Count'] = $CONT_AEREO_PRECOMPRA_D; //Cuenta de días de compra anticipada aérea   precompra
					$campos['Train_Net_Expense_Amount'] = ''; // VA VACIO  
					$campos['Train_Net_Ticket_Count'] = ''; // VA VACIO
					$campos['Train_Original_Ticket_Count'] = ''; // VA VACIO
					$campos['Train_Advance_Purchase_Days_Count'] = ''; // VA VACIO
					$campos['Hotel_Net_Base_Amount'] = number_format((float)$CONT_TARIFA_NETA_HOTEL_D, 2, '.', '');
					$campos['Hotel_Net_Booking_Count'] = $CONT_HOTEL_D;
					$campos['Hotel_Original_Booking_Count'] = '';  // VA VACIO
					$campos['Hotel_Net_Nights_Count'] = $CONT_HOTEL_NOCHES_D;
					$campos['Car_Net_Base_Amount'] = number_format((float)$CONT_TARIFA_NETA_CAR_D, 2, '.', '');
					$campos['Car_Net_Booking_Count'] = $CONT_CAR_D;
					$campos['Car_Original_Booking_Count'] = ''; // VA VACIO
					$campos['Car_Net_Days_Count'] = $CONT_CAR_DIAS_D;
					$campos['Towncar_Net_Expense_Amount'] = ''; // VA VACIO
					$campos['Towncar_Net_Booking_Count'] = ''; // VA VACIO
					$campos['Towncar_Original_Booking_Count'] = ''; // VA VACIO
					$campos['Other_Ground_Transportation_Net_Expense_Amount'] = number_format((float)$CONT_TARIFA_OTROS_TRANS_TERR_NETA_D, 2, '.', '');
					$campos['Other_Ground_Transportation_Net_Booking_Count '] = $CONT_TRANS_TERR_D;
					$campos['Other_Ground_Transportation_Original_Booking_Count'] = '';
					$campos['Other_Services_Net_Expense_Amount'] = number_format((float)$CONT_TARIFA_NETA_OTROS_SERVICIOS_D, 2, '.', '');
					$campos['Other_Services_Net_Booking_Count'] = $CONT_TARIFA_NETA_OTROS_SERVICIOS_D;


					array_push($nueva_plantilla, $campos);

					$campos = [];
					
					$campos['Partner_Code'] = '';
					$campos['Partner_Name'] = '';
					$campos['Country_Code'] = 'MEX';
					$campos['Currency_Code'] = 'MXN';
					$campos['Transaction_Year'] = $year;
					$campos['Transaction_Month_Number'] = $month;
					$campos['Client_ID'] = $value;
					$campos['Client_Name'] = $name_client;
					$campos['Domestic_International'] = 'International';
					$campos['Air_Net_Expense_Amount'] = number_format((float)$CONT_TARIFA_NETA_AEREO_I, 2, '.', '');
					$campos['Air_Net_Ticket_Count'] = $CONT_AEREO_I;  
					$campos['Air_Original_Ticket_Count'] = $CONT_AEREO_BOL_ORIGI_I;
					$campos['Air_Advance_Purchase_Days_Count'] = $CONT_AEREO_PRECOMPRA_I;
					$campos['Train_Net_Expense_Amount'] = ''; // VA VACIO
					$campos['Train_Net_Ticket_Count'] = ''; // VA VACIO
					$campos['Train_Original_Ticket_Count'] = ''; // VA VACIO
					$campos['Train_Advance_Purchase_Days_Count'] = '';
					$campos['Hotel_Net_Base_Amount'] = number_format((float)$CONT_TARIFA_NETA_HOTEL_I, 2, '.', '');
					$campos['Hotel_Net_Booking_Count'] = $CONT_HOTEL_I;
					$campos['Hotel_Original_Booking_Count'] = '';  // VA VACIO
					$campos['Hotel_Net_Nights_Count'] = $CONT_HOTEL_NOCHES_I;
					$campos['Car_Net_Base_Amount'] = number_format((float)$CONT_TARIFA_NETA_CAR_I, 2, '.', '');
					$campos['Car_Net_Booking_Count'] = $CONT_CAR_I;
					$campos['Car_Original_Booking_Count'] = ''; // VA VACIO
					$campos['Car_Net_Days_Count'] = $CONT_CAR_DIAS_I;
					$campos['Towncar_Net_Expense_Amount'] = ''; // VA VACIO
					$campos['Towncar_Net_Booking_Count'] = ''; // VA VACIO
					$campos['Towncar_Original_Booking_Count'] = ''; // VA VACIO
					$campos['Other_Ground_Transportation_Net_Expense_Amount'] = number_format((float)$CONT_TARIFA_OTROS_TRANS_TERR_NETA_I, 2, '.', '');
					$campos['Other_Ground_Transportation_Net_Booking_Count '] = $CONT_TRANS_TERR_I;
					$campos['Other_Ground_Transportation_Original_Booking_Count'] = '';
					$campos['Other_Services_Net_Expense_Amount'] = number_format((float)$CONT_TARIFA_NETA_OTROS_SERVICIOS_I, 2, '.', '');
					$campos['Other_Services_Net_Booking_Count'] = $CONT_TARIFA_NETA_OTROS_SERVICIOS_I;

					array_push($nueva_plantilla, $campos);


			}

			

		return $nueva_plantilla;
		
	
    }


    public function exportar_txt_lay_egencia_data_import_sp(){

	    header("Content-type: .txt");
	    header("Content-Disposition: attachment;filename=Summary_Transaction.txt");
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	 
	    set_time_limit(0); 
	    readfile($_SERVER['DOCUMENT_ROOT'].'\reportes_villatours_v\referencias\archivos\archivos_egencia_lay_data_import_sp\Summary_Transaction.txt');

	}



}
