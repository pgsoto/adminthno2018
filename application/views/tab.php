<?php
$usuario = $this->session->userdata('usuario_admin');
$secciones_menu = $this->ws->listar(63, "adms_administrador = {$usuario->codigo}");
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
}
?>
<!-- MENU 1 -->
<div class="col-sm-2">
    <ul id="menu-principal">
        <!-- portada -->
        <?php if ($permisos['todo']) { ?>
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
        <?php } ?>

        <!-- noticias -->
        <?php if ($permisos['todo'] || $permisos['noticias']) { ?>
            <li>
                <a style="cursor:pointer;">Noticias</a>
                <ul>
                    <li><a href="/noticias/slider/">Slider</a></li>
                    <li><a href="/noticias/noticias/">Noticias</a></li>
                    <li><a href="/noticias/categorias/">Categorias</a></li>
                </ul>
            </li>
        <?php } ?>

        <!-- servicios y tramites -->
        <?php if ($permisos['todo']) { ?>
            <li><a style="background: #FFF; color: #969696; font-style: italic;">Servicios y trámites</a></li>
            <li>
                <a style="cursor:pointer;">Centro de atención al vecino</a>
                <ul>
                    <li><a href="/centro-atencion-vecino/tramites/">Trámites</a></li>
                    <li><a href="/centro-atencion-vecino/desarrollo-social/">Desarrollo social</a></li>
                </ul>
            </li>
            <li>
                <a style="cursor:pointer;">Municipio</a>
                <ul>
                    <li><a href="/municipio/direciones/">Direcciones</a></li>
                    <li><a href="/municipio/das/">DAS</a></li>
                    <li><a href="/municipio/daem/">DAEM</a></li>
                    <li><a href="/municipio/alcalde/">Alcalde</a></li>
                    <li><a href="/municipio/consejo/">Consejo</a></li>
                    <li><a href="/municipio/organigrama/">Organigrama</a></li>
                </ul>
            </li>
            <li><a style="background: #FFF;"></a></li>
        <?php } ?>

        <!-- configuraciones -->
        <?php if ($permisos['todo']) { ?>
            <li>
                <a style="cursor:pointer;">Configuraciones</a>
                <ul>
                    <li><a href="/configuracion/informacion-municipal/">Información municipal</a></li>
                    <li><a href="/configuracion/administradores/">Administradores</a></li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</div>
