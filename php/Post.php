<?php
require_once("DatabaseAccess.php");

function getPostsFromDb(){
    // execute query and get posts data from the Posts table in the database
	 return getDbAccess()->executeQuery("SELECT * FROM Posts ORDER BY PostID DESC;");
}

function getCommentsFromDb($postID){
    return getDbAccess()->executeQuery("SELECT * FROM Comments WHERE PostID = $postID ORDER BY CommentID DESC;");
}

function getUserFromDb($userName){
    return getDbAccess()->executeQuery("SELECT UserID, UserName, UserImgUrl, UserLocation, MyLikes, MyBookmarks FROM Users WHERE UserName = '$userName';");
}

// generate html code for posts using data from the database
function generatePostsHtml(){
    $html = "";  

    $posts = getPostsFromDb(); //dohvatili kartice iz baze

    $userImgUrl = 'images/profile-pic.jpg';
    $userName = 'Jane Doe';

    foreach($posts as $post){
        // prolazimo kroz niz postova koji smo dohvatili iz baze, u nizu su spremljeni stupci te tablice(id, title...)
        // get values of the columns in the table in order 
        $postID = $post[0];
        $userID = $post[1];
        $postText = $post[2];
        $postImgUrl = $post[3];
        $isLiked = $post[4];
        $isBookmarked = $post[5];
        $totalLikes = $post[6];
        $totalBookmarks = $post[7];
        $totalComments = $post[8];
        $dateTime = $post[9];

        $heartClass = $isLiked == '1' ? "fa-solid" : "fa-regular"; // odrazava se stanje u bazi na srcima
        $bookmarkClass = $isBookmarked == '1' ? "fa-solid" : "fa-regular";

        // ovo je onaj template ko iz vjezbi, slicno samo sta tamo di umecemo varijable to radimo s $ 
        // html template filled with data
        $html .= "<article class='post-container' data-post-id='$postID'>
                    <div class='user-profile'>
                        <img src='$userImgUrl'>
                        <div>
                            <p>$userName</p>
                            <span>$dateTime</span>
                        </div>
                    </div>
                  
                  <p class='post-text'>$postText</p>
                  <img src='$postImgUrl' class='post-img'>

                  <div class='activity-icons'>
                      <div><i class='$heartClass fa-heart heart-icon'></i><span>$totalLikes</span></div>
                      <div><i class='fa-regular fa-comments comment-icon'></i><span>$totalComments</span></div>
                      <div><i class='$bookmarkClass fa-bookmark bookmark-icon'></i><span>$totalBookmarks</span></div>
                  </div>
                  <div class='comment-input-container' style='display: none;'>
                      <div class='user-profile'>
                          <img src='$userImgUrl'>
                          <p>$userName</p>
                      </div>
                      <input type='text' class='comment-input' placeholder='Add a comment...'>
                      <span class='error-message'></span>
                      <button type='submit' class='add-comment-button'>Post</button>
                      <div class='comment-feed'>
              ";

        $comments = getCommentsFromDb($postID);

        foreach($comments as $comment){
            $commentID=$comment[0];
            $commentText=$comment[3];
            $commentDateTime=$comment[4];
            
            $html .= "<article class='comment-container' data-comment-id='$commentID'>
                            <div class='user-profile'>
                                <img src='$userImgUrl'>
                                <div>
                                    <p>$userName</p>
                                    <span>$commentDateTime</span>
                                </div>
                            </div>
                            <p class='comment-text'>$commentText</p>
                        </article>";
        }

        $html .= "</div> </div> </article>";
                  
    }

    return $html;
}

function generateUserInfoHtml(){
    $html = ""; 
    $user = getUserFromDb('Jane Doe');

    $userID = $user[0][0];
    $userName = $user[0][1];
    $userImgUrl = $user[0][2];
    $userLocation = $user[0][3];
    $myLikes = $user[0][4];
    $myBookmarks = $user[0][5];

    $html .= "
    <img src='$userImgUrl'>
    <h4 data-user-id='$userID' id='username'>$userName</h4>
    <p><i class='fa-sharp fa-solid fa-location-dot'></i> $userLocation</p>
    
    <div class='counter-container'>
        <div class='counter like-counter'>
            <h3>$myLikes</h3>
            <span>Likes</span>
        </div>
        <div class='counter bookmark-counter'>
            <h3>$myBookmarks</h3>
            <span>Bookmarks</span>
        </div>
    </div>";

    return $html;
}

function togglePostLike($postID, $isLiked){
    getDbAccess()->executeQuery("UPDATE Posts SET isLiked='$isLiked' WHERE PostID='$postID' ");
}

function togglePostBookmark($postID, $isBookmarked){
    getDbAccess()->executeQuery("UPDATE Posts SET isBookmarked='$isBookmarked' WHERE PostID = '$postID' ");
}

function increaseTotalLikes($postID){
    getDbAccess()->executeQuery("UPDATE Posts SET TotalLikes = TotalLikes+1 WHERE PostID = '$postID' ");
}

function decreaseTotalLikes($postID){
    getDbAccess()->executeQuery("UPDATE Posts SET TotalLikes = TotalLikes-1  WHERE PostID = '$postID' ");
}
function increaseTotalBookmarks($postID){
    getDbAccess()->executeQuery("UPDATE Posts SET TotalBookmarks = TotalBookmarks+1 WHERE PostID = '$postID' ");
}

function decreaseTotalBookmarks($postID){
    getDbAccess()->executeQuery("UPDATE Posts SET TotalBookmarks = TotalBookmarks-1  WHERE PostID = '$postID' ");
}

function addPost($PostText,$PostImgUrl,$DateTime){
    getDbAccess()->executeQuery("INSERT INTO 
    Posts(UserID,PostText,PostImgUrl,isLiked,isBookmarked,TotalLikes,TotalBookmarks,TotalComments, DateTime) 
    VALUES
    ('Jane Doe', '$PostText', '$PostImgUrl', 0, 0, 0, 0, 0, '$DateTime') ");
}

function addComment($PostID, $CommentText, $CommentDateTime){
    getDbAccess()->executeQuery("INSERT INTO 
    Comments(PostID,UserID,CommentText,DateTime) 
    VALUES
    ('$PostID','Jane Doe','$CommentText','$CommentDateTime') ");
}
    
function increaseTotalComments($postID){
    getDbAccess()->executeQuery("UPDATE Posts SET TotalComments = TotalComments+1 WHERE PostID = '$postID' ");
}
/* funkcije za usera */
function increaseUserMyLikes($userName){
    getDbAccess()->executeQuery("UPDATE Users SET MyLikes = MyLikes+1 WHERE UserName = '$userName'");
}
function decreaseUserMyLikes($userName){
    getDbAccess()->executeQuery("UPDATE Users SET MyLikes = MyLikes-1 WHERE UserName = '$userName'");
}
function increaseUserMyBookmarks($userName){
    getDbAccess()->executeQuery("UPDATE Users SET MyBookmarks = MyBookmarks+1 WHERE UserName = '$userName'");
}
function decreaseUserMyBookmarks($userName){
    getDbAccess()->executeQuery("UPDATE Users SET MyBookmarks = MyBookmarks-1 WHERE UserName = '$userName'");
}


