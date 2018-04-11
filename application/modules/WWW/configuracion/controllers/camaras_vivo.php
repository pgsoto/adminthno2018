<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Camaras_vivo extends CI_Controller {
	    
	private $modulo = 31;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Cámaras en Vivo');
		
        #js
        $this->layout->js('/js/sistema/configuracion/camaras-vivo/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/configuracion/camaras-vivo/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("camv_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["camaras"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Cámaras en Vivo" => '/'));
		
		#view
		$this->layout->view('camaras-vivo/index', $contenido);
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
            
            $datos['camv_nombre'] = $this->input->post('nombre');
            $datos['camv_descripcion'] = $this->input->post('descripcion');
            $datos['camv_iframe'] = $this->input->post('iframe');
            $datos['camv_orden'] = $this->input->post('orden');
            $datos['camv_url'] = slug($this->input->post('nombre'));
            $datos['camv_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Cámara en Vivo');
            
            #js
            $this->layout->js('/js/sistema/configuracion/camaras-vivo/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Cámaras en Vivo" => '/configuracion/camaras-vivo/', "Agregar Cámara en Vivo" => "/"));
    		
    		#view
    		$this->layout->view('camaras-vivo/agregar');
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
            
            $datos['camv_nombre'] = $this->input->post('nombre');
            $datos['camv_descripcion'] = $this->input->post('descripcion');
            $datos['camv_iframe'] = $this->input->post('iframe');
            $datos['camv_orden'] = $this->input->post('orden');
            $datos['camv_url'] = slug($this->input->post('nombre'));
            $datos['camv_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"camv_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['camara'] = $camara = $this->ws->obtener($this->modulo,"camv_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Cámara en Vivo');
            
            #js
            $this->layout->js('/js/sistema/configuracion/camaras-vivo/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Cámaras en Vivo" => '/configuracion/camaras-vivo/', "Editar Cámara en Vivo" => "/"));
    		
    		#view
    		$this->layout->view('camaras-vivo/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "camv_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}