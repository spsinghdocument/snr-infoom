<?php
App::uses('AppController', 'Controller');
/**
 * HowItWorks Controller
 *
 * @property HowItWork $HowItWork
 */
class HowItWorksController extends AppController {
	public $name = 'HowItWorks';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('how_it_works', 'fetch_specific_content');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START --------------------------------------*/
	//FUNCTION FOR MANAGING THE CONTENT START
	public function admin_manage_content(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->HowItWork->save($this->request->data))
				$this->Session->setFlash(__('Content Uploaded Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Sorry Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/how_it_works/manage_content/');
		}

		$this->data = $this->HowItWork->findById('1');
	}
	//FUNCTION FOR MANAGING THE CONTENT END

	//FUNCTION FOR MANAGING THE CONTENT FOR USER START
	public function admin_manage_content_user(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->HowItWork->save($this->request->data))
				$this->Session->setFlash(__('Content Uploaded Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Sorry Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/how_it_works/manage_content_user/');
		}

		$this->data = $this->HowItWork->findById('2');
	}
	//FUNCTION FOR MANAGING THE CONTENT FOR USER END

	//FUNCTION FOR MANAGING THE PAGE CONTENT START
	public function admin_manage_page_content(){
		$this->paginate = array('conditions'=>array('HowItWork.id >'=>2), 'limit'=>PAGING_SIZE, 'order'=>array('HowItWork.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('HowItWork'));
	}
	//FUNCTION FOR MANAGING THE PAGE CONTENT END

	//FUNCTION FOR ADDING A NEW PAGE CONTENT START
	public function admin_add_page_content(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload image
			if($this->request->data['HowItWork']['image']['name'] != ''){
				if(in_array($this->request->data['HowItWork']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/', $this->request->data['HowItWork']['image']);
					if($fileName != ''){
						$this->request->data['HowItWork']['image'] = $fileName;
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}

			//save the other data
			if($continue == 'true'){
				if($this->HowItWork->save($this->request->data)){
					$this->Session->setFlash(__('Content Added Successfully!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/how_it_works/manage_page_content/');
				}else
					$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
			}
		}
	}
	//FUNCTION FOR ADDING A NEW PAGE CONTENT END

	//FUNCTION FOR MANAGING THE STATUS START
	public function admin_status_update($id, $newStatus){
		if($id != ''){
			$pageCount = $this->HowItWork->find('count', array('conditions'=>array('HowItWork.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->HowItWork->save($saveData, false))
					$this->Session->setFlash(__('Content '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/how_it_works/manage_page_content/');
		exit;
	}
	//FUNCTION FOR MANAGING THE STATUS END

	//FUNCTION FOR ADMIN VIEW START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('businessArr', $this->HowItWork->findById($id));
	}
	//FUNCTION FOR ADMIN VIEW END

	//FUNCTION FOR DELETING A CONTENT START
	public function admin_delete($id=null){
		if($id != ''){
			$this->HowItWork->recursive = -1;
			$businessArr = $this->HowItWork->findById($id);
			if(!empty($businessArr)){
				//delete the image
				if($businessArr['HowItWork']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/business/'.$businessArr['HowItWork']['image'];
					if(is_file($imageRealPath))
						unlink($imageRealPath);
				}

				//delete the record
				if($this->HowItWork->delete($id))
					$this->Session->setFlash(__('Content Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/how_it_works/manage_page_content/');
			}else{
				$this->Session->setFlash(__('No Associated Content Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/how_it_works/manage_page_content/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Content Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/how_it_works/manage_page_content/');
		}
	}
	//FUNCTION FOR DELETING A CONTENT END

	//FUNCTION FOR EDITING A CONTENT START
	public function admin_edit($id){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the new file
			if($this->request->data['HowItWork']['image']['name'] != ''){
				if(in_array($this->request->data['HowItWork']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/', $this->request->data['HowItWork']['image']);
					if($fileName != ''){
						//delete the old file start
						if($this->request->data['HowItWork']['old_image'] != ''){
							$realImagePath = '../webroot/img/front_end/business/'.$this->request->data['HowItWork']['old_image'];
							if(is_file($realImagePath))
								unlink($realImagePath);
						}
						//delete the old file end
						$this->request->data['HowItWork']['image'] = $fileName;
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}else
				$this->request->data['HowItWork']['image'] = $this->request->data['HowItWork']['old_image'];

			if($continue == 'true'){
				if($this->HowItWork->save($this->request->data)){
					$this->Session->setFlash(__('Content Updated Successfully!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/how_it_works/manage_page_content/');
				}else
					$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
			}
		}

		if(!empty($id)){
			$howItWorksArr = $this->HowItWork->findById($id);
			if(!empty($howItWorksArr)){
				$this->data = $howItWorksArr;
			}else
				$this->redirect('/admin/how_it_works/manage_page_content/');
		}else
			$this->redirect('/admin/how_it_works/manage_page_content/');
	}
	//FUNCTION FOR EDITING A CONTENT END
	/*---------------------------- ADMIN SECTION END   --------------------------------------*/

	/*---------------------------- FRONT SECTION START   --------------------------------------*/
	//FUNCTION FOR HOW IT WORKS START
	public function how_it_works(){
		
	}
	//FUNCTION FOR HOW IT WORKS END

	//FUNCTION TO FETCH THE SPECIFIC DATA START
	public function fetch_specific_content(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$contentArr = $this->HowItWork->findById($_POST['id']);
		$this->set('listing', $contentArr);
	}
	//FUNCTION TO FETCH THE SPECIFIC DATA END
	/*---------------------------- FRONT SECTION END     --------------------------------------*/

}
