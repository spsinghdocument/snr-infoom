<?php
App::uses('Component', 'Controller');
class FpComponent extends Component{
	public $components = array('Session', 'Cookie', 'Auth');

	//FUNCTION FOR ENCRYPTION START
	public function encrypt($data){
		return base64_encode($data);
	}
	

			
	
	
	
	
	//FUNCTION FOR ENCRYPTION END

	//FUNCTION FOR DECRYPTION START
	public function decrypt($data){
		return base64_decode($data);
	}
	//FUNCTION FOR DECRYPTION END
   
   //FUNCTION TO GENERATE PASSWORD START
   public function createTempPassword($len){
		$pass = '';
		$lchar = 0;
		$char = 0;
		for($i = 0; $i < $len; $i++){
			while($char == $lchar){
				$char = rand(48, 109);
				if($char > 57) $char += 7;
				if($char > 90) $char += 6;
			}
			$pass .= chr($char);
			$lchar = $char;
		}
		return $pass;
	}
   //FUNCTION TO GENERATE PASSWORD END

   //FUNCTION FOR PARSING THE URL START
	public function parseParameter($title){
		$title = trim(strtolower($title), '.');
		$title = trim($title, '-');
		$newParameter = str_replace(array('/',' ',',','.',':',"'",'?','!','&','#39;'), array('-'), $title);
		return $newParameter;
	}

	public function parseParameterNew($title){
		$title = strtolower(trim($title));
		$title = str_replace(' ', '-', $title);
		$newParameter = str_replace(array('/',' ',',','.',':',"'",'?','!','&','#39;'), array('-'), $title);
		return $newParameter;
	}
   //FUNCTION FOR PARSING THE URL END

   //FUNCTION FOR INCREMENTING A FIELD START
   public function incrementField($model, $field, $operator, $id){
	   Controller::loadModel($model);
	   $this->$model->updateAll(array($model.'.'.$field => $model.'.'.$field.$operator.'1'), array($model.'.id'=>$id));
   }
   //FUNCTION FOR INCREMENTING A FIELD END

   //FUNCTION FOR VALIDATING ADMIN LOGIN START
   public function validateAdmin(){
	   $ret = '';
	   if($this->Session->check('Auth.Admin')){
		  $ret = '/admin/admins/dashboard/';
	   }
	   return $ret;
   }
   //FUNCTION FOR VALIDATING ADMIN LOGIN END

   //FUNCTION FOR VALIDATING ADMIN LOGIN START
   public function validateUser(){
	   $ret = '';
	   if($this->Session->check('Auth.User')){
		  $ret = '/users/wall/';
	   }
	   return $ret;
   }
   //FUNCTION FOR VALIDATING ADMIN LOGIN END	

   //FETCH LATITUDES & LONGITUDES START
   public function fetchLatLongs($suburbId, $stateId){
	    set_time_limit(0);		
		Controller::loadModel('State');
		Controller::loadModel('Suburb');

		$ret = '';
		$address = '';

		$suburbArr = $this->Suburb->findById($suburbId);
		$address = $suburbArr['Suburb']['postcode'].', '.$suburbArr['Suburb']['suburb'];

		$stateArr = $this->State->findById($stateId);
		$address .= ', '.$stateArr['State']['code'].', Australia';

		if($address != ''){
			$googleURL='http://maps.google.com/maps/api/geocode/json?address=';
			$geocode=file_get_contents($googleURL.urlencode($address).'&sensor=false');
			$output= json_decode($geocode);
			$ret['latitude'] = $output->results[0]->geometry->location->lat;
			$ret['longitude'] = $output->results[0]->geometry->location->lng;
		}
		return $ret;
   }
   //FETCH LATITUDES & LONGITUDES END

	//FUNCTION FOR FETCHING THE SCROLL PAGINATION START
	public function set_scroll_pagination_data($model, $lastViewedPage, $offset, $conditions, $order){
	   Controller::loadModel($model);

	   $limitArr = ($lastViewedPage * $offset).','.$offset;

	   $faqArr = $this->$model->find('all', array('conditions'=>$conditions, 'order'=>$order, 'limit'=>$limitArr));
	   return $faqArr;
   }
	//FUNCTION FOR FETCHING THE SCROLL PAGINATION END

	//FUNCTION FOR CREATING A COOKIE START
	public function createCookie($name, $arr, $time){
		$this->Cookie->write($name, $arr, false, $time);
	}
	//FUNCTION FOR CREATING A COOKIE END

