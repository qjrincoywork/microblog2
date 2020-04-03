<?php
App::uses('AppController', 'Controller');

class PostsController extends AppController {
    public $uses = ['User', 'UserProfile', 'Post', 'Follow', 'Comment'];
    public $components = ['Paginator', 'RequestHandler'];

    public function beforeFilter() {
        $this->layout = 'main';
    }
    
    public function add() {
        if($this->request->is('ajax')) {
            $datum['success'] = false;
            $this->response->type('application/json');
            $this->autoRender = false;
            
            $this->request->data['Post']['user_id'] = $this->Session->read('User')['id'];
            $this->Post->set($this->request->data);
            
            if($this->Post->validates($this->request->data)) {
                $this->Post->save(h($this->request->data));
                $datum['success'] = true;
            } else {
                $errors = $this->Post->validationErrors;
                $datum['error'] = $errors;
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
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('post')) {
                $datum['success'] = false;

                $this->response->type('application/json');
                $this->autoRender = false;
                $this->Post->set($this->request->data);

                
                if($this->Post->validates($this->request->data)) {
                    $this->Post->save(h($this->request->data));
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