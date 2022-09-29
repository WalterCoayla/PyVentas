    <section class="content">
    <div class="container-fluid">
    <form action="?ctrl=CtrlCiudad&accion=guardarEditar" method="post">
        <div class="input-group mb-3">
            <span class="input-group-text">Id:</span>
            <input type="text" name="id" value="<?=$ciudad->getId()?>" 
                class="form-control">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Ciudad:</span>
            <input type="text" name="ciudad" value="<?=$ciudad->getNombre()?>" 
                class="form-control">
        </div>
        <div class="col-md-6">
            <label for="inputPais" class="form-label">Pais:</label>
            <select class="form-control" name="pais" id="pais">
                <?php 
                $paises= $ciudad->getPais()->leer()['data'];
                $pais = $ciudad->getPais()->getId();
                foreach ($paises as $p) {
                    if ($p["idpais"]==$pais) 
                            $seleccionado="selected";
                        else   
                            $seleccionado="";
                ?>
                <option <?=$seleccionado?>  value="<?=$p['idpais']?>"><?=$p['nombre']?></option>
                <?php } ?>

            </select>
            
        </div>
        <div class="col-md-3">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save2"></i> Guardar</button>
        </div>
    </form>
    <br><a href="?ctrl=CtrlCiudad" class="btn btn-primary">
        <i class="bi bi-arrow-90deg-left"></i>
        Retornar</a>
</div>
</section>
