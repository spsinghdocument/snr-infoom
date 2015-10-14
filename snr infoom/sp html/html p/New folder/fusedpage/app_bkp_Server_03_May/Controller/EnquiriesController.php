<?php
App::uses('AppController', 'Controller');
/**
 * Enquiries Controller
 *
 * @property Enquiry $Enquiry
 */
class EnquiriesController extends AppController {
	public $name = 'Enquiries';
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Fused', 'Image');
	public $components = array('Session', 'Auth');

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('contact_us');
		}
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR MANAGING ALL ENQUIRIES START
	public function admin_manage() {
		$this->paginate = array('conditions'=>array('Enquiry.admin_delete'=>'0'), 'limit'=>PAGING_SIZE, 'order'=>array('Enquiry.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('Enquiry'));
	}
	//FUNCTION FOR MANAGING ALL ENQUIRIES END

	//FUNCTION FOR DELETING THE ENQUIRY START
	public function admin_delete($id) {
		if($id != ''){
			$enqArr = $this->Enquiry->findById($id);
			if(!empty($enqArr)){
				$saveData['id'] = $enqArr['Enquiry']['id'];
				$saveData['admin_delete'] = '1';
				if($this->Enquiry->save($saveData))
					$this->Session->setFlash(__('Enquiry Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/enquiries/manage/');
			}else{
				$this->Session->setFlash(__('No Associated Enquiry Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/enquiries/manage/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Enquiry Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/enquiries/manage/');
		}
		exit;
	}
	//FUNCTION FOR DELETING THE ENQUIRY END

	//FUNCTION FOR VIEWING THE ENQUIRY START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$saveData['id'] = $id;
		$saveData['view'] = '1';
		$this->Enquiry->save($saveData, false);

		$this->set('enqAqq', $this->Enquiry->findById($id));
	}
	//FUNCTION FOR VIEWING THE ENQUIRY END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT SECTION START ----------------------------------------*/
	//FUNCTION FOR CONTACT US START
	public function contact_us(){
		$this->layout = 'FrontEnd/default';

		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Enquiry->save($this->request->data)){
				$this->Session->setFlash(__('Enquiry sent successfully!! Administrator would contact you soon!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/enquiries/contact_us/');
			}else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
		}
	}
	//FUNCTION FOR CONTACT US END
	/*---------------------------- FRONT SECTION END ----------------------------------------*/

}
