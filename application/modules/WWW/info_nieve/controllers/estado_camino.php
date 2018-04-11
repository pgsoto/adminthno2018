<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Estado_camino extends CI_Controller {
	    
	private $modulo = 46;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Estado de Camino');
		
        #JS - Editor
		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        
        #js
        $this->layout->js('/js/sistema/info-nieve/estado-camino/index.js');
        
		#contenido
		$contenido["estado"] = $this->ws->obtener($this->modulo,"edc_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Estado de Camino" => '/'));
		
		#view
		$this->layout->view('estado_camino/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['edc_estado_de_camino'] = $this->input->post('estado_de_camino');
            $datos['edc_transito'] = $this->input->post('transito');
            $datos['edc_porte_de_cadenas'] = $this->input->post('porte_de_cadenas');
            $datos['edc_uso_de_cadenas'] = $this->input->post('uso_de_cadenas');
            $datos['edc_horarios'] = $this->input->post('horarios');
            $datos['edc_observaciones'] = $this->input->post('observaciones');
            
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"edc_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        
	}
	
}