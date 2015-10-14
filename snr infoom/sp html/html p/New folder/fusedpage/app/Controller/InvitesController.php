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
			$this->Auth->allowedActions = array('accept_invitation', 'invite_friends_invite', 'fetch_invites_contacts', 'validate_invites_credentials', 'send_invitations_register');
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
		}
		return $ret;
	}

	function validateInviteUser($email){
		if($email != ''){
			$inviteArr = $this->Invite->find('first', array('fields'=>array('Invite.id'), 'conditions'=>array('Invite.invitee_email'=>$email)));
			if(!empty($inviteArr)){
				$this->Invite->delete($inviteArr['Invite']['id']);
			}
		}
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
			$sta = 'true';
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

				$sta = 'false';
			}
		}

		if($sta == 'false')
			echo 'sent';
		else
			echo '<font color="red">Please Invite Non-registered Users!</font>';

		exit;
	}
	//FUNCTION FOR SENDING THE INVITES END

	//FUNCTION FOR SENDING THE INVITATIONS FROM REGISTER PAGE START
	public function send_invitations_register(){ //pr($_POST);die;
		set_time_limit(0);
		$this->layout = 'ajax';
		
		$emails = $_POST['emails'];
		$message = $_POST['message'];
		$this->set('message', $message);

		$expEmailsArr = explode(',', $emails); //pr($expEmailsArr);die;
		
		//send the invitations start
		foreach($expEmailsArr as $email){ //echo $email;die;
			//$email = 'akash_mishra@seologistics.com';
			$saveData = '';
			$flag = 'User Already Registered!!';
			//vaildate website email
			if($this->validateWebsiteUser($email) == 'false'){
				//unique code
				$unique_code = $this->Fp->createTempPassword(8).'_'.strtolower($this->Fp->createTempPassword(8));
				$this->set('unique_code', $unique_code);

				//send the invitaion start
				$this->set('email', $email);

				Controller::loadModel('User');
				$this->User->recursive = -1;
				$userArr = $this->User->findById($_POST['user_id']);
				$this->set('userArr', $userArr); //pr($userArr);die;

				$this->validateInviteUser($email);

				//save the data in table
				$saveData['inviter_id'] = $userArr['User']['id'];
				$saveData['invitee_email'] = $email;
				$saveData['unique_code'] = $unique_code;
				$saveData['message'] = $message;
				$saveData['status'] = '0';
				$this->Invite->create();
				$this->Invite->save($saveData, false);

				$this->Email->to	  = $email;
				$this->Email->from    = $userArr['User']['email'];
				$this->Email->subject  = 'Website Invitation';
				$this->Email->template = 'front_end/invite_register';
				$this->Email->sendAs   = 'html'; 
				$this->Email->send();

				$flag = 'sent';
			}
		}

		echo $flag;
		exit;
	}
	//FUNCTION FOR SENDING THE INVITATIONS FROM REGISTER PAGE END

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

	/*------------------- INVITE FRIENDS SECTION START ----------------------------------*/
	//FUNCTION FOR VALIDATING THE PROVIDED CREDENTIALS START
	public function validate_invites_credentials(){ //pr($_POST);die;
		$this->layout = '';
		set_time_limit(0);

		//$err_msg = 'OK';

		include_once('../Vendor/open_inviter/openinviter.php');
		$err_msg = '';
		$fetchedEmails = '';

		$inviter = new OpenInviter();
		$startPlugin = $inviter->startPlugin($_POST['email_provider']);  //pr($startPlugin);die;
		if($startPlugin){// if plugin started
			$login = $inviter->login($_POST['email'], $_POST['password']);
			if($login){ //login the user
				$err_msg = 'OK';
			}else
				$err_msg = 'Invalid Login Email or Password';
		}else
			$err_msg = 'Plugin Error!';

		echo $err_msg;
		exit;
	}
	//FUNCTION FOR VALIDATING THE PROVIDED CREDENTIALS END

	//FUNCTION FOR FETCHING THE DETAILS START
	public function fetch_invites_contacts($email, $password, $provider){ //echo $email.', '.$password.', '.$provider;die;
		$this->layout = '';
		set_time_limit(0);

		include_once('../Vendor/open_inviter/openinviter.php');
		$err_msg = '';
		$fetchedEmails = '';

		$inviter = new OpenInviter();
		$startPlugin = $inviter->startPlugin($provider);
		if($startPlugin){// if plugin started
			$login = $inviter->login($email, $password);
			if($login){ //login the user
				$contacts = $inviter->getMyContacts();
				if($contacts){
					foreach($contacts as $key => $val){
						$fetchedEmails[$key] = $key;
					}
				}else
					$err_msg = 'Unable to Fetch Contacts!';
			}else
				$err_msg = 'Invalid Login Email or Password';
		}else
			$err_msg = 'Plugin Error!';
		return $fetchedEmails;
	}
	//FUNCTION FOR FETCHING THE DETAILS END

	//FUNCTION FOR FETCHING THE USER DEATILS START
	public function invite_friends_invite(){ //pr($_POST);die;
		$this->layout = 'ajax';
		
		$fetchedData = $this->fetch_invites_contacts($_POST['email'], $_POST['password'], $_POST['email_provider']); 
		/*$fetchedData = array(
				'arun_chauhan@seologistics.com'=>'arun_chauhan@seologistics.com',
				'shweta_jain@seologistics.com'=>'shweta_jain@seologistics.com',
				'ravi_kumar@seologistics.com'=>'ravi_kumar@seologistics.com',
				'saurabh_kumar@seologistics.com'=>'saurabh_kumar@seologistics.com',
				'akash_mishra@seologistics.com'=>'akash_mishra@seologistics.com',
		); */
		$this->set('fetchedData', $fetchedData);
		$this->set('inviter', $_POST['inviter']);
	}
	//FUNCTION FOR FETCHING THE USER DEATILS END
	/*------------------- INVITE FRIENDS SECTION END ----------------------------------*/

}
