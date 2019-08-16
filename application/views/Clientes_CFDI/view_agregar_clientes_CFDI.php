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

                   <button type="button" class="btn btn-default" style="margin-top: 86px;" onclick="seleccionar();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

                   </button>

                   <button type="button" class="btn btn-default" onclick="deseleccionar();">

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

             <div class="col-md-3">
            
                <label>Factura a:&nbsp;</label><br>
              
                <select id="slc_tpo_factura_alta" class="form-control">

                    <option value="1">CLIENTE</option>
                    <option value="2">VILLATOURS</option>

                </select>
            
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

    
    function seleccionar(){

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

    function deseleccionar(){

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

  function mod_guardar_cliente_CFDI() {

   var tpo_factura = $("#slc_tpo_factura_alta").val();

   var row_clientes_sele = $('#dg_clientes_seleccionadas').datagrid('getRows');

   var arr_cli = [];
    
   $.each( row_clientes_sele, function( key, value ) {
      
      arr_cli.push(value['id_cliente']);

   });


   $.post("<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/guardar_cliente_CFDI", {arr_cli:arr_cli,tpo_factura:tpo_factura}, function(data){

         if(data == 1){

          swal("Cliente guardado correctamente");

          clientes_CFDI('Clientes CFDI');

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