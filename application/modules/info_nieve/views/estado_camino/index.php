<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Estado de Camino</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            
                <label>Estado de camino</label>
				<select class="form-control validate[required]" name="estado_de_camino">
				    <option <?php echo ($estado && $estado->estado_de_camino)?'selected':''; ?> value="1">Abierto</option>
				    <option <?php echo ($estado && !$estado->estado_de_camino)?'selected':''; ?> value="0">Cerrado</option>
				</select>
                
            	<label>Tránsito</label>
                <input type="text" class="form-control" name="transito" value="<?php echo ($estado)?$estado->transito:''; ?>" />
                
                <label>Porte de cadenas</label>
                <input type="text" class="form-control" name="porte_de_cadenas" value="<?php echo ($estado)?$estado->porte_de_cadenas:''; ?>" />
                
                <label>Uso de cadenas</label>
                <input type="text" class="form-control" name="uso_de_cadenas" value="<?php echo ($estado)?$estado->uso_de_cadenas:''; ?>" />
                
                <label>Horarios</label>
                <textarea class="form-control" rows="3"  id="horarios" name="horarios"><?php echo ($estado)?$estado->horarios:''; ?></textarea>
                
                <label>Observaciones</label>
                <textarea class="form-control" rows="3"  id="observaciones" name="observaciones"><?php echo ($estado)?$estado->observaciones:''; ?></textarea>
        	</div>
            
            <input type="hidden" name="codigo" value="<?php echo ($estado)?$estado->codigo:''; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>