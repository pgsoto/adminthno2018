<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1><?= $titulo; ?></h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
            	<label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?= isset($result->nombre) ? $result->nombre : ''; ?>" />

                <label>Fecha</label>
                <input type="text" class="form-control datepicker" name="fecha" value="<?= isset($result->fecha) ? invierte_fecha($result->fecha) : ''; ?>" />

                <label>Hora de inicio</label>
                <div class="input-group bootstrap-timepicker timepicker">
                    <input id="timepicker1" type="text" class="form-control input-small" name="hora_inicio" value="<?= isset($result->hora_inicio) ? $result->hora_inicio : ''; ?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>

                <label>Hora de término</label>
                <div class="input-group bootstrap-timepicker timepicker">
                    <input id="timepicker1" type="text" class="form-control input-small" name="hora_termino" value="<?= isset($result->hora_termino) ? $result->hora_termino : ''; ?>">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>

                <label>Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" value="<?= isset($result->ubicacion) ? $result->ubicacion : ''; ?>" />

                <label>Organiza</label>
                <input type="text" class="form-control" name="organiza" value="<?= isset($result->organiza) ? $result->organiza : ''; ?>" />

                <label>Link</label>
                <input type="text" class="form-control" name="link" value="<?= isset($result->link) ? $result->link : ''; ?>" />

                <label>Descripción</label>
                <textarea class="form-control" rows="3"  id="descripcion" name="descripcion"><?= isset($result->descripcion) ? $result->descripcion : ''; ?></textarea>

                <label>Categoría</label>
                <select name="categoria" class="selectpicker" title="Categoría" >
                    <option selected disabled value="">Seleccione categoría...</option>
                    <?php foreach($categoria as $cate){ ?>
                        <option <?php if(isset($result->categoria) && $result->categoria == $cate->codigo) echo 'selected'; ?> value="<?php echo $cate->codigo ?>"><?php echo $cate->nombre ?></option>
                    <?php } ?>
                </select>

                <label>Adjuntar imagen tamaño mínimo <?php echo $this->img->recorte_ancho_1; ?>px x <?php echo $this->img->recorte_alto_1; ?>px</label>
                <div class="multi-imagen" style="margin-bottom:20px;">
                    <div style="display:none;" id="replicar-1" class="box">
                        <div class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" ></div>
                    </div>
                    <div id="cont-imagenes-1">
                        <?php if(isset($result) && $result->imagen_ruta_interna){ ?>
                            <div class="box" >
                                <div rel="1" class="img" style="width:<?php echo $this->img->min_ancho_1+2; ?>px; height:<?php echo $this->img->min_alto_1+2; ?>px;" >
                                    <img class="croppedImg" src="<?php echo $result->imagen_ruta_interna; ?>" />
                                    <div class="cropControls cropControlsUpload">
                                        <i class="cropControlRemoveCroppedImage eliminar_imagen" rel="<?php echo $result->codigo; ?>"></i>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="rutas-imagenes"></div>
                </div>

                <label>Mapa</label>
                <input id="pac-input" class="controls" type="text" placeholder="Busqueda">
                <input id="coor" type="hidden" name="mapa" value="<?= isset($result->mapa) ? $result->mapa : ''; ?>">
                <div class="mapa" id="map"></div>
                
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
                    <option <?= (isset($result->estado) && $result->estado == 1) ? 'selected' : ''; ?> value="1">Activo</option>
                    <option <?= (isset($result->estado) && $result->estado == 0) ? 'selected' : ''; ?> value="0">Inactivo</option>
				</select>
                
        	</div>

            <input type="hidden" id="codigo" name="codigo" value="<?= isset($result->codigo) ? $result->codigo : '0'; ?>" />

			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/eventos/eventos/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>

<script>
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy"
    });

    $('.timepicker').timepicker();
</script>

<script>
    CKEDITOR.replace( 'descripcion' );
</script>

<script>
    //configuracion para imagenes
    var id = 1;
    var urlDelete = '/eventos/eventos/eliminar-imagen/';
    var urlCargar = '/eventos/eventos/cargar-imagen/';
    var urlCortar = '/eventos/eventos/cortar-imagen/';
    var galeria = false;

    var cargar=[];
    //cargar.push(1);
    <?php if(!isset($result->imagen_ruta_interna) || $result->imagen_ruta_interna == ''){ ?>
    cargar.push(1);
    <?php } ?>

    //cargar_imagenes();
    cargar_imagen(cargar);

</script>

<style type="text/css">
.multi-imagen .box{
	width: 100%;
}
</style>

<script>
    function initAutocomplete() {

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -36.82013519999999, lng: -73.0443904},
            zoom: 12,
            mapTypeId: 'roadmap'
        });

        <?php if(isset($result->mapa)){ ?>
        var markers2 = [];
        markers2 = [
            ['<?= $result->nombre;?>', <?= $result->mapa_coor[0];?>,<?= $result->mapa_coor[1];?>]
        ];
        //console.log(markers2);
        var bounds = new google.maps.LatLngBounds();
        // Loop through our array of markers & place each one on the map
        for( i = 0; i < markers2.length; i++ ) {
            var position = new google.maps.LatLng(markers2[i][1], markers2[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers2[i][0]
            });

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }
        <?php } ?>

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    zoom: 5,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                document.getElementById("coor").value = place.geometry.location;
            });

            map.fitBounds(bounds);
        });

    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdSXBzktlVz-DwJ0r1PSNCZA7TnO4BNI0&libraries=places&callback=initAutocomplete"
        async defer></script>