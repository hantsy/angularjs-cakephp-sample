<?php

App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 * @property RequestHandlerComponent $RequestHandler
 */
class PostsController extends AppController {

    public $components = array('RequestHandler');

    public function index() {
        $posts = $this->Post->find('all');
        $this->set(array(
            'posts' => $posts,
            '_serialize' => array('posts')
        ));
    }

    public function view($id) {
        $post = $this->Post->findById($id);
        $this->set(array(
            'post' => $post,
            '_serialize' => array('post')
        ));
    }

    public function add() {
        //$this->Post->id = $id;
        if ($this->Post->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function edit($id) {
        $this->Post->id = $id;
        if ($this->Post->save($this->request->data)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

    public function delete($id) {
        if ($this->Post->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

}
