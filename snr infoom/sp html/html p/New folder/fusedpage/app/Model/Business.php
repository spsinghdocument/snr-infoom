<?php
App::uses('AppModel', 'Model');
/**
 * Business Model
 *
 * @property Categoty $Categoty
 * @property User $User
 */
class Business extends AppModel {

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
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => 'name',
			'order' => ''
		),
		'Sub-Category' => array(
			'className' => 'Category',
			'foreignKey' => 'subcategory_id',
			'conditions' => '',
			'fields' => 'name',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'BusinessBanner' => array(
			'className' => 'BusinessBanner',
			'foreignKey' => 'business_id',
			'dependent' => true
		),
		'BusinessFeedback' => array(
			'className' => 'BusinessFeedback',
			'foreignKey' => 'business_id',
			'dependent' => true
		),
	);
}
