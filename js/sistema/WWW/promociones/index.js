$(function(){
    
    $(".eliminar").click(function(e){
		
		e.preventDefault();
		var codigo = $(this).attr('rel');
        var url_hotel = $("#url_hotel").val();
        
		noty({
		layout: 'topCenter',
		fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>',
		  text: '¿Está seguro que desea eliminar este registro?',
		  buttons: [
			{addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty) {
				$noty.close();
				$(window).unbind('beforeunload');
				
				noty({
					text: 'El registro está siendo eliminado. Por favor, espere un momento.',
					layout: 'topCenter',
					type: 'alert',
					killer:true,
					closeWith: [],
					template: '<div class="noty_message"><img src="/imagenes/sitio/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
					fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
				});
				
				$.ajax({
					type: "POST",
					data: "codigo="+codigo,
					dataType: "json",
					url: '/promociones/eliminar/',
					success: function(json){
						if(json.result){
							noty({
								text: "El registro ha sido eliminado con éxito.",
								layout: 'topCenter',
								type: 'success',
								killer: true
							});

                            setTimeout(function(){
                                window.location.href = '/promociones/';
                            }, 1000);
						} 
						else
						{
							var error = noty({
								text: json.msg,
								layout: 'topCenter',
								type: 'error',
								timeout: 2000
							});
						}
					}
				});
			  }
			},
			{addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty) {
				$noty.close();
			  }
			}
		  ]
		});
		
	});
	
});