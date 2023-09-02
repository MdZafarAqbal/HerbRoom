<!DOCTYPE html>
<html lang="en">
<head>
	<title>Privacy Policy || HerbalCare</title>
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
	<h2 style="color:green; text-align:center">Privacy Policy</h2>
	<div class="layout">
		<div class="accordion">
			<div class="accordion__question">
				<ol>
					<li>This privacy policy applies to HerbalCare website at www.herbalcare.ae. We at HerbalCare take your privacy seriously. This policy covers the collection, processing and other use of personal data under the Personal Data Protection Law, Federal Decree Law No. 45 of 2021 constitutes an integrated framework to ensure the confidentiality of information and protect the privacy of individuals in the UAE.</li><br>
					<li>We will collect personal data on this Website only if it is directly provided to us by you the user, e.g. your e-mail address, name, home or work address and telephone number, and therefore has been provided by you with your consent. Normally you will only provide such details if you [wish to sign up for our free e-newsletter or other resources] are making a purchase from us.</li><br>
					<li>Your payment information (e.g. credit card details) provided when you make a purchase from our website is not received or stored by us. That information is processed securely and privately by the third party payment processors that we use.<br>
						HerbalCare.ae will not have access to that information at any time. We may share your personal data with our payment processors, but only for the purpose of completing the relevant payment transactions. Such payment processors are banned from using your personal data, except to provide these necessary payment services to us, and they are required to maintain the confidentiality of your personal data and payment information.</li><br>
					<li>We may hold and process personal data that you provide to us in accordance with the Personal Data Protection Law No.45 of 2021 (PDPL).</li><br>
					<li>The information that we collect and store relating to you is primarily used to enable us to provide our services to you, and to meet our contractual commitments to you</li><br>
				</ol>
				
			</div>			
		</div>
			<button class="btn btn-submit"><a href="{{route('home')}}">Home Page</a></button>
		</div>
	</div>
</body>
</html>
