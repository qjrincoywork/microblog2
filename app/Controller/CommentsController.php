<?php
App::uses('AppController', 'Controller');

class CommentsController extends AppController {
    public $uses = ['User', 'Post', 'Comment'];
    
    public function add() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('post')) {
                $datum['success'] = false;
                
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
            if($this->request->is('post')) {
                $datum['success'] = false;

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
            $data = $this->Comment->find('first', [
                'conditions' => ['Comment.id'=>$id]
            ]);
            $data['Comment']['content'] = htmlspecialchars_decode($data['Comment']['content'], ENT_NOQUOTES);
            $this->set('data', $data);
        }
    }

    public function delete() {
        if($this->RequestHandler->isAjax()) {
            if($this->request->is('post')) {
                $datum['success'] = false;
                $this->response->type('application/json');
                $this->autoRender = false;
                $this->Comment->delete($this->request->data['Comment']['id']);
                $datum['success'] = true;
                return json_encode($datum);
            }

            $id = $this->request->params['named']['id'];
            $data = $this->Comment->find('first',[
                'conditions' => ['Comment.id' => $id]
            ]);
            $this->set('data', $data);
        }
    }
}
