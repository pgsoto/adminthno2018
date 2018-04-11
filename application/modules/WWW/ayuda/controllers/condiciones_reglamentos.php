<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Condiciones_reglamentos extends CI_Controller {
	    
	private $modulo = 58;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Condiciones y Reglamentos');
		
        #js
        $this->layout->js('/js/sistema/ayuda/condiciones-reglamentos/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/ayuda/condiciones-reglamentos/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order("cor_orden ASC");
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["condiciones"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Condiciones y Reglamentos" => '/'));
		
		#view
		$this->layout->view('condiciones-reglamentos/index', $contenido);
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
            
            #agrega el archivo adjunto
            if($_FILES['archivo']['name']){
                $archivo = $_FILES['archivo'];
                $ruta = '/archivos/condiciones-reglamentos/';
                crear_directorio($ruta);
                
                #config archivo
                $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$ruta;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf|jpg|jpeg|png';
                #$config['max_size']	= '100';
                $this->load->library('upload');

                $nombre = explode('.',basename($archivo['name']));
                $extension = array_pop($nombre);
                $nombre = slug($nombre[0],'_').'_'.time();
                $config['file_name'] = $nombre.'.'.$extension;
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('archivo'))
        		{
        			$error .= "<div>* Ha ocurrido un error al subir el archivo</div>";
        		}
                
                $datos['cor_archivo_adjunto'] = $ruta.$config['file_name'];
            }
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cor_titulo'] = $this->input->post('titulo');
            $datos['cor_descripcion'] = $this->input->post('descripcion');
            $datos['cor_orden'] = $this->input->post('orden');
            $datos['cor_url'] = slug($this->input->post('titulo'));
            $datos['cor_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Condiciones y Reglamentos');
    		
            #JS - Editor
            $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        
            #js
            $this->layout->js('/js/sistema/ayuda/condiciones-reglamentos/agregar.js');
    		
    		#Nav
    		$this->layout->nav(array("Condiciones y Reglamentos" => '/ayuda/condiciones-reglamentos/', "Agregar Condiciones y Reglamentos" => "/"));
    		
    		#view
    		$this->layout->view('condiciones-reglamentos/agregar');
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
            
            #agrega el archivo adjunto
            if($_FILES['archivo']['name']){
                $archivo = $_FILES['archivo'];
                $ruta = '/archivos/condiciones-reglamentos/';
                crear_directorio($ruta);
                
                #config archivo
                $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$ruta;
                $config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf|jpg|jpeg|png';
                #$config['max_size']	= '100';
                $this->load->library('upload');

                $nombre = explode('.',basename($archivo['name']));
                $extension = array_pop($nombre);
                $nombre = slug($nombre[0],'_').'_'.time();
                $config['file_name'] = $nombre.'.'.$extension;
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('archivo'))
        		{
        			$error .= "<div>* Ha ocurrido un error al subir el archivo</div>";
        		}
                
                $datos['cor_archivo_adjunto'] = $ruta.$config['file_name'];
            }
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['cor_titulo'] = $this->input->post('titulo');
            $datos['cor_descripcion'] = $this->input->post('descripcion');
            $datos['cor_orden'] = $this->input->post('orden');
            $datos['cor_url'] = slug($this->input->post('titulo'));
            $datos['cor_estado'] = $this->input->post('estado');
            
            $this->ws->actualizar($this->modulo,$datos,"cor_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['condicion'] = $condicion = $this->ws->obtener($this->modulo,"cor_codigo = '$codigo'"));
            else show_error('');
            
    		#Title
    		$this->layout->title('Editar Condiciones y Reglamentos');
    		
            #JS - Editor
            $this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
        
            #js
            $this->layout->js('/js/sistema/ayuda/condiciones-reglamentos/editar.js');
    		
    		#Nav
    		$this->layout->nav(array("Condiciones y Reglamentos" => '/ayuda/condiciones-reglamentos/', "Editar Condiciones y Reglamentos" => "/"));
    		
    		#view
    		$this->layout->view('condiciones-reglamentos/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "cor_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
    
    
    ### ARCHIVO ADJUNTO
    public function descargar_archivo($codigo){
        $archivo = $this->ws->obtener($this->modulo,"cor_codigo = $codigo");
        
        $this->load->helper('download');
        $name = basename($archivo->archivo_adjunto);
        $data = file_get_contents($_SERVER['DOCUMENT_ROOT'].$archivo->archivo_adjunto);
        
        force_download($name, $data);
    }
    
    public function eliminar_archivo(){
        if($codigo = $this->input->post('codigo')){
            $archivo = $this->ws->obtener($this->modulo,"cor_codigo = $codigo");
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$archivo->archivo_adjunto))
                unlink($_SERVER['DOCUMENT_ROOT'].$archivo->archivo_adjunto);
            
            $this->ws->actualizar($this->modulo,array("cor_archivo_adjunto"=>""),"cor_codigo = $codigo");
            
            echo json_encode(array("result"=>true));
        }
    }
}