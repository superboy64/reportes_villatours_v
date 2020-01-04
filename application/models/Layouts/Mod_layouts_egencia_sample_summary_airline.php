<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');


class Mod_layouts_egencia_sample_summary_airline extends CI_Model {

   public function __construct(){

      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
      $this->load->library('lib_ciudades');
   
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
   
   public function get_layouts_egencia_data_import_sp($parametros){

      $ids_suc = $parametros["ids_suc"];
      $ids_serie = $parametros["ids_serie"];
      $ids_cliente = $parametros["ids_cliente"];
      $ids_servicio = $parametros["ids_servicio"];
      $ids_provedor = $parametros["ids_provedor"];
      $ids_corporativo = $parametros["ids_corporativo"];
      $fecha1 = $parametros["fecha1"];
      $fecha2 = $parametros["fecha2"];


      $id_usuario = $parametros["id_usuario"];
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
   


    $select = " 

select 

id_proveedor,    
moneda_vuelo,
SUBSTRING(fecha_fac, 4, 10) as fecha_fac,
nexp,
NAME,
sum(GVC_TOTAL) as GVC_TOTAL,
count(id_boleto) as cont_bolteos

FROM (

   select         

    type_of_service=convert(varchar,dba.TIPO_SERVICIO.id_tipo_servicio),
    CONCECUTIVO_BOLETOS.id_boleto,
    concecutivo_boletos.id_proveedor,
    moneda.clave_sat AS moneda_vuelo, 
    CONVERT(CHAR(12),datos_factura.fecha,105) AS fecha_fac, 
    nexp=CONVERT( VARCHAR,clientes.id_cliente), 
    NAME= clientes.nombre_cliente,
    DETALLE_FACTURA.TARIFA_MON_BASE+(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
          DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
          IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA)+
        (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
          DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
          IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA)+
        (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
          DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
          IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_TOTAL


    from

    dba.detalle_factura 

    left outer join
    dba.concecutivo_boletos on dba.detalle_factura.id_boleto = dba.concecutivo_boletos.id_boleto,

    dba.gds_general 

    left outer join
    dba.gds_vuelos on dba.gds_vuelos.consecutivo = dba.gds_general.consecutivo and dba.gds_vuelos.numero_boleto = dba.detalle_factura.numero_bol,

    dba.datos_factura

    left outer join
    dba.gds_vuelos_segmento on gds_vuelos_segmento.boleto = concecutivo_boletos.numero_bol 

    left outer join
    dba.gds_general on dba.datos_factura.consecutivo = dba.gds_general.consecutivo

    left outer join 
    dba.prov_tpo_serv ON dba.detalle_factura.prov_tpo_serv = dba.prov_tpo_serv.prov_tpo_serv

    left outer join 
    DBA.TIPO_SERVICIO ON DBA.TIPO_SERVICIO.ID_TIPO_SERVICIO = DBA.PROV_TPO_SERV.ID_SERVICIO

    left outer join 
    DBA.CLIENTES ON dba.datos_factura.id_cliente = dba.clientes.id_cliente
    
    left outer join 
    dba.proveedores ON dba.proveedores.ID_PROVEEDOR = prov_tpo_serv.ID_PROVEEDOR

    left outer join 
    DBA.VENDEDOR as VENDEDOR_TIT ON DATOS_FACTURA.ID_VENDEDOR_TIT = VENDEDOR_TIT.ID_VENDEDOR

    left outer join 
    DBA.moneda ON moneda.ID_MONEDA = datos_factura.ID_MONEDA

    left outer join 
    DBA.departamento ON departamento.id_depto = gds_general.id_depto

    


    /***********************forma de pago*******************************/

        LEFT OUTER JOIN dba.for_pgo_fac ON
        
        DATOS_FACTURA.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
        
        DATOS_FACTURA.ID_SERIE = for_pgo_fac.id_serie AND

        DATOS_FACTURA.FAC_NUMERO  = for_pgo_fac.fac_numero 

        LEFT OUTER JOIN dba.forma_de_pago ON for_pgo_fac.id_forma_pago = forma_de_pago.id_forma_pago

      /******************************************************/


    where

    (dba.datos_factura.fac_numero = dba.detalle_factura.fac_numero) and
    (dba.datos_factura.id_serie = dba.detalle_factura.id_serie) and
    (dba.datos_factura.id_sucursal = dba.detalle_factura.id_sucursal) and
    (dba.datos_factura.id_cliente = dba.clientes.id_cliente) and
    (dba.datos_factura.id_stat = 1)


    and dba.detalle_factura.id_stat = 1";

    if($id_intervalo == '5'){

      $condicion_fecha = 'datos_factura.fecha_folio';

    }else{

      $condicion_fecha = 'datos_factura.FECHA';

    }

    $select = $select . "
    and ".$condicion_fecha." between '".$fecha1."' and '".$fecha2."' 
    and TIPO_SERVICIO.id_tipo_servicio IN('BD','BI')";
    
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

              $select = $select . "and CLIENTES.id_cliente in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select = $select . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select = $select . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select = $select . "and CLIENTES.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_servicio > 0){

              $select = $select . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select = $select . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
        if($cont_serie > 0){  //ya

              $select = $select . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
        if($cont_cliente > 0){

              $select = $select . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }

    }


    $select = $select ." union select  
      
      type_of_service=convert(varchar,dba.TIPO_SERVICIO.id_tipo_servicio),
      CONCECUTIVO_BOLETOS.id_boleto,
      concecutivo_boletos.id_proveedor,
      moneda.clave_sat            AS moneda_vuelo, 
      CONVERT(char(12),notas_credito.nc_fec,105) AS fecha_fac,
      nexp=CONVERT(varchar,clientes.id_cliente), 
      NAME=              clientes.nombre_cliente,
      GVC_TOTAL='-'+
            convert(varchar,convert(varchar,DETALLE_NC.DET_NC_TAR_MN)+(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
              DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
              CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
              CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
              IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)+
            (select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
              DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
              CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
              CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
              IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)+
            (select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
              DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
              CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
              CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
              IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))


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
      NOTAS_CREDITO.ID_CLIENTE = CENTRO_COSTO.ID_CLIENTE 


      left outer join
      DBA.VENDEDOR as AUXILIAR on
      NOTAS_CREDITO.ID_VENAUX = AUXILIAR.ID_VENDEDOR left outer join
      
      DBA.CONCECUTIVO_BOLETOS on
      PROV_TPO_SERV.ID_PROVEEDOR = CONCECUTIVO_BOLETOS.ID_PROVEEDOR and
      DETALLE_NC.DET_NC_NUM_BOL = CONCECUTIVO_BOLETOS.NUMERO_BOL and
      DETALLE_NC.ID_SUCURSAL = CONCECUTIVO_BOLETOS.ID_SUCURSAL 

      left outer join
      DBA.SUCURSALES as SUC_FAC on
      NOTAS_CREDITO.ID_SUCURSAL_FAC = SUC_FAC.ID_SUCURSAL 
      left outer join 
      DBA.moneda ON moneda.ID_MONEDA = notas_credito.ID_MONEDA
     /***********************forma de pago*******************************/

      LEFT OUTER JOIN dba.for_pgo_fac ON
      
      notas_credito.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
      
      notas_credito.ID_SERIE = for_pgo_fac.id_serie AND

      notas_credito.FAC_NUMERO  = for_pgo_fac.fac_numero 

      LEFT OUTER JOIN dba.forma_de_pago ON for_pgo_fac.id_forma_pago = forma_de_pago.id_forma_pago

    /******************************************************/

      left outer join
      dba.gds_vuelos on dba.gds_vuelos.numero_boleto = DETALLE_NC.det_nc_num_bol and gds_vuelos.CANCELADO <> 'S'

      left outer join
      dba.gds_vuelos_segmento on gds_vuelos_segmento.boleto = concecutivo_boletos.numero_bol

      left outer join
      DBA.DEPARTAMENTO on
      NOTAS_CREDITO.ID_DEPTO = DEPARTAMENTO.ID_DEPTO and
      NOTAS_CREDITO.ID_CENCOS = DEPARTAMENTO.ID_CENTRO_COSTO and
      NOTAS_CREDITO.ID_CLIENTE = DEPARTAMENTO.ID_CLIENTE 

      where
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

    if($id_intervalo == '5'){

      $condicion_fecha = 'NOTAS_CREDITO.FECHA_FOLIO';

    }else{

      $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

    }
    
    $select = $select." 
    and ".$condicion_fecha." between '".$fecha1."' and '".$fecha2."' and TIPO_SERVICIO.id_tipo_servicio IN('BD','BI')
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

              $select = $select . "and CLIENTES.id_cliente in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select = $select . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select = $select . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select = $select . "and CLIENTES.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }

    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select = $select . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

        }
        if($cont_serie > 0){  //ya

              $select = $select . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
        if($cont_cliente > 0){

              $select = $select . "and CLIENTES.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }

    }
    

    $select = $select. "
              )As Z

              Group By 
              Z.id_proveedor,    
              Z.moneda_vuelo,
              SUBSTRING(Z.fecha_fac, 4, 10),
              Z.nexp,
              Z.NAME";

    
    $query_rows = $this->db->query($select);

    $result = $query_rows->result();

    return $result;


   }

      public function get_hoteles_sin_vuelo($parametros){

      $id_cliente = $parametros["id_cliente"];
      $id_cliente = ($id_cliente == "") ? $id_cliente = 'null' : $id_cliente = "'".$id_cliente."'"; 
      $id_corporativo = $parametros["id_corporativo"];
      $id_corporativo = ($id_corporativo == "") ? $id_corporativo = 'null' : $id_corporativo = "'".$id_corporativo."'"; 
      $fecha1 = $parametros["fecha1"];
      $fecha2 = $parametros["fecha2"];

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

      $query_rows = $this->db->query("execute sp_new_Martha_hoteles_no_vuelo '".$fecha1."','".$fecha2."',$id_cliente,$id_corporativo");
      
      $result = $query_rows->result();
   
      return $result;
 
   }

   public function get_razon_social_id_in($ids_cliente){

      $ids_cliente = implode(",", $ids_cliente);
                
      $query = $this->db->query("SELECT distinct nombre_cliente FROM clientes where id_cliente in ($ids_cliente)");

      return $query->result();

   }

   public function get_hoteles_num_bol($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$record_localizador,$consecutivo,$fecha1,$fecha2){
      
      if($tipo_funcion == "aut"){

                 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

                 $rango_fechas = explode("_", $rango_fechas);

                 $fecha1 = $rango_fechas[0];
                 $fecha2 = $rango_fechas[1];

       }
       
      /*$query = $this->db->query("SELECT DISTINCT buy_in_advance=datediff(dd,GDS_GENERAL.fecha_recepcion,dba.gds_hoteles.fecha_entrada),gds_hoteles.* FROM gds_hoteles 
                                 INNER JOIN GDS_GENERAL ON GDS_GENERAL.CONSECUTIVO =  gds_hoteles.CONSECUTIVO                 
                                 where gds_hoteles.consecutivo = '$consecutivo' and cast(GDS_GENERAL.fecha_recepcion as date) between '$fecha1' and '$fecha2' ");*/


      $query = $this->db->query("SELECT DISTINCT 
                                  gds_hoteles.id_habitacion as class_hotel,
                                  gds_hoteles.id_ciudad as destination_hotel,
                                  gds_hoteles.id_ciudad as origin_hotel,
                                  gds_hoteles.id_ciudad as routing_hotel,
                                  gds_hoteles.CONFIRMACION AS documento_hotel,
                                  gds_hoteles.NOMBRE_PAX AS GVC_NOM_PAX_HOTEL,
                                  gds_hoteles.tarjeta as payment_number_hotel,
                                  gds_hoteles.forma_pago as ID_FORMA_PAGO_HOTEL, 
                                  gds_hoteles.id_moneda as moneda_hotel, 
                                  buy_in_advance=datediff(dd,GDS_GENERAL.fecha_recepcion,dba.gds_hoteles.fecha_entrada),
                                  gds_hoteles.* 
                                  FROM gds_hoteles 
                                 INNER JOIN GDS_GENERAL ON GDS_GENERAL.CONSECUTIVO =  gds_hoteles.CONSECUTIVO                 
                                 where GDS_GENERAL.record_localizador = '$record_localizador' and cast(GDS_GENERAL.fecha_recepcion as date) between '$fecha1' and '$fecha2' ");

      
      $res = $query->result_array(); 
      return $res;

   }

   public function get_hoteles_iris($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$fac_numero,$fecha1,$fecha2,$id_serie){
                                  
      if($tipo_funcion == "aut"){

                 $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);
                 $rango_fechas = explode("_", $rango_fechas);
                 $fecha1 = $rango_fechas[0];
                 $fecha2 = $rango_fechas[1];

      }

      $db_prueba = $this->load->database('coniris', TRUE);

      $res = $db_prueba->query("SELECT
                                iris_reserv_serv.id_habitacion as class_hotel,
                                iris_ciudades.desc_ciudad as destination_hotel,
                                iris_ciudades.desc_ciudad as origin_hotel,
                                iris_ciudades.desc_ciudad as routing_hotel,
                                iris_reserv_serv.clave_confirmacion as documento_hotel,
                                iris_reserv_serv.PASAJERO_NOM + ' ' + iris_reserv_serv.PASAJERO_APELLIDO AS GVC_NOM_PAX_HOTEL,
                                iris_for_pgo_fac_serv.concepto as payment_number_hotel,
                                iris_for_pgo_fac_serv.id_forma_pago as ID_FORMA_PAGO_HOTEL
                                iris_reserv_serv.id_moneda as moneda_hotel,
                                iris_hoteles.direccion_ho,
                                iris_ciudades.desc_ciudad,
                                iris_hoteles.cp_ho,
                                iris_hoteles.tel1_ho,
                                fecha_fac2=convert(char(12),iris_reserv_serv.fecha_fac,105),buy_in_advance=datediff(dd,iris_cupones.fecha_cupon,iris_cupones.fecha_ent),iris_cupones.noches,iris_cupones.fecha_cupon,iris_reserv_serv.*
                                FROM iris_reserv_serv 
                                inner join iris_cupones on iris_cupones.num_factura = iris_reserv_serv.fac_numero and iris_cupones.id_serie_fac = iris_reserv_serv.id_serie
                                inner join iris_hoteles on iris_hoteles.id_hotel = iris_reserv_serv.id_hotel
                                left join iris_ciudades on iris_ciudades.id_ciudad = iris_reserv_serv.id_ciudad
                                left join iris_for_pgo_fac_serv on iris_for_pgo_fac_serv.consecutivo_reserv = iris_reserv_serv.consecutivo_reserv
                                WHERE iris_reserv_serv.FAC_NUMERO = $fac_numero and iris_reserv_serv.id_clave <> 'CXS' and cast(iris_cupones.fecha_cupon as date) between '$fecha1' and '$fecha2' and iris_reserv_serv.id_serie='$id_serie'");

      $res = $res->result_array();
      return $res;

   }

   public function get_autos_num_bol($consecutivo){
      $query = $this->db->query("SELECT  tipo_auto  as class_car,id_ciudad_renta as destination_car,id_ciudad_renta as origin_car, id_ciudad_renta as routing_car, confirmacion as documento_car,nombre_pax as GVC_NOM_PAX_CAR, tarjeta as payment_number_car, forma_pago as ID_FORMA_PAGO_AUTO ,id_moneda as moneda_auto, gds_autos.* FROM gds_autos where consecutivo = '".$consecutivo."' order by fecha_entrega");
      $res = $query->result_array();
      return $res;

   }

   public function get_segmentos_ticket_number($ticket,$consecutivo){
      
      $query = $this->db->query("SELECT * FROM gds_vuelos_segmento where boleto = '$ticket' and consecutivo = '$consecutivo' ");
      $res = $query->result_array();
      return $res;

   }
  
}