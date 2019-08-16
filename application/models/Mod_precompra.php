<?php
class Mod_precompra extends CI_Model {

   public function __construct(){
      parent::__construct();
   }
   
   public function get_catalogo_precompra_filtros($parametros){
   
     	  $db_prueba = $this->load->database('conmysql', TRUE);
     
        $precompra = $parametros['precompra'];

        if($precompra != ''){

          $precompra = " and nombre = '".$precompra."' "; 

        }else{

          $precompra="";

        }

        $res = $db_prueba->query("SELECT id, id_cliente, '' as rango_dias, fecha_alta, status  FROM rpv_precompra where status = 1 ".$precompra);

        $precompra = $res->result_array();

        $array_precompra = [];
        foreach ($precompra as &$valor) {


            $res2 = $db_prueba->query("SELECT *  FROM rpv_cliente_rango_precompra where status = 1 and id_precompra =".$valor['id']);

            $rpv_cliente_rango_precompra = $res2->result_array();

            $str_rangos = '';

            foreach ($rpv_cliente_rango_precompra as &$valor2) {

              $str_rangos = $str_rangos . $valor2['desde'] .'_'. $valor2['hasta'] . '/'; 
               

            }

            $valor['rango_dias'] = $str_rangos;

            array_push($array_precompra, $valor);


        }


     return $array_precompra;


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


   public function guardar_precompra($arr_cli,$arr_rangos_cli,$id_sucursal){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $db_prueba->trans_start();


     foreach ($arr_cli as &$valor) {
             
             $db_prueba->query("INSERT INTO rpv_precompra(id_sucursal, id_cliente, fecha_alta, status)
                                    VALUES($id_sucursal,'$valor',now(),1)");
             
             $id_precompra = $db_prueba->insert_id();

             foreach ($arr_rangos_cli as &$valor2) {
        
                $explode_rango_cli = explode('_', $valor2);
                $desde = $explode_rango_cli[0];
                $hasta = $explode_rango_cli[1];

                $db_prueba->query("INSERT INTO rpv_cliente_rango_precompra(id_precompra, desde, hasta, fecha_alta, status)
                                    VALUES($id_precompra,$desde,$hasta,now(),1)");

             
             }
     
      }

      $db_prueba->trans_complete();

      if ($db_prueba->trans_status() === FALSE)
      {
              
        return 0;

      }else{

        return 1;
      
      }

    }
    
    public function guardar_edicion_precompra($id_cliente,$id_precompra,$arr_rangos_cli,$id_sucursal){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

       $db_prueba->query("update rpv_cliente_rango_precompra
                          set status = 0
                          where id_precompra = ".$id_precompra);

       foreach ($arr_rangos_cli as &$valor2) {
        
                $explode_rango_cli = explode('_', $valor2);
                $desde = $explode_rango_cli[0];
                $hasta = $explode_rango_cli[1];

                $db_prueba->query("INSERT INTO rpv_cliente_rango_precompra(id_precompra, desde, hasta, fecha_alta, status)
                                    VALUES($id_precompra,$desde,$hasta,now(),1)");

             
             }

        $db_prueba->trans_complete();

            if ($db_prueba->trans_status() === FALSE)
            {
                    
              return 0;

            }else{

              return 1;
            
            }
    

   }


   public function eliminar_precompra($id_precompra){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

       $res = $db_prueba->query("UPDATE rpv_precompra
                                  set status = 0
                                  where id = $id_precompra
                                ");


       $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }

   }

   public function get_columnas_seleccionadas_alta($id_plantilla,$id_rep,$id_us){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT pla.*,pla_co.id_col,col.nombre_columna_vista FROM reportes_villa_tours.rpv_plantillas pla
                                inner join rpv_reporte_plantilla_columnas pla_co on pla.id = pla_co.id_plantilla
                                inner join rpv_reporte_columnas col on pla_co.id_col = col.id
                                where pla.id = $id_plantilla and pla.id_rep = $id_rep and pla.id_us = $id_us and pla_co.status = 1

                                ");
                                   
     return $res->result_array();

   }


}


