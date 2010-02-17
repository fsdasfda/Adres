<?php
class GroupsController extends AppController {

	public $name = 'Groups';
	

	public function index() {
		
		$this->paginate=array(
			'Group'=>array(
				'contain'=>array('SubGroup'),
				#'conditions'=>array('Group.parent_id'=>0)	//only the parent groups are shown
			));
			
		$this->set('groups', $this->paginate('Group'));
	}

	public function view($id = null) {
		
		if (!$id) {
		 	$this->flash(__('Invalid Group', true), array('action' => 'index'));
		}
		$this->Group->contain('SubGroup');
		$this->set('group', $this->Group->read(null, $id));
	}

	public function add() {
		
		$this->_setGroupList();
				
		if (!empty($this->data)) {
			$this->Group->create();
			if ($this->Group->save($this->data)) {
				$this->flash(__('Group saved.', true), array('action' => 'index'));
			} else {
			}
		}
	}

	public function edit($id = null) {
		
		if (!$id && empty($this->data)) {
			$this->flash(__('Invalid Group', true), array('action' => 'index'));
		}
		
		$this->_setGroupList();
		
		if (!empty($this->data)) {
			if ($this->Group->save($this->data)) {
				$this->flash(__('The Group has been saved.', true), array('action' => 'index'));
			} else {
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Group->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$id) {
			$this->flash(__('Invalid Group', true), array('action' => 'index'));
		}
		if ($this->Group->del($id)) {
			$this->flash(__('Group deleted', true), array('action' => 'index'));
		}
		$this->flash(__('The Group could not be deleted. Please, try again.', true), array('action' => 'index'));
	}
	
	
	
	#application use only
	private function _setGroupList(){
		$this->set('groups',$this->Group->find('list'));
	}

}
?>