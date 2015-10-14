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

	/*----------------- ADMIN SECTION START -------------------------*/
	//FUNCTION FOR LISTING THE RECORDS START
	public function admin_new_requests(){
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('PremiumRequest.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('PremiumRequest'));
	}
	//FUNCTION FOR LISTING THE RECORDS END

	//FUNCTION FOR VEWING THE RECORD START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$reqArr = $this->PremiumRequest->findById($id);
		$this->set('requestArr', $reqArr);

		//change the viewed status
		if($reqArr['PremiumRequest']['viewed'] == '0'){
			$saveData['id'] = $reqArr['PremiumRequest']['id'];
			$saveData['viewed'] = '1';
			$this->PremiumRequest->save($saveData, false);
		}
	}
	//FUNCTION FOR VEWING THE RECORD END

	//FUNCTION FOR MANAGING THE STATUS OF THE REQUEST START
	public function admin_set_payment_status(){ //pr($_POST);die;
		$this->layout = '';

		$premiumRequestId = $_POST['request_id'];

		$preReqArr = $this->PremiumRequest->findById($premiumRequestId);

		if(!empty($preReqArr)){
			//1. Change the request section in business table
			Controller::loadModel('Business');
			$saveBusinessData['id'] = $preReqArr['PremiumRequest']['business_id'];
			$saveBusinessData['request_sent'] = $preReqArr['PremiumRequest']['user_id'];
			if($this->Business->save($saveBusinessData, false)){
				//2. set the status in the premium request table
				$saveRequest['id'] = $preReqArr['PremiumRequest']['id'];
				$saveRequest['status'] = '2';
				$this->PremiumRequest->save($saveRequest, false);
			}

			//send email to the corresponding user start
			$this->set('preReqArr', $preReqArr);
			$this->Email->to	   = $preReqArr['User']['email'];
			$this->Email->from	   = EMAIL_ADMIN_FROM;
			$this->Email->subject  = 'Your request for Plan Upgrade';
			$this->Email->template = 'admin/plan_upgrade';
			$this->Email->sendAs   = 'html'; 
			$this->Email->send();
			//send email to the corresponding user end
		}
		echo '<font color="green">Sent!!</font>';
		exit;
	}
	//FUNCTION FOR MANAGING THE STATUS OF THE REQUEST END
	/*----------------- ADMIN SECTION END -------------------------*/

}