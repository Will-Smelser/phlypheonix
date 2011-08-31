<?php
class PimagesController extends AppController {

	var $name = 'Pimages';

	function index() {
		$this->Pimage->recursive = 0;
		$this->set('pimages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid pimage', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pimage', $this->Pimage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pimage->create();
			if ($this->Pimage->save($this->data)) {
				$this->Session->setFlash(__('The pimage has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pimage could not be saved. Please, try again.', true));
			}
		}
		$products = $this->Pimage->Product->find('list');
		$actors = $this->Pimage->Actor->find('list');
		$colors = $this->Pimage->Color->find('list');
		$sizes = $this->Pimage->Size->find('list');
		$this->set(compact('products', 'actors','sizes','colors'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pimage', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pimage->save($this->data)) {
				$this->Session->setFlash(__('The pimage has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pimage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pimage->read(null, $id);
		}
		$products = $this->Pimage->Product->find('list');
		$actors = $this->Pimage->Actor->find('list');
		$colors = $this->Pimage->Color->find('list');
		$sizes = $this->Pimage->Size->find('list');
		$this->set(compact('products', 'actors','sizes','colors'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for pimage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pimage->delete($id)) {
			$this->Session->setFlash(__('Pimage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pimage was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
