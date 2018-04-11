<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Landing_Pages extends CI_Controller {
	    
	private $modulo = 65, $modulo_imagenes = 68, $modulo_hotel = 14;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 540/2;
        $this->img->min_alto_1 = 360/2;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 540;
        $this->img->max_alto_1 = 540;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 540;
        $this->img->recorte_alto_1 = 360;
        
        #IMAGEN LATERAL
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_2 = 1580/4;
        $this->img->min_alto_2 = 450/4;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_2 = 1580;
        $this->img->max_alto_2 = 1580;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_2 = 1580;
        $this->img->recorte_alto_2 = 450;
        
        $this->img->upload_dir = '/imagenes/modulos/landing/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Landing Pages');
		
        #js
        $this->layout->js('/js/sistema/landing/index.js');
        $url = "";
        /*$where = $and = "";
        
        
        $where = "sli_tipo_seccion = 9";
        $and = " and ";*/
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/newsletter/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["landings"] = $this->ws->listar($this->modulo);
        $contenido['pagination'] = $this->pagination->create_links();
        //print_array($contenido["landings"]);
		#Nav
		$this->layout->nav(array("Newsletter" => '/'));
		
		#view
		$this->layout->view('index', $contenido);
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
            
            $datos['lan_nombre'] = $this->input->post('nombre');
            $datos['lan_descripcion'] = $this->input->post('descripcion');
            $datos['lan_formulario_contacto'] = $this->input->post('form');
            $datos['lan_url'] = slug($this->input->post('nombre'));
            
            if($this->input->post('ruta_interna_2')){
                $datos['lan_imagen'] = $this->input->post('ruta_interna_2');
                $datos['lan_galeria'] = $this->input->post('ruta_grande_2');
            }
            
            $id = $this->ws->insertar($this->modulo,$datos);
            $codigo = $id->lan_codigo;
            unset($datos);
            
            #galeria de imagenes
            $internas = $this->input->post('ruta_interna_1');
            $grandes = $this->input->post('ruta_grande_1');
            if($grandes){
                foreach($grandes as $k=>$aux){
                    if($aux){
                        $datos['land_ruta_interna'] = $internas[$k];
                        $datos['land_ruta_grande'] = $aux;
                        $datos['land_landing'] = $codigo;
                        
                        $this->ws->insertar($this->modulo_imagenes,$datos);
                    }
                }
            }
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Langing Pages');
    		
            #js - Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js
            $this->layout->js('/js/sistema/landing/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Habitaciones" => '/hoteles/habitaciones/', "Agregar Habitación" => "/"));
    		
    		#view
    		$this->layout->view('agregar');
        }
	}
    
    public function editar($codigo = 0){        
        if($this->input->post()){
			#validaciones
			$this->form_validation->set_rules('nombre','Nombre','required');
			$this->form_validation->set_rules('codigo','Codigo','required');
            $this->form_validation->set_message('required', '* %s es obligatorio');
            $this->form_validation->set_error_delimiters('<div>','</div>');
            
            $error = "";
            if(!$this->form_validation->run())
				$error .= validation_errors();
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
                        
            $datos['lan_nombre'] = $this->input->post('nombre');
            $datos['lan_descripcion'] = $this->input->post('descripcion');
            $datos['lan_formulario_contacto'] = $this->input->post('form');
            $datos['lan_url'] = slug($this->input->post('nombre'));
            //echo    $this->input->post('ruta_interna_2');
            if($this->input->post('ruta_interna_2') != null && $this->input->post('ruta_interna_2') != '')
                $datos['lan_imagen'] = $this->input->post('ruta_interna_2');
            $codigo = $this->input->post('codigo');
            
            $this->ws->actualizar($this->modulo,$datos,"lan_codigo = $codigo");
            unset($datos);
            #galeria de imagenes
            $internas = $this->input->post('ruta_interna_1');
            $grandes = $this->input->post('ruta_grande_1');
            //print_array($internas);
            //print_array($grandes);
            $cont= count(array_filter($this->input->post('ruta_interna_1'))); 
            if($cont > 0 ){
                $this->ws->eliminar($this->modulo_imagenes,"land_landing = ". $this->input->post('codigo'));
                foreach($grandes as $k=>$aux){
                    if($aux){
                        $datos['land_ruta_interna'] = $internas[$k];
                        $datos['land_ruta_grande'] = $aux;
                        $datos['land_landing'] = $codigo;
                        
                        $this->ws->insertar($this->modulo_imagenes,$datos);
                    }
                }
                echo json_encode(array("result"=>true));
                exit;
            }  
            echo json_encode(array("result"=>true));
                exit;    
        }
        else{
            #registro
            if($contenido['landing'] = $this->ws->obtener($this->modulo,"lan_codigo = $codigo"));
            else show_error('');
            
            $contenido['imagenes']->imagenes = $this->ws->listar($this->modulo_imagenes,"land_landing = $codigo");
            
    		#Title
    		$this->layout->title('Editar Landing Page');
    		
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #js
            $this->layout->js('/js/sistema/landing/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Editar Landing" => "/"));
    		//print_array($contenido);
    		#view
    		$this->layout->view('editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "lan_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
    
    ### IMAGEN ADJUNTA
    public function eliminar_imagen_adjunta(){
        if($codigo = $this->input->post('codigo')){
            $imagen = $this->ws->obtener($this->modulo,"hab_codigo = $codigo");
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta))
                unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta);
            
            $this->ws->actualizar($this->modulo,array("hab_imagen_adjunta"=>""),"hab_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
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
            if($this->input->post('tipo') == 1){
                if($imagen = $this->ws->obtener($this->modulo_imagenes,"land_codigo = $codigo")){
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_grande);
                    
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna))
                        unlink($_SERVER['DOCUMENT_ROOT'].$imagen->ruta_interna);
                        
                    $this->ws->eliminar($this->modulo_imagenes,"land_codigo = $codigo");
                }
            }elseif($this->input->post('tipo') == 2){
                if($imagen = $this->ws->obtener($this->modulo,"lan_codigo = $codigo")){
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen))
                        unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen);
                    $data['lan_imagen'] = '';
                    $this->ws->actualizar($this->modulo,$data,"lan_codigo = $codigo");
                }
            }
        } 
        echo json_encode(array("result"=>true));
    }
	
}