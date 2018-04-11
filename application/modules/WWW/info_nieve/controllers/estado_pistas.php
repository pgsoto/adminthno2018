<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Estado_pistas extends CI_Controller {
	    
	private $modulo = 48;
    public $img;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Estado de Pistas');
		
        #js
        $this->layout->js('/js/sistema/info-nieve/estado-pistas/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/info-nieve/estado-pistas/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("edp_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["estados"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Estado de Pistas" => '/'));
		
		#view
		$this->layout->view('estado_pistas/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre pista','required');
			$this->form_validation->set_rules('dificultad','Dificultad','required');
			$this->form_validation->set_rules('estado_pista','Estado de pista','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['edp_nombre'] = $this->input->post('nombre');
            $datos['edp_dificultad'] = $this->input->post('dificultad');
            $datos['edp_estado_pista'] = $this->input->post('estado_pista');
            $datos['edp_orden'] = $this->input->post('orden');
            $datos['edp_url'] = slug($this->input->post('nombre'));
            $datos['edp_estado'] = 1;
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Estado de Pista');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/info-nieve/estado-pistas/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Estado de Pistas" => '/info-nieve/estado-pistas/', "Agregar Estado de Pista" => "/"));
    		
    		#view
    		$this->layout->view('estado_pistas/agregar');
        }
	}
    
    public function editar($codigo){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre pista','required');
			$this->form_validation->set_rules('dificultad','Dificultad','required');
			$this->form_validation->set_rules('estado_pista','Estado de pista','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['edp_nombre'] = $this->input->post('nombre');
            $datos['edp_dificultad'] = $this->input->post('dificultad');
            $datos['edp_estado_pista'] = $this->input->post('estado_pista');
            $datos['edp_orden'] = $this->input->post('orden');
            $datos['edp_url'] = slug($this->input->post('nombre'));
            $datos['edp_estado'] = 1;
            
            $this->ws->actualizar($this->modulo,$datos,"edp_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['estado'] = $estado = $this->ws->obtener($this->modulo,"edp_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Estado de Pista');
    		
            #js
            $this->layout->js('/js/sistema/info-nieve/estado-pistas/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Estado de Pistas" => '/info-nieve/estado-pistas/', "Editar Estado de Pista" => "/"));
    		
    		#view
    		$this->layout->view('estado_pistas/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "edp_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}