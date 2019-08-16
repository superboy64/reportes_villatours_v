<?php
class Mod_tarjetas extends CI_Model {

   public function __construct(){
      parent::__construct();
   }
   
   public function get_catalogo_tarjetas_filtros($parametros){
   
     	  $db_prueba = $this->load->database('conmysql', TRUE);
     
        $precompra = $parametros['precompra'];

        if($precompra != ''){

          $precompra = " and nombre = '".$precompra."' "; 

        }else{

          $precompra="";

        }

        $res = $db_prueba->query("SELECT *  FROM rpv_cliente_tarjeta where status = 1 ".$precompra);

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


   public function guardar_tarjeta($arr_cli,$num_tarjet){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $db_prueba->trans_start();

     foreach ($arr_cli as &$valor) {
             
             $db_prueba->query("INSERT INTO rpv_cliente_tarjeta(id_cliente, tarjeta, fecha_alta, status)
                                    VALUES('$valor','$num_tarjet',now(),1)");
             
         
      }


    $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }
    


   }

   public function guardar_actualizacion_tarjetas($num_tarjeta_edit,$hidden_cliente_edit){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

       $res = $db_prueba->query("UPDATE rpv_cliente_tarjeta
                                  set tarjeta = '$num_tarjeta_edit'
                                  where id_cliente = '$hidden_cliente_edit'
                                ");

     
       $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }


   }

   public function eliminar_tarjeta($id_cliente){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();
       
    
       $res = $db_prueba->query("UPDATE rpv_cliente_tarjeta
                                  set status = 0
                                  where id_cliente = '".$id_cliente."'
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


