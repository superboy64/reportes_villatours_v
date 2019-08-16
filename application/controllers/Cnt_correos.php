<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');
defined('BASEPATH') OR exit('No direct script access allowed');


//php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Cnt_correos extends CI_Controller {

	public function __construct()
	{
	      parent::__construct();
	      $this->load->model('Mod_correos');
	      $this->load->model('Mod_usuario');
	      $this->load->model('Reportes/Mod_reportes_gastos_gen');
	      $this->load->library('lib_intervalos_fechas');
	}

	public function prueba_correos(){

		$title = $this->input->post('title');
		$id_perfil = $this->session->userdata('session_id_perfil');
		$param['id_perfil'] = $id_perfil;
		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		$param['title'] = $title;

		$this->load->view('Correos/form_envio_de_correo',$param);
		$this->load->view('Correos/scripts/script_form_envio_de_correo',$param);

	}

	public function consulta_correos_programados(){

		$title = $this->input->post('title');
		$id_perfil = $this->session->userdata('session_id_perfil');
		$param['id_perfil'] = $id_perfil;
		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		$param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Correos/consulta_correos_programados',$param);
		$this->load->view('Correos/scripts/script_consulta_correos_programados',$param);


	}

	public function consulta_correos_log(){
		
		$title = $this->input->post('title');
		$id_perfil = $this->session->userdata('session_id_perfil');
		$param['id_perfil'] = $id_perfil;
		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();
		$param['title'] = $title;

		$this->load->view('Filtros/view_filtros',$param);
		$this->load->view('Correos/consulta_correos_log',$param);


	}

	function iniciar_status_correo(){

		$this->load->view('Correos/status_correo');
		$this->load->view('footeraut');
	
	}

	function validar_status_gen_archivo(){

		
		$rest = $this->Mod_correos->validar_status_gen_archivo();

		if(count($rest) > 0 ){

			$this->Mod_correos->update_status_proceso(1);

			echo json_encode($rest);
			
		}else{

			
		
		}

	}

	public function prueba_envio(){

		$rest = $this->Mod_correos->prueba_envio();

	}

	public function enviar_correo(){

		$parametros_correo = $this->input->post('parametros_correo');

		$destinatario = $parametros_correo['destinatario'];
		$copia = $parametros_correo['copia'];
		$asunto = $parametros_correo['asunto'];
		$mensaje = $parametros_correo['mensaje'];
		$id_correo_automatico = $parametros_correo['id_correo_automatico'];
		$reportes = $parametros_correo['reportes'];
		$id_intervalo = $parametros_correo['id_intervalo'];
		$fecha_ini_proceso = $parametros_correo['fecha_ini_proceso'];
		$tipo_msn = $parametros_correo['tipo_msn'];

		$destinatario = explode('/', $destinatario);

		$copia = explode('/', $copia);

		$mail = new PHPMailer(true);  

		try {
		//Server settings
	    //$mail->SMTPDebug = 2;
	    $mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);   
		                              // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'secure.emailsrvr.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'sistemas@villatours.com.mx';                 // SMTP username
	    $mail->Password = 'deptosys*2015';                           // SMTP password
	    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;   

			    //Recipients
	    $mail->setFrom('sistemas@villatours.com.mx');
	        // Add a recipient              // Name is optional
	    foreach ($destinatario as $clave => $valor) {

	              $mail->addAddress($valor); 
	            
	            }

	    $array_status = [];

	    $reportes=array_filter($reportes, "strlen");
	    $str_nombre_reportes_enviados = "";

	    foreach ($reportes as $clave => $valor) {

	       $dat = explode('**', $valor);

	       $rep =  $dat[0];
	       $tipo_archivo =  $dat[1];
	       $rango_fecha =  $dat[2];
	       $status =  $dat[3];  //0->sin consumos  1->con consumos

	       array_push($array_status, $status);

	       $rango_fecha = explode('_', $rango_fecha);

	       $fecha1 =$rango_fecha[0];

	       $fecha2 =$rango_fecha[1];

	       //*****************************************************************************************

	       $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

    	   $rango_fechas = explode("_", $rango_fechas);

    	   $fecha1 = $rango_fechas[0];
    	   
    	   $fecha2 = $rango_fechas[1];

	       //*****************************************************************************************

    	   $fecha1 = substr($fecha1, 0, 10);
       	   $fecha2 = substr($fecha2, 0, 10);

	       $str_fecha = $fecha1.'_A_'.$fecha2;
	       

	       if($tipo_archivo == '1' && $status == '1'){

	            if($rep == 3){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Gastos generales/';
	                $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GG_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');
	            
	            }else if($rep == 4){
	            	
	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'GVC/';
	                $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GVC_Reporteador_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx'); 

	            }else if($rep == 5){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Segmentos/';
	                $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Layout_Segmentado_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx'); 

	            }else if($rep == 6){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Ficosa/';
	                $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_ficosa_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx'); 

	            }else if($rep == 8){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Aereolineas graficos aereos/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Graficos_ae_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 12){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Pasajero grafico aereo/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Gastos_ae_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 13){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Rutas grafico/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Graficos_rut_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 14){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Detalle de consumos/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Detalle_consumo_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 15){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Aereolineas graficos aereos/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Graficos_ae_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 16){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Pasajero grafico aereo/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Gastos_ae_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 17){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Rutas grafico/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Graficos_rut_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 18){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Gastos generales/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GG_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 19){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Detalle pasajero/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_detalle_pax_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 22){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Detalle cc/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Detalle_cc_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 23){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Ahorro/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_ahorro_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 24){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Detalle de consumos precompra aerea/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Detalle_consumos_precompra_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 25){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Total precompra aerea/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_total_precompra_ae_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 26){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Total pasajero servicio/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Total_Pasajero_servicio_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 34){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'GVC/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Detalle_consumos_p_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 35){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Servicio 24 hrs/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Serv_24hrs_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 36){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Servicio 24 hrs boletos/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Serv_24hrs_boleto_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 37){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Servicio 24 hrs (bol,cc,rev)/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Serv_24hrs_bol_cc_rev_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }else if($rep == 38){

	            	$str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Servicio 24 hrs CS/';
					$mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_Serv_24hrs_cs_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');

	            }


	       }

	       if($tipo_archivo == 2 && $status == 1){

	           if($rep == 3){

	           	  $str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Grafica gastos generales/';
	           	  $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/graficas_export/Reporte_GG_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.pdf'); 
	           	  
	           }
	           if($rep == 18){

	           	  $str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Grafica gastos generales/';
	           	  $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/graficas_export/Reporte_GG_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.pdf'); 
	           	  
	           }
	       }
	       if($tipo_archivo == 3 && $status == 1){

	          if($rep == 3){

	          	 $str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Gastos generales/';
	             $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GG_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');
	             $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/graficas_export/Reporte_GG_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.pdf');

	             
	          }else if($rep == 18){

	          	 $str_nombre_reportes_enviados = $str_nombre_reportes_enviados . 'Gastos generales/';
	          	 $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/archivos/Reporte_GG_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.xlsx');
	             $mail->addAttachment($_SERVER['DOCUMENT_ROOT'].'/reportes_villatours/referencias/graficas_export/Reporte_GG_net_'.ltrim(rtrim($str_fecha)).'_'.$id_correo_automatico.'_'.$rep.'.pdf');


	          }

	       }
	            
	    }
	    
	    $total_status = array_sum($array_status);

	    //Content
	    $mail->isHTML(true);                                // Set email format to HTML
	    $mail->Subject = $asunto;

	    if($total_status > 0){

	      if($tipo_msn == 1){

	      	$mail->Body  = $mensaje;

	      }else{

	      	$arr_nombre_reportes_enviados = explode("/", $str_nombre_reportes_enviados);
	      	$arr_nombre_reportes_enviados=array_filter($arr_nombre_reportes_enviados, "strlen");

	      	$new_str_nombre_reportes_enviados = "<br><br>";
	      	foreach ($arr_nombre_reportes_enviados as $clave => $valor) {

	      		$new_str_nombre_reportes_enviados = $new_str_nombre_reportes_enviados.'-'.$valor.'<br>';
	            
	        }

	      	$mail->Body  = "<div style='font-family: Calibri; font-size: 13px;'>Buen día<br><br>Envío reporte ".$new_str_nombre_reportes_enviados."<br>Correspondiente al periodo <br><br> ".$fecha1." a ".$fecha2."<br><br>Para cualquier duda o aclaración favor de comunicarse con su ejecutivo de cuenta<br><br>Saludos
	      	<br><br>
	      	<img src='http://villatours.com.mx/web/wp-content/uploads/2017/12/logo-vt-alta.png' height='95' width='384'></div>
	      	";

	      }

	    }else{

	      $mail->Body = "<div style='font-family: Calibri; font-size: 13px;'>Buenos días, le informamos que no se tuvieron consumos en el periodo <br><br>".$fecha1." a ".$fecha2."<br><br>Para cualquier duda o aclaración favor de comunicarse con su ejecutivo de cuenta<br><br>Saludos
	      <br><br>
	      <img src='http://villatours.com.mx/web/wp-content/uploads/2017/12/logo-vt-alta.png' height='95' width='384'></div>
	      ";

	    }
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	    $mail->CharSet = 'UTF-8';  
	   

	    $mail->send();

	   
	    echo json_encode(1);

		  
	  } catch (phpmailerException $e) {

	  	echo json_encode($e->errorMessage());
	    //echo $e->errorMessage(); //Pretty error messages from PHPMailer
	  
	  } catch (Exception $e) {

		echo json_encode($mail->ErrorInfo);
	  	
	  }

	}

	public function update_status_proceso(){

		$status = $this->input->post('status');
		
		$this->Mod_correos->update_status_proceso($status);

	}

	public function guardar_log_envio(){

		$id_reporte = $this->input->post('id_reporte');
		$detalle = $this->input->post('detalle');
		$status = $this->input->post('status');
		$id_correo_automatico = $this->input->post('id_correo_automatico');

		$this->Mod_correos->guardar_log_envio($id_reporte,$detalle,$status,$id_correo_automatico);


	}

	public function get_correos_enviados(){

		if ($this->session->userdata('session_status') != null)
		{

			$rest = $this->Mod_correos->get_correos_enviados();

			echo json_encode($rest);
		}
		else{
			
			echo json_encode('sess_out');

		}
	

	}
	
	public function get_correos_programados(){

		$sucursal = $this->input->get('sucursal');
		$asunto = $this->input->get('asunto');
		$destinatario = $this->input->get('destinatario');
		$fecha1 = $this->input->get('fecha1');
		$fecha2 = $this->input->get('fecha2');
		$status = $this->input->get('status');
		$id_us = $this->session->userdata('session_id');

		$rest = $this->Mod_correos->get_correos_programados($sucursal,$asunto,$destinatario,$status,$id_us,$fecha1,$fecha2);
	
		echo json_encode($rest);

	}  

	


	public function get_correos_log(){
		
		$sucursal = $this->input->get('sucursal');
		$asunto = $this->input->get('asunto');
		$destinatario = $this->input->get('destinatario');
		$fecha1 = $this->input->get('fecha1');
		$fecha2 = $this->input->get('fecha2');
		$status = $this->input->get('status');
		$id_us = $this->session->userdata('session_id');
		
		$rest = $this->Mod_correos->get_correos_log($sucursal,$asunto,$destinatario,$fecha1,$fecha2,$status,$id_us);

		echo json_encode($rest);

	} 

	
	public function Reenviar_correo(){

		$id_c_a = $this->input->post('id_c_a');
		
		$rest = $this->Mod_correos->Reenviar_correo($id_c_a);

		echo json_encode($rest);

	}

	public function guardar_config_envio_de_correos(){

		$sucursal = $this->session->userdata('session_id_sucursal');
		$destinatarios = $this->input->post('destinatarios');
		$concopia = $this->input->post('concopia');
		$asunto = $this->input->post('asunto');
		$reporte = $this->input->post('reporte');
		$intervalo = $this->input->post('intervalo');
		$fecha = $this->input->post('fecha');
		$hora = $this->input->post('hora');
		$mensaje = $this->input->post('mensaje');
		$tipo_msn = $this->input->post('tipo_msn');
		$dias = $this->input->post('dias');
		$dia_mes = $this->input->post('dia_mes');
		$filtro = $this->input->post('filtro');
		$id_usuario = $this->session->userdata('session_id');
		
		$rest = $this->Mod_correos->guardar_config_envio_de_correos($sucursal,$destinatarios,$concopia,$asunto,$reporte,$intervalo,$fecha,$hora,$mensaje,$tipo_msn,$dias,$dia_mes,$filtro,$id_usuario);

		echo json_encode($rest);
		
	}

	public function guardar_edicion_correos_programados(){

		$sucursal = $this->session->userdata('session_id_sucursal');
		$destinatarios = $this->input->post('destinatarios');
		$concopia = $this->input->post('concopia');
		$asunto = $this->input->post('asunto');
		$reporte = $this->input->post('reporte');
		$intervalo = $this->input->post('intervalo');
		$fecha = $this->input->post('fecha');
		$hora = $this->input->post('hora');
		$mensaje = $this->input->post('mensaje');
		$id_correo_aut = $this->input->post('id_correo_aut');
		$filtro = $this->input->post('filtro');


		$rest = $this->Mod_correos->guardar_edicion_correos_programados($sucursal,$destinatarios,$concopia,$asunto,$reporte,$intervalo,$fecha,$hora,$mensaje,$id_correo_aut,$filtro);
		
		echo json_encode($rest);

	}

	public function eliminar_correos_programados(){
		
		$id_correo_aut = $this->input->post('id_correo_aut');
		$id_intervalo = $this->input->post('id_intervalo');

		$rest = $this->Mod_correos->eliminar_correos_programados($id_correo_aut,$id_intervalo);
		
		echo json_encode($rest);

	}

	public function get_html_actualizar_correo(){
	
		$param["id_perfil"] = $this->session->userdata('session_id_perfil');
		$param["id_correo_aut"] = $this->input->post('id_correo_aut');
		$param['sucursales'] = $this->Mod_usuario->get_catalogo_sucursales();

		$this->load->view('Correos/editar_correo',$param);
		
	}

	public function get_reportes_seleccionados(){

		
		$id_correo_aut = $this->input->post('id_correo_aut');
		$rest = $this->Mod_correos->get_reportes_seleccionados($id_correo_aut);

		echo json_encode($rest);

	}

	public function get_reportes_not_in(){

		$id_perfil = $this->input->post('id_perfil');
		$str_reportes_selec = $this->input->post('str_reportes_selec');

		$rest = $this->Mod_correos->get_reportes_not_in($id_perfil,$str_reportes_selec);

		echo json_encode($rest);

	}

	public function delete_fil(){

		$id_correo_aut = $this->input->post('id_correo_aut');
		$id_rep = $this->input->post('id_rep');

		$rest = $this->Mod_correos->delete_fil($id_correo_aut,$id_rep);

		echo json_encode($rest);

	}
    	

	
}
