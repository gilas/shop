<?php

class RolesController extends AppController{
    
    /**
     * Get all role id can current user can access
     * 
     * @param mixed $role_id : role_id of user
     * @return array od all role id can user access 
     */
    public function _getAccessableId($role_id = null){
        if(is_null($role_id)){
            $role_id = $this->Auth->user('role_id');
        }
        $all = $this->Role->getPath($role_id,'id');
        return Set::combine($all,'{n}.Role.id','{n}.Role.id'); 
    }
    
    public function _getPath($role_id = null){
        if(is_null($role_id)){
            if($this->Auth->user('role_id')){
                $role_id = $this->Auth->user('role_id');
            }else{
                $role_id = $this->getId('Public');
            }
            
        }
        
        $all = $this->Role->getPath($role_id,array('id','name'));
        return Set::combine($all,'{n}.Role.id','{n}.Role.name'); 
    }
    
    /**
     *  return true if user can access to it, else return false
     * 
     * @param mixed $role_id : role_id of user
     * @return boolean
     */
    public function _hasPermission($role_id){
        $all = $this->getAccessableId($role_id);
        $return = false;
        
        if(in_array($role_id,$all))
            $return = true;
        
        return $return;
    }
    
    /**
     * Get id for current role name
     * 
     * @param mixed $role_name : role name
     * @return int id of current role
     */
    public function _getId($role_name = null){
        if(is_null($role_name)){
            return null;
        }
        $role = $this->Role->find('first',array(
            'controllers' => array(
              'Role.name' => $role_name  
            ),
        ));
        return ($role['Role']['id']) ? $role['Role']['id'] : null ; 
    }
    
    public function admin_index(){
        $this->helpers[] = 'AdminForm';
        $roles = $this->paginate();
        if($roles){
            foreach($roles as &$role){
                $role['User']['count'] = $this->_countUser($role['Role']['id']);
            }
        }
        $this->set('roles',$roles);
    }
    
    public function admin_add(){
        $this->pageTitle = 'افزودن نقش';
        $this->helpers[] = 'Validator';
        if($this->request->is('post')){
            $this->request->data['Role']['name'] = Inflector::slug(Inflector::humanize($this->request->data['Role']['name']));
            if($this->Role->save($this->request->data)){
                $this->Role->Aro->save(array(
                    'model' => 'Role',
                    'foreign_key' => $this->Role->id,
                    'alias' => $this->request->data['Role']['name'],
                    'parent_id' => 1,
                ));
                $this->Session->setFlash('نقش جدید درج گردید','message',array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('اشکال در درج نقش جدید','message',array('type' => 'error'));
            }
        }
    }
    
    public function admin_edit($id = null){
        $this->pageTitle = 'ویرایش نقش';
        $this->helpers[] = 'Validator';
        $this->Role->id = $id;
        if (!$this->Role->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        
        if($this->request->is('post') || $this->request->is('put')){
            
            if($this->Role->save($this->request->data)){
                $this->Session->setFlash('نقش ویرایش گردید','alert',array('type' => 'success'));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->Session->setFlash('اشکال در ویرایش نقش','alert',array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->Role->read();
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
            if($this->_countUser($id)){
                $this->Session->setFlash('این نقش دارای عضو می باشد', 'alert', array('type' => 'error'));
                $this->redirect($this->referer());
            }
            $this->Role->id = $id;
            $aro = $this->Role->read();
            if ($this->Role->delete()) {
                $this->Role->Aro->id = $aro['Aro']['id'];
                $this->Role->Aro->delete();
                $this->Session->setFlash('نقش با موفقیت حذف شد.', 'alert', array('type' => 'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'alert', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                if($this->_countUser($id)){
                    continue;
                }
                $this->Role->id = $i;
                $aro = $this->Role->read();
                if ($this->Role->delete()) {
                    $this->Role->Aro->id = $aro['Aro']['id'];
                    $this->Role->Aro->delete();
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' نقش با موفقیت حذف شد.', 'alert', array('type' => 'success'));
        }else{
            $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'alert', array('type' => 'error'));
        }
        $this->redirect($this->referer());
    }
    
    protected function _countUser($role_id = null){
        if(!$role_id){ return false;}
        return $this->Role->User->find('count', array('conditions' => array('role_id' => $role_id)));
    }
}
