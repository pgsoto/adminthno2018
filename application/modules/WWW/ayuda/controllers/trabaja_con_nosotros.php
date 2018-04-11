<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Trabaja_con_nosotros extends CI_Controller {
	    
	private $modulo = 59;
    public $sitio_url = SITIO_URL;
    
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
        
		#Title
		$this->layout->title('Trabaja con Nosotros');
		
        $where = $and = "";
        $url = "";
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 3;
		$config['base_url'] = '/ayuda/trabaja-con-nosotros/';
		$config['per_page'] = 20;
		$config['total_rows'] = count($this->ws->listar($this->modulo,$where));
        $config['suffix'] = '/'.$url;
        $config['first_url'] = $config['base_url'].$url;
		$this->pagination->initialize($config);
        
        #obtiene el numero de pagina
		$pagina = ($this->uri->segment($config['uri_segment']))?$this->uri->segment($config['uri_segment'])-1:0;

		#contenido
        $this->ws->order(array("tcn_fecha DESC","tcn_hora DESC"));
        $this->ws->limit($config['per_page'], ($config['per_page'] * $pagina));
		$contenido["trabaja"] = $this->ws->listar($this->modulo,$where);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Trabaja con Nosotros" => '/'));
		
		#view
		$this->layout->view('trabaja_con_nosotros/index', $contenido);
	}
    
    public function detalle($codigo){
        
        #registro
        $this->ws->joinInner(33,"tcn_area_de_trabajo = art_codigo");
        if($contenido['trabaja'] = $trabaja = $this->ws->obtener($this->modulo,"tcn_codigo = '$codigo'"));
        else show_error('');
        
		#Title
		$this->layout->title('Detalle Trabaja con Nosotros');
        
		#Nav
		$this->layout->nav(array("Trabaja con Nosotros" => '/ayuda/trabaja-con-nosotros/', "Detalle Trabaja con Nosotros" => "/"));
		
		#view
		$this->layout->view('trabaja_con_nosotros/detalle',$contenido);
        
	}
    
    ### ARCHIVO ADJUNTO
    public function descargar_archivo($codigo){
        $archivo = $this->ws->obtener($this->modulo,"tcn_codigo = $codigo");
        
        $this->load->helper('download');
        $name = basename($archivo->archivo_adjunto);
        $data = file_get_contents($this->sitio_url.$archivo->archivo_adjunto);
        
        force_download($name, $data);
    }
}