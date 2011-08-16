<?php
class CreditsController extends AppController {

	var $name = 'Credits';

	function index() {
		$this->Credit->recursive = 0;
		$this->set('credits', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('credit', $this->Credit->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Credit->create();
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Credit->User->find('list');
		$userPurchases = $this->Credit->UserPurchase->find('list');
		$sales = $this->Credit->Sale->find('list');
		$this->set(compact('users', 'userPurchases', 'sales'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid credit', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Credit->save($this->data)) {
				$this->Session->setFlash(__('The credit has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The credit could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Credit->read(null, $id);
		}
		$users = $this->Credit->User->find('list');
		$userPurchases = $this->Credit->UserPurchase->find('list');
		$sales = $this->Credit->Sale->find('list');
		$this->set(compact('users', 'userPurchases', 'sales'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for credit', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Credit->delete($id)) {
			$this->Session->setFlash(__('Credit deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Credit was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function test(){
		debug($this->Credit->reduceCreditsByAmount(1,1.5));
	}
}
