<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require 'vendor/autoload.php';

class Cnt_layouts_egencia_bookings_cadena extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_egencia_bookings_cadena');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_ciudades');
	      $this->load->library('lib_ega_booking_type');
	      $this->load->library('lib_ciudades_pais');
 		  $this->load->library('lib_ciudades_pais_detallado');
		  $this->load->library('lib_ciudades_pais_convert');
		  $this->load->library('lib_ciudades_estado_detallado');
		  $this->load->library('lib_ega_booking_type_code_cxs');    
		  $this->load->library('lib_ega_log'); 
	      $this->Mod_general->get_SPID();
	     
	}
	
	public function get_html_layouts_egencia_bookings(){

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

		$this->load->view('Layouts/view_lay_egencia_bookings');
		
	}

	public function get_html_layouts_Egencia_Data_Import(){  //todos los archivos

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

		$this->load->view('Layouts/view_lay_egencia_data_import');
		
	}
	

	public function get_layouts_egencia_data_import_sp_parametros(){

		$parametros = $_REQUEST["parametros"];
        $tipo_funcion = $_REQUEST['tipo_funcion'];  //falta
		$parametros = explode(",", $parametros);

		$consecutivo_ega = $this->input->post('consecutivo_ega');

		$this->get_layouts_egencia_data_import_sp($parametros,$tipo_funcion,$consecutivo_ega);		

	}

	public function get_layouts_egencia_data_import_sp($parametros,$tipo_funcion,$consecutivo_ega){

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

		  
		  $rest = $this->Mod_layouts_egencia_bookings_cadena->get_layouts_egencia_data_import_sp($parametros);

		  $array1 = array();
		  $array_consecutivo = array();
		  //$array_hotel_reserv = array();
		  $array_ticket_number = array();
		  $array_codigo_detalle = array();

		  function eliminar_acentos($cadena){
					
					//Reemplazamos la A y a
					$cadena = str_replace(
					array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
					array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
					$cadena
					);

					//Reemplazamos la E y e
					$cadena = str_replace(
					array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
					array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
					$cadena );

					//Reemplazamos la I y i
					$cadena = str_replace(
					array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
					array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
					$cadena );

					//Reemplazamos la O y o
					$cadena = str_replace(
					array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
					array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
					$cadena );

					//Reemplazamos la U y u
					$cadena = str_replace(
					array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
					array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
					$cadena );

					//Reemplazamos la N, n, C y c
					$cadena = str_replace(
					array('Ñ', 'ñ', 'Ç', 'ç'),
					array('N', 'n', 'C', 'c'),
					$cadena
					);
					
					return $cadena;
			}


		  function data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie){  //SUB FUNCION
					
		  			$dat[''] = '';
		  			
		  			$dat['Link_Key'] = '';	
			        $dat['BookingID'] = ''; //numero incrementable*/

			        $dat['fecha1'] = utf8_encode($fecha1);
			        $dat['fecha2'] = utf8_encode($fecha2);
			        $dat['id_serie'] = utf8_encode($id_serie);
			        $dat['fecha_salida_vuelos_cxs'] = utf8_encode($valor->fecha_salida_vuelos_cxs);
					$dat['fecha_salid_con_bol_cxs'] = utf8_encode($valor->fecha_salid_con_bol_cxs);
					$dat['fecha_salid_con_bol'] = utf8_encode($valor->fecha_salid_con_bol);
					$dat['fecha_regreso_vuelos_cxs'] = utf8_encode($valor->fecha_regreso_vuelos_cxs);
					$dat['fecha_regre_con_bol_cxs'] = utf8_encode($valor->fecha_regre_con_bol_cxs);
					$dat['fecha_regre_con_bol'] = utf8_encode($valor->fecha_regre_con_bol);
					$dat['TIPO_HOTEL'] = '';
					$dat['fac_numero_cxss'] = utf8_encode($valor->fac_numero_cxss);
					$dat['id_serie_cxss'] = utf8_encode($valor->id_serie_cxss);


					//-----analisis cliente------------//

					$dat['analisis46_cliente'] = utf8_encode($valor->analisis46_cliente);
			        $dat['analisis35_cliente'] = utf8_encode($valor->analisis35_cliente);
			        $dat['analisis1_cliente']	= utf8_encode($valor->analisis1_cliente);
					$dat['analisis2_cliente']	= utf8_encode($valor->analisis2_cliente);
					$dat['analisis3_cliente']	= utf8_encode($valor->analisis3_cliente);
					$dat['analisis4_cliente']	= utf8_encode($valor->analisis4_cliente);
					$dat['analisis5_cliente']	= utf8_encode($valor->analisis5_cliente);
					$dat['analisis6_cliente']	= utf8_encode($valor->analisis6_cliente);
					$dat['analisis7_cliente']	= utf8_encode($valor->analisis7_cliente);
					$dat['analisis8_cliente']	= utf8_encode($valor->analisis8_cliente);
					$dat['analisis9_cliente']	= utf8_encode($valor->analisis9_cliente);
					$dat['analisis10_cliente']	= utf8_encode($valor->analisis10_cliente);
					$dat['analisis11_cliente']	= utf8_encode($valor->analisis11_cliente);
					$dat['analisis12_cliente']	= utf8_encode($valor->analisis12_cliente);
					$dat['analisis13_cliente']	= utf8_encode($valor->analisis13_cliente);
					$dat['analisis14_cliente']	= utf8_encode($valor->analisis14_cliente);
					$dat['analisis15_cliente']	= utf8_encode($valor->analisis15_cliente);
					$dat['analisis16_cliente']	= utf8_encode($valor->analisis16_cliente);
					$dat['analisis17_cliente']	= utf8_encode($valor->analisis17_cliente);
					$dat['analisis18_cliente']	= utf8_encode($valor->analisis18_cliente);
					$dat['analisis19_cliente']	= utf8_encode($valor->analisis19_cliente);
					$dat['analisis20_cliente']	= utf8_encode($valor->analisis20_cliente);
					$dat['analisis21_cliente']	= utf8_encode($valor->analisis21_cliente);
					$dat['analisis22_cliente']	= utf8_encode($valor->analisis22_cliente);
					$dat['analisis23_cliente']	= utf8_encode($valor->analisis23_cliente);
					$dat['analisis24_cliente']	= utf8_encode($valor->analisis24_cliente);
					$dat['analisis25_cliente']	= utf8_encode($valor->analisis25_cliente);
					$dat['analisis26_cliente']	= utf8_encode($valor->analisis26_cliente);
					$dat['analisis27_cliente']	= utf8_encode($valor->analisis27_cliente);
					$dat['analisis28_cliente']	= utf8_encode($valor->analisis28_cliente);
					$dat['analisis29_cliente']	= utf8_encode($valor->analisis29_cliente);
					$dat['analisis30_cliente']	= utf8_encode($valor->analisis30_cliente);
					$dat['analisis31_cliente']	= utf8_encode($valor->analisis31_cliente);
					$dat['analisis32_cliente']	= utf8_encode($valor->analisis32_cliente);
					$dat['analisis33_cliente']	= utf8_encode($valor->analisis33_cliente);
					$dat['analisis34_cliente']	= utf8_encode($valor->analisis34_cliente);
					$dat['analisis36_cliente']	= utf8_encode($valor->analisis36_cliente);
					$dat['analisis37_cliente']	= utf8_encode($valor->analisis37_cliente);
					$dat['analisis38_cliente']	= utf8_encode($valor->analisis38_cliente);
					$dat['analisis39_cliente']	= utf8_encode($valor->analisis39_cliente);
					$dat['analisis40_cliente']	= utf8_encode($valor->analisis40_cliente);
					$dat['analisis41_cliente']	= utf8_encode($valor->analisis41_cliente);
					$dat['analisis42_cliente']	= utf8_encode($valor->analisis42_cliente);
					$dat['analisis43_cliente']	= utf8_encode($valor->analisis43_cliente);
					$dat['analisis44_cliente']	= utf8_encode($valor->analisis44_cliente);
					$dat['analisis45_cliente']	= utf8_encode($valor->analisis45_cliente);
					$dat['analisis47_cliente']	= utf8_encode($valor->analisis47_cliente);
					$dat['analisis48_cliente']	= utf8_encode($valor->analisis48_cliente);
					$dat['analisis49_cliente']	= utf8_encode($valor->analisis49_cliente);
					$dat['analisis50_cliente']	= utf8_encode($valor->analisis50_cliente);
					$dat['analisis51_cliente']	= utf8_encode($valor->analisis51_cliente);
					$dat['analisis52_cliente']	= utf8_encode($valor->analisis52_cliente);
					$dat['analisis53_cliente']	= utf8_encode($valor->analisis53_cliente);
					$dat['analisis54_cliente']	= utf8_encode($valor->analisis54_cliente);
					$dat['analisis55_cliente']	= utf8_encode($valor->analisis55_cliente);
					$dat['analisis56_cliente']	= utf8_encode($valor->analisis56_cliente);
					$dat['analisis57_cliente']	= utf8_encode($valor->analisis57_cliente);
					$dat['analisis58_cliente']	= utf8_encode($valor->analisis58_cliente);
					$dat['analisis59_cliente']	= utf8_encode($valor->analisis59_cliente);
					$dat['analisis60_cliente']	= utf8_encode($valor->analisis60_cliente);
					$dat['analisis61_cliente']	= utf8_encode($valor->analisis61_cliente);
					$dat['analisis62_cliente']	= utf8_encode($valor->analisis62_cliente);
					$dat['analisis63_cliente']	= utf8_encode($valor->analisis63_cliente);
					$dat['analisis64_cliente']	= utf8_encode($valor->analisis64_cliente);
					$dat['analisis65_cliente']	= utf8_encode($valor->analisis65_cliente);
					$dat['analisis66_cliente']	= utf8_encode($valor->analisis66_cliente);
					$dat['analisis67_cliente']	= utf8_encode($valor->analisis67_cliente);
					$dat['analisis68_cliente']	= utf8_encode($valor->analisis68_cliente);
					$dat['analisis69_cliente']	= utf8_encode($valor->analisis69_cliente);
					$dat['analisis70_cliente']	= utf8_encode($valor->analisis70_cliente);
					$dat['analisis71_cliente']	= utf8_encode($valor->analisis71_cliente);
					$dat['analisis72_cliente']	= utf8_encode($valor->analisis72_cliente);
					$dat['analisis73_cliente']	= utf8_encode($valor->analisis73_cliente);
					$dat['analisis74_cliente']	= utf8_encode($valor->analisis74_cliente);
					$dat['analisis75_cliente']	= utf8_encode($valor->analisis75_cliente);
					$dat['analisis76_cliente']	= utf8_encode($valor->analisis76_cliente);
					$dat['analisis77_cliente']	= utf8_encode($valor->analisis77_cliente);
					$dat['analisis78_cliente']	= utf8_encode($valor->analisis78_cliente);
					$dat['analisis79_cliente']	= utf8_encode($valor->analisis79_cliente);
					$dat['analisis80_cliente']	= utf8_encode($valor->analisis80_cliente);
					$dat['analisis81_cliente']	= utf8_encode($valor->analisis81_cliente);
					$dat['analisis82_cliente']	= utf8_encode($valor->analisis82_cliente);
					$dat['analisis83_cliente']	= utf8_encode($valor->analisis83_cliente);
					$dat['analisis84_cliente']	= utf8_encode($valor->analisis84_cliente);
					$dat['analisis85_cliente']	= utf8_encode($valor->analisis85_cliente);
					$dat['analisis86_cliente']	= utf8_encode($valor->analisis86_cliente);
					$dat['analisis87_cliente']	= utf8_encode($valor->analisis87_cliente);
					$dat['analisis88_cliente']	= utf8_encode($valor->analisis88_cliente);
					$dat['analisis89_cliente']	= utf8_encode($valor->analisis89_cliente);
					$dat['analisis90_cliente']	= utf8_encode($valor->analisis90_cliente);
					$dat['analisis91_cliente']	= utf8_encode($valor->analisis91_cliente);
					$dat['analisis92_cliente']	= utf8_encode($valor->analisis92_cliente);
					$dat['analisis93_cliente']	= utf8_encode($valor->analisis93_cliente);
					$dat['analisis94_cliente']	= utf8_encode($valor->analisis94_cliente);
					$dat['analisis95_cliente']	= utf8_encode($valor->analisis95_cliente);
					$dat['analisis96_cliente']	= utf8_encode($valor->analisis96_cliente);
					$dat['analisis97_cliente']	= utf8_encode($valor->analisis97_cliente);
					$dat['analisis98_cliente']	= utf8_encode($valor->analisis98_cliente);
					$dat['analisis99_cliente']	= utf8_encode($valor->analisis99_cliente);
					$dat['analisis100_cliente']	= utf8_encode($valor->analisis100_cliente);


			        //-----analisis cliente------------//

			        $dat['numero_bol_cxs'] = utf8_encode($valor->numero_bol_cxs);
			        
			        $dat['SBU'] = utf8_encode($valor->SBU);

			        $dat['EmployeeID'] = utf8_encode($valor->EmployeeID);

			        $dat['desc_centro_costo'] = utf8_encode($valor->desc_centro_costo);

			        $dat['consecutivo_vuelo'] = utf8_encode($valor->consecutivo_vuelo);

			        $dat['consecutivo_gen'] = utf8_encode($valor->consecutivo);

			        $dat['boleto_aereo'] = $valor->boleto_aereo;

					$dat['fecha_fac'] = utf8_encode($valor->fecha_fac);

					$dat['codigo_razon'] = utf8_encode($valor->codigo_razon);
					
					$dat['mail_cliente'] = utf8_encode($valor->mail_cliente);
		  			
		  			//$dat['consecutivo'] = utf8_encode($valor->id_boleto);

					$dat['TransactionType'] = utf8_encode($valor->TransactionType);

					$dat['BranchARCNumber'] = utf8_encode($valor->BranchARCNumber);
					
					$dat['departament'] = utf8_encode($valor->analisis12_cliente);
		  			
		  			$dat['pseudocity'] = utf8_encode($valor->pseudocity);

		  			$dat['contra'] =  utf8_encode($valor->contra);

		  			$dat['bol_contra'] =  utf8_encode($valor->bol_contra);

					$dat['VendorCountryCode_car'] = '';
		  			$dat['VendorCountryCode_hotel'] = '';
		  			$dat['VendorCountryCode_vuelo'] = ''; //utf8_encode($valor->VendorCountryCode)

					$dat['ticket_designer_car'] = '';
		  			$dat['ticket_designer_hotel'] = '';
		  			$dat['ticket_designer_vuelo'] = utf8_encode($valor->ticket_designer_vuelo);

		  			$dat['tour_code_car'] = '';
		  			$dat['tour_code_hotel'] = '';
		  			$dat['tour_code_vuelo'] = utf8_encode($valor->tour_code_vuelo);

					$dat['class_car'] = '';
		  			$dat['class_hotel'] = '';
		  			$dat['class_vuelo'] = utf8_encode($valor->class_vuelo);

					$dat['DomesticInternational'] = '';

					$dat['destination_car'] = '';
		  			$dat['destination_hotel'] = '';
		  			$dat['destination_vuelo'] = $valor->destination_vuelo;

		  			$dat['origin_car'] = '';
		  			$dat['origin_hotel'] = '';

		  			if(isset($valor->routing_vuelo) && $valor->routing_vuelo != ''){

		  				$explod = explode('/', $valor->routing_vuelo);
		  				$ori = $explod[0];

		  			}else{

		  				$ori = '';
		  			}

		  			$dat['origin_vuelo'] = utf8_encode($ori);

				    $dat['routing_car'] = '';
		  			$dat['routing_hotel'] = '';
		  			$dat['routing_vuelo'] = utf8_encode($valor->routing_vuelo);


					$dat['documento_car'] = '';
		  			$dat['documento_hotel'] = '';
		  			$dat['documento_vuelo'] = utf8_encode($valor->documento_vuelo);

					
					$dat['GVC_NOM_PAX_CAR'] = '';
		  			$dat['GVC_NOM_PAX_HOTEL'] = '';
		  			$dat['GVC_NOM_PAX_VUELO'] = utf8_encode($valor->GVC_NOM_PAX_VUELO);


		  			$dat['payment_number_car'] = '';
					$dat['payment_number_hotel'] = '';
					$dat['payment_number_vuelo'] = utf8_encode($valor->payment_number_vuelo);


		  			$dat['ID_FORMA_PAGO_AUTO'] = '';
		  			$dat['ID_FORMA_PAGO_AUTO_ORIGINAL'] = '';
		  			$dat['ID_FORMA_PAGO_HOTEL'] = '';
		  			$dat['ID_FORMA_PAGO_HOTEL_ORIGINAL'] = '';
					$dat['ID_FORMA_PAGO_VUELO'] = utf8_encode($valor->ID_FORMA_PAGO_VUELO);
					$dat['ID_FORMA_PAGO_VUELO_ORIGINAL'] = utf8_encode($valor->ID_FORMA_PAGO_VUELO_ORIGINAL);

					$dat['moneda_auto'] = '';
					$dat['moneda_hotel'] = '';
					$dat['moneda_vuelo'] = utf8_encode($valor->moneda_vuelo);

		  			$dat['emd'] = utf8_encode($valor->emd);
					$dat['SUMA_IMPUESTOS'] = utf8_encode($valor->SUMA_IMPUESTOS);
					$dat['GVC_TOTAL'] = utf8_encode($valor->GVC_TOTAL);
					$dat['GVC_IVA'] = utf8_encode($valor->GVC_IVA);
					$dat['GVC_TUA'] = utf8_encode($valor->GVC_TUA);
					$dat['GVC_OTROS_IMPUESTOS'] = utf8_encode($valor->GVC_OTROS_IMPUESTOS);
					$dat['IMP_CRE'] = utf8_encode($valor->IMP_CRE);
					$dat['TARIFA_OFRECIDA'] = utf8_encode($valor->TARIFA_OFRECIDA);
					$dat['GVC_TARIFA_MON_BASE'] = utf8_encode($valor->GVC_TARIFA_MON_BASE);

					$dat['GVC_FECHA_SALIDA'] = utf8_encode($valor->GVC_FECHA_SALIDA_CON);
					$dat['GVC_FECHA_REGRESO'] = utf8_encode($valor->GVC_FECHA_REGRESO_CON);

					if($valor->GVC_FECHA_SALIDA != '' && $valor->GVC_FECHA_SALIDA_CON != '' && $valor->GVC_FECHA_REGRESO != '' && $valor->GVC_FECHA_REGRESO_CON != ''){

							if($valor->GVC_FECHA_SALIDA != $valor->GVC_FECHA_SALIDA_CON || $valor->GVC_FECHA_REGRESO != $valor->GVC_FECHA_REGRESO_CON){

									if($valor->GVC_FECHA_SALIDA == '01-01-1900' || $valor->GVC_FECHA_REGRESO == '01-01-1900'){

										$dat['GVC_FECHA_SALIDA'] = utf8_encode($valor->GVC_FECHA_SALIDA_CON);
										$dat['GVC_FECHA_REGRESO'] = utf8_encode($valor->GVC_FECHA_REGRESO_CON);

									}else{

										$dat['GVC_FECHA_SALIDA'] = utf8_encode($valor->GVC_FECHA_SALIDA);
										$dat['GVC_FECHA_REGRESO'] = utf8_encode($valor->GVC_FECHA_REGRESO);

									}

							}else{

									$dat['GVC_FECHA_SALIDA'] = utf8_encode($valor->GVC_FECHA_SALIDA_CON);
									$dat['GVC_FECHA_REGRESO'] = utf8_encode($valor->GVC_FECHA_REGRESO_CON);
							}

					}

		  			$dat['cp_ho'] = '';
					$dat['GVC_FECHA_RESERVACION'] = utf8_encode($valor->GVC_FECHA_RESERVACION);
					$dat['codigo_bsp'] = utf8_encode($valor->codigo_bsp);
					$dat['linea_aerea'] = utf8_encode($valor->linea_aerea);
 					$dat['ID_VENDEDOR_TIT'] = utf8_encode($valor->ID_VENDEDOR_TIT);
 					$dat['VENDEDOR_NOMBRE_TIT'] = utf8_encode($valor->VENDEDOR_NOMBRE_TIT);
					$dat['id_sucursal'] = utf8_encode($valor->id_sucursal);
					$dat['ID_PROVEEDOR'] = utf8_encode($valor->ID_PROVEEDOR);
					$dat['nombre_proveedor'] = $valor->nombre_proveedor;
 					$dat['analisis4_cliente'] = utf8_encode($valor->analisis4_cliente);
 					$dat['id_stat'] = utf8_encode($valor->id_stat);
					$dat['GVC_NOM_CLI'] = utf8_encode($valor->GVC_NOM_CLI);

					$dat['name'] = utf8_encode($valor->name);
					$dat['nexp'] = utf8_encode($valor->nexp);
					$dat['destination'] = utf8_encode($valor->destination);

					$dat['fecha_salida_vu'] = utf8_encode($valor->fecha_salida_vu);
					$dat['fecha_regreso_vu'] = utf8_encode($valor->fecha_regreso_vu);

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

				
					return $dat;
				} //FIN FUNCION DATA GENERAL

		
		   foreach ($rest as $clave => $valor) {

			    $consecutivo_gds_general = $valor->consecutivo;
			    $codigo_detalle = $valor->codigo_detalle;
			    $record_localizador = utf8_encode($valor->record_localizador);
			    $fac_numero = utf8_encode($valor->documento);
			    $id_serie = utf8_encode($valor->id_serie);

			  	    if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI' || $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT' || $valor->type_of_service == 'HOTNAC_RES' ){

						if( !in_array($consecutivo_gds_general, $array_consecutivo) && $valor->type_of_service == 'HOTNAC' || $valor->type_of_service == 'HOTINT'){

							$ticket = utf8_encode($valor->ticket_number);
							$segmentos = $this->Mod_layouts_egencia_bookings_cadena->get_segmentos_ticket_number($ticket,$consecutivo_gds_general);
							$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

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


							$hoteles_iris_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_iris('man',$fecha_ini_proceso = '',$id_intervalo = 0,$fac_numero,$fecha1,$fecha2,$id_serie,$valor->TransactionType);


							$cont3=0;
					    	foreach ($hoteles_iris_arr as $clave_hot_ir => $valor_hot_ir) {  
							$cont3++;

						     	 $dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

						     	 if($valor->type_of_service == 'HOTNAC'){

									$dat['DomesticInternational'] = 'D';

								 }else if($valor->type_of_service == 'HOTINT'){

									$dat['DomesticInternational'] = 'I';

								 }

								 $dat['TIPO_HOTEL'] = 'FACTURADO';
						     	 $dat['type_of_service'] = 'HOTEL';
							     $dat['codigo_producto'] = 'HOTEL';

								 $dat['Link_Key'] = $valor_hot_ir['consecutivo_reserv'];
								 $dat['BookingID'] = $valor_hot_ir['consecutivo_reserv']; //numero incrementable*/

								 $dat['class_hotel'] = utf8_encode($valor_hot_ir['class_hotel']);
								 $dat['destination_hotel'] = utf8_encode($valor_hot_ir['destination_hotel']);
								 $dat['origin_hotel'] = utf8_encode($valor_hot_ir['origin_hotel']);
								 $dat['routing_hotel'] = utf8_encode($valor_hot_ir['routing_hotel']);

								 $cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($valor_hot_ir['id_ciudad']);  
								
						    	 $dat['VendorCountryCode_hotel'] = utf8_encode($cod_ciudad_3caracteres);

								 $dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot_ir['GVC_NOM_PAX_HOTEL']);
								 $dat['payment_number_hotel'] = utf8_encode($valor_hot_ir['payment_number_hotel']);
								 $dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot_ir['ID_FORMA_PAGO_HOTEL']);
								 $dat['ID_FORMA_PAGO_HOTEL_ORIGINAL'] = utf8_encode($valor_hot_ir['ID_FORMA_PAGO_HOTEL_ORIGINAL']);
								 $dat['moneda_hotel'] = utf8_encode($valor_hot_ir['moneda_hotel']);
								 $dat['telefono_hotel'] = utf8_encode($valor_hot_ir['tel1_ho']);
								 $dat['direccion_hotel'] = utf8_encode($valor_hot_ir['direccion_ho']);
								 $dat['nombre_ciudad_hotel'] = utf8_encode($valor_hot_ir['desc_ciudad']);

								 $cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($valor_hot_ir['id_ciudad']); 
								 $dat['estado_hotel'] = $cod_ciudad_estado;

								 $dat['cp_ho'] = utf8_encode($valor_hot_ir['cp_ho']);

						    	 $dat['nombre_hotel'] = utf8_encode($valor_hot_ir['nombre_hotel']);

						    	 $dat['fecha_entrada'] = utf8_encode($valor_hot_ir['fecha_entrada_hotel']);
						    	 $dat['fecha_salida'] = utf8_encode($valor_hot_ir['fecha_salida_hotel']);
								 $dat['fecha_entrada_original'] = utf8_encode($valor_hot_ir['fecha_entrada_hotel_original']);
						    	 $dat['fecha_salida_original'] = utf8_encode($valor_hot_ir['fecha_salida_hotel_original']);
						    	 $dat['propiedad'] =  utf8_encode($valor_hot_ir['id_cadena']);
						    	 $dat['documento_hotel'] = utf8_encode($valor_hot_ir['clave_confirmacion']);

						    	 $dat['VendorInterfaceID'] = utf8_encode($valor_hot_ir['id_cadena']);

						    	 $costo_hab = (float)$valor_hot_ir['costo_hab'];
						    	 $noches = (float)$valor_hot_ir['noches'];
						    	 $costo_hab = $costo_hab/$noches;

						    	 $dat['rate_hot'] = $costo_hab;

						    	 $dat['noches'] = utf8_encode($valor_hot_ir['noches']);
						    	 $dat['numero_habitaciones'] = utf8_encode($valor_hot_ir['numero_habitaciones']);
						    	 

						    	 $dat['buy_in_advance'] = utf8_encode($valor_hot_ir['buy_in_advance']);
						    	 $dat['tarifa_neta'] = utf8_encode($valor_hot_ir['tarifa_neta']);
						    	 $dat['iva_hot'] = utf8_encode($valor_hot_ir['iva']); 
								 $dat['otros_imp_hot'] = utf8_encode($valor_hot_ir['otros_imp']);

								 $dat['TotalPaid'] = $valor->GVC_TOTAL;

								 $dat['BookingType'] = 2;

								 array_push($array1, $dat);


							}

							$autos_arr = $this->Mod_layouts_egencia_bookings_cadena->get_autos_num_bol($consecutivo_gds_general);

						    $cont2=0;
						    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
						    $cont2++;

						    	$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

							    	$dat['type_of_service'] = 'CAR';
								    $dat['codigo_producto'] = 'CAR';
							    	if($cont2 > 1){

							            $dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
							            $dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/

							        }else{

							        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
							        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/
							        }
							    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
							    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
									$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
							    	$id_ciudad = $valor_aut['routing_car'];
							    	$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
									$dat['routing_car'] = utf8_encode($routing_car);

									$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);
						    	    $dat['VendorCountryCode_car'] = utf8_encode($cod_ciudad_3caracteres);
						    	    $cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
								    $dat['estado_car'] = $cod_ciudad_estado;

							    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
							    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
							   		$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
							   		$dat['ID_FORMA_PAGO_AUTO_ORIGINAL'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO_ORIGINAL']);
							   		$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
							   		$dat['nombre_arrendadora2'] = utf8_encode($valor_aut['nombre_arrendadora2']);
									$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega_car']);
									$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge_car']);
									$dat['Delivery_Date_original'] = utf8_encode($valor_aut['fecha_entrega_car_original']);
									$dat['Departure_date_original'] = utf8_encode($valor_aut['fecha_recoge_car_original']);
									$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
									$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
									$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
									$dat['tarifa_total'] = utf8_encode($valor_aut['tarifa_neta']);
									$dat['numero_autos'] = utf8_encode($valor_aut['numero_autos']);
									$dat['nombre_ciudad_renta'] = $routing_car; 

									$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									if($pais == 'MEX'){

										$dat['tarifa_diaria'] =  (float)$valor->analisis58_cliente;
										$tarifa_diaria =  (float)$valor->analisis58_cliente;

									}else{

										$dat['tarifa_diaria'] =  (float)$valor_aut['tarifa_diaria'];
										$tarifa_diaria =  (float)$valor_aut['tarifa_diaria'];

									}

									
							    	$dias = utf8_encode($valor_aut['dias']);
							    	$tarifa_total = $tarifa_diaria * $dias;
							    	$dat['tarifa_neta'] = $tarifa_total;

									$dat['iva_car'] = utf8_encode($valor_aut['iva']);  
									

									$dat['VendorInterfaceID'] = utf8_encode($valor_aut['id_arrendadora']);

									

								    $dat['BookingType'] = 3;
								    $dat['documento_car'] = utf8_encode($valor_aut['documento_car']);

								    
									  		if($pais == 'MEX'){

									  			$dat['DomesticInternational'] = 'D';
												
									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

									array_push($array1, $dat);

						    }
							
						    	

						}else if( !in_array($consecutivo_gds_general, $array_consecutivo) && $valor->type_of_service == 'HOTNAC_RES'){   //no estan facturados

								$ticket = utf8_encode($valor->ticket_number);
								$segmentos = $this->Mod_layouts_egencia_bookings_cadena->get_segmentos_ticket_number($ticket,$consecutivo_gds_general);
								$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

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

						

									$hoteles_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo_gds_general,$fecha1,$fecha2,$fac_numero,$valor->TransactionType);


								

								$cont=0;
							    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
							    $cont++;
							    	
							    	$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

							    	$dat['TIPO_HOTEL'] = 'RESERVADO';
							    	$dat['type_of_service'] = 'HOTEL';
									$dat['codigo_producto'] = 'HOTEL';
							    	//$rango_fechas = $this->lib_ciudades->ciudades($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);
							    	if($cont > 1){

								        $dat['Link_Key'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel'] + $cont);
								        $dat['BookingID'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel'] + $cont); //numero incrementable*/

							        }else{

							        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel']);
							        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel']); //numero incrementable*/

							        }

								    
									$dat['class_hotel'] = utf8_encode($valor_hot['class_hotel']);
							    	$dat['destination_hotel'] = utf8_encode($valor_hot['destination_hotel']);
									$dat['origin_hotel'] = utf8_encode($valor_hot['origin_hotel']);
							    	$id_ciudad = $valor_hot['id_ciudad'];

							    	$nombre_ciudad_hot = $this->lib_ciudades->ciudades($id_ciudad);
									$dat['routing_hotel'] = utf8_encode($nombre_ciudad_hot);

									$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);  
									
									
						    	    $dat['VendorCountryCode_hotel'] = utf8_encode($cod_ciudad_3caracteres);

							    	$dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot['GVC_NOM_PAX_HOTEL']);
							    	$dat['payment_number_hotel'] = utf8_encode($valor_hot['payment_number_hotel']);
							    	$dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL']);
							    	$dat['ID_FORMA_PAGO_HOTEL_ORIGINAL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL_ORIGINAL']);
							    	$dat['moneda_hotel'] = utf8_encode($valor_hot['moneda_hotel']);
						    	    $dat['telefono_hotel'] = utf8_encode($valor_hot['telefono']);
									$dat['direccion_hotel'] = utf8_encode($valor_hot['direccion']);

									$dat['nombre_ciudad_hotel'] = utf8_encode($nombre_ciudad_hot);//xxxxxxxxxxxxxxxxx
									
									$cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
								    $dat['estado_hotel'] = $cod_ciudad_estado;

								    $dat['cp_ho'] = '';  //no existe el cp en gds_hoteles
							    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
							    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada_hotel']);
							    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida_hotel']);
							    	$dat['fecha_entrada_original'] = utf8_encode($valor_hot['fecha_entrada_hotel_original']);
						    	    $dat['fecha_salida_original'] = utf8_encode($valor_hot['fecha_salida_hotel_original']);
						    	    $dat['costo_hab_noche'] = utf8_encode($valor_hot['costo_hab_noche']);
						    	    $dat['rate_hot'] = utf8_encode($valor_hot['costo_hab_noche']);

						    	    $pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

						    	    if($pais == 'MEX'){

										$costo_hab_noche = (float)$valor->analisis57_cliente;
										
									}else{

										$costo_hab_noche = (float)$dat['costo_hab_noche'];

									}

						    	    $noches = intval($valor_hot['noches']);

						    	    $tarifa_neta = $costo_hab_noche * $noches;

						    	    $dat['noches'] = utf8_encode($valor_hot['noches']);
						    	    $dat['tarifa_neta'] = $tarifa_neta; 
						    	    $dat['iva_hot'] = utf8_encode($valor_hot['iva']); 
								    $dat['otros_imp_hot'] = utf8_encode($valor_hot['otros_imp']); 

						    	    $dat['VendorInterfaceID'] = utf8_encode($valor_hot['id_cadena']);
						    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];

									$dat['BookingType'] = 2;
									$dat['propiedad'] =  $valor_hot['propiedad'];
									$dat['documento_hotel'] = utf8_encode($valor_hot['documento_hotel']);

									$dat['TotalPaid'] = $tarifa_neta;
									$dat['numero_habitaciones'] = utf8_encode($valor_hot['numero_habitaciones']);	

									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

									
									array_push($array1, $dat);

									

							   }

							   $autos_arr = $this->Mod_layouts_egencia_bookings_cadena->get_autos_num_bol($consecutivo_gds_general);

							    $cont2=0;
							    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
							    $cont2++;

							    	$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

							    	$dat['type_of_service'] = 'CAR';
								    $dat['codigo_producto'] = 'CAR';

							    	if($cont2 > 1){

							            $dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
							            $dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/

							        }else{

							        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
							        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/
							        }
							    	
							    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
							    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
									$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
							    	$id_ciudad = $valor_aut['routing_car'];
							    	$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
									$dat['routing_car'] = utf8_encode($routing_car);

									$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);
						    	    $dat['VendorCountryCode_car'] = utf8_encode($cod_ciudad_3caracteres);
						    	    $cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
								    $dat['estado_car'] = $cod_ciudad_estado;

							    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
							    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
							   		$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
							   		$dat['ID_FORMA_PAGO_AUTO_ORIGINAL'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO_ORIGINAL']);
							   		$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
							   		$dat['nombre_arrendadora2'] = utf8_encode($valor_aut['nombre_arrendadora2']);
									$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega_car']);
									$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge_car']);
									$dat['Delivery_Date_original'] = utf8_encode($valor_aut['fecha_entrega_car_original']);
									$dat['Departure_date_original'] = utf8_encode($valor_aut['fecha_recoge_car_original']);
									$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
									$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
									$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
									$dat['tarifa_total'] = utf8_encode($valor_aut['tarifa_neta']);

									$pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									if($pais == 'MEX'){

										$dat['tarifa_diaria'] =  (float)$valor->analisis58_cliente;
										$tarifa_diaria =  (float)$valor->analisis58_cliente;
										
									}else{

										$dat['tarifa_diaria'] =  (float)$valor_aut['tarifa_diaria'];
										$tarifa_diaria =  (float)$valor_aut['tarifa_diaria'];

									}

							    	$dias = (float)$valor_aut['dias'];
							    	$tarifa_total = $tarifa_diaria * $dias;
							    	$dat['tarifa_neta'] = $tarifa_total;
							    	$dat['numero_autos'] = utf8_encode($valor_aut['numero_autos']);
							    	$dat['nombre_ciudad_renta'] = $routing_car; 

							    	$dat['iva_car'] = utf8_encode($valor_aut['iva']);


									$dat['VendorInterfaceID'] = utf8_encode($valor_aut['id_arrendadora']);
									

								    $dat['BookingType'] = 3;
								    $dat['documento_car'] = utf8_encode($valor_aut['documento_car']);

								   
									  		if($pais == 'MEX'){


									  			$dat['DomesticInternational'] = 'D';
												

									  		}else{

									  			$dat['DomesticInternational'] = 'I';


									  		}

									array_push($array1, $dat);
							    }


						}  // FIN ELSE IF HOTNAC RES
						else if($valor->type_of_service == 'BD' || $valor->type_of_service == 'BI'){
									
									$ticket = utf8_encode($valor->ticket_number);
	 
									$segmentos = $this->Mod_layouts_egencia_bookings_cadena->get_segmentos_ticket_number($ticket,$consecutivo_gds_general);

					    			$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

									if($valor->type_of_service == 'BD'){

										$dat['DomesticInternational'] = 'D';

									}else if($valor->type_of_service == 'BI'){

										$dat['DomesticInternational'] = 'I';

									}


									$dat['Link_Key'] = $valor->codigo_detalle;	
									$dat['BookingID'] = $valor->codigo_detalle;	

									$booking_type = $this->lib_ega_booking_type->booking_type($valor->type_of_service);
									$dat['BookingType'] = $booking_type;

									array_push($array1, $dat);
						    		
									if(!in_array($consecutivo_gds_general, $array_consecutivo)  ){


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

									    

									

											$hoteles_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo_gds_general,$fecha1,$fecha2,$fac_numero,$valor->TransactionType);

									


									    $cont=0;
							    		foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
									  	$cont++;

									  		$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

									  		$dat['TIPO_HOTEL'] = 'RESERVADO';
									    	$dat['type_of_service'] = 'HOTEL';
											$dat['codigo_producto'] = 'HOTEL';
									    	//$rango_fechas = $this->lib_ciudades->ciudades($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);
									    	if($cont > 1){

										        $dat['Link_Key'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel'] + $cont);
										        $dat['BookingID'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel'] + $cont); //numero incrementable*/

									        }else{

									        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel']);
									        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel']); //numero incrementable*/

									        }

										    
											$dat['class_hotel'] = utf8_encode($valor_hot['class_hotel']);
									    	$dat['destination_hotel'] = utf8_encode($valor_hot['destination_hotel']);
											$dat['origin_hotel'] = utf8_encode($valor_hot['origin_hotel']);
									    	$id_ciudad = $valor_hot['id_ciudad'];

									    	$nombre_ciudad_hot = $this->lib_ciudades->ciudades($id_ciudad);
											$dat['routing_hotel'] = utf8_encode($nombre_ciudad_hot);

											$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);  
											
											
								    	    $dat['VendorCountryCode_hotel'] = utf8_encode($cod_ciudad_3caracteres);

									    	$dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot['GVC_NOM_PAX_HOTEL']);
									    	$dat['payment_number_hotel'] = utf8_encode($valor_hot['payment_number_hotel']);
									    	$dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL']);
									    	$dat['ID_FORMA_PAGO_HOTEL_ORIGINAL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL_ORIGINAL']);
									    	$dat['moneda_hotel'] = utf8_encode($valor_hot['moneda_hotel']);
								    	    $dat['telefono_hotel'] = utf8_encode($valor_hot['telefono']);
											$dat['direccion_hotel'] = utf8_encode($valor_hot['direccion']);

											$dat['nombre_ciudad_hotel'] = utf8_encode($nombre_ciudad_hot);//xxxxxxxxxxxxxxxxx
											$cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
										    $dat['estado_hotel'] = $cod_ciudad_estado;
										    
										    $dat['cp_ho'] = '';  //no existe el cp en gds_hoteles
									    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
									    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada_hotel']);
									    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida_hotel']);
									    	$dat['fecha_entrada_original'] = utf8_encode($valor_hot['fecha_entrada_hotel_original']);
								    	    $dat['fecha_salida_original'] = utf8_encode($valor_hot['fecha_salida_hotel_original']);
								    	    $dat['costo_hab_noche'] = utf8_encode($valor_hot['costo_hab_noche']);

								    	    $pais = $this->lib_ciudades_pais->ciudades($id_ciudad);
						    	    
								    	    if($pais == 'MEX'){

												$costo_hab_noche = (float)$valor->analisis57_cliente;
												
											}else{

												$costo_hab_noche = (float)$dat['costo_hab_noche'];

											}

						    	    		$noches = intval($valor_hot['noches']);

						    	   			$tarifa_neta = $costo_hab_noche * $noches;

						    	   			$dat['noches'] = utf8_encode($valor_hot['noches']);
						    	    		$dat['tarifa_neta'] = $tarifa_neta;
						    	    		$dat['iva_hot'] = utf8_encode($valor_hot['iva']); 
								            $dat['otros_imp_hot'] = utf8_encode($valor_hot['otros_imp']);  

								    	    $dat['rate_hot'] = utf8_encode($valor_hot['costo_hab_noche']);
									    	$dat['noches'] = utf8_encode($valor_hot['noches']);
									    	$dat['VendorInterfaceID'] = utf8_encode($valor_hot['id_cadena']);
								    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];

											$dat['BookingType'] = 2;
											$dat['propiedad'] =  $valor_hot['propiedad'];
											$dat['documento_hotel'] = utf8_encode($valor_hot['documento_hotel']);	

											$dat['TotalPaid'] = $tarifa_neta;
											$dat['numero_habitaciones'] = utf8_encode($valor_hot['numero_habitaciones']);


											  		if($pais == 'MEX'){


											  			$dat['DomesticInternational'] = 'D';
														

											  		}else{

											  			$dat['DomesticInternational'] = 'I';


											  		}

									    	array_push($array1, $dat);
									
											
									   
									   }

									   $autos_arr = $this->Mod_layouts_egencia_bookings_cadena->get_autos_num_bol($consecutivo_gds_general);

									    $cont2=0;
									    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
									    $cont2++;
									    	
									    	$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

									    	$dat['type_of_service'] = 'CAR';
										    $dat['codigo_producto'] = 'CAR';
									    	if($cont2 > 1){

									            $dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
									            $dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/

									        }else{

									        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
									        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/
									        }
									    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
									    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
											$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
									    	$id_ciudad = $valor_aut['routing_car'];
									    	$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
											$dat['routing_car'] = utf8_encode($routing_car);
											
											$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);
								    	    $dat['VendorCountryCode_car'] = utf8_encode($cod_ciudad_3caracteres);
								    	    $cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
										    $dat['estado_car'] = $cod_ciudad_estado;

									    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
									    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
									   		$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
									   		$dat['ID_FORMA_PAGO_AUTO_ORIGINAL'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO_ORIGINAL']);
									   		$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
									   		$dat['nombre_arrendadora2'] = utf8_encode($valor_aut['nombre_arrendadora2']);
											$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega_car']);
											$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge_car']);
											$dat['Delivery_Date_original'] = utf8_encode($valor_aut['fecha_entrega_car_original']);
									        $dat['Departure_date_original'] = utf8_encode($valor_aut['fecha_recoge_car_original']);
											$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
											$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
											$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
											$dat['tarifa_total'] = utf8_encode($valor_aut['tarifa_neta']);
											$dat['numero_autos'] = utf8_encode($valor_aut['numero_autos']);
											$dat['nombre_ciudad_renta'] = $routing_car; 
									        
									        $pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									        if($pais == 'MEX'){

												$dat['tarifa_diaria'] =  (float)$valor->analisis58_cliente;
												$tarifa_diaria =  (float)$valor->analisis58_cliente;
												
											}else{

												$dat['tarifa_diaria'] =  (float)$valor_aut['tarifa_diaria'];
												$tarifa_diaria =  (float)$valor_aut['tarifa_diaria'];

											}
									    	$dias = (float)$valor_aut['dias'];
									    	$tarifa_total = $tarifa_diaria * $dias;
									    	$dat['tarifa_neta'] = $tarifa_total;
									    	$dat['iva_car'] = utf8_encode($valor_aut['iva']);


											$dat['VendorInterfaceID'] = utf8_encode($valor_aut['id_arrendadora']);
											

										    $dat['BookingType'] = 3;
										    $dat['documento_car'] = utf8_encode($valor_aut['documento_car']);


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
						
						$ticket = utf8_encode($valor->ticket_number);
						$segmentos = $this->Mod_layouts_egencia_bookings_cadena->get_segmentos_ticket_number($ticket,$consecutivo_gds_general);
		    			$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

		    			$dat['Link_Key'] = $valor->codigo_detalle;	
						$dat['BookingID'] = $valor->codigo_detalle;	

						$booking_type = $this->lib_ega_booking_type->booking_type($valor->type_of_service);
						$dat['BookingType'] = $booking_type;

						if($booking_type == 9){

							$booking_type_code = $this->lib_ega_booking_type_code_cxs->booking_type_code($valor->type_of_service);

							$dat['BookingSubTypecxs'] = $booking_type_code;	


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
						    $tpo_serv = utf8_encode($valor->tpo_serv);


						    if($tpo_serv == '163' || $tpo_serv == '638' || $tpo_serv == '637' || $tpo_serv == '639' || $tpo_serv == '640' || $tpo_serv == '633' || $tpo_serv == '632' || $tpo_serv == '634' || $tpo_serv == '635'){


						    	$hoteles_arr_cxs = $this->Mod_layouts_egencia_bookings_cadena->get_cxs_hoteles($fac_numero,$id_serie);

								$cont=0;
							    foreach ($hoteles_arr_cxs as $clave_hot => $valor_hot) { //agrega hoteles
							    $cont++;

							    		//print_r($valor_hot);
							    		$dat['fecha_salida_vuelos_cxs'] = $valor_hot['fecha_entrada'];
							    		$dat['fecha_regreso_vuelos_cxs'] = $valor_hot['fecha_salida'];
								   		$dat['numero_bol_cxs'] = $valor_hot['consecutivo_reserv'];

								}


						    }

							
							if(substr($booking_type_code,0,2) != 'OT' ){ //excluye cargos por ervicio de otros servicios

								array_push($array1, $dat);  //solo los cxs seran reflejados,otros servicios no

							}

							
						
							
						}else{

							$dat['BookingSubTypecxs'] = '';

						}
						

						if(!in_array($consecutivo_gds_general, $array_consecutivo)){

									$ticket = utf8_encode($valor->ticket_number);
									$segmentos = $this->Mod_layouts_egencia_bookings_cadena->get_segmentos_ticket_number($ticket,$consecutivo_gds_general);
									$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);
									
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

									

									
										$hoteles_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$record_localizador,$consecutivo_gds_general,$fecha1,$fecha2,$fac_numero,$valor->TransactionType);

								
									
									$cont=0;
								    foreach ($hoteles_arr as $clave_hot => $valor_hot) { //agrega hoteles
								    $cont++;

								    	$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

								    		$dat['TIPO_HOTEL'] = 'RESERVADO';
									    	$dat['type_of_service'] = 'HOTEL';
											$dat['codigo_producto'] = 'HOTEL';
									    	//$rango_fechas = $this->lib_ciudades->ciudades($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);
									    	if($cont > 1){

										        $dat['Link_Key'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel'] + $cont);
										        $dat['BookingID'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel'] + $cont); //numero incrementable*/

									        }else{

									        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel']);
									        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_hot['fecha_entrada_hotel']); //numero incrementable*/

									        }

										    
											$dat['class_hotel'] = utf8_encode($valor_hot['class_hotel']);
									    	$dat['destination_hotel'] = utf8_encode($valor_hot['destination_hotel']);
											$dat['origin_hotel'] = utf8_encode($valor_hot['origin_hotel']);
									    	$id_ciudad = $valor_hot['id_ciudad'];

									    	$nombre_ciudad_hot = $this->lib_ciudades->ciudades($id_ciudad);
											$dat['routing_hotel'] = utf8_encode($nombre_ciudad_hot);

											$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);  
											
											
								    	    $dat['VendorCountryCode_hotel'] = utf8_encode($cod_ciudad_3caracteres);

									    	$dat['GVC_NOM_PAX_HOTEL'] = utf8_encode($valor_hot['GVC_NOM_PAX_HOTEL']);
									    	$dat['payment_number_hotel'] = utf8_encode($valor_hot['payment_number_hotel']);
									    	$dat['ID_FORMA_PAGO_HOTEL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL']);
									    	$dat['ID_FORMA_PAGO_HOTEL_ORIGINAL'] = utf8_encode($valor_hot['ID_FORMA_PAGO_HOTEL_ORIGINAL']);
									    	$dat['moneda_hotel'] = utf8_encode($valor_hot['moneda_hotel']);
								    	    $dat['telefono_hotel'] = utf8_encode($valor_hot['telefono']);
											$dat['direccion_hotel'] = utf8_encode($valor_hot['direccion']);

											$dat['nombre_ciudad_hotel'] = utf8_encode($nombre_ciudad_hot);//xxxxxxxxxxxxxxxxx
									
											$cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
										    $dat['estado_hotel'] = $cod_ciudad_estado;

										    $dat['cp_ho'] = '';  //no existe el cp en gds_hoteles
									    	$dat['nombre_hotel'] = utf8_encode($valor_hot['nombre_hotel']);
									    	$dat['fecha_entrada'] = utf8_encode($valor_hot['fecha_entrada_hotel']);
									    	$dat['fecha_salida'] = utf8_encode($valor_hot['fecha_salida_hotel']);
									    	$dat['fecha_entrada_original'] = utf8_encode($valor_hot['fecha_entrada_hotel_original']);
								    	    $dat['fecha_salida_original'] = utf8_encode($valor_hot['fecha_salida_hotel_original']);
								    	    $dat['costo_hab_noche'] = utf8_encode($valor_hot['costo_hab_noche']);

								    	    $pais = $this->lib_ciudades_pais->ciudades($id_ciudad);
						    	    
								    	    if($pais == 'MEX'){

												$costo_hab_noche = (float)$valor->analisis57_cliente;
												
											}else{

												$costo_hab_noche = (float)$dat['costo_hab_noche'];

											}

						    	    		$noches = intval($valor_hot['noches']);

						    	   			$tarifa_neta = $costo_hab_noche * $noches;

						    	   			$dat['noches'] = utf8_encode($valor_hot['noches']);
						    	    		$dat['tarifa_neta'] = $tarifa_neta;
						    	    		$dat['iva_hot'] = utf8_encode($valor_hot['iva']); 
								            $dat['otros_imp_hot'] = utf8_encode($valor_hot['otros_imp']); 

								    	    $dat['rate_hot'] = utf8_encode($valor_hot['costo_hab_noche']);
									    	$dat['noches'] = utf8_encode($valor_hot['noches']);
									    	$dat['VendorInterfaceID'] = utf8_encode($valor_hot['id_cadena']);
								    		$dat['buy_in_advance'] = $valor_hot['buy_in_advance'];

											$dat['BookingType'] = 2;
											$dat['propiedad'] =  $valor_hot['propiedad'];
											$dat['documento_hotel'] = utf8_encode($valor_hot['documento_hotel']);	

											$dat['TotalPaid'] = $tarifa_neta;
											$dat['numero_habitaciones'] = utf8_encode($valor_hot['numero_habitaciones']);

											  		if($pais == 'MEX'){


											  			$dat['DomesticInternational'] = 'D';
														

											  		}else{

											  			$dat['DomesticInternational'] = 'I';


											  		}

									    	array_push($array1, $dat);
									
											

							   	  }

								    $autos_arr = $this->Mod_layouts_egencia_bookings_cadena->get_autos_num_bol($consecutivo_gds_general);

								    $cont2=0;
								    foreach ($autos_arr as $clave_aut => $valor_aut) {  //agrega autos
								    $cont2++;

								    	$dat = data_general($valor,$segmentos,$fecha1,$fecha2,$id_serie);

								    	$dat['type_of_service'] = 'CAR';
									    $dat['codigo_producto'] = 'CAR';
								    	if($cont2 > 1){

								            $dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
								            $dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/

								        }else{

								        	$dat['Link_Key'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2);
								        	$dat['BookingID'] = $consecutivo_gds_general . ($valor_aut['fecha_recoge_car'] + $cont2); //numero incrementable*/
								        }
								    	$dat['class_car'] = utf8_encode($valor_aut['class_car']);
								    	$dat['destination_car'] = utf8_encode($valor_aut['destination_car']);
										$dat['origin_car'] = utf8_encode($valor_aut['origin_car']);
								    	$id_ciudad = $valor_aut['routing_car'];
								    	$routing_car = $this->lib_ciudades->ciudades($id_ciudad);
										$dat['routing_car'] = utf8_encode($routing_car);
										
										$cod_ciudad_3caracteres = $this->lib_ciudades_pais_detallado->ciudades($id_ciudad);
							    	    $dat['VendorCountryCode_car'] = utf8_encode($cod_ciudad_3caracteres);
							    	    $cod_ciudad_estado = $this->lib_ciudades_estado_detallado->ciudades($id_ciudad); 
									    $dat['estado_car'] = $cod_ciudad_estado;

								    	$dat['GVC_NOM_PAX_CAR'] = utf8_encode($valor_aut['GVC_NOM_PAX_CAR']);
								    	$dat['payment_number_car'] = utf8_encode($valor_aut['payment_number_car']);
								   		$dat['ID_FORMA_PAGO_AUTO'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO']);
								   		$dat['ID_FORMA_PAGO_AUTO_ORIGINAL'] = utf8_encode($valor_aut['ID_FORMA_PAGO_AUTO_ORIGINAL']);
								   		$dat['moneda_auto'] = utf8_encode($valor_aut['moneda_auto']);
								   		$dat['nombre_arrendadora2'] = utf8_encode($valor_aut['nombre_arrendadora2']);
										$dat['Delivery_Date'] = utf8_encode($valor_aut['fecha_entrega_car']);
										$dat['Departure_date'] = utf8_encode($valor_aut['fecha_recoge_car']);
										$dat['Delivery_Date_original'] = utf8_encode($valor_aut['fecha_entrega_car_original']);
									    $dat['Departure_date_original'] = utf8_encode($valor_aut['fecha_recoge_car_original']);
										$dat['Nr_days'] = utf8_encode($valor_aut['dias']);
										$dat['Place_delivery'] = utf8_encode($valor_aut['id_ciudad_entrega']);
										$dat['Place_delivery_back'] = utf8_encode($valor_aut['id_ciudad_recoge']);
										$dat['tarifa_total'] = utf8_encode($valor_aut['tarifa_neta']);
										$dat['numero_autos'] = utf8_encode($valor_aut['numero_autos']);
										$dat['nombre_ciudad_renta'] = $routing_car; 
									    
									    $pais = $this->lib_ciudades_pais->ciudades($id_ciudad);

									    if($pais == 'MEX'){

											$dat['tarifa_diaria'] =  (float)$valor->analisis58_cliente;
											$tarifa_diaria =  (float)$valor->analisis58_cliente;
											
										}else{

											$dat['tarifa_diaria'] =  (float)$valor_aut['tarifa_diaria'];
											$tarifa_diaria =  (float)$valor_aut['tarifa_diaria'];

										}
								    	$dias = (float)$valor_aut['dias'];
								    	$tarifa_total = $tarifa_diaria * $dias;
								    	$dat['tarifa_neta'] = $tarifa_total;
								    	$dat['iva_car'] = utf8_encode($valor_aut['iva']);

										$dat['VendorInterfaceID'] = utf8_encode($valor_aut['id_arrendadora']);
										

									    $dat['BookingType'] = 3;
									    $dat['documento_car'] = utf8_encode($valor_aut['documento_car']);


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
	    
				    //array_push($array_consecutivo, $consecutivo_gds_general);

					array_push($array_ticket_number, $valor->ticket_number);

			        
			   }  //fin del for principal


			  $log = $this->procesar_datos($array1,$consecutivo_ega);

			  //$this->genera_txt();

			  $id_us = $this->session->userdata('session_id');
	    	  $rest_local = $this->Mod_layouts_egencia_bookings_cadena->get_layouts_egencia_data_import_sp_local($id_us);
         	
			  $param_final['rep'] = $rest_local;
			  $param_final['log'] = $log;

	       	  echo json_encode($param_final);


         } //fin de la funcion



    public function procesar_datos($param_final,$consecutivo_ega){


    		$allrows = $param_final;
		
			$nueva_plantilla = $this->nueva_plantilla($allrows);
		    $id_us = $this->session->userdata('session_id');
		    
		    $this->Mod_layouts_egencia_bookings_cadena->delete_layouts_egencia_data_import_sp($id_us);

			if($consecutivo_ega != ''){
				$this->Mod_layouts_egencia_bookings_cadena->set_consecutivo($consecutivo_ega);
			}
		
			$array_car_reserv = array();
			$array_hotel_reserv = array();
			$arr_errores_log = [];

		 	$arr_errores_log_duplicate_records = [];
		 	$arr_errores_log_duplicate_records_hoteles = [];

			foreach($nueva_plantilla as $key => $value) {

				if($value['BookingType'] != 2 && $value['BookingType'] != 3){  // lo que no sea hotel

					
					$ultimo_id = $this->Mod_layouts_egencia_bookings_cadena->guardar_informacion_local($id_us,$value['Link_Key'],$value['BookingID'],$value['BookingType'],$value['BookingSubType'],$value['DocumentType'],$value['TransactionType'],$value['RecordLocator'],$value['InvoiceNumber'],$value['BranchName'],$value['BranchInterfaceID'],$value['BranchARCNumber'],$value['OutsideAgent'],$value['BookingAgent'],$value['InsideAgent'],$value['TicketingAgent'],$value['BookedOnline'],$value['AccountName'],$value['AccountInterfaceID'],$value['AccountType'],$value['VendorName'],$value['VendorInterfaceID'],$value['VendorCode'],$value['VendorAddress'],$value['VendorCity'],$value['VendorState'],$value['VendorZip'],$value['VendorCountryCode'],$value['VendorPhone'],$value['AirlineNumber'],$value['ReasonCode'],$value['ReasonDescription'],$value['IssuedDate'],$value['BookingDate'],$value['StartDate'],$value['EndDate'],$value['NumberofUnits'],$value['BookingDuration'],$value['CommissionAmount'],$value['CommissionRate'],$value['FullFare'],$value['LowFare'],$value['BaseFare'],$value['Tax1Amount'],$value['Tax2Amount'],$value['Tax3Amount'],$value['Tax4Amount'],$value['GSTAmount'],$value['QSTAmount'],$value['TotalTaxes'],$value['TotalPaid'],$value['PenaltyAmount'],$value['Rate'],$value['RateType'],$value['CurrencyCode'],$value['FormofPayment'],$value['PaymentNumber'],$value['TravelerName'],$value['DocumentNumber'],$value['OriginalDocumentNumber'],$value['Routing'],$value['Origin'],$value['Destination'],$value['DomesticInternational'],$value['Class'],$value['TourCode'],$value['TicketDesignator'],$value['ClientRemarks'],$value['Department'],$value['GSANumber'],$value['PurchaseOrder'],$value['CostCenter'],$value['CostCenterdescription'],$value['SBU'],$value['EmployeeID'],$value['BillableNonBillable'], $value['ProjectCode'],$value['ReasonforTravel'],$value['DepartmentDescription'],$value['CustomField9'],$value['CustomField10'], $value['GroupID'],$value['InPolicy'],$value['TravelerEmail'],$value['NegotiatedFare'],$value['boleto_aereo'],$value['consecutivo_gen'],$value['consecutivo_vuelo'],$value['analisis1_cliente'],$value['analisis2_cliente'],$value['analisis3_cliente'],$value['analisis4_cliente'],$value['analisis5_cliente'],$value['analisis6_cliente'],$value['analisis7_cliente'],$value['analisis8_cliente'],$value['analisis9_cliente'],$value['analisis10_cliente'],$value['analisis11_cliente'],$value['analisis12_cliente'],$value['analisis13_cliente'],$value['analisis14_cliente'],$value['analisis15_cliente'],$value['analisis16_cliente'],$value['analisis17_cliente'],$value['analisis18_cliente'],$value['analisis19_cliente'],$value['analisis20_cliente'],$value['analisis21_cliente'],$value['analisis22_cliente'],$value['analisis23_cliente'],$value['analisis24_cliente'],$value['analisis25_cliente'],$value['analisis26_cliente'],$value['analisis27_cliente'],$value['analisis28_cliente'],$value['analisis29_cliente'],$value['analisis30_cliente'],$value['analisis31_cliente'],$value['analisis32_cliente'],$value['analisis33_cliente'],$value['analisis34_cliente'],$value['analisis35_cliente'],$value['analisis36_cliente'],$value['analisis37_cliente'],$value['analisis38_cliente'],$value['analisis39_cliente'],$value['analisis40_cliente'],$value['analisis41_cliente'],$value['analisis42_cliente'],$value['analisis43_cliente'],$value['analisis44_cliente'],$value['analisis45_cliente'],$value['analisis46_cliente'],$value['analisis47_cliente'],$value['analisis48_cliente'],$value['analisis49_cliente'],$value['analisis50_cliente'],$value['analisis51_cliente'],$value['analisis52_cliente'],$value['analisis53_cliente'],$value['analisis54_cliente'],$value['analisis55_cliente'],$value['analisis56_cliente'],$value['analisis57_cliente'],$value['analisis58_cliente'],$value['analisis59_cliente'],$value['analisis60_cliente'],$value['analisis61_cliente'],$value['analisis62_cliente'],$value['analisis63_cliente'],$value['analisis64_cliente'],$value['analisis65_cliente'],$value['analisis66_cliente'],$value['analisis67_cliente'],$value['analisis68_cliente'],$value['analisis69_cliente'],$value['analisis70_cliente'],$value['analisis71_cliente'],$value['analisis72_cliente'],$value['analisis73_cliente'],$value['analisis74_cliente'],$value['analisis75_cliente'],$value['analisis76_cliente'],$value['analisis77_cliente'],$value['analisis78_cliente'],$value['analisis79_cliente'],$value['analisis80_cliente'],$value['analisis81_cliente'],$value['analisis82_cliente'],$value['analisis83_cliente'],$value['analisis84_cliente'],$value['analisis85_cliente'],$value['analisis86_cliente'],$value['analisis87_cliente'],$value['analisis88_cliente'],$value['analisis89_cliente'],$value['analisis90_cliente'],$value['analisis91_cliente'],$value['analisis92_cliente'],$value['analisis93_cliente'],$value['analisis94_cliente'],$value['analisis95_cliente'],$value['analisis96_cliente'],$value['analisis97_cliente'],$value['analisis98_cliente'],$value['analisis99_cliente'],$value['analisis100_cliente']);

					$array_data = $this->lib_ega_log->procesar_errores($value,$arr_errores_log_duplicate_records,$arr_errores_log_duplicate_records_hoteles,$ultimo_id);
					$arr_errores_log_duplicate_records = $array_data['arr_errores_log_duplicate_records'];
				  	$arr_errores_log_duplicate_records_hoteles = $array_data['arr_errores_log_duplicate_records_hoteles'];
					$error_msn = $array_data['msn'];

					array_push($arr_errores_log, $error_msn);

				}

				

			}

			foreach($nueva_plantilla as $key => $value) {

				if($value['BookingType'] == 3){  // lo que no sea hotel

				  $val_car_res = LTRIM(RTRIM($value['RecordLocator'])).LTRIM(RTRIM($value['BookingType'])).LTRIM(RTRIM($value['TravelerName'])).LTRIM(RTRIM($value['DocumentNumber'])).$value['TransactionType'].$value['StartDate'].$value['EndDate'];

				  if( !in_array($val_car_res, $array_car_reserv)){ 

					$ultimo_id = $this->Mod_layouts_egencia_bookings_cadena->guardar_informacion_local($id_us,$value['Link_Key'],$value['BookingID'],$value['BookingType'],$value['BookingSubType'],$value['DocumentType'],$value['TransactionType'],$value['RecordLocator'],$value['InvoiceNumber'],$value['BranchName'],$value['BranchInterfaceID'],$value['BranchARCNumber'],$value['OutsideAgent'],$value['BookingAgent'],$value['InsideAgent'],$value['TicketingAgent'],$value['BookedOnline'],$value['AccountName'],$value['AccountInterfaceID'],$value['AccountType'],$value['VendorName'],$value['VendorInterfaceID'],$value['VendorCode'],$value['VendorAddress'],$value['VendorCity'],$value['VendorState'],$value['VendorZip'],$value['VendorCountryCode'],$value['VendorPhone'],$value['AirlineNumber'],$value['ReasonCode'],$value['ReasonDescription'],$value['IssuedDate'],$value['BookingDate'],$value['StartDate'],$value['EndDate'],$value['NumberofUnits'],$value['BookingDuration'],$value['CommissionAmount'],$value['CommissionRate'],$value['FullFare'],$value['LowFare'],$value['BaseFare'],$value['Tax1Amount'],$value['Tax2Amount'],$value['Tax3Amount'],$value['Tax4Amount'],$value['GSTAmount'],$value['QSTAmount'],$value['TotalTaxes'],$value['TotalPaid'],$value['PenaltyAmount'],$value['Rate'],$value['RateType'],$value['CurrencyCode'],$value['FormofPayment'],$value['PaymentNumber'],$value['TravelerName'],$value['DocumentNumber'],$value['OriginalDocumentNumber'],$value['Routing'],$value['Origin'],$value['Destination'],$value['DomesticInternational'],$value['Class'],$value['TourCode'],$value['TicketDesignator'],$value['ClientRemarks'],$value['Department'],$value['GSANumber'],$value['PurchaseOrder'],$value['CostCenter'],$value['CostCenterdescription'],$value['SBU'],$value['EmployeeID'],$value['BillableNonBillable'], $value['ProjectCode'],$value['ReasonforTravel'],$value['DepartmentDescription'],$value['CustomField9'],$value['CustomField10'], $value['GroupID'],$value['InPolicy'],$value['TravelerEmail'],$value['NegotiatedFare'],$value['boleto_aereo'],$value['consecutivo_gen'],$value['consecutivo_vuelo'],$value['analisis1_cliente'],$value['analisis2_cliente'],$value['analisis3_cliente'],$value['analisis4_cliente'],$value['analisis5_cliente'],$value['analisis6_cliente'],$value['analisis7_cliente'],$value['analisis8_cliente'],$value['analisis9_cliente'],$value['analisis10_cliente'],$value['analisis11_cliente'],$value['analisis12_cliente'],$value['analisis13_cliente'],$value['analisis14_cliente'],$value['analisis15_cliente'],$value['analisis16_cliente'],$value['analisis17_cliente'],$value['analisis18_cliente'],$value['analisis19_cliente'],$value['analisis20_cliente'],$value['analisis21_cliente'],$value['analisis22_cliente'],$value['analisis23_cliente'],$value['analisis24_cliente'],$value['analisis25_cliente'],$value['analisis26_cliente'],$value['analisis27_cliente'],$value['analisis28_cliente'],$value['analisis29_cliente'],$value['analisis30_cliente'],$value['analisis31_cliente'],$value['analisis32_cliente'],$value['analisis33_cliente'],$value['analisis34_cliente'],$value['analisis35_cliente'],$value['analisis36_cliente'],$value['analisis37_cliente'],$value['analisis38_cliente'],$value['analisis39_cliente'],$value['analisis40_cliente'],$value['analisis41_cliente'],$value['analisis42_cliente'],$value['analisis43_cliente'],$value['analisis44_cliente'],$value['analisis45_cliente'],$value['analisis46_cliente'],$value['analisis47_cliente'],$value['analisis48_cliente'],$value['analisis49_cliente'],$value['analisis50_cliente'],$value['analisis51_cliente'],$value['analisis52_cliente'],$value['analisis53_cliente'],$value['analisis54_cliente'],$value['analisis55_cliente'],$value['analisis56_cliente'],$value['analisis57_cliente'],$value['analisis58_cliente'],$value['analisis59_cliente'],$value['analisis60_cliente'],$value['analisis61_cliente'],$value['analisis62_cliente'],$value['analisis63_cliente'],$value['analisis64_cliente'],$value['analisis65_cliente'],$value['analisis66_cliente'],$value['analisis67_cliente'],$value['analisis68_cliente'],$value['analisis69_cliente'],$value['analisis70_cliente'],$value['analisis71_cliente'],$value['analisis72_cliente'],$value['analisis73_cliente'],$value['analisis74_cliente'],$value['analisis75_cliente'],$value['analisis76_cliente'],$value['analisis77_cliente'],$value['analisis78_cliente'],$value['analisis79_cliente'],$value['analisis80_cliente'],$value['analisis81_cliente'],$value['analisis82_cliente'],$value['analisis83_cliente'],$value['analisis84_cliente'],$value['analisis85_cliente'],$value['analisis86_cliente'],$value['analisis87_cliente'],$value['analisis88_cliente'],$value['analisis89_cliente'],$value['analisis90_cliente'],$value['analisis91_cliente'],$value['analisis92_cliente'],$value['analisis93_cliente'],$value['analisis94_cliente'],$value['analisis95_cliente'],$value['analisis96_cliente'],$value['analisis97_cliente'],$value['analisis98_cliente'],$value['analisis99_cliente'],$value['analisis100_cliente']);

					$array_data = $this->lib_ega_log->procesar_errores($value,$arr_errores_log_duplicate_records,$arr_errores_log_duplicate_records_hoteles,$ultimo_id);
					$arr_errores_log_duplicate_records = $array_data['arr_errores_log_duplicate_records'];
				  	$arr_errores_log_duplicate_records_hoteles = $array_data['arr_errores_log_duplicate_records_hoteles'];
					$error_msn = $array_data['msn'];

					array_push($arr_errores_log, $error_msn);

					array_push($array_car_reserv, $val_car_res);

				  } //fin in array

				}
			
			}

			foreach($nueva_plantilla as $key => $value) {

				if($value['BookingType'] == 2 && $value['TIPO_HOTEL'] == 'FACTURADO'){  // todo los hoteles

					$val_hot_res = LTRIM(RTRIM($value['RecordLocator'])).LTRIM(RTRIM($value['BookingType'])).LTRIM(RTRIM($value['TravelerName'])).LTRIM(RTRIM($value['DocumentNumber'])).$value['TransactionType'].$value['StartDate'].$value['EndDate'];

					if( !in_array($val_hot_res, $array_hotel_reserv)){ 

					
						$ultimo_id = $this->Mod_layouts_egencia_bookings_cadena->guardar_informacion_local($id_us,$value['Link_Key'],$value['BookingID'],$value['BookingType'],$value['BookingSubType'],$value['DocumentType'],$value['TransactionType'],$value['RecordLocator'],$value['InvoiceNumber'],$value['BranchName'],$value['BranchInterfaceID'],$value['BranchARCNumber'],$value['OutsideAgent'],$value['BookingAgent'],$value['InsideAgent'],$value['TicketingAgent'],$value['BookedOnline'],$value['AccountName'],$value['AccountInterfaceID'],$value['AccountType'],$value['VendorName'],$value['VendorInterfaceID'],$value['VendorCode'],$value['VendorAddress'],$value['VendorCity'],$value['VendorState'],$value['VendorZip'],$value['VendorCountryCode'],$value['VendorPhone'],$value['AirlineNumber'],$value['ReasonCode'],$value['ReasonDescription'],$value['IssuedDate'],$value['BookingDate'],$value['StartDate'],$value['EndDate'],$value['NumberofUnits'],$value['BookingDuration'],$value['CommissionAmount'],$value['CommissionRate'],$value['FullFare'],$value['LowFare'],$value['BaseFare'],$value['Tax1Amount'],$value['Tax2Amount'],$value['Tax3Amount'],$value['Tax4Amount'],$value['GSTAmount'],$value['QSTAmount'],$value['TotalTaxes'],$value['TotalPaid'],$value['PenaltyAmount'],$value['Rate'],$value['RateType'],$value['CurrencyCode'],$value['FormofPayment'],$value['PaymentNumber'],$value['TravelerName'],$value['DocumentNumber'],$value['OriginalDocumentNumber'],$value['Routing'],$value['Origin'],$value['Destination'],$value['DomesticInternational'],$value['Class'],$value['TourCode'],$value['TicketDesignator'],$value['ClientRemarks'],$value['Department'],$value['GSANumber'],$value['PurchaseOrder'],$value['CostCenter'],$value['CostCenterdescription'],$value['SBU'],$value['EmployeeID'],$value['BillableNonBillable'], $value['ProjectCode'],$value['ReasonforTravel'],$value['DepartmentDescription'],$value['CustomField9'],$value['CustomField10'], $value['GroupID'],$value['InPolicy'],$value['TravelerEmail'],$value['NegotiatedFare'],$value['boleto_aereo'],$value['consecutivo_gen'],$value['consecutivo_vuelo'],$value['analisis1_cliente'],$value['analisis2_cliente'],$value['analisis3_cliente'],$value['analisis4_cliente'],$value['analisis5_cliente'],$value['analisis6_cliente'],$value['analisis7_cliente'],$value['analisis8_cliente'],$value['analisis9_cliente'],$value['analisis10_cliente'],$value['analisis11_cliente'],$value['analisis12_cliente'],$value['analisis13_cliente'],$value['analisis14_cliente'],$value['analisis15_cliente'],$value['analisis16_cliente'],$value['analisis17_cliente'],$value['analisis18_cliente'],$value['analisis19_cliente'],$value['analisis20_cliente'],$value['analisis21_cliente'],$value['analisis22_cliente'],$value['analisis23_cliente'],$value['analisis24_cliente'],$value['analisis25_cliente'],$value['analisis26_cliente'],$value['analisis27_cliente'],$value['analisis28_cliente'],$value['analisis29_cliente'],$value['analisis30_cliente'],$value['analisis31_cliente'],$value['analisis32_cliente'],$value['analisis33_cliente'],$value['analisis34_cliente'],$value['analisis35_cliente'],$value['analisis36_cliente'],$value['analisis37_cliente'],$value['analisis38_cliente'],$value['analisis39_cliente'],$value['analisis40_cliente'],$value['analisis41_cliente'],$value['analisis42_cliente'],$value['analisis43_cliente'],$value['analisis44_cliente'],$value['analisis45_cliente'],$value['analisis46_cliente'],$value['analisis47_cliente'],$value['analisis48_cliente'],$value['analisis49_cliente'],$value['analisis50_cliente'],$value['analisis51_cliente'],$value['analisis52_cliente'],$value['analisis53_cliente'],$value['analisis54_cliente'],$value['analisis55_cliente'],$value['analisis56_cliente'],$value['analisis57_cliente'],$value['analisis58_cliente'],$value['analisis59_cliente'],$value['analisis60_cliente'],$value['analisis61_cliente'],$value['analisis62_cliente'],$value['analisis63_cliente'],$value['analisis64_cliente'],$value['analisis65_cliente'],$value['analisis66_cliente'],$value['analisis67_cliente'],$value['analisis68_cliente'],$value['analisis69_cliente'],$value['analisis70_cliente'],$value['analisis71_cliente'],$value['analisis72_cliente'],$value['analisis73_cliente'],$value['analisis74_cliente'],$value['analisis75_cliente'],$value['analisis76_cliente'],$value['analisis77_cliente'],$value['analisis78_cliente'],$value['analisis79_cliente'],$value['analisis80_cliente'],$value['analisis81_cliente'],$value['analisis82_cliente'],$value['analisis83_cliente'],$value['analisis84_cliente'],$value['analisis85_cliente'],$value['analisis86_cliente'],$value['analisis87_cliente'],$value['analisis88_cliente'],$value['analisis89_cliente'],$value['analisis90_cliente'],$value['analisis91_cliente'],$value['analisis92_cliente'],$value['analisis93_cliente'],$value['analisis94_cliente'],$value['analisis95_cliente'],$value['analisis96_cliente'],$value['analisis97_cliente'],$value['analisis98_cliente'],$value['analisis99_cliente'],$value['analisis100_cliente']);

						$array_data = $this->lib_ega_log->procesar_errores($value,$arr_errores_log_duplicate_records,$arr_errores_log_duplicate_records_hoteles,$ultimo_id);
						$arr_errores_log_duplicate_records = $array_data['arr_errores_log_duplicate_records'];
					  	$arr_errores_log_duplicate_records_hoteles = $array_data['arr_errores_log_duplicate_records_hoteles'];
						$error_msn = $array_data['msn'];

						array_push($arr_errores_log, $error_msn);

						array_push($array_hotel_reserv, $val_hot_res);

					}//fin in array

						
				} //fin if validacion

			}

			foreach($nueva_plantilla as $key => $value) {

				if($value['BookingType'] == 2 && $value['TIPO_HOTEL'] == 'RESERVADO'){  // todo los hoteles

					$val_hot_res = LTRIM(RTRIM($value['RecordLocator'])).LTRIM(RTRIM($value['BookingType'])).LTRIM(RTRIM($value['TravelerName'])).LTRIM(RTRIM($value['DocumentNumber'])).$value['TransactionType'].$value['StartDate'].$value['EndDate'];

					if( !in_array($val_hot_res, $array_hotel_reserv)){ 

						$ultimo_id = $this->Mod_layouts_egencia_bookings_cadena->guardar_informacion_local($id_us,$value['Link_Key'],$value['BookingID'],$value['BookingType'],$value['BookingSubType'],$value['DocumentType'],$value['TransactionType'],$value['RecordLocator'],$value['InvoiceNumber'],$value['BranchName'],$value['BranchInterfaceID'],$value['BranchARCNumber'],$value['OutsideAgent'],$value['BookingAgent'],$value['InsideAgent'],$value['TicketingAgent'],$value['BookedOnline'],$value['AccountName'],$value['AccountInterfaceID'],$value['AccountType'],$value['VendorName'],$value['VendorInterfaceID'],$value['VendorCode'],$value['VendorAddress'],$value['VendorCity'],$value['VendorState'],$value['VendorZip'],$value['VendorCountryCode'],$value['VendorPhone'],$value['AirlineNumber'],$value['ReasonCode'],$value['ReasonDescription'],$value['IssuedDate'],$value['BookingDate'],$value['StartDate'],$value['EndDate'],$value['NumberofUnits'],$value['BookingDuration'],$value['CommissionAmount'],$value['CommissionRate'],$value['FullFare'],$value['LowFare'],$value['BaseFare'],$value['Tax1Amount'],$value['Tax2Amount'],$value['Tax3Amount'],$value['Tax4Amount'],$value['GSTAmount'],$value['QSTAmount'],$value['TotalTaxes'],$value['TotalPaid'],$value['PenaltyAmount'],$value['Rate'],$value['RateType'],$value['CurrencyCode'],$value['FormofPayment'],$value['PaymentNumber'],$value['TravelerName'],$value['DocumentNumber'],$value['OriginalDocumentNumber'],$value['Routing'],$value['Origin'],$value['Destination'],$value['DomesticInternational'],$value['Class'],$value['TourCode'],$value['TicketDesignator'],$value['ClientRemarks'],$value['Department'],$value['GSANumber'],$value['PurchaseOrder'],$value['CostCenter'],$value['CostCenterdescription'],$value['SBU'],$value['EmployeeID'],$value['BillableNonBillable'], $value['ProjectCode'],$value['ReasonforTravel'],$value['DepartmentDescription'],$value['CustomField9'],$value['CustomField10'], $value['GroupID'],$value['InPolicy'],$value['TravelerEmail'],$value['NegotiatedFare'],$value['boleto_aereo'],$value['consecutivo_gen'],$value['consecutivo_vuelo'],$value['analisis1_cliente'],$value['analisis2_cliente'],$value['analisis3_cliente'],$value['analisis4_cliente'],$value['analisis5_cliente'],$value['analisis6_cliente'],$value['analisis7_cliente'],$value['analisis8_cliente'],$value['analisis9_cliente'],$value['analisis10_cliente'],$value['analisis11_cliente'],$value['analisis12_cliente'],$value['analisis13_cliente'],$value['analisis14_cliente'],$value['analisis15_cliente'],$value['analisis16_cliente'],$value['analisis17_cliente'],$value['analisis18_cliente'],$value['analisis19_cliente'],$value['analisis20_cliente'],$value['analisis21_cliente'],$value['analisis22_cliente'],$value['analisis23_cliente'],$value['analisis24_cliente'],$value['analisis25_cliente'],$value['analisis26_cliente'],$value['analisis27_cliente'],$value['analisis28_cliente'],$value['analisis29_cliente'],$value['analisis30_cliente'],$value['analisis31_cliente'],$value['analisis32_cliente'],$value['analisis33_cliente'],$value['analisis34_cliente'],$value['analisis35_cliente'],$value['analisis36_cliente'],$value['analisis37_cliente'],$value['analisis38_cliente'],$value['analisis39_cliente'],$value['analisis40_cliente'],$value['analisis41_cliente'],$value['analisis42_cliente'],$value['analisis43_cliente'],$value['analisis44_cliente'],$value['analisis45_cliente'],$value['analisis46_cliente'],$value['analisis47_cliente'],$value['analisis48_cliente'],$value['analisis49_cliente'],$value['analisis50_cliente'],$value['analisis51_cliente'],$value['analisis52_cliente'],$value['analisis53_cliente'],$value['analisis54_cliente'],$value['analisis55_cliente'],$value['analisis56_cliente'],$value['analisis57_cliente'],$value['analisis58_cliente'],$value['analisis59_cliente'],$value['analisis60_cliente'],$value['analisis61_cliente'],$value['analisis62_cliente'],$value['analisis63_cliente'],$value['analisis64_cliente'],$value['analisis65_cliente'],$value['analisis66_cliente'],$value['analisis67_cliente'],$value['analisis68_cliente'],$value['analisis69_cliente'],$value['analisis70_cliente'],$value['analisis71_cliente'],$value['analisis72_cliente'],$value['analisis73_cliente'],$value['analisis74_cliente'],$value['analisis75_cliente'],$value['analisis76_cliente'],$value['analisis77_cliente'],$value['analisis78_cliente'],$value['analisis79_cliente'],$value['analisis80_cliente'],$value['analisis81_cliente'],$value['analisis82_cliente'],$value['analisis83_cliente'],$value['analisis84_cliente'],$value['analisis85_cliente'],$value['analisis86_cliente'],$value['analisis87_cliente'],$value['analisis88_cliente'],$value['analisis89_cliente'],$value['analisis90_cliente'],$value['analisis91_cliente'],$value['analisis92_cliente'],$value['analisis93_cliente'],$value['analisis94_cliente'],$value['analisis95_cliente'],$value['analisis96_cliente'],$value['analisis97_cliente'],$value['analisis98_cliente'],$value['analisis99_cliente'],$value['analisis100_cliente']);

							$array_data = $this->lib_ega_log->procesar_errores($value,$arr_errores_log_duplicate_records,$arr_errores_log_duplicate_records_hoteles,$ultimo_id);
							$arr_errores_log_duplicate_records = $array_data['arr_errores_log_duplicate_records'];
						  	$arr_errores_log_duplicate_records_hoteles = $array_data['arr_errores_log_duplicate_records_hoteles'];
							$error_msn = $array_data['msn'];

							array_push($arr_errores_log, $error_msn);
					
							array_push($array_hotel_reserv, $val_hot_res);

					}

				}

			}

		    

			return $arr_errores_log;

    } //fin funcion

    public function eliminar_BookingID(){

    	$id_us = $this->session->userdata('session_id');
    	$BookingID = $this->input->post('BookingID');
    	$this->Mod_layouts_egencia_bookings_cadena->eliminar_BookingID($BookingID,$id_us);

    	echo json_encode(1);
    		
    }

    public function genera_txt(){

    	$allrows = $this->input->post('allrows');
    	$allrows = json_decode($allrows); 
    	$id_us = $this->session->userdata('session_id');

		$archivo = fopen($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/archivos_egencia_lay_data_import_sp/bookings_'.$id_us.'.txt', "w+");
		
		$header = ['Link_Key','BookingID','BookingType','BookingSubType','DocumentType','TransactionType','RecordLocator','InvoiceNumber','BranchName','BranchInterfaceID','BranchARCNumber','OutsideAgent','BookingAgent','InsideAgent','TicketingAgent','BookedOnline','AccountName','AccountInterfaceID','AccountType','VendorName','VendorInterfaceID','VendorCode','VendorAddress','VendorCity','VendorState','VendorZip','VendorCountryCode','VendorPhone','AirlineNumber','ReasonCode','ReasonDescription','IssuedDate','BookingDate','StartDate','EndDate','NumberofUnits','BookingDuration','CommissionAmount','CommissionRate','FullFare','LowFare','BaseFare','Tax1Amount','Tax2Amount','Tax3Amount','Tax4Amount','GSTAmount','QSTAmount','TotalTaxes','TotalPaid','PenaltyAmount','Rate','RateType','CurrencyCode','FormofPayment','PaymentNumber','TravelerName','DocumentNumber','OriginalDocumentNumber','Routing','Origin','Destination','DomesticInternational','Class','TourCode','TicketDesignator','ClientRemarks','Department','GSANumber','PurchaseOrder','CostCenter','CostCenterdescription','SBU','EmployeeID','BillableNonBillable','ProjectCode','ReasonforTravel','DepartmentDescription','CustomField9','CustomField10','GroupID','InPolicy','TravelerEmail','NegotiatedFare'];

		$str_body = '';
		foreach ($header as $key => $value) {
			
					$str_body = $str_body . $value."	";

				}

		fwrite($archivo, $str_body);


		    	foreach($allrows as $value) { //validacioneseco

	      				$dat['Link_Key'] = $value->Link_Key2;
	      				$dat['BookingID'] = $value->BookingID2;
	      				$dat['BookingType'] = $value->BookingType;
	      				$dat['BookingSubType'] = $value->BookingSubType;
	      				$dat['DocumentType'] = $value->DocumentType;
	      				$dat['TransactionType'] = $value->TransactionType;
	      				$dat['RecordLocator'] = $value->RecordLocator;
	      				$dat['InvoiceNumber'] = $value->InvoiceNumber;
	      				$dat['BranchName'] = $value->BranchName;
	      				$dat['BranchInterfaceID'] = $value->BranchInterfaceID;
	      				$dat['BranchARCNumber'] = $value->BranchARCNumber;
	      				$dat['OutsideAgent'] = $value->OutsideAgent;
	      				$dat['BookingAgent'] = $value->BookingAgent;
	      				$dat['InsideAgent'] = $value->InsideAgent;
	      				$dat['TicketingAgent'] = $value->TicketingAgent;
	      				$dat['BookedOnline'] = $value->BookedOnline;
	      				$dat['AccountName'] = $value->AccountName;
	      				$dat['AccountInterfaceID'] = $value->AccountInterfaceID;
	      				$dat['AccountType'] = $value->AccountType;
	      				$dat['VendorName'] = $value->VendorName;
	      				$dat['VendorInterfaceID'] = $value->VendorInterfaceID;
	      				$dat['VendorCode'] = $value->VendorCode;
	      				$dat['VendorAddress'] = $value->VendorAddress;
	      				$dat['VendorCity'] = $value->VendorCity;
	      				$dat['VendorState'] = $value->VendorState;
	      				$dat['VendorZip'] = $value->VendorZip;
	      				$dat['VendorCountryCode'] = $value->VendorCountryCode;
	      				$dat['VendorPhone'] = $value->VendorPhone;
	      				$dat['AirlineNumber'] = $value->AirlineNumber;
	      				$dat['ReasonCode'] = $value->ReasonCode;
	      				$dat['ReasonDescription'] = $value->ReasonDescription;
	      				$dat['IssuedDate'] = $value->IssuedDate;
	      				$dat['BookingDate'] = $value->BookingDate;
	      				$dat['StartDate'] = $value->StartDate;
	      				$dat['EndDate'] = $value->EndDate;
	      				$dat['NumberofUnits'] = $value->NumberofUnits;
	      				$dat['BookingDuration'] = $value->BookingDuration;
	      				$dat['CommissionAmount'] = $value->CommissionAmount;
	      				$dat['CommissionRate'] = $value->CommissionRate;
	      				$dat['FullFare'] = $value->FullFare;
	      				$dat['LowFare'] = $value->LowFare;
	      				$dat['BaseFare'] = $value->BaseFare;
	      				$dat['Tax1Amount'] = $value->Tax1Amount;
	      				$dat['Tax2Amount'] = $value->Tax2Amount;
	      				$dat['Tax3Amount'] = $value->Tax3Amount;
	      				$dat['Tax4Amount'] = $value->Tax4Amount;
	      				$dat['GSTAmount'] = $value->GSTAmount;
	      				$dat['QSTAmount'] = $value->QSTAmount;
	      				$dat['TotalTaxes'] = $value->TotalTaxes;
	      				$dat['TotalPaid'] = $value->TotalPaid;
	      				$dat['PenaltyAmount'] = $value->PenaltyAmount;
	      				$dat['Rate'] = $value->Rate;
	      				$dat['RateType'] = $value->RateType;
	      				$dat['CurrencyCode'] = $value->CurrencyCode;
	      				$dat['FormofPayment'] = $value->FormofPayment;
	      				$dat['PaymentNumber'] = $value->PaymentNumber;
	      				$dat['TravelerName'] = $value->TravelerName;
	      				$dat['DocumentNumber'] = $value->DocumentNumber;
	      				$dat['OriginalDocumentNumber'] = $value->OriginalDocumentNumber;
	      				$dat['Routing'] = $value->Routing;
	      				$dat['Origin'] = $value->Origin;
	      				$dat['Destination'] = $value->Destination;
	      				$dat['DomesticInternational'] = $value->DomesticInternational;
	      				$dat['Class'] = $value->Class;
	      				$dat['TourCode'] = $value->TourCode;
	      				$dat['TicketDesignator'] = $value->TicketDesignator;
	      				$dat['ClientRemarks'] = $value->ClientRemarks;
	      				$dat['Department'] = $value->Department;
	      				$dat['GSANumber'] = $value->GSANumber;
	      				$dat['PurchaseOrder'] = $value->PurchaseOrder;
	      				$dat['CostCenter'] = $value->CostCenter;
	      				$dat['CostCenterdescription'] = $value->CostCenterdescription;
	      				$dat['SBU'] = $value->SBU;
	      				$dat['EmployeeID'] = $value->EmployeeID;
	      				$dat['BillableNonBillable'] = $value->BillableNonBillable;
	      				$dat['ProjectCode'] = $value->ProjectCode;
	      				$dat['ReasonforTravel'] = $value->ReasonforTravel;
	      				$dat['DepartmentDescription'] = $value->DepartmentDescription;
	      				$dat['CustomField9'] = $value->CustomField9;
	      				$dat['CustomField10'] = $value->CustomField10;
	      				$dat['GroupID'] = $value->GroupID;
	      				$dat['InPolicy'] = $value->InPolicy;
	      				$dat['TravelerEmail'] = $value->TravelerEmail;
	      				$dat['NegotiatedFare'] = $value->NegotiatedFare;

			    		fwrite($archivo,"\r\n");

			    		$str_body = '';
			    		foreach($dat as $value2) {

			    			$str_body = $str_body . $value2."	";

			    		}

			    		fwrite($archivo, $str_body);

			    	
		    	}

		fclose($archivo);

    }

    public function nueva_plantilla($rep){

    	function cortar_string ($string, $largo) { 
		   $marca = "<!--corte-->"; 
		 
		   if (strlen($string) > $largo) { 
		        
		       $string = wordwrap($string, $largo, $marca); 
		       $string = explode($marca, $string); 
		       $string = $string[0]; 
		   } 
		   return $string; 
		 
		} 

    	function eliminar_acentos2($cadena){
					
					//Reemplazamos la A y a
					$cadena = str_replace(
					array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
					array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
					$cadena
					);

					//Reemplazamos la E y e
					$cadena = str_replace(
					array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
					array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
					$cadena );

					//Reemplazamos la I y i
					$cadena = str_replace(
					array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
					array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
					$cadena );

					//Reemplazamos la O y o
					$cadena = str_replace(
					array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
					array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
					$cadena );

					//Reemplazamos la U y u
					$cadena = str_replace(
					array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
					array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
					$cadena );

					//Reemplazamos la N, n, C y c
					$cadena = str_replace(
					array('Ñ', 'ñ', 'Ç', 'ç'),
					array('N', 'n', 'C', 'c'),
					$cadena
					);
					
					return $cadena;
			}

    	$nueva_plantilla = [];

		foreach ($rep as $key => $value) {
			
			if($value['type_of_service'] == 'BD' || $value['type_of_service'] == 'BI'){

				$BookingType = $value['BookingType'];
				$consecutivo = $value['Link_Key'];
				$type_of_service = 1;
				$documentType = 'A';
				$VendorName = cortar_string ($value['nombre_proveedor'], 40); 
				$direccion = '';
				$nombre_ciudad = '';
				$estado = '';
				$telefono = '';
				$date1 = new DateTime($value['GVC_FECHA_SALIDA']);
				$date2 = new DateTime($value['GVC_FECHA_REGRESO']);
				$diff = $date1->diff($date2);
				
				if($date1 == '' || $date2 == ''){ 

					$bookingduration = '';

				}else{

					$dif = $diff->days;
					
					if($dif == 0){

						$dif =  1;

					}

					$bookingduration = $dif;

				}

				$rate = $value['GVC_TARIFA_MON_BASE'];
				$CurrencyCode = $value['moneda_vuelo'];
				$ID_FORMA_PAGO = $value['ID_FORMA_PAGO_VUELO'];
				$ID_FORMA_PAGO_ORIGINAL = $value['ID_FORMA_PAGO_VUELO_ORIGINAL'];
				$payment_number = $value['payment_number_vuelo'];
				$GVC_NOM_PAX = $value['GVC_NOM_PAX_VUELO'];
				$documento = $value['documento_vuelo'];
				$routing = $value['routing_vuelo'];
				$origin = $value['origin_vuelo'];
				$destination = $value['destination_vuelo'];
				$DomesticInternational = $value['DomesticInternational'];
				$class = $value['class_vuelo'];
				$tour_code = $value['tour_code_vuelo'];
				$ticket_designer = $value['ticket_designer_vuelo'];
			    $VendorCountryCode	= $value['VendorCountryCode_vuelo'];
			    $VendorInterfaceID = $value['ID_PROVEEDOR'];
			    $AirlineNumber = $value['codigo_bsp'];
				$codigo_razon = $value['codigo_razon'];

				$StartDate = str_replace("-", "/", $value['GVC_FECHA_SALIDA']);
				$EndDate = str_replace("-", "/", $value['GVC_FECHA_REGRESO']);


				$FullFare = number_format((float)$value['IMP_CRE'], 2, '.', '');
				$LowFare = number_format((float)$value['TARIFA_OFRECIDA'], 2, '.', '');
				$BaseFare = number_format((float)$value['GVC_TARIFA_MON_BASE'], 2, '.', '');

				$VendorInterfaceID = $value['ID_PROVEEDOR'];
				$DocumentNumber =  $value['boleto_aereo'];
				$OriginalDocumentNumber =  $value['bol_contra'];
				$boleto_aereo = $value['boleto_aereo'];
				$Department =  $value['departament']; 
				$DepartmentDescription =  $value['departament'];
				$consecutivo_gen =  $value['consecutivo_gen'];
				$consecutivo_vuelo =  $value['consecutivo_vuelo'];


				$Tax1Amount =  number_format((float)$value['GVC_IVA'], 2, '.', '');
				$Tax2Amount =  number_format((float)$value['GVC_TUA'], 2, '.', '');
				$Tax3Amount =  number_format((float)$value['GVC_OTROS_IMPUESTOS'], 2, '.', '');
				$TotalTaxes = number_format((float)$value['SUMA_IMPUESTOS'], 2, '.', '');
				$TotalPaid = number_format((float)$value['GVC_TOTAL'], 2, '.', '');
				$NumberofUnits = 1;

				$CostCenter = $value['GVC_ID_CENTRO_COSTO'];
				$desc_centro_costo =  $value['desc_centro_costo'];
				$TransactionType = $value['TransactionType'];
				$VendorCity = '';
				$VendorState = '';

				
			}else if($value['type_of_service'] == 'HOTEL'){


				$BookingType = $value['BookingType'];
				$consecutivo = $value['Link_Key'];
				$type_of_service = 2;
				$documentType = 'C';
				$VendorName = cortar_string ($value['nombre_hotel'], 40); 
				$direccion = $value['direccion_hotel'];
				$nombre_ciudad = $value['nombre_ciudad_hotel'];
				$estado = $value['estado_hotel'];
				$telefono = $value['telefono_hotel'];
				$date1 = new DateTime($value['fecha_entrada_original']);
				$date2 = new DateTime($value['fecha_salida_original']);
				$diff = $date1->diff($date2);

				$bookingduration = $value['noches'];

				$rate = number_format((float)$value['rate_hot'], 2, '.', '');
				$CurrencyCode = $value['moneda_hotel'];
				$ID_FORMA_PAGO = $value['ID_FORMA_PAGO_HOTEL'];
				$ID_FORMA_PAGO_ORIGINAL = $value['ID_FORMA_PAGO_HOTEL_ORIGINAL'];
				$payment_number = $value['payment_number_hotel'];
				$GVC_NOM_PAX = $value['GVC_NOM_PAX_HOTEL'];

				if($value['documento_hotel'] == ''){

					$documento = $value['analisis35_cliente'];

				}else{

					$documento = str_replace("-", "", $value['documento_hotel']);

				}

				$routing = $value['routing_hotel'];
				$origin = $value['origin_hotel'];
				$destination = $value['destination_hotel'];
				$DomesticInternational = $value['DomesticInternational'];
				$class = $value['class_hotel'];
				$tour_code = $value['tour_code_hotel'];
				$ticket_designer = $value['ticket_designer_hotel'];
				$VendorCountryCode	= $value['VendorCountryCode_hotel'];
				$VendorInterfaceID = $value['VendorInterfaceID'];
				$AirlineNumber = '';
				$codigo_razon= '';
				$StartDate = str_replace("-", "/", $value['fecha_entrada_original']);
				$EndDate = str_replace("-", "/", $value['fecha_salida_original']);
				$FullFare = "";
				$LowFare = "";
				$BaseFare = number_format((float)$value['tarifa_neta'], 2, '.', '');
				$DocumentNumber = '';

				$Tax1Amount =  number_format((float)$value['iva_hot'], 2, '.', '');
				$Tax2Amount =  '';
				$Tax3Amount =  number_format((float)$value['otros_imp_hot'], 2, '.', '');
				$TotalTaxes = $Tax1Amount * $Tax3Amount;
				$OriginalDocumentNumber =  '';
				$boleto_aereo = '';
				$Department =  $value['departament'];
				$DepartmentDescription =  $value['departament'];
				$consecutivo_gen =  '';
				$consecutivo_vuelo =  '';
				$TotalPaid = $BaseFare + $TotalTaxes;

				$NumberofUnits = $value['numero_habitaciones'];  

				$CostCenter = $value['GVC_ID_CENTRO_COSTO'];
				$desc_centro_costo =  $value['desc_centro_costo'];

				if($value['TIPO_HOTEL'] != 'RESERVADO'){

					$TransactionType = $value['TransactionType'];

				}else{

					$TransactionType = 'S';
				}

				
				$VendorCity = $nombre_ciudad;
				$VendorState = $value['estado_hotel'];
			
			}else if($value['type_of_service'] == 'CAR'){

				$consecutivo = $value['Link_Key'];
				$consecutivo = $consecutivo + 1;

				$BookingType = $value['BookingType'];
				$type_of_service = 3;
				$documentType = 'C';
				$VendorName = cortar_string ($value['nombre_arrendadora2'], 40); 
				$direccion = '';
				$nombre_ciudad= $value['nombre_ciudad_renta'];
				$estado = '';
				$telefono = '';
				$date1 = new DateTime($value['Delivery_Date_original']);
				$date2 = new DateTime($value['Departure_date_original']);
				$diff = $date1->diff($date2);


				$bookingduration = $value['Nr_days'];

				
				$rate = number_format((float)$value['tarifa_diaria'], 2, '.', '');
				$CurrencyCode = $value['moneda_auto'];
				$ID_FORMA_PAGO = $value['ID_FORMA_PAGO_AUTO'];
				$ID_FORMA_PAGO_ORIGINAL = $value['ID_FORMA_PAGO_AUTO_ORIGINAL'];
				$payment_number = $value['payment_number_car'];
				$GVC_NOM_PAX = $value['GVC_NOM_PAX_CAR'];
				$documento = str_replace("-", "", $value['documento_car']);
				$routing = $value['routing_car'];
				$origin = $value['origin_car'];
				$destination = $value['destination_car'];
				$DomesticInternational = $value['DomesticInternational'];
				$class = $value['class_car'];
				$tour_code = $value['tour_code_car'];
				$ticket_designer = $value['ticket_designer_car'];
				$VendorCountryCode	= $value['VendorCountryCode_car']; 
				$VendorInterfaceID = $value['VendorInterfaceID'];
				$AirlineNumber = '';
				$codigo_razon= '';
				$StartDate = str_replace("-", "/", $value['Departure_date_original']); 
				$EndDate = str_replace("-", "/", $value['Delivery_Date_original']);
				$FullFare = "";
				$LowFare = "";
				$BaseFare = number_format((float)$value['tarifa_total'], 2, '.', '');
				$tarifa_total = number_format((float)$value['tarifa_neta'], 2, '.', '');
				$DocumentNumber = '';

				$Tax1Amount =  number_format((float)$value['iva_car'], 2, '.', '');
				$Tax2Amount =  '';
				$Tax3Amount =  '';
				$TotalTaxes = number_format((float)$value['iva_car'], 2, '.', '');
				$OriginalDocumentNumber =  '';
				$boleto_aereo = '';
				$Department =  $value['departament'];
				$DepartmentDescription =  $value['departament'];
				$consecutivo_gen =  '';
				$consecutivo_vuelo =  '';
				$TotalPaid = $tarifa_total;

				$TotalPaid = $BaseFare + $TotalTaxes;

				$NumberofUnits = $value['numero_autos']; 
				
				$CostCenter = $value['GVC_ID_CENTRO_COSTO'];
				$desc_centro_costo =  $value['desc_centro_costo'];

				$TransactionType = 'S';

				$VendorCity = $nombre_ciudad;
				$VendorState = $value['estado_car'];

			}else{  // resto de servicios


				$BookingType = $value['BookingType'];
				$consecutivo = $value['Link_Key'];
				$type_of_service = 5;
				$documentType = 'C';
				$VendorName = cortar_string ($value['nombre_proveedor'], 40); 
				$direccion = '';
				$nombre_ciudad = '';
				$estado = '';
				$telefono = '';
				$date1 = new DateTime($value['GVC_FECHA_SALIDA']);
				$date2 = new DateTime($value['GVC_FECHA_REGRESO']);
				$diff = $date1->diff($date2);
				//$bookingduration = $diff->days;
				$bookingduration = ''; //se pone vacio por que aveces no tienen fecha inicio y salida
				$rate = $value['GVC_TARIFA_MON_BASE'];
				$CurrencyCode = $value['moneda_vuelo'];
				$ID_FORMA_PAGO = $value['ID_FORMA_PAGO_VUELO'];
				$ID_FORMA_PAGO_ORIGINAL = $value['ID_FORMA_PAGO_VUELO_ORIGINAL'];
				$payment_number = $value['payment_number_vuelo'];
				$GVC_NOM_PAX = $value['GVC_NOM_PAX_VUELO'];
				$documento = '';
				$routing = '';
				$origin = '';
				$destination = $value['destination_vuelo'];

				$booking_type = $this->lib_ega_booking_type->booking_type($value['type_of_service']);

				if($booking_type == 7){  //otras transportaciones  TODAS SON NACIONALES
				

						$DomesticInternational = 'D';

				}else{

						$DomesticInternational = '';

				}

				
				$class = $value['class_vuelo'];
				$tour_code = $value['tour_code_vuelo'];
				$ticket_designer = $value['ticket_designer_vuelo'];
				$VendorCountryCode	= $value['VendorCountryCode_vuelo'];
				$VendorInterfaceID = '';
				$AirlineNumber = '';
				$codigo_razon= '';


				if($BookingType == 9){

					if($value['fecha_salida_vuelos_cxs'] == '' || $value['fecha_salida_vuelos_cxs'] == '01-01-1900'){

						if($value['fecha_salid_con_bol_cxs'] == ''){

							$StartDate = str_replace("-", "/", $value['fecha_salid_con_bol']);

						}else{

							$StartDate = str_replace("-", "/", $value['fecha_salid_con_bol_cxs']);

						}

					}else{

						$StartDate = str_replace("-", "/", $value['fecha_salida_vuelos_cxs']);

					}

					if($value['fecha_regreso_vuelos_cxs'] == '' || $value['fecha_regreso_vuelos_cxs'] == '01-01-1900'){

					
						if($value['fecha_regre_con_bol_cxs'] == ''){

							$EndDate = str_replace("-", "/", $value['fecha_regre_con_bol']);

						}else{

							$EndDate = str_replace("-", "/", $value['fecha_regre_con_bol_cxs']);

						}

					}else{

						$EndDate = str_replace("-", "/", $value['fecha_regreso_vuelos_cxs']);

					}


				}else{

					$StartDate = '';
					$EndDate = '';

				}

				

				$FullFare = "";
				$LowFare = "";
				$BaseFare = number_format((float)$value['GVC_TARIFA_MON_BASE'], 2, '.', '');
				//$DocumentNumber = '';

				$Tax1Amount =  number_format((float)$value['GVC_IVA'], 2, '.', '');
				$Tax2Amount =  number_format((float)$value['GVC_TUA'], 2, '.', '');
				$Tax3Amount =  number_format((float)$value['GVC_OTROS_IMPUESTOS'], 2, '.', '');
				$TotalTaxes =  number_format((float)$value['SUMA_IMPUESTOS'], 2, '.', '');
				$OriginalDocumentNumber =  '';
				$boleto_aereo = '';
				$Department =  $value['departament'];
				$DepartmentDescription =  $value['departament'];
				$consecutivo_gen =  '';
				$consecutivo_vuelo =  '';
				$TotalPaid = number_format((float)$value['GVC_TOTAL'], 2, '.', '');

				$TotalPaid = $BaseFare + $TotalTaxes;

				$NumberofUnits = 1;  

				$CostCenter = $value['GVC_ID_CENTRO_COSTO'];
				$desc_centro_costo =  $value['desc_centro_costo'];

				$TransactionType = $value['TransactionType'];

				$VendorCity = '';
				$VendorState = '';

				if($BookingType == 9){

					$documento = '';
					
					if(substr($value['BookingSubTypecxs'],0,3) == 'HOT' ){ //excluye cargos por ervicio de otros servicios

							$fecha1 = $value["fecha1"];
				      		$fecha2 = $value["fecha2"];

						    $fac_numero = str_replace(".000000", "", $value['documento']);  
						    $id_serie = utf8_encode($value['id_serie']);

						    /*$fac_numero_cxss = str_replace(".000000", "", $value['fac_numero_cxss']);  
						    $id_serie_cxss = utf8_encode($value['id_serie_cxss']);*/

							$hoteles_iris_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_iris('man',$fecha_ini_proceso = '',$id_intervalo = 0,$fac_numero,$fecha1,$fecha2,$id_serie,'');


							if(isset($hoteles_iris_arr[0]['clave_confirmacion'])){

								$documento = str_replace("-", "", $hoteles_iris_arr[0]['clave_confirmacion']);

							}

							
							if($documento == ''){

								$hoteles_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_num_bol('man',$fecha_ini_proceso = '',$id_intervalo = 0,$value['record_localizador'],$value['consecutivo_gen'],$fecha1,$fecha2,$fac_numero,'');

								if(isset($hoteles_arr[0]['confirmacion'])){

									
									$documento = str_replace("-", "", $hoteles_arr[0]['confirmacion']);

								}

							}

							if($documento == ''){

								
								$documento = $value['analisis35_cliente'];

									

							}

							if($documento == ''){

									$hoteles_arr = $this->Mod_layouts_egencia_bookings_cadena->get_hoteles_sin_interfaz($fac_numero);
									
									if(isset($hoteles_arr[0]['confirmacion'])){

									
										$documento = str_replace("-", "", $hoteles_arr[0]['confirmacion']);

									}

							}

							if($documento == ''){

								if($value['numero_bol_cxs'] == ''){

									$documento =  $value['boleto_aereo'];

								}else{

									$documento = $value['numero_bol_cxs'];  //poner boletocxs

								}


							}

							/*if($documento == ''){

						  		$documento =  $value['EmployeeID'];

							}*/
							
							

					}else if(substr($value['BookingSubTypecxs'],0,3) == 'CAR'){

						  $autos_arr = $this->Mod_layouts_egencia_bookings_cadena->get_autos_num_bol($value['consecutivo_gen']);
						  if(isset($autos_arr[0]['documento_car'])){

									$documento = str_replace("-", "", $autos_arr[0]['documento_car']);

						  }

						  if($documento == ''){

								if($value['numero_bol_cxs'] == ''){

									$documento =  $value['boleto_aereo'];

								}else{

									$documento = $value['numero_bol_cxs'];  //poner boletocxs

								}


							}

						  if($documento == ''){  //quitar validacion cuando se corrigan los vacios para carros manuales

						  	$documento =  $value['EmployeeID'];

						  }

					}else{

						if($value['numero_bol_cxs'] == ''){

							$documento =  $value['boleto_aereo'];

						}else{

							$documento = $value['numero_bol_cxs'];  //poner boletocxs

						}

						/*if($documento == ''){

						  	$documento =  $value['EmployeeID'];

						}*/

					}

				}else{

					$documento =  $value['boleto_aereo'];

				}

			}  // fin otros servicios

			if($value['emd'] == 'S'){

				$importe_emd = $value['GVC_TARIFA_MON_BASE']; 

			}else{

				$importe_emd = '0'; 

			}

			if($VendorInterfaceID == ''){ 

					$VendorInterfaceID = $value['ID_PROVEEDOR'];
			
			}

			$record_localizador = $value['record_localizador'];

			$campos = [];

			$consecutivo = str_replace(".000000", "", $consecutivo);
			$campos['Link_Key'] = $consecutivo.$record_localizador;
			$campos['BookingID'] = $consecutivo;  //numerico incrementable que no tiene que ver con nada
			$campos['BookingType'] = $BookingType;

			$BookingSubType = '';

			if($BookingType == 1){

				$BookingSubType = 'Air';

			}else if($BookingType == 2){

				$BookingSubType = 'Hotel';

			}else if($BookingType == 3){

				$BookingSubType = 'Car';

			}else if($BookingType == 4){

				$BookingSubType = 'Cruise';

			}else if($BookingType == 5){

				$BookingSubType = 'Tour';
				
			}else if($BookingType == 6){

				$BookingSubType = 'Rail';
				
			}else if($BookingType == 7){

				$BookingSubType = 'Transportation';

			}else if($BookingType == 8){

				$BookingSubType = 'Insurance';
				
			}else if($BookingType == 9){

				if($value['BookingSubTypecxs'] == ''){

					$BookingSubType = 'Serv Fee';

				}else{

					$BookingSubType = $value['BookingSubTypecxs'];

				}

			}else if($BookingType == 10){ 

				$BookingSubType = 'Other';
				
			}


			$campos['BookingSubType'] = $BookingSubType;
			$campos['DocumentType'] = $documentType;

			$campos['TransactionType'] = $TransactionType;
			
			$campos['RecordLocator'] = $value['record_localizador'];

			if($value['documento'] == '0'){

				$value['documento'] = '';

			}

			if($value['mail_cliente'] != ''){

				$ex_mail = explode(';', $value['mail_cliente']);

				$mail_pax = $ex_mail[0];

			}else{

				$mail_pax = 'info@villatours.com.mx';

			}

			$campos['InvoiceNumber'] = str_replace(".000000", "", $value['documento']);  
			
			$campos['BranchName'] = $value['pseudocity'];  // EN GDS GENERAL EXISTE PSEUDOCITYBOLETA Y PSEUDOCITYRESERVA
			$campos['BranchInterfaceID'] = str_replace(".000000", "", $value['id_sucursal']);
			$campos['BranchARCNumber'] = $value['BranchARCNumber'];   //poner la IATA POR SUCURSAL
			$campos['OutsideAgent'] = $value['VENDEDOR_NOMBRE_TIT'];
			$campos['BookingAgent'] = $value['ID_VENDEDOR_TIT'];
			$campos['InsideAgent'] = $value['ID_VENDEDOR_TIT'];
			$campos['TicketingAgent'] = $value['ID_VENDEDOR_TIT'];


			if($value['analisis4_cliente'] == ''){

				$BookedOnline = 'N';

			}else{

				$BookedOnline = $value['analisis4_cliente'];

			}

			
			$campos['BookedOnline'] = $BookedOnline;
			
			$campos['AccountName'] = eliminar_acentos2(utf8_decode($value['GVC_NOM_CLI']));
			$campos['AccountInterfaceID'] = $value['nexp'];
			$campos['AccountType'] = 'C';
			$campos['VendorName'] = eliminar_acentos2(utf8_decode($VendorName));
			$campos['VendorInterfaceID'] = $VendorInterfaceID;  // PARA HOTELES SE AÑADE UN PREFIJO DESPUES DEL CODIGO DE PROVEEDOR
			//$campos['VendorCode'] = utf8_encode($value['ID_PROVEEDOR']);
			$campos['VendorCode'] = $VendorInterfaceID;

			if (strpos($direccion, '/') !== false) {
			    $direccion = '';
			}

			$campos['VendorAddress'] = eliminar_acentos2(utf8_decode($direccion));
			$campos['VendorCity'] = utf8_decode(eliminar_acentos2($nombre_ciudad));
			$campos['VendorState'] = $VendorState /*$estado_hotel*/;  //segun ega no es requerido
			$campos['VendorZip'] = $value['cp_ho'];  //hablar con mic para que agregen el codigo postal tanto pata hoteles facturados como reservados
			$campos['VendorCountryCode'] = $VendorCountryCode; //hablar con mic para que agregen el pais tanto pata hoteles facturados como reservados
			$campos['VendorPhone'] = $telefono;
			$campos['AirlineNumber'] =  $AirlineNumber;
			$campos['ReasonCode'] = eliminar_acentos2(utf8_decode($codigo_razon));
			$campos['ReasonDescription'] = '';

			if($value['fecha_fac'] == ''){

				$IssuedDate = $value['fecha_emi'];
			
			}else{

				$IssuedDate = $value['fecha_fac'];

			}

			$campos['IssuedDate'] = str_replace("-", "/", $IssuedDate);

			

			if($value['GVC_FECHA_RESERVACION'] == ''){

				$campos['BookingDate'] =  str_replace("-", "/", $value['fecha_fac']);

			}else{

				$campos['BookingDate'] =  str_replace("-", "/", $value['GVC_FECHA_RESERVACION']);

			}
			
			$campos['StartDate'] =  $StartDate;
			$campos['EndDate'] = $EndDate;
			
			$campos['NumberofUnits'] = $NumberofUnits;
			$campos['BookingDuration'] = $bookingduration;
			$campos['CommissionAmount'] = '';
			$campos['CommissionRate'] = '';
			$campos['FullFare'] = $FullFare;
			$campos['LowFare'] =  $LowFare;
			$campos['BaseFare'] = $BaseFare;

			$campos['Tax1Amount'] = $Tax1Amount;
			$campos['Tax2Amount'] = $Tax2Amount;
			$campos['Tax3Amount'] = $Tax3Amount;
			$campos['TotalTaxes'] = $TotalTaxes;

			$campos['TotalPaid'] = $TotalPaid;

			$campos['Tax4Amount'] = ''; //vacio
			$campos['GSTAmount'] = '';  //vacio
			$campos['QSTAmount'] = '';  //vacio

			$campos['PenaltyAmount'] = number_format((float)$importe_emd, 2, '.', '');

			$campos['Rate'] = number_format((float)$rate, 2, '.', ''); // no se sabe que campo tomar de hoteles y carros tanto como en irris que en icap  
									  // marca el neto indepenedientemente las noches que se quedaron..se ocupa el importe diario
			$campos['RateType'] = '';  // vacio
			$campos['CurrencyCode'] = /*$CurrencyCode*/ 'MXN';
			$campos['FormofPayment'] = $ID_FORMA_PAGO;

			$payment_number = $payment_number;
			$payment_number = substr($payment_number,-4);

	
			if(LTRIM(RTRIM($ID_FORMA_PAGO)) == 'CA'){

				$campos['PaymentNumber'] = '';
				
			}else{

				$campos['PaymentNumber'] = $ID_FORMA_PAGO_ORIGINAL.'-'.$payment_number;

			}
			
			$campos['TravelerName'] = $GVC_NOM_PAX;
			$campos['DocumentNumber'] = str_replace(".000000", "", $documento);

			$campos['OriginalDocumentNumber'] = $OriginalDocumentNumber; // vacio
			
			$campos['Routing'] = utf8_decode(eliminar_acentos2($routing)); 
			$campos['Origin'] = utf8_decode(eliminar_acentos2($origin));
			$campos['Destination'] = utf8_decode(eliminar_acentos2($destination));
			$campos['DomesticInternational'] = $DomesticInternational;
			$campos['Class'] = $class;
			$campos['TourCode'] = $tour_code;
			$campos['TicketDesignator'] = ''; //str_replace(".000000", "", $ticket_designer);
			$campos['ClientRemarks'] = ''; // vacio
			$campos['Department'] = $Department;
			$campos['GSANumber'] = '';  // vacio
			$campos['PurchaseOrder'] = ''; // vacio
			$campos['CostCenter'] = $CostCenter;
			$campos['CostCenterdescription'] =  $desc_centro_costo; // vacio
			$campos['SBU'] = $value['SBU'];
			$campos['EmployeeID'] =  $value['EmployeeID'];
			$campos['BillableNonBillable'] = ''; // vacio
			$campos['ProjectCode'] = ''; // vacio
			$campos['ReasonforTravel'] = ''; // vacio
			$campos['DepartmentDescription'] = $DepartmentDescription; // vacio
			$campos['CustomField9'] = ''; // vacio
			$campos['CustomField10'] = ''; // vacio

			$GroupID = $this->Mod_layouts_egencia_bookings_cadena->get_group_id($value['nexp']);
			
			if(count($GroupID) > 0){

				$campos['GroupID'] = $GroupID[0]->group_id; /*$value['analisis46_cliente'];*/ // vacio

			}else{

				$campos['GroupID'] = '';
			}

			$campos['InPolicy'] = ''; // vacio
			$campos['TravelerEmail'] = $mail_pax;   //no lo encontre
			$campos['NegotiatedFare'] = ''; // vacio
			$campos['boleto_aereo'] = $boleto_aereo;
			$campos['consecutivo_gen'] = $consecutivo_gen; // vacio
			$campos['consecutivo_vuelo'] = $consecutivo_vuelo; // vacio
			$campos['TIPO_HOTEL'] = $value['TIPO_HOTEL']; // vacio

			$campos['analisis1_cliente']	=$value['analisis1_cliente'];
			$campos['analisis2_cliente']	=$value['analisis2_cliente'];
			$campos['analisis3_cliente']	=$value['analisis3_cliente'];
			$campos['analisis4_cliente']	=$value['analisis4_cliente'];
			$campos['analisis5_cliente']	=$value['analisis5_cliente'];
			$campos['analisis6_cliente']	=$value['analisis6_cliente'];
			$campos['analisis7_cliente']	=$value['analisis7_cliente'];
			$campos['analisis8_cliente']	=$value['analisis8_cliente'];
			$campos['analisis9_cliente']	=$value['analisis9_cliente'];
			$campos['analisis10_cliente']	=$value['analisis10_cliente'];
			$campos['analisis11_cliente']	=$value['analisis11_cliente'];
			$campos['analisis12_cliente']	=$value['analisis12_cliente'];
			$campos['analisis13_cliente']	=$value['analisis13_cliente'];
			$campos['analisis14_cliente']	=$value['analisis14_cliente'];
			$campos['analisis15_cliente']	=$value['analisis15_cliente'];
			$campos['analisis16_cliente']	=$value['analisis16_cliente'];
			$campos['analisis17_cliente']	=$value['analisis17_cliente'];
			$campos['analisis18_cliente']	=$value['analisis18_cliente'];
			$campos['analisis19_cliente']	=$value['analisis19_cliente'];
			$campos['analisis20_cliente']	=$value['analisis20_cliente'];
			$campos['analisis21_cliente']	=$value['analisis21_cliente'];
			$campos['analisis22_cliente']	=$value['analisis22_cliente'];
			$campos['analisis23_cliente']	=$value['analisis23_cliente'];
			$campos['analisis24_cliente']	=$value['analisis24_cliente'];
			$campos['analisis25_cliente']	=$value['analisis25_cliente'];
			$campos['analisis26_cliente']	=$value['analisis26_cliente'];
			$campos['analisis27_cliente']	=$value['analisis27_cliente'];
			$campos['analisis28_cliente']	=$value['analisis28_cliente'];
			$campos['analisis29_cliente']	=$value['analisis29_cliente'];
			$campos['analisis30_cliente']	=$value['analisis30_cliente'];
			$campos['analisis31_cliente']	=$value['analisis31_cliente'];
			$campos['analisis32_cliente']	=$value['analisis32_cliente'];
			$campos['analisis33_cliente']	=$value['analisis33_cliente'];
			$campos['analisis34_cliente']	=$value['analisis34_cliente'];
			$campos['analisis35_cliente']	=$value['analisis35_cliente'];
			$campos['analisis36_cliente']	=$value['analisis36_cliente'];
			$campos['analisis37_cliente']	=$value['analisis37_cliente'];
			$campos['analisis38_cliente']	=$value['analisis38_cliente'];
			$campos['analisis39_cliente']	=$value['analisis39_cliente'];
			$campos['analisis40_cliente']	=$value['analisis40_cliente'];
			$campos['analisis41_cliente']	=$value['analisis41_cliente'];
			$campos['analisis42_cliente']	=$value['analisis42_cliente'];
			$campos['analisis43_cliente']	=$value['analisis43_cliente'];
			$campos['analisis44_cliente']	=$value['analisis44_cliente'];
			$campos['analisis45_cliente']	=$value['analisis45_cliente'];
			$campos['analisis46_cliente']	=$value['analisis46_cliente'];
			$campos['analisis47_cliente']	=$value['analisis47_cliente'];
			$campos['analisis48_cliente']	=$value['analisis48_cliente'];
			$campos['analisis49_cliente']	=$value['analisis49_cliente'];
			$campos['analisis50_cliente']	=$value['analisis50_cliente'];
			$campos['analisis51_cliente']	=$value['analisis51_cliente'];
			$campos['analisis52_cliente']	=$value['analisis52_cliente'];
			$campos['analisis53_cliente']	=$value['analisis53_cliente'];
			$campos['analisis54_cliente']	=$value['analisis54_cliente'];
			$campos['analisis55_cliente']	=$value['analisis55_cliente'];
			$campos['analisis56_cliente']	=$value['analisis56_cliente'];
			$campos['analisis57_cliente']	=$value['analisis57_cliente'];
			$campos['analisis58_cliente']	=$value['analisis58_cliente'];
			$campos['analisis59_cliente']	=$value['analisis59_cliente'];
			$campos['analisis60_cliente']	=$value['analisis60_cliente'];
			$campos['analisis61_cliente']	=$value['analisis61_cliente'];
			$campos['analisis62_cliente']	=$value['analisis62_cliente'];
			$campos['analisis63_cliente']	=$value['analisis63_cliente'];
			$campos['analisis64_cliente']	=$value['analisis64_cliente'];
			$campos['analisis65_cliente']	=$value['analisis65_cliente'];
			$campos['analisis66_cliente']	=$value['analisis66_cliente'];
			$campos['analisis67_cliente']	=$value['analisis67_cliente'];
			$campos['analisis68_cliente']	=$value['analisis68_cliente'];
			$campos['analisis69_cliente']	=$value['analisis69_cliente'];
			$campos['analisis70_cliente']	=$value['analisis70_cliente'];
			$campos['analisis71_cliente']	=$value['analisis71_cliente'];
			$campos['analisis72_cliente']	=$value['analisis72_cliente'];
			$campos['analisis73_cliente']	=$value['analisis73_cliente'];
			$campos['analisis74_cliente']	=$value['analisis74_cliente'];
			$campos['analisis75_cliente']	=$value['analisis75_cliente'];
			$campos['analisis76_cliente']	=$value['analisis76_cliente'];
			$campos['analisis77_cliente']	=$value['analisis77_cliente'];
			$campos['analisis78_cliente']	=$value['analisis78_cliente'];
			$campos['analisis79_cliente']	=$value['analisis79_cliente'];
			$campos['analisis80_cliente']	=$value['analisis80_cliente'];
			$campos['analisis81_cliente']	=$value['analisis81_cliente'];
			$campos['analisis82_cliente']	=$value['analisis82_cliente'];
			$campos['analisis83_cliente']	=$value['analisis83_cliente'];
			$campos['analisis84_cliente']	=$value['analisis84_cliente'];
			$campos['analisis85_cliente']	=$value['analisis85_cliente'];
			$campos['analisis86_cliente']	=$value['analisis86_cliente'];
			$campos['analisis87_cliente']	=$value['analisis87_cliente'];
			$campos['analisis88_cliente']	=$value['analisis88_cliente'];
			$campos['analisis89_cliente']	=$value['analisis89_cliente'];
			$campos['analisis90_cliente']	=$value['analisis90_cliente'];
			$campos['analisis91_cliente']	=$value['analisis91_cliente'];
			$campos['analisis92_cliente']	=$value['analisis92_cliente'];
			$campos['analisis93_cliente']	=$value['analisis93_cliente'];
			$campos['analisis94_cliente']	=$value['analisis94_cliente'];
			$campos['analisis95_cliente']	=$value['analisis95_cliente'];
			$campos['analisis96_cliente']	=$value['analisis96_cliente'];
			$campos['analisis97_cliente']	=$value['analisis97_cliente'];
			$campos['analisis98_cliente']	=$value['analisis98_cliente'];
			$campos['analisis99_cliente']	=$value['analisis99_cliente'];
			$campos['analisis100_cliente']	=$value['analisis100_cliente'];

			
			array_push($nueva_plantilla, $campos);
			//print_r($campos);

		}
		//print_r($campos);
		return $nueva_plantilla;

    }


    public function exportar_txt_lay_egencia_data_import_sp(){

    	$id_us = $this->session->userdata('session_id');
	    header("Content-type: .txt");
	    header('Content-Disposition: attachment;filename=bookings_'.$id_us.'.txt');
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	 
	    set_time_limit(0); 
	    readfile($_SERVER['DOCUMENT_ROOT'].'\reportes_villatours_v\referencias\archivos\archivos_egencia_lay_data_import_sp\bookings_'.$id_us.'.txt');

	}



}
