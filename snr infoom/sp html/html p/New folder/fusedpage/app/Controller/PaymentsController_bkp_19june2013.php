<?php
App::uses('AppController', 'Controller');
/**
 * Payments Controller
 *
 * @property Payment $Payment
 */
class PaymentsController extends AppController {
	public $name = 'PaypalSettings';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();		
	}
	//BEFORE FILTER ENDS

	//FUNCTION FOR PURCHASING THE MEMBERSHIP START
	public function purchase_membership(){ //pr($_POST);die;
		set_time_limit(0);
		$this->layout = 'ajax';
		
		//fetch user details start
		Controller::loadModel('User');
		$userArr = $this->User->findById($this->Session->read('Auth.User.User.id'));
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
		$currencyID = urlencode('USD');

		//fetch the Membership Details start
		Controller::loadModel('Membership');
		$membershipArr = $this->Membership->findById($_POST['plan_id']);
		$this->set('membershipArr', $membershipArr);
		if(!empty($membershipArr)){
			if($_POST['plan_type'] == 'year')
				$amount = urlencode($membershipArr['Membership']['pricing_year']);
			else
				$amount = urlencode($membershipArr['Membership']['pricing_month']);

			//Billing Address
			Controller::loadModel('Business');
			$this->Business->unbindModel(array('belongsTo'=>array('Category', 'Sub-Category', 'User'), 'hasMany'=>array('BusinessBanner', 'BusinessFeedback')));
			$businessArr = $this->Business->findById($_POST['business_id']);
			$this->set('businessArr', $businessArr);
			if(!empty($businessArr)){
				if($businessArr['Business']['user_id'] == ''){
					$address1 = urlencode($businessArr['Business']['street']);
					$address2 = urlencode('');
					//if city is empty
					$city = $businessArr['Business']['city'];
					if($city == '')
						$city = 'New York City';
					$city = urlencode($city);

					//for state
					$state = $businessArr['Business']['state'];
					if($state == '')
						$state = 'New York';
					$state = urlencode($state);

					//for zip
					$state = $businessArr['Business']['state'];
					if($zip == '')
						$zip = '96734';
					$zip = urlencode($zip]);

					//Load The Country Model
					Controller::loadModel('Country');
					$country = $businessArr['Business']['country'];
					if($country == '')
						$country = 'USA';
					$countryArr = $this->Country->find('first', array('fields'=>array('Country.country_iso_code_2'), 'conditions'=>array('Country.country_iso_code_3'=>$country)));
					$country = urlencode($countryArr['Country']['country_iso_code_2']);

					$nvpStr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
					"&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
					"&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";

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


					$httpParsedResponseArr = $this->Fp->PPHttpPost('DoDirectPayment', $nvpStr); //pr($httpParsedResponseArr);die;
					if(strtoupper($httpParsedResponseArr['ACK']) ==  'SUCCESS' || strtoupper($httpParsedResponseArr['ACK']) == 'SUCCESSWITHWARNING'){
						//first save the transaction details in payment table
						$savePaymentData['payment_status']	= 'Success';
						$savePaymentData['currency_id']		= urldecode($httpParsedResponseArr['CURRENCYCODE']);
						$savePaymentData['payment_date_time']= date('Y-m-d H:i:s', strtotime(urldecode($httpParsedResponseArr['TIMESTAMP'])));	
						$savePaymentData['transaction_id']	= urldecode($httpParsedResponseArr['TRANSACTIONID']);
						$savePaymentData['correlation_id']	= urldecode($httpParsedResponseArr['CORRELATIONID']);
						$this->set('savePaymentData', $savePaymentData);
						//pr($savePaymentData);die;
						
						Controller::loadModel('Payment');
						$this->Payment->save($savePaymentData);
						$paymentId = $this->Payment->id;

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
						$this->set('saveMembershipData', $saveMembershipData);

						//Update USer Details
						$saveUserData['id'] = $userArr['User']['id'];
						$saveUserData['usertype'] = '2';
						$saveUserData['referral_program'] = '1';
						$this->User->save($saveUserData);

						//Save Details to Business Table
						$saveBusinessData['id'] = $businessArr['Business']['id'];
						$saveBusinessData['user_id'] = $userArr['User']['id'];
						$this->Business->save($saveBusinessData);

						//setReferralPayments for the inviter
						$this->setRefferalPayment($businessArr['Business']['id']);

						//SEND EMAIL TO THE PURCHASER START
						$this->Email->to	   = $userArr['User']['email'];
						$this->Email->from	   = EMAIL_ADMIN_FROM;
						$this->Email->subject  = 'Membership Purchase';
						$this->Email->template = 'front_end/membership_purchase';
						$this->Email->sendAs   = 'html';
						$this->Email->send();
						//SEND EMAIL TO THE PURCHASER END

						echo '<font color="green">Your payment was successful!! The payment details have been sent to your email address.</font>';
						die;
					}else{
						echo '<font color="red">Error: '.urldecode($httpParsedResponseArr['L_LONGMESSAGE0']).'</font>';
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
	//FUNCTION FOR PURCHASING THE MEMBERSHIP END

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



}
