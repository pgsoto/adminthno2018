<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Agregar Estado de Pista</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre pista (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" />
                
                <label>Dificultad (*) </label>
                <input type="text" class="form-control validate[required]" name="dificultad" />
                
                <label>Estado de pista</label>
				<select class="form-control validate[required]" name="estado_pista">
				    <option value="1">Abierta</option>
				    <option value="0">Cerrada</option>
				</select>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" />
                
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/info-nieve/estado-pistas/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>