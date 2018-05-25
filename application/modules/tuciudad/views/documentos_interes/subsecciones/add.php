<div class="col-sm-10 text-left marg-fix">
    <div class="titulo-btn">
        <h1><?= $titulo; ?></h1>
    </div>

    <form action="#" method="post" id="form-agregar">
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <label>Nombres (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre"
                       value="<?= isset($result->nombre) ? $result->nombre : ''; ?>"/>

                <label>Orden (*) </label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden"
                       value="<?= isset($result->orden) ? $result->orden : ''; ?>"/>

                <label>Galería slider tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px
                    x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
                        <div class="img"
                             style="width:<?php echo $this->img->min_ancho_1 + 2; ?>px; height:<?php echo $this->img->min_alto_1 + 2; ?>px;"></div>
                    </div>
                    <?php if (isset($result)) { ?>
                        <div id="cont-imagenes-1">
                            <?php if ($result->imagenes) { ?>
                                <?php foreach ($result->imagenes as $aux) { ?>
                                    <div class="box">
                                        <div rel="1" class="img"
                                             style="width:<?php echo $this->img->min_ancho_1 + 2; ?>px; height:<?php echo $this->img->min_alto_1 + 2; ?>px;">
                                            <img class="croppedImg" src="<?php echo $aux->imagen_ruta_interna; ?>"/>
                                            <div class="cropControls cropControlsUpload">
                                                <i class="cropControlRemoveCroppedImage eliminar_imagen"
                                                   rel="<?php echo $aux->codigo; ?>"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div id="cont-imagenes-1"></div>
                    <?php } ?>

                    <div id="rutas-imagenes"></div>
                </div>

                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px
                    x <?php echo $this->img->recorte_alto_2; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-2" class="box">
                        <div class="img"
                             style="width:<?php echo $this->img->min_ancho_2 + 2; ?>px; height:<?php echo $this->img->min_alto_2 + 2; ?>px;"></div>
                    </div>
                    <?php if (isset($result)) { ?>
                        <div id="cont-imagenes-2">
                            <?php if ($result->imagen_ruta_interna) { ?>
                                <div class="box">
                                    <div rel="2" class="img"
                                         style="width:<?php echo $this->img->min_ancho_2 + 2; ?>px; height:<?php echo $this->img->min_alto_2 + 2; ?>px;">
                                        <img class="croppedImg" src="<?php echo $result->imagen_ruta_interna; ?>"/>
                                        <div class="cropControls cropControlsUpload">
                                            <i class="cropControlRemoveCroppedImage eliminar_imagen"
                                               rel="<?php echo $result->codigo; ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div id="cont-imagenes-2"></div>
                    <?php } ?>
                </div>

                <label>Descripción</label>
                <textarea class="form-control" rows="3" id="descripcion"
                          name="descripcion"><?= isset($result->descripcion) ? $result->descripcion : ''; ?></textarea>

                <label>Código Revista</label>
                <textarea class="form-control" rows="3" id="codigo_revista"
                          name="codigo_revista"><?= isset($result->codigo_revista) ? $result->codigo_revista : ''; ?></textarea>

                <label>Estado</label>
                <select class="form-control validate[required]" name="estado">
                    <option <?= (isset($result->estado) && $result->estado == 1) ? 'selected' : ''; ?> value="1">
                        Activo
                    </option>
                    <option <?= (isset($result->estado) && $result->estado == 0) ? 'selected' : ''; ?> value="0">
                        Inactivo
                    </option>
                </select>

            </div>

            <input type="hidden" id="seccion" name="seccion" value="<?= $seccion; ?>"/>

            <input type="hidden" id="codigo" name="codigo"
                   value="<?= isset($result->codigo) ? $result->codigo : '0'; ?>"/>

            <div class="col-xs-12">
                <div class="text-left" style="margin-top:20px;">
                    <a href="/tuciudad/documentos-interes/subsecciones/<?= $seccion; ?>/" class="btn btn-can">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    CKEDITOR.replace('descripcion');
</script>

<script>
    //configuracion para imagenes
    var id = 1;
    var urlDelete = '/tuciudad/documentos-interes/subsecciones/eliminar-imagen/';
    var urlCargar = '/tuciudad/documentos-interes/subsecciones/cargar-imagen/';
    var urlCortar = '/tuciudad/documentos-interes/subsecciones/cortar-imagen/';
    var galeria = true;

    var cargar = [];
    //cargar.push(1);
    <?php if(!isset($result->imagen_ruta_interna) || $result->imagen_ruta_interna == ''){ ?>
    cargar.push(2);
    <?php } ?>

    cargar_imagenes();
    cargar_imagen(cargar);

</script>