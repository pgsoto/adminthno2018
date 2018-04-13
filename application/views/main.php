<section id="header">
 <center> 
  <!-- [LOGO] -->
  <div class="row">
   <div class="col-md-8">
       <div id="logo">
           <?php if(isset($home_indicador)){ ?>
           <h1>Talcahuano</h1>
           <?php } else{ ?>
           <a href="/" title="Inicio: Tecla de Acceso 0" accesskey="0"><img src="/imagenes/template/logo.jpg" alt="Talcahuano" /></a>
           <?php } ?>
       </div>
   </div>
   <div class="col-md-2">
   </div>
   <div class="col-md-2">
   	<div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
      		<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
      		Usuario
      	    <span class="caret"></span>  
      </button>
      <ul class="dropdown-menu">
        <li><a href="/perfil/">Perfil</a></li>
        <li><a href="/logout/">Salir del sistema</a></li>
      </ul>
    </div>
   </div>
  </div>
  <!-- [MENU] -->
 </center>
</section>
