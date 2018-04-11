<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Nieve</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
                
            	<label>Nieve acumulada</label>
                <input type="text" class="form-control" name="nieve_acumulada" value="<?php echo ($nieve)?$nieve->nieve_acumulada:''; ?>" />
                
                <label>Nieve caída en las últimas 24 horas</label>
                <input type="text" class="form-control" name="nieve_caida_24h" value="<?php echo ($nieve)?$nieve->nieve_caida_24h:''; ?>" />
                
                <!--<label>Nieve caída en las últimas 48 horas</label>-->
                <!--<input type="text" class="form-control" name="nieve_caida_48h" value="<?php #echo ($nieve)?$nieve->nieve_caida_48h:''; ?>" />-->
                
                <!--<label>Nieve pisada en cancha</label>-->
                <!--<input type="text" class="form-control" name="nieve_pisada_canchas" value="<?php #echo ($nieve)?$nieve->nieve_pisada_canchas:''; ?>" />-->
                
                <label>Calidad de nieve</label>
                <input type="text" class="form-control" name="calidad_nieve" value="<?php echo ($nieve)?$nieve->calidad_nieve:''; ?>" />
                
                <label>Velocidad del viento</label>
                <input type="text" class="form-control" name="velocidad_viento" value="<?php echo ($nieve)?$nieve->velocidad_viento:''; ?>" />
                
            </div>
            
            <input type="hidden" name="codigo" value="<?php echo ($nieve)?$nieve->codigo:''; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>