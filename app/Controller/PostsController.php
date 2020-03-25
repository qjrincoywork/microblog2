<?php
// App::uses('AppController', 'Controller');

// use Cake\Mailer\Email;
// use Cake\Auth\DefaultPasswordHasher;
// use Cake\Utility\Security;
// use Cake\ORM\TableRegistry;
// use Cake\Utility;
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');

class PostsController extends AppController {
    public $uses = ['User', 'UserProfile'];

    /* public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register');
	} */

	public function beforeFilter() {
		parent::beforeFilter();
		// Allow users to register and logout.
		$this->Auth->allow('register', 'logout');
	}
	
	public function login() {
		if ($this->request->is('post')) {
			echo "<br>";
			print_r($this->Auth->login());
			echo "<pre>";
			print_r($this->request->data);
			die(' hits');
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		}
	}
	
	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

    public function dashboard() {
		die('hit');
        /* $this->User->recursive = 0;
        $this->set('users', $this->paginate()); */
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }

    public function register() {
        if ($this->request->is('post')) {
			$mytoken = Security::hash(Security::randomBytes(32));

			$user['User']['username'] = $this->request->data['User']['username'];
			$user['User']['password'] = $this->request->data['User']['password'];
			$user['User']['token'] = $mytoken;

            $isValidated = $this->User->validates();

            if ($isValidated) {
				$this->User->save($user);
				
				$userProfile['UserProfile']['user_id'] = $this->User->id;
				$userProfile['UserProfile']['email'] = $this->request->data['User']['email'];
				$userProfile['UserProfile']['first_name'] = $this->request->data['User']['first_name'];
				$userProfile['UserProfile']['last_name'] = $this->request->data['User']['last_name'];
				$userProfile['UserProfile']['middle_name'] = $this->request->data['User']['middle_name'];
				$userProfile['UserProfile']['suffix'] = $this->request->data['User']['suffix'];
				$userProfile['UserProfile']['gender'] = $this->request->data['User']['gender'];
				
				$isProfileValidated = $this->UserProfile->validates();
				if($isProfileValidated) {
					if($this->UserProfile->save($userProfile)) {
						// $this->Flash->success(__('Register Successful, your confirmation email has been sent'));

						/* CakeEmail::configTransport('mailtrap', [
							'host' => 'smtp.mailtrap.io',
							'port' => 2525,
							'username' => '7198513de5519f',
							'password' => 'd14fb3fca0f037',
							'className' => 'Smtp'
						]); */

						/* $subject = "Activation link sent on your email";
						$name = $this->request->data['User']['last_name'].', '.$this->request->data['User']['first_name'].' '.$this->request->data['User']['middle_name'];
						$to = trim($this->request->data['User']['email']);

						$email = new CakeEmail();
						$email->emailFormat('html');
						$email->from(['quirjohnincoy.work@gmail.com' => 'Microblog']);
						$email->to($to);
						$email->subject($subject);

						$activationUrl = $_SERVER['HTTP_HOST'] . "/users/activation/" . $mytoken;
						
						$message = "Dear <span style='color:#666666'>" . $name . "</span>,<br/><br/>";
						$message .= "Your account has been created successfully by Administrator.<br/>";
						$message .= "Please find the below details of your account: <br/><br/>";
						$message .= "<b>Full Name:</b> " . $name . "<br/>";
						$message .= "<b>Email Address:</b> " . $this->data['User']['email'] . "<br/>";
						$message .= "<b>Username:</b> " . $this->data['User']['username'] . "<br/>";
					
						$message .= "<b>Activate your account by clicking on the below url:</b> <br/>";
						$message .= "<a href='$activationUrl'>$activationUrl</a><br/><br/>";
						$message .= "<br/>Thanks, <br/>YNS Team";
						$email->send($message); */
						$this->Flash->success(__('Register Successful, your confirmation email has been sent'));
						return $this->redirect(['action' => 'login']);
						/* $email = new Email('default');
						$email->transport('mailtrap');
						$email->emailFormat('html');
						$email->from('quirjohnincoy.work@gmail.com', 'Quir John Incoy');
						$email->subject('Please confirm your email to activate your account');
						$email->to($myemail);
						$email->send('Hi '.$myusername. '</br>Please confirm your email link below</br><a href="http://local.cakephp/users/verification/'. $mytoken .'">Email Verification</a></br>Thank you'); */
					} else {
						$this->Flash->error(__('Register Failed in User Profile table, please try again'));
					}
				}
				$this->Flash->error(__('The user profile could not be saved. Please, try again.'));
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }
	
	public function activation($token) {
		$userTable = ClassRegistry::get('Users');
		$verify = $userTable->find('all')->where(['token' => $token])->first();
		$verify->deleted = 1;
		$userTable->save($verify);
	}

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

}
/* class UsersController extends AppController {
	
	public function index() {
		if($this->request->is('post')) {
			$userTable = TableRegistry::get('Users');
			$userProfileTable = TableRegistry::get('UserProfiles');
			$user = $userTable->newEntity();
			$userProfile = $userProfileTable->newEntity();
			
			$hasher = new DefaultPasswordHasher();
			$myusername = $this->request->getData('username');
			$myemail = $this->request->getData('email');
			$mypass = Security::hash($this->request->getData('password'), 'sha256', false);
			$mytoken = Security::hash(Security::randomBytes(32));

			$user->username = $myusername;
			$user->password = $hasher->hash($mypass);
			$user->token = $mytoken;
			$user->created = date('Y-m-d H:i:s');
			$user->modified = date('Y-m-d H:i:s');
			
			if($userTable->save($user)) {
				$userProfile->email = $myemail;
				$userProfile->first_name = $this->request->getData('first_name');
				$userProfile->last_name = $this->request->getData('last_name');
				$userProfile->middle_name = $this->request->getData('middle_name');
				$userProfile->suffix = $this->request->getData('suffix');
				$userProfile->gender = $this->request->getData('gender');
				$userProfile->created = date('Y-m-d H:i:s');
				$userProfile->modified = date('Y-m-d H:i:s');
				if($userProfileTable->save($userProfile)) {
					$this->Flash->set('Register Successful, your confirmation email has been sent', ['element' => 'success']);
					
					Email::configTransport('mailtrap', [
						'host' => 'smtp.mailtrap.io',
						'port' => 2525,
						'username' => '7198513de5519f',
						'password' => 'd14fb3fca0f037',
						'className' => 'Smtp'
					]);
					
					$email = new Email('default');
					$email->transport('mailtrap');
					$email->emailFormat('html');
					$email->from('quirjohnincoy.work@gmail.com', 'Quir John Incoy');
					$email->subject('Please confirm your email to activate your account');
					$email->to($myemail);
					$email->send('Hi '.$myusername. '</br>Please confirm your email link below</br><a href="http://local.cakephp/users/verification/'. $mytoken .'">Email Verification</a></br>Thank you');
				} else {
					$this->Flash->set('Register Failed in User Profile table, please try again', ['element' => 'error']);
				}
			} else {
				$this->Flash->set('Register Failed in User table, please try again', ['element' => 'error']);
			}
		}
	}

	public function register() {
		if($this->request->is('post')) {
			$users = ClassRegistry::init('Users');
			// $user = ClassRegistry::getObject('Users');
			echo "<pre>";
			print_r($users);
			die(' hit register');
			$userTable = ClassRegistry::get('Users');
			$userProfileTable = TableRegistry::get('UserProfiles');
			$user = $userTable->newEntity();
			$userProfile = $userProfileTable->newEntity();
			$hasher = new DefaultPasswordHasher();
			$myusername = $this->request->getData('username');
			$myemail = $this->request->getData('email');
			$mypass = Security::hash($this->request->getData('password'), 'sha256', false);
			$mytoken = Security::hash(Security::randomBytes(32));

			$user->username = $myusername;
			$user->password = $hasher->hash($mypass);
			$user->token = $mytoken;
			$user->created = date('Y-m-d H:i:s');
			$user->modified = date('Y-m-d H:i:s');
			
			if($userTable->save($user)) {
				$userProfile->email = $myemail;
				$userProfile->first_name = $this->request->getData('first_name');
				$userProfile->last_name = $this->request->getData('last_name');
				$userProfile->middle_name = $this->request->getData('middle_name');
				$userProfile->suffix = $this->request->getData('suffix');
				$userProfile->gender = $this->request->getData('gender');
				$userProfile->created = date('Y-m-d H:i:s');
				$userProfile->modified = date('Y-m-d H:i:s');
				if($userProfileTable->save($userProfile)) {
					$this->Flash->set('Register Successful, your confirmation email has been sent', ['element' => 'success']);
					
					Email::configTransport('mailtrap', [
						'host' => 'smtp.mailtrap.io',
						'port' => 2525,
						'username' => '7198513de5519f',
						'password' => 'd14fb3fca0f037',
						'className' => 'Smtp'
					]);
					
					$email = new Email('default');
					$email->transport('mailtrap');
					$email->emailFormat('html');
					$email->from('quirjohnincoy.work@gmail.com', 'Quir John Incoy');
					$email->subject('Please confirm your email to activate your account');
					$email->to($myemail);
					$email->send('Hi '.$myusername. '</br>Please confirm your email link below</br><a href="http://local.cakephp/users/verification/'. $mytoken .'">Email Verification</a></br>Thank you');
				} else {
					$this->Flash->set('Register Failed in User Profile table, please try again', ['element' => 'error']);
				}
			} else {
				$this->Flash->set('Register Failed in User table, please try again', ['element' => 'error']);
			}
		}
	}
	
	public function verification($token) {
		$userTable = TableRegistry::get('Users');
		$verify = $userTable->find('all')->where(['token' => $token])->first();
		$verify->deleted = 1;
		$userTable->save($verify);
	}
	
	public function login() {
		if($this->request->is('post')) {
			$userTable = TableRegistry::get('Users');
			$user = $userTable->newEntity();

			$hasher = new DefaultPasswordHasher();
			$myname = $this->request->getData('name');
			$myemail = $this->request->getData('email');
			$mypass = Security::hash($this->request->getData('password'));

		}
	}
} */