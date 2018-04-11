<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "inicio";
$route['404_override'] = '';

/* RUTAS PYME */

#LOGIN

#login
$route['login']                 = "inicio/login";
$route['logout']                = "inicio/logout";
$route['recuperar-contrasena']  = "inicio/recuperar_contrasena";

#FIN LOGIN

#PERFIL
$route['perfil']            = "perfil";
$route['perfil/guardar']    = "perfil/guardar";
#FIN PERFIL

#PORTADA

#slider
$route['portada/slider']                  = "portada/slider";
$route['portada/slider/(:num)']           = "portada/slider";
$route['portada/slider/agregar']          = "portada/slider/agregar";
$route['portada/slider/editar/(:num)']    = "portada/slider/editar/$1";
$route['portada/slider/eliminar']         = "portada/slider/eliminar";
$route['portada/slider/cargar-imagen']    = "portada/slider/cargar_imagen";
$route['portada/slider/cortar-imagen']    = "portada/slider/cortar_imagen";
$route['portada/slider/eliminar-imagen']  = "portada/slider/eliminar_imagen";

#accesos directos
$route['portada/accesos-directos']                  = "portada/accesos_directos";
$route['portada/accesos-directos/(:num)']           = "portada/accesos_directos";
$route['portada/accesos-directos/agregar']          = "portada/accesos_directos/agregar";
$route['portada/accesos-directos/editar/(:num)']    = "portada/accesos_directos/editar/$1";
$route['portada/accesos-directos/eliminar']         = "portada/accesos_directos/eliminar";
$route['portada/accesos-directos/cargar-imagen']    = "portada/accesos_directos/cargar_imagen";
$route['portada/accesos-directos/cortar-imagen']    = "portada/accesos_directos/cortar_imagen";
$route['portada/accesos-directos/eliminar-imagen']  = "portada/accesos_directos/eliminar_imagen";

#slider-turismo
$route['portada/slider-turismo']                  = "portada/slider_turismo";
$route['portada/slider-turismo/(:num)']           = "portada/slider_turismo";
$route['portada/slider-turismo/agregar']          = "portada/slider_turismo/agregar";
$route['portada/slider-turismo/editar/(:num)']    = "portada/slider_turismo/editar/$1";
$route['portada/slider-turismo/eliminar']         = "portada/slider_turismo/eliminar";
$route['portada/slider-turismo/cargar-imagen']    = "portada/slider_turismo/cargar_imagen";
$route['portada/slider-turismo/cortar-imagen']    = "portada/slider_turismo/cortar_imagen";
$route['portada/slider-turismo/eliminar-imagen']  = "portada/slider_turismo/eliminar_imagen";

#somos-tv
$route['portada/somos-tv']                  = "portada/somos_tv";
$route['portada/somos-tv/(:num)']           = "portada/somos_tv";
$route['portada/somos-tv/agregar']          = "portada/somos_tv/agregar";
$route['portada/somos-tv/editar/(:num)']    = "portada/somos_tv/editar/$1";
$route['portada/somos-tv/eliminar']         = "portada/somos_tv/eliminar";

#noticias
$route['portada/banners-transparencia']                  = "portada/banners_transparencia";
$route['portada/banners-transparencia/(:num)']           = "portada/banners_transparencia";
$route['portada/banners-transparencia/agregar']          = "portada/banners_transparencia/agregar";
$route['portada/banners-transparencia/editar/(:num)']    = "portada/banners_transparencia/editar/$1";
$route['portada/banners-transparencia/eliminar']         = "portada/banners_transparencia/eliminar";
$route['portada/banners-transparencia/cargar-imagen']    = "portada/banners_transparencia/cargar_imagen";
$route['portada/banners-transparencia/cortar-imagen']    = "portada/banners_transparencia/cortar_imagen";
$route['portada/banners-transparencia/eliminar-imagen']  = "portada/banners_transparencia/eliminar_imagen";

#FIN PORTADA

#NOTICIAS

#slider
$route['noticias/slider']                  = "noticias/slider";
$route['noticias/slider/(:num)']           = "noticias/slider";
$route['noticias/slider/agregar']          = "noticias/slider/agregar";
$route['noticias/slider/editar/(:num)']    = "noticias/slider/editar/$1";
$route['noticias/slider/eliminar']         = "noticias/slider/eliminar";
$route['noticias/slider/cargar-imagen']    = "noticias/slider/cargar_imagen";
$route['noticias/slider/cortar-imagen']    = "noticias/slider/cortar_imagen";
$route['noticias/slider/eliminar-imagen']  = "noticias/slider/eliminar_imagen";

