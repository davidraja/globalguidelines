<?php
function mail_attachment($eduUserName, $eduEnquiryFor, $eduUserContact, $eduUserEmail, $eduUserComment) {
	$subject = 'Education Enquiry Notification - '.$eduUserName;
	$from_name = 'Global Guidelines';
	$from_mail = 'info@globalguidelines.in';
	$replyto = 'info@globalguidelines.in';
	$mailto = 'globalguidelines@gmail.com';
	$message = '<body>
				<div style="border:1px solid #3E4A7B;">
             	<div style="background-color:#8A82BD; padding:8px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:16px">Global Guidelines - Education Enquiry</div>
			 	<div style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:1.5;">Applicant Name :  '.$eduUserName.'<br/>Enquiry for : '.$eduEnquiryFor.'<br/>Contact no : '.$eduUserContact.'<br/>Email Id : '.$eduUserEmail.'<br/>User Comment : '.nl2br($eduUserComment).'<br/></div>
			 	</div>
			 	</body>';
	
	$header = "From: ".$from_name." <".$from_mail.">\r\n";
	$header .= "Reply-To: ".$replyto."\r\n";
	$header .= "MIME-Version: 1.0\r\n"; 
	$boundary = uniqid("HTMLEMAIL");
	$header .= "Content-Type: multipart/alternative; boundary = ".$boundary."\r\n\r\n";
	$header .= "This is a MIME encoded message.\r\n\r\n";
	$header .= "--".$boundary."\r\n".
		   		"Content-Type: text/plain; charset=ISO-8859-1\r\n".
		   		"Content-Transfer-Encoding: base64\r\n\r\n";
	$header .= "--".$boundary."\r\n".
		   		"Content-Type: text/html; charset=ISO-8859-1\r\n".
		   		"Content-Transfer-Encoding: base64\r\n\r\n"; 
	$header .= chunk_split(base64_encode($message)); 
		
	return mail($mailto, $subject, "", $header);
}

