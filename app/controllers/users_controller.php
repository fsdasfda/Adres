<?php
class UsersController extends AppController {
    
    public $name ='Users';
    
    public $uses=array('Contact','ContactType','Field','FieldType','Group','Implementation');
    	
    public function beforeFilter(){   
		parent::beforeFilter();
    }

    public function index(){
    	
    	$this->set('users',$this->paginate());
    }

    public function register(){
        #$this->layout = null;
        if($this->data){                
            //TODO can improve the code here to use 
            if($this->data['User']['password']===$this->Auth->password($this->data['User']['confirm_password'])){
                #if($this->User->validate()){
                    $this->User->create();
                    $this->User->save($this->data);
                    $this->Session->setFlash(__("A email has been sent to your email address",true));
                #}
            }else{
                $this->Session->setFlash(__('Password mismatch',true));
            }
            $arrayName = array('tetst' => fadfasdfa, );
        }else{
            #$this->redirect('/login');
        }
    }



    public function login() {
    	if($this->Auth->user()){
    		$this->redirect(array('controller'=>'users','action'=>'home'));
    	}
	
    }

    public function logout() {
    	$this->Session->destroy();
        $this->redirect($this->Auth->logout());
        
    }
    

	public function delete($id=null){
		if (!$id) {
			$this->flash(__('Invalid User', true), array('action' => 'index'));
		}
		if ($this->User->del($id)) {
			$this->flash(__('Group deleted', true), array('action' => 'index'));
		}
		$this->flash(__('The Group could not be deleted. Please, try again.', true), array('action' => 'index'));
		
		
	}


    public function home(){
		if(!$this->isAuthenticated()){
			$this->flash('Something wrong','/');
		}
	
		if(!$this->Session->check('Implementation')){
    		$implementation = ClassRegistry::init('Implementation')->find(
    			'first',array(
    				'fields'=>array('id','name')
    			));
			$this->Session->write('Implementation',$implementation['Implementation']);
    	}
		
    	$contact_types = $this->ContactType->find('all',array(
    		'contain'=>array(
    			'CurrentGroup',
    			'Field',
    			'Contact'=>array('TypeString')
    		),
    		'conditions'=>array(
    			'ContactType.implementation_id'=>$this->Session->read('Implementation.id')
    		)
		));

        if(!$this->Session->check('Filter')){
            //TODO have to implement Session filters
        }
        
    	$this->set(compact('contact_types'));
    }
    	
	
	public function search(){
		
	}
	
	public function advance_search(){
		
	}
	

    public function add_record(){
        
    }


    public function delete_record() {

    }
    
    public function show_record($id=null){
    	if(!$id){
    		$this->redirect(array('controller'=>'users','action'=>'home'));
    	}
    	$contact = $this->Contact->read(null,$id);
    	$contactType = $contact['Contact']['contact_type_id'];
    	var_dump($this->ContactType->find('all',array(
    		'contain'=>array(
    			'Field'=>array('TypeString')),
    		'conditions'=>array(
    			'ContactType.id'=>$contactType)
    		)));
    }

}
?>