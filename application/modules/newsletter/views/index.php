<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1>Newsletter</h1>
    </div>

    <div class="subtitulo-btn">
    	<h2>&nbsp;</h2>
        <a class="btn btn-default" href="/newsletter/exportar">Exportar a excel</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-xs-5">Código</th>
                <th class="col-xs-5">Nombre</th>
				<th class="col-xs-2">Email</th>
                <th class="col-xs-2">Intereses</th>
                <th colspan="2" class="text-center">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if($newsletters){ ?>
                <?php foreach($newsletters as $aux){ ?>
                    <tr> 
                        <td><?=$aux->codigo; ?></td>
                        <td><?=$aux->nombre; ?></td>
                        <td><?= $aux->email ?></td>
                        <td><?= $aux->intereses ?></td>
                        <td class="text-center">
							<a rel="<?php echo $aux->codigo; ?>" class="eliminar" style="cursor:pointer;">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</a>
						</td>
						<td class="text-center">
                            <a href="/newsletter/detalle/<?php echo $aux->codigo; ?>/"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
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