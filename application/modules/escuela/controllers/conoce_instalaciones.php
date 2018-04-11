<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Conoce_instalaciones extends CI_Controller {
	    
	private $modulo = 51, $modulo_imagenes = 52;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 260;
        $this->img->min_alto_1 = 188.3;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 780;
        $this->img->max_alto_1 = 780;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 780;
        $this->img->recorte_alto_1 = 565;
        
        $this->img->upload_dir = '/imagenes/modulos/escuela/conoce-nuestras-instalaciones/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Conoce Nuestras Instalaciones');
		
        #JS - Editor
		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
  
        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');
            
        #js
        $this->layout->js('/js/sistema/escuela/conoce-instalaciones/index.js');
        
		#contenido
		$contenido["informacion"] = $informacion = $this->ws->obtener($this->modulo,"cni_codigo = 1");
        
        #imagenes
        if($informacion)
            $contenido['informacion']->imagenes = $this->ws->listar($this->modulo_imagenes,"cnii_conoce_nuestras_instalaciones = {$informacion->codigo}");
        
		#Nav
		$this->layout->nav(array("Conoce Nuestras Instalaciones" => '/'));
		
		#view
		$this->layout->view('conoce_instalaciones/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cni_descripcion'] = $this->input->post('descripcion');
            
            if($codigo = $this->input->post('codigo')){
                $this->ws->actualizar($this->modulo,$datos,"cni_codigo = $codigo");
            }
            else{
                $id = $this->ws->insertar($this->modulo,$datos);
                $codigo = $id->cni_codigo;
            }
            
            unset($datos);
            
            #galeria de imagenes
            $internas = $this->input->post('ruta_interna_1');
            $grandes = $this->input->post('ruta_grande_1');
            if($grandes){
                foreach($grandes as $k=>$aux){
                    if($aux){
                        $datos['cnii_ruta_interna'] = $internas[$k];
                        $datos['cnii_ruta_grande'] = $aux;
                        $datos['cnii_conoce_nuestras_instalaciones'] = $codigo;
                        
                        $this->ws->insertar($this->modulo_imagenes,$datos);
                    }
                }
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
            if($imagen = $this->ws->obtener($this->modulo_imagenes,"cnii_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande);
                
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna);
                    
                $this->ws->eliminar($this->modulo_imagenes,"cnii_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}