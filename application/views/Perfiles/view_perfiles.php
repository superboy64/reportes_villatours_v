<button type="button" class="btn btn-default" onclick="btn_agregar_perfil();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar</button>
<button type="button" class="btn btn-default" onclick="btn_actualizar_perfil();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar</button>
<button type="button" class="btn btn-default" onclick="btn_eliminar_perfil();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar</button>

<div id="div_datagrid" style="height: 90%;">
       <table id="dg" pagination="true" singleSelect="true" style="height: 95%;"></table>
</div>

<script type="text/javascript">
  $("#div_select_search_perfil").show();
  $("#div_select_sucursal").show();
  $("#div_btn_guardar").show();


  $("#title").html('<?=$title?>');
  
  buscar(0);
  
  function formatField(value){
    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  }
  
  function get_perfiles(status){

    var sucursal = $("#slc_sucursal").val();
    var perfil = $("#slc_search_perfil").val();
    var parametros = {};

    parametros['perfil'] = perfil;
    
    //$.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_catalogo_perfiles", {parametros:parametros,status:status}, function(data){
                
      $('#dg').datagrid({
            url:"<?php echo base_url(); ?>index.php/Cnt_perfiles/get_catalogo_perfiles?sucursal="+sucursal+"&perfil="+perfil+"&status="+status,
            //data:data,
            remoteSort:false,
            columns:[[
                    {field:'id',title:'Id',formatter:formatField},
                    {field:'id_sucursal',title:'Id sucursal',formatter:formatField},
                    {field:'id_departamento',title:'Id',hidden:true,formatter:formatField,sortable:true},
                    {field:'nombre',title:'Nombre',formatter:formatField,sortable:true},
                    {field:'fecha_alta',title:'Fecha Alta',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',formatter:formatField},
                    {field:'action',formatter:formatField,title:'DKS',
                        formatter: function(value,row,index){
                           //var e = '<a href="javascript:void(0)" onclick="editrow(this)">Edit</a> ';
                           var d = '<a href="javascript:void(0)" onclick="get_html_dks_perfil('+row['id']+')">ver DKS</a>';
                           //return e + d;
                           return d;
                        }
                    },
                    {field:'action2',formatter:formatField,title:'Modulos',
                        formatter: function(value,row,index){
                           //var e = '<a href="javascript:void(0)" onclick="editrow(this)">Edit</a> ';
                           var d = '<a href="javascript:void(0)" onclick="get_html_modulos_perfil('+row['id']+')">ver Modulos</a>';
                           //return e + d;
                           return d;
                        }
                    }
                ]],onLoadSuccess:function(){
                    
                                              
                }
      }).datagrid('clientPaging');
     
    //});

  }

    function get_html_dks_perfil(id_perfil){

    rest_modal('');

    $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_html_dks_perfil", {id_perfil:''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_footer").hide();

            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">DKS</h1></center>");

            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            $('#dg_dks_perfil').datagrid({
                url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_catalogo_dks_perfil?id_perfil="+id_perfil,
                columns:[[
                    {field:'id_cliente',title:'DK',formatter:formatField}
                   
                ]],onLoadSuccess:function(){
                    
                                                 
                }
            });

      });

  }

  function get_html_modulos_perfil(id_perfil){

  rest_modal('');

  $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_html_modulos_perfil", {id_perfil:''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_footer").hide();

            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Modulos</h1></center>");

            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            $('#dg_dks_perfil').datagrid({
                url:"<?php echo base_url(); ?>index.php/Cnt_perfiles/get_catalogo_modulos_perfil_distinct?id_perfil="+id_perfil,
                columns:[[
                    {field:'id',title:'Id',formatter:formatField},
                    {field:'nombre',title:'Modulo',formatter:formatField}
                   
                ]],onLoadSuccess:function(){
                    
                                                 
                }
            });

      });

  }


  function btn_agregar_perfil(){
    
    rest_modal('mod_guardar_perfil();');

    $("#modal_content").css({"width": "80%"});

    $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_html_agregar_perfiles", {suggest: ''}, function(data){
            
          $("#modal_body").append(data);
          $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nuevo Perfil</h1></center>");
          $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            get_clientes_dk();
            get_modulos();

        });
  }

  function btn_actualizar_perfil(){

    var row_perfil = $('#dg').datagrid('getSelections');
    var id_suc = row_perfil[0]['id_sucursal'];
    var id_perfil = row_perfil[0]['id'];
    

    rest_modal('mod_guardar_perfil();');

    $("#modal_content").css({"width": "80%"});

    $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_html_actualizar_perfiles", {id_perfil: id_perfil,id_suc:id_suc}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar Perfil</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            get_clientes_dk();
            get_modulos();


        });
  }
  
  function btn_eliminar_perfil(){

      var row_perfil = $('#dg').datagrid('getSelections');
      var id_perfil = row_perfil[0]['id'];

      $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/eliminar_perfil", {id_perfil:id_perfil}, function(data){
            
            if(data == 1){
               $('#dg').datagrid('reload');
               swal('Perfil eliminado correctamente');
            }else{
               swal('Error al eliminar perfil');
            }

        });

    }

    function buscar(status = 1){

      get_perfiles(status);


    }
</script>