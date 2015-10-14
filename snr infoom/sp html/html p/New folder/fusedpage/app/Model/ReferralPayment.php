<?php
App::uses('AppModel', 'Model');
/**
 * ReferralPayment Model
 *
 */
class ReferralPayment extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	 public $belongsTo = array(
		'Inviter' => array(
			'className' => 'User',
			'foreignKey' => 'inviter_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Invitee' => array(
			'className' => 'User',
			'foreignKey' => 'invitee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Business' => array(
			'className' => 'Business',
			'foreignKey' => 'business_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
