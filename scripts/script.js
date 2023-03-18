/*dohvatit cemo korisnicko ime*/
let currentUserName = document.querySelector("#username").textContent;

/*-------------------otvaranje dijela za upis src-a slike kad se klikne na ikonicu i tekst 'Photo'-------------------------------*/

/*kad upremo u 'Photo' onda se smatra da zelimo objavit sliku i tad je ImgUrl obavezan unos, dok obican postText nije */
/* (IDUCE DVI LINIJE SE PROVJERAVAJU U handleAddPostButtonClick) */
/*tako da cemo (ako je display != none)staviti gresku samo na prazan input ImgUrl-a, a tekst moze bit prazan*/
/* ako je display==none onda provjeravamo samo je li postText prazan*/
let addPhotoLinkArea = document.querySelector(".post-input-container a");
addPhotoLinkArea.addEventListener("click", handleAddPhotoAreaClick);

function handleAddPhotoAreaClick(e){
    let photoUrlInput = document.querySelector(".post-input-container input");
    if(photoUrlInput.style.display == 'none'){
        photoUrlInput.style.display = 'block';
    }
    else{
        photoUrlInput.style.display = 'none';
    }
    /*zbog gore (povise funk) navedene promjene konteksta onoga sta zelimo objavit pritiskom na 'Photo' botun, 
    u iducim linijama cemo osigurat da se maknu svi errori kad otvorimo ili zatvorimo photoUrlInput dio programa*/
    setStatus(document.querySelector(".post-input-container textarea"), "", "sucess");
    setStatus(photoUrlInput, "", "sucess");
        
}
/*mala funkcija s interneta kojom provjeravamo je li uneseni ImgUrl stvarno slika */
/*koristit cemo u handle AddPostButtonClick */
/*
ne radi
function isImgUrl(url) {
    const img = new Image();
    img.src = url;
    return new Promise((resolve) => {
      img.onload = () => resolve(true);
      img.onerror = () => resolve(false);
    });
  }*/


/*-----------------------------------dodavanje novog posta kad se klikne na botun 'Post' --------------------------------*/
let addPostButton = document.querySelector("#add-post-button");
addPostButton.addEventListener("click", handleAddPostButtonClick);

function validateField(field, fieldName){
    if(field.value.trim() == ""){
        this.setStatus(
            field,
            ` ${fieldName} cannot be blank`,
            "error"
            );
        return false; 
    }
    else{
        this.setStatus(field, null, "sucess");
        return true;
    }
}
function setStatus(field, message, status){
    const errorMessage = field.nextElementSibling;
    if(status=="sucess"){

        if(errorMessage){
            errorMessage.innerText = "";
        }
        field.classList.remove("input-error");
    }
    if(status=="error"){
        errorMessage.innerText = message;
        field.classList.add("input-error");
    }
}

function getDateTime(){
    let currentdate = new Date(); 
    let datetime = currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + ", "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes();
    return datetime;
}

async function handleAddPostButtonClick(e){
    //let addPostButton = e.currentTarget;

    let imageUrlInput = document.querySelector('.post-input-container input');
    let imageUrl = imageUrlInput.value;
    let postTextarea = document.querySelector('.post-input-container textarea');
    let postText = postTextarea.value;
    let dateTime = getDateTime();
    //da nam bude omogućeno objavljivanje postova s tekstom bez slike, slike bez teksta, i slike i teksta skupa
    if(imageUrlInput.style.display == 'none'){ 
        if(!validateField(postTextarea, "Text")){
            return;
        }
    }
    else{
        if(!validateField(imageUrlInput, "Image Url")){
            return;
        }
    }

    try {
        const serverResponse = await fetch(`API.php?action=addPost&PostText=${postText}&PostImgUrl=${imageUrl}&DateTime=${dateTime}`);
        const responseData = await serverResponse.json();
    
        if (!responseData.success) {
            throw new Error(`Error while adding post: ${responseData.reason}`);
        }


        const postTemplate = document.getElementById('post-template');
        const postElement = document.importNode(postTemplate.content, true);
        //postElement.querySelector('.post-img').src = imageUrl;
        postElement.querySelector('.post-text').textContent = postText;
        postElement.querySelector('.heart-icon').addEventListener('click', handleHeartIconClick);
        postElement.querySelector('.comment-icon').addEventListener('click', handleCommentIconClick);
        postElement.querySelector('.bookmark-icon').addEventListener('click', handleBookmarkIconClick);
        postElement.querySelector('span').textContent = dateTime;

        postTextarea.value = "";
        imageUrlInput.value = "";

        let postsContainer = document.getElementById('posts-feed');
        //postsContainer.appendChild(postElement); ovo mi je dodavalo na kraj 
        postsContainer.insertBefore(postElement, postsContainer.firstChild); //ovo doda na pocetak

        window.location.reload();

    } catch (error) {
      console.log(error);
        throw new Error(error.message || error);
    }
}


