<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Noticias extends CI_Controller {
	    
	private $modulo = 37, $modulo_imagenes = 38, $modulo_categoria = 30;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 270;
        $this->img->min_alto_1 = 180;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 1080;
        $this->img->max_alto_1 = 720;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 540;
        $this->img->recorte_alto_1 = 360;
        
        $this->img->upload_dir = '/imagenes/modulos/portada/noticias/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Noticias');
		
        #js
        $this->layout->js('/js/sistema/portada/noticias/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/portada/noticias/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("not_fecha_publicacion DESC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["noticias"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Noticias" => '/'));
		
		#view
		$this->layout->view('noticias/index', $contenido);
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
            
            $datos['not_titulo'] = $this->input->post('titulo');
            $datos['not_fecha_publicacion'] = ($this->input->post('fecha_publicacion'))?formatearFecha($this->input->post('fecha_publicacion')):'';
            $datos['not_descripcion'] = $this->input->post('descripcion');
            $datos['not_resumen'] = $this->input->post('resumen');
            $datos['not_categoria'] = $this->input->post('categoria');
            $datos['not_url'] = slug($this->input->post('titulo'));
            $datos['not_estado'] = $this->input->post('estado');
            
            $id = $this->ws->insertar($this->modulo,$datos);
            $codigo = $id->not_codigo;
            unset($datos);
            
            #galeria de imagenes
            $internas = $this->input->post('ruta_interna_1');
            $grandes = $this->input->post('ruta_grande_1');
            if($grandes){
                foreach($grandes as $k=>$aux){
                    if($aux){
                        $datos['noti_ruta_interna'] = $internas[$k];
                        $datos['noti_ruta_grande'] = $aux;
                        $datos['noti_noticia'] = $codigo;
                        
                        $this->ws->insertar($this->modulo_imagenes,$datos);
                    }
                }
            }
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Noticia');
    		
            #js - Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js - Datepicker
            $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
            $this->layout->css('/js/jquery/datepicker/datepicker3.css');
            
            #js
            $this->layout->js('/js/sistema/portada/noticias/agregar.js');
    		
            #categorias
            $contenido['categorias'] = $this->ws->listar($this->modulo_categoria,"can_estado = 1");
            
    		#Nav
    		$this->layout->nav(array("Noticias" => '/portada/noticias/', "Agregar Noticia" => "/"));
    		
    		#view
    		$this->layout->view('noticias/agregar',$contenido);
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
            
            $datos['not_titulo'] = $this->input->post('titulo');
            $datos['not_fecha_publicacion'] = ($this->input->post('fecha_publicacion'))?formatearFecha($this->input->post('fecha_publicacion')):'';
            $datos['not_descripcion'] = $this->input->post('descripcion');
            $datos['not_resumen'] = $this->input->post('resumen');
            $datos['not_categoria'] = $this->input->post('categoria');
            $datos['not_url'] = slug($this->input->post('titulo'));
            $datos['not_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"not_codigo = $codigo");
            unset($datos);
            
            #galeria de imagenes
            $internas = $this->input->post('ruta_interna_1');
            $grandes = $this->input->post('ruta_grande_1');
            if($grandes){
                foreach($grandes as $k=>$aux){
                    if($aux){
                        $datos['noti_ruta_interna'] = $internas[$k];
                        $datos['noti_ruta_grande'] = $aux;
                        $datos['noti_noticia'] = $codigo;
                        
                        $this->ws->insertar($this->modulo_imagenes,$datos);
                    }
                }
            }
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['noticia'] = $this->ws->obtener($this->modulo,"not_codigo = '$codigo'"));
            else show_error('');
            
            #imagenes
            $contenido['noticia']->imagenes = $this->ws->listar($this->modulo_imagenes,"noti_noticia = $codigo");
            
            #categorias
            $contenido['categorias'] = $this->ws->listar($this->modulo_categoria,"can_estado = 1");
            
    		#Title
    		$this->layout->title('Editar Noticia');
    		
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js - Datepicker
            $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
            $this->layout->css('/js/jquery/datepicker/datepicker3.css');
            
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/portada/noticias/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Noticias" => '/portada/noticias/', "Editar Noticia" => "/"));
    		
    		#view
    		$this->layout->view('noticias/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "not_codigo = {$this->input->post('codigo')}");
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
            if($imagen = $this->ws->obtener($this->modulo_imagenes,"noti_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande);
                
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna);
                    
                $this->ws->eliminar($this->modulo_imagenes,"noti_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}