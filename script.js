document.addEventListener("DOMContentLoaded", function(event) {
    let posts = [];

    let postTextarea = document.querySelector(".post-textarea");
    const maxChar = 500;
    let charRemaining = document.querySelector("#char-remaining-count");
    let submitButton = document.querySelector(".submit-button");
    // let postsList = document.querySelector("#posts-list");
    
    // display number of characters remaining
    postTextarea.addEventListener("keyup", function(event) {
        updateCharRemaining();
    });

    submitButton.addEventListener("click", function(event) {
        // reduce to 500 characters
        updateCharRemaining();
        // grab the text, add the string to posts
        let newPost = {
            text: postTextarea.value,
            timeStamp: Date().toString()
        }
        posts.push(newPost);
        updatePostList();
        // postTextarea.value = "";
    });
    
    // redundant now using php to load posts
    // function updatePostList() {
    //     // first, clear existing post list element
    //     postsList.innerHTML = "";

    //     // loop over list of posts in reverse order and create and append the post elements
    //     // for (let post of posts) {
    //     for (let i = posts.length - 1; i > -1; i--) {
    //         let post = posts[i];

    //         let postElem = document.createElement("div");
    //         let timestampText = document.createTextNode("Posted at: " + post.timeStamp);
    //         let postPara = document.createElement("p");
    //         let postText = document.createTextNode(post.text);
    //         postElem.appendChild(timestampText);
    //         postElem.appendChild(postPara);
    //         postPara.appendChild(postText);
    //         postsList.appendChild(postElem);
    //     }

    // }
    
    function updateCharRemaining() {
        // count number
        let numCharacters = postTextarea.value.length;
        if (numCharacters > maxChar) {
            postTextarea.value = postTextarea.value.substring(0, maxChar - 1);
            numCharacters = maxChar;
            charRemaining.innerText = maxChar + " / " + maxChar;
        } else {
            charRemaining.innerText = numCharacters + " / " + maxChar;
        }
        // console.log('characters: ' + numCharacters);
        
    }

    // focus textarea and fill in char remaining
    postTextarea.focus();
    updateCharRemaining();
});