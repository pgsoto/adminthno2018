<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Calendario</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" enctype="multipart/form-data" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $calendario->titulo; ?>" />
                
                <label>Fecha inicio</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" id="fecha_inicio" name="fecha_inicio" value="<?php echo ($calendario->fecha_inicio)?formatearFecha($calendario->fecha_inicio,false,'/'):''; ?>" />
                </div>
                
                <label>Hora inicio</label>
                <input type="text" class="form-control timepicker" name="hora_inicio" value="<?php echo ($calendario->hora_inicio)?date('H:i',strtotime($calendario->hora_inicio)):''; ?>" />
                
                <label>Sólo este día</label>
                <input type="checkbox" class="" id="solo_este_dia" name="solo_este_dia" value="1" <?php echo ($calendario->solo_este_dia)?'checked':''; ?> />
                
                <label>Fecha término</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    </div>
                    <input <?php echo ($calendario->solo_este_dia)?'disabled':''; ?> type="text" class="form-control pull-right datepicker" id="fecha_termino" name="fecha_termino" value="<?php echo ($calendario->fecha_termino)?formatearFecha($calendario->fecha_termino,false,'/'):''; ?>" />
                </div>
                
                <label>Hora término</label>
                <input type="text" class="form-control timepicker" name="hora_termino" value="<?php echo ($calendario->hora_inicio)?date('H:i',strtotime($calendario->hora_inicio)):''; ?>" />
                
                <label>Lugar</label>
                <input type="text" class="form-control" name="lugar" value="<?php echo $calendario->lugar; ?>" />
                
                <label>Resumen</label>
                <textarea class="form-control" name="resumen" rows="3"><?php echo $calendario->resumen; ?></textarea>
                
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"><?php echo $calendario->descripcion; ?></textarea>
                
                <label>Imagen adjunta. Tamaño mínimo 540px ancho</label>
                <input type="file" class="form-control" name="imagen" />
                <?php if($calendario->imagen_adjunta){ ?>
                    <img width="145" style="height: auto; margin-top:10px;" src="<?php echo $calendario->imagen_adjunta; ?>" />
                <?php } ?>
                
                <label>Categoría</label>
                <select class="form-control" name="categoria">
				    <option value="">Seleccione</option>
                    <?php if($categorias){ ?>
                        <?php foreach($categorias as $aux){ ?>
    				        <option <?php if($aux->codigo == $calendario->categoria) echo 'selected'; ?> value="<?php echo $aux->codigo; ?>" ><?php echo $aux->nombre; ?></option>
                        <?php } ?>
                    <?php } ?>
				</select>
                
                <label>Temporada</label>
                <select class="form-control" name="temporada">
				    <option value="">Seleccione</option>
                    <?php if($temporadas){ ?>
                        <?php foreach($temporadas as $aux){ ?>
    				        <option <?php if($aux->codigo == $calendario->temporada) echo 'selected'; ?> value="<?php echo $aux->codigo; ?>" ><?php echo $aux->nombre; ?></option>
                        <?php } ?>
                    <?php } ?>
				</select>
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option <?php if($calendario->estado) echo 'selected'; ?> value="1" >Activo</option>
				    <option <?php if(!$calendario->estado) echo 'selected'; ?>value="0" >Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $calendario->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/portada/calendario/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>