<?php
class PdetailsController extends AppController {

	var $name = 'Pdetails';

	function index() {
		$this->Pdetail->recursive = 0;
		$this->set('pdetails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid pdetail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pdetail', $this->Pdetail->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pdetail->create();
			if ($this->Pdetail->save($this->data)) {
				$this->Session->setFlash(__('The pdetail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pdetail could not be saved. Please, try again.', true));
			}
		}
		$products = $this->Pdetail->Product->find('list');
		$sizes = $this->Pdetail->Size->find('list');
		$colors = $this->Pdetail->Color->find('list');
		$this->set(compact('products', 'sizes', 'colors'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pdetail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pdetail->save($this->data)) {
				$this->Session->setFlash(__('The pdetail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pdetail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pdetail->read(null, $id);
		}
		$products = $this->Pdetail->Product->find('list');
		$sizes = $this->Pdetail->Size->find('list');
		$colors = $this->Pdetail->Color->find('list');
		$this->set(compact('products', 'sizes', 'colors'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for pdetail', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pdetail->delete($id)) {
			$this->Session->setFlash(__('Pdetail deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pdetail was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
