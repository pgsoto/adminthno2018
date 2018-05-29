<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1><?= $titulo; ?></h1>
    </div>
 
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">

                <label>Galería slider tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
                        <div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
                    </div>
                    <?php if(isset($result)) {?>
                        <div id="cont-imagenes-1">
                      
                                <?php foreach(array_reverse($result) as $aux){ ?>
                                    <div class="box" >
                                        <div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                            <img class="croppedImg" src="<?php echo $aux->imagen_ruta_interna; ?>" />
                                            <div class="cropControls cropControlsUpload">
                                                <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $aux->codigo; ?>"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                           
                        </div>
                    <?php }else{ ?>
                        <div id="cont-imagenes-1"></div>
                    <?php } ?>

                    <div id="rutas-imagenes"></div>
                </div>
        	</div>

            <input type="hidden" id="codigo_seccion" name="codigo_seccion" value="<?= $seccion; ?>" />
            <input type="hidden" id="codigo_subseccion" name="codigo_subseccion" value="<?=  $subseccion; ?>" />

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
	var urlDelete = '/tuciudad/barrios/subsecciones/eliminar-imagen-obras/';
    var urlCargar = '/tuciudad/barrios/subsecciones/cargar-imagen-obras/';
    var urlCortar = '/tuciudad/barrios/subsecciones/cortar-imagen-obras/';
    var galeria = true;

    var cargar=[];
    //cargar.push(1);
    <?php if(!isset($result->imagen_ruta_interna) || $result->imagen_ruta_interna == ''){ ?>
        cargar.push(2);
    <?php } ?>

    cargar_imagenes();
    cargar_imagen(cargar);

</script>