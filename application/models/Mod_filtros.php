<?php
class Mod_filtros extends CI_Model { 

   public function __construct() {
      parent::__construct();
      $this->load->database('default');

   }
   
   public function obtener_filtros($id_reporte){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $res = $db_prueba->query("SELECT fil.id_div,rar.tipo_archivo,fil.id_input FROM rpv_reporte_filtro refi
                              inner join rpv_filtros fil on fil.id = refi.id_filtro
                              inner join rpv_reporte_archivo rar on rar.id_rep = refi.id_reporte
                              where refi.id_reporte = $id_reporte");
    
    return $res->result_array();

   }

   public function obtener_filtros_correos_aut($id_correo_automatico){

     $db_prueba = $this->load->database('conmysql', TRUE);
     
     $res = $db_prueba->query("SELECT * FROM rpv_correo_rep_fil where id_correo_aut=$id_correo_automatico and status = 1");
    
     return $res->result_array();


   }

   public function guardar_filtro_temp($array_filtro,$id_reporte,$id_usuario){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $filtro_rep = $array_filtro['rep_'.$id_reporte];


      $fil_mult_id_suc = $filtro_rep['fil_mult_id_suc'];
      $fil_mult_id_serie = $filtro_rep['fil_mult_id_serie'];
      $fil_mult_id_cliente = $filtro_rep['fil_mult_id_cliente'];
      $fil_tipo_archivo = $filtro_rep['fil_tipo_archivo'];
      $fil_unic_id_servicio = $filtro_rep['fil_unic_id_servicio'];
      $fil_mult_id_servicio = $filtro_rep['fil_mult_id_servicio'];
      $fil_mult_id_servicio_ae = $filtro_rep['fil_mult_id_servicio_ae'];
      $fil_mult_id_provedor = $filtro_rep['fil_mult_id_provedor'];
      $fil_mult_id_corporativo = $filtro_rep['fil_mult_id_corporativo'];
      $fil_id_plantilla = $filtro_rep['fil_id_plantilla'];
      $fil_fecha1 = $filtro_rep['fil_fecha1'];
      $fil_fecha2 = $filtro_rep['fil_fecha2'];

      $db_prueba->query("DELETE FROM rpv_filtro_temp WHERE id_us = '$id_usuario' and  id_rep = ".$id_reporte);

      $db_prueba->query("INSERT INTO rpv_filtro_temp(fil_mult_id_suc,fil_mult_id_serie, fil_mult_id_cliente, fil_tipo_archivo, fil_unic_id_servicio, fil_mult_id_servicio, fil_mult_id_servicio_ae, fil_mult_id_provedor, fil_mult_id_corporativo, fil_id_plantilla, fil_fecha1, fil_fecha2, id_us, id_rep)
                  VALUES('$fil_mult_id_suc','$fil_mult_id_serie','$fil_mult_id_cliente','$fil_tipo_archivo','$fil_unic_id_servicio','$fil_mult_id_servicio','$fil_mult_id_servicio_ae','$fil_mult_id_provedor','$fil_mult_id_corporativo','$fil_id_plantilla','$fil_fecha1','$fil_fecha2','$id_usuario','$id_reporte')");


   }

   public function get_filtros_temp($id_usuario,$id_reporte){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM rpv_filtro_temp where id_rep = '$id_reporte' and id_us =".$id_usuario);

    
     return $res->result_array();



   }

   public function get_filtros_temp_edicion($id_correo_aut,$id_reporte){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM rpv_correo_rep_fil where id_rep = '$id_reporte' and id_correo_aut =".$id_correo_aut." and status= 1");

    
     return $res->result_array();



   }


}