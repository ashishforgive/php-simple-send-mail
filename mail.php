<?php
//(C)opyright 2017 by Andris Roling
//GIT https://github.com/andrisro/REST-PHP-Mailer

//Version: 1.2

//Predefined Variables
$to = "info@magicalindiajourney.com,akmashish15@gmail.com, jkgude@gmail.com";
$prefixSubject = "New Query from website";
$prefixMailBody = "Please find the new enquiry
";


// Empty variables, will be filled by script
$from = ""; 
$subject = ""; 
$message = ""; 

/*
	Check Variables, Would Prefer POST-Method, because it is more secure if you communicate with HTTPS
	You can call the Script by POST and GET Method by default.
*/
if(isset($_POST["from"]) && isset($_POST["subject"]) && isset($_POST["message"])) {
	//Set Variables
	$from = urldecode($_POST["from"]);
	$subject = urldecode($_POST["subject"]);
	$message = urldecode($_POST["message"]);

} else if(isset($_GET["from"]) && isset($_GET["subject"]) && isset($_GET["message"])) {
	//Set Variables
	$from = urldecode($_GET["from"]);
	$subject = urldecode($_GET["subject"]);
	$message = urldecode($_GET["message"]);
} else if(isset($_REQUEST["from"]) && isset($_REQUEST["subject"]) && isset($_REQUEST["message"])) {
	$from = urldecode($_REQUEST["from"]);
	$subject = urldecode($_REQUEST["subject"]);
	$message = urldecode($_REQUEST["message"]);	
} else {
	$requestbody = file_get_contents("php://input");
	
	//die(json_encode($requestbody));
	$decodedbody = array();
	$decodedbody = json_decode($requestbody,true);
	
	if(isset($decodedbody["from"]) && isset($decodedbody["subject"]) && isset($decodedbody["message"])) {
		$from = $decodedbody["from"];
		$subject = $decodedbody["subject"];
		$message = $decodedbody["message"];
	} else {
		die(json_encode("wrong_params"));
	}
}

$subject = $prefixSubject.$subject;
$message = $prefixMailBody.$message;

//Execute Mail
$headers = "From: ".addslashes($from)."\r\n";

if (mail($to, $subject, $message, $headers)) {
	echo(json_encode("mail_send"));
	$to, $subject, $message, $headers
} else {
	echo(json_encode("sending_failed"));
	echo $to;
	echo $subject;
	echo  $message;
	echo  $headers; 
}


 ?>