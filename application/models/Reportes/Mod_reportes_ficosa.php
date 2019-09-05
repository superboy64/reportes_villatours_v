<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');

class Mod_reportes_ficosa extends CI_Model {

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
   
   public function get_reportes_ficosa($parametros){

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
    buy_in_advance=datediff(dd,dba.concecutivo_boletos.fecha_emi,dba.gds_vuelos.fecha_salida),record_localizador=convert(varchar,dba.gds_general.record_localizador), 
    GVC_ID_CENTRO_COSTO=DATOS_FACTURA.ID_CENTRO_COSTO,
    DATOS_FACTURA.analisis14_cliente as analisis14_cliente
    from

    dba.detalle_factura left outer join
    dba.concecutivo_boletos on dba.detalle_factura.id_boleto = dba.concecutivo_boletos.id_boleto,
    dba.datos_factura left outer join
    dba.gds_general on dba.datos_factura.consecutivo = dba.gds_general.consecutivo,
    dba.gds_general left outer join
    dba.gds_vuelos on dba.gds_vuelos.consecutivo = dba.gds_general.consecutivo and dba.gds_vuelos.numero_boleto = dba.detalle_factura.numero_bol,
    DBA.TIPO_SERVICIO,
    DBA.CLIENTES,
    dba.prov_tpo_serv 
    where

    (dba.datos_factura.fac_numero = dba.detalle_factura.fac_numero) and
    (dba.datos_factura.id_serie = dba.detalle_factura.id_serie) and
    (dba.datos_factura.id_sucursal = dba.detalle_factura.id_sucursal) and
    (dba.datos_factura.id_cliente = dba.clientes.id_cliente) and
    (dba.datos_factura.id_stat = 1) and
    (dba.detalle_factura.prov_tpo_serv = dba.prov_tpo_serv.prov_tpo_serv) and
    DBA.TIPO_SERVICIO.ID_TIPO_SERVICIO = DBA.PROV_TPO_SERV.ID_SERVICIO and dba.detalle_factura.id_stat = 1";

    if($id_intervalo == '5'){

      $condicion_fecha = 'datos_factura.fecha_folio';

    }else{

      $condicion_fecha = 'datos_factura.FECHA';

    }

    $select = $select . "
    and ".$condicion_fecha." between '".$fecha1."' and '".$fecha2."' 
    and TIPO_SERVICIO.id_tipo_servicio <> 'CS' and detalle_factura.emd <> 'S' ";
    
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


  select tpo_cambio='',combustible='',dba.gds_general.id_serie,emd='',GVC_NOM_CLI='',GVC_ID_CORPORATIVO='',
    gds_general.consecutivo,name=gds_general.cl_nombre,nexp=cli.id_cliente,destination='',fecha_salida='',documento='',solicitor=df.solicito,type_of_service='',supplier='',codigo_producto='',final_user=convert(varchar,gds_general.nombre_pax),ticket_number='',typo_of_ticket='',fecha_emi=convert(char(12),gds_general.fecha_reservacion,105),city='_____campo_vacio_____',country='',total_emission='',total_millas='',total_Itinerary1='',origin1='',destina1='',total_Itinerary2='',origin2='',destina2='',total_Itinerary3='',origin3='',destina3='',total_Itinerary4='',origin4='',destina4='',total_Itinerary5='',origin5='',destina5='',total_Itinerary6='',origin6='',destina6='',total_Itinerary7='',origin7='',destina7='',total_Itinerary8='',origin8='',destina8='',total_Itinerary9='',origin9='',destina9='',total_Itinerary10='',origin10='',destina10='',hotel1='',fecha_entrada1='',fecha_salida1='',noches1='',break_fast1='',numero_hab1='',id_habitacion1='',id_ciudad1='',country1='',hotel2='',fecha_entrada2='',fecha_salida2='',noches2='',break_fast2='',numero_hab2='',id_habitacion2='',id_ciudad2='',country2='',hotel3='',fecha_entrada3='',fecha_salida3='',noches3='',break_fast3='',numero_hab3='',id_habitacion3='',id_ciudad3='',country3='',hotel4='',fecha_entrada4='',fecha_salida4='',noches4='',break_fast4='',numero_hab4='',id_habitacion4='',id_ciudad4='',country4='',hotel5='',fecha_entrada5='',fecha_salida5='',noches5='',break_fast5='',numero_hab5='',id_habitacion5='',id_ciudad5='',country5='',hotel6='',fecha_entrada6='',fecha_salida6='',noches6='',break_fast6='',numero_hab6='',id_habitacion6='',id_ciudad6='',country6='',hotel7='',fecha_entrada7='',fecha_salida7='',noches7='',break_fast7='',numero_hab7='',id_habitacion7='',id_ciudad7='',country7='',hotel8='',fecha_entrada8='',fecha_salida8='',noches8='',break_fast8='',numero_hab8='',id_habitacion8='',id_ciudad8='',country8='',hotel9='',fecha_entrada9='',fecha_salida9='',noches9='',break_fast9='',numero_hab9='',id_habitacion9='',id_ciudad9='',country9='',hotel10='',fecha_entrada10='',fecha_salida10='',noches10='',break_fast10='',numero_hab10='',id_habitacion10='',id_ciudad10='',country10='',Car_class1='',Delivery_Date1='',Nr_days1='',Place_delivery1='',Place_delivery_back1='',Departure_date1='',Car_class2='',Delivery_Date2='',Nr_days2='',Place_delivery2='',Place_delivery_back2='',Departure_date2='',Car_class3='',Delivery_Date3='',Nr_days3='',Place_delivery3='',Place_delivery_back3='',Departure_date3='',Car_class4='',Delivery_Date4='',Nr_days4='',Place_delivery4='',Place_delivery_back4='',Departure_date4='',Car_class5='',Delivery_Date5='',Nr_days5='',Place_delivery5='',Place_delivery_back5='',Departure_date5='',Car_class6='',Delivery_Date6='',Nr_days6='',Place_delivery6='',Place_delivery_back6='',Departure_date6='',Car_class7='',Delivery_Date7='',Nr_days7='',Place_delivery7='',Place_delivery_back7='',Departure_date7='',Car_class8='',Delivery_Date8='',Nr_days8='',Place_delivery8='',Place_delivery_back8='',Departure_date8='',Car_class9='',Delivery_Date9='',Nr_days9='',Place_delivery9='',Place_delivery_back9='',Departure_date9='',Car_class10='',Delivery_Date10='',Nr_days10='',Place_delivery10='',Place_delivery_back10='',Departure_date10='',buy_in_advance='',record_localizador=convert(varchar,dba.gds_general.record_localizador),GVC_ID_CENTRO_COSTO=dba.gds_general.id_centro_costo,analisis14_cliente=dba.gds_general.analisis14_cliente

    from

    CLIENTES AS cli

    left outer join
    gds_general ON gds_general.id_cliente = cli.id_cliente

    left outer join
    dba.datos_factura as df on df.consecutivo = gds_general.consecutivo 

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

   public function get_hoteles_num_bol($record_localizador,$consecutivo,$fecha1,$fecha2){
      /*$query = $this->db->query("SELECT DISTINCT buy_in_advance=datediff(dd,GDS_GENERAL.fecha_recepcion,dba.gds_hoteles.fecha_entrada),gds_hoteles.* FROM gds_hoteles 
                                 INNER JOIN GDS_GENERAL ON GDS_GENERAL.CONSECUTIVO =  gds_hoteles.CONSECUTIVO                 
                                 where gds_hoteles.consecutivo = '$consecutivo' and cast(GDS_GENERAL.fecha_recepcion as date) between '$fecha1' and '$fecha2' ");*/

      $query = $this->db->query("SELECT DISTINCT buy_in_advance=datediff(dd,GDS_GENERAL.fecha_recepcion,dba.gds_hoteles.fecha_entrada),gds_hoteles.* FROM gds_hoteles 
                                 INNER JOIN GDS_GENERAL ON GDS_GENERAL.CONSECUTIVO =  gds_hoteles.CONSECUTIVO                 
                                 where GDS_GENERAL.record_localizador = '$record_localizador' and cast(GDS_GENERAL.fecha_recepcion as date) between '$fecha1' and '$fecha2' ");
      
      $res = $query->result_array(); 
      return $res;

   }

   public function get_hoteles_iris($fac_numero,$fecha1,$fecha2,$id_serie){

      $db_prueba = $this->load->database('coniris', TRUE);
      $res = $db_prueba->query("SELECT 
                                fecha_fac2=convert(char(12),iris_reserv_serv.fecha_fac,105),buy_in_advance=datediff(dd,iris_cupones.fecha_cupon,iris_cupones.fecha_ent),iris_cupones.noches,iris_cupones.fecha_cupon,iris_reserv_serv.*
                                FROM iris_reserv_serv 
                                inner join iris_cupones on iris_cupones.num_factura = iris_reserv_serv.fac_numero and iris_cupones.id_serie_fac = iris_reserv_serv.id_serie
                                WHERE iris_reserv_serv.FAC_NUMERO = $fac_numero and iris_reserv_serv.id_clave <> 'CXS' and cast(iris_cupones.fecha_cupon as date) between '$fecha1' and '$fecha2' and iris_reserv_serv.id_serie='$id_serie'");
     
      $res = $res->result_array();
      return $res;

   }

   public function get_autos_num_bol($consecutivo){
      $query = $this->db->query("SELECT * FROM gds_autos where consecutivo = '".$consecutivo."' order by fecha_entrega");
      $res = $query->result_array();
      return $res;

   }

   public function get_segmentos_ticket_number($ticket,$consecutivo){
      
      $query = $this->db->query("SELECT * FROM gds_vuelos_segmento where boleto = '$ticket' and consecutivo = '$consecutivo' ");
      $res = $query->result_array();
      return $res;

   }
  
}