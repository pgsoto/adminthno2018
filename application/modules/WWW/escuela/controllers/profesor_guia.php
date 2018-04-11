<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Profesor_guia extends CI_Controller {
	    
	private $modulo = 53;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 165;
        $this->img->min_alto_1 = 165;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 330;
        $this->img->max_alto_1 = 330;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 165;
        $this->img->recorte_alto_1 = 165;
        
        $this->img->upload_dir = '/imagenes/modulos/escuela/profesor-guia/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Profesor Guía');
		
        #JS - Editor
		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
  
        #js Imagen Cropic
        $this->layout->js('/js/jquery/croppic/croppic.js');
        $this->layout->css('/js/jquery/croppic/croppic.css');
        $this->layout->js('/js/sistema/imagenes/simple.js');
            
        #js
        $this->layout->js('/js/sistema/escuela/profesor-guia/index.js');
        
		#contenido
		$contenido["informacion"] = $informacion = $this->ws->obtener($this->modulo,"prg_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Profesor Guía" => '/'));
		
		#view
		$this->layout->view('profesor_guia/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
            #validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            
            #agrega los archivos
            if(isset($_FILES['archivo']['name']) && $_FILES['archivo']['name']){
                if($archivo = $_FILES['archivo']){
                    $ruta = '/archivos/escuela/profesor-guia/';
                    crear_directorio($ruta);
                    
                    #libreria upload
                    $this->load->library('upload');
                    
                    $extension = array_pop(explode('.',$archivo['name']));
                    $file_name = 'profesor-guia-'.time().'.'.$extension;
                    
                    #config archivo
                    $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$ruta;
                    $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf|jpg|jpeg|png';
                    #$config['max_size']	= '100';
                    $config['file_name'] = $file_name;
                    $this->upload->initialize($config);
                    
                    if(!$this->upload->do_upload('archivo'))
            		{
            			//$error .= $this->upload->display_errors();
            			$error .= "<div>* Ha ocurrido un error al subir el archivo</div>";
            		}
                    
                    
                    $datos['prg_archivo_adjunto'] = $ruta.$file_name;
                }
            }
            
            if(!$this->form_validation->run())
				$error .= validation_errors();
                
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['prg_nombre'] = $this->input->post('nombre');
            $datos['prg_url'] = slug($this->input->post('nombre'));
            $datos['prg_descripcion'] = $this->input->post('descripcion');
            $datos['prg_estado'] = 1;
            
            if($this->input->post('ruta_interna_1'))
                $datos['prg_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            if($codigo = $this->input->post('codigo')){
                $this->ws->actualizar($this->modulo,$datos,"prg_codigo = $codigo");
            }
            else{
                $this->ws->insertar($this->modulo,$datos);
            }
            
            echo json_encode(array("result"=>true));
            
        }
	}
    
    #ARCHIVOS
    public function descargar_archivo($codigo){
        $archivo = $this->ws->obtener($this->modulo,"prg_codigo = $codigo");
        
        $this->load->helper('download');
        $name = basename($archivo->archivo_adjunto);
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$archivo->archivo_adjunto);
        
        force_download($name, $data);
    }
    
    public function eliminar_archivo(){
        $codigo = $this->input->post('codigo');
        $archivo = $this->ws->obtener($this->modulo,"prg_codigo = $codigo");
        
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$archivo->archivo_adjunto))
            unlink($_SERVER['DOCUMENT_ROOT'].$archivo->archivo_adjunto);
        
        $this->ws->actualizar($this->modulo,array("prg_archivo_adjunto"=>""),"prg_codigo = $codigo");
        
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
            if($imagen = $this->ws->obtener($this->modulo,"prg_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("prg_imagen_adjunta"=>""),"prg_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}