<?php
set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');

class Mod_layouts_venta_diaria_amex extends CI_Model {

    public function __construct(){
      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
   }
   
   
   
     function lay_venta_diaria_amex($parametros){
      
      $ids_suc = $parametros["ids_suc"];
      $ids_serie = $parametros["ids_serie"];
      $ids_cliente = $parametros["ids_cliente"];
      $ids_servicio = $parametros["ids_servicio"];
      $ids_metodo_pago = $parametros["ids_metodo_pago"];
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

      $ids_metodo_pago =  explode('_', $ids_metodo_pago);
      $ids_metodo_pago=array_filter($ids_metodo_pago, "strlen");

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

      $cont_metodo_pago = count($ids_metodo_pago);
      
      if( $cont_metodo_pago > 0){

        $str_met_pag = '';
        foreach ($ids_metodo_pago as $clave => $valor) {  //obtiene clientes asignados

                 $str_met_pag = $str_met_pag."'".$valor."',";

              }

              $str_met_pag=explode(',', $str_met_pag);
              $str_met_pag=array_filter($str_met_pag, "strlen");
              $str_met_pag = implode(",", $str_met_pag);

      }

    $id_perfil = $this->session->userdata('session_id_perfil');
    $db_prueba = $this->load->database('conmysql', TRUE);
      
      $us = $db_prueba->query("SELECT * FROM rpv_usuarios where id = $id_usuario");
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
    
    GVC_ID_SERIE varchar(500) null,
    GVC_DOC_NUMERO varchar(500) null,
    FECHA varchar(500) null,
    GVC_NOM_CLI varchar(500) null,
    analisis27_cliente varchar(500) null,
    GVC_ID_CORPORATIVO varchar(500) null,
    GVC_TOTAL varchar(500) null,
    GVC_ID_SERVICIO varchar(500) null,
    ID_FORMA_PAGO varchar(500) null,
    c_FormaPago varchar(500) null,
    GVC_RUTA varchar(500) null,
    GVC_ID_PROVEEDOR varchar(500) null,
    GVC_NOMBRE_PROVEEDOR varchar(500) null,
    GVC_TARIFA varchar(500) null,
    GVC_IVA varchar(500) null,
    GVC_TUA varchar(500) null,
    GVC_OTROS_IMPUESTOS varchar(500) null, 
    GVC_NOM_VEN_TIT varchar(500) null,
    NUMERO_CUENTA varchar(500) null,
    CONCEPTO varchar(500) null,
    NUMERO_CUPON varchar(500) null,
    NUMERO_BOLETO varchar(500) null,
    CVE varchar(500) null,
    GVC_DESCRIPCION_EXTENDIDA varchar(500) null

    )");
  

    $this->db->query("create table #TEMPNC(
   
    GVC_FAC_NUMERO varchar(500) null
    
    )");
    


     $select1 = "  insert into #TEMPFAC
    select 

      DATOS_FACTURA.ID_SERIE as GVC_ID_SERIE,
      DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO,
      CAST(DATOS_FACTURA.FECHA AS DATE) AS FECHA,
      DATOS_FACTURA.CL_NOMBRE as GVC_NOM_CLI,
      DATOS_FACTURA.analisis27_cliente as analisis27_cliente,
      CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO,
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
        IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_TOTAL,
       PROV_TPO_SERV.ID_SERVICIO as GVC_ID_SERVICIO,

       DATOS_FACTURA.c_MetodoPago,
       forma_de_pago.c_FormaPago,
       detalle_factura.concepto as GVC_RUTA,
       GVC_ID_PROVEEDOR=PROV_TPO_SERV.ID_PROVEEDOR,
       GVC_NOMBRE_PROVEEDOR=PROVEEDORES.NOMBRE,

       GVC_TARIFA=DETALLE_FACTURA.TARIFA_MON_BASE,
       GVC_IVA=(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
        DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
        CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
        CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
        IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA),
       GVC_TUA=(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
        DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
        CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
        CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
        IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA),
       GVC_OTROS_IMPUESTOS=(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
        DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
        CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
        CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
        IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA),

