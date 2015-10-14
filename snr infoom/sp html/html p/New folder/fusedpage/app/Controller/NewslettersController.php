<?php
App::uses('AppController', 'Controller');
/**
 * Newsletters Controller
 *
 * @property Newsletter $Newsletter
 */
class NewslettersController extends AppController {
	public $name = 'Newsletters';
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Fused', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp');

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			//$this->Auth->allowedActions = array('');
		}
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR MANAGING THE SUBSCRIBERS START
	public function admin_manage() {
		Controller::loadModel('User');
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('Newsletter.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('Newsletter'));
	}
	//FUNCTION FOR MANAGING THE SUBSCRIBERS END

	//FUNCTION FOR MANAGING THE STATUS OF SUBSCRIBERS START
	public function admin_status_update($id, $newStatus) {
		if($id != ''){
			$pageCount = $this->Newsletter->find('count', array('conditions'=>array('Newsletter.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Newsletter->save($saveData, false))
					$this->Session->setFlash(__('Subscriber '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Subscriber Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Subscriber Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Subscriber Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/newsletters/manage/');
		exit;
	}
	//FUNCTION FOR MANAGING THE STATUS OF SUBSCRIBERS START

	//FUNCTION FOR DELETING THE SUBSCRIBER START
	public function admin_delete($id) {
		if($id != ''){
			$subscriberCount = $this->Newsletter->find('count', array('conditions'=>array('Newsletter.id'=>$id)));
			if($subscriberCount > 0){
				if($this->Newsletter->delete($id))
					$this->Session->setFlash(__('Subscriber Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/newsletters/manage/');
			}else{
				$this->Session->setFlash(__('No Associated Subscriber Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/newsletters/manage/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Subscriber Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/newsletters/manage/');
		}
	}
	//FUNCTION FOR DELETING THE SUBSCRIBER END

	//FUNCTION FOR VIEWING THE SUBSCRIBER DETAIL START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('subscriberArr', $this->Newsletter->findById($id));
	}
	//FUNCTION FOR VIEWING THE SUBSCRIBER DETAIL END

	//FUNCTION TO SEND THE NEWSLETTER START
	public function admin_send() {
		set_time_limit(0);
		if(!empty($this->request->data)){ //pr($this->request->data);
			if(!empty($this->request->data['Newsletter']['message'])){
				$this->set('message', $this->request->data['Newsletter']['message']);
				foreach($this->request->data['Newsletter']['emails'] as $subscriber){ //echo $subscriber;die;
					//Send Email
					$this->Email->to	   = $subscriber;
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = trim($this->request->data['Newsletter']['subject']);
					$this->Email->template = 'admin/newsletter';
					$this->Email->sendAs   = 'html'; 
					$this->Email->send();
				}
				$this->Session->setFlash(__('Newsletter Sent Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/newsletters/send/');
			}else{
				$this->Session->setFlash(__('Please Provide Message!!', true), 'message', array('class'=>'message-red'));
			}
		}
	}
	//FUNCTION TO SEND THE NEWSLETTER END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

}
