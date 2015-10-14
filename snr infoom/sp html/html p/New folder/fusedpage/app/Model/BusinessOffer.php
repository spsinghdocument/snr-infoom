<?php
App::uses('AppModel', 'Model');
/**
 * BusinessOffer Model
 *
 * @property Business $Business
 */
class BusinessOffer extends AppModel {

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
	public $belongsTo = array(
		'Business' => array(
			'className' => 'Business',
			'foreignKey' => 'business_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'OfferCategory',
			'foreignKey' => 'name',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
