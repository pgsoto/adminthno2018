<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Como_llegar extends CI_Controller {
	    
	private $modulo = 56;
    public $img;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Cómo Llegar');
		
        #js
        $this->layout->js('/js/sistema/ayuda/como-llegar/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/ayuda/como-llegar/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("col_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["llegar"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Cómo Llegar" => '/'));
		
		#view
		$this->layout->view('como-llegar/index', $contenido);
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
            
            $datos['col_nombre'] = $this->input->post('nombre');
            $datos['col_descripcion'] = $this->input->post('descripcion');
            $datos['col_orden'] = $this->input->post('orden');
            $datos['col_url'] = slug($this->input->post('nombre'));
            $datos['col_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Cómo Llegar');
    		
            #JS - Editor
            $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        
            #js
            $this->layout->js('/js/sistema/ayuda/como-llegar/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Cómo Llegar" => '/ayuda/como-llegar/', "Agregar Cómo Llegar" => "/"));
    		
    		#view
    		$this->layout->view('como-llegar/agregar');
        }
	}
    
    public function editar($codigo){
        
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
            
            $datos['col_nombre'] = $this->input->post('nombre');
            $datos['col_descripcion'] = $this->input->post('descripcion');
            $datos['col_orden'] = $this->input->post('orden');
            $datos['col_url'] = slug($this->input->post('nombre'));
            $datos['col_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"col_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['llegar'] = $llegar = $this->ws->obtener($this->modulo,"col_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Cómo Llegar');
    		
            #JS - Editor
            $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        
            #js
            $this->layout->js('/js/sistema/ayuda/como-llegar/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Cómo Llegar" => '/ayuda/como-llegar/', "Editar Cómo Llegar" => "/"));
    		
    		#view
    		$this->layout->view('como-llegar/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "col_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}