<?php
/**
 * Handles the update of an existing forum post.
 * Finds the post by postId, updates its data, and returns success or error messages.
 */

 session_start();
 include_once "User.php";
 include_once "Post.php";
 
 $jsonData = file_get_contents('php://input');
 $data = json_decode($jsonData);
 
 $postId = $data->postId;
 $postTitle = $data->postTitle;
 $postContent = $data->postContent;
 $userId = $_SESSION["userId"];
 $dateWithHour = date('Y-m-d H:i:s', strtotime('+1 hour'));
 
 try {
     $existingPosts = json_decode(file_get_contents('../data/posts.json'), true);
 
     // Find the post by postId
     $postIndex = -1;
     foreach ($existingPosts as $index => $post) {
         if ($post['postId'] == $postId) {
             $postIndex = $index;
             break;
         }
     }
 
     if ($postIndex !== -1) {
         // Update the post data
         $existingPosts[$postIndex]['title'] = $postTitle;
         $existingPosts[$postIndex]['content'] = $postContent;
         $existingPosts[$postIndex]['date'] = $dateWithHour;
 
         file_put_contents('../data/posts.json', json_encode($existingPosts));
         echo json_encode(['message' => 'Success', 'postData' => $existingPosts[$postIndex]]);
     } else {
         echo json_encode(['error' => 'Post not found']);
     }
 } catch (Exception $e) {
     echo json_encode(['error' => $e->getMessage()]);
     error_log('Error: ' . $e->getMessage(), 0);
 }
 ?>