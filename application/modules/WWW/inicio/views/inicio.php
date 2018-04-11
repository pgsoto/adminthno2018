<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Aeurus Ltda.">
<meta http-equiv="Content-Language" content="es-ES">

<title>Login - Nevados de Chillán</title>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript" src="/js/jquery/validation-engine/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="/js/jquery/validation-engine/js/languages/jquery.validationEngine-es.js"></script>
<script type="text/javascript" src="/js/jquery/noty/packaged/jquery.noty.packaged.js"></script>

<script type="text/javascript" src="/js/sistema/index/login.js"></script>

<link href="/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/css/hoja-estilos.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css"  href="/js/jquery/validation-engine/css/validationEngine.jquery.css" />

<style>
	body { background:#fff; }
</style>
<div class="login-logo">
	<img src="/imagenes/template/logo.jpg" style="margin-left: -40px;" /> 
</div>

<h1 class="text-center">Bienvenido</h1>
<div class="login-box">
    <form action="#" method="post" class="form-horizontal" role="form" id="form-login">
        <div class="form-group">
            <div class="col-sm-1 icon-login">
      		    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </div>
            <div class="col-sm-11">
                <input type="text" class="form-control validate[required,custom[email]]" name="email" placeholder="Ingrese su correo" />
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-1 icon-login">
      		    <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
            </div>
            <div class="col-sm-11">
                <input type="password" class="form-control validate[required]" name="contrasena" placeholder="Ingrese su contrase&ntilde;a" />
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-login">Ingresar</button>
            </div>
            <div class="col-sm-12">
                <a href="/recuperar-contrasena/"><button type="button" class="btn btn-cancel btn-login">Recuperar Contraseña</button></a>
            </div>
        </div>
    </form>
</div>