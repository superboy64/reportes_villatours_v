<?php
class Mod_plantillas extends CI_Model {

   public function __construct(){
      parent::__construct();
   }
   
   public function get_catalogo_plantillas_filtros($parametros,$status,$id_us){
   
   	 $db_prueba = $this->load->database('conmysql', TRUE);
     
     if($status == 1){

        $plantilla = $parametros['plantilla'];

        if($plantilla != ''){

          $plantilla = " and nombre = '".$plantilla."' "; 

        }else{

          $plantilla="";

        }

        $res = $db_prueba->query("SELECT * FROM rpv_plantillas where status = 1 and id_us=".$id_us.$plantilla);

     }else{

        $res = $db_prueba->query("SELECT * FROM rpv_plantillas where status = 1 and id_us=".$id_us);

     }
   	 
   
     return $res->result_array();


   }

   public function get_catalogo_plantillas($id_us){
   
     $db_prueba = $this->load->database('conmysql', TRUE);
     
     $res = $db_prueba->query("SELECT * FROM rpv_plantillas where status = 1 and id_us=".$id_us);

     return $res->result_array();

   }


   public function get_catalogo_reportes(){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_submodulos where id_modulo = 3");
      
     return $res->result_array();


   }


   public function get_columnas_plantillas_alta($id_rep){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_reporte_columnas where id_rep = $id_rep order by id_rep asc");
   
     return $res->result_array();


   }
   

  public function get_columnas_plantillas($id_rep){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT id as id_col,id_rep, nombre_columna_vista FROM reportes_villa_tours.rpv_reporte_columnas where id_rep = $id_rep order by id_rep asc");
   
     return $res->result_array();


   }



   public function get_columnas_not_in_plantilla_alta($ids_selec,$id_rep){

    $columnas = explode(',', $ids_selec);

    $columnas = array_filter($columnas, "strlen");
    $columnas = implode(",", $columnas);


     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_reporte_columnas where id not in ($columnas) and id_rep = $id_rep order by id_rep asc;");
    
     return $res->result_array();

   }

  public function get_columnas_not_in_plantilla($ids_selec,$id_rep){

    $columnas = explode(',', $ids_selec);

    $columnas = array_filter($columnas, "strlen");
    $columnas = implode(",", $columnas);


     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT id as id_col,id_rep, nombre_columna_vista FROM reportes_villa_tours.rpv_reporte_columnas where id not in ($columnas) and id_rep = $id_rep order by id_rep asc;");
    
     return $res->result_array();

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

   public function get_columnas_seleccionadas($id_plantilla,$id_rep,$id_us){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT pla_co.id_col,pla.id_rep,col.nombre_columna_vista FROM reportes_villa_tours.rpv_plantillas pla
                                inner join rpv_reporte_plantilla_columnas pla_co on pla.id = pla_co.id_plantilla
                                inner join rpv_reporte_columnas col on pla_co.id_col = col.id
                                where pla.id = $id_plantilla and pla.id_rep = $id_rep and pla.id_us = $id_us and pla_co.status = 1

                                ");
                                   
     return $res->result_array();

   }

   public function guardar_plantilla($nombre,$id_reporte,$arr_col,$id_us,$id_sucursal){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $db_prueba->trans_start();

     $res = $db_prueba->query("INSERT into rpv_plantillas(id_sucursal, id_rep, id_us, nombre, fecha_alta, status)
                              values($id_sucursal,$id_reporte,$id_us,'$nombre',now(),1)");

     $id_plantilla = $db_prueba->insert_id();

     foreach ($arr_col as &$valor) {
      
        $db_prueba->query("insert into rpv_reporte_plantilla_columnas(id_plantilla,id_col, fecha_alta, status)
                               values($id_plantilla,$valor,now(),1)");
        
     }

    $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }
    


   }

   public function guardar_plantilla_edicion($id_plan,$nombre,$id_reporte,$arr_col,$id_sucursal){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();


       $res = $db_prueba->query("UPDATE rpv_plantillas
                                  set id_sucursal = $id_sucursal,
                                  id_rep = $id_reporte, 
                                  nombre = '$nombre'
                                  where id = $id_plan
                                ");

        $res = $db_prueba->query("UPDATE rpv_reporte_plantilla_columnas
                                  set status = 0
                                  where id_plantilla = $id_plan;
                                ");

       foreach ($arr_col as &$valor) {
      
        $db_prueba->query("INSERT into rpv_reporte_plantilla_columnas(id_plantilla,id_col, fecha_alta, status)
                               values($id_plan,$valor,now(),1)");
     
       }



       $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }


   }

   public function eliminar_plantilla($id_plantilla){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

       $res = $db_prueba->query("UPDATE rpv_plantillas
                                  set status = 0
                                  where id = $id_plantilla
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


