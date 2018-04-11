<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Detalle Trabaja con Nosotros</h1>
    </div>
    
    <form action="#" method="post" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre Completo</label>
                <input disabled="disabled" type="text" class="form-control" name="nombre_completo" value="<?php echo $trabaja->nombre_completo; ?>" />
                
                <label>Teléfono</label>
                <input disabled="disabled" type="text" class="form-control" name="telefono" value="<?php echo $trabaja->telefono; ?>" />
                
                <label>Fecha</label>
                <input disabled="disabled" type="text" class="form-control" name="fecha" value="<?php echo date('d/m/Y',strtotime($trabaja->fecha)); ?>" />
                
                <label>Hora</label>
                <input disabled="disabled" type="text" class="form-control" name="hora" value="<?php echo date('H:i',strtotime($trabaja->hora)); ?>" />
                
                <label>Email</label>
                <input disabled="disabled" type="text" class="form-control" name="email" value="<?php echo $trabaja->email; ?>" />
                
                <label>Ára de trabajo</label>
                <input disabled="disabled" type="text" class="form-control" name="area" value="<?php echo ($trabaja->areas_trabajo)?$trabaja->areas_trabajo->nombre:''; ?>" />
                
                <label>Archivo adjunto</label>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-5">
                        <?php if($trabaja->archivo_adjunto){ ?>
                            <a href="/ayuda/trabaja-con-nosotros/descargar-archivo/<?php echo $trabaja->codigo; ?>/">Descargar Archivo</a>
                        <?php } else{ ?>
                            <p style="font-size: 11px;">Sin archivo adjunto</p>
                        <?php } ?>
                    </div>
                </div>
        	</div>
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/ayuda/trabaja-con-nosotros/" class="btn btn-can">Volver</a>
                </div>
			</div>
        </div>
    </form>
</div>