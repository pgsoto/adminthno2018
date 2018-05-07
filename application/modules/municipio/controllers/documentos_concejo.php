<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Documentos_concejo extends CI_Controller
{

    private $nombre = 'Documentos ';
    private $modulo = 49, $modulo_seccion = 47, $modulo_tiposdocumentos = 50;
    public $img;

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        # Contenido
        $data = array();

        $seccion = 1;

        $tipo_documento = $this->uri->segment(4);

        $data['tipo_documento'] = $tipo_documento = $this->ws->obtener($this->modulo_tiposdocumentos, 'tipdoc_codigo = '.$tipo_documento);

        $data['seccion'] = $seccion;

        #Title
        $data['titulo'] = $this->nombre.' '.$tipo_documento->nombre;
        $this->layout->title($this->nombre.' '.$tipo_documento->nombre);

        #js
        $this->layout->js('/js/sistema/municipio/concejo/documentos/index.js');

        $where = $and = "";
        $url = "";

        $where .= "doccon_visible = 1";
        $and = " and ";

        $where .= $and."doccon_tipodocumento = ".$tipo_documento->codigo;
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 5;
        $config['base_url'] = '/municipio/concejo/documentos/' . $seccion . '/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("doccon_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        $seccion = $this->ws->obtener($this->modulo_seccion, "con_codigo = " . $seccion);

        #Nav
        $this->layout->nav(array('Concejo' => '/municipio/concejo/', $this->nombre.' '.$tipo_documento->nombre => '/'));

        #view
        $this->layout->view('concejo/documentos/index', $data);
    }

    public function agregar($tipo_documento = false, $codigo = false)
    {
        # Contenido
        $data = array();

        $data['tipo_documento'] = $tipo_documento = $this->ws->obtener($this->modulo_tiposdocumentos, "tipdoc_codigo = " . $tipo_documento);

        #js
        $this->layout->js('/js/sistema/municipio/concejo/documentos/agregar.js');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        $this->layout->js('/js/jquery/ckfinder/ckfinder.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "doccon_codigo = " . $codigo);

            #print_array($result);
            if (!$result) {
                redirect('/municipio/concejo/documentos/');
            } else {
                $data['result'] = $result;
            }
        }

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $tipo_documento->nombre;
            $this->layout->title('Editar ' . $tipo_documento->nombre);
            $this->layout->nav(array("Concejo" => "/municipio/concejo/", $this->nombre => "/municipio/concejo/documentos/".$tipo_documento->codigo."/", "Editar " . $this->nombre.' '.$tipo_documento->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $tipo_documento->nombre;
            $this->layout->title('Agregar ' . $tipo_documento->nombre);
            $this->layout->nav(array("Concejo" => "/municipio/concejo/", $this->nombre => "/municipio/concejo/documentos/".$tipo_documento->codigo."/", "Agregar " . $this->nombre.' '.$tipo_documento->nombre => "/"));
        }

        #view
        $this->layout->view('concejo/documentos/add', $data);

    }

    public function process()
    {
        #print_array($this->input->post());#die;
        if ($this->input->post()) {

            #validaciones
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            #$this->form_validation->set_rules('estado', 'Estado', 'required');
            $this->form_validation->set_rules('tipodocumento', 'Tipo Documento', 'required');

            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>', '</div>');

            if (!$this->form_validation->run()) {
                echo json_encode(array("result" => false, "msg" => validation_errors()));
                exit;
            } else {
                try {
                    $codigo = $this->input->post('codigo', true);

                    $data['doccon_consejo'] = 1;
                    $data['doccon_nombre'] = $this->input->post('nombre');
                    $data['doccon_orden'] = $this->input->post('orden');
                    $data['doccon_tipodocumento'] = $this->input->post('tipodocumento');

                    if($_FILES['archivo']['name'] != ''){

                        #subir archivo
                        list($name,$ext) = explode('.',$_FILES['archivo']['name']);
                        $uploads_dir = '/archivos/';
                        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$uploads_dir))
                            mkdir($_SERVER['DOCUMENT_ROOT'].$uploads_dir,0777);
                        $uploads_dir .= "concejos/";
                        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$uploads_dir))
                            mkdir($_SERVER['DOCUMENT_ROOT'].$uploads_dir,0777);
                        $uploads_dir .= "documentos/";
                        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$uploads_dir))
                            mkdir($_SERVER['DOCUMENT_ROOT'].$uploads_dir,0777);
                        $uploads_dir .= $this->input->post('tipodocumento')."/";
                        if(!file_exists($_SERVER['DOCUMENT_ROOT'].$uploads_dir))
                            mkdir($_SERVER['DOCUMENT_ROOT'].$uploads_dir,0777);

                        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$uploads_dir;
                        $config['allowed_types'] = "doc|docx|xls|xlsx|ppt|pptx|pdf";
                        $config['file_name'] = slug($name).'_'.time();
                        $config['max_size'] = '190799';
                        $this->load->library('upload', $config);
                        if(!$this->upload->do_upload('archivo')){
                            echo json_encode(array('result'=>false,'msg'=>$this->upload->display_errors('<div><b>','</b></div>')));
                            exit;
                        }
                        foreach($this->upload->data() as $k=>$aux){
                            if($k == 'file_name')
                                $name = $aux;
                        }
                        $data['doccon_archivo'] = $uploads_dir.$name;
                    }

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'doccon_codigo = ' . $codigo)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo, "seccion" => $this->input->post('tipodocumento')));
                            exit;
                        } else {
                            echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                            exit;
                        }
                    } else {
                        if ($codigo = $this->ws->insertar($this->modulo, $data)) {

                            echo json_encode(array("result" => true, "codigo" => $codigo->doccon_codigo, "seccion" => $this->input->post('tipodocumento')));
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
            $this->ws->eliminar($this->modulo, "doccon_codigo = {$this->input->post('codigo')}");
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
                if ($modelo = $this->ws->obtener($this->modulo_imagenes, "galdoccon_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                    $this->ws->eliminar($this->modulo_imagenes, "galdoccon_codigo = $codigo");
                }
            } elseif ($this->input->post('tipo') == 2) {
                if ($modelo = $this->ws->obtener($this->modulo, "doccon_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);
                    $data['doccon_imagen_ruta_interna'] = '';
                    $data['doccon_imagen_ruta_grande'] = '';
                    $this->ws->actualizar($this->modulo, $data, "doccon_codigo = $codigo");
                }
            }
        }
        echo json_encode(array("result" => true));
    }

}