<?php
App::uses('AppController', 'Controller');

class CommentsController extends AppController {
    public $uses = ['User', 'Post', 'Comment'];
    public function beforeFilter() {
        // $this->Security->blackHoleCallback = 'blackhole';
        /* $this->Security->validatePost = false;
        $this->Security->requireSecure(); */
    }
    
    public function blackhole($type) {
        // $this->Flash->error(__($type));
        // $this->redirect($this->referer());
    }

    public function add() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('post')) {
                $datum['success'] = false;
                $this->request->data['Comment']['user_id'] = $this->Session->read('Auth.User')['id'];
                $this->response->type('application/json');
                $this->autoRender = false;
                $this->Comment->set($this->request->data);
                
                if($this->Comment->validates($this->request->data)) {
                    $this->Comment->save(h($this->request->data));
                    $datum['success'] = true;
                } else {
                    $errors = $this->Comment->validationErrors;
                    $datum['error'] = $errors;
                }
                
                return json_encode($datum);
            }
            
            $id = $this->request->params['named']['post_id'];
            $data = $this->User->getPost($id);
            $this->set('data', $data);
        }
    }

    public function edit() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('put')) {
                $datum['success'] = false;
                $this->request->data['Comment']['user_id'] = $this->Session->read('Auth.User')['id'];
                $this->response->type('application/json');
                $this->autoRender = false;
                $this->Comment->set($this->request->data);
                
                if($this->Comment->validates($this->request->data)) {
                    $this->Comment->save(h($this->request->data));
                    $datum['success'] = true;
                } else {
                    $errors = $this->Comment->validationErrors;
                    $datum['error'] = $errors;
                }
                
                return json_encode($datum);
            }
            
            $id = $this->request->params['named']['id'];
            $this->request->data = $this->Comment->findById($id);
            $this->request->data['Comment']['content'] = htmlspecialchars_decode($this->request->data['Comment']['content'], ENT_NOQUOTES);
        }
    }

    public function delete() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('put')) {
                $this->request->data['Comment']['user_id'] = $this->Session->read('Auth.User')['id'];
                $datum['success'] = false;
                $this->response->type('application/json');
                $this->autoRender = false;

                if($this->Comment->validates($this->request->data)) {
                    $this->Comment->save($this->request->data);
                    $datum['success'] = true;
                } else {
                    $errors = $this->Comment->validationErrors;
                    $datum['error'] = $errors;
                }
                
                return json_encode($datum);
            }
            
            $id = $this->request->params['named']['id'];
            $this->request->data = $this->Comment->findById($id);
        }
    }
}
