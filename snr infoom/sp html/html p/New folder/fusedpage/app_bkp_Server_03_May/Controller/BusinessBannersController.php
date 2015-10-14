<?php
App::uses('AppController', 'Controller');
/**
 * BusinessBanners Controller
 *
 * @property BusinessBanner $BusinessBanner
 */
class BusinessBannersController extends AppController {
	public $name = 'BusinessBanners';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array();
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START --------------------------------------*/
	//FUNCTION FOR MANAGING THE BANNER START
	public function admin_manage($id=null){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			if($this->request->data['BusinessBanner']['image']['name'] != ''){
				if(in_array($this->request->data['BusinessBanner']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/banners/', $this->request->data['BusinessBanner']['image']);
					if($fileName != ''){
						$this->request->data['BusinessBanner']['banner'] = $fileName;
						//save the data
						if($this->BusinessBanner->save($this->request->data)){
							$this->Session->setFlash(__('Banner Saved Successfully!', true), 'message', array('class'=>'message-green'));
							$this->redirect('/admin/business_banners/manage/'.$this->request->data['BusinessBanner']['business_id'].'/');
						}else{
							$this->Session->setFlash(__('Please Try Later!', true), 'message', array('class'=>'message-red'));
							$this->redirect('/admin/business_banners/manage/'.$this->request->data['BusinessBanner']['business_id'].'/');
						}
					}else{
						$this->Session->setFlash(__('Please Try Later!', true), 'message', array('class'=>'message-red'));
						$this->redirect('/admin/business_banners/manage/'.$this->request->data['BusinessBanner']['business_id'].'/');
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$this->redirect('/admin/business_banners/manage/'.$this->request->data['BusinessBanner']['business_id'].'/');
				}
			}
		}

		if($id != ''){
			$show = 'yes';
			$this->BusinessBanner->recursive = -1;
			$businessArr = $this->BusinessBanner->find('all', array('conditions'=>array('BusinessBanner.business_id'=>$this->params['pass'][0])));
			$this->set('businessArr', $businessArr);
			if(count($businessArr) > 5)
				$show = 'no';
			$this->set('show', $show);
		}else
			$this->redirect('/admin/businesses/manage/');
	}
	//FUNCTION FOR MANAGING THE BANNER END

	//FUNCTION FOR DELELTING THE BANNER START
	public function admin_delete($id=null, $business_id=null){
		if($id != '' && $business_id != ''){
			$this->BusinessBanner->recursive = -1;
			$bannerArr = $this->BusinessBanner->findById($id);
			if(!empty($bannerArr)){
				$bannerRealPath = '../webroot/img/front_end/business/banners/'.$bannerArr['BusinessBanner']['banner'];
				if(is_file($bannerRealPath)){
					unlink($bannerRealPath);

					//delete the record
					$this->BusinessBanner->delete($id);
					$this->Session->setFlash(__('Banner Deleted Successfully!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/business_banners/manage/'.$business_id.'/');
				}else{
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
					$this->redirect('/admin/business_banners/manage/'.$business_id.'/');
				}
			}else
				$this->redirect('/admin/businesses/manage/');
		}else
			$this->redirect('/admin/businesses/manage/');
		exit;
	}
	//FUNCTION FOR DELELTING THE BANNER END

	//FUNCTION FOR SETTING THE DEFAULT BANNER START
	public function admin_default(){
		Controller::loadModel('BusinessDefaultBanner');
		
		if(!empty($this->request->data)){ //pr($this->request->data);
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			if($this->request->data['BusinessDefaultBanner']['banner']['name'] != ''){
				if(in_array($this->request->data['BusinessDefaultBanner']['banner']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/banners/', $this->request->data['BusinessDefaultBanner']['banner']);
					if($fileName != ''){
						$this->request->data['BusinessDefaultBanner']['banner'] = $fileName;
						$this->request->data['BusinessDefaultBanner']['status'] = '1';
						//save the data
						if($this->BusinessDefaultBanner->save($this->request->data)){
							$this->Session->setFlash(__('Default Banner Saved Successfully!', true), 'message', array('class'=>'message-green'));
							$this->redirect('/admin/business_banners/default/');
						}else{
							$this->Session->setFlash(__('Please Try Later!', true), 'message', array('class'=>'message-red'));
							$this->redirect('/admin/business_banners/default/');
						}
					}else{
						$this->Session->setFlash(__('Please Try Later!', true), 'message', array('class'=>'message-red'));
						$this->redirect('/admin/business_banners/default/');
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$this->redirect('/admin/business_banners/default/');
				}
			}
		}

		$this->set('defaultBannerArr', $this->BusinessDefaultBanner->find('first', array('conditions'=>array('BusinessDefaultBanner.id'=>'1', 'BusinessDefaultBanner.status'=>'1'))));
	}
	//FUNCTION FOR SETTING THE DEFAULT BANNER END

	//FUNCTION FOR DELETING THE DEFAULT BANNER START
	public function admin_delete_default_banner(){
		Controller::loadModel('BusinessDefaultBanner');

		$bannerArr = $this->BusinessDefaultBanner->findById('1'); //pr($bannerArr);die;
			if(!empty($bannerArr)){
				$bannerRealPath = '../webroot/img/front_end/business/banners/'.$bannerArr['BusinessDefaultBanner']['banner'];
				if(is_file($bannerRealPath)){
					unlink($bannerRealPath);



					//deativate the record
					$saveData['id'] = '1';
					$saveData['banner'] = '';
					$saveData['status'] = '0';
					if($this->BusinessDefaultBanner->save($saveData, false)){
						$this->Session->setFlash(__('Default Banner Deleted Successfully!', true), 'message', array('class'=>'message-green'));
						$this->redirect('/admin/business_banners/default/');
					}else{
						$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
						$this->redirect('/admin/business_banners/default/');
					}
			}else
				$this->redirect('/admin/business_banners/default/');
		}else
			$this->redirect('/admin/business_banners/default/');
		exit;
	}
	//FUNCTION FOR DELETING THE DEFAULT BANNER END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

}
