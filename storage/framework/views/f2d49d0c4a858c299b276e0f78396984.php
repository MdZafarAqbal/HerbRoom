<!-- Meta Tag -->
<?php echo $__env->yieldContent('meta'); ?>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<meta name="description" content="">

<!-- Title Tag  -->
<title><?php echo $__env->yieldContent('title'); ?></title>

<!-- Favicon -->
<link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">

<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

<!-- Vendor StyleSheets -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Box Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css">

  <!-- Flickity -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/3.0.0/flickity.min.css">

  <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
  <script src="https://unpkg.com/flickity@2.3.0/dist/flickity.pkgd.min.js" async></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.2/jquery.typeahead.min.js"></script>

  <?php echo $__env->yieldPushContent('vendor_styles'); ?>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&family=Vollkorn:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap">

<!-- HerbalCare StyleSheets -->
<link href="<?php echo e(asset('css/main/main.min.css')); ?>" rel="stylesheet">
<?php echo $__env->yieldPushContent('styles'); ?>
<link href="<?php echo e(asset('css/main/header.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/main/footer.min.css')); ?>" rel="stylesheet">

<!-- Vendor Scripts -->
<?php echo $__env->yieldPushContent('vendor_scripts'); ?>
<?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/main/layouts/head.blade.php ENDPATH**/ ?>