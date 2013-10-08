<?php

App::uses('AppController', 'Controller');

/**
 * GalleryItems Controller
 *
 * @property GalleryItem $GalleryItem
 */
class GalleryItemsController extends AppController {
    
    public $publicActions = array('getItems', 'view');

    public $paginate = array('order' => 'GalleryItem.lft ASC');
    public $helpers = array('UploadPack.Upload');
    public $paginateConditions = array(
        'title' => array(
            'type' => 'LIKE',
            'field' => 'GalleryItem.title',
        ),
        'published' => array('field' => 'GalleryItem.published'),
        'category_id' => array('field' => 'GalleryCategory.id'),
    );

    public function admin_index() {
        $this->pageTitle = 'لیست تصاویر گالری';
        $galleryItems = $this->paginate('GalleryItem');
        if (empty($galleryItems)) {
            $this->Session->setFlash('متاسفیم! آیتمی برای نمایش وجود ندارد. برای شروع می توانید از دکمه افزودن استفاده نمایید', 'message', array('type' => 'block'));
        }
        // Check the item can move to up or down
        $this->_recognizeMoving($galleryItems, 'GalleryItem');

        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $galleryCategories = $this->GalleryItem->GalleryCategory->find('list');
        $this->set(compact('galleryItems', 'galleryCategories'));
    }

    public function admin_add() {
        $this->pageTitle = 'افزودن تصویر به گالری';
        $this->set('galleryCategories', $this->GalleryItem->GalleryCategory->find('list'));
        if ($this->request->is('post')) {
            $this->request->data['GalleryItem']['user_id'] = $this->Auth->user('id');
            $folder_path = $this->GalleryItem->GalleryCategory->findById($this->request->data['GalleryItem']['gallery_category_id'], array('folder_name'));
            $this->request->data['GalleryItem']['folder_name'] = $folder_path['GalleryCategory']['folder_name'];

            if ($this->GalleryItem->save($this->request->data)) {
                $this->Session->setFlash('تصویر با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
    }

    public function admin_edit($id = NULL) {
        $this->pageTitle = 'ویرایش اطلاعات تصویر';
        $this->GalleryItem->id = $id;
        $this->set('galleryCategories', $this->GalleryItem->GalleryCategory->find('list'));
        $requestData = $this->GalleryItem->read();
        if (!$this->GalleryItem->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->GalleryItem->save($this->request->data)) {

                $this->Session->setFlash('تصویر با موفقیت ویرایش شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $requestData;
        }
    }

    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->GalleryItem->id = $id;

            if ($this->GalleryItem->delete()) {
                @rmdir(WWW_ROOT . 'img' . DS . 'imageGallery' . DS . $id);
                $this->Session->setFlash('تصویر حذف گردید', 'message', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->GalleryItem->id = $i;
                if ($this->GalleryItem->delete()) {
                    @rmdir(WWW_ROOT . 'img' . DS . 'imageGallery' . DS . $i);
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' ' . 'تصویر حذف گردید', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('GalleryItem', 'published', 0, 'تصویر با موفقیت  از حالت انتشار خارج شد');
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('GalleryItem', 'published', 1, 'تصویر با موفقیت منتشر شد');
        $this->redirect($this->referer());
    }

    public function view($catId, $id) {
        $this->GalleryItem->GalleryCategory->id = $catId;
        if (!$this->GalleryItem->GalleryCategory->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        $image = $this->GalleryItem->find('first', array(
            'conditions' => array(
                'GalleryItem.id' => $id,
                'GalleryItem.published' => true,
            )
                ));
        $neighbors = $this->GalleryItem->find('neighbors', array(
            'field' => 'lft',
            'value' => $image['GalleryItem']['lft'],
            'conditions' => array('GalleryItem.gallery_category_id' => $catId,'GalleryItem.published' => true),
            'order' => 'GalleryItem.lft ASC',
            'contain' => false,
            )
        );
        $this->set('cat_id', $catId);
        if(!empty($neighbors['next']['GalleryItem']['id'])){
            $this->set('next_id', $neighbors['next']['GalleryItem']['id']);
        }
        if(!empty($neighbors['prev']['GalleryItem']['id'])){
            $this->set('prev_id', $neighbors['prev']['GalleryItem']['id']);
        }
        
        $this->set('image', $image);
    }

    public function getItems($id = NULL) {
        $images = $this->GalleryItem->find('all', array(
            'conditions' => array(
                'GalleryItem.gallery_category_id' => $id,
                'GalleryItem.published' => true,
            ),
            'order' => 'GalleryItem.lft ASC'
                ));
        $this->set('images', $images);
    }

    public function admin_move() {
        $this->_move('GalleryItem', 'تصویر با موفقیت ویرایش شد');
        $this->redirect($this->referer());
    }

    public function admin_getLinkItem() {

        $conditions = array('GalleryItem.published' => true);
        if (!empty($this->request->query['q'])) {
            $conditions['GalleryItem.title LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['limit'] = 1;
        $this->paginate['recursive'] = -1;
        $this->set('galleryItems', $this->paginate());
    }

}
