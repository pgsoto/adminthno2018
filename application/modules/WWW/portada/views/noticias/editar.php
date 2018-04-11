<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Noticia</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $noticia->titulo; ?>" />
                
                <label>Fecha publicación</label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    </div>
                    <input type="text" class="form-control pull-right datepicker" name="fecha_publicacion" value="<?php echo ($noticia->fecha_publicacion)?formatearFecha($noticia->fecha_publicacion,false,'/'):''; ?>" />
                </div>
                
                <label>Resumen</label>
                <textarea class="form-control" rows="3" name="resumen"><?php echo $noticia->resumen; ?></textarea>
                
                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?php echo $noticia->descripcion; ?></textarea>
                
                <label>Categoría</label>
				<select class="form-control" name="categoria">
				    <option value="">Seleccione</option>
				    <?php if($categorias){ ?>
    				    <?php foreach($categorias as $aux){ ?>
                            <option <?php if($noticia->categoria == $aux->codigo) echo 'selected'; ?> value="<?php echo $aux->codigo; ?>"><?php echo $aux->nombre; ?></option>
                        <?php } ?>
                    <?php } ?>
				</select>
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option <?php if($noticia->estado) echo 'selected'; ?> value="1">Activo</option>
				    <option <?php if(!$noticia->estado) echo 'selected'; ?> value="0">Inactivo</option>
				</select>
                
        	</div>
            
            <!-- imagenes -->
            <div class="col-md-5">
                <label>Adjuntar imágenes tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($noticia->imagenes){ ?>
                            <?php foreach($noticia->imagenes as $aux){ ?>
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
            
            <input type="hidden" id="codigo" value="<?php echo $noticia->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/portada/noticias/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/portada/noticias/eliminar-imagen/';
    var urlCargar = '/portada/noticias/cargar-imagen/';
    var urlCortar = '/portada/noticias/cortar-imagen/';
    var galeria = true;
    
    cargar_imagenes();
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>