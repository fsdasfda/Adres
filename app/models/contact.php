<?php
class Contact extends AppModel {

	public $actsAs = array('Containable');
	
	public $name = 'Contact';

	public $belongsTo = array(
		'ContactType' => array(
			'className' => 'ContactType', 
			#'foreignKey' => 'contact_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'Group' => array(
			'className' => 'Group', 
			'foreignKey' => 'contact_id',
			'associationForeignKey' => 'group_id',
			
	));	
}
?>