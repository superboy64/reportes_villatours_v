<div class="row">

	  <div class="col-md-12">
	  
		<button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_precompra();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
		</button>

		<button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_precompra();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
		</button>

		<button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_precompra();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
		</button>
			
	  </div>
	  <div class="col-md-12">
	        
				<div id="div_datagrid" style="height: 90%;">
				       <table id="dg_precompra" style="height: 95%;" sortName="id" sortOrder="asc" data-options="
		                singleSelect:true,
		                autoRowHeight:false,
		                pagination:true,
		                pageSize:50"></table>
				</div>
			
	  </div>

</div>

<script type="text/javascript">
	
	$("#div_cliente_precompra").show();
	$("#div_btn_guardar").show();

	$("#title").html('<?=$title?>');

	get_precompra();

    function formatField(value){

    	return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    
    }

	function get_precompra(){
		
	var precompra = $("#slc_search_plantilla").val();
    var parametros = {};

    parametros['precompra'] = precompra;

    	$.post("<?php echo base_url(); ?>index.php/Cnt_precompra/get_catalogo_precompra", {parametros:parametros}, function(data){
                
	      data = JSON.parse(data);
	      
	      $('#dg_precompra').datagrid({
	            url:"#",
	            data:data,
	            columns:[[

                
                    {field:'id_cliente',title:'Id cliente',formatter:formatField,sortable:true},
                    {field:'rango_dias',title:'Rango de dias',formatter:formatField,sortable:true},
                    {field:'fecha_alta',title:'Fecha Alta',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',formatter:formatField}


                    
                ]],onLoadSuccess:function(){

                     
                  
                },onBeforeSortColumn:function(sort,order){
                   
                  
                
                },onSortColumn:function(sort,order){
                   
                    
                
                }
	      }).datagrid('clientPaging');
	     
	    });


	}
	

	function btn_agregar_precompra(){
		
		rest_modal('mod_guardar_precompra();');

		$("#modal_content").css({"width": "60%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_precompra/get_html_agregar_precompra", {suggest: ''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nueva precompra</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            get_clientes_dk();
           

        });
	}

	function btn_actualizar_precompra(){

		var row_precompra = $('#dg_precompra').datagrid('getSelections');
       
		rest_modal('mod_guardar_actualizacion_precompra();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_precompra/get_html_actualizar_precompra", {row_precompra:row_precompra}, function(data){
            
        	$("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar precompra</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

          
     	});


	}

	function btn_eliminar_precompra(){

		var row_precompra = $('#dg_precompra').datagrid('getSelections');
		var id_precompra = row_precompra[0]['id'];

		$.post("<?php echo base_url(); ?>index.php/Cnt_precompra/eliminar_precompra", {id_precompra:id_precompra}, function(data){
	        
	        if(data == 1){
	           $('#dg').datagrid('reload');
	           swal('Precompra eliminada correctamente');

	           consulta_precompra('Precompra');

	        }else{
	           swal('Error al eliminar precompra');
	        }

	    });

	}

	function buscar(){

		get_precompra();
	}

</script>