
<?php $__env->startSection('main-content'); ?>
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            <?php echo $__env->make('admin.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         </div>
     </div>
     <div class="card-body">
        <div class="row ">
            <div class="card-header py-3">
                <div class="card">
                    <div class="card-header">Import Product</div>
                    <div class="card-body">
                        <?php if(session('status')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(isset($errors) && $errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($error); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->has('failures')): ?>

                            <table class="table table-danger">
                                <tr>
                                    <th>Row</th>
                                    <th>Attribute</th>
                                    <th>Errors</th>
                                    <th>Value</th>
                                </tr>

                                <?php $__currentLoopData = session()->get('failures'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $validation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($validation->row()); ?></td>
                                        <td><?php echo e($validation->attribute()); ?></td>
                                        <td>
                                            <ul>
                                                <?php $__currentLoopData = $validation->errors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($e); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <?php echo e($validation->values()[$validation->attribute()]); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        <?php endif; ?>

                    <form action="<?php echo e(route('product-imports.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <input type="file" name="file" />
                                <button type="submit" class="btn btn-primary" style="margin-top:10px;">Import</button>
                            </div>
                    </form>                    
                </div>
            </div>
           
        </div>
    </div>  
</div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <?php if(count($products)>0): ?>
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th> PLU </th>
              <th>Name</th>
              <th>Promotion</th>              
              <th>Photo</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>S.N.</th>
              <th> PLU </th>
              <th>Name</th>
              <th>Promotion</th>              
              <th>Photo</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>

            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td><?php echo e($product->plu); ?></td>
                    <td><?php echo e($product->name); ?></td>                    
                    <td><?php echo e($product->promotion); ?></td> 
                               
                    <td>
                        <?php if($product->photo): ?>
                            <?php
                              $photo=explode(',',$product->photo);
                              // dd($photo);
                            ?>
                            <img src="<?php echo e($photo[0]); ?>" class="img-fluid zoom" style="max-width:80px" alt="<?php echo e($product->photo); ?>">
                        <?php else: ?>
                            <img src="<?php echo e(asset('admin_panel/img/thumbnail-default.jpg')); ?>" class="img-fluid" style="max-width:80px" alt="avatar.png">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($product->status=='active'): ?>
                            <span class="badge badge-success"><?php echo e($product->status); ?></span>
                        <?php else: ?>
                            <span class="badge badge-warning"><?php echo e($product->status); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('products.edit',$product->id)); ?>" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        
                        <form method="POST" action="<?php echo e(route('products.destroy',[$product->id])); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('delete'); ?>
                            <button class="btn btn-danger btn-sm dltBtn" data-id="<?php echo e($product->id); ?>" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>                        
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
        <?php echo $products->withQueryString()->links('pagination::bootstrap-5'); ?>

        <?php else: ?>
          <h6 class="text-center">No Products found!!! Please create Product</h6>
        <?php endif; ?>
      </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>

  <link href="<?php echo e(asset('admin_panel/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

  <!-- Page level plugins -->
  
  <script src="<?php echo e(asset('admin_panel/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin_panel/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo e(asset('admin_panel/js/demo/datatables-demo.js')); ?>"></script>
  <script>

$('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/admin/product/index.blade.php ENDPATH**/ ?>