<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <a href="#" class="btn btn-primary nuevo">
                <i class="fa fa-plus-circle"></i> 
                Insertar Nuevo Pais
            </a>
        </div>
        <div class="col-md-6">
            <div class="text-right">
                <button id="imprimirPDF" class="btn btn-secondary">
                    <i class="fa fa-file-pdf"></i> 
                    Descargar PDF
                </button>
                <a href="?ctrl=CtrlPais&accion=reporte&app=excel" class="btn btn-secondary">
                    <i class="fa fa-file-excel"></i> 
                    Descargar XLS
                </a>
                <a href="?ctrl=CtrlPais&accion=reporte&app=word" class="btn btn-secondary">
                    <i class="fa fa-file-word"></i> 
                    Descargar DOC
                </a>
            </div>
        </div>
    </div>
    
    <br><br>
    <table id="tablaDatos" class="table table-head-fixed text-nowrap">
        <thead>
          <tr>
            <th>Id</th>
            <th>Pais</th>
            <th>Operaciones</th>
          </tr>  
        </thead>
        <tbody>
            <?php 
    if (is_array($data))
        foreach ($data as $c) { ?>
            <tr>
                <td><?=$c["idpais"]?></td>
                <td><?=$c["nombre"]?></td>
                <td>
                <a data-id="<?=$c["idpais"]?>" class="editar" href="#">
                    <i class="bi bi-pencil-square"></i> Editar </a>
                / 
                <a data-id="<?=$c["idpais"]?>" data-nombre="<?=$c["nombre"]?>" class="eliminar" href="#">
                    <i class="bi bi-trash"></i> Eliminar </a>
                </td>
            </tr>
        <?php }    ?>
        </tbody>
    </table>
    <br><a href="?" class="btn btn-primary">
        <i class="bi bi-arrow-90deg-left"></i>
        Retornar</a>
    </div>
</section>
<!-- Modal Formulario - Nuevo / Editar -->
<div class="modal fade" id="modal-form" role="dialog">
    <div class="modal-dialog">
 
     <!-- Modal content-->
     <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="body-form">
    
        </div>
        
     </div>
    </div>
</div>
<!-- Modal Eliminar -->
<div class="modal fade" id="modal-eliminar" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="frm-eliminar"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body-eliminar">
                <div class="text-center">
                    <h5>¿Estas seguro que deseas seguir con la eliminación?</h5>
                    <h5 class="reg-eliminacion">Registro: </h5>
                </div>
            </div>
            <div class="modal-footer justify-content-between">            
                <button type="button" class="btn btn-secundary" data-dismiss="modal">Cancelar</button>
                <a type="button" class="btn btn-danger" id="btn-confirmar" href="" data-id="">Eliminar</a>
            </div>
        </div>
    </div>
</div>
