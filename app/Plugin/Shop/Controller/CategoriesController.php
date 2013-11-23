<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Categories Controller
 *
 */
class CategoriesController extends ShopAppController {
    
    public $uses = array('Shop.Category');

    public $paginate = array(
        'order' => 'Category.lft ASC',
    );
    
    public $paginateConditions = array(
        'name' => array(
            'type' => 'LIKE',
            'field' => 'Category.name',
        ),
    );
    
    public $helpers = array('UploadPack.Upload');
    
    public $publicActions = array('getList', 'view');
    
    protected function _getParentTitle(){
        return 'مدیریت مجموعه ها';
    }
/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->pageTitle = $this->_getParentTitle();
        $categories = $this->paginate();
        
        // Check the item can move to up or down
        $this->_recognizeMoving($categories, 'Category');
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $this->set(compact('categories'));
        $this->set('title', $this->pageTitle);
    }

/**
 * admin_add method
 *
 * @return void
 */
    public function admin_add() {
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'افزودن مجموعه';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                
                // Save Level for this item
                $path = $this->Category->getPath();
                // levels starts with 0
                $this->Category->saveField('level', count($path) - 1);
                
                $this->Session->setFlash('مجموعه با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
        $parents = $this->Category->generateTreeList();
        $this->set('parents', $parents);
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
    public function admin_edit($id = null) {
        
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'ویرایش  مجموعه';
        $this->helpers[] = 'Validator';
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                
                // Save Level for this item
                $path = $this->Category->getPath();
                // levels starts with 0
                $this->Category->saveField('level', count($path) - 1);
                // Update level of childrens
                $this->Category->updateChildrenLevel();
                
                $this->Session->setFlash('مجموعه با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->Category->read();
        }
        $parents = $this->Category->generateTreeList();
        $this->set('parents', $parents);
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        $this->render('admin_add');
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
            $this->Category->id = $id;

            if ($this->Category->delete()) {
                $this->Session->setFlash('مجموعه با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Category->id = $i;
                if ($this->Category->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' مجموعه منو حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }
    
    public function admin_move() {
        $this->_move('Category', 'مجموعه با موفقیت ویرایش شد.');
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('Category', 'published', 1, 'مجموعه با موفقیت منتشر شد.');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('Category', 'published', 0, 'مجموعه با موفقیت از حالت انتشار خارج شد.');
        $this->redirect($this->referer());
    }
    
    public function getList(){
        $categories = $this->Category->find('threaded', array('conditions' => array('published' => true), 'order' => 'Category.lft ASC'));
        return $this->_getStuffCount($categories);
    }
    
    public function _getStuffCount($categories){
        $this->loadModel('Shop.Stuff');
        if(empty($categories)){
            return $categories;
        }
        if ($categories) {
            foreach ($categories as &$category) {
                if (!empty($category['children'])) {
                    $child = $this->_getStuffCount($category['children']);
                    $category['children'] = $child;
                }
                $stuffCount = $this->Stuff->find('count', array('conditions' => array('category_id' => $category['Category']['id'] ) ));
                $category['Category']['name'] .= ' (' . $stuffCount . ')';
            }
        }
        return $categories;
    }
    
    public function view($id = null){
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        $category = $this->Category->read();
        
        $this->pageTitle = 'مشاهده مجموعه ' .$category['Category']['name'];
        
        $categoryParents = array($category);
        if($category['Category']['level'] > 0){
            $categoryParents = $this->Category->getPath();
        }
        $categoryChildren = $this->_getStuffCount($this->Category->children(null, true));
        $this->loadModel('Shop.Stuff');
        $this->paginate['Stuff']['conditions'] = array('published' => true, 'category_id' => $id);
        $this->paginate['Stuff']['contain'] = false;
        $stuffs = $this->paginate('Stuff');
        $this->set(compact('stuffs', 'category', 'categoryParents', 'categoryChildren'));
    }
}
