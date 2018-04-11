<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Calendario_general extends CI_Controller {
	    
	private $modulo = 35;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Calendario General');
		
        #js
        $this->layout->js('/js/sistema/portada/calendario/index.js');
        
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/portada/calendario/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->joinLeft(28,"calg_temporada = tec_codigo");
        $this->ws->joinLeft(29,"calg_categoria = cac_codigo");
        $this->ws->order(array("calg_fecha_inicio ASC","calg_hora_inicio ASC"));
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["calendario"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Calendario General" => '/'));
		
		#view
		$this->layout->view('calendario/index', $contenido);
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

            #subir imagen
            if($_FILES['imagen']['name']){
                
                $upload_dir = '/imagenes/modulos/portada/calendario/';
                creaDirectoriosUrl($upload_dir);
                
                $extension = array_pop(explode('.',$_FILES['imagen']['name']));
                $nombre_interna = slug($this->input->post('titulo')).time().'-interna.'.$extension;
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
                    
                    $configR['image_library'] = 'gd2';
                    $configR['source_image']	= $_SERVER['DOCUMENT_ROOT'].$upload_dir.$nombre_grande;
                    $configR['new_image']	= $_SERVER['DOCUMENT_ROOT'].$upload_dir.$nombre_interna;
                    $configR['maintain_ratio'] = TRUE;
                    $configR['master_dim'] = TRUE;
                    $configR['width'] = 540;
                    $this->load->library('image_lib', $configR); 
                    
                    #procesa la imagen
                    if(!$this->image_lib->resize())
                        #$this->image_lib->display_errors();
                        $error .= "<div>* Ha ocurrido un error al subir la imagen. Inténtelo nuevamente.</div>";
                        
                    else{
                        $datos['calg_imagen_adjunta'] = $upload_dir.$nombre_interna;
                        $datos['calg_imagen_adjunta_grande'] = $upload_dir.$nombre_grande;
                    }
        		}
            }
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            #si solo es en el dia la fecha de termino debe ser igual a la de inicio
            $fecha_termino = $this->input->post('fecha_termino');
            if($this->input->post('solo_este_dia'))
                $fecha_termino = $this->input->post('fecha_inicio');
            
            $datos['calg_titulo'] = $this->input->post('titulo');
            $datos['calg_resumen'] = $this->input->post('resumen');
            $datos['calg_descripcion'] = $this->input->post('descripcion');
            $datos['calg_fecha_inicio'] = ($this->input->post('fecha_inicio'))?formatearFecha($this->input->post('fecha_inicio')):'';
            $datos['calg_hora_inicio'] = $this->input->post('hora_inicio');
            $datos['calg_fecha_termino'] = ($fecha_termino)?formatearFecha($fecha_termino):'';
            $datos['calg_hora_termino'] = $this->input->post('hora_termino');
            $datos['calg_solo_este_dia'] = $this->input->post('solo_este_dia');
            $datos['calg_lugar'] = $this->input->post('lugar');
            $datos['calg_url'] = slug($this->input->post('titulo'));
            $datos['calg_temporada'] = $this->input->post('temporada');
            $datos['calg_categoria'] = $this->input->post('categoria');
            $datos['calg_estado'] = $this->input->post('estado');
            
            $this->ws->insertar($this->modulo,$datos);
            
            echo json_encode(array("result"=>true));
            
        }
        else{

    		#Title
    		$this->layout->title('Agregar Calendario');
    		
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js - Datepicker
            $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
            $this->layout->css('/js/jquery/datepicker/datepicker3.css');

            #js - Timepicker
            $this->layout->js('/js/jquery/bootstrap-timepicker/js/bootstrap-timepicker.js');
            
            #js
            $this->layout->js('/js/sistema/portada/calendario/agregar.js');
    		
            #contenido
            $contenido['temporadas'] = $this->ws->listar(28,"tec_estado = 1");
            $contenido['categorias'] = $this->ws->listar(29,"cac_estado = 1");
            
    		#Nav
    		$this->layout->nav(array("Calendario General" => '/portada/calendario/', "Agregar Calendario" => "/"));
    		
    		#view
    		$this->layout->view('calendario/agregar',$contenido);
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
            
            
            #subir imagen
            if($_FILES['imagen']['name']){
                $upload_dir = '/imagenes/modulos/portada/calendario/';
                creaDirectoriosUrl($upload_dir);
                
                $extension = array_pop(explode('.',$_FILES['imagen']['name']));
                $nombre_interna = slug($this->input->post('titulo')).time().'-interna.'.$extension;
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
                    
                    $configR['image_library'] = 'gd2';
                    $configR['source_image']	= $_SERVER['DOCUMENT_ROOT'].$upload_dir.$nombre_grande;
                    $configR['new_image']	= $_SERVER['DOCUMENT_ROOT'].$upload_dir.$nombre_interna;
                    $configR['maintain_ratio'] = FALSE;
                    $configR['master_dim'] = 'auto';
                    $configR['width'] = 540;
                    $this->load->library('image_lib', $configR); 
                    
                    #procesa la imagen
                    if(!$this->image_lib->resize())
                        #$this->image_lib->display_errors();
                        $error .= "<div>* Ha ocurrido un error al subir la imagen. Inténtelo nuevamente.</div>";
                        
                    else{
                        $datos['calg_imagen_adjunta'] = $upload_dir.$nombre_interna;
                        $datos['calg_imagen_adjunta_grande'] = $upload_dir.$nombre_grande;
                    }
        		}
            }
            
            if($error){
                echo json_encode(array("result"=>false,"msg"=>$error));
                exit;
            }
            
            #si solo es en el dia la fecha de termino debe ser igual a la de inicio
            $fecha_termino = $this->input->post('fecha_termino');
            if($this->input->post('solo_este_dia'))
                $fecha_termino = $this->input->post('fecha_inicio');
                
            $datos['calg_titulo'] = $this->input->post('titulo');
            $datos['calg_resumen'] = $this->input->post('resumen');
            $datos['calg_descripcion'] = $this->input->post('descripcion');
            $datos['calg_fecha_inicio'] = ($this->input->post('fecha_inicio'))?formatearFecha($this->input->post('fecha_inicio')):'';
            $datos['calg_hora_inicio'] = $this->input->post('hora_inicio');
            $datos['calg_fecha_termino'] = ($fecha_termino)?formatearFecha($fecha_termino):'';
            $datos['calg_hora_termino'] = $this->input->post('hora_termino');
            $datos['calg_solo_este_dia'] = $this->input->post('solo_este_dia');
            $datos['calg_lugar'] = $this->input->post('lugar');
            $datos['calg_url'] = slug($this->input->post('titulo'));
            $datos['calg_temporada'] = $this->input->post('temporada');
            $datos['calg_categoria'] = $this->input->post('categoria');
            $datos['calg_estado'] = $this->input->post('estado');

            $this->ws->actualizar($this->modulo,$datos,"calg_codigo = $codigo");
            
            
        
            echo json_encode(array("result"=>true));
            
        }
        else{
            
            #registro
            if($contenido['calendario'] = $calendario = $this->ws->obtener($this->modulo,"calg_codigo = '$codigo'"));
            else show_error('');
        
    		#Title
    		$this->layout->title('Editar Calendario');
    		
            #JS - Editor
    		$this->layout->js('/js/jquery/ckeditor-standard/ckeditor.js');
            
            #js - Datepicker
            $this->layout->js('/js/jquery/datepicker/bootstrap-datepicker.js');
            $this->layout->css('/js/jquery/datepicker/datepicker3.css');
            
            #js - Timepicker
            $this->layout->js('/js/jquery/bootstrap-timepicker/js/bootstrap-timepicker.js');
            
            #js
            $this->layout->js('/js/sistema/portada/calendario/editar.js');
    		
            #contenido
            $contenido['temporadas'] = $this->ws->listar(28,"tec_estado = 1");
            $contenido['categorias'] = $this->ws->listar(29,"cac_estado = 1");
            
    		#Nav
    		$this->layout->nav(array("Calendario General" => '/portada/calendario/', "Editar Calendario" => "/"));
    		
    		#view
    		$this->layout->view('calendario/editar',$contenido);
        }
	}
    
    public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "calg_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }
}