<?php
class SchoicesController extends AppController {

	var $name = 'Schoices';

	function index() {
		$this->Schoice->recursive = 0;
		$this->set('schoices', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid schoice', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('schoice', $this->Schoice->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Schoice->create();
			if ($this->Schoice->save($this->data)) {
				$this->Session->setFlash(__('The schoice has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The schoice could not be saved. Please, try again.', true));
			}
		}
		$sizes = $this->Schoice->Size->find('list');
		$this->set(compact('sizes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid schoice', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Schoice->save($this->data)) {
				$this->Session->setFlash(__('The schoice has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The schoice could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Schoice->read(null, $id);
		}
		$sizes = $this->Schoice->Size->find('list');
		$this->set(compact('sizes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for schoice', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Schoice->delete($id)) {
			$this->Session->setFlash(__('Schoice deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Schoice was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
