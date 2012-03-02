<?php
class ContactsController extends AppController {

	public $layout = 'default';

	public $name = 'Contacts';

	public $uses = array('Contact');

	public function index() {
		$this->paginate=array(
			'Contact'=>array(
				'contain'=>array(
					'ContactType',
					'Group'
					#'Field'
			)));

		$this->set('contacts', $this->paginate('Contact'));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Contact', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contact', $this->Contact->read(null, $id));
	}

	public function add() {
		if (!empty($this->data)) {
			$this->Contact->create();
			if ($this->Contact->save($this->data)) {
				$this->Session->setFlash(__('The Contact has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Contact could not be saved. Please, try again.', true));
			}
		}
	}

	public function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Contact', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Contact->save($this->data)) {
				$this->Session->setFlash(__('The Contact has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Contact could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Contact->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Contact', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Contact->del($id)) {
			$this->Session->setFlash(__('Contact deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The Contact could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	public function trash(){
        $this->layout = "administrator";

        $this->paginate= $this->Contact->findTrashed();
        $this->set('trashed',$this->paginate('Contact'));
    }


    public function restore($id=null)
	{
		$this->set('status',true);
		$contact = $this->Contact->read(null,$id);
        if(!empty($contact) && $this->data){

            $log=array(
                'user_id'=>$this->Auth->User('id'),
                'contact_id'=>$id,
                'description'=>$this->data['Contact']['message']
            );
			$contact['Contact']['trash_id']=0;
			$this->Contact->counter_cache($contact['Contact']['contact_type_id'],1);
			#adds a record to counter cache for restoring a contact
            if($this->Contact->save($contact)){
                $this->Contact->Log->save($log);
            }
            $this->redirect(array('action'=>'trash'));
		}
    }


    public function get($contact_type_id){
        $this->layout = 'api';
        $fields = $this->Contact->ContactType->Field->getPluginTypes($contact_type_id);
        $plugin_classes = array_values(array_unique(Set::extract('/Field/field_type_class_name',$fields)));
        $data = $this->TypeString->find('first');

        $this->set('data',$data);
        $this->render('/elements/json_data');
    }
}
