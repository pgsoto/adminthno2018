<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Imagen extends CI_Model{
    
    private $img;
    
	function __construct(){
		parent::__construct();
	}
    
    public function config($config){
        
        #obtiene el ID del contenedor
        $id = $config->id;
        
        #define el tamaño del contenedor en la vista
        $this->img->min_ancho = $config->{'min_ancho_'.$id};
        $this->img->min_alto = $config->{'min_alto_'.$id};
        
        #define el tamaño de la imagen grande
        $this->img->max_ancho = $config->{'max_ancho_'.$id};
        $this->img->max_alto = $config->{'max_alto_'.$id};
        
        #define el tamaño del recorte
        $this->img->recorte_ancho = $config->{'recorte_ancho_'.$id};
        $this->img->recorte_alto = $config->{'recorte_alto_'.$id};
        
        #si el tamaño maximo es distinto al tamaño minimo se define una diferencia de corte
        $this->img->razon = $this->img->recorte_ancho / $this->img->min_ancho;
        
        #directorio donde se guardan las imagenes
        $this->upload_dir = $config->upload_dir;
    }
    
    public function cargar_imagen($_FILES){

		if($_FILES['img']['name'] != ''){
			
            $imagen = $_FILES['img'];
            if(!$imagen['error']){
                
    			$extension = strtolower((array_pop(explode(".",$imagen['name']))));
                $foto_name = 'grande_'.time().'.'.$extension;
    			$permitidas = array("jpg","png","jpeg"); #extensiones permitidas
                
    			list($ancho,$alto) = getimagesize($imagen['tmp_name']);
    			if(in_array($extension,$permitidas))
    			{
    				if($ancho >= $this->img->recorte_ancho && $alto >= $this->img->recorte_alto){
                        
                        #crea el directorio para subir imagen
                        $uploads_dir = $_SERVER['DOCUMENT_ROOT'].$this->upload_dir;
                        creaDirectoriosUrl($this->upload_dir);
                        
                        #sube la imagen al servidor
                        if(!move_uploaded_file($imagen['tmp_name'], $uploads_dir.$foto_name))
                            $response = array("status"=>'error',"message"=>'<b>Ha ocurrido un error al subir la imagen. Inténtelo nuevamente.</b>');
                        else{
                            
                            #si las medidas maximas son menores que las medidas de la imagen se ajusta
                            if($ancho > $this->img->max_ancho || $alto > $this->img->max_alto){
                                $config['image_library'] = 'gd2';
                                $config['source_image']	= $uploads_dir.$foto_name;
                                $config['maintain_ratio'] = TRUE;
                                $config['master_dim'] = 'auto';
                                $config['quality'] = 100;
                                $config['width'] = $this->img->max_ancho;
                                $config['height'] = $this->img->max_alto;
                                
                                $this->load->library('image_lib', $config); 
                                
                                #procesa la imagen
                                if(!$this->image_lib->resize())
                                {
                                    $this->image_lib->display_errors();
                                }
                            }
                            
                            #retorna los datos de la imagen
                            list($ancho, $alto, $t, $a) = getimagesize($uploads_dir.$foto_name);
        					$response = array(
        						"status" => 'success',
        						"url" => $this->upload_dir.$foto_name,
        						"width" => $ancho,
        						"height" => $alto
        					);
                        }
    				}
    				else{
    					$response = array("status"=>'error',"message"=>'<b>La imagen debe tener un tamaño minimo de '.$this->img->recorte_ancho.' x '.$this->img->recorte_alto.'px. </b>');
    				}
    			}
    			else{
    				$response = array("status"=>'error',"message"=>'<b>La imagen debe ser jpg, jpeg o png.</b>');
    			}
            }
            else{
                $response = array("status"=>'error',"message"=>'<b>Ha ocurrido un error inesperado. Inténtelo nuevamente.</b>');
            }
		}
		else
			$response = array("status"=>'error',"message"=>'<b>Debe cargar una imagen. </b>');
		
		return $response;
	}
	
	public function cortar_imagen($_POST){

		#IMAGEN TAMAÑO INTERNA
		$ruta_grande = $imgUrl = $_POST['imgUrl'];
        
        #obtiene la ruta donde se caga la imagen
		$uploads_dir = explode('/',$imgUrl);
        unset($uploads_dir[count($uploads_dir)-1]);
        $uploads_dir = implode('/',$uploads_dir);

        #obtiene la extension
        $extension = array_pop(explode('.',$imgUrl));
        
		// original sizes
		$imgInitW = $_POST['imgInitW'];
		$imgInitH = $_POST['imgInitH'];
		
		// resized sizes
		$imgW = $_POST['imgW'] * $this->img->razon;
		$imgH = $_POST['imgH'] * $this->img->razon;
		
		// offsets
		$imgY1 = $_POST['imgY1'] * $this->img->razon;
		$imgX1 = $_POST['imgX1'] * $this->img->razon;
        
		// crop box
		$cropW = $_POST['cropW'] * $this->img->razon;
		$cropH = $_POST['cropH'] * $this->img->razon;
		
		// rotation angle
		$angle = $_POST['rotation'];
		$jpeg_quality = 100;
		$output_filename = $uploads_dir.'/interna_'.time().'.'.$extension;

		$imgUrl = $_SERVER['DOCUMENT_ROOT'].$imgUrl;
		$what = getimagesize($imgUrl);

		switch(strtolower($what['mime']))
		{
			case 'image/png':
				$img_r = imagecreatefrompng($imgUrl);
				$source_image = imagecreatefrompng($imgUrl);
				break;
			case 'image/jpeg':
				$img_r = imagecreatefromjpeg($imgUrl);
				$source_image = imagecreatefromjpeg($imgUrl);
				break;
			case 'image/gif':
				$img_r = imagecreatefromgif($imgUrl);
				$source_image = imagecreatefromgif($imgUrl);
				break;
			default: die('Tipo de imagen no soportado');
		}

		$resizedImage = imagecreatetruecolor($imgW, $imgH);
		imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
		$rotated_image = imagerotate($resizedImage, -$angle, 0);
		$rotated_width = imagesx($rotated_image);
		$rotated_height = imagesy($rotated_image);
		$dx = $rotated_width - $imgW;
		$dy = $rotated_height - $imgH;
		$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
		imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
		imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
		$final_image = imagecreatetruecolor($cropW, $cropH);
		imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
		imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
		imagejpeg($final_image, $_SERVER['DOCUMENT_ROOT'].$output_filename, $jpeg_quality);
		$ruta_interna = $output_filename;
        
		$response = Array("status"=>'success',"url"=>$ruta_interna, "ruta_grande"=>$ruta_grande);
		return $response;
	}
}