<div class="col-sm-10 text-left marg-fix">
  	<div class="titulo-btn">
        <h1><?= $titulo; ?></h1>
    </div>

    <form action="#" method="post" id="form-agregar" enctype="multipart/form-data">
        <div class="row" style="margin-top:30px; margin-bottom:30px;">
        	<div class="col-md-5">
                <label>Nombre (*) </label>
                <input type="text" class="form-control validate[required]" name="nombre" value="<?= isset($result->nombre) ? $result->nombre : ''; ?>" />

            	<label>Archivo (*) </label>
                <input type="file" class="form-control validate[required]" name="archivo"  />
                <?php if(isset($result->archivo)){ ?>
                    <p><a href="<?php echo $result->archivo; ?>" target="_blank">Descargar archivo</a></p>
                <?php } ?>

                <label>Orden</label>
                <input type="number" min="0" class="form-control validate[numeric]" name="orden" value="<?= isset($result->orden) ? $result->orden : ''; ?>" />

                <?php /*
                <label>Estado</label>
				<select class="form-control validate[required]" name="estado">
                    <option <?= (isset($result->estado) && $result->estado == 1) ? 'selected' : ''; ?> value="1">Activo</option>
                    <option <?= (isset($result->estado) && $result->estado == 0) ? 'selected' : ''; ?> value="0">Inactivo</option>
				</select>
                */ ?>

        	</div>

            <input type="hidden" id="tipodocumento" name="tipodocumento" value="<?= $tipo_documento->codigo; ?>" />

            <input type="hidden" id="codigo" name="codigo" value="<?= isset($result->codigo) ? $result->codigo : ''; ?>" />

			<div class="col-xs-12">
				<div class="text-left" style="margin-top:20px;">
					<a href="/municipio/concejo/documentos/<?= $tipo_documento->codigo; ?>/" class="btn btn-can">Cancelar</a>
					<button type="submit" class="btn btn-primary">Guardar</button>
                </div>
			</div>
        </div>
    </form>
</div>