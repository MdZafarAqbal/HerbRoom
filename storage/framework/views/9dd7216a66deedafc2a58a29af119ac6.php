
<?php $__env->startSection('title', 'Checkout Order || HerbalCare'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/main/checkout.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/main/loader.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('main-content'); ?>
  <!-- Start Checkout -->
  <h1 class="title page-title">Checkout</h1>

  <?php
    $countries = DB::table('countries')->where('status', 'active')->get();
    $states = DB::table('states')->where('country_id', '784')->get();
    $subtotal = Helper::cartSubtotal();
    $tax = Helper::cartTax();
    $discount = Helper::cartDiscount();
    $total = Helper::cartTotal();
    $order_success = session('order_success');
    $order_no = session('order_no');
  ?>

  <?php if($total != 0 || $order_success): ?>
    <?php if(auth()->guard()->guest()): ?>
      <p class="checkout-para">Please register in order to checkout more quickly.</p>
    <?php endif; ?>

    <section class="shop-checkout checkout-sec">
      <!-- Form -->
      <div class="form-container">
        <form id="order-form" class="form" method="post" action="<?php echo e(route('order')); ?>" novalidate>
          <?php echo csrf_field(); ?>
          <h2>Customer Detail</h2>

          <div class="customer-details">
            <fieldset class="type-selection">
              <legend>Customer</legend>
              <div class="form-group">
                <input type="radio" name="cust_type" id="individual" value="individual" checked>
                <label for="individual">Individual</label>
              </div>
              
              <div class="form-group">
                <input type="radio" name="cust_type" id="company" value="company">
                <label for="company">Company</label>
              </div>
  
              <?php if($errors->has('cust_type')): ?>
                <div class="error">
                  <?php $__errorArgs = ['cust_type'];
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
            </fieldset>
  
            <fieldset class="details">
              <legend>Invoice Details</legend>
              <div class="fl-bl">
                <div class="form-group" id="first-name">
                  <div class="form-input">
                    <input type="text" id="fname" name="fname" class="name" placeholder="First Name" value="<?php if(auth()->guard()->check()): ?> <?php echo e(old('fname') ?? auth()->user()->fname); ?> <?php else: ?> <?php echo e(old('fname')); ?> <?php endif; ?>">
                    <label for="fname">First Name</label>
                  </div>
                  
                  <?php if($errors->has('fname')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['fname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php echo $message; ?>

                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  <?php endif; ?>
                </div>

                <div class="form-group" id="last-name">
                  <div class="form-input">
                    <input type="text" id="lname" name="lname" class="name" placeholder="Last Name" value="<?php if(auth()->guard()->check()): ?> <?php echo e(old('lname') ?? auth()->user()->lname); ?> <?php else: ?> <?php echo e(old('lname')); ?> <?php endif; ?>">
                    <label for="lname">Last Name</label>
                  </div>
                  
                  <?php if($errors->has('lname')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['lname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php echo $message; ?>

                      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                  <?php endif; ?>
                </div>
  
                <div class="form-group collapse" id="company-name">
                  <div class="form-input">
                    <input type="text" id="cname" name="cname" placeholder="Company Name" value="<?php if(auth()->guard()->check()): ?> <?php echo e(old('cname') ?? auth()->user()->cname); ?> <?php else: ?> <?php echo e(old('cname')); ?> <?php endif; ?>">
                    <label for="cname">Company Name</label>
                  </div>
                  
                  <?php if($errors->has('cname')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['cname'];
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
                
                <div class="form-group collapse" id="trn">
                  <div class="form-input">
                    <input type="number" id="trn-no" name="trn_no" placeholder="TRN Number" value="<?php if(auth()->guard()->check()): ?> <?php echo e(old('trn_no') ?? auth()->user()->trn_no); ?> <?php else: ?> <?php echo e(old('trn_no')); ?> <?php endif; ?>">
                    <label for="trn-no">TRN Number</label>
                  </div>
                    
                  <?php if($errors->has('trn_no')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['trn_no'];
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
              </div>
  
              <div class="fl-bl">
                <div class="form-group">
                  <div class="form-input">
                    <input type="email" name="email" id="email" placeholder="someone@domain.com" value="<?php echo e(old('email')); ?>" required>
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
                    <input type="text" name="address" id="address" class="address-input" placeholder="Address" value="<?php echo e(old('address')); ?>">
                    <label for="address">Address</label>
                  </div>
    
                  <?php if($errors->has('address')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['address'];
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
              </div>
  
              <div class="fl-bl">
                <div class="form-group">
                  <div class="form-input">
                    <input type="text" name="landmark" id="landmark" placeholder="Landmark" value="<?php echo e(old('landmark')); ?>">
                    <label for='landmark'>Nearby Landmark <sup class='optional'>(Optional)</label>
                  </div>

                  <?php if($errors->has('landmark')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['landmark'];
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
                
                <div id="country-form-group" class="form-group">
                  <div class="form-input">
                    <input type="hidden" name="country" id="country" class="country-input h-s-input" value="784">
                    <input type="text" id="country-name" class="country-name selection-input" value="United Arab Emirates" readonly> 
                    <label for="country-name">Country</label>
                    <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                    <ul id="countries" class="selection-list collapse">
                      <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li id="country-<?php echo e($country->id); ?>" data-iso="<?php echo e($country->iso_code); ?>" data-call-code="<?php echo e($country->calling_code); ?>" onclick="country(this, <?php echo e($country->id); ?>)"><?php echo e($country->name); ?></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  </div>

                  <?php if($errors->has('country')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['country'];
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
              </div>
  
              <div class="fl-bl">
                <div id="state-form-group" class="form-group">
                  <div class="form-input">
                    <input type="hidden" name="state" id="state" class="state-input h-s-input">
                    <input type="text" id="state-name" class="state-name selection-input" placeholder="State" readonly> 
                    <label for="state-name">State</label>
                    <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                    <ul id="states" class="selection-list collapse">
                      <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li id="state-<?php echo e($state->id); ?>" data-state="<?php echo e($state->id); ?>" data-country="784" onclick="state(this)"><?php echo e($state->name); ?></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  </div>

                  <?php if($errors->has('state')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['state'];
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
  
                <div id="city-form-group" class="form-group">
                  <div class="form-input">
                    <input type="hidden" name="city" id="city" class="city-input h-s-input">
                    <input type="text" id="city-name" class="city-name selection-input" placeholder="City" readonly>
                    <label for="city-name">City</label>
                    <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                    <ul id="cities" class="selection-list collapse"></ul>
                  </div>

                  <?php if($errors->has('city')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['city'];
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
              </div>
  
              <div class="fl-bl">
                <div class="form-group">
                  <div class="phone-div">
                    <img class="flag-img flag" src="<?php echo e(asset('images/flags/AE.png')); ?>" alt="Country Flag Image" width="40" height="20">
                    <input type="text" class="phone-code" value="+971" readonly>
                    <div class="form-input">
                      <input type="tel" name="phone" id="phone" class="phone-input" placeholder="50 123 4567" value="<?php echo e(old('phone')); ?>">
                      <label for="phone">Phone</label>
                    </div>
                  </div>

                  <?php if($errors->has('phone')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['phone'];
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
                  <div class="phone-div">
                    <img class="flag-img flag" src="<?php echo e(asset('images/flags/AE.png')); ?>" alt="Country Flag Image" width="40" height="20">
                    <input type="text" class="phone-code" value="+971" readonly>
                    <div class="form-input">
                      <input type="tel" name="altphone" id="altphone" class="phone-input altphone-input" placeholder="50 123 4567" value="<?php echo e(old('altphone')); ?>">
                      <label for="altphone">Phone <sup class='optional'>(Optional)</sup></label>
                    </div>
                  </div>

                  <?php if($errors->has('altphone')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['altphone'];
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
              </div>
            </fieldset>
  
            <fieldset class="details">
              <legend>Shipping Details</legend>
              <h5>Same As Above?</h5>
              <div class="type-selection">
                <div class="form-group">
                  <input type="radio" name="shipping_option" id="same" value="same" checked>
                  <label for="same">Yes</label>
                </div>
                
                <div class="form-group">
                  <input type="radio" name="shipping_option" id="different" value="different">
                  <label for="different">No</label>
                </div>
              </div>
  
              <div id="shipping-details" class="collapse">
                <div class="fl-bl">
                  <div class="form-group" id="shipping-first-name">
                    <div class="form-input">
                      <input type="text" id="shipping-fname" class="name" name="shipping_fname" placeholder="First Name" value="<?php echo e(old('shipping_fname')); ?>">
                      <label for="shipping-fname">First Name</label>
                    </div>

                    <?php if($errors->has('shipping_fname')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_fname'];
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
  
                  <div class="form-group" id="shipping-last-name">
                    <div class="form-input">
                      <input type="text" id="shipping-lname" name="shipping_lname" class="name" placeholder="Last Name" value="<?php echo e(old('shipping_lname')); ?>">
                      <label for="shipping-lname">Last Name</label>
                    </div>

                    <?php if($errors->has('shipping_lname')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_lname'];
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
                </div>
  
                <div class="form-group">
                  <div class="form-input">
                    <input type="text" name="shipping_address" id="shipping-address" class="address" placeholder="Shipping Address" value="<?php echo e(old('shipping_address')); ?>">
                    <label for="shipping-address">Address</label>
                  </div>
  
                  <?php if($errors->has('shipping_address')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['shipping_address'];
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
  
                <div class="fl-bl">
                  <div class="form-group">
                    <div class="form-input">
                      <input type="text" name="shipping_landmark" id="shipping-landmark" placeholder="Nearby Landmark" value="<?php echo e(old('shipping_landmark')); ?>">
                      <label for="shipping-landmark">Nearby Landmark <sup class='optional'>(Optional)</sup></label>
                    </div>

                    <?php if($errors->has('shipping_landmark')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_landmark'];
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
  
                  <div id="shipping-country-form-group" class="form-group">
                    <div class="form-input">
                      <input type="hidden" name="shipping_country" id="shipping-country" class="country-input h-s-input" value="784">
                      <input type="text" id="shipping-country-name" class="country-name selection-input" value="United Arab Emirates" readonly> 
                      <label for="shipping-country-name">Country</label>
                      <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                      <ul id="shipping-countries" class="selection-list collapse">
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li id="shipping-country-<?php echo e($country->id); ?>" data-iso="<?php echo e($country->iso_code); ?>" data-call-code="<?php echo e($country->calling_code); ?>" onclick="country(this, <?php echo e($country->id); ?>)"><?php echo e($country->name); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    </div>

                    <?php if($errors->has('shipping_country')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_country'];
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
                </div>

                <div class="fl-bl">
                  <div id="shipping-state-form-group" class="form-group">
                    <div class="form-input">
                      <input type="hidden" name="shipping_state" id="shipping-state" class="state-input  h-s-input" value="<?php echo e(old('shipping_state')); ?>">
                      <input type="text" id="shipping-state-name" class="state-name selection-input" placeholder="State" readonly> 
                      <label for="shipping-state-name">State</label>
                      <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                      <ul id="shipping-states" class="selection-list collapse">
                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li id="shipping-state-<?php echo e($state->id); ?>" data-state="<?php echo e($state->id); ?>" data-country="784" onclick="state(this)"><?php echo e($state->name); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    </div>

                    <?php if($errors->has('shipping_state')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_state'];
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
    
                  <div id="shipping-city-form-group" class="form-group">
                    <div class="form-input">
                      <input type="hidden" name="shipping_city" id="shipping-city" class="city-input  h-s-input" value="<?php echo e(old('shipping_city')); ?>">
                      <input type="text" id="shipping-city-name" class="city-name selection-input" placeholder="City" readonly>
                      <label for="shipping-city-name">City</label>
                      <div class="dropdown-icon"><i class="fa-solid fa-angle-down"></i></div>
                      <ul id="shipping-cities" class="selection-list collapse"></ul>
                    </div>

                    <?php if($errors->has('shipping_city')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_city'];
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
                </div>
    
                <div class="fl-bl">
                  <div class="form-group">
                    <div class="phone-div">
                      <img class="shipping-flag-img flag" src="<?php echo e(asset('images/flags/AE.png')); ?>" alt="Country Flag Image" width="40" height="20">
                      <input type="text" class="phone-code" value="+971" readonly>
                      <div class="form-input">
                        <input type="tel" name="shipping_phone" id="shipping-phone" class="phone-input" placeholder="50 123 4567" value="<?php echo e(old('shipping_phone')); ?>">
                        <label for="shipping-phone">Phone</label>
                      </div>
                    </div>

                    <?php if($errors->has('shipping_phone')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_phone'];
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
                    <div class="phone-div">
                      <img class="shipping-flag-img flag" src="<?php echo e(asset('images/flags/AE.png')); ?>" alt="Country Flag Image" width="40" height="20">
                      <input type="text" class="phone-code" value="+971" readonly>
                      <div class="form-input">
                        <input type="tel" name="shipping_altphone" id="shipping-altphone" class="phone-input altphone-input" placeholder="50 123 4567" value="<?php echo e(old('shipping_altphone')); ?>">
                        <label for="shipping-altphone">Phone <sup class='optional'>(Optional)</sup></label>
                      </div>
                    </div>

                    <?php if($errors->has('shipping_altphone')): ?>
                      <div class="error">
                        <?php $__errorArgs = ['shipping_altphone'];
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
                </div>
              </div>
            </fieldset>
          </div>

          <h2>Payment Detail</h2>

          <div class="payment-detail">
            <fieldset class="payment-mthd type-selection">
              <legend>Payment Method</legend>
              <div class="form-group">
                <input type="radio" name="pay_mthd" id="op-input" value="op" checked>
                <label for="op-input">Online Payment</label>
              </div>
              <div class="form-group">
                <input type="radio" name="pay_mthd" id="cod-input" value="cod">
                <label for="cod-input">Cash on Delivery</label>
              </div>
            </fieldset>
  
            <fieldset class="op-form" id="op-form">
              <legend>Online Payment</legend>
              <div class="fl-bl">
                <div class="form-group">
                  <div class="form-input">
                    <input type="tel" id="account-no" class="account-no"  name="account_no"  placeholder="4242 4242 4242 4242">
                    <label for="account-no">Card Number</label>
                  </div>

                  <?php if($errors->has('account_no')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['account_no'];
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
                    <input type="text" id="account-name" class="account-name name" name="account_name" placeholder="Full Name (As per Card)" autocomplete="on">
                    <label for="account-name">Full Name</label>
                  </div>
                </div>

                <?php if($errors->has('account_name')): ?>
                  <div class="error">
                    <?php $__errorArgs = ['account_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                      <?php echo $message; ?>

                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                <?php endif; ?>
              </div>
  
              <div class="fl-bl">
                <div class='form-group expiry'>
                  <div class="form-input">
                    <input type="number" class='expiry-month' id='expiry-month' name="expiry_month" placeholder='MM'>
                    <label for="expiry-month">Expiry Month</label>
                  </div>

                  <?php if($errors->has('expiry_month')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['expiry_month'];
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
                
                <div class='form-group expiry'>
                  <div class="form-input">
                    <input type="number" class='expiry-year' id='expiry-year' name="expiry_year" placeholder='YYYY'>
                    <label for="expiry-year">Expiry Year</label>
                  </div>

                  <?php if($errors->has('expiry_year')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['expiry_year'];
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
  
                <div class="form-group cvc">
                  <div class="form-input">
                    <input type="password" id="cvv-cvc" class="cvv-cvc" name="cvv_cvc" placeholder="CVV/CVC" onkeypress="if(this.value.length == 3) return false;" autocomplete="off">
                    <label for="cvv-cvc">CVV/CVC</label>
                  </div>

                  <?php if($errors->has('cvv_cvc')): ?>
                    <div class="error">
                      <?php $__errorArgs = ['cvv_cvc'];
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
              </div>
  
              <div class="payment-options">
                <img src="<?php echo e(('images/visa-card.png')); ?>" alt="Visa Card Image" width="541" height="348">
                <img src="<?php echo e(('images/master-card.png')); ?>" alt="Master Card Image" width="541" height="348">
              </div>
            </fieldset>
          </div>
          <input type="submit" class="btn btn-checkout btn-plc" value="Place Order">
        </form>
      </div>

      <div class="order-summary">
        <div class="sums-summary">
          <div class="summary-title-container">
            <h2>Order Summary</h2>
          </div>
          <div class="coupon">
            <h3>Have Coupon?</h3>
            <input name="code" id="coupon-code" placeholder="Enter Coupon Code">
            <button id="coupon-apply" class="btn coupon-btn">Apply</button>
          </div>
          <div class="cart-totals">
            <div class="cart-total-value">
              <strong class="subtotal" data-price="<?php echo e(Helper::cartSubtotal()); ?>"> Amount <span>(Excluding VAT)</span>: </strong>
              <span id="subtotal-value">AED <?php echo e(number_format($subtotal, 2)); ?></span>
            </div>
            <?php if(auth()->guard()->check()): ?>
              <div class="cart-total-value">
                <strong class="discount"> Discount Applied: </strong>
                <span id="discount-value">AED <?php echo e(number_format($discount, 2)); ?></span>
              </div>
            <?php endif; ?>
            <div class="cart-total-value">
              <strong class="tax"> VAT Applied <span>(5%)</span>: </strong>
              <span id="tax-value">AED <?php echo e(number_format($tax, 2)); ?></span>
            </div>
            <div class="cart-total-value">
              <strong class="shopping"> Shipping: </strong>
              <span id="shipping-value">AED 0.00</span>
            </div>
          </div>
        
          <div class="cart-total-value grand-total">
            <strong class="total"> Total Amount: </strong>
            <span id="grand-total-value" data-total=<?php echo e($total); ?>>AED <?php echo e(number_format($total, 2)); ?></span>
          </div>
          <input type="submit" form="order-form" class="btn btn-checkout btn-plc-summary" value="Place Order">
        </div>
        <div class="cart" id="cart-summary">
          <?php
            $carts = Helper::cartItems();
          ?>

          <?php if($carts): ?>
          <div class="summary-title-container">
            <h2>Cart Summary</h2>
          </div>
          <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="cart-item">
            <img src="<?php echo e($cart->attr->product->photo); ?>" alt="product photo" class="cart-product-img zoom-img">
            <div class="cart-item-meta">
              <h3 class="cart-page-item-name"><?php echo e($cart->attr->product->name); ?></h3>
              <div class="cart-item-stats">
                <?php if($cart->attr->form_id): ?>
                  <div class="flex-container">
                    <div class="cart-page-item-price flex-item">
                      <strong>Price: </strong>
                      <span>AED <?php echo e(number_format($cart->attr->price, 2)); ?></span>
                    </div>

                    <div class="cart-page-item-form flex-item">
                      <strong>Form: </strong>
                      <span><?php echo e($cart->form); ?></span>
                    </div>
                  </div>

                  <div class="flex-container">
                    <div class="cart-page-item-size flex-item">
                      <strong>Size: </strong>
                      <span><?php echo e($cart->attr->size); ?></span>
                    </div>

                    <div class="cart-page-item-quantity flex-item">
                      <strong>Quantity: </strong>
                      <span><?php echo e($cart->quantity); ?></span>
                    </div>
                  </div>

                  <div class="cart-page-item-total flex-item">
                    <strong>Total: </strong>
                    <span id="<?php echo e($cart->id); ?>-total">AED <?php echo e(number_format($cart->total, 2)); ?></span>
                  </div>
                <?php else: ?>
                  <div class="flex-container">
                    <div class="cart-page-item-price flex-item">
                      <strong>Price: </strong>
                      <span>AED <?php echo e(number_format($cart->attr->price, 2)); ?></span>
                    </div>

                    <div class="cart-page-item-size flex-item">
                      <strong>Size: </strong>
                      <span><?php echo e($cart->attr->size); ?></span>
                    </div>
                  </div>

                  <div class="flex-container">
                    <div class="cart-page-item-quantity flex-item">
                      <strong>Quantity: </strong>
                      <span><?php echo e($cart->quantity); ?></span>
                    </div>

                    <div class="cart-page-item-total flex-item">
                      <strong>Total: </strong>
                      <span id="<?php echo e($cart->id); ?>-total">AED <?php echo e(number_format($cart->total, 2)); ?></span>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <?php else: ?>
            <p>Sorry! Your cart is empty. Choose products <a href="<?php echo e(route('home')); ?>"> here </a>!</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="loader-section popup-sec collapse">
      <div class="popup-container loader-container">
        <div class="loader">
          <div class="box box0">
            <div></div>
          </div>
          <div class="box box1">
            <div></div>
          </div>
          <div class="box box2">
            <div></div>
          </div>
          <div class="box box3">
            <div></div>
          </div>
          <div class="box box4">
            <div></div>
          </div>
          <div class="box box5">
            <div></div>
          </div>
          <div class="box box6">
            <div></div>
          </div>
          <div class="box box7">
            <div></div>
          </div>
          <div class="ground">
            <div></div>
          </div>
        </div>
      </div>
    </section>

    <section class="popup-sec order-success collapse">
      <div class="popup-container">
        <h3>Your order has been placed!</h3>
        <i class="fa-solid fa-circle-check fa-beat fa-xl success-icon"></i>
        <p>Thankyou for your purchase!</p>
        <p>Your order number is: <span id="order-no"></span></p>
        <p>You have received an order confirmation email with details of your order.</p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-submit"> Continue Shopping </a>
      </div>
    </section>

  <?php else: ?>
    <h4>Please add items to cart to proceed further. <a href="<?php echo e(route('home')); ?>">Continue Shopping</a></h4>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/main/checkout.min.js')); ?>"></script>

<?php if($order_success): ?>
  <script>
    $(document).ready(function() {
      $('body').css('height', '90vh');
      $('body').css('overflow', 'hidden');
      $('.order-success').removeClass('collapse');
      $('#order-no').html('<?= $order_no ?>');
    });
  </script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('main.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/main/pages/checkout.blade.php ENDPATH**/ ?>