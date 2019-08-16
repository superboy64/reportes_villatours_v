<div class="row">

    <div class="col-md-12">
    
    <button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_tarjetas();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
    </button>

    <button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_tarjetas();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
    </button>

    <button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_tarjetas();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
    </button>
      
    </div>
    <div class="col-md-12">
          
        <div id="div_datagrid" style="height: 90%;">
               <table id="dg_tarjetas" style="height: 95%;" sortName="id_cliente" sortOrder="asc" data-options="
                    singleSelect:true,
                    autoRowHeight:false,
                    pagination:true,
                    pageList: [500,1000,2000,3000],
                    pageSize:500"></table>
        </div>
      
    </div>

</div>

<script type="text/javascript">
  
  $("#div_cliente_tarjetas").show();
  $("#div_btn_guardar").show();

  $("#title").html('<?=$title?>');

  get_tarjetas();

  function formatField(value){

    return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
  
  }

  function get_tarjetas(){
    
        $('#dg_tarjetas').datagrid({
              url:"<?php echo base_url(); ?>index.php/Cnt_tarjetas/get_catalogo_tarjetas",
              columns:[[

                    {field:'id_cliente',title:'Id cliente',formatter:formatField,sortable:true},
                    {field:'tarjeta',title:'Tarjetas',formatter:formatField,sortable:true},
                    {field:'fecha_alta',title:'Fecha Alta',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',formatter:formatField}

                    
                ]],onLoadSuccess:function(){

                     
                  
                },onBeforeSortColumn:function(sort,order){
                   
                  
                
                },onSortColumn:function(sort,order){
                   
                    
                
                }
        }).datagrid('clientPaging');
       
  }
  

  function btn_agregar_tarjetas(){
    
    rest_modal('mod_guardar_tarjeta();');

    $("#modal_content").css({"width": "60%"});

    $.post("<?php echo base_url(); ?>index.php/Cnt_tarjetas/get_html_agregar_tarjetas", {suggest: ''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nueva Tarjeta</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            get_clientes_dk();
           

        });
  }

  function btn_actualizar_tarjetas() {

    var row_tarjeta = $('#dg_tarjetas').datagrid('getSelections');
       
    rest_modal('mod_guardar_actualizacion_tarjetas();');

    $("#modal_content").css({"width": "20%"});

    $.post("<?php echo base_url(); ?>index.php/Cnt_tarjetas/get_html_actualizar_tarjetas", {row_tarjeta:row_tarjeta}, function(data){
            
          $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar tarjeta</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

          
      });


  }

  function btn_eliminar_tarjetas(){

    var row_tarjetas = $('#dg_tarjetas').datagrid('getSelections');
    var id_cliente = row_tarjetas[0]['id_cliente'];

    $.post("<?php echo base_url(); ?>index.php/Cnt_tarjetas/eliminar_tarjeta", {id_cliente:id_cliente}, function(data){
          
          if(data == 1){

             consulta_tarjetas('Tarjetas');
             swal('Tarjeta eliminada correctamente');


          }else{
             swal('Error al eliminar tarjeta');
          }

      });

  }

  function buscar(){

    get_tarjetas();
  }

</script>