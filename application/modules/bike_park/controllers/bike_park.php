<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Bike_park extends CI_Controller {
	    
	private $modulo = 54;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 270;
        $this->img->min_alto_1 = 172.5;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 540;
        $this->img->max_alto_1 = 540;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 540;
        $this->img->recorte_alto_1 = 345;
        
        $this->img->upload_dir = '/imagenes/modulos/bike-park/bike-park/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Bike Park');
		
        #JS - Editor
		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
  
        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');
            
        #js
        $this->layout->js('/js/sistema/bike-park/bike-park/index.js');
        
		#contenido
		$contenido["informacion"] = $informacion = $this->ws->obtener($this->modulo,"bip_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Bike Park" => '/'));
		
		#view
		$this->layout->view('/bike_park/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['bip_descripcion'] = $this->input->post('descripcion');
            
            if($this->input->post('ruta_interna_1'))
                $datos['bip_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            if($codigo = $this->input->post('codigo')){
                $this->ws->actualizar($this->modulo,$datos,"bip_codigo = $codigo");
            }
            else{
                $this->ws->insertar($this->modulo,$datos);
            }
            
            echo json_encode(array("result"=>true));
            
        }
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
            if($imagen = $this->ws->obtener($this->modulo,"bip_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("bip_imagen_adjunta"=>""),"bip_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}