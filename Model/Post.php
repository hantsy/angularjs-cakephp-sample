<?php

App::uses('AppModel', 'Model');

/**
 * Post Model
 *
 */
class Post extends AppModel {

    public $belongsTo = array('User');

    public function isOwnedBy($post, $user) {
        return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
    }

}
