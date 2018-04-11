<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Nieve extends CI_Controller {
	    
	private $modulo = 47;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Nieve');
		
        #js
        $this->layout->js('/js/sistema/info-nieve/nieve/index.js');
        
		#contenido
		$contenido["nieve"] = $this->ws->obtener($this->modulo,"niv_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Nieve" => '/'));
		
		#view
		$this->layout->view('nieve/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['niv_nieve_acumulada'] = $this->input->post('nieve_acumulada');
            $datos['niv_nieve_caida_24h'] = $this->input->post('nieve_caida_24h');
            $datos['niv_nieve_caida_48h'] = $this->input->post('nieve_caida_48h');
            $datos['niv_nieve_pisada_canchas'] = $this->input->post('nieve_pisada_canchas');
            $datos['niv_calidad_nieve'] = $this->input->post('calidad_nieve');
            $datos['niv_velocidad_viento'] = $this->input->post('velocidad_viento');
            
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"niv_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        
	}
	
}