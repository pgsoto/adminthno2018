<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Subsecciones_servicentros extends CI_Controller
{

    private $nombre = 'Servicentros';
    private $modulo = 102, $modulo_seccion = 100;
    public $img;

    function __construct()
    {
        parent::__construct();

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
        $this->layout->js('/js/sistema/turismo/servicentros/subsecciones/index.js');

        $where = $and = "";
        $url = "";

        $where .= "subserv_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 5;
        $config['base_url'] = '/turismo/servicentros/subsecciones/' . $seccion . '/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("subserv_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        $seccion = $this->ws->obtener($this->modulo_seccion, "serv_codigo = " . $seccion);

        #Nav
        $this->layout->nav(array('Comercio' => '/turismo/servicentros/', $this->nombre => '/'));

        #view
        $this->layout->view('servicentros/subsecciones/index', $data);
    }

    public function agregar($seccion = false, $codigo = false)
    {
        # Contenido
        $data = array();

        $data['seccion'] = $seccion;

        #js
        $this->layout->js('/js/sistema/turismo/servicentros/subsecciones/agregar.js');

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "subserv_codigo = " . $codigo);
            if ($result) {
                $result->mapa_coor = explode(",", $result->mapa);
            }
            #print_array($result);
            if (!$result) {
                redirect('/turismo/servicentros/subsecciones/');
            } else {
                $data['result'] = $result;
            }
        }

        $seccion = $this->ws->obtener($this->modulo_seccion, "serv_codigo = " . $seccion);

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array("Comercio" => "/turismo/servicentros/", $this->nombre => "/turismo/servicentros/subsecciones/" . $seccion->codigo . "/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array("Comercio" => "/turismo/servicentros/", $this->nombre => "/turismo/servicentros/subsecciones/" . $seccion->codigo . "/", "Agregar " . $this->nombre => "/"));
        }

        #view
        $this->layout->view('servicentros/subsecciones/add', $data);

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

                    $data['subserv_estado'] = $this->input->post('estado');
                    $data['subserv_url'] = slug($this->input->post('nombre'));
                    $data['subserv_nombre'] = $this->input->post('nombre');
                    $data['subserv_orden'] = $this->input->post('orden');
                    $data['subserv_direccion'] = $this->input->post('direccion');

                    if ($this->input->post("mapa"))
                        $data['subserv_mapa'] = str_replace(array("(", ")", " "), "", $this->input->post("mapa"));

                    $data['subserv_seccion'] = $this->input->post('seccion');

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'subserv_codigo = ' . $codigo)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo, "seccion" => $this->input->post('seccion')));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo->subserv_codigo, "seccion" => $this->input->post('seccion')));
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
            $this->ws->eliminar($this->modulo, "subserv_codigo = {$this->input->post('codigo')}");
            echo json_encode(array("result" => true));
        } catch (Exception $e) {
            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
        }
    }

}