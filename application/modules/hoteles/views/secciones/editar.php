<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Sección</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $seccion->titulo; ?>" />
                
                <label>Bajada</label>
                <textarea class="form-control" rows="3"  id="bajada" name="bajada"><?php echo $seccion->bajada; ?></textarea>
                
                <label>Adjuntar imagen fondo tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($seccion->imagen_adjunta_fondo){ ?>
                            <div class="box" >
                    			<div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $seccion->imagen_adjunta_fondo; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $seccion->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <label>Adjuntar imagen lateral tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px x <?php echo $this->img->recorte_alto_2; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-2" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-2">
                        <?php if($seccion->imagen_adjunta_lateral){ ?>
                            <div class="box" >
                    			<div rel="2" class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $seccion->imagen_adjunta_lateral; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $seccion->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                </div>
                
                <label>Tipo Imagen</label>
				<select class="form-control validate[required]" name="tipo_imagen">
				    <option value="1" <?php if($seccion->tipo_de_imagen == 1) echo 'selected'; ?>>Fondo</option>
				    <option value="2" <?php if($seccion->tipo_de_imagen == 2) echo 'selected'; ?>>Lateral</option>
				</select>
                
                <label>Link</label>
                <input type="text" class="form-control" name="link" value="<?php echo $seccion->link; ?>" />
                
                <label>Nombre Link</label>
                <input type="text" class="form-control" name="nombre_link" value="<?php echo $seccion->nombre_link; ?>" />
                
                <label>Link 2</label>
                <input type="text" class="form-control" name="link_2" value="<?php echo $seccion->link_2; ?>" />
                
                <label>Nombre Link 2</label>
                <input type="text" class="form-control" name="nombre_link_2" value="<?php echo $seccion->nombre_link_2; ?>" />
                
                <label>Link 3</label>
                <input type="text" class="form-control" name="link_3" value="<?php echo $seccion->link_3; ?>" />
                
                <label>Nombre Link 3</label>
                <input type="text" class="form-control" name="nombre_link_3" value="<?php echo $seccion->nombre_link_3; ?>" />
                
                <label>Imagen adjunta</label>
                <input type="file" class="form-control" name="imagen" />
                <?php if($seccion->imagen_adjunta){ ?>
                    <img style="width: 100px;margin-top: 15px;" src="<?php echo $seccion->imagen_adjunta; ?>" />
                    <a class="eliminar_adjunto" rel="<?php echo $seccion->codigo;?>" style="cursor:pointer;">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				    </a>
                <?php } ?>
                
                <label>Nombre imagen adjunta</label>
                <input type="text" class="form-control" name="nombre_imagen_adjunta" value="<?php echo $seccion->nombre_imagen_adjunta; ?>" />
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $seccion->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($seccion->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$seccion->estado) echo 'selected'; ?>>Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="url_hotel" value="<?php echo $hotel->url; ?>" />
            <input type="hidden" id="codigo" value="<?php echo $seccion->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/hoteles/<?php echo $hotel->url; ?>/secciones/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/hoteles/secciones/eliminar-imagen/';
    var urlCargar = '/hoteles/secciones/cargar-imagen/';
    var urlCortar = '/hoteles/secciones/cortar-imagen/';
    var galeria = false;
    var cargar = [];
    <?php if(!$seccion->imagen_adjunta_fondo){ ?>
	   cargar.push(1);
    <?php } ?>
    
    <?php if(!$seccion->imagen_adjunta_lateral){ ?>
	   cargar.push(2);
    <?php } ?>
    
    if(cargar)
        cargar_imagen(cargar);
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>