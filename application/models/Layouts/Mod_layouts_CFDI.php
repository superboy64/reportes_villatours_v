<?php
set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');

class Mod_layouts_CFDI extends CI_Model {

    public function __construct(){
      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
   }
   
     function get_config_CFDI($ID_PROVEEDOR){

         $db_prueba = $this->load->database('conmysql', TRUE);
         
         $query = $db_prueba->query("select * from rpv_aereolineas_cfdi where id_aereolinea = '$ID_PROVEEDOR' and status = 1");

         //print_r("select * from rpv_aereolineas_cfdi where id_aereolinea = '$ID_PROVEEDOR' and status = 1");

         return $query->result();

     }
   
     function get_config_cliente_CFDI($id_cliente){

        $db_prueba = $this->load->database('conmysql', TRUE);
         
        $query = $db_prueba->query("select * from rpv_cliente_cfdi where id_cliente = '$id_cliente' and status = 1");

        return $query->result();

    }

    function get_config_aereolinea_CFDI($ID_PROVEEDOR){

          $db_prueba = $this->load->database('conmysql', TRUE);

          //print_r("select * from rpv_aereolineas_cfdi where id_aereolinea = '".$ID_PROVEEDOR."' and status = 1");

          $query = $db_prueba->query("select * from rpv_aereolineas_cfdi where id_aereolinea = '".$ID_PROVEEDOR."' and status = 1");


          return $query->result();

     }
   
     function lay_CFDI($parametros){
      
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
    
    analisis39_cliente varchar(500) null,
    confirmacion_la varchar(500) null,
    id_cliente varchar(500) null,
    GVC_DOC_NUMERO varchar(500) null,
    ID_PROVEEDOR varchar(500) null,
    BOLETO varchar(500) null,
    FECHA_EMISION_BOLETO varchar(500) null,
    IATA varchar(500) null,
    NOM_PAX varchar(500) null,
    rfc_cliente varchar(500) null,
    razon_social varchar(500) null,
    calle varchar(500) null,
    no_ext_cliente varchar(500) null,
    no_int_cliente varchar(500) null,
    colonia_cliente varchar(500) null,
    MUNICIPIO varchar(500) null,
    codigo_postal varchar(500) null,
    LOCALIDAD varchar(500) null,
    ESTADO varchar(500) null,
    PAIS varchar(500) null,
    ID_FORMA_PAGO varchar(500) null,
    MONTO_TOTAL varchar(500) null,
    USO_CFDI varchar(500) null

    )");
    

    $this->db->query("create table #TEMPNC(
   
    GVC_FAC_NUMERO varchar(500) null
    
    )");
    


     $select1 = "  insert into #TEMPFAC
    select 

      datos_factura.analisis39_cliente as analisis39_cliente,
      
      DETALLE_FACTURA.CLAVE_RESERVACION as confirmacion_la, 

      CLIENTES.id_cliente,

      DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO,   

      PROV_TPO_SERV.ID_PROVEEDOR,

      GVC_BOLETO=case when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then convert(varchar,DETALLE_FACTURA.numero_bol_Cxs) else convert(varchar,DETALLE_FACTURA.NUMERO_BOL) end, 

      GVC_FECHA_EMISION_BOLETO =  convert(char(12),convert(datetime,DATOS_FACTURA.FECHA),105), 
      
      IATA=case(DATOS_FACTURA.ID_SUCURSAL) when '2' then '86511574' when '3' then '86798003' when '4' then '86515984' when '5' then '86502194' else '86515973' end,  

      GVC_NOM_PAX=DETALLE_FACTURA.NOM_PASAJERO, 

      CLIENTES.rfc_cliente,

      razon_social = CLIENTES.nombre_cliente,

      calle = CLIENTES.calle_cliente,

      CLIENTES.no_ext_cliente,

      CLIENTES.no_int_cliente,

      CLIENTES.colonia_cliente,

      MUNICIPIO =  CLIENTES.id_ciudad,

      CLIENTES.codigo_postal,

      LOCALIDAD = CLIENTES.delegacion_cliente,

      ESTADO = CLIENTES.estado_cliente,

      PAIS = sat_paises.descripcion,

