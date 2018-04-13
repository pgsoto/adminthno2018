<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Área de Trabajo</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $administrador->nombre; ?>" />
                
                <label>Email (*) </label>
                <input type="text" class="form-control validate[required,custom[email]]" name="email" value="<?php echo $administrador->email; ?>" />

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
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($administrador->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$administrador->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $administrador->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/configuracion/administradores/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>