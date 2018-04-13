<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Agregar Administrador</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" />
                
                <label>Email (*) </label>
                <input type="text" class="form-control validate[required,custom[email]]" name="email" />

                <label>Contraseña (*) </label>
                <input type="password" class="form-control validate[required]" id="contrasena" name="contrasena" />
                
                <label>Confirmar contraseña (*) </label>
                <input type="password" class="form-control validate[required,equals[contrasena]]" name="confirmar-contrasena" />
                            
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1">Activo</option>
				    <option value="0">Inactivo</option>
				</select>
                
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/configuracion/administradores/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>