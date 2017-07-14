<?php
class RlabRequest{

	/**
	 * @var array
	 */
	public $key;
	//public $value=array();	
	public $value;
	//public $result=array($key=>$value);
	
	//public $extra=array($key=>$extras=array());

	public function set_result($name,$data){
		
		$this->key=$name;
		$this->value=$data;
	}
	public function get_result(){
		return $this->key;
	}
	
}
?>