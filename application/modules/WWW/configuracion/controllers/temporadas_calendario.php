<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Temporadas_calendario extends CI_Controller {
	    
	private $modulo = 28;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Temporadas de calendario');
		
        #js
        $this->layout->js('/js/sistema/configuracion/temporadas-calendario/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/configuracion/temporadas-calendario/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("tec_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["temporadas"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Temporadas de calendario" => '/'));
		
		#view
		$this->layout->view('temporadas-calendario/index', $contenido);
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
            
            $datos['tec_nombre'] = $this->input->post('nombre');
            $datos['tec_orden'] = $this->input->post('orden');
            $datos['tec_url'] = slug($this->input->post('nombre'));
            $datos['tec_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Temporada de Calendario');
            
            #js
            $this->layout->js('/js/sistema/configuracion/temporadas-calendario/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Temporadas de Calendario" => '/configuracion/temporadas-calendario/', "Agregar Temporada de Calendario" => "/"));
    		
    		#view
    		$this->layout->view('temporadas-calendario/agregar');
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
            
            $datos['tec_nombre'] = $this->input->post('nombre');
            $datos['tec_orden'] = $this->input->post('orden');
            $datos['tec_url'] = slug($this->input->post('nombre'));
            $datos['tec_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"tec_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['temporada'] = $temporada = $this->ws->obtener($this->modulo,"tec_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Temporada de Calendario');
            
            #js
            $this->layout->js('/js/sistema/configuracion/temporadas-calendario/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Temporadas de Calendario" => '/configuracion/temporadas-calendario/', "Editar Temporada de Calendario" => "/"));
    		
    		#view
    		$this->layout->view('temporadas-calendario/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "tec_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}