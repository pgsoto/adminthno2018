﻿<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Subsecciones_talcahuano_historico extends CI_Controller
{

    private $nombre = 'Subsecciones Talcahuano Histórico';
    private $modulo = 66, $modulo_imagenes = 67, $modulo_seccion = 64;
    public $img;

    function __construct()
    {
        parent::__construct();

        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_2 = 120;
        $this->img->min_alto_2 = 120;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_2 = 120 * 4;
        $this->img->max_alto_2 = 120 * 4;

        #define el tamaño del recorte
        $this->img->recorte_ancho_2 = 120;
        $this->img->recorte_alto_2 = 120;

        #GALERIA SLIDER
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 1920 / 4;
        $this->img->min_alto_1 = 720 / 4;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 1920 * 4;
        $this->img->max_alto_1 = 720 * 4;

        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 1920;
        $this->img->recorte_alto_1 = 720;

        $this->img->upload_dir = '/imagenes/modulos/tuciudad/talcahuano_historico/subsecciones/';

        #lib imagenes
        $this->load->model('inicio/imagen', 'objImagen');
    }

    public function index()
    {
        $seccion = 1;

        # Contenido
        $data = array();

        $data['seccion'] = $seccion;

        #Title
        $data['titulo'] = $this->nombre;
        $this->layout->title($this->nombre);

        #js
        $this->layout->js('/js/sistema/tuciudad/talcahuano_historico/subsecciones/index.js');

        $where = $and = "";
        $url = "";

        $where .= "subtalhis_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 5;
        $config['base_url'] = '/tuciudad/talcahuano-historico/subsecciones/' . $seccion . '/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("subtalhis_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        $seccion = $this->ws->obtener($this->modulo_seccion, "talhis_codigo = " . $seccion);

        #Nav
        $this->layout->nav(array('Talcahuano Histórico' => '/tuciudad/talcahuano-historico/', $this->nombre => '/'));

        #view
        $this->layout->view('talcahuano_historico/subsecciones/index', $data);
    }

    public function agregar($seccion = false, $codigo = false)
    {
        # Contenido
        $data = array();

        $data['seccion'] = $seccion;

        #js
        $this->layout->js('/js/sistema/tuciudad/talcahuano_historico/subsecciones/agregar.js');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        $this->layout->js('/js/jquery/ckfinder/ckfinder.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "subtalhis_codigo = " . $codigo);
            if ($result) {
                $result->mapa_coor = explode(",", $result->mapa);
                $result->imagenes = $this->ws->listar($this->modulo_imagenes, "galsubtalhis_subseccion = " . $codigo);
            }
            #print_array($result);
            if (!$result) {
                redirect('/tuciudad/talcahuano-historico/subsecciones/');
            } else {
                $data['result'] = $result;
            }
        }

        $seccion = $this->ws->obtener($this->modulo_seccion, "talhis_codigo = " . $seccion);

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array("Talcahuano Histórico" => "/tuciudad/talcahuano-historico/", $this->nombre => "/tuciudad/talcahuano-historico/subsecciones/" . $seccion->codigo . "/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array("Talcahuano Histórico" => "/tuciudad/talcahuano-historico/", $this->nombre => "/tuciudad/talcahuano-historico/subsecciones/" . $seccion->codigo . "/", "Agregar " . $this->nombre => "/"));
        }

        #view
        $this->layout->view('talcahuano_historico/subsecciones/add', $data);

    }

    public function process()
    {
        #print_array($this->input->post());#die;
        if ($this->input->post()) {

            #validaciones
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('orden', 'Orden', 'required');
            $this->form_validation->set_rules('estado', 'Estado', 'required');

            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>', '</div>');

            if (!$this->form_validation->run()) {
                echo json_encode(array("result" => false, "msg" => validation_errors()));
                exit;
            } else {
                try {
                    $codigo = $this->input->post('codigo', true);

                    $data['subtalhis_estado'] = $this->input->post('estado');
                    $data['subtalhis_url'] = slug($this->input->post('nombre'));
                    $data['subtalhis_nombre'] = $this->input->post('nombre');
                    $data['subtalhis_orden'] = $this->input->post('orden');
                    $data['subtalhis_descripcion'] = $this->input->post('descripcion');
                    $data['subtalhis_encargado'] = $this->input->post('encargado');
                    $data['subtalhis_secretaria'] = $this->input->post('secretaria');
                    $data['subtalhis_telefono'] = $this->input->post('telefono');
                    $data['subtalhis_email'] = $this->input->post('email');
                    $data['subtalhis_direccion'] = $this->input->post('direccion');

                    if ($this->input->post('ruta_interna_2')) {
                        $data['subtalhis_imagen_ruta_interna'] = $this->input->post('ruta_interna_2');
                        $data['subtalhis_imagen_ruta_grande'] = $this->input->post('ruta_grande_2');
                    }

                    if ($this->input->post("mapa"))
                        $data['subtalhis_mapa'] = str_replace(array("(", ")", " "), "", $this->input->post("mapa"));

                    $data['subtalhis_seccion'] = $this->input->post('seccion');

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'subtalhis_codigo = ' . $codigo)) {

                            #GALERIA
                            $internas = $this->input->post('ruta_interna_1');
                            $grandes = $this->input->post('ruta_grande_1');
                            if ($grandes) {
                                foreach ($grandes as $k => $aux) {
                                    if ($aux) {
                                        $data2['galsubtalhis_imagen_ruta_interna'] = $internas[$k];
                                        $data2['galsubtalhis_imagen_ruta_grande'] = $aux;
                                        $data2['galsubtalhis_subseccion'] = $codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }

                            echo json_encode(array("result" => true, "codigo" => $codigo, "seccion" => $this->input->post('seccion')));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {

                            #GALERIA
                            $internas = $this->input->post('ruta_interna_1');
                            $grandes = $this->input->post('ruta_grande_1');
                            if ($grandes) {
                                foreach ($grandes as $k => $aux) {
                                    if ($aux) {
                                        $data2['galsubtalhis_imagen_ruta_interna'] = $internas[$k];
                                        $data2['galsubtalhis_imagen_ruta_grande'] = $aux;
                                        $data2['galsubtalhis_subseccion'] = $codigo->subtalhis_codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }

                            echo json_encode(array("result" => true, "codigo" => $codigo->subtalhis_codigo, "seccion" => $this->input->post('seccion')));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    }

                } catch (Exception $e) {
                    echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                    exit;
                }
            }
        }
    }

    public function eliminar()
    {
        try {
            $this->ws->eliminar($this->modulo, "subtalhis_codigo = {$this->input->post('codigo')}");
            echo json_encode(array("result" => true));
        } catch (Exception $e) {
            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
        }
    }


    ###IMAGENES
    public function cargar_imagen()
    {

        #se realiza la configuracion para cada imagen
        $this->img->id = $this->input->post('id');
        $this->objImagen->config($this->img);

        $response = $this->objImagen->cargar_imagen($_FILES);
        echo json_encode($response);
    }

    public function cortar_imagen()
    {

        #se realiza la configuracion para cada imagen
        $this->img->id = $this->input->post('id');
        $this->objImagen->config($this->img);

        $response = $this->objImagen->cortar_imagen($_POST);
        echo json_encode($response);
    }

    public function eliminar_imagen()
    {
        if ($ruta = $this->input->post('ruta_imagen')) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $ruta))
                unlink($_SERVER['DOCUMENT_ROOT'] . $ruta);
        }

        if ($codigo = $this->input->post('codigo')) {

            if ($this->input->post('tipo') == 1) {
                if ($modelo = $this->ws->obtener($this->modulo_imagenes, "galsubtalhis_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                    $this->ws->eliminar($this->modulo_imagenes, "galsubtalhis_codigo = $codigo");
                }
            } elseif ($this->input->post('tipo') == 2) {
                if ($modelo = $this->ws->obtener($this->modulo, "subtalhis_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);
                    $data['subtalhis_imagen_ruta_interna'] = '';
                    $data['subtalhis_imagen_ruta_grande'] = '';
                    $this->ws->actualizar($this->modulo, $data, "subtalhis_codigo = $codigo");
                }
            }
        }
        echo json_encode(array("result" => true));
    }

}