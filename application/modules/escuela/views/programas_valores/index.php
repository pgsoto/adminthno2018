<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Programas y valores</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-10">
                <textarea class="form-control" rows="5"  id="contenido" name="contenido"><?php echo ($programa)?$programa->contenido:''; ?></textarea>
        	</div>
            
            <input type="hidden" name="codigo" value="<?php echo ($programa)?$programa->codigo:''; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>