
function activar_producto(x)
{
    $.ajax({
        method: "POST",
        url: "/productos/activar",
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { id: x.dataset.id }
    })
        .success(function( msg ) {
            console.log(msg);
            if(msg == true){
                this.attr('onclick','desactivar_producto('+ x.dataset.id+')');
                this.cdd
            }
        });

}

function desactivar_producto(x)
{
    $.ajax({
        method: "POST",
        url: "/productos/desactivar",
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { id: x.dataset.id }
    })
        .success(function( msg ) {
            console.log(msg);
            
        });

}

function activar_descuento($id)
{
    $.ajax({
        method: "POST",
        url: "/descuento/activar",
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { id: $id }
    })
        .success(function( msg ) {
            console.log(msg);
            location.reload();
        });

}

function desactivar_descuento($id)
{
    $.ajax({
        method: "POST",
        url: "/descuento/desactivar",
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { id: $id }
    })
        .success(function( msg ) {
            console.log(msg);
            location.reload();
        });

}

$('.fecha-picker').datepicker({
    language: "es"
});

$(function(){
    $("#productos-tabla").tablesorter();
});

$("#margen").keyup(function(){

    precio_margen = parseInt($("#precio_neto").val())*((parseInt($("#margen").val())/100)+1);
    if(precio_margen!=0 && !isNaN(precio_margen) && precio_margen!="")
    {
        precio_margen_iva = Math.round(precio_margen*1.19);

        if(precio_margen_iva!=0 && !isNaN(precio_margen_iva) && precio_margen_iva!="")
        {
            $("#precio_venta").val(precio_margen_iva);
        }
    }

});

$('.alerta').fadeOut(3000);
