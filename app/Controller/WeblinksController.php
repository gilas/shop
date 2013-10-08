<?php

App::uses('AppController', 'Controller');

/**
 * Weblinks Controller
 *
 * @property Weblink $Weblink
 */
class WeblinksController extends AppController {
    
    public $publicActions = array('go');
    
    public $paginateConditions = array(
        'category_id' => array('field' => 'Weblink.weblink_category_id'),
    );
    public function admin_index() {
        $this->pageTitle = 'مدیریت وب لینک ها';
        $weblinks = $this->paginate();
        $this->helpers[] = 'AdminForm';
        $this->set('weblinks', $weblinks);
    }

    public function admin_add() {
        $this->pageTitle = 'افزودن وب لینک';
        $this->set('weblinkCategories', $this->Weblink->WeblinkCategory->find('list'));
        if ($this->request->is('post')) {
            $this->request->data['Weblink']['created'] = Jalali::dateTime();
            $this->request->data['Weblink']['address'] = $this->_haveHttpPrefix($this->request->data['Weblink']['address']);
            if ($this->Weblink->save($this->request->data)) {
                $this->Session->setFlash('وب لینک با موفقیت اضافه شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->pageTitle = 'ویرایش وب لینک';
        $this->Weblink->id = $id;
        if (!$this->Weblink->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Weblink->save($this->request->data)) {
                $this->Session->setFlash('وب لینک با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->set('weblinkCategories', $this->Weblink->WeblinkCategory->find('list'));
            $this->request->data = $this->Weblink->read();
        }
        $this->render('admin_add');
    }

    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->Weblink->id = $id;

            if ($this->Weblink->delete()) {
                $this->Session->setFlash('وب لینک با موفیت حذف شد.', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Weblink->id = $i;
                if ($this->Weblink->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' وب لینک با موفیت حذف شد.', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    private function _haveHttpPrefix($url = Null) {
        if (substr($url, 0, 7) != 'http://')
            $url = 'http://' . $url;
        return $url;
    }
    
    public function admin_publish() {
        $this->_changeStatus('Weblink', 'published', 1, 'وب لینک با موفقیت منتشر شد.');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('Weblink', 'published', 0, 'وب لینک با موفقیت از حالت انتشار خارج شد.');
        $this->redirect($this->referer());
    }
    
    public function go($id = null){
        $this->Weblink->id = $id;
		if (!$this->Weblink->exists()) {
			throw new NotFoundException(SettingsController::read('Error.Code-14'));
		}
        $link = $this->Weblink->read(null,$id);
        // update hit
        $this->Weblink->updateAll(array('Weblink.hits' => 'Weblink.hits + 1'),array('Weblink.id' => $id));
        $this->redirect($link['Weblink']['address']);
    }
}
