﻿<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Accesos_directos extends CI_Controller
{

    private $nombre = 'Accesos directos';
    private $modulo = 14;
    public $img;

    function __construct()
    {
        parent::__construct();

        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 160;
        $this->img->min_alto_1 = 160;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 160*4;
        $this->img->max_alto_1 = 160*4;

        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 160;
        $this->img->recorte_alto_1 = 160;

        $this->img->upload_dir = '/imagenes/modulos/portada/accesos_directos/';

        #lib imagenes
        $this->load->model('inicio/imagen', 'objImagen');
    }

    public function index()
    {
        #Title
        $data['titulo'] = $this->nombre;
        $this->layout->title($this->nombre);

        #js
        $this->layout->js('/js/sistema/portada/accesos_directos/index.js');

        $where = $and = "";
        $url = "";

        $where = "acc_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 3;
        $config['base_url'] = '/portada/accesos-directos/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("acc_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        #Nav
        $this->layout->nav(array($this->nombre => '/'));

        #view
        $this->layout->view('accesos_directos/index', $data);
    }

    public function agregar($codigo = false)
    {
        #js
        $this->layout->js('/js/sistema/portada/accesos_directos/agregar.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        # Contenido
        $data = array();

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "acc_codigo = " . $codigo);
            #print_array($result);
            if (!$result) {
                redirect('/portada/accesos-directos/');
            } else {
                $data['result'] = $result;
            }
        }

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array($this->nombre => "/portada/accesos-directos/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array($this->nombre => "/portada/accesos-directos/", "Agregar " . $this->nombre => "/"));
        }

        #view
        $this->layout->view('accesos_directos/add', $data);

    }

    public function process()
    {
        #print_array($this->input->post());
        if ($this->input->post()) {

            #validaciones
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('estado', 'Estado', 'required');

            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>', '</div>');

            if (!$this->form_validation->run()) {
                echo json_encode(array("result" => false, "msg" => validation_errors()));
                exit;
            } else {
                try {
                    $codigo = $this->input->post('codigo', true);

                    $data['acc_estado'] = $this->input->post('estado');
                    $data['acc_url'] = slug($this->input->post('nombre'));
                    $data['acc_nombre'] = $this->input->post('nombre');
                    $data['acc_link'] = $this->input->post('link');
                    $data['acc_orden'] = $this->input->post('orden');

                    if ($this->input->post('ruta_interna_1'))
                        $data['acc_imagen_ruta_interna'] = $this->input->post('ruta_interna_1');

                    if ($this->input->post('ruta_grande_1'))
                        $data['acc_imagen_ruta_grande'] = $this->input->post('ruta_grande_1');

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'acc_codigo = ' . $codigo)) {
                            echo json_encode(array("result" => true, "codigo" => $codigo));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {
                            echo json_encode(array("result" => true, "codigo" => $codigo->acc_codigo));
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
            $this->ws->eliminar($this->modulo, "acc_codigo = {$this->input->post('codigo')}");
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
            if ($modelo = $this->ws->obtener($this->modulo, "acc_codigo = $codigo")) {
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                    unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                $this->ws->actualizar($this->modulo, array("acc_imagen_ruta_interna" => ""), "acc_codigo = $codigo");

                $this->ws->actualizar($this->modulo, array("acc_imagen_ruta_grande" => ""), "acc_codigo = $codigo");
            }
        }

        echo json_encode(array("result" => true));
    }

}