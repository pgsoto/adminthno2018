<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Cafeterías</h1>
    </div>
    
  	<div class="subtitulo-btn">
    	<h2>&nbsp;</h2>
        <a class="btn btn-default" href="/invierno/cafeterias/agregar/">Agregar cafetería</a>
    </div>
  
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-xs-5">Título</th>
				<th class="col-xs-2">Orden</th>
				<th class="col-xs-2">Estado</th>
                <th colspan="2" class="text-center">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if($cafeterias){ ?>
                <?php foreach($cafeterias as $aux){ ?>
                    <tr> 
                        <td><?php echo $aux->nombre; ?></td>
                        <td><?php echo $aux->orden; ?></td>
                        <td><?php echo ($aux->estado)?'Activo':'Inactivo'; ?></td>
						<td class="text-center">
                            <a href="/invierno/cafeterias/editar/<?php echo $aux->codigo; ?>/"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
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
                    <td colspan="4" style="text-align: center;"><i>No hay registros</i></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php echo $pagination; ?>
</div>