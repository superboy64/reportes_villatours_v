<?php
class Mod_egencia_udids_ac extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   
   public function get_catalogo_udids_ac(){

          $db_prueba = $this->load->database('conmysql', TRUE);

          $clientes = $db_prueba->query("SELECT id,id_cliente FROM rpv_analisis_cliente_cliente where status = 1  group by id_cliente");

          $clientes = $clientes->result();

          $array_nuevo = [];

          foreach ($clientes as $key => $value) {
              

              $analisis = $db_prueba->query("SELECT * FROM rpv_analisis_cliente_cliente
                                              inner join rpv_analisis_cliente on rpv_analisis_cliente.id = rpv_analisis_cliente_cliente.id_analisis
                                              where  rpv_analisis_cliente_cliente.id_cliente = '".$value->id_cliente."' and rpv_analisis_cliente_cliente.status = 1");

              $analisis = $analisis->result();

              $nombre_analisis = '';
              foreach ($analisis as $key2 => $value2) {

                $nombre = $value2->nombre;

                $nombre_analisis = $nombre_analisis.$nombre.'/';          

              }


              array_push($array_nuevo, $value->id.'*'.$value->id_cliente.'*'.$nombre_analisis);

          }

          $array_final = [];

          foreach ($array_nuevo as $key => $value) {
           
            $array_inicio = [];

            $explode = explode('*', $value);

            $array_inicio['id'] = $explode[0];
            $array_inicio['cliente'] = $explode[1];
            $array_inicio['analisis'] = $explode[2];

            array_push($array_final, $array_inicio);

          }


          return $array_final;
     
   }

   public function guardar_analisis_cliente($arr_cli,$arr_analis,$group_id){

    $status = 0;

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();

    $arr_cli = json_decode($arr_cli);
    $arr_analis = json_decode($arr_analis);


    foreach ($arr_cli as $key1 => $value1) {

      $cliente_existente = $db_prueba->query("SELECT * from rpv_analisis_cliente_cliente WHERE id_cliente = '".$value1."' and status = 1");
      $cliente_existente = $cliente_existente->result();

      if(count($cliente_existente) > 0){

        $status = 0;

      }else{

        $status = 1;

        foreach ($arr_analis as $key2 => $value2) {

          $db_prueba->query("INSERT INTO rpv_analisis_cliente_cliente(id_cliente, id_analisis, group_id, fecha_alta, status)
                             values('$value1','$value2','$group_id',now(),1)");


        }


      }
      

    }


    $db_prueba->trans_complete();

        if($db_prueba->trans_status() === FALSE || $status == 0)
        {
            
            if($status == 0){

              return 2;

            }else{

              return 0;

            }
          

        }else{

            return 1;
        
        }
    
   }


   public function eliminar_udids($id_cliente){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->trans_start();

      $res = $db_prueba->query("
                                    UPDATE rpv_analisis_cliente_cliente
                                    set status = 0
                                    where id_cliente = $id_cliente

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


