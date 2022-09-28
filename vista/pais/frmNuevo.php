    <section class="content">
    <div class="container-fluid">
    <form action="?ctrl=CtrlPais&accion=guardarNuevo" method="post">
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="inputID" class="form-label">Id:</label>
            <input type="text" class="form-control"
                name="id" value="" id="inputID">
        </div>
        <div class="col-md-6">
            <label for="inputPais" class="form-label">Pais:</label>
            <input type="text" class="form-control"
                name="pais" value="" id="inputPais">
        </div>
        </div>
        <div class="col-md-3">
        <button type="submit" class="form-control btn btn-primary">
            <i class="bi bi-save2"></i> Guardar</button>
        </div>
    </form>
    <br><a href="?ctrl=CtrlPais" class="btn btn-primary">
        <i class="bi bi-arrow-90deg-left"></i>
        Retornar</a>
</div>
</section>