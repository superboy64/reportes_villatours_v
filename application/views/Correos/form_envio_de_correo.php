<script type="text/javascript">
  $("#title").html('<?=$title?>');
</script>

  <div class="col-md-12">

     <div class="row">

        <div class="col-md-6">
          <label>Destinatario</label>
          <input type="text" spellcheck="false" class="form-control" id="txt_destinatarios_correo">
          <small id="emailHelp" class="form-text text-muted">para introducir varios correos utilizar el formato correo@prueba/correo@prueba2</small>
        </div>
        <div class="col-md-6">
          <label>Copia</label>
          <input type="text" spellcheck="false" class="form-control" id="txt_concopia_correo">
          <small id="emailHelp" class="form-text text-muted">para introducir varios correos utilizar el formato correo@prueba/correo@prueba2</small>
        </div>
        <div class="col-md-6">
          <label>Asunto</label>
          <input type="text" spellcheck="false" class="form-control" id="txt_asunto_correo">
        </div>

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-2" id="div_intervalo">
               <label>Intervalo</label>
                <select class="form-control" style="width: 172px;" id="slc_intervalo_correo">
                  <option value="0">seleccione</option>
                  <option value="1">diariamente</option>
                  <option value="5">diariamente(24 hrs)</option>
                  <option value="2">semanalmente</option>
                  <option value="4">quincenal</option>
                  <option value="3">mensualmente</option>
                </select>
            </div>
            <div class="col-md-2" id="div_fecha_inicio">
              <label>Fecha Envio:&nbsp;</label><br>
              <input class="form-control" type="text" id="txt_fecha" name="txt_fecha" style="height: 34px; border: 1px solid #cccccc;text-align: center;border-radius: 5px;"/>
            </div>
            <div class="col-md-2" id="div_hora">
              <label>Hora:&nbsp;</label><br>
              <input class="form-control" type="time" id="txt_hora">
            </div>

            <div class="form-check" id="div_dia_semana">
              <label>Dia:&nbsp;</label><br>
              <input type="checkbox" class="form-check-input" id="check_lunes">
              <label class="form-check-label" for="check_lunes">Lunes</label>
              <input type="checkbox" class="form-check-input" id="check_martes">
              <label class="form-check-label" for="check_martes">Martes</label>
              <input type="checkbox" class="form-check-input" id="check_miercoles">
              <label class="form-check-label" for="check_miercoles">Miercoles</label>
              <input type="checkbox" class="form-check-input" id="check_jueves">
              <label class="form-check-label" for="check_jueves">Jueves</label>
              <input type="checkbox" class="form-check-input" id="check_viernes">
              <label class="form-check-label" for="check_viernes">Viernes</label>
              <input type="checkbox" class="form-check-input" id="check_sabado">
              <label class="form-check-label" for="check_sabado">sabado</label>
              <input type="checkbox" class="form-check-input" id="check_domingo">
              <label class="form-check-label" for="check_domingo">domingo</label>
            </div>

            <div class="col-md-2" id="div_dia_mes">
              <label>Dia:&nbsp;</label><br>
              <input class="form-control" type="text" id="txt_dia_mes" name="txt_dia_mes" style="height: 34px; border: 1px solid #cccccc;text-align: center;border-radius: 5px;"/>
            </div>

          </div>

        </div>

    </div>

  </div>
  
  <div class="col-md-12">
  <br>
  </div>
  
  <div class="col-md-12">

   <div class="row">

        <div class="col-md-12">
          <div class="row">
            <div class="col-md-5">

              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h1 class="panel-title" style="color: #fff;">
                    

                      <div class="col-md-12">
                       
                        <div class="row">

                          <div class="col-md-8">
                            Seleccionar un reporte
                          </div>
                         

                        </div>
                      </div>

                 
                  </h1>
                 
                </div>
                <div class="panel-body" style="height: 191px;overflow-y:hidden;" >
                  <table id="dg_reportes" style="height: 191px;"></table>
                </div>
              </div>

            </div>

            <div class="col-md-1">
                 <center>

                   <button type="button" class="btn btn-default" style="margin-top: 89px;" onclick="seleccionar();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

                   </button>

                   <button type="button" class="btn btn-default" style="margin-top: 8px;" onclick="deseleccionar();">

                     &nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

                   </button>

                 </center>
               
            </div>

            <div class="col-md-5">

              <div class="panel panel-primary">
                <div class="panel-heading">
                  <h1 class="panel-title" style="color: #fff;">Reportes seleccionados</h1>
                 
                </div>
                <div class="panel-body" style="height: 191px;overflow-y:hidden;">
                  
                  <table id="dg_reportes_seleccionados" style="height: 191px;"></table>

                </div>
              </div>

            </div>

           </div>
        </div>

        <div class="col-md-12">
            <br>
            <label>Mensaje personalizado:&nbsp;</label><br>
            <input id="tipo_msn" type="checkbox" data-toggle="toggle" data-size="mini">
        </div>

        <div class="col-md-12" id="div_text_area">
                  <br>
                  <label>Mensaje:&nbsp;</label>
                  <textarea name="textarea" id="txt_msn" class="jqte-test" style="margin-top: 2px;"></textarea>
        </div>

  </div>
  <br>
  <button class="btn btn-primary" onclick="guardar_config_envio_de_correos();"><i class="fa fa-save">&nbsp;Guardar Configuracion</i></button>

  <div class="form-group" id="div_filtros">
    
  </div>

</div>

<script type="text/javascript">
   $('#tipo_msn').bootstrapToggle();
</script>