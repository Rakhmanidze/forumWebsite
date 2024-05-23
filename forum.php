<?php
session_start();

$isLoggedIn = false;

if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"] === "true")
  $isLoggedIn = true;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    >
    <link rel="icon" href="source/pawn.png" type="image/x-icon">
    <title>Chessko</title>
  </head>
  <body class="forum_page">
    <header>
      <div class="container">
        <div class="header_inner">
          <div class="header_logo">Chessko</div>
          <nav>
            <a href="index.html">Intro</a>
            <a href="profile.php">Profile</a>
            <a href="#l_forum">Forum</a>
            <a href="#l_rules">Site rules</a>
            <button id="log_out_btn" class="<?php if (!$isLoggedIn) echo "hidden"; ?>">Log out</button>
            <a id="navLogin" class="prevScroll <?php if ($isLoggedIn) echo "hidden"; ?>" href="#">Log in</a>
          </nav>
        </div>
      </div>
    </header>
    <div class="wholepage">
      <div class="container_join">
        <div id="l_forum" class="l_margin"></div>
        <h1 class="join">Join the Talk.</h1>
        <p class="textik">
          Explore the forum below and find answers to all of your questions
        </p>
      </div>
      <div class="formdiv">
        <div class="container">
          <div class="create_post">
            <div class="wrap__new_post">
              
              <?php if ($isLoggedIn): ?>

              <div class="container-button">
                <div class="hover bt-1"></div>
                <div class="hover bt-2"></div>
                <div class="hover bt-3"></div>
                <div class="hover bt-4"></div>
                <div class="hover bt-5"></div>
                <div class="hover bt-6"></div>
               
                <button class="newpost_btn"></button>
              </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="overlay" id="postOverlay"></div>
          <div class="modal" id="createPostModal">
            <div class="formbox create_post">
              <form action="create_post.php" id="createPostForm" class="form_body" method="post">
                <h2>New post</h2>
                <div class="input_box">
                  <label for="postTitle">Post Title:</label>
                  <input type="text" id="postTitle" name="postTitle" required maxlength="20">
                </div>
                <div class="input_box">
                  <label for="postContent">Post Content:</label>
                  <textarea
                    name="postContent"
                    id="postContent"
                    required
                    maxlength="200"
                  ></textarea>
                </div>               
                <button type="submit" class="login_btn">Create</button>
                <button class="close_btn" id="closePostModalBtn">Close</button>
              </form>
            </div>
          </div>
        </div>

        <div class="forum_content">
          <section class="forum_section" id="forum">
            <?php include "php/load_posts.php"; ?>
          </section>
        </div>
      </div>
      <div class="quote">
        <p class="qtext" id="firstquote">
          Chess is a path to endless improvement.
        </p>
        <p class="qtext" id="secondquote">
          Let us be your companion on this journey
        </p>
      </div>
      <section class="section">
        <div class="container">
          <div class="section_header">
            <div id="l_rules" class="l_margin"></div>
            <h2 id="site_rules" class="section_title">Site rules</h2>
          </div>
          <div class="rules">
            <div class="rules_item">
              <div class="rules_img">
                <img src="source/troll.jpg" alt="troll">
              </div>
              <div class="rules_text">No Trolling</div>
            </div>
            <div class="rules_item">
              <div class="rules_img">
                <img src="source/spam.jpg" alt="spam">
              </div>
              <div class="rules_text">No spamming</div>
            </div>
            <div class="rules_item">
              <div class="rules_img">
                <img src="source/respect.jpg" alt="respect">
              </div>
              <div class="rules_text">Respect each other</div>
            </div>
            <div class="rules_item">
              <div class="rules_img">
                <img src="source/copyright.jpg" alt="copyright">
              </div>
              <div class="rules_text">No spreading of copyrighted material</div>
            </div>
            <div class="rules_item">
              <div class="rules_img">
                <img src="source/advertise.jpg" alt="advertise">
              </div>
              <div class="rules_text">No advertising</div>
            </div>
            <div class="rules_item">
              <div class="rules_img">
                <img src="source/nice.jpg" alt="nice">
              </div>
              <div class="rules_text">Please be nice</div>
            </div>
          </div>
        </div>
      </section>

   
      <div class="overlay" id="overlay"></div>
      <div class="modal logmodal" id="registrationModal">
        <div class="formbox login">
          <form id="loginForm" enctype="multipart/form-data" action="php/login.php" method="post">
            <h2>Log in</h2>
            <div class="input_box" id="email_box">
              <span class="icon E_icon"></span>
              <input id="email_input" name="login_email" value="<?php echo isset($_GET['email_login']) ? htmlspecialchars($_GET['email_login']) : ''; ?>" type="email" required maxlength="30">
              <label for="email_input">Email*</label>
            </div>
            <p id="emailDoesntExistText" class="wrong_e _notext">
              Use your registered email
            </p>
            <p id="loginEmailDotText" class="wrong_e _notext">
              add dot
            </p>
            <div class="input_box">
              <span class="icon P_icon"></span>
              <input id="login_pass" name="login_PW" type="password"  required maxlength="20">
              <label for="login_pass">Password*</label>
            </div>
            <p class="incor_password" id="wrong_password">
              Wrong password
            </p>
            <p id="loginChars" class="wrong_e _notext">
              chars invalid
            </p>
            <span class="error_message text_margin">
               <?php
                echo isset($_GET['error_l']) ? htmlspecialchars($_GET['error_l']) : '';
                ?>
            </span>
            <button class="login_btn" type="submit">Log In</button>
            <div class="create_account">
              <p>
                Create an Account?
                <a href="#" class="register_link prevScroll">Sign up</a>
              </p>
            </div>
            <button class="close_btn">Close</button>
          </form>
        </div>

      
        <div class="formbox register">
          <form id="registrationForm" enctype="multipart/form-data" action="php/sign_up.php" method="post">
            <h2>Sign Up</h2>
            <div class="input_box" id="email_box2">
              <span class="icon E_icon"></span>
              <input id="sign_email"  name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required type="email" maxlength="30">
              <label for="sign_email">Email*</label>             
            </div>
            <p id="emailExistsText" class="wrong_e _notext">
              Email already in use
            </p>
            <p id="signupEmailDotText" class="wrong_e _notext">
              add dot
            </p>
            <div class="input_box" id="no_top">
              <span class="icon P_icon"></span>
              <input
                id="firstpassword"
                type="password"
                name="password" 
                required
                maxlength="20"
              >
              <label for="firstpassword">Password*</label>
            </div>
            <div id="email_box3" class="input_box">
              <span class="icon P_icon"></span>
              <input id="secondpassword" type="password" name="secondPassword" required maxlength="20">
              <label for="secondpassword">Confirm Password*</label>
            </div>
            <p class="incor_password" id="incor_password">
              Passwords are not the same
            </p>
            <p id="signChars" class="wrong_e _notext">
               chars invalid
            </p>
            <div class="input_box" id="noborder">
              <label for="file_input" class="attach">Add photo</label>
              <div class="file">
                <div class="file_item">
                  <input
                    id="file_input"
                    name="image"
                    accept=".jpg, .png"
                    type="file"
                    class="file_input"
                     
                  >
                  <div class="file_button">Choose</div>
                </div>
                <p id="img_error_text" class="img_error_text _notext">allowed only: png, jpg</p>
              </div>
            </div>
            <span class="error_message">
            <?php
                echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
                ?>
            </span>
            <button id="signUpBtn" type="submit" class="login_btn" name="signUpBtn">
              Sign up
            </button>
            <div class="create_account margin_b">
              <p>
                Already have an Account?
                <a href="#" class="login_link prevScroll">Log in</a>
              </p>
            </div>
            <button class="close_btn">Close</button>
          </form>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="container">
        <div class="copyright">© Made by R. Karymshakov</div>
      </div>
    </footer>
    <script src="js/signup_login.js"></script>
    <script src="js/create_post.js"></script>
  </body>
</html>