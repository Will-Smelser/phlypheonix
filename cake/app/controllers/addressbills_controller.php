<?php
class AddressbillsController extends AppController {

	var $name = 'Addressbills';

	function index() {
		$this->Addressbill->recursive = 0;
		$this->set('addressbills', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid addressbill', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('addressbill', $this->Addressbill->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Addressbill->create();
			if ($this->Addressbill->save($this->data)) {
				$this->Session->setFlash(__('The addressbill has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The addressbill could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid addressbill', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Addressbill->save($this->data)) {
				$this->Session->setFlash(__('The addressbill has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The addressbill could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Addressbill->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for addressbill', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Addressbill->delete($id)) {
			$this->Session->setFlash(__('Addressbill deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Addressbill was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
