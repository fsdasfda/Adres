<?php  
App::import('Model','Plugin');

class TypeEmail extends Plugin{
    public $useTable = 'type_email';     

    public $validate = array(
        'data'=>'email'
    );

}
?>
