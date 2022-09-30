
    
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=$titulo?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <?php 
                foreach ($migas as $key => $value) {
                  if($key!="#"){ ?>
                  <li class="breadcrumb-item"><a href="<?=$key?>"><?=$value?></a></li>
                <?php  }else{
                  ?>
                  <li class="breadcrumb-item"><?=$value?></li>
                <?php
                }
                  }
              ?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->