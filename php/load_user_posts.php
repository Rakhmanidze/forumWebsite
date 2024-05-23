<?php

/**
 * Displays posts for a specific user from the JSON file.
 */

if (!isset($_SESSION)) {
    session_start();
}

include_once "User.php";
include_once "Post.php";

/**
 * Finds a user by their ID in the given array of users.
 *
 * @param int $userId - User's ID.
 * @param array $usersData - The array of users to search in.
 *
 * @return array|null - The user data if found, or null if not found.
 */
function findUserById($userId, $usersData) {
    foreach ($usersData as $user) {
        if ($user['id'] == $userId) {
            return $user;
        }
    }
    return null;
}

try {
    $postsData = json_decode(file_get_contents('/home/karymrak/www//data/posts.json'), true);

    $usersData = json_decode(file_get_contents('/home/karymrak/www//data/sign_up.json'), true);

    $userEmail = $_SESSION['email'];

    $user = findUserByEmail($userEmail, $usersData);

    if (!$user) {
        throw new Exception("User not found.");
    }

    $userPosts = array_filter($postsData, function ($postData) use ($user) {
        return $postData['id'] == $user['id'];
    });

    foreach ($userPosts as $postData) {
        $userId = $postData['id'];
        $user = findUserById($userId, $usersData);
        $postId = $postData['postId'];
        $post = new Post(
            $postData['title'],
            $postData['content'],
            $user['email'],
            $postData['date'],
            $userId,
            $postId
        );

        echo '<div class="post_area">';
        echo '<div class="p_description post_column">';
        echo '<p class="link_post">Title: ' . htmlspecialchars($post->title) . '</p>';
        echo '<p  class="post_content">Post\'s content: ' . htmlspecialchars($post->content) . '</p>';
        echo '</div>';
        echo '<div class="post_info post_column">';
        echo 'Posted by ' . htmlspecialchars($post->userEmail) . '<br>last changes: <small><br>' . $post->date . '</small>';
        echo '<br><a href="#" class="changePostLink" postId="' . htmlspecialchars($postData['postId']) . '" post_title="' . htmlspecialchars($post->title) . '" post_content="' . htmlspecialchars($post->content) . '">Edit Post</a>';
        echo '</div>';
        echo '</div>';
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);

    error_log('Error: ' . $e->getMessage(), 0);
}

/**
 * Finds a user by their email in the given array of users.
 *
 * @param string $userEmail - User's email.
 * @param array $usersData - The array of users to search in.
 *
 * @return array|null - The user data if found, or null if not found.
 */

function findUserByEmail($userEmail, $usersData) {
    foreach ($usersData as $user) {
        if ($user['email'] == $userEmail) {
            return $user;
        }
    }
    return null;
}
