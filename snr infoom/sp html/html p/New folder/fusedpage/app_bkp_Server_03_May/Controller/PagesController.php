<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {
/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Fck', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp');

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('page');
		}
	}
	//BEFORE FILTER ENDS

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	/*public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	} */



	/*----------------------------  ADMIN SECTION START ---------------------------------------------*/
	//FUNCTION FOR ADMIN MANAGE START
	public function admin_manage() {
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('Page.id'=>'ASC'));
		$this->set('viewListing', $this->paginate('Page'));
	}
	//FUNCTION FOR ADMIN MANAGE END

	//FUNCTION FOR ACTIVATING/DEACTIVATING THE PAGE START
	public function admin_status_update($id, $newStatus) {
		if($id != ''){
			$pageCount = $this->Page->find('count', array('conditions'=>array('Page.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Page->save($saveData, false))
					$this->Session->setFlash(__('Page '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/pages/manage/');
		exit;
	}
	//FUNCTION FOR ACTIVATING/DEACTIVATING THE PAGE END

	//FUNCTION FOR EDITING THE PAGE CONTENT START
	public function admin_edit($id) {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->Page->save($this->request->data)){
				$this->Session->setFlash(__('Content Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/pages/manage/');
			}else{
				$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
				$id = $this->request->data['Page']['id'];
			}
		}

		if($id != ''){
			$pageArr = $this->Page->findById($id);
			if(!empty($pageArr)){
				$this->data = $pageArr;
			}else{
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/pages/manage/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/pages/manage/');
		}
	}
	//FUNCTION FOR EDITING THE PAGE CONTENT END

	//FUNCTION TO VIEW THE PAGE CONTENT START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('pageArr', $this->Page->findById($id));
	}
	//FUNCTION TO VIEW THE PAGE CONTENT END
	/*----------------------------  ADMIN SECTION END ---------------------------------------------*/

	/*----------------------------  FRONT SECTION START -------------------------------------------*/
	//FUNCTION FOR CMS PAGE START
	public function page($page=null){
		$this->layout = 'FrontEnd/default';
		if($page != ''){
			$pageArr = $this->Page->find('first', array('conditions'=>array('Page.alias_name'=>$page, 'Page.status'=>'1')));
			if(!empty($pageArr)){
				$this->set('pageArr', $pageArr);
			}else
				$this->redirect('/');
		}else
			$this->redirect('/');
	}
	//FUNCTION FOR CMS PAGE END
	/*----------------------------  FRONT SECTION END ---------------------------------------------*/
}
