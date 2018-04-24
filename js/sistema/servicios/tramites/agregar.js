$(function(){

    //agrega nuevo modelo
    $("#form-agregar").validationEngine('attach', {
        promptPosition:'topLeft',
        validationEventTrigger:false,
        showOneMessage:true,
        prettySelect:true,
        usePrefix:"selectBox_",
        onValidationComplete: function(form, status){
            if(status) {
                noty({
                    text: 'Creando registro. Por favor, espere un momento.',
                    layout: 'topCenter',
                    type: 'alert',
                    closeWith: [],
                    killer:true,
                    template: '<div class="noty_message"><img src="/imagenes/sitio/ajax-loader.gif">&nbsp;&nbsp;<span class="noty_text"></span><div class="noty_close"></div></div>',
                    fondo: '<div id="fondo" style=" position: fixed; top:0; height: 100%; width:100%; background-color: rgba(60, 56, 56, 0.38); display:block;z-index: 9999;"></div>'
                });

                $('#descripcion_iframe').html(CKEDITOR.instances.descripcion_iframe.getData());
                $('#descripcion_generico').html(CKEDITOR.instances.descripcion_generico.getData());
                
                var formData = new FormData(document.getElementById("form-agregar"));

                $.ajax({
                    url: '/servicios/tramites/process/',
                    type: 'post',
                    dataType: 'json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(json){
                        if(json.result){
                            noty({
                                text: "Registro creado con éxito.",
                                layout: 'topCenter',
                                type: 'success',
                                killer: true
                            });
                            setTimeout(function(){
                                if(json.codigo)
                                    window.location.href = '/servicios/tramites/';
                            }, 1000);
                        }
                        else
                        {
                            noty({
                                text: json.msg,
                                layout: 'topCenter',
                                type: 'error',
                                timeout: 3000,
                                killer: true
                            });
                        }
                    }
                });
            }
        }
    });

});