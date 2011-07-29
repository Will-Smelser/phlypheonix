<?php
class GroupsController extends AppController {

	var $components = array('Aclsetup','Ccats');
	
	
	var $name = 'Groups';

	function beforeFilter() {
		//session_start();
	    parent::beforeFilter(); 
	}
	
	function index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid group', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('group', $this->Group->read(null, $id));
	}

	function add() {
		/* ACL Controller Selection */
		$acoTbl = $this->Acl->Aco->Children();
		$acoTbl = $this->Ccats->cakeTableToArray('Aco','id',$acoTbl);
        $acoTree = $this->Ccats->assocArray($this->Acl->Aco,'/',$acoTbl,'alias');
        $this->set('acoArray',$acoTree);
        
        //var_dump($this->Aclsetup->getAcoGroupChildren($this,'customer'));
        
		if (!empty($this->data)) {
			$this->Group->create();
			if ($this->Group->save($this->data)) {
				
				$this->Aclsetup->addGroupAlias($this);
				$this->Group->saveAcl($this->data);  //save permissions
				
				$this->Session->setFlash(__('The group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.', true));
			}
		}
		//$users = $this->Group->User->find('list');
		//$this->set(compact('users'));
	}

	function edit($id = null) {
		/* ACL Controller Selection */
		$group = $this->Group->read(null, $id); //read current group information
		$curAcoGroupPerms = $this->Aclsetup->getAcoGroupChildren($this,$group['Group']['name']); //get current groups permissions
		$this->set('acoPerms',$curAcoGroupPerms); //make current permissions available for form
		
		$acoTbl = $this->Acl->Aco->Children();
		$acoTbl = $this->Ccats->cakeTableToArray('Aco','id',$acoTbl);
        $acoTree = $this->Ccats->assocArray($this->Acl->Aco,'/',$acoTbl,'alias');
        $this->set('acoArray',$acoTree);
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid group', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			//before the save clear current permissions
			$this->Group->clearAcl($group['Group']['name'], $curAcoGroupPerms);
			if ($this->Group->save($this->data)) {
				$this->Aclsetup->addGroupAlias($this);
				$this->Group->saveAcl($this->data); //save permissions
				$this->Session->setFlash(__('The group has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The group could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Group->read(null, $id);
		}
		$users = $this->Group->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for group', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Group->delete($id)) {
			$this->Session->setFlash(__('Group deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Group was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
	
/**
 * Rebuild the Acl based on the current controllers in the application
 * 
 * run in this order to initialize:
 *   1) buildAcl
 *   2) addGroupAlias
 *
 * @return void
 */
	//setup the initial state for acos table
    function buildAcl() {
    	$this->Aclsetup->buildAcl($this);
    }
 	
    //setup the initial state for aro table
	function addGroupAlias(){
		$this->Aclsetup->addGroupAlias($this);
	}
    
}
?>