       TITULAR.NOMBRE as GVC_NOM_VEN_TIT,

       DATOS_FACTURA.cte_num_cta,
       for_pgo_fac.concepto,
       detalle_factura.num_cupon,

       case when (DETALLE_FACTURA.NUMERO_BOL = '' or DETALLE_FACTURA.NUMERO_BOL is null and DETALLE_FACTURA.numero_bol_Cxs <> '' and DETALLE_FACTURA.numero_bol_Cxs is not null) then  DETALLE_FACTURA.numero_bol_Cxs else DETALLE_FACTURA.NUMERO_BOL  end as numero_bol,

       SUCURSALES.cve,
       DATOS_FACTURA.descr_exten as GVC_DESCRIPCION_EXTENDIDA
     
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
      DBA.sat_paises on
      CLIENTES.pais_cliente = sat_paises.c_Pais left outer join
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
      DBA.GDS_GENERAL on GDS_GENERAL.CONSECUTIVO = DATOS_FACTURA.CONSECUTIVO left outer join
      DBA.GDS_JUSTIFICACION_TARIFAS on GDS_VUELOS.CODIGO_RAZON = ID_JUSTIFICACION 
      /******************************************************/

        LEFT OUTER JOIN dba.for_pgo_fac ON
        
        DATOS_FACTURA.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
        
        DATOS_FACTURA.ID_SERIE = for_pgo_fac.id_serie AND

        DATOS_FACTURA.FAC_NUMERO  = for_pgo_fac.fac_numero 

        LEFT OUTER JOIN dba.forma_de_pago ON for_pgo_fac.id_forma_pago = forma_de_pago.id_forma_pago

      /******************************************************/
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

   

      //print_r("se va por aki");
      $condicion_fecha = 'DATOS_FACTURA.FECHA';
      //$condicion_fecha = 'CONCECUTIVO_BOLETOS.FECHA_EMI';


  

    $select1 = $select1." 
    and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
    ";

    $res = $db_prueba->query("SELECT * FROM rpv_usuarios_cliente where id_usuario = $id_usuario and status = 1");    
    $res = $res->result_array();

