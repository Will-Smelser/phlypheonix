<?php
class PattributesController extends AppController {

	var $name = 'Pattributes';

	function index() {
		$this->Pattribute->recursive = 0;
		$this->set('pattributes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid pattribute', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pattribute', $this->Pattribute->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pattribute->create();
			if ($this->Pattribute->save($this->data)) {
				$this->Session->setFlash(__('The pattribute has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pattribute could not be saved. Please, try again.', true));
			}
		}
		$products = $this->Pattribute->Product->find('list');
		$this->set(compact('products'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pattribute', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pattribute->save($this->data)) {
				$this->Session->setFlash(__('The pattribute has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pattribute could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pattribute->read(null, $id);
		}
		$products = $this->Pattribute->Product->find('list');
		$this->set(compact('products'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for pattribute', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pattribute->delete($id)) {
			$this->Session->setFlash(__('Pattribute deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pattribute was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
