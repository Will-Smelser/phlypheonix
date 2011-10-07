<?php
class CouponsController extends AppController {

	var $name = 'Coupons';
	var $uses = array('Coupon','User');

	function index() {
		$this->Coupon->recursive = 0;
		$this->set('coupons', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid coupon', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('coupon', $this->Coupon->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Coupon->create();
			$this->data['Coupon']['expires'] = strtotime($this->data['Coupon']['expires']);
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The coupon has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The coupon could not be saved. Please, try again.', true));
			}
		}
		$this->set('users',$this->User->find('list'));
		$this->set('refers',$this->User->find('list'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid coupon', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Coupon->save($this->data)) {
				$this->Session->setFlash(__('The coupon has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The coupon could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Coupon->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for coupon', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Coupon->delete($id)) {
			$this->Session->setFlash(__('Coupon deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Coupon was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
