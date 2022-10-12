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
        let url ='ctrl=CtrlCiudad$accion=nuevo';
        $("#modal-nuevo").load(url, function (response, status, xhr) {
            if (status == "error") {
                var msg = "Lo siento pero ocurrió un error: ";
                alert(msg + xhr.status + " " + xhr.statusText);
            }
        });
    });
});