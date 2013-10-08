<?php

App::uses('AppController', 'Controller');

/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {

    public $paginateConditions = array(
        'title' => array(
            'type' => 'LIKE',
            'field' => 'Menu.title',
        ),
        'published' => array('field' => 'Menu.published'),
        'menu_type_id' => array('field' => 'Menu.menu_type_id'),
    );

    public $paginate = array(
        'order' => 'Menu.lft ASC',
        'contain' => array('MenuType', 'LinkType'),
    );

    public $publicActions = array('getMenu');

    public $helpers = array('Cache');

/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->pageTitle = 'مدیریت منو';
        $menus = $this->paginate();
        // Check the item can move to up or down
        $this->_recognizeMoving($menus, 'Menu');

        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';

        // use this for filter form
        $menuTypes = $this->Menu->MenuType->find('list');
        $this->set(compact('menus', 'menuTypes'));
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        $this->pageTitle = 'افزودن گزینه منو';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $linkType = $this->Menu->LinkType->read('path',$this->request->data['Menu']['link_type_id']);
            if ($linkType['LinkType']['check_path'] ) {
                if (strpos($this->request->data['Menu']['link'], 'http://') === false) {
                    $this->request->data['Menu']['link'] = 'http://' . $this->request->data['Menu']['link'];
                }
            }
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                // Save Level for this item
                $path = $this->Menu->getPath();
                // levels starts with 0
                $this->Menu->saveField('level', count($path) - 1);

                $this->Session->setFlash('گزینه منو با موفقیت ایجاد شد', 'message', array('type' => 'success'));

                // Clear Chache
                $this->_clearCache('menu');
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
        $linkTypes = $this->Menu->LinkType->find('all');
        $parents = $this->Menu->find('all', array('order' => 'lft ASC', 'contain' => false));
        $menuTypes = $this->Menu->MenuType->find('list');
        $this->set(compact('parents', 'controller', 'menuTypes', 'linkTypes'));
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        $this->pageTitle = 'ویرایش گزینه منو';
        $this->helpers[] = 'Validator';
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $linkType = $this->Menu->LinkType->read('path',$this->request->data['Menu']['link_type_id']);
            if ($linkType['LinkType']['check_path']) {
                if (strpos($this->request->data['Menu']['link'], 'http://') === false) {
                    $this->request->data['Menu']['link'] = 'http://' . $this->request->data['Menu']['link'];
                }
            }
            if ($this->Menu->save($this->request->data)) {
                // Save Level for this item
                $path = $this->Menu->getPath();
                // levels starts with 0
                $this->Menu->saveField('level', count($path) - 1);
                // Update level of childrens
                $this->Menu->updateChildrenLevel();
                $this->Session->setFlash('گزینه منو با موفقیت ویرایش شد', 'message', array('type' => 'success'));

                // Clear Chache
                $this->_clearCache('menu');
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
        }
        $linkTypes = $this->Menu->LinkType->find('all');
        $parents = $this->Menu->find('all', array('order' => 'lft ASC', 'contain' => false));
        $menuTypes = $this->Menu->MenuType->find('list');
        $this->set(compact('parents', 'controller', 'menuTypes', 'linkTypes'));
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->Menu->id = $id;

            if ($this->Menu->childCount($id)) {
                $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            } elseif ($this->Menu->delete()) {
                $this->Session->setFlash('گزینه منو با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Menu->id = $i;
                if ($this->Menu->childCount($i)) {
                    continue;
                }
                if ($this->Menu->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' گزینه منو حذف گردید', 'message', array('type' => 'success'));
        }

        // Clear Chache
        $this->_clearCache('menu');
        $this->redirect($this->referer());
    }

/**
 * Move item to up or down
 *
 * @param mixed $id : item id
 * @param string $type : up or down
 * @return void
 */
    public function admin_move() {
        $this->_move('Menu', 'گزینه منو با موفقیت ویرایش شد');

        // Clear Chache
        $this->_clearCache('menu');
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('Menu', 'published', 1, 'گزینه منو با موفقیت منتشر شد');

        // Clear Chache
        $this->_clearCache('menu');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('Menu', 'published', 0, 'گزینه منو با موفقیت از حالت انتشار خارج شد');

        // Clear Chache
        $this->_clearCache('menu');
        $this->redirect($this->referer());
    }

/**
 * Return item array for current $menuTypeID
 *
 * @param int $menuTypeID : ID in MenuType Model
 * @return array
 */
    public function getMenu($menuTypeID) {

    	$result = null;

    	if(!isset($this->request->named['cache']) or $this->request->named['cache'] == true){
    		// Read from cache
    		$result = Cache::read('menu_'.$menuTypeID);
    	}

        if(!$result){
            $result = $this->Menu->find('threaded', array(
                    'conditions' => array(
                        'menu_type_id' => $menuTypeID,
                        'published' => true,
                    ),
                    'order' => 'lft ASC',
                    'contain' => false,
                )
            );
            Cache::write('menu_'.$menuTypeID, $result);
        }
        return $result;
    }

}
