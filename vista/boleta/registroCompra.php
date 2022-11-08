<section class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
        <h2>Gracias por su compra</h2>
        <a href="?" class="btn btn-success">Retornar</a>
    </div>
    <div class="col-md-6">
        <h2>Se generó la Boleta</h2>
        <h4>
          <strong>Numero: </strong> <?=$data[0]['nro']?>
        </h4>
        
        <p><strong>Fecha: </strong> <?=$data[0]['fecha']?></p>
        <p><strong>Total: </strong> S/ <?=number_format($data[0]['total'], 2, ',', ' ');?></p>
        <br><hr><br>
        <a target="_blank" rel="noopener" href="?ctrl=CtrlBoleta&accion=imprimir&id=<?=$data[0]['idboleta']?>" class="btn btn-success">
        <i class="fas fa-print"></i> Imprimir Boleta</a>
    </div>
  </div>
</div>
</section>