<!-- Main content -->
<section class="content">
    <div class="container-fluid">

    <a href="?ctrl=CtrlPais&accion=nuevo" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> 
        Insertar Nuevo Pais</a>
    <br><br>
    <table class="table table-head-fixed text-nowrap">
        <tr>
            <th>Id</th>
            <th>Pais</th>
            <th>Operaciones</th>
        </tr>
    <?php 
    if (is_array($data))
        foreach ($data as $c) { ?>
            <tr>
                <td><?=$c["idpais"]?></td>
                <td><?=$c["nombre"]?></td>
                <td>
                <a href="?ctrl=CtrlPais&accion=editar&id=<?=$c["idpais"]?>">
                    <i class="bi bi-pencil-square"></i> Editar </a>
                / 
                <a href="?ctrl=CtrlPais&accion=eliminar&id=<?=$c["idpais"]?>">
                    <i class="bi bi-trash"></i> Eliminar </a>
                </td>
            </tr>
        <?php }    ?>
    </table>
    <br><a href="?" class="btn btn-primary">
        <i class="bi bi-arrow-90deg-left"></i>
        Retornar</a>
    </div>
</section>