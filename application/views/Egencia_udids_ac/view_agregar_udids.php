<div class="row">

      <div class="col-md-12">
      <br>

        <div class="row">
        
              <div class="col-md-5">

                <div class="panel panel-primary">

                  <div class="panel-heading">
                    <h1 class="panel-title" style="color: #fff;">Clientes(DK)</h1>
                   
                  </div>
                  
                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                    <table id="dg_clientes" class="easyui-datagrid" style="height: 191px;"></table>
                  </div>
                
                </div>

              </div>

              <div class="col-md-1">

                 <center>

                   <button type="button" class="btn btn-default" style="margin-top: 86px;" onclick="seleccionar_cliente();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

                   </button>

                   <button type="button" class="btn btn-default" onclick="deseleccionar_cliente();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

                   </button>


                 </center>
                 

              </div>

              <div class="col-md-5">

                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h1 class="panel-title" style="color: #fff;">Clientes seleccionadas</h1>
                   
                  </div>
                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                    
                      <table id="dg_clientes_seleccionadas" style="height: 191px;"></table>
                   
                  </div>
                </div>

              </div> 

             <div class="col-md-12"><br></div>

             <div class="col-md-5">

                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h1 class="panel-title" style="color: #fff;">Analisis de cliente</h1>
                   
                  </div>
                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                    
                      <table id="dg_analisis_cliente" style="height: 191px;"></table>
                   
                  </div>
                </div>

              </div>
              <div class="col-md-1">

                 <center>

                   <button type="button" class="btn btn-default" style="margin-top: 86px;" onclick="seleccionar_analisis();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

                   </button>

                   <button type="button" class="btn btn-default" onclick="deseleccionar_analisis();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

                   </button>


                 </center>
                 

              </div> 
              <div class="col-md-5">

                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h1 class="panel-title" style="color: #fff;">Analisis de cliente seleccionados</h1>
                   
                  </div>
                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                    
                      <table id="dg_analisis_cliente_seleccionados" style="height: 191px;"></table>
                   
                  </div>
                </div>

              </div>

              <div class="col-md-6">

                <label>Group Id</label>
                <input type="text" class="form-control" id="txt_group_id_alta" style="width: 200px;">
        

              </div>

        </div>



      </div>


   </div>


