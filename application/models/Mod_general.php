<?php
class Mod_general extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   
   public function obtener_todos(){
      $query = $this->db->query('select top 50 * from Martha_GVC_Reporteador_BOL');
      return $query->result();
   }

   public function validar_usuario($usuario,$password){
   	 
   	 $db_prueba = $this->load->database('conmysql', TRUE);

   	 $res = $db_prueba->query("SELECT us.id, us.nombre, us.id_sucursal, us.usuario, us.password, us.id_perfil, us.fecha_alta, us.status, dep.nombre as nom_perfil FROM reportes_villa_tours.rpv_usuarios us
        inner join rpv_perfiles perf on perf.id = us.id_perfil
        inner join rpv_departamentos dep on dep.id = perf.id_departamento where us.usuario ='".$usuario."' and us.password='".$password."' ");
       //print_r("select * from rpv_usuarios where usuario ='".$usuario."' and password='".$password."' ");
       return $res->result();

   }

   public function nuevo_acceso($id_usuario,$id_sucursal,$ipvisitante,$usuario,$status){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->query("INSERT INTO rpv_accesos(id_sucursal, id_usuario, usuario_ingresado, ip_acceso, fecha_alta, status)VALUES($id_sucursal, $id_usuario,'$usuario','$ipvisitante',now(),$status)");
      
   }

}