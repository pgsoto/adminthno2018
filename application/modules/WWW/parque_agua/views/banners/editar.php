<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Banner</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $banner->nombre; ?>" />

                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($banner->imagen_adjunta){ ?>
                            <div class="box" >
                    			<div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $banner->imagen_adjunta; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $banner->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <label>Link</label>
                <input type="text" class="form-control" name="link" value="<?php echo $banner->link; ?>" />

                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $banner->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($banner->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$banner->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="url_hotel" value="<?php echo $hotel->url; ?>" />
            <input type="hidden" id="codigo" value="<?php echo $banner->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/parque-agua/banners/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/parque-agua/banners/eliminar-imagen/';
    var urlCargar = '/parque-agua/banners/cargar-imagen/';
    var urlCortar = '/parque-agua/banners/cortar-imagen/';
    var galeria = false;
    
    <?php if(!$banner->imagen_adjunta){ ?>
	   cargar_imagen();
    <?php } ?>
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>