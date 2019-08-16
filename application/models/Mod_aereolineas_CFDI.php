<?php
class Mod_aereolineas_CFDI extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   

   public function guardar_aereolinea_CFDI($arr_prov,$slc_cat_aereolinea,$slc_cat_cuenta,$txt_CODIGO_NUMERICO,$txt_CODIGO_TIMBRE){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();
    $arr_prov = json_decode($arr_prov);

     foreach ($arr_prov as &$valor) {
          
          $id_proveedor = $valor->id_proveedor;
          $nombre = $valor->nombre;
          
          $db_prueba->query("INSERT INTO rpv_aereolineas_cfdi(id_aereolinea, id_categoria_aereolinea, nombre_aereolinea, bajo_costo, codigo_numerico, codigo_timbre, fecha_alta, status)
                             values('$id_proveedor','$slc_cat_aereolinea','$nombre','$slc_cat_cuenta','$txt_CODIGO_NUMERICO','$txt_CODIGO_TIMBRE',now(),1)");

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

          $str_rows_aereolineas_selec = $str_rows_aereolineas_selec . "'".$valor->id_tipo_aereolinea."'".",";
       
       }

      $array_id_tipo_aereolinea = explode(",", $str_rows_aereolineas_selec);
      $array_id_tipo_aereolinea = array_filter($array_id_tipo_aereolinea, "strlen");
      $array_id_tipo_aereolinea = implode(",", $array_id_tipo_aereolinea);
     

      $query = $this->db->query("SELECT id_tipo_aereolinea FROM tipo_aereolinea where  id_tipo_aereolinea not in(".$array_id_tipo_aereolinea.")  and status = 1 order by id_tipo_aereolinea asc");

      return $query->result_array();


   }

   public function get_catalogo_aereolineas_CFDI_local(){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $res = $db_prueba->query("SELECT * FROM rpv_aereolineas_CFDI where status = 1");
                                   
      return $res->result_array();

   }

   public function guardar_actualizacion_aereolineas_CFDI($slc_cat_aereolinea_edit,$slc_cat_cuenta_edit,$hidden_aereolinea_edit,$txt_CODIGO_NUMERICO_edit,$txt_CODIGO_TIMBRE_edit){


       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

   
       $res = $db_prueba->query("UPDATE rpv_aereolineas_cfdi
                                  set 
                                  id_categoria_aereolinea = '$slc_cat_aereolinea_edit',
                                  codigo_numerico = '$txt_CODIGO_NUMERICO_edit',
                                  codigo_timbre = '$txt_CODIGO_TIMBRE_edit',
                                  bajo_costo = '$slc_cat_cuenta_edit'
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

   public function eliminar_aereolinea_CFDI($id){

       $db_prueba = $this->load->database('conmysql', TRUE);

       $db_prueba->trans_start();

    
       $res = $db_prueba->query("UPDATE rpv_aereolineas_cfdi
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


