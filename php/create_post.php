<?php

/**
 * Handles the creation of a new forum post.
 * Saves the post data to the JSON file and returns success or error messages.
 */

session_start();
include_once "User.php";
include_once "Post.php";

/**
 * Generates a unique postId based on existing post data.
 *
 * @param array $postsData - The array of existing posts.
 *
 * @return int - The generated unique postId.
 */
function generateUniquePostId($postsData) {
    $postId = 1;
    if (count($postsData) != 0) {
        $postId = $postsData[count($postsData) - 1]['postId'] + 1;
    }
    return $postId;
}

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData);

$postTitle = $data->postTitle;
$postContent = $data->postContent;
$userId = $_SESSION["userId"];
$dateWithHour = date('Y-m-d H:i:s', strtotime('+1 hour'));

try {
    $userEmail = $_SESSION['email'];

    $existingPosts = json_decode(file_get_contents('../data/posts.json'), true);

    $postId = generateUniquePostId($existingPosts);

    $postData = new Post(
        $postTitle,
        $postContent,
        $userEmail,
        $dateWithHour,
        $userId,
        $postId
    );



    $existingPosts[] = array(
        'title' => $postData->title,
        'content' => $postData->content,
        'date' => $postData->date,
        'id' => $postData->id,
        'postId' => $postData ->postId 
    );

    file_put_contents('../data/posts.json', json_encode($existingPosts));
    echo json_encode(['message' => 'Success', 'postData' => $postData]);
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
  error_log('Error: ' . $e->getMessage(), 0);
}