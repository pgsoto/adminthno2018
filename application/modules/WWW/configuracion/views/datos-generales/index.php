<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Datos Generales</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
    
        <!-- metadatos -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            
            <div class="col-md-5">
                <h3>Metadatos</h3>
                
            	<label>Título de Página</label>
                <input type="text" class="form-control" name="metadato_titulo" value="<?php echo ($datos)?$datos->metadato_titulo:''; ?>" />
                
                <label>Descripción</label>
                <textarea class="form-control" name="metadato_descripcion" rows="3"><?php echo ($datos)?$datos->metadato_descripcion:''; ?></textarea>
                
                <label>Palabras Claves</label>
                <textarea class="form-control" name="metadato_keywords" rows="3"><?php echo ($datos)?$datos->metadato_keywords:''; ?></textarea>
        	</div>
       	</div>
        
        <!-- reservas -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            
            <div class="col-md-5">
                <h3>Reservas</h3>
                
            	<label>Teléfono de Reserva</label>
                <input type="text" class="form-control" name="reserva_telefono" value="<?php echo ($datos)?$datos->reserva_telefono:''; ?>" />
                
                <label>Teléfono Desde el Extranjero</label>
                <input type="text" class="form-control" name="reserva_telefono_extranjero" value="<?php echo ($datos)?$datos->reserva_telefono_extranjero:''; ?>" />
                
                <label>Email de Reserva</label>
                <input type="text" class="form-control validate[custom[email]]" name="reserva_email" value="<?php echo ($datos)?$datos->reserva_email:''; ?>" />
            </div>
        </div>
            
        <!-- oficina chillan -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <h3>Oficina Chillán</h3>
                
            	<label>Teléfono</label>
                <input type="text" class="form-control" name="chillan_telefono" value="<?php echo ($datos)?$datos->chillan_telefono:''; ?>" />
                
                <label>Email</label>
                <input type="text" class="form-control validate[custom[email]]" name="chillan_email" value="<?php echo ($datos)?$datos->chillan_email:''; ?>" />
                
                <label>Horario</label>
                <textarea class="form-control" name="chillan_horario" rows="3"><?php echo ($datos)?$datos->chillan_horario:''; ?></textarea>
            </div>
        </div>
        
        <!-- oficina concepcion -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <h3>Oficina Concepción</h3>
                
            	<label>Teléfono</label>
                <input type="text" class="form-control" name="concepcion_telefono" value="<?php echo ($datos)?$datos->concepcion_telefono:''; ?>" />
                
                <label>Email</label>
                <input type="text" class="form-control validate[custom[email]]" name="concepcion_email" value="<?php echo ($datos)?$datos->concepcion_email:''; ?>" />
                
                <label>Horario</label>
                <textarea class="form-control" name="concepcion_horario" rows="3"><?php echo ($datos)?$datos->concepcion_horario:''; ?></textarea>
            </div>
        </div>
        
        <!-- oficina santiago -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <h3>Oficina Santiago</h3>
                
            	<label>Teléfono</label>
                <input type="text" class="form-control" name="santiago_telefono" value="<?php echo ($datos)?$datos->santiago_telefono:''; ?>" />
                
                <label>Email</label>
                <input type="text" class="form-control validate[custom[email]]" name="santiago_email" value="<?php echo ($datos)?$datos->santiago_email:''; ?>" />
                
                <label>Horario</label>
                <textarea class="form-control" name="santiago_horario" rows="3"><?php echo ($datos)?$datos->santiago_horario:''; ?></textarea>
            </div>
        </div>
            
        <!-- redes sociales -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <h3>Redes Sociales</h3>
                
            	<label>Facebook</label>
                <input type="text" class="form-control" name="facebook" value="<?php echo ($datos)?$datos->facebook:''; ?>" />
                
                <label>Instagram</label>
                <input type="text" class="form-control" name="instagram" value="<?php echo ($datos)?$datos->instagram:''; ?>" />
                
                <label>Twitter</label>
                <input type="text" class="form-control" name="twitter" value="<?php echo ($datos)?$datos->twitter:''; ?>" />
                
                <label>Youtube</label>
                <input type="text" class="form-control" name="youtube" value="<?php echo ($datos)?$datos->youtube:''; ?>" />
             
             </div>
            
            <input type="hidden" name="codigo" value="<?php echo ($datos)?$datos->codigo:''; ?>" />
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>