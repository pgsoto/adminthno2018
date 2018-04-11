<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Promociones extends CI_Controller {
	    
	private $modulo = 23,$modulo_hoteles = 24,$modulo_archivos = 25;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        
        #IMAGEN BANNER
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_1 = 270;
        $this->img->min_alto_1 = 180;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_1 = 540;
        $this->img->max_alto_1 = 540;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_1 = 540;
        $this->img->recorte_alto_1 = 360;
        
        
        #IMAGEN DETALLE
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho_2 = 270;
        $this->img->min_alto_2 = 180;
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho_2 = 800;
        $this->img->max_alto_2 = 600;
        
        #define el tamaño del recorte
        $this->img->recorte_ancho_2 = 540;
        $this->img->recorte_alto_2 = 360;
        
        $this->img->upload_dir = '/imagenes/modulos/promociones/';
        
        #lib imagenes
        $this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Promociones');
		
        #js
        $this->layout->js('/js/sistema/promociones/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 2;
		$config['base_url'] = '/promociones/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("pro_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["promociones"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Promociones" => '/'));
		
		#view
		$this->layout->view('/promociones/index', $contenido);
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
            
            $datos['pro_nombre'] = $this->input->post('nombre');
            $datos['pro_descripcion'] = $this->input->post('descripcion');
            $datos['pro_imagen_adjunta_banner'] = $this->input->post('ruta_interna_1');
            $datos['pro_imagen_adjunta_detalle'] = $this->input->post('ruta_interna_2');
            $datos['pro_imagen_adjunta_detalle_grande'] = $this->input->post('ruta_grande_2');
            $datos['pro_orden'] = $this->input->post('orden');
            $datos['pro_url'] = slug($this->input->post('nombre'));
            
            $datos['pro_invierno'] = $this->input->post('invierno');
            $datos['pro_verano'] = $this->input->post('verano');
            
            $datos['pro_evento'] = $this->input->post('evento');
            
              
            $datos['pro_estado'] = $this->input->post('estado');
            
            $id = $this->ws->insertar($this->modulo,$datos); #23 promociones
            $codigo = $id->pro_codigo;
              
            #asocia con los hoteles
            if($hoteles = $this->input->post('hoteles')){
                foreach($hoteles as $aux){
                    if($aux){
                        
                        unset($datos);
                        $datos['proh_promocion'] = $codigo;
                        $datos['proh_hotel'] = $aux;
                        
                        $this->ws->insertar($this->modulo_hoteles,$datos); #24 promociones hotel
                        
                    }
                }
            }
            
            #agrega los archivos
            if($archivos = $_FILES['archivos']){
                $ruta = '/archivos/promociones/';
                crear_directorio($ruta);
                
                #config archivo
                $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$ruta;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf|jpg|jpeg|png';
                #$config['max_size']	= '100';
                $this->load->library('upload');
                
                $nombre_archivo = $this->input->post('nombre_archivo');
                foreach($nombre_archivo as $k=>$aux){
                    if($aux){
                        if($archivos['name'][$k]){
                            
                            #se redefine la variable FILES con cada archivo
                            $_FILES['archivo']['name'] = $archivos['name'][$k];
                            $_FILES['archivo']['type'] = $archivos['type'][$k];
                            $_FILES['archivo']['tmp_name'] = $archivos['tmp_name'][$k];
                            $_FILES['archivo']['error'] = $archivos['error'][$k];
                            $_FILES['archivo']['size'] = $archivos['size'][$k];
                            
                            unset($datos);
                            
                            $file_name = slug($aux);
                            $config['file_name'] = $file_name;
                            $this->upload->initialize($config);
                            
                            if(!$this->upload->do_upload('archivo'))
                    		{
                    			$error = $this->upload->display_errors();
                                continue;
                    		}
            
                            $extension = array_pop(explode('.',$archivos['name'][$k]));
                            $file_name .= '.'.$extension;
                            $ruta_archivo = $ruta.$file_name;
                            
                            $datos['proa_nombre'] = $aux;
                            $datos['proa_ruta'] = $ruta_archivo;
                            $datos['proa_extension'] = $extension;
                            $datos['proa_peso'] = $archivos['size'][$k];
                            $datos['proa_promocion'] = $codigo;
                            
                            $this->ws->insertar($this->modulo_archivos,$datos);
                        }
                    }
                }
            }
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Promoción');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js
            $this->layout->js('/js/sistema/promociones/agregar.js');
    		
            #hoteles
            $this->ws->order("ho_orden ASC");
            $contenido['hoteles'] = $this->ws->listar(14,"ho_estado = 1");
            
    		#Nav
    		$this->layout->nav(array("Promociones" => '/promociones/', "Agregar Promoción" => "/"));
    		
    		#view
    		$this->layout->view('/promociones/agregar',$contenido);
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
            
            $datos['pro_nombre'] = $this->input->post('nombre');
            $datos['pro_descripcion'] = $this->input->post('descripcion');
            $datos['pro_orden'] = $this->input->post('orden');
            $datos['pro_url'] = slug($this->input->post('nombre'));
            
            
            
            if(!$this->input->post('invierno')){
                 $datos['pro_invierno'] =  0; 
            }else{
                  $datos['pro_invierno'] = $this->input->post('invierno');  
            }
            
            
             if(!$this->input->post('verano')){
                
               $datos['pro_verano'] = 0;
                
             }else{
               
               $datos['pro_verano'] = $this->input->post('verano');
                
             }
             
             
             if(!$this->input->post('evento')){
                
               $datos['pro_evento'] = 0;
                
             }else{
               
               $datos['pro_evento'] = $this->input->post('evento');
                
             }  

        
            
            $datos['pro_estado'] = $this->input->post('estado');
            
            
            #print_array($datos); die; 
              
              
            if($this->input->post('ruta_interna_1'))
                $datos['pro_imagen_adjunta_banner'] = $this->input->post('ruta_interna_1');
            
            if($this->input->post('ruta_interna_2')){
                $datos['pro_imagen_adjunta_detalle'] = $this->input->post('ruta_interna_2');
                $datos['pro_imagen_adjunta_detalle_grande'] = $this->input->post('ruta_grande_2');
            }
            
            $this->ws->actualizar($this->modulo,$datos,"pro_codigo = $codigo");
            
            #asocia con los hoteles
            $this->ws->eliminar($this->modulo_hoteles,"proh_promocion = $codigo");
            if($hoteles = $this->input->post('hoteles')){
                foreach($hoteles as $aux){
                    if($aux){
                        unset($datos);
                        $datos['proh_promocion'] = $codigo;
                        $datos['proh_hotel'] = $aux;
                        
                        $this->ws->insertar($this->modulo_hoteles,$datos);
                    }
                }
            }
            
            #agrega los archivos
            if($archivos = $_FILES['archivos']){
                $ruta = '/archivos/promociones/';
                crear_directorio($ruta);
                
                #config archivo
                $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$ruta;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf|jpg|jpeg|png';
                #$config['max_size']	= '100';
                $this->load->library('upload');
                
                $nombre_archivo = $this->input->post('nombre_archivo');
                foreach($nombre_archivo as $k=>$aux){
                    if($aux){
                        if(isset($archivos['name'][$k]) && $archivos['name'][$k]){
                            
                            #se redefine la variable FILES con cada archivo
                            $_FILES['archivo']['name'] = $archivos['name'][$k];
                            $_FILES['archivo']['type'] = $archivos['type'][$k];
                            $_FILES['archivo']['tmp_name'] = $archivos['tmp_name'][$k];
                            $_FILES['archivo']['error'] = $archivos['error'][$k];
                            $_FILES['archivo']['size'] = $archivos['size'][$k];
                            
                            unset($datos);
                            
                            $file_name = slug($aux);
                            $config['file_name'] = $file_name;
                            $this->upload->initialize($config);
                            
                            if(!$this->upload->do_upload('archivo'))
                    		{
                    			$error = $this->upload->display_errors();
                                continue;
                    		}
            
                            $extension = array_pop(explode('.',$archivos['name'][$k]));
                            $file_name .= '.'.$extension;
                            $ruta_archivo = $ruta.$file_name;
                            
                            $datos['proa_nombre'] = $aux;
                            $datos['proa_ruta'] = $ruta_archivo;
                            $datos['proa_extension'] = $extension;
                            $datos['proa_peso'] = $archivos['size'][$k];
                            $datos['proa_promocion'] = $codigo;
                            
                            $this->ws->insertar($this->modulo_archivos,$datos);
                        }
                    }
                }
            }
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['promocion'] = $promocion = $this->ws->obtener($this->modulo,"pro_codigo = '$codigo'"));
            else show_error('');
            
            
              
            #print_array($contenido['promocion']); die; 
            
             
            #hoteles
            $contenido['promocion']->hoteles = $this->ws->listar($this->modulo_hoteles,"proh_promocion = $codigo");
            
            #archivos
            $contenido['promocion']->archivos = $this->ws->listar($this->modulo_archivos,"proa_promocion = $codigo");
            
    		#Title
    		$this->layout->title('Editar Promoción');
    		
            #js Imagen Cropic
            $this->layout->js('/js/jquery/croppic/croppic.js');
            $this->layout->css('/js/jquery/croppic/croppic.css');
            $this->layout->js('/js/sistema/imagenes/simple.js');
            
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js
            $this->layout->js('/js/sistema/promociones/editar.js');
    		
            #hoteles
            $this->ws->order("ho_orden ASC");
            $contenido['hoteles'] = $this->ws->listar(14,"ho_estado = 1");
            
    		#Nav
    		$this->layout->nav(array("Promociones" => '/promociones/', "Editar Promoción" => "/"));
    		
    		#view
    		$this->layout->view('/promociones/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "pro_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
    
    #ARCHIVOS
    public function descargar_archivo($codigo){
        $archivo = $this->ws->obtener($this->modulo_archivos,"proa_codigo = $codigo");
        
        $this->load->helper('download');
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$archivo->ruta);
        $name = slug($archivo->nombre).'.'.$archivo->extension;
        
        force_download($name, $data);
    }
    
    public function eliminar_archivo(){
        $codigo = $this->input->post('codigo');
        $archivo = $this->ws->obtener($this->modulo_archivos,"proa_codigo = $codigo");
        
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$archivo->ruta))
            unlink($_SERVER['DOCUMENT_ROOT'].$archivo->ruta);
        
        $this->ws->eliminar($this->modulo_archivos,"proa_codigo = $codigo");
        
        echo json_encode(array("result"=>true));
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
        if($codigo = $this->input->post('codigo')){
            if($imagen = $this->ws->obtener($this->modulo,"pro_codigo = $codigo")){
                
                if($this->input->post('tipo') == 1){
                    //echo $_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta_banner;
                    
                    $datos['pro_imagen_adjunta_banner'] = "";                    
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta_banner))
                        unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta_banner);
                }
                else{
                    //echo $_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta_detalle;
                    //die;
                    $datos['pro_imagen_adjunta_detalle'] = "";
                    $datos['pro_imagen_adjunta_detalle_grande'] = "";
                    
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta_detalle_grande))
                        unlink($_SERVER['DOCUMENT_ROOT'].$imagen->imagen_adjunta_detalle_grande);
                }

                $this->ws->actualizar($this->modulo,$datos,"pro_codigo = $codigo");
            }
        }
        
        echo json_encode(array("result"=>true));
    }
	
}