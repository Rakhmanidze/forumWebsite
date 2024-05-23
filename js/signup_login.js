/**
 * Removes the anchor from the URL after the page loads.
 * If there is a hash in the URL, it replaces the current URL excluding the hash.
 *
 * @return {void} - Returns nothing.
 */
if (window.location.hash) {
  window.location.href = window.location.href.split("#")[0];
}

/**
 * Fixes the issue where the webpage scrolls up after clicking on links with class 'prevScroll'.
 *
 * - Selects all elements with the class 'prevScroll'.
 * - Listens for a click on each element and prevents the default anchor behavior.
 *
 * @return {void} - Returns nothing.
 */
var allprevScroll = document.querySelectorAll(".prevScroll");

allprevScroll.forEach(function (link) {
  link.addEventListener("click", function (event) {
    event.preventDefault();
  });
});

/**
 * Opens the login window, adding necessary CSS classes and disabling navigation links.
 */
function openLogInWindow() {
  document.getElementById("overlay").classList.add("_visible");
  document.getElementById("registrationModal").classList.add("_visible");
  document.body.classList.add("_noscroll");
  disableNavLinks();
}

/**
 * Closes the login window, removing CSS classes and enabling navigation links.
 */
function closeLogInWindow() {
  document.getElementById("overlay").classList.remove("_visible");
  document.getElementById("registrationModal").classList.remove("_visible");
  document.body.classList.remove("_noscroll");
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
 * Enables navigation links by removing the event listener preventing their default behavior.
 */
function enableNavLinks() {
  const navLinks = document.querySelectorAll("nav a");
  navLinks.forEach((link) => {
    link.removeEventListener("click", preventNavigation);
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

const CloseBtnss = document.querySelectorAll(".close_btn");
if (CloseBtnss) {
  CloseBtnss.forEach((button) => {
    button.addEventListener("click", closeLogInWindow);
  });
}

// When clicked, open the login window
const navLogin = document.getElementById("navLogin");
if (navLogin) {
  navLogin.addEventListener("click", openLogInWindow);
}

// Validate data ----
// // listen changes in file_input
const fileInput = document.getElementById("file_input");
const fileErrorText = document.getElementById("img_error_text");
let isFileValid = true;
fileInput.addEventListener("change", async () => {
  isFileValid = await uploadFile(fileInput.files[0]);
});

/**
 * Checks if the provided file is a valid image (JPEG or PNG).
 *
 * @param {File} file - The file to be validated.
 *
 * @return {Promise<boolean>} - TRUE if the file is valid, FALSE otherwise.
 */
async function uploadFile(file) {
  if (!["image/jpeg", "image/png"].includes(file.type)) {
    fileErrorText.classList.remove("_notext");
    fileInput.value = "";
    return false;
  } else {
    fileErrorText.classList.add("_notext");
    return true;
  }
}

// show email exists text
const signEmailInput = document.getElementById("sign_email");
const emailExistsText = document.getElementById("emailExistsText");

signEmailInput.addEventListener("input", async function () {
  const email = signEmailInput.value;
  const emailExists = await emailExistsInJson(email);

  if (emailExists) {
    emailExistsText.classList.remove("_notext");
  } else {
    emailExistsText.classList.add("_notext");
  }
});

// show text that password arent the same
const registrationForm = document.getElementById("registrationForm");
const firstPW = document.getElementById("firstpassword");
const secondPW = document.getElementById("secondpassword");
const notTheSamePWText = document.getElementById("incor_password");
const EmailDotErrorText = document.getElementById("signupEmailDotText");

secondPW.addEventListener("input", checkPasswordMatch);
/**
 * Checks if the entered passwords match and updates the visibility of a text element accordingly.
 */
function checkPasswordMatch() {
  if (firstPW.value !== secondPW.value) {
    notTheSamePWText.classList.add("_seetext");
  } else {
    notTheSamePWText.classList.remove("_seetext");
  }
  if (secondPW.value === "") {
    notTheSamePWText.classList.remove("_seetext");
  }
}

if (registrationForm) {
  registrationForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    const email = signEmailInput.value;
    const PWCharsError = document.getElementById("signChars");
    const isFirstPWValid = validateChars(firstPW, PWCharsError);
    const isSecondPWValid = validateChars(secondPW, PWCharsError);

    const emailExists = await emailExistsInJson(email);

    const hasDot = email.includes(".");

    if (!hasDot) {
      EmailDotErrorText.classList.remove("_notext");
      return;
    } else {
      EmailDotErrorText.classList.add("_notext");
    }

    if (
      !isFirstPWValid ||
      !isSecondPWValid ||
      firstPW.value !== secondPW.value ||
      !isFileValid ||
      emailExists ||
      !hasDot
    ) {
      return;
    }

    registrationForm.submit();
  });
} // -----

/**
 * Validates input characters against a regular expression and updates the visibility of an error message accordingly.
 *
 * @param {HTMLInputElement} Input - The input element to validate.
 * @param {HTMLElement} charsErrorMessage - The error message element.
 *
 * @return {boolean} - TRUE if the input characters match the allowed pattern, FALSE otherwise.
 */
function validateChars(Input, charsErrorMessage) {
  let inputValue = Input.value,
    allowedChars = /^[a-zA-Z0-9_]+$/;
  let validationResult = allowedChars.test(inputValue);
  if (validationResult) {
    charsErrorMessage.classList.add("_notext");
  } else {
    charsErrorMessage.classList.remove("_notext");
  }
  return validationResult;
}

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

//validate login data ----
const loginEmailInput = document.getElementById("email_input");
const emailDoesntExistText = document.getElementById("emailDoesntExistText");
const loginEmailDotText = document.getElementById("loginEmailDotText");
const loginPW = document.getElementById("login_pass");
const wrongLoginPW = document.getElementById("wrong_password");
// check email
loginEmailInput.addEventListener("input", async function () {
  const email = loginEmailInput.value;
  const emailExists = await emailExistsInJson(email);

  if (!emailExists) {
    emailDoesntExistText.classList.remove("_notext");
  } else {
    emailDoesntExistText.classList.add("_notext");
  }
});

// check password
let isPasswordCorrect = false;
loginPW.addEventListener("input", async function () {
  isPasswordCorrect = await verifyLoginPassword();
});

/**
 * Checks if the entered password matches the one associated with the email in the JSON data.
 *
 * @return {Promise<boolean>} - TRUE if the password is correct, FALSE otherwise.
 */
async function verifyLoginPassword() {
  const enteredPassword = loginPW.value;
  const enteredEmail = loginEmailInput.value;

  let verificationResult = await verifyLoginPasswordInJson(
    enteredEmail,
    enteredPassword
  );
  console.log(verificationResult);
  if (verificationResult) {
    wrongLoginPW.classList.remove("_seetext");
  } else {
    wrongLoginPW.classList.add("_seetext");
  }

  return verificationResult;
}

/**
 * Verifies user login password by sending a request to the server-side verification endpoint.
 *
 * @param {string} email - User's email for identification.
 * @param {string} password - User's password to verify.
 *
 * @return {Promise<boolean>} - A promise that resolves to TRUE if the password is verified, FALSE otherwise.
 */
async function verifyLoginPasswordInJson(email, password) {
  return fetch("/~karymrak/php/verify_pw_res.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      email: email,
      password: password,
    }),
  })
    .then((response) => {
      if (!response.ok) throw new Error("Password verifying failed.");
      return response.json();
    })
    .catch((error) => {
      console.log(`Error during verifying the password: ${error}`);
      return false;
    });
}

