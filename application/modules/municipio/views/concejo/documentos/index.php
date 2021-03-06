﻿<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1><?= $titulo; ?></h1>
    </div>

  	<div class="subtitulo-btn">
        <a class="btn btn-default" href="/municipio/concejo/documentos/agregar/<?= $tipo_documento->codigo; ?>/">Agregar</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-xs-5">Nombre</th>
				<th class="col-xs-2">Orden</th>
				<th class="col-xs-2">Descargar</th>
                <th colspan="2" class="text-center">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if($result){ ?>
                <?php foreach($result as $aux){ ?>
                    <tr>
                        <td><?php echo $aux->nombre; ?></td>
                        <td><?php echo $aux->orden; ?></td>
                        <td class="text-center">
                            <a href="<?php echo $aux->archivo; ?>"><span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>
                        </td>
						<td class="text-center">
                            <a href="/municipio/concejo/documentos/editar/<?php echo $seccion; ?>/<?php echo $aux->codigo; ?>/"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                        </td>
                        <td class="text-center">
							<a rel="<?php echo $aux->codigo; ?>" class="eliminar" style="cursor:pointer;">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</a>
                            <input type="hidden" id="tipodocumento" rel="<?= $tipo_documento->codigo; ?>" />
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