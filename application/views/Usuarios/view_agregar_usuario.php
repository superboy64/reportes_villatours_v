<div class="row">
  <div class="col-md-6">

    <div class="form-group">
      <label>Sucursal</label>
      <select class="form-control" id="slc_sucursal">
            <option>seleccione</option>
              <?php
                  foreach ($sucursales as &$valor){

                       print_r('<option value="'.$valor['id_sucursal'].'">'.$valor['cve'].'</option>');

                  }
              ?>
      </select>
    </div>
    <div class="form-group">
      <label>Nombre</label>
      <input type="text" class="form-control" id="txt_nombre" placeholder="Nombre">
    </div>
    <div class="form-group">
      <label>Usuario</label>
      <input type="usuario" class="form-control" id="txt_usuario" placeholder="Usuario">
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" class="form-control" id="txt_password" placeholder="Password">
    </div>
    <div class="form-group">
      <label>Perfil</label>
      <select class="form-control" id="slc_dep">
            <option>seleccione</option>
              <?php
                  foreach ($perfiles as &$valor){

                       print_r('<option value="'.$valor['id'].'">'.$valor['nombre'].'</option>');

                  }
              ?>
      </select>
    </div>

 </div>
</div>

  <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-5">

            <div class="panel panel-primary">
              <div class="panel-heading">
                <h1 class="panel-title" style="color: #fff;">
                  

                    <div class="col-md-12">
                     
                      <div class="row">

                        <div class="col-md-8">
                          Clientes(DK)
                        </div>
                       

                      </div>
                    </div>

               
                </h1>
               
              </div>
              <div class="panel-body" style="height: 191px;overflow-y:hidden;" >
                <div id="div_tbl_cli_img" style="margin-top: 71px;font-size: 18px;color: red;"><center><b>Visualización completa de clientes<b></center></div>
                <div id="div_tbl_cli">
                  <table id="dg_perfil_clientes" style="height: 191px;"></table>
                </div>
              </div>
            </div>

          </div>

          <div class="col-md-1">
             <center>

               <button type="button" class="btn btn-default" style="margin-top: 89px;" onclick="seleccionar();">

                 &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

               </button>

               <button type="button" class="btn btn-default" style="margin-top: 8px;" onclick="deseleccionar();">

                 &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

               </button>


             </center>
             

          </div>

          <div class="col-md-5">

            <div class="panel panel-primary">
              <div class="panel-heading">
                <h1 class="panel-title" style="color: #fff;">Clientes seleccionados</h1>
               
              </div>
              <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                <div id="div_tbl_sel_img" style="margin-top: 71px;font-size: 18px;color: red;"><center><b>Visualización completa de clientes<b></center></div>
                <div id="div_tbl_sel">
                  <table id="dg_perfil_seleccionados" style="height: 191px;"></table>
                </div>
              </div>
            </div>

          </div>

         </div>
      </div>
</div>

