<?php

set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '2000000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;
use Box\Spout\Writer\Style\Color;
use Box\Spout\Writer\Style\Border;
use Box\Spout\Writer\Style\BorderBuilder;

class Cnt_layouts_amex extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Layouts/Mod_layouts_amex');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->load->library('lib_ega_booking_type');
	      $this->load->model('Mod_general');
		  $this->Mod_general->get_SPID();
	     
	}
    
    public function get_html_layouts_amex(){

    	$title = $this->input->post('title');

		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();

		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		//$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio_amex();
				
		$rest_catalogo_id_servicio_amex = $this->Mod_catalogos_filtros->get_catalogo_id_provedor_amex();
		
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,4);

		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_catalogos_filtros->get_catalogo_clientes_amex($id_perfil);

		$param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    //$param["rest_catalogo_id_servicio_amex"] = $rest_catalogo_id_servicio;
	    $param["rest_catalogo_id_servicio_local"] = $rest_catalogo_id_servicio_amex;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Layouts/view_lay_amex');

	}

	public function get_catalogo_aereolineas_amex(){

		$slc_select_cat_provedor = $this->input->post("slc_select_cat_provedor");
		
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_tipo_aereolinea_amex($slc_select_cat_provedor);

		echo json_encode($rest_catalogo_id_servicio);

	}

    public function get_lay_amex(){
    	
		$parametros = $this->input->post("parametros");
        $cat_provedor = $this->input->post("cat_provedor");
        
		$parametros = explode(",", $parametros);
        
        $ids_serie = $parametros[0];
        $ids_cliente = $parametros[1];
        $ids_servicio = $parametros[2];
        $ids_provedor = $parametros[3];
        $ids_corporativo = $parametros[4];
        $id_plantilla = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];
        
        $parametros = [];
        
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["ids_servicio"] = $ids_servicio;
        $parametros["ids_provedor"] = $ids_provedor;
        $parametros["ids_corporativo"] = $ids_corporativo;
        $parametros["fecha1"] = $fecha1;
        $parametros["fecha2"] = $fecha2;

        $parametros["id_usuario"] = $this->session->userdata('session_id');
        $parametros["proceso"] = 2;
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';
        $parametros["id_plantilla"] = $id_plantilla;

		$rep = $this->lay_amex($parametros,$cat_provedor);

		$param_final['rep'] = $rep;
		
		echo json_encode($param_final);

	}

	public function lay_amex($parametros,$cat_provedor){

	    $rest = $this->Mod_layouts_amex->lay_amex($parametros,$cat_provedor);
	  
	    $array1 = array();

	    $rep = [];
		foreach($rest as $value) {
    		
			$id_prov_amex = $value["AMEX_ID_PROVEEDOR"];

			$rest = $this->Mod_layouts_amex->get_config_amex($id_prov_amex);

			$codigo_bsp = 000; 

			if(count($rest) > 0 ){

				$codigo_bsp = $rest[0]->codigo_bsp;
				$cambio_prov = $rest[0]->cambio_prov;
			    
			    
			    $cambio_prov = $this->lib_ega_booking_type->booking_type($cambio_prov);

				if($cambio_prov != "" && $cambio_prov != '9'){

					$value["AMEX_ID_PROVEEDOR"] =  '9K'/*$value["AMEX_ID_PROVEEDOR"]*/;

				}

				

			}

			/****************************/

			$categoria = $rest[0]->id_categoria_aereolinea;

			if(ltrim(rtrim($categoria)) == '2'){

				if(ltrim(rtrim($value["AMEX_confirmacion_la"])) != ""){

					$value["AMEX_BOLETO"] = '000'. str_pad($value["AMEX_confirmacion_la"], 7, "0",STR_PAD_LEFT) ;

				}else if(ltrim(rtrim($value["AMEX_analisis39_cliente"])) != '' ){

					$value["AMEX_BOLETO"] = '000'. str_pad($value["AMEX_analisis39_cliente"], 7, "0",STR_PAD_LEFT) ;

				}
				
			}

			if(ltrim(rtrim($value["AMEX_ID_SERV"])) == 'INGUTC' ){

					$value["AMEX_BOLETO"] = '100000000';

			}

			/****************************/
			
			$value["AMEX_CODIGO_BSP"] =  $codigo_bsp;

    		$cast_utf8 = array_map("utf8_encode", $value );

    		$AMEX_TOTAL = $value["AMEX_TOTAL"];

    		$AMEX_TOTAL = (float)$AMEX_TOTAL;
    		
    		if($AMEX_TOTAL > 0){

    			array_push($array1, $cast_utf8);

    		}


		    
		}

	    return $array1;

	}

	public function get_comparacion_tarjetas(){
		
		$ids_cliente = $this->input->post("ids_cliente");

		$tarjetas_sybase = $this->Mod_layouts_amex->tarjetas_sybase($ids_cliente);
		$tarjetas_local = $this->Mod_layouts_amex->tarjetas_local($ids_cliente);

		$param["tarjetas_sybase"] = $tarjetas_sybase;
		$param["tarjetas_local"] = $tarjetas_local;
		$param["ids_cliente"] = $ids_cliente;

		$this->load->view('Tarjetas/view_comparacion_tarjetas',$param);

	}

	public function exportar_excel_usuario_masivo(){
		
		$parametros = $_REQUEST['parametros'];
		$tipo_funcion = $_REQUEST['tipo_funcion'];
        
        $parametros = explode(",", $parametros);
        
        $ids_serie = $parametros[0];
        $ids_cliente = $parametros[1];
        $ids_servicio = $parametros[2];
        $ids_provedor = $parametros[3];
        $ids_corporativo = $parametros[4];
        $id_plantilla = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];

        if($tipo_funcion == "aut"){
        	
        	$id_correo_automatico = $parametros[8];
            $id_reporte = $parametros[9];
            $id_usuario = $parametros[10];
            $id_intervalo = $parametros[11];
            $fecha_ini_proceso = $parametros[12];
			
		}
        
        $parametros = [];

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

	  $parametros["id_plantilla"] = $id_plantilla;
      
      $parametros["proceso"] = 2;

	  //$rep = $this->reportes_gvc_reporteador($parametros);
	  $rest = $this->Mod_layouts_amex->lay_amex($parametros);
	  
	  $rep = [];

		foreach($rest as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($rep, $cast_utf8);
		    

		}
		
	  if(count($rep) > 0){

						$array_header = [ 'AMEX_ID_SERV','AMEX_5555','AMEX_CVE_AMEX','AMEX_EMPTY1','AMEX_EMPTY2','AMEX_EMPTY3','AMEX_CODIGO_BSP','AMEX_BOLETO','AMEX_CERO','AMEX_EMPTY4','AMEX_NOM_PAX','AMEX_CONCEPTO','AMEX_FECHA_SALIDA','AMEX_EMPTY5','AMEX_EMPTY6','AMEX_STATUS','AMEX_A','AMEX_FAC_NUMERO','AMEX_ID_PROVEEDOR','AMEX_TOTAL_0','AMEX_EMPTY7','AMEX_EMPTY8','AMEX_EMPTY9','AMEX_CONCEPTO','AMEX_CLA_PAX','AMEX_EMPTY10','AMEX_TUA','AMEX_IVA','AMEX_OTROS_IMPUESTOS','AMEX_EMPTY11','AMEX_EMPTY12','AMEX_FECHA_EMISION','AMEX_STATUS2','AMEX_EMPTY13','AMEX_EMPTY14','AMEX_EMPTY15','AMEX_EMPTY16','AMEX_EMPTY17','AMEX_EMPTY18','AMEX_EMPTY19','AMEX_NOM_CENCO','AMEX_EMPTY20','AMEX_IVA2','AMEX_EMPTY21','AMEX_EMPTY22','AMEX_EMPTY23','AMEX_EMPTY24','AMEX_EMPTY25','AMEX_EMPTY26','AMEX_TARIFA_MON_BASE','AMEX_TOTAL','AMEX_EMPTY27','AMEX_EMPTY28','AMEX_EMPTY29','AMEX_EMPTY30','AMEX_EMPTY31'];
      
					    $header = $array_header;

						$writer = WriterFactory::create(Type::XLSX); // for XLSX files
						//$writer = WriterFactory::create(Type::CSV); // for CSV files
						//$writer = WriterFactory::create(Type::ODS); // for ODS files

						$border = (new BorderBuilder())
						    ->setBorderTop(Color::WHITE, Border::WIDTH_THIN, Border::STYLE_SOLID)
						    ->setBorderRight(Color::WHITE, Border::WIDTH_THIN, Border::STYLE_SOLID)
						    ->setBorderBottom(Color::WHITE, Border::WIDTH_THIN, Border::STYLE_SOLID)
						    ->setBorderLeft(Color::WHITE, Border::WIDTH_THIN, Border::STYLE_SOLID)
						    ->build();

						$style = (new StyleBuilder())
						    ->setBorder($border)
						    ->build();


						$array_fecha1 = explode('/', $fecha1);
              			$fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

              			$array_fecha2 = explode('/', $fecha2);
              			$fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0]; //week

						$writer->openToFile($_SERVER['DOCUMENT_ROOT']."/reportes_villatours_v/referencias/archivos/Layout_amex_".$fecha1."_A_".$fecha2.".xlsx"); // 

						$titulo = [];
						$row_vacio = [];

						for($x=0;$x<=count($header);$x++){

							array_push($row_vacio, '');
							
							if($x==10){

								array_push($titulo, 'Layout Amex');

							}else{

								array_push($titulo, '');

							}
								

						}

						$writer->addRowWithStyle($titulo, $style); 

						$writer->addRowWithStyle($row_vacio, $style);

						$writer->addRowWithStyle($header, $style);
						
						//$writer->addRow($singleRow); // add a row at a time
						$writer->addRowsWithStyle($rep, $style); // add multiple rows at a time

						$writer->close();

					    $rut = $_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/Layout_amex_'.$fecha1.'_A_'.$fecha2.'.xlsx';

						header ('Content-Disposition: attachment; filename=Layout_amex_'.$fecha1.'_A_'.$fecha2.'.xlsx');
						header ("Content-Type: application/vnd.ms-excel");
						header ("Content-Length: ".filesize($rut));

						readfile($rut);

      }// fin validacion count
	  else{ 

       	print_r("<label>No existe informacion para exportar</label>");

	  }
	  
	}

	public function generar_txt(){

		$allrows = $this->input->post("allrows");
		$allrows = json_decode($allrows);
		
		$archivo = fopen($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/archivos_amex/MEX_EBTA_TPP_PI6VIL.txt', "w+");
		
		//-----header----//
		
		$AMEX_CONSECUTIVO = $this->Mod_layouts_amex->get_consecutivo();

		$AMEX_CONSECUTIVO = $AMEX_CONSECUTIVO[0]->consecutivo;
 		
		$AMEX_CONSECUTIVO = str_pad($AMEX_CONSECUTIVO, 9, "0",STR_PAD_LEFT);

		$str_header = "0000".date("d").date("m").date("y")."VR07".str_pad($AMEX_CONSECUTIVO, "0",STR_PAD_LEFT);  //."000000001"

		$str_header = str_pad($str_header, 818);

		fwrite($archivo, $str_header);

		fwrite ($archivo, "\r\n");

		//---fin header--//
		$controws = count($allrows);

		foreach($allrows as $value) {

                    $AMEX_TIPO = ltrim(rtrim(utf8_decode($value->AMEX_TIPO)));
                    $AMEX_5555 = ltrim(rtrim(utf8_decode($value->AMEX_5555)));
                    $AMEX_CVE_AMEX = ltrim(rtrim(utf8_decode($value->AMEX_CVE_AMEX)));
                    $AMEX_EMPTY1 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY1)));
                    $AMEX_EMPTY2 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY2)));
                    $AMEX_EMPTY3 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY3)));
                    $AMEX_CODIGO_BSP = ltrim(rtrim(utf8_decode($value->AMEX_CODIGO_BSP)));
                    $AMEX_BOLETO = ltrim(rtrim(utf8_decode($value->AMEX_BOLETO)));
                    $AMEX_CERO = ltrim(rtrim(utf8_decode($value->AMEX_CERO)));
                    $AMEX_EMPTY4 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY4)));

                    $AMEX_NOM_PAX = utf8_decode($value->AMEX_NOM_PAX);
                  
                    $AMEX_CONCEPTO = ltrim(rtrim(utf8_decode($value->AMEX_CONCEPTO)));
                    $AMEX_FECHA_SALIDA = ltrim(rtrim(utf8_decode($value->AMEX_FECHA_SALIDA)));
                    $AMEX_EMPTY5 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY5)));
                    $AMEX_EMPTY6 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY6)));
                    $AMEX_STATUS = ltrim(rtrim(utf8_decode($value->AMEX_STATUS)));
                    $AMEX_A = ltrim(rtrim(utf8_decode($value->AMEX_A)));
                    $AMEX_FAC_NUMERO = ltrim(rtrim(utf8_decode($value->AMEX_FAC_NUMERO)));
                    $AMEX_ID_PROVEEDOR = ltrim(rtrim(utf8_decode($value->AMEX_ID_PROVEEDOR)));
                    $AMEX_EMPTY7 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY7)));
                    $AMEX_EMPTY8 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY8)));
                    $AMEX_EMPTY9 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY9)));
                    $AMEX_CONCEPTO2 = ltrim(rtrim(utf8_decode($value->AMEX_CONCEPTO2)));
                    $AMEX_CLA_PAX = ltrim(rtrim(utf8_decode($value->AMEX_CLA_PAX)));
                    $AMEX_EMPTY10 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY10)));

                    $AMEX_TUA = ltrim(rtrim(utf8_decode($value->AMEX_TUA)));
                    $AMEX_IVA = ltrim(rtrim(utf8_decode($value->AMEX_IVA)));
					$AMEX_OTROS_IMPUESTOS = ltrim(rtrim(utf8_decode($value->AMEX_OTROS_IMPUESTOS)));

                    $AMEX_EMPTY11 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY11)));
                    $AMEX_EMPTY12 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY12)));
                    $AMEX_FECHA_EMISION = ltrim(rtrim(utf8_decode($value->AMEX_FECHA_EMISION)));
                    $AMEX_STATUS2 = ltrim(rtrim(utf8_decode($value->AMEX_STATUS2)));
                    $AMEX_EMPTY13 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY13)));
                    $AMEX_EMPTY14 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY14)));
                    $AMEX_EMPTY15 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY15)));
                    $AMEX_EMPTY16 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY16)));
                    $AMEX_EMPTY17 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY17)));
                    $AMEX_EMPTY18 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY18)));
                    $AMEX_EMPTY19 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY19)));
                    $AMEX_NOM_CENCO = ltrim(rtrim(utf8_decode($value->AMEX_NOM_CENCO)));
                    $AMEX_EMPTY20 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY20)));
                    $AMEX_IVA2 = ltrim(rtrim(utf8_decode($value->AMEX_IVA2)));
                    $AMEX_EMPTY21 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY21)));
                    $AMEX_EMPTY22 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY22)));
                    $AMEX_EMPTY23 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY23)));
                    $AMEX_EMPTY24 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY24)));
                    $AMEX_EMPTY25 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY25)));
                    $AMEX_EMPTY26 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY26)));
                    $AMEX_TARIFA_MON_BASE = number_format(ltrim(rtrim(utf8_decode($value->AMEX_TARIFA_MON_BASE))), 2, ",", ".");
                    $AMEX_TOTAL = number_format(ltrim(rtrim(utf8_decode($value->AMEX_TOTAL))), 2, ",", ".");
                    $AMEX_EMPTY27 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY27)));
                    $AMEX_EMPTY28 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY28)));
                    $AMEX_EMPTY29 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY29)));
                    $AMEX_EMPTY30 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY30)));
                    $AMEX_EMPTY31 = ltrim(rtrim(utf8_decode($value->AMEX_EMPTY31)));

                    $str_txt = "";

                    //de 1 a 10
                    $str_txt = $str_txt . $AMEX_5555.date('d').date('m').date('y');
 					//de 11 a 16
 					$str_txt = $str_txt ."      ";
 					//de 17 a 20
					$str_txt = $str_txt ."    ";
					//de 21 a 35

					$prefijo = substr($AMEX_CVE_AMEX, 0, 2);
					
					
					if($prefijo == 'AX'){

					    $str_txt = $str_txt .str_pad(substr($AMEX_CVE_AMEX,2,17), 15);  //concepto o numero de tarjeta

					}else{

						$str_txt = $str_txt .str_pad($AMEX_CVE_AMEX, 13);  //concepto o numero de tarjeta

					}

					//de 36 a 38
					$str_txt = $str_txt .substr($AMEX_CODIGO_BSP,0,3);
					//de 39 a 48
					$str_txt = $str_txt .str_pad(substr($AMEX_BOLETO,0,10), 10,"0");
					//de 49 a 49
					$str_txt = $str_txt .'0';
					//de 50 a 51
					$str_txt = $str_txt .'  ';
					//de 52 a 71
					$str_txt = $str_txt .str_pad(substr($AMEX_NOM_PAX, 0, 20), 20);
					//de 72 a 91
					$AMEX_CONCEPTO = str_replace("/", " ", $AMEX_CONCEPTO);
					$str_txt = $str_txt .str_pad(substr($AMEX_CONCEPTO, 0, 20), 20);
					//de 92 a 97
					$str_txt = $str_txt .date('d').date('m').date('y');
					//de 98 a 106
					$str_txt = $str_txt .'         ';
					//de 107 a 112
					$str_txt = $str_txt .'      ';
					//de 113 a 113
					$str_txt = $str_txt .str_pad($AMEX_STATUS, 1);
					//de 114-119
					$str_txt = $str_txt .'      ';
					//de 120-120
					$str_txt = $str_txt .$AMEX_A;
					//de 121-129
					$str_txt = $str_txt .str_pad($AMEX_FAC_NUMERO, 9, "0",STR_PAD_LEFT);
					//de 130-131
					$str_txt = $str_txt .substr($AMEX_ID_PROVEEDOR, 0, 2);
					//de 132-145
					$AMEX_TOTAL = str_replace(",", "", $AMEX_TOTAL);
					$AMEX_TOTAL = str_replace(".", "", $AMEX_TOTAL);
					$str_txt = $str_txt .str_pad($AMEX_TOTAL, 14, "0",STR_PAD_LEFT);
					//de 146-160
					$str_txt = $str_txt .'               ';
					//de 161-169
					$str_txt = $str_txt .'8651157 4';
					//de 170-172
					$str_txt = $str_txt .'   ';
					//de 173-180
					$str_txt = $str_txt .'        ';
					//de 181-200
					if(ltrim(rtrim($AMEX_CONCEPTO)) == 'CARGOS POR SERVICIO'){

						$AMEX_CONCEPTO = 'CAR GOS POR SER VIC ';

					}

					$str_txt = $str_txt .str_pad(substr($AMEX_CONCEPTO, 0, 20), 20);
					//de 201-215
					$str_txt = $str_txt .str_pad(substr($AMEX_CLA_PAX, 0, 15), 15);
					//de 216-220
					$str_txt = $str_txt .'     ';
					//de 221-230
					
					if((int)$AMEX_TUA < 1){

						$arr_amex_tua = explode('.', $AMEX_TUA);

						$AMEX_TUA =  '000.'.$arr_amex_tua[1]; 

					}

					$str_txt = $str_txt .str_pad($AMEX_TUA, 10);  //RELLENA LOS FALTANTES CON ESPACIOS EN BLANCO

					//de 231-244
					$AMEX_IVA = str_replace(".", "", $AMEX_IVA);

					if($AMEX_TIPO == 'FC'){ 		//NC
						$str_txt = $str_txt .str_pad($AMEX_IVA, 14, "0",STR_PAD_LEFT);
					}
					if($AMEX_TIPO == 'NC'){
						$str_txt = $str_txt .'00000000000000';
					}
					//de 245-245
					$str_txt = $str_txt .'N';
					//de 246-248
					$str_txt = $str_txt .'MXN';

					//de 249-256
					$AMEX_FECHA_EMISION = str_replace("-", "", $AMEX_FECHA_EMISION);
					$AMEX_FECHA_EMISION = substr($AMEX_FECHA_EMISION, 0, 8);
					$str_txt = $str_txt .$AMEX_FECHA_EMISION;
					//de 257-258
					if($AMEX_TIPO == 'FC'){ 		//NC
						$str_txt = $str_txt .' S';
					}
					if($AMEX_TIPO == 'NC'){
						$str_txt = $str_txt .'SR';
					}
					//de 259-267
					$str_txt = $str_txt .'070170019';
					//de 268-303
					$str_txt = $str_txt .'                                    ';
					//de 304-306
					$str_txt = $str_txt .'307';
					//de 307-323
					$str_txt = $str_txt .'                 ';
					//de 324-347
					$str_txt = $str_txt .str_pad($AMEX_NOM_CENCO, 24);
					//de 348-371
					$str_txt = $str_txt .'                        ';
					//de 372-385
					$str_txt = $str_txt .str_pad($AMEX_IVA, 14, "0",STR_PAD_LEFT);
					//de 386-396
					$str_txt = $str_txt .'           '; //PNR
					//397-418
					$str_txt = $str_txt .'                      ';
					//419-430
					$str_txt = $str_txt .'            ';
				

					//431-445
					$AMEX_TARIFA_MON_BASE = str_replace(",", "", $AMEX_TARIFA_MON_BASE);
					$AMEX_TARIFA_MON_BASE = str_replace(".", "", $AMEX_TARIFA_MON_BASE);
					$str_txt = $str_txt .str_pad('MXN'.str_pad($AMEX_TARIFA_MON_BASE, 12, "0",STR_PAD_LEFT),388);


					fwrite($archivo, $str_txt."\r\n");
				
				
					


		}


		$str_header = "9999".date("d").date("m").date("y").str_pad($controws, 6, "0",STR_PAD_LEFT);

		$str_header = str_pad($str_header, 818);

		fwrite($archivo, $str_header);

		fclose($archivo);


		//************************

		
		$this->Mod_layouts_amex->update_consecutivo($AMEX_CONSECUTIVO);

		
	}

	public function exportar_txt_lay_amex(){

	    header("Content-type: .txt");
	    header("Content-Disposition: attachment;filename=MEX_EBTA_TPP_PI6VIL.txt");
	    header("Content-Transfer-Encoding: binary"); 
	    header('Pragma: no-cache'); 
	    header('Expires: 0');
	 
	    set_time_limit(0); 
	    readfile($_SERVER['DOCUMENT_ROOT'].'\reportes_villatours_v\referencias\archivos\archivos_amex\MEX_EBTA_TPP_PI6VIL.txt');

	}

	
}
