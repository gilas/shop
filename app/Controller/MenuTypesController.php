<?php

class MenuTypesController extends AppController {

    public function admin_index() {
        $this->pageTitle = 'مدیریت نوع منو';
        $menuTypes = $this->paginate();
        if ($menuTypes) {
            foreach ($menuTypes as &$menuType) {
                $menuType['MenuType']['childCount'] = $this->_childCount($menuType['MenuType']['id']);
            }
        }
        $this->helpers[] = 'AdminForm';
        $this->set('menuTypes', $menuTypes);
    }

    public function admin_add() {
        $this->pageTitle = 'افزودن نوع منو';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $this->MenuType->create();
            if ($this->MenuType->save($this->request->data)) {
                $this->Session->setFlash('نوع منو با موفقیت ایجاد گردید', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }
    
    public function admin_edit( $id = null) {
        $this->pageTitle = 'ویرایش نوع منو';
        $this->helpers[] = 'Validator';
        $this->MenuType->id = $id;
        if (!$this->MenuType->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->MenuType->save($this->request->data)) {
                $this->Session->setFlash('نوع منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->MenuType->read();
        }
    }

    public function admin_getTypes() {
        return $this->MenuType->find('list');
    }

    /**
     * admin_delete method
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        
        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->MenuType->id = $id;

            if ($this->_childCount($id)) {
                $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            } elseif ($this->MenuType->delete()) {
                $this->Session->setFlash('نوع منو با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->MenuType->id = $i;
                if ($this->_childCount($id)) {
                    continue;
                }
                if ($this->MenuType->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' نوع منو حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    public function _childCount($id) {
        return $this->MenuType->Menu->find('count', array(
                    'conditions' => array('menu_type_id' => $id),
                    'contain' => false,
                ));
    }

}