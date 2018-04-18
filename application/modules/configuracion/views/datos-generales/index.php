<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Datos generales</h1>
    </div>
    
    <form action="#" method="post" id="form-agregar" >
        <?php /*
        <!-- metadatos -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            
            <div class="col-md-5">
                <h3>Metadatos</h3>
                
            	<label>Título de Página</label>
                <input type="text" class="form-control" name="metadato_titulo" value="<?php echo ($datos)?$datos->metadato_titulo:''; ?>" />
                
                <label>Descripción</label>
                <textarea class="form-control" name="metadato_descripcion" rows="3"><?php echo ($datos)?$datos->metadato_descripcion:''; ?></textarea>
                
                <label>Palabras Claves</label>
                <textarea class="form-control" name="metadato_keywords" rows="3"><?php echo ($datos)?$datos->metadato_keywords:''; ?></textarea>
        	</div>
       	</div>
 */ ?>
        
        <!-- oficina concepcion -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <h3>Información municipal</h3>

                <label>Nombre (*)</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo ($datos)?$datos->nombre:''; ?>" />

                <label>Dirección</label>
                <input type="text" class="form-control" name="direccion" value="<?php echo ($datos)?$datos->direccion:''; ?>" />

                <label>Mesa Central</label>
                <input type="text" class="form-control" name="mesa_central" value="<?php echo ($datos)?$datos->mesa_central:''; ?>" />
                
            	<label>CATOE 1</label>
                <input type="text" class="form-control" name="telefono_1" value="<?php echo ($datos)?$datos->telefono_1:''; ?>" />

                <label>CATOE 2</label>
                <input type="text" class="form-control" name="telefono_2" value="<?php echo ($datos)?$datos->telefono_2:''; ?>" />
                
                <label>Email</label>
                <input type="text" class="form-control validate[custom[email]]" name="email" value="<?php echo ($datos)?$datos->email:''; ?>" />
            </div>
        </div>
            
        <!-- redes sociales -->
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
            <div class="col-md-5">
                <h3>Redes Sociales</h3>
                
            	<label>Facebook</label>
                <input type="text" class="form-control" name="facebook" value="<?php echo ($datos)?$datos->facebook:''; ?>" />
                
                <label>Twitter</label>
                <input type="text" class="form-control" name="twitter" value="<?php echo ($datos)?$datos->twitter:''; ?>" />

                <label>Instagram</label>
                <input type="text" class="form-control" name="instagram" value="<?php echo ($datos)?$datos->instagram:''; ?>" />
             
             </div>
            
            <input type="hidden" name="codigo" value="<?php echo ($datos)?$datos->codigo:''; ?>" />
            
			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>