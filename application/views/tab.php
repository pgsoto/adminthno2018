<?php
#$usuario = $this->session->userdata('usuario_admin');
/*$secciones_menu = $this->ws->listar(63, "adms_administrador = {$usuario->codigo}");
$permisos = array(
    'todo' => false,
    'noticias' => false,
    'calendario-general' => false,
    'calendario-hotel-nevado' => false,
    'calendario-hotel-alto' => false,
);
foreach ($secciones_menu as $aux) {
    if ($aux->seccion == 1)
        $permisos['todo'] = true;
    if ($aux->seccion == 2)
        $permisos['noticias'] = true;
    if ($aux->seccion == 3)
        $permisos['calendario-general'] = true;
    if ($aux->seccion == 4)
        $permisos['calendario-hotel-nevado'] = true;
    if ($aux->seccion == 5)
        $permisos['calendario-hotel-alto'] = true;
}*/
?>
<!-- MENU 1 -->
<div class="col-sm-2">
    <ul id="menu-principal">
        <!-- portada -->
            <li>
                <a style="cursor:pointer;">Portada</a>
                <ul>
                    <li><a href="/portada/slider/">Slider principal</a></li>
                    <li><a href="/portada/accesos-directos/">Accesos Directos</a></li>
                    <li><a href="/portada/slider-turismo/">Slider turismo</a></li>
                    <li><a href="/portada/somos-tv/">Somos TV</a></li>
                    <li><a href="/portada/banners-transparencia/">Banners transparencia</a></li>
                </ul>
            </li>

        <!-- noticias -->
            <li>
                <a style="cursor:pointer;">Noticias</a>
                <ul>
                    <li><a href="/noticias/slider/">Slider</a></li>
                    <li><a href="/noticias/noticias/">Noticias</a></li>
                    <li><a href="/noticias/categorias/">Categorías de Noticias</a></li>
                </ul>
            </li>

        <!-- servicios y tramites -->
            <!--<li><a style="background: #FFF; color: #969696; font-style: italic;">Servicios y trámites</a></li>-->
            <li>
                <a style="cursor:pointer;">Servicios y trámites</a>
                <ul>
                    <li><a href="/servicios/tramites/">Centro de atención al vecino</a></li>
                    <li><a href="/servicios/desarrollo-social/">Desarrollo social</a></li>
                </ul>
            </li>
            <li>
                <a style="cursor:pointer;">Municipio</a>
                <ul>
                    <li><a href="/municipio/direcciones/">Direcciones</a></li>
                    <li><a href="/municipio/das/">DAS</a></li>
                    <li><a href="/municipio/daem/">DAEM</a></li>
                    <li><a href="/municipio/alcalde/">Alcalde</a></li>
                    <li><a href="/municipio/concejo/">Concejo</a></li>
                    <li><a href="/municipio/organigrama/">Organigrama</a></li>
                </ul>
            </li>
            <li>
                <a style="cursor:pointer;">Talcahuano tu ciudad</a>
                <ul>
                    <li><a href="/tuciudad/desarrollo-productivo/">Desarrollo productivo</a></li>
                    <li><a href="/tuciudad/seguridad/">Seguridad</a></li>
                    <li><a href="/tuciudad/talcahuano-historico/">Talcahuano histórico</a></li>
                    <li><a href="/tuciudad/talcahuano-limpio/">Talcahuano limpio</a></li>
                    <li><a href="/tuciudad/barrios/">Barrios</a></li>
                    <li><a href="/tuciudad/documentos-interes/">Documentos de interés</a></li>
                    <li><a href="/tuciudad/transporte/">Transporte</a></li>
                    <li><a href="/tuciudad/informacion-util/">Información útil</a></li>
                </ul>
            </li>
            <li>
                <a style="cursor:pointer;">Turismo</a>
                <ul>
                    <li><a href="/turismo/introduccion/">Introducción</a></li>
                    <li><a href="/turismo/donde-queda/">Dónde queda</a></li>
                    <li><a href="/turismo/servicios/">Servicios</a></li>
                    <li><a href="/turismo/comercio/">Comercio</a></li>
                    <li><a href="/turismo/bancos/">Bancos</a></li>
                    <li><a href="/turismo/servicentros/">Servicentros</a></li>
                </ul>
            </li>
            <li><a style="background: #FFF;"></a></li>

        <!-- evento y actividades -->
        <li>
            <a style="cursor:pointer;">Eventos y actividades</a>
            <ul>
                <li><a href="/eventos/slider/">Slider</a></li>
                <li><a href="/eventos/eventos/">Eventos</a></li>
                <li><a href="/eventos/categorias/">Categorías de Eventos</a></li>
            </ul>
        </li>

        <!-- configuraciones -->
            <li>
                <a style="cursor:pointer;">Configuraciones</a>
                <ul>
                    <li><a href="/configuracion/datos-generales/">Información municipal</a></li>
                    <li><a href="/configuracion/administradores/">Administradores</a></li>
                </ul>
            </li>
    </ul>
</div>
