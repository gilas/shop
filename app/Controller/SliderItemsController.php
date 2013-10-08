<?php

App::uses('AppController', 'Controller');

/**
 * SliderItems Controller
 *
 * @property SliderItem $SliderItem
 */
class SliderItemsController extends AppController {
    
    public $publicActions = array('getSlides');
    
    public $paginateConditions = array(
        'title' => array(
            'type' => 'LIKE',
            'field' => 'SliderItem.title',
        ),
        'published' => array('field' => 'SliderItem.published'),
    );
    
    public $paginate = array(
        'order' => 'SliderItem.lft ASC',
    );
    
    public $helpers = array('UploadPack.Upload');
	      
    public function admin_index() {
        $this->pageTitle = 'مدیریت اسلایدر صفحه نخست';
        $sliderItems = $this->paginate();
        
        // Check the item can move to up or down
        $this->_recognizeMoving($sliderItems, 'SliderItem');
        
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        
        $this->set(compact('sliderItems'));
    }

    public function admin_add() {
        $this->pageTitle = 'افزودن تصویر به اسلایدر';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post')) {
            $linkType = $this->SliderItem->LinkType->read('path',$this->request->data['SliderItem']['link_type_id']);
            if (empty($linkType['LinkType']['path'])) {
                if (strpos($this->request->data['SliderItem']['link'], 'http://') === false) {
                    $this->request->data['SliderItem']['link'] = 'http://' . $this->request->data['SliderItem']['link'];
                }
            }
            if ($this->SliderItem->save($this->request->data)) {
                $this->Session->setFlash('اسلاید با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }
        $linkTypes = $this->SliderItem->LinkType->find('all');
        $slideTypes = $this->slideTypes;
        $this->set(compact('slideTypes','linkTypes'));
    }

    public function admin_edit($id = NULL) {
        $this->pageTitle = 'ویرایش تصویر اسلایدر';
        $this->helpers[] = 'Validator';
        if ($this->request->is('post') || $this->request->is('put')) {
            $linkType = $this->SliderItem->LinkType->read('path',$this->request->data['SliderItem']['link_type_id']);
            if (empty($linkType['LinkType']['path'])) {
                if (strpos($this->request->data['SliderItem']['link'], 'http://') === false) {
                    $this->request->data['SliderItem']['link'] = 'http://' . $this->request->data['SliderItem']['link'];
                }
            }
            
            $this->SliderItem->id = $id;
            if ($this->SliderItem->save($this->request->data)) {
                $this->Session->setFlash('اسلاید با موفقیت ذخیره شد.', 'message', array('type' => 'success'));
                $this->redirect(array('action' => 'index', 'admin' => TRUE));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        }else{
            $this->request->data = $this->SliderItem->read(null, $id);
        }
        $linkTypes = $this->SliderItem->LinkType->find('all');
        $slideTypes = $this->slideTypes;
        $this->set(compact('slideTypes','linkTypes'));
    }

    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        
        $id = $this->request->data['id'];// we recieve id via posted data

	    $count = count($id);
        if($count == 1){
            $id = current($id);
            $this->SliderItem->id = $id;
            
            if ($this->SliderItem->delete()) {
    			$this->Session->setFlash('اسلایدر با موفقیت حذف شد', 'message', array('type' => 'success'));
    		}else{
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        }elseif($count > 1){
            $countAffected = 0;
            foreach($id as $i){
                $this->SliderItem->id = $i;
                
        		if ($this->SliderItem->delete()) {
        			$countAffected ++ ;
        		}
            }
            $this->Session->setFlash($countAffected .' مورد حذف گردید', 'message', array('type' => 'success'));
        }
		$this->redirect($this->referer());
    }
    
    public function admin_move() {
        $this->_move('SliderItem', 'اسلاید با موفقیت ویرایش شد');
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('SliderItem', 'published', 1, 'اسلاید با موفقیت منتشر شد');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('SliderItem', 'published', 0, 'اسلاید با موفقیت از حالت انتشار خارج شد');
        $this->redirect($this->referer());
    }
	
	public function getSlides(){
		return $this->SliderItem->find('all',array(
			'conditions' => array('SliderItem.published' => true),
			'order' => 'SliderItem.lft ASC',
		));
	}
    
}
