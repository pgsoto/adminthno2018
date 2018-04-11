<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Banners extends CI_Controller {
	    
	private $modulo = 21;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 295;
        $this->img->min_alto_1 = 110;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 590;
        $this->img->max_alto_1 = 590;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 590;
        $this->img->recorte_alto_1 = 220;

        $this->img->upload_dir = '/imagenes/modulos/valle-hermoso/banners/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Banners');
		
        #js
        $this->layout->js('/js/sistema/valle-hermoso/banners/index.js');
        
        $where = $and = "";
        $url = "";
        
        $where = "ban_tipo_seccion = 3";
        $and = " and ";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/valle-hermoso/banners/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("ban_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["banners"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Banners" => '/'));
		
		#view
		$this->layout->view('banners/index', $contenido);
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
            
            $datos['ban_nombre'] = $this->input->post('nombre');
            $datos['ban_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            $datos['ban_link'] = $this->input->post('link');
            $datos['ban_orden'] = $this->input->post('orden');
            $datos['ban_url'] = slug($this->input->post('nombre'));
            $datos['ban_estado'] = $this->input->post('estado');
            $datos['ban_tipo_seccion'] = 3;
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Banner');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/valle-hermoso/banners/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Banners" => '/valle-hermoso/banners/', "Agregar Banner" => "/"));
    		
    		#view
    		$this->layout->view('banners/agregar');
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
            
            $datos['ban_nombre'] = $this->input->post('nombre');
            $datos['ban_link'] = $this->input->post('link');
            $datos['ban_orden'] = $this->input->post('orden');
            $datos['ban_url'] = slug($this->input->post('nombre'));
            $datos['ban_estado'] = $this->input->post('estado');
            
            if($this->input->post('ruta_interna_1'))
                $datos['ban_imagen_adjunta'] = $this->input->post('ruta_interna_1');
            
            $this->ws->actualizar($this->modulo,$datos,"ban_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['banner'] = $banner = $this->ws->obtener($this->modulo,"ban_codigo = '$codigo' and ban_tipo_seccion = 3"));
            else show_error('');
        
    		#Title
    		$this->layout->title('Editar Banner');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/valle-hermoso/banners/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Banners" => '/valle-hermoso/banners/', "Editar Banner" => "/"));
    		
    		#view
    		$this->layout->view('banners/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "ban_codigo = {$this->input->post('codigo')}");
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
            if($imagen = $this->ws->obtener($this->modulo,"ban_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("tes_imagen_adjunta"=>""),"ban_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}