<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Habitación</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Título (*) </label>
                <input type="text" class="form-control validate[required]" name="titulo" value="<?php echo $habitacion->titulo; ?>" />

                <label>Descripción</label>
                <textarea class="form-control" rows="3" id="descripcion" name="descripcion"><?php echo $habitacion->descripcion; ?></textarea>
  
                <label>Alineación galería</label>
				<select class="form-control validate[required]" name="alineacion_galeria">
				    <option value="1" <?php if($habitacion->alineacion_galeria == 1) echo 'selected'; ?>>Izquierda</option>
				    <option value="2" <?php if($habitacion->alineacion_galeria == 2) echo 'selected'; ?>>Derecha</option>
				</select>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $habitacion->orden; ?>" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($habitacion->estado) echo 'selected'; ?>>Activo</option>
				    <option value="0" <?php if(!$habitacion->estado) echo 'selected'; ?>>Inactivo</option>
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
                        <?php if($habitacion->imagenes){ ?>
                            <?php foreach($habitacion->imagenes as $aux){ ?>
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
            
            <input type="hidden" id="codigo" value="<?php echo $habitacion->codigo; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/valle-hermoso/habitaciones/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/valle-hermoso/habitaciones/eliminar-imagen/';
    var urlCargar = '/valle-hermoso/habitaciones/cargar-imagen/';
    var urlCortar = '/valle-hermoso/habitaciones/cortar-imagen/';
    var galeria = true;
    
    cargar_imagenes();
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>