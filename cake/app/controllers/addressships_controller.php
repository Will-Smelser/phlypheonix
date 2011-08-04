<?php
class AddressshipsController extends AppController {

	var $name = 'Addressships';

	function index() {
		$this->Addressship->recursive = 0;
		$this->set('addressships', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid addressship', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('addressship', $this->Addressship->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Addressship->create();
			if ($this->Addressship->save($this->data)) {
				$this->Session->setFlash(__('The addressship has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The addressship could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid addressship', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Addressship->save($this->data)) {
				$this->Session->setFlash(__('The addressship has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The addressship could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Addressship->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for addressship', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Addressship->delete($id)) {
			$this->Session->setFlash(__('Addressship deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Addressship was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
