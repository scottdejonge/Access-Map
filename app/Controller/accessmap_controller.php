<?php
class AccessmapController extends AppController {
	
	var $uses = array('Accessmap');

	public function index() {
		ini_set('memory_limit','64M');
		$access = $this->Accessmap->find('all');
		$this->set('access',$access);
	}
	
	/*
public function generatelatlong() {
		$points = $this->Accessmap->find('all',array('limit'=>100,'conditions'=>array('latitude'=>'','longitude'=>'')));
		foreach($points as $point) {
			$locationstring = str_replace(" ","+",$point['Accessmap']['location'].', '.$point['Accessmap']['suburb'].', Queensland');
			$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$locationstring."&sensor=true";
			$data = json_decode(file_get_contents($url));
			if(sizeOf($data->results) > 0) {
				$this->Accessmap->id = $point['Accessmap']['id'];
				$this->Accessmap->saveField('latitude',$data->results[0]->geometry->location->lat);
				$this->Accessmap->saveField('longitude',$data->results[0]->geometry->location->lng);
				echo "SAVED - ".$point['Accessmap']['location']."<br />";
			} else {
				echo 'COULDNT SAVE - '.$point['Accessmap']['location']."<br />";
			}
		}
	}
*/
	
	
}
?>



