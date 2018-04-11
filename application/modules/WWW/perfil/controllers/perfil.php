<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Perfil extends CI_Controller {
	    
	private $modulo = 61;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Perfil');
		
        #js
        $this->layout->js('/js/sistema/perfil/index.js');
        
        #registro
        $usuario = $this->session->userdata('usuario_admin');
        if($contenido['perfil'] = $perfil = $this->ws->obtener($this->modulo,"adm_codigo = '$usuario->codigo'"));
        else show_error('');
            
		#Nav
		$this->layout->nav(array("Perfil" => '/'));
		
		#view
		$this->layout->view('perfil', $contenido);
	}
    
    public function guardar(){
        
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
            
            $datos['adm_nombre'] = $this->input->post('nombre');
            $datos['adm_email'] = $this->input->post('email');
            $datos['adm_telefono'] = $this->input->post('telefono');
            $datos['adm_url'] = slug($this->input->post('nombre'));
            
            if($this->input->post('contrasena'))
                $datos['adm_contrasena'] = md5($this->input->post('contrasena'));
            
            $usuario = $this->session->userdata('usuario_admin');
            $this->ws->actualizar($this->modulo,$datos,"adm_codigo = '$usuario->codigo'");
            
            #actiliza los datos de la sesion
            $usuario = $this->ws->obtener($this->modulo,"adm_codigo = '$usuario->codigo'");
            $this->session->set_userdata('usuario_admin',$usuario);
            
            echo json_encode(array("result"=>true));
            
        }
	}
}