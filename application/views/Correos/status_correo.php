<script src="<?php echo base_url(); ?>referencias/chartjs/dist/Chart.bundle.js"></script>
<script src="<?php echo base_url(); ?>referencias/Chartjs/utils.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>referencias/multi_select/css/bootstrap-multiselect.css">

<style type="text/css">
	body {
	  background-image: url("<?php echo base_url(); ?>referencias/img/email.png");
	  background-position: center; /* Center the image */
	  background-repeat: no-repeat; /* Do not repeat the image */
	  background-size: cover; /* Resize the background image to cover the entire container */
	}
</style>

<div class="row">
	<div class="col-md-12">
	            
	                <div id="div_datagrid" style="height: 80%;overflow-x: auto;">
	      			
	                </div>

					<h2><center><label id="status_operacion">Status: En linea</label></center></h2>
					<h2><center><label id="envio_actual">Validando existencia de correos...</label></center></h2>
				     
	</div>
</div>

<?php  set_time_limit(0); ?>

<script type="text/javascript">

  setInterval("validar()", 9000);  //9 segundos
  var cont = 0;
  function validar(){

    $.post("<?php echo base_url(); ?>index.php/Cnt_correos/validar_status_gen_archivo", {}, function(data){ 
 
        	  if(data != ''){

        	   data = JSON.parse(data);

        	   	 parametros_correo = {};
        		 parametros_correo['destinatario']= data[0]['destinatario'];
        		 parametros_correo['copia']= data[0]['copia'];
        		 parametros_correo['asunto']= data[0]['asunto'];
				 parametros_correo['mensaje']= data[0]['mensaje'];
				 parametros_correo['id_correo_automatico']= data[0]['id'];
				 parametros_correo['tipo_msn']= data[0]['tipo_msn'];

				 var id_correo_automatico = data[0]['id'];
				 var id_usuario = data[0]['id_usuario'];
				 var id_intervalo = data[0]['id_intervalo'];
				 var fecha_ini_proceso = data[0]['fecha_ini_proceso'];

        	   	 		$.post("<?php echo base_url(); ?>index.php/Cnt_filtros/obtener_filtros_correos_aut", {id_correo_automatico:id_correo_automatico}, function(post_filtro){
		                 	

		                 	post_filtro = JSON.parse(post_filtro);

		                 	total_rep = post_filtro.length;
		                 	
		                    var reportes_array = [];
							

		                    $.each(post_filtro, function( index, value ) {  
		                  	   
  										var id_reporte = value['id_rep'];
  										var filtro_rep = value['filtro_rep'];
  										filtro_rep = filtro_rep.split('/XX');
  										
  										var array_filter = [];

						                       $.each(filtro_rep, function( index, value ) {

						                          var da = value.split('___');
						                          array_filter[da[0]]= da[1];

						                       });
						                     

			                       		if(id_reporte == 3 || id_reporte == 4 || id_reporte == 5 || id_reporte == 6 || id_reporte == 8 || id_reporte == 12 || id_reporte == 13 || id_reporte == 14  || id_reporte == 15|| id_reporte == 16 || id_reporte == 17 || id_reporte == 18 || id_reporte == 19 || id_reporte == 20 || id_reporte == 22 || id_reporte == 23 || id_reporte == 24 || id_reporte == 25 || id_reporte == 26 || id_reporte == 34 || id_reporte == 35 || id_reporte == 36 || id_reporte == 37 || id_reporte == 38){

			                       			
						                       var fecha1 = array_filter['fil_fecha1'];
						                       var fecha2 = array_filter['fil_fecha2'];


						                       var id_cliente = array_filter['fil_id_cliente'];
						                       //var id_corporativo = array_filter['fil_id_corporativo'];

						                       //----------select multiple cliente

						                       var string_mult_id_suc = "";
						                       if(array_filter['fil_mult_id_suc'] != undefined){

						                       	var mult_id_suc = array_filter['fil_mult_id_suc'];

						                       	    mult_id_suc = mult_id_suc.split('###');
						                         	
						                         	 $.each(mult_id_suc, function( index, value ) {  //recorre ids de clientes dinamicamente


						                         	 	string_mult_id_suc = string_mult_id_suc + value + "_";
						                          		

						                      		 });


						                        }

						                        var id_suc = string_mult_id_suc;

						                       //----------select multiple cliente
						                       	var mult_id_cliente = array_filter['fil_mult_id_cliente'];

						                       	    mult_id_cliente = mult_id_cliente.split('##');
						                         	
						                         	 var string_mult_id_cliente = "";

						                         	 $.each(mult_id_cliente, function( index, value ) {  //recorre ids de clientes dinamicamente


						                         	 	string_mult_id_cliente = string_mult_id_cliente + value + "_";
						                          		

						                      		 });

						                        var id_cliente = string_mult_id_cliente;
						                        //----------select multiple serie
						                       	var mult_id_serie = array_filter['fil_mult_id_serie'];

						                       	    mult_id_serie = mult_id_serie.split('###');
						                         	
						                         	 var string_mult_id_serie = "";

						                         	 $.each(mult_id_serie, function( index, value ) {  //recorre ids de clientes dinamicamente


						                         	 	string_mult_id_serie = string_mult_id_serie + value + "_";
						                          		

						                      		 });

						                        var id_serie = string_mult_id_serie;


						                        if(id_reporte == 8 || id_reporte == 15 || id_reporte == 20){

						                        	//----------select multiple servicio ae
							                       	var mult_id_servicio = array_filter['fil_mult_id_servicio_ae'];

							                       	    mult_id_servicio = mult_id_servicio.split('####');
							                         	
							                         	 var string_mult_id_servicio = "";

							                         	 $.each(mult_id_servicio, function( index, value ) {  //recorre ids de clientes dinamicamente


							                         	 	string_mult_id_servicio = string_mult_id_servicio + value + "_";
							                          		

							                      		 });

							                        var id_servicio = string_mult_id_servicio;



						                        }else if(id_reporte == 12 || id_reporte == 13 || id_reporte == 16 || id_reporte == 17){


						                        	var id_servicio = array_filter['fil_unic_id_servicio'];


						                        }else{

						                        	 //----------select multiple servicio
							                       	var mult_id_servicio = array_filter['fil_mult_id_servicio'];

							                       	    mult_id_servicio = mult_id_servicio.split('####');
							                         	
							                         	 var string_mult_id_servicio = "";

							                         	 $.each(mult_id_servicio, function( index, value ) {  //recorre ids de clientes dinamicamente
							                         	 	
							                         	 	string_mult_id_servicio = string_mult_id_servicio + value + "_";							                          		
							                         	 	
							                      		 });

							                        var id_servicio = string_mult_id_servicio;


						                        }
						                       

						                        //----------select multiple provedor
						                       	var mult_id_provedor = array_filter['fil_mult_id_provedor'];

						                       	    mult_id_provedor = mult_id_provedor.split('#####');
						                         	
						                         	 var string_mult_id_provedor = "";

						                         	 $.each(mult_id_provedor, function( index, value ) {  //recorre ids de clientes dinamicamente


						                         	 	string_mult_id_provedor = string_mult_id_provedor + value + "_";
						                          		

						                      		 });

						                        var id_provedor = string_mult_id_provedor;
						                        //----------select multiple corporativo
						                       	var mult_id_corporativo = array_filter['fil_mult_id_corporativo'];

						                       	    mult_id_corporativo = mult_id_corporativo.split('######');
						                         	
						                         	 var string_mult_id_corporativo = "";

						                         	 $.each(mult_id_corporativo, function( index, value ) {  //recorre ids de clientes dinamicamente


						                         	 	string_mult_id_corporativo = string_mult_id_corporativo + value + "_";
						                          		

						                      		 });


						                       var id_corporativo = string_mult_id_corporativo;


						                       //-----------id_plantilla

						                       var id_plantilla =  array_filter['fil_id_plantilla'];

			
						                       var parametros = id_suc+','+id_serie+','+id_cliente+','+id_servicio+','+id_provedor+','+id_corporativo+','+id_plantilla+','+fecha1+','+fecha2+','+id_correo_automatico+','+id_reporte+','+id_usuario+','+id_intervalo+','+fecha_ini_proceso;



						                }

						                var str_fecha = fecha1+'_'+fecha2;
						             
						                var tipo_archivo = array_filter['fil_tipo_archivo'];

						                //reportes_array.push(value['id_rep']+'**'+tipo_archivo+'**'+str_fecha);

						                reportes_array[value['id_rep']] =  value['id_rep']+'**'+tipo_archivo+'**'+str_fecha;

						                

						                if(tipo_archivo == 1){

						                	archivos_excel(parametros,parametros_correo,reportes_array,tipo_archivo,id_reporte,id_correo_automatico,id_servicio,id_intervalo,fecha_ini_proceso);


						                }
						                if(tipo_archivo == 2){


											graficas(parametros,parametros_correo,reportes_array,tipo_archivo,id_reporte,id_correo_automatico,id_servicio,id_intervalo,fecha_ini_proceso);


						                }
						                if(tipo_archivo == 3){


						                	excel_graficas(parametros,parametros_correo,reportes_array,tipo_archivo,id_reporte,id_correo_automatico,id_servicio,id_intervalo,fecha_ini_proceso);


						                }
									    

			                 			
			                       });

		                    	  
		                    
		                 }).fail(function(error) { 
		                 	
		                 	
		                 	$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error en codigo 1',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		               

		                 });

        	  }

          });


  }


function enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico){

	$("#envio_actual").html("Generando correo");

	$.post("<?php echo base_url(); ?>index.php/Cnt_correos/enviar_correo", {parametros_correo:parametros_correo}, function(data){
						

						cont = 0; //termina el proceso y resetea el contador
							
						if(data == 1){

							var detalle = 'correo enviado exitosamente';
							var status = 1;

							$("#envio_actual").html(detalle);
						
						}else{
							
							var detalle = data;
							var status = 0;
							$("#envio_actual").html(detalle);
						}


					    $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:detalle,status:status,id_correo_automatico}, function(data){

						});
						
						$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){ 
							$("#envio_actual").html('Validando existencia de correos...');
		 				});
						

				   }).fail(function(error) { 

				   		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error al enviar correo',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
										$("#envio_actual").html('Validando existencia de correos...');
		 							});
							
							});

		              
				    });

}

function archivos_excel(parametros,parametros_correo,reportes_array,tipo_archivo,id_reporte,id_correo_automatico,id_servicio,id_intervalo,fecha_ini_proceso){

	//reportes_array = reportes_array.unique();

	parametros_correo['reportes']= reportes_array;
  	parametros_correo['tipo_archivo']= tipo_archivo;
  	parametros_correo['id_reporte']= id_reporte;
  	parametros_correo['id_intervalo']= id_intervalo;
  	parametros_correo['fecha_ini_proceso']= fecha_ini_proceso;

	if(id_reporte == 3){

		 $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/exportar_excel_usuario", {parametros:parametros,tipo_funcion:"aut"}, function(data){
				

	   			cont++;

				parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

	            if(total_rep == cont){

	           
	        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
	        	  	

	        	  
	        	}
									                   	 
		 }).fail(function(error) {

		 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 3',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		                 	//alert(error.responseJSON);

		  });

	}else if(id_reporte == 4){


		var clientes = parametros.split(",");
		clientes = clientes[1];

		clientes = clientes.split('_');

		clientes = clientes.filter(Boolean); // [foo, blue, 5]

		//if(clientes.length == 0){

			$.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador/exportar_excel_usuario_masivo", {parametros:parametros,tipo_funcion:"aut"}, function(data){
					
					

		   			cont++;
		   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
		            if(total_rep == cont){
		            
		            //*****************envio de correo************************
		        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
		        	//*******************************************************

		        	  
		        	}
										                   	 
			 }).fail(function(error) { 

			 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 4',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
								
								});

			                 	//alert(error.responseJSON);

			  });



	}else if(id_reporte == 34){


		var clientes = parametros.split(",");
		clientes = clientes[1];

		clientes = clientes.split('_');

		clientes = clientes.filter(Boolean); // [foo, blue, 5]

		//if(clientes.length == 0){

			$.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador_net/exportar_excel_usuario", {parametros:parametros,tipo_funcion:"aut"}, function(data){
					
					

		   			cont++;
		   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
		            if(total_rep == cont){
		            
		            //*****************envio de correo************************
		        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
		        	//*******************************************************

		        	  
		        	}
										                   	 
			 }).fail(function(error) { 

			 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 4',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
								
								});

			                 	//alert(error.responseJSON);

			  });



	}else if(id_reporte == 5){
		//alert("entra al reporte con id 5");
		$.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_layout_seg/exportar_excel_rep_layout_segmentado", {parametros:parametros,tipo_funcion:"aut"}, function(data){
				
							                   			
	   			
	   			cont++;
	   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            if(total_rep == cont){
	            
	            //*****************envio de correo************************
	        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
	        	//*******************************************************

	        	  
	        	}
									                   	 
		 }).fail(function(error) { 

		 	$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 5',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		                 	//alert(error.responseJSON);

		 });


	}else if(id_reporte == 6){
		
		$.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ficosa/exportar_excel_rep_ficosa", {parametros:parametros,tipo_funcion:"aut"}, function(data){
				
				
	   			cont++;
	   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            if(total_rep == cont){
	            	
	            //*****************envio de correo************************
	        	  	

	        	    enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
	        	//*******************************************************

	        	  
	        	}
									                   	 
		 }).fail(function(error) { 

		 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 6',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		                 	//alert(error.responseJSON);
		  });


	}else if(id_reporte == 8){
		
		 $("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae/get_grafica_provedor",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut"},
                    success: function (data) {

                        data = JSON.parse(data);

                        var arr_dat_BD = data['dat_BD'];
                        var arr_dat_BI = data['dat_BI'];


                        var arr_dom = [];
                        var arr_int = [];
                        var arr_prov = [];

                        $.each(data['grafica'], function( index, value ) {

                          arr_dom.push(value['BOL_DOM']);
                          arr_int.push(value['BOL_INT']);
                          arr_prov.push(value['ID_PROVEDOR']);
                        
                        });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {

                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            					
	            					if(total_rep == cont){

                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}

                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 8',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

                        var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                              type: 'bar',
                              data: {
                                labels: arr_prov,
                                datasets: [
                                  {
                                    label: "Boletos Domesticos",
                                    backgroundColor: "#1f497d",
                                    data: arr_dom
                                  }, {
                                    label: "Boletos Internacionales",
                                    backgroundColor: "#98DCFB",
                                    data: arr_int
                                  }
                                ]
                              },
                              options: {
                                scales: { 
                                  xAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }], 
                                  yAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }]
                                }, 
                                title: {
                                  display: false,
                                  text: 'Population growth (millions)'
                                },
                                animation: {
                                  onComplete: done
                                }
                              }
                          });

                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_provedor',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });
	        	
	 }else if(id_reporte == 12){
		 
		 $("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_ae/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {

                        data = JSON.parse(data);

                        var arr_dat_BD = data['dat_BD'];
                        var arr_dat_BI = data['dat_BI'];

                        var arr_dom = [];
                        var arr_int = [];
                        var arr_pax = [];

                        $.each(data['grafica'], function( index, value ) {

                          arr_dom.push(value['BOL_DOM']);
                          arr_int.push(value['BOL_INT']);
                          arr_pax.push(value['NOMBRE_PAX']);
                        
                        });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_ae/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {

                              		
                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            					if(total_rep == cont){
	            							
                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}
                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 8',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

						var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                              type: 'horizontalBar',
                              data: {
                                labels: arr_pax,
                                datasets: [
                                  {
                                    label: "Boletos Domesticos",
                                    backgroundColor: "#1f497d",
                                    data: arr_dom
                                  }, {
                                    label: "Boletos Internacionales",
                                    backgroundColor: "#98DCFB",
                                    data: arr_int
                                  }
                                ]
                              },
                              options: {
                                title: {
                                  display: false,
                                  text: 'Population growth (millions)'
                                },
                                scales: {
                                  xAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }], 
                                  yAxes: [{
                                    stacked: true,
                                    gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                  }]
                                },
                                animation: {
                                  onComplete: done
                                }
                              }
                          });

                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_pasajero',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });
	        	
	 }else if(id_reporte == 13){
		
		 $("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_rut/get_grafica_rutas",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {

                        data = JSON.parse(data);

                        var arr_dat_BD = data['dat_BD'];
                        var arr_dat_BI = data['dat_BI'];

                        var arr_dom = [];
                        var arr_int = [];
                        var arr_pax = [];

                        $.each(data['grafica'], function( index, value ) {

                          arr_dom.push(value['BOL_DOM']);
                          arr_int.push(value['BOL_INT']);
                          arr_pax.push(value['GVC_RUTA']);
                        
                        });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_rut/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {

                              		

                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

	            					if(total_rep == cont){
	            						
                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}

                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 8',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

						var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                              type: 'horizontalBar',
                              data: {
                                labels: arr_pax,
                                datasets: [
                                  {
                                    label: "Boletos Domesticos",
                                    backgroundColor: "#1f497d",
                                    data: arr_dom
                                  }, {
                                    label: "Boletos Internacionales",
                                    backgroundColor: "#98DCFB",
                                    data: arr_int
                                  }
                                ]
                              },
                              options: {
                                title: {
                                  display: false,
                                  text: 'Population growth (millions)'
                                },
                                scales: {
                                  xAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }], 
                                  yAxes: [{
                                    stacked: true,
                                    gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                  }]
                                },
                                animation: {
                                  onComplete: done
                                }
                              }
                          });

                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_rutas',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });
	        	
	 }else if(id_reporte == 14){ 

	 	
	 	$.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_consumo/exportal_excel_detalle_consumo", {parametros:parametros,tipo_funcion:"aut"}, function(data){
				
				
	   			cont++;

				parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
				
	            if(total_rep == cont){
	            
	        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);

	        	}
									                   	 
		 }).fail(function(error) {

		 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 14',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		                 	//alert(error.responseJSON);

		  });



	 }else if(id_reporte == 15){ //nuevo


	 	 $("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae_net/get_grafica_provedor",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut"},
                    success: function (data) {

                        data = JSON.parse(data);

                        var arr_dat_BD = data['dat_BD'];
                        var arr_dat_BI = data['dat_BI'];

                        $("#div_datagrid_html").empty();

                        var arr_dom = [];
                        var arr_int = [];
                        var arr_prov = [];

                        $.each(data['grafica'], function( index, value ) {

                          arr_dom.push(value['BOL_DOM']);
                          arr_int.push(value['BOL_INT']);
                          arr_prov.push(value['ID_PROVEDOR']);
                        
                        });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae_net/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {
                              		
                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            					if(total_rep == cont){
	            							
                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}

                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 8',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

                        var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                              type: 'bar',
                              data: {
                                labels: arr_prov,
                                datasets: [
                                  {
                                    label: "Boletos Domesticos",
                                    backgroundColor: "#1f497d",
                                    data: arr_dom
                                  }, {
                                    label: "Boletos Internacionales",
                                    backgroundColor: "#98DCFB",
                                    data: arr_int
                                  }
                                ]
                              },
                              options: {
                                scales: { 
                                  xAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }], 
                                  yAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }]
                                }, 
                                title: {
                                  display: false,
                                  text: 'Population growth (millions)'
                                },
                                animation: {
                                  onComplete: done
                                }
                              }
                          });

                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_provedor',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });


	 }else if(id_reporte == 16){     // fin else reporte 15

	 	$("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_ae_net/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {

                        data = JSON.parse(data);

                        var arr_dat_BD = data['dat_BD'];
                        var arr_dat_BI = data['dat_BI'];

                        $("#div_datagrid_html").empty();

                        var arr_dom = [];
                        var arr_int = [];
                        var arr_pax = [];

                        $.each(data['grafica'], function( index, value ) {

                          arr_dom.push(value['BOL_DOM']);
                          arr_int.push(value['BOL_INT']);
                          arr_pax.push(value['NOMBRE_PAX']);
                        
                        });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_ae_net/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {
                              			
                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            					if(total_rep == cont){
	            						
                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}

                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 8',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

						var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                              type: 'horizontalBar',
                              data: {
                                labels: arr_pax,
                                datasets: [
                                  {
                                    label: "Boletos Domesticos",
                                    backgroundColor: "#1f497d",
                                    data: arr_dom
                                  }, {
                                    label: "Boletos Internacionales",
                                    backgroundColor: "#98DCFB",
                                    data: arr_int
                                  }
                                ]
                              },
                              options: {
                                title: {
                                  display: false,
                                  text: 'Population growth (millions)'
                                },
                                scales: {
                                  xAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }], 
                                  yAxes: [{
                                    stacked: true,
                                    gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                  }]
                                },
                                animation: {
                                  onComplete: done
                                }
                              }
                          });

                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_pasajero',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });




	 }else if(id_reporte == 17){ 

	 	  $("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_rut_net/get_grafica_rutas",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {

                        data = JSON.parse(data);

                        var arr_dat_BD = data['dat_BD'];
                        var arr_dat_BI = data['dat_BI'];

                        $("#div_datagrid_html").empty();

                        var arr_dom = [];
                        var arr_int = [];
                        var arr_pax = [];

                        $.each(data['grafica'], function( index, value ) {

                          arr_dom.push(value['BOL_DOM']);
                          arr_int.push(value['BOL_INT']);
                          arr_pax.push(value['GVC_RUTA']);
                        
                        });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_rut_net/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {
                              		

                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            					if(total_rep == cont){
	            						
                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}

                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 8',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

						var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                              type: 'horizontalBar',
                              data: {
                                labels: arr_pax,
                                datasets: [
                                  {
                                    label: "Boletos Domesticos",
                                    backgroundColor: "#1f497d",
                                    data: arr_dom
                                  }, {
                                    label: "Boletos Internacionales",
                                    backgroundColor: "#98DCFB",
                                    data: arr_int
                                  }
                                ]
                              },
                              options: {
                                title: {
                                  display: false,
                                  text: 'Population growth (millions)'
                                },
                                scales: {
                                  xAxes: [{ 
                                     gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                    }], 
                                  yAxes: [{
                                    stacked: true,
                                    gridLines: { 
                                      color: "rgba(0, 0, 0, 0)", 
                                     } 
                                  }]
                                },
                                animation: {
                                  onComplete: done
                                }
                              }
                          });

                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_rutas',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });


	}else if(id_reporte == 26){ 

		  $("#div_datagrid_grafica"+id_reporte).empty();
          $("#div_datagrid").append('<div id="div_datagrid_grafica'+id_reporte+'" style="width: 60%;margin: 0 auto;"><canvas id="bar-chart-grouped'+id_reporte+'"></canvas></div><div id="div_datagrid_html"></div>');
          $("#bar-chart-grouped"+id_reporte).hide();

	        	$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_pasajero_servicio/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {

                        data = JSON.parse(data);

                        $("#div_datagrid_html").empty();

                        var arr_gen = [];
                        var arr_pax = [];
                        
                      	 $.each(data['grafica'], function( index, value ) {

                                 arr_pax.push(value['NOMBRE_PAX']);
                                 arr_gen.push(value['TOTAL_BOL']);
                                 servicio = '';
                                 color='#1f497d';


                         });

                        function done(){
                        
                          var url=myLine.toBase64Image();
                          //$("#div_datagrid_html").append('<img src="'+url+'" alt="Smiley face" height="500" width="500">');
                            $.ajax({
                              async:true,
                              type:"POST",
                              dataType:"html",//html
                              contentType:"application/x-www-form-urlencoded",//application/x-www-form-urlencoded
                              url:"<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_pasajero_servicio/exportar_excel_ae",
                              data:{parametros:parametros,tipo_funcion:"aut",img_grafica:url,id_servicio:id_servicio},
                              success: function (data) {
                              		

                              		cont++;
                              		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            					if(total_rep == cont){
	            						
                              			enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
                              			$("#div_datagrid").empty();

                              		}

                              },
                              error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 26',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }

                                      
                           });

                           $("#div_datagrid_grafica"+id_reporte).empty();

                        }

                        var myLine = new Chart(document.getElementById("bar-chart-grouped"+id_reporte), {
                                  type: 'horizontalBar',
                                  data: {
                                    labels: arr_pax,
                                    datasets: [
                                      {
                                        label: servicio,
                                        backgroundColor: color,
                                        data: arr_gen
                                      }
                                    ]
                                  },
                                  options: {
                                    title: {
                                      display: false,
                                      text: 'Population growth (millions)'
                                    },
                                    scales: {
                                      xAxes: [{ 
                                         gridLines: { 
                                          color: "rgba(0, 0, 0, 0)", 
                                         } 
                                        }], 
                                      yAxes: [{
                                        gridLines: { 
                                          color: "rgba(0, 0, 0, 0)", 
                                         }, 
                                        stacked: true
                                       
                                      }]
                                    },
	                                animation: {
	                                  onComplete: done
	                                }
                                  }
                              });

						
                      },
                      error: function () {
                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error get_grafica_rutas',status:0,id_correo_automatico}, function(data){

			                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
							
			 							});
							
								   }); 
                              }
                  });


	}else if(id_reporte == 18){

		 $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/exportar_excel_usuario", {parametros:parametros,tipo_funcion:"aut"}, function(data){
				
				

	   			cont++;
	   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
	            if(total_rep == cont){
	            	
	        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
	        	  	

	        	  
	        	}
									                   	 
		 }).fail(function(error) {

		 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 3',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		                 	//alert(error.responseJSON);

		  });

	}else if(id_reporte == 19){  //reporte nuevo detalle pax


		            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/get_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 19',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 19',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });
		 

	}else if(id_reporte == 22){

		            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_cc/get_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_cc/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 22',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 22',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });
		 

	}else if(id_reporte == 23){ 

		            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ahorro_net/get_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ahorro_net/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 23',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 23',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });
		 

	}else if(id_reporte == 24){ 


		            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_consumos_precompra/get_rep_detalle_consumo_precompra",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_consumos_precompra/exportal_excel_detalle_consumo_precompra", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 24',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 24',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });
		 

	}else if(id_reporte == 25){ 


		            $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_total_precompra_aerea/get_precompra",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_total_precompra_aerea/exportar_excel_total_pre", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 25',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 25',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });
		 

	}else if(id_reporte == 35){ 


				 $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 35',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 35',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });


	}else if(id_reporte == 36){ 

				$.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_boleto/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_boleto/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 36',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 36',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });


	}else if(id_reporte == 37){ 

				 $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_bol_cc_rev/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_bol_cc_rev/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 37',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 37',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });


	}else if(id_reporte == 38){ 

				 $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_cs/get_grafica_pasajero",
                    type: 'POST',
                    data: {parametros:parametros,tipo_funcion:"aut",id_servicio:id_servicio},
                    success: function (data) {


                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_cs/exportar_excel_ae", {tipo_funcion:"aut",parametros:parametros,id_servicio:id_servicio,data:data}, function(data){
				
				
					   			cont++;
					   			parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;

					            if(total_rep == cont){
					            	

					        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
					        	  	

					        	  
					        	}
													                   	 
							 }).fail(function(error) {

							 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 38',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

							               
							  });
                         


                      },
                      error: function () {
                          
                          $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 38',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});
                      }

                      
                  });


	}else{

		 $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'No existe automatizacion para el reporte con id:'+id_reporte,status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
												
												});

	}


}

