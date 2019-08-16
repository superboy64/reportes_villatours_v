
<?php 

//print_r($nombre_usuario);

          /*$nombre_usuario = $this->input->post('nombre_usuario');
          $usuario = $this->input->post('usuario');
          $departamento = $this->input->post('departamento');
          $fecha1 = $this->input->post('fecha1');
          $fecha2 = $this->input->post('fecha2');*/

?>
<div class="row" style="overflow-x: auto;">
 
				       
	       <center><table id="dg_accesos" style="width:800px; height: 400px;" sortName="id" sortOrder="asc" data-options="
		                singleSelect:true,
		                autoRowHeight:false,
		                pagination:true,
		                pageSize:50"></table></center>


	

</div>


<script type="text/javascript">

	get_accesos();
	
	function get_accesos(){

        var nombre_usuario = "<?php  echo $nombre_usuario;?>";
        var usuario = "<?php  echo $usuario;?>";
        var departamento = "<?php  echo $departamento;?>";
        var fecha1 = "<?php  echo $fecha1;?>";
        var fecha2 = "<?php  echo $fecha2;?>";

        var parametros = {};
        parametros['nombre_usuario'] = nombre_usuario;
        parametros['usuario'] = usuario;
        parametros['departamento'] = departamento;
        parametros['fecha1'] = fecha1;
        parametros['fecha2'] = fecha2;

        $.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_accesos", {parametros:parametros}, function(data){
                
          data = JSON.parse(data);

          $('#dg_accesos').datagrid({
                url:"#",
                data:data,
                remoteSort:false,
                columns:[[
                    {field:'id',title:'Id',formatter:formatField,sortable:true},
                    {field:'id_sucursal',title:'Id sucursal',formatter:formatField,sortable:true},
                    {field:'id_usuario',title:'Id usuario',formatter:formatField,sortable:true},
                    {field:'usuario_ingresado',title:'Usuario ingresado',formatter:formatField,sortable:true},
                    {field:'nombre_usuario',title:'Nombre',formatter:formatField,sortable:true},
                    {field:'departamento',title:'Departamento',formatter:formatField,sortable:true},
                    {field:'ip_acceso',title:'IP PC',formatter:formatField,sortable:true},
                    {field:'fecha_alta',title:'Fecha',formatter:formatField,sortable:true},
                    {field:'status',title:'Status',formatter:formatField,sortable:true},
                  ]],onLoadSuccess:function(){

                       
                    
                  },onBeforeSortColumn:function(sort,order){
                     
                    
                  
                  },onSortColumn:function(sort,order){
                     
                      
                  
                  }

          }).datagrid('clientPaging');
        

        });

	}


</script>