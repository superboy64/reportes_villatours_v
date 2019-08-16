<div class="row">
	  <div class="col-md-12">
	        
				<div id="div_datagrid" style="height: 90%;">
				       <table id="dg_con_correo_log" style="height: 95%;" data-options="
		                singleSelect:true,
		                autoRowHeight:false,
		                pagination:true,
		                pageSize:50"></table>
				</div>
			
	  </div>

</div>


<script type="text/javascript">
	
    $("#div_txt_asunto").show();
    $("#div_txt_destinatario").show();
    $("#div_btn_guardar").show();
    $("#div_rango_fechas").show();
    $("#div_select_sucursal").show();
    $("#lbl_rango_fecha").text("Fecha envio");

	$("#title").html('<?=$title?>');

	buscar(0);

    function formatField(value){

    	return '<span style="font-size:10px; color:#010101;">'+value+'</span>';
    
    }

    function formatFieldStatus(value){

      var text = '';
      if(value == 1){
        text = 'ENVIADO';
        return '<span style="font-size:10px; color:#51DB2C;">'+text+'</span>';
      }else if(value == 0){
        text = 'ERROR EN EL PROCESO';
        return '<span style="font-size:10px; color:#EC3829;">'+text+'</span>';
      }else if(value == 2){
        text = 'NO ENVIADO';
        return '<span style="font-size:10px; color:#F5BB06;">'+text+'</span>';
      }
      
   
    }

	function get_correos_log(status){
		    
            var sucursal = $("#slc_sucursal").val();
            var asunto = $("#txt_asunto").val();
            var destinatario = $("#txt_destinatario").val();
            var fecha1 = $("#datapicker_fecha1").val();
            var fecha2 = $("#datapicker_fecha2").val();

                $('#dg_con_correo_log').datagrid({
                      url:"<?php echo base_url(); ?>index.php/Cnt_correos/get_correos_log?sucursal="+sucursal+"&asunto="+asunto+"&destinatario"+destinatario+"&fecha1="+fecha1+"&fecha2="+fecha2+"&status="+status,
                      remoteSort:false,
                      columns:[[
                            
                            {field:'id_correo_automatico',title:'id correo automatico',formatter:formatField},
                            {field:'asunto',title:'asunto',formatter:formatField},
                            {field:'destinatario',title:'destinatario',formatter:formatField},
                            {field:'detalle_envio',title:'detalle envio',formatter:formatField},
                            {field:'fecha_envio',title:'fecha envio',formatter:formatField},
                            {field:'status',title:'status',formatter:formatFieldStatus}
                            
                        ]],onLoadSuccess:function(){

                             
                             
                        },onBeforeSortColumn:function(sort,order){
                           
                          
                        
                        },onSortColumn:function(sort,order){
                           
                            
                        
                        }
                }).datagrid('clientPaging');
           

	}

    function buscar(status = 1){

        get_correos_log(status);


    }

</script>
