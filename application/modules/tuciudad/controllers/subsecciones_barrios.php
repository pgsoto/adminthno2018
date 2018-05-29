<?php if (!defined('BASEPATH')) exit('No puede acceder a este archivo');

class Subsecciones_barrios extends CI_Controller
{

    private $nombre = 'Subsecciones Barrios';
    private $modulo = 74, $modulo_imagenes = 75, $modulo_seccion = 72, $modulo_imagenes_obras_realizadas = 76, $modulo_imagenes_obras_sociales = 77;
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

        $this->img->upload_dir = '/imagenes/modulos/tuciudad/barrios/subsecciones/';

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
        $this->layout->js('/js/sistema/tuciudad/barrios/subsecciones/index.js');

        $where = $and = "";
        $url = "";

        $where .= "subbar_visible = 1";
        $and = " and ";

        if (count($_GET) > 0)
            $url = '?' . http_build_query($_GET, '', "&");

        $config['uri_segment'] = 5;
        $config['base_url'] = '/tuciudad/barrios/subsecciones/' . $seccion . '/';
        $config['per_page'] = 20;
        $config['total_rows'] = count($this->ws->listar($this->modulo, $where));
        $config['suffix'] = '/' . $url;
        $config['first_url'] = $config['base_url'] . $url;
        $this->pagination->initialize($config);

        #obtiene el numero de pagina
        $pagina = ($this->uri->segment($config['uri_segment'])) ? $this->uri->segment($config['uri_segment']) - 1 : 0;

        #contenido
        $this->ws->order("subbar_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
        $data["result"] = $this->ws->listar($this->modulo, $where);
        $data['pagination'] = $this->pagination->create_links();

        $seccion = $this->ws->obtener($this->modulo_seccion, "bar_codigo = " . $seccion);

        #Nav
        $this->layout->nav(array('Barrios' => '/tuciudad/barrios/', $this->nombre => '/'));

        #view
        $this->layout->view('barrios/subsecciones/index', $data);
    }

    public function agregar($seccion = false, $codigo = false)
    {
        # Contenido
        $data = array();

        $data['seccion'] = $seccion;

        #js
        $this->layout->js('/js/sistema/tuciudad/barrios/subsecciones/agregar.js');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        $this->layout->js('/js/jquery/ckfinder/ckfinder.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        if ($codigo && is_numeric($codigo)) {
            $result = $this->ws->obtener($this->modulo, "subbar_codigo = " . $codigo);
            if ($result) {
                $result->mapa_coor = explode(",", $result->mapa);
                $result->imagenes = $this->ws->listar($this->modulo_imagenes, "galsubbar_subseccion = " . $codigo);
            }
            if (!$result) {
                redirect('/tuciudad/barrios/subsecciones/');
            } else {
                $data['result'] = $result;
            }
        }

        $seccion = $this->ws->obtener($this->modulo_seccion, "bar_codigo = " . $seccion);

        #nav
        if (isset($result)) {
            $data['titulo'] = 'Editar ' . $this->nombre;
            $this->layout->title('Editar ' . $this->nombre);
            $this->layout->nav(array("Barrios" => "/tuciudad/barrios/", $this->nombre => "/tuciudad/barrios/subsecciones/" . $seccion->codigo . "/", "Editar " . $result->nombre => "/"));
        } else {
            $data['titulo'] = 'Agregar ' . $this->nombre;
            $this->layout->title('Agregar ' . $this->nombre);
            $this->layout->nav(array("Barrios" => "/tuciudad/barrios/", $this->nombre => "/tuciudad/barrios/subsecciones/" . $seccion->codigo . "/", "Agregar " . $this->nombre => "/"));
        }

        #view
        $this->layout->view('barrios/subsecciones/add', $data);

    }