      ID_FORMA_PAGO = '',

      CASE WHEN PROV_TPO_SERV.ID_PROVEEDOR = 'NH' THEN (DETALLE_FACTURA.TARIFA_MON_BASE+(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
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
        IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA)) ELSE '' END AS MONTO_TOTAL,

      USO_CFDI = ''
     
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
      DBA.GDS_JUSTIFICACION_TARIFAS on GDS_VUELOS.CODIGO_RAZON = ID_JUSTIFICACION where
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

    $res = $db_prueba->query("SELECT * FROM rpv_cliente_cfdi where status = 1");
                            
    $res = $res->result_array();

      
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
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor == 0){

              /*if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea = 'AM'"; 
                   

              }else if($cat_provedor == 2){*/

                  $cat_prov = " and id_categoria_aereolinea = 2 and id_aereolinea <> 'AM'";

              //}

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select1 = $select1 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

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
         if($cont_provedor == 0){

              /*if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea = 'AM'"; 
                   

              }else if($cat_provedor == 2){*/

                  $cat_prov = " and id_categoria_aereolinea = 2 and id_aereolinea <> 'AM'";

              //}

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select1 = $select1 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



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

  
    $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

   
    $select2 = $select2."

      and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
    
    ";

   $res = $db_prueba->query("SELECT * FROM rpv_cliente_cfdi where status = 1");
                            
   $res = $res->result_array();

   if($all_dks == 0){

        if($cont_cliente == 0){  

           if($cont_cliente == 0){  

              $id_cliente_arr = [];

              foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                  
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

            }


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
         if($cont_provedor == 0){

              /*if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea = 'AM'"; 
                   

              }else if($cat_provedor == 2){*/

                  $cat_prov = " and id_categoria_aereolinea = 2 and id_aereolinea <> 'AM'";

              //}

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select2 = $select2 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

        if($cont_cliente == 0){  

           if($cont_cliente == 0){  

              $id_cliente_arr = [];

              foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                  
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

            }


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
         if($cont_provedor == 0){

              /*if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea = 'AM'"; 
                   

              }else if($cat_provedor == 2){*/

                  $cat_prov = " and id_categoria_aereolinea = 2 and id_aereolinea <> 'AM'";

              //}

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select2 = $select2 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $this->db->query($select1);


    $this->db->query($select2);

    $select3 = " select

      analisis39_cliente,
      confirmacion_la,
      id_cliente,
      GVC_DOC_NUMERO,
      ID_PROVEEDOR,
      BOLETO,
      FECHA_EMISION_BOLETO,
      IATA,
      NOM_PAX,
      rfc_cliente,
      razon_social,
      calle,
      no_ext_cliente,
      no_int_cliente,
      colonia_cliente,
      MUNICIPIO,
      codigo_postal,
      LOCALIDAD,
      ESTADO,
      PAIS,
      ID_FORMA_PAGO,
      MONTO_TOTAL,
      USO_CFDI

    from #TEMPFAC as FAC where 
     not FAC.GVC_DOC_NUMERO = any(select distinct GVC_FAC_NUMERO from #TEMPNC)";
    
    $query_rows = $this->db->query($select3);

    $result = $query_rows->result_array();

    $this->db->query("drop table #TEMPFAC");
    $this->db->query("drop table #TEMPNC");
   
    return $result;

   }

     function lay_CFDI_aereomexico($parametros){

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
    
    GVC_BOLETO varchar(500) null,
    analisis39_cliente varchar(500) null,
    confirmacion_la varchar(500) null,
    GVC_DOC_NUMERO  varchar(500) null,
    rfc_emisor varchar(500) null,
    razon_social varchar(500) null,
    IATA varchar(500) null,
    ID_PROVEEDOR varchar(500) null,
    GVC_NOMBRE_PROVEEDOR varchar(500) null,
    GVC_ID_SERIE varchar(500) null,
    id_serie_cxs varchar(500) null,
    fac_numero_cxs varchar(500) null,
    GVC_FECHA_EMISION_BOLETO varchar(500) null,
    GVC_TOTAL varchar(500) null,
    id_cliente varchar(500) null,
    nombre_cliente varchar(500) null,
    rfc_cliente varchar(500) null,
    calle varchar(500) null,
    no_ext_cliente varchar(500) null,
    no_int_cliente varchar(500) null,
    colonia_cliente varchar(500) null,
    MUNICIPIO varchar(500) null,
    CIUDAD varchar(500) null,
    ESTADO varchar(500) null,
    PAIS varchar(500) null,
    codigo_postal varchar(500) null,
    CORREO_ELECTRONICO varchar(500) null,
    comentarios varchar(500) null,
    GVC_NOM_PAX varchar(500) null,
    RUTA varchar(500) null,
    seguro_pasajero varchar(500) null,
    importe_seguro varchar(500) null,
    id_gds varchar(500) null,
    pseudocity_code varchar(500) null,
    pnr varchar(500) null,
    CLAVE_VENDEDOR varchar(500) null,
    aereo varchar(500) null,
    numero_viaje varchar(500) null,
    revisado  varchar(500) null,   
    bol_revisado  varchar(500) null,    
    solicita_fac_la varchar(500) null

    )");
    

    $this->db->query("create table #TEMPNC(
   
    GVC_FAC_NUMERO varchar(500) null
    
    )");
    


     $select1 = "  insert into #TEMPFAC
     select 

      GVC_BOLETO=case when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then convert(varchar,DETALLE_FACTURA.numero_bol_Cxs) else convert(varchar,DETALLE_FACTURA.NUMERO_BOL) end, 
      datos_factura.analisis39_cliente as analisis39_cliente,
      DETALLE_FACTURA.CLAVE_RESERVACION as confirmacion_la, 
      DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO,
      CLIENTES.rfc_cliente,
      razon_social = CLIENTES.nombre_cliente,
      IATA=case(DATOS_FACTURA.ID_SUCURSAL) when '2' then '86511574' when '3' then '86798003' when '4' then '86515984' when '5' then '86502194' else '86515973' end,  
      PROV_TPO_SERV.ID_PROVEEDOR,
      GVC_NOMBRE_PROVEEDOR=PROVEEDORES.NOMBRE,
      GVC_ID_SERIE=DATOS_FACTURA.ID_SERIE,
      DETALLE_FACTURA.id_serie_cxs,
      DETALLE_FACTURA.fac_numero_cxs,
      GVC_FECHA_EMISION_BOLETO=convert(char(12),convert(datetime,DATOS_FACTURA.FECHA),105),
      GVC_TOTAL=DETALLE_FACTURA.TARIFA_MON_BASE+(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
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
        IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA),
      datos_factura.id_cliente,
      nombre_cliente = CLIENTES.nombre_cliente,
      CLIENTES.rfc_cliente,
      calle = CLIENTES.calle_cliente,
      CLIENTES.no_ext_cliente,
      CLIENTES.no_int_cliente,
      CLIENTES.colonia_cliente,
      MUNICIPIO =  CLIENTES.id_ciudad,
      CIUDAD = CLIENTES.delegacion_cliente,
      ESTADO = CLIENTES.ESTADO_CLIENTE,
      PAIS = CLIENTES.PAIS_CLIENTE,
      CLIENTES.codigo_postal,
      CORREO_ELECTRONICO = CLIENTES.MAIL_CLIENTE,
      comentarios = '',
      GVC_NOM_PAX=DETALLE_FACTURA.NOM_PASAJERO,
      RUTA=DETALLE_FACTURA.CONCEPTO,
      DETALLE_FACTURA.seguro_pasajero,
      DETALLE_FACTURA.importe_seguro,
      id_gds  = gds_general.id_gds,
      pseudocity_code = gds_general.pseudocity_boletea,
      pnr = gds_general.record_localizador,
      CLAVE_VENDEDOR = DATOS_FACTURA.id_vendedor_tit,
      aereo = '1',
      numero_viaje = DATOS_FACTURA.analisis8_cliente,
      revisado = case when detalle_factura.emd = '' then 'N' else detalle_factura.emd end,    
      
      bol_revisado = case when detalle_factura.emd = 'S' then 

            (case when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then convert(varchar,DETALLE_FACTURA.numero_bol_Cxs) else convert(varchar,DETALLE_FACTURA.NUMERO_BOL) end)
      
      else '' end,     
      
      solicita_fac_la = '1'
     
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
      DBA.GDS_JUSTIFICACION_TARIFAS on GDS_VUELOS.CODIGO_RAZON = ID_JUSTIFICACION where
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

  

    $select1 = $select1." 
    and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
    ";

    $res = $db_prueba->query("SELECT * FROM rpv_cliente_cfdi where status = 1");
                            
    $res = $res->result_array();

      
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
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor == 0){

              //if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = 1 and id_aereolinea = 'AM'"; 
                   

              //}/*else if($cat_provedor == 2){

                  //$cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea <> 'AM'";

              //}

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select1 = $select1 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

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
         if($cont_provedor == 0){

              //if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = 1 and id_aereolinea = 'AM'"; 
                   

              /*}else if($cat_provedor == 2){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea <> 'AM'";

              }*/

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select1 = $select1 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



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

  

    $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

   

    $select2 = $select2."

      and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
    
    ";

   $res = $db_prueba->query("SELECT * FROM rpv_cliente_cfdi where status = 1");
                            
   $res = $res->result_array();

   if($all_dks == 0){

        if($cont_cliente == 0){  

           if($cont_cliente == 0){  

              $id_cliente_arr = [];

              foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                  
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

            }


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
         if($cont_provedor == 0){

              //if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = 1 and id_aereolinea = 'AM'"; 
                   

              /*}else if($cat_provedor == 2){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea <> 'AM'";

              }*/

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select2 = $select2 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

        if($cont_cliente == 0){  

           if($cont_cliente == 0){  

              $id_cliente_arr = [];

              foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                  
                  $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                  array_push($id_cliente_arr,$clientes_default);

              }

              $id_cliente_arr = implode(",", $id_cliente_arr);

              $select2 = $select2 . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

            }


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
         if($cont_provedor == 0){

              //if($cat_provedor == 1){

                  $cat_prov = " and id_categoria_aereolinea = 1 and id_aereolinea = 'AM'"; 
                   

              /*}else if($cat_provedor == 2){

                  $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' and id_aereolinea <> 'AM'";

              }*/

              $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_cfdi where status = 1 $cat_prov");
             
              $res_id_provedor = $res_id_provedor->result_array();

              $str_prov = '';
              foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                       $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                    }

              if(count($res_id_provedor) > 0){

                    $str_prov=explode(',', $str_prov);
                    $str_prov=array_filter($str_prov, "strlen");
                    $str_prov = implode(",", $str_prov);

                    $select2 = $select2 . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

              }else{


                    $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


              }
                        



         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $this->db->query($select1);


    $this->db->query($select2);

    $select3 = " select

      GVC_BOLETO,
      GVC_DOC_NUMERO,   
      rfc_cliente,
      razon_social,
      IATA,
      ID_PROVEEDOR,
      GVC_NOMBRE_PROVEEDOR,
      GVC_ID_SERIE,
      id_serie_cxs,
      fac_numero_cxs,
      GVC_FECHA_EMISION_BOLETO,
      GVC_TOTAL,
      id_cliente,
      nombre_cliente,
      rfc_cliente,
      calle,
      no_ext_cliente,
      no_int_cliente,
      colonia_cliente,
      MUNICIPIO,
      CIUDAD,
      ESTADO,
      PAIS,
      codigo_postal,
      CORREO_ELECTRONICO,
      comentarios,
      GVC_NOM_PAX,
      RUTA,
      seguro_pasajero,
      importe_seguro,
      id_gds,
      pseudocity_code,
      pnr,
      CLAVE_VENDEDOR,
      aereo,
      numero_viaje,
      revisado,
      bol_revisado,
      solicita_fac_la

    from #TEMPFAC as FAC where 
     not FAC.GVC_DOC_NUMERO = any(select distinct GVC_FAC_NUMERO from #TEMPNC)";
    
    $query_rows = $this->db->query($select3);

    $result = $query_rows->result_array();

    $this->db->query("drop table #TEMPFAC");
    $this->db->query("drop table #TEMPNC");
   
    return $result;



   }

  
}