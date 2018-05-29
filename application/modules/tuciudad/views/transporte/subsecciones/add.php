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

                <label>Resumen</label>
                <textarea class="form-control" rows="3" id="resumen"
                          name="resumen"><?= isset($result->resumen) ? $result->resumen : ''; ?></textarea>

                <label>Nombre Recorrido 1</label>
                <input type="text" class="form-control" name="nombre_recorrido_1"
                       value="<?= isset($result->nombre_recorrido_1) ? $result->nombre_recorrido_1 : ''; ?>"/>

                <label>Iframe Recorrido 1</label>
                <textarea class="form-control" rows="3" id="iframe_recorrido_1"
                          name="iframe_recorrido_1"><?= isset($result->iframe_recorrido_1) ? $result->iframe_recorrido_1 : ''; ?></textarea>

                <label>Nombre Recorrido 2</label>
                <input type="text" class="form-control" name="nombre_recorrido_2"
                       value="<?= isset($result->nombre_recorrido_2) ? $result->nombre_recorrido_2 : ''; ?>"/>

                <label>Iframe Recorrido 2</label>
                <textarea class="form-control" rows="3" id="iframe_recorrido_2"
                          name="iframe_recorrido_2"><?= isset($result->iframe_recorrido_2) ? $result->iframe_recorrido_2 : ''; ?></textarea>

                <label>Nombre Recorrido 3</label>
                <input type="text" class="form-control" name="nombre_recorrido_3"
                       value="<?= isset($result->nombre_recorrido_3) ? $result->nombre_recorrido_3 : ''; ?>"/>

                <label>Iframe Recorrido 3</label>
                <textarea class="form-control" rows="3" id="iframe_recorrido_3"
                          name="iframe_recorrido_3"><?= isset($result->iframe_recorrido_3) ? $result->iframe_recorrido_3 : ''; ?></textarea>

                <label>Nombre Recorrido 4</label>
                <input type="text" class="form-control" name="nombre_recorrido_4"
                       value="<?= isset($result->nombre_recorrido_4) ? $result->nombre_recorrido_4 : ''; ?>"/>

                <label>Iframe Recorrido 4</label>
                <textarea class="form-control" rows="3" id="iframe_recorrido_4"
                          name="iframe_recorrido_4"><?= isset($result->iframe_recorrido_4) ? $result->iframe_recorrido_4 : ''; ?></textarea>

                <label>Nombre Recorrido 5</label>
                <input type="text" class="form-control" name="nombre_recorrido_5"
                       value="<?= isset($result->nombre_recorrido_5) ? $result->nombre_recorrido_5 : ''; ?>"/>

                <label>Iframe Recorrido 5</label>
                <textarea class="form-control" rows="3" id="iframe_recorrido_5"
                          name="iframe_recorrido_5"><?= isset($result->iframe_recorrido_5) ? $result->iframe_recorrido_5 : ''; ?></textarea>

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
                    <a href="/tuciudad/transporte/subsecciones/<?= $seccion; ?>/" class="btn btn-can">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    //configuracion para imagenes
    var id = 1;
    var urlDelete = '/tuciudad/transporte/subsecciones/eliminar-imagen/';
    var urlCargar = '/tuciudad/transporte/subsecciones/cargar-imagen/';
    var urlCortar = '/tuciudad/transporte/subsecciones/cortar-imagen/';
    var galeria = false;

    var cargar = [];
    //cargar.push(1);
    <?php if(!isset($result->imagen_ruta_interna) || $result->imagen_ruta_interna == ''){ ?>
    cargar.push(1);
    <?php } ?>

    //cargar_imagenes();
    cargar_imagen(cargar);

</script>

<script>
    function initAutocomplete() {

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -36.82013519999999, lng: -73.0443904},
            zoom: 14,
            mapTypeId: 'roadmap',
            streetViewControl: false,
            minZoom: 13,
            maxZoom: 16,
            mapTypeControl: false
        });

        <?php if(isset($result->mapa)){ ?>
        var markers2 = [];
        markers2 = [
            ['<?= $result->nombre;?>', <?= $result->mapa_coor[0];?>,<?= $result->mapa_coor[1];?>]
        ];

        var icon_target = {
            url: '/imagenes/template/geocode-32.png',
            // Este marcador tiene 20 pixeless de ancho por 32 pixeles de alto.
            size: new google.maps.Size(32, 32),
            // El origen para esta imagen es (0, 0).
            origin: new google.maps.Point(0, 0),
            // El ancla para esa imagen es la base del asta bandera en (0, 32).
            anchor: new google.maps.Point(0, 32)
        };

        //console.log(markers2);
        var bounds = new google.maps.LatLngBounds();
        // Loop through our array of markers & place each one on the map
        for (i = 0; i < markers2.length; i++) {
            var position = new google.maps.LatLng(markers2[i][1], markers2[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers2[i][0],
                icon: icon_target
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
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
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