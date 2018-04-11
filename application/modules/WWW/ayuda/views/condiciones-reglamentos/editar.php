<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Condiciones y Reglamentos</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $condicion->titulo; ?>" />
                
                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?php echo $condicion->descripcion; ?></textarea>
                
                <label>Archivo adjunto</label>
                <input type="file" class="form-control" name="archivo" />
                <?php if($condicion->archivo_adjunto){ ?>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-5">
                            <a href="/ayuda/condiciones-reglamentos/descargar-archivo/<?php echo $condicion->codigo; ?>/">Descargar Archivo</a>
                        </div>
                        <div class="col-md-1">
                            <a rel="<?php echo $condicion->codigo; ?>" class="eliminar_archivo" style="cursor:pointer;">
        						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        					</a>
                        </div>
                    </div>
                <?php } ?>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $condicion->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($condicion->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$condicion->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $condicion->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/ayuda/condiciones-reglamentos/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>