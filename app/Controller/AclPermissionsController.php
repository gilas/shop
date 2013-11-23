<?php
class AclPermissionsController extends AppController{
    public $uses = array('Aro','Aco','ArosAco');

    public function admin_index(){
        $this->helpers[] = 'AdminForm';
        $acos = $this->Aco->generateTreeList(array(array('parent_id !=' => null)),'{n}.Aco.id','{n}.Aco.alias');
        $this->Aro->bindModel(array(
            'belongsTo' => array(
                'Role' => array(
                        'className' => 'Role',
                        'foreignKey' => 'foreign_key',
                    )
                )
            )
        );
        $aros = $this->Aro->find('all',array('recursive' => 0 ,'conditions' => array('Aro.parent_id !=' => null )));
        $aros = Set::combine($aros,'{n}.Aro.id','{n}.Role.title');
        $permissions = array();
        foreach($acos as $aco_id => $aco_alias){
            foreach($aros as $aro_id => $aro_alias){
                $condition = array(
                    'aco_id' => $aco_id,
                    'aro_id' => $aro_id,
                    '_create' => 1,
                    '_update' => 1,
                    '_read' => 1,
                    '_delete' => 1,
                );
                $permissions[$aco_id][$aro_id] = 0;
                if($this->ArosAco->hasAny($condition)){
                    $permissions[$aco_id][$aro_id] = 1;
                }                
            }
        }
        $this->set(compact('acos','aros','permissions'));
    }
    
    public function admin_editPermission(){
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }
        $id = $this->request->data['id'];
        $aro_id = $this->request->data['aro'];
        $type = $this->request->data['type'];
        if(count($id) == 1){
            $aco_id = current($id);
            if($this->_grant($aco_id, $aro_id, $type)){
                $this->Session->setFlash('تغییرات انجام گردید.', 'message', array('type' => 'success'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'message', array('type' => 'error'));
            }
        }else{
            $countAccepted = 0;
            
            foreach ($id as $aco_id) {
                if($this->_grant($aco_id, $aro_id, $type)){
                    $countAccepted++ ;
                }
            }
            if($countAccepted){
                $this->Session->setFlash($countAccepted . 'تغییرات انجام گردید  .', 'message', array('type' => 'success'));
            }else{
                $this->Session->setFlash(SettingsController::read('Error.Code-17'), 'message', array('type' => 'error'));
            }
        }
        $this->redirect($this->referer());
    }
    
    public function admin_sync(){
        set_time_limit(300);
        $this->AclGenerate = $this->Components->load('AclGenerate');
        $this->AclGenerate->initialize($this);
        $this->AclGenerate->aco_sync();
        $this->Session->setFlash('جدول متدها بروزرسانی شد','alert',array('type' => 'success'));
        $this->redirect(array('action' => 'index'));
    }
    
    protected function _grant($aco_id, $aro_id, $type){
        $row = $this->ArosAco->find('first',array(
            'conditions' => array(
                'aco_id' => $aco_id,
                'aro_id' => $aro_id,
            ),
            'recursive' => -1,
        ));
        $permission = array(
            'aco_id' => $aco_id,
            'aro_id' => $aro_id,
            '_create' => 1,'_update' => 1,'_read' => 1,'_delete' => 1,);
            
        if($type != 'on'){
            $permission['_create'] = $permission['_update'] = $permission['_read'] = $permission['_delete'] = -1;
        }
        
        if($row){
            $this->ArosAco->id = $row['ArosAco']['id'];
        }else{
            $this->ArosAco->create();
        }
        return $this->ArosAco->save($permission);
    }
}