#noticias
$route['noticias/listado']                  = "noticias/listado";
$route['noticias/listado/(:num)']           = "noticias/listado";
$route['noticias/listado/agregar']          = "noticias/listado/agregar";
$route['noticias/listado/editar/(:num)']    = "noticias/listado/editar/$1";
$route['noticias/listado/eliminar']         = "noticias/listado/eliminar";
$route['noticias/listado/cargar-imagen']    = "noticias/listado/cargar_imagen";
$route['noticias/listado/cortar-imagen']    = "noticias/listado/cortar_imagen";
$route['noticias/listado/eliminar-imagen']  = "noticias/listado/eliminar_imagen";

#categorias
$route['noticias/categorias']                  = "noticias/categorias";
$route['noticias/categorias/agregar']          = "noticias/categorias/agregar";

#FIN NOTICIAS

#CENTRO ATENCION VECINO

#centro-atencion-vecino
$route['centro-atencion-vecino/tramites']                  = "centro_atencion_vecino/tramites";
$route['centro-atencion-vecino/tramites/(:num)']           = "centro_atencion_vecino/tramites";
$route['centro-atencion-vecino/tramites/agregar']          = "centro_atencion_vecino/tramites/agregar";
$route['centro-atencion-vecino/tramites/editar/(:num)']    = "centro_atencion_vecino/tramites/editar/$1";
$route['centro-atencion-vecino/tramites/eliminar']         = "centro_atencion_vecino/tramites/eliminar";
$route['centro-atencion-vecino/tramites/cargar-imagen']    = "centro_atencion_vecino/tramites/cargar_imagen";
$route['centro-atencion-vecino/tramites/cortar-imagen']    = "centro_atencion_vecino/tramites/cortar_imagen";
$route['centro-atencion-vecino/tramites/eliminar-imagen']  = "centro_atencion_vecino/tramites/eliminar_imagen";

#centro-atencion-vecino
$route['centro-atencion-vecino/desarrollo-social']                  = "centro_atencion_vecino/desarrollo_social";
$route['centro-atencion-vecino/desarrollo-social/(:num)']           = "centro_atencion_vecino/desarrollo_social";
$route['centro-atencion-vecino/desarrollo-social/agregar']          = "centro_atencion_vecino/desarrollo_social/agregar";
$route['centro-atencion-vecino/desarrollo-social/editar/(:num)']    = "centro_atencion_vecino/desarrollo_social/editar/$1";
$route['centro-atencion-vecino/desarrollo-social/eliminar']         = "centro_atencion_vecino/desarrollo_social/eliminar";
$route['centro-atencion-vecino/desarrollo-social/cargar-imagen']    = "centro_atencion_vecino/desarrollo_social/cargar_imagen";
$route['centro-atencion-vecino/desarrollo-social/cortar-imagen']    = "centro_atencion_vecino/desarrollo_social/cortar_imagen";
$route['centro-atencion-vecino/desarrollo-social/eliminar-imagen']  = "centro_atencion_vecino/desarrollo_social/eliminar_imagen";

#FIN CENTRO ATENCION VECINO

#MUNICIPIO

#direcciones
$route['municipio/direcciones']                  = "municipio/direcciones";
$route['municipio/direcciones/(:num)']           = "municipio/direcciones";
$route['municipio/direcciones/agregar']          = "municipio/direcciones/agregar";
$route['municipio/direcciones/editar/(:num)']    = "municipio/direcciones/editar/$1";
$route['municipio/direcciones/eliminar']         = "municipio/direcciones/eliminar";
$route['municipio/direcciones/cargar-imagen']    = "municipio/direcciones/cargar_imagen";
$route['municipio/direcciones/cortar-imagen']    = "municipio/direcciones/cortar_imagen";
$route['municipio/direcciones/eliminar-imagen']  = "municipio/direcciones/eliminar_imagen";

#DAS
$route['municipio/das']                  = "municipio/das";
$route['municipio/das/(:num)']           = "municipio/das";
$route['municipio/das/agregar']          = "municipio/das/agregar";
$route['municipio/das/editar/(:num)']    = "municipio/das/editar/$1";
$route['municipio/das/eliminar']         = "municipio/das/eliminar";
$route['municipio/das/cargar-imagen']    = "municipio/das/cargar_imagen";
$route['municipio/das/cortar-imagen']    = "municipio/das/cortar_imagen";
$route['municipio/das/eliminar-imagen']  = "municipio/das/eliminar_imagen";

