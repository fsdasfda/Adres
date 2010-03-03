<?php  
class Group extends AppModel {
	
	public $name='Group';
	
	public $useTable='groups';
	
	public $actsAs=array('Containable');
	
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group', 
			'foreignKey' => 'parent_id'
		),
		'ContactType'=>array(
			'className' => 'ContactType', 
			'foreignKey' => 'contact_type_id',
		),
		'Implementation'=>array(
			'className'=>'Implementation'
			)
	);
	
	public $hasMany = array(
		'SubGroup' => array(
			'className' => 'Group', 
			'foreignKey' => 'parent_id'
		));
	
	public $hasAndBelongsToMany = array(
		'Contact' => array(
			'className' => 'Contact', 
			'foreignKey' => 'group_id',
			'associationForeignKey' => 'contact_id',
			
	));
	
	
	
	public function getCurrent($implementation_id){
		return $this->find('all',array(
			'contain'=>false,
			'conditions'=>array(
				'Group.implementation_id'=>$implementation_id,
				'Group.parent_id'=>0
		)));
	}
	
}

?>