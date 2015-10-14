<?php
App::uses('AppController', 'Controller');
/**
 * Payments Controller
 *
 * @property Payment $Payment
 */
class PaymentsController extends AppController {
	public $name = 'Payments';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp', 'Paypal');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allowedActions = array('set_payment_status');
	}
	//BEFORE FILTER ENDS

	//FUNCTION FOR SETTING THE REFFERAL PAYMENTS START
	public function setRefferalPayment($business_id){
		Controller::loadModel('Referrer');
		Controller::loadModel('ReferralPayment');
		Controller::loadModel('Invite');

		$refCount = $this->ReferralPayment->find('count', array('conditions'=>array('ReferralPayment.business_id'=>$business_id)));
		if($refCount == 0){ //If no payment for the corresponding business
			//fetch the inviter of the current user start
			$inviterArr = $this->Invite->findByInvitee_id($this->Session->read('Auth.User.User.id'));
			if(!empty($inviterArr)){ // if inviter found, then,
				$inverter_id = $inviterArr['Invite']['inviter_id'];

				//fetch the amount to be creditted
				$amtArr = $this->Referrer->findById('1');
				$amount = $amtArr['Referrer']['amount'];

				//Now save the data start
				$saveData['inviter_id'] = $inverter_id;
				$saveData['invitee_id'] = $this->Session->read('Auth.User.User.id');
				$saveData['business_id'] = $business_id;
				$saveData['amount'] = $amount;
				$saveData['status'] = '1';
				$this->ReferralPayment->save($saveData, false);
			}
		}
	}
	//FUNCTION FOR SETTING THE REFFERAL PAYMENTS END


	//FUNCTION FOR CLAIMING/ UPGRADING THE BUSINESS START
	public function purchase_membership(){ //pr($_POST);die;
		set_time_limit(0);
		$this->layout = 'ajax';

		//fetch user details start
		Controller::loadModel('User');
		$this->User->unbindModel(array('hasMany'=>array('Friend')));
		$userArr = $this->User->findById($this->Session->read('Auth.User.User.id')); //pr($userArr);die;
		$this->set('userArr', $userArr);

		$paymentType = urlencode('Sale');
		$firstName = urlencode($userArr['User']['first_name']);
		$lastName = urlencode($userArr['User']['last_name']);
		$creditCardType = urlencode($_POST['card_type']);
		$creditCardNumber = urlencode($_POST['card_number']);
		$expDateMonth = $_POST['exp_month'];
		$padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
		$expDateYear = urlencode($_POST['exp_year']);
		$cvv2Number = urlencode($_POST['secure_code']);
		$currencyCode = urlencode('USD');

		//fetch the Membership Details start
		Controller::loadModel('Membership');
		$membershipArr = $this->Membership->findById($_POST['plan_id']);
		$this->set('membershipArr', $membershipArr);
		if(!empty($membershipArr)){
			if($_POST['plan_type'] == 'year'){
				$amount = urlencode($membershipArr['Membership']['pricing_year']);
				$billingPeriod = urlencode('Year');
			}else{
				$amount = urlencode($membershipArr['Membership']['pricing_month']);
				$billingPeriod = urlencode('Month');
			}

			//Billing Address
			Controller::loadModel('Business');
			$this->Business->unbindModel(array('belongsTo'=>array('Category', 'Sub-Category', 'User'), 'hasMany'=>array('BusinessBanner', 'BusinessFeedback')));
			$businessArr = $this->Business->findById($_POST['business_id']); //pr($businessArr);die;
			$this->set('businessArr', $businessArr);
			if(!empty($businessArr)){
				if((empty($businessArr['Business']['user_id'])) || ($businessArr['Business']['user_id'] == $this->Session->read('Auth.User.User.id'))){// claim or upgrade

					//assign the payment type
					$paymentType = 'Claim';
					if($businessArr['Business']['user_id'] == $this->Session->read('Auth.User.User.id'))
						$paymentType = 'Upgrade';
					$this->set('paymentType', $paymentType);

					$address1 = urlencode($businessArr['Business']['street']);
					$address2 = urlencode('');
					//if city is empty
					$city = $businessArr['Business']['city'];
					if($city == '')
						$city = 'New York City';
					$city = urlencode($city);

					//for state
					$state = $businessArr['Business']['state']; //pr($businessArr);die;
					if($state == '')
						$state = 'New York';
					$state = urlencode($state); //echo $businessArr['Business']['zip'];die;
					
					//for zip
					$zip = $businessArr['Business']['zip'];
					if($zip == '')
						$zip = '96734';
					$zip = urlencode($zip);

					//Load The Country Model
					Controller::loadModel('Country');
					$country = $businessArr['Business']['country'];
					if($country == '')
						$country = 'USA';
					$countryArr = $this->Country->find('first', array('fields'=>array('Country.country_iso_code_2'), 'conditions'=>array('Country.country_iso_code_3'=>$country)));
					$country = urlencode($countryArr['Country']['country_iso_code_2']);

					$profileDesc = urlencode($businessArr['Business']['title']);
					$billingFrequency = urlencode('1');
					$totalBillingCycles = '';

					$profileStartDateDay = date('d');
					$padprofileStartDateDay = str_pad($profileStartDateDay, 2, '0', STR_PAD_LEFT);
					$profileStartDateMonth = date('m');
					// Month must be padded with leading zero
					$padprofileStartDateMonth = str_pad($profileStartDateMonth, 2, '0', STR_PAD_LEFT);
					$profileStartDateYear = date('Y');

					$profileStartDate = urlencode($profileStartDateYear . '-' . $padprofileStartDateMonth . '-' . $padprofileStartDateDay . 'T00:00:00Z');

					$customData = $businessArr['Business']['id'];
					$notifyURL = urldecode(SITE_PATH.'payments/set_payment_status');

					$nvpstr="&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=ZA&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles&NOTIFYURL=$notifyURL&CUSTOM=$customData";

					//The details for the payment table
					$savePaymentData['user_id'] = $this->Session->read('Auth.User.User.id');
					$savePaymentData['business_id'] = $businessArr['Business']['id'];
					$savePaymentData['membership_id'] = $membershipArr['Membership']['id'];
					$savePaymentData['currency'] = 'USD';
					$savePaymentData['total_amount'] = urldecode($amount);
					$savePaymentData['equivalent_USD'] = urldecode($amount);
					$savePaymentData['card_type'] = $_POST['card_type'];
					$savePaymentData['card_number'] = 'XXXXXXXXXXXX'.substr($_POST['card_number'], -4);
					$savePaymentData['exp_month'] = $_POST['exp_month'];
					$savePaymentData['exp_year'] = $_POST['exp_year'];
					$savePaymentData['ip_address'] = IP_ADDRESS; //pr($savePaymentData);die;


					$httpParsedResponseArr = $this->Paypal->hash_call('CreateRecurringPaymentsProfile', $nvpstr);
					$ack = strtoupper($httpParsedResponseArr['ACK']); //pr($httpParsedResponseArr);die;

					if(($ack == 'SUCCESS') || ($ack == 'SUCCESSWITHWARNING')){
						//first save the transaction details in payment table
						$savePaymentData['payment_status']	= 'Success';
						$savePaymentData['currency_id']		= 'USD';
						$savePaymentData['payment_date_time']= date('Y-m-d H:i:s', strtotime(urldecode($httpParsedResponseArr['TIMESTAMP'])));	
						$savePaymentData['correlation_id']	= urldecode($httpParsedResponseArr['CORRELATIONID']);
						$savePaymentData['payment_type'] = $paymentType;
						$savePaymentData['profile_id'] = $httpParsedResponseArr['PROFILEID']; //pr($savePaymentData);die;
						$this->set('savePaymentData', $savePaymentData);
						
						Controller::loadModel('Payment');
						$this->Payment->save($savePaymentData);
						$paymentId = $this->Payment->id; //echo $paymentId;die;

						//save the data in purchased memberships table
						$saveMembershipData['user_id'] = $this->Session->read('Auth.User.User.id');
						$saveMembershipData['business_id'] = $businessArr['Business']['id'];
						$saveMembershipData['membership_id'] = $membershipArr['Membership']['id'];
						$saveMembershipData['payment_id'] = $paymentId;
						$saveMembershipData['purchased_on'] = date('Y-m-d H:i:s', strtotime(urldecode($httpParsedResponseArr['TIMESTAMP'])));

						if($_POST['plan_type'] == 'year'){
							if($membershipArr['Membership']['pricing_year'] != '')
								$increment = "+1 year";
							else
								$increment = "+1 month";
						}else{ // for month
							$increment = "+1 month";
						}
						$saveMembershipData['expires_on'] = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s", strtotime($saveMembershipData['purchased_on'])).$increment)); //pr($saveMembershipData);die;

						Controller::loadModel('PurchasedMembership');
						$this->PurchasedMembership->save($saveMembershipData);
						$this->set('saveMembershipData', $saveMembershipData); //pr($saveMembershipData);die;

						//Update USer Details
						$saveUserData['id'] = $userArr['User']['id'];
						$saveUserData['usertype'] = '2';
						$saveUserData['referral_program'] = '1';
						$this->User->save($saveUserData); //pr($saveUserData);die;

						//Save Details to Business Table
						if($paymentType == 'Claim'){
							$saveBusinessData['id'] = $businessArr['Business']['id'];
							$saveBusinessData['user_id'] = $userArr['User']['id'];
							$this->Business->save($saveBusinessData);
						}

						//setReferralPayments for the inviter
						$this->setRefferalPayment($businessArr['Business']['id']);

						//SEND EMAIL TO THE PURCHASER START
						$this->Email->to	   = $userArr['User']['email'];
						//$this->Email->to	   = 'arun_chauhan@seologistics.com';
						$this->Email->from	   = EMAIL_ADMIN_FROM;
						$this->Email->subject  = 'Membership Purchase';
						$this->Email->template = 'front_end/membership_purchase';
						$this->Email->sendAs   = 'html';
						$this->Email->send();
						//SEND EMAIL TO THE PURCHASER END 

						echo '<font color="green">Your payment was successful!! The payment details have been sent to your email address.</font>';
						die;
					}else{
						$savePaymentData['payment_status']	= 'Failure';
						$savePaymentData['payment_date_time']= date('Y-m-d H:i:s', strtotime(urldecode($httpParsedResponseArr['TIMESTAMP'])));	
						$savePaymentData['payment_date_time']= date('Y-m-d H:i:s', strtotime(urldecode($httpParsedResponseArr['TIMESTAMP'])));	
						$savePaymentData['correlation_id']	= urldecode($httpParsedResponseArr['CORRELATIONID']);
						$savePaymentData['failure_reason']	= urldecode($httpParsedResponseArr['L_LONGMESSAGE0']);
						$this->Payment->save($savePaymentData);
						echo '<font color="red">Error!! '.$httpParsedResponseArr['L_SHORTMESSAGE0'].'</font>';
						die;
					}
				}else{
					echo '<font color="red">This Business Has Already Been Claimed!!</font>';
					die;
				}
			}else{
				echo '<font color="red">Invalid Business!!</font>';
				die;
			}
		}else{
			echo '<font color="red">Invalid Membership!!</font>';
			die;
		}
	}
	//FUNCTION FOR CLAIMING/ UPGRADING THE BUSINESS START



	//SET PAYMENT STATUS START 6/19/2013
	public function set_payment_status(){
		if(isset($_POST) && !empty($_POST)){
			$abc = json_encode($_POST);

			$from = "flexsin@flexsin.com";
			$headers = "From:" . $from;

			mail('arun_chauhan@seologistics.com', 'Post Data', $abc, $headers);

			echo 'sent';
		}
		die;
	}
	//SET PAYMENT STATUS END 6/19/2013


	/*----------------------------------- ADMIN SECTION START ----------------------------*/
	//FUNCTION FOR MANGING THE PAYMENT SECTION START
	public function admin_manage_payments(){
		//$this->User->recursive = -1;
		$this->paginate = array('fields'=>array('Payment.id', 'Payment.currency', 'Payment.total_amount', 'Payment.payment_date_time', 'Payment.payment_type', 'User.id', 'User.first_name', 'User.last_name', 'Business.id', 'Business.title', 'Membership.name'), 'conditions'=>array('Payment.payment_status'=>'Success', 'User.id <>'=>''), 'limit'=>PAGING_SIZE, 'order'=>array('Payment.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('Payment'));
	}
	//FUNCTION FOR MANGING THE PAYMENT SECTION END

	//FUNCTION TO VIEW THE USER DETAILS START
	public function admin_view($id){
		//$this->User->recursive = -1;
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('listing', $this->Payment->findById($id));
	}
	//FUNCTION TO VIEW THE USER DETAILS END

	//FUNCTION FOR SEARCHING START
	public function admin_search(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if(!empty($this->request->data['Search']['username'])){
				$or['User.first_name LIKE'] = '%'.$this->request->data['Search']['username'].'%';
				$or['User.last_name LIKE'] = '%'.$this->request->data['Search']['username'].'%';
				$or['CONCAT(User.first_name, " ", User.last_name) LIKE'] = '%'.$this->request->data['Search']['username'].'%';
				$or['User.username LIKE'] = '%'.$this->request->data['Search']['username'].'%';
			}else{
				$or['User.first_name LIKE'] = '';
				$or['User.last_name LIKE'] = '';
				$or['CONCAT(User.first_name, " ", User.last_name) LIKE'] = '';
				$or['User.username LIKE'] = '';
			}

			if(!empty($this->request->data['Search']['business_title'])){
				$or['Business.title LIKE'] = '%'.$this->request->data['Search']['business_title'].'%';
			}else{
				$or['Business.title LIKE'] = '';
			}

			if(!empty($this->request->data['Search']['membership'])){
				$or['Membership.name LIKE'] = '%'.$this->request->data['Search']['membership'].'%';
			}else{
				$or['Membership.name LIKE'] = '';
			}

			if(!empty($this->request->data['Search']['payment_type'])){
				$or['Payment.payment_type'] = $this->request->data['Search']['payment_type'];
			}else{
				$or['Payment.payment_type'] = '';
			}

			$this->Session->write('search_or', $or);
		}

		$cons = $this->Session->read('search_or'); //pr($cons);die;
		if(!empty($cons)){
			$this->paginate = array('fields'=>array('Payment.id', 'Payment.currency', 'Payment.total_amount', 'Payment.payment_date_time', 'Payment.payment_type', 'User.id', 'User.first_name', 'User.last_name', 'Business.id', 'Business.title', 'Membership.name'), 'conditions'=>array('Payment.payment_status'=>'Success', 'User.id <>'=>'', 'OR'=>$cons), 'limit'=>PAGING_SIZE, 'order'=>array('Payment.id'=>'DESC'));
			$this->set('viewListing', $this->paginate('Payment'));
		}
	}
	//FUNCTION FOR SEARCHING END

	//FUNCTION FOR SEARCHING THE FAILED PAYMENTS START
	public function admin_failed_search(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if(!empty($this->request->data['Search']['username'])){
				$or['User.first_name LIKE'] = '%'.$this->request->data['Search']['username'].'%';
				$or['User.last_name LIKE'] = '%'.$this->request->data['Search']['username'].'%';
				$or['CONCAT(User.first_name, " ", User.last_name) LIKE'] = '%'.$this->request->data['Search']['username'].'%';
				$or['User.username LIKE'] = '%'.$this->request->data['Search']['username'].'%';
			}else{
				$or['User.first_name LIKE'] = '';
				$or['User.last_name LIKE'] = '';
				$or['CONCAT(User.first_name, " ", User.last_name) LIKE'] = '';
				$or['User.username LIKE'] = '';
			}

			if(!empty($this->request->data['Search']['business_title'])){
				$or['Business.title LIKE'] = '%'.$this->request->data['Search']['business_title'].'%';
			}else{
				$or['Business.title LIKE'] = '';
			}

			if(!empty($this->request->data['Search']['membership'])){
				$or['Membership.name LIKE'] = '%'.$this->request->data['Search']['membership'].'%';
			}else{
				$or['Membership.name LIKE'] = '';
			}

			if(!empty($this->request->data['Search']['payment_type'])){
				$or['Payment.payment_type'] = $this->request->data['Search']['payment_type'];
			}else{
				$or['Payment.payment_type'] = '';
			}

			$this->Session->write('search_or', $or);
		}

		$cons = $this->Session->read('search_or'); //pr($cons);die;
		if(!empty($cons)){
			$this->paginate = array('fields'=>array('Payment.id', 'Payment.currency', 'Payment.total_amount', 'Payment.payment_date_time', 'Payment.payment_type', 'User.id', 'User.first_name', 'User.last_name', 'Business.id', 'Business.title', 'Membership.name'), 'conditions'=>array('Payment.payment_status'=>'Failure', 'User.id <>'=>'', 'OR'=>$cons), 'limit'=>PAGING_SIZE, 'order'=>array('Payment.id'=>'DESC'));
			$this->set('viewListing', $this->paginate('Payment'));
		}
	}
	//FUNCTION FOR SEARCHING THE FAILED PAYMENTS END

	//FUNCTION FOR FAILED PAYMENTS START
	public function admin_failed_payments(){
		$this->paginate = array('fields'=>array('Payment.id', 'Payment.currency', 'Payment.total_amount', 'Payment.payment_date_time', 'Payment.payment_type', 'User.id', 'User.first_name', 'User.last_name', 'Business.id', 'Business.title', 'Membership.name'), 'conditions'=>array('Payment.payment_status'=>'Failure', 'User.id <>'=>''), 'limit'=>PAGING_SIZE, 'order'=>array('Payment.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('Payment'));
	}
	//FUNCTION FOR FAILED PAYMENTS END
	/*----------------------------------- ADMIN SECTION END ----------------------------*/



}