/*---------------------------------------------------omogućavanje likanja -----------------------------------------------*/
let heartIcons = document.querySelectorAll(".post-container .heart-icon");
for(let i = 0; i < heartIcons.length; i++){
    let heartIcon = heartIcons[i];
    heartIcon.addEventListener("click", handleHeartIconClick);
}

async function handleHeartIconClick(e){
    let heartIcon = e.currentTarget; //Srce na koje smo sad klikli
    const post = heartIcon.closest('.post-container'); //closest ide samo kroz parente, kroz pretke, ne trazi medu djecom predaka
    const postID = post.getAttribute('data-post-id');
    const totalLikes = heartIcon.nextElementSibling;
    let currentUserMyLikesContainer = document.querySelector(".counter-container .like-counter h3");
    
    const isCurrentlyLiked = heartIcon.classList.contains("fa-solid");
    try{
        const serverResponse = await fetch(`API.php?action=togglePostLike&postID=${postID}&isLiked=${isCurrentlyLiked ? 0 : 1}&userID=${currentUserName}`);
        const resonseData = await serverResponse.json();

        if(!resonseData.success){
            //kad vamo throwam ne radi nist aposlje ifa nego ide na catch
            throw new Error(`Error while liking post: ${resonseData.reason}`)
        }

        if(!isCurrentlyLiked){ //"prazno" srce
            heartIcon.classList.remove("fa-regular"); 
            heartIcon.classList.add("fa-solid");//"puno" srce
            totalLikes.innerText = parseInt(totalLikes.innerText) +1;
            currentUserMyLikesContainer.textContent = parseInt(currentUserMyLikesContainer.textContent) +1;
        
        }
        else {
            heartIcon.classList.remove("fa-solid");
            heartIcon.classList.add("fa-regular");
            totalLikes.innerText = parseInt(totalLikes.innerText) -1;  
            currentUserMyLikesContainer.textContent = parseInt(currentUserMyLikesContainer.textContent) -1;
        
        }
    }catch(error){
        //kad vamo throwam pojavi se u konzoli
        throw new Error(error.message || error)
        alert(error)
    }
    
    
}

/*--------------------------------------------------omogucavanje bookmarka-----------------------------------------------*/
let bookmarkIcons = document.querySelectorAll(".post-container .bookmark-icon");
for(let i = 0; i < bookmarkIcons.length; i++){
    let bookmarkIcon = bookmarkIcons[i];
    bookmarkIcon.addEventListener("click", handleBookmarkIconClick);
}

