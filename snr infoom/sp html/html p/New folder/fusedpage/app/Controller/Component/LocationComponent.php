<?php
App::uses('Component', 'Controller');
class LocationComponent extends Component{
    public $errors = array();
	public $service = 'api.ipinfodb.com';
	public $version = 'v3';
	
	public function getLocationDetails(){
		Controller::loadModel('IpAddress');
		$ret = '';
		$expArr = explode('.', IP_ADDRESS);
		$ip = $expArr[0].'.'.$expArr[1].'.'.$expArr[2];
		$ipArr = $this->IpAddress->find('first', array('conditions'=>array('IpAddress.ipAddress'=>$ip)));
		if(!empty($ipArr)){ //pr($ipArr);die;
			foreach($ipArr['IpAddress'] as $key => $val)
				$ret[$key] = $val;
		}else
			$ret = $this->saveIpDetails($ip);
		return $ret;
	}

	function saveIpDetails($ip){
		Controller::loadModel('IpAddress');

		$ret = '';
		
		$ipDetailsArr = $this->getAllLocationDetails();
		if(!empty($ipDetailsArr) && ($ipDetailsArr['statusCode'] == 'OK') && ($ipDetailsArr['countryCode'] != '-')){
			$ipDetailsArr['ipAddress'] = $ip;
			$this->IpAddress->save($ipDetailsArr, false);
			$ipDetailsArr['id'] = $this->IpAddress->id;
			$ret = $ipDetailsArr;
		}
		return $ret;
	}

	public function getAllLocationDetails(){
		$ip = IP_ADDRESS;
		$name = 'ip-city';
		if(preg_match('/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip)){
			$xmlUrl = 'http://'.$this->service.'/'.$this->version.'/'.$name.'/?key='.IP_LOCATION_API_KEY.'&ip='.$ip.'&format=xml';
			$xml = @file_get_contents($xmlUrl);
			try{
				$response = @new SimpleXMLElement($xml);
				foreach($response as $field=>$value)
					$result[(string)$field] = (string)$value;
				return $result;
			}catch(Exception $e){
				$this->errors[] = $e->getMessage();
				return;
			}
		}
		$this->errors[] = '"'.$ip.'" is not a valid IP address or hostname.';
		return;
	}

}
?>