<?php

App::import('Model','Plugin');
App::import('Model', 'TypeStringOption');

class TypeString extends Plugin {

	public $actsAs=array('Containable');

	public $useTable='type_string';
	
	public $belongsTo = array('Contact');

	public $_adresValidate=array(
        'notEmptyFields'=>array(
            'rule'=>'notEmpty',
            'message'=>'field can not be blank'
        )
    );

    public function search($keys=array())
    {
		#$field = $this->getDisplayFieldName();

		return $this->find("all",array(
			'conditions' => array(
				'TypeString.field_id'=>$keys['fields'],
				'Contact.trash_id=0'
			),
			'contain' => array('Contact'), 
			'fields' => array("DISTINCT contact_id, GROUP_CONCAT( TypeString.data SEPARATOR ' ') as data"),
			'group' => "TypeString.contact_id having data REGEXP '^{$keys['term']}'"
		));
    }





}
?>
