const changeEmailform = document.getElementById("changeEmailform");
const newEmailInput = document.getElementById("newEmailInput");
const errorEmailText = document.getElementById("changeEmailExistsText");
const newEmailDotText = document.getElementById("changeEmailDotText");

/**
 * Handles the submission of the change email form, checking if the new email already exists.
 *
 * @param {Event} event - The form submission event.
 *
 * @return {Promise<void>} - A promise resolving to void.
 */
async function handleEmailChangeFormSubmission(event) {
  event.preventDefault();
  try {
    const newEmailhasDot = newEmailInput.value.includes(".");
    if (!newEmailhasDot) {
      newEmailDotText.classList.remove("_notext");
      return;
    } else {
      newEmailDotText.classList.add("_notext");
    }
    const userEmailExists = await emailExistsInJson(newEmailInput.value);
    if (!userEmailExists) {
      errorEmailText.classList.add("_notext");
      changeEmailform.submit();
    } else {
      errorEmailText.classList.remove("_notext");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

// Attach the event listener to the change email form
changeEmailform.addEventListener("submit", handleEmailChangeFormSubmission);
/**
 * Checks if the entered email already exists in the JSON data.
 *
 * @param {string} email - The email to be checked.
 *
 * @return {Promise<boolean>} - TRUE if the email exists, FALSE otherwise.
 */
async function emailExistsInJson(email) {
  return fetch("/~karymrak/php/find_email_res.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(email),
  })
    .then((response) => {
      if (!response.ok) throw new Error("email checking failed.");
      return response.json();
    })
    .catch((error) => {
      console.log(`Error during checking email: ${error}`);
      return false;
    });
}

/**
 * Opens the login window, adding necessary CSS classes and disabling navigation links.
 */
let currentPostId = null;

function openChangePostWindow(event) {
  currentPostId = event.currentTarget.getAttribute("postId");
  var postTitle = event.currentTarget.getAttribute("post_title");
  var postContent = event.currentTarget.getAttribute("post_content");

  document.querySelector('input[name="postTitle"]').value = postTitle;
  document.querySelector('textarea[name="postContent"]').value = postContent;
  document.getElementById("changePostOverlay").classList.add("_visible");
  document.getElementById("changePostModal").classList.add("_visible");
  disableNavLinks();
}

/**
 * Closes the login window, removing CSS classes and enabling navigation links.
 */
function closeChangePostWindow(event) {
  event.preventDefault();
  document.getElementById("changePostOverlay").classList.remove("_visible");
  document.getElementById("changePostModal").classList.remove("_visible");
  enableNavLinks();
}

/**
 * Disables navigation links by adding an event listener to prevent their default behavior.
 */
function disableNavLinks() {
  const navLinks = document.querySelectorAll("nav a");
  navLinks.forEach((link) => {
    link.addEventListener("click", preventNavigation);
  });
}

/**
 * Prevents the default navigation behavior of an event.
 *
 * @param {Event} event - The event to prevent default behavior for.
 */
function preventNavigation(event) {
  event.preventDefault();
}

/**
 * Enables navigation links by removing the event listener preventing their default behavior.
 */
function enableNavLinks() {
  const navLinks = document.querySelectorAll("nav a");
  navLinks.forEach((link) => {
    link.removeEventListener("click", preventNavigation);
  });
}

const CloseBtnss = document.querySelectorAll(".close_btn");
if (CloseBtnss) {
  CloseBtnss.forEach((button) => {
    button.addEventListener("click", closeChangePostWindow);
  });
}

addCLickToEditLinks();

/**
 * add click listener to all link for editing post and open window for changing post.
 */
function addCLickToEditLinks() {
  const changePostLinks = document.querySelectorAll(".changePostLink");

  if (changePostLinks) {
    changePostLinks.forEach((link) => {
      link.addEventListener("click", openChangePostWindow);
    });
  }
}

const changePostForms = document.querySelectorAll(".change_post_form");

changePostForms.forEach(function (form) {
  form.addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    const postId = currentPostId;
    const postTitle = formData.get("postTitle");
    const postContent = formData.get("postContent");

    const currentTime = new Date().toLocaleString();

    console.log("Data to be sent:", {
      postId,
      postTitle,
      postContent,
      currentTime,
    });

    try {
      const response = await fetch("/~karymrak/php/update_post.php", {
        method: this.method,
        body: JSON.stringify({
          postId,
          postTitle,
          postContent,
          currentTime,
        }),
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (!response.ok) {
        throw new Error(
          `Network response was not ok, status: ${response.status}`
        );
      }

      const data = await response.json();

      console.log("Server response:", data);

      if (data.message === "Success") {
        console.log("Post successfully updated:", data.postData);

        document
          .getElementById("changePostOverlay")
          .classList.remove("_visible");
        document.getElementById("changePostModal").classList.remove("_visible");
        enableNavLinks();
        let result = await loadPosts();
        if (result) {
          addCLickToEditLinks();
        }
      } else {
        console.error("Error:", data.error);
      }
    } catch (error) {
      console.error("Error:", error.message);
    }
  });
});

/**
 * Loads posts from the server and updates the content of the "forum" container.
 *
 * @return {boolean} - Returns nothing.
 */
async function loadPosts() {
  return fetch("/~karymrak/php/load_user_posts.php")
    .then((response) => response.text())
    .then((html) => {
      document.getElementById("forum").innerHTML = html;
      return true;
    })
    .catch((error) => {
      console.error("Error loading posts:", error);
      return false;
    });
}

const closeChangePostBtn = document.getElementById("closeChangePostModalBtn");

if (closeChangePostBtn) {
  closeChangePostBtn.onclick = function (event) {
    closeChangePostWindow(event);
  };
}
