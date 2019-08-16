<?php
class Mod_clientes extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   

   public function get_clientes_dk(){
   
     $query = $this->db->query('SELECT id_cliente,nombre_cliente,id_corporativo FROM clientes');

     return $query->result();

   }

   public function get_clientes_dk_perfil($id_per){
     
     $db_prueba = $this->load->database('conmysql', TRUE);

     $per = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_perfiles where id =".$id_per);
     $per = $per->result_array();

     $all_dks = $per[0]['all_dks'];

     if($all_dks  == '0'){

        $res = $db_prueba->query("SELECT id_cliente FROM rpv_perfil_cliente where status = 1 and id_perfil=".$id_per." order by  id_cliente asc");
        
        return $res->result_array();

     }else{

        $res = $this->db->query('SELECT id_cliente,nombre_cliente,id_corporativo FROM clientes order by  id_cliente asc');

        return $res->result_array();
     }


   }

   public function get_clientes_dk_perfil_filtrados($clientes){

     $query = $this->db->query("SELECT id_cliente,nombre_cliente,id_corporativo FROM clientes where id_cliente in(".$clientes.")");

     return $query->result();

   }

   public function get_clientes_dk_not_in($ids_selec){
      
     $query = $this->db->query("SELECT id_cliente,nombre_cliente,id_corporativo FROM clientes where id_cliente NOT IN (".$ids_selec.")");

     return $query->result();

   }

   public function get_clientes_dk_not_in_usuario($ids_selec,$id_per){
     
     $db_prueba = $this->load->database('conmysql', TRUE);
     $per = $db_prueba->query("SELECT id_cliente FROM reportes_villa_tours.rpv_perfil_cliente where id_perfil = $id_per");
     $per = $per->result_array();

     $clientes_buenos = [];

     foreach ($per as $clave => $valor) {
         
         array_push($clientes_buenos, $valor['id_cliente']);
         
      }

     $clientes_buenos = implode(",", $clientes_buenos);

     $query = $this->db->query("SELECT id_cliente,nombre_cliente,id_corporativo FROM clientes where id_cliente  IN (".$clientes_buenos.") and id_cliente NOT IN (".$ids_selec.")");

     return $query->result();

   }

   public function get_catalogo_dks_usuario_actualizacion($id_usuario){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT id_cliente FROM rpv_usuarios_cliente where status = 1 and id_usuario=".$id_usuario);
   
     return $res->result_array();


   }

   public function get_catalogo_dks_perfil_general($id_perfil){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT id_cliente FROM rpv_perfil_cliente where status = 1 and id_perfil=".$id_perfil);
   
     return $res->result_array();


   }

   public function get_catalogo_dks_seleccionados($dks){

    $query = $this->db->query('SELECT id_cliente,nombre_cliente,id_corporativo FROM clientes where id_cliente in('.$dks.')');

     return $query->result();

   }

   public function get_catalogo_dks_perfil($id_perfil){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT pc.id_cliente FROM rpv_perfiles per
                                inner join rpv_perfil_cliente pc on pc.id_perfil = per.id and pc.status = 1 where per.id =".$id_perfil);
   
     return $res->result_array();

   }
   

}