<?php
App::uses('AppController', 'Controller');
/**
 * Invites Controller
 *
 * @property Invite $Invite
 */
class InvitesController extends AppController {
	public $name = 'Invites';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('accept_invitation');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR SETTING THE REFFERAL PAYMENTS START
	public function admin_set_referrer_payment(){
		Controller::loadModel('Referrer');
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Referrer->save($this->request->data, false)){
				$this->Session->setFlash(__('Amount set successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/invites/set_referrer_payment/');
			}else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
		}

		$this->data = $this->Referrer->findById('1');
	}
	//FUNCTION FOR SETTING THE REFFERAL PAYMENTS END

	//FUNCTION FOR LISTING REFFERAL PAYMENTS START
	public function admin_referral_payments(){
		Controller::loadModel('ReferralPayment');
		//$this->ReferralPayment->recursive = -1;
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('ReferralPayment.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('ReferralPayment'));
	}
	//FUNCTION FOR LISTING REFFERAL PAYMENTS end

	//FUNCTION FOR VIEWING THE PAYMENT DETAILS START
	public function admin_referpayment_payment_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		Controller::loadModel('ReferralPayment');

		$this->set('viewlisting', $this->ReferralPayment->findById($id));
	}
	//FUNCTION FOR VIEWING THE PAYMENT DETAILS END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START ----------------------------------------*/
	//PAGE FOR INVITING THE FRIENDS START
	public function invite_friends(){
		
	}
	//PAGE FOR INVITING THE FRIENDS END

	//FUNCTION FOR VALIDATING THE WEBSITE USER START
	public function validateWebsiteUser($email){
		Controller::loadModel('User');

		$ret = 'false';

		if($email != ''){
			$userCount = $this->User->find('count', array('conditions'=>array('User.email'=>$email)));
			if($userCount > 0)
				$ret = 'true';
			else{
				$inviteCount = $this->Invite->find('count', array('conditions'=>array('Invite.invitee_email'=>$email)));
				if($inviteCount > 0)
					$ret = 'true';
			}
		}
		return $ret;
	}
	//FUNCTION FOR VALIDATING THE WEBSITE USER END

	//FUNCTION FOR SENDING THE INVITES START
	public function send_invitations(){ //pr($_POST);die;
		set_time_limit(0);
		$this->layout = 'ajax';

		$emails = $_POST['emails'];
		$message = $_POST['message'];
		$this->set('message', $message);

		$expEmailsArr = explode(',', $emails);

		//send the invitations start
		foreach($expEmailsArr as $email){
			$saveData = '';
			//vaildate website email
			if($this->validateWebsiteUser($email) == 'false'){
				//unique code
				$unique_code = $this->Fp->createTempPassword(8).'_'.strtolower($this->Fp->createTempPassword(8));
				$this->set('unique_code', $unique_code);

				//send the invitaion start
				$this->set('email', $email);

				//save the data in table
				$saveData['inviter_id'] = $this->Session->read('Auth.User.User.id');
				$saveData['invitee_email'] = $email;
				$saveData['unique_code'] = $unique_code;
				$saveData['message'] = $message;
				$saveData['status'] = '0';
				$this->Invite->create();
				$this->Invite->save($saveData, false);

				$this->Email->to	  = $email;
				$this->Email->from    = $this->Session->read('Auth.User.User.email');
				$this->Email->subject  = 'Website Invitation';
				$this->Email->template = 'front_end/invite';
				$this->Email->sendAs   = 'html'; 
				$this->Email->send();
			}
		}

		echo 'sent';

		exit;
	}
	//FUNCTION FOR SENDING THE INVITES END

	//FUNCTION ACCEPT THE INVITATION START
	public function accept_invitation($invitation_code){
		$inviteArr = $this->Invite->findByUnique_code($invitation_code);
		if(!empty($inviteArr)){
			$saveData['id'] = $inviteArr['Invite']['id'];
			$saveData['unique_code'] = 'verified';
			$saveData['status'] = '1';
			$this->Invite->save($saveData);
		}
		$this->redirect(SITE_PATH);
		exit;
	}
	//FUNCTION ACCEPT THE INVITATION END
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/

}
