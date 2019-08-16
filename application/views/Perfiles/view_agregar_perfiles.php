<div class="row">
  <div class="col-md-12">
    <!--Encabezado--><br>
    <div class="row">

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-2">

              <label>Sucursal:&nbsp;</label><br>
              
              <select class="form-control" id="slc_id_suc">
                      <?php
                          foreach ($sucursales as &$valor){
                               
                               print_r('<option value="'.$valor['id_sucursal'].'">'.$valor['cve'].'</option>');

                          }
                      ?>
              </select>
              
          </div>

          <div class="col-md-2">
          
              <label>Departamento</label>
              <select class="form-control" id="slc_dep">
              <option value="0">seleccione</option>
                <?php
                    foreach ($departamentos as &$valor){
                       print_r('<option value="'.$valor['id'].'">'.$valor['nombre'].'</option>');
                    }
                ?>
             </select>

          </div>

          <div class="col-md-2">

            <label>Sucursales visibles</label><br>
            <select id="slc_mult_id_sucursal_alta" multiple="multiple">
             
                <?php
                    foreach ($sucursales as &$valor){


                          print_r('<option value="'.$valor['id_sucursal'].'">'.$valor['cve'].'</option>');

                       

                    }
                ?>
                
            </select>
            
          </div>

          <div class="col-md-3">
              
              <label>Visualización completa de clientes</label>
              <br>
              <input id="all_dks" type="checkbox" data-toggle="toggle" data-size="mini" >

          </div>

        </div>
        <br>
      </div>
     
      <!--clientes-->
      <div class="col-md-4">

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h1 class="panel-title" style="color: #fff;">Clientes(DK)</h1>
           
          </div>
          <div class="panel-body" style="height: 191px;overflow-y:hidden;" >
            <div id="div_tbl_cli_img" style="margin-top: 71px;font-size: 18px;color: red;"><center><b>Visualización completa de clientes<b></center></div>
            <div class="divs_h"><table id="dg_perfil_clientes" style="height: 191px;"></table></div>
          </div>
        </div>

      </div>

      <div class="col-md-1">
         <center>
          <div class="divs_h">
            <div style="margin-top: 86px;">
             <button type="button" class="btn btn-default"  onclick="seleccionar();">
               &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
             </button>

             <button type="button" class="btn btn-default"  onclick="deseleccionar();">
               &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
             </button>
           </div>
         </div>

         </center>
         

      </div>

      <div class="col-md-4">

        <div class="panel panel-primary">

          <div class="panel-heading">
            <h1 class="panel-title" style="color: #fff;">Clientes seleccionados</h1>
          </div>
          <div class="panel-body" style="height: 191px;overflow-y:hidden;">
            <div id="div_tbl_sel_img" style="margin-top: 71px;font-size: 18px;color: red;"><center><b>Visualización completa de clientes<b></center></div>
            <div class="divs_h"><table id="dg_perfil_seleccionados" style="height: 191px;"></table></div>
          </div>

        </div>
        
      </div>
      <!--modulos-->
      <div class="col-md-12">
        <br><br>
      </div>

      <div class="col-md-4">

        <div class="panel panel-primary">

          <div class="panel-heading">
            <h1 class="panel-title" style="color: #fff;">Modulos</h1>
          </div>
          <div class="panel-body" style="height: 191px;overflow-y:hidden;">
            <table id="dg_modulos" style="height: 191px;" data-options="singleSelect:true"></table>
          </div>

        </div>
        
      </div>

      <div class="col-md-1">
        &nbsp;
      </div>

      <div class="col-md-4">

        <div class="panel panel-primary">

          <div class="panel-heading">
            <h1 class="panel-title" style="color: #fff;">Submodulos</h1>
          </div>
          <div class="panel-body" style="height: 191px;overflow-y:auto;">
            
            <?php  //se crean n cantidad de tablas segun la cantidad de modulos

                foreach ($modulos as &$valor){

                  print_r('<table style="display: none; font-size:14px;" class="table" id="tbl_sub_'.$valor["id"].'">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Nombre</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                           
                          </tbody>
                      </table>');

                }

            ?>
           
          </div>

        </div>
        
      </div>


    </div>
  </div> 

</div><!-- fin de row -->

<script type="text/javascript">

  $('#slc_mult_id_sucursal_alta').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      buttonWidth: '200px',
      maxHeight: 400,
  });

  $('#div_tbl_cli_img').hide();
  $('#div_tbl_sel_img').hide();
  $('#all_dks').bootstrapToggle();

  $('#all_dks').change(function() {
         
      var status = $(this).prop('checked');

      if(status == true){

        $(".divs_h").hide();
        $('#div_tbl_cli_img').show();
        $('#div_tbl_sel_img').show();

       }else if(status == false){

        $(".divs_h").show();

        $('#div_tbl_cli_img').hide();
        $('#div_tbl_sel_img').hide();

       }

  });

  function formatField(value){
  return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  }

  function get_modulos(){

      $('#dg_modulos').datagrid({
          url:"<?php echo base_url(); ?>index.php/Cnt_perfiles/get_catalogo_modulos",
          remoteSort:false,
          onClickRow: function(rowIndex, rowData){

            show_sub_modulos(rowData["id"]);

          },
          columns: [[
            {field:'id',title:'Id',formatter:formatField,sortable:true},
            {field:'nombre',title:'Nombre',formatter:formatField,sortable:true},
           
          ]],onLoadSuccess:function(){
                  
                get_sub_modulos();

            }
      });
  }

  function get_sub_modulos(){

    var modulos = $('#dg_modulos').datagrid('getRows');
   
    $.each(modulos, function( index, value ) {

      $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_catalogo_submodulos", {modulo_id: value["id"]}, function(data){
              
              data = JSON.parse(data);
                 
              $.each(data, function( index2, value2 ) {
                  
                  $('#tbl_sub_'+value["id"]+' '+'tbody').append('<tr style="font-size:10px;"><td><input id="prodId" name="prodId" type="hidden" value="'+value2["id"]+'">'+value2["id"]+'</td><td>'+value2["nombre"]+'</td><td><input id="chek_sub_'+value["id"]+'_'+value2["id"]+'" checked type="checkbox" data-toggle="toggle" data-size="mini"></td><td>Altas&nbsp;<input id="check_altas_'+value["id"]+'_'+value2["id"]+'" checked type="checkbox" data-toggle="toggle" data-size="mini">Bajas&nbsp;<input id="check_bajas_'+value["id"]+'_'+value2["id"]+'" checked type="checkbox" data-toggle="toggle" data-size="mini" ></td></tr>');

                  $('#chek_sub_'+value["id"]+'_'+value2["id"]).bootstrapToggle();
                  $('#check_altas_'+value["id"]+'_'+value2["id"]).bootstrapToggle();
                  $('#check_bajas_'+value["id"]+'_'+value2["id"]).bootstrapToggle();
                  
              });
             
          });
        
    });

  }

  function show_sub_modulos(id_modulo){
    
    var modulos_all = $('#dg_modulos').datagrid('getRows');
    var modulos = $('#dg_modulos').datagrid('getSelections');

    $.each(modulos_all, function( index, value ) {
        
        $('#tbl_sub_'+value["id"]).hide();
        
    });
    
    $('#tbl_sub_'+id_modulo).show();

  }


  /**********************************************************************************************/
 
  function get_clientes_dk(){

    $('#dg_perfil_clientes').datagrid({
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
                  {field:'ck',title:'Id',checkbox:"true",sortable:true},
                  {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                  {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                  {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                 
              ]],onLoadSuccess:function(){
                  
                $('#dg_perfil_seleccionados').datagrid({ //inicializa la tabla de seleccionados
                  columns: [[
                    {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                    {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                    {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                  ]]
                });


              }
          });

  }

    row_clientes_all =  [];

    function seleccionar(){

    var rows_clientes = $('#dg_perfil_clientes').datagrid('getSelections');
    
    $.each(rows_clientes, function( index, value ) {
        
        row_clientes_all.push(value);
        
    });

    row_clientes_all = row_clientes_all.unique();

      $('#dg_perfil_seleccionados').datagrid({
          data:row_clientes_all,
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
            {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
            {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
            {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
            {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true}
          ]],onLoadSuccess:function(){

                var rows_clientes_selec = $('#dg_perfil_seleccionados').datagrid('getRows');

                var ids_selec = '';
                $.each(rows_clientes_selec, function( index, value ) {
        
                    ids_selec = ids_selec + value['id_cliente'] + ',';
                   
                });

                $.post("<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_not_in", {ids_selec: ids_selec}, function(data){
              
                                        data = JSON.parse(data);

                                        $('#dg_perfil_clientes').datagrid({
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
                                                {field:'ck',title:'Id',checkbox:"true",sortable:true},
                                                {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                                                {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                                                {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                                              ]],onLoadSuccess:function(){
                                              
                                              console.log("se actualizaron los dks correctamento funcion(not in)2 ");
                                                  
                                            }
                                        });
                                       
                                    });
        }
      });

  }

    function deseleccionar(){

      var rows_clientes_selec = $('#dg_perfil_seleccionados').datagrid('getSelections');
      var rows_clientes_selec_all = $('#dg_perfil_seleccionados').datagrid('getRows');
      
      $.each(rows_clientes_selec, function( index, value ) {
        
         rows_clientes_selec_all.removeItem(value);

      });

      $('#dg_perfil_seleccionados').datagrid({
                            url:"#",
                            data:rows_clientes_selec_all,
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
                                {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                                {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                                {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                                
                            ]],onLoadSuccess:function(){

                                var rows_clientes_selec = $('#dg_perfil_seleccionados').datagrid('getRows');
                                
                                if(rows_clientes_selec.length != 0){

                                    var ids_selec = '';
                                    $.each(rows_clientes_selec, function( index, value ) {
                            
                                        ids_selec = ids_selec + value['id_cliente'] + ',';
                                       
                                    });

                                    $.post("<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_not_in", {ids_selec: ids_selec}, function(data){
              
                                        data = JSON.parse(data);

                                        console.log(data);

                                        $('#dg_perfil_clientes').datagrid({
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
                                              {field:'ck',title:'Id',checkbox:"true",sortable:true},
                                              {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                                              {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                                              {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                                            ]],onLoadSuccess:function(){
                                            
                                            console.log("se actualizaron los dks correctamento funcion(not in)2 ");
                                                
                                          }
                                        });
                                       
                                    });

                                }else{
                                    
                                    $('#dg_perfil_clientes').datagrid({
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
                                            {field:'ck',title:'Id',checkbox:"true",sortable:true},
                                            {field:'id_cliente',title:'Id',sortable:true},
                                            {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                                            {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                                           
                                        ]],onLoadSuccess:function(){
                                            
                                          
                                        }
                                    });

                                }

                              }
                        });
  

    }


  /**********************************************************************************************/
   
  function mod_guardar_perfil(){

    var status_all_cli = $("#all_dks").bootstrapToggle();
    status_all_cli = status_all_cli[0]['checked'];

    if(status_all_cli == true){

      status_all_cli = 1;

    }else{

      status_all_cli = 0

    }

    var slc_id_suc = $("#slc_id_suc").val();
    var rows_cli_select = $('#dg_perfil_seleccionados').datagrid('getRows');
    var rows_mod = $('#dg_modulos').datagrid('getRows');
    var slc_dep = $("#slc_dep").val();
    var slc_mult_id_sucursal_alta = $("#slc_mult_id_sucursal_alta").val();

    var array_mod = [];

    $.each(rows_mod, function( index, value ) {
        
        array_mod.push(value["id"]);
        
    });


    if($("#slc_dep").val() == 0){

         swal('Favor de asignar un Departamento al perfil');

    }else if(rows_cli_select.length == 0 && status_all_cli == 0){

         swal('Favor de asignar DKS al perfil');
         
    }else{

          $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_catalogo_submodulos_in", {array_mod: array_mod}, function(data){
                  data = JSON.parse(data);

                  var array_mod_submod = [];

                
                    $.each(data, function( index, value ) {
          
                         var status = $("#chek_sub_"+value["id_modulo"]+"_"+value["id"]).bootstrapToggle();
                             status = status[0]['checked'];

                             if(status == true){

                                  status = 1;

                                }else{

                                  status = 0;

                                }

                         var status_altas = $("#check_altas_"+value["id_modulo"]+"_"+value["id"]).bootstrapToggle();
                             status_altas = status_altas[0]['checked'];

                             if(status_altas == true){

                                  status_altas = 1;

                                }else{

                                  status_altas = 0;

                                }

                         var status_bajas = $("#check_bajas_"+value["id_modulo"]+"_"+value["id"]).bootstrapToggle();
                             status_bajas = status_bajas[0]['checked'];
                             
                             if(status_bajas == true){

                                  status_bajas = 1;

                                }else{

                                  status_bajas = 0;

                                }

                         array_mod_submod.push(value["id_modulo"]+'_'+value["id"]+'_'+status+'_'+status_altas+'_'+status_bajas);  //concatnacion id_modulo_id_submodulo_status

                           
                    });
                
                 
                  $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/guardar_perfil", {slc_id_suc:slc_id_suc,rows_cli_select: rows_cli_select,slc_dep:slc_dep,slc_mult_id_sucursal_alta:slc_mult_id_sucursal_alta,array_mod_submod:array_mod_submod,rows_mod:rows_mod,status_all_cli:status_all_cli}, function(data){
                            
                        if(data == 1){
                           
                           $('#myModal').modal('hide');
                           $('#dg').datagrid('reload');
                           swal('Perfil guardado correctamente');
                           
                        }else{
                           swal('Error al guardar perfil');
                        }

                  });

          });

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