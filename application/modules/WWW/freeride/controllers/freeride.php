<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Freeride extends CI_Controller {
	    
	private $modulo = 55;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Backcountry');
		
        #JS - Editor
		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
        #js
        $this->layout->js('/js/sistema/freeride/freeride/index.js');
        
        #contenido
        $contenido['informacion'] = $this->ws->obtener($this->modulo,"fre_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Backcountry" => '/'));
		
		#view
		$this->layout->view('/freeride/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            $sacar = array('&lt;' =>'<','&gt;' =>'>');
            $datos['fre_contenido'] = $this->input->post('contenido');
           
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"fre_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);

            echo json_encode(array("result"=>true));
            
        }
	}
}