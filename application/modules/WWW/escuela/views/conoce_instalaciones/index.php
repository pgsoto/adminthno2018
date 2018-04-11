<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Conoce Nuestras Instalaciones</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-10">

                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?php echo ($informacion)?$informacion->descripcion:''; ?></textarea>
                
            </div>
        </div>
        
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-10">
                <label>Adjuntar imágenes tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($informacion && $informacion->imagenes){ ?>
                            <?php foreach($informacion->imagenes as $aux){ ?>
                                <div class="box" >
                        			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                        <img class="croppedImg" src="<?php echo $aux->ruta_interna; ?>" />
                                        <div class="cropControls cropControlsUpload">
                                            <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $aux->codigo; ?>"></i>
                                        </div>
                                    </div>
                        		</div>
                            <?php } ?>
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
	var urlDelete = '/escuela/conoce-nuestras-instalaciones/eliminar-imagen/';
    var urlCargar = '/escuela/conoce-nuestras-instalaciones/cargar-imagen/';
    var urlCortar = '/escuela/conoce-nuestras-instalaciones/cortar-imagen/';
    var galeria = true;
    
    cargar_imagenes();
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 32%;
}
</style>