esto es una prueba de git

<div class="row">

    <div class="col-md-12">
    
    <button type="button" class="btn btn-default" id="btn_actualizar" onclick="btn_actualizar_correo();"><span class="fa fa-edit" style="color: #EAB139;"></span>&nbsp;Actualizar
    </button>

    <button type="button" class="btn btn-default" id="btn_eliminar" onclick="btn_eliminar_correo();"><span class="fa fa-minus-square" style="color:#EA4C39;"></span>&nbsp;Eliminar
    </button>
    
    <button type="button" class="btn btn-default" id="btn_agregar" onclick="Reenviar_correo();"><span class="fa fa-share-square" style="color: #20C72C;"></span>&nbsp;Reenviar
    </button>

    </div>

    <div class="col-md-12">
          
        <div id="div_datagrid" style="height: 90%;">
               <table id="dg_con_correo" style="height: 95%;" sortName="id" sortOrder="asc" data-options="
                    singleSelect:true,
                    autoRowHeight:false,
                    pagination:true,
                    pageSize:50"></table>
        </div>
      
    </div>

</div>


