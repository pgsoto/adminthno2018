<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1><?= $titulo; ?></h1>
    </div>
    <?php foreach($tipos_documentos as $tipdoc){ ?>
    <a href="/municipio/consejo/documentos/<?= $tipdoc->codigo; ?>" class="btn btn-primary"><?= $tipdoc->nombre; ?></a>
    <?php } ?>
    <a href="/municipio/consejo/integrantes/" class="btn btn-primary">Integrantes</a>
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
                <!--<label>Nombre (*) </label>-->
                <input type="hidden" class="form-control" name="nombre" value="<?= isset($result->nombre) ? $result->nombre : ''; ?>" />

                <label>Galería slider tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
                        <div class="img" style="width:<?php echo $this->img->min_ancho_1/4+2; ?>px; height:<?php echo $this->img->min_alto_1/4+2; ?>px;" ></div>
                    </div>
                    <?php if(isset($result)) {?>
                        <div id="cont-imagenes-1">
                            <?php if($result->imagenes){ ?>
                                <?php foreach(array_reverse($result->imagenes) as $aux){ ?>
                                    <div class="box" >
                                        <div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1/4+2; ?>px; height:<?php echo $this->img->min_alto_1/4+2; ?>px;" >
                                            <img class="croppedImg" src="<?php echo $aux->imagen_ruta_interna; ?>" />
                                            <div class="cropControls cropControlsUpload">
                                                <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $aux->codigo; ?>"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <div id="cont-imagenes-1"></div>
                    <?php } ?>

                    <div id="rutas-imagenes"></div>
                </div>

                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px x <?php echo $this->img->recorte_alto_2; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-2" class="box">
                        <div class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" ></div>
                    </div>
                    <?php if(isset($result)) { ?>
                        <div id="cont-imagenes-2">
                            <?php if($result->imagen_ruta_interna){ ?>
                                <div class="box" >
                                    <div rel="2" class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" >
                                        <img class="croppedImg" src="<?php echo $result->imagen_ruta_interna; ?>" />
                                        <div class="cropControls cropControlsUpload">
                                            <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $result->codigo; ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }else{ ?>
                        <div id="cont-imagenes-2"></div>
                    <?php } ?>
                </div>

                <label>Reseña e integrantes</label>
                <textarea class="form-control" rows="3"  id="resena_integrantes" name="resena_integrantes"><?= isset($result->resena_integrantes) ? $result->resena_integrantes : ''; ?></textarea>

                <label>Funciones</label>
                <textarea class="form-control" rows="3"  id="funciones" name="funciones"><?= isset($result->funciones) ? $result->funciones : ''; ?></textarea>

                <label>Sessiones</label>
                <textarea class="form-control" rows="3"  id="sesiones" name="sesiones"><?= isset($result->sesiones) ? $result->sesiones : ''; ?></textarea>

                <?php /*
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
                    <option <?= (isset($result->estado) && $result->estado == 1) ? 'selected' : ''; ?> value="1">Activo</option>
                    <option <?= (isset($result->estado) && $result->estado == 0) ? 'selected' : ''; ?> value="0">Inactivo</option>
				</select>
                */ ?>

        	</div>

            <input type="hidden" id="codigo" name="codigo" value="<?= isset($result->codigo) ? $result->codigo : ''; ?>" />

			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<!--<a href="/municipio/consejo/" class="btn btn-can">Cancelar</a>-->
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    CKEDITOR.replace( 'resena_integrantes' );
    CKEDITOR.replace( 'funciones' );
    CKEDITOR.replace( 'sesiones' );
</script>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/municipio/consejo/eliminar-imagen/';
    var urlCargar = '/municipio/consejo/cargar-imagen/';
    var urlCortar = '/municipio/consejo/cortar-imagen/';
    var galeria = true;

    var cargar=[];
    //cargar.push(1);
    <?php if(!isset($result->imagen_ruta_interna) || $result->imagen_ruta_interna == ''){ ?>
    cargar.push(2);
    <?php } ?>

    cargar_imagenes();
    cargar_imagen(cargar);

</script>