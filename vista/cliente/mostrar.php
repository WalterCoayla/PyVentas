<!-- Main content -->
<section class="content">
    <div class="container-fluid">

    <a href="?ctrl=CtrlCliente&accion=nuevo" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> 
        Insertar Nuevo Cliente</a>
    <br><br>
    <table class="table table-head-fixed text-nowrap">
        <thead>
          <tr>
            <th>Id</th>
            <th>Cliente</th>
            <th>DNI</th>
            <th>Pais</th>
            <th>Ciudad</th>
            <th>Operaciones</th>
          </tr>  
        </thead>
        <tbody>
            <?php 
    if (is_array($data))
        foreach ($data as $c) { ?>
            <tr>
                <td><?=$c["idcliente"]?></td>
                <td><?=$c["nombrecliente"]?></td>
                <td><?=$c["dni"]?></td>
                <td><?=$c["pais"]?></td>
                <td><?=$c["ciudad"]?></td>
                <td>
                <a href="?ctrl=CtrlCliente&accion=editar&id=<?=$c["idcliente"]?>">
                    <i class="bi bi-pencil-square"></i> Editar </a>
                / 
                <a href="?ctrl=CtrlCliente&accion=eliminar&id=<?=$c["idcliente"]?>">
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