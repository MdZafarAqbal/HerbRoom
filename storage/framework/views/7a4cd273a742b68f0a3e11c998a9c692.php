<!DOCTYPE html>
  <html lang="en-US">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">

    <title>Sign In || HerbalCare</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&family=Vollkorn:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- HerbalCare StyleSheet -->
    <link href="<?php echo e(asset('css/main/signin-up.min.css')); ?>" rel="stylesheet">
  </head>
  <body>
    <section class="shop-signing login-section">
      <div class="signing-img-container"></div>
      <div class="signing-form-container">
        <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('images/logo_green.png')); ?>" alt="HerbalCare Website Logo" class="signing-web-logo"></a>
        <h1 class="signing-web-title"><a href="<?php echo e(route('home')); ?>">HerbalCare</a></h1>
        <h2>Sign In</h2>

        <!-- Form -->
        <form class="form" method="post" action="<?php echo e(route('login')); ?>" novalidate>
          <?php echo csrf_field(); ?>

          <?php if($checkout): ?>
            <input type="hidden" name="checkout" value="true">
          <?php endif; ?>
          <div class="form-group">
            <div class="form-input">
              <input type="email" name="email" id="email" placeholder="someone@domain.com" value="<?php echo e(old('email')); ?>">
              <label for="email">Email</label>
            </div>

            <?php if($errors->has('email')): ?>
              <div class="error">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <?php echo e($message); ?>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
            <?php endif; ?>
          </div>
        
          <div class="form-group">
            <div class="form-input">
              <input type="password" name="password" id="password" placeholder="Enter Password" value="<?php echo e(old('password')); ?>">
              <label for="password">Password</label>
            </div>

            <?php if($errors->has('password')): ?>
              <div class="error">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <?php echo e($message); ?>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
            <?php endif; ?>
          </div>

          <div class="remember-checkbox">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember Me</label>
          </div>

          <div class="form-group submit-btn">
            <button class="btn signing-btn" type="submit">Login</button>
          </div>
        </form>    
        <p>Don't have an account? <a href="<?php echo e(route('register.view')); ?>" class="btn">Sign Up</a></p>
        <?php if(Route::has('reset.password')): ?>
          <p><a class="forgot-pass" href="<?php echo e(route('reset.password')); ?>">
            Forgot password?
          </a></p>
        <?php endif; ?>        
        <p>Goto <a href="<?php echo e(route('home')); ?>" class="btn">Homepage</a></p>
      </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <script src="<?php echo e(asset('js/main/login.min.js')); ?>"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NH2TVFJYP0"></script>
    <script>function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","G-NH2TVFJYP0");</script>
  </body>
</html>
<?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/auth/login.blade.php ENDPATH**/ ?>