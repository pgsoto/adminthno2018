<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Perfil</h1>
    </div>
    
    <form action="#" method="post" id="form-perfil" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $perfil->nombre; ?>" />
                
                <label>Email (*) </label>
                <input type="text" class="form-control validate[required,custom[email]]" name="email" value="<?php echo $perfil->email; ?>" />
                
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?php echo $perfil->telefono; ?>" />
                
                <fieldset style="display: none;margin-top: 10px;" class="cont-contrasena">
                    <label>Contraseña (*) </label>
                    <input type="password" class="form-control validate[required]" id="contrasena" name="contrasena" />
                    
                    <label>Confirmar contraseña (*) </label>
                    <input type="password" class="form-control validate[required,equals[contrasena]]" name="confirmar-contrasena" />
                    
                    <a href="#" class="cambiar-contrasena">Cancelar</a>
                </fieldset>
                
                <fieldset style="margin-top: 10px;" class="cont-contrasena">
                    <a href="#" class="cambiar-contrasena">Cambiar contraseña</a>
                </fieldset>
                
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>