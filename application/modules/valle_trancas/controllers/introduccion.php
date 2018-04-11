<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Introduccion extends CI_Controller
{
    private $modulo = 69;
    private $seccion = 10;

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        #Title
        $this->layout->title('Introducción');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');

        #js
        $this->layout->js('/js/sistema/valle-las-trancas/introduccion/index.js');

        #contenido
        $contenido["introduccion"] = $informacion = $this->ws->obtener($this->modulo, "int_tipo_seccion = " . $this->seccion);

        #Nav
        $this->layout->nav(array("Introducción" => '/'));

        #view
        $this->layout->view('introduccion/index', $contenido);
    }

    public function agregar()
    {

        if ($this->input->post()) {

            $error = "";
            if ($error) {
                echo json_encode(array("result" => false, "msg" => $error));
                exit;
            }

            $datos['int_descripcion'] = $this->input->post('descripcion');
            $datos['int_tipo_seccion'] = $this->seccion;

            if ($codigo = $this->input->post('codigo')) {
                $this->ws->actualizar($this->modulo, $datos, "int_tipo_seccion = $this->seccion");
            } else {
                $this->ws->insertar($this->modulo, $datos);
            }
            echo json_encode(array("result" => true));

        }
    }

}