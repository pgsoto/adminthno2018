<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Introduccion extends CI_Controller
{
    private $modulo = 69, $modulo_hotel = 14;

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');

        if($hotel->url == 'hotel-nevados'){
            $seccion = 5;
        }elseif($hotel->url == 'hotel-alto-nevados'){
            $seccion = 6;
        }elseif($hotel->url == 'deptos-valle-hermoso'){
            $seccion = 7;
        }

        #Title
        $this->layout->title('Introducción');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');

        #js
        $this->layout->js('/js/sistema/hoteles/introduccion/index.js');

        #contenido
        $contenido["introduccion"] = $informacion = $this->ws->obtener($this->modulo, "int_tipo_seccion = " . $seccion);

        #Nav
        $this->layout->nav(array("Introducción" => '/'));

        #view
        $this->layout->view('introduccion/index', $contenido);
    }

    public function agregar()
    {
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');

        if($hotel->url == 'hotel-nevados'){
            $seccion = 5;
        }elseif($hotel->url == 'hotel-alto-nevados'){
            $seccion = 6;
        }elseif($hotel->url == 'deptos-valle-hermoso'){
            $seccion = 7;
        }

        if ($this->input->post()) {

            $error = "";
            if ($error) {
                echo json_encode(array("result" => false, "msg" => $error));
                exit;
            }

            $datos['int_descripcion'] = $this->input->post('descripcion');
            $datos['int_tipo_seccion'] = $this->seccion;

            if ($codigo = $this->input->post('codigo')) {
                $this->ws->actualizar($this->modulo, $datos, "int_tipo_seccion = $seccion");
            } else {
                $this->ws->insertar($this->modulo, $datos);
            }
            echo json_encode(array("result" => true));

        }
    }

}