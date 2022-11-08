
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Imprimiendo Boleta</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-globe"></i> ABC S.A.
          <small class="float-right">BOLETA DE VENTA</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          Direccion: Calle Moquegua S/N<br>
          Ciudad/Pais: Moquegua / Perú<br>
          Phone: 053-465211<br>
          Email: abc.sa@gmail.com<br>
          RUC: 20123456787
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Para:
        <address>
          <strong><?=$data[0]['nombrecli'].' '.$data[0]['apellidocli']?></strong><br>
          Direccion: <?=$data[0]['direccion']?><br>
          Ciudad/Pais: <?=$data[0]['nombreciudad']?>/ <?=$data[0]['nombrepais']?><br>
          Phone:<br>
          Email: <?=$data[0]['email']?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Pedido #007612</b><br>
        <br>
        <b>Número Boleta: </b> <?=$data[0]['nro']?><br>
        <b>Fecha Emisión: </b> <?=$data[0]['fecha']?><br>
        <b>Monto: </b>S/ <?=number_format($data[0]['total'], 2, ',', ' ')?><br>
        <b>Condición: </b> Pago en efectivo
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Cant</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
        <?php 
            $suma=0;
            foreach ($data as $b) { ?>
            <tr>
                <td><?=$b['cantidad']?></td>
                <td>   
                    <b><?=$b['nombreprod']?></b><br>
                    <?=$b['descripcion']?>
                </td>
                <td>S/ <?=number_format($b['pu'], 2, ',', ' ')?></td>
                <td>S/ <?=number_format($b['cantidad']* $b['pu'], 2, ',', ' ')?></td>
            </tr>     

        <?php
            $suma += $b['cantidad']* $b['pu'];    
        }
        ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p>
            <b>Son: </b> <?=$data[0]['enLetras']?> Soles
        </p>
        <p class="lead">Gracias por su compra:</p>
        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
          ABC S.A. tiene los mejores productos a su servicio.
        <br>
          Regrese pronto.
        </p>
        <p class="lead">Fecha Impresión: <?=date('d/m/Y h:i:s A')?></p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>S/ <?=number_format($suma, 2, ',', ' ')?></td>
            </tr>
            <tr>
              <th>IGV (18 %)</th>
              <td>S/ <?=number_format($suma*0.18, 2, ',', ' ')?></td>
            </tr>
            
            <tr>
              <th>Total:</th>
              <td>S/ <?=number_format($data[0]['total'], 2, ',', ' ')?></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
