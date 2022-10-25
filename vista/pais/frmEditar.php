<section class="content">
    <div class="container-fluid">
        <form action="?ctrl=CtrlPais&accion=guardarEditar" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text">Id:</span>
                <input type="text" name="id" value="<?=$pais->getId()?>" 
                    class="form-control">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text">Pais:</span>
                <input type="text" name="pais" value="<?=$pais->getNombre()?>" 
                    class="form-control">
            </div>
            <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Guardar
                    </button>
            </div>
            
        </form>
    </div>
</section>
