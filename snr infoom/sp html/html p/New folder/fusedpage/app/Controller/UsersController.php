<?php
App::import('Vendor','PHPTwit',array('file'=>'twitter/twitteroauth.php')); //load twitter vendor
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	public $name = 'Users';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('home', 'sign_up', 'sign_up_2', 'validate_email', 'fetch_post_codes_details', 'activate', 'sign_in', 'forgot_password', 'sign_out', 'facebook_login', 'fetch_all_states');
		}
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR MANAGING THE USERS START
	public function admin_manage() {
		$this->User->recursive = -1;
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('User.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('User'));
	}
	//FUNCTION FOR MANAGING THE USERS END

	//FUNCTION FOR ACTIVATING/DEACTIVATING THE USER START
	public function admin_status_update($id, $newStatus) {
		if($id != ''){
			$this->User->recursive = -1;
			$userArr = $this->User->findById($id);
			if(!empty($userArr)){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1'){
					if($userArr['User']['activation_link'] != 'verified')
						$saveData['activation_link'] = 'verified';
					$message = 'Activated';
				}else
					$message = 'Deactivated';
				if($this->User->save($saveData, false)){
					$this->set('userArr', $userArr);
					$this->set('message', $message);

					//send email to corresponding user start
					$this->Email->to	   = $userArr['User']['email'];
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = 'Your Account '.$message.' by Administrator';
					$this->Email->template = 'admin/account';
					$this->Email->sendAs   = 'html'; 
					$this->Email->send();

					$this->Session->setFlash(__('User '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				}else
					$this->Session->setFlash(__('No Associated User Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated User Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated User Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/users/manage/');
		exit;
	}
	//FUNCTION FOR ACTIVATING/DEACTIVATING THE USER END

	//FUNCTION TO VIEW THE USER DETAILS START
	public function admin_view($id){
		//$this->User->recursive = -1;
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('userArr', $this->User->findById($id));
	}
	//FUNCTION TO VIEW THE USER DETAILS END

	//FUNCTION FOR DELETING THE USER START
	public function admin_delete($id) {
		if($id != ''){
			$this->User->recursive = -1;
			$usrArr = $this->User->findById($id);
			if(!empty($usrArr)){
				//delete profile image start
				if($usrArr['User']['image'] != ''){
					$imagePath = '../webroot/img/front_end/users/'.$usrArr['User']['image'];
					if(is_file($imagePath))
						unlink($imagePath);
				}
				//delete profile image end

				if($this->User->delete($id)){
					//remove the business associations
					Controller::loadModel('Business');
					$this->Business->updateAll(array('Business.user_id'=>NULL), array('Business.user_id'=>$id));

					$this->Session->setFlash(__('User Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				}else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/users/manage/');
			}else{
				$this->Session->setFlash(__('No Associated User Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/users/manage/');
			}
		}else
			$this->redirect('/admin/users/manage/');
		exit;
	}
	//FUNCTION FOR DELETING THE USER END

	//FUNCTION FOR RESETTING THE PASSWORD OF A USER START
	public function admin_reset_password($id) {
		if($id != ''){
			$this->User->recursive = -1;
			$userArr = $this->User->findById($id);
			if(!empty($userArr)){
				$newPassword = $this->Fp->createTempPassword(8);
				$saveData['id'] = $id;
				$saveData['password'] = $this->Auth->password($newPassword);
				if($this->User->save($saveData, false)){
					$this->set('userArr', $userArr);
					$this->set('newPassword', $newPassword);

					//send email to corresponding user start
					$this->Email->to	   = $userArr['User']['email'];
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = 'Your New Login Password';
					$this->Email->template = 'admin/reset';
					$this->Email->sendAs   = 'html'; 
					$this->Email->send();
					//send email to corresponding user end
					
					$this->Session->setFlash(__('Password Reset Successfully & Sent to the User!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/users/manage/');
				}else{
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
					$this->redirect('/admin/users/manage/');
				}
			}else{
				$this->Session->setFlash(__('No Associated User Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/users/manage/');
			}
		}else
			$this->redirect('/admin/users/manage/');
		exit;
	}
	//FUNCTION FOR RESETTING THE PASSWORD OF A USER END

	//FUNCTION FOR USER EDIT START
	public function admin_edit($id) {
		if($id != ''){
			if(!empty($this->request->data)){ //pr($this->request->data);die;
				/*------- FETCH SPACE ALTITUDES FROM GOOGLE START ---------*/
				/* $latsLongArr = $this->Fp->fetchLatLongs($this->request->data['User']['suburb_id'], $this->request->data['User']['state_id']);

				if(!empty($latsLongArr)){
					$this->request->data['User']['latitude'] = $latsLongArr['latitude'];
					$this->request->data['User']['longitude'] = $latsLongArr['longitude'];
				} */
				/*------- FETCH SPACE ALTITUDES FROM GOOGLE END   ---------*/

				//find the country id association start
				Controller::loadModel('Country');
				$countryArr = $this->Country->findByCountry_iso_code_3($this->request->data['User']['country']);
				if(!empty($countryArr))
					$this->request->data['User']['country_id'] = $countryArr['Country']['id'];
				//find the country id association end

				if($this->User->save($this->request->data))
					$this->Session->setFlash(__('User Details Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/users/manage/');
			}

			$userArr = $this->User->findById($id);
			if(!empty($userArr)){ //pr($userArr);die;
				$this->data = $userArr;
			}else{
				$this->Session->setFlash(__('No Associated User Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/users/manage/');
			}
		}else
			$this->redirect('/admin/users/manage/');
	}
	//FUNCTION FOR USER EDIT END

	//AJAX FUNCTION TO FETCH CORRESPONDING SUBURBS & POSTCODE START
	public function admin_fetch_corresponding_listing(){ //pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('Suburb');
		$ret = '';

		if($_POST['type'] == 'suburb'){
			$ret = $this->Suburb->find('list', array('fields'=>array('Suburb.id', 'Suburb.suburb'), 'conditions'=>array('Suburb.state_id'=>$_POST['id'])));
		}else{
			$suburbArr = $this->Suburb->findById($_POST['id']);
			$ret = $suburbArr['Suburb']['postcode'];
		}

		$this->set('ret', $ret);
		$this->set('post', $_POST);
	}
	//AJAX FUNCTION TO FETCH CORRESPONDING SUBURBS & POSTCODE END

	//AJAX FUNCTION FOR FETCHING THE CITIES START
	public function admin_fetch_post_codes_details(){ //pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('Postcode');
		$enteredPostCode = trim($_POST['postcode']);

		$postCodeArr = $this->Postcode->find('all', array('fields'=>array('Postcode.CountryName', 'Postcode.CityName', 'Postcode.ProvinceName', 'Postcode.ProvinceAbbr', 'Postcode.Latitude', 'Postcode.Longitude'), 'conditions'=>array('Postcode.PostalCode LIKE'=>'%'.$enteredPostCode.'%'), 'group'=>'Postcode.CityName'));
		$arr = array();
		$arr['data'] = $postCodeArr;
		echo json_encode($arr);
		exit;
	}
	//AJAX FUNCTION FOR FETCHING THE CITIES END

	//FUNCTION FOR FETCHING THE SEARCHED DATA START
	public function admin_search___(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$user_name = trim($this->request->data['User']['search_name']);
			$postcode = trim($this->request->data['User']['search_postcode']);
			$orCondition = array('User.first_name LIKE'=>"%".$user_name."%", 'User.last_name LIKE'=>"%".$user_name."%", 'CONCAT(User.first_name, " ", User.last_name) LIKE'=>"%".$user_name."%"); //pr($orCondition);die;
			$this->Session->write('orCondition', $orCondition);
		} //pr($this->Session->read('orCondition'));die;

		if($postcode != '')
			$this->paginate = array('conditions'=>array('User.postcode LIKE'=>"%".$postcode."%", 'OR'=>$this->Session->read('orCondition')), 'limit'=>PAGING_SIZE, 'order'=>array('User.id'=>'DESC'));
		else
			$this->paginate = array('conditions'=>array('OR'=>$this->Session->read('orCondition')), 'limit'=>PAGING_SIZE, 'order'=>array('User.id'=>'DESC'));
		//$abc = $this->paginate('User'); pr($abc);die;
		$this->set('viewListing', $this->paginate('User'));	
	}
	//FUNCTION FOR FETCHING THE SEARCHED DATA END


	//FUNCTION FOR FETCHING THE SEARCH DATA START
	public function admin_search(){ //pr($this->request->data); die;
		if(($this->request->data['User']['search_name'] != '') || ($this->request->data['User']['search_postcode'] != '') || ($this->request->data['User']['email'] != '') || ($this->request->data['User']['usertype'] != '')){
			$condition = array();
			$user_name = trim($this->request->data['User']['search_name']);
			$postcode = $this->request->data['User']['search_postcode'];
			$email = trim($this->request->data['User']['email']);
			$usertype = $this->request->data['User']['usertype'];

			$condition = array('User.first_name LIKE'=>"%".$user_name."%", 'User.last_name LIKE'=>"%".$user_name."%", 'CONCAT(User.first_name, " ", User.last_name) LIKE'=>"%".$user_name."%", 'User.postcode LIKE'=>"%".$postcode."%", 'User.email LIKE'=>"%".$email."%", 'User.usertype LIKE'=>"%".$usertype."%");
			
			$cond = array();
			foreach($condition as $key=>$value){
				if(!empty($value) && $value != '%%'){
					$cond[$key] = $value;
				}
			}
			$conditions = array('OR'=>$cond); 
			$this->paginate = array('conditions'=>array($conditions), 'limit'=>PAGING_SIZE, 'order'=>array('User.id'=>'DESC'));
			$this->set('viewListing', $this->paginate('User'));
		}
	}
	//FUNCTION FOR FETCHING THE SEARCH DATA END


	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START --------------------------------------*/
	//FUNCTION FOR HOME PAGE START
	/*public function home() {
		set_time_limit(0);
		$this->validateUser('User', $this->wallUrl);
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$this->request->data['User']['first_name'] = ucwords(strtolower(trim($this->request->data['User']['first_name'])));
			$this->request->data['User']['last_name'] = ucwords(strtolower(trim($this->request->data['User']['last_name'])));
			$this->request->data['User']['email'] = strtolower(trim($this->request->data['User']['email']));
			$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password_1']);
			$this->request->data['User']['activation_link'] = strtolower($this->Fp->createTempPassword(15));
			$this->request->data['User']['ip_address'] = IP_ADDRESS;
			$locationDetails = $this->Location->getLocationDetails(); //pr($locationDetails);die;
			if(!empty($locationDetails)){
				$this->request->data['User']['latitude'] = $locationDetails['latitude'];
				$this->request->data['User']['longitude'] = $locationDetails['longitude'];
				$this->request->data['User']['timezone'] = $locationDetails['timeZone'];
				$this->request->data['User']['ip_address_id'] = $locationDetails['id'];
			} //pr($this->request->data);die;
			
			//For Country Details start
			Controller::loadModel('Country');
			$countryArr = $this->Country->find('first', array('fields'=>array('Country.id'), 'conditions'=>array('Country.country_iso_code_2'=>$locationDetails['countryCode'])));
			if(!empty($countryArr)){
				$this->request->data['User']['country_id'] = $countryArr['Country']['id'];
			}
			//For Country Details end
			
			//pr($this->request->data);die;
			if($this->User->save($this->request->data)){
				
				//SEND ACTIVATION EMAIL TO USER START
				$this->set('userDetails', $this->request->data);

				$this->Email->to	   = $this->request->data['User']['email'];
				$this->Email->from	   = EMAIL_ADMIN_FROM;
				$this->Email->subject  = 'Account Activation Link';
				$this->Email->template = 'front_end/activation_code';
				$this->Email->sendAs   = 'html';
				$this->Email->send();
				//SEND ACTIVATION EMAIL TO USER END
				$this->redirect('/users/sign_up/'.base64_encode($this->User->id));
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}
	} */

	public function home(){
		header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' ); 
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); 
		header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
		header( 'Cache-Control: post-check=0, pre-check=0', false ); 
		header( 'Pragma: no-cache' );

		if($this->Session->check('registration_step')){
			$this->redirect($this->Session->read('registration_step'));
		}

		$this->validateUser('User', $this->wallUrl);

		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$this->request->data['User']['first_name'] = ucwords(strtolower(trim($this->request->data['User']['first_name'])));
			$this->request->data['User']['last_name'] = ucwords(strtolower(trim($this->request->data['User']['last_name'])));
			$this->request->data['User']['email'] = strtolower(trim($this->request->data['User']['email1']));
			$this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password_11']);
			$this->request->data['User']['activation_link'] = strtolower($this->Fp->createTempPassword(15));
			$this->request->data['User']['ip_address'] = IP_ADDRESS;
			$this->request->data['User']['username'] = rand(1, 9999).'_'.time();

			if($this->User->save($this->request->data)){
				$insrtId = $this->User->id;

				$this->Session->write('registration_step', '/users/sign_up/'.$this->Fp->encrypt($this->User->id));
				//check whether the registered email has been invited or not
				$this->validateRefferalEmail($this->request->data['User']['email'], $insrtId);

				//SEND ACTIVATION EMAIL TO USER START
				$this->set('userDetails', $this->request->data);

				$this->Email->to	   = $this->request->data['User']['email'];
				$this->Email->from	   = EMAIL_ADMIN_FROM;
				$this->Email->subject  = 'Account Activation Link';
				$this->Email->template = 'front_end/activation_code';
				$this->Email->sendAs   = 'html';
				$this->Email->send();
				//SEND ACTIVATION EMAIL TO USER END
				$this->redirect('/users/sign_up/'.$this->Fp->encrypt($this->User->id));
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}
	}
	//FUNCTION FOR HOME PAGE END

	//FUNCTION FOR USER SIGN UP STEP 1 START
	/* public function sign_up($id=null){
		$this->validateUser('User', $this->wallUrl);
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$this->request->data['User']['date_of_birth'] = $this->request->data['User']['year'].'-'.$this->request->data['User']['month'].'-'.$this->request->data['User']['date'];
			if($this->User->save($this->request->data, false)){
				$this->Session->setFlash(__('Details Registered Successfully! Account activation email has been sent to your email address!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/users/sign_up_2/'.base64_encode($this->request->data['User']['id']));
			}else{
				$id = base64_encode($this->request->data['User']['id']);
				$this->Session->setFlash(__('Please Try Again!!', true), 'message', array('class'=>'message-red'));
			}
		}

		if($id != ''){
			$id = base64_decode($id);
			$this->User->recursive = -1;
			$usrArr = $this->User->findById($id);
			if(!empty($usrArr)){
				if(($usrArr['User']['status'] == '0') && ($usrArr['User']['activation_link'] != 'verified')){
					$this->data = $usrArr;
				}else
					$this->redirect('/');
			}else
				$this->redirect('/');
		}else
			$this->redirect('/');
	} */

	//FUNCTION FOR REFERRAL VALIDATION START
	public function validateRefferalEmail($email, $user_id){
		Controller::loadModel('Invite');

		$reffArr = $this->Invite->findByInvitee_email($email); //pr($reffArr);die;
		if(!empty($reffArr)){
			$saveData['id'] = $reffArr['Invite']['id'];
			$saveData['invitee_id'] = $user_id;
			$saveData['invitee_joining_date'] = date('Y-m-d H:i:s'); //pr($saveData);die;
			$this->Invite->save($saveData, false);
		}
	}
	//FUNCTION FOR REFERRAL VALIDATION END

	public function sign_up($id=null){
		$this->validateUser('User', $this->wallUrl);

		if(!empty($this->request->data)){ //pr($this->request->data);die;

			/*--------- OTHER STATE N CITY STRAT ----------------------------*/
			if($this->request->data['User']['user_city'] != '')
				$this->request->data['User']['city'] = trim(ucwords(strtolower($this->request->data['User']['user_city'])));

			if($this->request->data['User']['user_zip'] != '')
				$this->request->data['User']['postcode'] = $this->request->data['User']['user_zip'];
			/*--------- OTHER STATE N CITY STRAT ----------------------------*/
			
			$this->request->data['User']['date_of_birth'] = $this->request->data['User']['year'].'-'.$this->request->data['User']['month'].'-'.$this->request->data['User']['date'];

			//find the country id association start
			Controller::loadModel('Country');
			$countryArr = $this->Country->findByCountry_iso_code_3($this->request->data['User']['country']);
			if(!empty($countryArr))
				$this->request->data['User']['country_id'] = $countryArr['Country']['id'];
			//find the country id association end

			if($this->User->save($this->request->data, false)){
				$this->Session->delete('registration_step');
				

				$this->Session->setFlash(__('Details Registered Successfully! Account activation email has been sent to your email address!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/users/sign_up_2/'.base64_encode($this->request->data['User']['id']));
			}else{
				$id = base64_encode($this->request->data['User']['id']);
				$this->Session->setFlash(__('Please Try Again!!', true), 'message', array('class'=>'message-red'));
			}
		}

		if($id != ''){
			$id = base64_decode($id);
			$this->User->recursive = -1;
			$usrArr = $this->User->findById($id);
			if(!empty($usrArr)){
				/* if(($usrArr['User']['status'] == '0') && ($usrArr['User']['activation_link'] != 'verified')){
					$this->data = $usrArr; */
				if($usrArr['User']['postcode'] == ''){
					$this->data = $usrArr;
				}else
					$this->redirect('/');
			}else
				$this->redirect('/');
		}else
			$this->redirect('/');
	}
	//FUNCTION FOR USER SIGN UP STEP 1 END

	//FUNCTION FOR USER SIGN UP STEP 2 START
	public function sign_up_2(){
		$this->validateUser('User', $this->wallUrl);
		if(!empty($this->request->data)){ pr($this->request->data);die;
			
		}
	}
	//FUNCTION FOR USER SIGN UP STEP 2 END

	//FUNCTION FOR VALIDATING THE EMAIL START
	public function validate_email(){ //pr($_GET);die;
		$this->layout=false;
		$this->autoRender=false;
		$ret = '';
		$result = array();
		$result[0] = $_GET['fieldId'];
		$emailCount = $this->User->find('count', array('conditions'=>array('User.email'=>$_GET['fieldValue'])));
		if($emailCount > 0){
			$result[1]= false;
		}else{
			$result[1]= true;
		}
		echo json_encode($result);
			
	}
	//FUNCTION FOR VALIDATING THE EMAIL END

	//FUNCTION TO FECTH THE POSTCODES SUGGESTIONS START
	/*function fetch_post_codes_details(){ //pr($_POST);die;		
		$this->layout = 'ajax';
		Controller::loadModel('Postcode');
		$enteredPostCode = trim($_POST['postcode']);

		$postCodeArr = $this->Postcode->find('all', array('fields'=>array('Postcode.CountryName', 'Postcode.CityName', 'Postcode.ProvinceName'), 'conditions'=>array('Postcode.PostalCode'=>$enteredPostCode), 'group'=>'Postcode.CityName'));
		$arr = array();
		$arr['data'] = $postCodeArr;
		echo json_encode($arr);
		exit;
	} */

	function fetch_post_codes_details(){ //pr($_POST);die;		
		$this->layout = 'ajax';
		Controller::loadModel('Postcode');
		$enteredPostCode = trim($_POST['postcode']);
		$enteredPostCode = str_replace('-', ' ', $enteredPostCode);

		$postCodeArr = $this->Postcode->find('all', array('fields'=>array('Postcode.CountryName', 'Postcode.CityName', 'Postcode.ProvinceName', 'Postcode.ProvinceAbbr', 'Postcode.Latitude', 'Postcode.Longitude'), 'conditions'=>array('Postcode.PostalCode LIKE'=>'%'.$enteredPostCode.'%'), 'group'=>'Postcode.CityName')); //pr($postCodeArr);die;
		$arr = array();
		$arr['data'] = $postCodeArr;
		echo json_encode($arr);
		exit;
	}
	//FUNCTION TO FECTH THE POSTCODES SUGGESTIONS END

	//FUNCTION FOR USER ACTIVATION SECTION START
	public function activate($code=null) {
		if($code != ''){
			$this->User->recursive = -1;
			$userArr = $this->User->findByActivationLink($code); //pr($userArr);die;
			if(!empty($userArr)){
				if($userArr['User']['status'] == '0'){
					$saveData['id'] = $userArr['User']['id'];
					$saveData['activation_link'] = 'verified';
					$saveData['status'] = '1';
					if($this->User->save($saveData, false)){
						$this->Session->setFlash(__('Account Activated Successfully!! Please Login!', true), 'message', array('class'=>'message-green'));
						$this->redirect('/users/sign_in/');
					}else{
						$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
						$this->redirect('/');
					}
				}else{
					if($userArr['User']['status'] == '2')
						$this->Session->setFlash(__('Your Account has been Deactivated by Administrator!!', true), 'message', array('class'=>'message-red'));
					$this->redirect('/');
				}
			}else
				$this->redirect('/');
		}else
			$this->redirect('/');
	}
	//FUNCTION FOR USER ACTIVATION SECTION END

	//FUNCTION FOR USER LOGIN START
	public function sign_in(){
		$this->validateUser('User', $this->wallUrl);

		//If remembered, redirect to user wall
		if($this->Fp->validateCookie('User', 'fusedpage_user', $this->wallUrl))
			$this->redirect($this->wallUrl);

		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$this->Session->delete('registration_step');
			$userArr = $this->User->find('first', array('conditions'=>array('User.email'=>trim($this->request->data['User']['email']), 'User.password'=>$this->Auth->password($this->request->data['User']['password_1']))));
			if(!empty($userArr)){ //pr($userArr);die;
	
				//check for locations values start
				if($userArr['User']['postcode'] == ''){ // send to registration step 2
					$this->redirect(SITE_PATH.'users/sign_up/'.$this->Fp->encrypt($userArr['User']['id']));
				}
				//check for locations values end

				if($userArr['User']['status'] == '1'){
					if($this->Auth->login($userArr)){
						//SET THE REMEMBER ME COOKIE START
						if($this->request->data['User']['remember'] == '1')
							$this->Fp->createCookie('fusedpage_user', array('email'=>$userArr['User']['email'], 'password'=>$userArr['User']['password']), '+2 weeks');
						else
							$this->Cookie->delete('fusedpage_user');
						$this->redirect($this->wallUrl);
						//SET THE REMEMBER ME COOKIE END
					}else
						$this->Session->setFlash(__('Invalid Email or Password!', true), 'message', array('class'=>'message-red'));
				}else{
					if($userArr['User']['status'] == '0')
						$this->Session->setFlash(__('Please Activate Account First!!', true), 'message', array('class'=>'message-red'));
					else
						$this->Session->setFlash(__('Account Deactivated by Administrator!!', true), 'message', array('class'=>'message-red'));
				}
			}else
				$this->Session->setFlash(__('Invalid Email or Password!', true), 'message', array('class'=>'message-red'));
		}
	}
	//FUNCTION FOR USER LOGIN END

	//FUNCTION FOR USER LOG OUT START
	public function sign_out(){
		if($this->Auth->logout()){			
			$this->Cookie->delete('fusedpage_user');
			$this->redirect(SITE_PATH);
		}
	}
	//FUNCTION FOR USER LOG OUT END

	//FUNCTION FOR USER FORGOT PASSWORD START
	public function forgot_password(){
		$this->validateUser('User', $this->wallUrl);

		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$email = trim($this->request->data['User']['email']);
			$userArr = $this->User->findByEmail($email);
			if(!empty($userArr)){
				if($userArr['User']['status'] == '1'){
					$newPassword = $this->Fp->createTempPassword(8);
					$saveData['id'] = $userArr['User']['id'];
					$saveData['password'] = $this->Auth->password($newPassword);
					if($this->User->save($saveData, false)){
						$this->set('newPassword', $newPassword);
						$this->set('userArr', $userArr);

						//Send Email With New Password
						$this->Email->to	   = $userArr['User']['email'];
						$this->Email->from	   = EMAIL_ADMIN_FROM;
						$this->Email->subject  = 'Your New Password';
						$this->Email->template = 'front_end/forgot_password';
						$this->Email->sendAs   = 'html';
						$this->Email->send();

						$this->Session->setFlash(__('New password has been sent to your email!', true), 'message', array('class'=>'message-green'));
						$this->redirect('/users/sign_in/');
					}else
						$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				}else{
					if($userArr['User']['status'] == '0')
						$this->Session->setFlash(__('Your account is not activated, please activate the account by clicking on the link sent to you!', true), 'message', array('class'=>'message-red'));
					else
						$this->Session->setFlash(__('Your Account has been Deactivated by Administrator!', true), 'message', array('class'=>'message-red'));
				}
			}else
				$this->Session->setFlash(__('No Associated Email Found!! Please Register!', true), 'message', array('class'=>'message-red'));
		}
	}
	//FUNCTION FOR USER FORGOT PASSWORD END

	//FUNCTION FOR USER DASHBOARD START
	public function dashboard(){ //pr($this->Session->read('Auth.User.User'));die;
		if(isset($this->params['id']) && $this->params['id'] != 'profile'){
			if($this->params['id'] == $this->Session->read('Auth.User.User.username')){
				$this->redirect('/users/dashboard/');
			}
		}
	}
	//FUNCTION FOR USER DASHBOARD END

	//FUNCTION FOR ACCOUNT SETTINGS START
	public function settings(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$extArr = explode('.', $this->request->data['User']['image']['name']);
			$ext = end($extArr);

			$file_name = $this->Fp->uploadFiles('../webroot/img/front_end/users/profile/', $ext, $this->request->data['User']['image']);
			if($file_name != ''){
				$saveData['id'] = $this->Session->read('Auth.User.User.id');
				$saveData['image'] = $file_name;
				if($this->User->save($saveData)){
					$this->Session->write('Auth.User.User.image', $file_name);

					//delete previous file
					if($this->request->data['User']['old_image'] != ''){
						$imagePath = '../webroot/img/front_end/users/profile/'.$this->request->data['User']['old_image'];
						if(is_file($imagePath))
							unlink($imagePath);
					}
				}
			}
		}

		$this->User->recursive = -1;
		$this->data = $this->User->findById($this->Session->read('Auth.User.User.id')); //pr($this->data);die;
	}
	//FUNCTION FOR ACCOUNT SETTINGS END

	//AJAX ACCOUNT SETTINGS FUNCTIONS START
	public function save_name_details(){ //pr($_POST); die;
		$this->layout = 'ajax';

		$saveData['id'] = $this->Session->read('Auth.User.User.id');
		$saveData['first_name'] = ucwords(strtolower(trim($_POST['first_name'])));
		$saveData['last_name'] = ucwords(strtolower(trim($_POST['last_name'])));
		if($this->User->save($saveData, false)){
			$this->Session->write('Auth.User.User.first_name', ucwords(strtolower(trim($_POST['first_name']))));
			$this->Session->write('Auth.User.User.last_name', ucwords(strtolower(trim($_POST['last_name']))));
			echo 'saved';
		}else
			echo 'error';
		exit;
	}
	//AJAX ACCOUNT SETTINGS FUNCTIONS END

	//AJAX FUNCTION FOR CHANGING THE PASSWORD START
	public function save_username(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$userCount = $this->User->find('count', array('conditions'=>array('User.username'=>trim($_POST['username']), 'User.id <>'=>$this->Session->read('Auth.User.User.id'))));

		if($userCount == 0){
			$saveData['id'] = $this->Session->read('Auth.User.User.id');
			$saveData['username'] = trim($_POST['username']);
			if($this->User->save($saveData, false))
				echo '<font color="green">Username Changed Successfully!</font>';
			else
				echo '<font color="red">Please Try Later!</font>';
			
		}else
			echo '<font color="red">Username Already Taken!</font>';

		exit;
	}
	//AJAX FUNCTION FOR CHANGING THE PASSWORD END

	//AJAX FUNCTION FOR SAVING THE NEW EMAIL START
	public function save_new_email(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$userCount = $this->User->find('count', array('conditions'=>array('User.email'=>trim($_POST['email']), 'User.id <>'=>$this->Session->read('Auth.User.User.id'))));

		if($userCount == 0){
			$saveData['id'] = $this->Session->read('Auth.User.User.id');
			$saveData['email'] = trim($_POST['email']);
			if($this->User->save($saveData, false))
				echo '<font color="green">Email Changed Successfully!</font>';
			else
				echo '<font color="red">Please Try Later!</font>';
			
		}else
			echo '<font color="red">Email Already Taken!</font>';

		exit;
	}
	//AJAX FUNCTION FOR SAVING THE NEW EMAIL END

	//AJAX FUNCTION FOR SAVING THE NEW PASSWORD START
	public function save_new_password(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$userCount = $this->User->find('count', array('conditions'=>array('User.password'=>$this->Auth->password($_POST['current']), 'User.id'=>$this->Session->read('Auth.User.User.id'))));

		if($userCount == 1){
			$saveData['id'] = $this->Session->read('Auth.User.User.id');
			$saveData['password'] = $this->Auth->password($_POST['newPass']);
			if($this->User->save($saveData, false))
				echo '<font color="green">Password Changed Successfully!</font>';
			else
				echo '<font color="red">Please Try Later!</font>';
			
		}else
			echo '<font color="red">Invalid Current Password!</font>';
		exit;
	}
	//AJAX FUNCTION FOR SAVING THE NEW PASSWORD END
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/


	/*------------------------  SOCIAL MEDIA START 5/28/2013 -------------------------------------------*/
	// TWITTER SECTION START
	function login_twitter(){
		$twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);
		$request_token = $twitteroauth->getRequestToken(SITE_PATH.'users/getTwitterData/');
		if(!empty($request_token)){
			$this->Session->write('oauth_token', $request_token['oauth_token']);
			$this->Session->write('oauth_token_secret', $request_token['oauth_token_secret']);
			$twitterUrl = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
			$this->redirect($twitterUrl);
		}else
			$this->redirect(SITE_PATH);
	}

	function getTwitterData(){//pr($_GET);die;
		$twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $this->Session->read('oauth_token'), $this->Session->read('oauth_token_secret'));
		$access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);

		$saveData['id'] = $this->Session->read('Auth.User.User.id');
		$saveData['twitter_oauth_token'] = $access_token['oauth_token'];
		$saveData['twitter_oauth_verifier'] = $access_token['oauth_token_secret'];
		$this->User->save($saveData, false);
		$this->Session->write('Auth.User.User.twitter_oauth_token', $access_token['oauth_token']);
		$this->Session->write('Auth.User.User.twitter_oauth_verifier', $access_token['oauth_token_secret']);

		$this->Session->delete('oauth_token');
		$this->Session->delete('oauth_token_secret');

		$this->redirect(SITE_PATH);
	}
	// TWITTER SECTION END

	//FACEBOOK SECTION START
	public function login_facebook(){
		include_once('../Vendor/facebook/facebook-auth/facebook.php');

		$facebook = new Facebook(array(
			'appId'  => FACEBOOK_APP_ID,
			'secret' => FACEBOOK_APP_SECRET,
			'cookie' => true
		));

		$user = $facebook->getUser();
		if(!empty($user)){
			try{
				$user_profile = $facebook->api('/me'); //pr($user_profile);die;
				//$user_profile = $facebook->api('/me?fields=id,first_name,last_name,gender,email'); pr($user_profile);die;
				$access_token = $facebook->getAccessToken();

				$saveData['id'] = $this->Session->read('Auth.User.User.id');
				$saveData['facebook_oauth_token'] = $access_token;
				$saveData['facebook_oauth_secret'] = '';
				$this->User->save($saveData, false);
				$this->Session->write('Auth.User.User.facebook_oauth_token', $access_token);
				$this->Session->write('Auth.User.User.facebook_oauth_secret', '');

				$this->redirect(SITE_PATH);
			}catch(FacebookApiException $e){
				pr($e);die;
				$user = null;
			}
		}else{
			$loginUrl = $facebook->getLoginUrl(array(
				'canvas' => 1,
				'fbconnect' => 0,
				'scope' => 'offline_access,publish_stream,email'
			));
			$this->redirect($loginUrl);
		}
	}
	//FACEBOOK SECTION END

	//FUNCTIOM FOR FACEBOOK LOGIN FROM REGISTRATION SECTION START
	public function facebook_login(){
		include_once('../Vendor/facebook/facebook-auth/facebook.php');

		$facebook = new Facebook(array(
			'appId'  => FACEBOOK_APP_ID,
			'secret' => FACEBOOK_APP_SECRET,
			'cookie' => true
		));

		$user = $facebook->getUser();
		if(!empty($user)){
			try{
				$user_profile = $facebook->api('/me'); //pr($user_profile);die;
				$access_token = $facebook->getAccessToken();
				
				$userEmail = $user_profile['email'];
				$userGender = $user_profile['gender'];

				//check for the user email start
				$this->User->recursive = -1;
				$userArr = $this->User->find('first', array('conditions'=>array('User.email'=>$userEmail)));
				if(!empty($userArr)){ //if email already registered, then set the facebook Authentication Token
					$saveData['id'] = $userArr['User']['id'];
					$saveData['facebook_oauth_token'] = $access_token;
					$saveData['facebook_oauth_secret'] = '';
					$this->User->save($saveData, false);
					
					$this->User->recursive = -1;
					$userArr = $this->User->find('first', array('conditions'=>array('User.id'=>$userArr['User']['id'])));
				}else{ //if email not registered, register the email
					$newPassword = $this->Fp->createTempPassword(6);
					$gender = array('male'=>'1', 'female'=>'2');
					$saveData['first_name'] = $user_profile['first_name'];
					$saveData['last_name'] = $user_profile['last_name'];
					$saveData['email'] = trim(strtolower($userEmail));
					$saveData['password'] = $this->Auth->password($newPassword);
					$saveData['gender'] = $gender[$userGender];
					$saveData['status'] = '1';
					$saveData['activation_link'] = 'verified';
					$saveData['ip_address'] = IP_ADDRESS;
					$saveData['username'] = rand(1, 9999).'_'.time();
					$saveData['facebook_oauth_token'] = $access_token;
					$saveData['facebook_oauth_secret'] = '';

					//write the image of the user from facebook start
					$frmUrl = 'https://graph.facebook.com/'.$user_profile['id'].'/picture?type=large';
					$userImage = $this->Fp->write_file($frmUrl, '../webroot/img/front_end/users/profile/');
					if($userImage != '')
						$saveData['image'] = $userImage;
					//write the image of the user from facebook end

					$this->User->save($saveData, false);
					$lastInsertId = $this->User->id;

					$this->User->recursive = -1;
					$userArr = $this->User->find('first', array('conditions'=>array('User.id'=>$lastInsertId)));

					//send Email to user for login credentials start
					$this->set('userDetails', $userArr);
					$this->set('password', $newPassword);

					$this->Email->to	   = $saveData['email'];
					//$this->Email->to	   = 'arun_chauhan@seologistics.com';
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = 'Facebook Registration';
					$this->Email->template = 'front_end/facebook_registration';
					$this->Email->sendAs   = 'html';
					$this->Email->send();
					//send Email to user for login credentials end
				}

				//login the user, and redirect
				if($userArr['User']['status'] == '1'){
					if($this->Auth->login($userArr)){
						$this->redirect($this->wallUrl);
					}else
						$this->Session->setFlash(__('Invalid Email or Password!', true), 'message', array('class'=>'message-red'));
				}else{
					if($userArr['User']['status'] == '0')
						$this->Session->setFlash(__('Please Activate Account First!!', true), 'message', array('class'=>'message-red'));
					else
						$this->Session->setFlash(__('Account Deactivated by Administrator!!', true), 'message', array('class'=>'message-red'));
					$this->redirect(SITE_PATH);
				}
			}catch(FacebookApiException $e){
				pr($e);die;
				$user = null;
			}
		}else{
			$loginUrl = $facebook->getLoginUrl(array(
				'canvas' => 1,
				'fbconnect' => 0,
				'scope' => 'offline_access,publish_stream,email'
			));
			$this->redirect($loginUrl);
		}
	}
	//FUNCTIOM FOR FACEBOOK LOGIN FROM REGISTRATION SECTION END

	//FUNCTION FOR DEACTIVING THE SOCIAL MEDIA START
	public function deactivate_social_media(){ //pr($_POST);die;
		$this->layout = 'ajax';
		$saved = 'no';
		
		$saveData['id'] = $this->Session->read('Auth.User.User.id');
		$saveData['social_'.$_POST['socialMedia']] = '0';
		if($this->User->save($saveData)){
			$this->Session->write('Auth.User.User.social_'.$_POST['socialMedia'], '0');
			$saved = 'yes';
		}
		$this->set('saved', $saved);
		$this->set('post', $_POST);
	}
	//FUNCTION FOR DEACTIVING THE SOCIAL MEDIA END

	//FUNCTION FOR SETTING THE FEEDS POSTING PERMISSIONS START
	public function set_social_perms(){ //pr($_POST);die;
		//pr($this->Session->read('Auth.User.User'));die;
		$this->layout = '';
		
		$perms = array('social_post_feeds', 'social_post_recommends', 'social_post_ratings', 'social_post_subscriptions');
		if($_POST['permissions'] != ''){
			$availablePerms = explode(',',$_POST['permissions']);

			$saveData['id'] = $this->Session->read('Auth.User.User.id');

			foreach($perms as $p){ //echo $p;die;
				if(in_array($p, $availablePerms)){ // if present, set to 1
					$val = '1';
				}else{ // set to 0
					$val = '0';
				}
				$saveData[$p] = $val;
				$this->Session->write('Auth.User.User.'.$p, $val);
			} //pr($saveData); pr($this->Session->read('Auth.User.User'));die;

			if($this->User->save($saveData))
				echo 'success';
			else
				echo 'fail';
		}else{
			echo 'fail';
		}
		exit;
	}
	//FUNCTION FOR SETTING THE FEEDS POSTING PERMISSIONS END
	/*------------------------  SOCIAL MEDIA END 5/28/2013 -------------------------------------------*/
	public function fetch_all_states(){ //pr($_POST);die;
		$this->layout = 'ajax';

		Controller::loadModel('Country');
		$countryIdArr = $this->Country->query("SELECT id FROM fp_countries WHERE country_iso_code_3 = '".$_POST['country']."'");
		$countryId = $countryIdArr[0]['fp_countries']['id'];

		Controller::loadModel('State');
		$statesArr = $this->State->find('list', array('fields'=>array('State.state_name', 'State.state_name'), 'conditions'=>array('State.country_id'=>$countryId)));
		
		$this->set('statesArr', $statesArr);
	}

	/*-------------------------------  META TAGS START ---------------------------------------*/
	public function admin_manage_tags(){
		Controller::loadModel('MetaTag');
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->MetaTag->save($this->request->data)){
				$this->Session->setFlash(__('Tags Successfully Updated!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/users/manage_tags/');
		}else{
				$this->Session->setFlash(__('Invalid Email or Password!', true), 'message', array('class'=>'message-red'));
			}
		}

		$this->data = $this->MetaTag->findByAlias_name('home');
	}
	/*-------------------------------  META TAGS END ---------------------------------------*/

}
