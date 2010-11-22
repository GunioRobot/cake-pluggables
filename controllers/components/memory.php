<?php
class MemoryComponent
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
		if(!empty($params['named']) && !empty($params['controller']) && $params['action'] == 'admin_index'){
			$this->Session->write("Pagem.{$params['controller']}", $params['named']);
		}
	}
	
	public function deletePagination($controller){
	    $this->Session->delete("Pagem.$controller");
	}

	public function prepareRedirect($params, $redirectTo){
		$redirectNew = "";
		if(is_array($redirectTo)){
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

		$controller = $params['controller'];
		if($this->Session->check("Pagem.$controller")){
			$settings =  $this->Session->read("Pagem.$controller");
			$append = array();
			foreach($settings as $key=>$value){
				$append[] = "$key:$value";
			}
			return $redirectNew . "/" . join("/", $append);
		} else {
			return $redirectNew;
		}
	}

}

?>
