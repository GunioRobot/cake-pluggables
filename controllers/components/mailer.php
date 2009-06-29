<?php

require_once 'plugins/jqcake/vendors/phpmailer/class.phpmailer.php';
require_once 'plugins/jqcake/vendors/phpmailer/class.smtp.php';

class MailerComponent extends PHPMailer
{
    public $controller = true;
	public $CharSet           = "utf-8";
	public $Encoding          = "7bit";
	public $SMTPAuth = true;     // turn on SMTP authentication
	public $WordWrap = 40;
	public $ContentType = 'text/html';
	
	/**
	* Test To/From
	* 
	*/
	public $TestTo;
	public $TestFrom;
	public $TestFromName;

    /**
     * SMPT Host
     *
     * @var string
     * @access public
     * @see setAuth()
     */
    public $Host = '';

    /**
     * SMPT Username
     *
     * @var string
     * @access public
     * @see setAuth()
     */
    public $Username = '';

    /**
     * SMPT Password
     *
     * @var string
     * @access public
     * @see setAuth()
     */
    public $Password = '';

    /**
     * mail authentication setter
     *
     * Informs the mail component which credentials are to be used to
     * complete a mail transaction
     *
     * @param string $user smtp username
     * @param string $pass smtp passowrd
     * @param string $host smtp hostname, defaults to localhost
     *
     * @access public
     * @return void
     * @see $Password, $Username, $Host, sendMessage()
     */
    public function setAuth($user, $pass, $host = 'localhost')
    {
        $this->Username = $user;
        $this->Password = $pass;
        $this->Host = $host;
    }

    public function hasAuth()
    {
        $user = ($this->Username != '');
        $pass = ($this->Password != '');
        return ($user && $pass);
    }
    
    /**
     * Attach files to the Mailer object
     *
     * @param string $filename
     * @param string $asfile
     * @access public
     */
    public function attach($filename, $asfile = '') {
      if (empty($this->attachments)) {
        $this->attachments = array();
        $this->attachments[0]['filename'] = $filename;
        $this->attachments[0]['asfile'] = $asfile;
      } else {
        $count = count($this->attachments);
        $this->attachments[$count+1]['filename'] = $filename;
        $this->attachments[$count+1]['asfile'] = $asfile;
      }
    }
	
	public function setDefaults($message){
	    $this->ClearAllRecipients();
	    if(empty($message['toEmail'])){
	        $this->AddAddress($this->TestTo);
	    }
	    if(empty($message['fromEmail'])){
		    $this->From = $this->TestFrom;
		    $this->FromName = $this->TestFromName;
		}
	}
	
	public function setupMessage($message){
	    // mail processing
		$this->setDefaults($message);
				
		if(!empty($message['fromEmail'])){
		    $this->From = $message['fromEmail'];
		}
		if(!empty($message['fromName'])){
		    $this->FromName = $message['fromName'];
		}
		if(!empty($message['toEmail'])){
		    $toEmail = $message['toEmail'];
		    $toName = '';
		    if(!empty($message['toName'])){
    		    $toName = $message['toName'];
    		}
		    $this->AddAddress($toEmail, $toName);
		}
		
		$this->Subject = $message['subject'];
		$msg = $message['body'];
		$this->IsMail();
		
		//added content type html to default vars
		//$this->IsHTML(true);
		$this->Body = $msg;

		//set charset
		if(!empty($message['CharSet'])){
			$this->CharSet = $message['CharSet'];
		}
		
		//if cc mail is not blank (isset) add a CC
		if(!empty($message['ccEmail'])){
			$this->AddAddress($message['ccEmail']);
		}
		
		//if bcc mail is not blank (isset) add a BCC
		if(!empty($message['bccEmail'])){
			$this->AddBCC($message['bccEmail'], "Tester");
		}
	}

    /**
     * email message sender
     *
     * @param array $message not really a message but a collection of
     * settings to use as smtp headers
     *
     * @access public
     * @return void
     * @throws Exception
     * @see setAuth(), $Username, $Password, $Host
     */
	function sendMessage()//$application)
	{
	    //if debug level is 2 then dont send
	    if(Configure::read('debug') == 2){
	        $this->ClearAllRecipients();
            return true;
	    }   
	    
        // validate
        $msg = 'Error!! Cannot send mail, credentials okay?';
        if (!$this->hasAuth()) throw new Exception($msg);
        $msg = null;
        
        //$this->attachAll();
		if($this->Send()){
			$this->ClearAllRecipients();
			return true;
		}else{
			$this->ClearAllRecipients();
			return false;
		}

	}
	
	function attachAll(){
        if (!empty($this->attachments)) {
          foreach ($this->attachments as $attachment) {
            if (empty($attachment['asfile'])) {
              $this->AddAttachment($attachment['filename']);
            } else {
              $this->AddAttachment($attachment['filename'], $attachment['asfile']);
            }
          }
        } 
	}
	
}

?>