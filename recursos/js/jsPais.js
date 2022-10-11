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
        $("#ciudad").html('<option>Cargando...</option>');
        $("#pais option:selected").each(function () {
            elegido = $(this).val();
            $.ajax({
                method: "GET",
                url: "index.php?ctrl=CtrlCiudad&accion=getCiudadesSelect",
                data: { id: elegido }
            }).done(function (data) {
                $("#ciudad").html(data);
            }).fail(function () {
                $("#ciudad").html('<option>Error!!</option>');
            });
        });
    });
    
    $("#nuevo").click(function (e) { 
        e.preventDefault();
        $("#modal-nuevo").load("ctrl=CtrlCiudad$accion=nuevo", function (response, status, xhr) {
            if (status == "error") {
                var msg = "Lo siento pero ocurrió un error: ";
                alert(msg + xhr.status + " " + xhr.statusText);
            }
        });   
    });

    
});