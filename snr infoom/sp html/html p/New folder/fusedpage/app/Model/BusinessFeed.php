<?php
App::uses('AppModel', 'Model');
/**
 * BusinessFeed Model
 *
 * @property Business $Business
 */
class BusinessFeed extends AppModel {

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
		'Business' => array(
			'className' => 'Business',
			'foreignKey' => 'business_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'GroupUser' => array(
			'className' => 'User',
			'foreignKey' => 'group_user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/* public $hasMany = array(
		'Recommended' => array(
			'className' => 'Recommended',
			'foreignKey' => 'feed_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	); */
}
