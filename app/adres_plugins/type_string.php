<?php

App::import('Model','Plugin');
App::import('Model', 'TypeStringOption');

class TypeString extends Plugin {



	public $useTable='type_string';
	
	public $belongsTo = array('Contact');

	public $_adresValidate=array(
        'notEmptyFields'=>array(
            'rule'=>'notEmpty',
            'message'=>'field can not be blank'
        )
    );


}
?>