    public function process()
    {
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

                    $data['subbar_estado'] = $this->input->post('estado');
                    $data['subbar_url'] = slug($this->input->post('nombre'));
                    $data['subbar_nombre'] = $this->input->post('nombre');
                    $data['subbar_orden'] = $this->input->post('orden');
                    $data['subbar_descripcion'] = $this->input->post('descripcion');
                    $data['subbar_encargado'] = $this->input->post('encargado');
                    $data['subbar_secretaria'] = $this->input->post('secretaria');
                    $data['subbar_telefono'] = $this->input->post('telefono');
                    $data['subbar_email'] = $this->input->post('email');
                    $data['subbar_direccion'] = $this->input->post('direccion');

                    if ($this->input->post('ruta_interna_2')) {
                        $data['subbar_imagen_ruta_interna'] = $this->input->post('ruta_interna_2');
                        $data['subbar_imagen_ruta_grande'] = $this->input->post('ruta_grande_2');
                    }

                    if ($this->input->post("mapa"))
                        $data['subbar_mapa'] = str_replace(array("(", ")", " "), "", $this->input->post("mapa"));

                    $data['subbar_seccion'] = $this->input->post('seccion');

                    # Si es una actualización el código es mayor a 0 ya que 0 es el valor predeterminado
                    if ($codigo > 0) {
                        if ($this->ws->actualizar($this->modulo, $data, 'subbar_codigo = ' . $codigo)) {

                            #GALERIA
                            $internas = $this->input->post('ruta_interna_1');
                            $grandes = $this->input->post('ruta_grande_1');
                            if ($grandes) {
                                foreach ($grandes as $k => $aux) {
                                    if ($aux) {
                                        $data2['galsubbar_imagen_ruta_interna'] = $internas[$k];
                                        $data2['galsubbar_imagen_ruta_grande'] = $aux;
                                        $data2['galsubbar_subseccion'] = $codigo;

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
                                        $data2['galsubbar_imagen_ruta_interna'] = $internas[$k];
                                        $data2['galsubbar_imagen_ruta_grande'] = $aux;
                                        $data2['galsubbar_subseccion'] = $codigo->subbar_codigo;

                                        $this->ws->insertar($this->modulo_imagenes, $data2);
                                    }
                                }
                            }

                            echo json_encode(array("result" => true, "codigo" => $codigo->subbar_codigo, "seccion" => $this->input->post('seccion')));
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
            $this->ws->eliminar($this->modulo, "subbar_codigo = {$this->input->post('codigo')}");
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
                if ($modelo = $this->ws->obtener($this->modulo_imagenes, "galsubbar_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                    $this->ws->eliminar($this->modulo_imagenes, "galsubbar_codigo = $codigo");
                }
            } elseif ($this->input->post('tipo') == 2) {
                if ($modelo = $this->ws->obtener($this->modulo, "subbar_codigo = $codigo")) {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);
                    $data['subbar_imagen_ruta_interna'] = '';
                    $data['subbar_imagen_ruta_grande'] = '';
                    $this->ws->actualizar($this->modulo, $data, "subbar_codigo = $codigo");
                }
            }
        }
        echo json_encode(array("result" => true));
    }



/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 *  ** ** ** ** ** ** **  chancho ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 *  ** ** ** ** ** ** ** ** ** ** ** ** ** **  OBRAS OBRAS REALIZADAS ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 *  ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 */

  ###IMAGENES
  public function cargar_imagen_obras()
  {

      #se realiza la configuracion para cada imagen
      $this->img->id = $this->input->post('id');
      $this->objImagen->config($this->img);

      $response = $this->objImagen->cargar_imagen($_FILES);
      echo json_encode($response);
  }

  public function cortar_imagen_obras()
  {

      $this->img->id = $this->input->post('id');
      $this->objImagen->config($this->img);

      $response = $this->objImagen->cortar_imagen($_POST);
      echo json_encode($response);
  }


  public function eliminar_imagen_obras()
  {
      if ($ruta = $this->input->post('ruta_imagen')) {
          if (file_exists($_SERVER['DOCUMENT_ROOT'] . $ruta))
              unlink($_SERVER['DOCUMENT_ROOT'] . $ruta);
      }

      if ($codigo = $this->input->post('codigo')) {

              if ($modelo = $this->ws->obtener($this->modulo_imagenes_obras_realizadas, "galobrrea_codigo = $codigo")) {
                  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                      unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                      unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                  $this->ws->eliminar($this->modulo_imagenes_obras_realizadas, "galobrrea_codigo = $codigo");
          } 
      }
      echo json_encode(array("result" => true));
  }

    public function obras_realizadas($seccion, $subseccion ){
  
         # Contenido
        $data = array();
        $seccion_barrio = $this->ws->obtener($this->modulo_seccion, "bar_codigo = " . $seccion);

        $where = 'galobrrea_subseccion = '.$subseccion;
        
        $data['result'] = $this->ws->listar($this->modulo_imagenes_obras_realizadas, $where);
     
        $data['seccion'] = $seccion;
        $data['subseccion'] = $subseccion;
        $data['seccion_barrio'] = $seccion_barrio;

        #Title
        $data['titulo'] = 'Obras realizadas';
        $this->layout->title($this->nombre);

        #js
        $this->layout->js('/js/sistema/tuciudad/barrios/subsecciones/agregar_gal_obras.js');

        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        #Nav
        $this->layout->nav(array("Barrios" => "/tuciudad/barrios/", $this->nombre => "/tuciudad/barrios/subsecciones/" . $seccion_barrio->codigo . "/", "Editar " . $seccion_barrio->nombre => "/"));

        #view
        $this->layout->view('barrios/subsecciones/obras_realizadas', $data);

    }