#DAEM
$route['municipio/daem']                  = "municipio/daem";
$route['municipio/daem/(:num)']           = "municipio/daem";
$route['municipio/daem/agregar']          = "municipio/daem/agregar";
$route['municipio/daem/editar/(:num)']    = "municipio/daem/editar/$1";
$route['municipio/daem/eliminar']         = "municipio/daem/eliminar";
$route['municipio/daem/cargar-imagen']    = "municipio/daem/cargar_imagen";
$route['municipio/daem/cortar-imagen']    = "municipio/daem/cortar_imagen";
$route['municipio/daem/eliminar-imagen']  = "municipio/daem/eliminar_imagen";

#alcalde
$route['municipio/alcalde']                  = "municipio/alcalde";
$route['municipio/alcalde/(:num)']           = "municipio/alcalde";
$route['municipio/alcalde/agregar']          = "municipio/alcalde/agregar";
$route['municipio/alcalde/editar/(:num)']    = "municipio/alcalde/editar/$1";
$route['municipio/alcalde/eliminar']         = "municipio/alcalde/eliminar";
$route['municipio/alcalde/cargar-imagen']    = "municipio/alcalde/cargar_imagen";
$route['municipio/alcalde/cortar-imagen']    = "municipio/alcalde/cortar_imagen";
$route['municipio/alcalde/eliminar-imagen']  = "municipio/alcalde/eliminar_imagen";

#consejo
$route['municipio/consejo']                  = "municipio/consejo";
$route['municipio/consejo/(:num)']           = "municipio/consejo";
$route['municipio/consejo/agregar']          = "municipio/consejo/agregar";
$route['municipio/consejo/editar/(:num)']    = "municipio/consejo/editar/$1";
$route['municipio/consejo/eliminar']         = "municipio/consejo/eliminar";
$route['municipio/consejo/cargar-imagen']    = "municipio/consejo/cargar_imagen";
$route['municipio/consejo/cortar-imagen']    = "municipio/consejo/cortar_imagen";
$route['municipio/consejo/eliminar-imagen']  = "municipio/consejo/eliminar_imagen";

#organigrama
$route['municipio/organigrama']                  = "municipio/organigrama";
$route['municipio/organigrama/(:num)']           = "municipio/organigrama";
$route['municipio/organigrama/agregar']          = "municipio/organigrama/agregar";
$route['municipio/organigrama/editar/(:num)']    = "municipio/organigrama/editar/$1";
$route['municipio/organigrama/eliminar']         = "municipio/organigrama/eliminar";
$route['municipio/organigrama/cargar-imagen']    = "municipio/organigrama/cargar_imagen";
$route['municipio/organigrama/cortar-imagen']    = "municipio/organigrama/cortar_imagen";
$route['municipio/organigrama/eliminar-imagen']  = "municipio/organigrama/eliminar_imagen";

#FIN MUNICIPIO

#CONFIGURACION

#administradores
$route['configuracion/administradores']                  = "configuracion/administradores";
$route['configuracion/administradores/(:num)']           = "configuracion/administradores";
$route['configuracion/administradores/agregar']          = "configuracion/administradores/agregar";
$route['configuracion/administradores/editar/(:num)']    = "configuracion/administradores/editar/$1";
$route['configuracion/administradores/eliminar']         = "configuracion/administradores/eliminar";

#temporadas de calendario
$route['configuracion/temporadas-calendario']                  = "configuracion/temporadas_calendario";
$route['configuracion/temporadas-calendario/(:num)']           = "configuracion/temporadas_calendario";
$route['configuracion/temporadas-calendario/agregar']          = "configuracion/temporadas_calendario/agregar";
$route['configuracion/temporadas-calendario/editar/(:num)']    = "configuracion/temporadas_calendario/editar/$1";
$route['configuracion/temporadas-calendario/eliminar']         = "configuracion/temporadas_calendario/eliminar";

