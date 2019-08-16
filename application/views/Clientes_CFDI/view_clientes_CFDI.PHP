<div class="row">

    <div class="col-md-12">
    
    <button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_clientes_CFDI();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
    </button>

    <button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_clientes_CFDI();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
    </button>

    <button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_clientes_CFDI();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
    </button>
      
    </div>
    <div class="col-md-12">
          
        <div id="div_datagrid" style="height: 90%;">
               <table id="dg_clientes_CFDI" style="height: 95%;" sortName="id_cliente" sortOrder="asc" data-options="
                    singleSelect:true,
                    autoRowHeight:false,
                    pagination:true,
                    pageList: [500,1000,2000,3000],
                    pageSize:500"></table>
        </div>
      
    </div>

</div>

<script type="text/javascript">
  
  $("#div_cliente_clientes_CFDI").show();
  $("#div_btn_guardar").show();

  $("#title").html('<?=$title?>');

  get_clientes_CFDI();

  function formatField(value){

    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  
  }

  function get_clientes_CFDI(){
    
        $('#dg_clientes_CFDI').datagrid({
              url:"<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/get_catalogo_clientes_CFDI",
              columns:[[

                    {field:'id',title:'Id',formatter:formatField,sortable:true,hidden:true},
                    {field:'id_cliente',title:'Id cliente',formatter:formatField,sortable:true},
                    {field:'tpo_factura',title:'Tipo factura',formatter:formatField,sortable:true},
                    {field:'fecha_alta',title:'Fecha Alta',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',formatter:formatField}

                    
                ]],onLoadSuccess:function(){

                     
                  
                },onBeforeSortColumn:function(sort,order){
                   
                  
                
                },onSortColumn:function(sort,order){
                   
                    
                
                }
        }).datagrid('clientPaging');
       
  }
  

  function btn_agregar_clientes_CFDI(){
    
    rest_modal('mod_guardar_cliente_CFDI();');

    $("#modal_content").css({"width": "60%"});

    $.post("<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/get_html_agregar_clientes_CFDI", {suggest: ''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nuevo Cliente</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            get_clientes_dk();
           

        });
  }

  function btn_actualizar_clientes_CFDI() {

    var row_clientes_CFDI = $('#dg_clientes_CFDI').datagrid('getSelections');
       
    rest_modal('mod_guardar_actualizacion_clientes_CFDI();');

    $("#modal_content").css({"width": "20%"});

    $.post("<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/get_html_actualizar_clientes_CFDI", {row_clientes_CFDI:row_clientes_CFDI}, function(data){
            
          $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar cliente</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

          
      });


  }

  function btn_eliminar_clientes_CFDI(){

    var row_clientes_CFDI = $('#dg_clientes_CFDI').datagrid('getSelections');
    var id_cliente_CFDI = row_clientes_CFDI[0]['id'];

    $.post("<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/eliminar_cliente_CFDI", {id_cliente_CFDI:id_cliente_CFDI}, function(data){
          
          if(data == 1){

             clientes_CFDI('Clientes CFDI');
             swal('Cliente eliminado correctamente');


          }else{
             swal('Error al eliminar cliente');
          }

      });

  }

  function buscar(){

    get_clientes_CFDI();
  }

</script>