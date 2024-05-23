/*
 * Handles the functionality of creating a new forum post.
 *
 * - Listens for a click on the 'create new post' button.
 * - Displays the create post modal and overlay.
 * - Listens for a click on the close button of the create post modal.
 * - Listens for a form submission on the create post form.
 * - Sends a POST request to the server to create a new post.
 * - Logs relevant data and handles success or error responses.
 * - Reloads posts after successful post creation.
 *
 * @return {void} - Returns nothing.
 */
const createPostBtn = document.querySelector(".container-button");
const postOverlay = document.getElementById("postOverlay");
const createPostModal = document.getElementById("createPostModal");
const closePostModalBtn = document.getElementById("closePostModalBtn");
const createPostForm = document.getElementById("createPostForm");

const inputTitle = document.getElementById("postTitle");
const inputContent = document.getElementById("postContent");

// Listening for a click on the 'create new post' button
if (createPostBtn) {
  createPostBtn.addEventListener("click", function () {
    postOverlay.classList.add("_visible");
    createPostModal.classList.add("_visible");
  });
}

closePostModalBtn.addEventListener("click", function () {
  postOverlay.classList.remove("_visible");
  createPostModal.classList.remove("_visible");
});

createPostForm.addEventListener("submit", function (event) {
  event.preventDefault();

  var formData = new FormData(this);

  console.log("Data to be sent:", {
    postTitle: formData.get("postTitle"),
    postContent: formData.get("postContent"),
  });

  fetch("/~karymrak/php/create_post.php", {
    method: this.method,
    body: JSON.stringify({
      postTitle: formData.get("postTitle"),
      postContent: formData.get("postContent"),
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(
          `Network response was not ok, status: ${response.status}`
        );
      }
      return response.json();
    })
    .then((data) => {
      console.log("Server response:", data);
      if (data.message === "Success") {
        console.log("Post successfully saved:", data.postData);

        postOverlay.classList.remove("_visible");
        createPostModal.classList.remove("_visible");
        inputTitle.value = null;
        inputContent.value = null;
        loadPosts();
      } else {
        console.error("Error:", data.error);
      }
    })
    .catch((error) => {
      console.error("Error:", error.message);
    });
});

/*
 * Loads posts from the server and updates the content of the "forum" container.
 *
 * @return {void} - Returns nothing.
 */
function loadPosts() {
  fetch("/~karymrak/php/load_posts.php")
    .then((response) => response.text())
    .then((html) => {
      document.getElementById("forum").innerHTML = html;
    })
    .catch((error) => {
      console.error("Error loading posts:", error);
    });
}
