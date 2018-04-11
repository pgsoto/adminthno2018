<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Agregar Landing Page</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" />
                
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" />
                
                <label>Correo </label>
                <input type="text" class="form-control" name="correo" />
                
                <label>Mensaje</label>
                <textarea class="form-control" rows="3"  id="mensaje" name="mensaje"></textarea>
                
                <label>Landing</label>
				<select class="form-control validate[required]" name="landing">
				    <?php foreach($landings as $landing){ ?> 
                        <option value="<?= $landing->codigo ?>"><?= $landing->nombre ?></option>
                    <?php } ?>
				</select>
                
        	</div>
                        
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/contactos_landing/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div> 

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/contactos_landing/eliminar-imagen/';
    var urlCargar = '/contactos_landing/cargar-imagen/';
    var urlCortar = '/contactos_landing/cortar-imagen/';
	cargar_imagenes();
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>
