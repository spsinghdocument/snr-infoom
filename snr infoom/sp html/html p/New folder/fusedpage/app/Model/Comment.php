<?php
App::uses('AppModel', 'Model');
/**
 * BusinessDeal Model
 *
 * @property Business $Business
 */
class Comment extends AppModel {

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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'dependent' => true
		)
	);
	
}
