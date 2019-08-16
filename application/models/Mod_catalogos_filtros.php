<?php
class Mod_catalogos_filtros extends CI_Model { 

   public function __construct() {
      parent::__construct();
      //$this->load->database('default'); por problemas de actualizacion en codeigniter odbc no tiene compatibilidad con builder
      //la conexion se remplazo creando una libreria nueva para ejecutar setencias puras a la base de datos sybase
      $this->load->database('default');

      //$this->load->library('consybase');

   }
   
   public function get_catalogo_series(){

      $query = $this->db->query('SELECT id_serie FROM serie order by id_serie asc');

      return $query->result_array();

   }

   public function get_catalogo_id_provedor_amex(){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $res_id_provedor = $db_prueba->query("SELECT * FROM rpv_aereolineas_amex where status = 1");

      return $res_id_provedor->result_array();
      

   }

   public function get_catalogo_id_provedor_CFDI(){

      $db_prueba = $this->load->database('conmysql', TRUE); 

      $res_id_provedor = $db_prueba->query("SELECT * FROM rpv_aereolineas_cfdi where status = 1");

      return $res_id_provedor->result_array();
            
   }

   public function get_catalogo_tipo_aereolinea_amex($slc_select_cat_provedor){

      $db_prueba = $this->load->database('conmysql', TRUE);

      if($slc_select_cat_provedor != 0){

         $slc_select_cat_provedor = " and id_categoria_aereolinea = $slc_select_cat_provedor";

      }else{

         $slc_select_cat_provedor = "";

      }

      $res_id_servicio = $db_prueba->query("SELECT * FROM rpv_aereolineas_amex where status = 1 ".$slc_select_cat_provedor);

      return $res_id_servicio->result_array();


   }

   public function get_catalogo_clientes_amex(){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT id_cliente FROM rpv_cliente_tarjeta where status = 1");

     return $res->result_array();
                            
                            
   }

   public function get_catalogo_clientes_CFDI(){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT id_cliente FROM rpv_cliente_cfdi where status = 1");

     return $res->result_array();
                            
                            
   }


   public function get_catalogo_corporativo(){

      $query = $this->db->query('SELECT id_corporativo FROM corporativo order by id_corporativo asc');

      return $query->result_array();

   }

   public function get_catalogo_id_servicio(){

      $query = $this->db->query("SELECT id_tipo_servicio FROM tipo_servicio order by id_tipo_servicio asc");

      return $query->result_array();

   }

   public function get_catalogo_id_servicio_aereo(){

      $query = $this->db->query("SELECT id_tipo_servicio FROM tipo_servicio where id_tipo_servicio in ('BD','BI') order by id_tipo_servicio asc");

      return $query->result_array();

   }

   public function get_catalogo_id_provedor(){

      $query = $this->db->query("SELECT id_proveedor,nombre FROM proveedores order by id_proveedor asc");

      return $query->result_array();
      
   }

   public function get_catalogo_metodo_pago(){

      $query = $this->db->query("SELECT id_forma_pago FROM forma_de_pago order by id_forma_pago asc");

      return $query->result_array();
      
   }

   public function get_catalogo_plantillas($id_us,$id_rep){

      if($id_rep == 34){

          $id_rep = 4; //se iguala por que tienen exactamente los mismos filtros

      }

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query("SELECT * FROM rpv_plantillas where id_rep = $id_rep and id_us = $id_us and status = 1");

      return $query->result_array();

   }

}