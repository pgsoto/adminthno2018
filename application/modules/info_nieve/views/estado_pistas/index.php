<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Estados de Pistas</h1>
    </div>
    
  	<div class="subtitulo-btn">
    	<h2>&nbsp;</h2>
        <a class="btn btn-default" href="/info-nieve/estado-pistas/agregar/">Agregar estado de pista</a>
    </div>
  
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-xs-5">Nombre Pista</th>
                <th class="col-xs-5">Dificultad</th>
                <th class="col-xs-2">Estado de Pista</th>
				<th class="col-xs-2">Orden</th>
                <th colspan="2" class="text-center">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if($estados){ ?>
                <?php foreach($estados as $aux){ ?>
                    <tr> 
                        <td><?php echo $aux->nombre; ?></td>
                        <td><?php echo $aux->dificultad; ?></td>
                        <td><?php echo ($aux->estado_pista)?'Abierta':'Cerrada'; ?></td>
                        <td><?php echo $aux->orden; ?></td>
						<td class="text-center">
                            <a href="/info-nieve/estado-pistas/editar/<?php echo $aux->codigo; ?>/"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td class="text-center">
							<a rel="<?php echo $aux->codigo; ?>" class="eliminar" style="cursor:pointer;">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</a>
						</td>
                    </tr>
                <?php } ?>
            <?php } else{ ?>
                <tr>
                    <td colspan="5" style="text-align: center;"><i>No hay registros</i></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php echo $pagination; ?>
</div>