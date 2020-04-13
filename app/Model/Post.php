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
        ],
        'image' => [
            'imageRule-1' => [
                'rule' => 'imageType',
                'allowEmpty' => true,
                'message'=>'Please input a valid image'
            ]
            /* 'imageRule-1' => [
                'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
                'allowEmpty' => true,
                'message'=>'Please input a valid image'
            ],
            'imageRule-2' => [
                'rule' => ['uploadError'],
                'allowEmpty' => true,
                'message' => "Image upload failed"
            ] */
        ]
    ];

    public function imageType() {
        if($this->data[$this->alias]['image'] != 'undefined' && isset($this->data[$this->alias]['image']['type'])) {
            $types = ['image/gif', 'image/png', 'image/jpg', 'image/jpeg'];
            if(in_array($this->data[$this->alias]['image']['type'], $types)) {
                return true;
            }
        } else {
            return true;
        }
        return false;
    }
}