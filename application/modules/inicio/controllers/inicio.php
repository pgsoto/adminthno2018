<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Inicio extends CI_Controller {
    
	private $modulo = 28;
	
	public function index()
	{/*
        #si ya esta logeado
        if($this->session->userdata('usuario_admin')){
            
            $usuario = $this->session->userdata('usuario_admin');
            $this->ws->joinInner(62,"adms_seccion = seu_codigo");
            $secciones = $this->ws->listar(63,"adms_administrador = {$usuario->codigo}");
            
            redirect($secciones[0]->secciones_usuario->url);  
        }*/
        
		#Title
		$this->layout->title('Login');
		
		#Metas
		$this->layout->setMeta('title','Login');
		$this->layout->setMeta('description','Login');
		$this->layout->setMeta('keywords','Login');
		
		#js
		$this->layout->js('/js/sistema/index/login.js');

		#view
		$this->load->view('inicio');
		
	}
	
	public function login(){
		
		if($this->input->post()){
						
			#validacion
			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_message('valid_email', '* %s no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run('login')){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
			}
            
            $email = $this->input->post('email');
            $contrasena = md5($this->input->post('contrasena'));
			$usuario = $this->ws->obtener($this->modulo,"adm_email = '$email' and adm_contrasena = '$contrasena' and adm_estado = 1");
			#print_array($usuario);die;
			if($usuario){
                $url = "/";
                $url = "/portada/slider/";
                $this->session->set_userdata('usuario_admin', $usuario);

                #print_array($this->session->userdata('usuario_admin'));

                echo json_encode(array("result"=>true,"url"=>$url));
                exit;
			}
            echo json_encode(array("result"=>false,"msg"=>'Email y/o contraseña incorrectos'));
            exit;
		}
        else
			redirect('/');
	}
	
    public function logout(){
        $this->session->sess_destroy();
		redirect('/');
	}
    
    #recuperar contrasena
    public function recuperar_contrasena(){
		
        if($this->input->post()){
            
            #validacion
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_message('valid_email', '* %s no es válido');
            $this->form_validation->set_error_delimiters('<div>','</div>');

            if(!$this->form_validation->run()){
                $error = validation_errors();
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            #models
            $this->load->model('email','objEmail');
            
            $rand = rand().time();
            $contrasena = substr($rand,1,8);
            if($usuario = $this->ws->obtener($this->modulo,"adm_email = '{$this->input->post('email')}' and adm_estado = 1")){

                if($this->objEmail->recuperar_contrasena($this->input->post('email'),$contrasena)){
                    $datos['adm_contrasena'] = md5($contrasena);
                    $where = "adm_codigo = '$usuario->codigo'";
                    $this->ws->actualizar($this->modulo,$datos,$where);
                    
                    echo json_encode(array("result"=>true));
                    exit;
                }
                else{
                    echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
                    exit;
                }
            }
            else{
                echo json_encode(array("result"=>false,"msg"=>"El email ingresado no se encuentra registrado."));
                exit;
            }
        }
        else{
            #Title
    		$this->layout->title('Recuperar Contraseña');
    		
    		#js
    		$this->layout->js('/js/sistema/index/recuperar-contrasena.js');
    		
    		#view
    		$this->load->view('recuperar-contrasena');
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */