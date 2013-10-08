<?php

App::uses('AppController', 'Controller');

/**
 * GalleryCategories Controller
 *
 * @property GalleryCategory $GalleryCategory
 */
class GalleryCategoriesController extends AppController {
    
    public $publicActions = array('index');

    public function admin_index() {
        $this->pageTitle = 'مدیریت مجموعه گالری';
        $galleryCategories = $this->paginate('GalleryCategory');
        for ($i = 0; $i < count($galleryCategories); $i++) {
            $galleryCategories[$i]['GalleryCategory']['imageCount'] = $this->_haveImage($galleryCategories[$i]['GalleryCategory']['id']);
        }
        
        $this->helpers[] = 'AdminForm';
        $this->set(compact('galleryCategories'));
    }

    public function admin_add() {
        $this->pageTitle = 'افزودن مجموعه گالری';
        $this->set('parents', $this->GalleryCategory->generateTreeList());
        if ($this->request->is('post')) {
            if ($this->GalleryCategory->save($this->request->data)) {
                mkdir(IMAGES . 'imageGallery' . DS . $this->request->data['GalleryCategory']['folder_name'], 0755);
                $this->Session->setFlash('مجموعه با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->Session->setFlash('پوشه تصاویر مجموعه با موفقیت ساخته شد.', 'message_1', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->pageTitle = 'ویرایش مجموعه گالری';
        $this->GalleryCategory->id = $id;

        if (!$this->GalleryCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }

        $requestData = $this->GalleryCategory->read();

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->GalleryCategory->save($this->request->data)) {
                rename(IMAGES . 'imageGallery' . DS . $requestData['GalleryCategory']['folder_name'], IMAGES . 'imageGallery' . DS . $this->request->data['GalleryCategory']['folder_name']);
                $this->Session->setFlash('مجموعه با موفقیت ویرایش شد', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $requestData;
        }
        $this->set('parents', $this->GalleryCategory->generateTreeList());
    }

    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        
        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->GalleryCategory->id = $id;

            if ($this->_haveImage($id)) {
                $this->Session->setFlash(SettingsController::read('Error.Code-15'), 'message', array('type' => 'error'));
            } elseif ($this->GalleryCategory->delete()) {
                $this->Session->setFlash('مجموعه گالری با موفقیت حذف شد.', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->GalleryCategory->id = $i;
                if ($this->_haveImage($i)) {
                    continue;
                }
                if ($this->GalleryCategory->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' مجموعه گالری با موفقیت حذف شد.', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('GalleryCategory', 'published', 1, 'مجموعه گالری با موفقیت منتشر شد.');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('GalleryCategory', 'published', 0, 'مجموعه گالری با موفقیت از حالت انتشار خارج شد.');
        $this->redirect($this->referer());
    }
    
    private function _haveImage($id) {
        return $this->GalleryCategory->GalleryItem->find('count', array('conditions' => array('gallery_category_id' => $id)));
    }
    
    public function admin_getLinkItem(){
        $conditions = array();
        if(!empty($this->request->query['q'])){
            $conditions['GalleryCategory.name LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['limit'] = 10;
        $this->paginate['recursive'] = -1;
        $this->set('galleryCategories',$this->paginate());
    }
    
    public function index(){
        $this->helpers[] = 'UploadPack.Upload';
        $categories = $this->GalleryCategory->find('all',array(
            'conditions' => array('published' => true), 
            'contain' => false,
            )
        );
        if($categories){
            foreach ($categories as &$category) {
                $item = $this->GalleryCategory->GalleryItem->find('first',array(
                    'conditions' => array(
                        'gallery_category_id' => $category['GalleryCategory']['id'],
                        'published' => true,
                    ),
                    'contain' => false,
                    )
                );
                if($item){
                    $category +=$item;
                }
                $count = $this->GalleryCategory->GalleryItem->find('count',array(
                    'conditions' => array(
                        'gallery_category_id' => $category['GalleryCategory']['id'],
                        'published' => true,
                    ),
                    'contain' => false,
                    )
                );
                $category['count'] = $count;
            }
        }
        $this->set('galleryCategories',$categories);
    }
}
