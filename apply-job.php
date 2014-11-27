<?php
function mail_attachment($jobUserName, $jobCategory, $jobUserContact, $jobUserEmail) {
	$uid = md5(uniqid(time()));
	$subject = 'Apply Job Notification - '.$jobUserName;
	$from_name = 'Global Guidelines';
	$from_mail = 'info@globalguidelines.in';
	$replyto = 'info@globalguidelines.in';
	$mailto = 'globalguidelines@gmail.com';
	$message = '<body>
				<div style="border:1px solid #3E4A7B;">
             	<div style="background-color:#8A82BD; padding:8px; color:#FFFFFF; font-family:Arial, Helvetica, sans-serif; font-size:16px">Global Guidelines - Job Application</div>
			 	<div style="padding:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:1.5;">Applicant Name :  '.$jobUserName.'<br/>Category : '.$jobCategory.'<br/>Contact no : '.$jobUserContact.'<br/>Email Id : '.$jobUserEmail.'<br/></div>
			 	</div>
			 	</body>';
	
	$header = "From: ".$from_name." <".$from_mail.">\r\n";
	$header .= "Reply-To: ".$replyto."\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
	$header .= "This is a multi-part message in MIME format.\r\n";
	$header .= "--".$uid."\r\n";
	$header .= "Content-type:text/html; charset=iso-8859-1\r\n";
	$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	$header .= $message."\r\n\r\n";
	
    $file = $_FILES['job-userresume']['tmp_name'];
    $filename = $_FILES['job-userresume']['name'];
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));

    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: ".$_FILES['job-userresume']['type']."; name=\"".$filename."\"\r\n"; // application/octet-stream
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
	
	$header .= "--".$uid."--";
	return mail($mailto, $subject, "", $header);
}

function processForm() {
					
	/* GET Form Variables */
	$jobUserName = $_POST["job-username"];
	$jobCategory = $_POST["job-usercategory"];
	$jobUserContact = $_POST["job-usercontactno"];
	$jobUserEmail = $_POST["job-useremail"];
	
	if (empty($jobUserName) || empty($jobCategory) || empty($jobUserContact) || empty($jobUserEmail)) {
		echo "<h4 class='errMsg'>Please give all the details.</h4>";
		return;
	}
	
	if (!empty($jobUserName) && !preg_match("/^[a-zA-Z ]*$/",$jobUserName)) {
		echo "<h4 class='errMsg'>Name field allowed only letters and white space.</h4>";
		return;
	}
	
	if (!empty($jobUserContact) && !preg_match("/^\d{10}$/",$jobUserContact)) {
		echo "<h4 class='errMsg'>Please give your 10 digit mobile contact number.</h4>";
		return;
	}
	
	if (!empty($jobUserEmail) && !filter_var($jobUserEmail, FILTER_VALIDATE_EMAIL)) {
		echo "<h4 class='errMsg'>Please give valid email id.</h4>";
		return;
	}
	
	if($_FILES['job-userresume']['error'] == 4) {
		echo "<h4 class='errMsg'>Please upload your resume.</h4>";
		return;
	}
	
	/* GET File Variables */ 
	$tmpName = $_FILES['job-userresume']['tmp_name']; 
	$fileType = $_FILES['job-userresume']['type']; 
	$fileName = $_FILES['job-userresume']['name'];
	$fileSize = $_FILES["job-userresume"]["size"];
	$fileFormat = pathinfo($fileName,PATHINFO_EXTENSION);
	
	if (empty($fileFormat) || ($fileFormat != "doc" && $fileFormat != "docx")) {
		echo "<h4 class='errMsg'>Sorry, only .doc and .docx format files are allowed.</h4>";
		return;
	}
	
	if ($fileSize > 400000) {
		echo "<h4 class='errMsg'>Sorry, file size is large, only below 400kb size are allowed.</h4>";
		return;
	}
	
	$mail_sent = mail_attachment($jobUserName, $jobCategory, $jobUserContact, $jobUserEmail);
	
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
		<div class="gl-main-container gl-aply-job">
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
								<li><a href="education-enquiry.php">Enquiry</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#">Job <span class="caret"></span></a>
						<div>
							<ul>
								<li><a href="#">Current Openings</a></li>
								<li><a href="#">Apply for Job</a></li>
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
			
			<aside>
				<div><img src="images/apply-for-a-job.png" width="232" height="350"/></div>
			</aside>
			<section>
				<h1>Looking for a Job Apply Here</h1>
				<?php 
				if ($_SERVER["REQUEST_METHOD"] == "POST") {			
					processForm();					
				}
				?>
				<h4 class="errMsg" id="errMsg"></h4>
				<form id="job-applyform" name="job-applyform" method="post" enctype="multipart/form-data" onsubmit="return validateApplyJobForm()">
					<div class="row">
						<label>Name: </label>
						<input type="text" id="job-username" name="job-username"/>
					</div>
					<div class="row">
						<label>Category: </label>
						<select id="job-usercategory" name="job-usercategory">
							<option value="Fresher" selected="selected">fresher</option>
							<option value="Experience">experience</option>
						</select>
					</div>
					<div class="row">
						<label>Mobile Number: </label>
						<input type="text" id="job-usercontactno" name="job-usercontactno"/>
					</div>
					<div class="row">
						<label>Email Id: </label>
						<input type="text" id="job-useremail" name="job-useremail"/>
					</div>
					<div class="row">
						<label>Attach Your Resume: </label>
						<input type="file" id="job-userresume" name="job-userresume" title="choose doc or docx format files"/>
					</div>
					<div class="row">
						<label>&nbsp; </label>
						<input type="submit" value="Submit" id="job-submitbtn" name="job-submitbtn"/>
					</div>
				</form>
			</section>
			
			<div style="clear:both;margin-bottom:-33px;">
				<img src="images/apply-job-bottom-new.jpg" width="790" height="90"/>
			</div>
			
			<footer>
				<p>Copyright &copy; 2014 - Global Guidelines - www.globalguidelines.in</p>
			</footer>
		</div>
		<script>
			function validateApplyJobForm() {
				var jobUserName = $('#job-username').val(),
					jobUserContact = $('#job-usercontactno').val(),
					jobUserEmail = $('#job-useremail').val(),
					jobUserFile = $('#job-userresume').val(),
					errMsg = $('#errMsg');
				
				errMsg.html("");
				
				if ( jobUserName == "" || jobUserContact == "" || jobUserEmail == "" || jobUserFile == "" ) {
					errMsg.html("Please give all the details.");
					return false;
				}
				
				if(!/^\d{10}$/.test(jobUserContact)) {
					errMsg.html("Please give your 10 digit mobile contact number.");
					return false;
				}
				
				if(!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(jobUserEmail)) {
					errMsg.html("Please give valid email id.");
					return false;
				}
				
				if(!/(\.docx|\.doc)$/i.test(jobUserFile)) {
					errMsg.html("Sorry, only .doc and .docx format files are allowed.");
					return false;
				}
				
				return true;	
			}
		</script>
	</body>
</html>