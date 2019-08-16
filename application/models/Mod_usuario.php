<?php
class Mod_usuario extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
   }
   
   public function cambio_contrasena_usuario($password_actual,$password_nuevo,$confirmar_password,$id_us){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();

    $validacion = $db_prueba->query(" 
        SELECT * FROM rpv_usuarios WHERE id = $id_us
    ");

    $validacion = $validacion->result();

   
    if($validacion[0]->password == md5($password_actual)){

        $res = $db_prueba->query("UPDATE rpv_usuarios
        SET password = '".md5($password_nuevo)."'
        where id = $id_us
        
        ");
       
        $db_prueba->trans_complete();

        if ($db_prueba->trans_status() === FALSE)
        {
                
          return 0;   // ocurrio un error en el proceso de actualizacion

        }else{

          return 1;  //proceso de actualizacion exitossa

        }

    }else{

         $db_prueba->trans_complete();
       
         return 2; //no paso la validacion  -- no existe el usuario

    }

   }

   public function get_datos_usuario($id_us){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT us.id, us.nombre, us.usuario, us.password, us.id_perfil,dep.nombre as perfil, us.fecha_alta, us.status from rpv_usuarios  us 
                              INNER JOIN rpv_perfiles per on per.id = us.id_perfil
                              INNER JOIN rpv_departamentos dep on dep.id = per.id_departamento
                              where us.status = 1 and us.id = $id_us;
                              ");
   
       return $res->result_array();


   }

   public function get_catalogo_usuarios(){
    
   	 $db_prueba = $this->load->database('conmysql', TRUE);

   	 $res = $db_prueba->query("SELECT distinct us.id, us.nombre, us.usuario, us.password, us.id_perfil,dep.nombre as perfil, us.fecha_alta, us.status from rpv_usuarios  us 
                              INNER JOIN rpv_perfiles per on per.id = us.id_perfil
                              INNER JOIN rpv_departamentos dep on dep.id = per.id_departamento
                              where us.status = 1 group by us.nombre
                              ");
   
       return $res->result_array();


   }

   public function get_catalogo_usuarios_filtro($sucursal,$nombre_usuario,$usuario,$departamento,$status){

     $db_prueba = $this->load->database('conmysql', TRUE);
     
     if($status == 1){

        if($sucursal != 0){

          $sucursal = " and us.id_sucursal = $sucursal "; 

        }else{

          $sucursal = "";
          
        }
        if($nombre_usuario != ''){

          $nombre_usuario = " and us.nombre = '".$nombre_usuario."' "; 

        }else{

          $nombre_usuario="";

        }
        if($usuario != ''){

          $usuario = " and us.usuario = '".$usuario."' "; 

        }else{

          $usuario="";

        }
        if($departamento != ''){

          $departamento = " and dep.nombre = '".$departamento."' ";

        }else{

          $departamento="";

        }


        $res = $db_prueba->query("SELECT us.id, us.id_sucursal, us.nombre, us.usuario, us.password, us.id_perfil,dep.nombre as perfil, us.fecha_alta, us.status from rpv_usuarios  us 
                              INNER JOIN rpv_perfiles per on per.id = us.id_perfil
                              INNER JOIN rpv_departamentos dep on dep.id = per.id_departamento
                              where  us.status = 1 ".$sucursal.$nombre_usuario.$usuario.$departamento);

    

     }else{

        $res = $db_prueba->query("SELECT us.id, us.id_sucursal, us.nombre, us.usuario, us.password, us.id_perfil,dep.nombre as perfil, us.fecha_alta, us.status from rpv_usuarios  us 
                              INNER JOIN rpv_perfiles per on per.id = us.id_perfil
                              INNER JOIN rpv_departamentos dep on dep.id = per.id_departamento
                              where us.status = 1
                              ");


     }

    
     return $res->result_array();


   }

   public function get_accesos($parametros){

        $nombre_usuario = $parametros['nombre_usuario'];
        $usuario = $parametros['usuario'];
        $departamento = $parametros['departamento'];
        $fecha1 = $parametros['fecha1'];
        $fecha2 = $parametros['fecha2'];


        if($nombre_usuario != ''){

          $nombre_usuario = " and rpv_usuarios.nombre = '".$nombre_usuario."' "; 

        }else{

          $nombre_usuario="";

        }
        if($usuario != ''){

          $usuario = " and usuario_ingresado = '".$usuario."' "; 

        }else{

          $usuario="";

        }
        if($departamento != ''){

          $departamento = " and rpv_departamentos.nombre = '".$departamento."' ";

        }else{

          $departamento="";

        }

        $fecha1 = explode('/', $fecha1);
        $dia1 = $fecha1[0];
        $mes1 = $fecha1[1];
        $ano1 = $fecha1[2];
        $fecha1 = $ano1.'-'.$mes1.'-'.$dia1;

        $fecha2 = explode('/', $fecha2);
        $dia2 = $fecha2[0];
        $mes2 = $fecha2[1];
        $ano2 = $fecha2[2];
        $fecha2 = $ano2.'-'.$mes2.'-'.$dia2;

        $db_prueba = $this->load->database('conmysql', TRUE);
        
        $res = $db_prueba->query("SELECT rpv_accesos.*,rpv_usuarios.nombre as nombre_usuario,rpv_departamentos.nombre as departamento  FROM reportes_villa_tours.rpv_accesos
                                LEFT join rpv_usuarios on rpv_usuarios.id = rpv_accesos.id_usuario
                                LEFT join rpv_perfiles on rpv_perfiles.id = rpv_usuarios.id_perfil
                                LEFT join rpv_departamentos on rpv_departamentos.id = rpv_perfiles.id_departamento where cast(rpv_accesos.fecha_alta as date) between '$fecha1' and '$fecha2' ".$nombre_usuario.$usuario.$departamento);
        return $res->result_array();
                             
   }

   public function get_catalogo_perfiles(){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $res = $db_prueba->query("SELECT per.all_dks,per.id,dep.nombre FROM rpv_perfiles per 
                               inner join rpv_departamentos dep on dep.id = per.id_departamento where per.status = 1");
   
     return $res->result_array();

   }

   public function get_catalogo_sucursales(){

     $query = $this->db->query("SELECT * FROM sucursales");

     return $query->result_array();

   }

   public function get_sucursales_actuales($id_peril){

     $db_prueba = $this->load->database('conmysql', TRUE);

     $query = $db_prueba->query("SELECT * from rpv_perfil_sucursal WHERE id_perfil = '$id_peril' and status = 1");

     return $query->result_array();

   }

   public function guardar_usuario($nombre,$usuario,$sucursal,$password,$perfil,$rows_clientes_selec_all,$all_dks){

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();

    $val_us = $db_prueba->query("SELECT * from rpv_usuarios WHERE usuario = '$usuario'");

    $val_us =  $val_us->result();

    if(count($val_us) > 0){
        
        return 2;

    }else{ //fin if val us

          $db_prueba->query("INSERT INTO rpv_usuarios(id_sucursal, nombre, usuario, password, id_perfil, fecha_alta, all_dks, status)
                             VALUES('".$sucursal."','".$nombre."','".$usuario."','".md5($password)."',".$perfil.",now(),$all_dks,1)"
                      );

          $id_usuario = $db_prueba->insert_id();

          if($all_dks == 0 ){

            foreach ($rows_clientes_selec_all as $clave => $valor) {
                  
                  

                  $db_prueba->query("INSERT INTO rpv_usuarios_cliente(id_usuario, id_cliente, fecha_alta, status)
                                    values($id_usuario, ".$valor['id_cliente'].", now(), 1)");
            
            }

          }else{

          
            $db_prueba->query("INSERT INTO rpv_usuarios_cliente(id_usuario, id_cliente, fecha_alta, status)
                                    values($id_usuario, 0, now(), 1)");

          }

          $db_prueba->trans_complete();

          if ($db_prueba->trans_status() === FALSE)
          {
                  
            return 0;

          }else{

            return 1;
          
          }

    }  //fin else val us


   }

   public function actualizar_usuario($id_usuario,$nombre,$usuario,$sucursal,$password,$id_perfil,$rows_clientes_selec_all,$all_dks){

    $rows_clientes_selec_all = json_decode($rows_clientes_selec_all);

    $db_prueba = $this->load->database('conmysql', TRUE);

    $db_prueba->trans_start();

    $dat_us = $db_prueba->query("SELECT  password from rpv_usuarios WHERE id=".$id_usuario);
    
    $dat_us = $dat_us->result();

    //print_r($dat_us);
    if($all_dks == ''){

      $all_dks = 0;

    }

    if($dat_us[0]->password == $password){

       $db_prueba->query("UPDATE rpv_usuarios
                       SET 
                           id_sucursal = '".$sucursal."',
                           nombre = '".$nombre."',
                           usuario =  '".$usuario."',
                           password = '".$password."',
                           id_perfil = ".$id_perfil.",
                           all_dks = ".$all_dks."
                           where id=".$id_usuario
                );

    }else{

       $db_prueba->query("UPDATE rpv_usuarios
                       SET 
                           id_sucursal = '".$sucursal."',
                           nombre = '".$nombre."',
                           usuario =  '".$usuario."',
                           password = '".md5($password)."',
                           id_perfil = ".$id_perfil.",
                           all_dks = ".$all_dks."
                           where id=".$id_usuario
                );


    }

      $db_prueba->query("UPDATE rpv_usuarios_cliente set status = 0 where id_usuario = $id_usuario");
      $db_prueba->query("UPDATE rpv_usuarios set all_dks = $all_dks where id = $id_usuario");

      if($all_dks == 0 ){

        foreach ($rows_clientes_selec_all as $clave => $valor) {

                  //print_r($valor['id_cliente']);
                  $db_prueba->query("INSERT INTO rpv_usuarios_cliente(id_usuario, id_cliente, fecha_alta, status)
                                values($id_usuario, ".$valor->id_cliente.", now(), 1)");
              
        
        }

      }else{

                  $db_prueba->query("INSERT INTO rpv_usuarios_cliente(id_usuario, id_cliente, fecha_alta, status)
                                values($id_usuario, 0, now(), 1)");


      }


    $db_prueba->trans_complete();

    if ($db_prueba->trans_status() === FALSE)
    {
            
      return 0;

    }else{

      return 1;
    }

  }

  public function eliminar_usuario($id_usuario){

    $db_prueba = $this->load->database('conmysql', TRUE);
    
    $db_prueba->trans_start();

    $db_prueba->query("UPDATE rpv_usuarios set status = 0 WHERE id=".$id_usuario);

    $db_prueba->trans_complete();

    if ($db_prueba->trans_status() === FALSE)
    {  
      return 0;

    }else{

      return 1;
    }

  }

}


