<?php
App::uses('ShopAppController', 'Shop.Controller');
/**
 * Stuffs Controller
 *
 */
class StuffsController extends ShopAppController {
    
    public $uses = array('Shop.Stuff');
    
    public $paginateConditions = array(
        'code' => array(
            'type' => 'LIKE',
            'field' => 'Stuff.code',
        ),
        'name' => array(
            'type' => 'LIKE',
            'field' => 'Stuff.name',
        ),
        'category' => array(
            'field' => 'Stuff.category_id',
        ),
    );
    
    public $helpers = array('UploadPack.Upload');
    
    public $publicActions = array('view');
    
    protected function _getParentTitle(){
        return 'مدیریت کالا ها';
    }
/**
 * admin_index method
 *
 * @return void
 */
    public function admin_index() {
        $this->pageTitle = $this->_getParentTitle();
        $stuffs = $this->paginate();
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $categories = $this->Stuff->Category->generateTreeList();
        $this->set(compact('stuffs', 'categories'));
        $this->set('title', $this->pageTitle);
    }

/**
 * admin_add method
 *
 * @return void
 */
 //TODO: This function must save gallery images for stuff
    public function admin_add() {
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'افزودن کالا';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $this->Stuff->create();
            if ($this->Stuff->save($this->request->data)) {
                if(!empty($this->request->data['gallery'])){
                    foreach($this->request->data['gallery'] as $gallery){
                        $g = array(
                            'stuff_id' => $this->Stuff->id,
                            'desc' => '',
                            'image' => $gallery,
                            'published' => true,
                        );
                        $this->Stuff->Gallery->create();
                        $this->Stuff->Gallery->save($g);
                    }
                }
                $this->Session->setFlash('کالا با موفقیت ایجاد شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
        $categories = $this->Stuff->Category->generateTreeList();
        $this->set('categories', $categories);
        $this->set('taxes', $this->_loadController('Shop.Taxes')->_getList());
        $this->set('deports', $this->_loadController('Shop.Deports')->_getList());
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        $this->set('types', $this->Stuff->namedType);
        $this->set('orders', $this->Stuff->namedOrder);
    }

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
  //TODO: This function must save gallery images for stuff
    public function admin_edit($id = null) {
        
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'ویرایش  کالا';
        $this->helpers[] = 'Validator';
        $this->Stuff->id = $id;
        if (!$this->Stuff->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Stuff->save($this->request->data)) {
                if(!empty($this->request->data['gallery'])){
                    foreach($this->request->data['gallery'] as $gallery){
                        $g = array(
                            'stuff_id' => $this->Stuff->id,
                            'desc' => '',
                            'image' => $gallery,
                            'published' => true,
                        );
                        $this->Stuff->Gallery->create();
                        $this->Stuff->Gallery->save($g);
                    }
                }
                $this->Session->setFlash('کالا با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->Stuff->read();
        }
        $categories = $this->Stuff->Category->generateTreeList();
        $this->set('categories', $categories);
        $this->set('taxes', $this->_loadController('Shop.Taxes')->_getList());
        $this->set('deports', $this->_loadController('Shop.Deports')->_getList());
        $this->set('title', $this->pageTitle);
        $this->set('parentTitle', $this->_getParentTitle());
        $this->set('types', $this->Stuff->namedType);
        $this->set('orders', $this->Stuff->namedOrder);
        $this->render('admin_add');
    }

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
 //TODO: This function is not complete, must check the stuff is not used in factors, or gallery image of it must be deleted
    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->Stuff->id = $id;

            if ($this->Stuff->delete()) {
                $this->Session->setFlash('کالا با موفقیت حذف شد', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Stuff->id = $i;
                if ($this->Stuff->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' کالا منو حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('Stuff', 'published', 1, 'کالا با موفقیت منتشر شد.');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('Stuff', 'published', 0, 'کالا با موفقیت از حالت انتشار خارج شد.');
        $this->redirect($this->referer());
    }
	
	public function admin_removeGallery(){
		$this->autoRender = false;
		if(! $this->request->is('post')){
			return SettingsController::read('Error.Code-12');
		}
		$this->Stuff->Gallery->id = $this->request->data('id');
		if(! $this->Stuff->Gallery->delete()){
			return 'اشکال در حذف تصویر';
		}
		return true;
	}
    
    public function _getInfo($code){
        $stuffs = $this->Stuff->find('all', array('conditions' => array('code' => $code), 'contain' => false));
        return Set::combine($stuffs, '{n}.Stuff.code', '{n}.Stuff');
    }
    
    public function view($id = null){
        $this->Stuff->id = $id;
        if (!$this->Stuff->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        $stuff = $this->Stuff->read();
        $this->pageTitle = 'مشاهده ' . $stuff['Stuff']['name'];
        
        $categoryParents = array($stuff);
        
        $this->Stuff->Category->id = $stuff['Category']['id'];  
        if($stuff['Category']['level'] > 0){
            $categoryParents = $this->Stuff->Category->getPath();
        }
        $this->helpers[] = 'AdminForm';
        $this->set(compact('stuff', 'categoryParents'));
    }
    
    
}
