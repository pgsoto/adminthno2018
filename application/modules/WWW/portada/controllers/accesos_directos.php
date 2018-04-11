<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Accesos_directos extends CI_Controller {
	    
	private $modulo = 39;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #imagen 1
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 320;
        $this->img->min_alto_1 = 309.5;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 640;
        $this->img->max_alto_1 = 640;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 640;
        $this->img->recorte_alto_1 = 619;
        
        #imagen 2
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_2 = 320;
        $this->img->min_alto_2 = 167.5;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_2 = 640;
        $this->img->max_alto_2 = 640;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_2 = 640;
        $this->img->recorte_alto_2 = 335;
        
        $this->img->upload_dir = '/imagenes/modulos/portada/accesos-directos/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Accesos Directos');
		
        #js
        $this->layout->js('/js/sistema/portada/accesos-directos/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/portada/accesos-directos/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("acd_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["accesos"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Accesos Directos" => '/'));
		
		#view
		$this->layout->view('accesos_directos/index', $contenido);
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
            
            $datos['acd_titulo'] = $this->input->post('titulo');
            $datos['acd_resumen'] = $this->input->post('resumen');
            $datos['acd_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            $datos['acd_imagen_adjunta_2'] = $this->input->post('ruta_interna_2');
            $datos['acd_link'] = $this->input->post('link');
            $datos['acd_orden'] = $this->input->post('orden');
            $datos['acd_url'] = slug($this->input->post('titulo'));
            $datos['acd_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Acceso Directo');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/portada/accesos-directos/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Accesos Directos" => '/portada/accesos-directos/', "Agregar Acceso Directo" => "/"));
    		
    		#view
    		$this->layout->view('accesos_directos/agregar');
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
            
            $datos['acd_titulo'] = $this->input->post('titulo');
            $datos['acd_resumen'] = $this->input->post('resumen');
            $datos['acd_link'] = $this->input->post('link');
            $datos['acd_orden'] = $this->input->post('orden');
            $datos['acd_url'] = slug($this->input->post('titulo'));
            $datos['acd_estado'] = $this->input->post('estado');
            
            if($this->input->post('ruta_interna_1'))
                $datos['acd_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            if($this->input->post('ruta_interna_2'))
                $datos['acd_imagen_adjunta_2'] = $this->input->post('ruta_interna_2');
            
            $this->ws->actualizar($this->modulo,$datos,"acd_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['acceso'] = $acceso = $this->ws->obtener($this->modulo,"acd_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Acceso Directo');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/portada/accesos-directos/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Accesos Directos" => '/portada/accesos-directos/', "Editar Acceso Directo" => "/"));
    		
    		#view
    		$this->layout->view('accesos_directos/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "acd_codigo = {$this->input->post('codigo')}");
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
            if($imagen = $this->ws->obtener($this->modulo,"sli_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("sli_imagen_adjunta"=>""),"sli_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}