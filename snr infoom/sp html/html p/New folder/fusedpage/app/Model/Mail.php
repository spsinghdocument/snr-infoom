<?php
App::uses('AppModel', 'Model');
/**
 * Mail Model
 *
 */
class Mail extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $belongsTo = array(
		'Sender' => array(
			'className' => 'User',
			'foreignKey' => 'sender_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Receiver' => array(
			'className' => 'User',
			'foreignKey' => 'receiver_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}
