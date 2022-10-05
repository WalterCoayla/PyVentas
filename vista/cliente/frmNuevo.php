    <section class="content">
    <div class="container-fluid">
    <form action="?ctrl=CtrlCliente&accion=guardarNuevo" method="post">
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="inputID" class="form-label">Id:</label>
            <input type="text" class="form-control"
                name="id" value="" id="inputID">
        </div>
        <div class="col-md-6">
            <label for="inputCiudad" class="form-label">Nombre:</label>
            <input type="text" class="form-control"
                name="nombre" value="" id="inputCiudad">
        </div>
        <div class="col-md-6">
            <label for="inputID" class="form-label">Apellido:</label>
            <input type="text" class="form-control"
                name="apellido" value="" id="inputID">
        </div>
        <div class="col-md-6">
            <label for="inputCiudad" class="form-label">DNI:</label>
            <input type="text" class="form-control"
                name="dni" value="" id="inputCiudad">
        </div>
        
        <div class="col-md-6">
            <label for="inputPais" class="form-label">Pais:</label>
            <select class="form-control" name="pais" id="pais">
                <option value="0">Seleccionar</option>

            </select>
            
        </div>
        <div class="col-md-6">
            <label for="inputPais" class="form-label">Cidad:</label>
            <select class="form-control" name="ciudad" id="pais">
                <option value="0">Seleccionar</option>

            </select>
            
        </div>
        </div>
        <div class="col-md-3">
        <button type="submit" class="form-control btn btn-primary">
            <i class="bi bi-save2"></i> Guardar</button>
        </div>
    </form>
    <br><a href="?ctrl=CtrlCliente" class="btn btn-primary">
        <i class="bi bi-arrow-90deg-left"></i>
        Retornar</a>
</div>
</section>

<script>
    $(function () {
        console.log('Cargando paises');
        $.ajax({
            method: "GET",
            url: "index.php?ctrl=CtrlPais&accion=getPaisesSelect",
            data: { }
        })
            .done(function (data) {
                $("#pais").html(data);
            });


    });
</script>