<script type="text/javascript">

$("#title").html('<?=$title?>');
  
  $("#div_txt_asunto").show();
  $("#div_txt_destinatario").show();
  $("#div_select_search_intervalo").show();
  $("#div_select_sucursal").show();
  $("#div_btn_guardar").show();
  $("#div_rango_fechas").show();
  $("#lbl_rango_fecha").text("Fecha envio");

    buscar(0);

    function formatField(value){

      return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    
    }

    function formatFieldIntervalo(value){

      var text = '';
      if(value == 1){
        text = 'diariamente';
      }else if(value == 2){
        text = 'semanalmente';
      }else if(value == 3){
        text = 'mensualmente';
      }else if(value == 4){
        text = 'quincenal';
      }else if(value == 5){
        text = 'diariamente(dia actual)';
      }
      return '<span style="font-size:10px; color:#010101;">'+text+'</span>';
    
    }

    function formatFieldStatus(value){

      var text = '';
      if(value == 1){
        text = 'ACTIVO';
      }else if(value == 0){
        text = 'INACTIVO';
      }
      return '<span style="font-size:10px; color:#010101;">'+text+'</span>';
    
    }

  function get_correos(status){

  var sucursal = $("#slc_sucursal").val();
  var asunto = $("#txt_asunto").val();
  var destinatario = $("#txt_destinatario").val();
  var fecha1 = $("#datapicker_fecha1").val();
  var fecha2 = $("#datapicker_fecha2").val();

  var parametros = {};


        $('#dg_con_correo').datagrid({
              url:"<?php echo base_url(); ?>index.php/Cnt_correos/get_correos_programados?sucursal="+sucursal+"&asunto="+asunto+"&destinatario="+destinatario+"&fecha1="+fecha1+"&fecha2="+fecha2+"&status="+status,
              remoteSort:false,
              columns:[[
                    
                    {field:'id',title:'Id',formatter:formatField,sortable:true},
                    {field:'id_sucursal',title:'id sucursal',formatter:formatField,sortable:true},
                    {field:'id_usuario',title:'id usuario',formatter:formatField,sortable:true},
                    {field:'asunto',title:'Asunto',formatter:formatField,sortable:true},
                    {field:'destinatario',title:'Destinatario',formatter:formatField,sortable:true},
                    {field:'copia',title:'Copia',formatter:formatField,sortable:true},
                    {field:'id_intervalo',title:'Intervalo',formatter:formatFieldIntervalo,sortable:true},                  
                    {field:'fecha_ini_proceso',title:'Fecha Inicio',formatter:formatField,sortable:true},
                    {field:'hora_ini_proceso',title:'Hora inicio',formatter:formatField},
                    {field:'fecha_alta',title:'Fecha alta',formatter:formatField},
                    {field:'status',title:'Status',formatter:formatFieldStatus},
                    {field:'mensaje',title:'Mensaje',formatter:formatField},
                    {field:'proximo_envio',title:'Fecha proximo envio',formatter:formatField},
                    {field:'fecha_ultimo_envio',title:'Fecha ultimo envio',formatter:formatField}
                    
                ]],onLoadSuccess:function(){

                     
                  
                },onBeforeSortColumn:function(sort,order){
                   
                  
                
                },onSortColumn:function(sort,order){
                   
                    
                
                }
        }).datagrid('clientPaging');
     

  }


  function btn_actualizar_correo(){

      rest_modal('mod_guardar_actualizacion();');

      $("#modal_content").css({"width": "50%"});

      var row_correo = $('#dg_con_correo').datagrid('getSelections');
      var id_corro_aut = row_correo[0]['id'];

      $.post("<?php echo base_url(); ?>index.php/Cnt_correos/get_html_actualizar_correo", {id_corro_aut:id_corro_aut}, function(data){
              
              $("#modal_body").append(data);
              $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar correo</h1></center>");
              $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

              $("#txt_destinatarios").val(row_correo[0]['destinatario']);
              $("#txt_concopia").val(row_correo[0]['copia']);
              $("#txt_asunto").val(row_correo[0]['asunto']);
              
              var fecha_ini_proceso = row_correo[0]['fecha_ini_proceso'];

              fecha_ini_proceso = fecha_ini_proceso.split('-');

              var ano = fecha_ini_proceso[0];
              var mes = fecha_ini_proceso[1];
              var dia = fecha_ini_proceso[2];

              fecha_ini_proceso = dia+'-'+mes+'-'+ano;

              $('#txt_fecha').val(fecha_ini_proceso);

              $("#txt_hora").val(row_correo[0]['hora_ini_proceso']);
            
              $("#txt_msn").jqteVal(row_correo[0]['mensaje']);

              $('#slc_sucursal_correo_act option[value="'+row_correo[0]['id_sucursal']+'"]').attr("selected", true);

              $('#slc_intervalo option[value="'+row_correo[0]['id_intervalo']+'"]').attr("selected", true);

              $("#id_correo_aut").val(row_correo[0]['id']);

              get_reportes_seleccionados(row_correo[0]['id']);


      });

    }


  function btn_eliminar_correo(){

    var row_correo = $('#dg_con_correo').datagrid('getSelections');
    
    var id_correo_aut = row_correo[0]['id'];
    var id_intervalo = row_correo[0]['id_intervalo'];
    
    $.post("<?php echo base_url(); ?>index.php/Cnt_correos/eliminar_correos_programados", {id_correo_aut:id_correo_aut,id_intervalo:id_intervalo}, function(data){

      if(data == 1){

        swal("Informacion actualizada correctamente");
        consulta_correos_programados('Correos programados');

      }else{

        swal("Ocurrio un error al actualizar la informacion");

      }
     

    });


  }

  function Reenviar_correo(){

    var row_correo = $('#dg_con_correo').datagrid('getSelections');

    var id_c_a = row_correo[0]['id'];


        $.post("<?php echo base_url(); ?>index.php/Cnt_correos/Reenviar_correo", {id_c_a:id_c_a}, function(data){
                
                if(data == 1){

                  swal("Correo reenviado exitosamente");
                  consulta_correos_log('Log envios');

                }else{

                  swal("Ocurrio un problema al reenviar el correo");

                }
              

          });


  }
  
  function buscar(status = 1){

    get_correos(status);


  }

</script>

