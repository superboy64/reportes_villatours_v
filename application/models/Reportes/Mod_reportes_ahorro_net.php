<?php
set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');

class Mod_reportes_ahorro_net extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
   }
   

   public function get_pasajero($parametros){
      
      $ids_suc = $parametros["ids_suc"];
      $ids_serie = $parametros["ids_serie"];
      $ids_cliente = $parametros["ids_cliente"];
      $id_servicio = $parametros["id_servicio"];
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

        $str_cli = '';

        foreach ($ids_cliente as $clave => $valor) {  //obtiene clientes asignados

                 $str_cli = $str_cli."'".$valor."',";

              }

        $str_cli=explode(',', $str_cli);
        $str_cli=array_filter($str_cli, "strlen");
        $str_cli = implode(",", $str_cli);


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
      GVC_NOM_VEN_TIT varchar(500) null,
      GVC_ID_SERIE varchar(500) null,
      GVC_DOC_NUMERO varchar(500) null,
      GVC_ID_CORPORATIVO varchar(500) null,
      GVC_ID_CLIENTE varchar(500) null,
      GVC_NOM_CLI varchar(500) null,
      GVC_CVE_RES_GLO varchar(500) null,
      analisis28_cliente varchar(500) null,
      GVC_FECHA varchar(500) null,
      GVC_BOLETO varchar(500) null,
      GVC_ID_SERVICIO varchar(500) null,
      TIPO_BOLETO varchar(500) null,
      GVC_ID_PROVEEDOR varchar(500) null,
      GVC_NOMBRE_PROVEEDOR varchar(500) null, 
      GVC_CONCEPTO varchar(500) null, 
      GVC_NOM_PAX varchar(500) null,
      GVC_TARIFA_MON_BASE varchar(500) null,
      GVC_IVA varchar(500) null, 
      GVC_TUA varchar(500) null,
      GVC_OTROS_IMPUESTOS varchar(500) null,
      GVC_TOTAL real null,
      analisis13_cliente varchar(500) null,
      analisis14_cliente varchar(500) null,
      analisis15_cliente varchar(500) null,
      analisis6_cliente varchar(500) null,
      analisis17_cliente varchar(500) null,
      analisis32_cliente varchar(500) null,
      analisis35_cliente varchar(500) null,
      analisis57_cliente varchar(500) null,
      GVC_CLASE_FACTURADA varchar(500) null,
      GVC_FECHA_SALIDA varchar(500) null,
      GVC_FECHA_REGRESO varchar(500) null,
      GVC_FECHA_EMISION_BOLETO varchar(500) null, 
      GVC_CLAVE_EMPLEADO varchar(500) null,
      GVC_FECHA_RESERVACION varchar(500) null, 
      MES varchar(500) null, 
      ANO varchar(500) null, 
      analisis26_cliente varchar(500) null,
      analisis11_cliente varchar(500) null,
      analisis23_cliente varchar(500) null,
      analisis1_cliente varchar(500) null,
      analisis18_cliente varchar(500) null
    )");
    
    $this->db->query("create table #TEMPNC(
     GVC_ID_CENTRO_COSTO varchar(500) null,
     GVC_DOC_NUMERO varchar(500) null, 
     GVC_FAC_NUMERO varchar(500) null,
     GVC_BOLETO varchar(500) null,
     GVC_ID_CLIENTE varchar(500) null,
     GVC_NOM_CLI varchar(500) null,
     GVC_ID_PROVEEDOR varchar(500) null,
     GVC_TARIFA_MON_BASE varchar(500) null,
     GVC_ID_SERVICIO varchar(500) null,
     total real null,
     GVC_TIPO varchar(500) null
     
    )");
    
    $select1 = "insert INTO #TEMPFAC
    SELECT
    TITULAR.NOMBRE as GVC_NOM_VEN_TIT,
    DATOS_FACTURA.ID_SERIE as GVC_ID_SERIE, 
    DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO, 
    CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO, 
    DATOS_FACTURA.ID_CLIENTE as GVC_ID_CLIENTE, 
    DATOS_FACTURA.CL_NOMBRE as GVC_NOM_CLI, 


    case when DATOS_FACTURA.CVE_RESERV_GLOBAL = '' then 'empty' else DATOS_FACTURA.CVE_RESERV_GLOBAL end as GVC_CVE_RES_GLO,


    DATOS_FACTURA.analisis28_cliente as analisis28_cliente,
    convert(char(12),convert(datetime,DATOS_FACTURA.FECHA),105)  as GVC_FECHA, 
    case when ( PROV_TPO_SERV.ID_SERVICIO = 'CS' ) then  convert(varchar,DETALLE_FACTURA.numero_bol_Cxs) else convert(varchar,DETALLE_FACTURA.NUMERO_BOL)  end as GVC_BOLETO, 
    convert(varchar,case when(PROV_TPO_SERV.ID_SERVICIO = 'AUTOBFR') then 'AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'AUTOBT0') then 'AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'AUTOBU') then 'AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'ACALAFIA') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'BD') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CALAFIA') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CALAFIAFR') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'BI') then 'BOL. INT.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then 'CARGO X SERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGBUS') then 'CARGO X SERV. AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSFE') then 'CARGO X SERV. CFDI'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSE') then 'CARGO X SERV. EME'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CHR') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CHR-10') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CHR-T0') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FPCH15') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FPCHT0') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CCRU10') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CCRU15') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CCRUT0') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CRUCER') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CRUCER-T0') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FCRU15') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FCRUT0') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGXPCV') then 'CRUCERO ING. X RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'DEBITO') then 'DEBITO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CUPONHTL') then 'HOTEL ING. X RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGXAH') then 'HOTEL ING. X RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FH0T15') then 'HOTEL INGRESOS POR RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FHOTT0') then 'HOTEL INGRESOS POR RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTINT') then 'HOTEL INT.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTINT-T0') then 'HOTEL INT.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTNAC') then 'HOTEL NAC.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTNAC-10') then 'HOTEL NAC.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INCENTIVOS') then 'INCENTIVOS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGUTC') then 'INGRESO X USO TDC'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FSES15') then 'INGRESOS X SER ESP'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FSEST0') then 'INGRESOS X SER ESP'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGXSE') then 'INGRESOS X SER ESP'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCAR') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCAR-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCCR') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCCR-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCRI') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCRI-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVMSC') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVMSC-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVNCR') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVNCR-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVOSC') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVOSC-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVPUL') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVPUL-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVRCA') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVRCA-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NOTCRE') then 'NOTA CREDITO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OPEVIA') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OVIAJE') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OVIAJEFR') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OVIAJET0') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FOPVIA') then 'OPERADORA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FOPVIAT0') then 'OPERADORA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OTROSO') then 'OTROS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OTROSO-10') then 'OTROS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OTROSO-T0') then 'OTROS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'ASSIST') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'ASSIST-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'AXASEG') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSEG10') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSEG15') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSEGT0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'EURASS') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'EURASS-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGSEG') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INTSEG') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INTSEG-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'PS') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGLAT') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGURO') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGU-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGVIA') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGVIA-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'WASSIT') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'WASSIT-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'PROP') then 'PROPINA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'RENAFR') then 'RENTA AUTO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'RENAT0') then 'RENTA AUTO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'RENAUT') then 'RENTA AUTO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEVAR') then 'SERV. ESP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEVAR-T0') then 'SERV. ESP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRA10') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRA15') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRAT0') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FTRA15') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FTRAT0') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TR') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAAIR') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAAUA') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRACAS') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAETG') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAETN') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAETN') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAEXC') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAGDN') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAGOL') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRALIZ') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRANOV') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAPTO') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAPTO-T0') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRASUB') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATCE') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATOT') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATPS') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATTE') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAVIP') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TVILIZ') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRENFR') then 'TREN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRENSE') then 'TREN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRENT0') then 'TREN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTREFR') then 'TREN PASE'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTREN') then 'TREN PASE'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRET0') then 'TREN PASE'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRONDEN') then 'TRONDEN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'VIRTUOSO') then 'VIRTUOSO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAVISA-10') then 'VISA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAVISA-T0') then 'VISA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRVISA') then 'VISA'
    end) as GVC_ID_SERVICIO, 
    DETALLE_FACTURA.contra as TIPO_BOLETO, 
    PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR,
    PROVEEDORES.NOMBRE as GVC_NOMBRE_PROVEEDOR, 
    DETALLE_FACTURA.CONCEPTO as GVC_CONCEPTO,  
    DETALLE_FACTURA.NOM_PASAJERO as GVC_NOM_PAX,
    DETALLE_FACTURA.TARIFA_MON_BASE as GVC_TARIFA_MON_BASE, 
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_IVA,  
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_TUA,
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_OTROS_IMPUESTOS, 
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
    DATOS_FACTURA.analisis13_cliente as analisis13_cliente,
    DATOS_FACTURA.analisis14_cliente as analisis14_cliente,
    DATOS_FACTURA.analisis15_cliente as analisis15_cliente,
    DATOS_FACTURA.analisis6_cliente as analisis6_cliente,
    DATOS_FACTURA.analisis17_cliente as analisis17_cliente,
    DATOS_FACTURA.analisis32_cliente as analisis32_cliente,
    DATOS_FACTURA.analisis35_cliente as analisis35_cliente,
    DATOS_FACTURA.analisis57_cliente as analisis57_cliente,
    CONCECUTIVO_BOLETOS.CLA_FAC as GVC_CLASE_FACTURADA, 
    cast(CONCECUTIVO_BOLETOS.FECHA_SAL as date) as GVC_FECHA_SALIDA, 
    cast(CONCECUTIVO_BOLETOS.FECHA_REG as date) as GVC_FECHA_REGRESO,  
    cast(CONCECUTIVO_BOLETOS.FECHA_EMI as date) as GVC_FECHA_EMISION_BOLETO,  
    DETALLE_FACTURA.cla_pax as GVC_CLAVE_EMPLEADO, 
    GVC_FECHA_RESERVACION=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else  convert(char(12),convert(datetime,GDS_GENERAL.FECHA_RESERVACION),105) end,
    MES=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else substring(GDS_GENERAL.FECHA_RESERVACION, 6, 2) end,
    ANO=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else substring(GDS_GENERAL.FECHA_RESERVACION, 1, 4) end,
    DATOS_FACTURA.analisis26_cliente as analisis26_cliente,
    DATOS_FACTURA.analisis11_cliente as analisis11_cliente,
    DATOS_FACTURA.analisis23_cliente as analisis23_cliente,
    DATOS_FACTURA.ANALISIS1_CLIENTE as analisis1_cliente,
    DATOS_FACTURA.analisis18_cliente as analisis18_cliente
    
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
  
    and DATOS_FACTURA.FECHA BETWEEN '".$fecha1."' AND '".$fecha2."' and DETALLE_FACTURA.contra <> 'S' and DETALLE_FACTURA.EMD <> 'S'  ";

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

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 

         }
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
        
        if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

        }

        if($cont_cliente > 1){

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 

         }

        if($cont_cliente == 1){

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE = ".$str_cli." "; 

         }

         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $select2 = " insert into #TEMPNC

    select
        GVC_ID_CENTRO_COSTO=NOTAS_CREDITO.ID_CENCOS,
        GVC_DOC_NUMERO=NOTAS_CREDITO.NC_NUMERO,
        GVC_FAC_NUMERO=NOTAS_CREDITO.FAC_NUMERO,
        GVC_BOLETO=case when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then null else convert(varchar,DETALLE_NC.DET_NC_NUM_BOL) end,
        CLIENTES.ID_CLIENTE,
        NOTAS_CREDITO.CL_NOMBRE,
   
        PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR,
        DETALLE_NC.DET_NC_TAR_MN as GVC_TARIFA_MON_BASE,
        PROV_TPO_SERV.ID_SERVICIO as GVC_ID_SERVICIO,

        total=(convert(real,DETALLE_NC.DET_NC_TAR_MN )+convert(real,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
          DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
          IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))+convert(real,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
          DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
          IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))+convert(real,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
          DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
          IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))),
          TIPO = 'NC'
          

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

    and NOTAS_CREDITO.NC_FEC BETWEEN '".$fecha1."' AND '".$fecha2."' and DETALLE_NC.det_nc_ctra <> 'S' ";

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

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

        }

        if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

        }

        if($cont_cliente > 1){

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 


         }

        if($cont_cliente == 1){

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE = ".$str_cli." "; 


         }

         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
    
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }


    $this->db->query($select1);

    $this->db->query($select2);

     $select3 = "select FAC.GVC_CVE_RES_GLO,count(FAC.GVC_CVE_RES_GLO) as cont ";
   
    $select3 = $select3 . " from #TEMPFAC as FAC where not FAC.GVC_DOC_NUMERO = any(select distinct GVC_FAC_NUMERO from #TEMPNC)";

    $select3 = $select3 . " group by FAC.GVC_CVE_RES_GLO";

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
  
   public function get_pasajero_detalle($parametros){

      $ids_suc = $parametros["ids_suc"];
      $ids_serie = $parametros["ids_serie"];
      $ids_cliente = $parametros["ids_cliente"];
      $id_servicio = $parametros["id_servicio"];
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

        $str_cli = '';

        foreach ($ids_cliente as $clave => $valor) {  //obtiene clientes asignados

                 $str_cli = $str_cli."'".$valor."',";

              }

        $str_cli=explode(',', $str_cli);
        $str_cli=array_filter($str_cli, "strlen");
        $str_cli = implode(",", $str_cli);


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

      GVC_NOM_VEN_TIT varchar(500) null,
      GVC_ID_SERIE varchar(500) null,
      GVC_DOC_NUMERO varchar(500) null,
      GVC_ID_CORPORATIVO varchar(500) null,
      GVC_ID_CLIENTE varchar(500) null,
      GVC_NOM_CLI varchar(500) null,
      GVC_CVE_RES_GLO varchar(500) null,
      analisis28_cliente varchar(500) null,
      GVC_FECHA varchar(500) null,
      GVC_BOLETO varchar(500) null,
      GVC_ID_SERVICIO varchar(500) null,
      TIPO_BOLETO varchar(500) null,
      GVC_ID_PROVEEDOR varchar(500) null,
      GVC_NOMBRE_PROVEEDOR varchar(500) null, 
      GVC_CONCEPTO varchar(500) null, 
      GVC_NOM_PAX varchar(500) null,
      GVC_TARIFA_MON_BASE varchar(500) null,
      GVC_IVA varchar(500) null, 
      GVC_TUA varchar(500) null,
      GVC_OTROS_IMPUESTOS varchar(500) null,
      GVC_TOTAL real null,
      analisis13_cliente varchar(500) null,
      analisis14_cliente varchar(500) null,
      analisis15_cliente varchar(500) null,
      analisis6_cliente varchar(500) null,
      analisis17_cliente varchar(500) null,
      analisis32_cliente varchar(500) null,
      analisis35_cliente varchar(500) null,
      analisis57_cliente varchar(500) null,
      GVC_CLASE_FACTURADA varchar(500) null,
      GVC_FECHA_SALIDA varchar(500) null,
      GVC_FECHA_REGRESO varchar(500) null,
      GVC_FECHA_EMISION_BOLETO varchar(500) null, 
      GVC_CLAVE_EMPLEADO varchar(500) null,
      GVC_FECHA_RESERVACION varchar(500) null, 
      MES varchar(500) null, 
      ANO varchar(500) null, 
      analisis26_cliente varchar(500) null,
      analisis11_cliente varchar(500) null,
      analisis23_cliente varchar(500) null,
      analisis1_cliente varchar(500) null,
      analisis18_cliente varchar(500) null


    )");
    
    $this->db->query("create table #TEMPNC(
     GVC_ID_CENTRO_COSTO varchar(500) null,
     GVC_DOC_NUMERO varchar(500) null, 
     GVC_FAC_NUMERO varchar(500) null,
     GVC_BOLETO varchar(500) null,
     GVC_ID_CLIENTE varchar(500) null,
     GVC_NOM_CLI varchar(500) null,
     GVC_ID_PROVEEDOR varchar(500) null,
     GVC_TARIFA_MON_BASE varchar(500) null,
     GVC_ID_SERVICIO varchar(500) null,
     total real null,
     GVC_TIPO varchar(500) null
    )");
    
    $select1 = "insert INTO #TEMPFAC
    SELECT
    TITULAR.NOMBRE as GVC_NOM_VEN_TIT,
    DATOS_FACTURA.ID_SERIE as GVC_ID_SERIE, 
    DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO, 
    CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO, 
    DATOS_FACTURA.ID_CLIENTE as GVC_ID_CLIENTE, 
    DATOS_FACTURA.CL_NOMBRE as GVC_NOM_CLI, 

    case when DATOS_FACTURA.CVE_RESERV_GLOBAL = '' then 'empty' else DATOS_FACTURA.CVE_RESERV_GLOBAL end as GVC_CVE_RES_GLO,
    
    DATOS_FACTURA.analisis28_cliente as analisis28_cliente,
    convert(char(12),convert(datetime,DATOS_FACTURA.FECHA),105)  as GVC_FECHA, 
    case when ( PROV_TPO_SERV.ID_SERVICIO = 'CS' ) then  convert(varchar,DETALLE_FACTURA.numero_bol_Cxs) else convert(varchar,DETALLE_FACTURA.NUMERO_BOL)  end as GVC_BOLETO, 
    convert(varchar,case when(PROV_TPO_SERV.ID_SERVICIO = 'AUTOBFR') then 'AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'AUTOBT0') then 'AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'AUTOBU') then 'AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'ACALAFIA') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'BD') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CALAFIA') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CALAFIAFR') then 'BOL. DOM.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'BI') then 'BOL. INT.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then 'CARGO X SERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGBUS') then 'CARGO X SERV. AUTOBUS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSFE') then 'CARGO X SERV. CFDI'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSE') then 'CARGO X SERV. EME'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CHR') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CHR-10') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CHR-T0') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FPCH15') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FPCHT0') then 'CHARTER'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CCRU10') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CCRU15') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CCRUT0') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CRUCER') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CRUCER-T0') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FCRU15') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FCRUT0') then 'CRUCERO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGXPCV') then 'CRUCERO ING. X RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'DEBITO') then 'DEBITO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CUPONHTL') then 'HOTEL ING. X RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGXAH') then 'HOTEL ING. X RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FH0T15') then 'HOTEL INGRESOS POR RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FHOTT0') then 'HOTEL INGRESOS POR RESERV.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTINT') then 'HOTEL INT.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTINT-T0') then 'HOTEL INT.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTNAC') then 'HOTEL NAC.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'HOTNAC-10') then 'HOTEL NAC.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INCENTIVOS') then 'INCENTIVOS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGUTC') then 'INGRESO X USO TDC'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FSES15') then 'INGRESOS X SER ESP'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FSEST0') then 'INGRESOS X SER ESP'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGXSE') then 'INGRESOS X SER ESP'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCAR') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCAR-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCCR') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCCR-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCRI') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVCRI-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVMSC') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVMSC-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVNCR') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVNCR-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVOSC') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVOSC-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVPUL') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVPUL-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVRCA') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NAVRCA-T0') then 'NAVIERA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'NOTCRE') then 'NOTA CREDITO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OPEVIA') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OVIAJE') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OVIAJEFR') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OVIAJET0') then 'OPER. VICA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FOPVIA') then 'OPERADORA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FOPVIAT0') then 'OPERADORA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OTROSO') then 'OTROS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OTROSO-10') then 'OTROS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'OTROSO-T0') then 'OTROS'
    when(PROV_TPO_SERV.ID_SERVICIO = 'ASSIST') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'ASSIST-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'AXASEG') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSEG10') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSEG15') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CSEGT0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'EURASS') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'EURASS-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INGSEG') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INTSEG') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'INTSEG-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'PS') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGLAT') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGURO') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGU-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGVIA') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEGVIA-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'WASSIT') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'WASSIT-T0') then 'POLIZA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'PROP') then 'PROPINA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'RENAFR') then 'RENTA AUTO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'RENAT0') then 'RENTA AUTO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'RENAUT') then 'RENTA AUTO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEVAR') then 'SERV. ESP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'SEVAR-T0') then 'SERV. ESP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRA10') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRA15') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRAT0') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FTRA15') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'FTRAT0') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TR') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAAIR') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAAUA') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRACAS') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAETG') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAETN') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAETN') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAEXC') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAGDN') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAGOL') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRALIZ') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRANOV') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAPTO') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAPTO-T0') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRASUB') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATCE') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATOT') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATPS') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRATTE') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAVIP') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TVILIZ') then 'TRANSP.'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRENFR') then 'TREN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRENSE') then 'TREN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRENT0') then 'TREN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTREFR') then 'TREN PASE'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTREN') then 'TREN PASE'
    when(PROV_TPO_SERV.ID_SERVICIO = 'CTRET0') then 'TREN PASE'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRONDEN') then 'TRONDEN'
    when(PROV_TPO_SERV.ID_SERVICIO = 'VIRTUOSO') then 'VIRTUOSO'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAVISA-10') then 'VISA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRAVISA-T0') then 'VISA'
    when(PROV_TPO_SERV.ID_SERVICIO = 'TRVISA') then 'VISA'
    end) as GVC_ID_SERVICIO, 
    DETALLE_FACTURA.contra as TIPO_BOLETO, 
    PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR,
    PROVEEDORES.NOMBRE as GVC_NOMBRE_PROVEEDOR, 
    DETALLE_FACTURA.CONCEPTO as GVC_CONCEPTO,  
    DETALLE_FACTURA.NOM_PASAJERO as GVC_NOM_PAX,
    DETALLE_FACTURA.TARIFA_MON_BASE as GVC_TARIFA_MON_BASE, 
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_IVA,  
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_TUA,
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_OTROS_IMPUESTOS, 
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
    DATOS_FACTURA.analisis13_cliente as analisis13_cliente,
    DATOS_FACTURA.analisis14_cliente as analisis14_cliente,
    DATOS_FACTURA.analisis15_cliente as analisis15_cliente,
    DATOS_FACTURA.analisis6_cliente as analisis6_cliente,
    DATOS_FACTURA.analisis17_cliente as analisis17_cliente,
    DATOS_FACTURA.analisis32_cliente as analisis32_cliente,
    DATOS_FACTURA.analisis35_cliente as analisis35_cliente,
    DATOS_FACTURA.analisis57_cliente as analisis57_cliente,
    CONCECUTIVO_BOLETOS.CLA_FAC as GVC_CLASE_FACTURADA, 
    cast(CONCECUTIVO_BOLETOS.FECHA_SAL as date) as GVC_FECHA_SALIDA, 
    cast(CONCECUTIVO_BOLETOS.FECHA_REG as date) as GVC_FECHA_REGRESO,  
    cast(CONCECUTIVO_BOLETOS.FECHA_EMI as date) as GVC_FECHA_EMISION_BOLETO,  
    DETALLE_FACTURA.cla_pax as GVC_CLAVE_EMPLEADO, 
    GVC_FECHA_RESERVACION=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else  convert(char(12),convert(datetime,GDS_GENERAL.FECHA_RESERVACION),105) end,
    MES=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else substring(GDS_GENERAL.FECHA_RESERVACION, 6, 2) end,
    ANO=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else substring(GDS_GENERAL.FECHA_RESERVACION, 1, 4) end,
    DATOS_FACTURA.analisis26_cliente as analisis26_cliente,
    DATOS_FACTURA.analisis11_cliente as analisis11_cliente,
    DATOS_FACTURA.analisis23_cliente as analisis23_cliente,
    DATOS_FACTURA.ANALISIS1_CLIENTE as analisis1_cliente,
    DATOS_FACTURA.analisis18_cliente as analisis18_cliente
 
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
  
    and DATOS_FACTURA.FECHA BETWEEN '".$fecha1."' AND '".$fecha2."' and DETALLE_FACTURA.contra <> 'S' and DETALLE_FACTURA.EMD <> 'S'  ";

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

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 

         }
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

         }

        if($cont_serie > 0){  //ya

              $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

         }

        if($cont_cliente > 1){

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 

         }

        if($cont_cliente == 1){

              $select1 = $select1 . "and CLIENTES.ID_CLIENTE = ".$str_cli." "; 

         }

         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $select2 = " insert into #TEMPNC

    select
        GVC_ID_CENTRO_COSTO=NOTAS_CREDITO.ID_CENCOS,
        GVC_DOC_NUMERO=NOTAS_CREDITO.NC_NUMERO,
        GVC_FAC_NUMERO=NOTAS_CREDITO.FAC_NUMERO,
        GVC_BOLETO=case when(PROV_TPO_SERV.ID_SERVICIO = 'CS') then null else convert(varchar,DETALLE_NC.DET_NC_NUM_BOL) end,
        CLIENTES.ID_CLIENTE,
        NOTAS_CREDITO.CL_NOMBRE,
   
        PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR,
        DETALLE_NC.DET_NC_TAR_MN as GVC_TARIFA_MON_BASE,
        PROV_TPO_SERV.ID_SERVICIO as GVC_ID_SERVICIO,

        total=(convert(real,DETALLE_NC.DET_NC_TAR_MN )+convert(real,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
          DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
          IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))+convert(real,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
          DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
          IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))+convert(real,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
          DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
          CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
          CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
          IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC))),
          TIPO = 'NC'

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

    and NOTAS_CREDITO.NC_FEC BETWEEN '".$fecha1."' AND '".$fecha2."' and DETALLE_NC.det_nc_ctra <> 'S' ";

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

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_cliente > 0){

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select2 = $select2 . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

         }
        
        if($cont_serie > 0){  //ya

              $select2 = $select2 . " and NOTAS_CREDITO.ID_SERIE in (".$str_ser.") "; //ya

         }

        if($cont_cliente > 1){

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE in (".$str_cli.") "; 


         }

        if($cont_cliente == 1){

              $select2 = $select2 . "and CLIENTES.ID_CLIENTE = ".$str_cli." "; 


         }

         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }

         if($cont_provedor > 0){

              $select2 = $select2 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }


    $this->db->query($select1);

    $this->db->query($select2);

    $select3 = "select FAC.*,precompra= datediff(dd, FAC.GVC_FECHA_EMISION_BOLETO , FAC.GVC_FECHA_SALIDA )";
   
    $select3 = $select3 . " from #TEMPFAC as FAC where not FAC.GVC_DOC_NUMERO = any(select distinct GVC_FAC_NUMERO from #TEMPNC) order by FAC.GVC_CVE_RES_GLO";


    $query_rows = $this->db->query($select3);

    //$result = $query_rows->result();

    if($proceso == '1'){
      
      $result = $query_rows->result();

    }else if($proceso == '2'){

      $result = $query_rows->result_array();
      
    }

    $this->db->query("drop table #TEMPFAC");
    $this->db->query("drop table #TEMPNC");
    
    //print_r($result);

    return $result;

   }


   public function get_razon_social_id_in($ids_cliente){

      $ids_cliente = implode(",", $ids_cliente);
                
      $query = $this->db->query("SELECT distinct nombre_cliente FROM clientes where id_cliente in ($ids_cliente) ");

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