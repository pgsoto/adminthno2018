<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Agregar Landing Page</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" />
                
                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"></textarea>
                
                <label>Formulario de Contacto</label>
				<select class="form-control validate[required]" name="form">
				    <option value="1">SI</option>
				    <option value="0">NO</option>
				</select>
                
        	</div>
            
            <!-- imagenes -->
            <div class="col-md-5"> 
            
                <label>Adjuntar imágenes galeria tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1"></div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <!-- imagenes -->
            
            <label>Adjuntar imagen de fondo tamaño mínimo <?php echo $this->img->recorte_ancho_2; ?>px x <?php echo $this->img->recorte_alto_2; ?>px</label>
            <div class="multi-imagen" style="margin-bottom:20px;">
                <div style="display:none;" id="replicar-2" class="box">
        			<div class="img" style="width:<?php echo $this->img->min_ancho_2+2; ?>px; height:<?php echo $this->img->min_alto_2+2; ?>px;" ></div>
        		</div>
                <div id="cont-imagenes-2"></div>
            </div>                                
        	</div>
            
            
           
			<div class="col-xs-12">
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
	cargar_imagenes();
    var cargar = [];
    //cargar.push(1);
    cargar.push(2);
    cargar_imagen(cargar);
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>
