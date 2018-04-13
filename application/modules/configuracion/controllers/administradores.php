<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Administradores extends CI_Controller {
	    
	private $modulo = 32;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Administradores');
		
        #js
        $this->layout->js('/js/sistema/configuracion/administradores/index.js');
        
        $where = $and = "";
        $url = "";
        
        $where = "adm_codigo <> 1";
        $and = " and ";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/configuracion/administradores/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("adm_nombre ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["administradores"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Administradores" => '/'));
		
		#view
		$this->layout->view('administradores/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			$this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('contrasena','Contraseña','required|matches[confirmar-contrasena]');
            $this->form_validation->set_rules('confirmar-contrasena','Confirmar contraseña','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_message('valid_email', '* %s no es válido');
            $this->form_validation->set_message('matches', '* %ss no coinciden');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }

            $datos['adm_estado'] = $this->input->post('estado');
            $datos['adm_url'] = slug($this->input->post('nombre'));
            $datos['adm_nombre'] = $this->input->post('nombre');
            $datos['adm_email'] = $this->input->post('email');
            $datos['adm_contrasena'] = md5($this->input->post('contrasena'));

            $this->ws->insertar($this->modulo,$datos);

            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Administrador');
            
            #js
            $this->layout->js('/js/sistema/configuracion/administradores/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Administradores" => '/configuracion/administradores/', "Agregar Administrador" => "/"));

    		#view
    		$this->layout->view('administradores/crear');
        }
	}
    
    public function editar($codigo){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
            $this->form_validation->set_rules('email','Email','required|valid_email');
            $this->form_validation->set_rules('contrasena','Contraseña','matches[confirmar-contrasena]');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_message('valid_email', '* %s no es válido');
            $this->form_validation->set_message('matches', '* %ss no coinciden');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }

            $datos['adm_estado'] = $this->input->post('estado');
            $datos['adm_url'] = slug($this->input->post('nombre'));
            $datos['adm_nombre'] = $this->input->post('nombre');
            $datos['adm_email'] = $this->input->post('email');
            
            if($this->input->post('contrasena'))
                $datos['adm_contrasena'] = md5($this->input->post('contrasena'));
            
            $this->ws->actualizar($this->modulo,$datos,"adm_codigo = $codigo");

            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['administrador'] = $administrador = $this->ws->obtener($this->modulo,"adm_codigo = '$codigo'"));
            else show_error('');

    		#Title
    		$this->layout->title('Editar Administrador');
            
            #js
            $this->layout->js('/js/sistema/configuracion/administradores/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Administradores" => '/configuracion/administradores/', "Editar Administrador" => "/"));

    		#view
    		$this->layout->view('administradores/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "adm_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}