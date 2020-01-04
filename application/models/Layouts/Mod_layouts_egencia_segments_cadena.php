<?php
set_time_limit(0);
ini_set('post_max_size','1000M');
ini_set('memory_limit', '20000M');

class Mod_layouts_egencia_segments_cadena extends CI_Model {

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
   
   public function get_layouts_egencia_data_import_sp($id_us){

      $db_prueba = $this->load->database('conmysql', TRUE);

      $query = $db_prueba->query("select * from rpv_ega_data_import WHERE id_usuario = ".$id_us." and BookingType = 1");
     
      $array_aereo = $query->result_array();

      $array_nuevo_formato = [];
      $msn = '';
      foreach ($array_aereo as $key => $value) {
           
           $status_rango_fechas = 0;
           $status_fecha_inicial = 0;
           $status_fecha_final = 0;

                   
           $boleto_aereo = str_replace(".000000", "", $value['boleto_aereo']);
           $consecutivo_vuelo = str_replace(".000000", "", $value['consecutivo_vuelo']);
           $fac_numero = $value['InvoiceNumber'];

           $query2 = $this->db->query( "select 
              gds_vuelos_segmento.*,
              CONVERT(CHAR(12),gds_vuelos_segmento.fecha_salida,105) as fecha_salida_or,
              convert(varchar,gds_vuelos.id_la) as supplier,
              gds_vuelos.id_clase_principal as class_vuelo,


              fecha_salidax = CASE WHEN ((select top 1 CONVERT(CHAR(12),GDS_VUELOS_SEGMENTOX.fecha_salida,105) from GDS_VUELOS_SEGMENTO as GDS_VUELOS_SEGMENTOX WHERE GDS_VUELOS_SEGMENTOX.numero_segmento > GDS_VUELOS_SEGMENTO.numero_segmento and GDS_VUELOS_SEGMENTOX.BOLETO = GDS_VUELOS_SEGMENTO.BOLETO AND 
                GDS_VUELOS_SEGMENTOX.CONSECUTIVO = GDS_VUELOS_SEGMENTO.CONSECUTIVO
                  ) IS NULL)
              THEN

                CONVERT(CHAR(12),GDS_VUELOS_SEGMENTO.FECHA_SALIDA,105)

              ELSE


                /*(select top 1 CONVERT(CHAR(12),GDS_VUELOS_SEGMENTOX.fecha_salida,105) from GDS_VUELOS_SEGMENTO as GDS_VUELOS_SEGMENTOX WHERE GDS_VUELOS_SEGMENTOX.numero_segmento > GDS_VUELOS_SEGMENTO.numero_segmento and GDS_VUELOS_SEGMENTOX.BOLETO = GDS_VUELOS_SEGMENTO.BOLETO AND 
                GDS_VUELOS_SEGMENTOX.CONSECUTIVO = GDS_VUELOS_SEGMENTO.CONSECUTIVO
                  )*/

                convert(char(12),(case gds_vuelos_segmento.cambio_fecha_llegada 
                  when '0' then gds_vuelos_segmento.fecha_salida
                when '1' then dateadd(day,1,gds_vuelos_segmento.fecha_salida)
                when '2' then dateadd(day,2,gds_vuelos_segmento.fecha_salida)
                when '3' then dateadd(day,3,gds_vuelos_segmento.fecha_salida)
                when '4' then dateadd(day,-1,gds_vuelos_segmento.fecha_salida)
                when '5' then dateadd(day,-2,gds_vuelos_segmento.fecha_salida)
                else gds_vuelos_segmento.fecha_salida
                end),105)


              END

              from dba.detalle_factura
        
              left outer join datos_factura on  datos_factura.id_serie =  detalle_factura.id_serie and  datos_factura.id_sucursal =  detalle_factura.id_sucursal and  datos_factura.fac_numero = detalle_factura.fac_numero
              
              left outer join
                dba.concecutivo_boletos on dba.detalle_factura.id_boleto = dba.concecutivo_boletos.id_boleto 

              left outer join
                    dba.gds_vuelos on dba.gds_vuelos.numero_boleto = dba.detalle_factura.numero_bol and gds_vuelos.consecutivo = datos_factura.consecutivo
              
              left join gds_vuelos_segmento on gds_vuelos_segmento.boleto = concecutivo_boletos.numero_bol and gds_vuelos_segmento.consecutivo = gds_vuelos.consecutivo

              where concecutivo_boletos.numero_bol = '".$boleto_aereo."' and gds_vuelos.consecutivo = '".$consecutivo_vuelo."' ");

           
              $array_segmento = $query2->result_array();

            $cont = 0;
            foreach ($array_segmento as $key2 => $value2) {
            $cont++;

              if($cont == 1){

                if(str_replace("-", "", $value2['fecha_salida_or']) == str_replace("/", "", $value['StartDate'])){

                  $status_fecha_inicial = 1;

                }

              }

              if(count($array_segmento) == $cont){

                  if(str_replace("-", "", $value2['fecha_salidax']) == str_replace("/", "", $value['EndDate'])){

                    $status_fecha_final = 1;

                  }

              }

              if(str_replace("-", "", $value2['fecha_salida_or']) >=  str_replace("/", "", $value['StartDate']) && str_replace("-", "", $value2['fecha_salidax']) <=  str_replace("/", "", $value['EndDate'])){

                 $status_rango_fechas = 1;


              }

              $db_prueba->query("insert into rpv_ega_data_import_consecutivo_segmento(id_usuario, fecha_alta)
                                values(".$id_us.",now()) ");

              $consecutivo_actual = $db_prueba->query("select * from rpv_ega_data_import_consecutivo_segmento
                                where id_usuario = ".$id_us." order by id desc limit 1 ");
              $consecutivo_actual = $consecutivo_actual->result_array();
              $consecutivo_actual = $consecutivo_actual[0]['id'];


              $dat['SegmentID'] =       $consecutivo_actual; //consecutivo + record ; //consecutivo + record 
              $dat['Link_Key'] =        $value['id'].$value['RecordLocator']; //consecutivo + record 
              $dat['BookingID'] =       $value['id'];
              $dat['DocumentNumber'] =  $value['DocumentNumber'];    //documento=dba.detalle_factura.fac_numero,
              $dat['Leg'] =             $value2['numero_segmento']; //gds_vuelos_segmento.numero_segmento,
              $dat['AirlineCode'] =     $value2['supplier'];                            //convert(varchar,dba.gds_vuelos.id_la),
              $dat['DepartCityCode'] =  $value2['id_ciudad_salida'];   //gds_vuelos_segmento.id_ciudad_salida,
              $dat['DepartDate'] =      str_replace("-", "/", $value2['fecha_salida_or']);  //convert(char(12),gds_vuelos.fecha_salida,105) as fecha_salida,
              $dat['DepartTime'] =      $value2['hora_salida']; //gds_vuelos_segmento.hora_salida,
              $dat['FlightNumber'] =    $value2['numero_vuelo']; //gds_vuelos_segmento.numero_vuelo,
              $dat['ArriveCityCode'] =  $value2['id_ciudad_destino']; //gds_vuelos_segmento.id_ciudad_destino,
              $dat['ArriveDate'] =      str_replace("-", "/", $value2['fecha_salidax']); //convert(char(12),gds_vuelos.fecha_regreso,105) as fecha_regreso,
              $dat['ArriveTime'] =      $value2['hora_llegada']; //gds_vuelos_segmento.hora_llegada,
              $dat['ConnectionCode'] =  $value2['coneccion'];//gds_vuelos_segmento.coneccion,
              $dat['FareBasis'] =       $value2['fare_basis']; //gds_vuelos_segmento.fare_basis,
              $dat['SegmentFare'] =     number_format((float)$value2['tarifa_segmento'], 2, '.', '');//gds_vuelos_segmento.tarifa_segmento,
              $dat['Class'] =           $value2['class_vuelo'];//gds_vuelos.id_clase_principal as class_vuelo,
              $dat['TicketDesignator'] = '';//vacio
              $dat['Mileage'] =         $value2['millas'];//gds_vuelos_segmento.millas,
              $dat['SeatAssignment'] =  '';//vacio
              $dat['EquipmentType'] =   '';  //vacio

              array_push($array_nuevo_formato, $dat);

              }

              if($status_fecha_inicial != 1 || $status_fecha_final != 1 || $status_rango_fechas != 1){

                $msn = $msn .'Error: Rango de fechas no valido Boking/segment para el BookingID-'.$value['id'].'<br>';

              }
              
           }


      //obtenemos aquellos boletos que se encuentran en la tabla consecutivo boletos pero no existen en las tablas gds-vuelos y gds_vuelos_segmento

      $query4 = $db_prueba->query("select * from rpv_ega_data_import WHERE id_usuario = ".$id_us." and BookingType = 1 and (consecutivo_vuelo = '' or consecutivo_vuelo is null)");
     
      $array_aereo_null = $query4->result_array();

      foreach ($array_aereo_null as $key => $value) {
              
              $db_prueba->query("insert into rpv_ega_data_import_consecutivo_segmento(id_usuario, fecha_alta)
                                values(".$id_us.",now()) ");

              $consecutivo_actual = $db_prueba->query("select * from rpv_ega_data_import_consecutivo_segmento
                                where id_usuario = ".$id_us." order by id desc limit 1 ");
              $consecutivo_actual = $consecutivo_actual->result_array();
              $consecutivo_actual = $consecutivo_actual[0]['id'];

              $dat['SegmentID'] =       $consecutivo_actual; //consecutivo + record ; //consecutivo + record 
              $dat['Link_Key'] =        $value['id'].$value['RecordLocator']; //consecutivo + record 
              $dat['BookingID'] =       $value['id'];
              $dat['DocumentNumber'] =  '';
              $dat['Leg'] =             '';
              $dat['AirlineCode'] =     '';                       
              $dat['DepartCityCode'] =  '';
              $dat['DepartDate'] =      '';
              $dat['DepartTime'] =      '';
              $dat['FlightNumber'] =    '';
              $dat['ArriveCityCode'] =  '';
              $dat['ArriveDate'] =      '';
              $dat['ArriveTime'] =      '';
              $dat['ConnectionCode'] =  '';
              $dat['FareBasis'] =       '';
              $dat['SegmentFare'] =     '';
              $dat['Class'] =           '';
              $dat['TicketDesignator'] = '';
              $dat['Mileage'] =         '';
              $dat['SeatAssignment'] =  '';
              $dat['EquipmentType'] =   '';

              array_push($array_nuevo_formato, $dat);


      }

      $db_prueba->query("delete from rpv_ega_data_import_consecutivo_segmento
                          where id_usuario = ".$id_us);
      
      $data = [];
      $data['array_nuevo_formato'] = $array_nuevo_formato;
      $data['msn'] = $msn;
      return $data;

   }

  
}