<?php
class Mod_perfiles extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   
   public function get_catalogo_perfiles($sucursal,$perfil,$status){

     $db_prueba = $this->load->database('conmysql', TRUE);


     if($status == 1){
     
        if($perfil != ''){

          $perfil = " and dep.nombre = '".$perfil."' "; 

        }else{

          $perfil="";

        }

        $res = $db_prueba->query("SELECT per.id_sucursal,per.id, per.id_departamento, dep.nombre, per.fecha_alta, per.status FROM rpv_perfiles per
                               inner join rpv_departamentos dep on dep.id = per.id_departamento where per.status = 1 ".$perfil);

     }else{


        $res = $db_prueba->query("SELECT per.id_sucursal,per.id, per.id_departamento, dep.nombre, per.fecha_alta, per.status FROM rpv_perfiles per
                               inner join rpv_departamentos dep on dep.id = per.id_departamento where per.status = 1");



     }


     return $res->result_array();

   }

   public function get_perfiles_id($id_perfil){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM rpv_perfiles where id = $id_perfil");
   
     return $res->result_array();

   }
   
   public function get_catalogo_departamentos(){

   	 $db_prueba = $this->load->database('conmysql', TRUE);

   	 $res = $db_prueba->query("SELECT * FROM rpv_departamentos");
   
     return $res->result_array();

   }

   public function get_estadisticas($id_us){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("

      SELECT 

        (SELECT count(*) FROM reportes_villa_tours.rpv_correo_automatico
        inner join rpv_log_envio_correo on rpv_log_envio_correo.id_correo_automatico = rpv_correo_automatico.id

          where rpv_correo_automatico.id_usuario = $id_us and rpv_log_envio_correo.status = 1 and cast(rpv_log_envio_correo.fecha_envio as date) = cast(now() as date)  ) as env_correctamente,

        (SELECT count(*) FROM reportes_villa_tours.rpv_correo_automatico
        inner join rpv_log_envio_correo on rpv_log_envio_correo.id_correo_automatico = rpv_correo_automatico.id

          where rpv_correo_automatico.id_usuario = $id_us and rpv_log_envio_correo.status = 0 and cast(rpv_log_envio_correo.fecha_envio as date) = cast(now() as date)  ) as no_enviados,

        (SELECT count(*) FROM reportes_villa_tours.rpv_accesos where cast(rpv_accesos.fecha_alta as date) = cast(now() as date)  ) as cant_us


      ");
   
     return $res->result_array();

   }

   public function guardar_perfil($id_suc,$rows_cli_select,$slc_dep,$slc_mult_id_sucursal_alta,$array_mod_submod,$rows_mod,$status_all_cli){

   	$db_prueba = $this->load->database('conmysql', TRUE);

   	$db_prueba->trans_start();

   	$db_prueba->query("INSERT INTO rpv_perfiles(id_sucursal, id_departamento, fecha_alta, all_dks, status)   
									VALUES($id_suc,".$slc_dep.",now(),$status_all_cli,1)");

   	$id_perfil = $db_prueba->insert_id();
    
   	
      if($status_all_cli == 1){

          $db_prueba->query("INSERT INTO rpv_perfil_cliente(id_perfil, id_cliente, fecha_alta,status)
                    VALUES(".$id_perfil.",'0',now(),1)");

      }else{

          foreach ($rows_cli_select as $key => $value) {
        
            $db_prueba->query("INSERT INTO rpv_perfil_cliente(id_perfil, id_cliente, fecha_alta,status)
                        VALUES(".$id_perfil.",".$value["id_cliente"].",now(),1)");

          }

      }

    foreach ($array_mod_submod as $key => $value) {
      
        $data = explode('_', $value);
        $id_modulo = $data[0]; 
        $id_submodulo = $data[1];
        $sub_modulo_status = $data[2]; 
        $altas_status = $data[3];
        $bajas_status = $data[4]; 

        $db_prueba->query("INSERT INTO rpv_perfil_modulo_submodulo(id_perfil, id_modulo, id_submodulo, fecha_alta, status_submodulo, status, altas, bajas)
                  VALUES(".$id_perfil.",".$id_modulo.",".$id_submodulo.",now(),".$sub_modulo_status.",1,".$altas_status.",".$bajas_status.")");

    }
    
    if($slc_mult_id_sucursal_alta != 0){

        foreach ($slc_mult_id_sucursal_alta as $key => $value) {
          
          $db_prueba->query("INSERT INTO rpv_perfil_sucursal(id_perfil, id_sucursal, fecha_alta, status)
                  VALUES(".$id_perfil.",".$value.",now(),1)");

        }


      }else{

          $db_prueba->query("INSERT INTO rpv_perfil_sucursal(id_perfil, id_sucursal, fecha_alta, status)
                  VALUES(".$id_perfil.",0,now(),1)");


      }

    $db_prueba->trans_complete();

   	if($db_prueba->trans_status() === FALSE)
		{

		  $db_prueba->trans_rollback();
			return 0;

		}else{
      
			return 1;

		}


   }


   public function guardar_perfil_actualizado($id_suc,$rows_cli_select,$slc_dep,$slc_mult_id_sucursal_act,$array_mod_submod,$rows_mod,$id_perfil,$status_all_cli){

    
      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->trans_start();

      $db_prueba->query("UPDATE rpv_perfiles set id_sucursal = $id_suc,id_departamento = ".$slc_dep.", all_dks = $status_all_cli where id = $id_perfil");

        $db_prueba->query("UPDATE rpv_perfil_cliente set status = 0 where id_perfil = $id_perfil");

      
      if($status_all_cli == 1){

          $db_prueba->query("INSERT INTO rpv_perfil_cliente(id_perfil, id_cliente, fecha_alta,status)
                    VALUES(".$id_perfil.",'0',now(),1)");

      }else{

          foreach ($rows_cli_select as $key => $value) {
        
            $db_prueba->query("INSERT INTO rpv_perfil_cliente(id_perfil, id_cliente, fecha_alta,status)
                        VALUES(".$id_perfil.","./*$value["id_cliente"]*/$value->id_cliente.",now(),1)");
            
          }

      }


      $db_prueba->query("UPDATE rpv_perfil_modulo_submodulo set status = 0 where id_perfil = $id_perfil");

      $cont_mod_sub = count($array_mod_submod);


      foreach ($array_mod_submod as $key => $value) {
        
          $data = explode('_', $value);
          $id_modulo = $data[0]; 
          $id_submodulo = $data[1]; 
          $sub_modulo_status = $data[2]; 
          $alta_status = $data[3]; 
          $baja_status = $data[4];

          $db_prueba->query("INSERT INTO rpv_perfil_modulo_submodulo(id_perfil,id_modulo, id_submodulo, fecha_alta,status_submodulo, status,altas,bajas)
                    VALUES(".$id_perfil.",".$id_modulo.",".$id_submodulo.",now(),".$sub_modulo_status.",1,".$alta_status.",".$baja_status.")");

      }

      $db_prueba->query("UPDATE rpv_perfil_sucursal
        set status = 0 where id_perfil =".$id_perfil);

      if($slc_mult_id_sucursal_act != 0){

        foreach ($slc_mult_id_sucursal_act as $key => $value) {
          
          $db_prueba->query("INSERT INTO rpv_perfil_sucursal(id_perfil, id_sucursal, fecha_alta, status)
                  VALUES(".$id_perfil.",".$value.",now(),1)");

        }


      }else{

          $db_prueba->query("INSERT INTO rpv_perfil_sucursal(id_perfil, id_sucursal, fecha_alta, status)
                  VALUES(".$id_perfil.",0,now(),1)");


      }

      


      $db_prueba->trans_complete();

      if($db_prueba->trans_status() === FALSE)
      {
        $db_prueba->trans_rollback();
        return 0;

      }else{
        
        return 1;
      }

    
   }

   public function get_catalogo_modulos_perfil($id_perfil){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT distinct mod_sub.id_perfil,modu.id,modu.nombre,mod_sub.id_submodulo as id_submodulo FROM reportes_villa_tours.rpv_perfil_modulo_submodulo mod_sub
                                inner join rpv_modulos modu on modu.id = mod_sub.id_modulo
                                where mod_sub.status = 1 and mod_sub.status_submodulo = 1 and mod_sub.id_perfil = ".$id_perfil);

     return $res->result_array();

   }

   public function get_catalogo_modulos_perfil_distinct($id_perfil){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT distinct mod_sub.id_perfil,modu.id,modu.nombre FROM reportes_villa_tours.rpv_perfil_modulo_submodulo mod_sub
                                inner join rpv_modulos modu on modu.id = mod_sub.id_modulo
                                where mod_sub.status = 1 and mod_sub.status_submodulo = 1 and mod_sub.id_perfil = ".$id_perfil);

     return $res->result_array();

   }

   public function get_catalogo_submodulos($modulo_id){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM rpv_submodulos where id_modulo=".$modulo_id);
   
     return $res->result_array();

   }

   public function get_catalogo_perfil_submodulos($modulo_id,$id_perfil){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT mo_sub.id_perfil,mo_sub.id_modulo,mo_sub.id_submodulo,sub.nombre,mo_sub.status_submodulo,mo_sub.altas,mo_sub.bajas FROM rpv_modulos modu
                                inner join rpv_perfil_modulo_submodulo mo_sub on mo_sub.id_modulo = modu.id and mo_sub.status = 1
                                inner join rpv_submodulos sub on sub.id = mo_sub.id_submodulo
                                where mo_sub.id_perfil = ".$id_perfil." and mo_sub.id_modulo = ".$modulo_id); 
   
     return $res->result_array();

   }

   public function get_catalogo_submodulos_in($str_mod){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT * FROM rpv_submodulos where id_modulo in (".$str_mod.")");  //falta validacion de perfil
   
     return $res->result_array();

   }

   public function get_catalogo_modulos(){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $res = $db_prueba->query("SELECT * FROM rpv_modulos");

    return $res->result_array();

   }

   public function eliminar_perfil($id_perfil){

    $db_prueba = $this->load->database('conmysql', TRUE);
    
    $db_prueba->trans_start();

    $db_prueba->query("UPDATE rpv_perfiles set status = 0 WHERE id=".$id_perfil);

    $db_prueba->trans_complete();

    if ($db_prueba->trans_status() === FALSE)
    {  
      return 0;

    }else{

      return 1;
    }

  }

}