<?php
include 'class.phpmailer.php';
include 'class.smtp.php';
class MailerComponent extends PHPMailer
{
    var $controller = true;
	var $CharSet           = "utf-8";
	var $Encoding          = "7bit";
	var $Host = "localhost";  // specify main and backup server
	var $SMTPAuth = true;     // turn on SMTP authentication
	var $Username = "anasumai-mail";  // SMTP username
	var $Password = "atm17"; // SMTP password
	var $WordWrap = 40;  
	
	function startup(&$controller)
    {
        // This method takes a reference to the controller which is loading it.
        // Perform controller initialization here.
    }
	
	function sendMessage($message)//$application)
	{
		
		$fromEmail = $message['fromEmail'];
		$fromName = $message['fromName'];
		$toEmail = $message['toEmail'];
		$toName = $message['toName'];
		$msg = $message['body'];
		$this->IsMail();
		//$this->IsHTML(true);
		$this->From = $fromEmail;
		$this->FromName = $fromName;
		$this->AddAddress($toEmail, $toName);

		//set charset
		if(isset($message['CharSet'])){
			$this->CharSet = $message['CharSet'];
		}
		
		//if cc mail is not blank (isset) add a CC
		if(isset($message['ccEmail'])){
			$this->AddAddress($message['ccEmail']);
		}
		
		//if bcc mail is not blank (isset) add a BCC
		if(isset($message['bccEmail'])){
			$this->AddBCC($message['bccEmail'], "Tester");
		}
		//$this->AddReplyTo($fromEmail, $fromName);
		$this->Subject = $message['subject'];
		$this->Body = $msg;
		//pr($this);

		if($this->Send()){
			$this->ClearAllRecipients();
			return true;
		}else{
			$this->ClearAllRecipients();
			return false;
		}

	}
	
}
?>