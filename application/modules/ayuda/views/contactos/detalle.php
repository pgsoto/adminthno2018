<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Detalle Contacto</h1>
    </div>
    
    <form action="#" method="post" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre Completo</label>
                <input disabled="disabled" type="text" class="form-control" name="nombre_completo" value="<?php echo $contacto->nombre_completo; ?>" />
                
                <label>Teléfono</label>
                <input disabled="disabled" type="text" class="form-control" name="telefono" value="<?php echo $contacto->telefono; ?>" />
                
                <label>Fecha</label>
                <input disabled="disabled" type="text" class="form-control" name="fecha" value="<?php echo date('d/m/Y',strtotime($contacto->fecha)); ?>" />
                
                <label>Hora</label>
                <input disabled="disabled" type="text" class="form-control" name="hora" value="<?php echo date('H:i',strtotime($contacto->hora)); ?>" />
                
                <label>Email</label>
                <input disabled="disabled" type="text" class="form-control" name="email" value="<?php echo $contacto->email; ?>" />
                
                <label>Asunto</label>
                <input disabled="disabled" type="text" class="form-control" name="asunto" value="<?php echo $contacto->asuntos_contacto->nombre; ?>" />
                
                <label>Mensaje</label>
                <textarea disabled="disabled" class="form-control" name="mensaje" rows="5"><?php echo $contacto->mensaje; ?></textarea>
                
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/ayuda/contactos/" class="btn btn-can">Volver</a>
                </div>
			</div>
        </div>
    </form>
</div>