<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Introducción</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-10">

                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?php echo ($introduccion)?$introduccion->descripcion:''; ?></textarea>
                
            </div>
        </div>

        <input type="hidden" name="codigo" value="<?php echo ($introduccion)?$introduccion->codigo:''; ?>" />
        <input type="hidden" id="url_hotel" value="<?php echo $hotel->url; ?>" />
        <div class="row" >
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>