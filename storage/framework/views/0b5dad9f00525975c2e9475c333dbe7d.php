<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link  rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="<?php echo e(route('home')); ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="home"  role="button">
          <i class="fas fa-home fa-fw"></i>
        </a>
      </li>

      <!-- Nav Item - Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
       <?php echo $__env->make('admin.notification.show', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
      </li>
      
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(Auth()->user()->name); ?></span>
          <?php if(Auth()->user()->photo): ?>
            <img class="img-profile rounded-circle" src="<?php echo e(Auth()->user()->photo); ?>">
          <?php else: ?>
            <img class="img-profile rounded-circle" src="<?php echo e(asset('admin_panel/img/avatar.png')); ?>">
          <?php endif; ?>
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <a class="dropdown-item" href="<?php echo e(route('password.change.view')); ?>">
            <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
            Change Password
          </a>
          <a class="dropdown-item" href="<?php echo e(route('settings')); ?>">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            Settings
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Logout</a>

            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </div>
      </li>

    </ul>

  </nav>
<?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>