<script type="text/javascript">

  row_clientes_all =  [];

  function formatField(value){

    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  
  }

  /*aqui va el motor de tablas dinamicas*/

  /**********************************************************************************************/

  function get_clientes_dk(){

    $('#dg_clientes').datagrid({
              url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk",
              onCheckAll: function(){
                var state = $(this).data('datagrid');
                state.selectedRows = $.extend(true,[],state.data.firstRows);
                state.checkedRows = $.extend(true,[],state.data.firstRows);
              },
              onUncheckAll: function(){
                var state = $(this).data('datagrid');
                state.selectedRows = [];
                state.checkedRows = [];
              },
              remoteSort:false,
              columns:[[
                  {field:'ck',title:'Id',checkbox:"true",sortable:true,width:50},
                  {field:'id_cliente',title:'Id',formatter:formatField,sortable:true,width:50},
                  {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true,width:100},
                  {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true,width:100},
                 
              ]],onLoadSuccess:function(){
                  
                $('#dg_clientes_seleccionadas').datagrid({ //inicializa la tabla de seleccionados
                  columns: [[
                    {field:'id_cliente',title:'Id',formatter:formatField,sortable:true,width:50},
                    {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true,width:100},
                    {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true,width:100},
                  ]]
                });


              }
          });

  }

    
    function seleccionar_cliente(){

      //var rows_reportes = $('#dg_reportes').datagrid('getSelections');
      var rows_clientes = $('#dg_clientes').datagrid('getSelections');
      var rows_clientes_selec = $('#dg_clientes_seleccionadas').datagrid('getRows');
            //var rows_clientes_selec = $('#dg_reportes_seleccionados').datagrid('getRows');

            var rows_clientes_all = $('#dg_clientes').datagrid('getRows');

            if(rows_clientes_selec.length > 0){

              $.each(rows_clientes, function( index, value ) {
 
                  $('#dg_clientes_seleccionadas').datagrid('appendRow',{ id_cliente: value['id_cliente'], nombre_cliente: value['nombre_cliente'], id_corporativo:value['id_corporativo'] });
                  
                
              });

              for (i = 0; i < rows_clientes_all.length; i++) {


                  $.each(rows_clientes, function( index2, value2 ) {

                    if(rows_clientes_all[i]['id_cliente'] == value2['id_cliente']){

                      $('#dg_clientes').datagrid('deleteRow', i);

                    }
                    
                
                  });


              }

            }else{


                $.each(rows_clientes, function( index, value ) {
                    

                    $('#dg_clientes_seleccionadas').datagrid('appendRow',{ id_cliente: value['id_cliente'], nombre_cliente: value['nombre_cliente'], id_corporativo:value['id_corporativo'] });
                    
                  
                });

               
               for (i = 0; i < rows_clientes_all.length; i++) {

                  $.each(rows_clientes, function( index2, value2 ) {

                    if(rows_clientes_all[i]['id_cliente'] == value2['id_cliente']){

                        $('#dg_clientes').datagrid('deleteRow', i);

                       


                    }
                    
                
                  }); 
                  
               }

              



            }

    }

    function deseleccionar_cliente(){

      var rows_clientes_selec = $('#dg_clientes_seleccionadas').datagrid('getSelections');
      var rows_clientes_selec_all = $('#dg_clientes_seleccionadas').datagrid('getRows');
     
      var $new_array_row_clientes_all = {};

       for (i = 0; i < rows_clientes_selec_all.length; i++) {

          $.each(rows_clientes_selec, function( index2, value2 ) {

            if(rows_clientes_selec_all[i]['id_cliente'] == value2['id_cliente']){

                $('#dg_clientes_seleccionadas').datagrid('deleteRow', i);

                $.each(row_clientes_all, function( index3, value3 ) {

                   if(index3 != 'rep_'+value2['id_cliente'] ){

                      $new_array_row_clientes_all[index3] = value3;

                    
                   }

                });


            }
            
        
          }); 
          
       }

       row_clientes_all = $new_array_row_clientes_all;

       reportes_not_in();
  

    }

    function reportes_not_in(){

      var rows_clientes_selec = $('#dg_clientes_seleccionadas').datagrid('getRows');

            var ids_selec = '';
            
            $.each(rows_clientes_selec, function( index, value ) {
    
                ids_selec = ids_selec + value['id_cliente'] + ',';
               
            });

            $.post("<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_not_in", {ids_selec: ids_selec}, function(data){
          
                data = JSON.parse(data);
                $('#dg_clientes').datagrid({
                  url:"#",
                  data:data,
                  onCheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = $.extend(true,[],state.data.firstRows);
                    state.checkedRows = $.extend(true,[],state.data.firstRows);
                  },
                  onUncheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = [];
                    state.checkedRows = [];
                  },
                  remoteSort:false,
                  columns: [[
                    {field:'ck',title:'Id',checkbox:"true",sortable:true,width:50},
                    {field:'id_cliente',title:'Id',formatter:formatField,sortable:true,width:50},
                    {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true,width:100},
                    {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true,width:100}
                  ]],onLoadSuccess:function(){
                  
                  console.log("problema solucionado 2");
                      
                }
              });
               
            });


    }

  /**********************************************************************************************/

    /*aqui va el motor de tablas dinamicas para analisis de cliente*/

  /**********************************************************************************************/

    function get_analisis_cliente(){

      $('#dg_analisis_cliente').datagrid({
                url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_catalogo_analisis_clientes",
                onCheckAll: function(){
                  var state = $(this).data('datagrid');
                  state.selectedRows = $.extend(true,[],state.data.firstRows);
                  state.checkedRows = $.extend(true,[],state.data.firstRows);
                },
                onUncheckAll: function(){
                  var state = $(this).data('datagrid');
                  state.selectedRows = [];
                  state.checkedRows = [];
                },
                remoteSort:false,
                columns:[[
                    {field:'ck',title:'Id',checkbox:"true",sortable:true,width:50},
                    {field:'nombre',title:'analisis_cliente',formatter:formatField,sortable:true,width:200},
                   
                ]],onLoadSuccess:function(){
                    
                  $('#dg_analisis_cliente_seleccionados').datagrid({ //inicializa la tabla de seleccionados
                    columns: [[
                      {field:'ck',title:'Id',checkbox:"true",sortable:true,width:50},
                      {field:'nombre',title:'analisis_cliente',formatter:formatField,sortable:true,width:200},
                    ]]
                  });


                }

            });

    }

 
    
    function seleccionar_analisis(){

      //var rows_reportes = $('#dg_reportes').datagrid('getSelections');
      var rows_analisis = $('#dg_analisis_cliente').datagrid('getSelections');
      var rows_analisis_selec = $('#dg_analisis_cliente_seleccionados').datagrid('getRows');
            //var rows_clientes_selec = $('#dg_reportes_seleccionados').datagrid('getRows');

            var rows_analisis_all = $('#dg_analisis_cliente').datagrid('getRows');

            if(rows_analisis_selec.length >= 0){

              $.each(rows_analisis, function( index, value ) {
             
                  $('#dg_analisis_cliente_seleccionados').datagrid('appendRow',{ id: value['id'], nombre: value['nombre']});
                
              });

              for (i = 0; i < rows_analisis_all.length; i++) {


                  $.each(rows_analisis, function( index2, value2 ) {

                    if(rows_analisis_all[i]['id'] == value2['id']){

                      $('#dg_analisis_cliente').datagrid('deleteRow', i);

                    }
                    
                
                  });


              }

            }else{


                $.each(rows_analisis, function( index, value ) {
                    

                    $('#dg_analisis_cliente_seleccionados').datagrid('appendRow',{ id_analisis: value['id'], nombre_analisis: value['nombre']});
                    
                  
                });

               
               for (i = 0; i < rows_analisis_all.length; i++) {

                  $.each(rows_analisis, function( index2, value2 ) {

                    if(rows_analisis_all[i]['id'] == value2['id']){

                        $('#dg_analisis_cliente').datagrid('deleteRow', i);

                       


                    }
                    
                
                  }); 
                  
               }

            }

    }

    function deseleccionar_analisis(){

      var rows_analisis_selec = $('#dg_analisis_cliente_seleccionados').datagrid('getSelections');
      var rows_analisis_selec_all = $('#dg_analisis_cliente_seleccionados').datagrid('getRows');
     
      var $new_array_row_analisis_cliente_all = {};

       for (i = 0; i < rows_analisis_selec_all.length; i++) {

          $.each(rows_analisis_selec, function( index2, value2 ) {

            if(rows_analisis_selec_all[i]['id'] == value2['id']){

                $('#dg_analisis_cliente_seleccionados').datagrid('deleteRow', i);

                $.each(row_clientes_all, function( index3, value3 ) {

                   if(index3 != 'rep_'+value2['id'] ){

                      $new_array_row_analisis_cliente_all[index3] = value3;

                    
                   }

                });


            }
            
        
          }); 
          
       }

       row_clientes_all = $new_array_row_analisis_cliente_all;

       reportes_not_in_analisis();
  

    }

    function reportes_not_in_analisis(){

      var rows_analisis_selec = $('#dg_analisis_cliente_seleccionados').datagrid('getRows');

            var ids_selec = '';
            
            $.each(rows_analisis_selec, function( index, value ) {
    
                ids_selec = ids_selec + value['id'] + ',';
               
            });

            $.post("<?php echo base_url(); ?>index.php/Cnt_clientes/get_analisis_cliente_dk_not_in", {ids_selec: ids_selec}, function(data){
          
                data = JSON.parse(data);
                $('#dg_analisis_cliente').datagrid({
                  url:"#",
                  data:data,
                  onCheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = $.extend(true,[],state.data.firstRows);
                    state.checkedRows = $.extend(true,[],state.data.firstRows);
                  },
                  onUncheckAll: function(){
                    var state = $(this).data('datagrid');
                    state.selectedRows = [];
                    state.checkedRows = [];
                  },
                  remoteSort:false,
                  columns: [[
                    {field:'ck',title:'Id',checkbox:"true",sortable:true,width:50},
                    {field:'nombre',title:'analisis_cliente',formatter:formatField,sortable:true,width:200},
                  ]],onLoadSuccess:function(){
                  
                  console.log("problema solucionado 2");
                      
                }
              });
               
            });


    }

  /**********************************************************************************************/

