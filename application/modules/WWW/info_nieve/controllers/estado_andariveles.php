<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Estado_andariveles extends CI_Controller {
	    
	private $modulo = 49;
    public $img;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Estado de Andariveles');
		
        #js
        $this->layout->js('/js/sistema/info-nieve/estado-andariveles/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/info-nieve/estado-andariveles/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("eda_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["estados"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Estado de Andariveles" => '/'));
		
		#view
		$this->layout->view('estado_andariveles/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre andarivel','required');
            $this->form_validation->set_rules('estado_andarivel','Estado de andarivel','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['eda_nombre'] = $this->input->post('nombre');
            $datos['eda_estado_andarivel'] = $this->input->post('estado_andarivel');
            $datos['eda_orden'] = $this->input->post('orden');
            $datos['eda_url'] = slug($this->input->post('nombre'));
            $datos['eda_estado'] = 1;
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Estado de Andarivel');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/info-nieve/estado-andariveles/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Estado de andariveles" => '/info-nieve/estado-andariveles/', "Agregar Estado de Andarivel" => "/"));
    		
    		#view
    		$this->layout->view('estado_andariveles/agregar');
        }
	}
    
    public function editar($codigo){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre andarivel','required');
			$this->form_validation->set_rules('estado_andarivel','Estado de andarivel','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['eda_nombre'] = $this->input->post('nombre');
            $datos['eda_estado_andarivel'] = $this->input->post('estado_andarivel');
            $datos['eda_orden'] = $this->input->post('orden');
            $datos['eda_url'] = slug($this->input->post('nombre'));
            $datos['eda_estado'] = 1;
            
            $this->ws->actualizar($this->modulo,$datos,"eda_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['estado'] = $estado = $this->ws->obtener($this->modulo,"eda_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Estado de Andarivel');
    		
            #js
            $this->layout->js('/js/sistema/info-nieve/estado-andariveles/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Estado de andariveles" => '/info-nieve/estado-andariveles/', "Editar Estado de Andarivel" => "/"));
    		
    		#view
    		$this->layout->view('estado_andariveles/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "eda_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}