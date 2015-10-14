<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 */
class FaqsController extends AppController {
	public $name = 'Faqs';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp');

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('faq', 'fetch_paging_data');
		}
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR ADDING A NEW FAQ START
	public function admin_add() {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Faq->save($this->request->data)){
				$this->Session->setFlash(__('FAQ Added Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/faqs/manage/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}
	}
	//FUNCTION FOR ADDING A NEW FAQ END

	//FUNCTION FOR MANAGING THE FAQ's START
	public function admin_manage() {
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('Faq.id'=>'ASC'));
		$this->set('viewListing', $this->paginate('Faq'));
	}
	//FUNCTION FOR MANAGING THE FAQ's END

	//FUNCTION FOR UPDATING THE STATUS START
	public function admin_status_update($id, $newStatus) {
		if($id != ''){
			$pageCount = $this->Faq->find('count', array('conditions'=>array('Faq.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Faq->save($saveData, false))
					$this->Session->setFlash(__('FAQ '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/faqs/manage/');
		exit;
	}
	//FUNCTION FOR UPDATING THE STATUS END

	//FUNCTION TO VIEW THE FAQ CONTENT START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('pageArr', $this->Faq->findById($id));
	}
	//FUNCTION TO VIEW THE FAQ CONTENT END

	//FUNCTION FOR EDITING A FAQ START
	public function admin_edit($id) {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Faq->save($this->request->data)){
				$this->Session->setFlash(__('FAQ Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/faqs/manage/');
			}else{
				$id = $this->request->data['Faq']['id'];
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
			}
		}

		if($id != ''){
			$faqArr = $this->Faq->findById($id);
			if(!empty($faqArr)){ //pr($faqArr);die;
				$this->data = $faqArr;
			}else{
				$this->Session->setFlash(__('No Associated FAQ Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/faqs/manage/');
			}
		}else
			$this->redirect('/admin/faqs/manage/');
	}
	//FUNCTION FOR EDITING A FAQ END

	//FUNCTION FOR DELETING A FAQ START
	public function admin_delete($id) {
		if($id != ''){
			$faqCount = $this->Faq->find('count', array('conditions'=>array('Faq.id'=>$id)));
			if($faqCount > 0){
				if($this->Faq->delete($id))
					$this->Session->setFlash(__('FAQ Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/faqs/manage/');
			}else{
				$this->Session->setFlash(__('No Associated FAQ Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/faqs/manage/');
			}
		}else{
			$this->Session->setFlash(__('No Associated FAQ Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/faqs/manage/');
		}
	}
	//FUNCTION FOR DELETING A FAQ END
	/*---------------------------- ADMIN SECTION END ------------------------------------------*/

	/*---------------------------- FRONT SECTION START ------------------------------------------*/
	//FUNCTION FOR FAQ START
	public function faq(){
		$this->layout = 'FrontEnd/default';
		Controller::loadModel('FaqMeta');
		//load FAQ Meta Tags
		$this->set('faqMetaArr', $this->FaqMeta->findById('1'));

		$this->set('viewListing', $this->Faq->find('all', array('conditions'=>array('Faq.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('Faq.id'=>'DESC'))));
	}
	//FUNCTION FOR FAQ END

	//FUNCTION FOR FETCHING THE DATA FOR PAGINATION START
	function fetch_paging_data(){ //pr($_POST);die;
		$this->layout = 'ajax';
	
		$this->set('viewListing', $this->Fp->set_scroll_pagination_data('Faq', $_POST['last_viewed_page'], PAGING_SIZE, array('Faq.status'=>'1'), array('Faq.id'=>'DESC')));
	}
	//FUNCTION FOR FETCHING THE DATA FOR PAGINATION END
	/*---------------------------- FRONT SECTION END --------------------------------------------*/

}
