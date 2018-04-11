<?php

class Email extends CI_Model
{
    public function __construct(){

    }

    public function enviar($contacto, $cuerpo = false){
        $this->contacto = $contacto;
        $this->empresa = $contacto->empresa;
        if(!$cuerpo)
            $this->generar_cuerpo();
		else
			$this->cuerpo = $cuerpo;
        return $this->envio();
    }

    public function envio()
    {

        $this->email->from($this->contacto->email, utf8_decode($this->contacto->nombres));
        $this->email->to($this->empresa->email_formulario);

       	if(trim($this->empresa->email_copia_formulario)!='')
            $this->email->cc($this->empresa->email_copia_formulario);

        $asunto = (isset($this->contacto->asunto))?$this->contacto->asunto:'Contacto';
        $asunto = utf8_decode($asunto." desde la administración de Zona Mascota [".date('d/m/y')." ".date('H:i:s')."]");
        $this->email->subject($asunto);
        $this->email->message(utf8_decode($this->cuerpo));
		if(isset($this->contacto->ruta_adjunto))
			$this->email->attach($this->contacto->ruta_adjunto);
        return $this->email->send();

    }

    public function recuperar_contrasena($email,$contrasena)
    {
        $this->email->from('envio@nevados.cl', utf8_decode('Nevados de Chillán'));
        $this->email->to($email);

        $cuerpo = 'Se ha recibido una solicitud para recuperar su contraseña de la administración de Nevados de Chillán.<br />
                    Su nueva contraseña es: <b>'.$contrasena.'</b><br /><br />
                    Por motivos de seguridad se le recomienda cambiar su contraseña una vez que haya ingresado al sistema.';
        $asunto = utf8_decode("Recuperar contraseña desde la administración de Nevados de Chillán [".date('d/m/y')." ".date('H:i:s')."]");
        $this->email->subject($asunto);
        $this->email->message(utf8_decode($cuerpo));
        return $this->email->send();

    }
}