<?php
App::uses('AppController', 'Controller');
/**
 * Memberships Controller
 *
 * @property Membership $Membership
 */
class MembershipsController extends AppController {
	public $name = 'Memberships';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('fetch_membership_data/');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR MANAGING THE MEMBERSHIPS PLANS START
	public function admin_manage(){
		//$this->Membership->recursive = -1;
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('Membership.id'=>'ASC'));
		$this->set('viewListing', $this->paginate('Membership'));
	}
	//FUNCTION FOR MANAGING THE MEMBERSHIPS PLANS END

	//FUNCTION FOR MEMBERSHIP PLAN STATUS CHANGE START
	public function admin_status_update($alias_name, $newStatus){
		if($alias_name != ''){
			$planArr = $this->Membership->findByAlias_name($alias_name); //pr($planArr);die;
			if(!empty($planArr)){
				$saveData['id'] = $planArr['Membership']['id'];
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Membership->save($saveData, false))
					$this->Session->setFlash(__('Plan '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Plan Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Plan Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Plan Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/memberships/manage/');
		exit;
	}
	//FUNCTION FOR MEMBERSHIP PLAN STATUS CHANGE END

	//FUNCTION FOR EDITING A MEMBERSHIP PLAN START
	public function admin_edit($alias_name=null){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Membership->save($this->request->data)){
				$this->Session->setFlash(__('Plan Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/memberships/manage/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}

		if($alias_name != ''){
			$planArr = $this->Membership->findByAlias_name($alias_name);
			if(!empty($planArr)){
				$this->data = $planArr;
			}else
				$this->redirect('/admin/memberships/manage/');
		}else
			$this->redirect('/admin/memberships/manage/');
	}
	//FUNCTION FOR EDITING A MEMBERSHIP PLAN END

	//FUNCTION FOR ADMIN VIEW START
	public function admin_view($alias_name){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('planArr', $this->Membership->findByAlias_name($alias_name));
	}
	//FUNCTION FOR ADMIN VIEW END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	//FUNCTION FOR FECTHING THE MEMBERSHIP PLAN DATA START
	public function fetch_membership_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$membershipArr = $this->Membership->findByAlias_name($_POST['alias_name']);
		$this->set('membershipArr', $membershipArr);
	}
	//FUNCTION FOR FECTHING THE MEMBERSHIP PLAN DATA END
}
