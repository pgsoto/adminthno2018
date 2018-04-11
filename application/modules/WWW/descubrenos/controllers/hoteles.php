<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Hoteles extends CI_Controller {
	    
	private $modulo = 50;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 260;
        $this->img->min_alto_1 = 188.3;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 780;
        $this->img->max_alto_1 = 780;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 780;
        $this->img->recorte_alto_1 = 565;
        
        $this->img->upload_dir = '/imagenes/modulos/descubrenos/hoteles/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Hoteles');
		
        #js
        $this->layout->js('/js/sistema/descubrenos/hoteles/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/descubrenos/hoteles/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("hop_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["hoteles"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Hoteles" => '/'));
		
		#view
		$this->layout->view('hoteles/index', $contenido);
	}
	
	public function agregar(){
        
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
            
            $datos['hop_titulo'] = $this->input->post('titulo');
            $datos['hop_bajada'] = $this->input->post('bajada');
            $datos['hop_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            $datos['hop_link'] = $this->input->post('link');
            $datos['hop_orden'] = $this->input->post('orden');
            $datos['hop_url'] = slug($this->input->post('titulo'));
            $datos['hop_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Hotel');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/descubrenos/hoteles/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Hoteles" => '/descubrenos/hoteles/', "Agregar Hotel" => "/"));
    		
    		#view
    		$this->layout->view('hoteles/agregar');
        }
	}
    
    public function editar($codigo){
        
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
            
            $datos['hop_titulo'] = $this->input->post('titulo');
            $datos['hop_bajada'] = $this->input->post('bajada');
            $datos['hop_link'] = $this->input->post('link');
            $datos['hop_orden'] = $this->input->post('orden');
            $datos['hop_url'] = slug($this->input->post('titulo'));
            $datos['hop_estado'] = $this->input->post('estado');
            
            if($this->input->post('ruta_interna_1'))
                $datos['hop_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            $this->ws->actualizar($this->modulo,$datos,"hop_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo,"hop_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Hotel');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/descubrenos/hoteles/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Hoteles" => '/descubrenos/hoteles/', "Editar Hotel" => "/"));
    		
    		#view
    		$this->layout->view('hoteles/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "hop_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
    
    
    
    ###IMAGENES
	public function cargar_imagen(){
        
        #se realiza la configuracion para cada imagen
        $this->img->id = $this->input->post('id');
        $this->objImagen->config($this->img);
        
        $response = $this->objImagen->cargar_imagen($_FILES);
        echo json_encode($response);
	}
	
	public function cortar_imagen(){
        
        #se realiza la configuracion para cada imagen
        $this->img->id = $this->input->post('id');
        $this->objImagen->config($this->img);
        
        $response =  $this->objImagen->cortar_imagen($_POST);
        echo json_encode($response);
	}
    
    public function eliminar_imagen(){
        if($ruta = $this->input->post('ruta_imagen')){
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$ruta))
                unlink($_SERVER['DOCUMENT_ROOT'].$ruta);
        }
        
        if($codigo = $this->input->post('codigo')){
            if($imagen = $this->ws->obtener($this->modulo,"hop_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("hop_imagen_adjunta"=>""),"hop_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}