﻿<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Subsecciones_informacion_util extends CI_Controller
{

    private $nombre = 'Subsecciones Información Útil';
    private $modulo = 87, $modulo_seccion = 85;
    public $img;

    function __construct()
    {
        parent::__construct();

        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 120;
        $this->img->min_alto_1 = 120;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 120 * 4;
        $this->img->max_alto_1 = 120 * 4;

        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 120;
        $this->img->recorte_alto_1 = 120;

        $this->img->upload_dir = '/imagenes/modulos/tuciudad/informacion_util/subsecciones/';

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
        $this->layout->js('/js/sistema/tuciudad/informacion_util/subsecciones/index.js');

        $where = $and = "";
        $url = "";

        $where .= "subinfuti_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 5;
        $config['base_url'] = '/tuciudad/informacion-util/subsecciones/' . $seccion . '/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("subinfuti_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        $seccion = $this->ws->obtener($this->modulo_seccion, "infuti_codigo = " . $seccion);

        #Nav
        $this->layout->nav(array('Información Útil' => '/tuciudad/informacion-util/', $this->nombre => '/'));

        #view
        $this->layout->view('informacion_util/subsecciones/index', $data);
    }

    public function agregar($seccion = false, $codigo = false)
    {
        # Contenido
        $data = array();

        $data['seccion'] = $seccion;

        #js
        $this->layout->js('/js/sistema/tuciudad/informacion_util/subsecciones/agregar.js');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        $this->layout->js('/js/jquery/ckfinder/ckfinder.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "subinfuti_codigo = " . $codigo);
            if ($result) {
                #
            }
            #print_array($result);
            if (!$result) {
                redirect('/tuciudad/informacion-util/subsecciones/');
            } else {
                $data['result'] = $result;
            }
        }

        $seccion = $this->ws->obtener($this->modulo_seccion, "infuti_codigo = " . $seccion);

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array("Información Útil" => "/tuciudad/informacion-util/", $this->nombre => "/tuciudad/informacion-util/subsecciones/" . $seccion->codigo . "/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array("Información Útil" => "/tuciudad/informacion-util/", $this->nombre => "/tuciudad/informacion-util/subsecciones/" . $seccion->codigo . "/", "Agregar " . $this->nombre => "/"));
        }

        #view
        $this->layout->view('informacion_util/subsecciones/add', $data);

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

                    $data['subinfuti_estado'] = $this->input->post('estado');
                    $data['subinfuti_url'] = slug($this->input->post('nombre'));
                    $data['subinfuti_nombre'] = $this->input->post('nombre');
                    $data['subinfuti_orden'] = $this->input->post('orden');
                    $data['subinfuti_descripcion'] = $this->input->post('descripcion');
                    $data['subinfuti_telefono'] = $this->input->post('telefono');
                    $data['subinfuti_email'] = $this->input->post('email');

                    if ($this->input->post('ruta_interna_1')) {
                        $data['subinfuti_imagen_ruta_interna'] = $this->input->post('ruta_interna_1');
                        $data['subinfuti_imagen_ruta_grande'] = $this->input->post('ruta_grande_1');
                    }

                    $data['subinfuti_seccion'] = $this->input->post('seccion');

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'subinfuti_codigo = ' . $codigo)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo, "seccion" => $this->input->post('seccion')));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo->subinfuti_codigo, "seccion" => $this->input->post('seccion')));
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
            $this->ws->eliminar($this->modulo, "subinfuti_codigo = {$this->input->post('codigo')}");
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
                if ($modelo = $this->ws->obtener($this->modulo, "subinfuti_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);
                    $data['subinfuti_imagen_ruta_interna'] = '';
                    $data['subinfuti_imagen_ruta_grande'] = '';
                    $this->ws->actualizar($this->modulo, $data, "subinfuti_codigo = $codigo");
                }
            }
        }
        echo json_encode(array("result" => true));
    }

}