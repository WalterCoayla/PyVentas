
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      <div class="alert alert-warning alert-dismissible fade <?php echo ($msg==''?'':'show')?>" role="alert">
        <strong>Mensaje: </strong> <?=$msg?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=$titulo?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php 
                foreach ($migas as $key => $value) {
                ?>
              <li class="breadcrumb-item"><a href="<?=$key?>"><?=$value?></a></li>

              <?php  }
              ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->