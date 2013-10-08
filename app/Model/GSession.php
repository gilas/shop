<?php

class GSession extends AppModel{
    public function beforeSave(){
        $this->data['Session']['user_id'] = AuthComponent::user('id');
    }
}