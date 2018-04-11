<?php //print_array($landing);?>
<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Landing Page</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" name="nombre" value="<?= $landing->nombre ?>" class="form-control validate[required]"/>
                
                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?= $landing->descripcion ?></textarea>
                
                <label>Formulario de Contacto</label>
				<select class="form-control validate[required]" name="form">
				    <option value="1" <?php if($landing->formulario_contacto) echo 'selected'; ?>>Si</option>
				    <option value="0" <?php if(!$landing->formulario_contacto) echo 'selected'; ?>>No</option>
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
                        <?php if($imagenes->imagenes){ ?>
                            <?php foreach($imagenes->imagenes as $aux){ ?>
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
                
                            <label>Adjuntar imagen lateral tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px x <?php echo $this->img->recorte_alto_2; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-2" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-2">
                        <?php if($landing->imagen){ ?>
                            <div class="box" >
                    			<div rel="2" class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $landing->imagen; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $landing->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                </div>                                
        	</div>
            

            
           
			<div class="col-xs-12">
                <input type="hidden" name="codigo" value="<?= $landing->codigo?>"> </input>
				<div class="text-left" style="margin-top:20px;">
					<a href="/landing_pages/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div> 

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/landing_pages/eliminar-imagen/';
    var urlCargar = '/landing_pages/cargar-imagen/';
    var urlCortar = '/landing_pages/cortar-imagen/';
    
    var cargar=[];
    //cargar.push(1);
    <?php if(!$landing->imagen){ ?>
        cargar.push(2);
    <?php } ?>
    
	cargar_imagenes();
    cargar_imagen(cargar);
    
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>
