<?php

set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

//php excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_gastos_gen extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_gastos_gen');
	      $this->load->model('Mod_general');
	      $this->load->model('Reportes/Mod_reportes_gvc_reporteador');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->Mod_general->get_SPID();
	     
	}

	public function get_html_rep_gastos_generales(){

		$title = $this->input->post('title');
		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();
		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();
		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio();
		$rest_catalogo_id_provedor = $this->Mod_catalogos_filtros->get_catalogo_id_provedor();
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,3);
		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);

		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
	    $param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_catalogo_id_servicio"] = $rest_catalogo_id_servicio;
	    $param["rest_catalogo_id_provedor"] = $rest_catalogo_id_provedor;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param["rest_clientes"] = $rest_clientes;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Reportes/view_rep_gastos_generales');
		
	}

	
	public function get_prueba_grafica(){
        

        $para = $this->input->post("parametros");
		$proceso = $this->input->post("proceso");

		$parametros = explode(",", $para);

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
        $parametros["proceso"] = 1;
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';

		$rest_grafica = $this->Mod_reportes_gastos_gen->get_prueba_grafica($parametros);
		
		
		$array1 = array();

		    foreach ($rest_grafica as $clave => $valor) {
			    	
					if($valor->name == "BOL. DOM."){
						array_push($array1, $valor);
					}

			}
			foreach ($rest_grafica as $clave => $valor) {
			    	
					if($valor->name == "BOL. INT."){
						array_push($array1, $valor);
					}

			}
			foreach ($rest_grafica as $clave => $valor) {
			    	
					if($valor->name == "HOTEL INT."){
						array_push($array1, $valor);
					}

			}
			foreach ($rest_grafica as $clave => $valor) {
			    	
					if($valor->name == "TRANSP."){
						array_push($array1, $valor);
					}

			}
			foreach ($rest_grafica as $clave => $valor) {
			    	
					if($valor->name == "CARGO X SERV."){
						array_push($array1, $valor);
					}

			}
			foreach ($rest_grafica as $clave => $valor) {
			    	
					if($valor->name == "OTROS2"){
						$valor->name = "OTROS";
						array_push($array1, $valor);
					}

			}

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
                
                $rz = $this->Mod_reportes_gastos_gen->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

			$array2 = [];
			$array2["grafica"] = $array1;
			$array2["sub"] = $sub;
        	
        	if($proceso == 'man'){
        		
        		$this->load->view('Reportes/formatos/view_formato_html_gastos_gen',$array2);
        		
        	}else{

        		
        		echo json_encode($array2, JSON_NUMERIC_CHECK);

        	}

	
	}

    public function guardar_img_grafica(){

    	$id_user = $this->session->userdata('session_id');

    	$url_img = $this->input->post("url_img");
    	$parametros = $this->input->post("parametros");
        
        $parametros = explode(",", $parametros);
        
        $fecha1 = $parametros[7];
        $fecha2 = $parametros[8];


        $id_correo_automatico = $parametros[9];
        $id_reporte = $parametros[10];
        $id_intervalo = $parametros[12];
        $fecha_ini_proceso = $parametros[13];

		$grafica = $this->input->post("grafica");

		
	     $this->load->library('FPDF');
		 $pdf=new FPDF(); 
	     define('FPDF_FONTPATH',base_url().'application/referencias/fpdf181/font');
	     $pdf->AddPage(); 
	     $pdf->SetFont('Arial','',16); 
	     
	     $pdf->Image($url_img , 30 ,31, 150 , 100,'jpg');

	     $pdf->SetFont('Arial','',8); 
	     $pdf->SetXY(30, 120);
	     $pdf->Write(20, '#TRANSAC');

		    $cont = 0;
			foreach ($grafica['grafica'] as $clave => $valor) {
				    	
						if($cont == 0){

							$pdf->SetFont('Arial','',8); 
						    $pdf->SetXY(60, 130);
						    $pdf->Write(0,$valor['total_boletos']);

						}else if($cont == 1){

							$pdf->SetFont('Arial','',8); 
						    $pdf->SetXY(80, 130);
						    $pdf->Write(0,$valor['total_boletos']);

						}else if($cont == 2){

							$pdf->SetFont('Arial','',8); 
						    $pdf->SetXY(103, 130);
						    $pdf->Write(0,$valor['total_boletos']);

						}else if($cont == 3){

							$pdf->SetFont('Arial','',8); 
						    $pdf->SetXY(123, 130);
						    $pdf->Write(0,$valor['total_boletos']);

						}else if($cont == 4){

							$pdf->SetFont('Arial','',8); 
						    $pdf->SetXY(143, 130);
						    $pdf->Write(0,$valor['total_boletos']);

						}else if($cont == 5){

						    $pdf->SetFont('Arial','',8); 
						    $pdf->SetXY(165, 130);
						    $pdf->Write(0,$valor['total_boletos']);

						}

						$cont++;
				
				}

  
		

        		 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

        		 $rango_fechas = explode("_", $rango_fechas);

        		 $fecha1 = $rango_fechas[0];
        		 $fecha2 = $rango_fechas[1];


		        $str_fecha = $fecha1.'_A_'.$fecha2;
    			$pdf->Output('F',$_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/graficas_export/Reporte_GG_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.pdf');
    			echo json_encode(1); //cuando es uno si tiene informacion

				
				
    }



	public function exportar_excel_usuario(){
		
		$parametros = $_REQUEST['parametros'];
		$tipo_funcion = $_REQUEST['tipo_funcion'];
        
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
        
       	if($tipo_funcion == "aut"){
        	
        	$id_correo_automatico = $parametros[9];
            $id_reporte = $parametros[10];
            $id_usuario = $parametros[11];
            $id_intervalo = $parametros[12];
            $fecha_ini_proceso = $parametros[13];
			
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

        $parametros["proceso"] = 2;
        
		$rest = $this->Mod_reportes_gastos_gen->get_reportes_gastos_gen($parametros);
		
		$rep = [];
		foreach($rest as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($rep, $cast_utf8);
		    
		}
		
		if(count($rep) > 0){
			
		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);
		
		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();
		
		foreach(range('A','Z') as $columnID) {

		    $activeSheet->getColumnDimension($columnID)->setAutoSize(true);

		}
		
		$spreadsheet->getActiveSheet()->getStyle('A6')
        ->getFont()->setSize(10);

        $spreadsheet->getActiveSheet()
		    ->duplicateStyle(
		        $spreadsheet->getActiveSheet()->getStyle('A6'),
		        'A6'.':AB'.((count($rep)) + 6).''
		    );
		
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
		
		$spreadsheet->getActiveSheet()
	    ->getStyle('P5:P'.(count($rep) + 5))
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('Q5:Q'.(count($rep) + 5))
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('R5:R'.(count($rep) + 5))
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('S5:S'.(count($rep) + 5))
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('T5:T'.(count($rep) + 5))
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

	    $spreadsheet->getActiveSheet()
	    ->getStyle('U5:U'.(count($rep) + 5))
	    ->getNumberFormat()
	    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$activeSheet->setCellValue('A5','SERIE');
		$activeSheet->setCellValue('B5','DOCUMENTO');
		$activeSheet->setCellValue('C5','CORPORATIVO');
		$activeSheet->setCellValue('D5','CLIENTE');
		$activeSheet->setCellValue('E5','NOMBRE CLIENTE');
		$activeSheet->setCellValue('F5','CC');
		$activeSheet->setCellValue('G5','DESC CC');
		$activeSheet->setCellValue('H5','FECHA DOCUMENTO');
		$activeSheet->setCellValue('I5','QUIEN SOLICITO');
		$activeSheet->setCellValue('J5','PNR');
		$activeSheet->setCellValue('K5','BOLETO');
		$activeSheet->setCellValue('L5','CVE DE SERVICIO');
		$activeSheet->setCellValue('M5','CVE DE PROVEEDOR');

		$activeSheet->setCellValue('N5','NOMBRE PROVEEDOR');

		$activeSheet->setCellValue('O5','RUTA');
		$activeSheet->setCellValue('P5','PASAJERO');
		$activeSheet->setCellValue('Q5','TARIFA');
		$activeSheet->setCellValue('R5','IVA');
		$activeSheet->setCellValue('S5','TUA');
		$activeSheet->setCellValue('T5','OTROS IMPUESTOS');
		$activeSheet->setCellValue('U5','TOTAL');
		$activeSheet->setCellValue('V5','CLASE');
		$activeSheet->setCellValue('W5','FECHA DE SALIDA');
		$activeSheet->setCellValue('X5','FECHA DE REGRESO');
		$activeSheet->setCellValue('Y5','FECHA DE EMISION');
		$activeSheet->setCellValue('Z5','NUMERO DE EMPLEADO');
		$activeSheet->setCellValue('AA5','CVE FORMA DE PAGO');
		$activeSheet->setCellValue('AB5','FECHA DE RESERVACION');

		//totales-----------------------------------------
		$array_tot_gen_GVC_TARIFA_MON_BASE = [];
		$array_tot_gen_GVC_IVA = [];
		$array_tot_gen_GVC_TUA = [];
		$array_tot_gen_GVC_OTROS_IMPUESTOS = [];
		$array_tot_gen_total = [];

		foreach ($rep as $valor) {

        	$GVC_TARIFA_MON_BASE = $valor["GVC_TARIFA_MON_BASE"];
        	$GVC_IVA = $valor["GVC_IVA"];
        	$GVC_TUA = $valor["GVC_TUA"];
        	$GVC_OTROS_IMPUESTOS = $valor["GVC_OTROS_IMPUESTOS"];
        	$GVC_TOTAL = $valor["GVC_TOTAL"];

        	array_push($array_tot_gen_GVC_TARIFA_MON_BASE, $GVC_TARIFA_MON_BASE);
			array_push($array_tot_gen_GVC_IVA, $GVC_IVA);
			array_push($array_tot_gen_GVC_TUA, $GVC_TUA);
			array_push($array_tot_gen_GVC_OTROS_IMPUESTOS, $GVC_OTROS_IMPUESTOS);
			array_push($array_tot_gen_total, $GVC_TOTAL);



       	}

       	$tot_gen_GVC_TARIFA_MON_BASE = array_sum($array_tot_gen_GVC_TARIFA_MON_BASE);
		$tot_gen_GVC_IVA = array_sum($array_tot_gen_GVC_IVA);
		$tot_gen_GVC_TUA = array_sum($array_tot_gen_GVC_TUA);
		$tot_gen_GVC_OTROS_IMPUESTOS = array_sum($array_tot_gen_GVC_OTROS_IMPUESTOS);
		$tot_gen_total = array_sum($array_tot_gen_total);


		$activeSheet->setCellValue('P'.((count($rep)) + 6),'TOTAL GENERAL')->getStyle('P'.((count($rep)) + 6));
		$activeSheet->setCellValue('Q'.((count($rep)) + 6),$tot_gen_GVC_TARIFA_MON_BASE)->getStyle('Q'.((count($rep)) + 6));
		$activeSheet->setCellValue('R'.((count($rep)) + 6),$tot_gen_GVC_IVA)->getStyle('R'.((count($rep)) + 6));
		$activeSheet->setCellValue('S'.((count($rep)) + 6),$tot_gen_GVC_TUA)->getStyle('S'.((count($rep)) + 6));
		$activeSheet->setCellValue('T'.((count($rep)) + 6),$tot_gen_GVC_OTROS_IMPUESTOS)->getStyle('T'.((count($rep)) + 6));
		$activeSheet->setCellValue('U'.((count($rep)) + 6),$tot_gen_total)->getStyle('U'.((count($rep)) + 6));

		$spreadsheet->getActiveSheet()->getStyle('P'.((count($rep)) + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$activeSheet->getStyle('P'.((count($rep)) + 6).':U'.((count($rep)) + 6).'')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('010101');

	    $spreadsheet->getActiveSheet()->getStyle('P'.((count($rep)) + 6).':U'.((count($rep)) + 6).'')
        ->getFont()->getColor()->setARGB('ffffff');

        $spreadsheet->getActiveSheet()
			    ->getStyle('Q5:Q'.((count($rep)) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('R5:R'.((count($rep)) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('S5:S'.((count($rep)) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('T5:T'.((count($rep)) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

		$spreadsheet->getActiveSheet()
			    ->getStyle('U5:U'.((count($rep)) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
		//fin totales-----------------------------------------
		
		$activeSheet->fromArray(
	        $rep,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A6'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

		$activeSheet->getStyle('A5:AB5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('A5:AB5')
        ->getFont()->getColor()->setARGB('ffffff');

		 $styleArray = [
		    'borders' => [
		        //'diagonalDirection' => \PhpOffice\PhpSpreadsheet\Style\Borders::DIAGONAL_BOTH,
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ],
		];

		$spreadsheet->getActiveSheet()->getStyle('A1:AB'.(count($rep) + 5))->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:AB4')->applyFromArray($styleArray);

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);



		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);


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
       
		$activeSheet->setCellValue('F1','GASTOS GENERALES' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);

		if($tipo_funcion == "aut"){

        		 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

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

		$str_razon_social = "";
		$str_corporativo = "";

 		foreach ($rep as $clave => $valor) {

			$str_razon_social = $str_razon_social . $valor['GVC_NOM_CLI'] . '/';
			$str_corporativo = $str_corporativo . $valor['GVC_ID_CORPORATIVO'] . '/';
					
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

            	
                $rz = $this->Mod_reportes_gastos_gen->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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


		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');


       if($tipo_funcion == "aut"){

       	$str_fecha = $fecha1.'_A_'.$fecha2;
       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/Reporte_GG_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
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

    	header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte_GG_'.$fecha1.'_A_'.$fecha2.'.xlsx"'); 
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


	public function get_rep_gastos_generales(){

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
        $parametros["proceso"] = 1;
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';

		$rep = $this->reportes_gastos_gen($parametros);

		//print_r($rep);

		$col = $this->Mod_reportes_gastos_gen->get_columnas($id_plantilla,3);

		$param_final['rep'] = $rep;
		$param_final['col'] = $col;

		echo json_encode($param_final);

	}

	public function reportes_gastos_gen($parametros){
		
		  $rest = $this->Mod_reportes_gastos_gen->get_reportes_gastos_gen($parametros);
		  
		    $array1 = array();

		    foreach ($rest as $clave => $valor) {
			 		

			    $valor->GVC_ID_SERIE = utf8_encode($valor->GVC_ID_SERIE); 
			    $valor->GVC_DOC_NUMERO = utf8_encode($valor->GVC_DOC_NUMERO); 
			    $valor->GVC_ID_CORPORATIVO = utf8_encode($valor->GVC_ID_CORPORATIVO); 
			    $valor->GVC_ID_CLIENTE = utf8_encode($valor->GVC_ID_CLIENTE); 
			    $valor->GVC_NOM_CLI = utf8_encode($valor->GVC_NOM_CLI); 
			    $valor->GVC_ID_CENTRO_COSTO = utf8_encode($valor->GVC_ID_CENTRO_COSTO); 
			    $valor->GVC_DESC_CENTRO_COSTO = utf8_encode($valor->GVC_DESC_CENTRO_COSTO); 
			    $valor->GVC_FECHA = utf8_encode($valor->GVC_FECHA); 
			    $valor->GVC_SOLICITO = utf8_encode($valor->GVC_SOLICITO); 
			    $valor->GVC_CVE_RES_GLO = utf8_encode($valor->GVC_CVE_RES_GLO); 
				$valor->GVC_BOLETO = utf8_encode($valor->GVC_BOLETO); 
				$valor->GVC_ID_SERVICIO = utf8_encode($valor->GVC_ID_SERVICIO); 
				$valor->GVC_ID_PROVEEDOR = utf8_encode($valor->GVC_ID_PROVEEDOR); 
				$valor->GVC_NOMBRE_PROVEEDOR = utf8_encode($valor->GVC_NOMBRE_PROVEEDOR); 
				$valor->GVC_CONCEPTO = utf8_encode($valor->GVC_CONCEPTO); 
				$valor->GVC_NOM_PAX = utf8_encode($valor->GVC_NOM_PAX); 
				$valor->GVC_TARIFA_MON_BASE = utf8_encode ($valor->GVC_TARIFA_MON_BASE); 
				$valor->GVC_IVA = utf8_encode($valor->GVC_IVA); 
				$valor->GVC_TUA = utf8_encode($valor->GVC_TUA); 
				$valor->GVC_OTROS_IMPUESTOS = utf8_encode($valor->GVC_OTROS_IMPUESTOS); 
				$valor->GVC_TOTAL = utf8_encode($valor->GVC_TOTAL);  
				$valor->GVC_CLASE_FACTURADA = utf8_encode($valor->GVC_CLASE_FACTURADA); 
				$valor->GVC_FECHA_SALIDA = utf8_encode($valor->GVC_FECHA_SALIDA); 
				$valor->GVC_FECHA_REGRESO = utf8_encode($valor->GVC_FECHA_REGRESO); 
				$valor->GVC_FECHA_EMISION_BOLETO = utf8_encode($valor->GVC_FECHA_EMISION_BOLETO); 
				$valor->GVC_CLAVE_EMPLEADO = utf8_encode($valor->GVC_CLAVE_EMPLEADO); 
				$valor->GVC_FOR_PAG1 = utf8_encode($valor->GVC_FOR_PAG1); 
				$valor->GVC_FECHA_RESERVACION = utf8_encode($valor->GVC_FECHA_RESERVACION); 

				array_push($array1, $valor);

			}

				
				return $array1;
		
	}

	public function get_catalogo_reportes(){

		//$id_perfil = $this->input->get('id_perfil');
		$id_perfil = $_REQUEST['id_perfil'];

		$reportes = $this->Mod_reportes_gastos_gen->get_catalogo_reportes($id_perfil);

		$array1 = array();

		    foreach ($reportes as $clave => $valor) {
			    	array_push($array1, $valor);
			}

			echo json_encode($array1);


	}

	public function prueba_mach(){

		$reportes = $this->Mod_reportes_gastos_gen->prueba_mach();
		$reportesdup = $this->Mod_reportes_gastos_gen->prueba_mach_dup();
	
		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

		$cont_reportes = count($reportes) + 5;

		$activeSheet->fromArray(
	        $reportes,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A1'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

	    $activeSheet->fromArray(
	        $reportesdup,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A'.$cont_reportes         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Gastos_generales_mach.xlsx"'); 
		header('Cache-Control: max-age=0');
		
		$Excel_writer->save('php://output', 'xlsx');

	}

	public function get_reportes_not_in(){

		$ids_selec = $this->input->post('ids_selec');
		$ids_selec = explode(",", $ids_selec);
		$ids_selec = array_filter($ids_selec, "strlen");

		$id_perfil = $this->input->post('id_perfil');

		$reportes = $this->Mod_reportes_gastos_gen->get_catalogo_reportes($id_perfil);

		$array_reportes = array();

		    foreach ($reportes as $clave => $valor) {
			 
			    array_push($array_reportes, $valor->id);
			   
			}
		

		$reportes = implode(",", $array_reportes);  //id submodulo - reportes

		$rest = $this->Mod_reportes_gastos_gen->get_reportes_perfil_filtrados($reportes);

		$array1 = array();

		    foreach ($rest as $clave => $valor) {
			   
			    	$array1[$valor->id] = $valor;

			}

			
			$ids_selec = implode(",", $ids_selec);
			$ids_selec = explode(",", $ids_selec);


			foreach ($ids_selec as $clave => $valor) {
			   
			    	unset($array1[$valor]);
			    	
			}

			$array2 = array();
			foreach ($array1 as $clave => $valor) {
			   		
			   		$valor->nombre = utf8_encode($valor->nombre);
			    	array_push($array2, $valor);
			    	
			}
			
			echo json_encode($array2);

	}


}
