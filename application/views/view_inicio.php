
<style>
    
    .ui-jqgrid tr.jqgrow td {
        white-space: pre;
        height: auto;
        vertical-align: text-top;
        padding-top: 2px;
    }

    .ui-jqgrid tr.jqgrow td {font-size:0.8em}

    .ui-jqgrid .ui-widget-header {
      background-color: #3d7ab6;
      background-image: none;
      color:#fff;
    }

    .ui-jqgrid .ui-jqgrid-labels th.ui-th-column {
        background-color: #3d7ab6;
        background-image: none;
        color:#fff;
    }

</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>referencias/css/style_inicio.css">
<link href="<?php echo base_url(); ?>referencias/css/font-awesome.min.css" rel="stylesheet">

<div class="col-md-12" style="background-color: #cacacc;  background-color: rgba(154, 154, 154, 0.6); color:#414a6c;">
  <div class="row">
      <div class="col-md-2">
        <nav class="navbar navbar-light bg-light">
          <a class="navbar-brand" href="inicio">
            <img id="profile-img" class="img-thumbnail" style="width: 212px; height: 48px;" src="<?php echo base_url(); ?>referencias/img/villatours.png"/>
          </a>
        </nav>
      </div>

    <div class="col-md-8" id="div_content_header" style="height: 65px;">

        <div class="col-md-12">
         
          <center><h3 style="font-family:'Colfax Medium';font-weight:normal; color: white;">Sistema de Reportes</h3></center>
          <center><h1 style="font-family:'Colfax Medium';font-weight:normal;font-size:17px;color: white;" id="title">Inicio</h1></center>
        
        </div>

    </div>

      <div class="col-md-2">
        <div class="row">

            <div class="col-md-4">
              
                   <?php
                      
                      $id_us = $this->session->userdata('session_id');

                      if($id_us == 14){

                   ?> 
                   <img class="img-responsive img-circle center-block" src="<?php echo base_url(); ?>referencias/img/user_martha.jpg" title="Imgen Perfil" style="height: 73px;" />
                   
                   <?php

                      }else{
                        
                   ?>  

                   <img class="img-responsive img-circle center-block" src="<?php echo base_url(); ?>referencias/img/user.jpg" title="Imgen Perfil" style="height: 73px;" />
                   <?php
                      }
                   ?>
              

            </div>

            <div class="col-md-8">
                    <blockquote>
                        
                        <a href="#" onclick="menu_usuario();"  style="cursor:pointer;color: white;"><?php print_r($this->session->userdata('session_usuario')); ?>&nbsp;<i class="glyphicon glyphicon-triangle-bottom"></i></a>

                        <div id="div_menu_usuario" style="position: absolute;width: 200;background-color: #fff; z-index: 1000; font-size: 15px; margin-left: -61px;" hidden>

                          <table>
                            <tr><td style="height: 30px;cursor:pointer;"><a onclick="ver_perfil_usuario();"><i class="glyphicon glyphicon-user"></i>ver perfil</a></td></tr>
                             <tr><td style="height: 30px;cursor:pointer;"><a onclick="cambio_contrasena_usuario();"><i class="fa fa-key"></i>&nbsp;&nbsp;cambio de contraseña</a></td></tr>
                              <tr><td style="height: 30px;cursor:pointer;"><a onclick="cerrar_session();"><i class="glyphicon glyphicon-log-in"></i>cerrar sesion</a></td></tr>
                          </table>

                        </div>

                        <small style="color:#eeeeee;">
                          <cite title="Source Title" ><span class="label label-warning"><?php print_r($this->session->userdata('session_nom_perfil')); ?></span>
                          </cite>
                        </small>
                        
                    </blockquote>
            </div>

          </div>
      </div>
</div>
</div>
<div class="col-md-12">

      <br> <!-- espacio -->
      
</div>

<?php

 $modulos_disp = [];
 
  foreach ($modulos_arr as $key => $value) {
                                 

    array_push($modulos_disp, $value['id']);  


  }

    $modulos_disp = array_unique($modulos_disp);


