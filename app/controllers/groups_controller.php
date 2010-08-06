<?php
class GroupsController extends AppController {

	public $name = 'Groups';
	public $uses=array(
		'Group',
		'Contact'
	);
	

	public function index() {
		
		$this->paginate=array(
			'Group'=>array(
				'contain'=>array(
					#'Contact',
					'ContactType',
					#'Implementation'
					),
				#'conditions'=>array('Group.parent_id'=>0)	//only the parent groups are shown
			));
		$this->set('groups', $this->paginate('Group'));
	}

	public function view($id = null) {
		
		if (!$id) {
		 	$this->flash(__('Invalid Group', true), array('action' => 'index'));
		}
		$this->set('group', $this->Group->read(null, $id));
	}

	public function add() {
		
		$this->_setGroupList();
		if (!empty($this->data)) {
			$this->Group->create();
			if ($this->Group->save($this->data)){
				$this->flash(__('Group saved.', true), array('action' => 'index'));
			} else {
			}
		}
		$this->set('contactTypes',$this->Group->ContactType->getList());		
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
			$this->set('contactTypes',$this->Group->ContactType->getList());		
		}
	}

	public function delete($id = null) {
		if (!$id) {
			//$this->flash(__('Invalid Group', true), array('action' => 'index'));
		}
		$this->Group->id = $id;
		if ($this->Group->delete()) {
            if(!$this->RequestHandler->isAjax()){
                $this->redirect(array('action' => 'index'));
            }else{
            	$this->set('status',true);
            }		
		}
		
	}
	
	
	
	public function join_group(){
		//TODO join in a  Group
		$this->layout = 'users';

		$this->set('status',true);
		#debug($this->Contact->getContact($this->data['Contact']['contact_id']));
		$contact = $this->Contact->getContact($this->data['Contact']['contact_id']);
		$contacts_group = $contact['Group'];
		$this->Contact->user_id = $this->Auth->user('id');
		$grp = $this->Group->findById($this->data['Contact']['group_id']);		
		$grp['Group']['ContactsGroup'] = array(
			'group_id' => $this->data['Contact']['group_id'],
			'contact_id'=>$this->data['Contact']['contact_id'] 	
		);

		$contacts_group[]=$grp['Group'];
		$contact['Group'] = $contacts_group;
		$this->Contact->log_message = "joined group:".$grp['Group']['name'];
		$this->Contact->save($contact);
		
		$groups = $this->Group->getList($contact);
		$this->set(compact('contact','groups','contact_id'));	
		
		$this->render('/elements/contact_groups')	;
		
	}
	
	

	public function leave_group(){
		$this->layout = 'users';
		
		$this->redirect_if_not_ajax_request();
		
		$contact_id = $this->params['named']['contact_id'];
		$group_id 	= $this->params['named']['group_id'];
		
		$this->Contact->id = $contact_id;
		
		$this->Contact->user_id = $this->Auth->user('id');
		$group = $this->Group->read(null,$group_id);
		$this->Contact->log_message = "left group: ".$group['Group']['name'];

		$this->Contact->leaveGroup($group_id,$contact_id);
		$this->set('status',true);
		
		
		$contact = $this->Contact->getContact($contact_id);		
		$groups = $this->Group->getList($contact);
		$this->set(compact('contact','groups','contact_id'));	
		
		$this->render('/elements/contact_groups')	;		
	}	
	
	#application use only
	private function _setGroupList(){
		$this->set('groups',$this->Group->find('list'));
	}

}
?>