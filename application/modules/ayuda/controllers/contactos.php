<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Contactos extends CI_Controller {
	    
	private $modulo = 60;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Contactos');
		
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/ayuda/contactos/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order(array("con_fecha DESC","con_hora DESC"));
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["contactos"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Contactos" => '/'));
		
		#view
		$this->layout->view('contactos/index', $contenido);
	}
    
    public function detalle($codigo){
        
        #registro
        $this->ws->joinInner(32,"con_asunto = asuc_codigo");
        if($contenido['contacto'] = $contacto = $this->ws->obtener($this->modulo,"con_codigo = '$codigo'"));
        else show_error('');
        
		#Title
		$this->layout->title('Detalle Contacto');
        
		#Nav
		$this->layout->nav(array("Contactos" => '/ayuda/contactos/', "Detalle Contacto" => "/"));
		
		#view
		$this->layout->view('contactos/detalle',$contenido);
        
	}
}