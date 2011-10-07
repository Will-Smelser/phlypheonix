<?php
class PstylesController extends AppController {

	var $name = 'Pstyles';

	function index() {
		$this->Pstyle->recursive = 0;
		$this->set('pstyles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid pstyle', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pstyle', $this->Pstyle->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pstyle->create();
			if ($this->Pstyle->save($this->data)) {
				$this->Session->setFlash(__('The pstyle has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pstyle could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pstyle', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pstyle->save($this->data)) {
				$this->Session->setFlash(__('The pstyle has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pstyle could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pstyle->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for pstyle', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pstyle->delete($id)) {
			$this->Session->setFlash(__('Pstyle deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pstyle was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
