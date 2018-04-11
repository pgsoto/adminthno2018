<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Editar Promoción</h1>
    </div>
    
    <form action="#" method="post" id="form-editar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?php echo $promocion->nombre; ?>" />
                
                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?php echo $promocion->descripcion; ?></textarea>
                
                <label>Adjuntar imagen banner tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1">
                        <?php if($promocion->imagen_adjunta_banner){ ?>
                            <div class="box" >
                    			<div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $promocion->imagen_adjunta_banner; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $promocion->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <label>Adjuntar imagen detalle tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px x <?php echo $this->img->recorte_alto_2; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-2" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-2">
                        <?php if($promocion->imagen_adjunta_detalle){ ?>
                            <div class="box" >
                    			<div rel="2" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $promocion->imagen_adjunta_detalle; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $promocion->codigo; ?>"></i>
                                    </div>
                                </div>
                    		</div>
                        <?php } ?>
                    </div>
                </div>
                
                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?php echo $promocion->orden; ?>" />
                
                <div class="form-group">
                    <label>Hoteles</label>
                    <?php if($hoteles){ ?>
                        <?php foreach($hoteles as $aux){ ?>
                            <div class="checkbox">
                                <label>
                                    <?php
                                        $checked = '';
                                        foreach($promocion->hoteles as $ho){
                                            if($ho->hotel == $aux->codigo)
                                                $checked = 'checked';
                                        }
                                    ?>
                                    <input type="checkbox" <?php echo $checked; ?> value="<?php echo $aux->codigo; ?>" name="hoteles[]" />
                                    <?php echo $aux->nombre; ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if($promocion->invierno)
                                    $checked = 'checked';
                            ?>
                            <input <?php echo $checked; ?> type="checkbox" value="1" name="invierno" />
                            Invierno
                        </label>
                        <label>
                            <?php
                                $checked2 = '';
                                if($promocion->verano)
                                    $checked2 = 'checked';
                            ?>
                            <input <?php echo $checked2; ?> type="checkbox" value="1" name="verano" />
                            Verano  
                        </label>   
                        
                         <label>
                            <?php
                                $checked3 = '';
                                if($promocion->evento)
                                    $checked3 = 'checked';
                            ?>
                            <input <?php echo $checked3; ?> type="checkbox" value="1" name="evento" />
                            Eventos 
                        </label>
                        
                          
                        
                    </div>
                </div>
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" <?php if($promocion->estado) echo 'selected'; ?> >Activo</option>
				    <option value="0" <?php if(!$promocion->estado) echo 'selected'; ?> >Inactivo</option>
				</select>
            </div>
        </div>
        
        <div class="row" style="margin-top:30px;">
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-xs-5">Nombre Archivo</th>
            				<th class="col-xs-2">Archivo</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="cont-archivos">
                        <tr id="archivo-base" style="display: none;">
                            <td><input type="text" class="form-control" name="nombre_archivo[]" /></td>
                            <td><input type="file" name="archivos[]" /></td>
                            <td class="text-center">
    							<a class="eliminar_archivo" rel="" style="cursor:pointer;">
    								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
    							</a>
    						</td>
                        </tr>
                        
                        <?php if($promocion->archivos){ ?>
                            <?php foreach($promocion->archivos as $k=>$aux){ ?>
                                <tr>
                                    <td><input type="text" class="form-control" name="nombre_archivo[]" value="<?php echo $aux->nombre; ?>" /></td>
                                    <td><a href="/promociones/descargar-archivo/<?php echo $aux->codigo;?>/">Descargar archivo</a></td>
                                    <td class="text-center">
                                        <?php if($k == 0){ ?>
                                            <a class="eliminar_archivo" rel="<?php echo $aux->codigo;?>" style="cursor:pointer;">
                								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                							</a>
                                            
                                            <a class="nuevo_archivo" style="cursor:pointer;">
                								<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                							</a>
                                        <?php }else{ ?>
                                            <a class="eliminar_archivo" rel="<?php echo $aux->codigo;?>" style="cursor:pointer;">
                								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                							</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                            <tr>
                                <td><input type="text" class="form-control" name="nombre_archivo[]" /></td>
                                <td><input type="file" name="archivos[]" /></td>
                                <td class="text-center">
                                    <a class="nuevo_archivo" style="cursor:pointer;">
        								<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
        							</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        	</div>
        </div>
        
        <input type="hidden" id="codigo" value="<?php echo $promocion->codigo; ?>" />
        <div class="row" >
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/promociones/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/promociones/eliminar-imagen/';
    var urlCargar = '/promociones/cargar-imagen/';
    var urlCortar = '/promociones/cortar-imagen/';
    var galeria = false; 
    
    var cargar = [];
    
    <?php if(!$promocion->imagen_adjunta_banner){ ?>
        cargar.push(1);
    <?php } ?>
    
    <?php if(!$promocion->imagen_adjunta_detalle){ ?>
        cargar.push(2);
    <?php } ?>
    
    cargar_imagen(cargar);
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>