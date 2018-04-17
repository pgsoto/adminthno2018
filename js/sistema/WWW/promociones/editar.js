$(document).ready(function () {
    
    //editor
    CKEDITOR.replace('descripcion');
    
    $("#form-editar").validationEngine('attach', {
        promptPosition:'topLeft',
		validationEventTrigger:false,
        showOneMessage:true,
        onValidationComplete: function (form, status) {
			if (status) {
        		noty({
        			text: 'Guardando registro. Por favor, espere un momento.',
        			layout: 'topCenter',
        			closeWith: [],
        			type: 'alert',
        			killer: true,
        			template: '<div class="noty_message"><img src="/imagenes/icons/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
        			fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
        		});
                
                $("#descripcion").val(CKEDITOR.instances['descripcion'].getData());
                var formData = new FormData(document.getElementById("form-editar"));
                
        		$.ajax({
        			url: '/promociones/editar/'+$("#codigo").val()+'/',
        			type: 'post',
        			dataType: 'html',
        			data: formData,
                    cache: false,
                    contentType: false,
	                processData: false,
        			success: function (result) {
                        var json = jQuery.parseJSON(result);
                        
        				if(json.result){
        				    
        					noty({
        						text: "Guardado con éxito",
        						layout: 'topCenter',
        						type: 'success',
        						killer: true
        					});
                            
        					setTimeout(function () {
        						window.location.href = '/promociones/';
        					}, 1000);
        				}else{
        				    
        					noty({
        						text: json.msg,
        						layout: 'topCenter',
        						type: 'error',
        						killer: true
        					});
        				}
        			}
        		});
        	}
        }
    });
    
    // agregar otro archivo
    $(".nuevo_archivo").click(function(){
       
       var archivo = $("#archivo-base").clone();
       archivo.show();
       archivo.attr('id','');
       $("#cont-archivos").append(archivo);
    });
    
    //eliminar archivos
    $("html").on('click','.eliminar_archivo',function(){
        $(".nuevo_archivo").click();
        $(this).parent().parent().remove();
        
        var codigo = $(this).attr('rel');
        if(codigo){
            $.ajax({
            	url: '/promociones/eliminar-archivo/',
            	type: 'post',
            	dataType: 'json',
            	data: 'codigo='+codigo,
            	success: function (result) {}
            });
        }
    });

});