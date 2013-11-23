<?php

class ShopAppController extends AppController {
    public function beforeRender(){
        $this->helpers[] = 'Shop.Shop';
        parent::beforeRender();
    }
}

