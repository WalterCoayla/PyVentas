<section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
              <div class="col-12">
                <?php 
                    $imagen= (is_array($imagenes['data']))?$imagenes['data'][0]['url']:'SIN_IMAGEN.jpg' ;
                ?>
                <img src="recursos/images/catalogo/<?=$imagen?>" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                <?php 
                    if(is_array($imagenes['data']))
                    foreach ($imagenes['data'] as $img) { ?>
                <div class="product-image-thumb active"><img src="recursos/images/catalogo/<?=$img['url']?>" alt="Product Image"></div>           
                <?php 
                    }
                ?>    
             </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?=$data[0]['nombre']?></h3>
                <p><?=$data[0]['descripcion']?>
                </p>
                
              <hr>
              <h4>Marca: <?=$data[0]['marca']?></h4>
              <h4>Modelo: <?=$data[0]['modelo']?></h4>
              <hr>
              <h4>Colores disponibles</h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                  <input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
                  Verde
                  <br>
                  <i class="fas fa-circle fa-2x text-green"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a2" autocomplete="off">
                  Azul
                  <br>
                  <i class="fas fa-circle fa-2x text-blue"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a3" autocomplete="off">
                  Blanco
                  <br>
                  <i class="fas fa-circle fa-2x text-white"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a4" autocomplete="off">
                  Rojo
                  <br>
                  <i class="fas fa-circle fa-2x text-red"></i>
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_a5" autocomplete="off">
                  Naranja
                  <br>
                  <i class="fas fa-circle fa-2x text-orange"></i>
                </label>
              </div>

              <h4 class="mt-3">Tamaños <small>Por favor seleccione uno</small></h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                  <span class="text-xl">S</span>
                  <br>
                  Small
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b2" autocomplete="off">
                  <span class="text-xl">M</span>
                  <br>
                  Medium
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b3" autocomplete="off">
                  <span class="text-xl">L</span>
                  <br>
                  Large
                </label>
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b4" autocomplete="off">
                  <span class="text-xl">XL</span>
                  <br>
                  Xtra-Large
                </label>
              </div>

              <div class="row">
                <div class="col-md-6">
                    <div class="bg-gray py-2 px-3 mt-4">
                        <h2 class="mb-0">
                        S/ <?=number_format($data[0]['pu'], 2, ',', ' ')?>
                        </h2>
                        <h4 class="mt-0">
                        <small>Ex Tax: $80.00 </small>
                        </h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-gray py-2 px-3 mt-4">
                        <h2 class="mb-0">
                          <?= $data[0]['stock']?> Unidades disponibles
                        </h2>
                        
                    </div>
                </div>
              </div>

              <div class="mt-4">
                <div class="btn btn-primary btn-lg btn-flat">
                  <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  Agregar al carrito
                </div>

                <div class="btn btn-default btn-lg btn-flat">
                  <i class="fas fa-heart fa-lg mr-2"></i>
                  Añadir a favoritos
                </div>
              </div>

              <div class="mt-4 product-share">
                <a href="#" class="text-gray">
                  <i class="fab fa-facebook-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fab fa-twitter-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-envelope-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-rss-square fa-2x"></i>
                </a>
              </div>

            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->