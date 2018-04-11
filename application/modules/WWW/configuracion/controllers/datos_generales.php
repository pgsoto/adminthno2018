<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Datos_generales extends CI_Controller {
	    
	private $modulo = 34;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Datos Generales');
		
        #js
        $this->layout->js('/js/sistema/configuracion/datos-generales/index.js');
        
		#contenido
		$contenido["datos"] = $this->ws->obtener($this->modulo,"dag_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Datos Generales" => '/'));
		
		#view
		$this->layout->view('datos-generales/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('chillan_email','Email Oficina Chillán','valid_email');
			$this->form_validation->set_rules('concepcion_email','Email Oficina Concepción','valid_email');
			
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
            
            #metadatos
            $datos['dag_metadato_titulo'] = $this->input->post('metadato_titulo');
            $datos['dag_metadato_descripcion'] = $this->input->post('metadato_descripcion');
            $datos['dag_metadato_keywords'] = $this->input->post('metadato_keywords');
            
            #reservas
            $datos['dag_reserva_telefono'] = $this->input->post('reserva_telefono');
            $datos['dag_reserva_telefono_extranjero'] = $this->input->post('reserva_telefono_extranjero');
            $datos['dag_reserva_email'] = $this->input->post('reserva_email');
            
            #oficina chillan
            $datos['dag_chillan_telefono'] = $this->input->post('chillan_telefono');
            $datos['dag_chillan_email'] = $this->input->post('chillan_email');
            $datos['dag_chillan_horario'] = $this->input->post('chillan_horario');
            
            #oficina concepcion
            $datos['dag_concepcion_telefono'] = $this->input->post('concepcion_telefono');
            $datos['dag_concepcion_email'] = $this->input->post('concepcion_email');
            $datos['dag_concepcion_horario'] = $this->input->post('concepcion_horario');
            
            #oficina santiago
            $datos['dag_santiago_telefono'] = $this->input->post('santiago_telefono');
            $datos['dag_santiago_email'] = $this->input->post('santiago_email');
            $datos['dag_santiago_horario'] = $this->input->post('santiago_horario');
            
            #redes sociales
            $datos['dag_facebook'] = $this->input->post('facebook');
            $datos['dag_instagram'] = $this->input->post('instagram');
            $datos['dag_twitter'] = $this->input->post('twitter');
            $datos['dag_youtube'] = $this->input->post('youtube');
            
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"dag_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
	}
}