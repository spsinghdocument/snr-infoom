<?php
App::uses('AppController', 'Controller');
/**
 * PremiumRequests Controller
 *
 * @property PremiumRequest $PremiumRequest
 */
class PremiumRequestsController extends AppController {
	public $name = 'PremiumRequests';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array();
	}
	//BEFORE FILTER ENDS



	//FUNCTION FOR POSTING A MESSAGE FOR ADMIN FOR PREMIUM PLUS PACKAGE START
	public function premium_plus_message(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['business_id'] = $_POST['business_id'];
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['message'] = trim($_POST['message']);
		if($this->PremiumRequest->save($saveData)){
			echo '<font color="green">Request Sent Successfully!!</font>';
		}else{
			echo '<font color="red">Please Try Later</font>';
		}
		exit;
	}
	//FUNCTION FOR POSTING A MESSAGE FOR ADMIN FOR PREMIUM PLUS PACKAGE END

}
