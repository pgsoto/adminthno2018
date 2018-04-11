<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Calendario extends CI_Controller {
	    
	private $modulo = 18, $modulo_hotel = 14;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');
        
        #deptos valle hermoso no tiene calendario
        if($hotel->codigo == 3)
            redirect('/');
            
		#Title
		$this->layout->title('Calendario Diario');
		
        #js
        $this->layout->js('/js/sistema/hoteles/calendario/index.js');
        
        $where = $and = "";
        $url = "";
        
        $where = "cad_hotel = '$hotel->codigo'";
        $and = " and ";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 4;
		$config['base_url'] = '/hoteles/'.$hotel->url.'/calendario/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("cad_hora_inicio ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["calendario"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Calendario Diario" => '/'));
		
		#view
		$this->layout->view('calendario/index', $contenido);
	}
	
	public function agregar(){
        
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');
        
        #deptos valle hermoso no tiene calendario
        if($hotel->codigo == 3)
            redirect('/');
            
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('titulo','Título','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cad_titulo'] = $this->input->post('titulo');
            $datos['cad_sector'] = $this->input->post('sector');
            $datos['cad_hora_inicio'] = $this->input->post('hora_inicio');
            $datos['cad_hora_termino'] = $this->input->post('hora_termino');
            $datos['act_orden'] = $this->input->post('orden');
            $datos['cad_url'] = slug($this->input->post('titulo'));
            $datos['cad_estado'] = $this->input->post('estado');
            $datos['cad_hotel'] = $hotel->codigo;
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Calendario');
    		
            #js - Time picker
            $this->layout->js('/js/jquery/bootstrap-timepicker/js/bootstrap-timepicker.js');
            
            #js
            $this->layout->js('/js/sistema/hoteles/calendario/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Calendario Diario" => '/hoteles/'.$hotel->url.'/calendario/', "Agregar Calendario" => "/"));
    		
    		#view
    		$this->layout->view('calendario/agregar',$contenido);
        }
	}
    
    public function editar($codigo){
        
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');
        
        #deptos valle hermoso no tiene calendario
        if($hotel->codigo == 3)
            redirect('/');
            
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('titulo','Título','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cad_titulo'] = $this->input->post('titulo');
            $datos['cad_sector'] = $this->input->post('sector');
            $datos['cad_hora_inicio'] = $this->input->post('hora_inicio');
            $datos['cad_hora_termino'] = $this->input->post('hora_termino');
            $datos['act_orden'] = $this->input->post('orden');
            $datos['cad_url'] = slug($this->input->post('titulo'));
            $datos['cad_estado'] = $this->input->post('estado');
            $datos['cad_hotel'] = $hotel->codigo;

            $this->ws->actualizar($this->modulo,$datos,"cad_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['calendario'] = $calendario = $this->ws->obtener($this->modulo,"cad_codigo = '$codigo' and cad_hotel = '$hotel->codigo'"));
            else show_error('');
        
    		#Title
    		$this->layout->title('Editar Calendario');
    		
            #js - Time picker
            $this->layout->js('/js/jquery/bootstrap-timepicker/js/bootstrap-timepicker.js');
            
            #js
            $this->layout->js('/js/sistema/hoteles/calendario/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Calendario Diario" => '/hoteles/'.$hotel->url.'/calendario/', "Editar Calendario" => "/"));
    		
    		#view
    		$this->layout->view('calendario/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "cad_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}