<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Agregar Banner</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" />

                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
            			<div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
            		</div>
                    <div id="cont-imagenes-1"></div>
                    <div id="rutas-imagenes"></div>
                </div>
                
                <label>Link</label>
                <input type="text" class="form-control" name="link" />

                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" />
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
				    <option value="1" >Activo</option>
				    <option value="0" >Inactivo</option>
				</select>
                
        	</div>
            
            <input type="hidden" id="url_hotel" value="<?php echo $hotel->url; ?>" />
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/parque-agua/banners/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
	var id = 1;
	var urlDelete = '/parque-agua/banners/eliminar-imagen/';
    var urlCargar = '/parque-agua/banners/cargar-imagen/';
    var urlCortar = '/parque-agua/banners/cortar-imagen/';
    var galeria = false;
    
    cargar_imagen();
</script> 

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>