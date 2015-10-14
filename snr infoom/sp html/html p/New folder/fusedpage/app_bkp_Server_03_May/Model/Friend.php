<?php
App::uses('AppModel', 'Model');
/**
 * BusinessDeal Model
 *
 * @property Business $Business
 */
class Friend extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */

public $belongsTo = array(
		'Sent' => array(
			'className' => 'User',
			'foreignKey' => 'request_sent',
			'dependent' => true
		),
		'Received' => array(
			'className' => 'User',
			'foreignKey' => 'request_received',
			'dependent' => true
		)
	);
	
}
