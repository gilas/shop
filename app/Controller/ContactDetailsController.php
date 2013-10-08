<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * ContactDetails Controller
 *
 * @property ContactDetail $ContactDetail
 */
class ContactDetailsController extends AppController {
    
    public $publicActions = array('view');
    
    public function admin_add() {
        $this->pageTitle = 'افزودن اطلاعات تماس';
        if ($this->request->is('post')) {
            if ($this->ContactDetail->save($this->request->data)) {
                $this->Session->setFlash('اطلاعات تماس با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->pageTitle = 'ویرایش اطلاعات تماس';
        $this->ContactDetail->id = $id;
        if (!$this->ContactDetail->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ContactDetail->save($this->request->data)) {
                $this->Session->setFlash('اطلاعات تماس با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->ContactDetail->read();
        }
    }

    public function admin_delete($id = NULL) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->ContactDetail->id = $id;

            if ($this->ContactDetail->delete()) {
                $this->Session->setFlash('اطلاعات تماس با موفیت حذف شد.', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->ContactDetail->id = $i;
                if ($this->ContactDetail->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' اطلاعات تماس با موفیت حذف شد.', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    public function admin_index() {
        $this->pageTitle = 'مدیریت اطلاعات تماس';
        $contactDetails = $this->paginate();
        $this->helpers[] = 'AdminForm';
        $this->set('contactDetails', $contactDetails);
    }

    public function admin_getLinkItem() {
        $conditions = array();
        if (!empty($this->request->query['q'])) {
            $conditions['ContactDetail.title LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['limit'] = 10;
        $this->paginate['recursive'] = -1;
        $this->set('contactDetails', $this->paginate());
    }
    
    public function view($id = NULL) {
        if ($this->request->is('post')) {
            $email = new CakeEmail('smtp');
            $email->from(array($this->request->data['ContactDetail']['email'] => $this->request->data['ContactDetail']['name']));
            $email->to('1razzaghi@gmail.com');
            $email->subject('Contact Form');
            $email->send($this->request->data['ContactDetail']['content']);
            $this->Session->setFlash('Your Message Have Been Sent.');
            $this->redirect($this->referer());
        } else {
            $this->ContactDetail->id = $id;
            if (!$this->ContactDetail->exists()) {
                throw new NotFoundException(SettingsController::read('Error.Code-14'));
            }
            $this->set('contactDetail', $this->ContactDetail->read());
        }
    }

}
