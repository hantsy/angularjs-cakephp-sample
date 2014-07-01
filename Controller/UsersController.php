<?php

App::uses('AppController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
		
        $this->Auth->allow('add', 'login'); 
    }

    public function login() {
        if ($this->Auth->user()) {
            $this->set(array(
                'message' => array(
                    'text' => __('You are logged in!'),
                    'type' => 'error'
                ),
                '_serialize' => array('message')
            ));
        }
//        $username = env('PHP_AUTH_USER');
//        $pass = env('PHP_AUTH_PW');

        //echo "userpass",  $username, $pass;
        if ($this->request->is('get')) {
            if ($this->Auth->login()) {
                // return $this->redirect($this->Auth->redirect());
                $this->set(array(
                    'user' => $this->Auth->user(),
                    '_serialize' => array('user')
                ));
                // $this->response->send();
            } else {

                $this->set(array(
                    'message' => array(
                        'text' => __('Invalid username or password, try again'),
                        'type' => 'error'
                    ),
                    '_serialize' => array('message')
                ));
                $this->response->statusCode(401);
                // $this->response->send();
            }
        }
        //$this->Session->setFlash(__('Invalid username or password, try again'));
    }

    public function logout() {
        if ($this->Auth->logout()) {
            $this->set(array(
                'message' => array(
                    'text' => __('Logout successfully'),
                    'type' => 'info'
                ),
                '_serialize' => array('message')
            ));
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->set(array(
                    'message' => array(
                        'text' => __('Registered successfully'),
                        'type' => 'info'
                    ),
                    '_serialize' => array('message')
                ));
            } else {
                $this->set(array(
                    'message' => array(
                        'text' => __('The user could not be saved. Please, try again.'),
                        'type' => 'error'
                    ),
                    '_serialize' => array('message')
                ));
                $this->response->statusCode(400);
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
//    public function edit($id = null) {
//        if (!$this->User->exists($id)) {
//            throw new NotFoundException(__('Invalid user'));
//        }
//        if ($this->request->is(array('post', 'put'))) {
//            if ($this->User->save($this->request->data)) {
//                $this->Session->setFlash(__('The user has been saved.'));
//                return $this->redirect(array('action' => 'index'));
//            } else {
//                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
//            }
//        } else {
//            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
//            $this->request->data = $this->User->find('first', $options);
//        }
//    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
//    public function delete($id = null) {
//        $this->User->id = $id;
//        if (!$this->User->exists()) {
//            throw new NotFoundException(__('Invalid user'));
//        }
//        $this->request->onlyAllow('post', 'delete');
//        if ($this->User->delete()) {
//            $this->Session->setFlash(__('The user has been deleted.'));
//        } else {
//            $this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
//        }
//        return $this->redirect(array('action' => 'index'));
//    }

}
