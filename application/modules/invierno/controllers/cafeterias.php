<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Cafeterias extends CI_Controller {
	    
	private $modulo = 44;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 130;
        $this->img->min_alto_1 = 120;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 260;
        $this->img->max_alto_1 = 240;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 130;
        $this->img->recorte_alto_1 = 120;
        
        $this->img->upload_dir = '/imagenes/modulos/invierno/cafeterias/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Cafeterías');
		
        #js
        $this->layout->js('/js/sistema/invierno/cafeterias/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/invierno/cafeterias/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("caf_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["cafeterias"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Cafeterías" => '/'));
		
		#view
		$this->layout->view('cafeterias/index', $contenido);
	}
	
	public function agregar(){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['caf_nombre'] = $this->input->post('nombre');
            $datos['caf_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            $datos['caf_orden'] = $this->input->post('orden');
            $datos['caf_url'] = slug($this->input->post('nombre'));
            $datos['caf_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Cafetería');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/invierno/cafeterias/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Cafeterías" => '/invierno/cafeterias/', "Agregar Cafetería" => "/"));
    		
    		#view
    		$this->layout->view('cafeterias/agregar');
        }
	}
    
    public function editar($codigo){
        
        if($this->input->post()){
            
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['caf_nombre'] = $this->input->post('nombre');
            $datos['caf_orden'] = $this->input->post('orden');
            $datos['caf_url'] = slug($this->input->post('nombre'));
            $datos['caf_estado'] = $this->input->post('estado');
            
            if($this->input->post('ruta_interna_1'))
                $datos['caf_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            $this->ws->actualizar($this->modulo,$datos,"caf_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['cafeteria'] = $cafeteria = $this->ws->obtener($this->modulo,"caf_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Cafetería');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/invierno/cafeterias/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("cafeteria" => '/invierno/cafeterias/', "Editar cafeteri" => "/"));
    		
    		#view
    		$this->layout->view('cafeterias/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "caf_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
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
            if($imagen = $this->ws->obtener($this->modulo,"caf_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("sli_imagen_adjunta"=>""),"caf_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}