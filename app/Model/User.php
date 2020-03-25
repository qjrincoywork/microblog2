<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $hasOne = 'UserProfile';
    // public $hasOne = ['UserProfile' => ['className' => 'Profile']];
    /* public $name = 'User';

    public $hasOne = array(
        'Profile' => array('className' => 'User.UserProfile')
    ); */

    public $validate = [
        'username' => [
            'required' => [
                'rule' => ['notBlank', 'isUnique'],
                'message' => 'A username is required'
            ]
        ],
        'password' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'A password is required'
            ]
        ],
        'token' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'A token is required'
            ]
        ]
    ];

    public function beforeSave($options = []) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}