async function handleBookmarkIconClick(e){
    let bookmarkIcon = e.currentTarget; //Bookmark na koje smo sad klikli
    const isCurrentlyBookmarked = bookmarkIcon.classList.contains('fa-solid');
    const post = bookmarkIcon.closest('.post-container');
    const postID = post.getAttribute('data-post-id');
    const totalBookmarks = bookmarkIcon.nextElementSibling;
    let currentUserMyBookmarksContainer = document.querySelector(".counter-container .bookmark-counter h3");
    

    try{
        const serverResponse = await fetch(`API.php?action=togglePostBookmark&postID=${postID}&isBookmarked=${isCurrentlyBookmarked ? 0 : 1}&userID=${currentUserName}`)
        const resonseData = await serverResponse.json()

        if(!resonseData.success){
            //kad vamo throwam ne radi nist aposlje ifa nego ide na catch
            throw new Error(`Error while bookmarking post: ${resonseData.reason}`)
        }
        if(!isCurrentlyBookmarked){ //"prazan" bookmark
            bookmarkIcon.classList.remove("fa-regular"); 
            bookmarkIcon.classList.add("fa-solid");//"puni" bookmark
            totalBookmarks.innerText = parseInt(totalBookmarks.innerText) +1;
            currentUserMyBookmarksContainer.textContent = parseInt(currentUserMyBookmarksContainer.textContent) +1;
            
        }
        else {
            bookmarkIcon.classList.remove("fa-solid");
            bookmarkIcon.classList.add("fa-regular");
            totalBookmarks.innerText = parseInt(totalBookmarks.innerText) -1;
            currentUserMyBookmarksContainer.textContent = parseInt(currentUserMyBookmarksContainer.textContent) -1;
        }
    }catch(error){
        //kad vamo throwam pojavi se u konzoli
        throw new Error(error.message || error)
        alert(error)
    }
}

/*-----------------------------------------------omogucavanje otvaranja dijela s komentarima --------------------------------*/
let commentIcons = document.querySelectorAll(".post-container .comment-icon");
for(let i = 0; i < commentIcons.length; i++){
    let commentIcon = commentIcons[i];
    commentIcon.addEventListener("click", handleCommentIconClick);
}

function handleCommentIconClick(e){
    let commentIcon = e.currentTarget; //'Dodaj komentar' na koje smo sad klikli
    const isCurrentlyCommented = commentIcon.classList.contains('fa-solid');
    const post = commentIcon.closest('.post-container');
    let commentContainer = post.querySelector('.comment-input-container');
    if(!isCurrentlyCommented){ //"prazna" ikona komentara
        commentIcon.classList.remove("fa-regular"); 
        commentIcon.classList.add("fa-solid");//"puna" ikona komentara

        commentContainer.style.display = 'block';
    }
    else {
        commentIcon.classList.remove("fa-solid");
        commentIcon.classList.add("fa-regular");

        commentContainer.style.display = 'none';
    }
}

/*---------------------------------dodavanje novog komentara-----------------------*/
let addCommentButtons = document.querySelectorAll(".post-container .add-comment-button");
for(let i = 0; i < addCommentButtons.length; i++){
    let addCommentButton = addCommentButtons[i];
    addCommentButton.addEventListener("click", handleAddCommentButtonClick);
}

async function handleAddCommentButtonClick(e){
    let addCommentButton = e.currentTarget;
    let post = addCommentButton.closest('.post-container');
    let postID = post.getAttribute('data-post-id');
    let commentTextInput = post.querySelector('.comment-input-container .comment-input');
    let commentText = commentTextInput.value;
    let dateTime = getDateTime();
    //da nam bude omogućeno objavljivanje postova s tekstom bez slike, slike bez teksta, i slike i teksta skupa
    if(!validateField(commentTextInput, "Comment")){
        return;
    }

    try {
        const serverResponse = await fetch(`API.php?action=addComment&PostID=${postID}&CommentText=${commentText}&DateTime=${dateTime}`);
        const responseData = await serverResponse.json();
    
        if (!responseData.success) {
            throw new Error(`Error while adding comment: ${responseData.reason}`);
        }

        console.log(commentText);

        window.location.reload();
        handleCommentIconClick(post.querySelector('.comment-icon'));

    } catch (error) {
      console.log(error);
        throw new Error(error.message || error);
    }
}

/*dodat 'aside' ko na stack overflowu kad dodamo bookmark*/