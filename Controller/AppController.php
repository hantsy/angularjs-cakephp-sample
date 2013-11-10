<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('Auth', 'Session');

    public function beforeFilter() {
        $this->Auth->authorize = array('Controller');
        $this->Auth->authenticate = array(
            'all' => array(
                //'scope' => array('User.is_active' => 1)
            ),
            'Basic'
        );

        $this->Auth->allow('index', 'view');
    }

    public function isAuthorized($user) {
        if (isset($user['role']) && ($user['role'] != 'admin')) {
            return false;
        }
        return true;
    }

}
