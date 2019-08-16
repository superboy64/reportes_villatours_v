  <div class="form-group">
	               
	        <img class="img-responsive img-circle center-block" src="<?php echo base_url(); ?>referencias/img/user.jpg" title="Imgen Perfil" style="height: 73px;" />
			<center><b><?=$this->session->userdata('session_nombre')?></b></center>          
	
  </div>
  


  <div style="height: 181px; width: 469px; background-color: #e3e3e3;">
  	
	  <div class="form-group">
	    &nbsp;<label for="exampleInputEmail1">Usuario:</label>
	    <?=$this->session->userdata('session_usuario')?>
	  </div>
	  
	  <div class="form-group">
	    &nbsp;<label for="exampleInputEmail1">Departamento:</label>
	    <?=$this->session->userdata('session_nom_perfil')?>
	  </div>

	  <div class="form-group">
	    &nbsp;<label for="exampleInputEmail1">Fecha alta:</label>
	    <?=$this->session->userdata('session_fecha_alta')?>
	  </div>

	  <div class="form-group">
	    &nbsp;<label for="exampleInputEmail1">Status:</label>
	    
	    <?php
	    if($this->session->userdata('session_status') == 1){

	    	?>
	    	Activo
	    <?php 
	     }else{ ?> Inactivo <?php } ?>

	  </div>

  </div>
