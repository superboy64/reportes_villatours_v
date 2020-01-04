
<div class="row">

	  <div class="col-md-12">
	  
		<button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_udids();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
		</button>

		<button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_udids();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
		</button>

		<button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_udids();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
		</button>

	  </div>
	  <div class="col-md-12">
	        
				<div id="div_datagrid" style="height: 90%;">
				       <table id="dg" style="height: 95%;" sortName="id_aereolinea" sortOrder="asc" data-options=" singleSelect:true,
                    autoRowHeight:false,
                    pagination:true,
                    pageList: [500,1000,2000,3000],
                    pageSize:500
		                "></table>
				</div>
			
	  </div>

</div>

<script type="text/javascript">
	
  $("#div_select_search_nombre_aereolinea").show();
  $("#div_select_search_aereolinea").show();
  $("#div_select_search_departamento").show();
  $("#div_rango_fechas").show();
  $("#div_btn_guardar").show();
  
	$("#title").html('<?=$title?>');

  buscar(0);

  function formatField(value){

   	return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    
  }
  
	function get_udids(status){

      $('#dg').datagrid({
            url:"<?php echo base_url(); ?>index.php/Cnt_egencia_udids_ac/get_catalogo_udids_ac",
            columns:[[
                  {field:'id',title:'id',formatter:formatField},
                  {field:'cliente',title:'cliente',formatter:formatField},
                  {field:'analisis',title:'analisis',formatter:formatField},
              ]],onLoadSuccess:function(){

                   
                
              },onBeforeSortColumn:function(sort,order){
                 
                
              
              },onSortColumn:function(sort,order){
                 
                  
              
              }
      }).datagrid('clientPaging');
     

	}

	function btn_agregar_udids(){
		
		rest_modal('mod_guardar_analisis_cliente();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_egencia_udids_ac/get_html_agregar_udids", {suggest: ''}, function(data){
            
            $("#modal_body").html(data);
            $("#modal_title").html("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nuevo UDID</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });
            get_clientes_dk();
            get_analisis_cliente();
           

        });
	}

	function btn_actualizar_udids() {

		var row_ac = $('#dg').datagrid('getSelections');

    	var id_ac = row_ac[0]['id'];

		rest_modal('mod_guardar_actualizacion_ac();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_egencia_udids_ac/get_html_actualizar_udids", {id_ac:id_ac}, function(data){
            
        	$("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar UDID</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });


     	});
	}

	function btn_eliminar_udids(){

		var row_ac = $('#dg').datagrid('getSelections');
		var id_cliente = row_ac[0]['cliente'];

		$.post("<?php echo base_url(); ?>index.php/Cnt_egencia_udids_ac/eliminar_udids", {id_cliente:id_cliente}, function(data){
	        
	        if(data == 1){
	           swal('AC eliminado correctamente');
               consulta_egencia_udids_ac('UDIDS');
	        }else{
	           swal('Error al eliminar AC');
	        }

	    });

	}
 
 function buscar(status = 1){

    get_udids(status);


 }

</script>

