<?php
App::uses('AppController', 'Controller');

class LikesController extends AppController {
    public $uses = ['User', 'Post', 'Like'];
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
            $this->response->type('application/json');
            $this->autoRender = false;
            $datum['success'] = false;
            $like['Like']['post_id'] = $this->request->data['post_id'];
            $like['Like']['user_id'] = $this->Session->read('Auth.User')['id'];
            
            $exists = $this->Like->find('first', [
                'conditions' => [
                        ['Like.post_id' => $like['Like']['post_id'],
                         'Like.user_id' => $like['Like']['user_id']
                    ]
                ]
            ]);
            
            if(!$exists) {
                $this->Like->save($like);
            } else {
                $status = $exists['Like']['deleted'] ? 0 : 1;
                $exists['Like']['deleted'] = $status;
                $this->Like->save($exists);
            }
            
            return json_encode($datum);
        }
    }
}