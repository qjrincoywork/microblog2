<?php
App::uses('AppController', 'Controller');

class PostsController extends AppController {
    public $uses = ['User', 'UserProfile', 'Post', 'Follow', 'Comment'];

    public function beforeFilter() {
        $this->Security->blackHoleCallback = 'blackhole';
        $this->Security->validatePost = false;
        // $this->Security->requireSecure();
        $this->layout = 'main';
    }

    public function blackhole($type) {
        /* switch ($type) {
            case "csrf":
                $this->Session->setFlash(__('The request has been black-holed (csrf)'));
                // $datum['error'] = "The request has been black-holed (csrf)";
                // $datum['error'] = "(csrf)";
                // return json_encode($datum);
                // $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
                // return $this->redirect($this->referer());
                break;
            case "auth":
                $this->Flash->error(__("The request has been black-holed (auth)"));
                // $this->Session->setFlash(__('The request has been black-holed (auth)'));
                // $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
                // $datum['error'] = "The request has been black-holed (auth)";
                // pr($datum);
                // die('hit');
                // return json_encode($datum);
                // return $this->redirect($this->here);
                break;
            case "secure":
                // return $this->redirect('https://'.env('SERVER_NAME').$this->here);
                break;
        } */
    }
    
    public function add() {
        if($this->request->is('ajax')) {
            $username = $this->Session->read('User')['username'];
            $datum['success'] = false;
            $this->request->data['Post']['user_id'] = $this->Session->read('User')['id'];
            $this->response->type('application/json');
            $this->autoRender = false;
            $this->Post->set($this->request->data);
            if($this->request->data['Post']['image'] == 'undefined') {
                $this->request->data['Post']['image'] = null;
                
                if($this->Post->validates($this->request->data)) {
                    $this->Post->save($this->request->data);
                    $datum['success'] = true;
                } else {
                    $errors = $this->Post->validationErrors;
                    $datum['error'] = $errors;
                }
            } else {
                if($this->Post->validates($this->request->data)) {
                    $uploadFolder = "img/".$username;
                    
                    if(!file_exists($uploadFolder)) {
                        mkdir($uploadFolder);
                    }

                    $path = $uploadFolder."/".$this->request->data['Post']['image']['name'];
                    
                    if(move_uploaded_file($this->request->data['Post']['image']['tmp_name'],
                                          $path)) {
                        $this->request->data['Post']['image'] = $path;
                        if($this->Post->save(h($this->request->data))) {
                            $datum['success'] = true;
                        }
                    }
                } else {
                    $errors = $this->Post->validationErrors;
                    $datum['error'] = $errors;
                }
            }
            echo json_encode($datum);
        }
    }

    public function share() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('post')) {
                $datum['success'] = false;
                
                $this->response->type('application/json');
                $this->autoRender = false;
                $this->Post->set($this->request->data);
                
                if(isset($this->request->data['Post']['post_id'])) {
                    unset($this->Post->validate['content']);
                    $this->Post->save(h($this->request->data));
                    $datum['success'] = true;
                }
                
                return json_encode($datum);
            }

            $postId = $this->request->params['named']['post_id'];
            $data = $this->User->getPost($postId);
            $this->set('data', $data);
        }
    }

    public function view() {
        $id = $this->request->params['named']['post_id'];
        $data = $this->User->getPost($id);
        $this->set('data', $data);
        $this->Comment->virtualFields['comment_ago'] = "CASE
                                                        WHEN Comment.created between date_sub(now(), INTERVAL 120 second) and now() 
                                                            THEN 'Just now'
                                                        WHEN Comment.created between date_sub(now(), INTERVAL 60 minute) and now() 
                                                            THEN concat(minute(TIMEDIFF(now(), Comment.created)), ' minutes ago')
                                                        WHEN datediff(now(), Comment.created) = 1 
                                                            THEN 'Yesterday'
                                                        WHEN Comment.created between date_sub(now(), INTERVAL 24 hour) and now() 
                                                            THEN concat(hour(TIMEDIFF(NOW(), Comment.created)), ' hours ago')
                                                        ELSE concat(datediff(now(), Comment.created),' days ago')
                                                    END";
        $this->paginate = [
            'limit' => 3,
            'conditions' => ['Comment.post_id' => $id],
            'order' => [
                'Comment.created'
            ]
        ];
        $this->set('comments', $this->paginate('Comment'));
        $this->set('title_for_layout', 'User Post');
    }
    
    public function edit() {
        if($this->request->is('post')) {
            $username = $this->Session->read('User')['username'];
            $datum['success'] = false;
            $this->request->data['Post']['user_id'] = $this->Session->read('User')['id'];
            // $this->request->data['Post']['id'] = $postId;
            $this->response->type('application/json');
            $this->autoRender = false;

            if($this->request->data['Post']['image'] == 'undefined') {
                unset($this->request->data['Post']['image']);
                $this->Post->set($this->request->data);
                
                if($this->Post->validates($this->request->data)) {
                    $this->Post->save($this->request->data);
                    $datum['success'] = true;
                } else {
                    $errors = $this->Post->validationErrors;
                    $datum['error'] = $errors;
                }
            } else {
                $this->Post->set($this->request->data);
                if($this->Post->validates($this->request->data)) {
                    $uploadFolder = "img/".$username;
                    
                    if(!file_exists($uploadFolder)) {
                        mkdir($uploadFolder);
                    }
                    
                    $path = $uploadFolder."/".$this->request->data['Post']['image']['name'];
                    if(move_uploaded_file($this->request->data['Post']['image']['tmp_name'],
                                            $path)) {
                        $this->request->data['Post']['image'] = $path;
                        
                        if($this->Post->save($this->request->data)) {
                            $datum['success'] = true;
                        }
                    }
                } else {
                    $errors = $this->Post->validationErrors;
                    $datum['error'] = $errors;
                }
            }
            return json_encode($datum);
        }
        $postId = $this->request->params['named']['post_id'];
        $data = $this->User->getPost($postId);
        $this->set('data', $data);
    }

    public function delete() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('post')) {
                $datum['success'] = false;

                $this->response->type('application/json');
                $this->autoRender = false;
                $this->Post->set($this->request->data);
                
                if($this->Post->validates($this->request->data)) {
                    $this->Post->save($this->request->data);
                    $datum['success'] = true;
                } else {
                    $errors = $this->Post->validationErrors;
                    $datum['error'] = $errors;
                }
                
                return json_encode($datum);
            }

            $postId = $this->request->params['named']['post_id'];
            $data = $this->User->getPost($postId);
            $this->set('data', $data);
        }
    }
}