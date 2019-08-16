<?php
class Pruebamodel extends CI_Model { 

   public function __construct() {
      parent::__construct();
      //$this->load->database('default'); por problemas de actualizacion en codeigniter odbc no tiene compatibilidad con builder
      //la conexion se remplazo creando una libreria nueva para ejecutar setencias puras a la base de datos sybase
      $this->load->database('default');

      //$this->load->library('consybase');

   }
   
   public function obtener_todos(){
     
      /*$conn = $this->consybase->conn();

      $sql="select * from tabla_prueba";

      $rs=odbc_exec($conn,$sql);
      
      while($fila=odbc_fetch_array($rs)){

         print_r($fila);

      }*/

      $query = $this->db->query('select * from anticipos');

      return $query->result();

      /*foreach ($query->result() as $row)
         {
                 print_r($row);
                 
         }
      */

   }


}