    $res_suc = $db_prueba->query("SELECT * from rpv_perfil_sucursal WHERE id_perfil = $id_perfil and status = 1");
    $res_suc = $res_suc->result_array();

      
    if($all_dks == 0){

        if($cont_cliente == 0){  
           
              $id_cliente_arr = [];  
              foreach ($res as $clave => $valor) {  //obtiene clientes asignados
             
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);
                 

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select1 = $select1 . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and CLIENTES.id_cliente in (".$str_cli.") "; 


         }
         if($cont_suc == 0){

           $sucursales_actuales = $res_suc;
           $array_suc = [];

           foreach ($sucursales_actuales as $key => $value) {
            
              $id_sucursal = $value['id_sucursal'];
              
              $query = $this->db->query("SELECT id_sucursal FROM sucursales where id_sucursal = ".$id_sucursal);
              $rest = $query->result_array();
              array_push($array_suc, $rest[0]['id_sucursal']);

           }

       
           $array_suc = implode(",", $array_suc);

           $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$array_suc.") "; //ya

         }
         if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         
         if($cont_servicio > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_metodo_pago > 0){

              $select1 = $select1 . " and for_pgo_fac.id_forma_pago in (".$str_met_pag.") "; //ya

         }

    }else if($all_dks == 1){

         if($cont_suc == 0){

           $sucursales_actuales = $res_suc;
           $array_suc = [];

           foreach ($sucursales_actuales as $key => $value) {
            
              $id_sucursal = $value['id_sucursal'];
              
              $query = $this->db->query("SELECT id_sucursal FROM sucursales where id_sucursal = ".$id_sucursal);
              $rest = $query->result_array();
              array_push($array_suc, $rest[0]['id_sucursal']);

           }

       
           $array_suc = implode(",", $array_suc);

           $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$array_suc.") "; //ya

         }
         if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_metodo_pago > 0){

              $select1 = $select1 . " and for_pgo_fac.id_forma_pago in (".$str_met_pag.") "; //ya

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

  
    $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

   
    $select2 = $select2."

      and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
    
    ";

   $res = $db_prueba->query("SELECT * FROM rpv_usuarios_cliente where id_usuario = $id_usuario and status = 1");
   $res = $res->result_array();

   $res_suc = $db_prueba->query("SELECT * from rpv_perfil_sucursal WHERE id_perfil = $id_perfil and status = 1");
   $res_suc = $res_suc->result_array();

   if($all_dks == 0){

        if($cont_cliente == 0){  

              $id_cliente_arr = [];  
              foreach ($res as $clave => $valor) {  //obtiene clientes asignados

                 
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);
                 

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc == 0){

           $sucursales_actuales = $res_suc;
           $array_suc = [];

           foreach ($sucursales_actuales as $key => $value) {
            
              $id_sucursal = $value['id_sucursal'];
              
              $query = $this->db->query("SELECT id_sucursal FROM sucursales where id_sucursal = ".$id_sucursal);
              $rest = $query->result_array();
              array_push($array_suc, $rest[0]['id_sucursal']);

           }

       
           $array_suc = implode(",", $array_suc);

           $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$array_suc.") "; //ya

         }
         if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_servicio > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_metodo_pago > 0){

              $select2 = $select2 . " and NOTAS_CREDITO.id_forma_pago in (".$str_met_pag.") "; //ya

         }

    }else if($all_dks == 1){

         if($cont_suc == 0){

           $sucursales_actuales = $res_suc;
           $array_suc = [];

           foreach ($sucursales_actuales as $key => $value) {
            
              $id_sucursal = $value['id_sucursal'];
              
              $query = $this->db->query("SELECT id_sucursal FROM sucursales where id_sucursal = ".$id_sucursal);
              $rest = $query->result_array();
              array_push($array_suc, $rest[0]['id_sucursal']);

           }

       
           $array_suc = implode(",", $array_suc);

           $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$array_suc.") "; //ya

         }
         if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         } 
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select2 = $select2 . "and CLIENTES.id_cliente in (".$str_cli.") "; 

         }
         if($cont_servicio > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_metodo_pago > 0){

              $select2 = $select2 . " and NOTAS_CREDITO.id_forma_pago in (".$str_met_pag.") "; //ya

         }

    }

    $this->db->query($select1);


    $this->db->query($select2);

    $select3 = " select

      GVC_ID_SERIE,
      GVC_DOC_NUMERO,
      FECHA,
      GVC_NOM_CLI,
      analisis27_cliente,
      GVC_ID_CORPORATIVO,
      GVC_TOTAL,
      GVC_ID_SERVICIO,
      ID_FORMA_PAGO,
      c_FormaPago,
      GVC_RUTA,
      GVC_ID_PROVEEDOR,
      GVC_NOMBRE_PROVEEDOR,
      GVC_TARIFA,
      GVC_IVA,
      GVC_TUA,
      GVC_OTROS_IMPUESTOS,
      GVC_NOM_VEN_TIT,
      NUMERO_CUENTA,
      CONCEPTO,
      NUMERO_CUPON,
      NUMERO_BOLETO,
      GVC_DESCRIPCION_EXTENDIDA

    from #TEMPFAC as FAC where 
     not FAC.GVC_DOC_NUMERO = any(select distinct GVC_FAC_NUMERO from #TEMPNC)";
    
    $query_rows = $this->db->query($select3);

    $result = $query_rows->result_array();

    $this->db->query("drop table #TEMPFAC");
    $this->db->query("drop table #TEMPNC");
   
    return $result;

   }

   
  
}