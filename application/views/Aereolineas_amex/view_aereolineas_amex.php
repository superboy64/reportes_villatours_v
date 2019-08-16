
<div class="row">

	  <div class="col-md-12">
	  
		<button type="button" class="btn btn-default" id="btn_agregar" onclick="btn_agregar_aereolinea();"><span class="fa fa-plus-square" style="color: #20C72C;"></span>&nbsp;Agregar
		</button>

		<button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_aereolinea();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
		</button>

		<button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_aereolinea();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
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
  
	function get_aereolineas(status){

      $('#dg').datagrid({
            url:"<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/get_catalogo_aereolineas_amex_local",
            columns:[[
                  {field:'id_aereolinea',title:'id_aereolinea',formatter:formatField},
                  {field:'id_categoria_aereolinea',title:'id_categoria_aereolinea',formatter:formatField,
                      formatter: function(value,row,index){

                         if(value == 1){

                          var d = '<p style="font-size:10px; color:#010101;">cargo</p>';

                         }else{

                           var d = '<p style="font-size:10px; color:#010101;">bajo costo</p>';

                         }
                
                         return d;
                
                      }
                  },
                  {field:'nombre_aereolinea',title:'nombre_aereolinea',formatter:formatField},
                  {field:'codigo_bsp',title:'codigo_bsp',formatter:formatField},
                  {field:'fecha_alta',title:'fecha_alta',formatter:formatField}
              ]],onLoadSuccess:function(){

                   
                
              },onBeforeSortColumn:function(sort,order){
                 
                
              
              },onSortColumn:function(sort,order){
                 
                  
              
              }
      }).datagrid('clientPaging');
     

	}
	
	function get_html_dks_aereolinea(id_aereolinea){

		rest_modal('');

		$.post("<?php echo base_url(); ?>index.php/Cnt_aereolinea/get_html_dks_aereolinea", {id_aereolinea:''}, function(data){
            
        	$("#modal_body").append(data);
        	$("#modal_footer").hide();
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">DKS</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });

			$('#dg_dks_aereolinea').datagrid({
                url:"<?php echo base_url(); ?>index.php/Cnt_clientes/get_catalogo_dks_aereolineas?id_aereolinea="+id_aereolinea,
                columns:[[
                    {field:'id_cliente',title:'DK',formatter:formatField}
                   
                ]],onLoadSuccess:function(){
                    
                                                 
                }
    		});

     	});

	}

	function btn_agregar_aereolinea(){
		
		rest_modal('guardar_aereolinea();');

		$("#modal_content").css({"width": "50%"});

		$.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/get_html_agregar_aereolinea_amex", {suggest: ''}, function(data){
            
            $("#modal_body").html(data);
            $("#modal_title").html("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Nueva aereolinea</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });
           

        });
	}

	function btn_actualizar_aereolinea() {

		var row_aereolinea = $('#dg').datagrid('getSelections');

    var id_aereolinea = row_aereolinea[0]['id'];

		rest_modal('mod_guardar_actualizacion_aereolineas_amex();');

		$("#modal_content").css({"width": "20%"});

		var row_aereolinea = $('#dg').datagrid('getSelections')

		$.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/get_html_actualizar_aereolinea_amex", {row_aereolinea:row_aereolinea}, function(data){
            
        	$("#modal_body").append(data);
            $("#modal_title").append("<center><h1 style=\"font-family:\'Colfax Medium\';font-weight:normal;font-size:32px\">Actualizar aereolinea</h1></center>");
            $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });


     	});
	}

	function btn_eliminar_aereolinea(){

		var row_aereolinea = $('#dg').datagrid('getSelections');
		var id = row_aereolinea[0]['id'];

		$.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/eliminar_aereolinea_amex", {id:id}, function(data){
	        
	        if(data == 1){
	           swal('Usuario eliminado correctamente');
             consulta_aereolineas('aereolineas AMEX');
	        }else{
	           swal('Error al eliminar usuario');
	        }

	    });

	}
 
 function buscar(status = 1){

    get_aereolineas(status);


 }

</script>

