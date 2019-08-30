<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '2000000M');


class Mod_reportes_gvc_reporteador_net extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database('default');
      $this->load->library('lib_intervalos_fechas');
      $this->load->library('lib_letras_excel');
   }
   

   public function get_columnas($id_plantilla,$id_reporte){

      $db_prueba = $this->load->database('conmysql', TRUE);

      if($id_plantilla == 0){

        $query = $db_prueba->query("SELECT 

       case  nombre_columna_vista 
       when 'GVC_DOC_NUMERO' then  'DOCUMENTO'
       when 'GVC_ID_SUCURSAL' then 'ID SUCURSAL'
       when 'GVC_ID_SERIE' then 'SERIE'
       when 'GVC_ID_CORPORATIVO' then 'ID CORPORATIVO'
       when 'GVC_NOM_CORP' then 'NOMBRE CORPORATIVO'
       when 'GVC_ID_CLIENTE' then 'CLIENTE'
       when 'GVC_NOM_CLI' then 'NOMBRE CLIENTE'
       when 'GVC_ID_CENTRO_COSTO' then 'CC'
       when 'GVC_DESC_CENTRO_COSTO' then 'DESC CC'
       when 'GVC_ID_DEPTO' then 'DEPTO'
       when 'GVC_DEPTO' then 'DESC DEPTO'
       when 'GVC_ID_VEN_TIT' then 'ID VEN TITULAR'
       when 'GVC_NOM_VEN_TIT' then 'NOM VEN TITULAR'
       when 'GVC_ID_VEN_AUX' then 'ID VEN AUXILIAR'
       when 'GVC_NOM_VEN_AUX' then 'NOM VEN AUXILIAR'
       when 'GVC_ID_CIUDAD' then 'CIUDAD CLIENTE'
       when 'GVC_FECHA' then 'FECHA DOCUMENTO'
       when 'GVC_MONEDA' then 'MONEDA'
       when 'GVC_TIPO_CAMBIO' then 'TIPO DE CAMBIO'
       when 'GVC_SOLICITO' then 'SOLICITO'
       when 'GVC_CVE_RES_GLO' then 'CVE RESERVACION'
       when 'analisis1_cliente' then 'DATO 1'
       when 'analisis2_cliente' then 'DATO 2'
       when 'analisis3_cliente' then 'DATO 3'
       when 'analisis4_cliente' then 'DATO 4'
       when 'analisis5_cliente' then 'DATO 5'
       when 'analisis6_cliente' then 'DATO 6'
       when 'analisis7_cliente' then 'DATO 7'
       when 'analisis8_cliente' then 'DATO 8'
       when 'analisis9_cliente' then 'DATO 9'
       when 'analisis10_cliente' then 'DATO 10'
       when 'analisis11_cliente' then 'DATO 11'
       when 'analisis12_cliente' then 'DATO 12'
       when 'analisis13_cliente' then 'DATO 13'
       when 'analisis14_cliente' then 'DATO 14'
       when 'analisis15_cliente' then 'DATO 15'
       when 'analisis16_cliente' then 'DATO 16'
       when 'analisis17_cliente' then 'DATO 17'
       when 'analisis18_cliente' then 'DATO 18'
       when 'analisis19_cliente' then 'DATO 19'
       when 'analisis20_cliente' then 'DATO 20'
       when 'analisis21_cliente' then 'DATO 21'
       when 'analisis22_cliente' then 'DATO 22'
       when 'analisis23_cliente' then 'DATO 23'
       when 'analisis24_cliente' then 'DATO 24'
       when 'analisis25_cliente' then 'DATO 25'
       when 'analisis26_cliente' then 'DATO 26'
       when 'analisis27_cliente' then 'DATO 27'
       when 'analisis28_cliente' then 'DATO 28'
       when 'analisis29_cliente' then 'DATO 29'
       when 'analisis30_cliente' then 'DATO 30'
       when 'analisis31_cliente' then 'DATO 31'
       when 'analisis32_cliente' then 'DATO 32'
       when 'analisis33_cliente' then 'DATO 33'
       when 'analisis34_cliente' then 'DATO 34'
       when 'analisis35_cliente' then 'DATO 35'
       when 'analisis36_cliente' then 'DATO 36'
       when 'analisis39_cliente' then 'DATO 39'
       when 'confirmacion_la' then 'confirmacion_la'
       when 'analisis40_cliente' then 'DATO 40'
       when 'analisis41_cliente' then 'DATO 41'
       when 'analisis42_cliente' then 'DATO 42'
       when 'analisis43_cliente' then 'DATO 43'
       when 'analisis44_cliente' then 'DATO 44'
       when 'analisis45_cliente' then 'DATO 45'
       when 'analisis46_cliente' then 'DATO 46'
       when 'analisis47_cliente' then 'DATO 47'
       when 'analisis48_cliente' then 'DATO 48'
       when 'analisis49_cliente' then 'DATO 49'
       when 'analisis50_cliente' then 'DATO 50'
       when 'analisis51_cliente' then 'DATO 51'
       when 'analisis52_cliente' then 'DATO 52'
       when 'analisis53_cliente' then 'DATO 53'
       when 'analisis54_cliente' then 'DATO 54'
       when 'analisis55_cliente' then 'DATO 55'
       when 'analisis56_cliente' then 'DATO 56'
       when 'analisis57_cliente' then 'DATO 57'
       when 'analisis58_cliente' then 'DATO 58'
       when 'analisis59_cliente' then 'DATO 59'
       when 'analisis60_cliente' then 'DATO 60'
       when 'TIPO_BOLETO' then 'REVISADO'
       when 'GVC_BOLETO' then 'BOLETO'
       when 'GVC_BOLETO_CXS' then 'BOLETO CXS'
       when 'GVC_ID_SERVICIO' then 'CVE SERVICIO'
       when 'GVC_ID_PROVEEDOR' then 'CVE PROVEEDOR'
       when 'GVC_NOMBRE_PROVEEDOR' then 'NOMBRE PROVEEDOR'
       when 'BOLETO_EMD' then 'EMD'
       when 'GVC_ALCANCE_SERVICIO' then 'ALCANCE SERVICIO'
       when 'GVC_CONCEPTO' then 'CONCEPTO'
       when 'GVC_NOM_PAX' then 'PASAJERO'
       when 'GVC_TARIFA_MON_BASE' then 'TARIFA BASE'
       when 'GVC_TARIFA_MON_EXT' then 'TARIFA BASE USD'
       when 'GVC_DESCUENTO' then 'DESCUENTO'
       when 'GVC_IVA_DESCUENTO' then 'IVA DESCUENTO'
       when 'GVC_COM_AGE' then 'COM AGE'
       when 'GVC_POR_COM_AGE' then 'POR COM AGE'
       when 'GVC_COM_TIT' then 'COM  VEND TIT'
       when 'GVC_POR_COM_TIT' then 'POR COM VEND TIT'
       when 'GVC_COM_AUX' then 'COM VEND AUX'
       when 'GVC_POR_COM_AUX' then 'POR COM VEND AUX'
       when 'GVC_POR_IVA_COM' then 'POR IVA COM'
       when 'GVC_IVA' then 'IVA'
       when 'GVC_TUA' then 'TUA'
       when 'GVC_OTROS_IMPUESTOS' then 'OTROS IMPUESTOS'
       when 'GVC_TOTAL' then 'TOTAL'
       when 'GVC_SUMA_IMPUESTOS' then 'SUMA DE IMPUESTOS'
       when 'GVC_IVA_EXT' then 'IVA USD'
       when 'GVC_TUA_EXT' then 'TUA USD'
       when 'GVC_OTR_EXT' then 'OTROS IMPUESTOS USD'
       when 'GVC_CVE_SUCURSAL' then 'CVE SUCURSAL'
       when 'GVC_NOM_SUCURSAL' then 'NOMBRE SUCURSAL'
       when 'GVC_TARIFA_COMPARATIVA_BOLETO' then 'TARIFA COMPARATIVA BOLETO'
       when 'GVC_TARIFA_COMPARATIVA_BOLETO_EXT' then 'TARIFA COMPARATIVA BOLETO USD'
       when 'GVC_CLASE_FACTURADA' then 'CLASE FACTURADA'
       when 'GVC_CLASE_COMPARATIVO' then 'CLASE COMPARATIVO'
       when 'GVC_FECHA_SALIDA' then 'FECHA SALIDA'
       when 'GVC_FECHA_REGRESO' then 'FECHA REGRESO'
       when 'GVC_FECHA_EMISION_BOLETO' then 'FECHA EMISION BOLETO'
       when 'GVC_CLAVE_EMPLEADO' then 'CLAVE DE EMPLEADO'
       when 'GVC_FOR_PAG1' then 'FORMA DE PAGO 1'
       when 'GVC_FOR_PAG2' then 'FORMA DE PAGO 2'
       when 'GVC_FOR_PAG3' then 'FORMA DE PAGO 3'
       when 'GVC_FOR_PAG4' then 'FORMA DE PAGO 4'
       when 'GVC_FOR_PAG5' then 'FORMA DE PAGO 5'
       when 'GVC_FAC_NUMERO' then 'GVC_FAC_NUMERO'
       when 'GVC_ID_SERIE_FAC' then 'GVC_ID_SERIE_FAC'
       when 'GVC_FAC_CVE_SUCURSAL' then 'GVC_FAC_CVE_SUCURSAL'
       when 'GVC_FAC_NOM_SUCURSAL' then 'GVC_FAC_NOM_SUCURSAL'
       when 'GVC_TIPO_DOCUMENTO' then 'TIPO DE DOCUMENTO'
       when 'GVC_ID_STATUS' then 'ID STATUS DOC'
       when 'GVC_CONSECUTIVO' then 'CONSECUTIVO'
       when 'GVC_TARIFA_OFRECIDA' then 'TARIFA OFRECIDA'
       when 'GVC_CODIGO_RAZON' then 'CODIGO DE RAZON'
       when 'GVC_DESC_CORTA' then 'DESC CORTA'
       when 'GVC_FECHA_RESERVACION' then 'FECHA DE RESERVACION'
       when 'GVC_PRODUCTO' then 'PRODUCTO'
       when 'GVC_CLASES' then 'CLASES POR SEGMENTO'

       end as nombre_columna_vista FROM reportes_villa_tours.rpv_reporte_columnas where id_rep = 4 and status = 1");

      }else{

       $query = $db_prueba->query("SELECT 

       case  nombre_columna_vista 
       when 'GVC_DOC_NUMERO' then  'DOCUMENTO'
       when 'GVC_ID_SUCURSAL' then 'ID SUCURSAL'
       when 'GVC_ID_SERIE' then 'SERIE'
       when 'GVC_ID_CORPORATIVO' then 'ID CORPORATIVO'
       when 'GVC_NOM_CORP' then 'NOMBRE CORPORATIVO'
       when 'GVC_ID_CLIENTE' then 'CLIENTE'
       when 'GVC_NOM_CLI' then 'NOMBRE CLIENTE'
       when 'GVC_ID_CENTRO_COSTO' then 'CC'
       when 'GVC_DESC_CENTRO_COSTO' then 'DESC CC'
       when 'GVC_ID_DEPTO' then 'DEPTO'
       when 'GVC_DEPTO' then 'DESC DEPTO'
       when 'GVC_ID_VEN_TIT' then 'ID VEN TITULAR'
       when 'GVC_NOM_VEN_TIT' then 'NOM VEN TITULAR'
       when 'GVC_ID_VEN_AUX' then 'ID VEN AUXILIAR'
       when 'GVC_NOM_VEN_AUX' then 'NOM VEN AUXILIAR'
       when 'GVC_ID_CIUDAD' then 'CIUDAD CLIENTE'
       when 'GVC_FECHA' then 'FECHA DOCUMENTO'
       when 'GVC_MONEDA' then 'MONEDA'
       when 'GVC_TIPO_CAMBIO' then 'TIPO DE CAMBIO'
       when 'GVC_SOLICITO' then 'SOLICITO'
       when 'GVC_CVE_RES_GLO' then 'CVE RESERVACION'
       when 'analisis1_cliente' then 'DATO 1'
       when 'analisis2_cliente' then 'DATO 2'
       when 'analisis3_cliente' then 'DATO 3'
       when 'analisis4_cliente' then 'DATO 4'
       when 'analisis5_cliente' then 'DATO 5'
       when 'analisis6_cliente' then 'DATO 6'
       when 'analisis7_cliente' then 'DATO 7'
       when 'analisis8_cliente' then 'DATO 8'
       when 'analisis9_cliente' then 'DATO 9'
       when 'analisis10_cliente' then 'DATO 10'
       when 'analisis11_cliente' then 'DATO 11'
       when 'analisis12_cliente' then 'DATO 12'
       when 'analisis13_cliente' then 'DATO 13'
       when 'analisis14_cliente' then 'DATO 14'
       when 'analisis15_cliente' then 'DATO 15'
       when 'analisis16_cliente' then 'DATO 16'
       when 'analisis17_cliente' then 'DATO 17'
       when 'analisis18_cliente' then 'DATO 18'
       when 'analisis19_cliente' then 'DATO 19'
       when 'analisis20_cliente' then 'DATO 20'
       when 'analisis21_cliente' then 'DATO 21'
       when 'analisis22_cliente' then 'DATO 22'
       when 'analisis23_cliente' then 'DATO 23'
       when 'analisis24_cliente' then 'DATO 24'
       when 'analisis25_cliente' then 'DATO 25'
       when 'analisis26_cliente' then 'DATO 26'
       when 'analisis27_cliente' then 'DATO 27'
       when 'analisis28_cliente' then 'DATO 28'
       when 'analisis29_cliente' then 'DATO 29'
       when 'analisis30_cliente' then 'DATO 30'
       when 'analisis31_cliente' then 'DATO 31'
       when 'analisis32_cliente' then 'DATO 32'
       when 'analisis33_cliente' then 'DATO 33'
       when 'analisis34_cliente' then 'DATO 34'
       when 'analisis35_cliente' then 'DATO 35'
       when 'analisis36_cliente' then 'DATO 36'
       when 'analisis39_cliente' then 'DATO 39'
       when 'confirmacion_la' then 'confirmacion_la'
       when 'analisis40_cliente' then 'DATO 40'
       when 'analisis41_cliente' then 'DATO 41'
       when 'analisis42_cliente' then 'DATO 42'
       when 'analisis43_cliente' then 'DATO 43'
       when 'analisis44_cliente' then 'DATO 44'
       when 'analisis45_cliente' then 'DATO 45'
       when 'analisis46_cliente' then 'DATO 46'
       when 'analisis47_cliente' then 'DATO 47'
       when 'analisis48_cliente' then 'DATO 48'
       when 'analisis49_cliente' then 'DATO 49'
       when 'analisis50_cliente' then 'DATO 50'
       when 'analisis51_cliente' then 'DATO 51'
       when 'analisis52_cliente' then 'DATO 52'
       when 'analisis53_cliente' then 'DATO 53'
       when 'analisis54_cliente' then 'DATO 54'
       when 'analisis55_cliente' then 'DATO 55'
       when 'analisis56_cliente' then 'DATO 56'
       when 'analisis57_cliente' then 'DATO 57'
       when 'analisis58_cliente' then 'DATO 58'
       when 'analisis59_cliente' then 'DATO 59'
       when 'analisis60_cliente' then 'DATO 60'
       when 'TIPO_BOLETO' then 'REVISADO'
       when 'GVC_BOLETO' then 'BOLETO'
       when 'GVC_BOLETO_CXS' then 'BOLETO CXS'
       when 'GVC_ID_SERVICIO' then 'CVE SERVICIO'
       when 'GVC_ID_PROVEEDOR' then 'CVE PROVEEDOR'
       when 'GVC_NOMBRE_PROVEEDOR' then 'NOMBRE PROVEEDOR'
       when 'BOLETO_EMD' then 'EMD'
       when 'GVC_ALCANCE_SERVICIO' then 'ALCANCE SERVICIO'
       when 'GVC_CONCEPTO' then 'CONCEPTO'
       when 'GVC_NOM_PAX' then 'PASAJERO'
       when 'GVC_TARIFA_MON_BASE' then 'TARIFA BASE'
       when 'GVC_TARIFA_MON_EXT' then 'TARIFA BASE USD'
       when 'GVC_DESCUENTO' then 'DESCUENTO'
       when 'GVC_IVA_DESCUENTO' then 'IVA DESCUENTO'
       when 'GVC_COM_AGE' then 'COM AGE'
       when 'GVC_POR_COM_AGE' then 'POR COM AGE'
       when 'GVC_COM_TIT' then 'COM  VEND TIT'
       when 'GVC_POR_COM_TIT' then 'POR COM VEND TIT'
       when 'GVC_COM_AUX' then 'COM VEND AUX'
       when 'GVC_POR_COM_AUX' then 'POR COM VEND AUX'
       when 'GVC_POR_IVA_COM' then 'POR IVA COM'
       when 'GVC_IVA' then 'IVA'
       when 'GVC_TUA' then 'TUA'
       when 'GVC_OTROS_IMPUESTOS' then 'OTROS IMPUESTOS'
       when 'GVC_TOTAL' then 'TOTAL'
       when 'GVC_SUMA_IMPUESTOS' then 'SUMA DE IMPUESTOS'
       when 'GVC_IVA_EXT' then 'IVA USD'
       when 'GVC_TUA_EXT' then 'TUA USD'
       when 'GVC_OTR_EXT' then 'OTROS IMPUESTOS USD'
       when 'GVC_CVE_SUCURSAL' then 'CVE SUCURSAL'
       when 'GVC_NOM_SUCURSAL' then 'NOMBRE SUCURSAL'
       when 'GVC_TARIFA_COMPARATIVA_BOLETO' then 'TARIFA COMPARATIVA BOLETO'
       when 'GVC_TARIFA_COMPARATIVA_BOLETO_EXT' then 'TARIFA COMPARATIVA BOLETO USD'
       when 'GVC_CLASE_FACTURADA' then 'CLASE FACTURADA'
       when 'GVC_CLASE_COMPARATIVO' then 'CLASE COMPARATIVO'
       when 'GVC_FECHA_SALIDA' then 'FECHA SALIDA'
       when 'GVC_FECHA_REGRESO' then 'FECHA REGRESO'
       when 'GVC_FECHA_EMISION_BOLETO' then 'FECHA EMISION BOLETO'
       when 'GVC_CLAVE_EMPLEADO' then 'CLAVE DE EMPLEADO'
       when 'GVC_FOR_PAG1' then 'FORMA DE PAGO 1'
       when 'GVC_FOR_PAG2' then 'FORMA DE PAGO 2'
       when 'GVC_FOR_PAG3' then 'FORMA DE PAGO 3'
       when 'GVC_FOR_PAG4' then 'FORMA DE PAGO 4'
       when 'GVC_FOR_PAG5' then 'FORMA DE PAGO 5'
       when 'GVC_FAC_NUMERO' then 'GVC_FAC_NUMERO'
       when 'GVC_ID_SERIE_FAC' then 'GVC_ID_SERIE_FAC'
       when 'GVC_FAC_CVE_SUCURSAL' then 'GVC_FAC_CVE_SUCURSAL'
       when 'GVC_FAC_NOM_SUCURSAL' then 'GVC_FAC_NOM_SUCURSAL'
       when 'GVC_TIPO_DOCUMENTO' then 'TIPO DE DOCUMENTO'
       when 'GVC_ID_STATUS' then 'ID STATUS DOC'
       when 'GVC_CONSECUTIVO' then 'CONSECUTIVO'
       when 'GVC_TARIFA_OFRECIDA' then 'TARIFA OFRECIDA'
       when 'GVC_CODIGO_RAZON' then 'CODIGO DE RAZON'
       when 'GVC_DESC_CORTA' then 'DESC CORTA'
       when 'GVC_FECHA_RESERVACION' then 'FECHA DE RESERVACION'
       when 'GVC_PRODUCTO' then 'PRODUCTO'
       when 'GVC_CLASES' then 'CLASES POR SEGMENTO'

       end as nombre_columna_vista
       
       FROM reportes_villa_tours.rpv_reporte_plantilla_columnas
                                        inner join rpv_reporte_columnas on rpv_reporte_columnas.id = rpv_reporte_plantilla_columnas.id_col
                                        where rpv_reporte_plantilla_columnas.id_plantilla = ".$id_plantilla." and rpv_reporte_plantilla_columnas.status = 1");


      }
      
      
      return $query->result();


   }

   public function get_columns_excel($id_plantilla,$id_reporte){

        if($id_plantilla != 0){

          $plantilla = ' and id in(
                          select id_col from rpv_reporte_plantilla_columnas 
                          where id_plantilla =
                          '.$id_plantilla.' and rpv_reporte_plantilla_columnas.status = 1)';

        }else{


          $plantilla = '';

        }

        $db_prueba = $this->load->database('conmysql', TRUE);


        $query = $db_prueba->query('select * from rpv_reporte_columnas
                                      where  id_rep = '.$id_reporte.$plantilla);
        
        return $query->result();
        

   }


   public function get_reportes_gvc_reporteador_net($parametros){

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
      $id_plantilla = $parametros["id_plantilla"];
      
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
                  
                  $array_campos_query_fc['GVC_DOC_NUMERO'] = 'DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO';
                  $array_campos_query_fc['GVC_ID_SUCURSAL'] = 'DATOS_FACTURA.ID_SUCURSAL as GVC_ID_SUCURSAL';
                  $array_campos_query_fc['GVC_ID_SERIE'] = 'DATOS_FACTURA.ID_SERIE as GVC_ID_SERIE';
                  $array_campos_query_fc['GVC_ID_CORPORATIVO'] = 'CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO';
                  $array_campos_query_fc['GVC_NOM_CORP'] = 'CORPORATIVO.NOMBRE_CORPORATIVO as GVC_NOM_CORP';
                  $array_campos_query_fc['GVC_ID_CLIENTE'] = 'DATOS_FACTURA.ID_CLIENTE as GVC_ID_CLIENTE';
                  $array_campos_query_fc['GVC_NOM_CLI'] = 'DATOS_FACTURA.CL_NOMBRE as GVC_NOM_CLI';
                  $array_campos_query_fc['GVC_ID_CENTRO_COSTO'] = 'DATOS_FACTURA.ID_CENTRO_COSTO as GVC_ID_CENTRO_COSTO';
                  $array_campos_query_fc['GVC_DESC_CENTRO_COSTO'] = 'CENTRO_COSTO.DESC_CENTRO_COSTO as GVC_DESC_CENTRO_COSTO';
                  $array_campos_query_fc['GVC_ID_DEPTO'] = 'DATOS_FACTURA.ID_DEPTO as GVC_ID_DEPTO';
                  $array_campos_query_fc['GVC_DEPTO'] = 'DEPARTAMENTO.DEPTO as GVC_DEPTO';
                  $array_campos_query_fc['GVC_ID_VEN_TIT'] = 'DATOS_FACTURA.ID_VENDEDOR_TIT as GVC_ID_VEN_TIT';
                  $array_campos_query_fc['GVC_NOM_VEN_TIT'] = 'TITULAR.NOMBRE as GVC_NOM_VEN_TIT';
                  $array_campos_query_fc['GVC_ID_VEN_AUX'] = 'DATOS_FACTURA.ID_VENDEDOR_AUX as GVC_ID_VEN_AUX';
                  $array_campos_query_fc['GVC_NOM_VEN_AUX'] = 'AUXILIAR.NOMBRE as GVC_NOM_VEN_AUX';
                  $array_campos_query_fc['GVC_ID_CIUDAD'] = 'DATOS_FACTURA.CL_CIUDAD as GVC_ID_CIUDAD';
                  $array_campos_query_fc['GVC_FECHA'] = 'convert(char(12),convert(datetime,DATOS_FACTURA.FECHA),105) as GVC_FECHA';
                  $array_campos_query_fc['GVC_MONEDA'] = 'DATOS_FACTURA.ID_MONEDA as GVC_MONEDA';
                  $array_campos_query_fc['GVC_TIPO_CAMBIO'] = 'DATOS_FACTURA.TPO_CAMBIO as GVC_TIPO_CAMBIO';
                  $array_campos_query_fc['GVC_SOLICITO'] = 'DATOS_FACTURA.SOLICITO as GVC_SOLICITO';
                  $array_campos_query_fc['GVC_CVE_RES_GLO'] = 'DATOS_FACTURA.CVE_RESERV_GLOBAL as GVC_CVE_RES_GLO';
                  $array_campos_query_fc['analisis1_cliente'] = 'DATOS_FACTURA.ANALISIS1_CLIENTE as analisis1_cliente';
                  $array_campos_query_fc['analisis2_cliente'] = 'DATOS_FACTURA.analisis2_cliente as analisis2_cliente';
                  $array_campos_query_fc['analisis3_cliente'] = 'DATOS_FACTURA.analisis3_cliente as analisis3_cliente';
                  $array_campos_query_fc['analisis4_cliente'] = 'DATOS_FACTURA.analisis4_cliente as analisis4_cliente';
                  $array_campos_query_fc['analisis5_cliente'] = 'DATOS_FACTURA.analisis5_cliente as analisis5_cliente';
                  $array_campos_query_fc['analisis6_cliente'] = 'DATOS_FACTURA.analisis6_cliente as analisis6_cliente';
                  $array_campos_query_fc['analisis7_cliente'] = 'DATOS_FACTURA.analisis7_cliente as analisis7_cliente';
                  $array_campos_query_fc['analisis8_cliente'] = 'DATOS_FACTURA.analisis8_cliente as analisis8_cliente';
                  $array_campos_query_fc['analisis9_cliente'] = 'DATOS_FACTURA.analisis9_cliente as analisis9_cliente';
                  $array_campos_query_fc['analisis10_cliente'] = 'DATOS_FACTURA.analisis10_cliente as analisis10_cliente';
                  $array_campos_query_fc['analisis11_cliente'] = 'DATOS_FACTURA.analisis11_cliente as analisis11_cliente';
                  $array_campos_query_fc['analisis12_cliente'] = 'DATOS_FACTURA.analisis12_cliente as analisis12_cliente';
                  $array_campos_query_fc['analisis13_cliente'] = 'DATOS_FACTURA.analisis13_cliente as analisis13_cliente';
                  $array_campos_query_fc['analisis14_cliente'] = 'DATOS_FACTURA.analisis14_cliente as analisis14_cliente';
                  $array_campos_query_fc['analisis15_cliente'] = 'DATOS_FACTURA.analisis15_cliente as analisis15_cliente';
                  $array_campos_query_fc['analisis16_cliente'] = 'DATOS_FACTURA.analisis16_cliente as analisis16_cliente';
                  $array_campos_query_fc['analisis17_cliente'] = 'DATOS_FACTURA.analisis17_cliente as analisis17_cliente';
                  $array_campos_query_fc['analisis18_cliente'] = 'DATOS_FACTURA.analisis18_cliente as analisis18_cliente';
                  $array_campos_query_fc['analisis19_cliente'] = 'DATOS_FACTURA.analisis19_cliente as analisis19_cliente';
                  $array_campos_query_fc['analisis20_cliente'] = 'DATOS_FACTURA.analisis20_cliente as analisis20_cliente';
                  $array_campos_query_fc['analisis21_cliente'] = 'DATOS_FACTURA.analisis21_cliente as analisis21_cliente';
                  $array_campos_query_fc['analisis22_cliente'] = 'DATOS_FACTURA.analisis22_cliente as analisis22_cliente';
                  $array_campos_query_fc['analisis23_cliente'] = 'DATOS_FACTURA.analisis23_cliente as analisis23_cliente';
                  $array_campos_query_fc['analisis24_cliente'] = 'DATOS_FACTURA.analisis24_cliente as analisis24_cliente';
                  $array_campos_query_fc['analisis25_cliente'] = 'DATOS_FACTURA.analisis25_cliente as analisis25_cliente';
                  $array_campos_query_fc['analisis26_cliente'] = 'DATOS_FACTURA.analisis26_cliente as analisis26_cliente';
                  $array_campos_query_fc['analisis27_cliente'] = 'DATOS_FACTURA.analisis27_cliente as analisis27_cliente';
                  $array_campos_query_fc['analisis28_cliente'] = 'DATOS_FACTURA.analisis28_cliente as analisis28_cliente';
                  $array_campos_query_fc['analisis29_cliente'] = 'DATOS_FACTURA.analisis29_cliente as analisis29_cliente';
                  $array_campos_query_fc['analisis30_cliente'] = 'DATOS_FACTURA.analisis30_cliente as analisis30_cliente';
                  $array_campos_query_fc['analisis31_cliente'] = 'DATOS_FACTURA.analisis31_cliente as analisis31_cliente';
                  $array_campos_query_fc['analisis32_cliente'] = 'DATOS_FACTURA.analisis32_cliente as analisis32_cliente';
                  $array_campos_query_fc['analisis33_cliente'] = 'DATOS_FACTURA.analisis33_cliente as analisis33_cliente';
                  $array_campos_query_fc['analisis34_cliente'] = 'DATOS_FACTURA.analisis34_cliente as analisis34_cliente';
                  $array_campos_query_fc['analisis35_cliente'] = 'DATOS_FACTURA.analisis35_cliente as analisis35_cliente';
                  $array_campos_query_fc['analisis36_cliente'] = 'DATOS_FACTURA.analisis36_cliente as analisis36_cliente';
                  $array_campos_query_fc['analisis39_cliente'] = 'DATOS_FACTURA.analisis39_cliente as analisis39_cliente';
                  $array_campos_query_fc['confirmacion_la'] = 'DETALLE_FACTURA.CLAVE_RESERVACION as confirmacion_la';
                  $array_campos_query_fc['analisis40_cliente'] = 'DATOS_FACTURA.analisis40_cliente as analisis40_cliente';
                  $array_campos_query_fc['analisis41_cliente'] = 'DATOS_FACTURA.analisis41_cliente as analisis41_cliente';
                  $array_campos_query_fc['analisis42_cliente'] = 'DATOS_FACTURA.analisis42_cliente as analisis42_cliente';
                  $array_campos_query_fc['analisis43_cliente'] = 'DATOS_FACTURA.analisis43_cliente as analisis43_cliente';
                  $array_campos_query_fc['analisis44_cliente'] = 'DATOS_FACTURA.analisis44_cliente as analisis44_cliente';
                  $array_campos_query_fc['analisis45_cliente'] = 'DATOS_FACTURA.analisis45_cliente as analisis45_cliente';
                  $array_campos_query_fc['analisis46_cliente'] = 'DATOS_FACTURA.analisis46_cliente as analisis46_cliente';
                  $array_campos_query_fc['analisis47_cliente'] = 'DATOS_FACTURA.analisis47_cliente as analisis47_cliente';
                  $array_campos_query_fc['analisis47_cliente'] = 'DATOS_FACTURA.analisis47_cliente as analisis47_cliente';
                  $array_campos_query_fc['analisis48_cliente'] = 'DATOS_FACTURA.analisis48_cliente as analisis48_cliente';
                  $array_campos_query_fc['analisis49_cliente'] = 'DATOS_FACTURA.analisis49_cliente as analisis49_cliente';
                  $array_campos_query_fc['analisis50_cliente'] = 'DATOS_FACTURA.analisis50_cliente as analisis50_cliente';
                  $array_campos_query_fc['analisis51_cliente'] = 'DATOS_FACTURA.analisis51_cliente as analisis51_cliente';
                  $array_campos_query_fc['analisis52_cliente'] = 'DATOS_FACTURA.analisis52_cliente as analisis52_cliente';
                  $array_campos_query_fc['analisis53_cliente'] = 'DATOS_FACTURA.analisis53_cliente as analisis53_cliente';
                  $array_campos_query_fc['analisis54_cliente'] = 'DATOS_FACTURA.analisis54_cliente as analisis54_cliente';
                  $array_campos_query_fc['analisis55_cliente'] = 'DATOS_FACTURA.analisis55_cliente as analisis55_cliente';
                  $array_campos_query_fc['analisis56_cliente'] = 'DATOS_FACTURA.analisis56_cliente as analisis56_cliente';
                  $array_campos_query_fc['analisis57_cliente'] = 'DATOS_FACTURA.analisis57_cliente as analisis57_cliente';
                  $array_campos_query_fc['analisis58_cliente'] = 'DATOS_FACTURA.analisis58_cliente as analisis58_cliente';
                  $array_campos_query_fc['analisis59_cliente'] = 'DATOS_FACTURA.analisis59_cliente as analisis59_cliente';
                  $array_campos_query_fc['analisis60_cliente'] = 'DATOS_FACTURA.analisis60_cliente as analisis60_cliente';
                  $array_campos_query_fc['TIPO_BOLETO'] = 'DETALLE_FACTURA.contra as TIPO_BOLETO';
                  $array_campos_query_fc['GVC_BOLETO'] = 'DETALLE_FACTURA.NUMERO_BOL as GVC_BOLETO';
                  $array_campos_query_fc['GVC_BOLETO_CXS'] = 'DETALLE_FACTURA.numero_bol_Cxs as GVC_BOLETO_CXS';
                  $array_campos_query_fc['GVC_ID_SERVICIO'] = 'PROV_TPO_SERV.ID_SERVICIO as GVC_ID_SERVICIO';
                  $array_campos_query_fc['GVC_ID_PROVEEDOR'] = 'PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR';
                  $array_campos_query_fc['GVC_NOMBRE_PROVEEDOR'] = 'convert(varchar,PROVEEDORES.NOMBRE) AS GVC_NOMBRE_PROVEEDOR';
                  $array_campos_query_fc['BOLETO_EMD'] = ' DETALLE_FACTURA.EMD as BOLETO_EMD';
                  $array_campos_query_fc['GVC_ALCANCE_SERVICIO'] = 'TIPO_SERVICIO.ID_ALCANCE_SERV as GVC_ALCANCE_SERVICIO';
                  $array_campos_query_fc['GVC_CONCEPTO'] = 'DETALLE_FACTURA.CONCEPTO as GVC_CONCEPTO';
                  $array_campos_query_fc['GVC_NOM_PAX'] = 'DETALLE_FACTURA.NOM_PASAJERO as GVC_NOM_PAX';
                  $array_campos_query_fc['GVC_TARIFA_MON_BASE'] = 'DETALLE_FACTURA.TARIFA_MON_BASE as GVC_TARIFA_MON_BASE';
                  $array_campos_query_fc['GVC_TARIFA_MON_EXT'] = 'DETALLE_FACTURA.TARIFA_MON_CTE as GVC_TARIFA_MON_EXT';
                  $array_campos_query_fc['GVC_DESCUENTO'] = 'DETALLE_FACTURA.DESCUENTO as GVC_DESCUENTO';
                  $array_campos_query_fc['GVC_IVA_DESCUENTO'] = 'ISNULL(DETALLE_FACTURA.IVA_DESC,0) as GVC_IVA_DESCUENTO';
                  $array_campos_query_fc['GVC_COM_AGE'] = 'DETALLE_FACTURA.COMISION_AGENT as GVC_COM_AGE';
                  $array_campos_query_fc['GVC_POR_COM_AGE'] = 'DETALLE_FACTURA.POR_COMISION_AGENT as GVC_POR_COM_AGE';
                  $array_campos_query_fc['GVC_COM_TIT'] = 'DETALLE_FACTURA.COMIS_TIT as GVC_COM_TIT';
                  $array_campos_query_fc['GVC_POR_COM_TIT'] = 'DETALLE_FACTURA.POR_COMIS_TIT as GVC_POR_COM_TIT';
                  $array_campos_query_fc['GVC_COM_AUX'] = 'DETALLE_FACTURA.COMIS_AUX as GVC_COM_AUX';
                  $array_campos_query_fc['GVC_POR_COM_AUX'] = 'DETALLE_FACTURA.POR_COMIS_AUX as GVC_POR_COM_AUX';
                  $array_campos_query_fc['GVC_POR_IVA_COM'] = 'DETALLE_FACTURA.POR_IVAS_COMIS as GVC_POR_IVA_COM';
                  $array_campos_query_fc['GVC_IVA'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_IVA";
                  $array_campos_query_fc['GVC_TUA'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_TUA";
                  $array_campos_query_fc['GVC_OTROS_IMPUESTOS'] = "(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
                    DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
                    CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
                    CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) as GVC_OTROS_IMPUESTOS";
                  $array_campos_query_fc['GVC_TOTAL'] = "DETALLE_FACTURA.TARIFA_MON_BASE+(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
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
                    IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA) AS GVC_TOTAL";
                  $array_campos_query_fc['GVC_SUMA_IMPUESTOS'] = 'DETALLE_FACTURA.SUM_IMP as GVC_SUMA_IMPUESTOS';
                  $array_campos_query_fc['GVC_IVA_EXT'] = 'case when(DATOS_FACTURA.TPO_CAMBIO = 0) then 0
                  else GVC_IVA/DATOS_FACTURA.TPO_CAMBIO
                  end as GVC_IVA_EXT';
                  $array_campos_query_fc['GVC_TUA_EXT'] = 'case when(DATOS_FACTURA.TPO_CAMBIO = 0) then 0
                  else GVC_TUA/DATOS_FACTURA.TPO_CAMBIO
                  end as GVC_TUA_EXT';
                  $array_campos_query_fc['GVC_OTR_EXT'] = 'case when(DATOS_FACTURA.TPO_CAMBIO = 0) then 0
                  else GVC_OTROS_IMPUESTOS/DATOS_FACTURA.TPO_CAMBIO
                  end as GVC_OTR_EXT';

                  $array_campos_query_fc['GVC_CVE_SUCURSAL'] = 'SUCURSALES.CVE as GVC_CVE_SUCURSAL';
                  $array_campos_query_fc['GVC_NOM_SUCURSAL'] = 'SUCURSALES.NOMBRE as GVC_NOM_SUCURSAL';

                  $array_campos_query_fc['GVC_TARIFA_COMPARATIVA_BOLETO'] = 'case when(GVC_TARIFA_MON_BASE = 0) then 0
                  when(CONCECUTIVO_BOLETOS.IMP_CRE = 0 or CONCECUTIVO_BOLETOS.IMP_CRE is null) then GVC_TARIFA_MON_BASE
                  else
                    CONCECUTIVO_BOLETOS.IMP_CRE
                  end as GVC_TARIFA_COMPARATIVA_BOLETO';
                  $array_campos_query_fc['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'] = 'case when(DATOS_FACTURA.TPO_CAMBIO = 0) then 0
                  else(GVC_TARIFA_COMPARATIVA_BOLETO/DATOS_FACTURA.TPO_CAMBIO)
                  end as GVC_TARIFA_COMPARATIVA_BOLETO_EXT';
                  $array_campos_query_fc['GVC_CLASE_FACTURADA'] = 'CONCECUTIVO_BOLETOS.CLA_FAC as GVC_CLASE_FACTURADA';
                  $array_campos_query_fc['GVC_CLASE_COMPARATIVO'] = 'CONCECUTIVO_BOLETOS.CLA_NOR as GVC_CLASE_COMPARATIVO';
                  $array_campos_query_fc['GVC_FECHA_SALIDA'] = 'convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as GVC_FECHA_SALIDA';
                  $array_campos_query_fc['GVC_FECHA_REGRESO'] = 'convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_REG),105) as GVC_FECHA_REGRESO';
                  $array_campos_query_fc['GVC_FECHA_EMISION_BOLETO'] = 'convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_EMI),105) as GVC_FECHA_EMISION_BOLETO';
                  $array_campos_query_fc['GVC_CLAVE_EMPLEADO'] = 'DETALLE_FACTURA.cla_pax as GVC_CLAVE_EMPLEADO';
                  $array_campos_query_fc['GVC_FOR_PAG1'] = '(select top 1 ID_FORMA_PAGO from DBA.FOR_PGO_FAC where
                    FOR_PGO_FAC.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
                    FOR_PGO_FAC.ID_SERIE = DATOS_FACTURA.ID_SERIE and
                    FOR_PGO_FAC.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO) as GVC_FOR_PAG1';
                  $array_campos_query_fc['GVC_FOR_PAG2'] = '0 as GVC_FOR_PAG2';
                  $array_campos_query_fc['GVC_FOR_PAG3'] = '0 as GVC_FOR_PAG3';
                  $array_campos_query_fc['GVC_FOR_PAG4'] = '0 as GVC_FOR_PAG4';
                  $array_campos_query_fc['GVC_FOR_PAG5'] = '0 as GVC_FOR_PAG5';
                  $array_campos_query_fc['GVC_FAC_NUMERO'] = 'null as GVC_FAC_NUMERO';
                  $array_campos_query_fc['GVC_ID_SERIE_FAC'] = 'null as GVC_ID_SERIE_FAC';


                  $array_campos_query_fc['GVC_FAC_CVE_SUCURSAL'] = 'null as GVC_FAC_CVE_SUCURSAL';
                  $array_campos_query_fc['GVC_FAC_NOM_SUCURSAL'] = 'null as GVC_FAC_NOM_SUCURSAL';


                  $array_campos_query_fc['GVC_TIPO_DOCUMENTO'] = "'FAC' as GVC_TIPO_DOCUMENTO";
                  $array_campos_query_fc['GVC_ID_STATUS'] = 'DATOS_FACTURA.ID_STAT as GVC_ID_STATUS';
                  $array_campos_query_fc['GVC_CONSECUTIVO'] = 'DATOS_FACTURA.CONSECUTIVO as GVC_CONSECUTIVO';
                  $array_campos_query_fc['GVC_TARIFA_OFRECIDA'] = 'case when(GDS_VUELOS.TARIFA_OFRECIDA = 0 or GDS_VUELOS.TARIFA_OFRECIDA is null) then GVC_TARIFA_MON_BASE
                  else
                    GDS_VUELOS.TARIFA_OFRECIDA
                  end as GVC_TARIFA_OFRECIDA';
                  $array_campos_query_fc['GVC_CODIGO_RAZON'] = 'GDS_VUELOS.CODIGO_RAZON as GVC_CODIGO_RAZON';
                  $array_campos_query_fc['GVC_DESC_CORTA'] = 'GDS_JUSTIFICACION_TARIFAS.DESC_CORTA as GVC_DESC_CORTA';
                  $array_campos_query_fc['GVC_FECHA_RESERVACION'] = "case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else  convert(char(12),convert(datetime,GDS_GENERAL.FECHA_RESERVACION),105) end  as GVC_FECHA_RESERVACION";
                  $array_campos_query_fc['GVC_PRODUCTO'] = 'TIPO_SERVICIO.PRODUCTO as GVC_PRODUCTO';
                  $array_campos_query_fc['GVC_CLASES'] = 'GDS_VUELOS.CLASES as GVC_CLASES';

                  //*****************************************************************
                  
                  $str_campos_query_fc_nombre_col = "";
                  $str_campos_query_fc_create = "";
                  $str_campos_query_fc="";

                  if($id_plantilla == 0){

                      $cont = 1;
                      $cont_total = count($array_campos_query_fc);

                      foreach ($array_campos_query_fc as $clave2 => $valor2) {  

                            if($cont_total == $cont){

                              $str_campos_query_fc_nombre_col = $str_campos_query_fc_nombre_col . $clave2;
                              $str_campos_query_fc_create = $str_campos_query_fc_create . $clave2 . ' varchar(500) null';
                              $str_campos_query_fc = $str_campos_query_fc . $valor2;

                            }else{

                              $str_campos_query_fc_nombre_col = $str_campos_query_fc_nombre_col . $clave2 . ',';
                              $str_campos_query_fc_create = $str_campos_query_fc_create . $clave2 . ' varchar(500) null,';
                              $str_campos_query_fc = $str_campos_query_fc . $valor2 . ',';

                              $cont++;

                            } 
                            
                      }


                  }else{

                      

                      $plantilla = $db_prueba->query("SELECT nombre_columna_vista FROM rpv_reporte_plantilla_columnas
                      inner join rpv_reporte_columnas on rpv_reporte_plantilla_columnas.id_col = rpv_reporte_columnas.id where rpv_reporte_plantilla_columnas.status = 1 and rpv_reporte_plantilla_columnas.id_plantilla = ".$id_plantilla);
                      
                      $plantilla = $plantilla->result_array();
                      

                      $cont = 1;
                      $cont_total = count($plantilla);

                      foreach ($plantilla as $clave1 => $valor1) {  
                        
                        $nombre_campo1 =  ltrim(rtrim($valor1["nombre_columna_vista"]));

                        //*****************************
                            

                                  foreach ($array_campos_query_fc as $clave2 => $valor2) {  

                                    $nombre_campo2 =  ltrim(rtrim($clave2));
                      
                                      if( $nombre_campo1 == $nombre_campo2 ){
                                       
                                            if($cont_total == $cont){  //CUANDO ES EL ULTIMO CAMPO

                                              //if($nombre_campo2 != 'GVC_DOC_NUMERO'){

                                                  $str_campos_query_fc_nombre_col = $str_campos_query_fc_nombre_col . $clave2;
                                                  $str_campos_query_fc_create = $str_campos_query_fc_create . $clave2 . ' varchar(500) null';
                                                  $str_campos_query_fc = $str_campos_query_fc . $valor2;

                                              //}

                                            }else{

                                              //if($nombre_campo2 != 'GVC_DOC_NUMERO'){

                                                  $str_campos_query_fc_nombre_col = $str_campos_query_fc_nombre_col . $clave2 . ',';
                                                  $str_campos_query_fc_create = $str_campos_query_fc_create . $clave2 . ' varchar(500) null,';
                                                  $str_campos_query_fc = $str_campos_query_fc . $valor2 . ',';
                                              
                                              //}

                                            }

                                            $cont++;

                                      }
                                     
                                  }

                        //*****************************

                      }

                  }
                  
                  $this->db->query("create table #TEMPFAC(
                  GVC_DOC_NUMERO_VALIDACION varchar(100) null,
                  ".$str_campos_query_fc_create."
                  )");  
                  

                  $ultimaletra = substr($str_campos_query_fc, -1);

                  if($ultimaletra == ','){

                    $str_campos_query_fc = substr($str_campos_query_fc, 0, -1);


                  }
                  
                  $valida_cantidad = "select count(*) as contador
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
                  ";
                  
                  $select1 = "insert into #TEMPFAC select DATOS_FACTURA.FAC_NUMERO as GVC_DOC_NUMERO_VALIDACION,".$str_campos_query_fc."
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
                  not DBA.DATOS_FACTURA.ID_SERIE = any(select ID_SERIE from DBA.GDS_CXS where EN_OTRA_SERIE = 'A')";

                  if($id_intervalo == '5'){

                    $condicion_fecha = 'DATOS_FACTURA.fecha_folio';

                  }else{

                    $condicion_fecha = 'DATOS_FACTURA.FECHA';

                  }

                  $select1 = $select1." 
                  and ".$condicion_fecha." between cast('".$fecha1."' as date) and cast('".$fecha2."' as date)
                  ";
                  $valida_cantidad = $valida_cantidad." 
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

                            $select1 = $select1 . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya
                            $valida_cantidad = $valida_cantidad . "and DATOS_FACTURA.ID_CLIENTE in (".$id_cliente_arr.") "; //ya

                       }
                       if($cont_suc > 0){

                            $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";
                            $valida_cantidad = $valida_cantidad . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

                       }
                       if($cont_cliente > 0){

                            $select1 = $select1 . "and CLIENTES.id_cliente in (".$str_cli.") "; 
                            $valida_cantidad = $valida_cantidad . "and CLIENTES.id_cliente in (".$str_cli.") "; 


                       }
                       if($cont_corporativo > 0){  //ya

                            $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

                       }
                       if($cont_serie > 0){  //ya

                            $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya


                       }
                       if($cont_servicio > 0){

                            $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

                       }
                       if($cont_provedor > 0){

                            $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

                       }
                       

                  }else if($all_dks == 1){

                      if($cont_suc > 0){

                            $select1 = $select1 . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";
                            $valida_cantidad = $valida_cantidad . "and DATOS_FACTURA.ID_SUCURSAL in (".$str_suc.") ";

                      }
                      if($cont_cliente > 0){

                            $select1 = $select1 . "and DATOS_FACTURA.ID_CLIENTE in (".$str_cli.") "; 
                            $valida_cantidad = $valida_cantidad . "and DATOS_FACTURA.ID_CLIENTE in (".$str_cli.") "; 


                       }
                       if($cont_corporativo > 0){  //ya

                            $select1 = $select1 . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and CLIENTES.ID_CORPORATIVO in (".$str_corp.") "; //ya

                       }
                       if($cont_serie > 0){  //ya

                            $select1 = $select1 . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and DATOS_FACTURA.ID_SERIE in (".$str_ser.") "; //ya

                       }
                       if($cont_servicio > 0){

                            $select1 = $select1 . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and PROV_TPO_SERV.ID_SERVICIO in (".$str_serv.") "; //ya

                       }
                       if($cont_provedor > 0){

                            $select1 = $select1 . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya
                            $valida_cantidad = $valida_cantidad . " and PROV_TPO_SERV.ID_PROVEEDOR in (".$str_prov.") "; //ya

                       }

                  }

                  $array_campos_query_nc['GVC_ID_SUCURSAL'] = 'NOTAS_CREDITO.ID_SUCURSAL as GVC_ID_SUCURSAL';
                  $array_campos_query_nc['GVC_ID_SERIE'] = 'NOTAS_CREDITO.ID_SERIE as GVC_ID_SERIE';
                  $array_campos_query_nc['GVC_DOC_NUMERO'] = 'NOTAS_CREDITO.NC_NUMERO as GVC_DOC_NUMERO';
                  $array_campos_query_nc['GVC_ID_CORPORATIVO'] = 'CORPORATIVO.ID_CORPORATIVO as GVC_ID_CORPORATIVO';
                  $array_campos_query_nc['GVC_NOM_CORP'] = 'CORPORATIVO.NOMBRE_CORPORATIVO as GVC_NOM_CORP';
                  $array_campos_query_nc['GVC_ID_CLIENTE'] = 'NOTAS_CREDITO.ID_CLIENTE as GVC_ID_CLIENTE';
                  $array_campos_query_nc['GVC_NOM_CLI'] = 'NOTAS_CREDITO.CL_NOMBRE as GVC_NOM_CLI';
                  $array_campos_query_nc['GVC_ID_CENTRO_COSTO'] = 'NOTAS_CREDITO.ID_CENCOS as GVC_ID_CENTRO_COSTO';
                  $array_campos_query_nc['GVC_DESC_CENTRO_COSTO'] = 'CENTRO_COSTO.DESC_CENTRO_COSTO as GVC_DESC_CENTRO_COSTO';
                  $array_campos_query_nc['GVC_ID_DEPTO'] = 'NOTAS_CREDITO.ID_DEPTO as GVC_ID_DEPTO';
                  $array_campos_query_nc['GVC_DEPTO'] = 'DEPARTAMENTO.DEPTO as GVC_DEPTO';
                  $array_campos_query_nc['GVC_ID_VEN_TIT'] = 'NOTAS_CREDITO.ID_VENDEDOR as GVC_ID_VEN_TIT';
                  $array_campos_query_nc['GVC_NOM_VEN_TIT'] = 'TITULAR.NOMBRE as GVC_NOM_VEN_TIT';
                  $array_campos_query_nc['GVC_ID_VEN_AUX'] = 'NOTAS_CREDITO.ID_VENAUX as GVC_ID_VEN_AUX';
                  $array_campos_query_nc['GVC_NOM_VEN_AUX'] = 'AUXILIAR.NOMBRE as GVC_NOM_VEN_AUX';
                  $array_campos_query_nc['GVC_ID_CIUDAD'] = 'NOTAS_CREDITO.CL_CIUDAD as GVC_ID_CIUDAD';
                  $array_campos_query_nc['GVC_FECHA'] = 'convert(char(12),convert(datetime,NOTAS_CREDITO.NC_FEC),105) as GVC_FECHA';
                  $array_campos_query_nc['GVC_MONEDA'] = 'NOTAS_CREDITO.ID_MONEDA as GVC_MONEDA';
                  $array_campos_query_nc['GVC_TIPO_CAMBIO'] = 'NOTAS_CREDITO.NC_TC as GVC_TIPO_CAMBIO';
                  $array_campos_query_nc['GVC_SOLICITO'] = 'NOTAS_CREDITO.NC_SOL as GVC_SOLICITO';
                  $array_campos_query_nc['GVC_CVE_RES_GLO'] = 'NOTAS_CREDITO.NC_CLA_GLOB as GVC_CVE_RES_GLO';
                  $array_campos_query_nc['analisis1_cliente'] = 'NOTAS_CREDITO.ANALISIS1_CLIENTE as analisis1_cliente';
                  $array_campos_query_nc['analisis2_cliente'] = 'NOTAS_CREDITO.analisis2_cliente as analisis2_cliente';
                  $array_campos_query_nc['analisis3_cliente'] = 'NOTAS_CREDITO.analisis3_cliente as analisis3_cliente';
                  $array_campos_query_nc['analisis4_cliente'] = 'NOTAS_CREDITO.analisis4_cliente as analisis4_cliente';
                  $array_campos_query_nc['analisis5_cliente'] = 'NOTAS_CREDITO.analisis5_cliente as analisis5_cliente';
                  $array_campos_query_nc['analisis6_cliente'] = 'NOTAS_CREDITO.analisis6_cliente as analisis6_cliente';
                  $array_campos_query_nc['analisis7_cliente'] = 'NOTAS_CREDITO.analisis7_cliente as analisis7_cliente';
                  $array_campos_query_nc['analisis8_cliente'] = 'NOTAS_CREDITO.analisis8_cliente as analisis8_cliente';
                  $array_campos_query_nc['analisis9_cliente'] = 'NOTAS_CREDITO.analisis9_cliente as analisis9_cliente';
                  $array_campos_query_nc['analisis10_cliente'] = 'NOTAS_CREDITO.analisis10_cliente as analisis10_cliente';
                  $array_campos_query_nc['analisis11_cliente'] = 'NOTAS_CREDITO.analisis11_cliente as analisis11_cliente';
                  $array_campos_query_nc['analisis12_cliente'] = 'NOTAS_CREDITO.analisis12_cliente as analisis12_cliente';
                  $array_campos_query_nc['analisis13_cliente'] = 'NOTAS_CREDITO.analisis13_cliente as analisis13_cliente';
                  $array_campos_query_nc['analisis14_cliente'] = 'NOTAS_CREDITO.analisis14_cliente as analisis14_cliente';
                  $array_campos_query_nc['analisis15_cliente'] = 'NOTAS_CREDITO.analisis15_cliente as analisis15_cliente';
                  $array_campos_query_nc['analisis16_cliente'] = ' NOTAS_CREDITO.analisis16_cliente as analisis16_cliente';
                  $array_campos_query_nc['analisis17_cliente'] = 'NOTAS_CREDITO.analisis17_cliente as analisis17_cliente';
                  $array_campos_query_nc['analisis18_cliente'] = 'NOTAS_CREDITO.analisis18_cliente as analisis18_cliente';
                  $array_campos_query_nc['analisis19_cliente'] = 'NOTAS_CREDITO.analisis19_cliente as analisis19_cliente';
                  $array_campos_query_nc['analisis20_cliente'] = 'NOTAS_CREDITO.analisis20_cliente as analisis20_cliente';
                  $array_campos_query_nc['analisis21_cliente'] = 'NOTAS_CREDITO.analisis21_cliente as analisis21_cliente';
                  $array_campos_query_nc['analisis22_cliente'] = 'NOTAS_CREDITO.analisis22_cliente as analisis22_cliente';
                  $array_campos_query_nc['analisis23_cliente'] = 'NOTAS_CREDITO.analisis23_cliente as analisis23_cliente';
                  $array_campos_query_nc['analisis24_cliente'] = 'NOTAS_CREDITO.analisis24_cliente as analisis24_cliente';
                  $array_campos_query_nc['analisis25_cliente'] = 'NOTAS_CREDITO.analisis25_cliente as analisis25_cliente';
                  $array_campos_query_nc['analisis26_cliente'] = 'NOTAS_CREDITO.analisis26_cliente as analisis26_cliente';
                  $array_campos_query_nc['analisis27_cliente'] = 'NOTAS_CREDITO.analisis27_cliente as analisis27_cliente';
                  $array_campos_query_nc['analisis28_cliente'] = ' NOTAS_CREDITO.analisis28_cliente as analisis28_cliente';
                  $array_campos_query_nc['analisis29_cliente'] = 'NOTAS_CREDITO.analisis29_cliente as analisis29_cliente';
                  $array_campos_query_nc['analisis30_cliente'] = 'NOTAS_CREDITO.analisis30_cliente as analisis30_cliente';
                  $array_campos_query_nc['analisis31_cliente'] = 'NOTAS_CREDITO.analisis31_cliente as analisis31_cliente';
                  $array_campos_query_nc['analisis32_cliente'] = 'NOTAS_CREDITO.analisis32_cliente as analisis32_cliente';
                  $array_campos_query_nc['analisis33_cliente'] = 'NOTAS_CREDITO.analisis33_cliente as analisis33_cliente';
                  $array_campos_query_nc['analisis34_cliente'] = 'NOTAS_CREDITO.analisis34_cliente as analisis34_cliente';
                  $array_campos_query_nc['analisis35_cliente'] = 'NOTAS_CREDITO.analisis35_cliente as analisis35_cliente';
                  $array_campos_query_nc['analisis36_cliente'] = 'NOTAS_CREDITO.analisis36_cliente as analisis36_cliente';
                  $array_campos_query_nc['analisis39_cliente'] = 'NOTAS_CREDITO.analisis39_cliente as analisis39_cliente';
                  $array_campos_query_nc['confirmacion_la'] = 'DETALLE_NC.CLAVE_RESERVACION as confirmacion_la';
                  $array_campos_query_nc['analisis40_cliente'] = 'NOTAS_CREDITO.analisis40_cliente as analisis40_cliente';
                  $array_campos_query_nc['analisis41_cliente'] = 'NOTAS_CREDITO.analisis41_cliente as analisis41_cliente';
                  $array_campos_query_nc['analisis42_cliente'] = 'NOTAS_CREDITO.analisis42_cliente as analisis42_cliente';
                  $array_campos_query_nc['analisis43_cliente'] = 'NOTAS_CREDITO.analisis43_cliente as analisis43_cliente';
                  $array_campos_query_nc['analisis44_cliente'] = 'NOTAS_CREDITO.analisis44_cliente as analisis44_cliente';
                  $array_campos_query_nc['analisis45_cliente'] = 'NOTAS_CREDITO.analisis45_cliente as analisis45_cliente';
                  $array_campos_query_nc['analisis46_cliente'] = 'NOTAS_CREDITO.analisis46_cliente as analisis46_cliente';
                  $array_campos_query_nc['analisis47_cliente'] = 'NOTAS_CREDITO.analisis47_cliente as analisis47_cliente';
                  $array_campos_query_nc['analisis48_cliente'] = 'NOTAS_CREDITO.analisis48_cliente as analisis48_cliente';
                  $array_campos_query_nc['analisis49_cliente'] = 'NOTAS_CREDITO.analisis49_cliente as analisis49_cliente';
                  $array_campos_query_nc['analisis50_cliente'] = 'NOTAS_CREDITO.analisis50_cliente as analisis50_cliente';
                  $array_campos_query_nc['analisis51_cliente'] = 'NOTAS_CREDITO.analisis51_cliente as analisis51_cliente';
                  $array_campos_query_nc['analisis52_cliente'] = 'NOTAS_CREDITO.analisis52_cliente as analisis52_cliente';
                  $array_campos_query_nc['analisis53_cliente'] = 'NOTAS_CREDITO.analisis53_cliente as analisis53_cliente';
                  $array_campos_query_nc['analisis54_cliente'] = 'NOTAS_CREDITO.analisis54_cliente as analisis54_cliente';
                  $array_campos_query_nc['analisis55_cliente'] = 'NOTAS_CREDITO.analisis55_cliente as analisis55_cliente';
                  $array_campos_query_nc['analisis56_cliente'] = 'NOTAS_CREDITO.analisis56_cliente as analisis56_cliente';
                  $array_campos_query_nc['analisis57_cliente'] = 'NOTAS_CREDITO.analisis57_cliente as analisis57_cliente';
                  $array_campos_query_nc['analisis58_cliente'] = 'NOTAS_CREDITO.analisis58_cliente as analisis58_cliente';
                  $array_campos_query_nc['analisis59_cliente'] = 'NOTAS_CREDITO.analisis59_cliente as analisis59_cliente';
                  $array_campos_query_nc['analisis60_cliente'] = 'NOTAS_CREDITO.analisis60_cliente as analisis60_cliente';
                  $array_campos_query_nc['TIPO_BOLETO'] = 'DETALLE_NC.det_nc_ctra as TIPO_BOLETO';
                  $array_campos_query_nc['GVC_BOLETO'] = 'DETALLE_NC.DET_NC_NUM_BOL as GVC_BOLETO';
                  $array_campos_query_nc['GVC_BOLETO_CXS'] = 'null as GVC_BOLETO_CXS';
                  $array_campos_query_nc['GVC_ID_SERVICIO'] = 'PROV_TPO_SERV.ID_SERVICIO as GVC_ID_SERVICIO';
                  $array_campos_query_nc['GVC_ID_PROVEEDOR'] = 'PROV_TPO_SERV.ID_PROVEEDOR as GVC_ID_PROVEEDOR';
                  $array_campos_query_nc['GVC_NOMBRE_PROVEEDOR'] = 'convert(varchar,PROVEEDORES.NOMBRE) AS GVC_NOMBRE_PROVEEDOR';
                  $array_campos_query_nc['BOLETO_EMD'] = 'PROVEEDORES.ID_TIPO_PROVEEDOR as GVC_ID_TIPO_PROVEEDOR';
                  $array_campos_query_nc['GVC_ALCANCE_SERVICIO'] = 'TIPO_SERVICIO.ID_ALCANCE_SERV as GVC_ALCANCE_SERVICIO';
                  $array_campos_query_nc['GVC_CONCEPTO'] = 'DETALLE_NC.DET_NC_CONCEPTO as GVC_CONCEPTO';
                  $array_campos_query_nc['GVC_NOM_PAX'] = 'DETALLE_NC.DET_NC_NOM_PAS as GVC_NOM_PAX';
                  $array_campos_query_nc['GVC_TARIFA_MON_BASE'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_TAR_MN) as GVC_TARIFA_MON_BASE";
                  $array_campos_query_nc['GVC_TARIFA_MON_EXT'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_TAR_EXT) as GVC_TARIFA_MON_EXT";
                  $array_campos_query_nc['GVC_DESCUENTO'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_DESC) as GVC_DESCUENTO";
                  $array_campos_query_nc['GVC_IVA_DESCUENTO'] = "'-'+ CONVERT(varchar,DETALLE_NC.IVA_DESC) as GVC_IVA_DESCUENTO";
                  $array_campos_query_nc['GVC_COM_AGE'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_COM_AGE) as GVC_COM_AGE";
                  $array_campos_query_nc['GVC_POR_COM_AGE'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_PORC_COM_AGE) as GVC_POR_COM_AGE";
                  $array_campos_query_nc['GVC_COM_TIT'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_COM_VEN) as GVC_COM_TIT";
                  $array_campos_query_nc['GVC_POR_COM_TIT'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_PORC_COM_VEN) as GVC_POR_COM_TIT";
                  $array_campos_query_nc['GVC_COM_AUX'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_COM_AUX) as GVC_COM_AUX";
                  $array_campos_query_nc['GVC_POR_COM_AUX'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_PORC_COM_AUX) as GVC_POR_COM_AUX";
                  $array_campos_query_nc['GVC_POR_IVA_COM'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_PORC_IVA_SOBRE_COM) as GVC_POR_IVA_COM";
                  $array_campos_query_nc['GVC_IVA'] = "'-'+ CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_IVA";
                  $array_campos_query_nc['GVC_TUA'] = "'-'+ CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_TUA";
                  $array_campos_query_nc['GVC_OTROS_IMPUESTOS'] = "'-'+ CONVERT(varchar,(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
                                      DBA.CATALOGO_DE_IMPUESTO,DBA.IMPXSERVNC where
                                      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPXSERVNC.ID_IMPUESTO and
                                      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) as GVC_OTROS_IMPUESTOS";
                  $array_campos_query_nc['GVC_TOTAL'] = "'-'+ CONVERT(varchar,convert(varchar,DETALLE_NC.DET_NC_TAR_MN)+(select ISNULL(ROUND(SUM(IMPXSERVNC.CANTIDAD),2),0) from
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
                                      IMPXSERVNC.ID_DET_NC = DETALLE_NC.ID_DET_NC)) AS GVC_TOTAL";
                  $array_campos_query_nc['GVC_SUMA_IMPUESTOS'] = "'-'+ CONVERT(varchar,DETALLE_NC.DET_NC_SUM_IMP) as GVC_SUMA_IMPUESTOS";
                  $array_campos_query_nc['GVC_IVA_EXT'] = ' GVC_IVA/NOTAS_CREDITO.NC_TC as GVC_IVA_EXT';
                  $array_campos_query_nc['GVC_TUA_EXT'] = ' GVC_TUA/NOTAS_CREDITO.NC_TC as GVC_TUA_EXT';
                  $array_campos_query_nc['GVC_OTR_EXT'] = 'GVC_OTROS_IMPUESTOS/NOTAS_CREDITO.NC_TC as GVC_OTR_EXT';

                  $array_campos_query_nc['GVC_CVE_SUCURSAL'] = 'SUC_NC.CVE as GVC_CVE_SUCURSAL';
                  $array_campos_query_nc['GVC_NOM_SUCURSAL'] = 'SUC_NC.NOMBRE as GVC_NOM_SUCURSAL';

                  $array_campos_query_nc['GVC_TARIFA_COMPARATIVA_BOLETO'] = 'case when(GVC_TARIFA_MON_BASE = 0) then 0
                                    when(CONCECUTIVO_BOLETOS.IMP_CRE/GVC_TARIFA_MON_BASE >= 1) and
                                    (CONCECUTIVO_BOLETOS.IMP_CRE/GVC_TARIFA_MON_BASE <= 2) then
                                      CONCECUTIVO_BOLETOS.IMP_CRE
                                    else
                                      CONCECUTIVO_BOLETOS.IMP_CRE*NOTAS_CREDITO.NC_TC
                                    end as GVC_TARIFA_COMPARATIVA_BOLETO';
                  $array_campos_query_nc['GVC_TARIFA_COMPARATIVA_BOLETO_EXT'] = '(GVC_TARIFA_COMPARATIVA_BOLETO/NOTAS_CREDITO.NC_TC) as GVC_TARIFA_COMPARATIVA_BOLETO_EXT';
                  $array_campos_query_nc['GVC_CLASE_FACTURADA'] = 'CONCECUTIVO_BOLETOS.CLA_FAC as GVC_CLASE_FACTURADA';
                  $array_campos_query_nc['GVC_CLASE_COMPARATIVO'] = 'CONCECUTIVO_BOLETOS.CLA_NOR as GVC_CLASE_COMPARATIVO';
                  $array_campos_query_nc['GVC_FECHA_SALIDA'] = 'convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as GVC_FECHA_SALIDA';
                  $array_campos_query_nc['GVC_FECHA_REGRESO'] = 'convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_REG),105) as GVC_FECHA_REGRESO';
                  $array_campos_query_nc['GVC_FECHA_EMISION_BOLETO'] = 'convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_EMI),105) as GVC_FECHA_EMISION_BOLETO';
                  $array_campos_query_nc['GVC_CLAVE_EMPLEADO'] = 'CONCECUTIVO_BOLETOS.CLA_PAX as GVC_CLAVE_EMPLEADO';
                  $array_campos_query_nc['GVC_FOR_PAG1'] = 'null as GVC_FOR_PAG1';
                  $array_campos_query_nc['GVC_FOR_PAG2'] = 'null as GVC_FOR_PAG2';
                  $array_campos_query_nc['GVC_FOR_PAG3'] = 'null as GVC_FOR_PAG3';
                  $array_campos_query_nc['GVC_FOR_PAG4'] = 'null as GVC_FOR_PAG4';
                  $array_campos_query_nc['GVC_FOR_PAG5'] = 'null as GVC_FOR_PAG5';
                  $array_campos_query_nc['GVC_FAC_NUMERO'] = ' NOTAS_CREDITO.FAC_NUMERO as GVC_FAC_NUMERO';
                  $array_campos_query_nc['GVC_ID_SERIE_FAC'] = 'NOTAS_CREDITO.ID_SERIE_FAC as GVC_ID_SERIE_FAC';
                  $array_campos_query_nc['GVC_FAC_CVE_SUCURSAL'] = 'SUC_FAC.CVE as GVC_FAC_CVE_SUCURSAL';
                  $array_campos_query_nc['GVC_FAC_NOM_SUCURSAL'] = 'SUC_FAC.NOMBRE as GVC_FAC_NOM_SUCURSAL';
                  $array_campos_query_nc['GVC_TIPO_DOCUMENTO'] = "'NC' as GVC_TIPO_DOCUMENTO";
                  $array_campos_query_nc['GVC_ID_STATUS'] = 'NOTAS_CREDITO.ID_STAT as GVC_ID_STATUS';
                  $array_campos_query_nc['GVC_CONSECUTIVO'] = 'NOTAS_CREDITO.CONSECUTIVO as GVC_CONSECUTIVO';
                  $array_campos_query_nc['GVC_TARIFA_OFRECIDA'] = '0';
                  $array_campos_query_nc['GVC_CODIGO_RAZON'] = 'null';
                  $array_campos_query_nc['GVC_DESC_CORTA'] = 'null';
                  $array_campos_query_nc['GVC_FECHA_RESERVACION'] = 'null';
                  $array_campos_query_nc['GVC_PRODUCTO'] = 'TIPO_SERVICIO.PRODUCTO as GVC_PRODUCTO';
                  $array_campos_query_nc['GVC_CLASES'] = 'null';

                 
                  $this->db->query("create table #TEMPNC(
                    GVC_FAC_NUMERO varchar(100) null
                  )");
                

                  $select2 = "insert into #TEMPNC select GVC_FAC_NUMERO=NOTAS_CREDITO.FAC_NUMERO
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

                    $condicion_fecha = 'NOTAS_CREDITO.FECHA_FOLIO';

                  }else{

                    $condicion_fecha = 'NOTAS_CREDITO.NC_FEC';

                  }

                  $select2 = $select2."

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
                  
                  //********************************************

                      $query_valida_cantidad = $this->db->query($valida_cantidad);
                      $result_valida_cantidad = $query_valida_cantidad->result_array();
                      
                      $cantidad_registros = $result_valida_cantidad[0]['contador'];

                      if($cantidad_registros < 1500 || $proceso == 2){


                            $this->db->query($select1);

                            $this->db->query($select2);

                            $ultimaletra = substr($str_campos_query_fc_nombre_col, -1);

                            if($ultimaletra == ','){

                              $str_campos_query_fc_nombre_col = substr($str_campos_query_fc_nombre_col, 0, -1);

                            }

                            $select3 = " select
                              
                              ".$str_campos_query_fc_nombre_col." 

                            from #TEMPFAC as FAC where 
                             not FAC.GVC_DOC_NUMERO_VALIDACION = any(select distinct GVC_FAC_NUMERO from #TEMPNC)";
                            
                            $query_rows = $this->db->query($select3);

                            $result = $query_rows->result_array();


                      }else{

                            $result = 'mayor';

                      }

     
                      $this->db->query("drop table #TEMPFAC");
                      $this->db->query("drop table #TEMPNC");


                  //********************************************
               
                  
  
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