$(function () {
    console.log('Cargando paises');
    $.ajax({
        method: "GET",
        url: "index.php?ctrl=CtrlPais&accion=getPaisesSelect",
        data: {}
    }).done(function (data) {
            $("#pais").html(data);
        });
    
    $("#pais").on('change', function () {
        $("#pais option:selected").each(function () {
            elegido = $(this).val();
            // alert("Selecionado: " + elegido);
            $.ajax({
                method: "GET",
                url: "index.php?ctrl=CtrlCiudad&accion=getCiudadesSelect",
                data: { id: elegido }
            })
        });
    });
        
});