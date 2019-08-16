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

class Cnt_reportes_gvc_reporteador extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_gvc_reporteador');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	     
	}
    
    public function get_html_reportes_gvc_reporteador(){

    	$title = $this->input->post('title');

		$rest_catalogo_series = $this->Mod_catalogos_filtros->get_catalogo_series();

		$rest_catalogo_corporativo = $this->Mod_catalogos_filtros->get_catalogo_corporativo();

		$rest_catalogo_id_servicio = $this->Mod_catalogos_filtros->get_catalogo_id_servicio();
		
		$rest_catalogo_id_provedor = $this->Mod_catalogos_filtros->get_catalogo_id_provedor();
		
		$id_us = $this->session->userdata('session_id');
		$rest_catalogo_plantillas = $this->Mod_catalogos_filtros->get_catalogo_plantillas($id_us,4);

		$id_perfil = $this->session->userdata('session_id_perfil');
		$rest_clientes  = $this->Mod_clientes->get_clientes_dk_perfil($id_perfil);
		
		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		$param["rest_catalogo_series"] = $rest_catalogo_series;
	    $param["rest_catalogo_corporativo"] = $rest_catalogo_corporativo;
	    $param["rest_catalogo_id_servicio"] = $rest_catalogo_id_servicio;
	    $param["rest_catalogo_id_provedor"] = $rest_catalogo_id_provedor;
	    $param["rest_clientes"] = $rest_clientes;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Reportes/view_rep_gvc_reporteador');

	}

    public function get_rep_gvc_reporteador(){

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
        $parametros["proceso"] = 2;
        $parametros["id_intervalo"] = '0';
        $parametros["fecha_ini_proceso"] = '';
        $parametros["id_plantilla"] = $id_plantilla;

		$rep = $this->reportes_gvc_reporteador($parametros);

		//$col = $this->Mod_reportes_gvc_reporteador->get_columnas($id_plantilla,4);

		$param_final['rep'] = $rep;
		//$param_final['col'] = $col;
		
		echo json_encode($param_final);

	}

	public function reportes_gvc_reporteador($parametros){

	    $rest = $this->Mod_reportes_gvc_reporteador->get_reportes_gvc_reporteador($parametros);
	  
	    $array1 = array();

	    $rep = [];
		foreach($rest as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($array1, $cast_utf8);
		    
		}

	    return $array1;

	}

	public function exportar_excel_usuario_masivo(){
		
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

	  $parametros["id_plantilla"] = $id_plantilla;
      
      $parametros["proceso"] = 2;

	  //$rep = $this->reportes_gvc_reporteador($parametros);
	  $rest = $this->Mod_reportes_gvc_reporteador->get_reportes_gvc_reporteador($parametros);
	  
	  $rep = [];
		foreach($rest as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($rep, $cast_utf8);
		    

		}
		
	  
	  if(count($rep) > 0){

	  				    $col = $this->Mod_reportes_gvc_reporteador->get_columnas($id_plantilla,4);

						$array_header = [];
      
					      foreach ($col as $clave1 => $valor) {  
					        
								array_push($array_header, ltrim(rtrim($valor->nombre_columna_vista)) );

					      }

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

						if($tipo_funcion == "aut"){
			
							  $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

			        		  $rango_fechas = explode("_", $rango_fechas);

			        		  $fecha1 = $rango_fechas[0];
			        		  $fecha2 = $rango_fechas[1];

				        	
						}

						if($tipo_funcion == "aut"){

							$writer->openToFile($_SERVER['DOCUMENT_ROOT']."/reportes_villatours/referencias/archivos/Reporte_GVC_Reporteador_".$fecha1."_A_".$fecha2.'_'.$id_correo_automatico.'_'.$id_reporte.".xlsx"); // write data to a file or 
						}else{

							$array_fecha1 = explode('/', $fecha1);
                  			$fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

                  			$array_fecha2 = explode('/', $fecha2);
                  			$fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0]; //week


							$writer->openToFile($_SERVER['DOCUMENT_ROOT']."/reportes_villatours/referencias/archivos/Reporte_GVC_Reporteador_".$fecha1."_A_".$fecha2.".xlsx"); // 

						}

						$titulo = [];
						$row_vacio = [];

						for($x=0;$x<=count($header);$x++){

							array_push($row_vacio, '');
							
							if($x==10){

								array_push($titulo, 'GVC REPORTEADOR');

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


						if($tipo_funcion == "aut"){

							echo json_encode(1); //cuando es uno si tiene informacion

						}else{
							
						
						    $rut = $_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GVC_Reporteador_'.$fecha1.'_A_'.$fecha2.'.xlsx';

							header ('Content-Disposition: attachment; filename=Reporte_GVC_Reporteador_'.$fecha1.'_A_'.$fecha2.'.xlsx');
							header ("Content-Type: application/vnd.ms-excel");
							header ("Content-Length: ".filesize($rut));


							readfile($rut);

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

        $parametros["id_plantilla"] = $id_plantilla;
        $parametros["proceso"] = 2;

		//$rep = $this->reportes_gvc_reporteador($parametros);
		$rest = $this->Mod_reportes_gvc_reporteador->get_reportes_gvc_reporteador($parametros);

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

		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');

		$activeSheet->setCellValue('A5' ,'GVC_ID_SUCURSAL');
	    $activeSheet->setCellValue('B5' ,'GVC_ID_SERIE');
	    $activeSheet->setCellValue('C5' ,'GVC_DOC_NUMERO');
	    $activeSheet->setCellValue('D5' ,'GVC_ID_CORPORATIVO');
	    $activeSheet->setCellValue('E5' ,'GVC_NOM_CORP');
	    $activeSheet->setCellValue('F5' ,'GVC_ID_CLIENTE');
	    $activeSheet->setCellValue('G5' ,'GVC_NOM_CLI');
	    $activeSheet->setCellValue('H5' ,'GVC_ID_CENTRO_COSTO');
	    $activeSheet->setCellValue('I5' ,'GVC_DESC_CENTRO_COSTO');
	    $activeSheet->setCellValue('J5' ,'GVC_ID_DEPTO');
	    $activeSheet->setCellValue('K5' ,'GVC_DEPTO');
	    $activeSheet->setCellValue('L5' ,'GVC_ID_VEN_TIT');
	    $activeSheet->setCellValue('M5' ,'GVC_NOM_VEN_TIT');
	    $activeSheet->setCellValue('N5' ,'GVC_ID_VEN_AUX');
	    $activeSheet->setCellValue('O5' ,'GVC_NOM_VEN_AUX');
	    $activeSheet->setCellValue('P5' ,'GVC_ID_CIUDAD');
	    $activeSheet->setCellValue('Q5' ,'GVC_FECHA');
	    $activeSheet->setCellValue('R5' ,'GVC_MONEDA');
	    $activeSheet->setCellValue('S5' ,'GVC_TIPO_CAMBIO');
	    $activeSheet->setCellValue('T5' ,'GVC_SOLICITO');
	    $activeSheet->setCellValue('U5' ,'GVC_CVE_RES_GLO');
	    $activeSheet->setCellValue('V5' ,'analisis1_cliente');
	    $activeSheet->setCellValue('W5' ,'analisis2_cliente');
	    $activeSheet->setCellValue('X5' ,'analisis3_cliente');
	    $activeSheet->setCellValue('Y5' ,'analisis4_cliente');
	    $activeSheet->setCellValue('Z5' ,'analisis5_cliente');
	    $activeSheet->setCellValue('AA5' ,'analisis6_cliente');
	    $activeSheet->setCellValue('AB5' ,'analisis7_cliente');
	    $activeSheet->setCellValue('AC5' ,'analisis8_cliente');
	    $activeSheet->setCellValue('AD5' ,'analisis9_cliente');
	    $activeSheet->setCellValue('AE5' ,'analisis10_cliente');
	    $activeSheet->setCellValue('AF5' ,'analisis11_cliente');
	    $activeSheet->setCellValue('AG5' ,'analisis12_cliente');
	    $activeSheet->setCellValue('AH5' ,'analisis13_cliente');
	    $activeSheet->setCellValue('AI5' ,'analisis14_cliente');
	    $activeSheet->setCellValue('AJ5' ,'analisis15_cliente');
	    $activeSheet->setCellValue('AK5' ,'analisis16_cliente');
	    $activeSheet->setCellValue('AL5' ,'analisis17_cliente');
	    $activeSheet->setCellValue('AM5' ,'analisis18_cliente');
	    $activeSheet->setCellValue('AN5' ,'analisis19_cliente');
	    $activeSheet->setCellValue('AO5' ,'analisis20_cliente');
	    $activeSheet->setCellValue('AP5' ,'analisis21_cliente');
	    $activeSheet->setCellValue('AQ5' ,'analisis22_cliente');
	    $activeSheet->setCellValue('AR5' ,'analisis23_cliente');
	    $activeSheet->setCellValue('AS5' ,'analisis24_cliente');
	    $activeSheet->setCellValue('AT5' ,'analisis25_cliente');
	    $activeSheet->setCellValue('AU5' ,'analisis26_cliente');
	    $activeSheet->setCellValue('AV5' ,'analisis27_cliente');
	    $activeSheet->setCellValue('AW5' ,'analisis28_cliente');
	    $activeSheet->setCellValue('AX5' ,'analisis29_cliente');
	    $activeSheet->setCellValue('AY5' ,'analisis30_cliente');
	    $activeSheet->setCellValue('AZ5' ,'analisis31_cliente');
	    $activeSheet->setCellValue('BA5' ,'analisis32_cliente');
	    $activeSheet->setCellValue('BB5' ,'analisis33_cliente');
	    $activeSheet->setCellValue('BC5' ,'analisis34_cliente');
	    $activeSheet->setCellValue('BD5' ,'analisis35_cliente');
	    $activeSheet->setCellValue('BE5' ,'analisis36_cliente');
	    $activeSheet->setCellValue('BF5' ,'analisis39_cliente');
	    $activeSheet->setCellValue('BG5' ,'confirmacion_la');
	    $activeSheet->setCellValue('BH5' ,'analisis40_cliente');
	    $activeSheet->setCellValue('BI5' ,'analisis41_cliente');
	    $activeSheet->setCellValue('BJ5' ,'analisis42_cliente');
	    $activeSheet->setCellValue('BK5' ,'analisis43_cliente');
	    $activeSheet->setCellValue('BL5' ,'analisis44_cliente');
	    $activeSheet->setCellValue('BM5' ,'analisis45_cliente');
	    $activeSheet->setCellValue('BN5' ,'analisis46_cliente');
	    $activeSheet->setCellValue('BO5' ,'analisis47_cliente');
	    $activeSheet->setCellValue('BP5' ,'analisis48_cliente');
	    $activeSheet->setCellValue('BQ5' ,'analisis49_cliente');
	    $activeSheet->setCellValue('BR5' ,'analisis50_cliente');
	    $activeSheet->setCellValue('BS5' ,'analisis51_cliente');
	    $activeSheet->setCellValue('BT5' ,'analisis52_cliente');
	    $activeSheet->setCellValue('BU5' ,'analisis53_cliente');
	    $activeSheet->setCellValue('BV5' ,'analisis54_cliente');
	    $activeSheet->setCellValue('BW5' ,'analisis55_cliente');
	    $activeSheet->setCellValue('BX5' ,'analisis56_cliente');
	    $activeSheet->setCellValue('BY5' ,'analisis57_cliente');
	    $activeSheet->setCellValue('BZ5' ,'analisis58_cliente');
	    $activeSheet->setCellValue('CA5' ,'analisis59_cliente');
	    $activeSheet->setCellValue('CB5' ,'analisis60_cliente');
	    $activeSheet->setCellValue('CC5' ,'TIPO_BOLETO');
	    $activeSheet->setCellValue('CD5' ,'GVC_BOLETO');
	    $activeSheet->setCellValue('CE5' ,'GVC_BOLETO_CXS');
	    $activeSheet->setCellValue('CF5' ,'GVC_ID_SERVICIO');
	    $activeSheet->setCellValue('CG5' ,'GVC_ID_PROVEEDOR');
	    $activeSheet->setCellValue('CH5' ,'GVC_NOMBRE_PROVEEDOR');
	    $activeSheet->setCellValue('CI5' ,'BOLETO_EMD');
	    $activeSheet->setCellValue('CJ5' ,'GVC_ALCANCE_SERVICIO');
	    $activeSheet->setCellValue('CK5' ,'GVC_CONCEPTO');
	    $activeSheet->setCellValue('CL5' ,'GVC_NOM_PAX');
	    $activeSheet->setCellValue('CM5' ,'GVC_TARIFA_MON_BASE');
	    $activeSheet->setCellValue('CN5' ,'GVC_TARIFA_MON_EXT');
	    $activeSheet->setCellValue('CO5' ,'GVC_DESCUENTO');
	    $activeSheet->setCellValue('CP5' ,'GVC_IVA_DESCUENTO');
	    $activeSheet->setCellValue('CQ5' ,'GVC_COM_AGE');
	    $activeSheet->setCellValue('CR5' ,'GVC_POR_COM_AGE');
	    $activeSheet->setCellValue('CS5' ,'GVC_COM_TIT');
	    $activeSheet->setCellValue('CT5' ,'GVC_POR_COM_TIT');
	    $activeSheet->setCellValue('CU5' ,'GVC_COM_AUX');
	    $activeSheet->setCellValue('CV5' ,'GVC_POR_COM_AUX');
	    $activeSheet->setCellValue('CW5' ,'GVC_POR_IVA_COM');
	    $activeSheet->setCellValue('CX5' ,'GVC_IVA');
	    $activeSheet->setCellValue('CY5' ,'GVC_TUA');
	    $activeSheet->setCellValue('CZ5' ,'GVC_OTROS_IMPUESTOS');
	    $activeSheet->setCellValue('DA5' ,'GVC_TOTAL');
	    $activeSheet->setCellValue('DB5' ,'GVC_SUMA_IMPUESTOS');
	    $activeSheet->setCellValue('DC5' ,'GVC_IVA_EXT');
	    $activeSheet->setCellValue('DD5' ,'GVC_TUA_EXT');  // falta 
	    $activeSheet->setCellValue('DE5' ,'GVC_OTR_EXT');
	    $activeSheet->setCellValue('DF5' ,'GVC_CVE_SUCURSAL');
	    $activeSheet->setCellValue('DG5' ,'GVC_NOM_SUCURSAL');
	    $activeSheet->setCellValue('DH5' ,'GVC_TARIFA_COMPARATIVA_BOLETO');
	    $activeSheet->setCellValue('DI5' ,'GVC_TARIFA_COMPARATIVA_BOLETO_EXT');
	    $activeSheet->setCellValue('DJ5' ,'GVC_CLASE_FACTURADA');
	    $activeSheet->setCellValue('DK5' ,'GVC_CLASE_COMPARATIVO');
	    $activeSheet->setCellValue('DL5' ,'GVC_FECHA_SALIDA');
	    $activeSheet->setCellValue('DM5' ,'GVC_FECHA_REGRESO');
	    $activeSheet->setCellValue('DN5' ,'GVC_FECHA_EMISION_BOLETO');
	    $activeSheet->setCellValue('DO5' ,'GVC_CLAVE_EMPLEADO');
	    $activeSheet->setCellValue('DP5' ,'GVC_FOR_PAG1');
	    $activeSheet->setCellValue('DQ5' ,'GVC_FOR_PAG2');
	    $activeSheet->setCellValue('DR5' ,'GVC_FOR_PAG3');
	    $activeSheet->setCellValue('DS5' ,'GVC_FOR_PAG4');
	    $activeSheet->setCellValue('DT5' ,'GVC_FOR_PAG5');
	    $activeSheet->setCellValue('DU5' ,'GVC_FAC_NUMERO');
	    $activeSheet->setCellValue('DV5' ,'GVC_ID_SERIE_FAC');
	    $activeSheet->setCellValue('DW5' ,'GVC_FAC_CVE_SUCURSAL');
	    $activeSheet->setCellValue('DX5' ,'GVC_FAC_NOM_SUCURSAL');
	    $activeSheet->setCellValue('DY5' ,'GVC_TIPO_DOCUMENTO');
	    $activeSheet->setCellValue('DZ5' ,'GVC_ID_STATUS');
	    $activeSheet->setCellValue('EA5' ,'GVC_CONSECUTIVO');
	    $activeSheet->setCellValue('EB5' ,'GVC_TARIFA_OFRECIDA');
	    $activeSheet->setCellValue('EC5' ,'GVC_CODIGO_RAZON');
	    $activeSheet->setCellValue('ED5' ,'GVC_DESC_CORTA');
	    $activeSheet->setCellValue('EE5' ,'GVC_FECHA_RESERVACION');
	    $activeSheet->setCellValue('EF5' ,'GVC_PRODUCTO');
	    $activeSheet->setCellValue('EG5' ,'GVC_CLASES');

		$activeSheet->fromArray(
	        $rep,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A6'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );


		$activeSheet->getStyle('A5:EG5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $activeSheet->getStyle('A5:EG5')
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

		$spreadsheet->getActiveSheet()->getStyle('A1:EG'.(count($rep) + 5))->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:AB4')->applyFromArray($styleArray);

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		
		$activeSheet->getColumnDimension('AB')->setAutoSize(true);

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

		$activeSheet->setCellValue('F1','GVC REPORTEADOR' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);

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

			if(isset($valor['GVC_NOM_CLI'])){ 

				$str_razon_social = $str_razon_social . $valor['GVC_NOM_CLI'] . '/';

			}

			if(isset($valor['GVC_ID_CORPORATIVO'])){

				$str_corporativo = $str_corporativo . $valor['GVC_ID_CORPORATIVO'] . '/';

			}



					
		}

            if(count($ids_corporativo) > 0 ){


	            if(count($ids_corporativo) == 1){


	              	$str_corporativo = explode('/', $str_corporativo);
					$str_corporativo = array_filter($str_corporativo, "strlen");
					$str_corporativo = array_unique($str_corporativo);
					$str_corporativo = implode("/", $str_corporativo);
					$activeSheet->setCellValue('F3',$str_corporativo )->getStyle('F3')->getFont()->setSize(14);
	              	


	            }else{

	              	$activeSheet->setCellValue('F2',"Clientes Villatours" )->getStyle('F2')->getFont()->setSize(14);

	            }


            }else if(count($ids_cliente) > 0){

            	
                $rz = $this->Mod_reportes_gvc_reporteador->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
                if(count($rz) > 1){

                	$activeSheet->setCellValue('F2',"Clientes Villatours" )->getStyle('F2')->getFont()->setSize(14);
                	  
                }else{


                    $str_razon_social = explode('/', $str_razon_social);
					$str_razon_social = array_filter($str_razon_social, "strlen");
					$str_razon_social = array_unique($str_razon_social);
					$str_razon_social = implode("/", $str_razon_social);
					$activeSheet->setCellValue('F2',$str_razon_social )->getStyle('F2')->getFont()->setSize(14);
					
	            	
                }
                
            }else{

            	$activeSheet->setCellValue('F2',"Clientes Villatours" )->getStyle('F2')->getFont()->setSize(14);
            	

            }

        
	 

		$spreadsheet->getActiveSheet()->mergeCells('F1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:I2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:I3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:I4');
		
        $spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);



       if($tipo_funcion == "aut"){

       	$str_fecha = $fecha1.'_A_'.$fecha2;
       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GVC_Reporteador_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
       	echo json_encode(1); //cuando es uno si tiene informacion

       }else{

       
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte_GVC_Reporteador_'.$fecha1.'_A_'.$fecha2.'.xlsx"'); 
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