function mod_guardar_analisis_cliente() {
   
   var row_clientes_sele = $('#dg_clientes_seleccionadas').datagrid('getRows');
   var row_analisis_sele = $('#dg_analisis_cliente_seleccionados').datagrid('getRows');
   var group_id = $("#txt_group_id_alta").val();

   var arr_cli = [];
    
   $.each( row_clientes_sele, function( key, value ) {
      
      arr_cli.push(value['id_cliente']);

   });

   var arr_analis = [];
    
   $.each( row_analisis_sele, function( key, value ) {
      
      arr_analis.push(value['id']);

   });

   arr_cli = JSON.stringify(arr_cli);
   arr_analis = JSON.stringify(arr_analis);

   $.post("<?php echo base_url(); ?>index.php/Cnt_egencia_udids_ac/guardar_analisis_cliente", {arr_cli:arr_cli,arr_analis:arr_analis,group_id:group_id}, function(data){

         if(data == 1){

          swal("Cliente guardado correctamente");
          consulta_egencia_udids_ac('UDIDS');
          $('#myModal').modal('hide');

         }else if(data == 2){

          swal("Error al guardar: cliente ya existe");
          consulta_egencia_udids_ac('UDIDS');
          $('#myModal').modal('hide');


         }else{

          swal("Error al guardar la cliente");

         }

   });

}

function mostrarContrasena(){

      var tipo = document.getElementById("txt_num_cliente");
      if(tipo.type == "password"){
          tipo.type = "text";
      }else{
          tipo.type = "password";
      }

}

Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
  });

  Array.prototype.removeItem = function (a) {
   for (var i = 0; i < this.length; i++) {
    if (this[i] == a) {
     for (var i2 = i; i2 < this.length - 1; i2++) {
      this[i2] = this[i2 + 1];
     }
     this.length = this.length - 1;
     return;
    }
   }
  };

  
</script>