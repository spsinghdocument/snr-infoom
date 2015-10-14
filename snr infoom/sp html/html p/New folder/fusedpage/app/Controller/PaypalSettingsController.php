<?php
App::uses('AppController', 'Controller');
/**
 * PaypalSettings Controller
 *
 * @property PaypalSetting $PaypalSetting
 */
class PaypalSettingsController extends AppController {
	public $name = 'PaypalSettings';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();		
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR SETTING THE PAYMENT MODE START
	public function admin_set_payment_mode(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			//assumptions: id => 1 for testing && id => 2 for live
			if($this->request->data['PaypalSetting']['mode'] == 'Testing'){
				$saveData['id'] = 1;
				$saveData['status'] = '1';
				$this->PaypalSetting->save($saveData);

				$savePaypalData['id'] = 2;
				$savePaypalData['status'] = '0';
				$this->PaypalSetting->save($savePaypalData);
			}else{
				$saveData['id'] = 1;
				$saveData['status'] = '0';
				$this->PaypalSetting->save($saveData);

				$savePaypalData['id'] = 2;
				$savePaypalData['status'] = '1';
				$this->PaypalSetting->save($savePaypalData);
			}
			$this->Session->setFlash(__('Paypal Mode Set Successfully!!', true), 'message', array('class'=>'message-green'));
			$this->redirect('/admin/paypal_settings/set_payment_mode/');
		}

		$this->PaypalSetting->recursive = -1;
		$paypalArr = $this->PaypalSetting->find('first', array('fields'=>array('PaypalSetting.mode_type'), 'conditions'=>array('PaypalSetting.status'=>'1')));// pr($paypalArr);die;
		$this->set('mode_type', $paypalArr['PaypalSetting']['mode_type']);
	}
	//FUNCTION FOR SETTING THE PAYMENT MODE END

	//FUNCTION FOR SETTING THE PAYPAL CREDENTIALS START
	public function admin_set_paypal_credentials(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->PaypalSetting->save($this->request->data)){
				$this->Session->setFlash(__('Paypal Credentials Set Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/paypal_settings/set_paypal_credentials/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}

		$this->PaypalSetting->recursive = -1;
		$paypalArr = $this->PaypalSetting->find('first', array('conditions'=>array('PaypalSetting.id'=>2)));
		$this->data = $paypalArr;
	}
	//FUNCTION FOR SETTING THE PAYPAL CREDENTIALS END
	/*---------------------------- ADMIN SECTION END   ----------------------------------------*/

}
