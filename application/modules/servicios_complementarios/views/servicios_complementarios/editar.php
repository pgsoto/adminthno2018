<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Servicio Complementario</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $servicio_complementario->nombre; ?>" />
                
                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($servicio_complementario->imagen_adjunta){ ?>
                            <div class="box" >
                    			<div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $servicio_complementario->imagen_adjunta; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $servicio_complementario->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>

                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $servicio_complementario->orden; ?>" />
                
                <div class="form-group">
                    <label>Secciones</label>
                    <?php if($tipo_secciones){ ?>
                        <?php foreach($tipo_secciones as $aux){ ?>
                            <div class="checkbox">
                                <label>
                                    <?php
                                        $checked = '';
                                        foreach($servicio_complementario->secciones as $sec){
                                            if($sec->tipo_seccion == $aux->codigo)
                                                $checked = 'checked';
                                        }
                                    ?>
                                    <input type="checkbox" <?php echo $checked; ?> value="<?php echo $aux->codigo; ?>" name="secciones[]" />
                                    <?php echo $aux->nombre; ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($servicio_complementario->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$servicio_complementario->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $servicio_complementario->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/servicios-complementarios/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/servicios-complementarios/eliminar-imagen/';
    var urlCargar = '/servicios-complementarios/cargar-imagen/';
    var urlCortar = '/servicios-complementarios/cortar-imagen/';
    var galeria = false;
    <?php if(!$servicio_complementario->imagen_adjunta){ ?>
	   cargar_imagen();
    <?php } ?>
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>