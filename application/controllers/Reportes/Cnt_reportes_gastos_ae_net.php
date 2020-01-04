<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_gastos_ae_net extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_gastos_ae_net');
	      $this->load->model('Mod_general');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->Mod_general->get_SPID();

	     
	}

	public function get_html_rep_gastos_ae(){

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

		$this->load->view('Reportes/view_rep_gastos_ae_net');
		
	}

	public function get_grafica_pasajero_html(){

		$rows_grafica = $this->input->post("rows_grafica");
		
		$para = $this->input->post("parametros");

		$id_servicio = $this->input->post("id_servicio");

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
                
                $rz = $this->Mod_reportes_gastos_ae_net->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

		$array2["rows_grafica"] =  $rows_grafica;
		$array2["id_servicio"] =  $id_servicio;
		$array2["fecha1"] =  $fecha1;
		$array2["fecha2"] =  $fecha2;
		$array2["sub"] =  $sub;


	
		$this->load->view('Reportes/formatos/view_formato_html_rep_gastos_ae',$array2);

		

	}


	public function get_grafica_pasajero(){

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

		$rest_grafica = $this->Mod_reportes_gastos_ae_net->get_grafica_pasajero($parametros);
		

		$array_grafica = [];


		foreach ($rest_grafica as $key => $value) {
		
			$value->NOMBRE_PAX =  utf8_encode($value->NOMBRE_PAX);

		}

		$array2["grafica"] = $rest_grafica;
		
	    echo json_encode( $array2, JSON_NUMERIC_CHECK );

	}

	public function exportar_excel_ae(){

		$parametros = $_REQUEST['parametros'];
		$id_servicio = $this->input->post("id_servicio");
		$img_grafica = $_REQUEST['img_grafica'];

		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$id_us = $this->session->userdata('session_id');
		// requires php5
		define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/');
		$img = $img_grafica;
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		$file = UPLOAD_DIR . 'rep_gastos_ae_' .$id_us. '.png';
		$success = file_put_contents($file, $data);


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

        $rest_grafica = $this->Mod_reportes_gastos_ae_net->get_grafica_pasajero($parametros);

        if(count($rest_grafica) > 0){
        $rep = [];

		foreach($rest_grafica as $value) {
    		
    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($rep, $cast_utf8);
		    

		}
		
        $spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();


		$activeSheet->getStyle('B28:E28')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('B28:E28')
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

		//$spreadsheet->getActiveSheet()->getStyle('A1:P1000')->applyFromArray($styleArray);

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);


		$array_TOTAL = [];
		$array_BOL = [];
		$array_BOL_DOM_GEN = [];
		$array_BOL_INT_GEN = [];
		$array_PART_BOL_DOM = [];
		$array_PART_BOL_INT = [];
		$STRING_HTML_BOL_DOM = "";

		foreach ($rep as $clave => $valor) {  



		 	   if($id_servicio == 'BD'){

			   	$BOL_DOM_GEN = $valor["BOL_DOM"];

		      	array_push($array_BOL_DOM_GEN, $BOL_DOM_GEN);
			   
			   }else{

			   	 $BOL_INT_GEN = $valor["BOL_INT"];

		      	 array_push($array_BOL_INT_GEN, $BOL_INT_GEN);

			   }



		}

		if($id_servicio == 'BD'){

			   	$total_TARIFA_GEN = array_sum($array_BOL_DOM_GEN);
			   
	   	 }else{

			    $total_TARIFA_GEN = array_sum($array_BOL_INT_GEN);

	   	 }

		$contbd = 28;
		foreach ($rep as $clave => $valor) {
		
		   //if($valor->BOL_DOM != 0 && $valor->BOL_DOM != ""){
		   	$contbd++;
		   	   $NOMBRE_PAX =  $valor["NOMBRE_PAX"];
			   $TOTAL_BOL = $valor["TOTAL_BOL"];
			   

			   if($id_servicio == 'BD'){

			   	 $BOL = $valor["BOL_DOM"];
			   
			   }else{

			   	 $BOL =  $valor["BOL_INT"];

			   }
			  

			   array_push($array_TOTAL, $TOTAL_BOL);
			   array_push($array_BOL, $BOL);

			   $PART_BOL = (($BOL/$total_TARIFA_GEN)*100);

			   array_push($array_PART_BOL_DOM, $PART_BOL);

			   $activeSheet->setCellValue('B'.$contbd,$NOMBRE_PAX )->getStyle('AL5')->getFont()->setBold(true);
			   $activeSheet->setCellValue('C'.$contbd,$TOTAL_BOL )->getStyle('AL5')->getFont()->setBold(true);
			   $activeSheet->setCellValue('D'.$contbd,number_format((float)$BOL) )->getStyle('AL5')->getFont()->setBold(true);
			   $activeSheet->setCellValue('E'.$contbd,number_format((float)$PART_BOL, 2, '.', '').'%' )->getStyle('AL5')->getFont()->setBold(true);
		      

		   //}

		  
				  
		}

		$total_BOL =  array_sum($array_TOTAL);
		$total_TARIFA =  array_sum($array_BOL);

		//--------


		$total_PART_BOL_DOM_GEN =  array_sum($array_PART_BOL_DOM);
		

		
		$contbd = $contbd + 1;

		$activeSheet->setCellValue('B28','PASAJERO' )->getStyle('B28')->getFont()->setBold(true);
		$activeSheet->setCellValue('C28','CANT' )->getStyle('C28')->getFont()->setBold(true);
		$activeSheet->setCellValue('D28','TARIFA/Pesos' )->getStyle('C28')->getFont()->setBold(true);
		$activeSheet->setCellValue('E28','%Part' )->getStyle('D28')->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->getStyle('B28')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		if($id_servicio == 'BD'){
			
			$activeSheet->setCellValue('B'.$contbd,'Total BOLETOS DOMESTICOS' )->getStyle('B'.$contbd,'Total BOLETOS DOMESTICOS')->getFont()->setBold(true);

		}else{

			$activeSheet->setCellValue('B'.$contbd,'Total BOLETOS INTERNACIONALES' )->getStyle('B'.$contbd,'Total BOLETOS INTERNACIONALES')->getFont()->setBold(true);


		}

		$activeSheet->setCellValue('C'.$contbd,$total_BOL )->getStyle('C'.$contbd)->getFont()->setBold(true);
		$activeSheet->setCellValue('D'.$contbd,number_format($total_TARIFA) )->getStyle('D'.$contbd)->getFont()->setBold(true);
		$activeSheet->setCellValue('E'.$contbd,number_format((float)$total_PART_BOL_DOM_GEN, 2, '.', '').'%')->getStyle('E'.$contbd)->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->mergeCells('B'.($contbd + 1).':'.'E'.($contbd + 1));
		$spreadsheet->getActiveSheet()->mergeCells('B'.($contbd + 2).':'.'E'.($contbd + 2));
		$spreadsheet->getActiveSheet()->mergeCells('B'.($contbd + 3).':'.'E'.($contbd + 3));

		$activeSheet->setCellValue('B'.($contbd + 1),'El consumo es la tarifa antes de impuestos de iva y tua.')->getStyle('B'.($contbd + 1))->getFont()->setBold(true);
		$activeSheet->setCellValue('B'.($contbd + 2),'El consumo es de tarifa de servicios de vuelos.(No cargos por cambios y revisados)' )->getStyle('B'.($contbd + 2))->getFont()->setBold(true);
		$activeSheet->setCellValue('B'.($contbd + 3),'Cantidades en Pesos Mexicanos' )->getStyle('B'.($contbd + 3))->getFont()->setBold(true);

		$spreadsheet->getActiveSheet()->getStyle('B'.($contbd + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B'.($contbd + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B'.($contbd + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$spreadsheet->getActiveSheet()->getStyle('A1:G'.($contbd + 3))->applyFromArray($styleArray);

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

		$activeSheet->getStyle('B'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('B'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('C'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('C'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('D'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('D'.$contbd)->applyFromArray($styleArray2);
		$activeSheet->getStyle('E'.$contbd)->applyFromArray($styleArray1);
		$activeSheet->getStyle('E'.$contbd)->applyFromArray($styleArray2);


		$spreadsheet->getActiveSheet()->mergeCells('B6:E6');
		$spreadsheet->getActiveSheet()->mergeCells('B7:E7');
		$spreadsheet->getActiveSheet()->mergeCells('B8:E8');
		$spreadsheet->getActiveSheet()->mergeCells('B9:E9');

		$spreadsheet->getActiveSheet()->getStyle('B6:E6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B7:E7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B8:E8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B9:E9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$spreadsheet->getActiveSheet()->getStyle('C8:C3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('D8:D3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$spreadsheet->getActiveSheet()->getStyle('E8:E3000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
     
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);


        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setCoordinates('B10');
		$drawing->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/rep_gastos_ae_'.$id_us.'.png');
		$drawing->setHeight(280);
		//$drawing->setWidth(600);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

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
		$drawing2->setCoordinates('E1');
		$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/img/91_4c.gif');
		$drawing2->setHeight(60);
		$drawing2->setWidth(60);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());
       	
       	$ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");

  	    $activeSheet->setCellValue('B6','GASTOS AEREOS')->getStyle('B6')->getFont()->setBold(true)->setSize(25);
        
        if($tipo_funcion == "aut"){
        	
        		 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

        		 $rango_fechas = explode("_", $rango_fechas);

        		 $fecha1 = $rango_fechas[0];
        		 $fecha2 = $rango_fechas[1];

        	   	 //$activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);

		        if(count($ids_corporativo) > 0 ){

		              $sub = "";

		              if(count($ids_corporativo) > 1){

		              	    $sub = $sub . $fecha1 . ' - ' . $fecha2;

		              }else{

		              	foreach ($ids_corporativo as $clave => $valor) {  //obtiene clientes asignados

		                 	$sub = $sub . $valor .' '. $fecha1 . ' - ' . $fecha2;

		              	}

		              }

	            }
	            
	            else if(count($ids_cliente) > 0){
	            	$title = "";
	            	$rango_fecha =  $fecha1 . ' - ' . $fecha2;
	            	$sub = "";
	                
	                $rz = $this->Mod_reportes_gastos_ae_net->get_razon_social_id_in($ids_cliente);  //optiene razon social
	                
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
                
                $rz = $this->Mod_reportes_gastos_ae_net->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

		}
            

		if($tipo_funcion == "aut"){

			/*$fecha1 = explode('/', $fecha1);
	        $dia1 = $fecha1[0];
	        $mes1 = $fecha1[1];
	        $ano1 = $fecha1[2];
	        $fecha1 = $ano1.'_'.$mes1.'_'.$dia1;

	        $fecha2 = explode('/', $fecha2);
	        $dia2 = $fecha2[0];
	        $mes2 = $fecha2[1];
	        $ano2 = $fecha2[2];
	        $fecha2 = $ano2.'_'.$mes2.'_'.$dia2;*/
        
			$str_fecha = $fecha1.'_A_'.$fecha2;
	       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours_v/referencias/archivos/Reporte_Gastos_ae_net_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
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
					'str_fecha'=> $fecha1.'_A_'.$fecha2,
			        'status' => 1,
			        'data'=>"data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
			     );

	    	echo json_encode($opResult);

			
	     }

	 }//fin count
	  else{

	    if($tipo_funcion != "aut"){

	    	 echo json_encode(0);
       	 

        }else{

        	 echo json_encode(0);


        }


	  }
	  

	}
	
	

}
