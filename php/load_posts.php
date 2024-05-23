<?php

/*
 * Displays posts from the JSON file with pagination.
 */

include_once "User.php";
include_once "Post.php";

try {
    $postsData = json_decode(file_get_contents('/home/karymrak/www/data/posts.json'), true);

    $usersData = json_decode(file_get_contents('/home/karymrak/www/data/sign_up.json'), true);

    $postsPerPage = 3;

    $totalPages = ceil(count($postsData) / $postsPerPage);

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    if ($currentPage == 0) {
        $currentPage = 1;
    } else if ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $startIndex = ($currentPage - 1) * $postsPerPage;

    $currentPage = max(min($currentPage, $totalPages), 1);

    $currentPosts = array_slice($postsData, $startIndex, $postsPerPage);

    echo '<div class="allposts">All posts:</div>';

    foreach ($currentPosts as $postData) {
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
        echo '<h3>Title: ' . htmlspecialchars($post->title) . '</h3>';
        echo '<p class="link_post">Post\'s content: ' . htmlspecialchars($post->content) . '</p>';
        echo '</div>';
        echo '<div class="post_info post_column">';
        echo 'Posted by ' . htmlspecialchars($post->userEmail) . '<br>last changes: <small><br>' . htmlspecialchars($post->date) . '</small>';
        echo '</div>';
        echo '</div>';
    }

    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = $i == $currentPage ? 'active' : '';
        echo '<a href="?page=' . $i . '" class="' . $activeClass . '">' . $i . '</a>';
    }
    echo '</div>';


} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);

    error_log('Error: ' . $e->getMessage(), 0);
}

/*
 * Finds a user by their ID in the given array of users.
 *
 * @param int $userId - User's ID.
 * @param array $usersData - The array of users to search in.
 *
 * @return array|null - The user data if found, or null if not found.
 */

function findUserById($userId, $usersData)
{
    foreach ($usersData as $user) {
        if ($user['id'] == $userId) {
            return $user;
        }
    }
    return null;
}
?>