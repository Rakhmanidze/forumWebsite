<?php

/**
 * Class Post
 * Represents a forum post with basic information.
 * 
 * @property string $title       - Post title.
 * @property string $content     - Post content.
 * @property string $userEmail   - Email of the user who created the post.
 * @property string $date        - Date when the post was created.
 * @property int    $id          - User's ID.
 * @property int    $postId      - Post's ID.
 */

class Post {
  public $title;
  public $content;
  public $userEmail;
  public $date;
  public $id;
  public $postId;

  /**
     * Post constructor.
     *
     * @param string $title     - Post title.
     * @param string $content   - Post content.
     * @param string $userEmail - Email of the user who created the post.
     * @param string $date      - Date when the post was created.
     * @param int    $id        - User's ID.
     * @param int    $postId    - Post's ID.
     */
    
  public function __construct( $title, $content, $userEmail, $date, $id, $postId) {
      $this->title = $title;
      $this->content = $content;
      $this->userEmail = $userEmail;
      $this->date = $date;
      $this->id = $id;
      $this ->postId = $postId;
  }
}