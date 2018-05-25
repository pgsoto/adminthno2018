<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Informacion_util extends CI_Controller
{

    private $nombre = 'Información Útil';
    private $modulo = 85, $modulo_imagenes = 86;
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

        $this->img->upload_dir = '/imagenes/modulos/tuciudad/informacion_util/';

        #lib imagenes
        $this->load->model('inicio/imagen', 'objImagen');

        #Si la tabla está vacía, se inserta el primer registro
        if (count($this->ws->listar($this->modulo)) == 0) {
            $data = array();
            $data['infuti_estado'] = 1;
            $data['infuti_url'] = slug($this->nombre);
            $data['infuti_nombre'] = $this->nombre;
            $this->ws->insertar($this->modulo, $data);
            unset($data);
        }

    }

    public function agregar()
    {
        $codigo = 1; //obligatoria primer registro

        #js
        $this->layout->js('/js/sistema/tuciudad/informacion_util/agregar.js');

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
            $result = $this->ws->obtener($this->modulo, "infuti_codigo = " . $codigo);
            if ($result) {
                $result->imagenes = $this->ws->listar($this->modulo_imagenes, "galinfuti_seccion = " . $codigo);
            }
            #print_array($result);
            if (!$result) {
                redirect('/tuciudad/informacion-util/');
            } else {
                $data['result'] = $result;
            }
        }

        #nav
        if (isset($result)) {
            $data['titulo'] = $this->nombre;
            $this->layout->title($this->nombre);
            $this->layout->nav(array($this->nombre => "/tuciudad/informacion-util/", $result->nombre => "/"));
        }

        #view
        $this->layout->view('informacion_util/add', $data);

    }

    public function process()
    {
        #print_array($this->input->post());die;
        if ($this->input->post()) {

            #validaciones
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');

            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_message('valid_email', '* %s no es válido');
            $this->form_validation->set_error_delimiters('<div>', '</div>');

            if (!$this->form_validation->run()) {
                echo json_encode(array("result" => false, "msg" => validation_errors()));
                exit;
            } else {
                try {
                    $codigo = $this->input->post('codigo', true);

                    $data['infuti_estado'] = 1;
                    $data['infuti_url'] = slug($this->input->post('nombre'));
                    $data['infuti_nombre'] = $this->input->post('nombre');
                    $data['infuti_descripcion'] = $this->input->post('descripcion');

                    if ($this->input->post('ruta_interna_2')) {
                        $data['infuti_imagen_ruta_interna'] = $this->input->post('ruta_interna_2');
                        $data['infuti_imagen_ruta_grande'] = $this->input->post('ruta_grande_2');
                    }

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'infuti_codigo = ' . $codigo)) {

                            #GALERIA
                            $internas = $this->input->post('ruta_interna_1');
                            $grandes = $this->input->post('ruta_grande_1');
                            if ($grandes) {
                                foreach ($grandes as $k => $aux) {
                                    if ($aux) {
                                        $data2['galinfuti_imagen_ruta_interna'] = $internas[$k];
                                        $data2['galinfuti_imagen_ruta_grande'] = $aux;
                                        $data2['galinfuti_seccion'] = $codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }

                            echo json_encode(array("result" => true, "codigo" => $codigo));
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
                                        $data2['galinfuti_imagen_ruta_interna'] = $internas[$k];
                                        $data2['galinfuti_imagen_ruta_grande'] = $aux;
                                        $data2['galinfuti_seccion'] = $codigo->infuti_codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }

                            echo json_encode(array("result" => true, "codigo" => $codigo->infuti_codigo));
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
            $this->ws->eliminar($this->modulo, "infuti_codigo = {$this->input->post('codigo')}");
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
                if ($modelo = $this->ws->obtener($this->modulo_imagenes, "galinfuti_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                    $this->ws->eliminar($this->modulo_imagenes, "galinfuti_codigo = $codigo");
                }
            } elseif ($this->input->post('tipo') == 2) {
                if ($modelo = $this->ws->obtener($this->modulo, "infuti_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);
                    $data['infuti_imagen_ruta_interna'] = '';
                    $data['infuti_imagen_ruta_grande'] = '';
                    $this->ws->actualizar($this->modulo, $data, "infuti_codigo = $codigo");
                }
            }
        }
        echo json_encode(array("result" => true));
    }

}