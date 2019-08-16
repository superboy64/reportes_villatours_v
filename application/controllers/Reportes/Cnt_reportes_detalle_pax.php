<?php
set_time_limit(0);
ini_set('post_max_size','10000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_detalle_pax extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_detalle_pax');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	     
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

		$this->load->view('Reportes/view_rep_detalle_pax');
		
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
                
                $rz = $this->Mod_reportes_detalle_pax->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

		$this->load->view('Reportes/view_rep_detalle_pax_html',$array2);
		

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
      
		$rest_pasajero = $this->Mod_reportes_detalle_pax->get_pasajero($parametros);

		$rest_pasajero_det = $this->Mod_reportes_detalle_pax->get_pasajero_detalle($parametros);

		$array_nuevo_formato = [];

		$array_tot_gen_GVC_TARIFA_MON_BASE = [];
		$array_tot_gen_GVC_IVA = [];
		$array_tot_gen_GVC_TUA = [];
		$array_tot_gen_GVC_OTROS_IMPUESTOS = [];
		$array_tot_gen_total = [];

		foreach ($rest_pasajero as $key => $value) {

		  $dat['GVC_NOM_PAX'] = ''; 
	      $dat['GVC_ID_SERIE']  = ''; 
	      $dat['GVC_DOC_NUMERO'] = ''; 
	      $dat['GVC_ID_CORPORATIVO'] = ''; 
	      $dat['GVC_ID_CLIENTE']  = ''; 
	      $dat['GVC_NOM_CLI']  = ''; 
	      $dat['GVC_ID_CENTRO_COSTO']  = ''; 
	      $dat['GVC_DESC_CENTRO_COSTO']  = ''; 
	      $dat['GVC_FECHA']  = ''; 
	      $dat['GVC_SOLICITO']  = ''; 
	      $dat['GVC_CVE_RES_GLO']  = ''; 
	      $dat['GVC_BOLETO']  = ''; 
	      $dat['GVC_ID_SERVICIO']  = ''; 
	      $dat['GVC_ID_PROVEEDOR']  = ''; 
	      $dat['GVC_NOMBRE_PROVEEDOR']  = ''; 
	      $dat['GVC_CONCEPTO']  = 'TOTAL';

	      $dat['GVC_TARIFA_MON_BASE']  = utf8_encode($value->GVC_TARIFA_MON_BASE);
	      $dat['GVC_IVA']  = utf8_encode($value->GVC_IVA);
	      $dat['GVC_TUA']  = utf8_encode($value->GVC_TUA);
	      $dat['GVC_OTROS_IMPUESTOS']  = utf8_encode($value->GVC_OTROS_IMPUESTOS);
	      $dat['GVC_TOTAL']  = $value->total;

	      $dat['GVC_CLASE_FACTURADA']  = ''; 
	      $dat['GVC_FECHA_SALIDA']  = ''; 
	      $dat['GVC_FECHA_REGRESO']  = ''; 
	      $dat['GVC_FECHA_EMISION_BOLETO']  = '';   
	      $dat['GVC_CLAVE_EMPLEADO']  = ''; 
	      $dat['GVC_FOR_PAG1']  = ''; 
	      $dat['GVC_FECHA_RESERVACION']  = ''; 
	      $dat['TIPO']  = 'TOTALES';


			foreach ($rest_pasajero_det as $key2 => $value2) {
				
			  $dat_det['GVC_NOM_PAX'] = utf8_encode($value2->GVC_NOM_PAX); 
		      $dat_det['GVC_ID_SERIE']  = utf8_encode($value2->GVC_ID_SERIE); 
		      $dat_det['GVC_DOC_NUMERO'] = utf8_encode($value2->GVC_DOC_NUMERO); 
		      $dat_det['GVC_ID_CORPORATIVO'] = utf8_encode($value2->GVC_ID_CORPORATIVO);
		      $dat_det['GVC_ID_CLIENTE']  = utf8_encode($value2->GVC_ID_CLIENTE);
		      $dat_det['GVC_NOM_CLI']  = utf8_encode($value2->GVC_NOM_CLI);
		      $dat_det['GVC_ID_CENTRO_COSTO']  = utf8_encode($value2->GVC_ID_CENTRO_COSTO); 
		      $dat_det['GVC_DESC_CENTRO_COSTO']  = utf8_encode($value2->GVC_DESC_CENTRO_COSTO);
		      $dat_det['GVC_FECHA']  = utf8_encode($value2->GVC_FECHA);
		      $dat_det['GVC_SOLICITO']  = utf8_encode($value2->GVC_SOLICITO);
		      $dat_det['GVC_CVE_RES_GLO']  = utf8_encode($value2->GVC_CVE_RES_GLO);
		      $dat_det['GVC_BOLETO']  = utf8_encode($value2->GVC_BOLETO);
		      $dat_det['GVC_ID_SERVICIO']  = utf8_encode($value2->GVC_ID_SERVICIO);
		      $dat_det['GVC_ID_PROVEEDOR']  = utf8_encode($value2->GVC_ID_PROVEEDOR);
		      $dat_det['GVC_NOMBRE_PROVEEDOR']  = utf8_encode($value2->GVC_NOMBRE_PROVEEDOR);
		      $dat_det['GVC_CONCEPTO']  = utf8_encode($value2->GVC_CONCEPTO);

		      $dat_det['GVC_TARIFA_MON_BASE']  = utf8_encode($value2->GVC_TARIFA_MON_BASE);
		      $dat_det['GVC_IVA']  = utf8_encode($value2->GVC_IVA);
		      $dat_det['GVC_TUA']  = utf8_encode($value2->GVC_TUA);
		      $dat_det['GVC_OTROS_IMPUESTOS']  = utf8_encode($value2->GVC_OTROS_IMPUESTOS);
		      $dat_det['GVC_TOTAL']  = $value2->total;

		      $dat_det['GVC_CLASE_FACTURADA']  = utf8_encode($value2->GVC_CLASE_FACTURADA);
		      $dat_det['GVC_FECHA_SALIDA']  = $value2->GVC_FECHA_SALIDA;
		      $dat_det['GVC_FECHA_REGRESO']  = $value2->GVC_FECHA_REGRESO;
		      $dat_det['GVC_FECHA_EMISION_BOLETO']  = $value2->GVC_FECHA_EMISION_BOLETO;  
		      $dat_det['GVC_CLAVE_EMPLEADO']  = $value2->GVC_CLAVE_EMPLEADO;
		      $dat_det['GVC_FOR_PAG1']  = $value2->GVC_FOR_PAG1;
		      $dat_det['GVC_FECHA_RESERVACION']  = $value2->GVC_FECHA_RESERVACION;
		      $dat_det['TIPO']  = 'DESCRIPCION';
				

			  if( ltrim(rtrim($value->GVC_NOM_PAX)) == ltrim(rtrim($value2->GVC_NOM_PAX)) ){


				 array_push($array_nuevo_formato, $dat_det);
				

			  }


			}

			array_push($array_nuevo_formato, $dat);

			array_push($array_tot_gen_GVC_TARIFA_MON_BASE, $value->GVC_TARIFA_MON_BASE);
			array_push($array_tot_gen_GVC_IVA, $value->GVC_IVA);
			array_push($array_tot_gen_GVC_TUA, $value->GVC_TUA);
			array_push($array_tot_gen_GVC_OTROS_IMPUESTOS, $value->GVC_OTROS_IMPUESTOS);
			array_push($array_tot_gen_total, $value->total);
			
			


		}

		$tot_gen_GVC_TARIFA_MON_BASE = array_sum($array_tot_gen_GVC_TARIFA_MON_BASE);
		$tot_gen_GVC_IVA = array_sum($array_tot_gen_GVC_IVA);
		$tot_gen_GVC_TUA = array_sum($array_tot_gen_GVC_TUA);
		$tot_gen_GVC_OTROS_IMPUESTOS = array_sum($array_tot_gen_GVC_OTROS_IMPUESTOS);
		$tot_gen_total = array_sum($array_tot_gen_total);


		$rest['array_nuevo_formato']  = $array_nuevo_formato;

		$rest['tot_gen_GVC_TARIFA_MON_BASE']  = $tot_gen_GVC_TARIFA_MON_BASE;
		$rest['tot_gen_GVC_IVA']  = $tot_gen_GVC_IVA;
		$rest['tot_gen_GVC_TUA']  = $tot_gen_GVC_TUA;
		$rest['tot_gen_GVC_OTROS_IMPUESTOS']  = $tot_gen_GVC_OTROS_IMPUESTOS;
		$rest['tot_gen_total']  = $tot_gen_total;


	    echo json_encode($rest,JSON_NUMERIC_CHECK);
	  

	}

	public function exportar_excel_ae(){

		$parametros = $_REQUEST['parametros'];
		$id_servicio = $this->input->post("id_servicio");
		//$img_grafica = $_REQUEST['img_grafica'];

		$rest_pasajero = $_REQUEST['data'];            //se quedo como idefinido :O
		


		//$rest_pasajero_gen = $_REQUEST['data']; 
		
		$rest_pasajero = json_decode($rest_pasajero);
		
		//$rest_pasajero_gen = json_decode($rest_pasajero_gen);


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
		$spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);


		$activeSheet->getStyle('A5:AB5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('A5:AB5')
        ->getFont()->getColor()->setARGB('ffffff');

		 $styleArray = [
		    'borders' => [
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ],
		];


		$spreadsheet->getActiveSheet()->getStyle('A1:AB'. (  (int)(count($rest_pasajero->array_nuevo_formato)) + 4) )->applyFromArray($styleArray);

		$spreadsheet->getActiveSheet()->getStyle('A6')
        ->getFont()->setSize(10);

        $spreadsheet->getActiveSheet()
		    ->duplicateStyle(
		        $spreadsheet->getActiveSheet()->getStyle('A6'),
		        'A6'.':AB'.(count($rest_pasajero->array_nuevo_formato)+ 4)  .''
		    );

			$activeSheet->setCellValue('A5','PASAJERO');
	        $activeSheet->setCellValue('B5','SERIE');
			$activeSheet->setCellValue('C5','DOCUMENTO');
			$activeSheet->setCellValue('D5','CORPORATIVO');
			$activeSheet->setCellValue('E5','CLIENTE');
			$activeSheet->setCellValue('F5','NOMBRE CLIENTE');
			$activeSheet->setCellValue('G5','CC');
			$activeSheet->setCellValue('H5','DESC CC');
			$activeSheet->setCellValue('I5','FECHA DOCUMENTO');
			$activeSheet->setCellValue('J5','QUIEN SOLICITO');
			$activeSheet->setCellValue('K5','PNR');
			$activeSheet->setCellValue('L5','BOLETO');
			$activeSheet->setCellValue('M5','CVE DE SERVICIO');
			$activeSheet->setCellValue('N5','CVE DE PROVEEDOR');
			$activeSheet->setCellValue('O5','NOMBRE PROVEEDOR');
			$activeSheet->setCellValue('P5','RUTA');
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

			$activeSheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	        $activeSheet->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	        $activeSheet->getStyle('C3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	        $activeSheet->getStyle('D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('E5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('F5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('G5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('J5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('K5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('L5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('M5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('N5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('O5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('P5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('Q5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('R5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('S5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('T5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('U5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('V5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('W5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('X5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('Y5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('Z5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('AA5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyle('AB5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			

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



		$array_tot_gen_GVC_TARIFA_MON_BASE = [];
		$array_tot_gen_GVC_IVA = [];
		$array_tot_gen_GVC_TUA = [];
		$array_tot_gen_GVC_OTROS_IMPUESTOS = [];
		$array_tot_gen_total = [];

		$cont = 6;

		if(count($rest_pasajero->array_nuevo_formato) > 0){

        foreach ($rest_pasajero->array_nuevo_formato as $valor) {

        	if($valor->TIPO == 'DESCRIPCION' ){

        		$activeSheet->setCellValue('A'.$cont,$valor->GVC_NOM_PAX);
        		$activeSheet->setCellValue('B'.$cont,$valor->GVC_ID_SERIE);
        		$activeSheet->setCellValue('C'.$cont,$valor->GVC_DOC_NUMERO);
        		$activeSheet->setCellValue('D'.$cont,$valor->GVC_ID_CORPORATIVO);
        		$activeSheet->setCellValue('E'.$cont,$valor->GVC_ID_CLIENTE);
        		$activeSheet->setCellValue('F'.$cont,$valor->GVC_NOM_CLI);
        		$activeSheet->setCellValue('G'.$cont,$valor->GVC_ID_CENTRO_COSTO);
        		$activeSheet->setCellValue('H'.$cont,$valor->GVC_DESC_CENTRO_COSTO);
        		$activeSheet->setCellValue('I'.$cont,$valor->GVC_FECHA);
        		$activeSheet->setCellValue('J'.$cont,$valor->GVC_SOLICITO);
        		$activeSheet->setCellValue('K'.$cont,$valor->GVC_CVE_RES_GLO);
        		$activeSheet->setCellValue('L'.$cont,$valor->GVC_BOLETO);
        		$activeSheet->setCellValue('M'.$cont,$valor->GVC_ID_SERVICIO);
        		$activeSheet->setCellValue('N'.$cont,$valor->GVC_ID_PROVEEDOR);
        		$activeSheet->setCellValue('O'.$cont,$valor->GVC_NOMBRE_PROVEEDOR);
        		$activeSheet->setCellValue('P'.$cont,$valor->GVC_CONCEPTO);

        		$activeSheet->setCellValue('Q'.$cont,$valor->GVC_TARIFA_MON_BASE);
        		$activeSheet->setCellValue('R'.$cont,$valor->GVC_IVA);
        		$activeSheet->setCellValue('S'.$cont,$valor->GVC_TUA);
        		$activeSheet->setCellValue('T'.$cont,$valor->GVC_OTROS_IMPUESTOS);
        		$activeSheet->setCellValue('U'.$cont,$valor->GVC_TOTAL);

        		$activeSheet->setCellValue('V'.$cont,$valor->GVC_CLASE_FACTURADA);
        		$activeSheet->setCellValue('W'.$cont,$valor->GVC_FECHA_SALIDA);
        		$activeSheet->setCellValue('X'.$cont,$valor->GVC_FECHA_REGRESO);
        		$activeSheet->setCellValue('Y'.$cont,$valor->GVC_FECHA_EMISION_BOLETO);
        		$activeSheet->setCellValue('Z'.$cont,$valor->GVC_CLAVE_EMPLEADO);
        		$activeSheet->setCellValue('AA'.$cont,$valor->GVC_FOR_PAG1);
        		$activeSheet->setCellValue('AB'.$cont,$valor->GVC_FECHA_RESERVACION);


        	}else{

        		$activeSheet->setCellValue('A'.$cont,'')->getStyle('A'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('B'.$cont,$valor->GVC_ID_SERIE)->getStyle('B'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('C'.$cont,$valor->GVC_DOC_NUMERO)->getStyle('C'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('D'.$cont,$valor->GVC_ID_CORPORATIVO)->getStyle('D'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('E'.$cont,$valor->GVC_ID_CLIENTE)->getStyle('E'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('F'.$cont,$valor->GVC_NOM_CLI)->getStyle('F'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('G'.$cont,$valor->GVC_ID_CENTRO_COSTO)->getStyle('G'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('H'.$cont,$valor->GVC_DESC_CENTRO_COSTO)->getStyle('H'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('I'.$cont,$valor->GVC_FECHA)->getStyle('I'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('J'.$cont,$valor->GVC_SOLICITO)->getStyle('J'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('K'.$cont,$valor->GVC_CVE_RES_GLO)->getStyle('K'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('L'.$cont,$valor->GVC_BOLETO)->getStyle('L'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('M'.$cont,$valor->GVC_ID_SERVICIO)->getStyle('M'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('N'.$cont,$valor->GVC_ID_PROVEEDOR)->getStyle('N'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('O'.$cont,$valor->GVC_NOMBRE_PROVEEDOR)->getStyle('O'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('P'.$cont,$valor->GVC_CONCEPTO)->getStyle('P'.$cont)->getFont()->setBold(true)->setSize(11);

        		$activeSheet->setCellValue('Q'.$cont,$valor->GVC_TARIFA_MON_BASE)->getStyle('Q'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('R'.$cont,$valor->GVC_IVA)->getStyle('R'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('S'.$cont,$valor->GVC_TUA)->getStyle('S'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('T'.$cont,$valor->GVC_OTROS_IMPUESTOS)->getStyle('T'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('U'.$cont,$valor->GVC_TOTAL)->getStyle('U'.$cont)->getFont()->setBold(true)->setSize(11);

        		$activeSheet->setCellValue('V'.$cont,$valor->GVC_CLASE_FACTURADA)->getStyle('V'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('W'.$cont,$valor->GVC_FECHA_SALIDA)->getStyle('W'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('X'.$cont,$valor->GVC_FECHA_REGRESO)->getStyle('X'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('Y'.$cont,$valor->GVC_FECHA_EMISION_BOLETO)->getStyle('Y'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('Z'.$cont,$valor->GVC_CLAVE_EMPLEADO)->getStyle('Z'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('AA'.$cont,$valor->GVC_FOR_PAG1)->getStyle('AA'.$cont)->getFont()->setBold(true)->setSize(11);
        		$activeSheet->setCellValue('AB'.$cont,$valor->GVC_FECHA_RESERVACION)->getStyle('AB'.$cont)->getFont()->setBold(true)->setSize(11);


        		$activeSheet->getStyle('P'.$cont)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        		array_push($array_tot_gen_GVC_TARIFA_MON_BASE, $valor->GVC_TARIFA_MON_BASE);
				array_push($array_tot_gen_GVC_IVA, $valor->GVC_IVA);
				array_push($array_tot_gen_GVC_TUA, $valor->GVC_TUA);
				array_push($array_tot_gen_GVC_OTROS_IMPUESTOS, $valor->GVC_OTROS_IMPUESTOS);
				array_push($array_tot_gen_total, $valor->GVC_TOTAL);

        	}



        $cont++;

        }

        $tot_gen_GVC_TARIFA_MON_BASE = array_sum($array_tot_gen_GVC_TARIFA_MON_BASE);
		$tot_gen_GVC_IVA = array_sum($array_tot_gen_GVC_IVA);
		$tot_gen_GVC_TUA = array_sum($array_tot_gen_GVC_TUA);
		$tot_gen_GVC_OTROS_IMPUESTOS = array_sum($array_tot_gen_GVC_OTROS_IMPUESTOS);
		$tot_gen_total = array_sum($array_tot_gen_total);


		$activeSheet->setCellValue('P'.(count($rest_pasajero->array_nuevo_formato) + 6),'TOTAL GENERAL')->getStyle('P'.(count($rest_pasajero->array_nuevo_formato) + 6))->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('Q'.(count($rest_pasajero->array_nuevo_formato) + 6),$tot_gen_GVC_TARIFA_MON_BASE)->getStyle('Q'.(count($rest_pasajero->array_nuevo_formato) + 6))->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('R'.(count($rest_pasajero->array_nuevo_formato) + 6),$tot_gen_GVC_IVA)->getStyle('R'.(count($rest_pasajero->array_nuevo_formato) + 6))->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('S'.(count($rest_pasajero->array_nuevo_formato) + 6),$tot_gen_GVC_TUA)->getStyle('S'.(count($rest_pasajero->array_nuevo_formato) + 6))->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('T'.(count($rest_pasajero->array_nuevo_formato) + 6),$tot_gen_GVC_OTROS_IMPUESTOS)->getStyle('T'.(count($rest_pasajero->array_nuevo_formato) + 6))->getFont()->setBold(true)->setSize(11);
		$activeSheet->setCellValue('U'.(count($rest_pasajero->array_nuevo_formato) + 6),$tot_gen_total)->getStyle('U'.(count($rest_pasajero->array_nuevo_formato) + 6))->getFont()->setBold(true)->setSize(11);

		$spreadsheet->getActiveSheet()->getStyle('P'.(count($rest_pasajero->array_nuevo_formato) + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		
		$activeSheet->getStyle('P'.(count($rest_pasajero->array_nuevo_formato) + 6).':U'.(count($rest_pasajero->array_nuevo_formato) + 6).'')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('010101');

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
       
		$activeSheet->setCellValue('F1','DETALLE PASAJERO' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);

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

            	
                $rz = $this->Mod_reportes_detalle_pax->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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

       		$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_detalle_pax_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');

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


		
	 }else{

		if($tipo_funcion != "aut"){

       	    echo json_encode(0); //cuando es uno si tiene informacion

        }else{

        	echo json_encode(0); //cuando es uno si tiene informacion

        }
		
	}

	}//fin de count
	


}