	//FUNCTION FOR VALIDATING THE COOKIE START
	public function validateCookie($model, $name){
		Controller::loadModel($model);

		$cookieArr = '';
		$cookieArr = $this->Cookie->read($name);
		if(!empty($cookieArr)){ //pr($cookieArr);die;
			$conditions = '';
			foreach($cookieArr as $key => $val){ //echo $key.' => '.$val;die;
				$conditions[$model.'.'.$key] = $val;
			}
			$conditions[$model.'.status'] = '1';

			$modelArr = $this->$model->find('first', array('conditions'=>$conditions));
			if(!empty($modelArr)){
				if($modelArr[$model]['status'] == '1'){
					if($this->Auth->login($modelArr))
						return true;
					else
						$this->Cookie->delete($name);
				}else
					$this->Cookie->delete($name);
			}else
				$this->Cookie->delete($name);
		}
	}
	//FUNCTION FOR VALIDATING THE COOKIE END

	//FUNCTION TO UPLOAD THE FILE START
	function uploadFiles($path, $ext, $formData){
		$filename = $this->createTempPassword(15).'.'.$ext;
		$url = $path.$filename;
		
		if(move_uploaded_file($formData['tmp_name'], $url))
			return $filename;
		else
			return '';
	}
	//FUNCTION TO UPLOAD THE FILE END

	//FUNCTION TO UPLOAD THE FILE START
	function uploadFile($path, $fileData){ 
		//find file extention
		$extArr = explode('.',  $fileData['name']);
		$ext = end($extArr);

		$filename = $this->createTempPassword(15).'.'.$ext;
		$url = $path.$filename;
		
		if(move_uploaded_file($fileData['tmp_name'], $url))
			return $filename;
		else
			return '';
	}
	//FUNCTION TO UPLOAD THE FILE END

	//FUNCTION FOR PAYPAL CREDIT CARD PAYMENT START
	function PPHttpPost($methodName_, $nvpStr_){ //echo $methodName_.', '.$nvpStr_;die;
		Controller::loadModel('PaypalSetting');

		$paymentArr = $this->PaypalSetting->find('first', array('conditions'=>array('PaypalSetting.status'=>'1')));
		if($paymentArr['PaypalSetting']['mode_type'] == 'Testing'){
			$settingId = 1;
			$environment = 'sandbox';
		}else{
			$settingId = 2;
			$environment = 'live';
		}
		
		$paypalSettingsArr = $this->PaypalSetting->find('first', array('conditions'=>array('PaypalSetting.id'=>$settingId))); 

		$API_UserName = urlencode($paypalSettingsArr['PaypalSetting']['user_name']);
		$API_Password = urlencode($paypalSettingsArr['PaypalSetting']['password']);
		$API_Signature = urlencode($paypalSettingsArr['PaypalSetting']['signature']);
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
		if('sandbox' ===  $environment || 'beta-sandbox' === $environment){
			$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		}
		$version = urlencode('51.0');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);

		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

 		$httpResponse = curl_exec($ch);

		if(!$httpResponse){
			$errorDes = "<span style='color:red;'>$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')'."</span>";
			exit($errorDes);
		}

