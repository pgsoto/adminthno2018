<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Areas_trabajo extends CI_Controller {
	    
	private $modulo = 33;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Áreas de Trabajo');
		
        #js
        $this->layout->js('/js/sistema/configuracion/areas-trabajo/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/configuracion/areas-trabajo/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("art_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["areas"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Áreas de Trabajo" => '/'));
		
		#view
		$this->layout->view('areas-trabajo/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			$this->form_validation->set_rules('email_destino','Email Destino','valid_email');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_message('valid_email', '* %s no es válido');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['art_nombre'] = $this->input->post('nombre');
            $datos['art_email_destino'] = $this->input->post('email_destino');
            $datos['art_orden'] = $this->input->post('orden');
            $datos['art_url'] = slug($this->input->post('nombre'));
            $datos['art_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Área de Trabajo');
            
            #js
            $this->layout->js('/js/sistema/configuracion/areas-trabajo/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Áreas de Trabajo" => '/configuracion/areas-trabajo/', "Agregar Área de Trabajo" => "/"));
    		
    		#view
    		$this->layout->view('areas-trabajo/agregar');
        }
	}
    
    public function editar($codigo){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
            $this->form_validation->set_rules('email_destino','Email Destino','valid_email');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['art_nombre'] = $this->input->post('nombre');
            $datos['art_email_destino'] = $this->input->post('email_destino');
            $datos['art_orden'] = $this->input->post('orden');
            $datos['art_url'] = slug($this->input->post('nombre'));
            $datos['art_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"art_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['area'] = $area = $this->ws->obtener($this->modulo,"art_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Área de Trabajo');
            
            #js
            $this->layout->js('/js/sistema/configuracion/areas-trabajo/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Áreas de Trabajo" => '/configuracion/areas-trabajo/', "Editar Área de Trabajo" => "/"));
    		
    		#view
    		$this->layout->view('areas-trabajo/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "art_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}