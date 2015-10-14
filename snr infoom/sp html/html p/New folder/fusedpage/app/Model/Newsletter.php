<?php
App::uses('AppModel', 'Model');
/**
 * Newsletter Model
 *
 */
class Newsletter extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	

	public $findMethods = array('fetchAllSubscribedEmails'=>true);

	function _findFetchAllSubscribedEmails($state, $query, $results = array()){
		if($state == 'before')
			return $query;

		if($state == 'after'){
			foreach($results as $list)
				$ret[$list['Newsletter']['email']] = $list['Newsletter']['email'];
			return $ret;
		}
	}

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'isUnique' => array(
				'rule' => array('isUnique', 'username'),
				'message' => 'Please Use Another Username!!'
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please Provide Valid Email!!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please Provide Email!!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	
}
