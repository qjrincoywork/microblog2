<?php
App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');

class Comment extends AppModel {
    public $actsAs = ['Containable'];
    public $belongsTo = ['Post', 'User'];
    public $validate = [
        'id' => [
            'idRule-1' => [
                'rule' => 'isMine',
                'message' => 'Unable to process action'
            ],
        ],
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