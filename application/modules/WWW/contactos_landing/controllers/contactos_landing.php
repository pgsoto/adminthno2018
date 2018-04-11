<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Contactos_Landing extends CI_Controller {
	    
	private $modulo = 67, $modulo_landing = 65,  $modulo_imagenes = 68, $modulo_hotel = 14;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        /*#define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 260;
        $this->img->min_alto_1 = 188.3;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 780;
        $this->img->max_alto_1 = 780;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 780;
        $this->img->recorte_alto_1 = 565;
        
        $this->img->upload_dir = '/imagenes/modulos/landing/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');*/
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Contactos Landing Pages');
		
        #js
        $this->layout->js('/js/sistema/contactos_landing/index.js');
        $url = "";
        /*$where = $and = "";
        
        
        $where = "sli_tipo_seccion = 9";
        $and = " and ";*/
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/contactos_landing/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contactos = $this->ws->listar($this->modulo);
        foreach($contactos as $contacto){
            $contacto->nombre_landing = $this->ws->obtener($this->modulo_landing,'lan_codigo = '.$contacto->landing);
        }
        
        $contenido["contactos"] = $contactos;
        //print_array($contactos); 
        $contenido['pagination'] = $this->pagination->create_links();
      
		#Nav
		$this->layout->nav(array("Newsletter" => '/'));
		
		#view
		$this->layout->view('index', $contenido);
	}
	
	public function agregar(){        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cont_nombre'] = $this->input->post('nombre');
            $datos['cont_telefono'] = $this->input->post('telefono');
            $datos['cont_correo'] = $this->input->post('correo');
            $datos['cont_mensaje'] = $this->input->post('mensaje');
            $datos['cont_landing'] = $this->input->post('landing');
 
            
            $this->ws->insertar($this->modulo,$datos);
            unset($datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Contacto Langing Pages');
    		
            #js - Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js
            $this->layout->js('/js/sistema/contactos_landing/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Contacto Landing" => '/contacto_landing', "Agregar Contacto Landing" => "/"));
            $this->ws->order('lan_nombre DESC');
    		$contenido['landings'] = $this->ws->listar($this->modulo_landing);
            //print_array($contenido['landings']);
    		#view
    		$this->layout->view('agregar', $contenido);
        }
	}
    
    public function editar($codigo = 0){        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cont_nombre'] = $this->input->post('nombre');
            $datos['cont_telefono'] = $this->input->post('telefono');
            $datos['cont_correo'] = $this->input->post('correo');
            $datos['cont_mensaje'] = $this->input->post('mensaje');
            $datos['cont_landing'] = $this->input->post('landing');
            //print_array($datos);
            
            if($this->ws->actualizar($this->modulo,$datos,"cont_codigo = ".$this->input->post('codigo'))){
                unset($datos);
            
                echo json_encode(array("result"=>true));  
                exit;                
            }else{
                $error = "Error al actualizar";
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
              
        }
        else{
            #registro
            if($contenido['contacto'] = $this->ws->obtener($this->modulo,"cont_codigo = $codigo"));
            else show_error('');
            
            $this->ws->order('lan_nombre DESC');
    		$contenido['landings'] = $this->ws->listar($this->modulo_landing);
            
    		#Title
    		$this->layout->title('Editar Contacto Landing Page');
    		
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/contactos_landing/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Editar Landing" => "/"));
    		//print_array($contenido);
    		#view
    		$this->layout->view('editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "cont_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
    	
}