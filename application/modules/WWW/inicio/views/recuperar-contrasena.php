<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Aeurus Ltda.">
<meta http-equiv="Content-Language" content="es-ES">

<title>Recuperar Contraseña - Nevados de Chillán</title>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript" src="/js/jquery/validation-engine/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="/js/jquery/validation-engine/js/languages/jquery.validationEngine-es.js"></script>
<script type="text/javascript" src="/js/jquery/noty/packaged/jquery.noty.packaged.js"></script>

<script type="text/javascript" src="/js/sistema/index/recuperar-contrasena.js"></script>

<link href="/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/css/hoja-estilos.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css"  href="/js/jquery/validation-engine/css/validationEngine.jquery.css" />

<style>
	body { background:#fff; }
</style>
<div class="login-logo">
	<img src="/imagenes/template/logo.jpg" style="margin-left: -40px;" /> 
</div>

<h1 class="text-center">Recuperar Contraseña</h1>
<div class="login-box">
    <form action="#" method="post" class="form-horizontal" role="form" id="form-recuperar">
        <div class="form-group">
            <div class="col-sm-1 icon-login">
      		    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </div>
            <div class="col-sm-11">
                <input type="text" class="form-control validate[required,custom[email]]" name="email" placeholder="Ingrese su correo" />
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-login">Recuperar</button>
            </div>
        </div>
    </form>
</div>