<?php
class MemoryComponent // extends Object
{
	public $components = array('Session');

	// function initialize(&$Controller) {
	// 	$this->Controller = $Controller;
	// }

	public function readPagination($controller=null){
		if(is_null($controller)){
			return $this->Session->read("Pagem");
		} else {
			return $this->Session->read("Pagem.$controller");
		}
	}
	
	public function savePagination($params){
		//@todo: this doesn't work with assignments controller because it has multiple tables?
		if(!empty($params['named']) && !empty($params['controller']) && $params['action'] == 'admin_index'){
			$this->Session->write("Pagem.{$params['controller']}", $params['named']);
		}
	}
	
	public function deletePagination($controller){
	    $this->Session->del("Pagem.$controller");
	}

	public function prepareRedirect($params, $redirectTo){
		//pr($this->Controller);
		//pr($params);
		$redirectNew = "";
		if(is_array($redirectTo)){
			//pr($redirectTo);
			if(!empty($params['prefix']) && $params['prefix'] == 'admin'){
				$redirectNew .= '/admin';
			}
			if(!empty($params['controller'])){
				$redirectNew .= "/" . $params['controller'];
			}
			if(!empty($redirectTo['action'])){
				$redirectNew .= "/" . $redirectTo['action'];
			}
		} else {
			$redirectNew = $redirectTo;
		}
		//echo $redirectNew;

		$controller = $params['controller'];
		if($this->Session->check("Pagem.$controller")){
			$settings =  $this->Session->read("Pagem.$controller");
			$append = array();
			foreach($settings as $key=>$value){
				$append[] = "$key:$value";
			}
			//echo  join("/", $append);
			return $redirectNew . "/" . join("/", $append);
		} else {
			return $redirectNew;
		}
	}

}

?>
