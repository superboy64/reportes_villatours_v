<?php
set_time_limit(0);
ini_set('post_max_size','10000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_ahorro_net extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_ahorro_net');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	     
	}

	public function get_html_rep_ahorro(){

		$title = $this->input->post('title');
		
		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$rest_catalogo_id_servicio_aereo = $this->Mod_catalogos_filtros->get_catalogo_id_servicio_aereo();
		$rest_catalogo_id_provedor = $this->Mod_catalogos_filtros->get_catalogo_id_provedor();
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,3);
		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		$param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_catalogo_id_servicio_aereo"] = $rest_catalogo_id_servicio_aereo;
	    $param["rest_catalogo_id_provedor"] = $rest_catalogo_id_provedor;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param["rest_clientes"] = $rest_clientes;

	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);

		$this->load->view('Reportes/view_rep_ahorro_net');
		
	}

	public function get_pasajero_html(){

		$data = $this->input->post("data");
		
		$para = $this->input->post("parametros");

		$parametros = explode(",", $para);

		$ids_suc = $parametros[0];
		$ids_serie = $parametros[1];
        $ids_cliente = $parametros[2];
        $ids_provedor = $parametros[3];
        $ids_corporativo = $parametros[4];
        $fecha1 = $parametros[5];
        $fecha2 = $parametros[6];

	    $ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");
  
            if(count($ids_corporativo) > 0 ){

	              $sub = "";

	              if(count($ids_corporativo) > 1){

	              	    $sub = $sub . $fecha1 . ' - ' . $fecha2;

	              }else{

	              	foreach ($ids_corporativo as $clave => $valor) {  //obtiene clientes asignados

	                 	$sub = $sub . $valor .'<br>'. $fecha1 . ' - ' . $fecha2;

	              	}

	              }

            }
            else if(count($ids_cliente) > 0){

            	$sub = "";
                
                $rz = $this->Mod_reportes_ahorro_net->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
                if(count($rz) > 1){

                	  $sub = $sub . $fecha1 . ' - ' . $fecha2 .' ';

                }else{

                	foreach ($rz as $clave => $valor) {  //obtiene clientes asignados

	                   $sub = $sub . $valor->nombre_cliente .'<br>'. $fecha1 . ' - ' . $fecha2 .' ';

	            	}
                }
                  

            }else{
            	
            	$sub = "Clientes Villatours" .'<br>'. $fecha1 . ' - ' . $fecha2;

            }

		$array2["data"] =  $data;
		$array2["fecha1"] =  $fecha1;
		$array2["fecha2"] =  $fecha2;
		$array2["sub"] =  $sub;

		$this->load->view('Reportes/view_rep_ahorro_html',$array2);
		

	}


	public function get_pasajero(){

		$para = $this->input->post("parametros");
		$id_servicio = $this->input->post("id_servicio");
		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

	    $parametros = explode(",", $para);

	
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
	        $ids_provedor = $parametros[3];
	        $ids_corporativo = $parametros[4];
	        $fecha1 = $parametros[5];
	        $fecha2 = $parametros[6];

		}

        $parametros = [];

        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["id_servicio"] = $id_servicio;
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

		$parametros["proceso"] = 1;
      
	
		$rest_pasajero = $this->Mod_reportes_ahorro_net->get_pasajero($parametros);

		$rest_pasajero_det = $this->Mod_reportes_ahorro_net->get_pasajero_detalle($parametros);


		$array_nuevo_formato = [];

		
		foreach ($rest_pasajero as $key => $value) {

			   $count_group = 0;
			   $count_group_bd = (int)$value->cont;
			   $glo = utf8_encode($value->GVC_CVE_RES_GLO);

				
				foreach ($rest_pasajero_det as $key2 => $value2) {

					$dat_det['inicio']  = 0;
                    $dat_det['fin']  = 0;
					$glo_det = utf8_encode($value2->GVC_CVE_RES_GLO);
					$dat_det['GVC_NOM_VEN_TIT']  = utf8_encode($value2->GVC_NOM_VEN_TIT); 
                    $dat_det['GVC_ID_SERIE']  = utf8_encode($value2->GVC_ID_SERIE); 
                    $dat_det['GVC_DOC_NUMERO']  = utf8_encode($value2->GVC_DOC_NUMERO); 
                    $dat_det['GVC_ID_CORPORATIVO']  = utf8_encode($value2->GVC_ID_CORPORATIVO); 
                    $dat_det['GVC_ID_CLIENTE']  = utf8_encode($value2->GVC_ID_CLIENTE); 
                    $dat_det['GVC_NOM_CLI']  = utf8_encode($value2->GVC_NOM_CLI); 
                    $dat_det['GVC_CVE_RES_GLO']  = utf8_encode($value2->GVC_CVE_RES_GLO); 
                    $dat_det['analisis28_cliente']  = utf8_encode($value2->analisis28_cliente); 
                    $dat_det['GVC_FECHA']  = utf8_encode($value2->GVC_FECHA); 
                    $dat_det['GVC_BOLETO']  = utf8_encode($value2->GVC_BOLETO); 
                    $dat_det['GVC_ID_SERVICIO']  = utf8_encode($value2->GVC_ID_SERVICIO); 
                    $dat_det['TIPO_BOLETO']  = utf8_encode($value2->TIPO_BOLETO); 
                    $dat_det['GVC_ID_PROVEEDOR']  = utf8_encode($value2->GVC_ID_PROVEEDOR); 
                    $dat_det['GVC_NOMBRE_PROVEEDOR']  = utf8_encode($value2->GVC_NOMBRE_PROVEEDOR); 
                    $dat_det['GVC_CONCEPTO']  = utf8_encode($value2->GVC_CONCEPTO); 
                    $dat_det['GVC_NOM_PAX']  = utf8_encode($value2->GVC_NOM_PAX); 
                    $dat_det['GVC_TARIFA_MON_BASE']  = utf8_encode($value2->GVC_TARIFA_MON_BASE); 
                    $dat_det['GVC_IVA']  = utf8_encode($value2->GVC_IVA); 
                    $dat_det['GVC_TUA']  = utf8_encode($value2->GVC_TUA); 
                    $dat_det['GVC_OTROS_IMPUESTOS']  = utf8_encode($value2->GVC_OTROS_IMPUESTOS); 
                    $dat_det['GVC_TOTAL']  = utf8_encode($value2->GVC_TOTAL); 
                    $dat_det['analisis13_cliente']  = utf8_encode($value2->analisis13_cliente); 
                    $dat_det['analisis14_cliente']  = utf8_encode($value2->analisis14_cliente); 
                    $dat_det['analisis15_cliente']  = utf8_encode($value2->analisis15_cliente); 
                    $valor_mas_alto = max($value2->analisis13_cliente, $value2->analisis14_cliente, $value2->analisis15_cliente);
                    $dat_det['valor_mas_alto']  = $valor_mas_alto; 
                    $dat_det['ahorro']  = (float)$valor_mas_alto - (float)$value2->GVC_TOTAL;

                    	if((float)$value2->GVC_TOTAL == 0){

                              $dat_det['_ahorro']  = 0; 

                        }else{

                              $dat_det['_ahorro']  = ((float)$valor_mas_alto - (float)$value2->GVC_TOTAL)/(float)$value2->GVC_TOTAL; 

                        }
                        
                        
                        
                        $dat_det['analisis6_cliente']  = utf8_encode($value2->analisis6_cliente); 
                        $dat_det['analisis17_cliente']  = utf8_encode($value2->analisis17_cliente); 


                        //validar division entre 0

                        if(is_numeric($value2->analisis17_cliente)){

                              if((float)$value2->GVC_TARIFA_MON_BASE == 0){

                                    $dat_det['ahorro_sobre_tar_ant_desc']  =  0; 

                              }else{

                                    $dat_det['ahorro_sobre_tar_ant_desc']  =  (float)$value2->analisis17_cliente / (float)$value2->GVC_TARIFA_MON_BASE; 

                              }

                              if((float)$value2->GVC_TARIFA_MON_BASE == 0 || (float)$value2->analisis17_cliente == 0){

                                    $dat_det['_ahorro_sobre_tar_ant_desc']  =  0; 

                              }else{

                                    $dat_det['_ahorro_sobre_tar_ant_desc']  = ((float)$value2->analisis17_cliente / (float)$value2->GVC_TARIFA_MON_BASE) / (float)$value2->analisis17_cliente; 

                              }
                              
                        }else{

                              $dat_det['ahorro_sobre_tar_ant_desc']  = 0; 
                              $dat_det['_ahorro_sobre_tar_ant_desc']  = 0; 

                        }

                        
                        $dat_det['analisis32_cliente']  = utf8_encode($value2->analisis32_cliente); 
                        $dat_det['analisis35_cliente']  = utf8_encode($value2->analisis35_cliente); 
                        $dat_det['analisis57_cliente']  = utf8_encode($value2->analisis57_cliente); 
                        $dat_det['GVC_CLASE_FACTURADA']  = utf8_encode($value2->GVC_CLASE_FACTURADA); 
                        $dat_det['GVC_FECHA_SALIDA']  = utf8_encode($value2->GVC_FECHA_SALIDA); 
                        $dat_det['GVC_FECHA_REGRESO']  = utf8_encode($value2->GVC_FECHA_REGRESO); 
                        $dat_det['GVC_FECHA_EMISION_BOLETO']  = utf8_encode($value2->GVC_FECHA_EMISION_BOLETO); 
                        $dat_det['PRECOMPRA']  = utf8_encode($value2->precompra);
                        $dat_det['GVC_CLAVE_EMPLEADO']  = utf8_encode($value2->GVC_CLAVE_EMPLEADO); 
                        $dat_det['GVC_FECHA_RESERVACION']  = utf8_encode($value2->GVC_FECHA_RESERVACION); 
                        $dat_det['MES']  = $value2->MES; 
                        $dat_det['ANO']  = $value2->ANO; 
                        $dat_det['analisis26_cliente']  = utf8_encode($value2->analisis26_cliente); 
                        $dat_det['analisis11_cliente']  = utf8_encode($value2->analisis11_cliente); 
                        $dat_det['analisis23_cliente']  = utf8_encode($value2->analisis23_cliente); 
                        $dat_det['analisis1_cliente']  = utf8_encode($value2->analisis1_cliente); 
                        $dat_det['analisis18_cliente']  = utf8_encode($value2->analisis18_cliente); 

							if($glo_det == $glo){

								$count_group++;

								

										if($count_group_bd > 1){

										 
												 if($count_group == 1){

												 	$dat_det['inicio']  = 1;
                                          			$dat_det['fin']  = 0;

												 }	


												 if($count_group_bd ==  $count_group){

													$dat_det['inicio']  = 0;
                                          			$dat_det['fin']  = 1;


												 }


										}

										array_push($array_nuevo_formato, $dat_det);

							}  //fin if ==


				}
				

			} //FIN FOR AGRUPAMIENTO 


			$rest['array_nuevo_formato']  = $array_nuevo_formato;

            echo json_encode($rest);


		} 
		
	  

	public function exportar_excel_ae(){


		$parametros = $_REQUEST['parametros'];
		$id_servicio = $this->input->post("id_servicio");
		//$img_grafica = $_REQUEST['img_grafica'];

		$rest_pasajero = $_REQUEST['data'];            //se quedo como idefinido :O
		
		$rest_pasajero = json_decode($rest_pasajero);
		
		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$id_us = $this->session->userdata('session_id');
		

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
	        $ids_provedor = $parametros[3];
	        $ids_corporativo = $parametros[4];
	        $fecha1 = $parametros[5];
	        $fecha2 = $parametros[6];

		}

        $parametros = [];

        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["id_servicio"] = $id_servicio;
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

		$parametros["proceso"] = 2;

		//$rest_pasajero = $this->Mod_reportes_ahorro_net->get_pasajero($parametros);
        $rest_pasajero_det = $this->Mod_reportes_ahorro_net->get_pasajero_detalle($parametros);


        if($tipo_funcion == "aut"){
        	
        	$parametros["id_usuario"] = $id_usuario;
        	$parametros["id_intervalo"] = $id_intervalo;
        	$parametros["fecha_ini_proceso"] = $fecha_ini_proceso;
			
		}else{

			$parametros["id_usuario"] = $this->session->userdata('session_id');
	        $parametros["id_intervalo"] = '0';
	        $parametros["fecha_ini_proceso"] = '';

		}

		$parametros["proceso"] = 2;

		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');

		$spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}

		$spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
		$spreadsheet->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);


		$activeSheet->getStyle('A5:AV5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('A5:AV5')
        ->getFont()->getColor()->setARGB('ffffff');


			$activeSheet->setCellValue('A5','GVC_NOM_VEN_TIT');
			$activeSheet->setCellValue('B5','GVC_ID_SERIE');
			$activeSheet->setCellValue('C5','GVC_DOC_NUMERO');
			$activeSheet->setCellValue('D5','GVC_ID_CORPORATIVO');
			$activeSheet->setCellValue('E5','GVC_ID_CLIENTE');
			$activeSheet->setCellValue('F5','GVC_NOM_CLI');
			$activeSheet->setCellValue('G5','GVC_CVE_RES_GLO');
			$activeSheet->setCellValue('H5','analisis28_cliente');
			$activeSheet->setCellValue('I5','GVC_FECHA');
			$activeSheet->setCellValue('J5','GVC_BOLETO');
			$activeSheet->setCellValue('K5','GVC_ID_SERVICIO');
			$activeSheet->setCellValue('L5','TIPO_BOLETO');
			$activeSheet->setCellValue('M5','GVC_ID_PROVEEDOR');
			$activeSheet->setCellValue('N5','GVC_NOMBRE_PROVEEDOR');
			$activeSheet->setCellValue('O5','GVC_CONCEPTO');
			$activeSheet->setCellValue('P5','GVC_NOM_PAX');
			$activeSheet->setCellValue('Q5','GVC_TARIFA_MON_BASE');
			$activeSheet->setCellValue('R5','GVC_IVA');
			$activeSheet->setCellValue('S5','GVC_TUA');
			$activeSheet->setCellValue('T5','GVC_OTROS_IMPUESTOS');
			$activeSheet->setCellValue('U5','GVC_TOTAL');
			$activeSheet->setCellValue('V5','analisis13_cliente');
			$activeSheet->setCellValue('W5','analisis14_cliente');
			$activeSheet->setCellValue('X5','analisis15_cliente');
			$activeSheet->setCellValue('Y5','valor_mas_alto');
			$activeSheet->setCellValue('Z5','ahorro');
			$activeSheet->setCellValue('AA5','_ahorro');
			$activeSheet->setCellValue('AB5','analisis6_cliente');
			$activeSheet->setCellValue('AC5','analisis17_cliente');
			$activeSheet->setCellValue('AD5','ahorro_sobre_tar_ant_desc');
			$activeSheet->setCellValue('AE5','_ahorro_sobre_tar_ant_desc');
			$activeSheet->setCellValue('AF5','analisis32_cliente');
			$activeSheet->setCellValue('AG5','analisis35_cliente');
			$activeSheet->setCellValue('AH5','analisis57_cliente');
			$activeSheet->setCellValue('AI5','GVC_CLASE_FACTURADA');
			$activeSheet->setCellValue('AJ5','GVC_FECHA_SALIDA');
			$activeSheet->setCellValue('AK5','GVC_FECHA_REGRESO');
			$activeSheet->setCellValue('AL5','GVC_FECHA_EMISION_BOLETO');
			$activeSheet->setCellValue('AM5','PRECOMPRA');
			$activeSheet->setCellValue('AN5','GVC_CLAVE_EMPLEADO');
			$activeSheet->setCellValue('AO5','GVC_FECHA_RESERVACION');
			$activeSheet->setCellValue('AP5','MES');
			$activeSheet->setCellValue('AQ5','ANO');
			$activeSheet->setCellValue('AR5','analisis26_cliente');
			$activeSheet->setCellValue('AS5','analisis11_cliente');
			$activeSheet->setCellValue('AT5','analisis23_cliente');
			$activeSheet->setCellValue('AU5','analisis1_cliente');
			$activeSheet->setCellValue('AV5','analisis18_cliente');
			

		$spreadsheet->getActiveSheet()
			    ->getStyle('Q5:Q'.(count($rest_pasajero->array_nuevo_formato) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('R5:R'.(count($rest_pasajero->array_nuevo_formato) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('S5:S'.(count($rest_pasajero->array_nuevo_formato) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('T5:T'.(count($rest_pasajero->array_nuevo_formato) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('U5:U'.(count($rest_pasajero->array_nuevo_formato) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);


		$cont = 6;

		$styleArrayborderall = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => 'FFFFFF'],
		        ],
		    ],
		];

        $styleArraybordertop = [
		    'borders' => [
		        'top' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => 'FFFFFF'],
		        ],
		    ],
		];

      	$styleArrayborderleft = [
		    'borders' => [
		        'left' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => 'FFFFFF'],
		        ],
		    ],
		];

		$styleArrayborderright = [
		    'borders' => [
		        'right' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => 'FFFFFF'],
		        ],
		    ],
		];

		$styleArrayborderbottom = [
		    'borders' => [
		        'bottom' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => 'FFFFFF'],
		        ],
		    ],
		];


		$spreadsheet->getActiveSheet()->getStyle('A1:AV6')->applyFromArray($styleArrayborderall);

		if(count($rest_pasajero->array_nuevo_formato) > 0){


        	foreach ($rest_pasajero->array_nuevo_formato as $key => $value) {

				

        		$activeSheet->setCellValue('A'.$cont,$value->GVC_NOM_VEN_TIT);
        		$activeSheet->setCellValue('B'.$cont,$value->GVC_ID_SERIE);
        		$activeSheet->setCellValue('C'.$cont,$value->GVC_DOC_NUMERO);
        		$activeSheet->setCellValue('D'.$cont,$value->GVC_ID_CORPORATIVO);
        		$activeSheet->setCellValue('E'.$cont,$value->GVC_ID_CLIENTE);
        		$activeSheet->setCellValue('F'.$cont,$value->GVC_NOM_CLI);
        		$activeSheet->setCellValue('G'.$cont,$value->GVC_CVE_RES_GLO);
        		$activeSheet->setCellValue('H'.$cont,$value->analisis28_cliente);
        		$activeSheet->setCellValue('I'.$cont,$value->GVC_FECHA);
        		$activeSheet->setCellValue('J'.$cont,$value->GVC_BOLETO);
        		$activeSheet->setCellValue('K'.$cont,$value->GVC_ID_SERVICIO);
        		$activeSheet->setCellValue('L'.$cont,$value->TIPO_BOLETO);
        		$activeSheet->setCellValue('M'.$cont,$value->GVC_ID_PROVEEDOR);
        		$activeSheet->setCellValue('N'.$cont,$value->GVC_NOMBRE_PROVEEDOR);
        		$activeSheet->setCellValue('O'.$cont,$value->GVC_CONCEPTO);
        		$activeSheet->setCellValue('P'.$cont,$value->GVC_NOM_PAX);
        		$activeSheet->setCellValue('Q'.$cont,$value->GVC_TARIFA_MON_BASE);
        		$activeSheet->setCellValue('R'.$cont,$value->GVC_IVA);
        		$activeSheet->setCellValue('S'.$cont,$value->GVC_TUA);
        		$activeSheet->setCellValue('T'.$cont,$value->GVC_OTROS_IMPUESTOS);
        		$activeSheet->setCellValue('U'.$cont,$value->GVC_TOTAL);
        		$activeSheet->setCellValue('V'.$cont,$value->analisis13_cliente);
        		$activeSheet->setCellValue('W'.$cont,$value->analisis14_cliente);
        		$activeSheet->setCellValue('X'.$cont,$value->analisis15_cliente);

        		

        		$valor_mas_alto = max($value->analisis13_cliente, $value->analisis14_cliente, $value->analisis15_cliente);
                
                $activeSheet->setCellValue('Y'.$cont,(float)$valor_mas_alto);  //n

                $activeSheet->setCellValue('Z'.$cont,(float)$valor_mas_alto - (float)$value->GVC_TOTAL);  //n
           

            	if((float)$value->GVC_TOTAL == 0){

                      $activeSheet->setCellValue('AA'.$cont,0);  //n

                }else{

                	  $activeSheet->setCellValue('AA'.$cont,((float)$valor_mas_alto - (float)$value->GVC_TOTAL)/(float)$value->GVC_TOTAL);  //n

                     

                }
                        
                $activeSheet->setCellValue('AB'.$cont,$value->analisis6_cliente);
        		$activeSheet->setCellValue('AC'.$cont,$value->analisis17_cliente);        
                        
                      
                //validar division entre 0

                if(is_numeric($value->analisis17_cliente)){

                      if((float)$value->GVC_TARIFA_MON_BASE == 0){

                            $activeSheet->setCellValue('AD'.$cont,0);  //n

                      }else{

                      		$activeSheet->setCellValue('AD'.$cont,(float)$value->analisis17_cliente / (float)$value->GVC_TARIFA_MON_BASE);        


                      }

                      if((float)$value->GVC_TARIFA_MON_BASE == 0 || (float)$value->analisis17_cliente == 0){

                            $activeSheet->setCellValue('AE'.$cont,0);        

                      }else{

                      		$activeSheet->setCellValue('AE'.$cont,((float)$value->analisis17_cliente / (float)$value->GVC_TARIFA_MON_BASE) / (float)$value->analisis17_cliente);     


                      }
                      
                }else{

                      $activeSheet->setCellValue('AD'.$cont,0);        
                      $activeSheet->setCellValue('AE'.$cont,0);        

                }


        		$activeSheet->setCellValue('AF'.$cont,$value->analisis32_cliente);
        		$activeSheet->setCellValue('AG'.$cont,$value->analisis35_cliente);
        		$activeSheet->setCellValue('AH'.$cont,$value->analisis57_cliente);
        		$activeSheet->setCellValue('AI'.$cont,$value->GVC_CLASE_FACTURADA);
        		$activeSheet->setCellValue('AJ'.$cont,$value->GVC_FECHA_SALIDA);
        		$activeSheet->setCellValue('AK'.$cont,$value->GVC_FECHA_REGRESO);
        		$activeSheet->setCellValue('AL'.$cont,$value->GVC_FECHA_EMISION_BOLETO);

        		$activeSheet->setCellValue('AM'.$cont,$value->PRECOMPRA);

        		$activeSheet->setCellValue('AN'.$cont,$value->GVC_CLAVE_EMPLEADO);
        		$activeSheet->setCellValue('AO'.$cont,$value->GVC_FECHA_RESERVACION);
        		$activeSheet->setCellValue('AP'.$cont,$value->MES);
        		$activeSheet->setCellValue('AQ'.$cont,$value->ANO);
        		$activeSheet->setCellValue('AR'.$cont,$value->analisis26_cliente);
        		$activeSheet->setCellValue('AS'.$cont,$value->analisis11_cliente);
        		$activeSheet->setCellValue('AT'.$cont,$value->analisis23_cliente);
        		$activeSheet->setCellValue('AU'.$cont,$value->analisis1_cliente);
        		$activeSheet->setCellValue('AV'.$cont,$value->analisis18_cliente);

        	if($value->inicio == '1' && $value->fin == '0'){  //comienza  arriba
           		
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderleft);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderright);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderbottom);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);	


            }else if($value->inicio == '0' && $value->fin == '1'){  //termina  abajo

                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderleft);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderright);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArraybordertop);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            }else if($value->inicio == '0' && $value->fin == '0'){  //cuando no hay linea

                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderleft);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderright);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArraybordertop);
                $spreadsheet->getActiveSheet()->getStyle('A'.$cont.':AV'.$cont)->applyFromArray($styleArrayborderbottom);

            }


            $cont++;

		} //FIN FOR AGRUPAMIENTO 
	

	    $spreadsheet->getActiveSheet()->getStyle('P'.(count($rest_pasajero->array_nuevo_formato) + 6).':U'.(count($rest_pasajero->array_nuevo_formato) + 6).'')
        ->getFont()->getColor()->setARGB('ffffff');

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
       
		$activeSheet->setCellValue('F1','AHORRO' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);

		$ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");

		$str_razon_social = "";
		$str_corporativo = "";

		if($tipo_funcion == "aut"){
        	
        		$rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

        		$rango_fechas = explode("_", $rango_fechas);

        		$fecha1 = $rango_fechas[0];
        		$fecha2 = $rango_fechas[1];

        	   	$activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);

		 		foreach ($rest_pasajero->array_nuevo_formato as $clave => $valor) {

					$str_razon_social = $str_razon_social . $valor->GVC_NOM_CLI . '/';
					$str_corporativo = $str_corporativo . $valor->GVC_ID_CORPORATIVO . '/';
							
				}
    

		}else{

			$activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);

		}

		$str_razon_social = "";
		$str_corporativo = "";

 		foreach ($rest_pasajero->array_nuevo_formato as $clave => $valor) {

			$str_razon_social = $str_razon_social . $valor->GVC_NOM_CLI . '/';
			$str_corporativo = $str_corporativo . $valor->GVC_ID_CORPORATIVO . '/';
					
		}

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

            	
                $rz = $this->Mod_reportes_ahorro_net->get_razon_social_id_in($ids_cliente);  //optiene razon social

                
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


			if($tipo_funcion == "aut"){

				$str_fecha = $fecha1.'_A_'.$fecha2;

	       		$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_ahorro_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');

	       		echo json_encode(1); //cuando es uno si tiene informacion

		    }else{

		    	$fecha1 = explode('/', $fecha1);
		        $dia1 = $fecha1[0];
		        $mes1 = $fecha1[1];
		        $ano1 = $fecha1[2];
		        $fecha1 = $ano1.'_'.$mes1.'-'.$dia1;

		        $fecha2 = explode('/', $fecha2);
		        $dia2 = $fecha2[0];
		        $mes2 = $fecha2[1];
		        $ano2 = $fecha2[2];
		        $fecha2 = $ano2.'_'.$mes2.'_'.$dia2;

				ob_start();
				$Excel_writer->save("php://output");
				$xlsData = ob_get_contents();
				ob_end_clean();
				 
				$opResult = array(
						'str_fecha'=> $fecha1.'_A_'.$fecha2,
				        'status' => 1,
				        'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
				     );

		    	echo json_encode($opResult);
				
		     }

	 }else{

			if($tipo_funcion != "aut"){

	       	    echo json_encode(0); //cuando es uno si tiene informacion

	        }else{

	        	echo json_encode(0); //cuando es uno si tiene informacion

	        }
			
		}
	

		
	}



}
