<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    private $obj;
    private $layout_view;
    private $title = '';
    private $titleDefault = 'Administración';
    private $css_list = array(), $js_list = array();
	private $metas = '';
	private $navegacion = array();
	public $current = '';

    function Layout() {
	
		#obj
        $this->obj =& get_instance();
        $this->layout_view = "layout/default.php";
        
        #si no esta en las siguientes urls valida los permisos a la seccion
        /*$url_sin_validar = array('/','/login/','/logout/','/recuperar-contrasena/','/perfil/','/perfil/guardar/');
        if(!in_array($_SERVER['REQUEST_URI'],$url_sin_validar)){
            #$this->valida_seccion();
        }*/
		
		#css
		$this->css('/css/bootstrap.css');
		$this->css('/css/hoja-estilos.css');
		
		#js
		$this->js('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
		
        #js
		$this->js('/js/boostrap/bootstrap.min.js');
        
        #validador
        $this->css('/js/jquery/validation-engine/css/validationEngine.jquery.css');
        $this->js('/js/jquery/validation-engine/js/jquery.validationEngine.js');
        $this->js('/js/jquery/validation-engine/js/languages/jquery.validationEngine-es.js');
		
		#notificaciones
		$this->js('/js/jquery/noty/packaged/jquery.noty.packaged.js');
		$this->js('/js/jquery/ckfinder/ckfinder.js');
        
        #JS - Multiple select boxes
		$this->css('/js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->js('/js/jquery/bootstrap-multi-select/js/bootstrap-select.js');
		
        #layout
        if(isset($this->obj->layout_view))
			$this->layout_view = $this->obj->layout_view;
		
    }

    function view($view, $data = null, $return = false) {
        
        #listado de hoteles para el menu
        #$this->obj->ws->order("ho_orden ASC");
        #$data['menu_hoteles'] = $this->obj->ws->listar(14,"ho_estado = 1");
        
		#render template
        $data['content_for_layout'] = $this->obj->load->view($view, $data, true);
		
        #template
        $this->block_replace = true;
        $output = $this->obj->load->view($this->layout_view, $data, $return);
		
        return $output;
    }

    /**
     * Agregar title a la pagina actual
     *
     * @param $title
     */
    function title($title) {
        $this->title = $title.' - '.$this->titleDefault;
    }
	
	function getTitle(){
        return $this->title;
	}

    /**
     * Agregar Javascript a la pagina actual
     * @param $item
     */
    function js($item){
        $this->js_list[] = $item;
    }
	
	function getJs(){
		$js = '';
		if($this->js_list){
			foreach ($this->js_list as $aux){
				$js .= '<script type="text/javascript" src="'.$aux.'"></script>
		';
			}
		}
		return $js;
    }

    /**
     * Agregar CSS a la pagina actual
     * @param $item
     */
    function css($item){
        $this->css_list[] = $item;
    }
	
	function getCss(){
		$css = '';
		if($this->css_list){
			foreach ($this->css_list as $aux){
				$css .= '<link rel="stylesheet" type="text/css"  href="'.$aux.'" />
		';
			}
		}
		return $css;
    }
	
	/**
     * Agregar Metas a la pagina actual
     * @param $name, $content
     */
    function setMeta($name,$content) {
        $meta->name = $name;
        $meta->content = $content;
		$this->metas[] = $meta;
    }
	
	function headMeta() {
		$metas = '';
		if($this->metas){
			foreach($this->metas as $aux){
				$metas .= '<meta name="'.$aux->name.'" content="'.$aux->content.'" />
		';
			}
		}
        return $metas;
    }
	
	/**
     * Agregar Navegacion a la pagina actual
     * @param $nav
     */
    function nav($nav) {
		$this->navegacion = $nav;
    }
	
	function getNav() {
		$html = '';
		if($this->navegacion){
			$html = '<nav id="navigation"><center>Usted está en: <a href="/">Inicio</a>';
			$i = 1;
			$ruta_master = '/';
			
			$html .= ' &gt; ';
			foreach($this->navegacion as $nombre=>$ruta)
			{
				$html .= ($i==count($this->navegacion))? '<span>'.$nombre.'</span>':'<a href="' . $ruta . '">'.$nombre.'</a> &gt; ';
				$i++;
			}
			
			$html .='</center></nav>';
		}
		return $html;
	}
    /*
    function valida_seccion(){
        
        #si no esta logeado
        if(!$this->obj->session->userdata('usuario_admin'))
            redirect('/');
        
        $usuario = $this->obj->session->userdata('usuario_admin');
        $this->obj->ws->joinInner(62,"adms_seccion = seu_codigo");
        $secciones = $this->obj->ws->listar(63,"adms_administrador = {$usuario->codigo}");
        
        #si no tiene secciones se deslogea
        if(!$secciones){
            $this->obj->session->unset_userdata('usuario_admin');
            redirect('/');
        }
        
        #obtiene la url actual
        $url_actual = $_SERVER['REQUEST_URI'];
        
        #revisa si tiene permisos para la url actual
        $permisos = false;
        foreach($secciones as $aux){
            if($aux->seccion == 1) #permisos
                $permisos = true;
            elseif(strpos($url_actual.'/',$aux->secciones_usuario->url) !== false)
                $permisos = true;
        }
        
        #si no tiene permisos redirecciona
        if(!$permisos){
            redirect($secciones[0]->secciones_usuario->url);
        }
    }*/
	
}