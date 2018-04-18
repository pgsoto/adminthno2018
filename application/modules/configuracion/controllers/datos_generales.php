<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Datos_generales extends CI_Controller {
	    
	private $modulo = 27;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Datos Generales');
		
        #js
        $this->layout->js('/js/sistema/configuracion/datos-generales/index.js');
        
		#contenido
		$contenido["datos"] = $datos = $this->ws->obtener($this->modulo,"dag_codigo = 1");
        print_array($datos);
		#Nav
		$this->layout->nav(array("Datos Generales" => '/'));
		
		#view
		$this->layout->view('datos-generales/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			$this->form_validation->set_rules('email','Email','valid_email');
			
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

            $datos['dag_estado'] = 1;
            $datos['dag_url'] = slug($this->input->post('nombre'));
            
            #metadatos
            #$datos['dag_metadato_titulo'] = $this->input->post('metadato_titulo');
            #$datos['dag_metadato_descripcion'] = $this->input->post('metadato_descripcion');
            #$datos['dag_metadato_keywords'] = $this->input->post('metadato_keywords');

            #info
            $datos['dag_nombre'] = $this->input->post('nombre');
            $datos['dag_direccion'] = $this->input->post('direccion');
            $datos['dag_mesa_central'] = $this->input->post('mesa_central');
            $datos['dag_telefono_1'] = $this->input->post('telefono_1');
            $datos['dag_telefono_2'] = $this->input->post('telefono_2');
            $datos['dag_email'] = $this->input->post('email');

            #redes sociales
            $datos['dag_facebook'] = $this->input->post('facebook');
            $datos['dag_twitter'] = $this->input->post('twitter');
            $datos['dag_instagram'] = $this->input->post('instagram');
            
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"dag_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
	}
}