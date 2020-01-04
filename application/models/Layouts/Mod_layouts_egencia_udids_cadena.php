<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');

class Mod_layouts_egencia_udids_cadena extends CI_Model {

   public function __construct(){

      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
      $this->load->library('lib_ciudades');
      $this->load->library('lib_catalogo_udids');
   
   }

   public function get_analisis_cliente($id_cliente){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $query = $db_prueba->query("SELECT rpv_analisis_cliente_cliente.*,rpv_analisis_cliente.nombre FROM rpv_analisis_cliente_cliente 
      inner join rpv_analisis_cliente on rpv_analisis_cliente.id = rpv_analisis_cliente_cliente.id_analisis
      where rpv_analisis_cliente_cliente.status = 1 and rpv_analisis_cliente_cliente.id_cliente = '".$id_cliente."'");
     
    return $query->result();

   }
   
   public function get_layouts_egencia_data_import_sp($id_us){

  
      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query("select * from rpv_ega_data_import WHERE id_usuario = ".$id_us."");
     
      $array_aereo = $query->result_array();
      
      $array_nuevo_formato = [];

      foreach ($array_aereo as $key2 => $value2) {
        

        $dat['Link_Key'] =  $value2['id'].$value2['RecordLocator']; //consecutivo + record 
        $dat['BookingID'] =  $value2['id'];
        
        $get_analisis_cliente = $this->get_analisis_cliente($value2['AccountInterfaceID']);

        foreach ($get_analisis_cliente as $key1 => $value1) {


          $UdidNumber = $value1->id_analisis;
          $UdidValue = $value2[$value1->nombre];
          $UdidDefinitions = $this->lib_catalogo_udids->udids($UdidNumber); 

          $dat['UdidNumber'] = $UdidNumber;
          $dat['UdidValue'] = $UdidValue;
          $dat['UdidDefinitions'] = $UdidDefinitions;

          array_push($array_nuevo_formato, $dat);

        }

        

      }

       return $array_nuevo_formato;
       
   }


  public function delete_layouts_egencia_data_import_sp($id_us){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->query("delete from rpv_ega_data_import WHERE id_usuario = ".$id_us."");

  }

 
  
}