function graficas(parametros,parametros_correo,reportes_array,tipo_archivo,id_reporte,id_correo_automatico,id_servicio,id_intervalo,fecha_ini_proceso){
				  

	parametros_correo['reportes']= reportes_array;
  	parametros_correo['tipo_archivo']= tipo_archivo;
  	parametros_correo['id_reporte']= id_reporte;
  	parametros_correo['id_intervalo']= id_intervalo;
  	parametros_correo['fecha_ini_proceso']= fecha_ini_proceso;

	if(id_reporte == 3){

	$.post( "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/get_prueba_grafica", {parametros: parametros,proceso:'aut'})
      .done(function(grafica) {

		grafica = $.parseJSON(grafica);

			var exportUrl = 'http://export.highcharts.com/';

	          var optionsStr = JSON.stringify({

	          chart: {
	            type: 'column'
	          },
	          title: {
	          	text: 'Gastos Generales'
	            
	          },
	          subtitle: {
	            text: String(grafica['sub'])
	          },
	          xAxis: {
	                    type: 'category'
	                 },
	          yAxis: {
	            allowDecimals: false,
	            title: {
	              text: 'Total'
	            }
	          },
	          credits: {
	                enabled: false
    
	            },
	          legend: {
	                enabled: false
	          },
	          html:{
	            enable: true
	          },
	          plotOptions: {
	                            series: {
	                                borderWidth: 0,
	                                colorByPoint: true,
	                                dataLabels: {
	                                    enabled: true,
	                                    format: '${point.y:,.0f}'
	                                }
	                            }
	                        },
	          tooltip: {
	            formatter: function () {
	              return '<b>' + this.series.name + '</b><br/>' +
	                this.point.y + ' ' + this.point.name.toLowerCase();
	            }
	          },"series": [
	                            {
	                                "name": "Servicio",
	                                "colorByPoint": true,
	                                "data": grafica['grafica']
	                            }
	                        ]

	                    }), 

    globalOptions = JSON.stringify({ 
	    lang: { 
	      thousandsSep: ','
	    } ,
	    colors: ['#226ad8', '#f37100', '#00b0d5', '#04a205', '#d03604', '#f4b300']  //define el color para cada columna,

    }),dataString = encodeURI('async=true&type=jpeg&width=800&options=' + optionsStr + '&globalOptions=' + globalOptions);

	                    	$.ajax({
	                            type: 'POST',
	                            data: dataString,
	                            url: exportUrl,
	                            success: function (data) {

	                                var url_img = exportUrl + data;

	                                  $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/guardar_img_grafica", {url_img: url_img,parametros,grafica:grafica}, function(data){

											      		cont++;
											      		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
											            if(total_rep == cont){
											            	
											        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
											        		
											        	  
											        	}

	                                  }).fail(function(error) { 


	                                  		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 3',status:0,id_correo_automatico}, function(data){

						                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
										
						 							});
											
											});


	                                   });


	                            },
	                            error: function (err) {

	                                $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 3',status:0,id_correo_automatico}, function(data){

				                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
								
				 							});
									
									});

	                            }
	                        });

      })
      .fail(function() {
        alert( "error" );
      });


	}else if(id_reporte == 18){ //actualmente no existe grafica para este id de reporte

    $.post( "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/get_prueba_grafica", {parametros: parametros,proceso:'aut'})
      .done(function(grafica) {

		grafica = $.parseJSON(grafica);

			var exportUrl = 'http://export.highcharts.com/';

	          var optionsStr = JSON.stringify({

	          chart: {
	            type: 'column'
	          },
	          title: {
	          	text: 'Gastos Generales'
	            
	          },
	          subtitle: {
	            text: String(grafica['sub'])
	          },
	          xAxis: {
	                    type: 'category'
	                 },
	          yAxis: {
	            allowDecimals: false,
	            title: {
	              text: 'Total'
	            }
	          },
	          credits: {
	                enabled: false
    
	            },
	          legend: {
	                enabled: false
	          },
	          html:{
	            enable: true
	          },
	          plotOptions: {
	                            series: {
	                                borderWidth: 0,
	                                colorByPoint: true,
	                                dataLabels: {
	                                    enabled: true,
	                                    format: '${point.y:,.0f}'
	                                }
	                            }
	                        },
	          tooltip: {
	            formatter: function () {
	              return '<b>' + this.series.name + '</b><br/>' +
	                this.point.y + ' ' + this.point.name.toLowerCase();
	            }
	          },"series": [
	                            {
	                                "name": "Servicio",
	                                "colorByPoint": true,
	                                "data": grafica['grafica']
	                            }
	                        ]

	                    }), 

    globalOptions = JSON.stringify({ 
	    lang: { 
	      thousandsSep: ','
	    } ,
	    colors: ['#226ad8', '#f37100', '#00b0d5', '#04a205', '#d03604', '#f4b300']  //define el color para cada columna,

    }),dataString = encodeURI('async=true&type=jpeg&width=800&options=' + optionsStr + '&globalOptions=' + globalOptions);

	                    	$.ajax({
	                            type: 'POST',
	                            data: dataString,
	                            url: exportUrl,
	                            success: function (data) {

	                                var url_img = exportUrl + data;

	                                  $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/guardar_img_grafica", {url_img: url_img,parametros,grafica:grafica}, function(data){

											      		cont++;
											      		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
											            if(total_rep == cont){
											            	
											        	  	enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
											        		
											        	  
											        	}

	                                  }).fail(function(error) { 


	                                  		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 3',status:0,id_correo_automatico}, function(data){

						                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
										
						 							});
											
											});


	                                   });


	                            },
	                            error: function (err) {

	                                $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 3',status:0,id_correo_automatico}, function(data){

				                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
								
				 							});
									
									});

	                            }
	                        });

      })
      .fail(function() {
        alert( "error" );
      });

	}else if(id_reporte == 5){ //actualmente no existe grafica para este id de reporte


	}else{



		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'No existe el reporte con el id: '+id_reporte,status:0,id_correo_automatico}, function(data){

				                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
								
				 							});
									
									});


	}


}


