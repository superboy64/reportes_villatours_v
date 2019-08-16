<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Cnt_reportes_serv_24hrs extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_serv_24hrs');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');

	     
	}

	public function get_html_rep_pasajeros_servicio(){

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

		$this->load->view('Reportes/view_rep_serv_24hrs');
		
	}

	public function get_grafica_pasajero_html(){

		$rows_grafica = $this->input->post("rows_grafica");
		$rows_provedores_servicio = $this->input->post("rows_provedores_servicio");

		
		$para = $this->input->post("parametros");

		$id_servicio = $this->input->post("id_servicio");

		$parametros = explode(",", $para);


		$ids_suc = $parametros[0];
		$ids_serie = $parametros[1];
        $ids_cliente = $parametros[2];
        $ids_servicio = $parametros[3];  
        $ids_provedor = $parametros[4];
        $ids_corporativo = $parametros[5];
        $fecha1 = $parametros[6];
        $fecha2 = $parametros[7];

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

            }else if(count($ids_cliente) > 0){

            	$sub = "";
                
                $rz = $this->Mod_reportes_serv_24hrs->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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
		$array2["rows_provedores_servicio"] = $rows_provedores_servicio;
		$array2["id_servicio"] =  $id_servicio;
		$array2["fecha1"] =  $fecha1;
		$array2["fecha2"] =  $fecha2;
		$array2["sub"] =  $sub;


	
		$this->load->view('Reportes/formatos/view_formato_html_rep_serv_24hrs',$array2);

		

	}


	public function get_grafica_pasajero(){

		$para = $this->input->post("parametros");
		//$id_servicio = $this->input->post("id_servicio");
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
			$ids_servicio = $parametros[3];  //esta vacio --no se ocupa en este reporte 
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
      	
      
		$rest_grafica = $this->Mod_reportes_serv_24hrs->get_grafica_pasajero($parametros);
		$rest_provedores_servicio = $this->Mod_reportes_serv_24hrs->get_provedores_servicio($parametros);
		

		foreach ($rest_grafica as $key => $value) {
		
			$value->AGENT =  utf8_encode($value->AGENT);

		}

		$array2["grafica"] = $rest_grafica;


		foreach ($rest_provedores_servicio as $key => $value) {
		
			$value->AGENT =  utf8_encode($value->AGENT);
			$value->GVC_ID_SERVICIO =  utf8_encode($value->GVC_ID_SERVICIO);

		}

		$array2["provedores_servicio"] = $rest_provedores_servicio;
		

	    echo json_encode( $array2, JSON_NUMERIC_CHECK );

	}

	public function exportar_excel_ae(){

		$parametros = $_REQUEST['parametros'];
		$id_servicio = $this->input->post("id_servicio");

		$tipo_funcion = $_REQUEST['tipo_funcion'];  //falta

		$id_us = $this->session->userdata('session_id');
		
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

		$parametros["proceso"] = 2;

		$rest_grafica = $this->Mod_reportes_serv_24hrs->get_grafica_pasajero($parametros);
        $rest_provedores_servicio = $this->Mod_reportes_serv_24hrs->get_provedores_servicio($parametros);

        foreach ($rest_grafica as $key => $value) {
		
			$value['AGENT'] =  utf8_encode($value['AGENT']);

		}

		$array2["grafica"] = $rest_grafica;


		foreach ($rest_provedores_servicio as $key => $value) {
		
			$value['AGENT'] =  utf8_encode($value['AGENT']);
			$value['GVC_ID_SERVICIO'] =  utf8_encode($value['GVC_ID_SERVICIO']);

		}

        if(count($rest_grafica) > 0){

		
        $spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();

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


        $activeSheet->setCellValue('B10','AGENTE');
        $activeSheet->setCellValue('C10','CLAVE DE SERVICIO');
		$activeSheet->setCellValue('D10','# TRANSACCIONES');
		$activeSheet->setCellValue('E10','TARIFA/Pesos');

		
		//******************************************************************************
		$cont = 0;
		$TOTAL_GEN = 0;
    	$TOTAL_BOL_GEN = 0;
		  foreach ($rest_grafica as $clave => $valor) {  

		      if($valor['TOTAL'] != 0 && $valor['TOTAL'] != ""){

		        $AGENT = $valor['AGENT'];
		        $TOTAL = $valor['TOTAL'];
		        $TOTAL_BOL = $valor['TOTAL_BOL'];

		        $TOTAL_GEN = $TOTAL_GEN + $TOTAL;
        		$TOTAL_BOL_GEN = $TOTAL_BOL_GEN + $TOTAL_BOL;

		      $count=0;
		      foreach ($rest_provedores_servicio as $clave2 => $valor2) {  

		       $AGENT2 = $valor2['AGENT'];
		       $TOTAL2 = $valor2['TOTAL'];
		       $TOTAL_BOL2 = $valor2['TOTAL_BOL'];
		       $GVC_ID_SERVICIO2 = $valor2['GVC_ID_SERVICIO'];

		        if($AGENT2 == $AGENT){
		          $cont++;
		          $count++;

		          if($count==1){


		            $activeSheet->setCellValue('B'.($cont+10),$AGENT );
		            $activeSheet->setCellValue('C'.($cont+10),$GVC_ID_SERVICIO2 );
			        $activeSheet->setCellValue('D'.($cont+10),$TOTAL_BOL2);
				    $activeSheet->setCellValue('E'.($cont+10),$TOTAL2);


		          }else{

		            $activeSheet->setCellValue('B'.($cont+10),'' );
		            $activeSheet->setCellValue('C'.($cont+10),$GVC_ID_SERVICIO2 );
			        $activeSheet->setCellValue('D'.($cont+10),$TOTAL_BOL2);
				    $activeSheet->setCellValue('E'.($cont+10),$TOTAL2);


		          }

		        }//fin validacion pax

		      }//fin for rows_provedores_servicio

		      $cont++;

		      $activeSheet->setCellValue('B'.($cont+10),'Total '.$AGENT)->getStyle('B'.($cont+10))->getFont()->setBold(true);
	          $activeSheet->setCellValue('C'.($cont+10),'')->getStyle('C'.($cont+10))->getFont()->setBold(true);
		      $activeSheet->setCellValue('D'.($cont+10),$TOTAL_BOL)->getStyle('D'.($cont+10))->getFont()->setBold(true);
			  $activeSheet->setCellValue('E'.($cont+10),$TOTAL)->getStyle('E'.($cont+10))->getFont()->setBold(true);


		    }// fin validacion vacios


		  } //fin for
		  
		  $cont++; 
		  $spreadsheet->getActiveSheet()->getStyle('A1:F'.($cont+10))->applyFromArray($styleArray);

		  $activeSheet->setCellValue('B'.($cont+10),'Total general')->getStyle('B'.($cont+10))->getFont()->setBold(true);
          $activeSheet->setCellValue('C'.($cont+10),'')->getStyle('C'.($cont+10))->getFont()->setBold(true);
	      $activeSheet->setCellValue('D'.($cont+10),$TOTAL_BOL_GEN)->getStyle('D'.($cont+10))->getFont()->setBold(true);
		  $activeSheet->setCellValue('E'.($cont+10),$TOTAL_GEN)->getStyle('E'.($cont+10))->getFont()->setBold(true);

		$activeSheet->getStyle('B'.($cont+10).':E'.($cont+10).'')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('010101');

	    $spreadsheet->getActiveSheet()->getStyle('B'.($cont+10).':E'.($cont+10).'')
        ->getFont()->getColor()->setARGB('ffffff');

         $spreadsheet->getActiveSheet()
			    ->getStyle('E11:E'.($cont+10))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
	  	//****************************************************************************************************************

	  	$activeSheet->getStyle('B10:E10')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');
	    
	    $spreadsheet->getActiveSheet()->getStyle('B10:E10')
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
		$drawing2->setCoordinates('E1');
		$drawing2->setPath($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/img/91_4c.gif');
		$drawing2->setHeight(60);
		$drawing2->setWidth(60);
        $drawing2->setWorksheet($spreadsheet->getActiveSheet());
       	
       	$ids_corporativo =  explode('_', $ids_corporativo);
		$ids_corporativo = array_filter($ids_corporativo, "strlen");
  	    $ids_cliente =  explode('_', $ids_cliente);
  	    $ids_cliente = array_filter($ids_cliente, "strlen");

  	    $activeSheet->setCellValue('B6','Servicios 24 hrs')->getStyle('B6')->getFont()->setBold(true)->setSize(25);
        
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
	                
	                $rz = $this->Mod_reportes_serv_24hrs->get_razon_social_id_in($ids_cliente);  //optiene razon social
	                
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
                
                $rz = $this->Mod_reportes_serv_24hrs->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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
        
			$str_fecha = $fecha1.'_A_'.$fecha2;
	       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Serv_24hrs_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
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