?>
  <div class="col-md-12" id="contenedor">

    
    <div class="loading-wrap" id="animation_loading" hidden>
    
      <div class="triangle1"></div>
      <div class="triangle2"></div>
      <div class="triangle3"></div>

    </div>


   

    <div class="row">
        <div class="col-md-2" style="color:#414a6c;">
          
            <div class="panel-group">

              <?php
                
                foreach ($modulos_disp as $key => $mo) {
                                        
                  if($mo == 1){
                    ?>

                        <div class="panel panel-default">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="fa fa-cogs">&nbsp;
                                  </span>Administrar</a>
                              </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <table class="table">
                                    
                                    <?php

                                          foreach ($modulos_arr as $key => $value) {
                                          
                                              if($value['id'] == 1){
                                                if($value['id_submodulo'] == 1){
                                                   $title = 'Administrar - Usuarios';
                                                  ?>
                                                    <tr>
                                      
                                                        <td>
                                                            <a id="link_adm_us" href="javascript:void(0);" onclick="li_btn_get_administrar_usuarios('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-users" style="width: 28px;"></i>Usuarios&nbsp;</a> 
                                                        </td>
                                                    
                                                    </tr>

                                                    <script type="text/javascript">
                                                       
                                                       function li_btn_get_administrar_usuarios(title){
          
                                                            carga();
                                                            $.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_html_usuarios", {title: title}, function(data){

                                                             carga_completa(data);

                                                            });

                                                        }

                                                    </script>


                                                  <?php

                                                }

                                                if($value['id_submodulo'] == 2){
                                                 $title = 'Administrar - Perfiles';
                                                  ?>
                                                    <tr>
                                                    
                                                        <td>
                                                            <a id="link_adm_per" href="javascript:void(0);" onclick="li_btn_get_administrar_perfiles('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-user" style="width: 28px;"></i>Perfiles&nbsp;</a>
                                                        </td>

                                                    </tr>

                                                    <script type="text/javascript">

                                                            function li_btn_get_administrar_perfiles(title){
          
                                                                carga();
                                                                $.post("<?php echo base_url(); ?>index.php/Cnt_perfiles/get_html_perfiles", {title: title}, function(data){
                                                                  
                                                                  carga_completa(data);

                                                                });

                                                            }

                                                    </script>
                                                  <?php


                                                }

                                                if($value['id_submodulo'] == 11){
                                                    $title = 'Plantillas';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_plantillas('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-server" style="width: 28px;"></i>Plantillas&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                        function consulta_plantillas(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_plantillas/get_html_plantillas", {title: title}, function(data){

                                                                carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }

                                                  if($value['id_submodulo'] == 27){
                                                    $title = 'Precompra';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_precompra('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-arrows-h" style="width: 28px;"></i>Precompra&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                        function consulta_precompra(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_precompra/get_html_precompra", {title: title}, function(data){

                                                                carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }

                                                  if($value['id_submodulo'] == 28){
                                                    $title = 'Tarjetas AMEX';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_tarjetas('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-cc-amex" style="width: 28px;"></i>Tarjetas AMEX&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                        function consulta_tarjetas(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_tarjetas/get_html_tarjetas", {title: title}, function(data){
                                                              
                                                                carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }

                                                  if($value['id_submodulo'] == 29){
                                                    $title = 'Aereolineas AMEX';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_aereolineas('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-plane" style="width: 28px;"></i>Aerolineas AMEX&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                        function consulta_aereolineas(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_amex/get_html_aereolineas_amex", {title: title}, function(data){

                                                                carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>

                                                    <?php

                                                  }

                                                  if($value['id_submodulo'] == 30){
                                                    $title = 'Clientes CFDI';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="clientes_CFDI('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-user-circle-o" style="width: 28px;"></i>Clientes CFDI&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                        function clientes_CFDI(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_clientes_CFDI/get_html_clientes_CFDI", {title: title}, function(data){
                                                              
                                                                carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }
                                                  
                                                  if($value['id_submodulo'] == 31){
                                                    $title = 'Aerolineas CFDI';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_aereolineas_CFDI('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-plane" style="width: 28px;"></i>Aerolineas CFDI&nbsp;</a>
                                                          </td>
                                                        
                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                        function consulta_aereolineas_CFDI(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_aereolineas_CFDI/get_html_aereolineas_CFDI", {title: title}, function(data){

                                                                carga_completa(data);

                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }


                                              }


                                          }

                                    ?>
       
                                  </table>
                              </div>
                          </div>
                      </div>


                    <?php

                  }


                }

              ?>
              <!--*****************************************Reportes******************************************************-->
              <?php
                
                foreach ($modulos_disp as $key => $mo) {
                                        
                  if($mo == 3){

                    ?>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour_uno"><span class="fa fa-registered">&nbsp;
                                    </span>Reportes con notas de credito</a>
                                </h4>
                            </div>
                            <div id="collapseFour_uno" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                      <?php
                                      foreach ($modulos_arr as $key => $value) {
                                                if($value['id'] == 3){

                                                  if($value['id_submodulo'] == 3){
                                                     $title = 'Reporte - GVC Reporteador';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_reportes_gvc_reporteador('<?=$title?>');" >GVC Reporteador&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      <script type="text/javascript">
                                                            
                                                             function li_btn_get_reportes_gvc_reporteador(title){
                                                                
                                                                carga();
                                                                $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador/get_html_reportes_gvc_reporteador", {title: title}, function(data){
                                                                    
                                                                  carga_completa(data);
                                                                   
                                                                });

                                                            } 

                                                      </script>
                                                    <?php

                                                  }

                                                  if($value['id_submodulo'] == 4){
                                                     $title = 'Reporte - Gastos generales';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_gastos_generales('<?=$title?>');" >Gastos generales&nbsp;</a>
                                                          </td>


                                                      </tr>

                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_gastos_generales(title){
         
                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen/get_html_rep_gastos_generales", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                               
                                                            });
                                                          

                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 5){
                                                     $title = 'Reporte de Servicios Por Segmentos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_layout_segmentado('<?=$title?>');" >Reporte Segmentado&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      
                                                      <script type="text/javascript">

                                                           function li_btn_get_rep_layout_segmentado(title){
        
                                                            carga();
                                                            $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_layout_seg/get_html_rep_layout_segmentado", {title: title}, function(data){
                                                                  
                                                                  carga_completa(data);
                                                                 
                                                              });

                                                          }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 6){
                                                     $title = 'Reporte - Ficosa';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_ficosa('<?=$title?>');" >Ficosa&nbsp;</a>
                                                          </td>

                                                      </tr>

                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_ficosa(title){
        
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ficosa/get_html_rep_ficosa", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });

                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 8){
                                                     $title = 'Reporte - Graficos aereos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_graficos_ae('<?=$title?>');" >Aerolíneas Graficos aereos&nbsp;</a>
                                                          </td>

                                                          
                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_graficos_ae(title){
        
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae/get_html_rep_graficos_ae", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });

                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 12){
                                                     $title = 'Reporte - Pax Graficos aereos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_gastos_ae('<?=$title?>');" >Pax Grafico aereo&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_gastos_ae(title){

                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_ae/get_html_rep_gastos_ae", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 13){
                                                     $title = 'Reporte - Graficos rutas';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_graficos_rut('<?=$title?>');" >Rutas Grafico&nbsp;</a>
                                                          </td>

                                                         
                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_graficos_rut(title){

                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_rut/get_html_rep_graficos_rut", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }


                                                }


                                            }
                                        ?>

                                       
                                     

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="fa fa-registered">&nbsp;
                                    </span>Reportes Netos</a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                      <?php
                                      
                                      $id_us = $this->session->userdata('session_id');

                                      foreach ($modulos_arr as $key => $value) {
                                                if($value['id'] == 3){
                                                  
                                                  if($value['id_submodulo'] == 34){
                                                     $title = 'Reporte - GVC Reporteador';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_gvc_reporteador_net('<?=$title?>');" >GVC Reporteador&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_gvc_reporteador_net(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gvc_reporteador_net/get_html_rep_gvc_reporteador_net", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                               
                                                            });



                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 18){
                                                     $title = 'Reporte - Gastos generales';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_gastos_generales_net('<?=$title?>');" >Gastos generales&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_gastos_generales_net(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_gen_net/get_html_rep_gastos_generales", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                               
                                                            });



                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 14){
                                                     $title = 'Reporte - Detalle de consumos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_detalle_consumos('<?=$title?>');" >Detalle de consumos&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_detalle_consumos(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_consumo/get_html_rep_detalle_consumo", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                    }
                                                  

                                                  if($value['id_submodulo'] == 15){
                                                     $title = 'Reporte - Graficos aereos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_graficos_ae_net('<?=$title?>');" >Aerolíneas Graficos aereos&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_graficos_ae_net(title){
        
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_ae_net/get_html_rep_graficos_ae_net", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });

                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                 
                                                  if($value['id_submodulo'] == 16){
                                                     $title = 'Reporte - Gastos aereos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_gastos_ae_net('<?=$title?>');" >Pax Grafico aereo&nbsp;</a>
                                                          </td>


                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_gastos_ae_net(title){

                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_gastos_ae_net/get_html_rep_gastos_ae", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                 
                                                  if($value['id_submodulo'] == 17){
                                                     $title = 'Reporte - Graficos rutas';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_graficos_rut_net('<?=$title?>');" >Ruta Grafico&nbsp;</a>
                                                          </td>

                                                      </tr>
                                                      <script type="text/javascript">
                                                        
                                                        function li_btn_get_rep_graficos_rut_net(title){

                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_graficos_rut_net/get_html_rep_graficos_rut", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 17){
                                                     $title = 'Reporte - Tabulador aerolineas';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_tabulador_aereolineas('<?=$title?>');" >Tabulador aerolineas&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_tabulador_aereolineas(title){

                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_tabulador_aereolineas/get_html_rep_graficos_ae_net", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 17){
                                                     $title = 'Reporte - Detalle Pax';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_detalle_pax('<?=$title?>');" >Detalle Pax&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_detalle_pax(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_pax/get_html_rep_gastos_ae", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 22){
                                                     $title = 'Reporte - Detalle CC';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_detalle_cc('<?=$title?>');" >Detalle CC&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_detalle_cc(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_cc/get_html_rep_gastos_ae", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 23 /*&& $id_us == 14*/){
                                                     $title = 'Reporte - Ahorro';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_ahorro('<?=$title?>');" >Ahorro&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_ahorro(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ahorro_net/get_html_rep_ahorro", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }


                                                  if($value['id_submodulo'] == 24 /*&& $id_us == 14*/){
                                                     $title = 'Reporte - Detalle de consumos precompra aerea';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_precompra('<?=$title?>');" >Detalle de consumos con precompra aerea&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_precompra(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_detalle_consumos_precompra/get_html_rep_detalle_consumo_precompra", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 25 /*&& $id_us == 14*/){
                                                     $title = 'Reporte - Total de precompra aerea';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_total_rep_precompra_aerea('<?=$title?>');" >Total de precompra aerea&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_total_rep_precompra_aerea(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_total_precompra_aerea/get_html_rep_total_precompra_ae", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 26 && $id_us == 14){
                                                     $title = 'Reporte - Total por pasajero y servicio';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_pasajero_servicio('<?=$title?>');" >Total por pasajero y servicio&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_pasajero_servicio(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_pasajero_servicio/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 35){
                                                     $title = 'Reporte - Serv 24 HRS';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_serv_24hrs('<?=$title?>');" >Serv 24 HRS&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_serv_24hrs(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }


                                                  if($value['id_submodulo'] == 36){
                                                     $title = 'Reporte - Serv 24 HRS boletos';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_serv_24hrs_boleto('<?=$title?>');" >Serv 24 HRS boletos&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_serv_24hrs_boleto(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_boleto/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 37){
                                                     $title = 'Serv 24 HRS (boletos,revisados y cargos por cambio)';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_serv_24hrs_bol_cc_rev('<?=$title?>');" >Serv 24 HRS (boletos,revisados y cargos por cambio)&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_serv_24hrs_bol_cc_rev(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_bol_cc_rev/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 38){
                                                     $title = 'Serv 24 HRS CS';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_serv_24hrs_cs('<?=$title?>');" >Serv 24 HRS CS&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_serv_24hrs_cs(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_serv_24hrs_cs/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 38 && $id_us == 14){
                                                     $title = 'ventas corporativas';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_ventas_corporativas('<?=$title?>');" >ventas corporativas&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_ventas_corporativas(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ventas_corporativas/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 38 && $id_us == 14){
                                                     $title = 'ventas corporativas clientes';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_ventas_corporativas_clientes('<?=$title?>');" >ventas corporativas clientes&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_ventas_corporativas_clientes(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_ventas_corporativas_clientes/get_html_rep_pasajeros_servicio", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }

                                                  if($value['id_submodulo'] == 38 && $id_us == 14 ){
                                                     $title = 'Hoteles limpieza';
                                                    ?>
                                                      <tr>
                                                          
                                                          <td>
                                                              <i class="glyphicon glyphicon-file" ></i>
                                                          </td>
                                                          <td colspan="4">
                                                              <a id="link_rep_gra_ae" href="javascript:void(0);" onclick="li_btn_get_rep_hoteles_limpieza('<?=$title?>');" >Hoteles limpieza&nbsp;</a>
                                                          </td>
                                                          

                                                      </tr>
                                                      <script type="text/javascript">

                                                        function li_btn_get_rep_hoteles_limpieza(title){
      
                                                          carga();
                                                          $.post("<?php echo base_url(); ?>index.php/Reportes/Cnt_reportes_hoteles_limpieza/get_html_rep_hoteles_limpieza", {title: title}, function(data){
                                                                
                                                               carga_completa(data);
                                                                
                                                            });


                                                        }

                                                      </script>
                                                    <?php


                                                  }


                                                }


                                            }
                                        ?>

                                       
                                     

                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php

                  }

                }


              ?>
              <!--********************************************layouts*****************************************************************-->
              <?php
                
                foreach ($modulos_disp as $key => $mo) {

                        if($mo == 5){
                    
                    ?>

                        <div class="panel panel-default">
                          <div class="panel-heading">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseThre"><span class="fa fa-sticky-note-o">&nbsp;
                                  </span>Layouts</a>
                              </h4>
                          </div>
                          <div id="collapseThre" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <table class="table">
                                    
                                    <?php

                                          foreach ($modulos_arr as $key => $value) {
                                          
                                              if($value['id'] == 5){
                                                if($value['id_submodulo'] == 21){
                                                   $title = 'Layout - EBTA';
                                                  ?>
                                                    <tr>
                                      
                                                        <td>
                                                            <a id="link_adm_us" href="javascript:void(0);" onclick="li_btn_get_EBTA('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-wpforms" style="width: 28px;"></i>EBTA&nbsp;</a> 
                                                        </td>
                                                    
                                                    </tr>

                                                    <script type="text/javascript">
                                                       
                                                       function li_btn_get_EBTA(title){
          
                                                            carga();
                                                            $.post("<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_amex/get_html_layouts_amex", {title: title}, function(data){

                                                             carga_completa(data);

                                                            });

                                                        }

                                                    </script>


                                                  <?php

                                                }

                                                

                                              }


                                          }

                                    ?>

                                    <?php

                                          foreach ($modulos_arr as $key => $value) {
                                          
                                              if($value['id'] == 5){
                                                if($value['id_submodulo'] == 32){
                                                   $title = 'Layout - CFDI';
                                                  ?>
                                                    <tr>
                                      
                                                        <td>
                                                            <a id="link_adm_us" href="javascript:void(0);" onclick="li_btn_get_CFDI('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-wpforms" style="width: 28px;"></i>CFDI&nbsp;</a> 
                                                        </td>
                                                    
                                                    </tr>

                                                    <script type="text/javascript">
                                                       
                                                       function li_btn_get_CFDI(title){
          
                                                            carga();
                                                            $.post("<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_CFDI/get_html_layouts_CFDI", {title: title}, function(data){

                                                             carga_completa(data);

                                                            });

                                                        }

                                                    </script>


                                                  <?php

                                                }

                                                

                                              }


                                          }

                                    ?>

                                    <?php

                                          foreach ($modulos_arr as $key => $value) {
                                          
                                              if($value['id'] == 5){
                                                if($value['id_submodulo'] == 33){
                                                   $title = 'Layout - Venta diaria Amex';
                                                  ?>
                                                    <tr>
                                      
                                                        <td>
                                                            <a id="link_adm_us" href="javascript:void(0);" onclick="li_btn_get_venta_diaria_amex('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-wpforms" style="width: 28px;"></i>Venta diaria Amex&nbsp;</a> 
                                                        </td>
                                                    
                                                    </tr>

                                                    <script type="text/javascript">
                                                       
                                                       function li_btn_get_venta_diaria_amex(title){
          
                                                            carga();
                                                            $.post("<?php echo base_url(); ?>index.php/Layouts/Cnt_layouts_venta_diaria_amex/get_html_layouts_venta_diaria_amex", {title: title}, function(data){

                                                             carga_completa(data);

                                                            });

                                                        }

                                                    </script>


                                                  <?php

                                                }

                                                

                                              }


                                          }

                                    ?>
       
                                  </table>
                              </div>
                          </div>
                      </div>


                    <?php

                  }


                }

              ?>
              <!--********************************************automatizacion***************************************************-->
               <?php
                
                foreach ($modulos_disp as $key => $mo) {
                                        
                  if($mo == 4){
                    ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="fa fa-clock-o">&nbsp;
                                    </span>Automatización</a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table">
                                      <?php

                                            foreach ($modulos_arr as $key => $value) {
                                            
                                                if($value['id'] == 4){

                                                  if($value['id_submodulo'] == 7){
                                                    $title = 'Automatización - Envio de correos';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="prueba_correos('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-envelope" style="width: 28px;"></i>Programacion de correos&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      <script type="text/javascript">

                                                        function prueba_correos(title){
         
                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_correos/prueba_correos", {title: title}, function(data){

                                                                carga_completa(data);
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }
                                                  if($value['id_submodulo'] == 9){
                                                    $title = 'Correos programados';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_correos_programados('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-envelope-open" style="width: 28px;"></i>Correos programados&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      <script type="text/javascript">

                                                        function consulta_correos_programados(title){

                                                           carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_correos/consulta_correos_programados", {title: title}, function(data){

                                                                carga_completa(data);
                                                                
                                                               
                                                            });

                                                        }

                                                      </script>
                                                    <?php

                                                  }
                                                  if($value['id_submodulo'] == 10){
                                                    $title = 'Log envios';
                                                    ?>
                                                      <tr>
                                                      
                                                          <td>
                                                              <a id="link_correos" href="javascript:void(0);" onclick="consulta_correos_log('<?=$title?>');" style="margin-left: 27px;"><i class="fa fa-share-square" style="width: 28px;"></i>Log envios&nbsp;</a>
                                                          </td>
                                                      
                                                      </tr>
                                                      <script type="text/javascript">

                                                        function consulta_correos_log(title){

                                                          carga();
                                                           $.post("<?php echo base_url(); ?>index.php/Cnt_correos/consulta_correos_log", {title: title}, function(data){

                                                                carga_completa(data);
                                                                
                                                               
                                                            });
                                                          
                                                        }

                                                      </script>
                                                    <?php

                                                  }
                                                  

                                                }


                                            }

                                      ?>
                                        
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php

                    }

                }

                ?>
     
            </div>
        </div>
        <!--modal global-->
        <center>
               <div id="myModal" class="modal fade" tabindex="-1" role="dialog" style="overflow:auto;">

                  <div class="modal-dialog" role="document" id="modal_content" style="width: 100%;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modal_title">
                          
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="modal_body" style="text-align: left;">
                       
                      </div>
                      <div class="modal-footer" id="modal_footer">
                        <button type="button" class="btn btn-primary" id="btn_modal_guardar"><i class="fa fa-save">&nbsp;Guardar</i></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_modal_cancelar"><i class="fa fa-remove">&nbsp;Cancelar</i></button>
                      </div>
                    </div>
                  </div>

              </div>
          </center>
              <!--fin modal-->
        <center>
           <div id="myModal_accesos" class="modal fade" tabindex="-1" role="dialog" style="overflow:auto;opacity: 3;">

              <div class="modal-dialog" role="document" id="modal_content_accesos" style="width: 100%;background-color: white;">
                <div class="modal-content_accesos">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modal_title_accesos">
                      
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="modal_body_accesos" style="text-align: left;">
                   
                  </div>
                  <div class="modal-footer" id="modal_footer_accesos">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_modal_cancelar">Cancelar</button>
                  </div>
                </div>
              </div>

          </div>
        </center>
      
        <div id="div_contenedor" class="col-md-8" style="margin-bottom: 18px;">

               <div id="body_content" style="height:auto;">
                    
                      
                      
               </div>
               
        </div>

      <?php foreach ($modulos_disp as $key => $mo) {
                                        
         if($mo == 4){
      
      ?>

      <div class="col-md-2">

        <div id="luz" style="float: left;"></div>

          <div class="col-md-12">


            <div class="panel panel-primary">

              <div class="panel-heading">
                
                  <h1 class="panel-title" style="color: #fff;" id="lbl_proceso_script">Correos enviados&nbsp;&nbsp;&nbsp;</h1>     
                    
              </div>

              <div class="panel-body" style="height: 358px; overflow-y:hidden; overflow: auto;" id="div_correos_enviados">
                
                <!--<table id="dg_perfil_clientes" style="height: 191px;"></table>-->
              
              </div>

              
            
            </div>

           
            <div class="col-md-12">
                  
                  <div class="row">

                      <div class="col-md-4" style="background-color: #337ab7; color: white;">

                          <center><i class="fa fa-envelope-o"></i></center>
                          <center style="font-size: 12px; margin-top: 6px;">Envios<br><?=$estadisticas[0]['env_correctamente']?></center> 

                      </div>
                   
                      <div class="col-md-4" style="background-color: #337ab7; color: white;">

                          <center><i class="fa fa-exclamation-circle"></i></center>
                          <center style="font-size: 12px; margin-top: 6px;">Rechazos<br><?=$estadisticas[0]['no_enviados']?></center>

                      </div>
                      <div class="col-md-4" style="background-color: #337ab7; color: white;">

                          <center><i class="fa fa-users"></i></center>
                          <center style="font-size: 12px; margin-top: 6px;">Usuarios<br><?=$estadisticas[0]['cant_us']?></center> 

                      </div>
                     
                  </div>



              </div>
               
                 
          </div>
            
      </div>

    <?php
        } 
     }
    ?>

    </div>
  </div>
  
  <div class="col-md-12" style="height: 52px;">

        <br> <!-- espacio -->
        
  </div>
 
  <div id="div_footer" class="col-md-12">
            <br> <!-- espacio -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
            
                    <!--Footer-->
                    <footer id="footer" class="navbar navbar-fixed-bottom" style="background-color: rgba(56, 58, 66, 0.6); color:white;">

                            <div class="row">

                                <div class="col-md-4">
                                 
                                    <div class="text-center center-block">
                                        <p class="txt-railway" style="font-family:'Colfax Medium';">Redes sociales</p>
                                        
                                          <a href="https://www.facebook.com/bootsnipp"><i id="social-fb" class="fa fa-facebook-square fa-3x social" style="color:white;"></i></a>
                                          <a href="https://twitter.com/bootsnipp"><i id="social-tw" class="fa fa-twitter-square fa-3x social" style="color:white;"></i></a>
                                          <a href="https://plus.google.com/+Bootsnipp-page"><i id="social-gp" class="fa fa-google-plus-square fa-3x social" style="color:white;"></i></a>
                                          <a href="mailto:bootsnipp@gmail.com"><i id="social-em" class="fa fa-envelope-square fa-3x social" style="color:white;"></i></a>
                                          
                                    </div>
                  
                                </div>
                                <div class="col-md-4" style="margin-top: 50px;">
                                 
                                   <center style="font-size: 16px;"> © 2015 Copyright:  <a href="http://www.villatours.com.mx/" target="_blank" style="color:white;"> www.villatours.com.mx</a></center>
                  
                                </div>
                                <div class="col-md-4">

                                  <div class="text-center center-block">
                                    <h5 class="title mb-3" style="font-family:'Colfax Medium';font-weight:normal;font-size:13px;">Links</h5>
                                    <li><a href="http://10.77.62.155/web/pantalla.php" target="_blank" style="color:white;">Intranet villatours</a></li>
                                  </div>   
                                  
                                </div>

                               
                            </div>
                        
                           
                            

                           
                    </footer>
                    <!--/.Footer-->
            
                </div>
                <!-- Grid column -->
            
            </div>

    </div>

 <script type="text/javascript">

     function menu_usuario(){

        $( "#div_menu_usuario" ).toggle();
     
     }
     
     function carga(){

       rest_modal("");
       $("#body_content").empty();
       $("#div_contenedor").removeClass("css_div_contenedor");
       $("#animation_loading").show();

     }

     function carga_completa(data){

        $("#animation_loading").hide();
        $("#body_content").html(data);

        $("#gif_link_rep_lay_seg").remove();
        $("#gif_link_adm_us").remove();
        $("#gif_link_adm_per").remove();
        $("#gif_link_gvc_rep").remove();
        $("#gif_link_rep_gen").remove();
        $("#gif_link_rep_fic").remove();
        $("#gif_link_correos").remove();

        $("#div_contenedor").addClass("css_div_contenedor");

     }


      function rest_modal(funcionallamar){

        $("#btn_modal_guardar").prop("onclick", null);
        $("#modal_body").empty();
        $("#modal_title").empty();
        $("#modal_footer").show();
        $("#btn_modal_guardar").attr("onClick",funcionallamar);
        $("#modal_content").css({"width": "500px"});


      }

      function cerrar_session(){
     
        $.post("<?php echo base_url(); ?>index.php/Cnt_general/cerrar_session", {suggest: ""}, function(data){
              
              location.reload();
             
          });

      }

     
      function ver_perfil_usuario(){
        
        rest_modal("");
       
        $("#modal_footer").hide();
        $("#modal_title").hide();
        $("#modal_header").hide();
        $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });


        $.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_datos_usuario", {suggest: ""}, function(data){
              
               $("#modal_body").append(data);
               
          });

      }

      function cambio_contrasena_usuario(){

        rest_modal("");
       
        $("#modal_footer").hide();
        $("#modal_title").hide();
        $("#modal_header").hide();
        $('#myModal').modal({
                      backdrop: false,
                      show: true
                    });


        $.post("<?php echo base_url(); ?>index.php/Cnt_usuario/get_html_cambio_contrasena_usuario", {suggest: ""}, function(data){
              
               $("#modal_body").append(data);
               
               
          });


      }


</script>

<script type="text/javascript">
  
  setInterval("sincronizar_correos_enviados()", 9000);  //9 segundos 

  function sincronizar_correos_enviados(){

         $.post("<?php echo base_url(); ?>index.php/Cnt_correos/get_correos_enviados", {suggest: ""}, function(data){
               
               if(data == '"sess_out"'){

                  window.location.href = "";

               }

               data = JSON.parse(data);
               
               var fila = '<table class="table table-striped"><tbody>';

               fila = fila + '<thead><tr style="font-size:14px;"><th scope="col">Status</th><th scope="col">Reporte</th><th scope="col">Destinatario</th></tr></thead>';

               $.each(data, function( index, value ) {  

                if(value['status'] == '1'){

                  var status = 'Enviado';

                }else if(value['status'] == '0'){

                  var status = 'Error';
                
                }else if(value['status'] == '2'){

                  var status = 'No enviado';

                }

                if(value['status_script'] == '0'){

                  var status_script = 'Analizando';
                  $("#lbl_proceso_script").html('Correos enviados&nbsp;&nbsp;&nbsp;<span class="badge badge-danger" style="background-color: #28cc28a1;color: white;"><i class="fa fa-refresh">&nbsp;'+status_script+'</i></span>');

                }else if(value['status_script'] == '1'){

                  var status_script = 'Procesando';  
                  $("#lbl_proceso_script").html('Correos enviados&nbsp;&nbsp;&nbsp;<span class="badge badge-danger" style="background-color: #f9910b;color: white;"><i class="fa fa-server">&nbsp;'+status_script+'</i></span>');

                }

                
                if(value['status'] == '1'){
                  
                  fila = fila + '<tr style="color:#337ab7; font-size:12px;"><td><i class="glyphicon glyphicon-ok-circle" style="width: 28px; color:#97DE56; font-size:20px;"></i></td><td>'+value['nombre']+'</td><td>'+value['destinatario']+'</td></tr>';
                
                }else if(value['status'] == '0'){

                  fila = fila + '<tr style="color:#337ab7; font-size:12px;"><td><i class="glyphicon glyphicon-remove-circle" style="width: 28px; color:#FD7153; font-size:20px;"></i><td>'+value['nombre']+'</td><td>'+value['destinatario']+'</td></tr>';
                
                }else if(value['status'] == '2'){

                  fila = fila + '<tr style="color:#337ab7; font-size:12px;"><td><i class="glyphicon glyphicon-ban-circle" style="width: 28px; color:#fff; font-size:20px;"></i><td><td>'+value['nombre']+'</td><td>'+value['destinatario']+'</td></tr>';
                  
                }
                
               
               });

               fila = fila + '</tbody></table>';

               $("#div_correos_enviados").empty();
               $("#div_correos_enviados").append(fila);

               
          });



      }


</script>