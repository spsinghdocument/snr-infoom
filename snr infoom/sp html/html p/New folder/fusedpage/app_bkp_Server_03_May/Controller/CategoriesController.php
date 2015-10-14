<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {
	public $name = 'Categories';
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Fused', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp');

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('fetch_sub_categories');
		}
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR ADDING A CATEGORY START
	public function admin_add() {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$saveData['name'] = ucwords(trim($this->request->data['Category']['name']));
			$saveData['alias_name'] = $this->Fp->parseParameter($saveData['name']);
			$saveData['status'] = $this->request->data['Category']['status'];
			if($this->Category->save($saveData)){
				$this->Session->setFlash(__('Category Added Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/categories/manage/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}
	}
	//FUNCTION FOR ADDING A CATEGORY END

	//FUNCTION FOR MANAGING THE CATEGORIES START
	public function admin_manage() {
		$this->paginate = array('conditions'=>array('Category.parent_id'=>0),'limit'=>PAGING_SIZE, 'order'=>array('Category.id'=>'ASC'));
		$this->set('viewListing', $this->paginate('Category'));
	}
	//FUNCTION FOR MANAGING THE CATEGORIES END

	//FUNCTION FOR MANAGING THE CATEGORIES START
	public function admin_status_update($id, $newStatus) {
		if($id != ''){
			$pageCount = $this->Category->find('count', array('conditions'=>array('Category.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Category->save($saveData, false))
					$this->Session->setFlash(__('Category '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/categories/manage/');
		exit;
	}
	//FUNCTION FOR MANAGING THE CATEGORIES END

	//FUNCTION FOR VIEWING THE CATEGORY DETAILS START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('categoryArr', $this->Category->findById($id));
	}
	//FUNCTION FOR VIEWING THE CATEGORY DETAILS END

	//FUNCTION FOR EDITING THE CATEGORY DETAILS START
	public function admin_edit($id=null) {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Category->save($this->request->data)){
				$this->Session->setFlash(__('Category Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/categories/manage/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}

		if($id != ''){
			$catArr = $this->Category->findById($id);
			if(!empty($catArr)){
				$this->data = $catArr;
			}else{
				$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/categories/manage/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/manage/');
		}
	}
	//FUNCTION FOR EDITING THE CATEGORY DETAILS END

	//FUNCTION FOR DELETING THE CATEGORY DETAILS START
	public function admin_delete($id=null) {
		if($id != ''){
			if($this->Category->delete($id))
				$this->Session->setFlash(__('Category Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/manage/');
		}else{
			$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/manage/');
		}
		exit;
	}
	//FUNCTION FOR DELETING THE CATEGORY DETAILS END

	//FUNCTION FOR ADDING THE SUB-CATEGORY START
	public function admin_add_sub_category($parent_id=null) {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$saveData['parent_id'] = $this->request->data['Category']['parent_id'];
			$saveData['name'] = ucwords(trim($this->request->data['Category']['name']));
			$saveData['alias_name'] = $this->Fp->parseParameter($saveData['name']);
			$saveData['status'] = $this->request->data['Category']['status'];
			if($this->Category->save($saveData)){
				//update the counter of parent category
				$this->Fp->incrementField('Category', 'count', '+', $saveData['parent_id']);
				$this->Session->setFlash(__('Sub-Category Added Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/categories/sub_categories_manage/'.$saveData['parent_id'].'/');
			}else{
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/categories/manage/');
			}
		}

		if($parent_id != '')
			$this->request->data['Category']['parent_id'] = $parent_id;
	}
	//FUNCTION FOR ADDING THE SUB-CATEGORY END

	//FUNCTION FOR MANAGING THE SUB-CATEGORIES START
	public function admin_sub_categories_manage($parent_id){
		if($parent_id != ''){
			$this->paginate = array('conditions'=>array('Category.parent_id'=>$parent_id), 'limit'=>PAGING_SIZE, 'order'=>array('Category.id'=>'ASC'));
			$this->set('viewListing', $this->paginate('Category'));
		}else{
			$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/manage/');
		}
	}
	//FUNCTION FOR MANAGING THE SUB-CATEGORIES END

	//FUNCTION FOR MANAGING THE CATEGORIES START
	public function admin_sub_category_status_update($parent_id, $id, $newStatus) {
		if($id != ''){
			$pageCount = $this->Category->find('count', array('conditions'=>array('Category.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Category->save($saveData, false))
					$this->Session->setFlash(__('Sub-Category '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/categories/sub_categories_manage/'.$parent_id.'/');
		exit;
	}
	//FUNCTION FOR MANAGING THE CATEGORIES END

	//FUNCTION FOR EDITING A SUB-CATEGORY START
	public function admin_sub_category_edit($parent_id, $id) {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Category->save($this->request->data)){
				//set parent_ID's
				if($this->request->data['Category']['original_parent_id'] != $this->request->data['Category']['parent_id']){
					//decrement the original one
					$this->Fp->incrementField('Category', 'count', '-', $this->request->data['Category']['original_parent_id']);
					//decrement the new one
					$this->Fp->incrementField('Category', 'count', '+', $this->request->data['Category']['parent_id']);
				}
				$this->Session->setFlash(__('Sub-Category Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/categories/sub_categories_manage/'.$this->request->data['Category']['parent_id'].'/');
			}else
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
		}

		if($id != ''){
			$catArr = $this->Category->findById($id);
			if(!empty($catArr)){ //pr($catArr);die;
				$this->data = $catArr;
			}else{
				$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/categories/sub_categories_manage/'.$parent_id.'/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/sub_categories_manage/'.$parent_id.'/');
		}
	}
	//FUNCTION FOR EDITING A SUB-CATEGORY END

	//FUNCTION FOR ADDING A SUB-CATEGORY START
	public function admin_sub_category_delete($parent_id, $id) {
		if($id != ''){
			if($this->Category->delete($id)){
				$this->Session->setFlash(__('Sub-Category Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				//decrement the counter of parent_id
				$this->Fp->incrementField('Category', 'count', '-', $parent_id);
			}else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/sub_categories_manage/'.$parent_id.'/');
		}else{
			$this->Session->setFlash(__('No Associated Category Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/categories/sub_categories_manage/'.$parent_id.'/');
		}
		exit;
	}
	//FUNCTION FOR ADDING A SUB-CATEGORY END

	//AJAX FUNCTION FOR FETCHING THE SUB-CATEGORIES START
	public function fetch_sub_categories(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$ret = '';

		$catArr = $this->Category->find('list', array('fields'=>array('Category.id', 'Category.name'), 'conditions'=>array('Category.status'=>'1', 'Category.parent_id'=>$_POST['category_id']), 'order'=>array('Category.name'=>'ASC')));
		if(!empty($catArr))
			$ret = $catArr;

		$this->set('catArr', $catArr);
		$this->set('type', $_POST['type']);
	}
	//AJAX FUNCTION FOR FETCHING THE SUB-CATEGORIES END
	/*---------------------------- ADMIN SECTION END   ----------------------------------------*/
}
