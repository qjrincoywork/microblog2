<?php
App::uses('AppModel', 'Model');

class UserProfile extends AppModel {
    public $belongsTo = ['User'];
    
    public $validate = [
        'email' => [
            'emailRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Email is required'
            ],
            'emailRule-2' => [
                'rule' => 'email',
                'message' => 'Invalid Email format'
            ]
        ],
        'first_name' => [
            'first_nameRule-1' => [
                'rule' => 'notBlank',
                'message' => 'First name is required'
            ]
        ],
        'last_name' => [
            'last_nameRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Last name is required'
            ]
        ],
        'gender' => [
            'genderRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Gender is required'
            ]
        ],
        'image' => [
            'imageRule-1' => [
                'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
                'allowEmpty' => true,
                'message'=>'Please input a valid image'
            ],
            'imageRule-2' => [
                'rule' => ['uploadError'],
                'allowEmpty' => true,
                'message' => "Image upload failed"
            ]
        ]
    ];
}