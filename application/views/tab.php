<?php
$usuario = $this->session->userdata('usuario_admin');
$secciones_menu = $this->ws->listar(63,"adms_administrador = {$usuario->codigo}");
$permisos = array(
    'todo' => false,
    'noticias' => false,
    'calendario-general' => false,
    'calendario-hotel-nevado' => false,
    'calendario-hotel-alto' => false,
);
foreach($secciones_menu as $aux){
    if($aux->seccion == 1)
        $permisos['todo'] = true;
    if($aux->seccion == 2)
        $permisos['noticias'] = true;
    if($aux->seccion == 3)
        $permisos['calendario-general'] = true;
    if($aux->seccion == 4)
        $permisos['calendario-hotel-nevado'] = true;
    if($aux->seccion == 5)
        $permisos['calendario-hotel-alto'] = true;
}
?>
<!-- MENU 1 -->
<div class="col-sm-2">
	<ul id="menu-principal">
		<!-- portada -->
        <?php if($permisos['todo'] || $permisos['noticias'] || $permisos['calendario-general']){ ?>
            <li>
    			<a style="cursor:pointer;">Portada</a>
    			<ul>
                    <?php if($permisos['todo']){ ?>
    				    <li><a href="/portada/slider/">Slider</a></li>
                    <?php } ?>
                    <?php if($permisos['todo'] || $permisos['calendario-general']){ ?>
    				    <li><a href="/portada/calendario/">Calendario General</a></li>
                    <?php } ?>
                    <?php if($permisos['todo'] || $permisos['noticias']){ ?>
    				    <li><a href="/portada/noticias/">Noticias</a></li>
                    <?php } ?>
                    <?php if($permisos['todo']){ ?>
        				<li><a href="/portada/accesos-directos/">Accesos Directos</a></li>
        				<li><a href="/portada/auspiciadores/">Auspiciadores</a></li>
        				<li><a href="/portada/informacion-prensa/">Información Para Prensa</a></li>
                        <li><a href="/landing_pages/">Landings Pages</a></li>
        				<li><a href="/contactos_landing/">Contactos Landing Pages</a></li>
                        <li><a href="/newsletter/">Newsletter</a></li>                      
                    <?php } ?>
    			</ul>
    		</li>
        <?php } ?>
        
        <!-- descubrenos -->
        <?php if($permisos['todo']){ ?>
            <li><a style="background: #FFF; color: #969696; font-style: italic;">Descúbrenos</a></li>
            <li>
    			<a style="cursor:pointer;">Descúbrenos</a>
    			<ul>
    				<li><a href="/descubrenos/slider/">Slider</a></li>
                    <li><a href="/descubrenos/introduccion/">Introducción</a></li>
    				<li><a href="/descubrenos/hoteles/">Hoteles</a></li>
    				<li><a href="/descubrenos/secciones/">Secciones</a></li>
    			</ul>
    		</li>
            <li>
    			<a style="cursor:pointer;">Nuestra Historia</a>
    			<ul>
    				<li><a href="/historia/slider/">Slider</a></li>
    				<li><a href="/historia/introduccion/">Introducción</a></li>
    				<li><a href="/historia/secciones/">Secciones</a></li>
    			</ul>
    		</li>
            <li>
    			<a style="cursor:pointer;">Valle Las Trancas</a>
    			<ul>
    				<li><a href="/valle-las-trancas/slider/">Slider</a></li>
                    <li><a href="/valle-las-trancas/introduccion/">Introducción</a></li>
    				<li><a href="/valle-las-trancas/secciones/">Secciones</a></li>
    			</ul>
    		</li>
            <li><a style="background: #FFF;"></a></li>
        <?php } ?>
        
        <!-- alojamiento -->
        <?php if($permisos['todo'] || $permisos['calendario-hotel-nevado'] || $permisos['calendario-hotel-alto']){ ?>
            <li><a style="background: #FFF; color: #969696; font-style: italic;">Alojamiento</a></li>
            <?php if($menu_hoteles){ ?>
                <?php foreach($menu_hoteles as $aux){ ?>
                    
                    <?php
                        if($aux->codigo == 1 && !$permisos['todo'] && !$permisos['calendario-hotel-nevado'])
                            continue;
                            
                        if($aux->codigo == 2 && !$permisos['todo'] && !$permisos['calendario-hotel-alto'])
                            continue;
                        
                        if($aux->codigo == 3 && !$permisos['todo'])
                            continue;
                    ?>
                    
                    <li>
            			<a style="cursor:pointer;"><?php echo $aux->nombre; ?></a>
            			<ul>
            				<?php if($permisos['todo']){ ?>
                                <li><a href="/hoteles/<?php echo $aux->url; ?>/slider/">Slider</a></li>
                                <li><a href="/hoteles/<?php echo $aux->url; ?>/introduccion/">Introducción</a></li>
                				<li><a href="/hoteles/<?php echo $aux->url; ?>/habitaciones/">Habitaciones</a></li>
                				<li><a href="/hoteles/<?php echo $aux->url; ?>/actividades/">Actividades</a></li>
                            <?php } ?>
                            
                            <?php if($aux->codigo != 3){ ?>
                                <?php
                                    $calendario = false;
                                    if($aux->codigo == 1 && ($permisos['todo'] || $permisos['calendario-hotel-nevado']))
                                        $calendario = true;
                                    elseif($aux->codigo == 2 && ($permisos['todo'] || $permisos['calendario-hotel-alto']))
                                        $calendario = true;
                                
                                ?>
                                <?php if($calendario){ ?>
            				        <li><a href="/hoteles/<?php echo $aux->url; ?>/calendario/">Calendario</a></li>
                                <?php } ?>
                            <?php } ?>
                            
                            <?php if($permisos['todo']){ ?>
                				<li><a href="/hoteles/<?php echo $aux->url; ?>/secciones/">Secciones</a></li>
                                <?php if($aux->codigo != 3){ ?>
                				    <li><a href="/hoteles/<?php echo $aux->url; ?>/testimonios/">Testimonios</a></li>
                                <?php } ?>
                            <?php } ?>
                            
                            <?php if($permisos['todo']){ ?>
            				    <li><a href="/hoteles/<?php echo $aux->url; ?>/banners/">Banners</a></li>
                            <?php } ?>
            			</ul>
        		  </li>
                <?php } ?>
            <?php } ?>
            
            <?php if($permisos['todo']){ ?>
                <li>
                    <!-- servicios complementarios -->
                    <li>
            			<a href="/servicios-complementarios/">Servicios Complementarios</a>
            		</li>                
        			<a href="/promociones/">Promociones</a>
        		</li>
            <?php } ?>
            <li><a style="background: #FFF;"></a></li>
        <?php } ?>
        
        <!-- parque de agua -->
        <?php if($permisos['todo']){ ?>
            <li>
    			<a style="cursor:pointer;">Parque de Agua</a>
    			<ul>
    				<li><a href="/parque-agua/slider/">Slider</a></li>
                    <li><a href="/parque-agua/introduccion/">Introducción</a></li>
    				<li><a href="/parque-agua/programas-valores/">Programas y Valores</a></li>
                    <li><a href="/parque-agua/secciones/">Secciones</a></li>
                    <li><a href="/parque-agua/banners/">Banners</a></li>
    			</ul>
    		</li>
        
            <!-- invierno -->
            <li><a style="background: #FFF; color: #969696; font-style: italic;;">Invierno</a></li>
            <li>
            	<a style="cursor:pointer;">Invierno</a>
            	<ul>
            		<li><a href="/invierno/slider/">Slider</a></li>
                    <li><a href="/invierno/introduccion/">Introducción</a></li>
            		<li><a href="/invierno/secciones/">Secciones</a></li>
            		<li><a href="/invierno/cafeterias/">Cafeterías</a></li>
            		<li><a href="/invierno/programas-valores/">Programas y Valores</a></li>
            		<li><a href="/invierno/mapa-pistas/">Mapa de Pistas</a></li>
            	</ul>
            </li>
        
            <li>
            	<a style="cursor:pointer;">Info. Nieve</a>
            	<ul>
            		<li><a href="/info-nieve/estado-camino/">Estado de Camino</a></li>
            		<li><a href="/info-nieve/nieve/">Nieve</a></li>
            		<li><a href="/info-nieve/estado-pistas/">Estado de Pistas</a></li>
            		<li><a href="/info-nieve/estado-andariveles/">Estado de Andariveles</a></li>
            	</ul>
            </li>
            
            <li>
            	<a style="cursor:pointer;">Escuela</a>
            	<ul>
            		<li><a href="/escuela/conoce-nuestras-instalaciones/">Conoce Nuestras Instalaciones</a></li>
            		<li><a href="/escuela/profesor-guia/">Profesor Guía</a></li>
            		<li><a href="/escuela/programas-valores/">Programas y Valores</a></li>
                    <li><a href="/escuela/secciones/">Secciones</a></li>
            	</ul>
            </li>
            <!-- freeride -->
            <li>
    			<a href="/freeride/">Backcountry</a>
    		</li>            
            <li><a style="background: #fff;"></a></li>
        
        

            
            <!-- verano -->
            <li><a style="background: #FFF; color: #969696; font-style: italic;">Verano</a></li>
            <li>
                <a style="cursor:pointer;">Verano</a>
                <ul>
                    <li><a href="/verano/slider/">Slider</a></li>
                    <li><a href="/verano/introduccion/">Introducción</a></li>
                    <li><a href="/verano/secciones/">Secciones</a></li>
                    <!--<li><a href="/verano/calendario">Calendario</a></li>-->
                    <li><a href="/verano/programas-valores/">Programas y Valores</a></li>
                </ul>
            </li>
            <li>
            	<a style="cursor:pointer;">Bike Park</a>
            	<ul>
            		<li><a href="/bike-park/slider/">Slider</a></li>
                    <li><a href="/bike-park/">Bike Park</a></li>
            		<li><a href="/bike-park/secciones/">Secciones</a></li>
            		<li><a href="/bike-park/programas-valores/">Programas y Valores</a></li>
            	</ul>
            </li>
            <li><a style="background: #FFF;"></a></li>
            
            

        
        
            <!-- ayuda -->
            <li>
    			<a style="cursor:pointer;">Ayuda</a>
    			<ul>
    				<li><a href="/ayuda/slider/">Slider</a></li>
    				<li><a href="/ayuda/como-llegar/">Cómo Llegar</a></li>
    				<li><a href="/ayuda/preguntas-frecuentes/">Preguntas Frecuentes</a></li>
    				<li><a href="/ayuda/condiciones-reglamentos/">Condiciones y Reglamentos</a></li>
    				<li><a href="/ayuda/trabaja-con-nosotros/">Trabaja con Nosotros</a></li>
    				<li><a href="/ayuda/contactos/">Contactos</a></li>
    			</ul>
    		</li>
            
            
            <!-- configuraciones -->
            <li>
    			<a style="cursor:pointer;">Configuraciones</a>
    			<ul>
    				<li><a href="/configuracion/administradores/">Administradores</a></li>
    				<li><a href="/configuracion/temporadas-calendario/">Temporadas de Calendario</a></li>
    				<li><a href="/configuracion/categorias-calendario/">Categorías de Calendario</a></li>
    				<li><a href="/configuracion/categorias-noticias/">Categorías de Noticias</a></li>
    				<li><a href="/configuracion/camaras-vivo/">Cámaras en Vivo</a></li>
    				<li><a href="/configuracion/asuntos-contacto/">Asuntos de Contacto</a></li>
    				<li><a href="/configuracion/areas-trabajo/">Áreas de Trabajo</a></li>
    				<li><a href="/configuracion/datos-generales/">Datos Generales</a></li>
    			</ul>
    		</li>
        <?php } ?>
	</ul>
</div>
