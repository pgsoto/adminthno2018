<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Newsletter extends CI_Controller {
	    
	private $modulo = 64;
    public $img;
    
	function __construct(){
		parent::__construct();
        
        //$this->img->upload_dir = '/imagenes/modulos/invierno/slider/';
        
        #lib imagenes
        //$this->load->model('inicio/imagen','objImagen');
	}
	
	public function index(){
        
		#Title
		$this->layout->title('NewsLetter');
		
        #js
        $this->layout->js('/js/sistema/newsletter/index.js');
        $url = "";
        /*$where = $and = "";
        
        
        $where = "sli_tipo_seccion = 9";
        $and = " and ";*/
        
        if(count($_GET) > 0)
            $url = '?'.http_build_query($_GET, '', "&");
        
		$config['uri_segment'] = 2;
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
		$contenido["newsletters"] = $this->ws->listar($this->modulo);
        $contenido['pagination'] = $this->pagination->create_links();
        
		#Nav
		$this->layout->nav(array("Newsletter" => '/'));
		
		#view
		$this->layout->view('index', $contenido);
	}
	
	public function detalle($codigo){
        
        #Newsletters
        if($contenido['newsletter'] = $newsletter = $this->ws->obtener($this->modulo,"new_codigo = $codigo"));
        else show_error('');
        
		#Title
		$this->layout->title('Detalle Newsletter');
        
		#Nav
		$this->layout->nav(array("Newsletters" => '/newsletter/', "Detalle Newsletter" => "/"));
		
		#view
		$this->layout->view('detalle',$contenido);
        
	}

	public function eliminar() {
		try {
			$this->ws->eliminar($this->modulo, "new_codigo = {$this->input->post('codigo')}");
			echo json_encode(array("result" => true));
		} catch (Exception $e) {
			echo json_encode(array("result" => false, "msg" => "Ha ocurrido un error inesperado. Por favor, int�ntelo nuevamente."));
		}
    }

	public function exportar(){

		require APPPATH."libraries/PHPExcel/PHPExcel.php";

		$news = $this->ws->listar($this->modulo);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
		getProperties()
		->setCreator("Aeurus.cl")
		->setLastModifiedBy("Aeurus.cl")
		->setTitle("Excel Newsletter")
		->setSubject("Excel Newsletter")
		->setDescription("Excel Newsletter")
		->setKeywords("Newsletter")
		->setCategory("Newsletter");


		$styleArray = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '000000'),
				),
			),
			'font'    => array(
				'bold'      => true,
				'italic'    => false,
				'strike'    => false,
			),
			'alignment' => array(
				'wrap'       => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'b0c47c')
			),
		);

		$styleArraInfo = array(
			'font'    => array(
				'bold'      => false,
				'italic'    => false,
				'strike'    => false,
				'size' => 10
			),
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '000000'),
				),
			),
			'alignment' => array(
				'wrap'       => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
		);


		$styleFont = array(
			'font'    => array(
				'bold'      => true,
				'italic'    => false,
				'strike'    => false,
			),
			'alignment' => array(
				'wrap'       => true,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('1:3')->applyFromArray($styleFont);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


		$i=1;

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, 'Nombre');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($styleArray);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, 'Correo');
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, 'Intereses');
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($styleArray);
		

		$i++;

		//carga de datos

		foreach($news as  $n){

			if(($n->nombre)){ $nombre = $n->nombre; }else{ $nombre = '';}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i,$nombre);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($styleArraInfo);

			if(($n->email)){ $email = $n->email; }else{ $email = '';}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $email );
			$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArraInfo);

			if(($n->intereses)){ $intereses = $n->intereses; }else{ $intereses = '';}
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $intereses );
			$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($styleArraInfo);
			
			$i++;

		}


		$objPHPExcel->getActiveSheet()->setTitle("EXCEL NEWSLETTER");

		$objPHPExcel->setActiveSheetIndex(0);


		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Newsletter - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');

		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        ob_end_clean();
		$objWriter->save('php://output');
		exit;

	}
}