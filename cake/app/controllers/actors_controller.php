<?php
class ActorsController extends AppController {

	var $name = 'Actors';

	function index() {
		$this->Actor->recursive = 0;
		$this->set('actors', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid actor', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('actor', $this->Actor->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Actor->create();
			if ($this->Actor->save($this->data)) {
				$this->Session->setFlash(__('The actor has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The actor could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid actor', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Actor->save($this->data)) {
				$this->Session->setFlash(__('The actor has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The actor could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Actor->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for actor', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Actor->delete($id)) {
			$this->Session->setFlash(__('Actor deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Actor was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
