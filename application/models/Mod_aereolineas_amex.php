<?php
class Mod_aereolineas_amex extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   

 
   public function guardar_aereolinea_amex($arr_prov,$slc_cat_aereolinea,$txt_CODIGO_BSP,$rad_cambio_prov){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();
    $arr_prov = json_decode($arr_prov);

     foreach ($arr_prov as &$valor) {
          
          $id_proveedor = $valor->id_proveedor;
          $nombre = $valor->nombre;
          
          $db_prueba->query("INSERT INTO rpv_aereolineas_amex(id_aereolinea, id_categoria_aereolinea, nombre_aereolinea, codigo_bsp, cambio_prov, fecha_alta, status)
                             values('$id_proveedor','$slc_cat_aereolinea','$nombre','$txt_CODIGO_BSP','$rad_cambio_prov',now(),1)");

      }

    $db_prueba->trans_complete();

        if($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }
    

   }

   public function get_aereolineas_amex_not_in($rows_aereolineas_selec){

      $rows_aereolineas_selec = json_decode($rows_aereolineas_selec); // null

      $str_rows_aereolineas_selec = "";

      foreach ($rows_aereolineas_selec as &$valor) {

          $str_rows_aereolineas_selec = $str_rows_aereolineas_selec . "'".$valor->id_proveedor."'".",";
       
       }

      $array_id_provedor = explode(",", $str_rows_aereolineas_selec);
      $array_id_provedor = array_filter($array_id_provedor, "strlen");
      $array_id_provedor = implode(",", $array_id_provedor);


      $query = $this->db->query("SELECT id_proveedor,nombre FROM proveedores where id_proveedor not in(".$array_id_provedor.") order by id_proveedor asc");


      return $query->result_array();


   }

   public function get_catalogo_aereolineas_amex_local(){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $res = $db_prueba->query("SELECT * FROM rpv_aereolineas_amex where status = 1");
                                   
      return $res->result_array();

   }

   public function guardar_actualizacion_aereolineas_amex($slc_cat_aereolinea_edit,$hidden_aereolinea_edit,$txt_CODIGO_BSP_edit,$rad_cambio_prov_edit){


       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();


       $res = $db_prueba->query("UPDATE rpv_aereolineas_amex
                                  set id_categoria_aereolinea = '$slc_cat_aereolinea_edit',
                                  codigo_bsp = '$txt_CODIGO_BSP_edit',
                                  cambio_prov = '$rad_cambio_prov_edit'
                                  where id_aereolinea = '$hidden_aereolinea_edit'
                                ");

       $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;

        }else{

          return 1;
        
        }


   }

   public function eliminar_aereolinea($id){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

    
       $res = $db_prueba->query("UPDATE rpv_aereolineas_amex
                                  set status = 0
                                  where id = $id
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


