<center>
    <div class="row content">
    <?php echo $this->load->view('tab'); ?>
    
        <div class="col-sm-10 text-left marg-fix">
          	<div class="titulo-btn">
                <h1>Editar contraseña</h1>           
            </div>
            
            <form action="#" method="post" id="form-perfil">
                <div class="row" style="margin-top:30px; margin-bottom:30px;">
                	<div class="col-md-4">
                    	<label>Contraseña actual</label>
                        <input type="password" class="form-control validate[required]" name="contrasena_a" />
                        
                        <label>Nueva contraseña</label>
                        <input type="password" class="form-control validate[required]" name="contrasena_n" id="contrasena_n" />
                        
                        <label>Repetir nueva contraseña</label>
                        <input type="password" class="form-control validate[required,equals[contrasena_n]]" name="repetir_contrasena_n" />
                        
                	</div>
                </div>
                
                <div class="text-right">
                    <button type="button" class="btn btn-can cancelar">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</center>