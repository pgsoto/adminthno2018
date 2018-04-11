<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Informacion_prensa extends CI_Controller {

    private $modulo = 41, $modulo_imagenes = 42, $modulo_archivos = 43;
    public $img;

    function __construct(){
        parent::__construct();

        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 270;
        $this->img->min_alto_1 = 180;

        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 1080;
        $this->img->max_alto_1 = 720;

        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 540;
        $this->img->recorte_alto_1 = 360;

        $this->img->upload_dir = '/imagenes/modulos/portada/informacion-prensa/';

        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
    }

    public function index(){

        #Title
        $this->layout->title('Información Para Prensa');

        #JS - Editor
        $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');

        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');

        #js
        $this->layout->js('/js/sistema/portada/informacion-prensa/index.js');

        #contenido
        $contenido["informacion"] = $informacion = $this->ws->obtener($this->modulo,"ipp_codigo = 1");

        #imagenes
        if($informacion)
            $contenido['informacion']->imagenes = $this->ws->listar($this->modulo_imagenes,"ippi_informacion_para_prensa = {$informacion->codigo}");

        #archivos
        if($informacion)
            $contenido['informacion']->archivos = $this->ws->listar($this->modulo_archivos,"ippa_informacion_para_prensa = {$informacion->codigo}");

        #Nav
        $this->layout->nav(array("Información Para Prensa" => '/'));

        #view
        $this->layout->view('informacion_prensa/index', $contenido);
    }

    public function agregar(){

        if($this->input->post()){

            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }

            $datos['ipp_descripcion'] = $this->input->post('descripcion');

            if($codigo = $this->input->post('codigo')){
                $this->ws->actualizar($this->modulo,$datos,"ipp_codigo = $codigo");
            }
            else{
                $id = $this->ws->insertar($this->modulo,$datos);
                $codigo = $id->ipp_codigo;
            }

            unset($datos);

            #galeria de imagenes
            $internas = $this->input->post('ruta_interna_1');
            $grandes = $this->input->post('ruta_grande_1');
            if($grandes){
                foreach($grandes as $k=>$aux){
                    if($aux){
                        $datos['ippi_ruta_interna'] = $internas[$k];
                        $datos['ippi_ruta_grande'] = $aux;
                        $datos['ippi_informacion_para_prensa'] = $codigo;

                        $this->ws->insertar($this->modulo_imagenes,$datos);
                    }
                }
            }

            #agrega los archivos
            if($_FILES['archivos']['name']){


                if($archivos = $_FILES['archivos']){
                    $ruta = '/archivos/informacion-prensa/';
                    crear_directorio($ruta);

                    #config archivo
                    $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$ruta;
                    $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf|jpg|jpeg|png';
                    #$config['max_size']	= '100';
                    $this->load->library('upload');

                    $nombre_archivo = $this->input->post('nombre_archivo');
                    #print_r($archivos);die;
                    foreach($nombre_archivo as $k=>$aux){

                        if($aux){
                            if($archivos['name'][$k]){

                                #se redefine la variable FILES con cada archivo
                                $_FILES['archivo']['name'] = $archivos['name'][$k];
                                $_FILES['archivo']['type'] = $archivos['type'][$k];
                                $_FILES['archivo']['tmp_name'] = $archivos['tmp_name'][$k];
                                $_FILES['archivo']['error'] = $archivos['error'][$k];
                                $_FILES['archivo']['size'] = $archivos['size'][$k];

                                unset($datos);

                                $file_name = slug($aux);
                                $config['file_name'] = $file_name;
                                $this->upload->initialize($config);

                                if(!$this->upload->do_upload('archivo'))
                                {
                                   echo $error = $this->upload->display_errors();
                                    continue;
                                }

                                $extension = array_pop(explode('.',$archivos['name'][$k]));
                                $file_name .= '.'.$extension;
                                $ruta_archivo = $ruta.$file_name;

                                $datos['ippa_nombre'] = $aux;
                                $datos['ippa_ruta'] = $ruta_archivo;
                                $datos['ippa_extension'] = $extension;
                                $datos['ippa_peso'] = $archivos['size'][$k];
                                $datos['ippa_informacion_para_prensa'] = $codigo;

                                $this->ws->insertar($this->modulo_archivos,$datos);
                            }
                        }
                    }
                }
            }

            echo json_encode(array("result"=>true));

        }
    }

    #ARCHIVOS
    public function descargar_archivo($codigo){
        $archivo = $this->ws->obtener($this->modulo_archivos,"ippa_codigo = $codigo");

        $this->load->helper('download');
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$archivo->ruta);
        $name = slug($archivo->nombre).'.'.$archivo->extension;

        force_download($name, $data);
    }

    public function eliminar_archivo(){
        $codigo = $this->input->post('codigo');
        $archivo = $this->ws->obtener($this->modulo_archivos,"ippa_codigo = $codigo");

        if(file_exists($_SERVER['DOCUMENT_ROOT'].$archivo->ruta))
            unlink($_SERVER['DOCUMENT_ROOT'].$archivo->ruta);

        $this->ws->eliminar($this->modulo_archivos,"ippa_codigo = $codigo");

        echo json_encode(array("result"=>true));
    }

    ###IMAGENES
    public function cargar_imagen(){

        #se realiza la configuracion para cada imagen
        $this->img->id = $this->input->post('id');
        $this->objImagen->config($this->img);

        $response = $this->objImagen->cargar_imagen($_FILES);
        echo json_encode($response);
    }

    public function cortar_imagen(){

        #se realiza la configuracion para cada imagen
        $this->img->id = $this->input->post('id');
        $this->objImagen->config($this->img);

        $response =  $this->objImagen->cortar_imagen($_POST);
        echo json_encode($response);
    }

    public function eliminar_imagen(){
        if($ruta = $this->input->post('ruta_imagen')){
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$ruta))
                unlink($_SERVER['DOCUMENT_ROOT'].$ruta);
        }

        if($codigo = $this->input->post('codigo')){
            if($imagen = $this->ws->obtener($this->modulo_imagenes,"ippi_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande);

                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna);

                $this->ws->eliminar($this->modulo_imagenes,"ippi_codigo = $codigo");
            }
        }

        echo json_encode(array("result"=>true));
    }

}