#categorias de calendario
$route['configuracion/categorias-calendario']                  = "configuracion/categorias_calendario";
$route['configuracion/categorias-calendario/(:num)']           = "configuracion/categorias_calendario";
$route['configuracion/categorias-calendario/agregar']          = "configuracion/categorias_calendario/agregar";
$route['configuracion/categorias-calendario/editar/(:num)']    = "configuracion/categorias_calendario/editar/$1";
$route['configuracion/categorias-calendario/eliminar']         = "configuracion/categorias_calendario/eliminar";

#categorias de noticias
$route['configuracion/categorias-noticias']                  = "configuracion/categorias_noticias";
$route['configuracion/categorias-noticias/(:num)']           = "configuracion/categorias_noticias";
$route['configuracion/categorias-noticias/agregar']          = "configuracion/categorias_noticias/agregar";
$route['configuracion/categorias-noticias/editar/(:num)']    = "configuracion/categorias_noticias/editar/$1";
$route['configuracion/categorias-noticias/eliminar']         = "configuracion/categorias_noticias/eliminar";

#camaras en vivo
$route['configuracion/camaras-vivo']                  = "configuracion/camaras_vivo";
$route['configuracion/camaras-vivo/(:num)']           = "configuracion/camaras_vivo";
$route['configuracion/camaras-vivo/agregar']          = "configuracion/camaras_vivo/agregar";
$route['configuracion/camaras-vivo/editar/(:num)']    = "configuracion/camaras_vivo/editar/$1";
$route['configuracion/camaras-vivo/eliminar']         = "configuracion/camaras_vivo/eliminar";

#asuntos de contactos
$route['configuracion/asuntos-contacto']                  = "configuracion/asuntos_contacto";
$route['configuracion/asuntos-contacto/(:num)']           = "configuracion/asuntos_contacto";
$route['configuracion/asuntos-contacto/agregar']          = "configuracion/asuntos_contacto/agregar";
$route['configuracion/asuntos-contacto/editar/(:num)']    = "configuracion/asuntos_contacto/editar/$1";
$route['configuracion/asuntos-contacto/eliminar']         = "configuracion/asuntos_contacto/eliminar";

#areas de trabajo
$route['configuracion/areas-trabajo']                  = "configuracion/areas_trabajo";
$route['configuracion/areas-trabajo/(:num)']           = "configuracion/areas_trabajo";
$route['configuracion/areas-trabajo/agregar']          = "configuracion/areas_trabajo/agregar";
$route['configuracion/areas-trabajo/editar/(:num)']    = "configuracion/areas_trabajo/editar/$1";
$route['configuracion/areas-trabajo/eliminar']         = "configuracion/areas_trabajo/eliminar";

#datos generales
$route['configuracion/datos-generales']                  = "configuracion/datos_generales";
$route['configuracion/datos-generales/agregar']          = "configuracion/datos_generales/agregar";

#FIN CONFIGURACION





