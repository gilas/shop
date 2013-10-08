<?php

App::uses('AppController', 'Controller');

/**
 * WeblinkCategories Controller
 *
 * @property WeblinkCategory $WeblinkCategory
 */
class WeblinkCategoriesController extends AppController {

    public $publicActions = array('view');

    public function admin_index() {
        $this->pageTitle = 'مدیریت مجموعه های وب لینک';
        $weblinkCategories = $this->paginate();
        for ($i = 0; $i < count($weblinkCategories); $i++) {
            $weblinkCategories[$i]['WeblinkCategory']['linkCount'] = $this->_haveLink($weblinkCategories[$i]['WeblinkCategory']['id']);
        }
        $this->helpers[] = 'AdminForm';
        $this->set(compact('weblinkCategories'));
    }

    public function admin_add() {
        $this->pageTitle = 'افزودن مجموعه وب لینک';
        if ($this->request->is('post')) {
            if ($this->WeblinkCategory->save($this->request->data)) {
                $this->Session->setFlash('مجموعه با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->pageTitle = 'ویرایش مجموعه وب لینک';
        $this->WeblinkCategory->id = $id;
        if (!$this->WeblinkCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->WeblinkCategory->save($this->request->data)) {
                $this->Session->setFlash('مجموعه وب لینک با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->WeblinkCategory->read();
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
            $this->WeblinkCategory->id = $id;

            if ($this->_haveLink($id)) {
                $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            } elseif ($this->WeblinkCategory->delete()) {
                $this->Session->setFlash('مجموعه وب لینک با موفیت حذف شد.', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->WeblinkCategory->id = $i;
                if ($this->_haveLink($i)) {
                    continue;
                }
                if ($this->WeblinkCategory->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' مجموعه وب لینک با موفیت حذف شد.', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    private function _haveLink($id) {
        return $this->WeblinkCategory->Weblink->find('count', array(
                    'conditions' => array(
                        'weblink_category_id' => $id
                    )
                        )
        );
    }

    public function admin_getLinkItem() {

        $conditions = array();
        if (!empty($this->request->query['q'])) {
            $conditions['WeblinkCategory.name LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['limit'] = 10;
        $this->paginate['recursive'] = -1;
        $this->set('weblinkCategories', $this->paginate());
    }

    public function view($catId = NULL) {
        $this->pageTitle = 'مشاهده لینک ها';
        $weblinks = $this->WeblinkCategory->Weblink->find('all', array(
            'conditions' => array(
                'Weblink.weblink_category_id' => $catId,
                'Weblink.published' => 1
            )
                )
        );
        $this->set('weblinks', $weblinks);
    }

}
