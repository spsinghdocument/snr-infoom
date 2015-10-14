<?php
App::uses('AppController', 'Controller');
/**
 * FaqMetas Controller
 *
 * @property FaqMeta $FaqMeta
 */
class FaqMetasController extends AppController {
	public $name = 'FaqMetas';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
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
	//FUNCTION FOR MANAGING THE FAQ META TAGS START
	public function admin_manage() {
		$this->set('metaArr', $this->FaqMeta->findById('1'));
	}
	//FUNCTION FOR MANAGING THE FAQ META TAGS END

	//FUNCTION FOR EDITING THE FAQ META TAGS START
	public function admin_edit() {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->FaqMeta->save($this->request->data)){
				$this->Session->setFlash(__('Meta Tags Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/faq_metas/manage/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}

		$this->data = $this->FaqMeta->findById('1');
	}
	//FUNCTION FOR EDITING THE FAQ META TAGS END

	//FUNCTION FOR VIEWING THE META TAG START
	public function admin_view() {
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('metaArr', $this->FaqMeta->findById('1'));
	}
	//FUNCTION FOR VIEWING THE META TAG END
	/*---------------------------- ADMIN SECTION END ------------------------------------------*/
	


}
