$(function(){
    $(".eliminar_imagen").click(function(){
        var codigo = $(this).attr('rel');
        var contenedor = $(this).parent().parent().parent();
        var cont = $(this).parent().parent().attr('rel');

        $.ajax({
            type: "POST",
            data: "codigo="+codigo+"&tipo="+cont,
            dataType: "json",
            url: urlDelete,
            success: function(json){
                contenedor.remove();

                if(!galeria)
                    cargar_imagen(cont);
            }
        });
    });
});

function cargar_imagen(cargar = [1], data = []){
    console.log('cargar:'+cargar);
    var i;
    for(i=0; i < cargar.length; i++){
        var cont = cargar[i];

        var replica = $("#replicar-"+cont).clone();
        replica.attr('id','');
        replica.children().attr('id',"img"+id);
        replica.css('display','inline-block');
        $("#cont-imagenes-"+cont).prepend(replica);

        var rutas = '<input type="hidden" class="imagenes" name="ruta_grande_'+cont+'" id="img-grande-'+cont+'-'+id+'" >'+
            '<input type="hidden" name="ruta_interna_'+cont+'" id="img-interna-'+cont+'-'+id+'" >';

        $("#rutas-imagenes").append(rutas);
        var croppicContainerModalOptions = {
            uploadUrl: urlCargar,
            cropUrl: urlCortar,
            modal:true,
            outputUrlId:'img-interna-'+cont+'-'+id,
            outputUrlIdGr:'img-grande-'+cont+'-'+id,
            urlDelete:urlDelete,
            idContenedor: cont,
            uploadData: {"id": cont, "data": data},
            cropData: {"id": cont, "data": data},
            imgEyecandyOpacity:0.4,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>',
            onAfterImgUpload: function(){ },
            onAfterImgCrop: function(){},
        }
        var cropContainerModal = new Croppic('img'+id, croppicContainerModalOptions);
        id += 1;
    }
}

function cargar_imagenes(cargar = [1], data = []){

    var i;
    for(i=0; i < cargar.length; i++){
        var cont = cargar[i];

        var replica = $("#replicar-"+cont).clone();
        replica.attr('id','');
        replica.children().attr('id',"img"+id);
        replica.css('display','inline-block');
        $("#cont-imagenes-"+cont).prepend(replica);

        var rutas = '<input type="hidden" class="imagenes" name="ruta_grande_'+cont+'[]" id="img-grande-'+cont+'-'+id+'" >'+
            '<input type="hidden" name="ruta_interna_'+cont+'[]" id="img-interna-'+cont+'-'+id+'" >';

        $("#rutas-imagenes").append(rutas);
        var croppicContainerModalOptions = {
            uploadUrl: urlCargar,
            cropUrl: urlCortar,
            modal:true,
            outputUrlId:'img-interna-'+cont+'-'+id,
            outputUrlIdGr:'img-grande-'+cont+'-'+id,
            urlDelete:urlDelete,
            cargaContenedorDelete:false,
            idContenedor: cont,
            uploadData: {"id": cont, "data":data},
            cropData: {"id": cont, "data":data},
            imgEyecandyOpacity:0.4,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>',
            onAfterImgUpload: function(){ },
            onAfterImgCrop: function(){

                var carga = [];
                carga.push(cont);
                cargar_imagenes(carga);

            },
        }
        var cropContainerModal = new Croppic('img'+id, croppicContainerModalOptions);
        id += 1;
    }
}