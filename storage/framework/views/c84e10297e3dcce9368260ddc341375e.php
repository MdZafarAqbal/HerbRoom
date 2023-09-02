<!DOCTYPE html>
<html lang="en-us">
  <head>
		<?php echo $__env->make('main.layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
  </head>
  <body>
		<!-- Header -->
		<?php echo $__env->make('main.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<!-- End Header -->

    <?php echo $__env->make('layouts.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <section id="main-content">
		  <?php echo $__env->yieldContent('main-content'); ?>
    </section>

		<!-- Footer -->
		<?php echo $__env->make('main.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<!-- End Footer -->

		<!-- Scripts -->
		<script src="<?php echo e(asset('js/main/header.min.js')); ?>"></script>
		<script src="<?php echo e(asset('js/main/main.min.js')); ?>"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NH2TVFJYP0"></script>
    <script>function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","G-NH2TVFJYP0");</script>
		<?php echo $__env->yieldPushContent('scripts'); ?>
		<!-- End Scripts -->
  </body>
</html><?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/main/layouts/master.blade.php ENDPATH**/ ?>