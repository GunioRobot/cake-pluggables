<?php
/**
 * AauthComponent
 * 
 * Requirements:
 * - PHP5
 * - A model called User
 * - User table with the fields id, username, password, and level
 *  
 */
 
class AauthComponent extends Object {
    var $components = array('Session');
    var $successURL = '/admin/';
    var $allowedURLS = array('adminuserslogin','adminuserslogout');
    var $whiteListUrl = array();
    
    //called before Controller::beforeFilter()
	function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
		if(!empty($this->controller->successURL)){
		    $this->successURL = $this->controller->successURL;
		}
	}
	
	public function checkLogin($data, $crypt_method='sha1', $salt=''){
	    $user = ClassRegistry::init('User');
	    $fields = array('User.username', 'User.id', 'User.level', 'User.company_id');
	    $conditions = array();
	    $conditions['User.username'] = $data['User']['username'];
	    if($crypt_method == 'sha1'){
	        $conditions['User.password'] = sha1($data['User']['password']);
	    } elseif($crypt_method == 'md5'){
	        $conditions['User.password'] = md5($data['User']['password']);
        }
	    
	    $login = $user->find('first', array('conditions'=>$conditions, 'fields'=>$fields));
	    if(!empty($login)){
	        $this->_setupLogin($login);
	        return $this->controller->redirect($this->successURL);
	    } else{
	        $this->controller->set('error', __('Login Error', true));
	    }
	    return false;
	}
	
	private function _setupLogin($login){
	    $this->Session->write('User', $login['User']);
	}
	
	public function logout(){
	    $this->Session->destroy();
        return $this->controller->redirect('/admin/users/login');
    }
    
    public function checkAuth($level = 2){
        if(!in_array(str_replace(array("/","1", "2", "3", "4", "5", "6", "7", "8", "9", "0"),
            "",strtolower($this->controller->params['url']['url'])), $this->allowedURLS)){
            if(!$this->Session->check('User.level') OR $this->Session->read('User.level') < $level){
                return $this->controller->redirect('/admin/users/login');
            }
        }
    }
    public function setAllowedUrls($whitelist){
        $this->allowedURLS = $whitelist;
    }
    
}
?>