		$httpResponseAr = explode("&", $httpResponse);
		$httpParsedResponseAr = array();
		foreach($httpResponseAr as $i => $value){
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1){
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}

		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)){
			$errorDes_1 = "<span style='color:red;'>Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.</span>";
			exit($errorDes_1);
		}
		return $httpParsedResponseAr;
	}
	//FUNCTION FOR PAYPAL CREDIT CARD PAYMENT END

	//FUNCTION FOR VALIDATING THE BUSINESS MEMBERSHIP START
	function validateBusinessMembership($business_id){
		Controller::loadModel('Business');

		$ret = '';

		$this->Business->recursive = -1;
		$businessArr = $this->Business->findById($business_id);
		if(!empty($businessArr)){
			//condition 1: if business is claimed
			if(!empty($businessArr['Business']['user_id'])){
				$ret = $businessArr['Business']['user_id'];

				//condition 2: Is logged in user is the owner of the corresponding buisness
				if($businessArr['Business']['user_id'] != $this->Session->read('Auth.User.User.id'))
					$ret = $businessArr['Business']['user_id'];
				else
					$ret = '';
			}
		}
		return $ret;
	}
	//FUNCTION FOR VALIDATING THE BUSINESS MEMBERSHIP END

	//FETCH THE USER_ID OF THE CORRESPONDING BUSINESS START
	public function fetchCorrespondingBusinessUser_id($business_id){
		Controller::loadModel('Business');

		$ret = '';
		$this->Business->recursive = -1;
		$businessArr = $this->Business->findById($business_id);
		if(!empty($businessArr))
			$ret = $businessArr['Business']['user_id'];
		return $ret;
	}
	//FETCH THE USER_ID OF THE CORRESPONDING BUSINESS START

	/*-------------------------------------------------  VIDEO SECTION START -------------------------------------------------*/
	//FUNCTION FOR TESTING THE FFMPEG START
	public function test_mpeg(){
		$ffmpeg = '';
		$ffmpeg = trim(shell_exec('which ffmpeg')); 
		$ret = 'true';
		if($ffmpeg == '')
			$ret = 'false';
		return $ret;
	}
	//FUNCTION FOR TESTING THE FFMPEG END


	//FUNCTION FOR CONVERTING A VIDEO FILE TO FLV END
	public function convert_to_flv($input, $output){
		$shellCommand = "ffmpeg -i ".$input."-ar 22050 -ab 32 -f flv -s 320x240 ".$output;
		$convert_video = exec($shellCommand, $ret);

		//check for the presence of flv file whether created or not
		$return = 'false';
		if(is_file($output))
			$return = 'true';
		return $return;
	}
	//FUNCTION FOR CONVERTING A VIDEO FILE TO FLV END

	//FUNCTION FOR MAKING AN IMAGE OF A VIDEO FILE START
	public function snap_from_video($input, $output){
		$shellCommand = "ffmpeg -i ".$input." -an -ss 00:00:05 -r 1 -vframes 1 -f mjpeg -y ".$output;
		$convert_image = exec($shellCommand, $ret);

		//check for the presence of flv file whether created or not
		$return = 'false';
		if(is_file($output))
			$return = 'true';
		return $return;
	}
	//FUNCTION FOR MAKING AN IMAGE OF A VIDEO FILE END

	//FUNCTION FOR UPLOADING A VIDEO START
	public function upload_major_videos($videoPath, $imagePath, $fileData){
		//find file extention
		$return = '';
		$extArr = explode('.',  $fileData['name']);
		$ext = strtolower(end($extArr));

		$allowedVideoExtensions = array('mpg', 'wma', 'mov', 'flv', 'mp4', 'wmv');
		if(in_array($ext, $allowedVideoExtensions)){
			$filename = $this->createTempPassword(15);
			$videoUrl = $videoPath.$filename.'.'.$ext;
			$targetVideoFile = '';

			if(move_uploaded_file($fileData['tmp_name'], $videoUrl)){
				$targetVideoFile = $videoPath.$filename.'.flv';
				if($this->test_mpeg() == 'true'){ //test the ffmpeg server configuration
					if($ext != 'flv'){ //if uploaded file is not flv, then convert to flv
						if($this->convert_to_flv($videoUrl, $targetVideoFile) == 'true'){ //delete the original file
							unlink($videoUrl);
						}
					}else{ //take snapshot from video
						$targetImageUrl = $imagePath.$filename.'.jpg';
						$this->snap_from_video($targetVideoFile, $targetImageUrl, $fromdurasec="01");
					}
				}
			}
			if($targetVideoFile != ''){
				$return = $filename.'.flv';
			}
		}
		return $return;
	}
	//FUNCTION FOR UPLOADING A VIDEO END
	/*-------------------------------------------------  VIDEO SECTION END -------------------------------------------------*/

	//FETCH THE CORRESPONDING BUSINESS MEMBERSHIP PLAN START 6/1/2013
	public function fetchBusinessMembershipPlan($businerss_id){
		Controller::loadModel('PurchasedMembership');

		/* $ret = '1';

		$this->PurchasedMembership->recursive = -1;
		$businessArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$businerss_id), 'limit'=>1, 'order'=>array('PurchasedMembership.id'=>'DESC'))); //pr($businessArr);die;
		if(!empty($businessArr)){
			//first, check the expiration date
			$todayDate = strtotime(date('Y-m-d'));
			$expiryDate = strtotime(date('Y-m-d', strtotime($businessArr['PurchasedMembership']['expires_on'])));

			if($todayDate <= $expiryDate){
				$ret = $businessArr['PurchasedMembership']['membership_id'];
			}
		}
		return $ret; */

		$ret = '0';

		$this->PurchasedMembership->recursive = -1;
		$businessArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$businerss_id), 'limit'=>1, 'order'=>array('PurchasedMembership.id'=>'DESC'))); //pr($businessArr);die;
		if(!empty($businessArr)){
			//first, check the expiration date
			$todayDate = strtotime(date('Y-m-d'));
			$expiryDate = strtotime(date('Y-m-d', strtotime($businessArr['PurchasedMembership']['expires_on'])));

			if($todayDate <= $expiryDate){
				$ret = $businessArr['PurchasedMembership']['membership_id'];
			}else{
				$ret = '1';
			}
		}
		return $ret;
	}
	//FETCH THE CORRESPONDING BUSINESS MEMBERSHIP PLAN END 6/1/2013

	//WRITE FILE FROM ANOTHER DOMAIN TO OUR SITE START
	public function write_file($from, $path){
		$filename = $this->createTempPassword(15).'.jpg';
		$file = $path.$filename;

		$img = file_get_contents($from);
		$fp = fopen($file,'w');
		fwrite($fp, $img);
		fclose($fp);

		return $filename;
	}
	//WRITE FILE FROM ANOTHER DOMAIN TO OUR SITE END

}
?>