<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(route('admin')); ?>">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="<?php echo e(route('admin')); ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Banner
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- Nav Item - Charts -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('file-manager')); ?>">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Media Manager</span></a>
    </li> -->
<!--Banner -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-image"></i>
        <span>Banners</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Banner Options:</h6>
          <a class="collapse-item" href="<?php echo e(route('banners.index')); ?>">Banners</a>
          <a class="collapse-item" href="<?php echo e(route('banners.create')); ?>">Add Banners</a>
        </div>
      </div>
    </li>
<!-- fixed Banner -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFixedBanner" aria-expanded="true" aria-controls="collapseFixedBanner">
        <i class="fas fa-image"></i>
        <span>Fixed Banners</span>
      </a>
      <div id="collapseFixedBanner" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Banner Options:</h6>
          <a class="collapse-item" href="<?php echo e(route('fixed-banners.index')); ?>">Fixed Banners</a>
          <a class="collapse-item" href="<?php echo e(route('fixed-banners.create')); ?>">Add Fixed Banners</a>
        </div>
      </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Shop
        </div>

    <!-- Categories -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse" aria-expanded="true" aria-controls="categoryCollapse">
        <i class="fas fa-sitemap"></i>
        <span>Category</span>
      </a>
      <div id="categoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Category Options:</h6>
          <a class="collapse-item" href="<?php echo e(route('categories.index')); ?>">Category</a>
          <a class="collapse-item" href="<?php echo e(route('categories.create')); ?>">Add Category</a>
        </div>
      </div>
    </li>
    <!-- SubCategories -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#subcategoryCollapse" aria-expanded="true" aria-controls="subcategoryCollapse">
        <i class="fas fa-sitemap"></i>
        <span>Subcategory</span>
      </a>
      <div id="subcategoryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Subcategory Options:</h6>
          <a class="collapse-item" href="<?php echo e(route('subcategories.index')); ?>">Subcategory</a>
          <a class="collapse-item" href="<?php echo e(route('subcategories.create')); ?>">Add Subcategory</a>
        </div>
      </div>
    </li>
    <!-- Form -->
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#formCollapse" aria-expanded="true" aria-controls="formCollapse">
          <i class="fas fa-cubes"></i>
          <span>Forms</span>
        </a>
        <div id="formCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Form Options:</h6>
            <a class="collapse-item" href="<?php echo e(route('forms.index')); ?>">Forms</a>
            <a class="collapse-item" href="<?php echo e(route('forms.create')); ?>">Add Form</a>
            
          </div>
        </div>
    </li>
    <!-- Product -->
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse" aria-expanded="true" aria-controls="productCollapse">
          <i class="fas fa-cubes"></i>
          <span>Products</span>
        </a>
        <div id="productCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Product Options:</h6>
            <a class="collapse-item" href="<?php echo e(route('products.index')); ?>">Products</a>
            <a class="collapse-item" href="<?php echo e(route('products.create')); ?>">Add Product</a>
            
          </div>
        </div>
    </li>

    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse" aria-expanded="true" aria-controls="brandCollapse">
          <i class="fas fa-table"></i>
          <span>Brands</span>
        </a>
        <div id="brandCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Brand Options:</h6>
            <a class="collapse-item" href="<?php echo e(route('brands.index')); ?>">Brands</a>
            <a class="collapse-item" href="<?php echo e(route('brands.create')); ?>">Add Brand</a>
          </div>
        </div>
    </li>

<!--Country -->
    
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#countryCollapse" aria-expanded="true" aria-controls="countryCollapse">
      <i class="fas fa-globe"></i>
        <span>Country</span>
      </a>
      <div id="countryCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Country Options:</h6>
          <a class="collapse-item" href="<?php echo e(route('countries.index')); ?>">Countries</a>
          <a class="collapse-item" href="<?php echo e(route('countries.create')); ?>">Add Countries</a>
        </div>
      </div>
    </li>
    <!-- City -->
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stateCollapse" aria-expanded="true" aria-controls="stateCollapse">
        <i class="fas fa-landmark"></i>
          <span>State</span>
        </a>
        <div id="stateCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">State Options:</h6>
            <a class="collapse-item" href="<?php echo e(route('states.index')); ?>">States</a>
            <a class="collapse-item" href="<?php echo e(route('states.create')); ?>">Add States</a>
          </div>
        </div>
    </li>
    <!-- City -->
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#cityCollapse" aria-expanded="true" aria-controls="cityCollapse">
          <i class="fas fa-city"></i>
          <span>City</span>
        </a>
        <div id="cityCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">City Options:</h6>
            <a class="collapse-item" href="<?php echo e(route('cities.index')); ?>">City</a>
            <a class="collapse-item" href="<?php echo e(route('cities.create')); ?>">Add City</a>
          </div>
        </div>
    </li>
    <!-- Coupon -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#couponCollapse" aria-expanded="true" aria-controls="couponCollapse">
            <i class="fas fa-coupons fa-folder"></i>
            <span>Coupon</span>
        </a>
        <div id="couponCollapse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Coupon Options:</h6>
            <a class="collapse-item" href="<?php echo e(route('coupons.index')); ?>">Coupon</a>
            <a class="collapse-item" href="<?php echo e(route('coupons.create')); ?>">Add Coupon</a>
            </div>
        </div>
    </li>
    <!--Orders -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('orders.index')); ?>">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Orders</span>
        </a>
    </li>
      
    <!-- Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('reviews.index')); ?>">
            <i class="fas fa-comments"></i>
            <span>Reviews</span></a>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider">

    
     <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>
    
     <!-- Users -->
     <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('users.index')); ?>">
            <i class="fas fa-users"></i>
            <span>Users</span></a>
    </li>
     <!-- General settings -->
     <li class="nav-item">
        <a class="nav-link" href="<?php echo e(route('settings')); ?>">
            <i class="fas fa-cog"></i>
            <span>Settings</span></a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul><?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>