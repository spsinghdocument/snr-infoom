<?php
App::uses('AppModel', 'Model');
/**
 * GroupGallery Model
 *
 * @property Group $Group
 * @property User $User
 */
class GroupGallery extends AppModel {

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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
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
		'GroupAlbum' => array(
			'className' => 'GroupAlbum',
			'foreignKey' => 'album_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
