<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_tabulador_aereolineas extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_tabulador_aereolineas');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	     
	}

	public function get_html_rep_graficos_ae_net(){

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
	    $param["rest_catalogo_id_servicio"] = $rest_catalogo_id_servicio_aereo;
	    $param["rest_catalogo_id_provedor"] = $rest_catalogo_id_provedor;
	    $param["rest_catalogo_plantillas"] = $rest_catalogo_plantillas;
	    $param["rest_clientes"] = $rest_clientes;

	    $param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);

		$this->load->view('Reportes/view_rep_tabulador_aereolineas');
		
	}

	public function get_grafica_provedor_html(){

		$arr_dat_BD = $this->input->post("arr_dat_BD");
		$arr_dat_BI = $this->input->post("arr_dat_BI");
	
		$para = $this->input->post("parametros");
		//$tipo_funcion = $_REQUEST['tipo_funcion'];

		$parametros = explode(",", $para);

		$ids_suc = $parametros[0];
		$ids_serie = $parametros[1];
        $ids_cliente = $parametros[2];
        $ids_servicio = $parametros[3];
        $ids_provedor = $parametros[4];
        $ids_corporativo = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];

		if($arr_dat_BD == ''){

			$arr_dat_BD = [];

		}

		if($arr_dat_BI == ''){

			$arr_dat_BI = [];

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
                
                $rz = $this->Mod_reportes_tabulador_aereolineas->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

		$array2["dat_BD"] =  $arr_dat_BD;
		$array2["dat_BI"] =  $arr_dat_BI;
		$array2["fecha1"] =  $fecha1;
		$array2["fecha2"] =  $fecha2;
		$array2["sub"] =  $sub;

		$this->load->view('Reportes/formatos/view_formato_html_rep_tabulador_aereolineas',$array2);


	}


	public function get_grafica_provedor(){

		$para = $this->input->post("parametros");
		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$parametros = explode(",", $para);

        if($tipo_funcion == "aut"){

        	$ids_serie = $parametros[0];
	        $ids_cliente = $parametros[1];
	        $ids_servicio = $parametros[2];
	        $ids_provedor = $parametros[3];
	        $ids_corporativo = $parametros[4];
	        $id_plantilla = $parametros[5];
	        $fecha1 = $parametros[6];
	        $fecha2 = $parametros[7];
        	$id_correo_automatico = $parametros[8];
            $id_reporte = $parametros[9];
            $id_usuario = $parametros[10];
            $id_intervalo = $parametros[11];
            $fecha_ini_proceso = $parametros[12];
			
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
      
		$rest_grafica = $this->Mod_reportes_tabulador_aereolineas->get_grafica_provedor($parametros);

		/*$rest_dat_BD = $this->Mod_reportes_tabulador_aereolineas->get_datos_grafica($parametros,'BD');
		$rest_dat_BI = $this->Mod_reportes_tabulador_aereolineas->get_datos_grafica($parametros,'BI');*/
	
		$array_grafica = [];

		foreach ($rest_grafica as $key => $value) {
		
			$value->DESC_SERVICIO =  utf8_encode($value->DESC_SERVICIO);
			$value->NOMBRE_PROVEDOR =  utf8_encode($value->NOMBRE_PROVEDOR);

		}

		foreach ($rest_grafica as $key => $value) {
		
			$value->DESC_SERVICIO =  utf8_encode($value->DESC_SERVICIO);
			$value->NOMBRE_PROVEDOR =  utf8_encode($value->NOMBRE_PROVEDOR);

		}

		$array2["grafica"] = $rest_grafica;
		/*$array2["dat_BD"] =  $rest_dat_BD;
		$array2["dat_BI"] =  $rest_dat_BI;*/
		//$array2["sub"] =  $sub;

	    echo json_encode( $array2, JSON_NUMERIC_CHECK );

	}

	public function exportar_excel_ae(){

		$arr_dat_BD = $_REQUEST['arr_dat_BD'];
		$arr_dat_BI = $_REQUEST['arr_dat_BI'];

		$parametros = $_REQUEST['parametros'];
		$img_grafica = $_REQUEST['img_grafica'];

		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$id_us = $this->session->userdata('session_id');
		// requires php5
		define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/');
		$img = $img_grafica;
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . 'rep_ae_' .$id_us. '.png';
		$success = file_put_contents($file, $data);

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
	        $fecha1 = $parametros[6];
	        $fecha2 = $parametros[7];
	        $val_tot_gen_bd = $parametros[8];
	        $val_tot_gen_bi = $parametros[9];
	        $val_tot_gen = $parametros[10];

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

        //$rest_grafica = $this->Mod_reportes_tabulador_aereolineas->get_grafica_provedor($parametros);
		
		$rest_dat_BD = $arr_dat_BD;
		$rest_dat_BI = $arr_dat_BI;

		$dat_BD = [];

		foreach($rest_dat_BD as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($dat_BD, $cast_utf8);
		    

		}

		$dat_BI = [];

		foreach($rest_dat_BI as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($dat_BI, $cast_utf8);
		    

		}

        $spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();


		$activeSheet->getStyle('B29:J29')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('B29:J29')
        ->getFont()->getColor()->setARGB('ffffff');

        $activeSheet->getStyle('F28:J28')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('F28:J28')
        ->getFont()->getColor()->setARGB('ffffff');

        $styleArray = [
		    'borders' => [
		        //'diagonalDirection' => \PhpOffice\PhpSpreadsheet\Style\Borders::DIAGONAL_BOTH,
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ]
		   
		];


		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);


		$array_TOTAL_BOL_DOM = [];
		$array_BOL_DOM = [];
		$array_BOL_DOM_GEN = [];
		$array_BOL_INT_GEN = [];
		$array_PART_BOL_DOM = [];
		$array_PART_BOL_INT = [];
		$STRING_HTML_BOL_DOM = "";

		foreach ($dat_BD as $clave => $valor) {  

		    $BOL_DOM_GEN = $valor[2];
			array_push($array_BOL_DOM_GEN, $BOL_DOM_GEN);

		}

		
		foreach ($dat_BI as $clave => $valor) {  

		   $BOL_INT_GEN = $valor[2];

		   array_push($array_BOL_INT_GEN, $BOL_INT_GEN);

		}

		
		$total_TARIFA_DOM_GEN =  array_sum($array_BOL_DOM_GEN);
		$total_TARIFA_INT_GEN =  array_sum($array_BOL_INT_GEN);

		$total_TARIFA_GEN = (float)$total_TARIFA_DOM_GEN + (float)$total_TARIFA_INT_GEN;

		$contbd = 29;
		foreach ($dat_BD as $clave => $valor) {  
		$contbd++;

		   $NOMBRE_PROVEDOR =  $valor[0];
		   $TOTAL_BOL = $valor[1];
		   $BOL_DOM = $valor[2];
		   $COMISION_BD = $valor[3];
		   $VAL_COM_BD = $valor[4];
		   $INGRESO_BD = $valor[5];
		   $VAL_ING_BD = $valor[6];
		   $VAL_TOT_BD = $valor[7];

		   array_push($array_TOTAL_BOL_DOM, $TOTAL_BOL);
		   array_push($array_BOL_DOM, $BOL_DOM);

		   $PART_BOL_DOM = (((float)$BOL_DOM/(float)$total_TARIFA_GEN)*100);

		   array_push($array_PART_BOL_DOM, $PART_BOL_DOM);

		   $activeSheet->setCellValue('B'.$contbd,$NOMBRE_PROVEDOR )->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('C'.$contbd,$TOTAL_BOL )->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('D'.$contbd,number_format((float)$BOL_DOM) )->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('E'.$contbd,number_format((float)$PART_BOL_DOM, 2, '.', '').'%')->getStyle('AL5')->getFont()->setBold(true);

		   $activeSheet->setCellValue('F'.$contbd,$COMISION_BD.'%')->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('G'.$contbd,$VAL_COM_BD)->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('H'.$contbd,$INGRESO_BD.'%')->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('I'.$contbd,$VAL_ING_BD)->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('J'.$contbd,$VAL_TOT_BD)->getStyle('AL5')->getFont()->setBold(true);
				  
		}


		$total_BOL_DOM =  array_sum($array_TOTAL_BOL_DOM);
		$total_TARIFA_DOM =  array_sum($array_BOL_DOM);

		//--------

		$array_TOTAL_BOL_INT = [];
		$array_BOL_INT = [];
		$STRING_HTML_BOL_INT = "";

		$contint = $contbd + 3;
		foreach ($dat_BI as $clave => $valor) {  

		   $NOMBRE_PROVEDOR =  $valor[0];
		   $TOTAL_BOL = $valor[1];
		   $BOL_INT = $valor[2];

		   $COMISION_BI = $valor[3];
		   $VAL_COM_BI = $valor[4];
		   $INGRESO_BI = $valor[5];
		   $VAL_ING_BI = $valor[6];
		   $VAL_TOT_BI = $valor[7];


		   array_push($array_TOTAL_BOL_INT, $TOTAL_BOL);
		   array_push($array_BOL_INT, $BOL_INT);

		   $PART_BOL_INT = (((float)$BOL_INT/(float)$total_TARIFA_GEN)*100);

		   array_push($array_PART_BOL_INT, $PART_BOL_INT);

		   $activeSheet->setCellValue('B'.$contint,$NOMBRE_PROVEDOR )->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('C'.$contint,$TOTAL_BOL )->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('D'.$contint,number_format((float)$BOL_INT) )->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('E'.$contint,number_format((float)$PART_BOL_INT, 2, '.', '').'%')->getStyle('AL5')->getFont()->setBold(true);

		   $activeSheet->setCellValue('F'.$contint,$COMISION_BI.'%')->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('G'.$contint,$VAL_COM_BI)->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('H'.$contint,$INGRESO_BI.'%')->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('I'.$contint,$VAL_ING_BI)->getStyle('AL5')->getFont()->setBold(true);
		   $activeSheet->setCellValue('J'.$contint,$VAL_TOT_BI)->getStyle('AL5')->getFont()->setBold(true);

		   $contint++;
		}

		

		$total_BOL_INT =  array_sum($array_TOTAL_BOL_INT);
		$total_TARIFA_INT =  array_sum($array_BOL_INT);

		$TOTAL_BOL_GEN = $total_BOL_INT + $total_BOL_DOM;

		$total_PART_BOL_DOM_GEN =  array_sum($array_PART_BOL_DOM);
		$total_PART_BOL_INT_GEN =  array_sum($array_PART_BOL_INT);

		$total_PART_GEN = $total_PART_BOL_DOM_GEN + $total_PART_BOL_INT_GEN;

		$contbd = $contbd + 1;

		$activeSheet->setCellValue('B29','AEROLINEA' )->getStyle('B28')->getFont()->setBold(true);
		$activeSheet->setCellValue('C29','CANT' )->getStyle('C28')->getFont()->setBold(true);
		$activeSheet->setCellValue('D29','TARIFA/Pesos' )->getStyle('C28')->getFont()->setBold(true);
		$activeSheet->setCellValue('E29','%Part' )->getStyle('D28')->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->getStyle('B29')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$activeSheet->setCellValue('F29','%' )->getStyle('D28')->getFont()->setBold(true);
		$activeSheet->setCellValue('G29','VALOR' )->getStyle('D28')->getFont()->setBold(true);
		$activeSheet->setCellValue('H29','%' )->getStyle('D28')->getFont()->setBold(true);
		$activeSheet->setCellValue('I29','VALOR' )->getStyle('D28')->getFont()->setBold(true);
		$activeSheet->setCellValue('J29','COM+ING' )->getStyle('D28')->getFont()->setBold(true);

		$activeSheet->setCellValue('B'.$contbd,'Total BOLETOS DOMESTICOS' )->getStyle('B'.$contbd,'Total BOLETOS DOMESTICOS')->getFont()->setBold(true);
		$activeSheet->setCellValue('C'.$contbd,$total_BOL_DOM )->getStyle('C'.$contbd)->getFont()->setBold(true);
		$activeSheet->setCellValue('D'.$contbd,number_format((float)$total_TARIFA_DOM) )->getStyle('D'.$contbd)->getFont()->setBold(true);
		$activeSheet->setCellValue('E'.$contbd,number_format((float)$total_PART_BOL_DOM_GEN, 2, '.', '').'%')->getStyle('E'.$contbd)->getFont()->setBold(true);

		$activeSheet->setCellValue('J'.$contbd,number_format((float)$val_tot_gen_bd) )->getStyle('J'.$contbd)->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->mergeCells('F28:G28');
		$spreadsheet->getActiveSheet()->mergeCells('H28:I28');


		$activeSheet->setCellValue('F28','COMISION')->getStyle('F28')->getFont()->setBold(true);
		$activeSheet->setCellValue('H28','INGRESO')->getStyle('H28')->getFont()->setBold(true);
		$activeSheet->setCellValue('J28','GRAN TOTAL')->getStyle('J28')->getFont()->setBold(true);
		
		$spreadsheet->getActiveSheet()->getStyle('F28')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('H28')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$styleArray1 = [
		    'borders' => [
		        'top' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '010101'],
		        ],
		    ],
		];
		$styleArray2 = [
		    'borders' => [
		        'bottom' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['argb' => '010101'],
		        ],
		    ],
		];

		$activeSheet->setCellValue('B'.$contint,'Total BOLETOS INTERNACIONALES' )->getStyle('B'.$contint,'Total BOLETOS INTERNACIONALES')->getFont()->setBold(true);
		$activeSheet->setCellValue('C'.$contint,$total_BOL_INT )->getStyle('C'.$contint)->getFont()->setBold(true);
		$activeSheet->setCellValue('D'.$contint,number_format((float)$total_TARIFA_INT) )->getStyle('D'.$contint)->getFont()->setBold(true);
		$activeSheet->setCellValue('E'.$contint,number_format((float)$total_PART_BOL_INT_GEN, 2, '.', '').'%')->getStyle('E'.$contint)->getFont()->setBold(true);

		$activeSheet->setCellValue('J'.$contint,number_format((float)$val_tot_gen_bi) )->getStyle('J'.$contint)->getFont()->setBold(true);


		$contint = $contint + 1;

		$activeSheet->setCellValue('B'.$contint,'Total general')->getStyle('AL5')->getFont()->setBold(true);
		$activeSheet->setCellValue('C'.$contint,$TOTAL_BOL_GEN )->getStyle('AL5')->getFont()->setBold(true);
		$activeSheet->setCellValue('D'.$contint,number_format((float)$total_TARIFA_GEN) )->getStyle('AL5')->getFont()->setBold(true);
		$activeSheet->setCellValue('E'.$contint,(float)$total_PART_GEN.'%' )->getStyle('AL5')->getFont()->setBold(true);

		$activeSheet->setCellValue('J'.$contint,number_format((float)$val_tot_gen))->getStyle('AL5')->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->mergeCells('B'.($contint + 1).':'.'J'.($contint + 1));
		$spreadsheet->getActiveSheet()->mergeCells('B'.($contint + 2).':'.'J'.($contint + 2));
		$spreadsheet->getActiveSheet()->mergeCells('B'.($contint + 3).':'.'J'.($contint + 3));

		$activeSheet->setCellValue('B'.($contint + 1),'El consumo es la tarifa antes de impuestos de iva y tua.')->getStyle('B'.($contint + 1))->getFont()->setBold(true);
		$activeSheet->setCellValue('B'.($contint + 2),'El consumo es de tarifa de servicios de vuelos.(No cargos por cambios y revisados)' )->getStyle('B'.($contint + 2))->getFont()->setBold(true);
		$activeSheet->setCellValue('B'.($contint + 3),'Cantidades en Pesos Mexicanos' )->getStyle('B'.($contint + 3))->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->getStyle('B'.($contint + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B'.($contint + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B'.($contint + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$spreadsheet->getActiveSheet()->getStyle('A1:J'.($contint + 3))->applyFromArray($styleArray);  //PINTA TODOS LOS BORDES DE BLANCO

		$activeSheet->getStyle('B'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('B'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('C'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('C'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('D'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('D'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('E'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('E'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('F'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('F'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('G'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('G'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('H'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('H'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('I'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('I'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('J'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('J'.$contbd)->applyFromArray($styleArray2);

		$activeSheet->getStyle('B'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('B'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('C'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('C'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('D'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('D'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('E'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('E'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('F'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('F'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('G'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('G'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('H'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('H'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('I'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('I'.($contint - 1))->applyFromArray($styleArray2);
		$activeSheet->getStyle('J'.($contint - 1))->applyFromArray($styleArray1);
		$activeSheet->getStyle('J'.($contint - 1))->applyFromArray($styleArray2);

		$activeSheet->getStyle('B'.$contint.':J'.$contint.'')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('010101');

	    $spreadsheet->getActiveSheet()->getStyle('B'.$contint.':J'.$contint.'')
        ->getFont()->getColor()->setARGB('ffffff');

        $spreadsheet->getActiveSheet()->getStyle('D30:D'.$contint)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('G30:G'.$contint)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('I30:I'.$contint)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('J30:J'.$contint)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

		$spreadsheet->getActiveSheet()->mergeCells('B6:I6');
		$spreadsheet->getActiveSheet()->mergeCells('B7:I7');
		$spreadsheet->getActiveSheet()->mergeCells('B8:I8');
		$spreadsheet->getActiveSheet()->mergeCells('B9:I9');

		$spreadsheet->getActiveSheet()->getStyle('B6:I6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B7:I7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B8:I8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B9:I9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$spreadsheet->getActiveSheet()->getStyle('C8:C3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('D8:D3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$spreadsheet->getActiveSheet()->getStyle('E8:E3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
     
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);


        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setCoordinates('B11');
		$drawing->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/rep_ae_'.$id_us.'.png');
		$drawing->setHeight(280);

		$colWidth = $spreadsheet->getActiveSheet()->getColumnDimension('K')->getWidth();

		if ($colWidth == -1) { //not defined which means we have the standard width
		    $colWidthPixels = 730; //pixels, this is the standard width of an Excel cell in pixels = 9.140625 char units outer size
		} else {                  //innner width is 8.43 char units
		    $colWidthPixels = $colWidth * 7.0017094; //colwidht in Char Units * Pixels per CharUnit
		}
		$offsetX = $colWidthPixels - $drawing->getWidth(); //pixels
		$drawing->setOffsetX($offsetX); //pixels
		$drawing->setWorksheet($spreadsheet->getActiveSheet());


        $spreadsheet->getActiveSheet()->mergeCells('B10:I10');

        $spreadsheet->getActiveSheet()->getStyle('B10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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
		$drawing2->setCoordinates('J1');
		$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/img/91_4c.gif');
		$drawing2->setHeight(60);
		$drawing2->setWidth(60);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());
       	
       	$ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");

  	    $activeSheet->setCellValue('B6','TABULADOR AEROLINEAS')->getStyle('B6')->getFont()->setBold(true)->setSize(25);
      	    

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
                
                $rz = $this->Mod_reportes_tabulador_aereolineas->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

            $activeSheet->setCellValue('B7', utf8_encode($title) )->getStyle('B7')->getFont()->setBold(true)->setSize(14);
			$activeSheet->setCellValue('B8', utf8_encode($sub) )->getStyle('B8')->getFont()->setBold(true)->setSize(14);
			$activeSheet->setCellValue('B9', utf8_encode($rango_fecha) )->getStyle('B8')->getFont()->setBold(true)->setSize(14);

		


	     	$fecha1 = str_replace('/','_',$fecha1);
			$fecha2 = str_replace('/','_',$fecha2);

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
	

}
