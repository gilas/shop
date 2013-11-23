<?php

class FactorItem extends ShopAppModel {
    public $belongsTo = array(
        'Stuff' => array(
            'className' => 'Shop.Stuff',
            'foreignKey' => 'stuff_id',
        ),
    );
}
