<?php

set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

//php excel
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_hoteles_limpieza extends CI_Controller {


	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_hoteles_limpieza');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	     
	}

	public function get_html_rep_hoteles_limpieza(){
		
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
		$this->load->view('Reportes/view_rep_hoteles_limpieza');
		
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
        
		$rest = $this->Mod_reportes_hoteles_limpieza->get_reportes_hoteles_limp($parametros);
		
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
		        'A6'.':O'.((count($rep)) + 6).''
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


		$activeSheet->setCellValue('A5','GVC_ID_SERVICIO');
		$activeSheet->setCellValue('B5','GVC_ID_SERIE');
		$activeSheet->setCellValue('C5','GVC_DOC_NUMERO');
		$activeSheet->setCellValue('D5','GVC_ID_CLIENTE');
		$activeSheet->setCellValue('E5','GVC_RECORD_LOCALIZADOR');
		$activeSheet->setCellValue('F5','GVC_CVE_PAX');
		$activeSheet->setCellValue('G5','GVC_NOMBRE_PAX');
		$activeSheet->setCellValue('H5','GVC_NOMBRE_HOTEL');
		$activeSheet->setCellValue('I5','GVC_FECHA_ENTRADA');
		$activeSheet->setCellValue('J5','GVC_FECHA_SALIDA');
		$activeSheet->setCellValue('K5','GVC_NOCHES');
		$activeSheet->setCellValue('L5','GVC_FECHA_FACTURA');
		$activeSheet->setCellValue('M5','GVC_FECHA_RESERVACION');
		$activeSheet->setCellValue('N5','GVC_AC28');
		$activeSheet->setCellValue('O5','GVC_ID_CORPORATIVO');
		$activeSheet->setCellValue('P5','GVC_NOM_CLI');
		$activeSheet->setCellValue('Q5','GVC_ID_STAT');
       
		$activeSheet->fromArray(
	        $rep,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A6'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

		$activeSheet->getStyle('A5:Q5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $spreadsheet->getActiveSheet()->getStyle('A5:Q5')
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

		$spreadsheet->getActiveSheet()->getStyle('A1:Q'.(count($rep) + 5))->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:Q4')->applyFromArray($styleArray);

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		$spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);


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

            	
                $rz = $this->Mod_reportes_hoteles_limpieza->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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
       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GG_net_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
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
		header('Content-Disposition: attachment;filename="Reporte_GG_net_'.$fecha1.'_A_'.$fecha2.'.xlsx"'); 
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


	public function get_rep_hoteles_limpieza(){

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

		$rep = $this->reportes_hoteles_limp($parametros);

		$col = $this->Mod_reportes_hoteles_limpieza->get_columnas($id_plantilla,3);

		$param_final['rep'] = $rep;
		$param_final['col'] = $col;

		echo json_encode($param_final);

	}

	public function reportes_hoteles_limp($parametros){
		
		  $rest = $this->Mod_reportes_hoteles_limpieza->get_reportes_hoteles_limp($parametros);
		  
		    $array1 = array();

		    foreach ($rest as $clave => $valor) {
   
			 	$valor->GVC_ID_SERVICIO = utf8_encode($valor->GVC_ID_SERVICIO);
			 	$valor->GVC_ID_SERIE = utf8_encode($valor->GVC_ID_SERIE);
			 	$valor->GVC_DOC_NUMERO = utf8_encode($valor->GVC_DOC_NUMERO);
			 	$valor->GVC_ID_CLIENTE = utf8_encode($valor->GVC_ID_CLIENTE);
			 	$valor->GVC_RECORD_LOCALIZADOR = utf8_encode($valor->GVC_RECORD_LOCALIZADOR);
			 	$valor->GVC_CVE_PAX = utf8_encode($valor->GVC_CVE_PAX);
			 	$valor->GVC_NOMBRE_PAX = utf8_encode($valor->GVC_NOMBRE_PAX);
			 	$valor->GVC_NOMBRE_HOTEL = utf8_encode($valor->GVC_NOMBRE_HOTEL);
			 	$valor->GVC_FECHA_ENTRADA = utf8_encode($valor->GVC_FECHA_ENTRADA);
			 	$valor->GVC_FECHA_SALIDA = utf8_encode($valor->GVC_FECHA_SALIDA);
			 	$valor->GVC_NOCHES = utf8_encode($valor->GVC_NOCHES);
			 	$valor->GVC_FECHA_FACTURA = utf8_encode($valor->GVC_FECHA_FACTURA);
			 	$valor->GVC_FECHA_RESERVACION = utf8_encode($valor->GVC_FECHA_RESERVACION);
			 	$valor->GVC_AC28 = utf8_encode($valor->GVC_AC28);
			 	$valor->GVC_ID_CORPORATIVO = utf8_encode($valor->GVC_ID_CORPORATIVO);
			 	$valor->GVC_NOM_CLI = utf8_encode($valor->GVC_NOM_CLI);
			 	$valor->GVC_ID_STAT = utf8_encode($valor->GVC_ID_STAT);
			 	

				array_push($array1, $valor);


			}

				
				return $array1;
		
	}


}
