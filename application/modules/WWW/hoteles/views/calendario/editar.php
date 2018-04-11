<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Calendario</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $calendario->titulo; ?>" />
                
                <label>Sector</label>
                <input type="text" class="form-control" name="sector" value="<?php echo $calendario->sector; ?>" />
                
                <label>Hora inicio</label>
                <input type="text" class="form-control timepicker" name="hora_inicio" value="<?php echo date('H:i',strtotime($calendario->hora_inicio)); ?>" />
                
                <label>Hora término</label>
                <input type="text" class="form-control timepicker" name="hora_termino" value="<?php echo date('H:i',strtotime($calendario->hora_termino)); ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($calendario->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$calendario->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="url_hotel" value="<?php echo $hotel->url; ?>" />
            <input type="hidden" id="codigo" value="<?php echo $calendario->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/hoteles/<?php echo $hotel->url; ?>/calendario/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>