<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Programas_valores extends CI_Controller {

	private $modulo = 27;

	function __construct(){
		parent::__construct();
	}

	public function index(){

		#Title
		$this->layout->title('Programas y valores');

        #JS - Editor
		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');

        #js
        $this->layout->js('/js/sistema/verano/programas-valores/agregar.js');

        #contenido
					$this->ws->order('prv_codigo DESC');
        $contenido['programa'] = $this->ws->obtener($this->modulo,"prv_tipo_seccion = 14");
		#Nav
		$this->layout->nav(array("Programas y valores" => '/'));

		#view
		$this->layout->view('programas_valores/index', $contenido);
	}

	public function agregar(){
        if($this->input->post()){
			#validaciones
            $error = "";
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            $datos['prv_contenido'] = $this->input->post('contenido');
            $datos['prv_tipo_seccion'] = 14; 
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"prv_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);

            echo json_encode(array("result"=>true));

        }
	}
}
