<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialNetwork</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="https://kit.fontawesome.com/11c4571db7.js" crossorigin="anonymous"></script>
    <template id="post-template">
    <article class="post-container" data-post-id="">
                    <div class="user-profile">
                        <img src="images/profile-pic.jpg">
                        <div>
                            <p>Jane Doe</p>
                            <span></span>
                        </div>
                    </div>
                    
                    <p class="post-text"></p>
                    <img src="" class="post-img">

                    <div class="activity-icons">
                        <div><i class="fa-regular fa-heart heart-icon"></i> <span>0</span></div>
                        <div><i class="fa-regular fa-comments comment-icon"></i><span>0</span></div>
                        <div><i class="fa-regular fa-bookmark bookmark-icon"></i><span>0</span></div>
                    </div>
                    <div class="comment-input-container" style="display: none;">
                        <div class="user-profile">
                            <img src="images/profile-pic.jpg">
                            <p>Jane Doe</p>
                        </div>
                        <input type="text" class="comment-input" placeholder="Add a comment...">
                        <span class="error-message"></span>
                        <button type="submit" class="add-comment-button">Post</button>

                        <div class="comment-feed">
                            <article class="comment-container" data-comment-id="">
                                <div class="user-profile">
                                    <img src="">
                                    <p></p>
                                </div>
                                <p class="comment-text"></p>
                            </article>
                        </div>
                    </div>
                </article>
    </template>
</head>
<body>
    <nav>
        <h1>SocialNetwork</h1>
    </nav>

    <div class="container">

        <!-- sidebar -->
        <div class="sidebar">
            <?php 
                require_once("php/Post.php");
                echo(generateUserInfoHtml());
            ?>
        </div>
        <!-- main-content -->
        <div class="main-content">

            <div class="write-post-container">
                <div class="user-profile">
                    <img src="images/profile-pic.jpg">
                    <div>
                        <p>Jane Doe</p>
                    </div>
                </div>

                <div class="post-input-container">
                    <textarea rows="3" placeholder="What's on your mind?"></textarea> 
                    <span class="error-message"></span>
                    <a href="#"><i class="fa-sharp fa-regular fa-images"></i>Photo/Video</a>
                    <input type="text" style="display: none;" placeholder="e.g. images/random-1.jpg">
                    <span class="error-message"></span>
                </div>
                <button type="submit" id="add-post-button">Post</button>
            </div>
            <div id="posts-feed">
                <?php 
                require_once("php/Post.php");
                echo(generatePostsHtml());
                ?>
            </div>

            
        </div>

        
    </div>

    <div class="footer">
        <p>Copyright 2023 - Ivana Govorusic - PZI FESB</p>
    </div>
    <script src="scripts/script.js"></script>
    
</body>
</html>
