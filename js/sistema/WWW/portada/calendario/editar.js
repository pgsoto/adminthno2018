$(document).ready(function () {

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
        			url: '/portada/calendario/editar/'+$("#codigo").val()+'/',
        			type: 'post',
        			dataType: 'html',
        			data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
        			success: function (result){
                        var json = jQuery.parseJSON(result);
        				if(json.result){
        				    
        					noty({
        						text: "Guardado con éxito",
        						layout: 'topCenter',
        						type: 'success',
        						killer: true
        					});
                            
        					setTimeout(function () {
        						window.location.href = '/portada/calendario/';
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
    
    //editor
    CKEDITOR.replace('descripcion');
    
    //timepicker
    $('.timepicker').timepicker({
        minuteStep: 1,
        showMeridian: false,
        defaultTime: false
    });
    
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format:"dd/mm/yyyy"
    });
    
    //deja la fecha de termino igual a la de inicio
    $("#solo_este_dia").change(function(){
        var inicio = $("#fecha_inicio").val();
            if($(this).is(':checked')){
            if(inicio == ""){
                noty({
    				text: 'Debe indicar una fecha de inicio',
    				layout: 'topCenter',
    				type: 'error',
    				killer: true
    			});
                
                return false;
            }
            
            $("#fecha_termino").val(inicio);
            $("#fecha_termino").attr('disabled',true);
        }
        else{
            $("#fecha_termino").val('');
            $("#fecha_termino").attr('disabled',false);
        }
    });
    
    $("#fecha_inicio").change(function(){
       $("#solo_este_dia").change();
    });

});
