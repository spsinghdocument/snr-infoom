<?php
App::uses('AppModel', 'Model');
/**
 * BusinessEdit Model
 *
 * @property Business $Business
 */
class BusinessEdit extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Business' => array(
			'className' => 'Business',
			'foreignKey' => 'business_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		/*'User' => array(
			'className' => 'User',
			'foreignKey' => 'edited_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		) */
	);
}

