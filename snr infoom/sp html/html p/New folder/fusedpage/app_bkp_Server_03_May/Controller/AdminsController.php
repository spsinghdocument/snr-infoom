<?php
App::uses('AppController', 'Controller');
/**
 * Admins Controller
 *
 * @property Admin $Admin
 */
class AdminsController extends AppController {

	public $name = 'Admins';
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp');
	public $layout = 'Admin/default';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->userModel = 'Admin';
		$this->Auth->fields = array('username'=>'username', 'password'=>'password');

		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('admin_sign_in', 'admin_forgot_password');
	}
	//BEFORE FILTER ENDS

	//FUNCTION FOR ADMIN FORGOT PASSWORD START
	public function admin_forgot_password(){
		$this->layout = 'Admin/sign_in';

		//VALIDATE ADMIN START
		$redirectUrl = $this->Fp->validateAdmin();
		if($redirectUrl != '')
			$this->redirect($redirectUrl);
		//VALIDATE ADMIN END

		if(!empty($this->data)){ //pr($this->request->data);die;
			$adminArr = $this->Admin->findByEmail($this->request->data['Admin']['email']);
			if(!empty($adminArr)){ //pr($adminArr);die;
				$newPassword = $this->Fp->createTempPassword(8);
				$encNewPassword = $this->Auth->password($newPassword);
				$saveData['id'] = $adminArr['Admin']['id'];
				$saveData['password'] = $encNewPassword;
				if($this->Admin->save($saveData, false)){
					//SEND EMAIL TO ADMINISTRATOR START
					$this->set('adminArr', $adminArr);
					$this->set('newPassword', $newPassword);

					$this->Email->to	   = $adminArr['Admin']['email'];
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = 'Your New Login Password';
					$this->Email->template = 'admin/forgot_password';
					$this->Email->sendAs   = 'html'; 
					$this->Email->send();
					//SEND EMAIL TO ADMINISTRATOR END

					$this->Session->setFlash(__('New Password Sent to Your Email Successfully!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/admins/sign_in/');
				}
			}else{
				$this->Session->setFlash(__('No Corresponding Email Found!!', true), 'message', array('class'=>'message-red'));
			}
		}
	}
	//FUNCTION FOR ADMIN FORGOT PASSWORD END

	//FUNCTION FOR ADMIN LOGIN START
	public function admin_sign_in() {
		$this->layout = 'Admin/sign_in';

		//VALIDATE ADMIN START
		$redirectUrl = $this->Fp->validateAdmin();
		if($redirectUrl != '')
			$this->redirect($redirectUrl);
		//VALIDATE ADMIN END

		if(!empty($this->data)){ //pr($this->request->data);die;
			$this->Admin->recursive = -1;
			$adminArr = $this->Admin->find('first', array('conditions'=>array('username'=>trim($this->request->data['Admin']['username']), 'password'=>$this->Auth->password($this->request->data['Admin']['password']))));
			if(!empty($adminArr)){
				if($adminArr['Admin']['role'] == '1'){ // if super admin
					//directly login
					if($this->Auth->login($adminArr))
						$this->redirect('/admin/admins/dashboard/');
					else
						$this->Session->setFlash(__('Invalid Username or Password!!', true), 'message', array('class'=>'message-red'));
				}else{ // if sub-admin
					
				}
			}else{
				$this->Session->setFlash(__('Invalid Username or Password!!', true), 'message', array('class'=>'message-red'));
			}
		}
	}
	//FUNCTION FOR ADMIN LOGIN END

	//FUNCTION FOR ADMIN DASHBOARD START
	function admin_dashboard() { //pr($this->Session->read('Auth'));die;
		
	}
	//FUNCTION FOR ADMIN DASHBOARD END

	//FUNCTION FOR ADMIN SIGN OUT START
	public function admin_sign_out() {
		if($this->Session->check('Auth.Admin')){
			if($this->Session->delete('Auth.Admin'))
				$this->redirect('/admin/admins/sign_in');
		}
	}
	//FUNCTION FOR ADMIN SIGN OUT END

	//FUNCTION FOR CHANGING THE ADMIN EMAIL START
	public function admin_change_email() {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Admin->save($this->request->data)){
				$this->Session->setFlash(__('Admin Email Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/admins/change_email/');
			}else
				$this->Session->setFlash(__('Please Correct Following Error!!', true), 'message', array('class'=>'message-red'));
		}
		$this->data = $this->Admin->findById($this->Session->read('Auth.Admin.Admin.id'));
	}
	//FUNCTION FOR CHANGING THE ADMIN EMAIL END

	//FUNCTION FOR CHANGING THE ADMIN PASSWORD START
	public function admin_change_password() {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			//validate current password
			$adminCount = $this->Admin->find('count', array('conditions'=>array('Admin.id'=>$this->request->data['Admin']['id'], 'Admin.password'=>$this->Auth->password($this->request->data['Admin']['current_password']))));

			if($adminCount > 0){
				//match both passwords
				if($this->request->data['Admin']['new_password'] == $this->request->data['Admin']['confirm_password']){
					$saveData['id'] = $this->request->data['Admin']['id'];
					$saveData['password'] = $this->Auth->password($this->request->data['Admin']['confirm_password']);
					if($this->Admin->save($saveData)){
						$this->Session->setFlash(__('Password Updated Successfully!!', true), 'message', array('class'=>'message-green'));
						$this->redirect('/admin/admins/change_password/');
					}else
						$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				}else
					$this->Session->setFlash(__('Both Passwords Should be Same!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('Invalid Current Password!!', true), 'message', array('class'=>'message-red'));
		}
		$this->data = $this->Admin->findById($this->Session->read('Auth.Admin.Admin.id'));
	}
	//FUNCTION FOR CHANGING THE ADMIN PASSWORD END

}
