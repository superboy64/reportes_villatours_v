<?php
class Mod_correos extends CI_Model { 

   public function __construct() {
      parent::__construct();
      $this->load->database('default');

   }
   
   public function prueba_envio(){

    $db_prueba = $this->load->database('conmysql', TRUE);
    
    $db_prueba->query("DROP EVENT IF EXISTS run_event;");
    
    $db_prueba->query("
    CREATE 
    EVENT `run_event` 
    ON SCHEDULE EVERY 1 MINUTE STARTS '2018-08-14 13:07:00' 
    DO 
    BEGIN
    SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event started';
    insert into rpv_prueba_evento(status)VALUES(1);
    SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event finished';
    END;");

   }

   public function guardar_config_envio_de_correos($sucursal,$destinatarios,$concopia,$asunto,$reporte,$intervalo,$fecha,$hora,$mensaje,$tipo_msn,$dias,$dia_mes,$filtro,$id_usuario){
    
    $array_fecha = explode('/', $fecha);
          
    $fecha = $array_fecha[2].'-'.$array_fecha[1].'-'.$array_fecha[0];

    $array_dia_mes = explode('/', $dia_mes);
    $dia_mes = $array_fecha[0];
  
    $db_prueba = $this->load->database('conmysql', TRUE);
    
    if($dias != ""){

      $array_dias = explode('/', $dias);
      $array_dias=array_filter($array_dias, "strlen");
      
      $sql_dias="";

      $count_total = count($array_dias);

      $cont = 0;

      foreach ($array_dias as $clave => $valor) {
        $cont++;  
        

        if($cont != $count_total){

          $sql_dias = $sql_dias . "DAYOFWEEK(NOW()) = $valor OR ";

        }else{
          $sql_dias = $sql_dias . "DAYOFWEEK(NOW()) = $valor";
        }
            
     
      }
     
    }

    $db_prueba->trans_start();
 
    $db_prueba->query("INSERT INTO rpv_correo_automatico(id_sucursal, id_usuario, destinatario, copia, asunto, id_intervalo, fecha_ini_proceso, hora_ini_proceso, fecha_alta, status, status_envio, mensaje, fecha_ultimo_envio, dia, dia_mes, tipo_msn)
                  VALUES($sucursal,$id_usuario,'".$destinatarios."','".$concopia."','".$asunto."',$intervalo,'".$fecha."','".$hora."',now(),1,0,'".$mensaje."',null,'".$dias."','".$dia_mes."',$tipo_msn)");

    $id_correo_automatico = $db_prueba->insert_id();

    $array_rep = array();

    foreach ($reporte as $clave => $valor) {

                array_push($array_rep, $valor['id']);

          }

        $array1 = array();
        
        foreach ($array_rep as $clave => $valor) {
          $str_filtros = ""; 
             foreach ($filtro['rep_'.$valor] as $clave2 => $valor2) {

                $str_filtros =  $str_filtros.$clave2.'___'.$valor2.'/XX';

             }
             
             $db_prueba->query("INSERT INTO rpv_correo_rep_fil(id_correo_aut, id_rep, filtro_rep, status, fecha_alta)
                  VALUES($id_correo_automatico,$valor,'".$str_filtros."',1,now())");
             

          }


    if($intervalo == 1){
      //DIARIO
       $db_prueba->query("DROP EVENT IF EXISTS run_event_diario_".$id_correo_automatico.";");

       $db_prueba->query("
        CREATE 
        EVENT `run_event_diario_".$id_correo_automatico."` 
        ON SCHEDULE EVERY 1 DAY
        STARTS '".$fecha." ".$hora."'
        DO 
          BEGIN
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_diario started';
              UPDATE rpv_correo_automatico
              SET status_envio = 1
              where id = $id_correo_automatico;
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_diario finished';
          END;");

    }else if($intervalo == 2){
      $db_prueba->query("DROP EVENT IF EXISTS run_event_semanal_".$id_correo_automatico.";");
      //SEMANAL
      $db_prueba->query("
       CREATE EVENT IF NOT EXISTS `run_event_semanal_".$id_correo_automatico."`
       ON SCHEDULE
       EVERY 1 WEEK
       STARTS '".$fecha." ".$hora."'
       DO
          BEGIN
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_semanal started';
              UPDATE rpv_correo_automatico
              SET status_envio = 1
              where id = $id_correo_automatico;
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_semanal finished';
          END;");

    }else if($intervalo == 3){
      $db_prueba->query("DROP EVENT IF EXISTS run_event_mensual_".$id_correo_automatico.";");
      //Mensual
      $db_prueba->query("
       CREATE EVENT IF NOT EXISTS `run_event_mensual_".$id_correo_automatico."`
       ON SCHEDULE
       EVERY 1 MONTH
       STARTS '".$fecha." ".$hora."'
       DO
          BEGIN
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_mensual started';
              UPDATE rpv_correo_automatico
              SET status_envio = 1
              where id = $id_correo_automatico;
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_mensual finished';
          END;");

    }else if($intervalo == 4){
      $db_prueba->query("DROP EVENT IF EXISTS run_event_quincenal_".$id_correo_automatico.";");
      //Mensual
      $db_prueba->query("
        CREATE 
        EVENT `run_event_diario_".$id_correo_automatico."` 
        ON SCHEDULE EVERY 15 DAY
        STARTS '".$fecha." ".$hora."'
        DO 
          BEGIN
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_quincenal started';
              UPDATE rpv_correo_automatico
              SET status_envio = 1
              where id = $id_correo_automatico;
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_quincenal finished';
          END;");

    }else if($intervalo == 5){  //nuevo
      $db_prueba->query("DROP EVENT IF EXISTS run_event_diario_dia_actual".$id_correo_automatico.";");
      //Mensual
      $db_prueba->query("
        CREATE 
        EVENT `run_event_diario_".$id_correo_automatico."` 
        ON SCHEDULE EVERY 1 DAY
        STARTS '".$fecha." ".$hora."'
        DO 
          BEGIN
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_quincenal started';
              UPDATE rpv_correo_automatico
              SET status_envio = 1
              where id = $id_correo_automatico;
            SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_quincenal finished';
          END;");

    }

    $db_prueba->trans_complete();

    if($db_prueba->trans_status() === FALSE)
    {
      $db_prueba->trans_rollback();
      return 0;

    }else{
      
      return 1;

    }
    

   }

   function guardar_edicion_correos_programados($sucursal,$destinatarios,$concopia,$asunto,$reporte,$intervalo,$fecha,$hora,$mensaje,$id_correo_aut,$filtro){

    $array_fecha = explode('/', $fecha);
          
    $fecha = $array_fecha[2].'-'.$array_fecha[1].'-'.$array_fecha[0];
    
    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();

    $db_prueba->query("update 
                      rpv_correo_automatico
                      set 
                      id_sucursal = '$sucursal',
                      destinatario = '$destinatarios',
                      copia = '$concopia',
                      asunto = '$asunto',
                      id_intervalo = '$intervalo',
                      fecha_ini_proceso = '$fecha',
                      hora_ini_proceso = '$hora',
                      mensaje = '$mensaje'

                      where id = $id_correo_aut
                      ");


//**********************************    aqui me quede
$array_rep = array();
foreach ($reporte as $clave => $valor) {

  if(isset($valor['id_rep']) ){

    array_push($array_rep, $valor['id_rep']);

  }

}

$str_rep = implode(",", $array_rep);

if($str_rep == ""){

  $str_rep ="''";

}

$res_rep = $db_prueba->query("SELECT id_rep FROM rpv_correo_rep_fil where id_correo_aut = $id_correo_aut and id_rep not in(".$str_rep.")");

$res_rep = $res_rep->result_array();



if(count($res_rep) > 0){

  $array_rep_del = array();
  foreach ($res_rep as $clave => $valor) {

    array_push($array_rep_del, $valor['id_rep']);


  }

  $array_rep_del = implode(",", $array_rep_del);

  $db_prueba->query("UPDATE rpv_correo_rep_fil   
                                            SET 
                                                status = 0
                                                WHERE id_correo_aut = $id_correo_aut and id_rep in (".$array_rep_del.") and status = 1

                                            ");

}




          foreach ($reporte as $clave => $valor) {

                      $valor1 = $valor['id'];

                      $str_filtros = ""; 
                    
                      if(isset($filtro['rep_'.$valor1]) ){


                        foreach ($filtro['rep_'.$valor1] as $clave2 => $valor2) {

                            $str_filtros =  $str_filtros.$clave2.'___'.$valor2.'/XX';

                         }
                         
                         if($valor['status'] == 'A'){

                            
                            $db_prueba->query("INSERT INTO rpv_correo_rep_fil(id_correo_aut, id_rep, filtro_rep, status, fecha_alta)
                                  VALUES($id_correo_aut,$valor1,'".$str_filtros."',1,now())");



                         }else{

                            
                            $db_prueba->query("UPDATE rpv_correo_rep_fil   
                                            SET 
                                                filtro_rep = '".$str_filtros."',
                                                fecha_alta = now()
                                                WHERE id_correo_aut = $id_correo_aut and id_rep = $valor1 and status = 1

                                            ");


                         }
                         

                      }


                }

              $array1 = array();
              
             

//**********************************
          
          if($intervalo == 1){
        
            //DIARIO
          $db_prueba->query("DROP EVENT IF EXISTS run_event_diario_".$id_correo_aut.";");

             $db_prueba->query("
              CREATE 
              EVENT `run_event_diario_".$id_correo_aut."` 
              ON SCHEDULE EVERY 1 DAY
              STARTS '".$fecha." ".$hora."'
              DO 
                BEGIN
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_diario started';
                    UPDATE rpv_correo_automatico
                    SET status_envio = 1
                    where id = $id_correo_aut;
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_diario finished';
                END;");

          }else if($intervalo == 2){
            $db_prueba->query("DROP EVENT IF EXISTS run_event_semanal_".$id_correo_aut.";");
            //SEMANAL
            $db_prueba->query("
             CREATE EVENT IF NOT EXISTS `run_event_semanal_".$id_correo_aut."`
             ON SCHEDULE
             EVERY 1 WEEK
             STARTS '".$fecha." ".$hora."'
             DO
                BEGIN
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_semanal started';
                    UPDATE rpv_correo_automatico
                    SET status_envio = 1
                    where id = $id_correo_aut;
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_semanal finished';
                END;");

          }else if($intervalo == 3){
            $db_prueba->query("DROP EVENT IF EXISTS run_event_mensual_".$id_correo_aut.";");
            //Mensual
            $db_prueba->query("
             CREATE EVENT IF NOT EXISTS `run_event_mensual_".$id_correo_aut."`
             ON SCHEDULE
             EVERY 1 MONTH
             STARTS '".$fecha." ".$hora."'
             DO
                BEGIN
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_mensual started';
                    UPDATE rpv_correo_automatico
                    SET status_envio = 1
                    where id = $id_correo_aut;
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_mensual finished';
                END;");

          }else if($intervalo == 4){
            $db_prueba->query("DROP EVENT IF EXISTS run_event_quincenal_".$id_correo_aut.";");
            //Mensual
            $db_prueba->query("
              CREATE 
              EVENT `run_event_quincenal_".$id_correo_aut."` 
              ON SCHEDULE EVERY 15 DAY
              STARTS '".$fecha." ".$hora."'
              DO 
                BEGIN
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_quincenal started';
                    UPDATE rpv_correo_automatico
                    SET status_envio = 1
                    where id = $id_correo_aut;
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_quincenal finished';
                END;");

          }else if($intervalo == 5){  //nuevo
            $db_prueba->query("DROP EVENT IF EXISTS run_event_diario_dia_actual_".$id_correo_aut.";");
            //Mensual
            $db_prueba->query("
              CREATE 
              EVENT `run_event_diario_dia_actual_".$id_correo_aut."` 
              ON SCHEDULE EVERY 1 DAY
              STARTS '".$fecha." ".$hora."'
              DO 
                BEGIN
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_diario_dia_actual_ started';
                    UPDATE rpv_correo_automatico
                    SET status_envio = 1
                    where id = $id_correo_aut;
                  SIGNAL SQLSTATE '01000' SET MESSAGE_TEXT = 'run_event_diario_dia_actual_ finished';
                END;");

          }
   
    $db_prueba->trans_complete();

    if ($db_prueba->trans_status() === FALSE)
    {  
      return 0;

    }else{

      return 1;
    }


   }

   
   function validar_status_gen_archivo(){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $proceso = $db_prueba->query("SELECT * FROM rpv_correo_status_proceso where status_proceso = 1 and id = 1");
    $proceso = $proceso->result_array();
    $proceso = count($proceso);

    if($proceso > 0){
     
      return $res = [];
    
    }else{

      $res = $db_prueba->query("SELECT * FROM rpv_correo_automatico where status_envio = 1 and status = 1 limit 1"); //puede obtener varios rows

      return $res->result_array();
  
    }

   }

   function cambiar_status_correo($id_correo_automatico){

     $db_prueba = $this->load->database('conmysql', TRUE);
     
      $res = $db_prueba->query("UPDATE rpv_correo_automatico
                                SET status_envio = 0
                                where id = $id_correo_automatico;"); //puede obtener varios rows


   }

   function update_status_proceso($status){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $db_prueba->query("UPDATE rpv_correo_status_proceso
                                SET status_proceso = $status
                                where id = 1"); //puede obtener varios rows

   }

   function delete_fil($id_correo_aut,$id_rep){

    $db_prueba = $this->load->database('conmysql', TRUE);

     $db_prueba->query("UPDATE rpv_correo_rep_fil
                                SET status = 0
                                where id_correo_aut = ".$id_correo_aut." and id_rep = ".$id_rep." "); //puede obtener varios rows


   }

   function guardar_log_envio($id_reporte,$detalle,$status,$id_correo_automatico){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $res = $db_prueba->query("SELECT * FROM rpv_correo_automatico
       where id= ".$id_correo_automatico);
   
       $res = $res->result_array();

       $destinatario = "";
       $id_intervalo = 0;

       if(count($res) > 0){

        $destinatario = $res[0]['destinatario'];
        $id_intervalo = $res[0]['id_intervalo'];
        $asunto = $res[0]['asunto'];

       }
       
       $db_prueba->query("INSERT INTO rpv_log_envio_correo(id_reporte, detalle_envio, destinatario, intervalo, asunto, fecha_envio, status, id_correo_automatico)
                  VALUES($id_reporte,'$detalle','$destinatario',$id_intervalo,'$asunto',now(),$status,$id_correo_automatico)"); 
       
      
   }

   
   function get_correos_enviados(){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $res = $db_prueba->query("SELECT 

        (select case when (cast(status_proceso as SIGNED INTEGER) > 0) then 1 else 0 end from rpv_correo_status_proceso) as status_script, 

        rpv_log_envio_correo.*,
        rpv_submodulos.nombre,
        rpv_correo_automatico.destinatario 
        FROM reportes_villa_tours.rpv_log_envio_correo

      inner join rpv_submodulos on rpv_submodulos.id = rpv_log_envio_correo.id_reporte
      inner join rpv_correo_automatico on rpv_correo_automatico.id = rpv_log_envio_correo.id_correo_automatico order by id desc
      ");

     
      return $res->result_array();

   }

   function get_reportes_seleccionados($id_correo_aut){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $res = $db_prueba->query("SELECT * FROM rpv_correo_rep_fil
      inner join rpv_submodulos on rpv_submodulos.id = rpv_correo_rep_fil.id_rep where rpv_correo_rep_fil.status = 1 and id_correo_aut= ".$id_correo_aut);
   

      return $res->result_array();


   }

   function get_reportes_not_in($id_perfil,$str_reportes_selec){

      $arr_rep = [];
      
      $str_reportes_selec = explode('_', $str_reportes_selec);
      $str_reportes_selec = array_filter($str_reportes_selec, "strlen");
      $arr_rep = implode(",", $str_reportes_selec);

      
      $db_prueba = $this->load->database('conmysql', TRUE);

      $res = $db_prueba->query("SELECT sub.id,sub.nombre from rpv_perfil_modulo_submodulo pms 
                                  INNER JOIN rpv_submodulos sub on sub.id =  pms.id_submodulo
                                  WHERE pms.id_perfil = '$id_perfil' and pms.id_modulo = 3 and pms.status_submodulo = 1 and pms.status = 1 and sub.id not in($arr_rep) ");

      return $res->result_array();


  }

  function get_correos_programados($sucursal,$asunto,$destinatario,$status,$id_us,$fecha1,$fecha2){

      $db_prueba = $this->load->database('conmysql', TRUE);

      if($status == 1){

        if($sucursal != 0){

          $sucursal = " and id_sucursal = $sucursal"; 

        }else{

          $sucursal="";

        }
        if($asunto != ''){

          $asunto = " and asunto like '%".$asunto."%' "; 

        }else{

          $asunto="";

        }

        if($destinatario != ''){

          $destinatario = " and destinatario like '%".$destinatario."%' "; 

        }else{

          $destinatario="";

        }

        $fecha1 = explode('/', $fecha1);
        $dia1 = $fecha1[0];
        $mes1 = $fecha1[1];
        $ano1 = $fecha1[2];
        $fecha1 = $ano1.'-'.$mes1.'-'.$dia1;

        $fecha2 = explode('/', $fecha2);
        $dia2 = $fecha2[0];
        $mes2 = $fecha2[1];
        $ano2 = $fecha2[2];
        $fecha2 = $ano2.'-'.$mes2.'-'.$dia2;

        $res = $db_prueba->query("SELECT id, id_sucursal, id_usuario, destinatario, copia, asunto, id_intervalo, fecha_ini_proceso, hora_ini_proceso, fecha_alta, status, status_envio, mensaje, 
        (select fecha_envio from rpv_log_envio_correo where rpv_correo_automatico.id = rpv_log_envio_correo.id_correo_automatico order by fecha_envio desc limit 1) as fecha_ultimo_envio, 
        dia, dia_mes, tipo_msn,

        case 

        /*---------------------- POR DIA ---------------------------*/

        when (id_intervalo = 1) 
        then 
        cast(DATE_ADD(now(), INTERVAL 1 DAY) as date) 

        /*-------------------- POR SEMANA -----------------------------*/

        when (timestampdiff(WEEK,fecha_ini_proceso,now()) > 0 and id_intervalo = 2) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL (timestampdiff(WEEK,fecha_ini_proceso,now()) + 1) WEEK)

        when (timestampdiff(WEEK,fecha_ini_proceso,now()) = 0 and id_intervalo = 2) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 1 WEEK)

        /*-------------------- POR MES ---------------------------------------*/

        when (timestampdiff(MONTH,fecha_ini_proceso,now()) > 0 and id_intervalo = 3) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL (timestampdiff(MONTH,fecha_ini_proceso,now()) + 1) MONTH) 

        when (timestampdiff(MONTH,fecha_ini_proceso,now()) = 0 and id_intervalo = 3) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 1 MONTH) 

        /*--------------------- POR QUINCENA --------------------------------------*/

        when (timestampdiff(DAY,fecha_ini_proceso,now()) >= 15 and id_intervalo = 4) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 15 DAY) 

        when (timestampdiff(DAY,fecha_ini_proceso,now()) = 0 and id_intervalo = 4) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 15 DAY)

        /*--------------------- POR 24 HRS --------------------------------------*/

        when (id_intervalo = 5) 
        then 
        DATE_ADD(now(), INTERVAL 1 DAY)


        END
        as proximo_envio 

        FROM reportes_villa_tours.rpv_correo_automatico where status = 1 and
        cast((select fecha_envio from rpv_log_envio_correo where rpv_correo_automatico.id = rpv_log_envio_correo.id_correo_automatico order by fecha_envio desc limit 1) as date)
        between '$fecha1' and '$fecha2' and id_usuario =".$id_us.$sucursal.$asunto.$destinatario);
      }else{

        $res = $db_prueba->query("SELECT id, id_sucursal, id_usuario, destinatario, copia, asunto, id_intervalo, fecha_ini_proceso, hora_ini_proceso, fecha_alta, status, status_envio, mensaje, 
        (select fecha_envio from rpv_log_envio_correo where rpv_correo_automatico.id = rpv_log_envio_correo.id_correo_automatico order by fecha_envio desc limit 1) as fecha_ultimo_envio, 
        dia, dia_mes, tipo_msn, 

        case 

        /*---------------------- POR DIA ---------------------------*/

        when (id_intervalo = 1) 
        then 
        cast(DATE_ADD(now(), INTERVAL 1 DAY) as date) 

        /*-------------------- POR SEMANA -----------------------------*/

        when (timestampdiff(WEEK,fecha_ini_proceso,now()) > 0 and id_intervalo = 2) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL (timestampdiff(WEEK,fecha_ini_proceso,now()) + 1) WEEK)

        when (timestampdiff(WEEK,fecha_ini_proceso,now()) = 0 and id_intervalo = 2) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 1 WEEK)

        /*-------------------- POR MES ---------------------------------------*/

        when (timestampdiff(MONTH,fecha_ini_proceso,now()) > 0 and id_intervalo = 3) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL (timestampdiff(MONTH,fecha_ini_proceso,now()) + 1) MONTH) 

        when (timestampdiff(MONTH,fecha_ini_proceso,now()) = 0 and id_intervalo = 3) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 1 MONTH) 

        /*--------------------- POR QUINCENA --------------------------------------*/

        when (timestampdiff(DAY,fecha_ini_proceso,now()) >= 15 and id_intervalo = 4) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 15 DAY) 

        when (timestampdiff(DAY,fecha_ini_proceso,now()) = 0 and id_intervalo = 4) 
        then 
        DATE_ADD(fecha_ini_proceso, INTERVAL 15 DAY)

        /*--------------------- POR 24 HRS --------------------------------------*/

        when (id_intervalo = 5) 
        then 
        DATE_ADD(now(), INTERVAL 1 DAY)


        END
        as proximo_envio 

        FROM reportes_villa_tours.rpv_correo_automatico where status = 1 and id_usuario =".$id_us);

      }
      
      
      return $res->result_array();

   }

   function get_correos_log($sucursal,$asunto,$destinatario,$fecha1,$fecha2,$status,$id_us){

      $db_prueba = $this->load->database('conmysql', TRUE);

      if($status == 1){

        if($sucursal != ''){

          $sucursal = " and sucursal = $sucursal "; 

        }else{

          $sucursal="";

        }

        if($asunto != ''){

          $asunto = " and asunto like '%".$asunto."%' "; 

        }else{

          $asunto="";

        }

        if($destinatario != ''){

          $destinatario = " and destinatario like '%".$destinatario."%' "; 

        }else{

          $destinatario="";

        }

        $fecha1 = explode('/', $fecha1);
        $dia1 = $fecha1[0];
        $mes1 = $fecha1[1];
        $ano1 = $fecha1[2];
        $fecha1 = $ano1.'-'.$mes1.'-'.$dia1;

        $fecha2 = explode('/', $fecha2);
        $dia2 = $fecha2[0];
        $mes2 = $fecha2[1];
        $ano2 = $fecha2[2];
        $fecha2 = $ano2.'-'.$mes2.'-'.$dia2;

        $res = $db_prueba->query("SELECT rpv_log_envio_correo.* FROM reportes_villa_tours.rpv_log_envio_correo inner join rpv_correo_automatico on rpv_correo_automatico.id = rpv_log_envio_correo.id_correo_automatico where fecha_envio between '$fecha1' and '$fecha2' and rpv_correo_automatico.id_usuario=".$id_us.$sucursal.$asunto.$destinatario." order by id desc");

      }
      else{

        $res = $db_prueba->query("SELECT rpv_log_envio_correo.* FROM reportes_villa_tours.rpv_log_envio_correo inner join rpv_correo_automatico on rpv_correo_automatico.id = rpv_log_envio_correo.id_correo_automatico where rpv_correo_automatico.id_usuario=".$id_us." order by id desc");


      }
      

        return $res->result_array();

   }

   function Reenviar_correo($id_c_a){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();

    $db_prueba->query("update rpv_correo_automatico
                       set status_envio = 1
                       where id =  $id_c_a ");

   
    $db_prueba->trans_complete();

    if ($db_prueba->trans_status() === FALSE)
    {  
      return 0;

    }else{

      return 1;
    }


   }

   function eliminar_correos_programados($id_correo_aut,$id_intervalo){

          $db_prueba = $this->load->database('conmysql', TRUE);
          
          $db_prueba->trans_start();

          if($id_intervalo == 1){
        
            $db_prueba->query("DROP EVENT IF EXISTS run_event_diario_".$id_correo_aut.";");
  
          }else if($id_intervalo == 2){
            
            $db_prueba->query("DROP EVENT IF EXISTS run_event_semanal_".$id_correo_aut.";");
        
          }else if($id_intervalo == 3){
            
            $db_prueba->query("DROP EVENT IF EXISTS run_event_mensual_".$id_correo_aut.";");
           
          }else if($id_intervalo == 4){
            
            $db_prueba->query("DROP EVENT IF EXISTS run_event_quincenal_".$id_correo_aut.";");
          

          }else if($id_intervalo == 5){  //nuevo
            
            $db_prueba->query("DROP EVENT IF EXISTS run_event_diario_dia_actual".$id_correo_aut.";");
           
          }

            $db_prueba->query("update rpv_correo_automatico  
                              set status = 0
                              where id = ".$id_correo_aut);

            $db_prueba->trans_complete();

            if ($db_prueba->trans_status() === FALSE)
            {  
              return 0;

            }else{

              return 1;
            }

   }



}