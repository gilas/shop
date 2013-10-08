<?php
class MessagesUser extends AppModel
{
    public $actsAs = array('Tree');

	public $name = "MessagesUser";
    public $belongsTo = array(
        'Recipient' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'fields' => array('Recipient.id', 'Recipient.username', 'Recipient.name','Recipient.role_id')
        ),
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'message_id',
        ),
        'SenderInfo' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'fields' => array('SenderInfo.id', 'SenderInfo.username', 'SenderInfo.name','SenderInfo.role_id')
        ),
        
    );
    
 }
?>