<script type="text/javascript">
  
    function formatField(value){
      return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    }

    $('#div_tbl_cli').show();$('#div_tbl_cli_img').hide();
    $('#div_tbl_sel').show();$('#div_tbl_sel_img').hide();

    $("#all_dks").bootstrapToggle();

    $("#slc_dep").change(function() {

      $('#div_tbl_cli').show();$('#div_tbl_cli_img').hide();
      $('#div_tbl_sel').show();$('#div_tbl_sel_img').hide();

      var id_per = $( "#slc_dep" ).val();

      $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_perfiles_id", {id_per:id_per}, function(data){

        data = JSON.parse(data);

        var all_dks = data[0]['all_dks'];

        if(all_dks == '0'){

          get_clientes_dk_perfil(id_per);

          $('#dg_perfil_seleccionados').datagrid({ //inicializa la tabla de seleccionados
                    url:"#",
                    data:[],
                    remoteSort:false,
                    columns: [[
                      {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                      {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                      {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                    ]],onLoadSuccess:function(){

                        row_clientes_all =  [];
                        console.log("problema solucionado3");

                      }
                  });

        }else{  

          $('#div_tbl_cli').hide();$('#div_tbl_cli_img').show();
          $('#div_tbl_sel').hide();$('#div_tbl_sel_img').show();

        }

      });
    
    });

    function get_clientes_dk_perfil(id_per){

    $('#dg_perfil_clientes').datagrid({
              url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_perfil?id_per="+id_per,
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
                  {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
                  {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                  {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                  {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                 
              ]],onLoadSuccess:function(){
                  
                $('#dg_perfil_seleccionados').datagrid({ //inicializa la tabla de seleccionados
                  remoteSort:false,
                  columns: [[
                    {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                    {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                    {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                  ]],onLoadSuccess:function(){

                           console.log("problema solucionado");
                           //$('#dg_perfil_clientes').data('datagrid').selectedRows  
                    }
                });


              }
          });

  }

    row_clientes_all =  [];

    function seleccionar(){

    var id_per = $( "#slc_dep" ).val();

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

               
                $.post("<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_not_in_usuario", {ids_selec: ids_selec,id_per:id_per}, function(data){
              
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
                        {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
                        {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                        {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                        {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                      ]],onLoadSuccess:function(){
                      
                      console.log("se actualizaron los dks correctamento funcion(not in) ");
                          
                    }
                  });
                   
                });


        }
      });

  }

    function deseleccionar(){
      
      var id_per = $( "#slc_dep" ).val();
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
                                {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
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


                                    $.post("<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_not_in", {ids_selec: ids_selec,id_per:id_per}, function(data){
              
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
                                            {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
                                            {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                                            {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                                            {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                                          ]],onLoadSuccess:function(){
                                          
                                          console.log("se actualizaron los dks correctamente funcion(not in)2 ");
                                              
                                        }
                                    });
                                       
                                    });

                                    

                                }else{

                                    $('#dg_perfil_clientes').datagrid({
                                        url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_clientes_dk_perfil?id_per="+id_per,
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
                                            {field:'ck',title:'Id',checkbox:"true",formatter:formatField,sortable:true},
                                            {field:'id_cliente',title:'Id',formatter:formatField,sortable:true},
                                            {field:'nombre_cliente',title:'Nombre',formatter:formatField,sortable:true},
                                            {field:'id_corporativo',title:'Corporativo',formatter:formatField,sortable:true},
                                           
                                        ]],onLoadSuccess:function(){
                                            
                                            console.log("problema solucionado2");
                                          
                                        }
                                    });

                                }

                              }
                        });
  

    }

    function mod_guardar_usuario() {

    var txt_nombre = $("#txt_nombre").val();
    var txt_usuario = $("#txt_usuario").val();
    var txt_password = $("#txt_password").val();
    var slc_sucursal = $("#slc_sucursal").val();
    var slc_dep = $("#slc_dep").val();

    $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_perfiles_id", {id_per:slc_dep}, function(data){

        data = JSON.parse(data);

        var all_dks = data[0]['all_dks'];

        if(all_dks == '0'){

          var rows_clientes_selec_all = $('#dg_perfil_seleccionados').datagrid('getRows');

        }else{


          var rows_clientes_selec_all = [];


        }

        console.log(all_dks);
        $.post("<?php echo base_url(); ?>index.php/Cnt_usuario/guardar_usuario", {txt_nombre:txt_nombre,txt_usuario:txt_usuario,txt_password:txt_password,slc_sucursal:slc_sucursal,slc_dep:slc_dep,rows_clientes_selec_all:rows_clientes_selec_all,all_dks:all_dks}, function(data){
            
            if(data == 1){
               $('#myModal').modal('hide');
               $('#dg').datagrid('reload');
               swal('Usuario guardado correctamente');
            }else if(data == 2){

               swal('Usuario ya existente en la base de datos');

            }else{
               swal('Error al guardar usuario');
            }

        });

    });

   
    
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