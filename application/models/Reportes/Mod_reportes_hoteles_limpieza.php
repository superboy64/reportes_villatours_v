<?php
set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');

class Mod_reportes_hoteles_limpieza extends CI_Model {

   public function __construct(){

      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
      
   }
   

   public function get_columnas($id_plantilla,$id_reporte){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query('SELECT * FROM reportes_villa_tours.rpv_reporte_columnas where id_rep = '.$id_reporte);
      
      return $query->result();


   }

   public function get_columns_excel($id_plantilla,$id_reporte){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query('select * from rpv_reporte_columnas
                                      where id not in(
                                      select id_col from rpv_reporte_plantilla_columnas 
                                      where id_plantilla =
                                      '.$id_plantilla.') and id_rep = '.$id_reporte.' ');

     
       return $query->result();


   }


   public function get_reportes_hoteles_limp($parametros){

      $ids_suc = $parametros["ids_suc"];
      $ids_serie = $parametros["ids_serie"];
      $ids_cliente = $parametros["ids_cliente"];
      $ids_servicio = $parametros["ids_servicio"];
      $ids_provedor = $parametros["ids_provedor"];
      $ids_corporativo = $parametros["ids_corporativo"];
      $fecha1 = $parametros["fecha1"];
      $fecha2 = $parametros["fecha2"];
      $id_usuario = $parametros["id_usuario"];
      $proceso = $parametros["proceso"];
      $id_intervalo = $parametros["id_intervalo"];
      $fecha_ini_proceso = $parametros["fecha_ini_proceso"];

      $ids_suc =  explode('_', $ids_suc);
      $ids_suc=array_filter($ids_suc, "strlen");

      $ids_serie =  explode('_', $ids_serie);
      $ids_serie=array_filter($ids_serie, "strlen");

      $ids_cliente =  explode('_', $ids_cliente);
      $ids_cliente=array_filter($ids_cliente, "strlen");

      $ids_servicio =  explode('_', $ids_servicio);
      $ids_servicio=array_filter($ids_servicio, "strlen");
      
      $ids_provedor =  explode('_', $ids_provedor);
      $ids_provedor=array_filter($ids_provedor, "strlen");

      $ids_corporativo =  explode('_', $ids_corporativo);
      $ids_corporativo=array_filter($ids_corporativo, "strlen");

      $cont_suc = count($ids_suc);
      
      if( $cont_suc > 0){
        $str_suc = '';
        foreach ($ids_suc as $clave => $valor) {  //obtiene clientes asignados

                 $str_suc = $str_suc."'".$valor."',";

              }

              $str_suc=explode(',', $str_suc);
              $str_suc=array_filter($str_suc, "strlen");
              $str_suc = implode(",", $str_suc);

      }

      $cont_serie = count($ids_serie);
      
      if( $cont_serie > 0){
        $str_ser = '';
        foreach ($ids_serie as $clave => $valor) {  //obtiene clientes asignados

                 $str_ser = $str_ser."'".$valor."',";

              }

              $str_ser=explode(',', $str_ser);
              $str_ser=array_filter($str_ser, "strlen");
              $str_ser = implode(",", $str_ser);

      }

      $cont_cliente = count($ids_cliente);
      
      if( $cont_cliente > 0){

        $str_cli = implode(",", $ids_cliente);

      }

      $cont_servicio = count($ids_servicio);
      
      if( $cont_servicio > 0){

        $str_serv = '';
        foreach ($ids_servicio as $clave => $valor) {  //obtiene clientes asignados

                 $str_serv = $str_serv."'".$valor."',";

              }

              $str_serv=explode(',', $str_serv);
              $str_serv=array_filter($str_serv, "strlen");
              $str_serv = implode(",", $str_serv);

      }

      $cont_provedor = count($ids_provedor);
      
      if( $cont_provedor > 0){

        $str_prov = '';
        foreach ($ids_provedor as $clave => $valor) {  //obtiene clientes asignados

                 $str_prov = $str_prov."'".$valor."',";

              }

              $str_prov=explode(',', $str_prov);
              $str_prov=array_filter($str_prov, "strlen");
              $str_prov = implode(",", $str_prov);

      }

      $cont_corporativo = count($ids_corporativo);
      
      if( $cont_corporativo > 0){

        $str_corp = '';
        foreach ($ids_corporativo as $clave => $valor) {  //obtiene clientes asignados

                 $str_corp = $str_corp."'".$valor."',";

              }

              $str_corp=explode(',', $str_corp);
              $str_corp=array_filter($str_corp, "strlen");
              $str_corp = implode(",", $str_corp);

      }

     
      $db_prueba = $this->load->database('conmysql', TRUE);
      
      $us = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_usuarios where id = $id_usuario");
      $us = $us->result_array();

      $all_dks = $us[0]['all_dks'];

      if($id_intervalo != 0){  //si es diferente es un proceso automatico

                 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

                 $rango_fechas = explode("_", $rango_fechas);

                 $fecha1 = $rango_fechas[0];
                 $fecha2 = $rango_fechas[1];


      }else{


        if($fecha1 == ""){

          $hoy = getdate();
          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
          $year = $hoy['year'];
          $fecha1 = $year.'-'.$mes.'-'.$dia;
          $fecha2 = $year.'-'.$mes.'-'.$dia;
         
          }else{
               
                $array_fecha1 = explode('/', $fecha1);
                
                $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];

                $array_fecha2 = explode('/', $fecha2);
                
                $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
               
          }

      }
    
    $this->db->query("create table #TEMPFAC(

    GVC_ID_SERVICIO varchar(500) null,
    GVC_ID_SERIE varchar(500) null,
    GVC_DOC_NUMERO varchar(500) null,
    GVC_ID_CLIENTE varchar(500) null,
    GVC_RECORD_LOCALIZADOR varchar(500) null,
    GVC_CVE_PAX varchar(500) null,
    GVC_NOMBRE_PAX varchar(500) null,
    GVC_NOMBRE_HOTEL varchar(500) null,
    GVC_FECHA_ENTRADA varchar(500) null,
    GVC_FECHA_SALIDA varchar(500) null,
    GVC_NOCHES varchar(500) null,
    GVC_FECHA_FACTURA varchar(500) null,
    GVC_FECHA_RESERVACION varchar(500) null,
    GVC_AC28 varchar(500) null,
    GVC_AC01 varchar(500) null,
    GVC_ID_CORPORATIVO varchar(500) null,
    GVC_NOM_CLI varchar(500) null,
    GVC_ID_STAT varchar(500) null
    
    )");

    $this->db->query("create table #TEMPNC(

     GVC_FAC_NUMERO varchar(500) null

    )");

     $select1 = " insert into #TEMPFAC 

      select 

    PROV_TPO_SERV.ID_SERVICIO,
      gds_general.id_serie,
      GVC_DOC_NUMERO=DATOS_FACTURA.FAC_NUMERO,
      gds_general.id_cliente,
      CASE WHEN (gds_general.record_localizador = 'IRIS' OR gds_general.record_localizador = '' OR gds_general.record_localizador IS NULL) THEN  datos_factura.analisis1_cliente ELSE gds_general.record_localizador END AS record_localizador,
      gds_general.cla_pax,
      gds_general.nombre_pax,
      gds_hoteles.nombre_hotel,
      gds_hoteles.fecha_entrada,
      gds_hoteles.fecha_salida,
      gds_hoteles.noches,
      datos_factura.fecha,
      gds_general.fecha_reservacion,
      gds_general.analisis28_cliente,
      datos_factura.analisis1_cliente,
      GVC_ID_CORPORATIVO=CLIENTES.ID_CORPORATIVO,
      GVC_NOM_CLI=DATOS_FACTURA.CL_NOMBRE,
      datos_factura.id_stat


      from
      DBA.DATOS_FACTURA,
      DBA.DETALLE_FACTURA,
      DBA.CLIENTES,
      DBA.VENDEDOR as TITULAR,
      DBA.PROV_TPO_SERV,
      DBA.SUCURSALES,
      DBA.PROVEEDORES,
      DBA.TIPO_SERVICIO left outer join
      DBA.CORPORATIVO on
      CLIENTES.ID_CORPORATIVO = CORPORATIVO.ID_CORPORATIVO left outer join
      DBA.CENTRO_COSTO on
      DATOS_FACTURA.ID_CENTRO_COSTO = CENTRO_COSTO.ID_CENTRO_COSTO and
      DATOS_FACTURA.ID_CLIENTE = CENTRO_COSTO.ID_CLIENTE left outer join
      DBA.DEPARTAMENTO on
      DATOS_FACTURA.ID_DEPTO = DEPARTAMENTO.ID_DEPTO and
      DATOS_FACTURA.ID_CENTRO_COSTO = DEPARTAMENTO.ID_CENTRO_COSTO and
      DATOS_FACTURA.ID_CLIENTE = DEPARTAMENTO.ID_CLIENTE left outer join
      DBA.VENDEDOR as AUXILIAR on
      DATOS_FACTURA.ID_VENDEDOR_AUX = AUXILIAR.ID_VENDEDOR left outer join
      DBA.CONCECUTIVO_BOLETOS on
      DETALLE_FACTURA.ID_BOLETO = CONCECUTIVO_BOLETOS.ID_BOLETO left outer join
      DBA.GDS_VUELOS on GDS_VUELOS.CONSECUTIVO = DATOS_FACTURA.CONSECUTIVO and
      GDS_VUELOS.NUMERO_BOLETO = DETALLE_FACTURA.NUMERO_BOL left outer join
      DBA.GDS_GENERAL on GDS_GENERAL.CONSECUTIVO = DATOS_FACTURA.CONSECUTIVO 
      left outer join
      DBA.GDS_JUSTIFICACION_TARIFAS on GDS_VUELOS.CODIGO_RAZON = ID_JUSTIFICACION 
    left outer join
      DBA.GDS_HOTELES on GDS_HOTELES.CONSECUTIVO = GDS_GENERAL.CONSECUTIVO 
      where
      DETALLE_FACTURA.ID_SERIE = DATOS_FACTURA.ID_SERIE and
      DETALLE_FACTURA.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO and
      DETALLE_FACTURA.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
      DATOS_FACTURA.ID_STAT = 1 and
      DATOS_FACTURA.ID_CLIENTE = CLIENTES.ID_CLIENTE and
      DATOS_FACTURA.ID_VENDEDOR_TIT = TITULAR.ID_VENDEDOR and
      DETALLE_FACTURA.PROV_TPO_SERV = PROV_TPO_SERV.PROV_TPO_SERV and
      DATOS_FACTURA.ID_SUCURSAL = SUCURSALES.ID_SUCURSAL and
      PROV_TPO_SERV.ID_PROVEEDOR = PROVEEDORES.ID_PROVEEDOR and
      PROV_TPO_SERV.ID_SERVICIO = TIPO_SERVICIO.ID_TIPO_SERVICIO and
      not DBA.DATOS_FACTURA.ID_SERIE = any(select ID_SERIE from DBA.GDS_CXS where EN_OTRA_SERIE = 'A')
    
     ";

    $select1 = $select1."
        AND datos_factura.fecha between '".$fecha1."' and '".$fecha2."'
    ";

    if($all_dks == 0){
       
        if($cont_cliente == 0){  

           $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_usuarios_cliente where id_usuario = $id_usuario and status = 1");
             
              $res = $res->result_array();
              $id_cliente_arr = [];  
              foreach ($res as $clave => $valor) {  //obtiene clientes asignados

                 
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);
                 

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select1 = $select1 . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and CLIENTES.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){
      
         if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }


     $select2 = " insert into #TEMPNC
     select
       
        GVC_FAC_NUMERO=NOTAS_CREDITO.FAC_NUMERO
       

      from
      
      DBA.NOTAS_CREDITO,
      DBA.DETALLE_NC,
      DBA.CLIENTES,
      DBA.VENDEDOR as TITULAR,
      DBA.PROV_TPO_SERV,
      DBA.SUCURSALES as SUC_NC,
      DBA.PROVEEDORES,
      DBA.TIPO_SERVICIO left outer join
      DBA.CORPORATIVO on
      CLIENTES.ID_CORPORATIVO = CORPORATIVO.ID_CORPORATIVO left outer join
      DBA.CENTRO_COSTO on
      NOTAS_CREDITO.ID_CENCOS = CENTRO_COSTO.ID_CENTRO_COSTO and
      NOTAS_CREDITO.ID_CLIENTE = CENTRO_COSTO.ID_CLIENTE left outer join
      DBA.DEPARTAMENTO on
      NOTAS_CREDITO.ID_DEPTO = DEPARTAMENTO.ID_DEPTO and
      NOTAS_CREDITO.ID_CENCOS = DEPARTAMENTO.ID_CENTRO_COSTO and
      NOTAS_CREDITO.ID_CLIENTE = DEPARTAMENTO.ID_CLIENTE left outer join
      DBA.VENDEDOR as AUXILIAR on
      NOTAS_CREDITO.ID_VENAUX = AUXILIAR.ID_VENDEDOR left outer join
      DBA.CONCECUTIVO_BOLETOS on
      PROV_TPO_SERV.ID_PROVEEDOR = CONCECUTIVO_BOLETOS.ID_PROVEEDOR and
      DETALLE_NC.DET_NC_NUM_BOL = CONCECUTIVO_BOLETOS.NUMERO_BOL and
      DETALLE_NC.ID_SUCURSAL = CONCECUTIVO_BOLETOS.ID_SUCURSAL left outer join
      DBA.SUCURSALES as SUC_FAC on
      NOTAS_CREDITO.ID_SUCURSAL_FAC = SUC_FAC.ID_SUCURSAL where
      NOTAS_CREDITO.NC_NUMERO = DETALLE_NC.NC_NUMERO and
      NOTAS_CREDITO.ID_SERIE = DETALLE_NC.ID_SERIE and
      NOTAS_CREDITO.ID_SUCURSAL = DETALLE_NC.ID_SUCURSAL and
      NOTAS_CREDITO.ID_STAT = 1 and
      NOTAS_CREDITO.ID_CLIENTE = CLIENTES.ID_CLIENTE and
      NOTAS_CREDITO.ID_VENDEDOR = TITULAR.ID_VENDEDOR and
      DETALLE_NC.PROV_TPO_SERV = PROV_TPO_SERV.PROV_TPO_SERV and
      NOTAS_CREDITO.ID_SUCURSAL = SUC_NC.ID_SUCURSAL and
      PROV_TPO_SERV.ID_PROVEEDOR = PROVEEDORES.ID_PROVEEDOR and
      PROV_TPO_SERV.ID_SERVICIO = TIPO_SERVICIO.ID_TIPO_SERVICIO
     
     ";


    $select2 = $select2."

      and NOTAS_CREDITO.NC_FEC between '".$fecha1."' and '".$fecha2."' AND 0 = 1
    
    ";

   if($all_dks == 0){

        if($cont_cliente == 0){  

           $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_usuarios_cliente where id_usuario = $id_usuario and status = 1");
             
              $res = $res->result_array();
              $id_cliente_arr = [];  
              foreach ($res as $clave => $valor) {  //obtiene clientes asignados

                 
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);
                 

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_cliente > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
        if($cont_cliente > 0){

              $select2 = $select2 . "and CLIENTES.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $this->db->query($select1);

    $this->db->query($select2);

    $select3 = " select

    GVC_ID_SERVICIO,
    GVC_ID_SERIE,
    GVC_DOC_NUMERO,
    GVC_ID_CLIENTE,
    GVC_RECORD_LOCALIZADOR,
    GVC_CVE_PAX,
    GVC_NOMBRE_PAX,
    GVC_NOMBRE_HOTEL,
    GVC_FECHA_ENTRADA,
    GVC_FECHA_SALIDA,
    GVC_NOCHES,
    GVC_FECHA_FACTURA,
    GVC_FECHA_RESERVACION,
    GVC_AC28,
    GVC_AC01,
    GVC_ID_CORPORATIVO,
    GVC_NOM_CLI,
    GVC_ID_STAT

    from #TEMPFAC as FAC where
         not FAC.GVC_DOC_NUMERO = any(select distinct GVC_FAC_NUMERO from #TEMPNC)";
    
    $query_rows = $this->db->query($select3);

  
    if($proceso == '1'){
      
      $result = $query_rows->result();

    }else if($proceso == '2'){

      $result = $query_rows->result_array();
      
    }
    
    $this->db->query("drop table #TEMPFAC");
    $this->db->query("drop table #TEMPNC");
   
    return $result;

  
   }



   public function get_razon_social_id_in($ids_cliente){

      $ids_cliente = implode(",", $ids_cliente);
                
      $query = $this->db->query("SELECT distinct nombre_cliente FROM clientes where id_cliente in ($ids_cliente)");

      return $query->result();

   }
 

  
}