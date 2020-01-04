<?php
set_time_limit(0);
ini_set('post_max_size','10000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_total_precompra_aerea extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_total_precompra_aerea');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->load->model('Mod_general');
		  $this->Mod_general->get_SPID();
	     
	}

	public function get_html_rep_total_precompra_ae(){

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

		$this->load->view('Reportes/view_rep_total_precompra_aerea');
		
	}

	public function get_rep_total_precompra_aerea_html(){

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
                
                $rz = $this->Mod_reportes_total_precompra_aerea->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

		$this->load->view('Reportes/view_rep_total_precompra_aerea_html',$array2);
		

	}


	public function get_precompra(){

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
			$ids_servicio = $parametros[3];
	        $ids_provedor = $parametros[4];
	        $ids_corporativo = $parametros[5];
	        $fecha1 = $parametros[6];
	        $fecha2 = $parametros[7];

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


		$parametros["proceso"] = 1;
      	
		$rest_precompra = $this->Mod_reportes_total_precompra_aerea->get_precompra($parametros);
		
		$array_ids_precompra = array_unique($rest_precompra['array_ids_precompra']);
		$array_data = $rest_precompra['array_data'];

		$array_totalizado = [];

		foreach ($array_ids_precompra as $clave => $valor) {

			$array_precompra_bd = [];
			$array_precompra_bi = [];
			$cont_transac_bd = 0;
			$sum_tarifa_bd = 0;
			$cont_transac_bi = 0;
			$sum_tarifa_bi = 0;
			foreach ($array_data as $clave2 => $valor2) {

				$GVC_ID_PRECOMPRA = $valor2->GVC_ID_PRECOMPRA;
			    $GVC_TARIFA_MON_BASE =  (int)$valor2->GVC_TARIFA_MON_BASE;

					if($GVC_ID_PRECOMPRA ==  $valor){
						
						if($valor2->GVC_ID_SERVICIO == 'BOL. DOM.'){

							$cont_transac_bd++;

							$array_precompra_bd['tipo_servicio'] = 'BD';
							$array_precompra_bd['dias_precompra'] = $GVC_ID_PRECOMPRA;
							$array_precompra_bd['ntransacciones'] = $cont_transac_bd;

							$sum_tarifa_bd = $sum_tarifa_bd + $GVC_TARIFA_MON_BASE;

							$array_precompra_bd['tarifa'] = $sum_tarifa_bd;


						}

						if($valor2->GVC_ID_SERVICIO == 'BOL. INT.'){

							$cont_transac_bi++;

							$array_precompra_bi['tipo_servicio'] = 'BI';
							$array_precompra_bi['dias_precompra'] = $GVC_ID_PRECOMPRA;
							$array_precompra_bi['ntransacciones'] = $cont_transac_bi;

							$sum_tarifa_bi = $sum_tarifa_bi + $GVC_TARIFA_MON_BASE;

							$array_precompra_bi['tarifa'] = $sum_tarifa_bi;


						}

					}

			

			}

			if(count($array_precompra_bd) > 0){

				array_push($array_totalizado, $array_precompra_bd);

			}
			
			if(count($array_precompra_bi) > 0){

				array_push($array_totalizado, $array_precompra_bi);
				
			}	
			


		}

		
		echo json_encode($array_totalizado); //cuando es uno si tiene informacion

	}

	public function exportar_excel_total_pre(){

		$parametros = $_REQUEST['parametros'];
		$id_servicio = $this->input->post("id_servicio");

		$rest_precompra = $_REQUEST['data'];
		
		$rest_precompra = json_decode($rest_precompra);

		$new_array = [];
		
		$tipo_funcion = $_REQUEST['tipo_funcion']; 

		$id_us = $this->session->userdata('session_id');
		
		$parametros = explode(",", $parametros);

		//print_r($parametros);

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
	        $fecha1 = $parametros[6];
	        $fecha2 = $parametros[7];


		}

        $parametros = [];

        $parametros["ids_suc"] = $ids_suc;
        $parametros["ids_serie"] = $ids_serie;
        $parametros["ids_cliente"] = $ids_cliente;
        $parametros["id_servicio"] = $ids_servicio;
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

		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);


		 $styleArray = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ],
		];

		$spreadsheet->getActiveSheet()->getStyle('A1:G'. (  (int)(count($rest_precompra)) + 5) )->applyFromArray($styleArray);

		$spreadsheet->getActiveSheet()->getStyle('A6')
        ->getFont()->setSize(10);

        $spreadsheet->getActiveSheet()
		    ->duplicateStyle(
		        $spreadsheet->getActiveSheet()->getStyle('A6'),
		        'A6'.':G'.(count($rest_precompra)+ 17)  .''
		    );


		$activeSheet->setCellValue('C10','DIAS DE PRECOMPRA' )->getStyle('B26')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('C10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeSheet->setCellValue('D10','# TRANSACCIONES' )->getStyle('C26')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('D10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$activeSheet->setCellValue('E10','TARIFA/Pesos' )->getStyle('C26')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('E10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$activeSheet->getStyle('C10:E10')->getFill()
		    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('C10:E10')
        ->getFont()->getColor()->setARGB('ffffff');
		

		if(count($rest_precompra) > 0){

		    $contbd = 10;
		    $total_bd = 0;
		    $total_transac_bd = 0;
		    foreach ($rest_precompra as $clave => $valor) {

				if($valor->tipo_servicio == "BD"){
					$contbd++;

					$activeSheet->setCellValue('C'.$contbd,$valor->dias_precompra );
					$activeSheet->setCellValue('D'.$contbd,$valor->ntransacciones );
					$spreadsheet->getActiveSheet()->getStyle('D'.$contbd)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					$activeSheet->setCellValue('E'.$contbd,number_format((float)$valor->tarifa));
					$spreadsheet->getActiveSheet()->getStyle('E'.$contbd)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
					$total_bd = $total_bd + (float)$valor->tarifa;
					$total_transac_bd = $total_transac_bd + (int)$valor->ntransacciones;

				}

												
			}

		
			$contbi = $contbd + 1;

			$activeSheet->setCellValue('C'.$contbi,'TOTAL BOLETOS DOMESTICOS' )->getStyle('C'.$contbi)->getFont()->setBold(true);
			$activeSheet->setCellValue('D'.$contbi,$total_transac_bd )->getStyle('D'.$contbi)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('D'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->setCellValue('E'.$contbi,number_format((float)$total_bd) )->getStyle('E'.$contbi)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('E'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);


			$contbi = $contbi + 1;
			$total_bi = 0;
			$total_transac_bi = 0;
			foreach ($rest_precompra as $clave => $valor) {

				if($valor->tipo_servicio == "BI"){
					$contbi++;

					$activeSheet->setCellValue('C'.$contbi,$valor->dias_precompra );
					$activeSheet->setCellValue('D'.$contbi,$valor->ntransacciones );
					$spreadsheet->getActiveSheet()->getStyle('D'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					$activeSheet->setCellValue('E'.$contbi,number_format((float)$valor->tarifa));
					$spreadsheet->getActiveSheet()->getStyle('E'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
					$total_bi = $total_bi + (float)$valor->tarifa;
					$total_transac_bi = $total_transac_bi + (int)$valor->ntransacciones;

				}
												
			}

			$contbi = $contbi + 1;

			$activeSheet->setCellValue('C'.$contbi,'TOTAL BOLETOS INTERNACIONALES' )->getStyle('C'.$contbi)->getFont()->setBold(true);
			$activeSheet->setCellValue('D'.$contbi,$total_transac_bi )->getStyle('D'.$contbi)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('D'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->setCellValue('E'.$contbi,number_format((float)$total_bi) )->getStyle('E'.$contbi)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('E'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

			$contbi = $contbi + 1;

			$total_gen = $total_bd + $total_bi;
			$total_gen_transac = $total_transac_bd + $total_transac_bi;

			$activeSheet->setCellValue('C'.$contbi,'Total general')->getStyle('C'.$contbi)->getFont()->setBold(true);
			$activeSheet->setCellValue('D'.$contbi,$total_gen_transac )->getStyle('D'.$contbi)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('D'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->setCellValue('E'.$contbi,number_format((float)$total_gen) )->getStyle('E'.$contbi)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('E'.$contbi)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

			$spreadsheet->getActiveSheet()->mergeCells('C'.($contbi + 1).':'.'E'.($contbi + 1));
			$spreadsheet->getActiveSheet()->mergeCells('C'.($contbi + 2).':'.'E'.($contbi + 2));
			$spreadsheet->getActiveSheet()->mergeCells('C'.($contbi + 3).':'.'E'.($contbi + 3));

			$activeSheet->setCellValue('C'.($contbi + 1),'El consumo es la tarifa antes de impuestos de iva y tua.')->getStyle('C'.($contbi + 1))->getFont()->setBold(true);
			$activeSheet->setCellValue('C'.($contbi + 2),'El consumo es de tarifa de servicios de vuelos.(No cargos por cambios y revisados)' )->getStyle('C'.($contbi + 2))->getFont()->setBold(true);
			$activeSheet->setCellValue('C'.($contbi + 3),'Cantidades en Pesos Mexicanos' )->getStyle('C'.($contbi + 3))->getFont()->setBold(true);

			$spreadsheet->getActiveSheet()->getStyle('C'.($contbi + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.($contbi + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$spreadsheet->getActiveSheet()->getStyle('C'.($contbi + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			$activeSheet->getStyle('C'.$contbi.':E'.$contbi.'')->getFill()
		    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		    ->getStartColor()->setARGB('010101');

		    $spreadsheet->getActiveSheet()->getStyle('C'.$contbi.':E'.$contbi.'')
	        ->getFont()->getColor()->setARGB('ffffff');

	        $spreadsheet->getActiveSheet()->mergeCells('C6:E6');

			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);

			
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
				$drawing2->setCoordinates('F1');
				$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/img/91_4c.gif');
				$drawing2->setHeight(60);
				$drawing2->setWidth(60);
		        $drawing2->setWorksheet($spreadsheet->getActiveSheet());

				$activeSheet->setCellValue('C6','Precompra aerea' )->getStyle('C6')->getFont()->setBold(true)->setSize(30);

				$spreadsheet->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		        

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

				        if(count($ids_corporativo) > 0 ){
				        	  $title = "";
			            	  $rango_fecha =  $fecha1 . ' - ' . $fecha2;
				              $sub = "";

				              if(count($ids_corporativo) > 1){

				              	    $title = "Clientes Villatours";

				              }else{

				              	foreach ($ids_corporativo as $clave => $valor) { 
				  
				                 	$sub = $sub . $valor;

				              	}

				              }

			            }
			            
			            else if(count($ids_cliente) > 0){
			            	$title = "";
			            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
			            	$sub = "";
			                
			                $rz = $this->Mod_reportes_total_precompra_aerea->get_razon_social_id_in($ids_cliente);
			                
			                if(count($rz) > 1){

			                	  $title = "Clientes Villatours";
			                	  
			                }else{

			                	foreach ($rz as $clave => $valor) {  

				                   $sub = $sub . $valor->nombre_cliente;

				            	}
			                }
			                
			            }else{

			            	$title = "Clientes Villatours";
			            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
			            	$sub = "";

			            }
						

				}else{
					
					if(count($ids_corporativo) > 0 ){
						$title = "";
		            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
		            	$sub = "";

			              if(count($ids_corporativo) > 1){

			              	    $title = "Clientes Villatours";

			              }else{

			              	foreach ($ids_corporativo as $clave => $valor) {  //obtiene clientes asignados

			                 	$sub = $sub . $valor;


			              	}

			              }

		            }

		            else if(count($ids_cliente) > 0){
		            	$title = "";
		            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
		            	$sub = "";
		                
		                $rz = $this->Mod_reportes_total_precompra_aerea->get_razon_social_id_in($ids_cliente);  //optiene razon social
		                
		                if(count($rz) > 1){

		                	  $title = "Clientes Villatours";
		                	  
		                }else{

		                	foreach ($rz as $clave => $valor) {  //obtiene clientes asignados

			                   $sub = $sub . $valor->nombre_cliente;

			            	}
		                }
		                
		            }else{

		            	$title = "Clientes Villatours";
		            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
		            	$sub = "";

		            }

		        
				}

				$spreadsheet->getActiveSheet()->mergeCells('C7:E7');
				$spreadsheet->getActiveSheet()->mergeCells('C8:E8');
				$spreadsheet->getActiveSheet()->mergeCells('C9:E9');

				$activeSheet->setCellValue('C7', utf8_encode($title) )->getStyle('C7')->getFont()->setBold(true)->setSize(14);
				$spreadsheet->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				$activeSheet->setCellValue('C8', utf8_encode($sub) )->getStyle('C8')->getFont()->setBold(true)->setSize(14);
				$spreadsheet->getActiveSheet()->getStyle('C8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

				$activeSheet->setCellValue('C9', utf8_encode($rango_fecha) )->getStyle('C9')->getFont()->setSize(14);
				$spreadsheet->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



				if($tipo_funcion == "aut"){

		       		$str_fecha = $fecha1.'_A_'.$fecha2;
			       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/Reporte_total_precompra_ae_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
			       	echo json_encode(1); //cuando es uno si tiene informacion

			    }else{

					$fecha1 = explode('/', $fecha1);
			        $dia1 = $fecha1[0];
			        $mes1 = $fecha1[1];
			        $ano1 = $fecha1[2];
			        $fecha1 = $ano1.'_'.$mes1.'_'.$dia1;

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
							'str_fecha'=> $fecha1.'_'.$fecha2,
					        'status' => 1,
					        'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
					     );

			    	echo json_encode($opResult);
					
			     }


		}else{

			if($tipo_funcion != "aut"){

	       	    echo json_encode(0);

	        }else{

	        	echo json_encode(0); //cuando es uno si tiene informacion

	        }
			
		}

	}//fin de count
	


}
