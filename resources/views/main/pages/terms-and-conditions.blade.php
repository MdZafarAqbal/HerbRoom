<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Terms and Conditions || Herbal Care</title>
		<style>
			body{
				background-color: #faf9f6;
			}
			.layout{
				width: auto;
				margin: auto;
			}
			.accordion{
				padding: 10px;
				margin-top: 10px;
				margin-bottom: 10px;
				background: #7c8e7b;
				border-radius: 10px;
				color: #faf9f6;
			}
			.accordion__question p{
				margin: 5px;
				padding: 0;
				font-family: Verdana;
				font-size: 20px;
			}
			.accordion__answer p{
				margin: 5px;
				padding: 10px;
				font-size: large;
				font-family: Verdana, Geneva, Tahoma, sans-serif;
				color: #000;
				background: #faf9f6;
				border-radius: 10px;
			}
			.accordion:hover{
				cursor: pointer;
			}
			.accordion__answer {
				display: none;
			}
			.accordion.active .accordion__answer {
				display: block;
			}
			.btn-submit{
			height: 3em;
    		margin: 1em 0;
			width: 11.5em;
			background-color:#7c8e7b;
			position: absolute;
			left:40%;
			right:50%;
		}
		</style>
	</head>
	<body>
		<h2 style="color:green; text-align:center">Terms and Conditions</h2>
		<div class="layout">
			<div class="accordion">
				<div class="accordion__question">
					<p style="font-size: 15px;">
						<i>
							Please note that Delivery dates & timeframes for processing returns and refunds are estimates only and not guaranteed.<br>
							Most Herbs & Spices or Herbal Teas that we sell are in their original loose raw forms. When shipped the products will be packed in either transparent plastic bag or brown paper bag.
						</i>
					</p>
				</div>			
			</div>
		</div>
		<div class="layout">
			<div class="accordion">
				<div class="accordion__question">
					<p><b>Return & Refund Policy</b></p>
					<ol type="a">
						<li>Products must be returned with the original packaging, sealed and unopened. If the product have been used, damaged or the original packaging is opened, we will decline the refunds.</li><br>
						<li>Return of product should be initiated within 15 days of receiving the Products.</li><br>
						<li>Your refund will reflect the total amount you paid for the product(s) you are returning. However, you will not be refunded any original shipping costs you may have paid for the delivery of the product(s) to you.</li><br>
						<li><b>Return of partial or full order :</b> If on return, the value of invoice goes below the limit of free delivery (i.e. AED. 100.00), the shipping fee will be charged and deducted from the refundable amount.  </li><br>
						<p><i>Please remember that in order for us to process your return, the process will initiate once we receive the returned goods in our warehouse and inspect the goods with the reason as provided by you.</i></p>
					</ol>						
					</ol>
				</div>			
			</div>
		</div>
		<div class="layout">
			<div class="accordion">
				<div class="accordion__question">
					<p><b>Cancellation Policy:</b></p>
					<ol type="a">
						<li>Go to Track your order.</li><br>
						<li>You cannot cancel the order once dispatched.</li><br>						
					</ol>
				</div>			
			</div>
		</div>
		<button class="btn btn-submit"><a href="{{route('home')}}">Home Page</a></button>
	</body>
</html>
