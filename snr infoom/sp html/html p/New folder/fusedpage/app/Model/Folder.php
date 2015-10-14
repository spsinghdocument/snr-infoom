<?php
App::uses('AppModel', 'Model');
/**
 * Folder Model
 *
 * @property User $User
 * @property Mail $Mail
 */
class Folder extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	/* public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	); */

/**
 * hasMany associations
 *
 * @var array
 */
	/* public $hasMany = array(
		'Mail' => array(
			'className' => 'Mail',
			'foreignKey' => 'folder_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	); */

}
