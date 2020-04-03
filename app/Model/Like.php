<?php
App::uses('AppModel', 'Model');

class Like extends AppModel {
    public $actsAs = ['Containable'];
    public $belongsTo = ['Post', 'User'];
}