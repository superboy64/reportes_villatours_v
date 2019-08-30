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

class Cnt_reportes_gvc_reporteador_net extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Reportes/Mod_reportes_gvc_reporteador_net');
	      $this->load->model('Mod_catalogos_filtros');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_clientes');
	      $this->load->helper('file');
	      $this->load->library('lib_intervalos_fechas');
	      $this->load->library('lib_letras_excel');  //al llamar una libreria se hace referencia en minusculas
	     
	}
    
    public function get_html_rep_gvc_reporteador_net(){

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
		$this->load->view('Reportes/view_rep_gvc_reporteador_net');

	}


    public function get_rep_gvc_reporteador_net(){

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
        $parametros["id_plantilla"] = $id_plantilla;

		$rep = $this->reportes_gvc_reporteador_net($parametros);


		$param_final['rep'] = $rep;
		
		
		echo json_encode($param_final);
		

	}

	public function reportes_gvc_reporteador_net($parametros){

	    $rest = $this->Mod_reportes_gvc_reporteador_net->get_reportes_gvc_reporteador_net($parametros);
	  	
	  	if($rest != 'mayor'){

	  			$array1 = array();

			    $rep = [];
				foreach($rest as $value) {
		    		if(isset($value['GVC_TARIFA_MON_BASE'])){

						$value['GVC_TARIFA_MON_BASE'] = $value['GVC_TARIFA_MON_BASE'];
					}
		    		
					if(isset($value['GVC_TARIFA_MON_EXT'])){

						$value['GVC_TARIFA_MON_EXT'] = $value['GVC_TARIFA_MON_EXT'];
					}

					if(isset($value['GVC_DESCUENTO'])){

						$value['GVC_DESCUENTO'] = $value['GVC_DESCUENTO'];
					}
					
					if(isset($value['GVC_IVA_DESCUENTO'])){

						$value['GVC_IVA_DESCUENTO'] = $value['GVC_IVA_DESCUENTO'];
					}
					
					if(isset($value['GVC_COM_AGE'])){

						$value['GVC_COM_AGE'] = $value['GVC_COM_AGE'];
					}
					
					if(isset($value['GVC_COM_TIT'])){

						$value['GVC_COM_TIT'] = $value['GVC_COM_TIT'];
					}
					
					if(isset($value['GVC_COM_AUX'])){

						$value['GVC_COM_AUX'] = $value['GVC_COM_AUX'];
					}
					
					if(isset($value['GVC_POR_IVA_COM'])){

						$value['GVC_POR_IVA_COM'] = $value['GVC_POR_IVA_COM'];
					}
					
					if(isset($value['GVC_IVA'])){

						$value['GVC_IVA'] = $value['GVC_IVA'];
					}
					
					if(isset($value['GVC_TUA'])){

						$value['GVC_TUA'] = $value['GVC_TUA'];
					}
					
					if(isset($value['GVC_OTROS_IMPUESTOS'])){

						$value['GVC_OTROS_IMPUESTOS'] = $value['GVC_OTROS_IMPUESTOS'];
					}
					
					if(isset($value['GVC_TOTAL'])){

						$value['GVC_TOTAL'] = $value['GVC_TOTAL'];
					}
					
					if(isset($value['GVC_SUMA_IMPUESTOS'])){

						$value['GVC_SUMA_IMPUESTOS'] = $value['GVC_SUMA_IMPUESTOS'];
					}
					
					if(isset($value['GVC_IVA_EXT'])){

						$value['GVC_IVA_EXT'] = $value['GVC_IVA_EXT'];
					}
					
					if(isset($value['GVC_TUA_EXT'])){

						$value['GVC_TUA_EXT'] = $value['GVC_TUA_EXT'];
					}
					
					if(isset($value['GVC_OTR_EXT'])){

						$value['GVC_OTR_EXT'] = $value['GVC_OTR_EXT'];
					}
					
					if(isset($value['GVC_TARIFA_COMPARATIVA_BOLETO'])){

						$value['GVC_TARIFA_COMPARATIVA_BOLETO'] = $value['GVC_TARIFA_COMPARATIVA_BOLETO'];
					}
					
					if(isset($value['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'])){

						$value['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'] = $value['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'];
					}

		    		$cast_utf8 = array_map("utf8_encode", $value );
		    		array_push($array1, $cast_utf8);
				    
				}

			    return $array1;


	  	}else{

	  		return $rest;

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


      	$rest_plantilla = $this->Mod_reportes_gvc_reporteador_net->get_columnas($id_plantilla,4);

      	$array_num_letra = []; 
		$rep_plantilla = [];
		
		$cont_letra = 1;
		foreach($rest_plantilla as $clave => $value) {
    		
    		if($value->nombre_columna_vista  == 'TARIFA BASE'){

				array_push($array_num_letra, $cont_letra);

			}
    		
			if($value->nombre_columna_vista == 'TARIFA BASE USD'){

				array_push($array_num_letra, $cont_letra);

			}

			if($value->nombre_columna_vista ==  'DESCUENTO'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'IVA DESCUENTO'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'COM AGE'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'COM  VEND TIT'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'COM VEND AUX'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'POR IVA COM'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'IVA'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'TUA'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'OTROS IMPUESTOS'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'TOTAL'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'SUMA DE IMPUESTOS'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'IVA USD'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'TUA USD'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'OTROS IMPUESTOS USD'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'TARIFA COMPARATIVA BOLETO'){

				array_push($array_num_letra, $cont_letra);
				
			}
			
			if($value->nombre_columna_vista == 'TARIFA COMPARATIVA BOLETO USD'){

				array_push($array_num_letra, $cont_letra);
				
			}

    		array_push($rep_plantilla, $value->nombre_columna_vista);

    		$cont_letra++;
		    
		}

		$rest = $this->Mod_reportes_gvc_reporteador_net->get_reportes_gvc_reporteador_net($parametros);

		$rep = [];
		foreach($rest as $clave => $value) {
    		
			if(isset($value['GVC_TARIFA_MON_BASE'])){

				$value['GVC_TARIFA_MON_BASE'] = $value['GVC_TARIFA_MON_BASE'];
								
			}
    		
			if(isset($value['GVC_TARIFA_MON_EXT'])){

				$value['GVC_TARIFA_MON_EXT'] = $value['GVC_TARIFA_MON_EXT'];
				
			}

			if(isset($value['GVC_DESCUENTO'])){

				$value['GVC_DESCUENTO'] = $value['GVC_DESCUENTO'];
				
			}
			
			if(isset($value['GVC_IVA_DESCUENTO'])){

				$value['GVC_IVA_DESCUENTO'] = $value['GVC_IVA_DESCUENTO'];
				
			}
			
			if(isset($value['GVC_COM_AGE'])){

				$value['GVC_COM_AGE'] = $value['GVC_COM_AGE'];
				
			}
			
			if(isset($value['GVC_COM_TIT'])){

				$value['GVC_COM_TIT'] = $value['GVC_COM_TIT'];
				
			}
			
			if(isset($value['GVC_COM_AUX'])){

				$value['GVC_COM_AUX'] = $value['GVC_COM_AUX'];
				
			}
			
			if(isset($value['GVC_POR_IVA_COM'])){

				$value['GVC_POR_IVA_COM'] = $value['GVC_POR_IVA_COM'];
				
			}
			
			if(isset($value['GVC_IVA'])){

				$value['GVC_IVA'] = $value['GVC_IVA'];
				
			}
			
			if(isset($value['GVC_TUA'])){

				$value['GVC_TUA'] = $value['GVC_TUA'];
				
			}
			
			if(isset($value['GVC_OTROS_IMPUESTOS'])){

				$value['GVC_OTROS_IMPUESTOS'] = $value['GVC_OTROS_IMPUESTOS'];
				
			}
			
			if(isset($value['GVC_TOTAL'])){

				$value['GVC_TOTAL'] = $value['GVC_TOTAL'];
				
			}
			
			if(isset($value['GVC_SUMA_IMPUESTOS'])){

				$value['GVC_SUMA_IMPUESTOS'] = $value['GVC_SUMA_IMPUESTOS'];
				
			}
			
			if(isset($value['GVC_IVA_EXT'])){

				$value['GVC_IVA_EXT'] = $value['GVC_IVA_EXT'];
				
			}
			
			if(isset($value['GVC_TUA_EXT'])){

				$value['GVC_TUA_EXT'] = $value['GVC_TUA_EXT'];
				
			}
			
			if(isset($value['GVC_OTR_EXT'])){

				$value['GVC_OTR_EXT'] = $value['GVC_OTR_EXT'];
				
			}
			
			if(isset($value['GVC_TARIFA_COMPARATIVA_BOLETO'])){

				$value['GVC_TARIFA_COMPARATIVA_BOLETO'] = $value['GVC_TARIFA_COMPARATIVA_BOLETO'];
				
			}
			
			if(isset($value['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'])){

				$value['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'] = $value['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'];
				
			}


    		$cast_utf8 = array_map("utf8_encode", $value );
    		array_push($rep, $cast_utf8);
		    

		}

	  if(count($rep) > 0){

		$spreadsheet = new Spreadsheet();  
		$Excel_writer = new Xlsx($spreadsheet);

		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet();
	
		$spreadsheet->getActiveSheet()->mergeCells('F1:K1');
		$spreadsheet->getActiveSheet()->mergeCells('F2:K2');
		$spreadsheet->getActiveSheet()->mergeCells('F3:K3');
		$spreadsheet->getActiveSheet()->mergeCells('F4:K4');

		$spreadsheet->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        //$array_num_letra = array_unique($array_num_letra);
		foreach ($array_num_letra as $clave => $valor) {

			$letra = $this->lib_letras_excel->get_letra_excel($valor);
				
			$spreadsheet->getActiveSheet()
			    ->getStyle($letra.'5:'.$letra.((count($rep)) + 6))
			    ->getNumberFormat()
			    ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

					
		}
			

		if( count($rep_plantilla) == 0){

			$cantidad_columnas = count($rep);


		}else{

			$cantidad_columnas = count($rep_plantilla);

		}


		$rango_final = $this->lib_letras_excel->get_letra_excel($cantidad_columnas);


		$activeSheet->getStyle('A5:'.$rango_final.'5')->getFill()
	    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
	    ->getStartColor()->setARGB('1f497d');

	    $activeSheet->getStyle('A5:'.$rango_final.'5')
        ->getFont()->getColor()->setARGB('ffffff');

		$styleArray = [
		    'borders' => [
		        //'diagonalDirection' => \PhpOffice\PhpSpreadsheet\Style\Borders::DIAGONAL_BOTH,
		        'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		             'color' => ['argb' => 'ffffff'],
		        ],
		    ],
		    'font' => [
        				'size' => 9
    				  ]
		];

		$spreadsheet->getActiveSheet()->getStyle('A1:EG'.(count($rep) + 5))->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A1:AB4')->applyFromArray($styleArray);

		$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
		
		$activeSheet->getColumnDimension('AB')->setAutoSize(true);

	
	    //fin columnas con formato de moneda

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

		$activeSheet->setCellValue('F1','Detalle de consumos' )->getStyle('F1')->getFont()->setBold(true)->setSize(25);


		$activeSheet->fromArray(
	        $rep_plantilla,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A5'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );

		$activeSheet->fromArray(
	        $rep,  // The data to set
	        NULL,        // Array values with this value will not be set
	        'A6'         // Top left coordinate of the worksheet range where
	                     //    we want to set these values (default is A1)
	    );


		if($tipo_funcion == "aut"){
			
			     $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

        		 $rango_fechas = explode("_", $rango_fechas);

        		 $fecha1 = $rango_fechas[0];
        		 $fecha2 = $rango_fechas[1];

        	   	 $activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);
        	
		}else{

			$activeSheet->setCellValue('F4',$fecha1.' - '.$fecha2)->getStyle('F4')->getFont()->setSize(14);

		}

		

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

            	
                $rz = $this->Mod_reportes_gvc_reporteador_net->get_razon_social_id_in($ids_cliente);  //optiene razon social
                
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


       if($tipo_funcion == "aut"){

       	$str_fecha = $fecha1.'_A_'.$fecha2;
       	$Excel_writer->save($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Detalle_consumos_p_'.$str_fecha.'_'.$id_correo_automatico.'_'.$id_reporte.'.xlsx');
       	echo json_encode(1); //cuando es uno si tiene informacion

       }else{

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Detalle_consumos_p_'.$fecha1.'_A_'.$fecha2.'.xlsx"'); 
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
