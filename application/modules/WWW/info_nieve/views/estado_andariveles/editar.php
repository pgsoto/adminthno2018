<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Estado de Andarivel</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre andarivel (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $estado->nombre; ?>" />
                
                <label>Estado de andarivel</label>
				<select class="form-control validate[required]" name="estado_andarivel">
				    <option <?php if($estado->estado_andarivel) echo 'selected'; ?> value="1">Abierta</option>
				    <option <?php if(!$estado->estado_andarivel) echo 'selected'; ?> value="0">Cerrada</option>
				</select>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $estado->orden; ?>" />
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $estado->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/info-nieve/estado-andariveles/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>