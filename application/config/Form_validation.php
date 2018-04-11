<?php 
$config = array(
	'contacto' => array(
		array(
			'field'=>'nombres',
			'label'=>'Nombres',
			'rules'=>'required'
		),
		array(
			'field'=>'apellidos',
			'label'=>'Apellidos',
			'rules'=>'required'
		),
		// array(
			// 'field'=>'telefono',
			// 'label'=>'Teléfono',
			// 'rules'=>'required'
		// ),
		array(
			'field'=>'email',
			'label'=>'Email',
			'rules'=>'required|valid_email'
		),
		array(
			'field'=>'mensaje',
			'label'=>'Mensaje',
			'rules'=>'required'
		)
	),
	'login' => array(
		array(
			'field'=>'email',
			'label'=>'Email',
			'rules'=>'required|valid_email'
		),
		array(
			'field'=>'contrasena',
			'label'=>'Contraseña',
			'rules'=>'required'
		)
	)
);