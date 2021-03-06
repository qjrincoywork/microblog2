<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    public $uses = ['User', 'UserProfile', 'Post', 'Follow'];
    // public $components = ['Security'];

    public function beforeFilter() {
        $this->Auth->allow('register', 'activation', 'logout', 'testEmail');
        // $this->Security->blackHoleCallback = 'blackhole';
        // $this->Security->validatePost = false;
        // $this->Security->requireSecure();
        $this->layout = 'main';
        if($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
    }

    public function blackhole($type) {
        // $this->redirect($this->referer());
    }
    
    public function getPosts($ids, $conditions = null) {
        $this->UserProfile->virtualFields['image'] = "CASE 
                                                        WHEN UserProfile.image IS NULL
                                                            THEN
                                                                CASE
                                                                WHEN UserProfile.gender = 0
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
        $this->paginate = [
            'joins' => [
                [
                    'table' => 'follows',
                    'alias' => 'Follow',
                    'type' => 'left',
                    'foreignKey' => false,
                    'conditions'=> ['UserProfile.user_id = Follow.following_id']
                ],
            ],
            'conditions' => [
                $conditions,
                'Post.user_id' => $ids,
            ],
            'order' => [
                'Post.created DESC'
            ],
            'limit' => 4
        ];
        return $this->paginate('Post');
    }
    
    public function dashboard() {
        $userId = $this->Session->read('Auth.User')['id'];
        $ids = $this->Follow->find('list', [
                    'fields' => ['Follow.following_id'],
                    'conditions' => ['Follow.user_id' => $userId, 'Follow.deleted' => 0]
        ]);
        $ids[] = $userId;
        $data = $this->getPosts($ids, ['Post.deleted' => 0]);
        $this->set('data', $data);
        $this->set('title_for_layout', 'Home page');
    }
    
    public function profile() {
        $conditions = [];
        if(empty($this->request->params['named']['user_id'])) {
            throw new NotFoundException();
        }
        
        if(!empty($this->request->params['named']['user_id'])){
            $id = $this->Session->read('Auth.User')['id'];
            $userId = $this->request->params['named']['user_id'];
            if($userId !== $id) {
                $conditions = ['Post.deleted' => 0];
            }
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
            $profile = $this->UserProfile->find('first', [
                'conditions' => ['UserProfile.user_id' => $userId]
            ]);

            if(!$profile) {
                throw new NotFoundException();
            }
            
            $data = $this->getPosts($userId, $conditions);
            $this->set('profile', $profile);
            $this->set('data', $data);
        }
        $this->set('title_for_layout', 'User Profile');
    }
    
    public function edit() {
        if($this->RequestHandler->isAjax()) {
            $id = $this->Session->read('Auth.User')['id'];
            if($this->request->is('put')) {
                $this->request->data['UserProfile']['id'] = $id;
                $this->request->data['UserProfile']['user_id'] = $id;

                $datum['success'] = false;
                $this->response->type('application/json');
                $this->autoRender = false;

                unset($this->UserProfile->validate['email']['emailRule-3']);
               
                $this->UserProfile->set($this->request->data);
                if($this->UserProfile->validates($this->request->data)) {
                    $this->UserProfile->save(h($this->request->data));
                    $datum['success'] = true;
                } else {
                    $errors = $this->UserProfile->validationErrors;
                    $datum['error'] = $errors;
                }
                
                return json_encode($datum);
            }
            
            $this->request->data = $this->UserProfile->find('first',[
                'conditions' => ['UserProfile.user_id' => $id]
            ]);
        }
    }
    
    public function testEmail() {
        try {
            $activationUrl = (isset($_SERVER['HTTPS']) === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            $subject = "Microblog Account Activation";
            $name = "Incoy, Quir John";
            $to = trim("quirjohnincoy.work@gmail.com");
            
            $message = "Dear <span style='color:#666666'>" . ucwords($name) . "</span>,<br/><br/>";
            $message .= "<b>Full Name:</b> " . ucwords($name) . "<br/>";
            $message .= "<b>Email Address:</b> " . $to . "<br/>";
            $message .= "<b>Activate your account by clicking </strong><a href='$activationUrl'>Activate Account now</a></strong></b><br/>";
            
            $email = new CakeEmail('gmail');
            $email->from(['quirjohnincoy.work@gmail.com' => 'Microblog'])
                    ->emailFormat('html')
                    ->to($to)
                    ->subject($subject);
                    // ->send($message)
            if($email->send($message)) {
                echo "Email sent";
            } else {
                echo "Email not sent";
            }
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    public function editPicture() {
        if($this->RequestHandler->isAjax()) {
            $id = $this->Session->read('Auth.User')['id'];
            $datum['success'] = false;
            if($this->request->is('put')) {
                $this->response->type('application/json');
                $this->autoRender = false;
                $this->request->data['UserProfile']['id'] = $id;
                $this->request->data['UserProfile']['user_id'] = $id;
                $profile = $this->request->data;
                $username = $this->Session->read('Auth.User')['username'];
                if($profile['UserProfile']['image'] == 'undefined') {
                    $profile['UserProfile']['image'] = null;
                    $this->UserProfile->save($profile);
                    $datum['success'] = true;
                } else {
                    if($this->UserProfile->validates($profile)) {
                        $uploadFolder = "img/".$username;
                        
                        if(!file_exists($uploadFolder)) {
                            mkdir($uploadFolder);
                        }
                        
                        $path = $uploadFolder."/".$profile['UserProfile']['image']['name'];
                        if(move_uploaded_file($this->request->data['UserProfile']['image']['tmp_name'],
                                              $path)) {
                            $profile['UserProfile']['image'] = $path;
                            $this->UserProfile->set($profile);
                            if($this->UserProfile->save()) {
                                $datum['success'] = true;
                            }
                        }
                    } else {
                        $errors = $this->UserProfile->validationErrors;
                        $datum['error'] = $errors;
                    }
                }
                return json_encode($datum);
            }
            $this->request->data = $this->User->findById($id);
        }
    }

    public function changePassword() {
        $id = $this->Session->read('Auth.User')['id'];
        if($this->request->is('put')) {
            $datum['success'] = false;
            $this->response->type('application/json');
            $this->autoRender = false;
            $this->request->data['User']['id'] = $id;
            $this->User->set($this->request->data);
            if($this->User->validates($this->request->data)) {
                $this->User->save(h($this->request->data));
                $datum['success'] = true;
            } else {
                $errors = $this->User->validationErrors;
                $datum['error'] = $errors;
            }
            
            return json_encode($datum);
        }
        $data = $this->User->findById($id);
        unset($data['User']['password']);
        $this->request->data = $data;
    }

    public function search() {
        $conditions = [];
        if(isset($this->request->data['user'])){
            $cond = [];
            $cond['UserProfile.first_name LIKE'] = "%" . trim($this->request->data['user']) . "%";
            $cond['UserProfile.last_name LIKE'] = "%" . trim($this->request->data['user']) . "%";
            $cond['UserProfile.email LIKE'] = "%" . trim($this->request->data['user']) . "%";
            $cond['UserProfile.middle_name LIKE'] = "%" . trim($this->request->data['user']) . "%";
            $cond['UserProfile.suffix LIKE'] = "%" . trim($this->request->data['user']) . "%";
            $cond["CONCAT(UserProfile.first_name,' ',UserProfile.last_name) LIKE"] = "%" . trim($this->request->data['user']) . "%";
            $conditions['OR'] = $cond;
        }
        
        $this->paginate = ['conditions' => [$conditions, 'User.is_online !=' => 2], 'limit' => 10];
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
        $data = $this->paginate('User');
        $this->set('data',$data);
    }

    public function following() {
        $field = key($this->request->params['named']);
        $id = $this->request->params['named'][$field];
        
        if($field == 'user_id') {
            $conditions = ['Follow.'.$field => $id];
            $column = 'following_id';
            $message = 'No user following';
        } else {
            $conditions = ['Follow.'.$field => $id];
            $column = 'user_id';
            $message = "Don't have any follower";
        }
        
        $ids = $this->Follow->find('list', [
                    'fields' => ['Follow.'.$column],
                    'conditions' => [$conditions, 'Follow.deleted' => 0]
        ]);
        
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
        $this->paginate = [
            'limit' => 10,
            'conditions' => [
                ['User.id' => $ids, 'User.deleted' => 0]
            ]
        ];
        
        $this->set('message', $message);
        $this->set('data', $this->paginate());
    }

    public function follow() {
        if($this->RequestHandler->isAjax()) {
            $this->response->type('application/json');
            $this->autoRender = false;
            $datum['success'] = false;
            
            $follow['Follow']['user_id'] = $this->Session->read('Auth.User')['id'];
            $follow['Follow']['following_id'] = $this->request->data['following_id'];
            
            $exists = $this->Follow->find('first', [
                'conditions' => [
                        ['Follow.following_id' => $follow['Follow']['following_id'],
                         'Follow.user_id' => $follow['Follow']['user_id']
                    ]
                ]
            ]);
            
            if(!$exists) {
                $this->Follow->save($follow);
                $datum['success'] = true;
            } else {
                $status = $exists['Follow']['deleted'] ? 0 : 1;
                $exists['Follow']['deleted'] = $status;
                $this->Follow->save($exists);
                $datum['success'] = true;
            }
            
            echo json_encode($datum);
        }
    }

    public function register() {
        $this->layout = 'default';
        if ($this->request->is('ajax')) {
            try {
                $datum['success'] = false;
                $this->response->type('application/json');
                $this->autoRender = false;

                $mytoken = Security::hash(Security::randomBytes(32));
                $this->request->data['User']['token'] = $mytoken;
                $this->User->set($this->request->data);
                
                if($this->User->validates($this->request->data)) {
                    $this->UserProfile->set($this->request->data);
                    
                    if($this->UserProfile->validates($this->request->data)) {
                        $this->User->save(h($this->request->data));
                        $this->request->data['UserProfile']['user_id'] = $this->User->id;
                        if($this->UserProfile->save(h($this->request->data))) {
                            $activationUrl = (isset($_SERVER['HTTPS']) === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . "/users/activation/" . $mytoken;
                            $subject = "Microblog Account Activation";
                            $name = $this->request->data['UserProfile']['last_name'].', '.$this->request->data['UserProfile']['first_name'].' '.$this->request->data['UserProfile']['middle_name'];
                            $to = trim($this->request->data['UserProfile']['email']);
                            
                            $message = "Dear <span style='color:#666666'>" . ucwords($name) . "</span>,<br/><br/>";
                            $message .= "Your account has been created successfully.<br/>";
                            $message .= "Please look at the details of your account below: <br/><br/>";
                            $message .= "<b>Full Name:</b> " . ucwords($name) . "<br/>";
                            $message .= "<b>Email Address:</b> " . $to . "<br/>";
                            $message .= "<b>Username:</b> " . $this->data['User']['username'] . "<br/>";
                            $message .= "<b>Activate your account by clicking </strong><a href='$activationUrl'>Activate Account now</a></strong></b><br/>";
                            $message .= "<br/>Thanks, <br/>YNS Team";
                            
                            $email = new CakeEmail('gmail');
                            $email->from(['quirjohnincoy.work@gmail.com' => 'Microblog'])
                                    ->emailFormat('html')
                                    ->to($to)
                                    ->subject($subject)
                                    ->send($message);
                            
                            $datum['success'] = true;
                        }
                    } else {
                        $errors = $this->UserProfile->validationErrors;
                        $datum['error'] = $errors;
                    }
                } else {
                    $errors = $this->User->validationErrors;
                    $datum['error'] = $errors;
                }
                
                echo json_encode($datum);
            }
            catch(Exception $e)
            {
                $datum['error'] = $e;
                $datum['success'] = "false";
                echo json_encode($datum);
            }
        }
    }
    
    public function activation($token) {
        if(!$token) {
            throw new NotFoundException();
            $this->Flash->error(__('Invalid token'));
        }
        
        $user = $this->User->find('first', [
            'conditions' => [
                    ['User.token' => $token]
                ]
        ]);

        if(!$user) {
            throw new NotFoundException();
            $this->Flash->error(__('Invalid token!'));
        }
        
        $id = $user['User']['id'];
        
        if(isset($user['User']['is_online']) && $user['User']['is_online'] == 2) {
            $this->User->set(['id' => $id, 'is_online' => 0]);
            $this->User->save();
            $this->Flash->success(__('Account successfully verified!, You can now login'));
            $this->redirect(['controller' => 'users', 'action' => 'login']);
        } else {
            $this->Flash->error(__('Account was already verified!'));
            $this->redirect(['controller' => 'users', 'action' => 'login']);
        }
    }
    
    public function login() {
        $this->layout = 'default';
        /* if($this->Session->read('Auth.User')) {
            return $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
        } */
        
        if($this->request->is('post')) {
            $user = $this->User->find('first', [
                'conditions' => [
                        ['User.username' => $this->request->data['User']['username']]
                    ]
            ]);
            
            if(!$user) {
                $this->Flash->error(__('User does not exist'));
            } else {
                switch ($user['User']['is_online']) {
                    case 2:
                        $this->Flash->error(__('Please activate your account first, Thank you.'));
                        break;
                    case 3:
                        $this->Flash->error(__('Your account has been deactivated, Please Contact Admin.'));
                        break;
                    default:
                        if ($this->Auth->login()) {
                            $this->User->set(['id' => $user['User']['id'],
                                            'is_online' => 1,
                                            'attempts' => 0]);
                            $this->User->save();
                            return $this->redirect($this->Auth->redirectUrl("/users/dashboard"));
                        } else {
                            if($user['User']['attempts'] <= 4) {
                                $attempt = $user['User']['attempts'] + 1; 
                                $this->User->set(['id' => $user['User']['id'],
                                                'attempts' => $attempt]);
                                $this->User->save();
                                $this->Flash->error(__('Invalid username or password, try again'));
                            } else {
                                $this->User->set(['id' => $user['User']['id'],
                                                    'is_online' => 3]);
                                $this->User->save();
                                $this->Flash->error(__('Your account has been deactivated, Please Contact Admin.'));
                            }
                        }
                        break;
                }
            }
        }
    }
    
    public function logout() {
        if($this->Session->read('Auth.User')) {
            $id = $this->Session->read('Auth.User')['id'];
            $this->User->set(['id' => $id,
                            'is_online' => 0,
                            'modified' => date('Y-m-d H:i:s')]);
            $this->User->save();
        }
        return $this->redirect($this->Auth->logout());
    }
}