function excel_graficas(parametros,parametros_correo,reportes_array,tipo_archivo,id_reporte,id_correo_automatico,id_servicio,id_intervalo,fecha_ini_proceso){
					   
	parametros_correo['reportes']= reportes_array;
  	parametros_correo['tipo_archivo']= tipo_archivo;
  	parametros_correo['id_reporte']= id_reporte;
  	parametros_correo['id_intervalo']= id_intervalo;
  	parametros_correo['fecha_ini_proceso']= fecha_ini_proceso;


	if(id_reporte == 3){

       $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/exportar_excel_usuario", {parametros:parametros,tipo_funcion:"aut"}, function(data){
			
       	 $.post( "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/get_prueba_grafica", {parametros: parametros,proceso:'aut'})
      		.done(function(grafica) {

			grafica = $.parseJSON(grafica);

				var exportUrl = 'http://export.highcharts.com/';

		          var chart = JSON.stringify({

		          chart: {
		            type: 'column'
		          },
		          title: {
		            text: 'Gastos Generales'
		          },
		          xAxis: {
		                    type: 'category'
		                 },
		          yAxis: {
		            allowDecimals: false,
		            title: {
		              text: 'Total'
		            }
		          },
		          credits: {
		                enabled: false
		            },
		          legend: {
		                enabled: false
		          },
		          html:{
		            enable: true
		          },
		          plotOptions: {
		                            series: {
		                                borderWidth: 0,
		                                colorByPoint: true,
		                                dataLabels: {
		                                    enabled: true,
		                                    format: '${point.y:,.0f}'
		                                }
		                            }
		                        },
		          tooltip: {
		            formatter: function () {
		              return '<b>' + this.series.name + '</b><br/>' +
		                this.point.y + ' ' + this.point.name.toLowerCase();
		            }
		          },"series": [
		                            {
		                                "name": "Servicio",
		                                "colorByPoint": true,
		                                "data": grafica['grafica']
		                            }
		                        ],

		                    }),dataString = encodeURI('async=true&type=jpeg&width=800&options=' + chart);

		                    	$.ajax({
		                            type: 'POST',
		                            data: dataString,
		                            url: exportUrl,
		                            success: function (data) {

		                                var url_img = exportUrl + data;

		                                  $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/guardar_img_grafica", {url_img: url_img,parametros,grafica:grafica}, function(data){

		                                  		

								          		cont++;
								          		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
						                        if(total_rep == cont){
						                           
											       enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);
											    
						                    	  
						                    	}

		                                  }).fail(function(error) { 


	                                  		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 3',status:0,id_correo_automatico}, function(data){

						                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
										
						 							});
											
											});


	                                   });


		                            },
		                            error: function (err) {
		                                debugger;
		                                console.log('error', err.statusText)
		                            }
		                        });

          }).fail(function(error) {

		 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 3',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		                 	//alert(error.responseJSON);

		  });
			
   });


	}else if(id_reporte == 18){ //actualmente no existe grafica para este id de reporte


		 $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/exportar_excel_usuario", {parametros:parametros,tipo_funcion:"aut"}, function(data){
			
       	 $.post( "<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/get_prueba_grafica", {parametros: parametros,proceso:'aut'})
      		.done(function(grafica) {

			grafica = $.parseJSON(grafica);

				var exportUrl = 'http://export.highcharts.com/';

		          var chart = JSON.stringify({

		          chart: {
		            type: 'column'
		          },
		          title: {
		            text: 'Gastos Generales'
		          },
		          xAxis: {
		                    type: 'category'
		                 },
		          yAxis: {
		            allowDecimals: false,
		            title: {
		              text: 'Total'
		            }
		          },
		          credits: {
		                enabled: false
		            },
		          legend: {
		                enabled: false
		          },
		          html:{
		            enable: true
		          },
		          plotOptions: {
		                            series: {
		                                borderWidth: 0,
		                                colorByPoint: true,
		                                dataLabels: {
		                                    enabled: true,
		                                    format: '${point.y:,.0f}'
		                                }
		                            }
		                        },
		          tooltip: {
		            formatter: function () {
		              return '<b>' + this.series.name + '</b><br/>' +
		                this.point.y + ' ' + this.point.name.toLowerCase();
		            }
		          },"series": [
		                            {
		                                "name": "Servicio",
		                                "colorByPoint": true,
		                                "data": grafica['grafica']
		                            }
		                        ],

		                    }),dataString = encodeURI('async=true&type=jpeg&width=800&options=' + chart);

		                    	$.ajax({
		                            type: 'POST',
		                            data: dataString,
		                            url: exportUrl,
		                            success: function (data) {

		                                var url_img = exportUrl + data;

		                                  $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/guardar_img_grafica", {url_img: url_img,parametros,grafica:grafica}, function(data){

		                                  		

								          		cont++;
								          		parametros_correo['reportes'][id_reporte] = parametros_correo['reportes'][id_reporte] + '**' + data;
						                        if(total_rep == cont){
						                           
						                        
											       enviar_correo(parametros_correo,id_reporte,status,id_correo_automatico);

						                    	  
						                    	}

		                                  }).fail(function(error) { 


	                                  		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 18',status:0,id_correo_automatico}, function(data){

						                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
										
						 							});
											
											});


	                                   });


		                            },
				                      error: function () {
				                                  $.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'grafica reporte 18',status:0,id_correo_automatico}, function(data){

							                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
											
							 							});
											
												   }); 
				                              }
		                        });

          }).fail(function(error) {

		 		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'Error excel reporte 18',status:0,id_correo_automatico}, function(data){

		                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
						
		 							});
							
							});

		  });
			
   });


	}else if(id_reporte == 5){ //actualmente no existe grafica para este id de reporte





	}else{



		$.post("<?php echo base_url(); ?>index.php/Cnt_correos/guardar_log_envio", {id_reporte:id_reporte,detalle:'No existe el reporte con el id: '+id_reporte,status:0,id_correo_automatico}, function(data){

				                 			$.post("<?php echo base_url(); ?>index.php/Cnt_correos/update_status_proceso", {status:0}, function(data){  //cambia status para continuar con los demas correos
								
				 							});
									
									});



	}



} 

Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
  });

</script>