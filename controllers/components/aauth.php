<?php
/**
 * AauthComponent
 * A simpler auth plugin used in place of the cake ACL. This component uses a simple
 * hierarchy of admin levels to determine the permissions. Users can set a minimum 
 * level to access all admin pages and can also set different permissions on certain
 * controller methods.
 * 
 * 
 * Requirements:
 * - PHP5
 * - CakePHP 1.2
 * - A model called User
 * - users table with the fields id, username, password, and level
 *  
 */
 
class AauthComponent extends Object
{
    var $components = array('Session');
    var $successURL = '/admin/';
    var $allowedURLS = array('adminuserslogin','adminuserslogout', 'userslogin', 'userslogout');
    var $whiteListUrl = array();
    var $loginURL = '/admin/users/login';
    var $loginFields = array('User.username', 'User.id', 'User.level');
    
    //called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array())
	{
		// saving the controller reference for later use
		$this->controller =& $controller;
		if(!empty($this->controller->successURL)){
		    $this->successURL = $this->controller->successURL;
		}
	}
	
	public function checkLogin($data, $crypt_method='sha1', $salt=false)
	{
	    $user = ClassRegistry::init('User');
	    $conditions = array();
	    $conditions['User.username'] = $data['User']['username'];
	    
	    //append the Security.salt defined in your app/config/core.php
	    if($salt){
	        $data['User']['password'] .= Configure::read('Security.salt');
	    }
	    
	    if($crypt_method == 'sha1'){
	        $conditions['User.password'] = sha1($data['User']['password']);
	    } elseif($crypt_method == 'md5'){
	        $conditions['User.password'] = md5($data['User']['password']);
        }
	    
	    $login = $user->find('first', array('conditions'=>$conditions, 'fields'=>$this->loginFields));
	    if(!empty($login)){
	        $this->_setupLogin($login);
	        return $this->controller->redirect($this->successURL);
	    } else{
	        $this->controller->set('error', __('Login Error', true));
	    }
	    return false;
	}
	
	private function _setupLogin($login)
	{
	    $this->Session->write('User', $login['User']);
	}
	
	public function logout()
	{
	    $this->Session->destroy();
        return $this->controller->redirect($this->loginURL);
    }
    
    public function checkAuth($level = 2)
    {
        if(!in_array(str_replace(array("/","1", "2", "3", "4", "5", "6", "7", "8", "9", "0"),
            "",strtolower($this->controller->params['url']['url'])), $this->allowedURLS)){
            if(!$this->Session->check('User.level') OR $this->Session->read('User.level') < $level){
                return $this->controller->redirect($this->loginURL);
            }
        }
    }
    
    public function setAllowedUrls($whitelist)
    {
        $this->allowedURLS = $whitelist;
    }
    
}
?>