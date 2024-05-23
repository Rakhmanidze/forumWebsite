<?php
session_start();
if (!isset($_SESSION["isLoggedIn"]))
    header("Location: /~karymrak/forum.php");
$userEmail = $_SESSION['email'];
$imagePath = "/~karymrak/data/user_img/user.jpg";
if (strlen($_SESSION["nameOfPhoto"]) > 0)
    $imagePath = "/~karymrak/data/user_img/" . $_SESSION["nameOfPhoto"];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
      href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet">
    <link rel="icon" href="source/pawn.png" type="image/x-icon">
    <title>Chessko</title>
  </head>
  <body class="profile_page">
    <header>
      <div class="container">
        <div class="header_inner">
          <div class="header_logo">Chessko</div>
          <nav>
            <a href="forum.php">Forum</a>
          </nav>
        </div>
      </div>
    </header>
    <div class="prof_cont">
      <div class="card">
        <div class="u_log">Your info:</div>
        <div class="row">
          <div class="photo_cont">
            <img src="<?php echo $imagePath ?>" alt="user_image" class="u_photo">
          </div>
          <div class="u_info">
            <div class="tab">
              <div class="profile">
                <div class="line">
                  <div class="u_email">Email:</div>
                  <div class="cur_email"><?php echo $userEmail; ?></div>
                </div>
                <div class="line">
                  <div class="u_email">  Edit your email:</div>
                  <div class="cur_email">
                  <form id="changeEmailform" enctype="multipart/form-data" action="php/change_email.php" method="post">
                    <div class="input-group">
                      <label class="change_label" for="newEmailInput">New</label>
                      <input autocomplete="off" name="change_email" id="newEmailInput" class="change_input" type="email" required maxlength="30">
                      <button id="change_email_btn" class="main_btn" type="submit">
                            change
                      </button>
                      <p id="changeEmailExistsText" class="wrong_e _notext" >
                        choose other email
                      </p>
                      <p id="changeEmailDotText" class="wrong_e _notext" >
                        add dot
                      </p>
                    </div>
                  </form>
                  </div>
                </div>
                <div class="line">
                    <p>Your posts:</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="user_posts">
          <div class="formdiv_profile">
            <div class="forum_content">
              <section class="forum_section" id="forum">
                <?php include "/home/karymrak/www/php/load_user_posts.php"; ?>
              </section>
            </div>
        </div>
      </div>
      <div class="overlay" id="changePostOverlay"></div>
          <div class="modal" id="changePostModal">
            <div class="formbox create_post">
              <form class="form_body change_post_form" method="post">
                <h2>Change post</h2>
                <div class="input_box">
                  <label for="postTitle">Post Title:</label>
                  <input type="text" id="postTitle" name="postTitle" required maxlength="20"/>
                </div>
                <div class="input_box">
                  <label for="postContent">Post Content:</label>
                  <textarea
                    id="postContent"
                    name="postContent"
                    maxlength="200"
                    required
                  ></textarea>
                </div>               
                <button type="submit" class="login_btn">Change</button>
                <button class="close_btn" id="closeChangePostModalBtn">Close</button>
              </form>
            </div>
          </div>
    </div>
    <script src="js/profile.js"></script>
  </body>
</html>
