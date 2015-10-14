<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
App::import('Vendor','constants');
class AppController extends Controller {
	//public $components = array('DebugKit.Toolbar');
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Cookie', 'Email',
		'Auth'=>array(
			'authenticate'=>array(
				'User'=>array('userModel'=>'User'),
				'Admin'=>array('userModel'=>'Admin')
			)
		), 'Fp', 'SocialMedia');


	//BEFORE FILTER STARTS
	function beforeFilter(){
		if(isset($this->params['prefix']) && $this->params['prefix'] == 'admin'){
			$this->Auth->loginAction = array('controller'=>'admins', 'action'=>'sign_in');
			AuthComponent::$sessionKey = 'Auth.Admin';
			$this->layout = 'Admin/default';
		}else{
			$this->Auth->loginAction = array('controller'=>'users', 'action'=>'home');
			if($this->Session->check('Auth.User.User.id'))
				$this->layout = 'FrontEnd/Inner/default';
			else
				$this->layout = 'FrontEnd/default';
			AuthComponent::$sessionKey = 'Auth.User';
		}
	}
	//BEFORE FILTER ENDS

	//FUNCTION FOR VALIDATING THE PAGES FOR USER START
	public function validateUser($authType, $redirectUrl){
		if($this->Session->check('Auth.User.User.id'))
			$this->redirect($redirectUrl);
	}
	//FUNCTION FOR VALIDATING THE PAGES FOR USER END

}
