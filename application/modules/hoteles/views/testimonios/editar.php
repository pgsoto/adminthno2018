<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Testimonio</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $testimonio->nombre; ?>" />
                
                <label>Fecha</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" name="fecha" value="<?php echo ($testimonio->fecha)?formatearFecha($testimonio->fecha,false,'/'):''; ?>" />
                </div>
                
                <label>Testimonio</label>
                <textarea class="form-control" rows="5"  id="testimonio" name="testimonio"><?php echo $testimonio->testimonio; ?></textarea>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $testimonio->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($testimonio->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$testimonio->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="url_hotel" value="<?php echo $hotel->url; ?>" />
            <input type="hidden" id="codigo" value="<?php echo $testimonio->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/hoteles/<?php echo $hotel->url; ?>/testimonios/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>