<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '2000000M');

class Mod_layouts_amex extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
   }
   
   public function get_columns_excel($id_plantilla,$id_reporte){
         
         $db_prueba = $this->load->database('conmysql', TRUE);
         
         $query = $db_prueba->query('select * from rpv_reporte_columnas
                                      where id not in(
                                      select id_col from rpv_reporte_plantilla_columnas 
                                      where id_plantilla =
                                      '.$id_plantilla.' and rpv_reporte_plantilla_columnas.status = 1) and id_rep = '.$id_reporte.' ');

         return $query->result();

   }

   public function get_config_amex($id_prov_amex){

         $db_prueba = $this->load->database('conmysql', TRUE);
         
         $query = $db_prueba->query("select * from rpv_aereolineas_amex where id_aereolinea = '$id_prov_amex' and status = 1");

         return $query->result();

   }

   public function update_consecutivo($AMEX_CONSECUTIVO){
         
         $db_prueba = $this->load->database('conmysql', TRUE);
         
         $AMEX_CONSECUTIVO = (int)$AMEX_CONSECUTIVO;

         $AMEX_CONSECUTIVO = $AMEX_CONSECUTIVO + 1;

         $db_prueba->query("UPDATE rpv_consecutivo_amex SET consecutivo = '$AMEX_CONSECUTIVO' ");

   }

   public function get_consecutivo(){

        $db_prueba = $this->load->database('conmysql', TRUE);
         
        $query = $db_prueba->query("SELECT * FROM rpv_consecutivo_amex");

        return $query->result();


   }

   public function tarjetas_sybase($ids_cliente){

    $arr_ids_cliente = explode("_", $ids_cliente);

    $str_cli = '';

    foreach ($arr_ids_cliente as $clave => $valor) {  //obtiene clientes asignados

             $str_cli = $str_cli."'".$valor."',";

          }

    $str_cli=explode(',', $str_cli);
    $str_cli=array_filter($str_cli, "strlen");

    if(count($str_cli) > 0){

      $str_cli = implode(",", $str_cli);

      $select = " 
                    SELECT 

                    DISTINCT
                    datos_facturA.id_cliente,
                    for_pgo_fac.concepto
                         
                    FROM  dba.datos_factura

                    LEFT OUTER JOIN dba.for_pgo_fac 
                    ON datos_factura.id_sucursal = for_pgo_fac.id_sucursal 
                    AND datos_factura.id_serie = for_pgo_fac.id_serie 
                    AND datos_factura.fac_numero = for_pgo_fac.fac_numero 

                    WHERE 

                    datos_factura.id_stat = 1 
                    AND NOT dba.datos_factura.id_serie = ANY (SELECT id_serie 
                                                             FROM   dba.gds_cxs 
                                                             WHERE  en_otra_serie = 'A')

                    AND datos_factura.id_cliente IN (".$str_cli.") and for_pgo_fac.id_forma_pago in ('AX','AXS') 

                    "; //ya

       $query_rows = $this->db->query($select);

       $result = $query_rows->result();

    }else{

       $result = [];

    }
   

    return $result;

   }

   public function tarjetas_local($ids_cliente){

    $arr_ids_cliente = explode("_", $ids_cliente);

    $str_cli = '';

    foreach ($arr_ids_cliente as $clave => $valor) {  //obtiene clientes asignados

             $str_cli = $str_cli."'".$valor."',";

          }

    $str_cli=explode(',', $str_cli);
    $str_cli=array_filter($str_cli, "strlen");
    $str_cli = implode(",", $str_cli);

    $db_prueba = $this->load->database('conmysql', TRUE);
    
    $query_rows = $db_prueba->query('SELECT * FROM rpv_cliente_tarjeta where id_cliente in ('.$str_cli.') and status = 1');
    
    $result = $query_rows->result_array();

    return $result;  

   }


   public function lay_amex($parametros,$cat_provedor){

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
      $id_plantilla = $parametros["id_plantilla"];
      
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

        $str_cli = '';

        foreach ($ids_cliente as $clave => $valor) {  //obtiene clientes asignados

                 $str_cli = $str_cli."'".$valor."',";

              }

        $str_cli=explode(',', $str_cli);
        $str_cli=array_filter($str_cli, "strlen");
        $str_cli = implode(",", $str_cli);


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
      
      $array_fecha1 = explode('/', $fecha1);
      $fecha_gen_1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

      $array_fecha1 = explode('/', $fecha1);
      $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0]; //week

      $array_fecha2 = explode('/', $fecha2);
      $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];


                    $db_prueba = $this->load->database('conmysql', TRUE);
                    
                    $us = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_usuarios where id = $id_usuario");
                    $us = $us->result_array();

                    $all_dks = $us[0]['all_dks'];
                    
                    
                    if($id_intervalo != 0){  //si es diferente es un proceso automatico

                         $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$parametros["fecha1"],$parametros["fecha2"]);

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
                         
                        }


                    }

                  //**Definicion de variables dinamicas para ordenamiento de campos**

                  $array_campos_query_fc['AMEX_analisis39_cliente'] = 'datos_factura.analisis39_cliente as AMEX_analisis39_cliente';
                  $array_campos_query_fc['AMEX_confirmacion_la'] = 'DETALLE_FACTURA.CLAVE_RESERVACION as AMEX_confirmacion_la';
                  $array_campos_query_fc['AMEX_TIPO'] = "'FC' AS AMEX_TIPO";
                  $array_campos_query_fc['AMEX_ID_SERV'] = "PROV_TPO_SERV.ID_SERVICIO AS AMEX_ID_SERV";
                  $array_campos_query_fc['AMEX_5555'] = "'5555' AS AMEX_5555";
                  $array_campos_query_fc['AMEX_CVE_AMEX'] = "for_pgo_fac.concepto AS AMEX_CVE_AMEX";
                  $array_campos_query_fc['AMEX_EMPTY1'] = "'' as AMEX_EMPTY1";
                  $array_campos_query_fc['AMEX_EMPTY2'] = "'' as AMEX_EMPTY2";
                  $array_campos_query_fc['AMEX_EMPTY3'] = "'' as AMEX_EMPTY3";
                  $array_campos_query_fc['AMEX_CODIGO_BSP'] = "'' as AMEX_CODIGO_BSP";
                  $array_campos_query_fc['AMEX_BOLETO'] = "case when ( PROV_TPO_SERV.ID_SERVICIO = 'CS' or prov_tpo_serv.id_servicio = 'CSE' or prov_tpo_serv.id_servicio = 'CSFE' or prov_tpo_serv.id_servicio = 'CSFAU'or prov_tpo_serv.id_servicio = 'CSFEX'or prov_tpo_serv.id_servicio = 'CSFHI'or prov_tpo_serv.id_servicio = 'CSFHN'or prov_tpo_serv.id_servicio = 'CSFHX'or prov_tpo_serv.id_servicio = 'CSFLC'or prov_tpo_serv.id_servicio = 'CSFRH'or prov_tpo_serv.id_servicio = 'CSFRV'or prov_tpo_serv.id_servicio = 'CSFVI'or prov_tpo_serv.id_servicio = 'CSFVN'or prov_tpo_serv.id_servicio = 'CSOA'or prov_tpo_serv.id_servicio = 'CSOEX'or prov_tpo_serv.id_servicio = 'CSOHI'or prov_tpo_serv.id_servicio = 'CSOHN'or prov_tpo_serv.id_servicio = 'CSOHX'or prov_tpo_serv.id_servicio = 'CSOLC'or prov_tpo_serv.id_servicio = 'CSORH'or prov_tpo_serv.id_servicio = 'CSORV'or prov_tpo_serv.id_servicio = 'CSOVI'or prov_tpo_serv.id_servicio = 'CSOVN'or prov_tpo_serv.id_servicio = 'CSSS'or prov_tpo_serv.id_servicio = 'CSVIP'or prov_tpo_serv.id_servicio = 'CSVIS'or prov_tpo_serv.id_servicio = 'CSSIVA'or prov_tpo_serv.id_servicio = 'CUPONHTL'or prov_tpo_serv.id_servicio = 'FCRU15'or prov_tpo_serv.id_servicio = 'FCRUT0'or prov_tpo_serv.id_servicio = 'FH0T15'or prov_tpo_serv.id_servicio = 'FHOTT0'or prov_tpo_serv.id_servicio = 'FPCH15'or prov_tpo_serv.id_servicio = 'FPCHT0'or prov_tpo_serv.id_servicio = 'FPGR15'or prov_tpo_serv.id_servicio = 'FPGRT0'or prov_tpo_serv.id_servicio = 'FRAU15'or prov_tpo_serv.id_servicio = 'FRAUT0'or prov_tpo_serv.id_servicio = 'FSES15'or prov_tpo_serv.id_servicio = 'FSEST0'or prov_tpo_serv.id_servicio = 'FTRA15'or prov_tpo_serv.id_servicio = 'FTRAT0'or prov_tpo_serv.id_servicio = 'GINGCH'or prov_tpo_serv.id_servicio = 'GINGCH-0'or prov_tpo_serv.id_servicio = 'GINGCR'or prov_tpo_serv.id_servicio = 'GINGCR-0'or prov_tpo_serv.id_servicio = 'GINGCS'or prov_tpo_serv.id_servicio = 'GINGCS-0'or prov_tpo_serv.id_servicio = 'GINGRA'or prov_tpo_serv.id_servicio = 'GINGRA-0'or prov_tpo_serv.id_servicio = 'GINGRH'or prov_tpo_serv.id_servicio = 'GINGRH-0'or prov_tpo_serv.id_servicio = 'GINGSE'or prov_tpo_serv.id_servicio = 'GINGSE-0'or prov_tpo_serv.id_servicio = 'GINGTA'or prov_tpo_serv.id_servicio = 'GINGTA-0'or prov_tpo_serv.id_servicio = 'INGBUS'or prov_tpo_serv.id_servicio = 'INGCSG'or prov_tpo_serv.id_servicio = 'INGXAH'or prov_tpo_serv.id_servicio = 'TRONDEN'
                ) then  DETALLE_FACTURA.numero_bol_Cxs else DETALLE_FACTURA.NUMERO_BOL  end as AMEX_BOLETO";
                  $array_campos_query_fc['AMEX_CERO'] = "0 as AMEX_CERO";
                  $array_campos_query_fc['AMEX_EMPTY4'] = "'' as AMEX_EMPTY4";
                  $array_campos_query_fc['AMEX_NOM_PAX'] = "DETALLE_FACTURA.NOM_PASAJERO as AMEX_NOM_PAX";
                  $array_campos_query_fc['AMEX_CONCEPTO'] = "DETALLE_FACTURA.CONCEPTO as AMEX_CONCEPTO";
                  $array_campos_query_fc['AMEX_FECHA_SALIDA'] = "CONVERT(CHAR(12), CONVERT(DATETIME,    case when (concecutivo_boletos.fecha_sal is null ) then detalle_factura.fecha_mod else concecutivo_boletos.fecha_sal  end ), 105) 
                    as AMEX_FECHA_SALIDA";/*"convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as AMEX_FECHA_SALIDA";*/
                  $array_campos_query_fc['AMEX_EMPTY5'] = "'' as AMEX_EMPTY5";
                  $array_campos_query_fc['AMEX_EMPTY6'] = "'' as AMEX_EMPTY6";
                  $array_campos_query_fc['AMEX_STATUS'] = "'D' as AMEX_STATUS";
                  $array_campos_query_fc['AMEX_A'] = "'A' as AMEX_A";
                  $array_campos_query_fc['AMEX_FAC_NUMERO'] = "DATOS_FACTURA.FAC_NUMERO as AMEX_FAC_NUMERO";
                  $array_campos_query_fc['AMEX_ID_PROVEEDOR'] = "PROV_TPO_SERV.ID_PROVEEDOR as AMEX_ID_PROVEEDOR";
                  $array_campos_query_fc['AMEX_TOTAL_0'] = "'000000' as AMEX_TOTAL_0";
                  $array_campos_query_fc['AMEX_EMPTY7'] = "'' as AMEX_EMPTY7";
                  $array_campos_query_fc['AMEX_EMPTY8'] = "'' as AMEX_EMPTY8";
                  $array_campos_query_fc['AMEX_EMPTY9'] = "'' as AMEX_EMPTY9";
                  $array_campos_query_fc['AMEX_CONCEPTO2'] = "DETALLE_FACTURA.CONCEPTO as AMEX_CONCEPTO2";
                  $array_campos_query_fc['AMEX_CLA_PAX'] = "DETALLE_FACTURA.cla_pax as AMEX_CLA_PAX";
                  $array_campos_query_fc['AMEX_EMPTY10'] = "'' as AMEX_EMPTY10";
                  $array_campos_query_fc['AMEX_TUA'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as AMEX_TUA";
                  $array_campos_query_fc['AMEX_IVA'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as AMEX_IVA";

                  $array_campos_query_fc['AMEX_OTROS_IMPUESTOS'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as AMEX_OTROS_IMPUESTOS";
                  
                  $array_campos_query_fc['AMEX_EMPTY11'] = "'' as AMEX_EMPTY11";
                  $array_campos_query_fc['AMEX_EMPTY12'] = "'' as AMEX_EMPTY12";
                  $array_campos_query_fc['AMEX_FECHA_EMISION'] = "CONVERT(CHAR(12), CONVERT(DATETIME,    case when (concecutivo_boletos.fecha_sal is null ) then detalle_factura.fecha_mod else concecutivo_boletos.fecha_sal  end ), 105)  as AMEX_FECHA_EMISION"/*"case when (prov_tpo_serv.id_servicio = 'CS') THEN  (select top 1 dateadd(dd, 1, fecha_emi) as fecha_emi from concecutivo_boletos where numero_bol = detalle_factura.numero_bol_cxs) else concecutivo_boletos.fecha_emi end
                     AS AMEX_FECHA_EMISION"*/;
                  $array_campos_query_fc['AMEX_STATUS2'] = "'S' as AMEX_STATUS2";
                  $array_campos_query_fc['AMEX_EMPTY13'] = "'' as AMEX_EMPTY13";
                  $array_campos_query_fc['AMEX_EMPTY14'] = "'' as AMEX_EMPTY14";
                  $array_campos_query_fc['AMEX_EMPTY15'] = "'' as AMEX_EMPTY15";
                  $array_campos_query_fc['AMEX_EMPTY16'] = "'' as AMEX_EMPTY16";
                  $array_campos_query_fc['AMEX_EMPTY17'] = "'' as AMEX_EMPTY17";
                  $array_campos_query_fc['AMEX_EMPTY18'] = "'' as AMEX_EMPTY18";
                  $array_campos_query_fc['AMEX_EMPTY19'] = "'' as AMEX_EMPTY19";

                  $array_campos_query_fc['AMEX_NOM_CENCO'] = " DATOS_FACTURA.ID_CENTRO_COSTO as AMEX_NOM_CENCO";

                  $array_campos_query_fc['AMEX_EMPTY20'] = "'' as AMEX_EMPTY20";

                  $array_campos_query_fc['AMEX_IVA2'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as AMEX_IVA2";

                  $array_campos_query_fc['AMEX_EMPTY21'] = "'' as AMEX_EMPTY21";
                  $array_campos_query_fc['AMEX_EMPTY22'] = "'' as AMEX_EMPTY22";
                  $array_campos_query_fc['AMEX_EMPTY23'] = "'' as AMEX_EMPTY23";
                  $array_campos_query_fc['AMEX_EMPTY24'] = "'' as AMEX_EMPTY24";
                  $array_campos_query_fc['AMEX_EMPTY25'] = "'' as AMEX_EMPTY25";
                  $array_campos_query_fc['AMEX_EMPTY26'] = "'' as AMEX_EMPTY26";
                  $array_campos_query_fc['AMEX_TARIFA_MON_BASE'] = "DETALLE_FACTURA.TARIFA_MON_BASE AS AMEX_TARIFA_MON_BASE";
                  $array_campos_query_fc['AMEX_TOTAL'] = "
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
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as AMEX_TOTAL";

                  $array_campos_query_fc['AMEX_EMPTY27'] = "'' as AMEX_EMPTY27";
                  $array_campos_query_fc['AMEX_EMPTY28'] = "'' as AMEX_EMPTY28";
                  $array_campos_query_fc['AMEX_EMPTY29'] = "'' as AMEX_EMPTY29";
                  $array_campos_query_fc['AMEX_EMPTY30'] = "'' as AMEX_EMPTY30";
                  $array_campos_query_fc['AMEX_EMPTY31'] = "'' as AMEX_EMPTY31";

                  //*****************************************************************

                  $str_campos_query_fc="";

                  $cont = 1;
                  $cont_total = count($array_campos_query_fc);

                  foreach ($array_campos_query_fc as $clave2 => $valor2) {  

                        if($cont_total == $cont){

                          $str_campos_query_fc = $str_campos_query_fc . $valor2;

                        }else{

                          $str_campos_query_fc = $str_campos_query_fc . $valor2 . ',';

                          $cont++;

                        } 

                        
                  }

                  $select = " select distinct ".$str_campos_query_fc."
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
                  DBA.GDS_GENERAL on GDS_GENERAL.CONSECUTIVO = DATOS_FACTURA.CONSECUTIVO left outer join
                  DBA.GDS_JUSTIFICACION_TARIFAS on GDS_VUELOS.CODIGO_RAZON = ID_JUSTIFICACION 
                  /******************************************************/
                    LEFT OUTER JOIN dba.for_pgo_fac ON
                    
                    DATOS_FACTURA.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
                    
                    DATOS_FACTURA.ID_SERIE = for_pgo_fac.id_serie AND

                    DATOS_FACTURA.FAC_NUMERO  = for_pgo_fac.fac_numero 
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
                  not DBA.DATOS_FACTURA.ID_SERIE = any(select ID_SERIE from DBA.GDS_CXS where EN_OTRA_SERIE = 'A')";

                  if($id_intervalo == '5'){

                    $condicion_fecha = 'DATOS_FACTURA.fecha_folio';

                  }else{

                    $condicion_fecha = 'DATOS_FACTURA.FECHA';

                  }
                  
                  /*************************************************/

                  $res = $db_prueba->query("SELECT * FROM rpv_cliente_tarjeta where status = 1");
                            
                  $res = $res->result_array();

                  $str_tarjeta = '';
                  $str_tarjeta_ax = '';

                  foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                      
                      $tarjetas_default = $valor['tarjeta'];

                      $str_tarjeta = $str_tarjeta."'".$tarjetas_default."',";

                  }

                  foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                      
                      $tarjetas_default = 'AX'.$valor['tarjeta'];

                      $str_tarjeta_ax = $str_tarjeta_ax."'".$tarjetas_default."',";

                  }

                  $str_tarjeta=explode(',', $str_tarjeta);
                  $str_tarjeta=array_filter($str_tarjeta, "strlen");
                  $str_tarjeta = implode(",", $str_tarjeta);

                  $str_tarjeta_ax=explode(',', $str_tarjeta_ax);
                  $str_tarjeta_ax=array_filter($str_tarjeta_ax, "strlen");
                  $str_tarjeta_ax = implode(",", $str_tarjeta_ax);

                  /*************************************************/

                  $select = $select." 
                  and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
                  and (ltrim(rtrim(for_pgo_fac.concepto)) in (".$str_tarjeta.") or ltrim(rtrim(for_pgo_fac.concepto)) in (".$str_tarjeta_ax.") ) and for_pgo_fac.id_forma_pago in ('AX','AXS')
                  ";

                  if($all_dks == 0){

                      if($cont_cliente == 0){  

                            $id_cliente_arr = [];

                            foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                                
                                $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                                array_push($id_cliente_arr,$clientes_default);

                            }

                            $id_cliente_arr = implode(",", $id_cliente_arr);

                            $select = $select . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

                       }
                       if($cont_cliente > 0){

                            $select = $select . "and CLIENTES.id_cliente in (".$str_cli.") "; 


                       }
                       if($cont_corporativo > 0){  //ya

                            $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

                       }
                       if($cont_serie > 0){  //ya

                            $select = $select . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

                       }
                       if($cont_servicio > 0){

                            $select = $select . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

                       }
                       if($cont_provedor == 0){

                            if($cat_provedor != 0){

                                $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' "; 

                            }else{

                                $cat_prov = "";

                            }

                            $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_amex where status = 1 $cat_prov");
                           
                            $res_id_provedor = $res_id_provedor->result_array();

                            $str_prov = '';
                            foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                                     $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                                  }

                            if(count($res_id_provedor) > 0){

                                  $str_prov=explode(',', $str_prov);
                                  $str_prov=array_filter($str_prov, "strlen");
                                  $str_prov = implode(",", $str_prov);

                                  $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                            }else{


                                  $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


                            }
                                      
        


                       }
                       if($cont_provedor > 0){

                            $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                       }
                       

                  }else if($all_dks == 1){

                      if($cont_cliente == 0){  

                         $res = $db_prueba->query("SELECT * FROM rpv_cliente_tarjeta where status = 1");
                            
                            $res = $res->result_array();
                            $id_cliente_arr = [];

                            foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                                
                                $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                                array_push($id_cliente_arr,$clientes_default);

                            }

                            $id_cliente_arr = implode(",", $id_cliente_arr);

                            $select = $select . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

                       }

                      if($cont_cliente > 0){

                            $select = $select . "and DATOS_FACTURA.ID_CLIENTE in (".$str_cli.") "; 


                       }
                       if($cont_corporativo > 0){  //ya

                            $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

                       }
                       if($cont_serie > 0){  //ya

                            $select = $select . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

                       }
                       if($cont_servicio > 0){

                            $select = $select . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

                       }
                       if($cont_provedor == 0){

                            if($cat_provedor != 0){

                                $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' "; 

                            }else{

                                $cat_prov = "";

                            }

                            $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_amex where status = 1 $cat_prov");
                            $res_id_provedor = $res_id_provedor->result_array();

                            $str_prov = '';
                            foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados


                                     $str_prov = $str_prov."'".$valor['id_aereolinea']."',";


                                  }

                            if(count($res_id_provedor) > 0){
                                  
                                  $str_prov=explode(',', $str_prov);
                                  $str_prov=array_filter($str_prov, "strlen");
                                  $str_prov = implode(",", $str_prov);

                                  $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya
                                  
                            }else{

                                  $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya

                            }        

                       }
                       if($cont_provedor > 0){

                            $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                       }

                  }
                  
                  $array_campos_query_nc['AMEX_analisis39_cliente'] = 'notas_credito.analisis39_cliente as AMEX_analisis39_cliente';
                  $array_campos_query_nc['AMEX_confirmacion_la'] = 'DETALLE_NC.CLAVE_RESERVACION as AMEX_confirmacion_la';
                  $array_campos_query_nc['AMEX_TIPO'] = "'NC' AS AMEX_TIPO";
                  $array_campos_query_nc['AMEX_ID_SERV'] = "PROV_TPO_SERV.ID_SERVICIO AS AMEX_ID_SERV";
                  $array_campos_query_nc['AMEX_5555'] = "'5555' AS AMEX_5555";
                  $array_campos_query_nc['AMEX_CVE_AMEX'] = "for_pgo_fac.concepto AS AMEX_CVE_AMEX";
                  $array_campos_query_nc['AMEX_EMPTY1'] = "'' as AMEX_EMPTY1";
                  $array_campos_query_nc['AMEX_EMPTY2'] = "'' as AMEX_EMPTY2";
                  $array_campos_query_nc['AMEX_EMPTY3'] = "'' as AMEX_EMPTY3";
                  $array_campos_query_nc['AMEX_CODIGO_BSP'] = "'' as AMEX_CODIGO_BSP";
                  $array_campos_query_nc['AMEX_BOLETO'] = "case when (PROV_TPO_SERV.ID_SERVICIO = 'CS' or prov_tpo_serv.id_servicio = 'CSE' or prov_tpo_serv.id_servicio = 'CSFE' or prov_tpo_serv.id_servicio = 'CSFAU'or prov_tpo_serv.id_servicio = 'CSFEX'or prov_tpo_serv.id_servicio = 'CSFHI'or prov_tpo_serv.id_servicio = 'CSFHN'or prov_tpo_serv.id_servicio = 'CSFHX'or prov_tpo_serv.id_servicio = 'CSFLC'or prov_tpo_serv.id_servicio = 'CSFRH'or prov_tpo_serv.id_servicio = 'CSFRV'or prov_tpo_serv.id_servicio = 'CSFVI'or prov_tpo_serv.id_servicio = 'CSFVN'or prov_tpo_serv.id_servicio = 'CSOA'or prov_tpo_serv.id_servicio = 'CSOEX'or prov_tpo_serv.id_servicio = 'CSOHI'or prov_tpo_serv.id_servicio = 'CSOHN'or prov_tpo_serv.id_servicio = 'CSOHX'or prov_tpo_serv.id_servicio = 'CSOLC'or prov_tpo_serv.id_servicio = 'CSORH'or prov_tpo_serv.id_servicio = 'CSORV'or prov_tpo_serv.id_servicio = 'CSOVI'or prov_tpo_serv.id_servicio = 'CSOVN'or prov_tpo_serv.id_servicio = 'CSSS'or prov_tpo_serv.id_servicio = 'CSVIP'or prov_tpo_serv.id_servicio = 'CSVIS'or prov_tpo_serv.id_servicio = 'CSSIVA'or prov_tpo_serv.id_servicio = 'CUPONHTL'or prov_tpo_serv.id_servicio = 'FCRU15'or prov_tpo_serv.id_servicio = 'FCRUT0'or prov_tpo_serv.id_servicio = 'FH0T15'or prov_tpo_serv.id_servicio = 'FHOTT0'or prov_tpo_serv.id_servicio = 'FPCH15'or prov_tpo_serv.id_servicio = 'FPCHT0'or prov_tpo_serv.id_servicio = 'FPGR15'or prov_tpo_serv.id_servicio = 'FPGRT0'or prov_tpo_serv.id_servicio = 'FRAU15'or prov_tpo_serv.id_servicio = 'FRAUT0'or prov_tpo_serv.id_servicio = 'FSES15'or prov_tpo_serv.id_servicio = 'FSEST0'or prov_tpo_serv.id_servicio = 'FTRA15'or prov_tpo_serv.id_servicio = 'FTRAT0'or prov_tpo_serv.id_servicio = 'GINGCH'or prov_tpo_serv.id_servicio = 'GINGCH-0'or prov_tpo_serv.id_servicio = 'GINGCR'or prov_tpo_serv.id_servicio = 'GINGCR-0'or prov_tpo_serv.id_servicio = 'GINGCS'or prov_tpo_serv.id_servicio = 'GINGCS-0'or prov_tpo_serv.id_servicio = 'GINGRA'or prov_tpo_serv.id_servicio = 'GINGRA-0'or prov_tpo_serv.id_servicio = 'GINGRH'or prov_tpo_serv.id_servicio = 'GINGRH-0'or prov_tpo_serv.id_servicio = 'GINGSE'or prov_tpo_serv.id_servicio = 'GINGSE-0'or prov_tpo_serv.id_servicio = 'GINGTA'or prov_tpo_serv.id_servicio = 'GINGTA-0'or prov_tpo_serv.id_servicio = 'INGBUS'or prov_tpo_serv.id_servicio = 'INGCSG'or prov_tpo_serv.id_servicio = 'INGXAH'or prov_tpo_serv.id_servicio = 'TRONDEN') then (select detalle_factura.numero_bol from datos_factura

                    inner join gds_general on gds_general.consecutivo = datos_factura.consecutivo and gds_general.id_cliente = NOTAS_CREDITO.ID_CLIENTE
                    inner join detalle_factura on detalle_factura.fac_numero = gds_general.fac_numero /*and detalle_factura.fac_numero_cxs = NOTAS_CREDITO.FAC_NUMERO*/ and detalle_factura.id_serie_cxs = NOTAS_CREDITO.ID_SERIE_FAC
                    
                    where datos_factura.fac_numero = NOTAS_CREDITO.FAC_NUMERO and datos_factura.id_cliente = NOTAS_CREDITO.ID_CLIENTE) else detalle_nc.det_nc_num_bol end

                    AS AMEX_BOLETO";
                  $array_campos_query_nc['AMEX_CERO'] = "0 as AMEX_CERO";
                  $array_campos_query_nc['AMEX_EMPTY4'] = "'' as AMEX_EMPTY4";
                  $array_campos_query_nc['AMEX_NOM_PAX'] = "DETALLE_NC.DET_NC_NOM_PAS as AMEX_NOM_PAX";
                  $array_campos_query_nc['AMEX_CONCEPTO'] = "DETALLE_NC.DET_NC_CONCEPTO as AMEX_CONCEPTO";
                  $array_campos_query_nc['AMEX_FECHA_SALIDA'] = "CONVERT(CHAR(12), CONVERT(DATETIME,    case when (concecutivo_boletos.fecha_sal is null ) then detalle_nc.fecha_mod else concecutivo_boletos.fecha_sal  end ), 105) 
                    AS 
                    AMEX_FECHA_SALIDA";/*"convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as AMEX_FECHA_SALIDA";*/
                  $array_campos_query_nc['AMEX_EMPTY5'] = "'' as AMEX_EMPTY5";
                  $array_campos_query_nc['AMEX_EMPTY6'] = "'' as AMEX_EMPTY6";
                  $array_campos_query_nc['AMEX_STATUS'] = "'C' as AMEX_STATUS";
                  $array_campos_query_nc['AMEX_A'] = "'A' as AMEX_A";
                  $array_campos_query_nc['AMEX_FAC_NUMERO'] = "NOTAS_CREDITO.nc_numero as AMEX_FAC_NUMERO";
                  $array_campos_query_nc['AMEX_ID_PROVEEDOR'] = "PROV_TPO_SERV.ID_PROVEEDOR as AMEX_ID_PROVEEDOR";
                  $array_campos_query_nc['AMEX_TOTAL_0'] = "'000000' as AMEX_TOTAL_0";
                  $array_campos_query_nc['AMEX_EMPTY7'] = "'' as AMEX_EMPTY7";
                  $array_campos_query_nc['AMEX_EMPTY8'] = "'' as AMEX_EMPTY8";
                  $array_campos_query_nc['AMEX_EMPTY9'] = "'' as AMEX_EMPTY9";
                  $array_campos_query_nc['AMEX_CONCEPTO2'] = "DETALLE_NC.DET_NC_CONCEPTO as AMEX_CONCEPTO2";
                  $array_campos_query_nc['AMEX_CLA_PAX'] = "DETALLE_NC.cla_pax as AMEX_CLA_PAX";
                  $array_campos_query_nc['AMEX_EMPTY10'] = "'' as AMEX_EMPTY10";
                  
                  $array_campos_query_nc['AMEX_TUA'] = "(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC) as AMEX_TUA";

                  $array_campos_query_nc['AMEX_IVA'] = "(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC) as AMEX_IVA";


                  $array_campos_query_nc['AMEX_OTROS_IMPUESTOS'] = "CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as AMEX_OTROS_IMPUESTOS";


                  $array_campos_query_nc['AMEX_EMPTY11'] = "'' as AMEX_EMPTY11";
                  $array_campos_query_nc['AMEX_EMPTY12'] = "'' as AMEX_EMPTY12";
                  $array_campos_query_nc['AMEX_FECHA_EMISION'] = "CONVERT(CHAR(12), CONVERT(DATETIME,    case when (concecutivo_boletos.fecha_sal is null ) then detalle_nc.fecha_mod else concecutivo_boletos.fecha_sal  end ), 105)  as AMEX_FECHA_EMISION" /*"case when (prov_tpo_serv.id_servicio = 'CS') THEN  (select top 1 dateadd(dd, 1, fecha_emi) as fecha_emi from concecutivo_boletos where numero_bol = DETALLE_NC.det_nc_num_bol) else concecutivo_boletos.fecha_emi end
                     AS AMEX_FECHA_EMISION"*/;
                  $array_campos_query_nc['AMEX_STATUS2'] = "'SR' as AMEX_STATUS2";
                  $array_campos_query_nc['AMEX_EMPTY13'] = "'' as AMEX_EMPTY13";
                  $array_campos_query_nc['AMEX_EMPTY14'] = "'' as AMEX_EMPTY14";
                  $array_campos_query_nc['AMEX_EMPTY15'] = "'' as AMEX_EMPTY15";
                  $array_campos_query_nc['AMEX_EMPTY16'] = "'' as AMEX_EMPTY16";
                  $array_campos_query_nc['AMEX_EMPTY17'] = "'' as AMEX_EMPTY17";
                  $array_campos_query_nc['AMEX_EMPTY18'] = "'' as AMEX_EMPTY18";
                  $array_campos_query_nc['AMEX_EMPTY19'] = "'' as AMEX_EMPTY19";
                  $array_campos_query_nc['AMEX_NOM_CENCO'] = "NOTAS_CREDITO.ID_CENCOS as AMEX_NOM_CENCO";
                  $array_campos_query_nc['AMEX_EMPTY20'] = "'' as AMEX_EMPTY20";

                  $array_campos_query_nc['AMEX_IVA2'] = "(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC) as AMEX_IVA2";

                  $array_campos_query_nc['AMEX_EMPTY21'] = "'' as AMEX_EMPTY21";
                  $array_campos_query_nc['AMEX_EMPTY22'] = "'' as AMEX_EMPTY22";
                  $array_campos_query_nc['AMEX_EMPTY23'] = "'' as AMEX_EMPTY23";
                  $array_campos_query_nc['AMEX_EMPTY24'] = "'' as AMEX_EMPTY24";
                  $array_campos_query_nc['AMEX_EMPTY25'] = "'' as AMEX_EMPTY25";
                  $array_campos_query_nc['AMEX_EMPTY26'] = "'' as AMEX_EMPTY26";
                  $array_campos_query_nc['AMEX_TARIFA_MON_BASE'] = "CONVERT(varchar,DETALLE_NC.DET_NC_TAR_MN) as AMEX_TARIFA_MON_BASE";
                  $array_campos_query_nc['AMEX_TOTAL'] = "
                  CONVERT(varchar,
                  convert(varchar,DETALLE_NC.DET_NC_TAR_MN)+(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
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
                    IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as AMEX_TOTAL";
                  $array_campos_query_nc['AMEX_EMPTY27'] = "'' as AMEX_EMPTY27";
                  $array_campos_query_nc['AMEX_EMPTY28'] = "'' as AMEX_EMPTY28";
                  $array_campos_query_nc['AMEX_EMPTY29'] = "'' as AMEX_EMPTY29";
                  $array_campos_query_nc['AMEX_EMPTY30'] = "'' as AMEX_EMPTY30";
                  $array_campos_query_nc['AMEX_EMPTY31'] = "'' as AMEX_EMPTY31";
                 
                  $str_campos_query_nc="";

                  //if($id_plantilla == 0){

                      $cont = 1;
                      $cont_total = count($array_campos_query_nc);

                      foreach ($array_campos_query_nc as $clave2 => $valor2) {  

                            if($cont_total == $cont){

                             $str_campos_query_nc = $str_campos_query_nc . $valor2;

                            }else{

                              $str_campos_query_nc = $str_campos_query_nc . $valor2 . ',';
                              $cont++;
                              

                            } 
                        
                            
                           
                      }

                  $select = $select ."union ALL select distinct ".$str_campos_query_nc."
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
                  NOTAS_CREDITO.ID_SUCURSAL_FAC = SUC_FAC.ID_SUCURSAL 
                  /******************************************************/  
                    LEFT OUTER JOIN dba.for_pgo_fac ON
                    
                    NOTAS_CREDITO.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
                    
                    NOTAS_CREDITO.ID_SERIE_FAC = for_pgo_fac.id_serie AND

                    NOTAS_CREDITO.FAC_NUMERO  = for_pgo_fac.fac_numero 
                  /******************************************************/ 
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
                  PROV_TPO_SERV.ID_SERVICIO = TIPO_SERVICIO.ID_TIPO_SERVICIO";
                  
                  if($id_intervalo == '5'){

                    $condicion_fecha = 'NOTAS_CREDITO.FECHA_FOLIO';

                  }else{

                    $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

                  }

                  /*************************************************/

                  $res = $db_prueba->query("SELECT * FROM rpv_cliente_tarjeta where status = 1");
                            
                  $res = $res->result_array();

                  $str_tarjeta = '';
                  $str_tarjeta_ax = '';

                  foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                      
                      $tarjetas_default = $valor['tarjeta'];

                      $str_tarjeta = $str_tarjeta."'".$tarjetas_default."',";

                  }

                  foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                      
                      $tarjetas_default = 'AX'.$valor['tarjeta'];

                      $str_tarjeta_ax = $str_tarjeta_ax."'".$tarjetas_default."',";

                  }

                  $str_tarjeta=explode(',', $str_tarjeta);
                  $str_tarjeta=array_filter($str_tarjeta, "strlen");
                  $str_tarjeta = implode(",", $str_tarjeta);

                  $str_tarjeta_ax=explode(',', $str_tarjeta_ax);
                  $str_tarjeta_ax=array_filter($str_tarjeta_ax, "strlen");
                  $str_tarjeta_ax = implode(",", $str_tarjeta_ax);

                  /*************************************************/

                  $select = $select."

                    and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date) and (ltrim(rtrim(for_pgo_fac.concepto)) in (".$str_tarjeta.") or ltrim(rtrim(for_pgo_fac.concepto)) in (".$str_tarjeta_ax.") ) 
                    and for_pgo_fac.id_forma_pago in ('AX','AXS')
                  
                  ";

                  if($all_dks == 0){


                       if($cont_cliente == 0){  

                         $res = $db_prueba->query("SELECT * FROM rpv_cliente_tarjeta where status = 1");
                            
                            $res = $res->result_array();
                            $id_cliente_arr = [];

                            foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                                
                                $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                                array_push($id_cliente_arr,$clientes_default);

                            }

                            $id_cliente_arr = implode(",", $id_cliente_arr);

                            $select = $select . "and clientes.id_cliente in (".$id_cliente_arr.") "; //ya

                       }
                       if($cont_cliente > 0){

                            $select = $select . "and NOTAS_CREDITO.ID_CLIENTE in (".$str_cli.") "; 


                       }
                       if($cont_corporativo > 0){  //ya

                            $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

                       }
                       if($cont_serie > 0){  //ya

                            $select = $select . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

                       }
                       if($cont_servicio > 0){

                            $select = $select . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

                       }
                       if($cont_provedor == 0){

                            if($cat_provedor != 0){

                                $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' "; 

                            }else{

                                $cat_prov = "";

                            }

                            $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_amex where status = 1 $cat_prov");
                           
                            $res_id_provedor = $res_id_provedor->result_array();

                            $str_prov = '';
                            foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                                     $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                                  }

                            if(count($res_id_provedor) > 0){

                                  $str_prov=explode(',', $str_prov);
                                  $str_prov=array_filter($str_prov, "strlen");
                                  $str_prov = implode(",", $str_prov);

                                  $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                            }else{


                                  $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


                            }
                                      
        


                       }
                       if($cont_provedor > 0){

                            $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                       }


                     

                  }else if($all_dks == 1){

                       if($cont_cliente == 0){  

                         $res = $db_prueba->query("SELECT * FROM rpv_cliente_tarjeta where status = 1");
                            
                            $res = $res->result_array();
                            $id_cliente_arr = [];

                            foreach ($res as $clave => $valor) {  //obtiene clientes asignados
                                
                                $clientes_default = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
                                array_push($id_cliente_arr,$clientes_default);

                            }

                            $id_cliente_arr = implode(",", $id_cliente_arr);

                            $select = $select . "and CLIENTES.id_cliente in (".$id_cliente_arr.") "; //ya

                       }
                       if($cont_cliente > 0){

                            $select = $select . "and CLIENTES.id_cliente in (".$str_cli.") "; 


                       }
                       if($cont_corporativo > 0){  //ya

                            $select = $select . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

                       }
                       if($cont_serie > 0){  //ya

                            $select = $select . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

                       }
                       if($cont_servicio > 0){

                            $select = $select . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

                       }
                       if($cont_provedor == 0){

                            if($cat_provedor != 0){

                                $cat_prov = " and id_categoria_aereolinea = '$cat_provedor' "; 

                            }else{

                                $cat_prov = "";

                            }

                            $res_id_provedor = $db_prueba->query("SELECT id_aereolinea FROM rpv_aereolineas_amex where status = 1 $cat_prov");
                           
                            $res_id_provedor = $res_id_provedor->result_array();

                            $str_prov = '';

                            foreach ($res_id_provedor as $clave => $valor) {  //obtiene clientes asignados

                                     $str_prov = $str_prov."'".$valor['id_aereolinea']."',";

                                  }

                            if(count($res_id_provedor) > 0){

                                  $str_prov=explode(',', $str_prov);
                                  $str_prov=array_filter($str_prov, "strlen");
                                  $str_prov = implode(",", $str_prov);

                                  $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                            }else{


                                  $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in ('0000000') "; //ya


                            }
                           

                       }
                       if($cont_provedor > 0){

                            $select = $select . " and ltrim(rtrim(PROV_TPO_SERV.ID_PROVEEDOR)) in (".$str_prov.") "; //ya

                       }

                  }
                  
                  //print_r($select);

                  $query_rows = $this->db->query($select);


                  if($proceso == '1'){
                    
                    $result = $query_rows->result();

                  }else if($proceso == '2'){

                    $result = $query_rows->result_array();
                  }
                  
    
    return $result;

   }

   public function get_prueba_grafica($parametros){

      $id_serie = $parametros["id_serie"];
      $id_serie = ($id_serie == "") ? $id_serie = 'null' : $id_serie = "'".$id_serie."'"; 
      $id_cliente = $parametros["id_cliente"];
      $id_cliente = ($id_cliente == "") ? $id_cliente = 'null' : $id_cliente = "'".$id_cliente."'"; 
      $id_corporativo = $parametros["id_corporativo"];
      $id_corporativo = ($id_corporativo == "") ? $id_corporativo = 'null' : $id_corporativo = "'".$id_corporativo."'"; 
      $fecha1 = $parametros["fecha1"];
      $fecha2 = $parametros["fecha2"];

      /*********nuevo************/

      $id_usuario = $parametros["id_usuario"];

      $db_prueba = $this->load->database('conmysql', TRUE);
      $res = $db_prueba->query("SELECT * FROM reportes_villa_tours.rpv_usuarios_cliente where id_usuario = $id_usuario");
      $res = $res->result_array();
    
      foreach ($res as $clave => $valor) {
          $clientes = str_pad($valor['id_cliente'],  6, "0", STR_PAD_LEFT);
          $this->db->query("insert into martha_cliente_usuario(id_usuario,id_cliente)VALUES($id_usuario, '".$clientes."' )");

      }
     
      /***************************/
    
      if($fecha1 == ""){

          $hoy = getdate();
          $dia = str_pad($hoy['mday'], 2, "0", STR_PAD_LEFT);
          $mes = str_pad($hoy['mon'], 2, "0", STR_PAD_LEFT);
          $year = $hoy['year'];
          $fecha1 = $year.'-'.$mes.'-'.$dia;
          $fecha2 = $year.'-'.$mes.'-'.$dia;
          /*$fecha1 = '2015-01-02';
          $fecha2 = '2015-01-02';*/
          
          
      }else{
          
          $array_fecha1 = explode('/', $fecha1);
          
          $fecha1 = $array_fecha1[2].'-'.$array_fecha1[1].'-'.$array_fecha1[0];

          $array_fecha2 = explode('/', $fecha2);
          
          $fecha2 = $array_fecha2[2].'-'.$array_fecha2[1].'-'.$array_fecha2[0];
          
      }

      $query = $this->db->query("execute sp_new_Martha_GVC_Reporteador_grafica '$fecha1','$fecha2',$id_serie,$id_cliente,$id_corporativo,$id_usuario");

      $result = $query->result();

      /*********nuevo************/
        $this->db->query("delete from martha_cliente_usuario where id_usuario = $id_usuario");
      /***************************/

      return $result;

   }


   public function get_razon_social_id_in($ids_cliente){

      $ids_cliente = implode(",", $ids_cliente);
                
      $query = $this->db->query("SELECT distinct nombre_cliente FROM clientes where id_cliente in ($ids_cliente)");

      return $query->result();

   }

   public function get_razon_social_id($id_cliente){

      $query = $this->db->query("SELECT TOP 1 GVC_NOM_CLI FROM Martha_GVC_Reporteador_BOL where GVC_ID_CLIENTE = '".$id_cliente."' ");

      return $query->result();

   }

  
   public function get_catalogo_reportes($id_perfil){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query('SELECT sub.id,sub.nombre from rpv_perfil_modulo_submodulo pms 
                                  INNER JOIN rpv_submodulos sub on sub.id =  pms.id_submodulo
                                  WHERE pms.id_perfil = '.$id_perfil.' and pms.id_modulo = 3 and pms.status_submodulo = 1 and pms.status = 1');

      return $query->result();

    
   }

   public function get_reportes_perfil_filtrados($reportes){

     $db_prueba = $this->load->database('conmysql', TRUE);
     
     $query = $db_prueba->query("SELECT sub.id,sub.nombre from rpv_perfil_modulo_submodulo pms 
                                  INNER JOIN rpv_submodulos sub on sub.id =  pms.id_submodulo
                                  WHERE  pms.id_modulo = 3 and pms.status_submodulo = 1 and pms.status = 1 and sub.id in(".$reportes.") ");

     return $query->result();

   }
  
}