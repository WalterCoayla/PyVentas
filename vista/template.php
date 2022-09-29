<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$titulo?></title>
    <?php echo Vista::mostrar('./plantilla/css.php',$datos,true); ?>
</head>
<body>
    <?php echo Vista::mostrar('./plantilla/nav.php',$datos,true); ?>
    <?php echo Vista::mostrar('./plantilla/aside.php',$datos,true); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo Vista::mostrar('./plantilla/wrapper.php',$datos,true); ?>
    <?php echo $contenido; ?>
  </div>
    <?php echo Vista::mostrar('./plantilla/footer.php',$datos,true); ?>
    <?php echo Vista::mostrar('./plantilla/js.php',$datos,true); ?>
</body>
</html>