<?php
App::uses('AppModel', 'Model');

class Comment extends AppModel {
    public $actsAs = ['Containable'];
    public $belongsTo = ['Post', 'User'];
    public $validate = [
        'content' => [
            'contentRule-1' => [
                'rule' => ['maxLength', 140],
                'message' => 'Maximum character is 140'
            ],
            'contentRule-2' => [
                'rule' => 'notBlank',
                'message' => "Comment can't be empty"
            ]
        ]
    ];
}