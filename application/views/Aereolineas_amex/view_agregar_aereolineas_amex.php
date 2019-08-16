<div class="row">

      <div class="col-md-12">
    <br>

        <div class="row">
        
              <div class="col-md-5">

                <div class="panel panel-primary">

                  <div class="panel-heading">
                    <h1 class="panel-title" style="color: #fff;">Aereolineas</h1>
                   
                  </div>
                  
                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                    <table id="dg_aereolineas" class="easyui-datagrid" style="height: 191px;width: 370px;"></table>
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
                    <h1 class="panel-title" style="color: #fff;">Aereolineas seleccionadas</h1>
                   
                  </div>
                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                    
                      <table id="dg_aereolineas_seleccionadas" style="height: 191px;width: 370px;"></table>
                   
                  </div>
                </div>

              </div> 

             <div class="col-md-12"><br></div>

           <div class="col-md-3">
            
              <label>Categoria:&nbsp;</label><br>
            
              <select id="slc_cat_aereolinea" class="form-control">

                  <option value="1">CARGO</option>
                  <option value="2">BAJO COSTO</option>

              </select>
            
           </div>

           <div class="col-md-3">
            
              <label>Codigo BSP:&nbsp;</label><br>
              <input type="text" class="form-control" id="txt_CODIGO_BSP">
              
            
           </div>

           <div class="col-md-3" id="div_cambio_prov">
             
              <div class="form-check">
                <input class="form-check-input" type="radio" name="rad_cambio_prov"  value="9K" checked>
                <label class="form-check-label">
                  9K
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="rad_cambio_prov"  value="CS">
                <label class="form-check-label">
                  CS
                </label>
              </div>

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
  
  get_aereolineas_amex();
  $("#div_cambio_prov").hide();

  function get_aereolineas_amex(){

    $('#dg_aereolineas').datagrid({
              url:"<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/get_catalogo_aereolineas_amex",
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
                  {field:'ck',title:'Id',checkbox:"true",sortable:true},
                  {field:'id_proveedor',title:'id_proveedor',formatter:formatField,sortable:true},
                  {field:'nombre',title:'Aereolinea',formatter:formatField,sortable:true}
                 
              ]],onLoadSuccess:function(){
                  
                $('#dg_aereolineas_seleccionadas').datagrid({ //inicializa la tabla de seleccionados
                  columns: [[
                     {field:'ck',title:'Id',checkbox:"true",sortable:true},
                     {field:'id_proveedor',title:'id_proveedor',formatter:formatField,sortable:true},
                     {field:'nombre',title:'Aereolinea',formatter:formatField,sortable:true,width:370}
                  ]]
                });


              }
          });

  }

    
    function seleccionar(){

      //var rows_reportes = $('#dg_reportes').datagrid('getSelections');
      var rows_aereolineas = $('#dg_aereolineas').datagrid('getSelections');
      var rows_aereolineas_selec = $('#dg_aereolineas_seleccionadas').datagrid('getRows');
            //var rows_aereolineas_selec = $('#dg_reportes_seleccionados').datagrid('getRows');

            var rows_aereolineas_all = $('#dg_aereolineas').datagrid('getRows');

            if(rows_aereolineas_selec.length > 0){

              $.each(rows_aereolineas, function( index, value ) {
 
                  $('#dg_aereolineas_seleccionadas').datagrid('appendRow',{ id_proveedor: value['id_proveedor'],nombre:value['nombre']});
                  
                
              });

              for (i = 0; i < rows_aereolineas_all.length; i++) {


                  $.each(rows_aereolineas, function( index2, value2 ) {

                    if(rows_aereolineas_all[i]['id_proveedor'] == value2['id_proveedor']){

                      $('#dg_aereolineas').datagrid('deleteRow', i);

                    }
                    
                
                  });


              }

            }else{

            
                $.each(rows_aereolineas, function( index, value ) {
                   
                    $('#dg_aereolineas_seleccionadas').datagrid('appendRow',{ id_proveedor: value['id_proveedor'],nombre:value['nombre']});
                    
                  
                });

               
               for (i = 0; i < rows_aereolineas_all.length; i++) {

                  $.each(rows_aereolineas, function( index2, value2 ) {

                    if(rows_aereolineas_all[i]['id_proveedor'] == value2['id_proveedor']){

                        $('#dg_aereolineas').datagrid('deleteRow', i);


                    }
                    
                
                  }); 
                  
               }

            }

    }

    function deseleccionar(){

      var rows_aereolineas_selec = $('#dg_aereolineas_seleccionadas').datagrid('getSelections');
      var rows_aereolineas_selec_all = $('#dg_aereolineas_seleccionadas').datagrid('getRows');
     
      var $new_array_row_clientes_all = {};

       for (i = 0; i < rows_aereolineas_selec_all.length; i++) {

          $.each(rows_aereolineas_selec, function( index2, value2 ) {

            if(rows_aereolineas_selec_all[i]['id_proveedor'] == value2['id_proveedor']){

                $('#dg_aereolineas_seleccionadas').datagrid('deleteRow', i);

                $.each(row_clientes_all, function( index3, value3 ) {

                   if(index3 != 'rep_'+value2['id_proveedor'] ){

                      $new_array_row_clientes_all[index3] = value3;

                    
                   }

                });


            }
            
        
          }); 
          
       }

       row_clientes_all = $new_array_row_clientes_all;

       aereolineas_not_in();
  

    }

    function aereolineas_not_in(){

            var rows_aereolineas_selec = $('#dg_aereolineas_seleccionadas').datagrid('getRows');


            $.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/get_aereolineas_amex_not_in", {rows_aereolineas_selec: JSON.stringify(rows_aereolineas_selec)}, function(data){
                
                data = JSON.parse(data);
                
                $('#dg_aereolineas').datagrid({
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
                    {field:'id_proveedor',title:'Id_aereolinea',formatter:formatField,sortable:true},
                    {field:'nombre',title:'Aereolinea',formatter:formatField,sortable:true,width:370}
                  ]],onLoadSuccess:function(){
                     
                     console.log("problema solucionado 2");
                     
                }
              });
               
            });
            

    }

  /**********************************************************************************************/

  function guardar_aereolinea(){

    var slc_cat_aereolinea = $("#slc_cat_aereolinea").val();
    var txt_CODIGO_BSP = $("#txt_CODIGO_BSP").val();

    var rad_cambio_prov = "";

    if(slc_cat_aereolinea == '1'){

        if(txt_CODIGO_BSP == '306'){

           rad_cambio_prov = $('input[name="rad_cambio_prov"]:checked').val();

        }

    }

    
    var row_aereolineas_sele = $('#dg_aereolineas_seleccionadas').datagrid('getRows');

    $.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/guardar_aereolinea_amex", {arr_prov:JSON.stringify(row_aereolineas_sele),slc_cat_aereolinea:slc_cat_aereolinea,txt_CODIGO_BSP:txt_CODIGO_BSP,rad_cambio_prov:rad_cambio_prov}, function(data){

         if(data == 1){

          swal("aereolinea guardado correctamente");

          consulta_aereolineas('aereolineas AMEX');

          $('#myModal').modal('hide');

         }else{

          swal("Error al guardar la tarjeta");

         }

    });


  }


$("#txt_CODIGO_BSP").blur(function(){

    var codigo_bsp = $(this).val();
    var cat_aereolinea = $("#slc_cat_aereolinea").val();

    if(cat_aereolinea == '1'){

        if(codigo_bsp == '306'){

          $("#div_cambio_prov").show();

        }else{

          $("#div_cambio_prov").hide();

        }

    }else{

          $("#div_cambio_prov").hide();

    }
    

});


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