    public function process_obras_realizadas(){

            if ($this->input->post()) {
                    $sub = $this->input->post("codigo_subseccion");
                                #GALERIA
                                $internas = $this->input->post('ruta_interna_1');
                                $grandes = $this->input->post('ruta_grande_1');
                                if ($grandes) {
                                    foreach ($grandes as $k => $aux) {
                                        if ($aux) {
                                            $data2['galobrrea_imagen_ruta_interna'] = $internas[$k];
                                            $data2['galobrrea_imagen_ruta_grande'] = $aux;
                                            $data2['galobrrea_subseccion'] = $sub;
    
                                            $this->ws->insertar($this->modulo_imagenes_obras_realizadas, $data2);
                                        }
                                    }
                                }
                                echo json_encode(array("result" => true, "codigo" => $this->input->post("codigo_seccion"), "seccion" => $this->input->post('codigo_seccion')));
                                exit;
            }else{
                echo json_encode(array("result" => false, "msg" => "Debe ingresar al menos una fotografía"));
                exit;
            }
    }
            
/** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 *  ** ** ** ** ** ** ** chanchito * ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 *  ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** OBRAS SOCIALES ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 *  ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** ** **
 */
  public function cargar_imagen_sociales(){

      $this->img->id = $this->input->post('id');
      $this->objImagen->config($this->img);

      $response = $this->objImagen->cargar_imagen($_FILES);
      echo json_encode($response);
  }

  public function cortar_imagen_sociales(){

      $this->img->id = $this->input->post('id');
      $this->objImagen->config($this->img);

      $response = $this->objImagen->cortar_imagen($_POST);
      echo json_encode($response);
  }


  public function eliminar_imagen_sociales(){
      if ($ruta = $this->input->post('ruta_imagen')) {
          if (file_exists($_SERVER['DOCUMENT_ROOT'] . $ruta))
              unlink($_SERVER['DOCUMENT_ROOT'] . $ruta);
      }

      if ($codigo = $this->input->post('codigo')) {

              if ($modelo = $this->ws->obtener($this->modulo_imagenes_obras_sociales, "galobrsoc_codigo = $codigo")) {
                  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna))
                      unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_interna);

                  if (file_exists($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande))
                      unlink($_SERVER['DOCUMENT_ROOT'] . $modelo->imagen_ruta_grande);

                  $this->ws->eliminar($this->modulo_imagenes_obras_sociales, "galobrsoc_codigo = $codigo");
          } 
      }
      echo json_encode(array("result" => true));
  }


  public function obras_sociales($seccion, $subseccion){
  
        $seccion = 1;
        # Contenido
        $data = array();

        $data['seccion'] = $seccion;

        $data = array();
        $seccion_barrio = $this->ws->obtener($this->modulo_seccion, "bar_codigo = " . $seccion);

        $where = 'galobrsoc_subseccion = '.$subseccion;
        
        $data['result'] = $this->ws->listar($this->modulo_imagenes_obras_sociales, $where);

        $data['seccion'] = $seccion;
        $data['subseccion'] = $subseccion;
        $data['seccion_barrio'] = $seccion_barrio;

        #Title
        $data['titulo'] = 'Obras Sociales';
        $this->layout->title($this->nombre);

        #js
        $this->layout->js('/js/sistema/tuciudad/barrios/subsecciones/agregar_gal_sociales.js');

         #js Imagen Cropic
         $this->layout->js('/js/jquery/croppic/croppic.js');
         $this->layout->css('/js/jquery/croppic/croppic.css');
         $this->layout->js('/js/sistema/imagenes/simple.js');
 
        #Nav
        $this->layout->nav(array("Barrios" => "/tuciudad/barrios/", $this->nombre => "/tuciudad/barrios/subsecciones/" . $seccion_barrio->codigo . "/", "Editar " . $seccion_barrio->nombre => "/"));

        #view
        $this->layout->view('barrios/subsecciones/obras_sociales', $data);

  }


  public function process_obras_sociales(){

        if ($this->input->post()) {
            $sub = $this->input->post("codigo_subseccion");

                        #GALERIA
                        $internas = $this->input->post('ruta_interna_1');
                        $grandes = $this->input->post('ruta_grande_1');
                        if ($grandes) {
                            foreach ($grandes as $k => $aux) {
                                if ($aux) {
                                    $data2['galobrsoc_imagen_ruta_interna'] = $internas[$k];
                                    $data2['galobrsoc_imagen_ruta_grande'] = $aux;
                                    $data2['galobrsoc_subseccion'] = $sub;

                                    $this->ws->insertar($this->modulo_imagenes_obras_sociales, $data2);
                                }
                            }
                        }

                        echo json_encode(array("result" => true,"codigo" => $this->input->post("codigo_seccion"), "seccion" => $this->input->post('codigo_seccion')));
                        exit;
        }else{
            echo json_encode(array("result" => false, "msg" => "Debe ingresar al menos una fotografía"));
            exit;
        }
        
  }

}