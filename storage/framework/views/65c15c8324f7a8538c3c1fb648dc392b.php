<?php if($message = session('success')): ?>
  <div class="flash-success flash-message">
    <p><?php echo e($message); ?></p>
  </div>
<?php endif; ?>
<?php if($message = session('error')): ?>
  <div class="flash-error flash-message">
    <p><?php echo e($message); ?></p>
  </div>
<?php endif; ?>
<?php if($message = session('warning')): ?>
  <div class="flash-warning flash-message">
    <p><?php echo e($message); ?></p>
  </div>
<?php endif; ?>
<?php if($message = session('info')): ?>
  <div class="flash-info flash-message">
    <p><?php echo e($message); ?></p>
  </div>
<?php endif; ?>
<?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/layouts/flash-message.blade.php ENDPATH**/ ?>