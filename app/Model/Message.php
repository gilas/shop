<?php
class Message extends AppModel
{
    
    public $validate = array(
        'subject' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'تکمیل این فیلد ضروری است',
            ),
        ),
        'message' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'تکمیل این فیلد ضروری است',
            ),
        ),
    );
    
    // Every pm can read by one Reader
    public $hasOne = array(
        'Reader' =>array(
            'foreignKey' => 'message_id',
            'className' => 'MessagesUser',
        ),
        'Sender' =>array(
            'foreignKey' => 'message_id',
            'className' => 'MessagesUser',
            'conditions' => array('Sender.is_sender' => true),
        )
    );
    
    // Every pm has many recipient, recipients can detect by his folder
    // so if his folder fro current pm is not outbox , so he is recipient
    public $hasMany = array(
        'Recipients' =>array(
            'foreignKey' => 'message_id',
            'className' => 'MessagesUser',
            'conditions' => array('Recipients.is_sender' => false),
        )
    );
    
    public $folders = array(
        '1' => 'inbox',
        '2' => 'outbox',
        '3' => 'draft',
        '4' => 'trash',
        'inbox' => '1',
        'outbox' => '2',
        'draft' => '3',
        'trash' => '4',
    );
}
?>