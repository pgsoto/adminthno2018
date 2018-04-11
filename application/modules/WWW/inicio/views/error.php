<div class="col-sm-10">
	<div class="row" style="margin-bottom: 15px;">
    	<div class="col-sm-12">
    		<a  style="cursor:pointer;" onClick="history.go(-1);" class="btn btn-primary btn-lg"><i class="icon-arrow-left" style=" margin-right:5px;"></i> << Volver</a>
    	</div>
	</div>  

	<div class="row">
		<div class="col-sm-12">
			<h1>Ha ocurrido un error inesperado</h1>
		</div>
	</div>
	
	<?php if(isset($error)){ ?>
		<div class="row">
			<div class="col-sm-12">
				<h4><?php echo $error; ?></h4>
			</div>
		</div>
	<?php } ?>
</div>  