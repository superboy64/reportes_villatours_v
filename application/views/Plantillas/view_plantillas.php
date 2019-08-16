<div class="row">

	  <div class="col-md-12">
	  
		<button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_plantilla();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
		</button>

		<button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_plantilla();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
		</button>

		<button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_plantilla();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
		</button>
			
	  </div>
	  <div class="col-md-12">
	        
				<div id="div_datagrid" style="height: 90%;">
				       <table id="dg_platilla" style="height: 95%;" sortName="id" sortOrder="asc" data-options="
		                singleSelect:true,
		                autoRowHeight:false,
		                pagination:true,
		                pageSize:50"></table>
				</div>
			
	  </div>

</div>

<script type="text/javascript">
	
	$("#div_select_search_plantilla").show();
	$("#div_btn_guardar").show();

	$("#title").html('<?=$title?>');

	buscar(0);

    function formatField(value){

    	return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    
    }

	function get_plantillas(status){
		
	var plantilla = $("#slc_search_plantilla").val();
    var parametros = {};

    parametros['plantilla'] = plantilla;

    	$.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/get_catalogo_plantillas", {parametros:parametros,status:status}, function(data){
                
	      data = JSON.parse(data);

	      $('#dg_platilla').datagrid({
	            url:"#",
	            data:data,
	            remoteSort:false,
	            columns:[[

                    {field:'id',title:'Id',formatter:formatField,sortable:true},
                    {field:'id_rep',title:'Id rep',formatter:formatField,sortable:true},
                    {field:'id_us',title:'Id us',formatter:formatField,sortable:true},
                 
                    {field:'nombre',title:'Nombre',formatter:formatField,sortable:true},
                    {field:'fecha_alta',title:'Fecha Alta',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',formatter:formatField}
                    
                ]],onLoadSuccess:function(){

                     
                  
                },onBeforeSortColumn:function(sort,order){
                   
                  
                
                },onSortColumn:function(sort,order){
                   
                    
                
                }
	      }).datagrid('clientPaging');
	     
	    });


	}
	

	function btn_agregar_plantilla(){
		
		rest_modal('mod_guardar_plantilla();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/get_html_agregar_plantilla", {suggest: ''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nueva plantilla</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });
           

        });
	}

	function btn_actualizar_plantilla() {
		
		var row_plantilla = $('#dg_platilla').datagrid('getSelections');

        var id_plantilla = row_plantilla[0]['id'];
        var id_rep = row_plantilla[0]['id_rep'];
        var id_us = row_plantilla[0]['id_us'];
        var nombre = row_plantilla[0]['nombre'];
       
		rest_modal('mod_guardar_actualizacion_plantilla();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/get_html_actualizar_plantilla", {row_plantilla:row_plantilla}, function(data){
            
        	$("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar plantilla</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

            $("#txt_nombre_act").val(nombre);

            $("#slc_reporte_act option[value="+ id_rep +"]").attr("selected",true);

            $("#txt_hidden_id_plant").val(id_plantilla);
            $("#txt_hidden_id_us").val(id_us);

             get_columnas_seleccionadas(id_plantilla,id_rep,id_us);

     	});


	}

	function btn_eliminar_plantilla(){

		var row_plantilla = $('#dg_platilla').datagrid('getSelections');
		var id_plantilla = row_plantilla[0]['id'];

		$.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/eliminar_plantilla", {id_plantilla:id_plantilla}, function(data){
	        
	        if(data == 1){
	           $('#dg').datagrid('reload');
	           swal('Plantilla eliminada correctamente');

	           consulta_plantillas('Plantillas');

	        }else{
	           swal('Error al eliminar plantilla');
	        }

	    });

	}

	function buscar(status = 1){

      get_plantillas(status);


    }

</script>