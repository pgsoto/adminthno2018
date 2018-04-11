<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Detalle Contacto</h1>
    </div>
    
    <form action="#" method="post" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            
            	<label>Código</label>
                <input disabled="disabled" type="text" class="form-control" name="codigo" value="<?php echo $newsletter->codigo; ?>" />
                
                <label>Nombre</label>
                <input disabled="disabled" type="text" class="form-control" name="nombre_completo" value="<?php echo $newsletter->nombre; ?>" />    

                <label>Email</label>
                <input disabled="disabled" type="text" class="form-control" name="telefono" value="<?php echo $newsletter->email; ?>" />
                
                <label>Intereses</label>
                <textarea disabled="disabled" class="form-control" name="mensaje" rows="5"><?php echo $newsletter->intereses; ?></textarea>
                
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/newsletter/" class="btn btn-can">Volver</a>
                </div>
			</div>
        </div>
    </form>
</div>