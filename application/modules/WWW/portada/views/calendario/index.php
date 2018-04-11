<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Calendario</h1>
    </div>
    
  	<div class="subtitulo-btn">
    	<h2>&nbsp;</h2>
        <a class="btn btn-default" href="/portada/calendario/agregar/">Agregar calendario</a>
    </div>
  
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-xs-5">Título</th>
                <th class="col-xs-2">Fecha inicio</th>
                <th class="col-xs-2">Fecha término</th>
                <th class="col-xs-2">Lugar</th>
                <th class="col-xs-3">Categoría</th>
                <th class="col-xs-3">Temporada</th>
				<th class="col-xs-2">Estado</th>
                <th colspan="2" class="text-center">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if($calendario){ ?>
                <?php foreach($calendario as $aux){ ?>
                    <tr> 
                        <td><?php echo $aux->titulo; ?></td>
                        <td><?php echo date('d/m/Y',strtotime($aux->fecha_inicio)); ?></td>
                        <td><?php echo date('d/m/Y',strtotime($aux->fecha_termino)); ?></td>
                        <td><?php echo $aux->lugar; ?></td>
                        <td><?php echo $aux->categorias_calendario->nombre; ?></td>
                        <td><?php echo $aux->temporadas_calendario->nombre; ?></td>
                        <td><?php echo ($aux->estado)?'Activo':'Inactivo'; ?></td>
						<td class="text-center">
                            <a href="/portada/calendario/editar/<?php echo $aux->codigo; ?>/"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
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
                    <td colspan="9" style="text-align: center;"><i>No hay registros</i></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php echo $pagination; ?>
</div>