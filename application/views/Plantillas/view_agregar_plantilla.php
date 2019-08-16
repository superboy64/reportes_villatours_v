<div class="row">
  <div class="col-md-6">

      <div class="form-group">
        <label>Nombre</label>
        <input type="text" class="form-control" id="txt_nombre" placeholder="Nombre">
      </div>
      <div class="form-group">
        <label>Reporte</label>
        <select class="form-control" id="slc_reporte">
              
              <option>seleccione</option>
              <!--
                <?php
                    foreach ($reportes as &$valor){

                         print_r('<option value="'.$valor['id'].'">'.$valor['nombre'].'</option>');

                    }
                ?> por lo pronto solo se utilizaran las plantillas en gvc reporteador-->
              <option  value='4' >GVC reporteador</option>
              <option  value='5' >Layout segmentado</option>

        </select>
      </div>


  </div>

      <div class="col-md-12">
        <div class="row">
        
            <div class="panel panel-primary">
  
                    <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-5">

                                <div class="panel panel-primary">
                                  <div class="panel-heading">
                                    <h1 class="panel-title" style="color: #fff;">
                                      

                                        <div class="col-md-12">
                                         
                                          <div class="row">

                                            <div class="col-md-8">
                                              Columnas
                                            </div>
                                           

                                          </div>
                                        </div>

                                   
                                    </h1>
                                   
                                  </div>
                                  <div class="panel-body" style="height: 191px;overflow-y:hidden;" >
                                    
                                    <div id="div_tbl_cli">
                                      <table id="dg_columnas" style="height: 191px;"></table>
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
                                    <h1 class="panel-title" style="color: #fff;">Columnas seleccionadas</h1>
                                   
                                  </div>
                                  <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                                    
                                    <div id="div_tbl_sel">
                                      <table id="dg_columnas_seleccionadas" style="height: 191px;"></table>
                                    </div>
                                  </div>
                                </div>

                              </div>

                             </div>
                          </div>
                    </div>


          </div>

         </div>


      </div>

</div>

<script type="text/javascript">
  
  $( "#slc_reporte" ).change(function() {

    var id_rep = $( "#slc_reporte" ).val();
    
    mostrar_cloumnas(id_rep);
  
  });
  
  function formatField(value){

    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  
  }

  function mostrar_cloumnas(id_rep){


    $.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/mostrar_cloumnas", {id_rep:id_rep}, function(data){

        data = JSON.parse(data);

        $('#dg_columnas').datagrid({ 
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
          columns:[[ 
              {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
              {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
              {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true},
              
             
          ]],onLoadSuccess:function(){
              
              console.log("carga alta");
          
              $('#dg_columnas_seleccionadas').datagrid({
                  url:"#",
                  data:[],
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
                    {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
                    {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
                    {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true},
                  ]],onLoadSuccess:function(){

                      console.log("clear grid seleccion");
                      row_columnas_all =  [];
                        

                    }

              });

          }

        });

      });

  }
  
    row_columnas_all =  [];

    function seleccionar(){

    var id_rep = $( "#slc_reporte" ).val();

    var rows_columnas = $('#dg_columnas').datagrid('getSelections');
    
    $.each(rows_columnas, function( index, value ) {
        
        row_columnas_all.push(value);
        
    });

    row_columnas_all = row_columnas_all.unique();

      $('#dg_columnas_seleccionadas').datagrid({
          data:row_columnas_all,
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
            {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
            {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
            {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true},
          ]],onLoadSuccess:function(){


                var rows_columnas_selec = $('#dg_columnas_seleccionadas').datagrid('getRows');

                var ids_selec = '';
                $.each(rows_columnas_selec, function( index, value ) {
        
                    ids_selec = ids_selec + value['id_col'] + ',';
                   
                });

               
                $.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/get_columnas_not_in_plantilla", {ids_selec: ids_selec,id_rep:id_rep}, function(data){
              
                    data = JSON.parse(data);

                    
                    $('#dg_columnas').datagrid({
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
                          {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
                          {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
                          {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true},
                        ]],onLoadSuccess:function(){
                        
                        console.log("se actualizaron los dks correctamento funcion(not in) ");
                            
                      }
                    });
                   
                });


        }
      });

  }

  function deseleccionar(){
      
      var id_rep = $( "#slc_reporte" ).val();
      var rows_columnas_selec = $('#dg_columnas_seleccionadas').datagrid('getSelections');
      var rows_columnas_selec_all = $('#dg_columnas_seleccionadas').datagrid('getRows');
      
      $.each(rows_columnas_selec, function( index, value ) {
        
         rows_columnas_selec_all.removeItem(value);

      });

      $('#dg_columnas_seleccionadas').datagrid({
                            url:"#",
                            data:rows_columnas_selec_all,
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
                                {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
                                {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
                                {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true}
                                
                            ]],onLoadSuccess:function(){

                                var rows_columnas_selec = $('#dg_columnas_seleccionadas').datagrid('getRows');
                                
                                if(rows_columnas_selec.length != 0){

                                    var ids_selec = '';
                                    $.each(rows_columnas_selec, function( index, value ) {
                            
                                        ids_selec = ids_selec + value['id_col'] + ',';
                                       
                                    });


                                    $.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/get_columnas_not_in_plantilla", {ids_selec: ids_selec,id_rep:id_rep}, function(data){
              
                                        data = JSON.parse(data);

                                        $('#dg_columnas').datagrid({
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
                                            {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
                                            {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
                                            {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true}
                                          ]],onLoadSuccess:function(){
                                          
                                          console.log("se actualizaron los dks correctamente funcion(not in)2 ");
                                              
                                        }
                                    });
                                       
                                    });

                                    

                                }else{

                                    $('#dg_columnas').datagrid({
                                        url:"<?php echo base_url(); ?>index.php/Cnt_plantillas/get_columnas_plantillas_url?id_rep="+id_rep,
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
                                            {field:'id',title:'id',checkbox:"true",formatter:formatField,sortable:true},
                                            {field:'id_rep',title:'id_rep',formatter:formatField,sortable:true,hidden:true},
                                            {field:'nombre_columna_vista',title:'nombre_columna_vista',formatter:formatField,sortable:true}
                                           
                                        ]],onLoadSuccess:function(){
                                            
                                            console.log("problema solucionado2");
                                          
                                        }
                                    });

                                }

                              }
                        });
  

    }

  function mod_guardar_plantilla() {

    var nombre = $("#txt_nombre").val();
    var id_reporte = $("#slc_reporte").val();

    var row_plantilla_sele = $('#dg_columnas_seleccionadas').datagrid('getRows');

    var arr_col = [];
    
    $.each( row_plantilla_sele, function( key, value ) {
      
      arr_col.push(value['id_col']);

    });

    $.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/guardar_plantilla", {nombre:nombre,id_reporte:id_reporte,arr_col:arr_col}, function(data){

         if(data == 1){

          swal("Plantilla guardada correctamente");
          consulta_plantillas('Plantillas');
          $('#myModal').modal('hide');

         }else{

          swal("Error al guardar la plantilla");

         }

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