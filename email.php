<?php
/** Get emails from the query string **/
$emails = $_GET['emails'] ?? null;

/** If there are nor emails stop the code execution with message **/
if($emails == null) {
	die('No email addresses found! You can add emails to the query string i.e. ?emails=[emails_separated_by_comma]');
}

/** Split emails by comma (if any) to form an array **/
if(strpos($emails, ',')) {
	$arrEmails = explode(',', $emails);
} else {
	$arrEmails[] = $emails;
}

/** Initialize the $subject and the $message variables here **/
$subject = 'Test via PHP';
$message = 'Lorem ispum dolor sit amet';

/** Set the headers here **/
$headers  = "From: Example <info@example.com>\n";
$headers .= "X-Sender: Example <info@example.com>\n";
$headers .= 'X-Mailer: PHP/' . phpversion();
$headers .= "X-Priority: 1\n"; // Urgent message!
$headers .= "Return-Path: info@example.com\n"; // Return path for errors
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=iso-8859-1\n";

/** Loop through the array of emails **/
foreach($arrEmails as $toEmail) {
	/** Validate the email **/
	if (filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
		$mail = mail(trim($toEmail), $subject, $message, $headers);

		if($mail) {
			$sendEmails[] = $toEmail;
		} else {
			$notSendEmails[] = $toEmail;
		}
	} else {
		$notSendEmails[] = $toEmail;
	}
}

/** Display the emails sent **/
if(!empty($sendEmails)) {
	echo '<strong>Email(s) sent to:</strong><br> ' . implode('<br>', $sendEmails);
	echo '<br><br>';
}

/** Display the emails not sent **/
if(!empty($notSendEmails)) {
	echo '<strong>Couldn\'t send email(s) to:</strong><br> ' . implode('<br>', $notSendEmails);
}