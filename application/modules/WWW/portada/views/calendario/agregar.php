<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Agregar Calendario</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" enctype="multipart/form-data" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" />
                
                <label>Fecha inicio</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="fecha_inicio" name="fecha_inicio" />
                </div>
                
                <label>Hora inicio</label>
                <input type="text" class="form-control timepicker" name="hora_inicio" />
                
                <label>Sólo este día</label>
                <input type="checkbox" class="" id="solo_este_dia" name="solo_este_dia" value="1" />
                
                <label>Fecha término</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="fecha_termino" name="fecha_termino" />
                </div>
                
                <label>Hora término</label>
                <input type="text" class="form-control timepicker" name="hora_termino" />
                
                <label>Lugar</label>
                <input type="text" class="form-control" name="lugar" />
                
                <label>Resumen</label>
                <textarea class="form-control" name="resumen" rows="3"></textarea>
                
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                
                <label>Imagen adjunta. Tamaño mínimo 540px ancho</label>
                <input type="file" class="form-control" name="imagen" />
                
                <label>Categoría</label>
                <select class="form-control" name="categoria">
				    <option value="">Seleccione</option>
                    <?php if($categorias){ ?>
                        <?php foreach($categorias as $aux){ ?>
    				        <option value="<?php echo $aux->codigo; ?>" ><?php echo $aux->nombre; ?></option>
                        <?php } ?>
                    <?php } ?>
				</select>
                
                <label>Temporada</label>
                <select class="form-control" name="temporada">
				    <option value="">Seleccione</option>
                    <?php if($temporadas){ ?>
                        <?php foreach($temporadas as $aux){ ?>
    				        <option value="<?php echo $aux->codigo; ?>" ><?php echo $aux->nombre; ?></option>
                        <?php } ?>
                    <?php } ?>
				</select>
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" >Activo</option>
				    <option value="0" >Inactivo</option>
				</select>
                
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/portada/calendario/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>