function processForm() {
					
	/* GET Form Variables */
	$eduUserName = $_POST["edu-username"];
	$eduEnquiryFor = $_POST["edu-enquirydegree"];
	$eduUserContact = $_POST["edu-usercontactno"];
	$eduUserEmail = $_POST["edu-useremail"];
	$eduUserComment = $_POST["edu-usercomment"];
	
	if (empty($eduUserName) || empty($eduEnquiryFor) || empty($eduUserContact) || empty($eduUserEmail) || empty($eduUserComment)) {
		echo "<h4 class='errMsg'>Please give all the details.</h4>";
		return;
	}
	
	if (!empty($eduUserName) && !preg_match("/^[a-zA-Z ]*$/",$eduUserName)) {
		echo "<h4 class='errMsg'>Name field allowed only letters and white space.</h4>";
		return;
	}
	
	if (!empty($eduUserContact) && !preg_match("/^\d{10}$/",$eduUserContact)) {
		echo "<h4 class='errMsg'>Please give your 10 digit mobile contact number.</h4>";
		return;
	}
	
	if (!empty($eduUserEmail) && !filter_var($eduUserEmail, FILTER_VALIDATE_EMAIL)) {
		echo "<h4 class='errMsg'>Please give valid email id.</h4>";
		return;
	}
	
	$mail_sent = mail_attachment($eduUserName, $eduEnquiryFor, $eduUserContact, $eduUserEmail, $eduUserComment);
	
	echo $mail_sent ? "<h4 class='msg'>We have received your request, we will contact you soon...</h4>" : "<h4 class='errMsg'>Something went wrong, please try again...</h4>";

}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="www.globalguidelines.in" />
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Job and Education Consulting Services - Global Guidelines</title>
		<meta name="keywords" content="Global Guidelines, Job Guidelines, Education Guidelines, Consulting Services, Job Consulting, Education Consulting, Education Services, GlobalGuidelines" />
		<meta name="description" content="Global Guidelines is offering reliable and prompt services to the students and job seekers. Global Guidelines give proper admission guidance for the students to join reputed colleges in India. We have acted as preferred job recruitment partners to multinational and leading businesses." />
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<script src="js/jquery-1.9.1.min.js"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-57045850-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
	</head>
	<body>
		<div class="gl-main-container gl-edu-enquiry">
			<header>
				<h1>Global Guidelines</h1>
				<div class="right"><img src="images/header_new/logo.png" width="140" height="60"/></div>
			</header>
			<nav>
				<ul>
					<li><a href="/">Home</a></li>
					<li>
						<a href="#">Education <span class="caret"></span></a>
						<div>
							<ul>
								<li><a href="#">Services</a></li>
								<li><a href="#">Enquiry</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#">Job <span class="caret"></span></a>
						<div>
							<ul>
								<li><a href="#">Current Openings</a></li>
								<li><a href="apply-job.php">Apply for Job</a></li>
							</ul>
						</div>
					</li>
					<li><a href="contact-us.html">Contact Us</a></li>
				</ul>
				<div class="gl-social-icons-container">
					<a href="https://www.facebook.com/globalguidelines" target="_blank"><img src="images/social-icons/facebook_24.png"/></a>
					<a href="https://twitter.com/globeguideline" target="_blank"><img src="images/social-icons/twitter_24.png"/></a>
					<a href="#"><img src="images/social-icons/linkedin_24.png"/></a>
					<a href="#"><img src="images/social-icons/googleplus_24.png"/></a>
				</div>
			</nav>
			
			<aside class="top">
				<div><img src="images/enquiry-top.jpg" width="120" height="200"/></div>
			</aside>
			<section>
				<h1>Education Enquiry</h1>
				<?php 
				if ($_SERVER["REQUEST_METHOD"] == "POST") {			
					processForm();					
				}
				?>
				<h4 class="errMsg" id="errMsg"></h4>
				<form id="edu-enquiryform" name="edu-enquiryform" method="post" enctype="multipart/form-data" onsubmit="return validateEduEnquiryForm()">
					<div class="row">
						<label>Name: </label>
						<input type="text" id="edu-username" name="edu-username"/>
					</div>
					<div class="row">
						<label>Interested In: </label>
						<select id="edu-enquirydegree" name="edu-enquirydegree">
							<option value="Bachelor Degree" selected="selected">bachelor degree</option>
							<option value="Master Degree">master degree</option>
						</select>
					</div>
					<div class="row">
						<label>Mobile Number: </label>
						<input type="text" id="edu-usercontactno" name="edu-usercontactno"/>
					</div>
					<div class="row">
						<label>Email Id: </label>
						<input type="text" id="edu-useremail" name="edu-useremail"/>
					</div>
					<div class="row">
						<label style="vertical-align: top;">Comments: </label>
						<textarea id="edu-usercomment" name="edu-usercomment"></textarea>
					</div>
					<div class="row">
						<label>&nbsp; </label>
						<input type="submit" value="Send" id="edu-submitbtn" name="edu-submitbtn"/>
					</div>
				</form>
			</section>
			
			<aside class="bottom">
				<div><img src="images/enquiry-bottom.png" width="135" height="185"/></div>
			</aside>
			
			<div style="clear:both;margin-bottom:-33px;">
				<img src="images/apply-job-bottom-new.jpg" width="790" height="90"/>
			</div>
			
			<footer>
				<p>Copyright &copy; 2014 - Global Guidelines - www.globalguidelines.in</p>
			</footer>
		</div>
		<script>
			function validateEduEnquiryForm() {
				var eduUserName = $('#edu-username').val(),
					eduUserContact = $('#edu-usercontactno').val(),
					eduUserEmail = $('#edu-useremail').val(),
					eduUserComment = $('#edu-usercomment').val(),
					errMsg = $('#errMsg');
				
				errMsg.html("");
				
				if ( $.trim(eduUserName) == "" || $.trim(eduUserContact) == "" || $.trim(eduUserEmail) == "" || $.trim(eduUserComment) == "" ) {
					errMsg.html("Please give all the details.");
					return false;
				}
				
				if(!/^\d{10}$/.test(eduUserContact)) {
					errMsg.html("Please give your 10 digit mobile contact number.");
					return false;
				}
				
				if(!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(eduUserEmail)) {
					errMsg.html("Please give valid email id.");
					return false;
				}
				
				return true;	
			}
		</script>
	</body>
</html>