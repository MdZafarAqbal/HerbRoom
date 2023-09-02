<footer class="footer shop-footer" >
    <?php 
        $setting = DB::table('settings')->first(); 
    ?>
	<!-- Footer Top -->
	<div class="footer-top main-footer">				
		<div class="footer-about">
			<div class="logo">
				<a href="<?php echo e(route('home')); ?>"><img src="<?php echo e($setting->logo); ?>" alt="#"></a>
			</div>
			<hr>

			<div class="footer-desc">
				<p class="desc-text">We welcome you to the Botanical World of Herbs. We provide exquisite Herbs, Teas, Oils and Extracts of exceptional character of rich underlying attributes since 1980.</p>
			</div>
		</div>

		<div class="footer-menu">
			<div class="footer-info">
				<h3>Information</h3>
				<hr>
				<ul>
					<li><a href="<?php echo e(route('about.us')); ?>">About Us</a></li>
					<li><a href="<?php echo e(route('terms.and.conditions')); ?>">Terms & Conditions</a></li>
					<li><a href="<?php echo e(route('privacy.policy')); ?>">Privacy Policy</a></li>
					<li><a href="<?php echo e(route('faq')); ?>">FAQ</a></li>
				</ul>
			</div>
      
			<div class="footer-loc">
        <div>
          <h3>Address</h3></div>
          <hr>
          <div>
          <ul>
            <li><?php echo e($setting->address); ?></li>
            <li><a href="mailto:<?php echo e($setting->email); ?>"><?php echo e($setting->email); ?></a></li>
            <li><a href="tel:<?php echo e($setting->phone); ?>"><?php echo e($setting->phone); ?></a></li>
          </ul>
        </div>
			</div>
		</div>
	</div>
	<!-- End Footer Top -->

	<div class="copyright">
		<p>Copyright &#169 <?php echo e(date('Y')); ?> <a href="#" target="_blank">World Forum Trading</a>  -  All Rights Reserved.</p>
	</div>

	<!-- Fixed Footer -->
	<div id="footer-fixed" class="footer-fixed fixed-bottom"> 
		<!-- Features -->
    <div class="features" >
			<div class="feature1" >
				<h4><i class="fa-solid fa-rocket"></i> Free Shipping<br>Over AED 100.00</h4>
			</div>
												
			<div class="feature2">
				<h4><i class="fa-solid fa-clock-rotate-left"></i> Free Return<br>Within 15 days</h4>
			</div>
										
			<div class="feature3">
				<h4><i class="fa-solid fa-lock"></i>100% Secure <br> Payment</h4>
			</div>
		</div>
		<!-- End Features -->
	</div>
	<!-- End Fixed Footer -->
</footer>
<?php /**PATH D:\XAMPP\htdocs\herbalcare\resources\views/main/layouts/footer.blade.php ENDPATH**/ ?>