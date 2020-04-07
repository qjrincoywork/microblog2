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
            ],
            'emailRule-3'=> [
                'rule' => 'isUnique',
                'message' => 'Email already exists'
            ],
        ],
        'first_name' => [
            'first_nameRule-1' => [
                'rule' => 'notBlank',
                'message' => 'First name is required'
            ],
            'first_nameRule-2' => [
                'rule' => "/(?=.*[a-z])(?=.*[A-Z])/",
                'message' => 'Please enter only letters'
            ]
        ],
        'last_name' => [
            'last_nameRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Last name is required'
            ],
            'last_nameRule-2' => [
                'rule' => "/(?=.*[a-z])(?=.*[A-Z])/",
                'message' => 'Please enter only letters'
            ]
        ],
        'middle_name' => [
            'middle_nameRule-1' => [
                'rule' => "/(?=.*[a-z])(?=.*[A-Z])/",
                'allowEmpty' => true,
                'message' => 'Please enter only letters'
            ]
        ],
        'suffix' => [
            'suffixRule-1' => [
                'rule' => "/(?=.*[a-z])(?=.*[A-Z])/",
                'allowEmpty' => true,
                'message' => 'Please enter only letters'
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