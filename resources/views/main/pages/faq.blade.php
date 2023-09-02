<!DOCTYPE html>
<html lang="en">
<head>
	<title>Help Center || HerbalCare</title>
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
	<h2 style="color:green; text-align:center">FAQ</h2>
	<div class="layout">
		<div class="accordion">
			<div class="accordion__question">
				<p>Why should I buy from Herbalcare.ae?</p>

			</div>
			<div class="accordion__answer">
				<p>We at Herbalcare.ae handpicked all the herbs in their natural forms. No artificial chemical or any other substitute is added to any of our product. All the herbs which we collect are sorted, processed and cleaned by the old proven natural traditional methods, which guarantee natural taste and purity. We store all the goods in a hygienic way so that its curing values are not impacted.</p>

			</div>
		</div>
		<div class="accordion">
			<div class="accordion__question">
				<p>Do you ship outside UAE?</p>

			</div>
			<div class="accordion__answer">
				<p><i>
					Currently we initiate orders within UAE only.
				</i></p>

			</div>
		</div>
		<div class="accordion">
			<div class="accordion__question">
				<p>How long does it take my order to get delivered?</p>

			</div>
			<div class="accordion__answer">
				<p><i>
					Once the order is confirmed, it takes 3 to 5 days to dispatch and delivered.

				</i></p>

			</div>
		</div>
		<div class="accordion">
			<div class="accordion__question">
				<p>My order has been dispatched, how do i track it?</p>

			</div>
			<div class="accordion__answer">
				<p><i>
					a)	You will receive a tracking number by email once the order is dispatched. You may track your order on www.herbalcare.ae<br>
					b)	You may also check you order by your ORDER ID on our website.
				</i></p>
			</div>
		</div>		
		<div class="accordion">
			<div class="accordion__question">
				<p>When and how can i cancel my order?</p>

			</div>
			<div class="accordion__answer">
				<p><i>
					Return of product should be initiated within 15 days of receiving the Products. Please review return policy.

				</i></p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion__question">
				<p>Which payment methods you take?</p>
			</div>
			<div class="accordion__answer">
				<p><i>
					(Cash on delivery,  Master Card, Visa Card)
				</i></p>
			</div>
		</div>
		<div class="accordion">
			<div class="accordion__question">
				<p>What if the product is out of stock</p>
			</div>
			<div class="accordion__answer">
				<p><i>
					You may directly email us on theherbroom.2001@gmail.com

				</i></p>
			</div>
			
		</div>
		<button class="btn btn-submit"><a href="{{route('home')}}">Home Page</a></button>
	</div>

	<script>
		let answers = document.querySelectorAll(".accordion");
		answers.forEach((event)=>{
			event.addEventListener('click',()=>{
				if(event.classList.contains("active")){
					event.classList.remove("active");
				}
				else{
					event.classList.add("active");
				}
			});
		});
	</script>
</body>
</html>
