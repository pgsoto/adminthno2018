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

                <label>Encargado</label>
                <textarea class="form-control" rows="3" id="encargado"
                          name="encargado"><?= isset($result->encargado) ? $result->encargado : ''; ?></textarea>

                <label>Secretaria</label>
                <textarea class="form-control" rows="3" id="secretaria"
                          name="secretaria"><?= isset($result->secretaria) ? $result->secretaria : ''; ?></textarea>

                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono"
                       value="<?= isset($result->telefono) ? $result->telefono : ''; ?>"/>

                <label>Email</label>
                <input type="text" class="form-control validate[custom[email]]" name="email"
                       value="<?= isset($result->email) ? $result->email : ''; ?>"/>

                <label>Dirección</label>
                <input type="text" class="form-control" name="direccion"
                       value="<?= isset($result->direccion) ? $result->direccion : ''; ?>"/>

                <label>Mapa</label>
                <input id="pac-input" class="controls" type="text" placeholder="Busqueda">
                <input id="coor" type="hidden" name="mapa" value="<?= isset($result->mapa) ? $result->mapa : ''; ?>">
                <div class="mapa" id="map"></div>

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
                    <a href="/tuciudad/desarrollo-productivo/subsecciones/<?= $seccion; ?>/" class="btn btn-can">Cancelar</a>
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
    var urlDelete = '/tuciudad/desarrollo-productivo/subsecciones/eliminar-imagen/';
    var urlCargar = '/tuciudad/desarrollo-productivo/subsecciones/cargar-imagen/';
    var urlCortar = '/tuciudad/desarrollo-productivo/subsecciones/cortar-imagen/';
    var galeria = true;

    var cargar = [];
    //cargar.push(1);
    <?php if(!isset($result->imagen_ruta_interna) || $result->imagen_ruta_interna == ''){ ?>
    cargar.push(2);
    <?php } ?>

    cargar_imagenes();
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