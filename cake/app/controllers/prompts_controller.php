<?php
class PromptsController extends AppController {

	var $name = 'Prompts';

	function index() {
		$this->Prompt->recursive = 0;
		$temp = $this->paginate();
		foreach($temp as $key=>$p){
			$temp[$key]['Prompt']['ends'] =	date('m/d/y',$p['Prompt']['ends']);
		}
		$this->set('prompts', $temp);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid prompt', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('prompt', $this->Prompt->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->data['Prompt']['ends'] = strtotime($this->data['Prompt']['ends']);
			$this->Prompt->create();
			if ($this->Prompt->save($this->data)) {
				$this->Session->setFlash(__('The prompt has been saved', true));
				$this->redirect(array('action' => 'index'));
				
				//check if this should be added to all users
				if(empty($this->data['User']['User'])) {
					$this->Prompt->addToAll($this->Prompt->id);
				}
				
			} else {
				$this->Session->setFlash(__('The prompt could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Prompt->User->find('list');
		$this->set(compact('users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid prompt', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->data['Prompt']['ends'] = strtotime($this->data['Prompt']['ends']);
			if ($this->Prompt->save($this->data)) {

				//check if this should be added to all users
				if(empty($this->data['User']['User'])) {
					$this->Prompt->addToAll($this->Prompt->id);
				}
				
				$this->Session->setFlash(__('The prompt has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The prompt could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Prompt->read(null, $id);
			$this->data['Prompt']['ends'] = date('m/d/y',$this->data['Prompt']['ends']);
		}
		$users = $this->Prompt->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for prompt', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Prompt->delete($id)) {
			$this->Session->setFlash(__('Prompt deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Prompt was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * Wrapper for deleteing the user's prompt entry
	 * @param unknown_type $id
	 */
	function deleteUserPrompt($id = null){
		$this->Prompt->removeUserPrompt($id);
	}
	
	/**
	 * Delete all prompts from users_prompts where `end` has expired
	 */
	function clean(){
		$this->Prompt->cleanUpPrompts();
		$this->Session->setFlash(__('Prompts cleaned ('.mysql_affected_rows().').', true));
		$this->redirect(array('action' => 'index'));
	}
}
