<?php
/*
print_r($tarjetas_sybase);
print_r($tarjetas_local);
*/
?>

<table class="table table-hover">
  
  <thead>

    <tr>
      <th scope="col">Cliente</th>
      <th scope="col">Tarjeta sybase</th>
      <th scope="col">Tarjeta local</th>
    </tr>

  </thead>
  
  <tbody>

  	<?php

		$ids_cliente = explode("_", $ids_cliente);
		$ids_cliente = array_filter($ids_cliente, "strlen");

		foreach ($ids_cliente as $key_clientes => $value_clientes) {


			print_r("<tr>");

				print_r("<td>");

					print_r($value_clientes);
				
				print_r("</td>");
				print_r("<td>");

					foreach ($tarjetas_sybase as $key_syb => $value_syb) {

		  				if($value_syb->id_cliente == $value_clientes){

		  					$tarjeta = $value_syb->concepto;

		  					$tarjeta_pre = substr($tarjeta, 0, -15);
		  					$tarjeta_num = substr($tarjeta, -15);  
		  					$tarjeta_com = $tarjeta_pre.$tarjeta_num;
		  					
						    if(ctype_digit($tarjeta_num)){

						    	if(strlen($tarjeta_com) == 17){

						    		print_r($tarjeta_com.' ');

						    	}
						    	

						    }

		  				}
				  		
				  	}

				print_r("</td>");
				print_r("<td>");

					foreach ($tarjetas_local as $key_loc => $value_loc) {

				  		if($value_loc["id_cliente"] == $value_clientes){

						    print_r($value_loc["tarjeta"].' '); 

				  		}
						    
			  		}
				
				print_r("</td>");

			print_r("</tr>");

		
		}


  	?> 


  </tbody>

</table>