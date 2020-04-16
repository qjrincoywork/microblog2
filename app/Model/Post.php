<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');

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
        'id' => [
            'idRule-1' => [
                'rule' => 'isMine',
                'message' => 'Unable to process action'
            ]
        ],
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

    public function isMine() {
        $id = $this->data[$this->alias]['id'];
        $userId = CakeSession::read('Auth.User')['id'];
        
        $data = $this->find('first', [
            'conditions' => [$this->alias.'.id' => $id, $this->alias.'.user_id' => $userId]
        ]);
        
        if($data) {
            return true;
        }
        return false;
    }
}