/*
#NUESTRA HISTORIA

#slider
$route['historia/slider']                  = "historia/slider";
$route['historia/slider/(:num)']           = "historia/slider";
$route['historia/slider/agregar']          = "historia/slider/agregar";
$route['historia/slider/editar/(:num)']    = "historia/slider/editar/$1";
$route['historia/slider/eliminar']         = "historia/slider/eliminar";
$route['historia/slider/cargar-imagen']    = "historia/slider/cargar_imagen";
$route['historia/slider/cortar-imagen']    = "historia/slider/cortar_imagen";
$route['historia/slider/eliminar-imagen']  = "historia/slider/eliminar_imagen";

#introduccion
$route['historia/introduccion']                  = "historia/introduccion";
$route['historia/introduccion/agregar']          = "historia/introduccion/agregar";

#secciones
$route['historia/secciones']                  = "historia/secciones";
$route['historia/secciones/(:num)']           = "historia/secciones";
$route['historia/secciones/agregar']          = "historia/secciones/agregar";
$route['historia/secciones/editar/(:num)']    = "historia/secciones/editar/$1";
$route['historia/secciones/eliminar']         = "historia/secciones/eliminar";
$route['historia/secciones/cargar-imagen']    = "historia/secciones/cargar_imagen";
$route['historia/secciones/cortar-imagen']    = "historia/secciones/cortar_imagen";
$route['historia/secciones/eliminar-imagen']  = "historia/secciones/eliminar_imagen";
$route['historia/secciones/eliminar-imagen-adjunta'] = "historia/secciones/eliminar_imagen_adjunta";

#FIN NUESTRA HISTORIA

#VALLE LAS TRANCAS

#slider
$route['valle-las-trancas/slider']                  = "valle_trancas/slider";
$route['valle-las-trancas/slider/(:num)']           = "valle_trancas/slider";
$route['valle-las-trancas/slider/agregar']          = "valle_trancas/slider/agregar";
$route['valle-las-trancas/slider/editar/(:num)']    = "valle_trancas/slider/editar/$1";
$route['valle-las-trancas/slider/eliminar']         = "valle_trancas/slider/eliminar";
$route['valle-las-trancas/slider/cargar-imagen']    = "valle_trancas/slider/cargar_imagen";
$route['valle-las-trancas/slider/cortar-imagen']    = "valle_trancas/slider/cortar_imagen";
$route['valle-las-trancas/slider/eliminar-imagen']  = "valle_trancas/slider/eliminar_imagen";

#introduccion
$route['valle-las-trancas/introduccion']                  = "valle_trancas/introduccion";
$route['valle-las-trancas/introduccion/agregar']          = "valle_trancas/introduccion/agregar";

#secciones
$route['valle-las-trancas/secciones']                  = "valle_trancas/secciones";
$route['valle-las-trancas/secciones/(:num)']           = "valle_trancas/secciones";
$route['valle-las-trancas/secciones/agregar']          = "valle_trancas/secciones/agregar";
$route['valle-las-trancas/secciones/editar/(:num)']    = "valle_trancas/secciones/editar/$1";
$route['valle-las-trancas/secciones/eliminar']         = "valle_trancas/secciones/eliminar";
$route['valle-las-trancas/secciones/cargar-imagen']    = "valle_trancas/secciones/cargar_imagen";
$route['valle-las-trancas/secciones/cortar-imagen']    = "valle_trancas/secciones/cortar_imagen";
$route['valle-las-trancas/secciones/eliminar-imagen']  = "valle_trancas/secciones/eliminar_imagen";
$route['valle-las-trancas/secciones/eliminar-imagen-adjunta'] = "valle_trancas/secciones/eliminar_imagen_adjunta";

#FIN VALLE LAS TRANCAS


#INVIERNO

#slider
$route['invierno/slider']                  = "invierno/slider";
$route['invierno/slider/(:num)']           = "invierno/slider";
$route['invierno/slider/agregar']          = "invierno/slider/agregar";
$route['invierno/slider/editar/(:num)']    = "invierno/slider/editar/$1";
$route['invierno/slider/eliminar']         = "invierno/slider/eliminar";
$route['invierno/slider/cargar-imagen']    = "invierno/slider/cargar_imagen";
$route['invierno/slider/cortar-imagen']    = "invierno/slider/cortar_imagen";
$route['invierno/slider/eliminar-imagen']  = "invierno/slider/eliminar_imagen";

#introduccion
$route['invierno/introduccion']                  = "invierno/introduccion";
$route['invierno/introduccion/agregar']          = "invierno/introduccion/agregar";

#secciones
$route['invierno/secciones']                  = "invierno/secciones";
$route['invierno/secciones/(:num)']           = "invierno/secciones";
$route['invierno/secciones/agregar']          = "invierno/secciones/agregar";
$route['invierno/secciones/editar/(:num)']    = "invierno/secciones/editar/$1";
$route['invierno/secciones/eliminar']         = "invierno/secciones/eliminar";
$route['invierno/secciones/cargar-imagen']    = "invierno/secciones/cargar_imagen";
$route['invierno/secciones/cortar-imagen']    = "invierno/secciones/cortar_imagen";
$route['invierno/secciones/eliminar-imagen']  = "invierno/secciones/eliminar_imagen";
$route['invierno/secciones/eliminar-imagen-adjunta'] = "invierno/secciones/eliminar_imagen_adjunta";

#cafeterias
$route['invierno/cafeterias']                  = "invierno/cafeterias";
$route['invierno/cafeterias/(:num)']           = "invierno/cafeterias";
$route['invierno/cafeterias/agregar']          = "invierno/cafeterias/agregar";
$route['invierno/cafeterias/editar/(:num)']    = "invierno/cafeterias/editar/$1";
$route['invierno/cafeterias/eliminar']         = "invierno/cafeterias/eliminar";
$route['invierno/cafeterias/cargar-imagen']    = "invierno/cafeterias/cargar_imagen";
$route['invierno/cafeterias/cortar-imagen']    = "invierno/cafeterias/cortar_imagen";
$route['invierno/cafeterias/eliminar-imagen']  = "invierno/cafeterias/eliminar_imagen";

#programas y valores
$route['invierno/programas-valores']         = "invierno/programas_valores";
$route['invierno/programas-valores/agregar'] = "invierno/programas_valores/agregar";

#mapa de pistas
$route['invierno/mapa-pistas']         = "invierno/mapa_pistas";
$route['invierno/mapa-pistas/agregar'] = "invierno/mapa_pistas/agregar";

#FIN INVIERNO

#VERANO

#slider
$route['verano/slider']                  = "verano/slider";
$route['verano/slider/(:num)']           = "verano/slider";
$route['verano/slider/agregar']          = "verano/slider/agregar";
$route['verano/slider/editar/(:num)']    = "verano/slider/editar/$1";
$route['verano/slider/eliminar']         = "verano/slider/eliminar";
$route['verano/slider/cargar-imagen']    = "verano/slider/cargar_imagen";
$route['verano/slider/cortar-imagen']    = "verano/slider/cortar_imagen";
$route['verano/slider/eliminar-imagen']  = "verano/slider/eliminar_imagen";

#introduccion
$route['verano/introduccion']                  = "verano/introduccion";
$route['verano/introduccion/agregar']          = "verano/introduccion/agregar";

#secciones
$route['verano/secciones']                  = "verano/secciones";
$route['verano/secciones/(:num)']           = "verano/secciones";
$route['verano/secciones/agregar']          = "verano/secciones/agregar";
$route['verano/secciones/editar/(:num)']    = "verano/secciones/editar/$1";
$route['verano/secciones/eliminar']         = "verano/secciones/eliminar";
$route['verano/secciones/cargar-imagen']    = "verano/secciones/cargar_imagen";
$route['verano/secciones/cortar-imagen']    = "verano/secciones/cortar_imagen";
$route['verano/secciones/eliminar-imagen']  = "verano/secciones/eliminar_imagen";
$route['verano/secciones/eliminar-imagen-adjunta'] = "verano/secciones/eliminar_imagen_adjunta";

#programas y valores
$route['verano/programas-valores']         = "verano/programas_valores";
$route['verano/programas-valores/agregar'] = "verano/programas_valores/agregar";

#FIN VERANO

#INFO NIEVE

#estado del camino
$route['info-nieve/estado-camino']          = "info_nieve/estado_camino";
$route['info-nieve/estado-camino/agregar']  = "info_nieve/estado_camino/agregar";

#nieve
$route['info-nieve/nieve']          = "info_nieve/nieve";
$route['info-nieve/nieve/agregar']  = "info_nieve/nieve/agregar";

#estado de pistas
$route['info-nieve/estado-pistas']                  = "info_nieve/estado_pistas";
$route['info-nieve/estado-pistas/(:num)']           = "info_nieve/estado_pistas";
$route['info-nieve/estado-pistas/agregar']          = "info_nieve/estado_pistas/agregar";
$route['info-nieve/estado-pistas/editar/(:num)']    = "info_nieve/estado_pistas/editar/$1";
$route['info-nieve/estado-pistas/eliminar']         = "info_nieve/estado_pistas/eliminar";

#estado de andariveles
$route['info-nieve/estado-andariveles']                  = "info_nieve/estado_andariveles";
$route['info-nieve/estado-andariveles/(:num)']           = "info_nieve/estado_andariveles";
$route['info-nieve/estado-andariveles/agregar']          = "info_nieve/estado_andariveles/agregar";
$route['info-nieve/estado-andariveles/editar/(:num)']    = "info_nieve/estado_andariveles/editar/$1";
$route['info-nieve/estado-andariveles/eliminar']         = "info_nieve/estado_andariveles/eliminar";

#FIN INFO NIEVE




#ESCUELA

#conoce nuestras instalaciones
$route['escuela/conoce-nuestras-instalaciones']                 = "escuela/conoce_instalaciones";
$route['escuela/conoce-nuestras-instalaciones/agregar']         = "escuela/conoce_instalaciones/agregar";
$route['escuela/conoce-nuestras-instalaciones/cargar-imagen']   = "escuela/conoce_instalaciones/cargar_imagen";
$route['escuela/conoce-nuestras-instalaciones/cortar-imagen']   = "escuela/conoce_instalaciones/cortar_imagen";
$route['escuela/conoce-nuestras-instalaciones/eliminar-imagen'] = "escuela/conoce_instalaciones/eliminar_imagen";

#profesor guia
$route['escuela/profesor-guia']                             = "escuela/profesor_guia";
$route['escuela/profesor-guia/agregar']                     = "escuela/profesor_guia/agregar";
$route['escuela/profesor-guia/cargar-imagen']               = "escuela/profesor_guia/cargar_imagen";
$route['escuela/profesor-guia/cortar-imagen']               = "escuela/profesor_guia/cortar_imagen";
$route['escuela/profesor-guia/eliminar-imagen']             = "escuela/profesor_guia/eliminar_imagen";
$route['escuela/profesor-guia/descargar-archivo/(:num)']    = "escuela/profesor_guia/descargar_archivo/$1";
$route['escuela/profesor-guia/eliminar-archivo']            = "escuela/profesor_guia/eliminar_archivo";
$route['escuela/secciones/cargar-imagen']          = "escuela/secciones/cargar_imagen";
$route['escuela/secciones/cortar-imagen']          = "escuela/secciones/cortar_imagen";
$route['escuela/secciones/eliminar-imagen']        = "escuela/secciones/eliminar_imagen";

#programas y valores
$route['escuela/programas-valores']          = "escuela/programas_valores";
$route['escuela/programas-valores/agregar']  = "escuela/programas_valores/agregar";

#FIN ESCUELA



#INVIERNO

#slider
$route['bike-park/slider']                  = "bike_park/slider";
$route['bike-park/slider/(:num)']           = "bike_park/slider";
$route['bike-park/slider/agregar']          = "bike_park/slider/agregar";
$route['bike-park/slider/editar/(:num)']    = "bike_park/slider/editar/$1";
$route['bike-park/slider/eliminar']         = "bike_park/slider/eliminar";
$route['bike-park/slider/cargar-imagen']    = "bike_park/slider/cargar_imagen";
$route['bike-park/slider/cortar-imagen']    = "bike_park/slider/cortar_imagen";
$route['bike-park/slider/eliminar-imagen']  = "bike_park/slider/eliminar_imagen";

#secciones
$route['bike-park/secciones']                  = "bike_park/secciones";
$route['bike-park/secciones/(:num)']           = "bike_park/secciones";
$route['bike-park/secciones/agregar']          = "bike_park/secciones/agregar";
$route['bike-park/secciones/editar/(:num)']    = "bike_park/secciones/editar/$1";
$route['bike-park/secciones/eliminar']         = "bike_park/secciones/eliminar";
$route['bike-park/secciones/cargar-imagen']    = "bike_park/secciones/cargar_imagen";
$route['bike-park/secciones/cortar-imagen']    = "bike_park/secciones/cortar_imagen";
$route['bike-park/secciones/eliminar-imagen']  = "bike_park/secciones/eliminar_imagen";
$route['bike-park/secciones/eliminar-imagen-adjunta'] = "bike_park/secciones/eliminar_imagen_adjunta";

#bike park
$route['bike-park']                             = "bike_park";
$route['bike-park/agregar']                     = "bike_park/agregar";
$route['bike-park/cargar-imagen']               = "bike_park/cargar_imagen";
$route['bike-park/cortar-imagen']               = "bike_park/cortar_imagen";
$route['bike-park/eliminar-imagen']             = "bike_park/eliminar_imagen";

#programas y valores
$route['bike-park/programas-valores']          = "bike_park/programas_valores";
$route['bike-park/programas-valores/agregar']  = "bike_park/programas_valores/agregar";

#FIN INVIERNO



#AYUDA

#slider
$route['ayuda/slider']                  = "ayuda/slider";
$route['ayuda/slider/(:num)']           = "ayuda/slider";
$route['ayuda/slider/agregar']          = "ayuda/slider/agregar";
$route['ayuda/slider/editar/(:num)']    = "ayuda/slider/editar/$1";
$route['ayuda/slider/eliminar']         = "ayuda/slider/eliminar";
$route['ayuda/slider/cargar-imagen']    = "ayuda/slider/cargar_imagen";
$route['ayuda/slider/cortar-imagen']    = "ayuda/slider/cortar_imagen";
$route['ayuda/slider/eliminar-imagen']  = "ayuda/slider/eliminar_imagen";

#como llegar
$route['ayuda/como-llegar']                 = "ayuda/como_llegar";
$route['ayuda/como-llegar/(:num)']          = "ayuda/como_llegar";
$route['ayuda/como-llegar/agregar']         = "ayuda/como_llegar/agregar";
$route['ayuda/como-llegar/editar/(:num)']   = "ayuda/como_llegar/editar/$1";
$route['ayuda/como-llegar/eliminar']        = "ayuda/como_llegar/eliminar";

#preguntas frecuentes
$route['ayuda/preguntas-frecuentes']                 = "ayuda/preguntas_frecuentes";
$route['ayuda/preguntas-frecuentes/(:num)']          = "ayuda/preguntas_frecuentes";
$route['ayuda/preguntas-frecuentes/agregar']         = "ayuda/preguntas_frecuentes/agregar";
$route['ayuda/preguntas-frecuentes/editar/(:num)']   = "ayuda/preguntas_frecuentes/editar/$1";
$route['ayuda/preguntas-frecuentes/eliminar']        = "ayuda/preguntas_frecuentes/eliminar";

#condiciones y reglamentos
$route['ayuda/condiciones-reglamentos']                            = "ayuda/condiciones_reglamentos";
$route['ayuda/condiciones-reglamentos/(:num)']                     = "ayuda/condiciones_reglamentos";
$route['ayuda/condiciones-reglamentos/agregar']                    = "ayuda/condiciones_reglamentos/agregar";
$route['ayuda/condiciones-reglamentos/editar/(:num)']              = "ayuda/condiciones_reglamentos/editar/$1";
$route['ayuda/condiciones-reglamentos/eliminar']                   = "ayuda/condiciones_reglamentos/eliminar";
$route['ayuda/condiciones-reglamentos/descargar-archivo/(:num)']   = "ayuda/condiciones_reglamentos/descargar_archivo/$1";
$route['ayuda/condiciones-reglamentos/eliminar-archivo']           = "ayuda/condiciones_reglamentos/eliminar_archivo";

#trabaja con nosotros
$route['ayuda/trabaja-con-nosotros']                            = "ayuda/trabaja_con_nosotros";
$route['ayuda/trabaja-con-nosotros/(:num)']                     = "ayuda/trabaja_con_nosotros";
$route['ayuda/trabaja-con-nosotros/detalle/(:num)']             = "ayuda/trabaja_con_nosotros/detalle/$1";
$route['ayuda/trabaja-con-nosotros/descargar-archivo/(:num)']   = "ayuda/trabaja_con_nosotros/descargar_archivo/$1";

#contactos
$route['ayuda/contactos']                   = "ayuda/contactos";
$route['ayuda/contactos/(:num)']            = "ayuda/contactos";
$route['ayuda/contactos/detalle/(:num)']    = "ayuda/contactos/detalle/$1";

#FIN AYUDA

#FreeRide
$route['freeride']          = "freeride";
$route['freeride/agregar']  = "freeride/agregar";
#FIN FreeRide

#NEWSLETTER
$route['newsletter']         = "newsletter";
$route['newsletter/(:num)'] = "newsletter";


#Landing Pages
$route['landing_pages']                 = "landing_pages";
$route['landing_pages/(:num)']          = "landing_pages";
$route['landing_pages/agregar']         = "landing_pages/agregar";
$route['landing_pages/editar/(:num)']   = "landing_pages/editar/$1";
$route['landing_pages/eliminar']        = "landing_pages/eliminar";
$route['landing_pages/cargar-imagen']          = "landing_pages/cargar_imagen";
$route['landing_pages/cortar-imagen']          = "landing_pages/cortar_imagen";
$route['landing_pages/eliminar-imagen']        = "landing_pages/eliminar_imagen";

#Landing Pages
$route['contactos_landing']                 = "contactos_landing";
$route['contactos_landing/(:num)']          = "landing_pages";
$route['contactos_landing/agregar']         = "contactos_landing/agregar";
$route['contactos_landing/editar/(:num)']   = "contactos_landing/editar/$1";
$route['contactos_landing/eliminar']        = "contactos_landing/eliminar";
$route['contactos_landing/cargar-imagen']          = "contactos_landing/cargar_imagen";
$route['contactos_landing/cortar-imagen']          = "contactos_landing/cortar_imagen";
$route['contactos_landing/eliminar-imagen']        = "contactos_landing/eliminar_imagen";
*/

/* End of file routes.php */
/* Location: ./application/config/routes.php */