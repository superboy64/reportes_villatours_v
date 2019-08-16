<?php
class Mod_clientes_CFDI extends CI_Model {

   public function __construct(){
      parent::__construct();
   }
   
   public function get_catalogo_clientes_CFDI_filtros($parametros){
   
     	  $db_prueba = $this->load->database('conmysql', TRUE);

        $res = $db_prueba->query("SELECT *  FROM rpv_cliente_cfdi where status = 1");

        $precompra = $res->result_array();

        
     return $precompra;


   }

   public function get_catalogo_reportes(){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_submodulos where id_modulo = 3");
      
     return $res->result_array();


   }

   public function get_catalogo_precompra($id_us){
   
     $db_prueba = $this->load->database('conmysql', TRUE);
     
     $res = $db_prueba->query("SELECT * FROM rpv_cliente_rango_precompra where status = 1");

     return $res->result_array();

   }


   public function guardar_cliente_CFDI($arr_cli,$tpo_factura){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $db_prueba->trans_start();

     foreach ($arr_cli as &$valor) {
             
             $db_prueba->query("INSERT INTO rpv_cliente_CFDI(id_cliente, tpo_factura, fecha_alta, status)
                                    VALUES('$valor','$tpo_factura',now(),1)");
             
         
      }


    $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }
    


   }

   public function guardar_actualizacion_clientes_CFDI($tpo_factura,$id_cliene_CFDI){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

       $res = $db_prueba->query("UPDATE rpv_cliente_cfdi
                                  set tpo_factura = '$tpo_factura'
                                  where id = '$id_cliene_CFDI'
                                ");

     
       $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }


   }

   public function eliminar_cliente_CFDI($id_cliente_CFDI){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();
       
    
       $res = $db_prueba->query("UPDATE rpv_cliente_cfdi
                                  set status = 0
                                  where ID = '".$id_cliente_CFDI."'
                                ");


       $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }

   }



}


