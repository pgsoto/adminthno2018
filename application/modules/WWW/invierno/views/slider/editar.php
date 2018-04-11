<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Slider</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $slider->titulo; ?>" />
                
                <label>Antetitulo </label>
                <input type="text" class="form-control" name="antetitulo" value="<?php echo $slider->antetitulo; ?>" />
                
                <label>Bajada</label>
                <textarea class="form-control" rows="3"  id="bajada" name="bajada"><?php echo $slider->bajada; ?></textarea>
                
                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($slider->imagen_adjunta){ ?>
                            <div class="box" >
                    			<div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $slider->imagen_adjunta; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $slider->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <label>URL Video</label>
                <input type="text" class="form-control" name="url-video" value="<?php echo $slider->url_video; ?>" />
                
                <label>Link</label>
                <input type="text" class="form-control" name="link" value="<?php echo $slider->link; ?>" />
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $slider->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($slider->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$slider->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="codigo" value="<?php echo $slider->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/invierno/slider/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/invierno/slider/eliminar-imagen/';
    var urlCargar = '/invierno/slider/cargar-imagen/';
    var urlCortar = '/invierno/slider/cortar-imagen/';
    var galeria = false;
    
    <?php if(!$slider->imagen_adjunta){ ?>
	   cargar_imagen();
    <?php } ?>
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>