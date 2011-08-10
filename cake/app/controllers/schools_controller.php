<?php
class SchoolsController extends AppController {

	var $name = 'Schools';

	function index() {
		$this->School->recursive = 0;
		$this->set('schools', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid school', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('school', $this->School->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->School->create();
			if ($this->School->save($this->data)) {
				$this->Session->setFlash(__('The school has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The school could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid school', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->School->save($this->data)) {
				$this->Session->setFlash(__('The school has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The school could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->School->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for school', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->School->delete($id)) {
			$this->Session->setFlash(__('School deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('School was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
