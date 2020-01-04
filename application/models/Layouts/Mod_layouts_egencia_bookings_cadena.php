<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');

class Mod_layouts_egencia_bookings_cadena extends CI_Model {

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

   public function get_group_id($cliente){

      $db_prueba = $this->load->database('conmysql', TRUE);
      
      $query = $db_prueba->query('SELECT * FROM reportes_villa_tours.rpv_analisis_cliente_cliente where id_cliente = '.$cliente.' limit 1');

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


   public function guardar_informacion_local($id_us,$Link_Key,$BookingID,$BookingType,$BookingSubType,$DocumentType,$TransactionType,$RecordLocator,$InvoiceNumber,$BranchName,$BranchInterfaceID,$BranchARCNumber,$OutsideAgent,$BookingAgent,$InsideAgent,$TicketingAgent,$BookedOnline,$AccountName,$AccountInterfaceID,$AccountType,$VendorName,$VendorInterfaceID,$VendorCode,$VendorAddress,$VendorCity,$VendorState,$VendorZip,$VendorCountryCode,$VendorPhone,$AirlineNumber,$ReasonCode,$ReasonDescription,$IssuedDate,$BookingDate,$StartDate,$EndDate,$NumberofUnits,$BookingDuration,$CommissionAmount,$CommissionRate,$FullFare,$LowFare,$BaseFare,$Tax1Amount,$Tax2Amount,$Tax3Amount,$Tax4Amount,$GSTAmount,$QSTAmount,$TotalTaxes,$TotalPaid,$PenaltyAmount,$Rate,$RateType,$CurrencyCode,$FormofPayment,$PaymentNumber,$TravelerName,$DocumentNumber,$OriginalDocumentNumber,$Routing,$Origin,$Destination,$DomesticInternational,$Class,$TourCode,$TicketDesignator,$ClientRemarks,$Department,$GSANumber,$PurchaseOrder,$CostCenter,$CostCenterdescription,$SBU,$EmployeeID,$BillableNonBillable,$ProjectCode,$ReasonforTravel,$DepartmentDescription,$CustomField9,$CustomField10,$GroupID,$InPolicy,$TravelerEmail,$NegotiatedFare,$boleto_aereo,$consecutivo_gen,$consecutivo_vuelo,$analisis1_cliente,$analisis2_cliente,$analisis3_cliente,$analisis4_cliente,$analisis5_cliente,$analisis6_cliente,$analisis7_cliente,$analisis8_cliente,$analisis9_cliente,$analisis10_cliente,$analisis11_cliente,$analisis12_cliente,$analisis13_cliente,$analisis14_cliente,$analisis15_cliente,$analisis16_cliente,$analisis17_cliente,$analisis18_cliente,$analisis19_cliente,$analisis20_cliente,$analisis21_cliente,$analisis22_cliente,$analisis23_cliente,$analisis24_cliente,$analisis25_cliente,$analisis26_cliente,$analisis27_cliente,$analisis28_cliente,$analisis29_cliente,$analisis30_cliente,$analisis31_cliente,$analisis32_cliente,$analisis33_cliente,$analisis34_cliente,$analisis35_cliente,$analisis36_cliente,$analisis37_cliente,$analisis38_cliente,$analisis39_cliente,$analisis40_cliente,$analisis41_cliente,$analisis42_cliente,$analisis43_cliente,$analisis44_cliente,$analisis45_cliente,$analisis46_cliente,$analisis47_cliente,$analisis48_cliente,$analisis49_cliente,$analisis50_cliente,$analisis51_cliente,$analisis52_cliente,$analisis53_cliente,$analisis54_cliente,$analisis55_cliente,$analisis56_cliente,$analisis57_cliente,$analisis58_cliente,$analisis59_cliente,$analisis60_cliente,$analisis61_cliente,$analisis62_cliente,$analisis63_cliente,$analisis64_cliente,$analisis65_cliente,$analisis66_cliente,$analisis67_cliente,$analisis68_cliente,$analisis69_cliente,$analisis70_cliente,$analisis71_cliente,$analisis72_cliente,$analisis73_cliente,$analisis74_cliente,$analisis75_cliente,$analisis76_cliente,$analisis77_cliente,$analisis78_cliente,$analisis79_cliente,$analisis80_cliente,$analisis81_cliente,$analisis82_cliente,$analisis83_cliente,$analisis84_cliente,$analisis85_cliente,$analisis86_cliente,$analisis87_cliente,$analisis88_cliente,$analisis89_cliente,$analisis90_cliente,$analisis91_cliente,$analisis92_cliente,$analisis93_cliente,$analisis94_cliente,$analisis95_cliente,$analisis96_cliente,$analisis97_cliente,$analisis98_cliente,$analisis99_cliente,$analisis100_cliente
   ){

       $db_prueba = $this->load->database('conmysql', TRUE);
 
      
       $query = $db_prueba->query("insert into rpv_ega_data_import(id_usuario,Link_Key, BookingID, BookingType, BookingSubType, DocumentType, TransactionType, RecordLocator, InvoiceNumber, BranchName, BranchInterfaceID, BranchARCNumber, OutsideAgent, BookingAgent, InsideAgent, TicketingAgent, BookedOnline, AccountName, AccountInterfaceID, AccountType, VendorName, VendorInterfaceID, VendorCode, VendorAddress, VendorCity, VendorState, VendorZip, VendorCountryCode, VendorPhone, AirlineNumber, ReasonCode, ReasonDescription, IssuedDate, BookingDate, StartDate, EndDate, NumberofUnits, BookingDuration, CommissionAmount, CommissionRate, FullFare, LowFare, BaseFare, Tax1Amount, Tax2Amount, Tax3Amount, Tax4Amount, GSTAmount, QSTAmount, TotalTaxes, TotalPaid, PenaltyAmount, Rate, RateType, CurrencyCode, FormofPayment, PaymentNumber, TravelerName, DocumentNumber, OriginalDocumentNumber, Routing, Origin, Destination, DomesticInternational, Class, TourCode, TicketDesignator, ClientRemarks, Department, GSANumber, PurchaseOrder, CostCenter, CostCenterdescription, SBU, EmployeeID, BillableNonBillable, ProjectCode, ReasonforTravel, DepartmentDescription, CustomField9, CustomField10, GroupID, InPolicy, TravelerEmail, NegotiatedFare, boleto_aereo, consecutivo_gen, consecutivo_vuelo,analisis1_cliente,analisis2_cliente,analisis3_cliente,analisis4_cliente,analisis5_cliente,analisis6_cliente,analisis7_cliente,analisis8_cliente,analisis9_cliente,analisis10_cliente,analisis11_cliente,analisis12_cliente,analisis13_cliente,analisis14_cliente,analisis15_cliente,analisis16_cliente,analisis17_cliente,analisis18_cliente,analisis19_cliente,analisis20_cliente,analisis21_cliente,analisis22_cliente,analisis23_cliente,analisis24_cliente,analisis25_cliente,analisis26_cliente,analisis27_cliente,analisis28_cliente,analisis29_cliente,analisis30_cliente,analisis31_cliente,analisis32_cliente,analisis33_cliente,analisis34_cliente,analisis35_cliente,analisis36_cliente,analisis37_cliente,analisis38_cliente,analisis39_cliente,analisis40_cliente,analisis41_cliente,analisis42_cliente,analisis43_cliente,analisis44_cliente,analisis45_cliente,analisis46_cliente,analisis47_cliente,analisis48_cliente,analisis49_cliente,analisis50_cliente,analisis51_cliente,analisis52_cliente,analisis53_cliente,analisis54_cliente,analisis55_cliente,analisis56_cliente,analisis57_cliente,analisis58_cliente,analisis59_cliente,analisis60_cliente,analisis61_cliente,analisis62_cliente,analisis63_cliente,analisis64_cliente,analisis65_cliente,analisis66_cliente,analisis67_cliente,analisis68_cliente,analisis69_cliente,analisis70_cliente,analisis71_cliente,analisis72_cliente,analisis73_cliente,analisis74_cliente,analisis75_cliente,analisis76_cliente,analisis77_cliente,analisis78_cliente,analisis79_cliente,analisis80_cliente,analisis81_cliente,analisis82_cliente,analisis83_cliente,analisis84_cliente,analisis85_cliente,analisis86_cliente,analisis87_cliente,analisis88_cliente,analisis89_cliente,analisis90_cliente,analisis91_cliente,analisis92_cliente,analisis93_cliente,analisis94_cliente,analisis95_cliente,analisis96_cliente,analisis97_cliente,analisis98_cliente,analisis99_cliente,analisis100_cliente)
        values (".$id_us.",'".$Link_Key."','".$BookingID."','".$BookingType."','".$BookingSubType."','".$DocumentType."','".$TransactionType."','".$RecordLocator."','".$InvoiceNumber."','".$BranchName."','".$BranchInterfaceID."','".$BranchARCNumber."','".$OutsideAgent."','".$BookingAgent."','".$InsideAgent."','".$TicketingAgent."','".$BookedOnline."','".$AccountName."','".$AccountInterfaceID."','".$AccountType."','".$VendorName."','".$VendorInterfaceID."','".$VendorCode."','".$VendorAddress."','".$VendorCity."','".$VendorState."','".$VendorZip."','".$VendorCountryCode."','".$VendorPhone."','".$AirlineNumber."','".$ReasonCode."','".$ReasonDescription."','".$IssuedDate."','".$BookingDate."','".$StartDate."','".$EndDate."','".$NumberofUnits."','".$BookingDuration."','".$CommissionAmount."','".$CommissionRate."','".$FullFare."','".$LowFare."','".$BaseFare."','".$Tax1Amount."','".$Tax2Amount."','".$Tax3Amount."','".$Tax4Amount."','".$GSTAmount."','".$QSTAmount."','".$TotalTaxes."','".$TotalPaid."','".$PenaltyAmount."','".$Rate."','".$RateType."','".$CurrencyCode."','".$FormofPayment."','".$PaymentNumber."','".$TravelerName."','".$DocumentNumber."','".$OriginalDocumentNumber."','".$Routing."','".$Origin."','".$Destination."','".$DomesticInternational."','".$Class."','".$TourCode."','".$TicketDesignator."','".$ClientRemarks."','".$Department."','".$GSANumber."','".$PurchaseOrder."','".$CostCenter."','".$CostCenterdescription."','".$SBU."','".$EmployeeID."','".$BillableNonBillable."','".$ProjectCode."','".$ReasonforTravel."','".$DepartmentDescription."','".$CustomField9."','".$CustomField10."','".$GroupID."','".$InPolicy."','".$TravelerEmail."','".$NegotiatedFare."','".$boleto_aereo."','".$consecutivo_gen."','".$consecutivo_vuelo."','".$analisis1_cliente."','".$analisis2_cliente."','".$analisis3_cliente."','".$analisis4_cliente."','".$analisis5_cliente."','".$analisis6_cliente."','".$analisis7_cliente."','".$analisis8_cliente."','".$analisis9_cliente."','".$analisis10_cliente."','".$analisis11_cliente."','".$analisis12_cliente."','".$analisis13_cliente."','".$analisis14_cliente."','".$analisis15_cliente."','".$analisis16_cliente."','".$analisis17_cliente."','".$analisis18_cliente."','".$analisis19_cliente."','".$analisis20_cliente."','".$analisis21_cliente."','".$analisis22_cliente."','".$analisis23_cliente."','".$analisis24_cliente."','".$analisis25_cliente."','".$analisis26_cliente."','".$analisis27_cliente."','".$analisis28_cliente."','".$analisis29_cliente."','".$analisis30_cliente."','".$analisis31_cliente."','".$analisis32_cliente."','".$analisis33_cliente."','".$analisis34_cliente."','".$analisis35_cliente."','".$analisis36_cliente."','".$analisis37_cliente."','".$analisis38_cliente."','".$analisis39_cliente."','".$analisis40_cliente."','".$analisis41_cliente."','".$analisis42_cliente."','".$analisis43_cliente."','".$analisis44_cliente."','".$analisis45_cliente."','".$analisis46_cliente."','".$analisis47_cliente."','".$analisis48_cliente."','".$analisis49_cliente."','".$analisis50_cliente."','".$analisis51_cliente."','".$analisis52_cliente."','".$analisis53_cliente."','".$analisis54_cliente."','".$analisis55_cliente."','".$analisis56_cliente."','".$analisis57_cliente."','".$analisis58_cliente."','".$analisis59_cliente."','".$analisis60_cliente."','".$analisis61_cliente."','".$analisis62_cliente."','".$analisis63_cliente."','".$analisis64_cliente."','".$analisis65_cliente."','".$analisis66_cliente."','".$analisis67_cliente."','".$analisis68_cliente."','".$analisis69_cliente."','".$analisis70_cliente."','".$analisis71_cliente."','".$analisis72_cliente."','".$analisis73_cliente."','".$analisis74_cliente."','".$analisis75_cliente."','".$analisis76_cliente."','".$analisis77_cliente."','".$analisis78_cliente."','".$analisis79_cliente."','".$analisis80_cliente."','".$analisis81_cliente."','".$analisis82_cliente."','".$analisis83_cliente."','".$analisis84_cliente."','".$analisis85_cliente."','".$analisis86_cliente."','".$analisis87_cliente."','".$analisis88_cliente."','".$analisis89_cliente."','".$analisis90_cliente."','".$analisis91_cliente."','".$analisis92_cliente."','".$analisis93_cliente."','".$analisis94_cliente."','".$analisis95_cliente."','".$analisis96_cliente."','".$analisis97_cliente."','".$analisis98_cliente."','".$analisis99_cliente."','".$analisis100_cliente."')");

      $ultimo_id = $db_prueba->insert_id();

      return $ultimo_id;


   }
   
   public function get_layouts_egencia_data_import_sp_local($id_us){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query("select CONCAT(id, RecordLocator) as Link_Key2, id as BookingID2, rpv_ega_data_import.* from rpv_ega_data_import WHERE id_usuario = ".$id_us);
     
      $array_aereo = $query->result_array();

      return $array_aereo;

   }

   public function eliminar_BookingID($BookingID,$id_us){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->query("delete from rpv_ega_data_import where id =".$BookingID." and id_usuario = ".$id_us);
     
   
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
    
    /**********************************************************/

        fecha_salida_vuelos_cxs = CONVERT(CHAR(12),gds_vuelos_cxs.fecha_salida,105) ,

        fecha_salid_con_bol_cxs = (select top 1 CONVERT(CHAR(12),concecutivo_boletos_cxs.fecha_sal,105) from concecutivo_boletos as concecutivo_boletos_cxs where 

         concecutivo_boletos_cxs.id_boleto =  detalle_factura_cxs.id_boleto

        ),
        fecha_salid_con_bol = CONVERT(CHAR(12),concecutivo_boletos.fecha_sal,105),




        fecha_regreso_vuelos_cxs = CONVERT(CHAR(12),gds_vuelos_cxs.fecha_regreso,105),

        fecha_regre_con_bol_cxs = (select top 1 CONVERT(CHAR(12),concecutivo_boletos_cxs.fecha_reg,105) from concecutivo_boletos as concecutivo_boletos_cxs where concecutivo_boletos_cxs.id_boleto =  detalle_factura_cxs.id_boleto),

        fecha_regre_con_bol = CONVERT(CHAR(12),concecutivo_boletos.fecha_reg,105),

    /**********************************************************/

    DETALLE_FACTURA.ID_CUPON,
    DETALLE_FACTURA.prov_tpo_serv as tpo_serv,

    analisis46_cliente = CASE WHEN (datos_factura.analisis46_cliente IS NULL OR datos_factura.analisis46_cliente = '')  THEN
      GDS_GENERAL.analisis46_cliente
    ELSE
      datos_factura.analisis46_cliente
    END,
    analisis35_cliente = CASE WHEN (datos_factura.analisis35_cliente IS NULL OR datos_factura.analisis35_cliente = '')  THEN
      GDS_GENERAL.analisis35_cliente
    ELSE
      datos_factura.analisis35_cliente
    END,
    DETALLE_FACTURA.numero_bol_cxs,
    SBU = CASE WHEN (datos_factura.analisis14_cliente IS NULL OR datos_factura.analisis14_cliente = '')  THEN
      GDS_GENERAL.analisis14_cliente
    ELSE
      datos_factura.analisis14_cliente
    END,

    EmployeeID = CASE WHEN(DETALLE_FACTURA.cla_pax IS NULL or DETALLE_FACTURA.cla_pax = '') THEN
     GDS_GENERAL.cla_pax
    ELSE
     DETALLE_FACTURA.cla_pax
    END,
    centro_costo.desc_centro_costo,
    dba.gds_vuelos.consecutivo as consecutivo_vuelo,
    concecutivo_boletos.numero_bol as boleto_aereo,
    convert(char(12),datos_factura.fecha,105) as fecha_fac,
    dba.gds_vuelos.codigo_razon as codigo_razon,
    datos_factura.mail_cliente, 
    detalle_factura.contra,
    detalle_factura.bol_contra,
    detalle_factura.detalle_factura as codigo_detalle,
    /*concecutivo_boletos.id_boleto,*/
    datos_factura.id_stat, 
    datos_factura.tpo_cambio,
    dba.gds_vuelos.combustible as combustible,
    dba.gds_general.id_serie,detalle_factura.emd,
    
    GVC_NOM_CLI=convert(varchar,DATOS_FACTURA.CL_NOMBRE),
    GVC_ID_CORPORATIVO=convert(varchar,CLIENTES.ID_CORPORATIVO),
    consecutivo=dba.gds_general.consecutivo,
    name=convert(varchar,dba.gds_general.cl_nombre),
    /*nexp=convert(varchar,dba.gds_general.id_cliente),*/
    nexp=convert(varchar,CLIENTES.id_cliente),
    destination=convert(varchar,dba.gds_vuelos.ruta),

    fecha_salida_vu=convert(char(12),dba.gds_vuelos.fecha_salida,105),
    
    fecha_regreso_vu=

      case when (gds_vuelos.fecha_regreso = '1900-01-01') then
        convert(char(12),dba.gds_vuelos.fecha_salida,105)
      else
        convert(char(12),dba.gds_vuelos.fecha_regreso,105)
      end,

    /*fecha_salida_vu=convert(char(12),concecutivo_boletos.fecha_sal,105),
    fecha_regreso_vu=convert(char(12),concecutivo_boletos.fecha_reg,105),*/

    documento=dba.detalle_factura.fac_numero,
    solicitor=convert(varchar,dba.datos_factura.solicito),
    type_of_service=convert(varchar,dba.TIPO_SERVICIO.id_tipo_servicio),
    supplier=convert(varchar,dba.gds_vuelos.id_la),
    codigo_producto=convert(varchar,(if dba.detalle_factura.numero_bol is not null then 'AIR' else 'TRA' endif)),
    final_user=convert(varchar,dba.detalle_factura.nom_pasajero),
    ticket_number=convert(varchar,dba.detalle_factura.numero_bol),
    typo_of_ticket=convert(varchar,dba.TIPO_SERVICIO.id_alcance_serv),
    fecha_emi=convert(char(12),dba.concecutivo_boletos.fecha_emi,105),city='',country='',total_emission='',
    
    total_millas='',
    
    total_Itinerary1='',
    origin1='',
    destina1='',
    total_Itinerary2='',
    origin2='',
    destina2='',
    total_Itinerary3='',
    origin3='',
    destina3='',
    total_Itinerary4='',
    origin4='',
    destina4='',
    total_Itinerary5='',
    origin5='',
    destina5='',
    total_Itinerary6='',
    origin6='',
    destina6='',
    total_Itinerary7='',
    origin7='',
    destina7='',
    total_Itinerary8='',
    origin8='',
    destina8='',
    total_Itinerary9='',
    origin9='',
    destina9='',
    total_Itinerary10='',
    origin10='',
    destina10='',hotel1='',fecha_entrada1='',fecha_salida1='',noches1='',
    break_fast1=null,numero_hab1='',id_habitacion1='',id_ciudad1='',
    country1=null,hotel2='',fecha_entrada2='',fecha_salida2='',noches2='',
    break_fast2=null,numero_hab2='',id_habitacion2='',id_ciudad2='',
    country2=null,hotel3='',fecha_entrada3='',fecha_salida3='',noches3='',
    break_fast3=null,numero_hab3='',id_habitacion3='',id_ciudad3='',
    country3=null,hotel4='',fecha_entrada4='',fecha_salida4='',noches4='',
    break_fast4=null,numero_hab4='',id_habitacion4='',id_ciudad4='',
    country4=null,hotel5='',fecha_entrada5='',fecha_salida5='',noches5='',
    break_fast5=null,numero_hab5='',id_habitacion5='',id_ciudad5='',
    country5=null,hotel6='',fecha_entrada6='',fecha_salida6='',noches6='',
    break_fast6=null,numero_hab6='',id_habitacion6='',id_ciudad6='',
    country6=null,hotel7='',fecha_entrada7='',fecha_salida7='',noches7='',
    break_fast7=null,numero_hab7='',id_habitacion7='',id_ciudad7='',
    country7=null,hotel8='',fecha_entrada8='',fecha_salida8='',noches8='',
    break_fast8=null,numero_hab8='',id_habitacion8='',id_ciudad8='',
    country8=null,hotel9='',fecha_entrada9='',fecha_salida9='',noches9='',
    break_fast9=null,numero_hab9='',id_habitacion9='',id_ciudad9='',
    country9=null,hotel10='',fecha_entrada10='',fecha_salida10='',noches10='',
    break_fast10=null,numero_hab10='',id_habitacion10='',id_ciudad10='',
    country10=null,Car_class1='',Delivery_Date1='',Nr_days1='',Place_delivery1='',Place_delivery_back1='',Departure_date1='',Car_class2='',Delivery_Date2='',Nr_days2='',Place_delivery2='',Place_delivery_back2='',Departure_date2='',Car_class3='',Delivery_Date3='',Nr_days3='',Place_delivery3='',Place_delivery_back3='',Departure_date3='',Car_class4='',Delivery_Date4='',Nr_days4='',Place_delivery4='',Place_delivery_back4='',Departure_date4='',Car_class5='',Delivery_Date5='',Nr_days5='',Place_delivery5='',Place_delivery_back5='',Departure_date5='',Car_class6='',Delivery_Date6='',Nr_days6='',Place_delivery6='',Place_delivery_back6='',Departure_date6='',Car_class7='',Delivery_Date7='',Nr_days7='',Place_delivery7='',Place_delivery_back7='',Departure_date7='',Car_class8='',Delivery_Date8='',Nr_days8='',Place_delivery8='',Place_delivery_back8='',Departure_date8='',Car_class9='',Delivery_Date9='',Nr_days9='',Place_delivery9='',Place_delivery_back9='',Departure_date9='',Car_class10='',Delivery_Date10='',Nr_days10='',Place_delivery10='',Place_delivery_back10='',Departure_date10='',
    buy_in_advance=datediff(dd,dba.concecutivo_boletos.fecha_emi,dba.gds_vuelos.fecha_salida),

    record_localizador= 
    case 
    when(dba.gds_general.record_localizador is null or dba.gds_general.record_localizador='' or dba.gds_general.record_localizador='IRIS') 
    then
      (case when (datos_factura.analisis1_cliente is null or datos_factura.analisis1_cliente='')
        then 
          datos_factura.cve_reserv_global
        else
          datos_factura.analisis1_cliente
        end)
        
    else 
      dba.gds_general.record_localizador 
    end,

    GVC_ID_CENTRO_COSTO=DATOS_FACTURA.ID_CENTRO_COSTO,

    /*   analisis   de cliente  */

    analisis14_cliente = CASE WHEN (datos_factura.analisis14_cliente IS NULL OR datos_factura.analisis14_cliente = '')  THEN
      GDS_GENERAL.analisis14_cliente
    ELSE
      datos_factura.analisis14_cliente
    END,

    analisis4_cliente = CASE WHEN (datos_factura.analisis4_cliente IS NULL OR datos_factura.analisis4_cliente = '')  THEN
      GDS_GENERAL.analisis4_cliente
    ELSE
      datos_factura.analisis4_cliente
    END,

    analisis12_cliente = CASE WHEN (datos_factura.analisis12_cliente IS NULL OR datos_factura.analisis12_cliente = '')  THEN
      GDS_GENERAL.analisis12_cliente
    ELSE
      datos_factura.analisis12_cliente
    END,

    analisis1_cliente = CASE WHEN (datos_factura.analisis1_cliente IS NULL OR datos_factura.analisis1_cliente = '')  THEN
      GDS_GENERAL.analisis1_cliente
    ELSE
      datos_factura.analisis1_cliente
    END,
    analisis2_cliente = CASE WHEN (datos_factura.analisis2_cliente IS NULL OR datos_factura.analisis2_cliente = '')  THEN
      GDS_GENERAL.analisis2_cliente
    ELSE
      datos_factura.analisis2_cliente
    END,
    analisis3_cliente = CASE WHEN (datos_factura.analisis3_cliente IS NULL OR datos_factura.analisis3_cliente = '')  THEN
      GDS_GENERAL.analisis3_cliente
    ELSE
      datos_factura.analisis3_cliente
    END,
    analisis5_cliente = CASE WHEN (datos_factura.analisis5_cliente IS NULL OR datos_factura.analisis5_cliente = '')  THEN
      GDS_GENERAL.analisis5_cliente
    ELSE
      datos_factura.analisis5_cliente
    END,
    analisis6_cliente = CASE WHEN (datos_factura.analisis6_cliente IS NULL OR datos_factura.analisis6_cliente = '')  THEN
      GDS_GENERAL.analisis6_cliente
    ELSE
      datos_factura.analisis6_cliente
    END,
    analisis7_cliente = CASE WHEN (datos_factura.analisis7_cliente IS NULL OR datos_factura.analisis7_cliente = '')  THEN
      GDS_GENERAL.analisis7_cliente
    ELSE
      datos_factura.analisis7_cliente
    END,
    analisis8_cliente = CASE WHEN (datos_factura.analisis8_cliente IS NULL OR datos_factura.analisis8_cliente = '')  THEN
      GDS_GENERAL.analisis8_cliente
    ELSE
      datos_factura.analisis8_cliente
    END,
    analisis9_cliente = CASE WHEN (datos_factura.analisis9_cliente IS NULL OR datos_factura.analisis9_cliente = '')  THEN
      GDS_GENERAL.analisis9_cliente
    ELSE
      datos_factura.analisis9_cliente
    END,
    analisis10_cliente = CASE WHEN (datos_factura.analisis10_cliente IS NULL OR datos_factura.analisis10_cliente = '')  THEN
      GDS_GENERAL.analisis10_cliente
    ELSE
      datos_factura.analisis10_cliente
    END,
    analisis11_cliente = CASE WHEN (datos_factura.analisis11_cliente IS NULL OR datos_factura.analisis11_cliente = '')  THEN
      GDS_GENERAL.analisis11_cliente
    ELSE
      datos_factura.analisis11_cliente
    END,
    analisis13_cliente = CASE WHEN (datos_factura.analisis13_cliente IS NULL OR datos_factura.analisis13_cliente = '')  THEN
      GDS_GENERAL.analisis13_cliente
    ELSE
      datos_factura.analisis13_cliente
    END,
    analisis15_cliente = CASE WHEN (datos_factura.analisis15_cliente IS NULL OR datos_factura.analisis15_cliente = '')  THEN
      GDS_GENERAL.analisis15_cliente
    ELSE
      datos_factura.analisis15_cliente
    END,
    analisis16_cliente = CASE WHEN (datos_factura.analisis16_cliente IS NULL OR datos_factura.analisis16_cliente = '')  THEN
      GDS_GENERAL.analisis16_cliente
    ELSE
      datos_factura.analisis16_cliente
    END,
    analisis17_cliente = CASE WHEN (datos_factura.analisis17_cliente IS NULL OR datos_factura.analisis17_cliente = '')  THEN
      GDS_GENERAL.analisis17_cliente
    ELSE
      datos_factura.analisis17_cliente
    END,
    analisis18_cliente = CASE WHEN (datos_factura.analisis18_cliente IS NULL OR datos_factura.analisis18_cliente = '')  THEN
      GDS_GENERAL.analisis18_cliente
    ELSE
      datos_factura.analisis18_cliente
    END,
    analisis19_cliente = CASE WHEN (datos_factura.analisis19_cliente IS NULL OR datos_factura.analisis19_cliente = '')  THEN
      GDS_GENERAL.analisis19_cliente
    ELSE
      datos_factura.analisis19_cliente
    END,
    analisis20_cliente = CASE WHEN (datos_factura.analisis20_cliente IS NULL OR datos_factura.analisis20_cliente = '')  THEN
      GDS_GENERAL.analisis20_cliente
    ELSE
      datos_factura.analisis20_cliente
    END,
    analisis21_cliente = CASE WHEN (datos_factura.analisis21_cliente IS NULL OR datos_factura.analisis21_cliente = '')  THEN
      GDS_GENERAL.analisis21_cliente
    ELSE
      datos_factura.analisis21_cliente
    END,
    analisis22_cliente = CASE WHEN (datos_factura.analisis22_cliente IS NULL OR datos_factura.analisis22_cliente = '')  THEN
      GDS_GENERAL.analisis22_cliente
    ELSE
      datos_factura.analisis22_cliente
    END,
    analisis23_cliente = CASE WHEN (datos_factura.analisis23_cliente IS NULL OR datos_factura.analisis23_cliente = '')  THEN
      GDS_GENERAL.analisis23_cliente
    ELSE
      datos_factura.analisis23_cliente
    END,
    analisis24_cliente = CASE WHEN (datos_factura.analisis24_cliente IS NULL OR datos_factura.analisis24_cliente = '')  THEN
      GDS_GENERAL.analisis24_cliente
    ELSE
      datos_factura.analisis24_cliente
    END,
    analisis25_cliente = CASE WHEN (datos_factura.analisis25_cliente IS NULL OR datos_factura.analisis25_cliente = '')  THEN
      GDS_GENERAL.analisis25_cliente
    ELSE
      datos_factura.analisis25_cliente
    END,
    analisis26_cliente = CASE WHEN (datos_factura.analisis26_cliente IS NULL OR datos_factura.analisis26_cliente = '')  THEN
      GDS_GENERAL.analisis26_cliente
    ELSE
      datos_factura.analisis26_cliente
    END,
    analisis27_cliente = CASE WHEN (datos_factura.analisis27_cliente IS NULL OR datos_factura.analisis27_cliente = '')  THEN
      GDS_GENERAL.analisis27_cliente
    ELSE
      datos_factura.analisis27_cliente
    END,
    analisis28_cliente = CASE WHEN (datos_factura.analisis28_cliente IS NULL OR datos_factura.analisis28_cliente = '')  THEN
      GDS_GENERAL.analisis28_cliente
    ELSE
      datos_factura.analisis28_cliente
    END,
    analisis29_cliente = CASE WHEN (datos_factura.analisis29_cliente IS NULL OR datos_factura.analisis29_cliente = '')  THEN
      GDS_GENERAL.analisis29_cliente
    ELSE
      datos_factura.analisis29_cliente
    END,
    analisis30_cliente = CASE WHEN (datos_factura.analisis30_cliente IS NULL OR datos_factura.analisis30_cliente = '')  THEN
      GDS_GENERAL.analisis30_cliente
    ELSE
      datos_factura.analisis30_cliente
    END,
    analisis31_cliente = CASE WHEN (datos_factura.analisis31_cliente IS NULL OR datos_factura.analisis31_cliente = '')  THEN
      GDS_GENERAL.analisis31_cliente
    ELSE
      datos_factura.analisis31_cliente
    END,
    analisis32_cliente = CASE WHEN (datos_factura.analisis32_cliente IS NULL OR datos_factura.analisis32_cliente = '')  THEN
      GDS_GENERAL.analisis32_cliente
    ELSE
      datos_factura.analisis32_cliente
    END,
    analisis33_cliente = CASE WHEN (datos_factura.analisis33_cliente IS NULL OR datos_factura.analisis33_cliente = '')  THEN
      GDS_GENERAL.analisis33_cliente
    ELSE
      datos_factura.analisis33_cliente
    END,
    analisis34_cliente = CASE WHEN (datos_factura.analisis34_cliente IS NULL OR datos_factura.analisis34_cliente = '')  THEN
      GDS_GENERAL.analisis34_cliente
    ELSE
      datos_factura.analisis34_cliente
    END,
    analisis36_cliente = CASE WHEN (datos_factura.analisis36_cliente IS NULL OR datos_factura.analisis36_cliente = '')  THEN
      GDS_GENERAL.analisis36_cliente
    ELSE
      datos_factura.analisis36_cliente
    END,
    analisis37_cliente = CASE WHEN (datos_factura.analisis37_cliente IS NULL OR datos_factura.analisis37_cliente = '')  THEN
      GDS_GENERAL.analisis37_cliente
    ELSE
      datos_factura.analisis37_cliente
    END,
    analisis38_cliente = CASE WHEN (datos_factura.analisis38_cliente IS NULL OR datos_factura.analisis38_cliente = '')  THEN
      GDS_GENERAL.analisis38_cliente
    ELSE
      datos_factura.analisis38_cliente
    END,
    analisis39_cliente = CASE WHEN (datos_factura.analisis39_cliente IS NULL OR datos_factura.analisis39_cliente = '')  THEN
      GDS_GENERAL.analisis39_cliente
    ELSE
      datos_factura.analisis39_cliente
    END,
    analisis40_cliente = CASE WHEN (datos_factura.analisis40_cliente IS NULL OR datos_factura.analisis40_cliente = '')  THEN
      GDS_GENERAL.analisis40_cliente
    ELSE
      datos_factura.analisis40_cliente
    END,
    analisis41_cliente = CASE WHEN (datos_factura.analisis41_cliente IS NULL OR datos_factura.analisis41_cliente = '')  THEN
      GDS_GENERAL.analisis41_cliente
    ELSE
      datos_factura.analisis41_cliente
    END,
    analisis42_cliente = CASE WHEN (datos_factura.analisis42_cliente IS NULL OR datos_factura.analisis42_cliente = '')  THEN
      GDS_GENERAL.analisis42_cliente
    ELSE
      datos_factura.analisis42_cliente
    END,
    analisis43_cliente = CASE WHEN (datos_factura.analisis43_cliente IS NULL OR datos_factura.analisis43_cliente = '')  THEN
      GDS_GENERAL.analisis43_cliente
    ELSE
      datos_factura.analisis43_cliente
    END,
    analisis44_cliente = CASE WHEN (datos_factura.analisis44_cliente IS NULL OR datos_factura.analisis44_cliente = '')  THEN
      GDS_GENERAL.analisis44_cliente
    ELSE
      datos_factura.analisis44_cliente
    END,
    analisis45_cliente = CASE WHEN (datos_factura.analisis45_cliente IS NULL OR datos_factura.analisis45_cliente = '')  THEN
      GDS_GENERAL.analisis45_cliente
    ELSE
      datos_factura.analisis45_cliente
    END,
    analisis47_cliente = CASE WHEN (datos_factura.analisis47_cliente IS NULL OR datos_factura.analisis47_cliente = '')  THEN
      GDS_GENERAL.analisis47_cliente
    ELSE
      datos_factura.analisis47_cliente
    END,
    analisis48_cliente = CASE WHEN (datos_factura.analisis48_cliente IS NULL OR datos_factura.analisis48_cliente = '')  THEN
      GDS_GENERAL.analisis48_cliente
    ELSE
      datos_factura.analisis48_cliente
    END,
    analisis49_cliente = CASE WHEN (datos_factura.analisis49_cliente IS NULL OR datos_factura.analisis49_cliente = '')  THEN
      GDS_GENERAL.analisis49_cliente
    ELSE
      datos_factura.analisis49_cliente
    END,
    analisis50_cliente = CASE WHEN (datos_factura.analisis50_cliente IS NULL OR datos_factura.analisis50_cliente = '')  THEN
      GDS_GENERAL.analisis50_cliente
    ELSE
      datos_factura.analisis50_cliente
    END,
    analisis51_cliente = CASE WHEN (datos_factura.analisis51_cliente IS NULL OR datos_factura.analisis51_cliente = '')  THEN
      GDS_GENERAL.analisis51_cliente
    ELSE
      datos_factura.analisis51_cliente
    END,
    analisis52_cliente = CASE WHEN (datos_factura.analisis52_cliente IS NULL OR datos_factura.analisis52_cliente = '')  THEN
      GDS_GENERAL.analisis52_cliente
    ELSE
      datos_factura.analisis52_cliente
    END,
    analisis53_cliente = CASE WHEN (datos_factura.analisis53_cliente IS NULL OR datos_factura.analisis53_cliente = '')  THEN
      GDS_GENERAL.analisis53_cliente
    ELSE
      datos_factura.analisis53_cliente
    END,
    analisis54_cliente = CASE WHEN (datos_factura.analisis54_cliente IS NULL OR datos_factura.analisis54_cliente = '')  THEN
      GDS_GENERAL.analisis54_cliente
    ELSE
      datos_factura.analisis54_cliente
    END,
    analisis55_cliente = CASE WHEN (datos_factura.analisis55_cliente IS NULL OR datos_factura.analisis55_cliente = '')  THEN
      GDS_GENERAL.analisis55_cliente
    ELSE
      datos_factura.analisis55_cliente
    END,
    analisis56_cliente = CASE WHEN (datos_factura.analisis56_cliente IS NULL OR datos_factura.analisis56_cliente = '')  THEN
      GDS_GENERAL.analisis56_cliente
    ELSE
      datos_factura.analisis56_cliente
    END,
    analisis57_cliente = CASE WHEN (datos_factura.analisis57_cliente IS NULL OR datos_factura.analisis57_cliente = '')  THEN
      GDS_GENERAL.analisis57_cliente
    ELSE
      datos_factura.analisis57_cliente
    END,
    analisis58_cliente = CASE WHEN (datos_factura.analisis58_cliente IS NULL OR datos_factura.analisis58_cliente = '')  THEN
      GDS_GENERAL.analisis58_cliente
    ELSE
      datos_factura.analisis58_cliente
    END,
    analisis59_cliente = CASE WHEN (datos_factura.analisis59_cliente IS NULL OR datos_factura.analisis59_cliente = '')  THEN
      GDS_GENERAL.analisis59_cliente
    ELSE
      datos_factura.analisis59_cliente
    END,
    analisis60_cliente = CASE WHEN (datos_factura.analisis60_cliente IS NULL OR datos_factura.analisis60_cliente = '')  THEN
      GDS_GENERAL.analisis60_cliente
    ELSE
      datos_factura.analisis60_cliente
    END,
    analisis61_cliente = CASE WHEN (datos_factura.analisis61_cliente IS NULL OR datos_factura.analisis61_cliente = '')  THEN
      GDS_GENERAL.analisis61_cliente
    ELSE
      datos_factura.analisis61_cliente
    END,
    analisis62_cliente = CASE WHEN (datos_factura.analisis62_cliente IS NULL OR datos_factura.analisis62_cliente = '')  THEN
      GDS_GENERAL.analisis62_cliente
    ELSE
      datos_factura.analisis62_cliente
    END,
    analisis63_cliente = CASE WHEN (datos_factura.analisis63_cliente IS NULL OR datos_factura.analisis63_cliente = '')  THEN
      GDS_GENERAL.analisis63_cliente
    ELSE
      datos_factura.analisis63_cliente
    END,
    analisis64_cliente = CASE WHEN (datos_factura.analisis64_cliente IS NULL OR datos_factura.analisis64_cliente = '')  THEN
      GDS_GENERAL.analisis64_cliente
    ELSE
      datos_factura.analisis64_cliente
    END,
    analisis65_cliente = CASE WHEN (datos_factura.analisis65_cliente IS NULL OR datos_factura.analisis65_cliente = '')  THEN
      GDS_GENERAL.analisis65_cliente
    ELSE
      datos_factura.analisis65_cliente
    END,
    analisis66_cliente = CASE WHEN (datos_factura.analisis66_cliente IS NULL OR datos_factura.analisis66_cliente = '')  THEN
      GDS_GENERAL.analisis66_cliente
    ELSE
      datos_factura.analisis66_cliente
    END,
    analisis67_cliente = CASE WHEN (datos_factura.analisis67_cliente IS NULL OR datos_factura.analisis67_cliente = '')  THEN
      GDS_GENERAL.analisis67_cliente
    ELSE
      datos_factura.analisis67_cliente
    END,
    analisis68_cliente = CASE WHEN (datos_factura.analisis68_cliente IS NULL OR datos_factura.analisis68_cliente = '')  THEN
      GDS_GENERAL.analisis68_cliente
    ELSE
      datos_factura.analisis68_cliente
    END,
    analisis69_cliente = CASE WHEN (datos_factura.analisis69_cliente IS NULL OR datos_factura.analisis69_cliente = '')  THEN
      GDS_GENERAL.analisis69_cliente
    ELSE
      datos_factura.analisis69_cliente
    END,
    analisis70_cliente = CASE WHEN (datos_factura.analisis70_cliente IS NULL OR datos_factura.analisis70_cliente = '')  THEN
      GDS_GENERAL.analisis70_cliente
    ELSE
      datos_factura.analisis70_cliente
    END,
    analisis71_cliente = CASE WHEN (datos_factura.analisis71_cliente IS NULL OR datos_factura.analisis71_cliente = '')  THEN
      GDS_GENERAL.analisis71_cliente
    ELSE
      datos_factura.analisis71_cliente
    END,
    analisis72_cliente = CASE WHEN (datos_factura.analisis72_cliente IS NULL OR datos_factura.analisis72_cliente = '')  THEN
      GDS_GENERAL.analisis72_cliente
    ELSE
      datos_factura.analisis72_cliente
    END,
    analisis73_cliente = CASE WHEN (datos_factura.analisis73_cliente IS NULL OR datos_factura.analisis73_cliente = '')  THEN
      GDS_GENERAL.analisis73_cliente
    ELSE
      datos_factura.analisis73_cliente
    END,
    analisis74_cliente = CASE WHEN (datos_factura.analisis74_cliente IS NULL OR datos_factura.analisis74_cliente = '')  THEN
      GDS_GENERAL.analisis74_cliente
    ELSE
      datos_factura.analisis74_cliente
    END,
    analisis75_cliente = CASE WHEN (datos_factura.analisis75_cliente IS NULL OR datos_factura.analisis75_cliente = '')  THEN
      GDS_GENERAL.analisis75_cliente
    ELSE
      datos_factura.analisis75_cliente
    END,
    analisis76_cliente = CASE WHEN (datos_factura.analisis76_cliente IS NULL OR datos_factura.analisis76_cliente = '')  THEN
      GDS_GENERAL.analisis76_cliente
    ELSE
      datos_factura.analisis76_cliente
    END,
    analisis77_cliente = CASE WHEN (datos_factura.analisis77_cliente IS NULL OR datos_factura.analisis77_cliente = '')  THEN
      GDS_GENERAL.analisis77_cliente
    ELSE
      datos_factura.analisis77_cliente
    END,
    analisis78_cliente = CASE WHEN (datos_factura.analisis78_cliente IS NULL OR datos_factura.analisis78_cliente = '')  THEN
      GDS_GENERAL.analisis78_cliente
    ELSE
      datos_factura.analisis78_cliente
    END,
    analisis79_cliente = CASE WHEN (datos_factura.analisis79_cliente IS NULL OR datos_factura.analisis79_cliente = '')  THEN
      GDS_GENERAL.analisis79_cliente
    ELSE
      datos_factura.analisis79_cliente
    END,
    analisis80_cliente = CASE WHEN (datos_factura.analisis80_cliente IS NULL OR datos_factura.analisis80_cliente = '')  THEN
      GDS_GENERAL.analisis80_cliente
    ELSE
      datos_factura.analisis80_cliente
    END,
    analisis81_cliente = CASE WHEN (datos_factura.analisis81_cliente IS NULL OR datos_factura.analisis81_cliente = '')  THEN
      GDS_GENERAL.analisis81_cliente
    ELSE
      datos_factura.analisis81_cliente
    END,
    analisis82_cliente = CASE WHEN (datos_factura.analisis82_cliente IS NULL OR datos_factura.analisis82_cliente = '')  THEN
      GDS_GENERAL.analisis82_cliente
    ELSE
      datos_factura.analisis82_cliente
    END,
    analisis83_cliente = CASE WHEN (datos_factura.analisis83_cliente IS NULL OR datos_factura.analisis83_cliente = '')  THEN
      GDS_GENERAL.analisis83_cliente
    ELSE
      datos_factura.analisis83_cliente
    END,
    analisis84_cliente = CASE WHEN (datos_factura.analisis84_cliente IS NULL OR datos_factura.analisis84_cliente = '')  THEN
      GDS_GENERAL.analisis84_cliente
    ELSE
      datos_factura.analisis84_cliente
    END,
    analisis85_cliente = CASE WHEN (datos_factura.analisis85_cliente IS NULL OR datos_factura.analisis85_cliente = '')  THEN
      GDS_GENERAL.analisis85_cliente
    ELSE
      datos_factura.analisis85_cliente
    END,
    analisis86_cliente = CASE WHEN (datos_factura.analisis86_cliente IS NULL OR datos_factura.analisis86_cliente = '')  THEN
      GDS_GENERAL.analisis86_cliente
    ELSE
      datos_factura.analisis86_cliente
    END,
    analisis87_cliente = CASE WHEN (datos_factura.analisis87_cliente IS NULL OR datos_factura.analisis87_cliente = '')  THEN
      GDS_GENERAL.analisis87_cliente
    ELSE
      datos_factura.analisis87_cliente
    END,
    analisis88_cliente = CASE WHEN (datos_factura.analisis88_cliente IS NULL OR datos_factura.analisis88_cliente = '')  THEN
      GDS_GENERAL.analisis88_cliente
    ELSE
      datos_factura.analisis88_cliente
    END,
    analisis89_cliente = CASE WHEN (datos_factura.analisis89_cliente IS NULL OR datos_factura.analisis89_cliente = '')  THEN
      GDS_GENERAL.analisis89_cliente
    ELSE
      datos_factura.analisis89_cliente
    END,
    analisis90_cliente = CASE WHEN (datos_factura.analisis90_cliente IS NULL OR datos_factura.analisis90_cliente = '')  THEN
      GDS_GENERAL.analisis90_cliente
    ELSE
      datos_factura.analisis90_cliente
    END,
    analisis91_cliente = CASE WHEN (datos_factura.analisis91_cliente IS NULL OR datos_factura.analisis91_cliente = '')  THEN
      GDS_GENERAL.analisis91_cliente
    ELSE
      datos_factura.analisis91_cliente
    END,
    analisis92_cliente = CASE WHEN (datos_factura.analisis92_cliente IS NULL OR datos_factura.analisis92_cliente = '')  THEN
      GDS_GENERAL.analisis92_cliente
    ELSE
      datos_factura.analisis92_cliente
    END,
    analisis93_cliente = CASE WHEN (datos_factura.analisis93_cliente IS NULL OR datos_factura.analisis93_cliente = '')  THEN
      GDS_GENERAL.analisis93_cliente
    ELSE
      datos_factura.analisis93_cliente
    END,
    analisis94_cliente = CASE WHEN (datos_factura.analisis94_cliente IS NULL OR datos_factura.analisis94_cliente = '')  THEN
      GDS_GENERAL.analisis94_cliente
    ELSE
      datos_factura.analisis94_cliente
    END,
    analisis95_cliente = CASE WHEN (datos_factura.analisis95_cliente IS NULL OR datos_factura.analisis95_cliente = '')  THEN
      GDS_GENERAL.analisis95_cliente
    ELSE
      datos_factura.analisis95_cliente
    END,
    analisis96_cliente = CASE WHEN (datos_factura.analisis96_cliente IS NULL OR datos_factura.analisis96_cliente = '')  THEN
      GDS_GENERAL.analisis96_cliente
    ELSE
      datos_factura.analisis96_cliente
    END,
    analisis97_cliente = CASE WHEN (datos_factura.analisis97_cliente IS NULL OR datos_factura.analisis97_cliente = '')  THEN
      GDS_GENERAL.analisis97_cliente
    ELSE
      datos_factura.analisis97_cliente
    END,
    analisis98_cliente = CASE WHEN (datos_factura.analisis98_cliente IS NULL OR datos_factura.analisis98_cliente = '')  THEN
      GDS_GENERAL.analisis98_cliente
    ELSE
      datos_factura.analisis98_cliente
    END,
    analisis99_cliente = CASE WHEN (datos_factura.analisis99_cliente IS NULL OR datos_factura.analisis99_cliente = '')  THEN
      GDS_GENERAL.analisis99_cliente
    ELSE
      datos_factura.analisis99_cliente
    END,
    analisis100_cliente = CASE WHEN (datos_factura.analisis100_cliente IS NULL OR datos_factura.analisis100_cliente = '')  THEN
      GDS_GENERAL.analisis100_cliente
    ELSE
      datos_factura.analisis100_cliente
    END,


    /*       fin analisis de ciente     */
    proveedores.nombre as nombre_proveedor,
    proveedores.ID_PROVEEDOR as ID_PROVEEDOR,
    datos_factura.id_sucursal,
    vendedor_tit.NOMBRE  AS VENDEDOR_NOMBRE_TIT,
    vendedor_tit.ID_VENDEDOR  AS ID_VENDEDOR_TIT,
    proveedores.linea_aerea,
    proveedores.codigo_bsp,
    GVC_FECHA_RESERVACION=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else  convert(char(12),convert(datetime,GDS_GENERAL.FECHA_RESERVACION),105) end,


    convert(char(12),convert(datetime,GDS_VUELOS.FECHA_SALIDA),105) as GVC_FECHA_SALIDA,
    convert(char(12),convert(datetime,GDS_VUELOS.FECHA_REGRESO),105) as GVC_FECHA_REGRESO,

    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_SAL),105) as GVC_FECHA_SALIDA_CON,
    convert(char(12),convert(datetime,CONCECUTIVO_BOLETOS.FECHA_REG),105) as GVC_FECHA_REGRESO_CON,

    CONCECUTIVO_BOLETOS.IMP_CRE,
    GDS_VUELOS.TARIFA_OFRECIDA,
    DETALLE_FACTURA.TARIFA_MON_BASE as GVC_TARIFA_MON_BASE,

    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA) as GVC_IVA,  
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA) as GVC_TUA, 
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA) as GVC_OTROS_IMPUESTOS,


    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA)+
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA)+
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA) as SUMA_IMPUESTOS,


    DETALLE_FACTURA.TARIFA_MON_BASE+(select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'IVA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA)+
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'TUA' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA)+
    (select ISNULL(ROUND(SUM(IMPUESTOS_FACTURA.CATIDAD),2),0) from
      DBA.IMPUESTOS_FACTURA,DBA.CATALOGO_DE_IMPUESTO where
      CATALOGO_DE_IMPUESTO.ID_IMPUESTO = IMPUESTOS_FACTURA.ID_IMPUESTO and
      CATALOGO_DE_IMPUESTO.ID_CATEGORIA = 'OTR' and
      IMPUESTOS_FACTURA.ID_DET_FAC = DETALLE_FACTURA.DETALLE_FACTURA) as GVC_TOTAL,


      moneda.clave_sat as moneda_vuelo,

      (select top 1 

                   ID_FORMA_PAGO from DBA.FOR_PGO_FAC

                    where
                    FOR_PGO_FAC.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
                    FOR_PGO_FAC.ID_SERIE = DATOS_FACTURA.ID_SERIE and
                    FOR_PGO_FAC.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO) as ID_FORMA_PAGO_VUELO_ORIGINAL,

      (select top 1 

                    CASE WHEN(ID_FORMA_PAGO = 'AX' or ID_FORMA_PAGO = 'VI' or ID_FORMA_PAGO = 'MC' or ID_FORMA_PAGO = 'CC' or ID_FORMA_PAGO = 'TP') 
                    THEN 'CC' ELSE 'CA' END as ID_FORMA_PAGO from DBA.FOR_PGO_FAC

                    where
                    FOR_PGO_FAC.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
                    FOR_PGO_FAC.ID_SERIE = DATOS_FACTURA.ID_SERIE and
                    FOR_PGO_FAC.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO) as ID_FORMA_PAGO_VUELO,


      for_pgo_fac.concepto AS payment_number_vuelo,

      DETALLE_FACTURA.NOM_PASAJERO as GVC_NOM_PAX_VUELO,
      documento_vuelo=concecutivo_boletos.numero_bol,
      DETALLE_FACTURA.CONCEPTO as routing_vuelo,
      gds_vuelos.id_origen as origin_vuelo,
      gds_vuelos.id_destino_principal as destination_vuelo,
      gds_vuelos.id_clase_principal as class_vuelo,
      gds_vuelos.tour_code as tour_code_vuelo,
      gds_vuelos.numero_boleto as ticket_designer_vuelo,

      pseudocity= 
                CASE 
                                WHEN ( 
                                                                (gds_general.pseudocity_boletea IS NULL or gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 2) THEN 'D4C2'
                                WHEN ( 
                                                                (gds_general.pseudocity_boletea IS NULL or gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 3) THEN 'D4B2'
                                WHEN ( 
                                                                (gds_general.pseudocity_boletea IS NULL or gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 4) THEN 'X0O4'
                                WHEN ( 
                                                                (gds_general.pseudocity_boletea IS NULL or gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 5) THEN 'P3FY'
                                WHEN ( 
                                                                (gds_general.pseudocity_boletea IS NULL or gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 6) THEN 'DI13'
                                ELSE gds_general.pseudocity_boletea 
                                      END, 

      departament = CASE WHEN (datos_factura.analisis12_cliente IS NULL OR datos_factura.analisis12_cliente = '') THEN
      gds_general.analisis12_cliente ELSE datos_factura.analisis12_cliente END,

      BranchARCNumber=case(datos_factura.id_sucursal) when '2' then '86511574' when '3' then '86798003' when '7' then '86798003' when '4' then '86515984' when '5' then '86502194' when '6' then '86502194' ELSE '' end,  

      CASE 

      WHEN ( DATOS_FACTURA.ID_STAT = 8 ) THEN 'C'
      WHEN ( DATOS_FACTURA.ID_STAT = 1 AND detalle_factura.contra <> 'S') THEN 'S' 
      WHEN ( DATOS_FACTURA.ID_STAT = 1 AND detalle_factura.contra = 'S') THEN 'X' 
      

      END AS TransactionType,



      proveedores.c_Pais as VendorCountryCode,

      fac_numero_cxss=dba.detalle_factura.fac_numero_cxs,
      id_serie_cxss=dba.detalle_factura.id_serie_cxs


    from

    dba.detalle_factura 

    LEFT OUTER JOIN detalle_factura AS detalle_factura_cxs on  
    detalle_factura_cxs.ID_SERIE_CXS = detalle_factura.ID_SERIE 
    AND detalle_factura_cxs.FAC_NUMERO_CXS = detalle_factura.FAC_NUMERO
    AND detalle_factura_cxs.numero_bol = detalle_factura.numero_bol_cxs

    left outer join
    dba.concecutivo_boletos on dba.detalle_factura.id_boleto = dba.concecutivo_boletos.id_boleto,

    dba.gds_general 

    left outer join
    dba.gds_vuelos on dba.gds_vuelos.consecutivo = dba.gds_general.consecutivo and dba.gds_vuelos.numero_boleto = dba.detalle_factura.numero_bol,

    dba.datos_factura 

    LEFT OUTER JOIN dba.gds_vuelos as gds_vuelos_cxs
    ON gds_vuelos_cxs.numero_boleto = detalle_factura.numero_bol_cxs
    and gds_vuelos_cxs.fac_numero = detalle_factura_cxs.fac_numero

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

    left outer join 
    centro_costo ON centro_costo.id_centro_costo = gds_general.id_centro_costo and centro_costo.id_cliente = clientes.id_cliente

    left outer join 
    centro_costo as centro_costo2 ON centro_costo2.id_centro_costo = datos_factura.id_centro_costo and centro_costo.id_cliente = clientes.id_cliente

    /***********************forma de pago*******************************/

        LEFT OUTER JOIN dba.for_pgo_fac ON
        
        DATOS_FACTURA.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
        
        DATOS_FACTURA.ID_SERIE = for_pgo_fac.id_serie AND

        DATOS_FACTURA.FAC_NUMERO  = for_pgo_fac.fac_numero AND

        datos_factura.tot_base =  for_pgo_fac.importe

        LEFT OUTER JOIN dba.forma_de_pago ON for_pgo_fac.id_forma_pago = forma_de_pago.id_forma_pago

    /******************************************************/

    where

    (dba.datos_factura.fac_numero = dba.detalle_factura.fac_numero) and
    (dba.datos_factura.id_serie = dba.detalle_factura.id_serie) and
    (dba.datos_factura.id_sucursal = dba.detalle_factura.id_sucursal) and
    (dba.datos_factura.id_cliente = dba.clientes.id_cliente)
     ";

    if($id_intervalo == '5'){

      $condicion_fecha = 'datos_factura.fecha_folio';

    }else{

      $condicion_fecha = 'datos_factura.FECHA';

    }


    $select = $select . "
    and ".$condicion_fecha." between '".$fecha1."' and '".$fecha2."'";
    
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

    $select = $select ."union  
                
  select 
  fecha_salida_vuelos_cxs='',
  fecha_salid_con_bol_cxs='',
  fecha_salid_con_bol='',
  fecha_regreso_vuelos_cxs='',
  fecha_regre_con_bol_cxs='',
  fecha_regre_con_bol='',
  ID_CUPON='',
  tpo_serv='',
   analisis46_cliente=GDS_GENERAL.analisis46_cliente,
   analisis35_cliente=GDS_GENERAL.analisis35_cliente,
   numero_bol_cxs='',SBU = GDS_GENERAL.analisis14_cliente,EmployeeID = GDS_GENERAL.cla_pax,centro_costo.desc_centro_costo,consecutivo_vuelo='',boleto_aereo='',fecha_fac='',codigo_razon='',mail_cliente='',contra='',bol_contra='',codigo_detalle=''/*,id_boleto=''*/,id_stat='', tpo_cambio='',combustible='',dba.gds_general.id_serie,emd='',GVC_NOM_CLI=cli.nombre_cliente,GVC_ID_CORPORATIVO='',
    gds_general.consecutivo,name=gds_general.cl_nombre,nexp=cli.id_cliente,destination='',fecha_salida_vu='',fecha_regreso_vu='',documento='',solicitor=df.solicito,type_of_service='HOTNAC_RES',supplier='',codigo_producto='',final_user=convert(varchar,gds_general.nombre_pax),ticket_number='',typo_of_ticket='',fecha_emi=convert(char(12),gds_general.fecha_reservacion,105),city='_____campo_vacio_____',country='',total_emission='',total_millas='',total_Itinerary1='',origin1='',destina1='',total_Itinerary2='',origin2='',destina2='',total_Itinerary3='',origin3='',destina3='',total_Itinerary4='',origin4='',destina4='',total_Itinerary5='',origin5='',destina5='',total_Itinerary6='',origin6='',destina6='',total_Itinerary7='',origin7='',destina7='',total_Itinerary8='',origin8='',destina8='',total_Itinerary9='',origin9='',destina9='',total_Itinerary10='',origin10='',destina10='',hotel1='',fecha_entrada1='',fecha_salida1='',noches1='',break_fast1='',numero_hab1='',id_habitacion1='',id_ciudad1='',country1='',hotel2='',fecha_entrada2='',fecha_salida2='',noches2='',break_fast2='',numero_hab2='',id_habitacion2='',id_ciudad2='',country2='',hotel3='',fecha_entrada3='',fecha_salida3='',noches3='',break_fast3='',numero_hab3='',id_habitacion3='',id_ciudad3='',country3='',hotel4='',fecha_entrada4='',fecha_salida4='',noches4='',break_fast4='',numero_hab4='',id_habitacion4='',id_ciudad4='',country4='',hotel5='',fecha_entrada5='',fecha_salida5='',noches5='',break_fast5='',numero_hab5='',id_habitacion5='',id_ciudad5='',country5='',hotel6='',fecha_entrada6='',fecha_salida6='',noches6='',break_fast6='',numero_hab6='',id_habitacion6='',id_ciudad6='',country6='',hotel7='',fecha_entrada7='',fecha_salida7='',noches7='',break_fast7='',numero_hab7='',id_habitacion7='',id_ciudad7='',country7='',hotel8='',fecha_entrada8='',fecha_salida8='',noches8='',break_fast8='',numero_hab8='',id_habitacion8='',id_ciudad8='',country8='',hotel9='',fecha_entrada9='',fecha_salida9='',noches9='',break_fast9='',numero_hab9='',id_habitacion9='',id_ciudad9='',country9='',hotel10='',fecha_entrada10='',fecha_salida10='',noches10='',break_fast10='',numero_hab10='',id_habitacion10='',id_ciudad10='',country10='',Car_class1='',Delivery_Date1='',Nr_days1='',Place_delivery1='',Place_delivery_back1='',Departure_date1='',Car_class2='',Delivery_Date2='',Nr_days2='',Place_delivery2='',Place_delivery_back2='',Departure_date2='',Car_class3='',Delivery_Date3='',Nr_days3='',Place_delivery3='',Place_delivery_back3='',Departure_date3='',Car_class4='',Delivery_Date4='',Nr_days4='',Place_delivery4='',Place_delivery_back4='',Departure_date4='',Car_class5='',Delivery_Date5='',Nr_days5='',Place_delivery5='',Place_delivery_back5='',Departure_date5='',Car_class6='',Delivery_Date6='',Nr_days6='',Place_delivery6='',Place_delivery_back6='',Departure_date6='',Car_class7='',Delivery_Date7='',Nr_days7='',Place_delivery7='',Place_delivery_back7='',Departure_date7='',Car_class8='',Delivery_Date8='',Nr_days8='',Place_delivery8='',Place_delivery_back8='',Departure_date8='',Car_class9='',Delivery_Date9='',Nr_days9='',Place_delivery9='',Place_delivery_back9='',Departure_date9='',Car_class10='',Delivery_Date10='',Nr_days10='',Place_delivery10='',Place_delivery_back10='',Departure_date10='',buy_in_advance='',record_localizador=convert(varchar,dba.gds_general.record_localizador),GVC_ID_CENTRO_COSTO=dba.gds_general.id_centro_costo,


    /*   analisis de cliente   */

    analisis14_cliente=dba.gds_general.analisis14_cliente,
    analisis4_cliente = dba.gds_general.analisis4_cliente,
    analisis12_cliente = dba.gds_general.analisis12_cliente,

    GDS_GENERAL.analisis1_cliente as analisis1_cliente,
    GDS_GENERAL.analisis2_cliente as analisis2_cliente,
    GDS_GENERAL.analisis3_cliente as analisis3_cliente,
    GDS_GENERAL.analisis5_cliente as analisis5_cliente,
    GDS_GENERAL.analisis6_cliente as analisis6_cliente,
    GDS_GENERAL.analisis7_cliente as analisis7_cliente,
    GDS_GENERAL.analisis8_cliente as analisis8_cliente,
    GDS_GENERAL.analisis9_cliente as analisis9_cliente,
    GDS_GENERAL.analisis10_cliente as analisis10_cliente,
    GDS_GENERAL.analisis11_cliente as analisis11_cliente,
    GDS_GENERAL.analisis13_cliente as analisis13_cliente,
    GDS_GENERAL.analisis15_cliente as analisis15_cliente,
    GDS_GENERAL.analisis16_cliente as analisis16_cliente,
    GDS_GENERAL.analisis17_cliente as analisis17_cliente,
    GDS_GENERAL.analisis18_cliente as analisis18_cliente,
    GDS_GENERAL.analisis19_cliente as analisis19_cliente,
    GDS_GENERAL.analisis20_cliente as analisis20_cliente,
    GDS_GENERAL.analisis21_cliente as analisis21_cliente,
    GDS_GENERAL.analisis22_cliente as analisis22_cliente,
    GDS_GENERAL.analisis23_cliente as analisis23_cliente,
    GDS_GENERAL.analisis24_cliente as analisis24_cliente,
    GDS_GENERAL.analisis25_cliente as analisis25_cliente,
    GDS_GENERAL.analisis26_cliente as analisis26_cliente,
    GDS_GENERAL.analisis27_cliente as analisis27_cliente,
    GDS_GENERAL.analisis28_cliente as analisis28_cliente,
    GDS_GENERAL.analisis29_cliente as analisis29_cliente,
    GDS_GENERAL.analisis30_cliente as analisis30_cliente,
    GDS_GENERAL.analisis31_cliente as analisis31_cliente,
    GDS_GENERAL.analisis32_cliente as analisis32_cliente,
    GDS_GENERAL.analisis33_cliente as analisis33_cliente,
    GDS_GENERAL.analisis34_cliente as analisis34_cliente,
    GDS_GENERAL.analisis36_cliente as analisis36_cliente,
    GDS_GENERAL.analisis37_cliente as analisis37_cliente,
    GDS_GENERAL.analisis38_cliente as analisis38_cliente,
    GDS_GENERAL.analisis39_cliente as analisis39_cliente,
    GDS_GENERAL.analisis40_cliente as analisis40_cliente,
    GDS_GENERAL.analisis41_cliente as analisis41_cliente,
    GDS_GENERAL.analisis42_cliente as analisis42_cliente,
    GDS_GENERAL.analisis43_cliente as analisis43_cliente,
    GDS_GENERAL.analisis44_cliente as analisis44_cliente,
    GDS_GENERAL.analisis45_cliente as analisis45_cliente,
    GDS_GENERAL.analisis47_cliente as analisis47_cliente,
    GDS_GENERAL.analisis48_cliente as analisis48_cliente,
    GDS_GENERAL.analisis49_cliente as analisis49_cliente,
    GDS_GENERAL.analisis50_cliente as analisis50_cliente,
    GDS_GENERAL.analisis51_cliente as analisis51_cliente,
    GDS_GENERAL.analisis52_cliente as analisis52_cliente,
    GDS_GENERAL.analisis53_cliente as analisis53_cliente,
    GDS_GENERAL.analisis54_cliente as analisis54_cliente,
    GDS_GENERAL.analisis55_cliente as analisis55_cliente,
    GDS_GENERAL.analisis56_cliente as analisis56_cliente,
    GDS_GENERAL.analisis57_cliente as analisis57_cliente,
    GDS_GENERAL.analisis58_cliente as analisis58_cliente,
    GDS_GENERAL.analisis59_cliente as analisis59_cliente,
    GDS_GENERAL.analisis60_cliente as analisis60_cliente,
    GDS_GENERAL.analisis61_cliente as analisis61_cliente,
    GDS_GENERAL.analisis62_cliente as analisis62_cliente,
    GDS_GENERAL.analisis63_cliente as analisis63_cliente,
    GDS_GENERAL.analisis64_cliente as analisis64_cliente,
    GDS_GENERAL.analisis65_cliente as analisis65_cliente,
    GDS_GENERAL.analisis66_cliente as analisis66_cliente,
    GDS_GENERAL.analisis67_cliente as analisis67_cliente,
    GDS_GENERAL.analisis68_cliente as analisis68_cliente,
    GDS_GENERAL.analisis69_cliente as analisis69_cliente,
    GDS_GENERAL.analisis70_cliente as analisis70_cliente,
    GDS_GENERAL.analisis71_cliente as analisis71_cliente,
    GDS_GENERAL.analisis72_cliente as analisis72_cliente,
    GDS_GENERAL.analisis73_cliente as analisis73_cliente,
    GDS_GENERAL.analisis74_cliente as analisis74_cliente,
    GDS_GENERAL.analisis75_cliente as analisis75_cliente,
    GDS_GENERAL.analisis76_cliente as analisis76_cliente,
    GDS_GENERAL.analisis77_cliente as analisis77_cliente,
    GDS_GENERAL.analisis78_cliente as analisis78_cliente,
    GDS_GENERAL.analisis79_cliente as analisis79_cliente,
    GDS_GENERAL.analisis80_cliente as analisis80_cliente,
    GDS_GENERAL.analisis81_cliente as analisis81_cliente,
    GDS_GENERAL.analisis82_cliente as analisis82_cliente,
    GDS_GENERAL.analisis83_cliente as analisis83_cliente,
    GDS_GENERAL.analisis84_cliente as analisis84_cliente,
    GDS_GENERAL.analisis85_cliente as analisis85_cliente,
    GDS_GENERAL.analisis86_cliente as analisis86_cliente,
    GDS_GENERAL.analisis87_cliente as analisis87_cliente,
    GDS_GENERAL.analisis88_cliente as analisis88_cliente,
    GDS_GENERAL.analisis89_cliente as analisis89_cliente,
    GDS_GENERAL.analisis90_cliente as analisis90_cliente,
    GDS_GENERAL.analisis91_cliente as analisis91_cliente,
    GDS_GENERAL.analisis92_cliente as analisis92_cliente,
    GDS_GENERAL.analisis93_cliente as analisis93_cliente,
    GDS_GENERAL.analisis94_cliente as analisis94_cliente,
    GDS_GENERAL.analisis95_cliente as analisis95_cliente,
    GDS_GENERAL.analisis96_cliente as analisis96_cliente,
    GDS_GENERAL.analisis97_cliente as analisis97_cliente,
    GDS_GENERAL.analisis98_cliente as analisis98_cliente,
    GDS_GENERAL.analisis99_cliente as analisis99_cliente,
    GDS_GENERAL.analisis100_cliente as analisis100_cliente,


    /*   fin analisis de cliente */

    nombre_proveedor='',ID_PROVEEDOR='',id_sucursal=gds_general.ID_SUCURSAL,VENDEDOR_NOMBRE_TIT=vendedor_tit.NOMBRE,ID_VENDEDOR_TIT=vendedor_tit.ID_VENDEDOR,linea_aerea='',codigo_bsp='',GVC_FECHA_RESERVACION=  case when(GDS_GENERAL.FECHA_RESERVACION = '1900-01-01' ) then '' else  convert(char(12),convert(datetime,GDS_GENERAL.FECHA_RESERVACION),105) end,

    GVC_FECHA_SALIDA='',
    GVC_FECHA_REGRESO='',
    GVC_FECHA_SALIDA_CON='',
    GVC_FECHA_REGRESO_CON='',

    IMP_CRE='',
    TARIFA_OFRECIDA='',GVC_TARIFA_MON_BASE='',GVC_IVA='',GVC_TUA='',GVC_OTROS_IMPUESTOS='',SUMA_IMPUESTOS='',GVC_TOTAL='',moneda_vuelo='',ID_FORMA_PAGO_VUELO_ORIGINAL='',ID_FORMA_PAGO_VUELO='',payment_number_vuelo='',GVC_NOM_PAX_VUELO='',documento_vuelo='',routing_vuelo='',origin_vuelo='',destination_vuelo='',class_vuelo='',tour_code_vuelo='',ticket_designer_vuelo='',

    gds_general.pseudocity_boletea as pseudocity,

    departament = gds_general.analisis12_cliente,

    BranchARCNumber=case(GDS_GENERAL.ID_SUCURSAL) when '2' then '86511574' when '3' then '86798003' when '4' then '86515984' when '5' then '86502194' else '86515973' end,TransactionType='S',VendorCountryCode='',
    
    fac_numero_cxss='',
    id_serie_cxss=''
    
    from
    CLIENTES AS cli
    left outer join
    gds_general ON gds_general.id_cliente = cli.id_cliente
    left outer join
    dba.datos_factura as df on df.consecutivo = gds_general.consecutivo
    left outer join 
    DBA.VENDEDOR as VENDEDOR_TIT ON gds_general.ID_VENDEDOR_TIT = VENDEDOR_TIT.ID_VENDEDOR
    left outer join 
    centro_costo ON centro_costo.id_centro_costo = gds_general.id_centro_costo 

    where

    df.id_sucursal is null";

    if($id_intervalo == '5'){

      $condicion_fecha = 'gds_general.fecha_recepcion';

    }else{

      $condicion_fecha = 'convert(date,gds_general.fecha_recepcion)';

    }

    $select = $select." 
    and ".$condicion_fecha." between '".$fecha1."' and '".$fecha2."' 
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

              $select = $select . "and cli.id_cliente in (".$id_cliente_arr.") "; //ya

         }
         if($cont_suc > 0){

              $select = $select . "and df.ID_SUCURSAL in (".$str_suc.") ";

         }
         if($cont_serie > 0){  //ya

              $select = $select . " and df.ID_SERIE in (".$str_ser.") "; //ya

         }
         if($cont_cliente > 0){

              $select = $select . "and cli.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select = $select . " and cli.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }

    }else if($all_dks == 1){

        if($cont_suc > 0){

              $select = $select . "and df.ID_SUCURSAL in (".$str_suc.") ";

        }
        if($cont_serie > 0){  //ya

              $select = $select . " and df.ID_SERIE in (".$str_ser.") "; //ya

         }
        if($cont_cliente > 0){

              $select = $select . "and cli.id_cliente in (".$str_cli.") "; 


         }
         if($cont_corporativo > 0){  //ya

              $select = $select . " and cli.ID_CORPORATIVO in (".$str_corp.") "; //ya

         }

    }
    

    $select = $select ."union 

      select 
      
      DISTINCT
        
       /**********************************************************/
        
        fecha_salida_vuelos_cxs = CONVERT(CHAR(12),gds_vuelos_cxs.fecha_salida,105) ,

        fecha_salid_con_bol_cxs = (select top 1 CONVERT(CHAR(12),concecutivo_boletos_cxs.fecha_sal,105) from concecutivo_boletos as concecutivo_boletos_cxs where 

         concecutivo_boletos_cxs.id_boleto =  detalle_factura_cxs.id_boleto

        ),
        fecha_salid_con_bol = CONVERT(CHAR(12),concecutivo_boletos.fecha_sal,105),




        fecha_regreso_vuelos_cxs = CONVERT(CHAR(12),gds_vuelos_cxs.fecha_regreso,105),

        fecha_regre_con_bol_cxs = (select top 1 CONVERT(CHAR(12),concecutivo_boletos_cxs.fecha_reg,105) from concecutivo_boletos as concecutivo_boletos_cxs where concecutivo_boletos_cxs.id_boleto =  detalle_factura_cxs.id_boleto),

        fecha_regre_con_bol = CONVERT(CHAR(12),concecutivo_boletos.fecha_reg,105),

        /**********************************************************/
        DETALLE_FACTURA.ID_CUPON,
        DETALLE_FACTURA.prov_tpo_serv as tpo_serv,
        analisis46_cliente = CASE WHEN (datos_factura.analisis46_cliente IS NULL OR datos_factura.analisis46_cliente = '')  THEN
        GDS_GENERAL.analisis46_cliente
          ELSE
        datos_factura.analisis46_cliente
        END,
        analisis35_cliente = CASE WHEN (datos_factura.analisis35_cliente IS NULL OR datos_factura.analisis35_cliente = '')  THEN
          GDS_GENERAL.analisis35_cliente
        ELSE
          datos_factura.analisis35_cliente
        END,
        DETALLE_FACTURA.numero_bol_cxs,
        SBU = CASE WHEN (datos_factura.analisis14_cliente IS NULL OR datos_factura.analisis14_cliente = '')  THEN
          GDS_GENERAL.analisis14_cliente
        ELSE
          datos_factura.analisis14_cliente
        END,
        EmployeeID = CASE WHEN(DETALLE_FACTURA.cla_pax IS NULL or DETALLE_FACTURA.cla_pax = '') THEN
         GDS_GENERAL.cla_pax
        ELSE
         DETALLE_FACTURA.cla_pax
        END,
        centro_costo.desc_centro_costo, 
                gds_vuelos.consecutivo                     AS consecutivo_vuelo, 
                concecutivo_boletos.numero_bol             AS boleto_aereo, 
                CONVERT(char(12),notas_credito.nc_fec,105) AS fecha_fac, 
                gds_vuelos.codigo_razon               AS codigo_razon, 
                notas_credito.mail_cliente, 
                contra =                detalle_nc.det_nc_ctra, 
                bol_contra =            detalle_nc.det_nc_boctra, 
                detalle_nc.id_det_nc AS codigo_detalle, 
                notas_credito.id_stat, 
                tpo_cambio = datos_factura.tpo_cambio, 
                detalle_nc.combustible, 
                id_serie=notas_credito.id_serie, 
                emd = detalle_factura.emd, 
                gvc_nom_cli=       notas_credito.cl_nombre, 
                gvc_id_corporativo=corporativo.id_corporativo, 
                consecutivo=       notas_credito.consecutivo, 
                NAME=              notas_credito.cl_nombre, 
                nexp=CONVERT(varchar,clientes.id_cliente), 
                destination=CONVERT(VARCHAR,dba.gds_vuelos.ruta),  
                fecha_salida_vu=CONVERT( char(12),concecutivo_boletos.fecha_sal,105), 
                fecha_regreso_vu=CONVERT(char(12),concecutivo_boletos.fecha_reg,105), 
                documento=notas_credito.nc_numero, 
                solicitor=notas_credito.nc_sol, 
                type_of_service=CONVERT(varchar,dba.tipo_servicio.id_tipo_servicio), 
                supplier=CONVERT(       VARCHAR,dba.gds_vuelos.id_la), 
                codigo_producto=CONVERT(varchar,(IF concecutivo_boletos.numero_bol IS NOT NULL THEN 'AIR' ELSE 'TRA' endif)), 
                final_user=CONVERT(     varchar,detalle_nc.det_nc_nom_pas), 
                ticket_number=CONVERT(  varchar,concecutivo_boletos.numero_bol), 
                typo_of_ticket=CONVERT( varchar,dba.tipo_servicio.id_alcance_serv), 
                fecha_emi=CONVERT(      char(12),dba.concecutivo_boletos.fecha_emi,105), 
                city='', 
                country='', 
                total_emission='', 
                total_millas='', 
                total_itinerary1='', 
                origin1='', 
                destina1='', 
                total_itinerary2='', 
                origin2='', 
                destina2='', 
                total_itinerary3='', 
                origin3='', 
                destina3='', 
                total_itinerary4='', 
                origin4='', 
                destina4='', 
                total_itinerary5='', 
                origin5='', 
                destina5='', 
                total_itinerary6='', 
                origin6='', 
                destina6='', 
                total_itinerary7='', 
                origin7='', 
                destina7='', 
                total_itinerary8='', 
                origin8='', 
                destina8='', 
                total_itinerary9='', 
                origin9='', 
                destina9='', 
                total_itinerary10='', 
                origin10='', 
                destina10='', 
                hotel1='', 
                fecha_entrada1='', 
                fecha_salida1='', 
                noches1='', 
                break_fast1=NULL, 
                numero_hab1='', 
                id_habitacion1='', 
                id_ciudad1='', 
                country1=NULL, 
                hotel2='', 
                fecha_entrada2='', 
                fecha_salida2='', 
                noches2='', 
                break_fast2=NULL, 
                numero_hab2='', 
                id_habitacion2='', 
                id_ciudad2='', 
                country2=NULL, 
                hotel3='', 
                fecha_entrada3='', 
                fecha_salida3='', 
                noches3='', 
                break_fast3=NULL, 
                numero_hab3='', 
                id_habitacion3='', 
                id_ciudad3='', 
                country3=NULL, 
                hotel4='', 
                fecha_entrada4='', 
                fecha_salida4='', 
                noches4='', 
                break_fast4=NULL, 
                numero_hab4='', 
                id_habitacion4='', 
                id_ciudad4='', 
                country4=NULL, 
                hotel5='', 
                fecha_entrada5='', 
                fecha_salida5='', 
                noches5='', 
                break_fast5=NULL, 
                numero_hab5='', 
                id_habitacion5='', 
                id_ciudad5='', 
                country5=NULL, 
                hotel6='', 
                fecha_entrada6='', 
                fecha_salida6='', 
                noches6='', 
                break_fast6=NULL, 
                numero_hab6='', 
                id_habitacion6='', 
                id_ciudad6='', 
                country6=NULL, 
                hotel7='', 
                fecha_entrada7='', 
                fecha_salida7='', 
                noches7='', 
                break_fast7=NULL, 
                numero_hab7='', 
                id_habitacion7='', 
                id_ciudad7='', 
                country7=NULL, 
                hotel8='', 
                fecha_entrada8='', 
                fecha_salida8='', 
                noches8='', 
                break_fast8=NULL, 
                numero_hab8='', 
                id_habitacion8='', 
                id_ciudad8='', 
                country8=NULL, 
                hotel9='', 
                fecha_entrada9='', 
                fecha_salida9='', 
                noches9='', 
                break_fast9=NULL, 
                numero_hab9='', 
                id_habitacion9='', 
                id_ciudad9='', 
                country9=NULL, 
                hotel10='', 
                fecha_entrada10='', 
                fecha_salida10='', 
                noches10='', 
                break_fast10=NULL, 
                numero_hab10='', 
                id_habitacion10='', 
                id_ciudad10='', 
                country10=NULL, 
                car_class1='', 
                delivery_date1='', 
                nr_days1='', 
                place_delivery1='', 
                place_delivery_back1='', 
                departure_date1='', 
                car_class2='', 
                delivery_date2='', 
                nr_days2='', 
                place_delivery2='', 
                place_delivery_back2='', 
                departure_date2='', 
                car_class3='', 
                delivery_date3='', 
                nr_days3='', 
                place_delivery3='', 
                place_delivery_back3='', 
                departure_date3='', 
                car_class4='', 
                delivery_date4='', 
                nr_days4='', 
                place_delivery4='', 
                place_delivery_back4='', 
                departure_date4='', 
                car_class5='', 
                delivery_date5='', 
                nr_days5='', 
                place_delivery5='', 
                place_delivery_back5='', 
                departure_date5='', 
                car_class6='', 
                delivery_date6='', 
                nr_days6='', 
                place_delivery6='', 
                place_delivery_back6='', 
                departure_date6='', 
                car_class7='', 
                delivery_date7='', 
                nr_days7='', 
                place_delivery7='', 
                place_delivery_back7='', 
                departure_date7='', 
                car_class8='', 
                delivery_date8='', 
                nr_days8='', 
                place_delivery8='', 
                place_delivery_back8='', 
                departure_date8='', 
                car_class9='', 
                delivery_date9='', 
                nr_days9='', 
                place_delivery9='', 
                place_delivery_back9='', 
                departure_date9='', 
                car_class10='', 
                delivery_date10='', 
                nr_days10='', 
                place_delivery10='', 
                place_delivery_back10='', 
                departure_date10='', 
                buy_in_advance=datediff(dd,dba.concecutivo_boletos.fecha_emi,dba.gds_vuelos.fecha_salida),
                record_localizador= 
                CASE 
                                WHEN( 
                                                                dba.gds_general.record_localizador IS NULL
                                                OR              dba.gds_general.record_localizador=''
                                                OR              dba.gds_general.record_localizador='IRIS') THEN (
                                                CASE 
                                                                WHEN ( 
                                                                                                datos_factura.analisis1_cliente IS NULL
                                                                                OR              datos_factura.analisis1_cliente='') THEN datos_factura.cve_reserv_global
                                                                ELSE datos_factura.analisis1_cliente
                                                END) 
                                ELSE dba.gds_general.record_localizador 
                                                    END, 
                gvc_id_centro_costo=                notas_credito.id_cencos, 
                

                /*   analisis de cliente   */



                DATOS_FACTURA.analisis14_cliente as analisis14_cliente,
                DATOS_FACTURA.analisis4_cliente as analisis4_cliente,
                DATOS_FACTURA.analisis12_cliente as analisis12_cliente,

                DATOS_FACTURA.analisis1_cliente as analisis1_cliente,
                DATOS_FACTURA.analisis2_cliente as analisis2_cliente,
                DATOS_FACTURA.analisis3_cliente as analisis3_cliente,
                DATOS_FACTURA.analisis5_cliente as analisis5_cliente,
                DATOS_FACTURA.analisis6_cliente as analisis6_cliente,
                DATOS_FACTURA.analisis7_cliente as analisis7_cliente,
                DATOS_FACTURA.analisis8_cliente as analisis8_cliente,
                DATOS_FACTURA.analisis9_cliente as analisis9_cliente,
                DATOS_FACTURA.analisis10_cliente as analisis10_cliente,
                DATOS_FACTURA.analisis11_cliente as analisis11_cliente,
                DATOS_FACTURA.analisis13_cliente as analisis13_cliente,
                DATOS_FACTURA.analisis15_cliente as analisis15_cliente,
                DATOS_FACTURA.analisis16_cliente as analisis16_cliente,
                DATOS_FACTURA.analisis17_cliente as analisis17_cliente,
                DATOS_FACTURA.analisis18_cliente as analisis18_cliente,
                DATOS_FACTURA.analisis19_cliente as analisis19_cliente,
                DATOS_FACTURA.analisis20_cliente as analisis20_cliente,
                DATOS_FACTURA.analisis21_cliente as analisis21_cliente,
                DATOS_FACTURA.analisis22_cliente as analisis22_cliente,
                DATOS_FACTURA.analisis23_cliente as analisis23_cliente,
                DATOS_FACTURA.analisis24_cliente as analisis24_cliente,
                DATOS_FACTURA.analisis25_cliente as analisis25_cliente,
                DATOS_FACTURA.analisis26_cliente as analisis26_cliente,
                DATOS_FACTURA.analisis27_cliente as analisis27_cliente,
                DATOS_FACTURA.analisis28_cliente as analisis28_cliente,
                DATOS_FACTURA.analisis29_cliente as analisis29_cliente,
                DATOS_FACTURA.analisis30_cliente as analisis30_cliente,
                DATOS_FACTURA.analisis31_cliente as analisis31_cliente,
                DATOS_FACTURA.analisis32_cliente as analisis32_cliente,
                DATOS_FACTURA.analisis33_cliente as analisis33_cliente,
                DATOS_FACTURA.analisis34_cliente as analisis34_cliente,
                DATOS_FACTURA.analisis36_cliente as analisis36_cliente,
                DATOS_FACTURA.analisis37_cliente as analisis37_cliente,
                DATOS_FACTURA.analisis38_cliente as analisis38_cliente,
                DATOS_FACTURA.analisis39_cliente as analisis39_cliente,
                DATOS_FACTURA.analisis40_cliente as analisis40_cliente,
                DATOS_FACTURA.analisis41_cliente as analisis41_cliente,
                DATOS_FACTURA.analisis42_cliente as analisis42_cliente,
                DATOS_FACTURA.analisis43_cliente as analisis43_cliente,
                DATOS_FACTURA.analisis44_cliente as analisis44_cliente,
                DATOS_FACTURA.analisis45_cliente as analisis45_cliente,
                DATOS_FACTURA.analisis47_cliente as analisis47_cliente,
                DATOS_FACTURA.analisis48_cliente as analisis48_cliente,
                DATOS_FACTURA.analisis49_cliente as analisis49_cliente,
                DATOS_FACTURA.analisis50_cliente as analisis50_cliente,
                DATOS_FACTURA.analisis51_cliente as analisis51_cliente,
                DATOS_FACTURA.analisis52_cliente as analisis52_cliente,
                DATOS_FACTURA.analisis53_cliente as analisis53_cliente,
                DATOS_FACTURA.analisis54_cliente as analisis54_cliente,
                DATOS_FACTURA.analisis55_cliente as analisis55_cliente,
                DATOS_FACTURA.analisis56_cliente as analisis56_cliente,
                DATOS_FACTURA.analisis57_cliente as analisis57_cliente,
                DATOS_FACTURA.analisis58_cliente as analisis58_cliente,
                DATOS_FACTURA.analisis59_cliente as analisis59_cliente,
                DATOS_FACTURA.analisis60_cliente as analisis60_cliente,
                DATOS_FACTURA.analisis61_cliente as analisis61_cliente,
                DATOS_FACTURA.analisis62_cliente as analisis62_cliente,
                DATOS_FACTURA.analisis63_cliente as analisis63_cliente,
                DATOS_FACTURA.analisis64_cliente as analisis64_cliente,
                DATOS_FACTURA.analisis65_cliente as analisis65_cliente,
                DATOS_FACTURA.analisis66_cliente as analisis66_cliente,
                DATOS_FACTURA.analisis67_cliente as analisis67_cliente,
                DATOS_FACTURA.analisis68_cliente as analisis68_cliente,
                DATOS_FACTURA.analisis69_cliente as analisis69_cliente,
                DATOS_FACTURA.analisis70_cliente as analisis70_cliente,
                DATOS_FACTURA.analisis71_cliente as analisis71_cliente,
                DATOS_FACTURA.analisis72_cliente as analisis72_cliente,
                DATOS_FACTURA.analisis73_cliente as analisis73_cliente,
                DATOS_FACTURA.analisis74_cliente as analisis74_cliente,
                DATOS_FACTURA.analisis75_cliente as analisis75_cliente,
                DATOS_FACTURA.analisis76_cliente as analisis76_cliente,
                DATOS_FACTURA.analisis77_cliente as analisis77_cliente,
                DATOS_FACTURA.analisis78_cliente as analisis78_cliente,
                DATOS_FACTURA.analisis79_cliente as analisis79_cliente,
                DATOS_FACTURA.analisis80_cliente as analisis80_cliente,
                DATOS_FACTURA.analisis81_cliente as analisis81_cliente,
                DATOS_FACTURA.analisis82_cliente as analisis82_cliente,
                DATOS_FACTURA.analisis83_cliente as analisis83_cliente,
                DATOS_FACTURA.analisis84_cliente as analisis84_cliente,
                DATOS_FACTURA.analisis85_cliente as analisis85_cliente,
                DATOS_FACTURA.analisis86_cliente as analisis86_cliente,
                DATOS_FACTURA.analisis87_cliente as analisis87_cliente,
                DATOS_FACTURA.analisis88_cliente as analisis88_cliente,
                DATOS_FACTURA.analisis89_cliente as analisis89_cliente,
                DATOS_FACTURA.analisis90_cliente as analisis90_cliente,
                DATOS_FACTURA.analisis91_cliente as analisis91_cliente,
                DATOS_FACTURA.analisis92_cliente as analisis92_cliente,
                DATOS_FACTURA.analisis93_cliente as analisis93_cliente,
                DATOS_FACTURA.analisis94_cliente as analisis94_cliente,
                DATOS_FACTURA.analisis95_cliente as analisis95_cliente,
                DATOS_FACTURA.analisis96_cliente as analisis96_cliente,
                DATOS_FACTURA.analisis97_cliente as analisis97_cliente,
                DATOS_FACTURA.analisis98_cliente as analisis98_cliente,
                DATOS_FACTURA.analisis99_cliente as analisis99_cliente,
                DATOS_FACTURA.analisis100_cliente as analisis100_cliente,





                /*   fin analisis de cliente */



                proveedores.nombre               AS nombre_proveedor, 
                proveedores.id_proveedor         AS id_proveedor, 
                notas_credito.id_sucursal, 
                titular.nombre      AS vendedor_nombre_tit, 
                titular.id_vendedor AS id_vendedor_tit, 
                proveedores.linea_aerea, 
                proveedores.codigo_bsp, 
                gvc_fecha_reservacion= 
                CASE 
                                WHEN( 
                                                                gds_general.fecha_reservacion = '1900-01-01' ) THEN '' 
                                ELSE CONVERT(char(12),CONVERT(datetime,gds_general.fecha_reservacion),105)
                                                                                         END,


                convert(char(12),convert(datetime,GDS_VUELOS.FECHA_SALIDA),105) as GVC_FECHA_SALIDA,
                convert(char(12),convert(datetime,GDS_VUELOS.FECHA_REGRESO),105) as GVC_FECHA_REGRESO,                                                      
                CONVERT(char(12),CONVERT(datetime,CONCECUTIVO_BOLETOS.fecha_sal),105) AS GVC_FECHA_SALIDA_CON,
                CONVERT(char(12),CONVERT(datetime,CONCECUTIVO_BOLETOS.fecha_reg),105) AS GVC_FECHA_REGRESO_CON,


                concecutivo_boletos.imp_cre, 
                gds_vuelos.tarifa_ofrecida, 
                gvc_tarifa_mon_base='-'+ CONVERT(varchar,isnull(round(detalle_nc.det_nc_tar_mn,2),0)), 
                gvc_iva='-'            + CONVERT(varchar, 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'IVA' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)), 
                gvc_tua='-'+ CONVERT(varchar, 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'TUA' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)), 
                gvc_otros_impuestos='-'+ CONVERT(varchar, 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'OTR' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)), 
                suma_impuestos='-'+ 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'IVA' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)+ 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'TUA' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)+ 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'OTR' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc), 
                gvc_total='-'+ CONVERT(varchar,CONVERT(varchar,detalle_nc.det_nc_tar_mn)+ 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'IVA' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)+ 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'TUA' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)+ 
                ( 
                       SELECT isnull(round(sum(impxservnc.cantidad),2),0) 
                       FROM   dba.catalogo_de_impuesto, 
                              dba.impxservnc 
                       WHERE  catalogo_de_impuesto.id_impuesto = impxservnc.id_impuesto 
                       AND    catalogo_de_impuesto.id_categoria = 'OTR' 
                       AND    impxservnc.id_det_nc = detalle_nc.id_det_nc)), 
                moneda.clave_sat AS moneda_vuelo, 
                (select top 1 

                   ID_FORMA_PAGO from DBA.FOR_PGO_FAC

                    where
                    FOR_PGO_FAC.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
                    FOR_PGO_FAC.ID_SERIE = DATOS_FACTURA.ID_SERIE and
                    FOR_PGO_FAC.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO) as ID_FORMA_PAGO_VUELO_ORIGINAL,

                  (select top 1 

                    CASE WHEN(ID_FORMA_PAGO = 'AX' or ID_FORMA_PAGO = 'VI' or ID_FORMA_PAGO = 'MC' or ID_FORMA_PAGO = 'CC' or ID_FORMA_PAGO = 'TP') 
                    THEN 'CC' ELSE 'CA' END as ID_FORMA_PAGO from DBA.FOR_PGO_FAC

                    where
                    FOR_PGO_FAC.ID_SUCURSAL = DATOS_FACTURA.ID_SUCURSAL and
                    FOR_PGO_FAC.ID_SERIE = DATOS_FACTURA.ID_SERIE and
                    FOR_PGO_FAC.FAC_NUMERO = DATOS_FACTURA.FAC_NUMERO) as ID_FORMA_PAGO_VUELO,

                for_pgo_fac.concepto AS payment_number_vuelo, 
                gvc_nom_pax_vuelo=CONVERT(varchar,detalle_nc.det_nc_nom_pas), 
                documento_vuelo=concecutivo_boletos.numero_bol,
                routing_vuelo =                 concecutivo_boletos.ruta, 
                gds_vuelos.id_origen            AS origin_vuelo, 
                gds_vuelos.id_destino_principal AS destination_vuelo, 
                gds_vuelos.id_clase_principal   AS class_vuelo, 
                gds_vuelos.tour_code            AS tour_code_vuelo, 
                gds_vuelos.numero_boleto        AS ticket_designer_vuelo, 
                pseudocity= 
                CASE 
                                WHEN ( 
                                                                ( 
                                                                                gds_general.pseudocity_boletea IS NULL
                                                                OR              gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 2) THEN 'D4C2'
                                WHEN ( 
                                                                ( 
                                                                                gds_general.pseudocity_boletea IS NULL
                                                                OR              gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 3) THEN 'D4B2'
                                WHEN ( 
                                                                ( 
                                                                                gds_general.pseudocity_boletea IS NULL
                                                                OR              gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 4) THEN 'X0O4'
                                WHEN ( 
                                                                ( 
                                                                                gds_general.pseudocity_boletea IS NULL
                                                                OR              gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 5) THEN 'P3FY'
                                WHEN ( 
                                                                ( 
                                                                                gds_general.pseudocity_boletea IS NULL
                                                                OR              gds_general.pseudocity_boletea = '' )
                                                AND             datos_factura.id_sucursal = 6) THEN 'DI13'
                                ELSE gds_general.pseudocity_boletea 
                                      END,  
                 departament = CASE WHEN (datos_factura.analisis12_cliente IS NULL OR datos_factura.analisis12_cliente = '') THEN
                 gds_general.analisis12_cliente ELSE datos_factura.analisis12_cliente END,
                brancharcnumber= 
                CASE(datos_factura.id_sucursal) 
                                WHEN '2' THEN '86511574' 
                                WHEN '3' THEN '86798003' 
                                WHEN '7' THEN '86798003' 
                                WHEN '4' THEN '86515984' 
                                WHEN '5' THEN '86502194' 
                                WHEN '6' THEN '86502194' 
                                ELSE '' 
                END,  
                CASE 
                                WHEN ( 
                                                                notas_credito.id_stat = 8 ) THEN 'C'
                                WHEN ( 
                                                                notas_credito.id_stat = 1 ) THEN 'R'
                END                AS transactiontype, 
                proveedores.c_pais AS vendorcountrycode,
                fac_numero_cxss=dba.detalle_factura.fac_numero_cxs,
                id_serie_cxss=dba.detalle_factura.id_serie_cxs

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

     
      left outer join
      DBA.DEPARTAMENTO on
      NOTAS_CREDITO.ID_DEPTO = DEPARTAMENTO.ID_DEPTO and
      NOTAS_CREDITO.ID_CENCOS = DEPARTAMENTO.ID_CENTRO_COSTO and
      NOTAS_CREDITO.ID_CLIENTE = DEPARTAMENTO.ID_CLIENTE

      LEFT OUTER JOIN datos_factura 
      on datos_factura.fac_numero = notas_credito.fac_numero and datos_factura.id_sucursal = notas_credito.id_sucursal and datos_factura.id_serie = notas_credito.id_serie_fac

      LEFT OUTER JOIN dba.gds_general 
      ON              dba.datos_factura.consecutivo = dba.gds_general.consecutivo 

      LEFT OUTER JOIN detalle_factura on detalle_factura.fac_numero = datos_factura.fac_numero and detalle_factura.id_sucursal = datos_factura.id_sucursal and detalle_factura.id_serie = datos_factura.id_serie

      LEFT OUTER JOIN detalle_factura AS detalle_factura_cxs on  
      detalle_factura_cxs.ID_SERIE_CXS = detalle_factura.ID_SERIE 
      AND detalle_factura_cxs.FAC_NUMERO_CXS = detalle_factura.FAC_NUMERO
      AND detalle_factura_cxs.numero_bol = detalle_factura.numero_bol_cxs

      LEFT OUTER JOIN dba.gds_vuelos 
      ON              dba.gds_vuelos.consecutivo = dba.gds_general.consecutivo 
      AND             dba.gds_vuelos.numero_boleto = dba.detalle_factura.numero_bol 

      LEFT OUTER JOIN dba.gds_vuelos as gds_vuelos_cxs
      ON gds_vuelos_cxs.numero_boleto = detalle_factura.numero_bol_cxs
      and gds_vuelos_cxs.fac_numero = detalle_factura.fac_numero_cxs

      /***********************forma de pago*******************************/

        LEFT OUTER JOIN dba.for_pgo_fac ON
        
        DATOS_FACTURA.ID_SUCURSAL = for_pgo_fac.id_sucursal AND
        
        DATOS_FACTURA.ID_SERIE = for_pgo_fac.id_serie AND

        DATOS_FACTURA.FAC_NUMERO  = for_pgo_fac.fac_numero AND

        datos_factura.tot_base =  for_pgo_fac.importe

        LEFT OUTER JOIN dba.forma_de_pago ON for_pgo_fac.id_forma_pago = forma_de_pago.id_forma_pago

      /******************************************************/

      where
      NOTAS_CREDITO.NC_NUMERO = DETALLE_NC.NC_NUMERO and
      NOTAS_CREDITO.ID_SERIE = DETALLE_NC.ID_SERIE and
      NOTAS_CREDITO.ID_SUCURSAL = DETALLE_NC.ID_SUCURSAL and
      /*NOTAS_CREDITO.ID_STAT = 1 and*/
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
    and ".$condicion_fecha." between '".$fecha1."' and '".$fecha2."' 
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

   public function get_hoteles_sin_interfaz($fac_numero){
    

        $query = $this->db->query("SELECT * from gds_hoteles where fac_numero = ".$fac_numero);

        
        $res = $query->result_array(); 
        return $res;


   }

   public function get_hoteles_num_bol($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$record_localizador,$consecutivo,$fecha1,$fecha2,$fac_numero,$TransactionType){
    

        if($tipo_funcion == "aut"){

                   $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);

                   $rango_fechas = explode("_", $rango_fechas);

                   $fecha1 = $rango_fechas[0];
                   $fecha2 = $rango_fechas[1];

         }
         
         if($fac_numero == ''){  // no se acopla a EGA MUESTTRA DUPLICADOS E INVOICE NUMBER SERIA EL UNICO DATO DIFERNTE PERO PAR EGA NO SE TOMA EN CUENTA

          $fac_num = '';
          

         }else{

          $fac_num = 'AND FAC_NUMERO = '.$fac_numero;

         }

        $query = $this->db->query("SELECT DISTINCT
                                    
                                    
                                    REPLACE(SUBSTRING(convert(char(12),gds_hoteles.fecha_entrada,105), 7, 10),'-','') as fecha_entrada_hotel,
                                    REPLACE(SUBSTRING(convert(char(12),gds_hoteles.fecha_salida,105), 7, 10),'-','') as fecha_salida_hotel,
                                    
                                    convert(char(12),gds_hoteles.fecha_entrada,105) as fecha_entrada_hotel_original,
                                    convert(char(12),gds_hoteles.fecha_salida,105) as fecha_salida_hotel_original,
                                    gds_hoteles.direccion as direccion,
                                    gds_hoteles.id_habitacion as class_hotel,
                                    gds_hoteles.id_ciudad as id_ciudad,
                                    gds_hoteles.id_ciudad as destination_hotel,
                                    gds_hoteles.id_ciudad as origin_hotel,
                                    gds_hoteles.id_ciudad as routing_hotel,
                                    gds_hoteles.CONFIRMACION AS documento_hotel,
                                    gds_hoteles.NOMBRE_PAX AS GVC_NOM_PAX_HOTEL,
                                    gds_hoteles.tarjeta as payment_number_hotel,
                                    gds_hoteles.forma_pago AS ID_FORMA_PAGO_HOTEL_ORIGINAL,
                                    gds_hoteles.costo_hab_noche,
                                    gds_hoteles.tarifa_neta,
                                    gds_hoteles.id_cadena,
                                    gds_hoteles.noches,
                                    gds_hoteles.impuesto1 as iva,
                                    gds_hoteles.impuesto2 as otros_imp,
                                    gds_hoteles.numero_hab as numero_habitaciones,

                                    CASE WHEN(gds_hoteles.forma_pago = 'AX' or gds_hoteles.forma_pago = 'VI' or gds_hoteles.forma_pago = 'MC' or gds_hoteles.forma_pago = 'CC' or gds_hoteles.forma_pago = 'TP') 
                                    THEN 'CC' ELSE 'CA' END as ID_FORMA_PAGO_HOTEL,


                                    gds_hoteles.id_moneda as moneda_hotel, 
                                    buy_in_advance=datediff(dd,GDS_GENERAL.fecha_recepcion,dba.gds_hoteles.fecha_entrada),
                                    gds_hoteles.propiedad,
                                    gds_hoteles.* 
                                    FROM gds_hoteles 
                                   INNER JOIN GDS_GENERAL ON GDS_GENERAL.CONSECUTIVO =  gds_hoteles.CONSECUTIVO                 
                                   where GDS_GENERAL.record_localizador = '$record_localizador' and cast(GDS_GENERAL.fecha_recepcion as date) between '$fecha1' and '$fecha2' AND gds_hoteles.consecutivo = '$consecutivo' /*and gds_hoteles.fac_numero is not null*/ ");

        
        $res = $query->result_array(); 
        return $res;


   }

   public function get_hoteles_iris($tipo_funcion,$fecha_ini_proceso,$id_intervalo,$fac_numero,$fecha1,$fecha2,$id_serie,$TransactionType){
    
        if($tipo_funcion == "aut"){

             $rango_fechas = $this->lib_intervalos_fechas->rengo_fecha($fecha_ini_proceso,$id_intervalo,$fecha1,$fecha2);
             $rango_fechas = explode("_", $rango_fechas);
             $fecha1 = $rango_fechas[0];
             $fecha2 = $rango_fechas[1];

        }

        $db_prueba = $this->load->database('coniris', TRUE);

        $res = $db_prueba->query("SELECT
                                  iris_reserv_serv.consecutivo_reserv,
                      
                                  REPLACE(SUBSTRING(convert(char(12),iris_cupones.fecha_ent,105), 7, 10),'-','') as fecha_entrada_hotel,  
                                  REPLACE(SUBSTRING(convert(char(12),iris_cupones.fecha_sal,105), 7, 10),'-','') as fecha_salida_hotel,

                                  convert(char(12),iris_cupones.fecha_ent,105)  as fecha_entrada_hotel_original,
                                  convert(char(12),iris_cupones.fecha_sal,105)  as fecha_salida_hotel_original,

                                  iris_reserv_serv.id_habitacion as class_hotel,
                                  iris_ciudades.desc_ciudad as destination_hotel,
                                  iris_ciudades.desc_ciudad as origin_hotel,
                                  iris_ciudades.desc_ciudad as routing_hotel,
                                  iris_reserv_serv.clave_confirmacion as documento_hotel,
                                  iris_reserv_serv.PASAJERO_APELLIDO + '/' + iris_reserv_serv.PASAJERO_NOM  AS GVC_NOM_PAX_HOTEL,
                                  iris_for_pgo_fac_serv.concepto as payment_number_hotel,

                                  iris_for_pgo_fac_serv.id_forma_pago AS ID_FORMA_PAGO_HOTEL_ORIGINAL,

                                  CASE WHEN(iris_for_pgo_fac_serv.id_forma_pago = 'AX' or iris_for_pgo_fac_serv.id_forma_pago = 'VI' or iris_for_pgo_fac_serv.id_forma_pago = 'MC' or iris_for_pgo_fac_serv.id_forma_pago = 'CC' or iris_for_pgo_fac_serv.id_forma_pago = 'TP') 
                                    THEN 'CC' ELSE 'CA' END as ID_FORMA_PAGO_HOTEL,

                                  iris_reserv_serv.costo_hab,
                                  iris_reserv_serv.tarifa_neta,

                                  iris_reserv_serv.id_moneda as moneda_hotel,
                                  iris_hoteles.direccion_ho,
                                  iris_ciudades.desc_ciudad,
                                  iris_hoteles.cp_ho,
                                  iris_hoteles.tel1_ho,
                                  iris_hoteles.nombre_ho as nombre_hotel,
                                  iris_ciudades.id_ciudad,
                                  iris_hoteles.id_cadena,
                                  iris_reserv_serv.impuesto_uno as iva,
                                  iris_reserv_serv.impuesto_dos as otros_imp,
                                  iris_reserv_serv.cantidad as numero_habitaciones,
                                  iris_hoteles.num_hab as num_cupon,
                                  iris_reserv_serv.clave_confirmacion,

                                  fecha_fac2=convert(char(12),iris_reserv_serv.fecha_fac,105),
                                  buy_in_advance=datediff(dd,iris_cupones.fecha_cupon,iris_cupones.fecha_ent),
                                  iris_cupones.noches,
                                  convert(char(12),iris_cupones.fecha_cupon,105) as fecha_cupon,
                                  iris_reserv_serv.*
                                  FROM iris_reserv_serv 
                                  inner join iris_cupones on iris_cupones.num_factura = iris_reserv_serv.fac_numero and iris_cupones.id_serie_fac = iris_reserv_serv.id_serie
                                  inner join iris_hoteles on iris_hoteles.id_hotel = iris_reserv_serv.id_hotel
                                  left join iris_ciudades on iris_ciudades.id_ciudad = iris_reserv_serv.id_ciudad
                                  left join iris_for_pgo_fac_serv on iris_for_pgo_fac_serv.consecutivo_reserv = iris_reserv_serv.consecutivo_reserv
                                  WHERE iris_reserv_serv.FAC_NUMERO = $fac_numero and iris_reserv_serv.id_clave <> 'CXS' and cast(iris_cupones.fecha_cupon as date) between '$fecha1' and '$fecha2' and iris_reserv_serv.id_serie='$id_serie'");

        $res = $res->result_array();

        $db_prueba->close();

        return $res;
     

   }

   public function get_autos_num_bol($consecutivo){

      $query = $this->db->query("select 

        gds_arrendadoras.arrendadora as nombre_arrendadora2,
        REPLACE(SUBSTRING(convert(char(12),fecha_recoge,105), 7, 10),'-','') as fecha_recoge_car,
        REPLACE(SUBSTRING(convert(char(12),fecha_entrega,105), 7, 10),'-','') as fecha_entrega_car, 
        convert(char(12),fecha_recoge,105)  as fecha_recoge_car_original,
        convert(char(12),fecha_entrega,105)  as fecha_entrega_car_original,
        tipo_auto  as class_car,
        id_ciudad_renta as destination_car,
        id_ciudad_renta as origin_car, 
        id_ciudad_renta as routing_car, 
        confirmacion as documento_car,
        nombre_pax as GVC_NOM_PAX_CAR, 
        tarjeta as payment_number_car, 
        forma_pago AS ID_FORMA_PAGO_AUTO_ORIGINAL,
        dias,
        id_ciudad_entrega,
        id_ciudad_recoge,
        CASE WHEN(forma_pago = 'AX' or forma_pago = 'VI' or forma_pago = 'MC' or forma_pago = 'CC' or forma_pago = 'TP') 
                                  THEN 'CC' ELSE 'CA' END as ID_FORMA_PAGO_AUTO,
        gds_autos.id_arrendadora,
        gds_autos.tarifa_diaria,
        gds_autos.tarifa_total as tarifa_neta,
        gds_autos.impuesto as iva,
        gds_autos.numero_autos,
        gds_autos.nombre_ciudad_renta,

        id_moneda as moneda_auto, 
        gds_autos.* 
        FROM gds_autos 
        left join gds_arrendadoras on gds_arrendadoras.id_arrendadora = gds_autos.id_arrendadora
        where consecutivo = '".$consecutivo."' order by fecha_entrega");

      
      $res = $query->result_array();
      return $res;


   }

   public function get_segmentos_ticket_number($ticket,$consecutivo){
      
      $query = $this->db->query("SELECT * FROM gds_vuelos_segmento where boleto = '$ticket' and consecutivo = '$consecutivo' ");
      $res = $query->result_array();
      return $res;

   }

   public function get_cxs_hoteles($fac_numero,$id_serie){

      $db_prueba = $this->load->database('coniris', TRUE);

      $query = $db_prueba->query("SELECT 

                                  convert(char(12),fecha_entrada,105) AS fecha_entrada,
                                  convert(char(12),fecha_salida,105) AS fecha_salida,
                                  consecutivo_reserv 

                                  FROM iris_reserv_serv 
                                  where fac_numero = $fac_numero and id_serie = '$id_serie'");

      $res = $query->result_array();
      
      $db_prueba->close();

      return $res;

   }

   public function delete_layouts_egencia_data_import_sp($id_us){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->query("delete from rpv_ega_data_import WHERE id_usuario = ".$id_us."");

   }

   public function set_consecutivo($consecutivo_ega){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $db_prueba->query("ALTER table rpv_ega_data_import AUTO_INCREMENT = ".$consecutivo_ega.";");

   }

   public function get_booking_id(){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query("SELECT id FROM  rpv_ega_data_import ORDER BY id desc limit 1");

      $res = $query->result_array();
      
      $db_prueba->close();

      return $res;

   }

  
}