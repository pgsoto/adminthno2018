<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Mapa_pistas extends CI_Controller {
	    
	private $modulo = 45;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        #medidas imagen
        $this->img->ancho_min_1 = 1170;
        $this->img->alto_min_1 = 0;
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Mapa de Pistas');
		
        #js
        $this->layout->js('/js/sistema/invierno/mapa-pistas/index.js');
        
		#contenido
		$contenido["mapa"] = $this->ws->obtener($this->modulo,"map_codigo = 1");
        
		#Nav
		$this->layout->nav(array("Mapa de Pistas" => '/'));
		
		#view
		$this->layout->view('mapa_pistas/index', $contenido);
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

            #subir imagen
            if($_FILES['imagen']['name']){
                
                $upload_dir = '/imagenes/modulos/invierno/mapa-pistas/';
                creaDirectoriosUrl($upload_dir);
                
                $extension = array_pop(explode('.',$_FILES['imagen']['name']));
                $nombre_grande = slug($this->input->post('titulo')).time().'-grande.'.$extension;
                
                $configU['upload_path'] = $_SERVER['DOCUMENT_ROOT'].$upload_dir;
        		$configU['allowed_types'] = 'jpeg|jpg|png';
                $configU['file_name'] = $nombre_grande;
        		#$configU['max_size']	= '100';
        		$this->load->library('upload', $configU);
                
        		if(!$this->upload->do_upload('imagen'))
        			#$error .= $this->upload->display_errors();
                    $error .= "<div>* Ha ocurrido un error al subir la imagen. Inténtelo nuevamente.</div>";
        		else{
                    #datos de la imagen cargada
                    $dataUpload = $this->upload->data();
                    
                    #si la imagen es mayor 1170 se ajusta
                    if($dataUpload['image_width'] >= $this->img->ancho_min_1){
                        
                        #si el alto no esta definido se mantiene el actual
                        $this->img->alto_min_1 = ($this->img->alto_min_1)?$this->img->alto_min_1:$dataUpload['image_height'];
                        
                        $configR['image_library'] = 'gd2';
                        $configR['source_image']	= $_SERVER['DOCUMENT_ROOT'].$upload_dir.$nombre_grande;
                        $configR['maintain_ratio'] = TRUE;
                        $configR['master_dim'] = 'auto';
                        $configR['width'] = $this->img->ancho_min_1;
                        $configR['height'] = $this->img->alto_min_1;
                        $this->load->library('image_lib', $configR); 
                        
                        #procesa la imagen
                        if(!$this->image_lib->resize())
                            #$this->image_lib->display_errors();
                            $error .= "<div>* Ha ocurrido un error al subir la imagen. Inténtelo nuevamente.</div>";
                    }
                    else{
                        $error .= "<div>* La imagen debe tener un tamaño mínimo de ".$this->img->ancho_min_1."px de ancho</div>";
                    }
                    
                    #se guarda la imagen en la db
                    $datos['map_imagen_adjunta'] = $upload_dir.$nombre_grande;
        		}
            }
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            $datos['map_nombre'] = $this->input->post('nombre');
            $datos['map_url'] = slug($this->input->post('nombre'));
            $datos['map_estado'] = 1;
            
            if($codigo = $this->input->post('codigo'))
                $this->ws->actualizar($this->modulo,$datos,"map_codigo = $codigo");
            else
                $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
	}
}