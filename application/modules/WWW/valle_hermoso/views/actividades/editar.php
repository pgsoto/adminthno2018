<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Actividad</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $actividad->titulo; ?>" />

                <label>Bajada</label>
                <textarea class="form-control" rows="3"  id="bajada" name="bajada"><?php echo $actividad->bajada; ?></textarea>
                
                <label>Link</label>
                <input type="text" class="form-control" name="link" value="<?php echo $actividad->link; ?>" />
                
                <label>Nombre Link</label>
                <input type="text" class="form-control" name="nombre_link" value="<?php echo $actividad->nombre_link; ?>" />
                
                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($actividad->imagen_adjunta){ ?>
                            <div class="box" >
                    			<div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $actividad->imagen_adjunta; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $actividad->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px x <?php echo $this->img->recorte_alto_2; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-2" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-2">
                        <?php if($actividad->imagen_adjunta_2){ ?>
                            <div class="box" >
                    			<div rel="2" class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $actividad->imagen_adjunta_2; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $actividad->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                </div>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $actividad->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($actividad->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$actividad->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $actividad->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/valle-hermoso/actividades/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/valle-hermoso/actividades/eliminar-imagen/';
    var urlCargar = '/valle-hermoso/actividades/cargar-imagen/';
    var urlCortar = '/valle-hermoso/actividades/cortar-imagen/';
    var galeria = false;
    var cargar = [];
    <?php if(!$actividad->imagen_adjunta){ ?>
	   cargar.push(1);
    <?php } ?>
    <?php if(!$actividad->imagen_adjunta_2){ ?>
	   cargar.push(2);
    <?php } ?>
    
    cargar_imagen(cargar);
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>