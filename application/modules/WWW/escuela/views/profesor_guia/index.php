<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Profesor Guía</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">

                <label>Nombre (*)</label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo ($informacion)?$informacion->nombre:''; ?>" />
                
                <label>Archivo Adjunto</label>
                <input type="file" class="form-control" name="archivo" />
                <?php if($informacion && $informacion->archivo_adjunto){ ?>
                    <div>
                        <div class="col-md-5">
                            <a href="/escuela/profesor-guia/descargar-archivo/<?php echo $informacion->codigo; ?>/">Descargar archivo</a>
                        </div>
                        <div class="col-md-1">
                            <a class="eliminar_archivo" rel="<?php echo $informacion->codigo; ?>" style="color: red; cursor: pointer;">X</a>
                        </div>
                    </div>
                <?php } ?>
                
            </div>
        </div>
        
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-10">

                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?php echo ($informacion)?$informacion->descripcion:''; ?></textarea>
                
            </div>
        </div>
        
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <label>Adjuntar imágenes tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($informacion && $informacion->imagen_adjunta){ ?>
                            <div class="box" >
                    			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $informacion->imagen_adjunta; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $informacion->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>
            </div>
        </div>
        
        <input type="hidden" name="codigo" value="<?php echo ($informacion)?$informacion->codigo:''; ?>" />
        <div class="row" >
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/escuela/profesor-guia/eliminar-imagen/';
    var urlCargar = '/escuela/profesor-guia/cargar-imagen/';
    var urlCortar = '/escuela/profesor-guia/cortar-imagen/';
    var galeria = false;
    <?php if($informacion && !$informacion->imagen_adjunta){ ?>
        cargar_imagen();
    <?php } elseif(!$informacion){ ?>
        cargar_imagen();
    <?php } ?>
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 32%;
}
</style>