<?php

class AjaxController extends AppController {
	
	var $uses = array('Accessmap');
	
	public function index() {
		$access = $this->Accessmap->find('all', array('limit' => 1000));
		foreach($access as &$point) {
			$point['Accessmap']['category'] = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$point['Accessmap']['category']))));
			$point['Accessmap']['subcategory'] = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$point['Accessmap']['subcategory']))));
		}
		echo json_encode($access);
		die();
	}
	
	public function data($category) {
		$data = $this->Accessmap->find('all', array('conditions' => array('category' => $category)));
		foreach($data as &$point) {
			$point['Accessmap']['category'] = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$point['Accessmap']['category']))));
			$point['Accessmap']['subcategory'] = strtolower(str_replace("&","and",str_replace(" ","_",str_replace("/","",$point['Accessmap']['subcategory']))));;
		}
		echo json_encode($data);
		
		die();
	}
	
}
?>



