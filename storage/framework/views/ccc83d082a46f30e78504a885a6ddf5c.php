
<?php $__env->startSection('title', 'HerbalCare - Botanical World of Herbs || Shop Herbs, Teas, Oils and Extracts'); ?>

<?php $__env->startPush('vendor_styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/vendor/exzoom.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/main/index.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/main/modal.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('vendor_scripts'); ?>
  <script src="<?php echo e(asset('js/vendor/exzoom.min.js')); ?>" defer></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('main-content'); ?>
  <?php
    $cats = Helper::categories();
  ?>
  <!-- <video src="<?php echo e(asset('images/bannert.mp4')); ?>" autoplay muted loop></video> -->

  <?php if($banners): ?>
    <section id="slider" class="slider">         
      <ul id="carousel-wrap" class="carousel-wrap">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                    
          <li>
            <picture>
              <source media="(min-width: 768px)" srcset="<?php echo e($banner->photo_desktop); ?>">
              <source media="(min-width: 480px)" srcset="<?php echo e($banner->photo_tablet); ?>">
              <img class="slide-img" src="<?php echo e($banner->photo_mobile); ?>" alt="Slider Image">
            </picture>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>

      <a href="#" id="slide-prev">&lt;</a>
      <a href="#" id="slide-next">&gt;</a>
    </section>
  <?php endif; ?>

  <section class="products-catalog">
    <?php
      $auth = Auth::check();
    ?>

    <?php if($pop_products->isNotEmpty()): ?>
      <div class="products">
        <h2 class="cat-title"> Popular Items </h2>
      
        <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false, "autoPlay": 3000}'>
          <?php $__currentLoopData = $pop_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price');            

              if($auth)
                $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
            ?>
            <div class="product-card <?php echo e($product->id); ?>-card carousel-cell">
              <img class="product-image" src="<?php echo e($product->photo); ?>" alt="product image">
              
              <div class="overlay">
                <button id="pop<?php echo e($product->id); ?>" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, <?php echo e($product->id); ?>)"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h4 class="card-product-title"><?php echo e($product->name); ?></h4>
                <?php if($minprice==$maxprice): ?>
                  <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span></p>
                <?php else: ?>
                  <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span> - AED <span class="value"><?php echo e(number_format($maxprice,2)); ?></span></p>
                <?php endif; ?>
              </div>
              <div class="prod-detail-link">
                <a href="<?php echo e(route('product.detail', $product->slug)); ?>" class="btn btn-submit detail-link"> Product Details </a>
                <?php if(auth()->guard()->check()): ?>
                  <?php if(count($wishlist) != 0): ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-solid fa-heart fav"></i></button>
                  <?php else: ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-regular fa-heart fav"></i></button>
                  <?php endif; ?>
                <?php else: ?>
                  <button class="btn favbtn" onclick="window.location.href = '/login'"><i class="fa-regular fa-heart fav"></i></button>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if($trn_products->isNotEmpty()): ?>
      <div class="products">
        <h2 class="cat-title"> Trending Items </h2>
      
        <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false, "autoPlay": 3000}'>
          <?php $__currentLoopData = $trn_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price'); 

              if($auth)
                $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
            ?>
            <div class="product-card <?php echo e($product->id); ?>-card carousel-cell">
              <img class="product-image" src="<?php echo e($product->photo); ?>" alt="product image">
              
              <div class="overlay">
                <button id="trn<?php echo e($product->id); ?>" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, <?php echo e($product->id); ?>)"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h4 class="card-product-title"><?php echo e($product->name); ?></h4>
              <?php if($minprice==$maxprice): ?>
                <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span></p>
              <?php else: ?>
                <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span> - AED <span class="value"><?php echo e(number_format($maxprice,2)); ?></span></p>
              <?php endif; ?>              </div>
              <div class="prod-detail-link">
                <a href="<?php echo e(route('product.detail', $product->slug)); ?>" class="btn btn-submit detail-link"> Product Details </a>
                
                <?php if(auth()->guard()->check()): ?>
                  <?php if(count($wishlist) != 0): ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-solid fa-heart fav"></i></button>
                  <?php else: ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-regular fa-heart fav"></i></button>
                  <?php endif; ?>
                <?php else: ?>
                  <button class="btn favbtn" onclick="window.location.href = 'user/login'"><i class="fa-regular fa-heart fav"></i></button>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if($new_products->isNotEmpty()): ?>
      <div class="products">
        <h2 class="cat-title"> New Items </h2>
      
        <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false, "autoPlay": 3000}'>
          <?php $__currentLoopData = $new_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $minprice = $product->attrs()->min('price');
              $maxprice = $product->attrs()->max('price'); 

              if($auth)
                $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
            ?>
            <div class="product-card <?php echo e($product->id); ?>-card carousel-cell">
              <img class="product-image" src="<?php echo e($product->photo); ?>" alt="product image">
              
              <div class="overlay">
                <button id="new<?php echo e($product->id); ?>" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, <?php echo e($product->id); ?>)"> 
                  <i class="fa-regular fa-eye"></i>
                  <p>Quick View</p>
                </button>
              </div>

              <div class="meta-detail">
                <h4 class="card-product-title"><?php echo e($product->name); ?></h4>
              <?php if($minprice==$maxprice): ?>
                <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span></p>
              <?php else: ?>
                <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span> - AED <span class="value"><?php echo e(number_format($maxprice,2)); ?></span></p>
              <?php endif; ?>              </div>
              <div class="prod-detail-link">
                <a href="<?php echo e(route('product.detail', $product->slug)); ?>" class="btn btn-submit detail-link"> Product Details </a>
                <?php if(auth()->guard()->check()): ?>
                  <?php if(count($wishlist) != 0): ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-solid fa-heart fav"></i></button>
                  <?php else: ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-regular fa-heart fav"></i></button>
                  <?php endif; ?>
                <?php else: ?>
                  <button class="btn favbtn" onclick="window.location.href = '/login';"><i class="fa-regular fa-heart fav"></i></button>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if($cats->isNotEmpty()): ?>
      <div class="fixed-banner-container">
        <?php
          $fixed_upper = $fixed_banners->where('name', 'upper')->first();
        ?>
        
        <picture>
          <source media="(min-width: 768px)" srcset="<?php echo e($fixed_upper->photo_desktop); ?>">
          <source media="(min-width: 480px)" srcset="<?php echo e($fixed_upper->photo_tablet); ?>">
          <img class="slide-img" src="<?php echo e($fixed_upper->photo_mobile); ?>" alt="Fixed Banner Image">
        </picture>
      </div>
      <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
          $product_cat = $cat->products()->where('status', 'active')->inRandomOrder()->limit(9)->get();
        ?>

        <?php if($product_cat->isNotEmpty()): ?>
          <div class="products">
            <h2 class="cat-title"> <?php echo e($cat->name); ?> </h2>
          
            <div class="product-slider carousel hero-slider"  data-flickity='{ "contain": true, "pageDots": false }'>
              <?php $__currentLoopData = $product_cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $minprice = $product->attrs()->min('price');
                $maxprice = $product->attrs()->max('price');

                if($auth)
                  $wishlist = $product->wishlists()->where('user_id', Auth::user()->id)->get();
              ?>
            <div class="product-card <?php echo e($product->id); ?>-card carousel-cell">
              <img class="product-image" src="<?php echo e($product->photo); ?>" alt="product image">
              
              <div class="overlay">
                <button id="cat<?php echo e($cat->id); ?>_<?php echo e($product->id); ?>" class="btn btn-quick-view" title="Quick View" onclick="showModal(id, <?php echo e($product->id); ?>)"> 
                  <i class="fa-regular fa-eye"></i>
                      <p>Quick View</p>
                    </button>
                  </div>

                  <div class="meta-detail">
                    <h4 class="card-product-title"><?php echo e($product->name); ?></h4>
                  <?php if($minprice==$maxprice): ?>
                    <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span></p>
                  <?php else: ?>
                    <p class="price">AED <span class="value"><?php echo e(number_format($minprice,2)); ?></span> - AED <span class="value"><?php echo e(number_format($maxprice,2)); ?></span></p>
                  <?php endif; ?>                  </div>
                  <div class="prod-detail-link">
                    <a href="<?php echo e(route('product.detail', $product->slug)); ?>" class="btn btn-submit detail-link"> Product Details </a>
                    <?php if(auth()->guard()->check()): ?>
                  <?php if(count($wishlist) != 0): ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-solid fa-heart fav"></i></button>
                  <?php else: ?>
                    <button class="btn favbtn" onclick="fav(this, <?php echo e($product->id); ?>)"><i class="fa-regular fa-heart fav"></i></button>
                  <?php endif; ?>
                <?php else: ?>
                  <button class="btn favbtn" onclick="window.location.href = '/login';"><i class="fa-regular fa-heart fav"></i></button>
                <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <div class="product-card <?php echo e($product->id); ?>-card carousel-cell link-card">
                <a href="<?php echo e(route('cat.products', $cat->slug)); ?>" class="view-link">View All</a>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="fixed-banner-container">
      <?php
        $fixed_lower = $fixed_banners->where('name', 'lower')->first();
      ?>

      <picture>
        <source media="(min-width: 768px)" srcset="<?php echo e($fixed_lower->photo_desktop); ?>">
        <source media="(min-width: 480px)" srcset="<?php echo e($fixed_lower->photo_tablet); ?>">
        <img class="slide-img" src="<?php echo e($fixed_lower->photo_mobile); ?>" alt="Fixed Banner Image">
      </picture>
    </div>

    <h2 class="center-title cat-title">Visit Our Stores</h2>

    <div class="store-carousel">
      <div class="store-card">
        <img class="store-img" src="<?php echo e(asset('images/satwa.jpg')); ?>" alt="store image">

        <div class="meta-detail">
          <h3 class="card-store-title">SATWA</h3>
        </div>
        <div class="learn-more-link">
          <a href="<?php echo e(route('contact')); ?>#satwa" class="btn btn-submit detail-link"> Learn More </a>
        </div>
      </div>
      <div class="store-card">
        <img class="store-img" src="<?php echo e(asset('images/meena-bazar.jpg')); ?>" alt="store image">

        <div class="meta-detail">
          <h3 class="card-store-title">MEENA BAZAAR</h3>
        </div>
        <div class="learn-more-link">
          <a href="<?php echo e(route('contact')); ?>#meena-bazaar" class="btn btn-submit detail-link"> Learn More </a>
        </div>
      </div>
      <div class="store-card">
        <img class="store-img" src="<?php echo e(asset('images/rolla.jpg')); ?>" alt="store image">

        <div class="meta-detail">
          <h3 class="card-store-title">ROLLA St.</h3>
        </div>
        <div class="learn-more-link">
          <a href="<?php echo e(route('contact')); ?>#rolla" class="btn btn-submit detail-link"> Learn More </a>
        </div>
      </div>
    </div>
    
    <div id="modal-container" class="modal-container"></div>
    <section id="checkout-popup" class="checkout-popup">
      <div id="location-popup" class="ch-popup" data-toggle="0">
        <button type="button" class="btn close close-inner" id="inner-close-btn" onclick="remInnerModal()">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <button id="page-loc-btn" class="btn btn-submit popup-btn loc-btn" onclick="remInnerModal()">Stay on Page</button>
        <?php if(auth()->guard()->check()): ?>
          <button id="chkt-loc-btn" class="btn btn-submit popup-btn loc-btn" onclick="location.href = '/checkout'">Checkout</button>
        <?php else: ?>
          <button id="chkt-loc-btn" class="btn btn-submit popup-btn loc-btn" onclick="chOptions()">Checkout</button>
          <button id="guest-chkt-btn" class="btn btn-submit popup-btn chkt-btn collapse" onclick="location.href = '/checkout'">Checkout as Guest</button>
          <button id="login-chkt-btn" class="btn btn-submit popup-btn chkt-btn collapse" onclick="location.href = '/login?checkout=1'">Login to Checkout</button>
        <?php endif; ?>
      </div>
    </section>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
  <script src="<?php echo e(asset('js/main/index.min.js')); ?>"></script>
  <script src="<?php echo e(asset('js/main/modal.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('main.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/main/index.blade.php ENDPATH**/ ?>