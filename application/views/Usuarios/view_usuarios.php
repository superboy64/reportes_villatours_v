<div class="row">

	  <div class="col-md-12">
	  
		<button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_usuario();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
		</button>

		<button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_usuario();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
		</button>

		<button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_usuario();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
		</button>

		<button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_accesos();"><span class="fa fa-universal-access" style="color: #20C72C;"></span>&nbsp;Accesos
		</button>
			
	  </div>
	  <div class="col-md-12">
	        
				<div id="div_datagrid" style="height: 90%;">
				       <table id="dg" style="height: 95%;" sortName="id" sortOrder="asc" data-options="
		                singleSelect:true,
		                autoRowHeight:false,
		                pagination:true,
		                pageSize:20"></table>
				</div>
			
	  </div>

</div>

<script type="text/javascript">
	
  $("#div_select_search_nombre_usuario").show();
  $("#div_select_search_usuario").show();
  $("#div_select_search_departamento").show();
  $("#div_select_sucursal").show();
  $("#div_btn_guardar").show();
  
	$("#title").html('<?=$title?>');

  buscar(0);

  function formatField(value){

   	return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    
  }
  

	function get_usuarios(status){

    var sucursal = $("#slc_sucursal").val();
    var nombre_usuario = $("#slc_search_nombre_usuario").val();
    var usuario = $("#slc_search_usuario").val();
    var departamento = $("#slc_search_departamento").val();
    var parametros = {};  

      $('#dg').datagrid({
            url:"<?php echo base_url(); ?>index.php/Cnt_usuario/get_catalogo_usuarios?sucursal="+sucursal+"&nombre_usuario="+nombre_usuario+"&usuario="+usuario+"&departamento="+departamento+"&status="+status,
            remoteSort:false,
            columns:[[
                  {field:'id',title:'Id',formatter:formatField,sortable:true,hidden:true},
                  {field:'id_sucursal',title:'Sucursal',formatter:formatField,sortable:true/*,hidden:true*/},
                  {field:'nombre',title:'Nombre',formatter:formatField,sortable:true},
                  {field:'usuario',title:'Usuario',formatter:formatField,sortable:true},
                  {field:'id_perfil',title:'Id_perfil',hidden:true,formatter:formatField,sortable:true},
                  {field:'perfil',title:'Departameento',formatter:formatField,sortable:true},
                  {field:'fecha_alta',title:'Fecha Alta',formatter:formatField,sortable:true},
                  {field:'status',title:'Status',formatter:formatField},
                  {field:'action',title:'Acciones',formatter:formatField,
                      formatter: function(value,row,index){

                         var d = '<a href="javascript:void(0)" onclick="get_html_dks_usuario('+row['id']+')">ver DKS</a>';
                   
                         return d;
                      }
                  }
              ]],onLoadSuccess:function(){

                   
                
              },onBeforeSortColumn:function(sort,order){
                 
                
              
              },onSortColumn:function(sort,order){
                 
                  
              
              }

      }).datagrid('clientPaging');
     
    

	}
	
	function get_html_dks_usuario(id_usuario){

		rest_modal('');

		$.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_html_dks_usuario", {id_usuario:''}, function(data){
            
        	$("#modal_body").append(data);
        	$("#modal_footer").hide();
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">DKS</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

			$('#dg_dks_usuario').datagrid({
                url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_catalogo_dks_usuarios?id_usuario="+id_usuario,
                columns:[[
                    {field:'id_cliente',title:'DK',formatter:formatField}
                   
                ]],onLoadSuccess:function(){
                    
                                                 
                }
    		});

     	});

	}

	function btn_agregar_usuario(){
		
		rest_modal('mod_guardar_usuario();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_html_agregar_usuario", {suggest: ''}, function(data){
            
            $("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nuevo usuario</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });
           

        });
	}

	function btn_accesos(){

    var nombre_usuario = $("#slc_search_nombre_usuario").val();
    var usuario = $("#slc_search_usuario").val();
    var departamento = $("#slc_search_departamento").val();
    var fecha1 = $("#datapicker_fecha1").val();
    var fecha2 = $("#datapicker_fecha2").val();

		$.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_html_accesos", {nombre_usuario: nombre_usuario,usuario:usuario,departamento:departamento,fecha1:fecha1,fecha2:fecha2}, function(data){
            
            $("#modal_content_accesos").css({"width": "50%"});
            $("#modal_body_accesos").html(data);
            $("#modal_title_accesos").html("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Accesos</h1></center>");
            $('#myModal_accesos').modal({
                      backdrop: false,
                      show: true
                    });
           
        });

	}

	function btn_actualizar_usuario() {

		var row_usuario = $('#dg').datagrid('getSelections');

    var id_usuario = row_usuario[0]['id'];

		rest_modal('mod_guardar_actualizacion();');

		$("#modal_content").css({"width": "50%"});

		var row_usuario = $('#dg').datagrid('getSelections')

		$.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_html_actualizar_usuario", {row_usuario:row_usuario}, function(data){
            
        	$("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar usuario</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

             get_catalogo_dks_seleccionados(id_usuario);

     	});
	}

	function btn_eliminar_usuario(){

		var row_usuario = $('#dg').datagrid('getSelections');
		var id_usuario = row_usuario[0]['id'];

		$.post("<?php echo base_url(); ?>index.php/Cnt_usuario/eliminar_usuario", {id_usuario:id_usuario}, function(data){
	        
	        if(data == 1){
	           $('#dg').datagrid('reload');
	           swal('Usuario eliminado correctamente');
	        }else{
	           swal('Error al eliminar usuario');
	        }

	    });

	}
 
 function buscar(status = 1){

    get_usuarios(status);


 }

</script>

