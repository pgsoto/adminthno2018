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
                
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?php echo $administrador->telefono; ?>" />
                
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
                
                <div class="form-group">
                    <label>Permisos</label>
                    <?php if($secciones){ ?>
                        <?php foreach($secciones as $aux){ ?>
                            <?php
                                $checked = '';
                                if($administrador->secciones){
                                    foreach($administrador->secciones as $sec){
                                        if($sec->seccion == $aux->codigo)
                                            $checked = 'checked';
                                    }
                                }
                            ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" <?php echo $checked; ?> class="secciones" name="secciones[]" value="<?php echo $aux->codigo; ?>" /><?php echo $aux->nombre; ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                
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