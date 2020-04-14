<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeTime', 'Utility');
App::import('Helper', 'SystemHelper');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = [
        'Paginator',
        'Flash',
        'Email',
        'RequestHandler',
        'Security',
        'Session',
        'Auth' => [
            'loginRedirect' => ['controller' => 'users', 'action' => 'dashboard'],
            'logoutRedirect' => ['controller' => 'users', 'action' => 'login'],
            'authenticate' => [
                'Form' => [
                    'passwordHasher' => 'Blowfish',
                    'fields' => [
                        'log_username' => 'username',
                        'log_password' => 'password'
                    ],
                ]
            ]
        ],
    ];
    
    public function beforeFilter() {
        if (empty($this->params['controller'])) {
            return $this->redirect(['/']);
        }
        $this->set('url', '/');
        $this->Auth->allow('login');

        /* $url = env('HTTP_HOST');
        if (!isset($_SERVER['HTTPS']) && strpos($url, 'local') === false) {
            $this->Security->requireSecure();
            $this->Security->requireAuth();
        } */
    }

    /* public function blackhole($type) {
        // $this->Session->setFlash(__('ERROR: %s',$type), 'flash/error');
        // $this->Session->setFlash('What are you doing!?');
        
        switch ($type) {
            case "csrf":
                $this->Session->setFlash(__('The request has been black-holed (csrf)'));
                // $datum['error'] = "The request has been black-holed (csrf)";
                // $datum['error'] = "(csrf)";
                // return json_encode($datum);
                // $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
                // return $this->redirect($this->referer());
                break;
            case "auth":
                $this->Session->setFlash(__('The request has been black-holed (auth)'));
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
        }
    } */
}
