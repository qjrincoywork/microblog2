<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeSession', 'Model/Datasource');

class User extends AppModel {
    public $actsAs = ['Containable'];
    public $hasOne = 'UserProfile';
    public $hasMany = ['Follow', 'Post', 'Comment', 'Like'];

    public $validate = [
        'username' => [
            'usernameRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Username is required'
            ],
            'usernameRule-2'=> [
                'rule' => 'isUnique',
                'message' => 'Username already exists'
            ],
            'usernameRule-3' => [
                'rule' => ['minLength', 8],
                'message' => 'Minimum character is 8'
            ]
        ],
        'password' => [
            'passwordRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Password is required'
            ],
            'passwordRule-2' => [
                'rule' => "/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/",
                'message' => 'The password does not meet the requirements'
            ]
        ],
        'confirm_password' => [
            'confirm_passwordRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Confirm password is required'
            ],
            'confirm_passwordRule-2' => [
                'rule' => "confirmPassword",
                'message' => "Does not match with password"
            ]
        ],
        'old_password' => [
            'old_passwordRule-1' => [
                'rule' => 'notBlank',
                'message' => 'Old password is required'
            ],
            'old_passwordRule-2' => [
                'rule' => 'validateOldPassword',
                'message' => 'Not the same with old password'
            ]
        ],
        'token' => [
            'required' => [
                'rule' => 'notBlank',
                'message' => 'token is required'
            ]
        ]
    ];
    
    public function confirmPassword() {
        if ($this->data['User']['password'] !== $this->data['User']['confirm_password']){
            return false;
        }
        return true;
    }

    public function validateOldPassword() {
        $data = $this->find('first', [
                            'conditions' => ['User.id' => $this->data['User']['id']]
        ]);
        
        $same = password_verify($this->data['User']['old_password'], $data['User']['password']);

        if (!$same){
            return false;
        }
        return true;
    }

    public function beforeSave($options = []) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

    public function getPost($postId)
    {
        $id = CakeSession::read('Auth.User')['id'];
        $this->UserProfile->virtualFields['image'] = "CASE 
                                                        WHEN UserProfile.image IS NULL
                                                            THEN
                                                                CASE
                                                                WHEN UserProfile.gender != 1
                                                                    THEN '/img/default_avatar_f.svg'
                                                                    ELSE '/img/default_avatar_m.svg'
                                                                END
                                                        ELSE concat('/',UserProfile.image)
                                                      END";
        $this->Post->virtualFields['post_ago'] = "CASE
                                                    WHEN Post.created between date_sub(now(), INTERVAL 120 second) and now() 
                                                        THEN 'Just now'
                                                    WHEN Post.created between date_sub(now(), INTERVAL 60 minute) and now() 
                                                        THEN concat(minute(TIMEDIFF(now(), Post.created)), ' minutes ago')
                                                    WHEN datediff(now(), Post.created) = 1 
                                                        THEN 'Yesterday'
                                                    WHEN Post.created between date_sub(now(), INTERVAL 24 hour) and now() 
                                                        THEN concat(hour(TIMEDIFF(NOW(), Post.created)), ' hours ago')
                                                    ELSE concat(datediff(now(), Post.created),' days ago')
                                                END";
                                                
        $data = $this->Post->find('first',[
            'conditions' => ['Post.id' => $postId]
        ]);
        
        if($data) {
            if(!$data['Post']['deleted'] || $data['Post']['user_id'] == $id) {
                $data['Post']['content'] = htmlspecialchars_decode($data['Post']['content'], ENT_NOQUOTES);
            } else {
                $data = [];
            }
        }
        
        return $data;
    }

    public function getUserPost($userId)
    {
        $this->UserProfile->virtualFields['image'] = "CASE 
                                                        WHEN UserProfile.image IS NULL
                                                            THEN
                                                                CASE
                                                                WHEN UserProfile.gender != 1
                                                                    THEN '/img/default_avatar_f.svg'
                                                                    ELSE '/img/default_avatar_m.svg'
                                                                END
                                                        ELSE concat('/',UserProfile.image)
                                                      END";
        $this->Post->virtualFields['post_ago'] = "CASE
                                                    WHEN Post.created between date_sub(now(), INTERVAL 120 second) and now() 
                                                        THEN 'Just now'
                                                    WHEN Post.created between date_sub(now(), INTERVAL 60 minute) and now() 
                                                        THEN concat(minute(TIMEDIFF(now(), Post.created)), ' minutes ago')
                                                    WHEN datediff(now(), Post.created) = 1 
                                                        THEN 'Yesterday'
                                                    WHEN Post.created between date_sub(now(), INTERVAL 24 hour) and now() 
                                                        THEN concat(hour(TIMEDIFF(NOW(), Post.created)), ' hours ago')
                                                    ELSE concat(datediff(now(), Post.created),' days ago')
                                                END";
                                                
        $data = $this->Post->find('all',[
            'Post.deleted' => 0,
            'conditions' => ['Post.user_id' => $userId],
            'order' => [
                'Post.created DESC'
            ]
        ]);
        
        return $data;
    }
}