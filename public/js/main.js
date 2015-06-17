
function activar_producto(x)
{
    $.ajax({
        method: "POST",
        url: "/productos/activar",
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { id: x.dataset.id }
    })
        .success(function( msg ) {
            if(msg == true){
                console.log(msg);
                x.setAttribute('onclick','desactivar_producto(this)');
                x.innerHTML = "Desactivar";
                x.className = 'btn btn-danger';
                console.log(x);
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
            if(msg == true) {
                console.log(msg);
                x.setAttribute('onclick', 'activar_producto(this)');
                x.innerHTML = "Activar";
                x.className = 'btn btn-success';
                console.log(x);
            }

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
