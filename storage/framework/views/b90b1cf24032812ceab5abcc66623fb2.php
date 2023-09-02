

<?php $__env->startSection('main-content'); ?>

<div class="card">
  <h5 class="card-header">Edit Product</h5>
  <div class="card-body">
    <form method="post" id="main" action="<?php echo e(route('products.update',$product->id)); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?> 
      <?php echo method_field('PATCH'); ?>
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Plu Code <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="plu" placeholder="Enter Plu"  value="<?php echo e($product->plu); ?>" class="form-control">
        <?php $__errorArgs = ['plu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Name <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter Name"  value="<?php echo e($product->name); ?>" class="form-control">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
        
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Scientific Name/ Boltical Name </label>
        <input id="inputTitle" type="text" name="sci_name" placeholder="Enter Scientific Name"  value="<?php echo e($product->sci_name); ?>" class="form-control">
        <?php $__errorArgs = ['sci_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label for="other_name" class="col-form-label">Other name </label>
        <textarea id="other_name" name="other_name" placeholder="Enter Other Name"  value="<?php echo e($product->other_name); ?>" class="form-control"><?php echo e($product->other_name); ?></textarea>
        <?php $__errorArgs = ['other_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label for="benefit" class="col-form-label">Benefit</label>
        <textarea class="form-control" id="benefits" name="benefits" value="<?php echo e($product->benefits); ?>"><?php echo e($product->benefits); ?></textarea>
        <?php $__errorArgs = ['benefits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>     
      <div class="form-group">
        <label for="description" class="col-form-label">Description</label>
        <textarea class="form-control" id="description" name="description" value="<?php echo e($product->description); ?>"><?php echo e($product->description); ?></textarea>
        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label for="packaging_details" class="col-form-label">Packaging Details</label>
        <textarea class="form-control" id="packaging_details" name="packaging_details" value="<?php echo e($product->packaging_details); ?>"><?php echo e($product->packaging_details); ?></textarea>
        <?php $__errorArgs = ['packaging_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label for="precautions" class="col-form-label">Precautions</label>
        <textarea class="form-control" id="precautions" name="precautions" value="<?php echo e($product->precautions); ?>"><?php echo e($product->precautions); ?></textarea>
        <?php $__errorArgs = ['precautions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <?php
        $coupons = DB::table('coupons')->where('effect','product')->orderBy('id','DESC')->get();
      ?>
      <div class="form-group">
        <label for="coupon_id">Coupon</label>
         
        <div class="coupon">
          <select name="coupon_id" id="coupon_id" class="form-control">
            <?php if($product->coupon): ?>
              <option value=""><?php echo e($product->coupon->code); ?></option>
            <?php endif; ?>
            <option value="">--Select Coupon --</option>           
            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($coupon->id); ?>"><?php echo e($coupon->code); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>             
          </select>
        </div>         
      </div>
      <div class="form-group">
        <div id="category">
          <label for="category_id">Category</label>
          
          <select name="cat_id" id="category_id" class="form-control category_id">
            <option value="">--Select category--</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>          
          <div class="form-group d-none child_cat_div" id="child_cat_div">
            <label for="child_cat_id">Sub Category</label>
            <select name="subcat_id" id="child_cat_id" class="form-control child_cat_id">
              <option value="">--Select any category--</option>
              
            </select>               
          </div>
          <a href="javascript:void(0);" class="category_button" title="Add field">Add</a><br> 
        </div>
        <input type="hidden" id="cat_count" name="cat_count" value="">
        <input type="hidden" id="subcat_count" name="subcat_count" value="">          
      </div>
      <div class="modal-shopping-list" id="modal-shopping-list">
        <table class="table table-bordered" id="catgory-dataTable" width="100%" cellspacing="0">
          <h6>Category and SubCategory List</h6>
          <thead>
            <tr style="border:1px">
              <!-- <th id="cat-id">Id</th> -->
              <th id="cat-name" scope="col">Category</th>
              <th scope="col">SubCategory</th>
              <!--<th scope="col">Action</th>-->
            </tr>
          </thead>
          <tbody>           
            <?php $__currentLoopData = $product->cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <tr id="<?php echo e($proCat->id); ?>-tr">
              <!-- <td class="td-cat-title"><?php echo e($proCat->id); ?></td> -->
                <td class="td-cat-title"><?php echo e($proCat->name); ?></td>               
                <td>
                  <?php $__currentLoopData = $product->subcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proSubcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($proCat->id == $proSubcat->parent_id): ?> 
                      <?php echo e($proSubcat->name); ?>

                    <?php endif; ?> 
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </td>
                <!--<td>-->
                <!--  <button type="button" onclick="proCatDlt(<?=$product->id?>,<?=$proCat->id?>)"><i class="fas fa-trash-alt"></i></button>-->
                <!--</td>           -->
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div> 
      <div class="form-group">
        <label for="brand_id">Brand</label>
               
        <div class="brand">
          <select name="brand_id" id="brand_id" class="form-control">
            <option value="">--Select Brand--</option>
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($brand->id); ?>" <?php echo e((($product->brand_id==$brand->id)? 'selected':'')); ?>><?php echo e($brand->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
          <a href="javascript:void(0);" class="brand_button" title="Add field">Add</a><br>
        </div>         
        <input type="hidden" id="brand_count" name="brand_count" value="">
      </div>
      <div class="modal-shopping-list" id="modal-shopping-list">
        <table class="table table-bordered" id="brand-dataTable" width="100%" cellspacing="0">
          <h6>Brand List</h6>
          <thead>
            <tr>
              <th>Id</th>
              <th>Brand Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $product['brands']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro_brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="<?php echo e($pro_brand->id); ?>-tr">
              <td><?php echo e($pro_brand->id); ?></td>
              <td calss="td-brand-title"><?php echo e($pro_brand->name); ?></td> 
              <td>
                <button type="button" onclick="proBrandDlt(<?=$product->id?>,<?=$pro_brand->id?>)"><i class="fas fa-trash-alt"></i></button>
              </td>             
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
      <div class="form-group">
        <label for="promotion">promotion</label>
        <select name="promotion" class="form-control">
          
          <option value="popular" <?php echo e((($product->promotion=='popular')? 'selected':'')); ?>>Popular</option>
          <option value="new" <?php echo e((($product->promotion=='new')? 'selected':'')); ?>>New</option>
          <option value="trending" <?php echo e((($product->promotion=='trending')? 'selected':'')); ?>>Trending</option>
        </select>
      </div>
      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
              <i class="fas fa-image"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="<?php echo e($product->photo); ?>">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
        <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
        
      <div class="form-group">
        <label for="inputPrice" class="col-form-label">Min Price <span class="text-danger">*</span></label>
        <input id="inputPrice" type="number" name="minprice" value="<?php echo e($product->minprice); ?>" class="form-control">
        <?php $__errorArgs = ['minprice'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="controls">
        <label class="control-label">Size Wise Price: </label>                                
        <div class="control-group">
          
          <div class="field_wrapper">
            <div class="abc">
              <input type="text" name="flu[]" id="flu" placeholder="flu" style="width:120px;"/>
              <select name="form_id[]" id="form_id" placeholder="form_id" style="width:120px;">
                <option value="">--Select Form--</option>
                <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($form->id); ?>"><?php echo e($form->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <input type="text" name="sku[]" id="sku" placeholder="sku" style="width:120px;" />                                    
              <input type="text" name="size[]" id="size" placeholder="size" style="width:120px;"/>
              <input type="float"  name="price[]" id="price" placeholder="price" style="width:120px;"/>
              <input id="discount" type="numberfloat" name="discount[]" min="0" max="100" placeholder="Enter discount" style="width:120px;"/>
              <input type="float" name="stock[]" id="stock" placeholder="stock" style="width:120px;"/>
              <a href="javascript:void(0);" class="add_button1" title="Add field">Add</a><br>
            </div>
            <input type="hidden" id="form_count" name="form_count" value="">
          </div>
        </div>
      </div>
      <div class="widget-title"  >
        <h5> Product Attributes List</h5>
      </div>     
      
        <table class="table table-bordered" id="attribute-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Flu</th>
              <th>SKU</th>
              <th>Form</th>
              <th>Size</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Stock</th>                                    
              <th>Action</th>
            </tr>
          </thead> 
                    
          <tbody>
          
            <?php $__currentLoopData = $product['attrs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><input type="hidden" name="idAttr" form="edit<?php echo e($attribute->id); ?>" value="<?php echo e($attribute->id); ?>"><?php echo e($attribute->flu); ?></td>
                <td><?php echo e($attribute->sku); ?></td>
                <?php if($attribute->form): ?>                                        
                  <td><?php echo e($attribute->form->name); ?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <td><?php echo e($attribute->size); ?> </td>
                <td><input type="float" form="edit<?php echo e($attribute->id); ?>" name="price" value="<?php echo e($attribute->price); ?>" style="width:80px;"></td>
                <td><input type="float" form="edit<?php echo e($attribute->id); ?>" name="discount" value="<?php echo e($attribute->discount); ?>" style="width:80px;"></td>
                <td><input type="number" form="edit<?php echo e($attribute->id); ?>" name="stock" value="<?php echo e($attribute->stock); ?>" style="width:80px;"></td>
                      
                <td class="center">
                  <input type="submit" form="edit<?php echo e($attribute->id); ?>" value="Update" class="btn btn-primary btn-mini" >
                                                                                              
                  <form >                    
                  </form>
                  <form method="get" id="delete<?php echo e($attribute->id); ?>" action="<?php echo e(url('admin/product/delete-attributes',[$attribute->id])); ?>">
                    <button class="btn btn-danger btn-sm dltBtn" form="delete<?php echo e($attribute->id); ?>" data-id="<?php echo e($attribute->id); ?>" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>                    
                  </form>
                </td>                        
              </tr> 
              <form method="post" id="edit<?php echo e($attribute->id); ?>" action="<?php echo e(route('edit.attribute', ['id' => $product->id])); ?>" enctype="multipart/form-data"> 
                <?php echo e(csrf_field()); ?>

              </form>       
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                           
          </tbody>
        </table>     
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger"></span></label>
          <div class="input-group">
            <span class="input-group-btn">
              <input type="file" id="input-file-now-custom-3" class="form-control m-2" name="images[]" multiple>
            </span>          
          </div>
        </div>
        <table class="table table-bordered" id="image-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>              
              <th>Id</th>
              <th>image</th>                            
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $product['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($image->id); ?></td>                                    
                <td><?php echo e($image->name); ?> </td>                        
                <td class="center">                                                                                 
                  <form method="get" id="deletImage" action="<?php echo e(url('admin/product/delete-images',[$image->id])); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('delete'); ?>
                    <button class="btn btn-danger btn-sm dltBtn1" form="deletImage" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>  
                  </form>
                </td>                        
              </tr>                    
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                         
          </tbody>
        </table>
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" form="main-form" class="form-control">
            <option value="active" <?php echo e((($product->status=='active')? 'selected' : '')); ?>>Active</option>
            <option value="inactive" <?php echo e((($product->status=='inactive')? 'selected' : '')); ?>>Inactive</option>
          </select>
          <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group mb-3">
        
        </div>
      </form>
      <button class="btn btn-success" form="main" type="submit">Update</button>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('admin_panel/summernote/summernote.min.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="<?php echo e(asset('admin_panel/summernote/summernote.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  $('#lfm').filemanager('image');

  $(document).ready(function() {
    $('#other_name').summernote({
      placeholder: "Write other_name.....",
        tabsize: 2,
        height: 100
    });
  });
  
  $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write detail description.....",
        tabsize: 2,
        height: 100
    });
  });
  $(document).ready(function() {
    $('#packaging_details').summernote({
      placeholder: "Write detail packaging_detailsn.....",
        tabsize: 2,
        height: 100
    });
  });

  $(document).ready(function() {
    $('#benefits').summernote({
      placeholder: "Write benefit.....",
        tabsize: 2,
        height: 100
    });
  });
  $(document).ready(function() {
    $('#precautions').summernote({
      placeholder: "Write precautions.....",
        tabsize: 2,
        height: 100
    });
  });
  // $('select').selectpicker();
  
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-success").click(function(){ 
        var html = $(".clone").html();
        $(".increment").after(html);
    });
    $("body").on("click",".btn-danger",function(){ 
        $(this).parents(".control-group").remove();
    });
  });

  $(document).ready(function() {
    var max_fields = 15;
    var x = 1;
    var wrapper = $("#category");
    var add_button = $(".category_button");
    
    $(add_button).click(function(e) {
      e.preventDefault();
      if (x < max_fields) {
        x++;
        $(wrapper).append(`<div class="category${x}"><br><label for="cat_id">Category</label>
        <select name="cat_id${x}" id="category_id${x}" class="form-control category_id${x}">
          <option value="">--Select category--</option>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        
        <div class="form-group d-none child_cat_div${x}" id="child_cat_div${x}">
          <label for="subcat_id${x}">Sub Category</label>
          <select name="subcat_id${x}" id="child_cat_id${x}" class="form-control child_cat_id${x}">
            <option value="">--Select any category--</option>
            
          </select>
        </div> <a href="#" class="delete">Delete</a></div>`);
        $("#cat_count").val(x);
        $("#subcat_count").val(x);
        
      } else {
        alert('You Reached the limits')
      }
      $(`.category_id${x}`).change(function (){         
        var category_id=$(this).val();
        if(category_id !=null){         
          // Ajax call
          $.ajax({        
            url:`/admin/category/"+category_id+"/child`,
            data:{
              _token:"<?php echo e(csrf_token()); ?>",
              id:category_id
            },
            type:"POST",
            success:function(response){       
              if(typeof(response) !='object'){
                response=$.parseJSON(response)            
              }
              var html_option="<option value=''>----Select sub category----</option>"
              if(response.status){
                var data=response.data;
                if(response.data){
                  $(`.child_cat_div${x}`).removeClass('d-none');
                  $.each(data,function(id,name){
                    html_option +="<option value='"+id+"'>"+name+"</option>"
                  });
                }
                else{ 
                }
              }
              else{
                
                $(`.child_cat_div${x}`).addClass('d-none');
              }
              $(`.child_cat_id${x}`).html(html_option);
            }
          });
        }
        else{
        }
        
      })
    });
    $(wrapper).on("click", ".delete", function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    })
  });
 
  $('.category_id').change(function (){ 
        
    var category_id=$(this).val();
    console.log(category_id);
    if(category_id !=null){
      //alert(category_id);
      // Ajax call
      $.ajax({        
        url:"/admin/category/"+category_id+"/child",
        data:{
          _token:"<?php echo e(csrf_token()); ?>",
          id:category_id
        },
        type:"POST",
        success:function(response){       
          if(typeof(response) !='object'){
            response=$.parseJSON(response)            
          }
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            if(response.data){
              $('.child_cat_div').removeClass('d-none');
              $.each(data,function(id,name){
                html_option +="<option value='"+id+"'>"+name+"</option>"
              });
            }
            else{ 
            }
          }
          else{
            
            $('.child_cat_div').addClass('d-none');
          }
          $('.child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
    
  })

  $(document).ready(function() {
    var max_fields = 15;
    var wrapper = $(".brand");
    var add_button = $(".brand_button");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
          x++;
          $(wrapper).append(`<div><br><select name="brand_id${x}" id="brand_id${x}" class="form-control">
          <option value="">--Select Brand--</option><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
          <a href="#" class="delete">Delete</a></div>`);//add input box
          $("#brand_count").val(x);
        } else {
          alert('You Reached the limits')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    })
  });
  $(document).ready(function() {
    var max_fields = 15;
    var wrapper = $(".abc");
    var add_button = $(".add_button1");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append(`<div>
            <input type="text" name="flu[]" id="flu${x}" placeholder="flu" style="width:120px;margin-right:5px; margin-top:5px;"/>
            <select name="form_id[]" id="form_id" placeholder="form_id" style="width:120px;">
              <option value="">--Select Form--</option>
              <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($form->id); ?>"><?php echo e($form->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="text" name="sku[]" id="sku" placeholder="sku" style="width:120px; margin-right:5px; margin-top:5px;" required />
            <input type="text" name="size[]" id="size" placeholder="size" style="width:120px; margin-right:5px margin-top:5px;" required/>
            <input type="text" name="price[]" id="price" placeholder="price" style="width:120px; margin-right:5px margin-top:5px;" required/>
            <input id="discount" type="number" name="discount[]" min="0" max="100" placeholder="Enter discount" style="width:120px;"required/>
            <input type="text" name="stock[]" id="stock" placeholder="stock" style="width:120px; margin-right:5px margin-top:5px;" required/>
            <a href="#" class="delete">Delete</a></div>`);//add input box
            $("#form_count").val(x);
           
        } else {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    })
  });

  function proCatDlt(productId, catId){
    
  $("#" + catId + "-tr").remove(); 
  $.ajax({
    url:'/admin/product/delete-category/' + catId,
    type:"get",
    data:{
        productId:productId
    },
    success:function(response){
     
    }});
  }
  $.each($('.td-cat-title'), (key, value) => {
    let el = document.getElementById(value.innerText);
    if(el !== undefined) {
      // el.setAttribute('disabled', 'disabled');
      el.style.display = 'none';
    }
  });

  function proBrandDlt(productId, brandId){
    
    $("#" + brandId + "-tr").remove(); 
    $.ajax({
      url:'/admin/product/delete-brand/' + brandId,
      type:"get",
      data:{
          productId:productId
      },
      success:function(response){
        
      }});
    }
    $.each($('.td-brand-title'), (key, value) => {
      let el = document.getElementById(value.innerText);
      if(el !== undefined) {
        el.setAttribute('disabled', 'disabled');
        el.style.display = 'none';
      }
    });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/admin/product/edit.blade.php ENDPATH**/ ?>