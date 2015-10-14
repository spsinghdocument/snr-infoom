<?php
App::uses('AppController', 'Controller');
App::uses('Xml','Utility');

/**
 * Sites Controller
 *
 * @property Enquiry $Site
 */


class SitesController extends AppController
{
	var $name='Sites';
	//var $uses = array('Issue','Category','Article','ArticleCategory');
	var $helpers=array('Session','Html');
	public $components = array('Session', 'Auth');
   //BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('sitemap');
		}
	}
	//BEFORE FILTER ENDS


	function sitemap()
	{ //Configure::write ('debug', 0);
		//App::import('Xml');
		
		$this->layout='null';
		//echo Configure::version();
		//exit;
		//$this->autoRender=false;
		//Controller::loadModel('Business');
		
		$this->header('Content-type: text/xml');
		
		//echo "<?xml version=\"1.0\">";

	    // $site = $this->Business->find('all',array('conditions'=>array('Business.status'=>1))); 
		 
		 //pr($site);
		 //exit;
		//$site1 = $this->Article->find('all',array('conditions'=>array('Article.active'=>1,'Article.type'=>'M')));   
		//$site2 = $this->Issue->find('all',array('conditions'=>array('Issue.active'=>1,'Issue.type'=>'M'))); 
	
		//$site3 = $this->Category->find('all',array('conditions'=>array('Category.active'=>1,'Category.type'=>'J')));     
		//$site4 = $this->Article->find('all',array('conditions'=>array('Article.active'=>1,'Article.type'=>'J')));   
		//$site5 = $this->Issue->find('all',array('conditions'=>array('Issue.active'=>1,'Issue.type'=>'J')));   
       //$this->set('site',$site);	
		//  $this->set('site1',$site1);	
		   // $this->set('site2',$site2);	
			// $this->set('site3',$site3);	
		  //$this->set('site4',$site4);	
		  //  $this->set('site5',$site5);	
        $today =  date('Y-m-d');
		$this->set('today',$today);
		//echo $today;
		//exit;
		//header('Content-Type: text/plain'); 

		//Configure::write ('debug', 0); 

   }
}

?>