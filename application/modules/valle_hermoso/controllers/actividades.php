<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Actividades extends CI_Controller {
	    
	private $modulo = 17;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #imagen 1
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 285;
        $this->img->min_alto_1 = 300;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 300;
        $this->img->max_alto_1 = 300;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 285;
        $this->img->recorte_alto_1 = 300;
        
        #imagen 2
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_2 = 300;
        $this->img->min_alto_2 = 150;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_2 = 600;
        $this->img->max_alto_2 = 600;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_2 = 600;
        $this->img->recorte_alto_2 = 300;
        
        $this->img->upload_dir = '/imagenes/modulos/valle-hermoso/actividades/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
        
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Actividades');
		
        #js
        $this->layout->js('/js/sistema/valle-hermoso/actividades/index.js');
        
        $where = $and = "";
        $url = "";
        
        $where = "act_tipo_seccion = 3";
        $and = " and ";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/valle-hermoso/actividades/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("act_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["actividades"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Actividades" => '/'));
		
		#view
		$this->layout->view('actividades/index', $contenido);
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
            
            $datos['act_titulo'] = $this->input->post('titulo');
            $datos['act_bajada'] = $this->input->post('bajada');
            $datos['act_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            $datos['act_imagen_adjunta_2'] = $this->input->post('ruta_interna_2');
            $datos['act_link'] = $this->input->post('link');
            $datos['act_nombre_link'] = $this->input->post('nombre_link');
            $datos['act_orden'] = $this->input->post('orden');
            $datos['act_url'] = slug($this->input->post('titulo'));
            $datos['act_estado'] = $this->input->post('estado');
            $datos['act_tipo_seccion'] = 3;
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Actividad');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/valle-hermoso/actividades/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Actividades" => '/valle-hermoso/actividades/', "Agregar Actividad" => "/"));
    		
    		#view
    		$this->layout->view('actividades/agregar');
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
            
            $datos['act_titulo'] = $this->input->post('titulo');
            $datos['act_bajada'] = $this->input->post('bajada');
            $datos['act_link'] = $this->input->post('link');
            $datos['act_nombre_link'] = $this->input->post('nombre_link');
            $datos['act_orden'] = $this->input->post('orden');
            $datos['act_url'] = slug($this->input->post('titulo'));
            $datos['act_estado'] = $this->input->post('estado');
            
            if($this->input->post('ruta_interna_1'))
                $datos['act_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            if($this->input->post('ruta_interna_2'))
                $datos['act_imagen_adjunta_2'] = $this->input->post('ruta_interna_2');
            
            $this->ws->actualizar($this->modulo,$datos,"act_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['actividad'] = $actividad = $this->ws->obtener($this->modulo,"act_codigo = '$codigo' and act_tipo_seccion = 3"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Actividad');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/valle-hermoso/actividades/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Actividades" => '/valle-hermoso/actividades/', "Editar Actividad" => "/"));
    		
    		#view
    		$this->layout->view('actividades/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "act_codigo = {$this->input->post('codigo')}");
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
            if($imagen = $this->ws->obtener($this->modulo,"act_codigo = $codigo")){
                
                if($this->input->post('tipo') == 1){
                    $ruta_imagen = $imagen->imagen_adjunta;
                    $campo = "act_imagen_adjunta";
                }
                else{
                    $ruta_imagen = $imagen->imagen_adjunta_2;
                    $campo = "secc_imagen_adjunta_2";
                }
                
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$ruta_imagen))
                    unlink($_SERVER['DOCUMENT_ROOT'].$ruta_imagen);
                
                $this->ws->actualizar($this->modulo,array($campo=>""),"act_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
}