<?php
require_once("php/Post.php");
// tu je bila greska jer san pozivala cards.php............



// function that we call from our JS code that processes the request and calls actions that execute queries
function processRequest(){
  $action = getRequestParameter("action");

    // action that was called
    switch ($action) {
      case  'togglePostLike':
        processTogglePostLike();
        break;
      case  'togglePostBookmark':
        processTogglePostBookmark();
        break;
      case 'addPost':
        processAddPost();
        break;
      case 'addComment':
        processAddComment();
        break;
      default:
      echo(json_encode(array(
         "success" => false,
         "reason" => "Unknown action: $action"
      )));
      break;
    }
}

// getRequestParameter("action") -> "deleteCard"
function getRequestParameter($key) {
   // $_REQUEST[$key] -> a map of keys and values from the request
   return isset($_REQUEST[$key]) ? $_REQUEST[$key] : "";
}

// http://pzi.fesb.hr/korisnickoime/vj9/API.php?action=togglePostLike&postID=1^isLiked=1  
//ili jednostavno API.php?action=togglePostLike&postID=1^isLiked=1  - to ce se ovom dole funkcijom slat
function processTogglePostLike(){
  $success = false;
  $reason = "";

  $postID = getRequestParameter("postID");
  $isLiked = getRequestParameter("isLiked");
  $userID = getRequestParameter("userID");

  if(is_numeric($postID) && is_numeric($isLiked)){
    togglePostLike($postID, $isLiked);
    if($isLiked){
      increaseTotalLikes($postID);
      increaseUserMyLikes($userID);
    }
    else{
      decreaseTotalLikes($postID);
      decreaseUserMyLikes($userID);
    }
    $success=true;
  }
  else{
    $success = false;
    $reason = "Needs postID:number; isLiked:number;";
  }

  echo(json_encode(array(
    "success"=> $success,
    "reason" => $reason
  )));
}

function processTogglePostBookmark(){
  $success = false;
  $reason = "";

  $postID = getRequestParameter("postID"); //GREŠKA! je bila u tome da sam koristila ' umjesto " ......................
  $isBookmarked = getRequestParameter("isBookmarked");
  $userID = getRequestParameter("userID");

  if(is_numeric($postID) && is_numeric($isBookmarked)){
    togglePostBookmark($postID, $isBookmarked);
    if($isBookmarked){
      increaseTotalBookmarks($postID);
      increaseUserMyBookmarks($userID);
    }
    else{
      decreaseTotalBookmarks($postID);
      decreaseUserMyBookmarks($userID);
    }
    $success=true;
  }
  else{
    $success = false;
    $reason = "Needs postID:number; isBookmarked:number;";
  }

  echo(json_encode(array(
    "success"=> $success,
    "reason" => $reason
  )));
}

function processAddPost(){
  $success =false;
  $reason = "";

  $PostText = getRequestParameter("PostText");
  $PostImgUrl = getRequestParameter("PostImgUrl");
  $DateTime = getRequestParameter("DateTime");


  if(is_string($PostText) && is_string($PostImgUrl) && is_string($DateTime)){
    addPost($PostText,$PostImgUrl,$DateTime);
    $success = true;
  }
  else{
    $success = false;
    $reason = "Needs PostText:string; PostImgUrl:string; DateTime:string";
  }

  echo(json_encode(array(
      "success" => $success,
      "reason" => $reason
      )));

}

function processAddComment(){
  $success =false;
  $reason = "";

  $PostID = getRequestParameter("PostID");
  $CommentText = getRequestParameter("CommentText");
  $CommentDateTime = getRequestParameter("DateTime");


  if(is_string($PostID) && is_string($CommentText) && is_string($CommentDateTime)){
    addComment($PostID, $CommentText, $CommentDateTime);
    increaseTotalComments($PostID);
    $success = true;
  }
  else{
    $success = false;
    $reason = "Needs PostID:number; CommentText:string; CommentDateTime:string";
  }

  echo(json_encode(array(
      "success" => $success,
      "reason" => $reason
      )));
}

processRequest();