// log in listener
const loginForm = document.getElementById("loginForm");
if (loginForm) {
  loginForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    const LogPW = document.getElementById("login_pass");
    const loginPWCharsError = document.getElementById("loginChars");
    const isloginPWValid = validateChars(LogPW, loginPWCharsError);

    const loginEmailhasDot = loginEmailInput.value.includes(".");
    if (!loginEmailhasDot) {
      loginEmailDotText.classList.remove("_notext");
      return;
    } else {
      loginEmailDotText.classList.add("_notext");
    }
    try {
      // Check if the email already exists in the JSON file
      const userEmailExists = await emailExistsInJson(loginEmailInput.value);

      if (userEmailExists && isloginPWValid && isPasswordCorrect) {
        closeLogInWindow();
        loginForm.submit();
      }
    } catch (error) {
      console.error("Error:", error);
    }
  });
} //----

//switching from log in to sign up and back
const loginr = document.querySelector(".logmodal");
const loginlink = document.querySelector(".login_link");
const registerlink = document.querySelector(".register_link");
if (registerlink && loginlink) {
  registerlink.addEventListener("click", () => {
    loginr.classList.add("active");
  });
  loginlink.addEventListener("click", () => {
    loginr.classList.remove("active");
  });
}

// logout
const logOutBtn = document.getElementById("log_out_btn");
logOutBtn.addEventListener("click", async function () {
  let result = await logout();
  if (result) location.href = "/~karymrak/forum.php";
});

/**
 * Initiates the user logout process by making a request to the server-side logout endpoint.
 *
 * @return {Promise<boolean>} - A promise that resolves to TRUE if the logout is successful, FALSE otherwise.
 */
async function logout() {
  return fetch("/~karymrak/php/logout.php", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => {
      if (!response.ok) throw new Error("Logout failed");
      return response.json();
    })
    .catch((error) => {
      console.log(`Error during logout: ${error}`);
      return false;
    });
}
