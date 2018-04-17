﻿<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Direcciones extends CI_Controller
{

    private $nombre = 'Direcciones';
    private $modulo = 29, $modulo_imagenes = 30;
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
        $this->img->min_ancho_1 = 1920;
        $this->img->min_alto_1 = 720;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 1920 * 4;
        $this->img->max_alto_1 = 720 * 4;

        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 1920;
        $this->img->recorte_alto_1 = 720;

        $this->img->upload_dir = '/imagenes/modulos/municipio/direcciones/';

        #lib imagenes
        $this->load->model('inicio/imagen', 'objImagen');
    }

    public function index()
    {
        #Title
        $data['titulo'] = $this->nombre;
        $this->layout->title($this->nombre);

        #js
        $this->layout->js('/js/sistema/municipio/direcciones/index.js');

        $where = $and = "";
        $url = "";

        $where = "dir_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 3;
        $config['base_url'] = '/municipio/direcciones/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("dir_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        #Nav
        $this->layout->nav(array($this->nombre => '/'));

        #view
        $this->layout->view('direcciones/index', $data);
    }

    public function agregar($codigo = false)
    {
        #js
        $this->layout->js('/js/sistema/municipio/direcciones/agregar.js');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        $this->layout->js('/js/jquery/ckfinder/ckfinder.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        # Contenido
        $data = array();

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "dir_codigo = " . $codigo);
            if ($result) {
                $result->mapa_coor = explode(",", $result->mapa);
                $result->imagenes = $this->ws->listar($this->modulo_imagenes, "gald_direccion = " . $codigo);
            }
            #print_array($result);
            if (!$result) {
                redirect('/municipio/direcciones/');
            } else {
                $data['result'] = $result;
            }
        }

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array($this->nombre => "/municipio/direcciones/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array($this->nombre => "/municipio/direcciones/", "Agregar " . $this->nombre => "/"));
        }

        #view
        $this->layout->view('direcciones/add', $data);

    }

    public function process()
    {
        #print_array($this->input->post());die;
        if ($this->input->post()) {

            #validaciones
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('orden', 'Orden', 'required');
            $this->form_validation->set_rules('mapa', 'Mapa', 'required');
            $this->form_validation->set_rules('estado', 'Estado', 'required');

            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>', '</div>');

            if (!$this->form_validation->run()) {
                echo json_encode(array("result" => false, "msg" => validation_errors()));
                exit;
            } else {
                try {
                    $codigo = $this->input->post('codigo', true);

                    $data['dir_estado'] = $this->input->post('estado');
                    $data['dir_url'] = slug($this->input->post('nombre'));
                    $data['dir_nombre'] = $this->input->post('nombre');
                    $data['dir_orden'] = $this->input->post('orden');
                    $data['dir_descripcion'] = $this->input->post('descripcion');
                    $data['dir_datos_contacto'] = $this->input->post('datos_contacto');

                    if ($this->input->post('ruta_interna_2')) {
                        $data['dir_imagen_ruta_interna'] = $this->input->post('ruta_interna_2');
                        $data['dir_imagen_ruta_grande'] = $this->input->post('ruta_grande_2');
                    }

                    if ($this->input->post("mapa"))
                        $data['dir_mapa'] = str_replace(array("(", ")", " "), "", $this->input->post("mapa"));

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($update = $this->ws->actualizar($this->modulo, $data, 'dir_codigo = ' . $codigo)) {

                            #GALERIA SLIDER
                            $internas = $this->input->post('ruta_interna_1');
                            $grandes = $this->input->post('ruta_grande_1');
                            if ($grandes) {
                                foreach ($grandes as $k => $aux) {
                                    if ($aux) {
                                        $data2['gald_imagen_ruta_interna'] = $internas[$k];
                                        $data2['gald_imagen_ruta_grande'] = $aux;
                                        $data2['gald_direccion'] = $codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }
                            unset($data2);

                            echo json_encode(array("result" => true, "codigo" => $codigo));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {

                            #GALERIA SLIDER
                            $internas = $this->input->post('ruta_interna_1');
                            $grandes = $this->input->post('ruta_grande_1');
                            if ($grandes) {
                                foreach ($grandes as $k => $aux) {
                                    if ($aux) {
                                        $data2['gald_imagen_ruta_interna'] = $internas[$k];
                                        $data2['gald_imagen_ruta_grande'] = $aux;
                                        $data2['gald_direccion'] = $codigo->dir_codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }
                            unset($data2);

                            echo json_encode(array("result" => true, "codigo" => $codigo->dir_codigo));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    }
                    unset($data);

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
            $this->ws->eliminar($this->modulo, "dir_codigo = {$this->input->post('codigo')}");
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

        if ($codigo = $this->input->post('codigo')) {
            if ($modelo = $this->ws->obtener($this->modulo, "dir_codigo = $codigo")) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                $this->ws->actualizar($this->modulo, array("dir_imagen_ruta_interna" => ""), "dir_codigo = $codigo");

                $this->ws->actualizar($this->modulo, array("dir_imagen_ruta_grande" => ""), "dir_codigo = $codigo");
            }
        }

        echo json_encode(array("result" => true));
    }

}