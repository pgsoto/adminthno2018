<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Eventos extends CI_Controller
{

    private $nombre = 'Eventos';
    private $modulo = 33, $modulo_categoria = 34;
    public $img;

    function __construct()
    {
        parent::__construct();

        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 1065;
        $this->img->min_alto_1 = 360;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 1065*4;
        $this->img->max_alto_1 = 360*4;

        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 1065;
        $this->img->recorte_alto_1 = 360;

        $this->img->upload_dir = '/imagenes/modulos/eventos/eventos/';

        #lib imagenes
        $this->load->model('inicio/imagen', 'objImagen');
    }

    public function index()
    {
        #Title
        $data['titulo'] = $this->nombre;
        $this->layout->title($this->nombre);

        #js
        $this->layout->js('/js/sistema/eventos/eventos/index.js');

        $where = $and = "";
        $url = "";

        $where = "eve_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 3;
        $config['base_url'] = '/eventos/eventos/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("eve_fecha DESC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        foreach ($data["result"] as $aux){
            $aux->categoria = $this->ws->obtener($this->modulo_categoria, array("cate_codigo"=>$aux->categoria));
        }
        $data['pagination'] = $this->pagination->create_links();
        #rint_array($data["result"]);
        #Nav
        $this->layout->nav(array($this->nombre => '/'));

        #view
        $this->layout->view('eventos/eventos/index', $data);
    }

    public function agregar($codigo = false)
    {
        #js
        $this->layout->js('/js/sistema/eventos/eventos/agregar.js');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        $this->layout->js('/js/jquery/ckfinder/ckfinder.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        #TIMER
        $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
        $this->layout->js('/js/jquery/bootstrap-timepicker/js/bootstrap-timepicker.js');
        $this->layout->css('/js/jquery/datepicker/datepicker3.css');

        # Contenido
        $data = array();

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "eve_codigo = " . $codigo);
            if ($result) {
                $result->mapa_coor = explode(",", $result->mapa);
            }
            #print_array($result);
            if (!$result) {
                redirect('/eventos/eventos/');
            } else {
                $data['result'] = $result;
            }
        }

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array($this->nombre => "/eventos/eventos/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array($this->nombre => "/eventos/eventos/", "Agregar " . $this->nombre => "/"));
        }

        $data["categoria"] = $this->ws->listar($this->modulo_categoria);

        #view
        $this->layout->view('eventos/eventos/add', $data);

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

                    $data['eve_estado'] = $this->input->post('estado');
                    $data['eve_url'] = slug($this->input->post('nombre'));
                    $data['eve_nombre'] = $this->input->post('nombre');
                    $data['eve_fecha'] = formatearFecha($this->input->post('fecha'));
                    $data['eve_hora_inicio'] = $this->input->post('hora_inicio');
                    $data['eve_hora_termino'] = $this->input->post('hora_termino');
                    $data['eve_ubicacion'] = $this->input->post('ubicacion');
                    $data['eve_organiza'] = $this->input->post('organiza');
                    $data['eve_link'] = $this->input->post('link');
                    $data['eve_descripcion'] = $this->input->post('descripcion');

                    if ($this->input->post('categoria'))
                        $data['eve_categoria'] = $this->input->post('categoria');

                    if ($this->input->post('ruta_interna_1'))
                        $data['eve_imagen_ruta_interna'] = $this->input->post('ruta_interna_1');

                    if ($this->input->post('ruta_grande_1'))
                        $data['eve_imagen_ruta_grande'] = $this->input->post('ruta_grande_1');

                    if ($this->input->post("mapa"))
                        $data['eve_mapa'] = str_replace(array("(", ")", " "), "", $this->input->post("mapa"));

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'eve_codigo = ' . $codigo)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo->eve_codigo));
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
            $this->ws->eliminar($this->modulo, "eve_codigo = {$this->input->post('codigo')}");
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

                if ($modelo = $this->ws->obtener($this->modulo, "eve_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);
                    $data['eve_imagen_ruta_interna'] = '';
                    $data['eve_imagen_ruta_grande'] = '';
                    $this->ws->actualizar($this->modulo, $data, "eve_codigo = $codigo");
                }

        }
        echo json_encode(array("result" => true));
    }

}