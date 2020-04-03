<?php
App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $actsAs = ['Containable'];
    public $hasMany = ['Comment', 'Like'];

    public $belongsTo = [
        'UserProfile' => [
            'foreignKey' => 'user_id'
        ],
        'User' => [
            'foreignKey' => 'user_id'
        ]
    ];

    public $validate = [
        'content' => [
            'contentRule-1' => [
                'rule' => ['maxLength', 140],
                'message' => 'Maximum character is 140'
            ],
            'contentRule-2' => [
                'rule' => 'notBlank',
                'message' => "Post can't be empty"
            ]
        ]
    ];
}