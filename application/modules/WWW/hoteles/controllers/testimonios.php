<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Testimonios extends CI_Controller {
	    
	private $modulo = 20,$modulo_hotel = 14;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 165;
        $this->img->min_alto_1 = 165;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 800;
        $this->img->max_alto_1 = 800;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 165;
        $this->img->recorte_alto_1 = 165;

        $this->img->upload_dir = '/imagenes/modulos/hoteles/testimonios/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');
        
        #deptos valle hermoso no tiene testimonios
        if($hotel->codigo == 3)
            redirect('/');
        
		#Title
		$this->layout->title('Testimonios');
		
        #js
        $this->layout->js('/js/sistema/hoteles/testimonios/index.js');
        
        $where = $and = "";
        $url = "";
        
        $where = "tes_hotel = '$hotel->codigo'";
        $and = " and ";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 4;
		$config['base_url'] = '/hoteles/'.$hotel->url.'/testimonios/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("tes_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["testimonios"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Testimonios" => '/'));
		
		#view
		$this->layout->view('testimonios/index', $contenido);
	}
	
	public function agregar(){
        
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');
        
        #deptos valle hermoso no tiene testimonios
        if($hotel->codigo == 3)
            redirect('/');
            
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
            
            $datos['tes_nombre'] = $this->input->post('nombre');
            $datos['tes_testimonio'] = $this->input->post('testimonio');
            $datos['tes_orden'] = $this->input->post('orden');
            $datos['tes_url'] = slug($this->input->post('nombre'));
            $datos['tes_fecha'] = ($this->input->post('fecha'))?formatearFecha($this->input->post('fecha')):'';
            $datos['tes_estado'] = $this->input->post('estado');
            $datos['tes_hotel'] = $hotel->codigo;
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Testimonos');
    		
            #js Imagen Cropic
            /*$this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');*/
            
            #js - Datepicker
            $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
            $this->layout->css('/js/jquery/datepicker/datepicker3.css');
            
            #js
            $this->layout->js('/js/sistema/hoteles/testimonios/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Testimonios" => '/hoteles/'.$hotel->url.'/testimonios/', "Agregar Testimonio" => "/"));
    		
    		#view
    		$this->layout->view('testimonios/agregar',$contenido);
        }
	}
    
    public function editar($codigo){
        
        #url hotel
        $url_hotel = $this->uri->segment(2);
        if($contenido['hotel'] = $hotel = $this->ws->obtener($this->modulo_hotel,"ho_url = '$url_hotel' and ho_estado = 1"));
        else show_error('');
        
        #deptos valle hermoso no tiene testimonios
        if($hotel->codigo == 3)
            redirect('/');
            
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
            
            $datos['tes_nombre'] = $this->input->post('nombre');
            $datos['tes_testimonio'] = $this->input->post('testimonio');
            $datos['tes_orden'] = $this->input->post('orden');
            $datos['tes_url'] = slug($this->input->post('nombre'));
            $datos['tes_fecha'] = ($this->input->post('fecha'))?formatearFecha($this->input->post('fecha')):'';
            $datos['tes_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"tes_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['testimonio'] = $testimonio = $this->ws->obtener($this->modulo,"tes_codigo = '$codigo' and tes_hotel = '$hotel->codigo'"));
            else show_error('');
        
    		#Title
    		$this->layout->title('Editar Testimonio');
    		
            #js Imagen Cropic
            /*$this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');*/
            
            #js - Datepicker
            $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
            $this->layout->css('/js/jquery/datepicker/datepicker3.css');
            
            #js
            $this->layout->js('/js/sistema/hoteles/testimonios/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Testimonios" => '/hoteles/'.$hotel->url.'/testimonios/', "Editar Testimonio" => "/"));
    		
    		#view
    		$this->layout->view('testimonios/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "tes_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
    
    
    /*
    Sin imagen desde el 08/06/2017
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
            if($imagen = $this->ws->obtener($this->modulo,"tes_codigo = $codigo")){
                if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                    unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
                    
                $this->ws->actualizar($this->modulo,array("tes_imagen_adjunta"=>""),"tes_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	*/
}