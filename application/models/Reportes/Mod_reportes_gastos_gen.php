<?php
set_time_limit(0);
ini_set('post_max_size','4000M');
ini_set('memory_limit', '20000M');

class Mod_reportes_gastos_gen extends CI_Model {

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


   public function get_reportes_gastos_gen($parametros){

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

    $select = "select 
    DATOS_FACTURA.ID_SERIE as GVC_ID_SERIE, 
    DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO, 
    CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO, 
    DATOS_FACTURA.ID_CLIENTE as GVC_ID_CLIENTE, 
    DATOS_FACTURA.CL_NOMBRE as GVC_NOM_CLI, 
    DATOS_FACTURA.ID_CENTRO_COSTO as GVC_ID_CENTRO_COSTO,  
    CENTRO_COSTO.DESC_CENTRO_COSTO as GVC_DESC_CENTRO_COSTO,  
    convert(char(12),convert(datetime,DATOS_FACTURA.FECHA),105)  as GVC_FECHA,  
    DATOS_FACTURA.SOLICITO as GVC_SOLICITO, 
    DATOS_FACTURA.CVE_RESERV_GLOBAL as GVC_CVE_RES_GLO, 
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
    CONCECUTIVO_BOLETOS.CLA_FAC as GVC_CLASE_FACTURADA, 
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as GVC_FECHA_SALIDA, 
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_REG),105) as GVC_FECHA_REGRESO,  
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_EMI),105) as GVC_FECHA_EMISION_BOLETO,  
    DETALLE_FACTURA.cla_pax as GVC_CLAVE_EMPLEADO, 
    (select top 1 ID_FORMA_PAGO from DBA.FOR_PGO_FAC where
      FOR_PGO_FAC.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
      FOR_PGO_FAC.ID_SERIE = DATOS_FACTURA.ID_SERIE and
      FOR_PGO_FAC.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO) as GVC_FOR_PAG1,  
    GVC_FECHA_RESERVACION=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else  convert(char(12),convert(datetime,GDS_GENERAL.FECHA_RESERVACION),105) end 
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
    not DBA.DATOS_FACTURA.ID_SERIE = any(select ID_SERIE from DBA.GDS_CXS where EN_OTRA_SERIE = 'A') ";

    if($id_intervalo == '5'){

      $condicion_fecha = 'DATOS_FACTURA.fecha_folio';

    }else{

      //print_r("se va por aki");
      $condicion_fecha = 'DATOS_FACTURA.FECHA';

    }

    $select = $select." 
    and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
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

              $select = $select . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select = $select . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

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
         if($cont_provedor > 0){

              $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select = $select . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

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
         if($cont_provedor > 0){

              $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $select = $select ."UNION ALL select 
    NOTAS_CREDITO.ID_SERIE as GVC_ID_SERIE, 
    NOTAS_CREDITO.NC_NUMERO as GVC_DOC_NUMERO,  
    CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO, 
    NOTAS_CREDITO.ID_CLIENTE as GVC_ID_CLIENTE, 
    NOTAS_CREDITO.CL_NOMBRE as GVC_NOM_CLI, 
    NOTAS_CREDITO.ID_CENCOS as GVC_ID_CENTRO_COSTO,  
    CENTRO_COSTO.DESC_CENTRO_COSTO as GVC_DESC_CENTRO_COSTO, 
    convert(char(12),convert(datetime,NOTAS_CREDITO.NC_FEC),105)  as GVC_FECHA, 
    NOTAS_CREDITO.NC_SOL as GVC_SOLICITO, 
    NOTAS_CREDITO.NC_CLA_GLOB as GVC_CVE_RES_GLO, 
    case when ( PROV_TPO_SERV.ID_SERVICIO = 'CS' ) then  null else convert(varchar,DETALLE_NC.DET_NC_NUM_BOL)  end as GVC_BOLETO,
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
    PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR, 
    PROVEEDORES.NOMBRE as GVC_NOMBRE_PROVEEDOR, 
    DETALLE_NC.DET_NC_CONCEPTO as GVC_CONCEPTO, 
    DETALLE_NC.DET_NC_NOM_PAS as GVC_NOM_PAX, 

    '-'+          
    CONVERT(varchar,isnull(round(detalle_nc.det_nc_tar_mn,2),0)) as gvc_tarifa_mon_base, 
    '-'+CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_IVA, 
    '-'+CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_TUA,  
    '-'+CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_OTROS_IMPUESTOS, 


    '-'+ CONVERT(varchar,
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
      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_TOTAL,

      
    CONCECUTIVO_BOLETOS.CLA_FAC as GVC_CLASE_FACTURADA, 
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as GVC_FECHA_SALIDA, 
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_REG),105) as GVC_FECHA_REGRESO, 
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_EMI),105) as GVC_FECHA_EMISION_BOLETO, 
    CONCECUTIVO_BOLETOS.CLA_PAX as GVC_CLAVE_EMPLEADO, 
    null as GVC_FOR_PAG1, 
    null 
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
    PROV_TPO_SERV.ID_SERVICIO = TIPO_SERVICIO.ID_TIPO_SERVICIO";

    if($id_intervalo == '5'){

      $condicion_fecha = 'NOTAS_CREDITO.NC_FEC.FECHA_FOLIO';

    }else{

      //print_r("se va por aki");

      $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

    }

    $select = $select."

      and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
    
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

              $select = $select . "and NOTAS_CREDITO.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select = $select . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

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
         if($cont_provedor > 0){

              $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }else if($all_dks == 1){

         if($cont_suc > 0){

              $select = $select . "and NOTAS_CREDITO.ID_SUCURSAL in (".$str_suc.") ";

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
         if($cont_provedor > 0){

              $select = $select . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }


    $query_rows = $this->db->query($select);


    if($proceso == '1'){
      
      $result = $query_rows->result();

    }else if($proceso == '2'){

      $result = $query_rows->result_array();
    }
    
     
    return $result;
  
  
   }

   public function get_prueba_grafica($parametros){

      $ids_suc = $parametros["ids_suc"];
      $ids_serie = $parametros["ids_serie"];
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

    $this->db->query("create table #NombreTabla6(
    id_pagination integer null,
    GVC_ID_SUCURSAL varchar(500) null,
    GVC_ID_SERIE varchar(500) null,
    GVC_DOC_NUMERO varchar(500) null,
    GVC_ID_CORPORATIVO varchar(500) null,
    GVC_NOM_CORP varchar(500) null,
    GVC_ID_CLIENTE varchar(500) null,
    GVC_NOM_CLI varchar(500) null,
    GVC_ID_CENTRO_COSTO varchar(500) null,
    GVC_DESC_CENTRO_COSTO varchar(500) null,
    GVC_ID_DEPTO varchar(500) null,
    GVC_DEPTO varchar(500) null,
    GVC_ID_VEN_TIT varchar(500) null,
    GVC_NOM_VEN_TIT varchar(500) null,
    GVC_ID_VEN_AUX varchar(500) null,
    GVC_NOM_VEN_AUX varchar(500) null,
    GVC_ID_CIUDAD varchar(500) null,
    GVC_FECHA varchar(500) null,
    GVC_MONEDA varchar(500) null,
    GVC_TIPO_CAMBIO varchar(500) null,
    GVC_SOLICITO varchar(500) null,
    GVC_CVE_RES_GLO varchar(500) null,
    analisis1_cliente varchar(500) null,
    analisis2_cliente varchar(500) null,
    analisis3_cliente varchar(500) null,
    analisis4_cliente varchar(500) null,
    analisis5_cliente varchar(500) null,
    analisis6_cliente varchar(500) null,
    analisis7_cliente varchar(500) null,
    analisis8_cliente varchar(500) null,
    analisis9_cliente varchar(500) null,
    analisis10_cliente varchar(500) null,
    analisis11_cliente varchar(500) null,
    analisis12_cliente varchar(500) null,
    analisis13_cliente varchar(500) null,
    analisis14_cliente varchar(500) null,
    analisis15_cliente varchar(500) null,
    analisis16_cliente varchar(500) null,
    analisis17_cliente varchar(500) null,
    analisis18_cliente varchar(500) null,
    analisis19_cliente varchar(500) null,
    analisis20_cliente varchar(500) null,
    analisis21_cliente varchar(500) null,
    analisis22_cliente varchar(500) null,
    analisis23_cliente varchar(500) null,
    analisis24_cliente varchar(500) null,
    analisis25_cliente varchar(500) null,
    analisis26_cliente varchar(500) null,
    analisis27_cliente varchar(500) null,
    analisis28_cliente varchar(500) null,
    analisis29_cliente varchar(500) null,
    analisis30_cliente varchar(500) null,
    analisis31_cliente varchar(500) null,
    analisis32_cliente varchar(500) null,
    analisis33_cliente varchar(500) null,
    analisis34_cliente varchar(500) null,
    analisis35_cliente varchar(500) null,
    analisis36_cliente varchar(500) null,
    analisis39_cliente varchar(500) null,
    confirmacion_la varchar(500) null,
    analisis40_cliente varchar(500) null,
    analisis41_cliente varchar(500) null,
    analisis42_cliente varchar(500) null,
    analisis43_cliente varchar(500) null,
    analisis44_cliente varchar(500) null,
    analisis45_cliente varchar(500) null,
    analisis46_cliente varchar(500) null,
    analisis47_cliente varchar(500) null,
    analisis48_cliente varchar(500) null,
    analisis49_cliente varchar(500) null,
    analisis50_cliente varchar(500) null,
    analisis51_cliente varchar(500) null,
    analisis52_cliente varchar(500) null,
    analisis53_cliente varchar(500) null,
    analisis54_cliente varchar(500) null,
    analisis55_cliente varchar(500) null,
    analisis56_cliente varchar(500) null,
    analisis57_cliente varchar(500) null,
    analisis58_cliente varchar(500) null,
    analisis59_cliente varchar(500) null,
    analisis60_cliente varchar(500) null,
    TIPO_BOLETO varchar(500) null,
    GVC_BOLETO varchar(500) null,
    GVC_ID_SERVICIO varchar(500) null,
    GVC_ID_PROVEEDOR varchar(500) null,
    BOLETO_EMD varchar(500) null,
    GVC_ALCANCE_SERVICIO varchar(500) null,
    GVC_CONCEPTO varchar(500) null,
    GVC_NOM_PAX varchar(500) null,
    GVC_TARIFA_MON_BASE varchar(500) null,
    GVC_TARIFA_MON_EXT varchar(500) null,
    GVC_DESCUENTO varchar(500) null,
    GVC_IVA_DESCUENTO varchar(500) null,
    GVC_COM_AGE varchar(500) null,
    GVC_POR_COM_AGE varchar(500) null,
    GVC_COM_TIT varchar(500) null,
    GVC_POR_COM_TIT varchar(500) null,
    GVC_COM_AUX varchar(500) null,
    GVC_POR_COM_AUX varchar(500) null,
    GVC_POR_IVA_COM varchar(500) null,
    GVC_IVA varchar(500) null,
    GVC_TUA varchar(500) null,
    GVC_OTROS_IMPUESTOS varchar(500) null,
    GVC_SUMA_IMPUESTOS varchar(500) null,
    GVC_IVA_EXT varchar(500) null,
    GVC_TUA_EXT varchar(500) null,
    GVC_OTR_EXT varchar(500) null,
    total real null,
    GVC_CVE_SUCURSAL varchar(500) null,
    GVC_NOM_SUCURSAL varchar(500) null,
    GVC_TARIFA_COMPARATIVA_BOLETO varchar(500) null,
    GVC_TARIFA_COMPARATIVA_BOLETO_EXT varchar(500) null,
    GVC_CLASE_FACTURADA varchar(500) null,
    GVC_CLASE_COMPARATIVO varchar(500) null,
    GVC_FECHA_SALIDA varchar(500) null,
    GVC_FECHA_REGRESO varchar(500) null,
    GVC_FECHA_EMISION_BOLETO varchar(500) null,
    GVC_CLAVE_EMPLEADO varchar(500) null,
    GVC_FOR_PAG1 varchar(500) null,
    GVC_FOR_PAG2 varchar(500) null,
    GVC_FOR_PAG3 varchar(500) null,
    GVC_FOR_PAG4 varchar(500) null,
    GVC_FOR_PAG5 varchar(500) null,
    GVC_FAC_NUMERO varchar(500) null,
    GVC_ID_SERIE_FAC varchar(500) null,
    GVC_FAC_CVE_SUCURSAL varchar(500) null,
    )");
    
    $select1 = "insert into #NombreTabla6
    select id_pagination=identity(5),
      convert(varchar,GVC_ID_SUCURSAL),
      convert(varchar,GVC_ID_SERIE),
      convert(varchar,GVC_DOC_NUMERO),
      convert(varchar,GVC_ID_CORPORATIVO),
      convert(varchar,GVC_NOM_CORP),
      convert(varchar,GVC_ID_CLIENTE),
      convert(varchar,GVC_NOM_CLI),
      convert(varchar,GVC_ID_CENTRO_COSTO),
      convert(varchar,GVC_DESC_CENTRO_COSTO),
      convert(varchar,GVC_ID_DEPTO),
      convert(varchar,GVC_DEPTO),
      convert(varchar,GVC_ID_VEN_TIT),
      convert(varchar,GVC_NOM_VEN_TIT),
      convert(varchar,GVC_ID_VEN_AUX),
      convert(varchar,GVC_NOM_VEN_AUX),
      convert(varchar,GVC_ID_CIUDAD),
      convert(varchar,GVC_FECHA),
      convert(varchar,GVC_MONEDA),
      convert(varchar,GVC_TIPO_CAMBIO),
      convert(varchar,GVC_SOLICITO),
      convert(varchar,GVC_CVE_RES_GLO),
      convert(varchar,analisis1_cliente),
      convert(varchar,analisis2_cliente),
      convert(varchar,analisis3_cliente),
      convert(varchar,analisis4_cliente),
      convert(varchar,analisis5_cliente),
      convert(varchar,analisis6_cliente),
      convert(varchar,analisis7_cliente),
      convert(varchar,analisis8_cliente),
      convert(varchar,analisis9_cliente),
      convert(varchar,analisis10_cliente),
      convert(varchar,analisis11_cliente),
      convert(varchar,analisis12_cliente),
      convert(varchar,analisis13_cliente),
      convert(varchar,analisis14_cliente),
      convert(varchar,analisis15_cliente),
      convert(varchar,analisis16_cliente),
      convert(varchar,analisis17_cliente),
      convert(varchar,analisis18_cliente),
      convert(varchar,analisis19_cliente),
      convert(varchar,analisis20_cliente),
      convert(varchar,analisis21_cliente),
      convert(varchar,analisis22_cliente),
      convert(varchar,analisis23_cliente),
      convert(varchar,analisis24_cliente),
      convert(varchar,analisis25_cliente),
      convert(varchar,analisis26_cliente),
      convert(varchar,analisis27_cliente),
      convert(varchar,analisis28_cliente),
      convert(varchar,analisis29_cliente),
      convert(varchar,analisis30_cliente),
      convert(varchar,analisis31_cliente),
      convert(varchar,analisis32_cliente),
      convert(varchar,analisis33_cliente),
      convert(varchar,analisis34_cliente),
      convert(varchar,analisis35_cliente),
      convert(varchar,analisis36_cliente),
      convert(varchar,analisis39_cliente),
      convert(varchar,confirmacion_la),
      convert(varchar,analisis40_cliente),
      convert(varchar,analisis41_cliente),
      convert(varchar,analisis42_cliente),
      convert(varchar,analisis43_cliente),
      convert(varchar,analisis44_cliente),
      convert(varchar,analisis45_cliente),
      convert(varchar,analisis46_cliente),
      convert(varchar,analisis47_cliente),
      convert(varchar,analisis48_cliente),
      convert(varchar,analisis49_cliente),
      convert(varchar,analisis50_cliente),
      convert(varchar,analisis51_cliente),
      convert(varchar,analisis52_cliente),
      convert(varchar,analisis53_cliente),
      convert(varchar,analisis54_cliente),
      convert(varchar,analisis55_cliente),
      convert(varchar,analisis56_cliente),
      convert(varchar,analisis57_cliente),
      convert(varchar,analisis58_cliente),
      convert(varchar,analisis59_cliente),
      convert(varchar,analisis60_cliente),
      convert(varchar,TIPO_BOLETO),
      convert(varchar,GVC_BOLETO),
      GVC_ID_SERVICIO=convert(varchar,case when(GVC_ID_SERVICIO = 'AUTOBFR') then 'AUTOBUS'
      when(GVC_ID_SERVICIO = 'AUTOBT0') then 'AUTOBUS'
      when(GVC_ID_SERVICIO = 'AUTOBU') then 'AUTOBUS'
      when(GVC_ID_SERVICIO = 'ACALAFIA') then 'BOL. DOM.'
      when(GVC_ID_SERVICIO = 'BD') then 'BOL. DOM.'
      when(GVC_ID_SERVICIO = 'CALAFIA') then 'BOL. DOM.'
      when(GVC_ID_SERVICIO = 'CALAFIAFR') then 'BOL. DOM.'
      when(GVC_ID_SERVICIO = 'BI') then 'BOL. INT.'
      when(GVC_ID_SERVICIO = 'CS') then 'CARGO X SERV.'
      when(GVC_ID_SERVICIO = 'INGBUS') then 'CARGO X SERV. AUTOBUS'
      when(GVC_ID_SERVICIO = 'CSFE') then 'CARGO X SERV. CFDI'
      when(GVC_ID_SERVICIO = 'CSE') then 'CARGO X SERV. EME'
      when(GVC_ID_SERVICIO = 'CHR') then 'CHARTER'
      when(GVC_ID_SERVICIO = 'CHR-10') then 'CHARTER'
      when(GVC_ID_SERVICIO = 'CHR-T0') then 'CHARTER'
      when(GVC_ID_SERVICIO = 'FPCH15') then 'CHARTER'
      when(GVC_ID_SERVICIO = 'FPCHT0') then 'CHARTER'
      when(GVC_ID_SERVICIO = 'CCRU10') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'CCRU15') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'CCRUT0') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'CRUCER') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'CRUCER-T0') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'FCRU15') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'FCRUT0') then 'CRUCERO'
      when(GVC_ID_SERVICIO = 'INGXPCV') then 'CRUCERO ING. X RESERV.'
      when(GVC_ID_SERVICIO = 'DEBITO') then 'DEBITO'
      when(GVC_ID_SERVICIO = 'CUPONHTL') then 'HOTEL ING. X RESERV.'
      when(GVC_ID_SERVICIO = 'INGXAH') then 'HOTEL ING. X RESERV.'
      when(GVC_ID_SERVICIO = 'FH0T15') then 'HOTEL INGRESOS POR RESERV.'
      when(GVC_ID_SERVICIO = 'FHOTT0') then 'HOTEL INGRESOS POR RESERV.'
      when(GVC_ID_SERVICIO = 'HOTINT') then 'HOTEL INT.'
      when(GVC_ID_SERVICIO = 'HOTINT-T0') then 'HOTEL INT.'
      when(GVC_ID_SERVICIO = 'HOTNAC') then 'HOTEL NAC.'
      when(GVC_ID_SERVICIO = 'HOTNAC-10') then 'HOTEL NAC.'
      when(GVC_ID_SERVICIO = 'INCENTIVOS') then 'INCENTIVOS'
      when(GVC_ID_SERVICIO = 'INGUTC') then 'INGRESO X USO TDC'
      when(GVC_ID_SERVICIO = 'FSES15') then 'INGRESOS X SER ESP'
      when(GVC_ID_SERVICIO = 'FSEST0') then 'INGRESOS X SER ESP'
      when(GVC_ID_SERVICIO = 'INGXSE') then 'INGRESOS X SER ESP'
      when(GVC_ID_SERVICIO = 'NAVCAR') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVCAR-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVCCR') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVCCR-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVCRI') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVCRI-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVMSC') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVMSC-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVNCR') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVNCR-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVOSC') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVOSC-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVPUL') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVPUL-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVRCA') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NAVRCA-T0') then 'NAVIERA'
      when(GVC_ID_SERVICIO = 'NOTCRE') then 'NOTA CREDITO'
      when(GVC_ID_SERVICIO = 'OPEVIA') then 'OPER. VICA'
      when(GVC_ID_SERVICIO = 'OVIAJE') then 'OPER. VICA'
      when(GVC_ID_SERVICIO = 'OVIAJEFR') then 'OPER. VICA'
      when(GVC_ID_SERVICIO = 'OVIAJET0') then 'OPER. VICA'
      when(GVC_ID_SERVICIO = 'FOPVIA') then 'OPERADORA'
      when(GVC_ID_SERVICIO = 'FOPVIAT0') then 'OPERADORA'
      when(GVC_ID_SERVICIO = 'OTROSO') then 'OTROS'
      when(GVC_ID_SERVICIO = 'OTROSO-10') then 'OTROS'
      when(GVC_ID_SERVICIO = 'OTROSO-T0') then 'OTROS'
      when(GVC_ID_SERVICIO = 'ASSIST') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'ASSIST-T0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'AXASEG') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'CSEG10') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'CSEG15') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'CSEGT0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'EURASS') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'EURASS-T0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'INGSEG') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'INTSEG') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'INTSEG-T0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'PS') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'SEGLAT') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'SEGURO') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'SEGU-T0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'SEGVIA') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'SEGVIA-T0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'WASSIT') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'WASSIT-T0') then 'POLIZA'
      when(GVC_ID_SERVICIO = 'PROP') then 'PROPINA'
      when(GVC_ID_SERVICIO = 'RENAFR') then 'RENTA AUTO'
      when(GVC_ID_SERVICIO = 'RENAT0') then 'RENTA AUTO'
      when(GVC_ID_SERVICIO = 'RENAUT') then 'RENTA AUTO'
      when(GVC_ID_SERVICIO = 'SEVAR') then 'SERV. ESP.'
      when(GVC_ID_SERVICIO = 'SEVAR-T0') then 'SERV. ESP.'
      when(GVC_ID_SERVICIO = 'CTRA10') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'CTRA15') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'CTRAT0') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'FTRA15') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'FTRAT0') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TR') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAAIR') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAAUA') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRACAS') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAETG') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAETN') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAETN') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAEXC') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAGDN') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAGOL') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRALIZ') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRANOV') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAPTO') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAPTO-T0') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRASUB') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRATCE') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRATOT') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRATPS') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRATTE') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRAVIP') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TVILIZ') then 'TRANSP.'
      when(GVC_ID_SERVICIO = 'TRENFR') then 'TREN'
      when(GVC_ID_SERVICIO = 'TRENSE') then 'TREN'
      when(GVC_ID_SERVICIO = 'TRENT0') then 'TREN'
      when(GVC_ID_SERVICIO = 'CTREFR') then 'TREN PASE'
      when(GVC_ID_SERVICIO = 'CTREN') then 'TREN PASE'
      when(GVC_ID_SERVICIO = 'CTRET0') then 'TREN PASE'
      when(GVC_ID_SERVICIO = 'TRONDEN') then 'TRONDEN'
      when(GVC_ID_SERVICIO = 'VIRTUOSO') then 'VIRTUOSO'
      when(GVC_ID_SERVICIO = 'TRAVISA-10') then 'VISA'
      when(GVC_ID_SERVICIO = 'TRAVISA-T0') then 'VISA'
      when(GVC_ID_SERVICIO = 'TRVISA') then 'VISA'
      end),convert(varchar,GVC_ID_PROVEEDOR),
      convert(varchar,BOLETO_EMD),
      convert(varchar,GVC_ALCANCE_SERVICIO),
      convert(varchar,GVC_CONCEPTO),
      convert(varchar,GVC_NOM_PAX),
      GVC_TARIFA_MON_BASE=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_TARIFA_MON_BASE) else convert(varchar,GVC_TARIFA_MON_BASE)
      end,
      GVC_TARIFA_MON_EXT=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_TARIFA_MON_EXT) else convert(varchar,GVC_TARIFA_MON_EXT)
      end,convert(varchar,GVC_DESCUENTO),
      convert(varchar,GVC_IVA_DESCUENTO),
      convert(varchar,GVC_COM_AGE),
      convert(varchar,GVC_POR_COM_AGE),
      convert(varchar,GVC_COM_TIT),
      convert(varchar,GVC_POR_COM_TIT),
      convert(varchar,GVC_COM_AUX),
      convert(varchar,GVC_POR_COM_AUX),
      convert(varchar,GVC_POR_IVA_COM),
      GVC_IVA=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_IVA) else convert(varchar,GVC_IVA)
      end,
      GVC_TUA=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_TUA) else convert(varchar,GVC_TUA)
      end,
      GVC_OTROS_IMPUESTOS=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_OTROS_IMPUESTOS) else convert(varchar,GVC_OTROS_IMPUESTOS)
      end,
      GVC_SUMA_IMPUESTOS=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_SUMA_IMPUESTOS) else convert(varchar,GVC_SUMA_IMPUESTOS)
      end,
      GVC_IVA_EXT=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_IVA_EXT) else convert(varchar,GVC_IVA_EXT)
      end,
      GVC_TUA_EXT=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_TUA_EXT) else convert(varchar,GVC_TUA_EXT)
      end,
      GVC_OTR_EXT=case when(convert(varchar,GVC_TIPO_DOCUMENTO) = 'DN' or convert(varchar,GVC_TIPO_DOCUMENTO) = 'NC') then '-'+convert(varchar,GVC_OTR_EXT) else convert(varchar,GVC_OTR_EXT)
      end,
      total=(convert(real,GVC_TARIFA_MON_BASE)+convert(real,GVC_IVA)+convert(real,GVC_TUA)+convert(real,GVC_OTROS_IMPUESTOS)),
      convert(varchar,GVC_CVE_SUCURSAL),
      convert(varchar,GVC_NOM_SUCURSAL),
      convert(varchar,GVC_TARIFA_COMPARATIVA_BOLETO),
      convert(varchar,GVC_TARIFA_COMPARATIVA_BOLETO_EXT),
      convert(varchar,GVC_CLASE_FACTURADA),
      convert(varchar,GVC_CLASE_COMPARATIVO),
      convert(varchar,GVC_FECHA_SALIDA),
      convert(varchar,GVC_FECHA_REGRESO),
      convert(varchar,GVC_FECHA_EMISION_BOLETO),
      convert(varchar,GVC_CLAVE_EMPLEADO),
      convert(varchar,GVC_FOR_PAG1),
      convert(varchar,GVC_FOR_PAG2),
      convert(varchar,GVC_FOR_PAG3),
      convert(varchar,GVC_FOR_PAG4),
      convert(varchar,GVC_FOR_PAG5),
      convert(varchar,GVC_FAC_NUMERO),
      convert(varchar,GVC_ID_SERIE_FAC),
      convert(varchar,GVC_FAC_CVE_SUCURSAL) from
      Martha_GVC_Reporteador_BOL2 where GVC_FECHA between '".$fecha1."' and '".$fecha2."' ";


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

              $select1 = $select1 . "and GVC_ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select1 = $select1 . "and GVC_ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_cliente > 0){

              $select1 = $select1 . "and GVC_ID_CLIENTE in (".$str_cli.") "; 

         }
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and GVC_ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and GVC_ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and GVC_ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and GVC_ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select1 = $select1 . "and GVC_ID_SUCURSAL in (".$str_suc.") ";

        }
        if($cont_cliente > 0){

              $select1 = $select1 . "and GVC_ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select1 = $select1 . " and GVC_ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select1 = $select1 . " and GVC_ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select1 = $select1 . " and GVC_ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select1 = $select1 . " and GVC_ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

    }

    $this->db->query($select1);

    $select2 = "select name=case when(GVC_ID_SERVICIO = 'BOL. DOM.' or GVC_ID_SERVICIO = 'BOL. INT.' or GVC_ID_SERVICIO = 'HOTEL INT.' or GVC_ID_SERVICIO = 'TRANSP.' or GVC_ID_SERVICIO = 'CARGO X SERV.') then GVC_ID_SERVICIO
    else 'OTROS2' end,y=SUM(case when(GVC_TARIFA_MON_BASE = '0.00') then 0 else convert(numeric,GVC_TARIFA_MON_BASE) end),total_boletos=SUM(case when(total >= 0) then 1 else-1 end) from
    #NombreTabla6 where 1=1
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

              $select2 = $select2 . "and GVC_ID_CLIENTE in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select2 = $select2 . "and GVC_ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_cliente > 0){

              $select2 = $select2 . "and GVC_ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and GVC_ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and GVC_ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select2 = $select2 . " and GVC_ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and GVC_ID_PROVEEDOR in (".$str_prov.") "; //ya

         }

        
    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select2 = $select2 . "and GVC_ID_SUCURSAL in (".$str_suc.") ";

         }
        if($cont_cliente > 0){

              $select2 = $select2 . "and GVC_ID_CLIENTE in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select2 = $select2 . " and GVC_ID_CORPORATIVO in (".$str_corp.") "; //ya

         }
         if($cont_serie > 0){  //ya

              $select2 = $select2 . " and GVC_ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_servicio > 0){

              $select2 = $select2 . " and GVC_ID_SERVICIO in (".$str_serv.") "; //ya

         }
         if($cont_provedor > 0){

              $select2 = $select2 . " and GVC_ID_PROVEEDOR in (".$str_prov.") "; //ya

         }


    }
   
   $select2 = $select2 . "group by(case when(GVC_ID_SERVICIO = 'BOL. DOM.' or GVC_ID_SERVICIO = 'BOL. INT.' or GVC_ID_SERVICIO = 'HOTEL INT.' or GVC_ID_SERVICIO = 'TRANSP.' or GVC_ID_SERVICIO = 'CARGO X SERV.') then GVC_ID_SERVICIO
    else 'OTROS2' end)";


    $query_rows = $this->db->query($select2);

    $result = $query_rows->result();

    $this->db->query("drop table #NombreTabla6");

    return $result;

   }


   public function get_razon_social_id_in($ids_cliente){

      $ids_cliente = implode(",", $ids_cliente);
                
      $query = $this->db->query("SELECT distinct nombre_cliente FROM clientes where id_cliente in ($ids_cliente)");

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

   public function prueba_mach(){

     $query = $this->db->query("execute sp_vt_gastos_gen_mach");


     return $query->result_array();

    
   }

   public function prueba_mach_dup(){

     $query = $this->db->query("execute sp_vt_gastos_gen_mach_dup");

     return $query->result_array();

   }
  
}