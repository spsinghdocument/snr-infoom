<?php
App::uses('Component', 'Controller');
class PaypalComponent extends Component{
	public $components = array('Session', 'Cookie', 'Auth');

	public $API_USERNAME = '';
	public $API_PASSWORD = '';
	public $API_SIGNATURE = '';
	public $API_ENDPOINT = '';
	public $SUBJECT = '';
	public $USE_PROXY = FALSE;
	public $PROXY_HOST = '127.0.0.1';
	public $PROXY_PORT = '808';
	public $PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
	public $VERSION = '65.1';
	public $ACK_SUCCESS = 'SUCCESS';
	public $ACK_SUCCESS_WITH_WARNING = 'SUCCESSWITHWARNING';

	public $AUTH_TOKEN = '';
	public $AUTH_SIGNATURE = '';
	public $AUTH_TIMESTAMP = '';

	function __construct(){
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

		$this->API_USERNAME = urlencode($paypalSettingsArr['PaypalSetting']['user_name']);
		$this->API_PASSWORD = urlencode($paypalSettingsArr['PaypalSetting']['password']);
		$this->API_SIGNATURE = urlencode($paypalSettingsArr['PaypalSetting']['signature']);
		$this->API_ENDPOINT = "https://api-3t.paypal.com/nvp";
		if('sandbox' ===  $environment || 'beta-sandbox' === $environment){
			$this->API_ENDPOINT = 'https://api-3t.'.$environment.'.paypal.com/nvp';
		}
	}

	function formAutorization($auth_token, $auth_signature, $auth_timestamp){
		$authString="token=".$auth_token.",signature=".$auth_signature.",timestamp=".$auth_timestamp ;
		return $authString;
	}

	function nvpHeader(){
		$nvpHeaderStr = "";
		if(defined('AUTH_MODE')){
			$AuthMode = "AUTH_MODE"; 
		}else{
			if((!empty($this->API_USERNAME)) && (!empty($this->API_PASSWORD)) && (!empty($this->API_SIGNATURE)) && (!empty($this->SUBJECT))){
				$AuthMode = "THIRDPARTY";
			}elseif((!empty($this->API_USERNAME)) && (!empty($this->API_PASSWORD)) && (!empty($this->API_SIGNATURE))){
				$AuthMode = "3TOKEN";
			}elseif(!empty($AUTH_token) && !empty($AUTH_signature) && !empty($AUTH_timestamp)) {
				$AuthMode = "PERMISSION";
			}elseif(!empty($subject)){
				$AuthMode = "FIRSTPARTY";
			}
		}
		
		switch($AuthMode){
			case "3TOKEN" : 
			$nvpHeaderStr = "&PWD=".urlencode($this->API_PASSWORD)."&USER=".urlencode($this->API_USERNAME)."&SIGNATURE=".urlencode($this->API_SIGNATURE);
			break;
			case "FIRSTPARTY" :
			$nvpHeaderStr = "&SUBJECT=".urlencode($this->SUBJECT);
			break;
			case "THIRDPARTY" :
			$nvpHeaderStr = "&PWD=".urlencode($this->API_PASSWORD)."&USER=".urlencode($this->API_USERNAME)."&SIGNATURE=".urlencode($this->API_SIGNATURE)."&SUBJECT=".urlencode($this->SUBJECT);
			break;		
			case "PERMISSION" :
			$nvpHeaderStr = formAutorization($this->AUTH_TOKEN, $this->AUTH_SIGNATURE, $this->AUTH_TIMESTAMP);
			break;
		}
		return $nvpHeaderStr;
	}

	function hash_call($methodName, $nvpStr){ //echo $methodName;die;
		$nvpheader = $this->nvpHeader();
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);

		//in case of permission APIs send headers as HTTPheders
		if(!empty($AUTH_token) && !empty($AUTH_signature) && !empty($AUTH_timestamp)){
			$headers_array[] = "X-PP-AUTHORIZATION: ".$nvpheader;
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_array);
			curl_setopt($ch, CURLOPT_HEADER, false);
		}else{
			$nvpStr=$nvpheader.$nvpStr;
		}
		//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		//Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		/* if(USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT); */

		//check if version is included in $nvpStr else include the version.
		if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)){
			$nvpStr = "&VERSION=" . urlencode($this->VERSION) . $nvpStr;	
		}

		$nvpreq = "METHOD=".urlencode($methodName).$nvpStr;

		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

		//getting response from server
		$response = curl_exec($ch);
		curl_close($ch);

		$httpResponseAr = explode("&", $response);
		$httpParsedResponseArr = array();
		foreach($httpResponseAr as $i => $value){
			$tmpAr = explode('=', $value);
			if(sizeof($tmpAr) > 1){
				$httpParsedResponseArr[urldecode($tmpAr[0])] = urldecode($tmpAr[1]);
			}
		}

		/*//convrting NVPResponse to an Associative Array
		$nvpResArray=deformatNVP($response);
		$nvpReqArray=deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) {
		// moving to display page to display curl errors
		$_SESSION['curl_error_no']=curl_errno($ch) ;
		$_SESSION['curl_error_msg']=curl_error($ch);
		$location = "APIError.php";
		header("Location: $location");
		} else {
		//closing the curl
		curl_close($ch);
		}
		return $nvpResArray; */
		return $httpParsedResponseArr;
	}


	
	
}

?>