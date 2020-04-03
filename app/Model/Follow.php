<?php
App::uses('AppModel', 'Model');

class Follow extends AppModel {
    public $actsAs = ['Containable'];
    
    public $belongsTo = [
        'UserProfile' => [
            'foreignKey' => 'user_id'
        ],
        'User' => [
            'foreignKey' => 'user_id'
        ]
    ];
}