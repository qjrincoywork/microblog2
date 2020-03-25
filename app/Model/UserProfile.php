<?php
App::uses('AppModel', 'Model');

class UserProfile extends AppModel {
    public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A email is required'
            )
        ),
        'first_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A first name is required'
            )
        ),
        'last_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'A last name is required'
            )
        )/* ,
        'gender' => array(
            'required' => array(
                'message' => 'A gender is required'
            )
        ) */
    );

    /* public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    } */
}